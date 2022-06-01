<?php


namespace App\Services\ImportFiles;


use App\Models\Products\Category;
use App\Models\Products\Group;
use App\Models\Products\SubCategoryGroup;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ImportGroup extends ImportFiles
{

    public function import($file, $history_id)
    {
        Log::channel('imports')->info('Import Groups, history id is ' . $history_id);

        try {
            Excel::load($file, function ($reader) use($history_id){
                // Loop through all sheets
                $results = $reader->all();
                $parentCategory = null;
                $index = 0;
                foreach ($results as $key => $row) {
                    if (!$this->checkImportCachedStatus($history_id, ImportConstants::STATE_CANCEL)) {
                        $groupImage = $row['group_image'] ?? null;
                        $subcategory_slug = $row['subcategory_slug'] ?? null;
                        $group_slug = $row['group_slug'] ?? null;
                        if (filter_var($groupImage, FILTER_VALIDATE_URL) === FALSE) {
                            $groupImage = str_replace(' ', '-', $groupImage);
                            $groupImage = url("storage/uploads/" . $groupImage);
                        }
                        if ($row['group'] != null || $row['group_ar'] != null) {
                            if ($group_slug) {
                                $item = Group::where("slug", $group_slug)->first();
                            } else {
                                $item = Group::where("name_en", $row['group'])->first();
                            }
                            if ($item) {
                                $item->update(["name_en" => $row['group'], "name_ar" => $row['group_ar'], "image" => $groupImage, "slug" => $group_slug]);
                                if ($row['category'] != null || $row['subcategory'] != null) {
                                    if ($subcategory_slug) {
                                        $subCategory = Category::where('slug', $subcategory_slug)->where('parent_id', '!=', null)->first();
                                    } else {
                                        $subCategory = Category::where("name", $row['subcategory'])->where('parent_id', '!=', null)->first();
                                    }
                                    if ($subCategory) {
                                        SubCategoryGroup::firstOrCreate(['sub_category_id' => $subCategory->id, 'category_id' => $subCategory->parent->id, 'group_id' => $item->id,]);
                                    }
                                }
                            } else {
                                $item = Group::create(["name_en" => $row['group'], 'name_ar' => $row['group_ar'], "image" => $groupImage, "slug" => $group_slug]);
                                if ($row['category'] != null || $row['subcategory'] != null) {
                                    if ($subcategory_slug) {
                                        $subCategory = Category::where('slug', $subcategory_slug)->where('parent_id', '!=', null)->first();
                                    } else {
                                        $subCategory = Category::where("name", $row['subcategory'])->where('parent_id', '!=', null)->first();
                                    }
                                    if ($subCategory) {
                                        SubCategoryGroup::firstOrCreate(['sub_category_id' => $subCategory->id, 'category_id' => $subCategory->parent->id, 'group_id' => $item->id,]);
                                    }
                                }
                            }
                            $parentCategory = $item;
                        } else {
                            if ($parentCategory) {
                                if ($row['category'] != null || $row['subcategory'] != null) {
                                    if ($subcategory_slug) {
                                        $subCategory = Category::where('slug', $subcategory_slug)->where('parent_id', '!=', null)->first();
                                    } else {
                                        $subCategory = Category::where("name", $row['subcategory'])->where('parent_id', '!=', null)->first();
                                    }
                                    if ($subCategory) {
                                        SubCategoryGroup::firstOrCreate(['sub_category_id' => $subCategory->id, 'category_id' => $subCategory->parent->id, 'group_id' => $parentCategory->id,]);
                                    }
                                }
                            }
                        }

                        $index++;
                        $progress = ceil(($index / count($results)) * 100);
                        $this->_importRepo->updateHistoryProgress($progress, $history_id);

                    }else{
                        Log::channel('imports')->info('Import Canceled');
                        break;
                    }
                }
            });
        } catch (\Exception $e) {
            Log::channel('imports')->error($e->getMessage());
            $this->_importRepo->changeState(ImportConstants::STATE_ERROR, $history_id);
        }
    }
}