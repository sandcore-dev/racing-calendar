<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Season::class, function (Faker $faker) {
    return [
        'access_token_id'   => factory(App\AccessToken::class)->create()->id,
        'year'              => $faker->unique()->year(),
        'header_image'      => null,
        'footer_image'      => null,
    ];
});
