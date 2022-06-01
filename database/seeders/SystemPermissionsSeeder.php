<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        // DB::table("permissions")->insert([
        //     ["guard_name" => "web", "name" => "View Categories"],
        //     ["guard_name" => "web", "name" => "View Products"],
        //     ["guard_name" => "web", "name" => "View Brands"],
        //     ["guard_name" => "web", "name" => "View Options"],
        //     ["guard_name" => "web", "name" => "View Orders"],
        //     ["guard_name" => "web", "name" => "View Order States"],
        //     ["guard_name" => "web", "name" => "View Customers"],
        //     ["guard_name" => "web", "name" => "View Staff"],
        //     ["guard_name" => "web", "name" => "View Cities"],
        //     ["guard_name" => "web", "name" => "View Promos"],
        //     ["guard_name" => "web", "name" => "View Ads"],
        //     ["guard_name" => "web", "name" => "View Notifications"],
        //     ["guard_name" => "web", "name" => "View Rewards"],
        //     ["guard_name" => "web", "name" => "View Gift Requests"],
        //     ["guard_name" => "web", "name" => "View Medical"],
        //     ["guard_name" => "web", "name" => "View Admins"],
        //     ["guard_name" => "web", "name" => "View Settings"],
        //     ["guard_name" => "web", "name" => "View Ads"],
        //     ["guard_name" => "web", "name" => "View Slider"],
        //     ["guard_name" => "web", "name" => "View Sections"],
        //     ["guard_name" => "web", "name" => "View Lists"]
        // ]);

        DB::table("permissions")->insert([
            ["guard_name" => "web", "name" => "View Group page"]
        ]);
    }
}
