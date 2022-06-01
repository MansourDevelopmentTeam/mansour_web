<?php
namespace App\Sheets\Export\Groups;

use App\Models\Products\Brand;
use App\Models\Products\Category;
use App\Models\Products\Group;
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

class GroupsExport implements FromCollection, WithHeadings ,WithMapping, ShouldAutoSize, WithStrictNullComparison
{


    public function collection()
    {
        $items = Group::with('sub_categories')->get();
        return $items;
    }


    public function map($item): array
    {
        if (count($item['sub_categories']) > 0) {
            $i = 0;
            $subCategoryData = [];
            foreach ($item['sub_categories'] as $subCategory) {
                $array = [
                    $i == 0 ? $item->name_en : '',
                    $i == 0 ? $item->name_ar : '',
                    $i == 0 ? $item->image : '',
                    $subCategory->parent->name,
                    $subCategory->name,
                    $subCategory->slug,
                    $i == 0 ? $item->slug : '',
                ];
                $subCategoryData[] = $array;
                $i++;
            }
            $data = $subCategoryData;
        } else {
            $data = [
                $item->name_en,
                $item->name_ar,
                $item->image,
                '',
                '',
                '',
                $item->slug,
            ];
        }

        return $data;
    }

    public function headings(): array
    {
      return  [
          "group",
          "group_ar",
          "group_image",
          "category",
          "subcategory",
          "subcategory_slug",
          "group_slug"
        ];
    }
}
