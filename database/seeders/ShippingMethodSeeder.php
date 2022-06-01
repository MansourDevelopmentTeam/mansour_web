<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShippingMethodSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shipping_methods')->truncate();
        DB::table('shipping_methods')->insert([
            ["name" => "INTERNAL"],
            ["name" => "MYLERZ"],
            ["name" => "ARAMEX"],
            ["name" => "BOSTA"],
        ]);
    }
}
