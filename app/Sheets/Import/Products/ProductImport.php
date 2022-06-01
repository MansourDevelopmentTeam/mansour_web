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
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Validators\Failure;

class ProductImport implements ToCollection, WithHeadingRow, SkipsOnFailure
{
    use SkipsFailures;



    public function __construct()
    {

    }

    public function collection(Collection $rows)
    {
        $missed_categories = [];
        $missed_count = 0;
        $missed_images = [];
        $missed_keys = [];
        if (!empty($rows)) {
            foreach ($rows  as $key => $record) {
                $sku = $record->sku;
                $category_name = $record->subcategory;
                if ($category = Category::whereNotNull("parent_id")->where("name", trim($category_name))->first()) {
                    $category_id = $category->id;
                } else {
                    $missed_categories[] = $category_name;
                    $missed_keys[] = $key;
                    $missed_count++;
                    continue;
                }

                $brand_id = null;
                if ($record->brand) {
                    $brand = Brand::where("name", $record->brand)->first();
                    if ($brand) {
                        $brand_id = $brand->id;
                    }
                }

                $images = explode(',', $record->image);
                $main_image = null;
                if (count($images)) {
                    $main_image = trim($images[0]);
                    $main_image = preg_replace("/\s/", "-", $main_image);
                    unset($images[0]);
                    if (filter_var($main_image, FILTER_VALIDATE_URL) === FALSE) {
                        $main_image = "storage/uploads/" . $main_image;
                    }
                }

                // if product exists
                $product_data = [
                    "name" => $record->name,
                    "name_ar" => $record->name_ar,
                    "price" => $record->price,
                    "discount_price" => $record->discount_price,
                    "description" => $record->description,
                    "description_ar" => $record->description_ar,
                    "sku" => $record->sku,
                    "order" => $record->order,
                    "stock" => $record->stock,
                    "brand_id" => $brand_id,
                    "affiliate_commission" => $record->affiliate_commission,
                    // "image" => preg_replace("/\s/", "-", $record->image),
                    "image" => $main_image,
                    "active" => (integer)$record->active,
                    "category_id" => $category_id,

                ];

                if ($product = Product::where("sku", $sku)->first()) {
                    $product->update($product_data);
                } else {
                    $product = Product::create($product_data + ["creator_id" => \Auth::id()]);
                }

                if (count($images)) {
                    $product->images()->delete();
                    foreach ($images as $image) {
                        $image = preg_replace("/\s/", "-", trim($image));
                        if (filter_var($main_image, FILTER_VALIDATE_URL) === FALSE) {
                            $image = "storage/uploads/" . $image;
                        }
                        $product->images()->create([
                            "url" => $image
                        ]);
                    }
                }
            }
        }
        Log::info($missed_images);
        Log::info($missed_categories);
        Log::info($missed_keys);
        Log::info("Missed Products: {$missed_count}");
        return response()->json([
            "code" => 200,
            "message" => "Success",
            "data" => [
                'missed_categories' => $missed_categories,
                'missed_count' => $missed_count,
                'missed_images' => $missed_images,
                'missed_keys' => $missed_keys,
            ]
        ], 200)->send();
    }

    public function onError(\Throwable $e)
    {

    }

    public function onFailure(Failure ...$failures)
    {

    }
}
