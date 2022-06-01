<?php
namespace App\Sheets\Export\Deliverers;

use App\Models\Products\Brand;
use App\Models\Products\Product;
use App\Models\Users\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class DelivererOrdersExport implements FromCollection, WithHeadings ,WithMapping, ShouldAutoSize, WithStrictNullComparison
{


    public function __construct($id){
        $this->id = $id;
    }
    public function collection()
    {
        $deliverer =  User::where("type", 3)->where("id", $this->id)->firstOrFail();
        return $deliverer->deliveries;
    }


    public function map($order): array
    {
        return [
            $order->id,
            $order->customer->name,
            $order->created_at,
            $order->invoice->cost_amount,
            $order->invoice->total_amount,
            $order->invoice->remaining,
            $order->state->name,
        ];
    }

    public function headings(): array
    {

      return   ["id", "customer", "time", "paid amount", "total amount", "remaining", "state"];
    }
}
