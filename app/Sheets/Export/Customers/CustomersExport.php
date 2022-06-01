<?php
namespace App\Sheets\Export\Customers;

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

class CustomersExport implements FromCollection, WithHeadings ,WithMapping, ShouldAutoSize, WithStrictNullComparison
{


    public function collection()
    {
        return User::withCount('orders')->where("type", 1)->with('cart.cartItems.product','addresses','settings')->get();
    }


    public function map($customer): array
    {
        return [
            $customer->id,
            $customer->name,
            $customer->email,
            $customer->birthdate ? date("Y-m-d", strtotime($customer->birthdate)) : "",
            $customer->addresses->first() ? $customer->addresses->first()->address : "",
            $customer->phone,
            $customer->orders_count,
            $customer->settings->language ?? null,
            (int)$customer->active
        ];
    }

    public function headings(): array
    {

      return   ["id", "name", "email", "birthdate", "address", "contact", "total_orders","language", "active"];
    }
}
