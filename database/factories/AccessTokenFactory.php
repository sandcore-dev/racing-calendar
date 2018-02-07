<?php

use Faker\Generator as Faker;

$factory->define(App\AccessToken::class, function (Faker $faker) {
    return [
        'name' => str_random(10),
    ];
});
