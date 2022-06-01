<?php


namespace App\Services\ExportFiles;


use App\Models\Products\Category;

class ExportCategory extends ExportFiles
{

    protected $_reportName = 'Categories_';

    public function prepareExportDataArray($filterData = null): \Generator
    {
        $categories = Category::where('parent_id', null)->with('subCategories')->get();
        $this->_count = $categories->count();
        foreach ($categories as $item) {
            if (count($item['subCategories']) > 0) {
                $i = 0;
                $subCategoryData = [];
                foreach ($item['subCategories'] as $subCategory) {
                    $options = $subCategory->options()->pluck('name_en')->implode(',');
                    $array = [
                        $item->name ?? '', $item->name_ar ?? '', $subCategory->name,
                        $subCategory->name_ar, $subCategory->slug,
                        $options, $item->image ?? '' ,$subCategory->image,
                    ];
                    $subCategoryData[] = $array;
                    $i++;
                }
                $data = $subCategoryData;
            } else {
                $data = [
                    $item->name, $item->name_ar, $item->image, '', '', '',
                ];
            }
           yield $data;
        }
    }
}