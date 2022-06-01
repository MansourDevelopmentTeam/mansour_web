<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\Locations\Area;
use Faker\Provider\ne_NP\Address;
use App\Models\Locations\District;

$factory->define(District::class, function (Faker $faker) {
    $faker->addProvider(new Address($faker));

    return [
        'name' => $faker->district,
        'name_ar' => $faker->district,
        'active' => 1,
        'deactivation_notes' => $faker->sentence(),
        'delivery_fees' => $faker->randomDigit,
        "area_id" => factory(Area::class)->create(),
    ];
});
