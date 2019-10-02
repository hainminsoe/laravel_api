<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Articles::class, function (Faker $faker) {
    return [
        // dummy title and body for articles
        'title' => $faker->text(50),
        'body'  => $faker->text(200)
    ];
});
