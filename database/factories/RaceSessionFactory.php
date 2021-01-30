<?php

namespace Database\Factories;

use App\Models\Race;
use App\Models\RaceSession;
use DateInterval;
use DateTimeImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;

class RaceSessionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RaceSession::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'race_id' => Race::factory(),
            'start_time' => $this->faker->dateTime,
            'end_time' => function (array $attributes) {
                return DateTimeImmutable::createFromMutable($attributes['start_time'])->add(new DateInterval('PT2H'));
            },
            'name' => $this->faker->randomElement(['Practice', 'Qualifying', 'Race']),
        ];
    }
}
