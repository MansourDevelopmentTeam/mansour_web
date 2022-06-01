<?php

namespace App\Sheets\Import\Products;

use App\Models\Inventories\Inventory;
use App\Models\Products\Brand;
use App\Models\Products\Category;
use App\Models\Products\CategoryOption;
use App\Models\Products\Option;
use App\Models\Products\OptionValue;
use App\Models\Products\Product;
use App\Models\Products\ProductOptionValues;
use App\Models\Products\ProductTag;
use App\Models\Products\Tag;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Validators\Failure;

class ProductPricesImport implements ToCollection, WithHeadingRow, SkipsOnFailure
{
    use SkipsFailures;
    private $pushService;
    private $approved;

    public function __construct($pushService)
    {
        $this->pushService = $pushService;
    }

    public function collection(Collection $rows)
    {
        if (!empty($rows)) {
            foreach ($rows as $row) {
                $sku = $row["sku"];

                if ($product = Product::where("sku", $sku)->first()) {
                    $data = [
                        "stock" => $row["stock"],
                        "active" => $row["active"]
                    ];
                    !isset($row["price"]) ?: $data["price"] = $row["price"];
                    !isset($row["discount_price"]) ?: $data["discount_price"] = $row["discount_price"];
                    $product->update($data);

                    if ($product->stock > 0) {
                        $users = $product->stock_notifiers;
                        $product->stock_notifiers()->sync([]);
                        $this->pushService->notifyUsers($users, "{$product->name} is now available", "Product in Stock");
                    }
                    if(Settings::get('multiple_inventories')) {
                        $inventoriesArr = [];
                        foreach ($row as $key => $value) {
                            if(0 === strpos($key, 'stock_in_inventory_')){
                                $invName = str_replace('_', ' ', substr($key, 19));
                                $inventory = Inventory::where('name', $invName)->first();
                                if($inventory){
                                    $inventoriesArr[$inventory->id] = ['stock' => $value];
                                }
                            }
                        }
                        $product->inventories()->sync($inventoriesArr);
                    }
                }
            }
        }

    }

    public function onError(\Throwable $e)
    {

    }

    public function onFailure(Failure ...$failures)
    {

    }
}
