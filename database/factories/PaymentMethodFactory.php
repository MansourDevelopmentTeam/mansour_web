<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\Payment\PaymentMethod;

$factory->define(PaymentMethod::class, function (Faker $faker) {
    return [
        'name' => $faker->creditCardType,
        'name_ar' => $faker->creditCardType,
        'active' => 1,
        'order' => 1,
        'is_online' => $faker->boolean
    ];
});
