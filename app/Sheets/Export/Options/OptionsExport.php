<?php
namespace App\Sheets\Export\Options;

use App\Models\Products\Brand;
use App\Models\Products\Category;
use App\Models\Products\Option;
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

class OptionsExport implements FromCollection, WithHeadings ,WithMapping, ShouldAutoSize, WithStrictNullComparison
{


    public function collection()
    {
        return Option::with('values')->get();
    }


    public function map($item): array
    {
        $type = '';
        if ($item->type == 1) {
            $type = 'text';
        } elseif ($item->type == 2) {
            $type = 'color code';
        } elseif ($item->type == 3) {
            $type = 'image';
        } elseif ($item->type == 4) {
            $type = 'variant image';
        } elseif ($item->type == 5) {
            $type = 'input';
        }
        if (count($item['values']) > 0) {
            $i = 0;
            $values = [];
            foreach ($item['values'] as $value) {
                $array = [
                    $i == 0 ? $item->name_en : '',
                    $i == 0 ? $item->name_ar : '',
                    $i == 0 ? $type : '',
                    $value->image,
                    $value->color_code,
                    $value->name_en,
                    $value->name_ar,
                ];
                $values[] = $array;
                $i++;
            }
            $data = $values;
        } else {
            $data = [
                $item->name_en,
                $item->name_ar,
                $type,
                $item->image,
                $item->color_code,
                '',
                '',
            ];
        }

        return $data;
    }

    public function headings(): array
    {
      return  [
          "option",
          "option_ar",
          "type",
          "image",
          "hex_code",
          "values",
          "values_ar",
      ];
    }
}
