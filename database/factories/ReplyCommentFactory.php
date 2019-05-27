<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;
use League\Flysystem\Exception;

$factory->define(App\Models\ReplyComment::class, function (Faker $faker, array $attributes) {    
    return [
        'to_comment_id' => $attributes['to_comment_id'],
        'from_comment_id' => $attributes['from_comment_id']
    ];
});
