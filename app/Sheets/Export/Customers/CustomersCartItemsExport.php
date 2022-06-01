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

class CustomersCartItemsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStrictNullComparison
{


    public function collection()
    {
        $users = User::where("type", 1)->with('cart.cartItems.product')->get()->filter(function ($customer) {
            return (bool)optional($customer->cart)->count();
        });
        return $users;
    }


    public function map($customer): array
    {
        $skus = "";
        $lastUpdate = "";
        if ($customer->cart) {
            $cartItems = $customer->cart->cartItems;
            $skus = implode(",", $cartItems->pluck('product')->pluck('sku')->toArray());
            $lastUpdate = optional($cartItems->sortByDesc('updated_at')->first())->updated_at;
        }
        return [
            $customer->id,
            $customer->name,
            $customer->email,
            $customer->phone,
            $skus,
            $lastUpdate
        ];
    }

    public function headings(): array
    {

        return ["id", "name", "email", "contact", "items", "last_update"];
    }
}
