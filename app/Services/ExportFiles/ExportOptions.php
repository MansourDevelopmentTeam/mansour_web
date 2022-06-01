<?php


namespace App\Services\ExportFiles;


use App\Models\Products\Option;
use Generator;

class ExportOptions extends ExportFiles
{
    protected $_reportName = 'Options_';

    /**
     * @param null $filterData
     * @return Generator
     */
    public function prepareExportDataArray($filterData = null): Generator
    {
        $items = Option::with('values')->get();
        $this->_count = $items->count();
        foreach ($items as $item) {
            $type = $this->getType($item->type);
            if (count($item['values']) > 0) {
                $i = 0;
                $values = [];
                foreach ($item['values'] as $value) {
                    $array = [
                        $i == 0 ? $item->name_en : '', $i == 0 ? $item->name_ar : '',
                        $i == 0 ? $type : '', $value->image, $value->color_code, $value->name_en, $value->name_ar,
                    ];
                    $values[] = $array;
                    $i++;
                }
                $data = $values;
            } else {
                $data = [
                    $item->name_en, $item->name_ar, $type, $item->image, $item->color_code, '', '',
                ];
            }
           yield $data;
        }
    }

    /**
     * @param $type
     * @return string
     */
    private function getType($type): string
    {
        if ($type == 1) {
            return 'text';
        } elseif ($type == 2) {
            return 'color code';
        } elseif ($type == 3) {
            return 'image';
        } elseif ($type == 4) {
            return 'variant image';
        } elseif ($type == 5) {
            return 'input';
        }
        return '';
    }
}