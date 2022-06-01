<?php

return [

    /*
    |--------------------------------------------------------------------------
    | System Constants
    |--------------------------------------------------------------------------
    |
    */

    'products'               => envFromDB('PRODUCT_TYPE', 'variant'),
    'delivery_method'        => envFromDB('DELIVERY_FEES', 'location'),
    'admin_url'              => envFromDB('ADMIN_URL'),
    'ex_rate_pts'            => envFromDB('ex_rate_pts', 0),
    'ex_rate_egp'            => envFromDB('ex_rate_egp', 0),
    'ex_rate_gold'           => envFromDB('ex_rate_gold', 0),
    'egp_gold'               => envFromDB('egp_gold', 0),
    'pending_days'           => envFromDB('pending_days', 0),
    'refer_points'           => envFromDB('refer_points', 0),
    'refer_minimum'          => envFromDB('refer_minimum', 0),
    'off_time'               => envFromDB('off_time'),
    'min_order_amount'       => envFromDB('min_order_amount', 0),
    'open_time'              => envFromDB('open_time'),
    'except_cod_amount'      => envFromDB('except_cod_amount', 0),
    'menu'                   => envFromDB('menu'),
    'affiliate_pending_days' => envFromDB('affiliate_pending_days', 0),
    'enable_affiliate'       => envFromDB('enable_affiliate', false),
    'primary_color'          => envFromDB('WEB_BRAND_COLOR'),
];
