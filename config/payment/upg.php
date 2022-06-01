<?php

return [
    "merchant_id" => envFromDB('UPG_MERCHANT_ID'),
    "terminal_id" => envFromDB('UPG_TERMINAL_ID'),
    "secure_key" => envFromDB('UPG_SECURE_KEY'),
    "secure_key2" => env('UPG_SECURE_KEY2')
];
