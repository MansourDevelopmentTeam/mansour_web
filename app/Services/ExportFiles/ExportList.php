<?php


namespace App\Services\ExportFiles;


use App\Models\Products\Lists;
use Generator;

class ExportList extends ExportFiles
{
    protected $_reportName = 'List_';

    public function prepareExportDataArray($filterData = null): Generator
    {
        $list = Lists::findOrFail(request('list_id'));
        $this->_count = $list->count();
        if (count($list->products) > 0) {
            for ($i = 0; $i < $list->products->count(); $i++) {
               yield [$list->products[$i]->sku];
            }
        }
    }
}