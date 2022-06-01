<?php
namespace App\Sheets\Export\Prescriptions;

use App\Models\Medical\Prescription;
use App\Models\Products\Brand;
use App\Models\Products\Product;
use App\Models\Users\Address;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class PrescriptionsExport implements FromCollection, WithHeadings ,WithMapping, ShouldAutoSize, WithStrictNullComparison
{


    public function collection()
    {
        return Prescription::with("user")->get();
    }


    public function map($prescription): array
    {
        $address = Address::find($prescription->address_id);
        return [
            $prescription->id,
            $prescription->user->full_name ?? $prescription->address->customer_full_name,
            $prescription->admin ? $prescription->admin->name : "-",
            $prescription->user->phone ?? $prescription->address->phone,
            $prescription->note,
            implode(',', $prescription->images->pluck('url')->toArray()),
            optional($address)->formatted_address,
            $prescription->invoice_id,
            $prescription->amount,
            $prescription->comment,
            $prescription->cancellation_id,
            optional($prescription->CancellationReason)->text,
            $prescription->cancellation_text,
            $prescription->status_word,
            $prescription->created_at,
        ];
    }

    public function headings(): array
    {
      return  ["id", "name", "assigned admin", "phone", "note", "images", 'address', 'invoice_id', 'amount', 'comment', "cancellation_id", "cancellation_reason", "cancellation_text", 'status', "time"];
    }
}
