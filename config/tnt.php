<?php

return [
    'driver'    => 'mysql',
    'host'      => env('DB_HOST', 'localhost'),
    'database'  => env('DB_DATABASE', 'market'),
    'username'  => env('DB_USERNAME', 'root'),
    'password'  => env('DB_PASSWORD', 'root'),
    'storage'   => storage_path("app/public"),
    'stemmer'   => \TeamTNT\TNTSearch\Stemmer\PorterStemmer::class//optional
];
