<?php

use Faker\Generator as Faker;

$factory->define(App\Season::class, function (Faker $faker) {
    return [
        'year'			=> $faker->unique()->year(),
        'access_token'	=> str_random(10),
        'header_url'	=> $faker->imageUrl(640, 280),
        'footer_url'	=> $faker->imageUrl(640, 280),
    ];
});
