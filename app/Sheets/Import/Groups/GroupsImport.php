<?php

namespace App\Sheets\Import\Groups;

use App\Models\Products\Brand;
use App\Models\Products\Category;
use App\Models\Products\Group;
use App\Models\Products\SubCategoryGroup;
use App\Models\Products\Tag;
use App\Services\ImportFiles\ImportConstants;
use App\Services\ImportFiles\ImportFiles;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Validators\Failure;

class GroupsImport extends ImportFiles implements ToCollection, WithHeadingRow, SkipsOnFailure
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
        Log::channel('imports')->info('Import Groups, history id is ' . $this->history_id);
        $updatedCounts = 0;
        $createdCounts = 0;
        $data = [
            'total_sheet_count' => count($rows),
            'totaly_imported_count' => &$index,
            'total_updated_groups' => &$updatedCounts,
            'total_created_groups' => &$createdCounts,
            'missed' => []
        ];
        try {
            if (!empty($rows)) {
                $parentCategory = null;
                $index = 0;
                foreach ($rows as $row) {
                    if (!$this->checkImportCachedStatus($this->history_id, ImportConstants::STATE_CANCEL)) {
                        $groupImage = isset($row['group_image']) ? $row['group_image'] : null;
                        $subcategory_slug = isset($row['subcategory_slug']) ? $row['subcategory_slug'] : null;
                        $group_slug = isset($row['group_slug']) ? $row['group_slug'] : null;
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
                                        if (!$subCategory) {
                                            $data['missed'][] = 'Sub-category slug ' . $subcategory_slug . ' not found';
                                        }
                                    } else {
                                        $subCategory = Category::where("name", $row['subcategory'])->where('parent_id', '!=', null)->first();
                                        if (!$subCategory) {
                                            $data['missed'][] = 'Sub-category name ' . $row['subcategory'] . ' not found';
                                        }
                                    }
                                    if ($subCategory) {
                                        SubCategoryGroup::firstOrCreate(['sub_category_id' => $subCategory->id, 'category_id' => $subCategory->parent->id, 'group_id' => $item->id,]);
                                        $index++;
                                    }
                                }
                                $updatedCounts++;
                            } else {
                                $item = Group::create(["name_en" => $row['group'], 'name_ar' => $row['group_ar'], "image" => $groupImage, "slug" => $group_slug]);
                                if ($row['category'] != null || $row['subcategory'] != null) {
                                    if ($subcategory_slug) {
                                        $subCategory = Category::where('slug', $subcategory_slug)->where('parent_id', '!=', null)->first();
                                        if (!$subCategory) {
                                            $data['missed'][] = 'Sub-category slug ' . $subcategory_slug . ' not found';
                                        }
                                    } else {
                                        $subCategory = Category::where("name", $row['subcategory'])->where('parent_id', '!=', null)->first();
                                        if (!$subCategory) {
                                            $data['missed'][] = 'Sub-category name ' . $row['subcategory'] . ' not found';
                                        }
                                    }
                                    if ($subCategory) {
                                        SubCategoryGroup::firstOrCreate(['sub_category_id' => $subCategory->id, 'category_id' => $subCategory->parent->id, 'group_id' => $item->id,]);
                                        $index++;
                                    }
                                }
                                $createdCounts;
                            }
                            $parentCategory = $item;
                        } else {
                            if ($parentCategory) {
                                if ($row['category'] != null || $row['subcategory'] != null) {
                                    if ($subcategory_slug) {
                                        $subCategory = Category::where('slug', $subcategory_slug)->where('parent_id', '!=', null)->first();
                                        if (!$subCategory) {
                                            $data['missed'][] = 'Sub-category slug ' . $subcategory_slug . ' not found';
                                        }
                                    } else {
                                        $subCategory = Category::where("name", $row['subcategory'])->where('parent_id', '!=', null)->first();
                                        if (!$subCategory) {
                                            $data['missed'][] = 'Sub-category name ' . $row['subcategory'] . ' not found';
                                        }
                                    }
                                    if ($subCategory) {
                                        SubCategoryGroup::firstOrCreate(['sub_category_id' => $subCategory->id, 'category_id' => $subCategory->parent->id, 'group_id' => $parentCategory->id,]);
                                        $index++;
                                    }
                                }
                            }
                        }
                        $progress = ceil(($index / count($rows)) * 100);
                        $this->_importRepo->updateHistoryProgress($progress, $this->history_id);
                        $this->status = 'success';
                    } else {
                        $this->status = 'cancelled';
                        Log::channel('imports')->info('Import Canceled');
                        break;
                    }
                }
                $this->_importRepo->changeState(ImportConstants::STATE_COMPLETE, $this->history_id);
                $this->statusCode = '200';
                $this->reportData = $data;
                $this->errorMessage = null;
            }
        } catch (\Exception $e) {
            $this->status = 'error';
            $this->statusCode = '422';
            $this->reportData = $data;
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
