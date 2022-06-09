<?php

return [

        /**
         * Orange SMS integration
         */
        'sms' => [
            'api_domain' => 'https://marketingportal.access2arabia.com:7755',
            'send_sms_api_uri' => '/JSON/API/A2A/SendSMS',
            'sender_id' => env('ORANGE_SENDER_ID') ?? null,
            'username' => env('ORANGE_SMS_USERNAME') ?? null,
            'password' => env('ORANGE_SMS_PASSWORD') ?? null
        ]
];
