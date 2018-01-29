<?php

use Faker\Generator as Faker;

$factory->define(App\Country::class, function (Faker $faker) {
    return [
        'code'	=> $faker->unique()->countryCode,
        'name'	=> $faker->unique()->country,
    ];
});
