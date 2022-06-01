<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdsSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ads')->insert([
            ["image" => "http://via.placeholder.com/328x177", "banner_ad" => 1, "created_at" => date("Y-m-d"), "active" => 1, 'type' => 3],
            ["image" => "http://via.placeholder.com/328x177", "banner_ad" => 1, "created_at" => date("Y-m-d"), "active" => 1, 'type' => 3],
            ["image" => "http://via.placeholder.com/328x177", "banner_ad" => 1, "created_at" => date("Y-m-d"), "active" => 1, 'type' => 3],
            ["image" => "http://via.placeholder.com/328x177", "banner_ad" => 1, "created_at" => date("Y-m-d"), "active" => 1, 'type' => 3],
            ["image" => "http://via.placeholder.com/328x177", "banner_ad" => 1, "created_at" => date("Y-m-d"), "active" => 1, 'type' => 3],
            ["image" => "http://via.placeholder.com/328x177", "banner_ad" => 1, "created_at" => date("Y-m-d"), "active" => 1, 'type' => 3]
        ]);
    }
}
