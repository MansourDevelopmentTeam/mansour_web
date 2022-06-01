<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CopySettingsToConfigurations extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $settings = DB::table('settings')->first();

        $fieldTypes = [
            'ex_rate_pts'            => 'number',
            'ex_rate_egp'            => 'number',
            'ex_rate_gold'           => 'number',
            'egp_gold'               => 'number',
            'pending_days'           => 'number',
            'refer_points'           => 'number',
            'refer_minimum'          => 'number',
            'off_time'               => 'time',
            'open_time'              => 'time',
            'min_order_amount'       => 'number',
            'except_cod_amount'      => 'number',
            'menu'                   => 'textarea',
            'softbar_text_ar'        => 'textarea',
            'softbar_text_en'        => 'textarea',
            'softbar_bg_color'       => 'color',
            'softbar_view'           => 'switch',
            'affiliate_pending_days' => 'number',
            'enable_affiliate'       => 'switch',
        ];

        foreach ($settings as $key => $value) {
            if ($key == 'id' || $key == 'created_at' || $key == 'updated_at') {
                continue;
            }
            DB::table('configurations')->where('key', $key)->update([
                "alias" => null,
                "value" => $value,
                "label" => ucwords(str_replace('_', ' ', $key)),
                "type" => $fieldTypes[$key],
                "group" => "Ecommerce",
                "required" => true,
                "editable" => true,
                "scope" => "backend",
                "description" => null,
            ]);
        }

    }
}
