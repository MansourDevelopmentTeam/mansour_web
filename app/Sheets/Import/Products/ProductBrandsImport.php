<?php

namespace App\Sheets\Import\Products;

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

class ProductBrandsImport implements ToCollection, WithHeadingRow, SkipsOnFailure
{
    use SkipsFailures;

    private $approved;

    public function __construct()
    {

    }

    public function collection(Collection $rows)
    {
        if (!empty($rows)) {
            foreach ($rows as $row) {
                $sku = $row["sku"];
                if (!$row["brand"]) {
                    continue;
                }
                $brand = Brand::firstOrCreate(["name" => $row["brand"]]);
                if ($product = Product::where("sku", $sku)->first()) {
                    $product->update(["brand_id" => $brand->id]);
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
