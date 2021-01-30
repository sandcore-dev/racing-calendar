<?php

namespace Database\Factories;

use App\Models\Template;
use App\Models\TemplateSession;
use DateInterval;
use Illuminate\Database\Eloquent\Factories\Factory;

class TemplateSessionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TemplateSession::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'template_id' => Template::factory(),
            'days' => $this->faker->numberBetween(1, 3),
            'start_time' => $this->faker->time(),
            'end_time' => function (array $attributes) {
                return $attributes['end_time']->add(new DateInterval('P1H'));
            },
            'name' => $this->faker->words(3, true),
        ];
    }
}
