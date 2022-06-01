<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Users\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'phone' => $faker->e164PhoneNumber,
        'phone_verified' => 1,
        'password' => bcrypt(Str::random(10)),
        'remember_token' => Str::random(10),
    ];
});
