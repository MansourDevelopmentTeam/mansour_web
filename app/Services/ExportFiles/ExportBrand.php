<?php


namespace App\Services\ExportFiles;


use App\Models\Products\Brand;

class ExportBrand extends ExportFiles
{
    protected $_reportName = 'Brands_';

    public function prepareExportDataArray($filterData = null): \Generator
    {
        $brands = Brand::all();
        $this->_count = $brands->count();
        foreach ($brands as $brand){
            yield [$brand->name, $brand->name_ar, $brand->image];
        }
    }
}