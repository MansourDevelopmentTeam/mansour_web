<?php

return [
    "certificateVerifyPeer" => env('VISA_CERTIFICATE_VERIFY_PEER', false),
    "certificateVerifyHost" => env('VISA_CERTIFICATE_VERIFY_HOST', 0),
    "gatewayUrl" => env('VISA_GATEWAY_URL'),
    "merchantId" => env('VISA_MERCHANT_ID'),
    "apiUsername" => env('VISA_API_USERNAME'),
    "password" => env('VISA_PASSWORD'),
    "site_url" => env('VISA_SITE_URL'),
    "debug" => env('VISA_DEBUG', true),
    "version" => env('VISA_VERSION', "49"),
    "js_file" => env('VISA_JS_FILE'),
];
