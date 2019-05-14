<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;
use League\Flysystem\Exception;

$factory->define(App\Comment::class, function (Faker $faker, array $attributes) {    
    return [
        'content' => $faker->randomLetter,
        'board_id' => $attributes['board_id'],
        'owner_user_id' => $attributes['owner_user_id']
    ];
});
