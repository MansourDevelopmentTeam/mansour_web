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

class DeliverersExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStrictNullComparison
{


    public function collection()
    {
        return User::with("delivererProfile")->where("active", 1)->where("type", 3)->get();
    }


    public function map($user): array
    {
        return [
            $user->id,
            $user->delivererProfile->unique_id,
            $user->name,
            $user->addresses->first() ? $user->addresses->first()->address : "",
            $user->phone,
            $user->orders->count(),
            $user->delivererProfile->area->name,
            (int)$user->active
        ];
    }

    public function headings(): array
    {

        return ["id", "unique_id", "name", "address", "phone", "total_orders", "area", "active"];
    }
}
