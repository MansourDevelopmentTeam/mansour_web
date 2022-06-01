<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\Users\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $admin['name'] = "Admin";
        $admin['email'] = "admin@admin.com";
        $admin['type'] = 2;
        $admin['password'] = bcrypt(123456);
        User::create($admin);
    }
}
