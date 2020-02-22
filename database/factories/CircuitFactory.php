<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Circuit::class, function (Faker $faker) {
    $city       = $faker->unique()->city;
    $country    = App\Country::count() ? App\Country::inRandomOrder()->first() : factory(App\Country::class)->create();
    
    return [
        'name'          => $city . ' Raceway',
        'city'          => $city,
        'area'          => null,
        'country_id'    => $country->id,
    ];
});
