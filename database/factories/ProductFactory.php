<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Products\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text,
        'stock' => $faker->randomDigitNot(0),
        'image' => $faker->imageUrl(),
        'parent_id' => null
    ];
});
