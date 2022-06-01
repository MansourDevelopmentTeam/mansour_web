<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Products\ProductTag;
use App\Models\Products\Tag;
use Faker\Generator as Faker;

$factory->define(Tag::class, function (Faker $faker) {
    return [
        'name_en' => $faker->name,
        'description_en' => $faker->text,
    ];
});

$factory->define(ProductTag::class, function (Faker $faker) {
    return [
        'tag_id' => factory(Tag::class)->create()->id,
        'product_id' => $faker->randomDigit
    ];
});
