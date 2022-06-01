<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Payment Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the default payment "driver" that will be used on
    | requests.
    |
    |
    */

    'driver' => env('PAYMENT_DRIVER', 'cod'),

    'env' => env('PAYMENT_ENV', 'test'),

    'we_accept_credential' => [
        'api_key' => envFromDB('WE_ACCEPT_PAYMENT_API_KEY'),
        'hmac_hash' => envFromDB('HMAC_HASH'),
    ],

    /*
    |--------------------------------------------------------------------------
    | List Provider
    |--------------------------------------------------------------------------
    |
    | Here you may specify the provider that will be used to provide
    | Payment providers: "cod", "weaccept", "paytabs"
    |
    */
    'providers' => [
        'cod' => [
            'driver' => \App\Classes\Payment\Drivers\CodMethod::class,
            'credentials' => []
        ],
        'weaccept' => [
            'driver' => \App\Classes\Payment\Drivers\PaymobMethod::class,
            'credentials' => [
                'api_key',
                'iframe_id',
                'integration_id',
                'merchant_id',
            ],

        ],
        'bank' => [
            'driver' => \App\Classes\Payment\Drivers\MasterCardMethod::class,
            'credentials' => [
                'username',
                'password',
                'gateway_url',
                'checkout_js',
                'merchant_id',
            ],
        ],
        'paytabs' => [
            'driver' => \App\Classes\Payment\Drivers\PaytabsMethod::class,
            'credentials' => [
                'server_key',
                'profile_id',
                'test',
            ],
        ]
    ],


    /*
    |--------------------------------------------------------------------------
    | Payment Stores
    |--------------------------------------------------------------------------
    |
    |
    */

    'stores' => [

        /**
         * Cash On Delivery
         */
        1 => [
            'driver' => 'cod',
            'class' => \App\Classes\Payment\Drivers\CodMethod::class,
            'isActive' => true,
            'isOnline' => false,
            'isInstallment' => false,
            'type' => \App\Models\Payment\PaymentMethod::TYPE_CARD,
            'name_en' => 'Cash On Delivery',
            'name_ar' => 'الدفع عند الاستلام',
            'icon' => 'images/payment_methods/cash_payment.png',
            'credentials' => [],
        ],
        /**
         * Credit / Debit card We Accept
         */
        2 => [
            'driver' => 'visa_accept',
            'class' => \App\Classes\Payment\Drivers\PaymobMethod::class,
            'isActive' => true,
            'isOnline' => true,
            'isInstallment' => false,
            'type' => \App\Models\Payment\PaymentMethod::TYPE_CARD,
            'name_en' => 'Credit / Debit card',
            'name_ar' => 'بطاقة الائتمان \ خصم مباشر',
            "icon" => 'images/payment_methods/credit_payment.png',
            'credentials' => [
                'api_key' => envFromDB('WE_ACCEPT_PAYMENT_API_KEY'),
                'hmac_hash' => envFromDB('HMAC_HASH'),
                'iframe_id' => envFromDB('WE_ACCEPT_IFRAME_ID'),
                'integration_id' => envFromDB('WE_ACCEPT_INTEGRATION_ID'),
                'merchant_id' => envFromDB('MERCHANT_ID')
            ],
        ],
        /**
         * ValU
         */
        3 => [
            'driver' => 'valu',
            'class' => \App\Classes\Payment\Drivers\PaymobMethod::class,
            'isActive' => true,
            'isOnline' => true,
            'isInstallment' => true,
            'type' => \App\Models\Payment\PaymentMethod::TYPE_CARD,
            'name_en' => 'ValU',
            'name_ar' => 'فاليو',
            "icon" => 'images/payment_methods/valU_payment.png',
            'credentials' => [
                'api_key' => envFromDB('WE_ACCEPT_PAYMENT_API_KEY'),
                'hmac_hash' => envFromDB('HMAC_HASH'),
                'iframe_id' => envFromDB('VALU_IFRAME_ID'),
                'integration_id' => envFromDB('VALU_INTEGRATION_ID'),
                'merchant_id' => envFromDB('MERCHANT_ID')
            ],
        ],
        /**
         * Fawry
         */
        4 => [
            'driver' => 'fawry',
            'isActive' => false,
            'isOnline' => true,
            'isInstallment' => false,
            'type' => \App\Models\Payment\PaymentMethod::TYPE_CARD,
            'name_en' => 'Fawry',
            'name_ar' => 'فوري',
            "icon" => 'images/payment_methods/fawry.png'
        ],
        /**
         * Premium
         */
        5 => [
            'driver' => 'premium',
            'class' => \App\Classes\Payment\Drivers\PaymobMethod::class,
            'isActive' => true,
            'isOnline' => true,
            'isInstallment' => true,
            'type' => \App\Models\Payment\PaymentMethod::TYPE_CARD,
            'name_en' => 'Premium',
            'name_ar' => 'بريميوم',
            "icon" => 'images/payment_methods/premium.png',
            'credentials' => [
                'api_key' => envFromDB('WE_ACCEPT_PAYMENT_API_KEY'),
                'hmac_hash' => envFromDB('HMAC_HASH'),
                'iframe_id' => envFromDB('PREMIUM_IFRAME_ID'),
                'integration_id' => envFromDB('PREMIUM_INTEGRATION_ID'),
                'merchant_id' => envFromDB('MERCHANT_ID')
            ],
        ],
        /**
         * Credit card installment We Accept
         */
        6 => [
            'driver' => 'visa_accept_installment',
            'class' => \App\Classes\Payment\Drivers\PaymobMethod::class,
            'isActive' => true,
            'isOnline' => true,
            'isInstallment' => true,
            'type' => \App\Models\Payment\PaymentMethod::TYPE_CARD,
            'name_en' => 'Credit card installment',
            'name_ar' => 'تقسيط بطاقة الائتمان',
            "icon" => 'images/payment_methods/qnb_payment.png',
            'credentials' => [
                'api_key' => envFromDB('WE_ACCEPT_PAYMENT_API_KEY'),
                'hmac_hash' => envFromDB('HMAC_HASH'),
                'iframe_id' => envFromDB('WE_ACCEPT_IFRAME_ID'),
                'integration_id' => envFromDB('WE_ACCEPT_INTEGRATION_ID'),
                'merchant_id' => envFromDB('MERCHANT_ID')
            ],
        ],
        /**
         * Credit / Debit card QNB
         */
        7 => [
            'driver' => 'visa_qnb',
            'class' => \App\Classes\Payment\Drivers\MasterCardMethod::class,
            'isActive' => true,
            'isOnline' => true,
            'isInstallment' => false,
            'type' => \App\Models\Payment\PaymentMethod::TYPE_CARD,
            'name_en' => 'Credit / Debit card QNB',
            'name_ar' => 'بطاقة الائتمان \ خصم مباشر',
            "icon" => 'images/payment_methods/credit_payment.png',
            'credentials' => [
                'username' => envFromDB('QNB_USERNAME'),
                'password' => envFromDB('QNB_PASSWORD'),
                'base_url' => envFromDB('QNB_BASE_URL'),
                'gateway_url' => envFromDB('QNB_GATEWAY_URL'),
                'checkout_js' => envFromDB('QNB_CHECKOUT_JS'),
                'merchant_id' => envFromDB('QNB_MERCHANT_ID')
            ],
        ],
        /**
         * Meza
         */
        8 => [
            'driver' => 'meza',
            'class' => \App\Classes\Payment\Drivers\UpgMethod::class,
            'isActive' => false,
            'isOnline' => true,
            'isInstallment' => false,
            'type' => \App\Models\Payment\PaymentMethod::TYPE_CARD,
            'name_en' => 'Meza',
            'name_ar' => 'ميزه',
            "icon" => 'images/payment_methods/meza_payment.png',
            'credentials' => [
                'secure_key' => envFromDB('MEZA_SECURE_KEY'),
                'merchant_id' => envFromDB('MEZA_MERCHANT_ID'),
                'terminal_id' => envFromDB('MEZA_TERMINAL_ID')
            ],
        ],
        /**
         * Souhoola
         */
        9 => [
            'driver' => 'souhoola',
            'class' => \App\Classes\Payment\Drivers\PaymobMethod::class,
            'isActive' => true,
            'isOnline' => true,
            'isInstallment' => true,
            'type' => \App\Models\Payment\PaymentMethod::TYPE_CARD,
            'name_en' => 'Souhoola',
            'name_ar' => 'سهولة',
            "icon" => 'images/payment_methods/souhoola_payment.png',
            'credentials' => [
                'api_key' => envFromDB('WE_ACCEPT_PAYMENT_API_KEY'),
                'hmac_hash' => envFromDB('HMAC_HASH'),
                'iframe_id' => envFromDB('SOUHOOLA_IFRAME_ID'),
                'integration_id' => envFromDB('SOUHOOLA_INTEGRATION_ID'),
                'merchant_id' => envFromDB('MERCHANT_ID')
            ],
        ],
        /**
         * Get Go
         */
        10 => [
            'driver' => 'get_go',
            'class' => \App\Classes\Payment\Drivers\PaymobMethod::class,
            'isActive' => true,
            'isOnline' => true,
            'isInstallment' => true,
            'type' => \App\Models\Payment\PaymentMethod::TYPE_CARD,
            'name_en' => 'Get Go',
            'name_ar' => 'جيت جو',
            "icon" => 'images/payment_methods/get_go_payment.png',
            'credentials' => [
                'api_key' => envFromDB('WE_ACCEPT_PAYMENT_API_KEY'),
                'hmac_hash' => envFromDB('HMAC_HASH'),
                'iframe_id' => envFromDB('GET_GO_IFRAME_ID'),
                'integration_id' => envFromDB('GET_GO_INTEGRATION_ID'),
                'merchant_id' => envFromDB('MERCHANT_ID')
            ],
        ],
        /**
         * Shahry
         */
        11 => [
            'driver' => 'shahry',
            'class' => \App\Classes\Payment\Drivers\PaymobMethod::class,
            'isActive' => true,
            'isOnline' => true,
            'isInstallment' => true,
            'type' => \App\Models\Payment\PaymentMethod::TYPE_CARD,
            'name_en' => 'Shahry',
            'name_ar' => 'شهرى',
            "icon" => 'images/payment_methods/shahry_payment.png',
            'credentials' => [
                'api_key' => envFromDB('WE_ACCEPT_PAYMENT_API_KEY'),
                'hmac_hash' => envFromDB('HMAC_HASH'),
                'iframe_id' => envFromDB('SHAHRY_IFRAME_ID'),
                'integration_id' => envFromDB('SHAHRY_INTEGRATION_ID'),
                'merchant_id' => envFromDB('MERCHANT_ID')
            ],
        ],
        /**
         * Vodafone Cash
         */
        12 => [
            'driver' => 'vodafone_cash',
            'class' => \App\Classes\Payment\Drivers\PaymobMethod::class,
            'isActive' => true,
            'isOnline' => true,
            'isInstallment' => false,
            'type' => \App\Models\Payment\PaymentMethod::TYPE_CASH,
            'name_en' => 'Vodafone Cash',
            'name_ar' => 'فودافون كاش',
            "icon" => 'images/payment_methods/default.png',
            'credentials' => [
                'api_key' => envFromDB('WE_ACCEPT_PAYMENT_API_KEY'),
                'hmac_hash' => envFromDB('HMAC_HASH'),
                'iframe_id' => envFromDB('VODAFONE_IFRAME_ID'),
                'integration_id' => envFromDB('VODAFONE_INTEGRATION_ID'),
                'merchant_id' => envFromDB('MERCHANT_ID')
            ],
        ],
        /**
         * Visa NBE Installment
         */
        13 => [
            'driver' => 'visa_nbe_installment',
            'class' => \App\Classes\Payment\Drivers\MasterCardMethod::class,
            'isActive' => true,
            'isOnline' => true,
            'isInstallment' => true,
            'type' => \App\Models\Payment\PaymentMethod::TYPE_INSTALLMENT,
            'name_en' => 'Visa NBE Installment',
            'name_ar' => 'فيزا البنك الاهلى تقسيط',
            "icon" => 'images/payment_methods/visa_nbe_installment.png',
            'credentials' => [
                'base_url' => envFromDB('NBE_BASE_URL'),
                'gateway_url' => envFromDB('NBE_GATEWAY_URL'),
                'checkout_js' => envFromDB('NBE_CHECKOUT_JS')
            ],
        ],
        /**
         * Visa NBE
         */
        14 => [
            'driver' => 'visa_nbe',
            'class' => \App\Classes\Payment\Drivers\MasterCardMethod::class,
            'isActive' => true,
            'isOnline' => true,
            'isInstallment' => false,
            'type' => \App\Models\Payment\PaymentMethod::TYPE_CARD,
            'name_en' => 'Visa NBE',
            'name_ar' => 'فيزا البنك الاهلى',
            "icon" => 'images/payment_methods/visa_nbe_payment.png',
            'credentials' => [
                'username' => envFromDB('NBE_USERNAME'),
                'password' => envFromDB('NBE_PASSWORD'),
                'base_url' => envFromDB('NBE_BASE_URL'),
                'gateway_url' => envFromDB('NBE_GATEWAY_URL'),
                'checkout_js' => envFromDB('NBE_CHECKOUT_JS'),
                'merchant_id' => envFromDB('NBE_MERCHANT_ID')
            ],
        ],
        /**
         * Credit / Debit card QNB Installment
         */
        15 => [
            'driver' => 'visa_qnb_installment',
            'class' => \App\Classes\Payment\Drivers\MasterCardMethod::class,
            'isActive' => true,
            'isOnline' => true,
            'isInstallment' => true,
            'type' => \App\Models\Payment\PaymentMethod::TYPE_INSTALLMENT,
            'name_en' => 'Credit / Debit card QNB Installment',
            'name_ar' => 'بطاقة الائتمان \ خصم مباشر',
            "icon" => 'images/payment_methods/visa_qnb_installment.png',
            'credentials' => [
                'base_url' => envFromDB('QNB_BASE_URL'),
                'checkout_js' => envFromDB('QNB_CHECKOUT_JS'),
                'gateway_url' => envFromDB('QNB_GATEWAY_URL')
            ],
        ],
        16 => [
            'driver' => 'visa_qnb_simplify',
            'class' => \App\Classes\Payment\Drivers\QnbSimplifyMethod::class,
            'isActive' => true,
            'isOnline' => true,
            'isInstallment' => false,
            'type' => \App\Models\Payment\PaymentMethod::TYPE_CARD,
            'name_en' => 'Credit / Debit card QNB Simplify',
            'name_ar' => 'بطاقة الائتمان \ خصم مباشر',
            "icon" => 'images/payment_methods/visa_qnb_simplify.png',
            'credentials' => [
                "public_key" => envFromDB('QNB_SIMPLIFY_API_PUBLIC_KEY'),
                "private_key" => envFromDB('QNB_SIMPLIFY_API_PRIVATE_KEY'),
            ],
        ],
        /**
         * Visa Paytabs
         */
        17 => [
            'driver' => 'visa_paytabs',
            'class' => \App\Classes\Payment\Drivers\PaytabsMethod::class, 
            'isActive' => true,
            'isOnline' => true,
            'isInstallment' => false,
            'type' => \App\Models\Payment\PaymentMethod::TYPE_CARD,
            'name_en' => 'Visa Paytabs',
            'name_ar' => 'بطاقة الائتمان \ خصم مباشر',
            "icon" => 'images/payment_methods/visa_paytabs.png',
            'credentials' => [
                'baseUrl' => 'https://secure-egypt.paytabs.com/',
                'callback_url' => envFromDB('PAYTABS_CALLBACK_URL'),//'/api/customer/pay/paytabs/callback',
                'server_key' => envFromDB('PAYTABS_SERVER_KEY'),
                'profile_id' => envFromDB('PAYTABS_PROFILE_ID')
            ],
        ],
        /**
         * Visa On Delivery
         */
        18 => [
            'driver' => 'cod_visa',
            'class' => \App\Classes\Payment\Drivers\CodMethod::class,
            'isActive' => true,
            'isOnline' => false,
            'isInstallment' => false,
            'type' => \App\Models\Payment\PaymentMethod::TYPE_CARD,
            'name_en' => 'Visa On Delivery',
            'name_ar' => 'الدفع عند الاستلام عن طريق الفيزا',
            'icon' => 'images/payment_methods/cash_payment.png',
            'credentials' => [],
        ],
    ],

];
