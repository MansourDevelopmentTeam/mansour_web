<?php


namespace App\Services\ImportFiles;


use App\Models\Products\Brand;
use App\Models\Products\Category;
use App\Models\Products\Product;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ImportProduct extends ImportFiles
{

    public function import($file, $history_id)
    {
        try {
            Log::channel('imports')->info('Import product, history id is ' . $history_id);
            Excel::load($file, function ($reader) use ($history_id) {
                // Loop through all sheets
                $results = $reader->all();
                $missed_categories = [];
                $missed_count = 0;
                $missed_keys = [];
                $index = 0;
                foreach ($results as $key => $record) {
                    if (!$this->checkImportCachedStatus($history_id, ImportConstants::STATE_CANCEL)) {
                        if (is_float($record->sku)) {
                            $sku = (int)$record->sku;
                        } else {
                            $sku = $record->sku;
                        }
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
                            "name" => $record->name, "name_ar" => $record->name_ar, "price" => $record->price,
                            "weight" => $record->weight, "discount_price" => $record->discount_price,
                            "description" => $record->description, "meta_title" => $record->meta_title, "meta_description" => $record->meta_description, "keywords" => $record->keywords, "preorder" => $record->preorder, "preorder_price" => $record->preorder_price,
                            "description_ar" => $record->description_ar, "sku" => $record->sku, "brand_id" => $brand_id,
                            "image" => $main_image, "category_id" => $category_id, "active" => $record->active
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
                        $index++;
                        $progress = ceil(($index / count($results)) * 100);
                        $this->_importRepo->updateHistoryProgress($progress, $history_id);

                    }else{
                        Log::channel('imports')->info('Import canceled is is ' . $history_id);
                    }

                }
                $this->_importRepo->changeState(ImportConstants::STATE_COMPLETE, $history_id);
            });
        } catch (\Exception $e) {
            Log::channel('imports')->error("HandleFileError: " . $e->getMessage());
            $this->_importRepo->changeState(ImportConstants::STATE_ERROR, $history_id);
        }
    }
}