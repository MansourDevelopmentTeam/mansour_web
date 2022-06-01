<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
        'client_id' => env("FACEBOOKK_CLIENT_ID", ""),
        'client_secret' => envFromDB("FACEBOOK_CLIENT_SECRET", ""),
        'redirect' => "",
    ],

    'google' => [
        'client_id' => envFromDB("GOOGLE_CLIENT_ID", ""),
        'client_secret' => envFromDB("GOOGLE_CLIENT_SECRET", ""),
        'redirect' => envFromDB("GOOGLE_REDIRECT", ""),
    ],
    "apple" => [
        "client_id" => env("APPLE_CLIENT_ID"),
        "client_secret" => env("APPLE_CLIENT_SECRET"),
        "redirect" => env("APPLE_REDIRECT_URI")
    ],
];
