<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Users\User;
use App\Models\Orders\Cart;
use Faker\Generator as Faker;
use App\Models\Orders\CartItem;
use App\Models\Products\Product;



$factory->define(Cart::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class)->create()->id
    ];
});

$factory->define(CartItem::class, function (Faker $faker) {

    return [
        'cart_id' => factory(Cart::class)->create()->id,
        'amount' => $faker->randomDigitNot(0),
        'product_id' => factory(Product::class)->create()->id
    ];
});
