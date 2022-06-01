<?php
namespace App\Sheets\Export\Brands;

use App\Models\Products\Brand;
use App\Models\Products\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class BrandsExport implements FromCollection, WithHeadings ,WithMapping, ShouldAutoSize, WithStrictNullComparison
{


    public function collection()
    {
        $brands = Brand::all();
        return $brands;
    }


    public function map($item): array
    {
        return [
            $item->name,
            $item->name_ar,
            $item->image,
        ];
    }

    public function headings(): array
    {
      return  [
            "brand",
            "brand_ar",
            "image"
        ];
    }
}
