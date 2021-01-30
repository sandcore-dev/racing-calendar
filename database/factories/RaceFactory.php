<?php

namespace Database\Factories;

use App\Models\Circuit;
use App\Models\Location;
use App\Models\Race;
use App\Models\Season;
use Illuminate\Database\Eloquent\Factories\Factory;

class RaceFactory extends Factory
{
    protected $model = Race::class;

    public function definition(): array
    {
        return [
            'start_time' => $this->faker->time(),
            'name' => $this->faker->unique()->company . ' Grand Prix',
            'season_id' => Season::factory(),
            'circuit_id' => Circuit::factory(),
            'location_id' => Location::factory(),
            'remarks' => $this->faker->optional(75)->sentence,
            'status' => $this->faker->optional(75)->randomElement(['scheduled', 'postponed', 'cancelled']),
        ];
    }
}
