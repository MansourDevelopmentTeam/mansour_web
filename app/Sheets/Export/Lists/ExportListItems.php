<?php

namespace App\Sheets\Export\Lists;

use App\Models\Products\Brand;
use App\Models\Products\ListItems;
use App\Models\Products\Lists;
use App\Models\Products\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportListItems implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStrictNullComparison
{

    private $listID;

    public function __construct($listID)
    {
        $this->listID = $listID;
    }

    public function collection()
    {
        $list = Lists::where('id', $this->listID)->with('products')->get();
        return $list;
    }


    public function map($list): array
    {
        $arr = [];
        if (count($list->products) > 0) {
            foreach ($list->products as $key => $product) {
                $arr[] = [
                    $product->sku,
                    $product->name,
                    $list->id,
                ];
            }
        }
        return $arr;
    }

    public function headings(): array
    {
        return ["sku", 'name', 'list_id'];
    }
}
