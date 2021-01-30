<?php

namespace Database\Factories;

use App\Models\Championship;
use App\Models\Season;
use Illuminate\Database\Eloquent\Factories\Factory;

class SeasonFactory extends Factory
{
    protected $model = Season::class;

    public function definition(): array
    {
        return [
            'championship_id' => Championship::factory(),
            'year' => $this->faker->unique()->year(),
            'header_image' => null,
            'footer_image' => null,
            'access_token' => $this->faker->optional()->randomAscii,
        ];
    }
}
