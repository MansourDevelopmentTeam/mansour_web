<?php

namespace App\Sheets\Export\Cities;

use App\Models\Locations\City;
use App\Models\Products\Brand;
use App\Models\Products\Category;
use App\Models\Products\Product;
use App\Models\Products\Tag;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class CitiesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStrictNullComparison
{
    public function collection()
    {
        return City::with('areas', 'areas.districts')->get();
    }


    public function map($item): array
    {
        $finalData = [];
        if (count($item->areas) > 0) {
            foreach ($item->areas as $area) {
                if (count($area->districts) > 0) {
                    foreach ($area->districts as $districts) {
                        $finalData[] = [
                            $item->name,
                            $item->name_ar,
                            $item->delivery_fees,
                            $area->name,
                            $area->name_ar,
                            $area->delivery_fees,
                            $districts->name,
                            $districts->name_ar,
                            $districts->delivery_fees,
                        ];
                    }
                } else {
                    $finalData[] =[
                        $item->name,
                        $item->name_ar,
                        $item->delivery_fees,
                        $area->name,
                        $area->name_ar,
                        $area->delivery_fees,
                        '',
                        '',
                        '',
                    ];
                }
            }
        } else {
            $finalData[] = [
                $item->name,
                $item->name_ar,
                $item->delovery_fees,
                '',
                '',
                '',
            ];
        }

        return $finalData;
    }

    public function headings(): array
    {
        return [
            "city_name",
            "city_name_ar",
            "city_fees",
            "area_name",
            "area_name_ar",
            "area_fees",
            "district_name",
            "district_name_ar",
            "district_fees"
        ];
    }
}
