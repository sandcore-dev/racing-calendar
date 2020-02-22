<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Illuminate\Support\Str;

$factory->define(App\AccessToken::class, function () {
    return [
        'name' => Str::random(10),
    ];
});
