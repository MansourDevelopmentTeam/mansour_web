<?php

return [

    /*
    |--------------------------------------------------------------------------
    | System Integration
    |--------------------------------------------------------------------------
    |
    */

    'sms' => [
        'default' => envFromDB('SMS_CONNECTION', ''),
        'driver' => envFromDB('SMS_DRIVER', 'database'),
        'username' => envFromDB('SMS_USERNAME', 'username'),
        'password' => envFromDB('SMS_PASSWORD', 'password'),
        'sender_id' => envFromDB('SMS_SENDER_ID', 'sender_id'),
        'token' => envFromDB('SMS_TOKEN', 'token'),
        'msignature' => envFromDB('SMS_MSIGNATURE', 'msignature'),
        'sms_id' => envFromDB('SMS_ID', 'sms_id')
    ],

    'aramex' => [
		'url'  => envFromDB('ARAMEX_URL'),
		'username'  => envFromDB('ARAMEX_USER_NAME'),
		'password'  => envFromDB('ARAMEX_PASSWORD'),
		'account_entity'    => 'CAI',
		'account_country_code'  => 'EG',
		'version'   => 'v1',
        'sub_account'   => [
            [
                'account'   => 1,
                'account_pin'   => envFromDB('ARAMEX_ACCOUNT_PIN_1'),
                'account_number'    => envFromDB('ARAMEX_ACCOUNT_NUMBER_1'),
            ],
            [
                'account'   => 2,
                'account_pin'   => envFromDB('ARAMEX_ACCOUNT_PIN_2'),
                'account_number'    => envFromDB('ARAMEX_ACCOUNT_NUMBER_2'),
            ]
        ]
    ],
    'qatar_post' => [
    'url'  => envFromDB('QATAR_POST_URL'),
    'username'  => envFromDB('QATAR_POST_USER_NAME'),
    'password'  => envFromDB('QATAR_POST_PASSWORD')
]

];
