<?php

use Faker\Generator as Faker;

$factory->define(App\Circuit::class, function (Faker $faker) {
	$city		= $faker->unique()->city;
	$country	= App\Country::count() ? App\Country::inRandomOrder()->first() : factory(App\Country::class)->create();
	
    return [
        'name'			=> $city . ' Raceway',
        'city'			=> $city,
        'area'			=> null,
        'country_id'	=> $country->id,
    ];
});
