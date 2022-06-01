<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $configurations = [];

        $configurations = array_merge($configurations, config('variables.admin'));
        $configurations = array_merge($configurations, config('variables.app'));
        $configurations = array_merge($configurations, config('variables.services'));
        $configurations = array_merge($configurations, config('variables.settings'));
        $configurations = array_merge($configurations, config('variables.web'));
        $configurations = array_merge($configurations, config('variables.themes'));
        $configurations = array_merge($configurations, config('variables.strings'));



        foreach ($configurations as $configuration) {
            DB::table('configurations')->updateOrInsert(
                ['key' => $configuration['key']],
                Arr::except($configuration, ['key', 'value'])
            );
        }

        $configurationKeys = Arr::pluck($configurations, 'key');
        DB::table('configurations')->whereNotIn('key', $configurationKeys)->delete();


    }
}
