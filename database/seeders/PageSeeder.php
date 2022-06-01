<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pages')->truncate();

        DB::table('pages')->insert([
            'slug' => 'contact',
            'title_en' => 'Contact us',
            'title_ar' => 'اتصل بنا',
            'content_ar' => 'static',
            'content_en' => 'static',
            'active' => '1',
            // 'order' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pages')->insert([
            'slug' => 'branches',
            'title_en' => 'Branches',
            'title_ar' => 'الفروع',
            'content_ar' => 'static',
            'content_en' => 'static',
            'active' => '1',
            // 'order' => '2',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
