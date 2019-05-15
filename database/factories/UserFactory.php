<?php

use App\User;
use Illuminate\Support\Str;

$factory->define(User::class, function () {
    return [
        'name' => env('TEST_USER_NAME'),
        'email' => env('TEST_USER_EMAIL'),
        'email_verified_at' => now(),
        'password' => Hash::make(env('TEST_USER_PASSWORD')),
        'remember_token' => Str::random(10),
    ];
}, 'testUser');
