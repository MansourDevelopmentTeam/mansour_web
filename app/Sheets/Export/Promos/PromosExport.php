<?php
namespace App\Sheets\Export\Promos;

use App\Models\Payment\Promo;
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

class PromosExport implements FromCollection, WithHeadings ,WithMapping, ShouldAutoSize, WithStrictNullComparison
{


    public function collection()
    {
        return Promo::with("invoices")->get();
    }


    public function map($promo): array
    {
        $type = $promo->type == 1 ? "Amount" : "Percent";
        return  [
            $promo->id,
            $promo->name,
            $promo->description,
            $promo->amount,
            $type,
            $promo->use_number,
            $promo->expiration_date,
            (int)$promo->active
        ];
    }

    public function headings(): array
    {
      return ["id", "name", "description", "amount", "type", "uses", "expiration_date", "active"];
    }
}
