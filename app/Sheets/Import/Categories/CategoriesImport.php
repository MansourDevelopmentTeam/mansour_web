<?php

namespace App\Sheets\Import\Categories;

use Illuminate\Support\Str;
use App\Models\Products\Tag;
use App\Models\Products\Brand;
use App\Models\Products\Option;
use App\Models\Products\Category;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\Models\Products\CategoryOption;
use App\Services\ImportFiles\ImportFiles;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Services\ImportFiles\ImportConstants;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CategoriesImport extends ImportFiles implements ToCollection, WithHeadingRow, SkipsOnFailure
{
    use SkipsFailures;

    protected $history_id;
    public $reportData;
    public $status;
    public $statusCode;
    public $errorMessage;

    public function __construct($history_id)
    {
        parent::__construct();
        $this->history_id = $history_id;
    }

    public function collection(Collection $rows)
    {
        try {
            if (!empty($rows)) {
                $parentCategory = null;
                $index = 0;
                foreach ($rows as $row) {
                    if (!$this->checkImportCachedStatus($this->history_id, ImportConstants::STATE_CANCEL)) {
                        $categoryImage = isset($row['category_image']) ? $row['category_image'] : null;

                        if (isset($row['subcategory_slug']) && !empty($row['subcategory_slug'])) {
                            $subcategory_slug = Str::slug($row['subcategory_slug'], '-');
                        } else {
                            throw new \Exception("Categroy slug not found");
                        }

                        if (isset($row['category_slug']) && !empty($row['category_slug'])) {
                            $category_slug = Str::slug($row['category_slug'], '-');
                        } else {
                            throw new \Exception("Categroy slug not found");
                        }

                        $subCategoryOptions = isset($row['subcategory_options']) && !empty($row['subcategory_options']) ? explode(',', $row['subcategory_options']) : '';
                        if (filter_var($categoryImage, FILTER_VALIDATE_URL) === FALSE) {
                            $categoryImage = str_replace(' ', '-', $categoryImage);
                            $categoryImage = url("storage/uploads/" . $categoryImage);
                        }
                        $subCategoryImage = isset($row['subcategory_image']) ? $row['subcategory_image'] : '';
                        if (filter_var($subCategoryImage, FILTER_VALIDATE_URL) === FALSE) {
                            $subCategoryImage = str_replace(' ', '-', $subCategoryImage);
                            $subCategoryImage = url("storage/uploads/" . $subCategoryImage);
                        }
                        if ($row['category'] != null || $row['category_ar'] != null) {
                            $item = Category::where("name", $row['category'])->first();
                            if ($item) {
                                $item->update(["name" => $row['category'], "name_ar" => $row['category_ar'], "image" => $categoryImage, "slug" => $category_slug]);
                                if ($row['subcategory'] != null || $row['subcategory_ar'] != null) {
                                    if ($subcategory_slug) {
                                        $subCat = Category::where('slug', $subcategory_slug)->where('parent_id', $item->id)->first();
                                    }

                                    if ($subCat) {
                                        $subCat->update(["name" => $row['subcategory'], "name_ar" => $row['subcategory_ar'], "image" => $subCategoryImage, "parent_id" => $item->id, "active" => '1', 'slug' => $subcategory_slug]);
                                    } else {

                                        $subCategorySlugExists = Category::where('slug', $subcategory_slug)->exists();
                                        if ($subCategorySlugExists) {
                                            throw new \Exception("Sub-category slug ({$row['subcategory_slug']}) is already exists in categories table");
                                        }

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
                                    $item = Category::create(["name" => $row['category'], "name_ar" => $row['category_ar'], "image" => $categoryImage, "active" => '1', "slug" => $category_slug]);
                                    $subCategorySlugExists = Category::where('slug', $subcategory_slug)->exists();
                                    if ($subCategorySlugExists) {
                                        throw new \Exception("Sub-category slug ({$row['subcategory_slug']}) is already exists in categories table");
                                    }
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
                                    $item = Category::create(["name" => $row['category'], "name_ar" => $row['category_ar'], "image" => $categoryImage, "active" => '1', "slug" => $category_slug]);
                                }
                            }
                            $parentCategory = $item;
                        } else {
                            if ($parentCategory) {
                                if ($subcategory_slug) {
                                    $subCat = Category::where('slug', $subcategory_slug)->where('parent_id', $parentCategory->id)->first();
                                }

                                if ($subCat) {
                                    $subCat->update(["name" => $row['subcategory'], "name_ar" => $row['subcategory_ar'], "image" => $subCategoryImage, "slug" => $subcategory_slug]);
                                } else {

                                    $subCategorySlugExists = Category::where('slug', $subcategory_slug)->exists();
                                    if ($subCategorySlugExists) {
                                        throw new \Exception("Sub-category slug ({$row['subcategory_slug']}) is already exists in categories table");
                                    }
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
                        $progress = ceil(($index / count($rows)) * 100);
                        $this->_importRepo->updateHistoryProgress($progress, $this->history_id);
                        $this->status = 'success';
                    } else {
                        $this->status = 'cancelled';
                        Log::channel('imports')->info("Import canceled, history id is $this->history_id");
                        break;
                    }
                }
                $this->_importRepo->changeState(ImportConstants::STATE_COMPLETE, $this->history_id);
                $this->statusCode = '200';
                $this->reportData = [];
                $this->errorMessage = null;
            }
        } catch (\Exception $e) {
            $this->status = 'error';
            $this->statusCode = '422';
            $this->reportData = [];
            $this->errorMessage = $e->getMessage();
            Log::channel('imports')->error($e->getMessage());
            $this->_importRepo->changeState(ImportConstants::STATE_ERROR, $this->history_id);
        }
    }

    public function onError(\Throwable $e)
    {
    }

    public function onFailure(Failure ...$failures)
    {
    }

    public function import($file, $history_id)
    {
        // TODO: Implement import() method.
    }
}
