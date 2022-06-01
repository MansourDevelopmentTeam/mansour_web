<?php

namespace App\Sheets\Export\Products;

use App\Models\Inventories\Inventory;
use App\Models\Products\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductSalesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStrictNullComparison
{

    public function __construct($items)
    {
        $this->items = $items;
    }

    public function collection()
    {
        return $this->items;
    }


    public function map($item): array
    {
        // dd(array_values($player));
        return [
            $item->product->name,
            $item->product->parent->sku,
            $item->product->sku,
            $item->sale_count,
        ];
    }

    public function headings(): array
    {
        return ["name", "main_sku", "sku", "count"];
    }
}
