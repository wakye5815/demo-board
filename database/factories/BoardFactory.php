<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;
use League\Flysystem\Exception;

$factory->define(App\Board::class, function (Faker $faker, array $attributes) {    
    return [
        'name' => $faker->randomLetter,
        'owner_user_id' => $attributes['owner_user_id']
    ];
});
