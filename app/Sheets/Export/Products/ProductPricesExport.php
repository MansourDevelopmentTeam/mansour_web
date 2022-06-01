<?php
namespace App\Sheets\Export\Products;

use App\Models\Inventories\Inventory;
use App\Models\Products\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductPricesExport implements FromCollection, WithHeadings ,WithMapping, ShouldAutoSize, WithStrictNullComparison
{

    public function __construct($products ,$multipleInventoriesStatus)
    {
        $this->products = $products;
        $this->multipleInventoriesStatus = $multipleInventoriesStatus ;
    }
    public function collection()
    {
        return $this->products;
    }


    public function map($product): array
    {
        // dd(array_values($player));
        $mainProductsArray = [
            $product->sku,
            $product->price,
            $product->discount_price,
            $product->active
        ];
        if($this->multipleInventoriesStatus) {
            foreach (Inventory::with(['Products'])->get() as $inventory) {
                $stock = $inventory->Products()->where('product_id', $product->id)->first()->pivot->stock ?? 0;
                array_push($mainProductsArray, (string) $stock);
            }
        } else {
            $mainProductsArray[] = $product->stock;
        }
     return $mainProductsArray;
    }

    public function headings(): array
    {
        $headingArray = [
            "sku",
            "price",
            "discount_price",
            "active"
        ];
        $inventories = null;
        if($this->multipleInventoriesStatus) {
            $inventories = Inventory::with(['Products'])->get();
            $inventoriesNames = $inventories->map(function ($inventory) {
                return 'stock_in_inventory_' . str_replace(' ', '_', $inventory->name);
            })->toArray();
            $headingArray = array_merge($headingArray, $inventoriesNames);
        } else {
            $headingArray[] = "stock";
        }
        return $headingArray;
    }
}
