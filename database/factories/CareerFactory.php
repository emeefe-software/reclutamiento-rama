<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Career;
use Faker\Generator as Faker;

$factory->define(Career::class, function (Faker $faker) {
    return [
        'name' => $faker->jobTitle,
        'withCV' => true,
        'withPortfolio' => true
    ];
});
