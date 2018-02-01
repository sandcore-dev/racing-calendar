<?php

use Faker\Generator as Faker;

$factory->define(App\Season::class, function (Faker $faker) {
    return [
        'year'			=> $faker->unique()->year(),
        'access_token'	=> str_random(10),
        'header_image'	=> null,
        'footer_image'	=> null,
    ];
});
