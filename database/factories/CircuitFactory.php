<?php

namespace Database\Factories;

use App\Models\Circuit;
use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class CircuitFactory extends Factory
{
    protected $model = Circuit::class;

    public function definition(): array
    {
        return [
            'name' => function (array $attributes) {
                return $attributes['city'] . 'Raceway';
            },
            'city' => $this->faker->unique()->city,
            'area' => $this->faker->optional(75)->city,
            'country_id' => Country::factory(),
        ];
    }
}
