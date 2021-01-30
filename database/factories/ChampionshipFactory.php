<?php

namespace Database\Factories;

use App\Models\Championship;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChampionshipFactory extends Factory
{
    protected $model = Championship::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->company . ' Championship',
            'domain' => $this->faker->unique()->domainWord . '.' . parse_url(config('app.url'), PHP_URL_HOST),
        ];
    }
}
