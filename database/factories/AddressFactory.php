<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Users\Address;
use Faker\Generator as Faker;
use App\Models\Locations\Area;
use App\Models\Locations\City;

$factory->define(City::class, function (Faker $faker) {
    return [
        'name' => $faker->city,
        'delivery_fees' => $faker->randomDigit,
    ];
});

$factory->define(Area::class, function (Faker $faker) {
    return [
        'name' => $faker->streetAddress,
        'active' => 1,
        'delivery_fees' => $faker->randomDigit,
        "city_id" => factory(City::class)->create(),
    ];
});


$factory->define(Address::class, function (Faker $faker) {
    return [
        "user_id" => 2,
        "city_id" => factory(City::class)->create(),
        "area_id" => factory(Area::class)->create(),
    ];
});
