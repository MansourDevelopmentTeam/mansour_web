<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Payment\Promo;
use Faker\Generator as Faker;

$factory->define(Promo::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'type' => 1,
        'expiration_date' => now()->addDay(),
    ];
});
