<?php

use App\Models\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(User::class, function () {
    return [
        'name' => env('TEST_USER_NAME'),
        'email' => env('TEST_USER_EMAIL'),
        'email_verified_at' => now(),
        'password' => Hash::make(env('TEST_USER_PASSWORD')),
        'remember_token' => Str::random(10),
    ];
}, 'testUser');

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'email_verified_at' => now(),
        'password' => Hash::make(env(Str::random(10))),
        'remember_token' => Str::random(10),
    ];
});
