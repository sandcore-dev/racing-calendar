<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Championship;
use Faker\Generator as Faker;

$factory->define(Championship::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->company . ' Championship',
        'domain' => $faker->unique()->domainName,
    ];
});
