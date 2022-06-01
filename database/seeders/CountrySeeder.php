<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->truncate();

        DB::table('countries')->insert([
                'name_en'          => 'Egypt',
                'name_ar'          => 'مصر',
                'country_code'     => 'EG',
                'currency_code_en' => 'EGP',
                'currency_code_ar' => 'ج.م',
                'flag'             => 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/fe/Flag_of_Egypt.svg/125px-Flag_of_Egypt.svg.png',
                'phone_prefix'     => '+2',
                'phone_length'     => '11',
                'phone_pattern'    => '(010|011|012|015)([0-9]{8})',
                'default_language' => 'AR',
                'fallback'         => true,
        ]);

        DB::table('countries')->insert([
            'name_en'          => 'Qatar',
            'name_ar'          => 'قطر',
            'country_code'     => 'QA',
            'currency_code_en' => 'QR',
            'currency_code_ar' => 'ر.ق',
            'flag'             => 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/Flag_of_Qatar.svg/125px-Flag_of_Qatar.svg.png',
            'phone_prefix'     => '+974',
            'phone_length'     => '8',
            'phone_pattern'    => '(30|33|70|77|55|66|60|50|74|44|40)([0-9]{6})',
            'default_language' => 'AR',
        ]);

    }
}
