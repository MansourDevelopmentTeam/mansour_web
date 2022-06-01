<?php


namespace App\Services\ImportFiles;


use App\Models\Products\Category;
use App\Models\Products\CategoryOption;
use App\Models\Products\Option;
use App\Models\Repositories\ImportRepository;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ImportCategory extends ImportFiles
{

    public function import($file, $history_id)
    {
        try {
            Excel::load($file, function ($reader) use ($file, $history_id){
                // Loop through all sheets
                $results = $reader->all();
                $parentCategory = null;
                if (!empty($results)) {
                    $index = 0;
                    foreach ($results as $row) {
                        if (!$this->checkImportCachedStatus($history_id, ImportConstants::STATE_CANCEL)) {
                            $categoryImage = $row['category_image'] ?? null;
                            $subcategory_slug = !isset($row['subcategory_slug']) || empty($row['subcategory_slug']) ? null : $row['subcategory_slug'];
                            $subCategoryOptions = isset($row['subcategory_options']) && !empty($row['subcategory_options']) ? explode(',', $row['subcategory_options']) : '';
                            $categoryImage = $this->getImageUrl($categoryImage);
                            $subCategoryImage = $row['subcategory_image'] ?? '';
                            $subCategoryImage = $this->getImageUrl($subCategoryImage);

                            if ($row['category'] != null || $row['category_ar'] != null) {
                                $item = Category::where("name", $row['category'])->first();
                                if ($item) {
                                    $item->update(["name" => $row['category'], "name_ar" => $row['category_ar'], "image" => $categoryImage]);
                                    if ($row['subcategory'] != null || $row['subcategory_ar'] != null) {
                                        if ($subcategory_slug) {
                                            $subCat = Category::where('slug', $subcategory_slug)->where('parent_id', $item->id)->first();
                                        } else {
                                            $subCat = Category::where('name', $row['subcategory'])->where('parent_id', $item->id)->first();
                                        }
                                        if ($subCat) {
                                            $subCat->update(["name" => $row['subcategory'], "name_ar" => $row['subcategory_ar'], "image" => $subCategoryImage, "parent_id" => $item->id, "active" => '1', 'slug' => $subcategory_slug]);
                                        } else {
                                            $subCat = Category::create(["name" => $row['subcategory'], "name_ar" => $row['subcategory_ar'], "image" => $subCategoryImage, "parent_id" => $item->id, "active" => '1', 'slug' => $subcategory_slug]);
                                        }
                                        if (is_array($subCategoryOptions) && !empty($subCategoryOptions)) {
                                            CategoryOption::where('sub_category_id', $subCat->id)->delete();
                                            foreach ($subCategoryOptions as $subCategoryOption) {
                                                if (!empty($subCategoryOption) && $subCategoryOption != null) {
                                                    $option = Option::where('name_en', $subCategoryOption)->first();
                                                    if ($option) {
                                                        $categoryOptionData = [
                                                            "option_id" => $option->id,
                                                            "sub_category_id" => $subCat->id
                                                        ];
                                                        CategoryOption::create($categoryOptionData);
                                                    }
                                                }
                                            }
                                        }

                                    }
                                } else {
                                    if ($row['subcategory'] != null || $row['subcategory_ar'] != null) {
                                        $item = Category::create(["name" => $row['category'], "name_ar" => $row['category_ar'], "image" => $categoryImage, "active" => '1']);
                                        $subCat = Category::create(["name" => $row['subcategory'], "name_ar" => $row['subcategory_ar'], "image" => $subCategoryImage, "parent_id" => $item->id, "active" => '1', 'slug' => $subcategory_slug]);
                                        if (is_array($subCategoryOptions)) {
                                            foreach ($subCategoryOptions as $subCategoryOption) {
                                                $option = Option::where('name_en', $subCategoryOption)->first();
                                                if ($option) {
                                                    $categoryOptionData = [
                                                        "option_id" => $option->id,
                                                        "sub_category_id" => $subCat->id
                                                    ];
                                                    CategoryOption::updateOrCreate($categoryOptionData);
                                                }
                                            }
                                        }
                                    } else {
                                        $item = Category::create(["name" => $row['category'], "name_ar" => $row['category_ar'], "image" => $categoryImage, "active" => '1']);
                                    }
                                }
                                $parentCategory = $item;
                            } else {
                                if ($parentCategory) {
                                    if ($subcategory_slug) {
                                        $subCat = Category::where('slug', $subcategory_slug)->where('parent_id', $parentCategory->id)->first();
                                    } else {
                                        $subCat = Category::where("name", $row['subcategory'])->where('parent_id', $parentCategory->id)->first();
                                    }
                                    if ($subCat) {
                                        $subCat->update(["name" => $row['subcategory'], "name_ar" => $row['subcategory_ar'], "image" => $subCategoryImage, "slug" => $subcategory_slug]);
                                    } else {
                                        $subCat = Category::create(["name" => $row['subcategory'], "name_ar" => $row['subcategory_ar'], "image" => $subCategoryImage, "parent_id" => $parentCategory->id, "active" => '1', "slug" => $subcategory_slug]);
                                    }
                                    if (is_array($subCategoryOptions)) {
                                        foreach ($subCategoryOptions as $subCategoryOption) {
                                            $option = Option::where('name_en', $subCategoryOption)->first();
                                            if ($option) {
                                                $categoryOptionData = [
                                                    "option_id" => $option->id,
                                                    "sub_category_id" => $subCat->id
                                                ];
                                                CategoryOption::updateOrCreate($categoryOptionData);
                                            }
                                        }
                                    }
                                }
                            }
                            // update progress
                            $index++;
                            $progress = ceil(($index / count($results)) * 100);
                            $this->_importRepo->updateHistoryProgress($progress, $history_id);
                        }else{
                            Log::channel('imports')->info("Import canceled, history id is $history_id");
                            break;
                        }
                    }
                    $this->_importRepo->changeState(ImportConstants::STATE_COMPLETE, $history_id);
                }
            });
        } catch (\Exception $e) {
            Log::channel('imports')->error($e->getMessage());
            $this->_importRepo->changeState(ImportConstants::STATE_ERROR, $history_id);
        }
    }


    private function getImageUrl($image){
        if (filter_var($image, FILTER_VALIDATE_URL) === FALSE) {
            $image = str_replace(' ', '-', $image);
            return url("storage/uploads/" . $image);
        }
        return null;
    }
}