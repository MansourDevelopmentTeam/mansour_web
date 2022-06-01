<?php


namespace App\Services\ExportFiles;


use App\Models\Products\Group;
use Generator;

class ExportGroups extends ExportFiles
{
    protected $_reportName = 'Groups_';
    public function prepareExportDataArray($filterData = null): Generator
    {
        $items = Group::with('sub_categories')->get();
        $this->_count = $items->count();
        foreach ($items as $item) {
            if (count($item['sub_categories']) > 0) {
                $i = 0;
                $subCategoryData = [];
                foreach ($item['sub_categories'] as $subCategory) {
                    $array = [
                        $i == 0 ? $item->name_en : '', $i == 0 ? $item->name_ar : '',
                        $subCategory->parent->name,
                        $subCategory->name, $subCategory->slug,
                        $i == 0 ? $item->slug : '', $i == 0 ? $item->image : ''
                    ];
                    $subCategoryData[] = $array;
                    $i++;
                }
                $data = $subCategoryData;
            } else {
                $data = [
                    $item->name_en,$item->name_ar, '', '', '', $item->slug,$item->image
                ];
            }
            yield $data;
        }
    }
}