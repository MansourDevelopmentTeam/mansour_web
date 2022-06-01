<?php


namespace App\Services\ExportFiles;


use App\Models\Medical\Prescription;
use App\Models\Products\Brand;
use App\Models\Users\Address;

class ExportPrescription extends ExportFiles
{
    protected $_reportName = 'Prescription_';

    public function prepareExportDataArray($filterData = null): \Generator
    {

        $prescriptions = Prescription::all();
        $this->_count = $prescriptions->count();

        foreach ($prescriptions as $prescription){
            $address = Address::find($prescription->address_id);
            yield [
                $prescription->id,
                $prescription->user->name,
                $prescription->admin ? $prescription->admin->name : "-",
                $prescription->user->phone,
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
    }
}
