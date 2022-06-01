<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Users\User;
use App\Models\Orders\Order;
use Faker\Generator as Faker;
use App\Models\Payment\Invoice;
use App\Models\Products\Product;
use App\Models\Orders\OrderProduct;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'payment_method' => 1,
        'user_id' => factory(User::class)->create()->id,
    ];
});

$factory->define(OrderProduct::class, function (Faker $faker) {
    return [
        'product_id' => factory(Product::class)->create()->id,
        'order_id' => factory(Order::class)->create()->id,
        'amount' => $faker->randomDigitNot(0)
    ];
});

$factory->define(Invoice::class, function (Faker $faker) {
    return [
        'order_id' => factory(Order::class)->create()->id
    ];
});
