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

class ProductStocksExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStrictNullComparison
{

    public function collection()
    {
        return Product::with('paymentMethods')->MainProduct()->get();
    }


    public function map($item): array
    {
        if (count($item->productVariants) > 0) {
            $variantsStocks = [];
            foreach ($item->productVariants as $key => $product) {

                $variantsStocks[] = [
                    $product->parent->sku,
                    $product->sku,
                    $product->price,
                    $product->discount_price,
                    $product->discount_start_date,
                    $product->discount_end_date,
                    $product->paymentMethods->implode('id', ','),
                    $product->stock,
                    $product->active,
                ];
            }

            return $variantsStocks;
        } else {
            return array();
        }
    }

    public function headings(): array
    {
        return ["main sku", "sku", "price", "discount_price", "discount_start_date", "discount_end_date", "payment_methods", "stock", "active"];
    }
}
