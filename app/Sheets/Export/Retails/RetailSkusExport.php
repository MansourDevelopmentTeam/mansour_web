<?php

namespace App\Sheets\Export\Retails;

use App\Models\Products\Brand;
use App\Models\Products\Product;
use App\Models\Retails\RetailDraft;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class RetailSkusExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStrictNullComparison
{
    public function collection()
    {
        $request = request();
        $query = RetailDraft::query()->with('product');
        $query->when(isset($request->status), function ($q) use ($request) {
            $q->when($request->status == 1, function ($q) {
                $q->whereNull('product_id');
            });
            $q->when($request->status == 2, function ($q) {
                $q->whereNotNull('product_id');
            });
        })->when($request->q, function ($q) use ($request) {
            $q->where('sku', 'like', "{$request->q}%");
        });
        $drafts = $query->orderBy("sku", "asc")->get();
        return $drafts;
    }


    public function map($item): array
    {
        return [
            $item->id,
            $item->name,
            $item->sku,
            $item->stock,
            $item->price,
            $item->discount_price,
        ];
    }

    public function headings(): array
    {
        return ['id', 'name', 'sku', 'stock', 'price', 'discount_price'];
    }
}
