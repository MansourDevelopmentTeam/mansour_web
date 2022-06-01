<?php

namespace App\Sheets\Export\Categories;

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

class CategoriesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStrictNullComparison
{


    public function collection()
    {
        $items = Category::where('parent_id', null)->with('subCategories')->get();
        return $items;
    }


    public function map($item): array
    {
        if (count($item['subCategories']) > 0) {
            $i = 0;
            $subCategoryData = [];
            foreach ($item['subCategories'] as $subCategory) {
                $options = $subCategory->options()->pluck('name_en')->implode(',');
                $array = [
                    $i == 0 ? $item->name : '',
                    $i == 0 ? $item->name_ar : '',
                    $i == 0 ? $item->image : '',
                    $subCategory->name,
                    $subCategory->name_ar,
                    $subCategory->slug,
                    $subCategory->image,
                    $options
                ];
                $subCategoryData[] = $array;
                $i++;
            }
            $data = $subCategoryData;
        } else {
            $data = [
                $item->name,
                $item->name_ar,
                $item->slug,
                $item->image,
                '',
                '',
                '',
            ];
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            "category",
            "category_ar",
            "slug",
            "category_image",
            "subcategory",
            "subcategory_ar",
            "subcategory_slug",
            "subcategory_image",
            "subcategory_options",
        ];
    }
}
