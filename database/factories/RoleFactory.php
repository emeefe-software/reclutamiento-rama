<?php

use App\Role;
use Faker\Generator as Faker;

$factory->define(Role::class, function (Faker $faker) {
    return [
        'name' =>$faker->word,
        'display_name'=> $faker->word,
        'description' => $faker->sentence(3),
    ];
});
