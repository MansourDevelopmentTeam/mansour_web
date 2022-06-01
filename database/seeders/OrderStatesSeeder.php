<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderStatesSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table("order_states")->insert([
            ["name" => "Created"],
            ["name" => "Processing"],
            ["name" => "On Delivery"],
            ["name" => "Delivered"],
            ["name" => "Investigation"],
            ["name" => "Cancelled"],
            ["name" => "Returned"],
            ["name" => "Prepared"],
            ["name" => "Not Paid"],
            ["name" => "Partial Returned"],
            ["name" => "Pending Payment"],
            ["name" => "Payment Expired"],
        ]);
    }
}
