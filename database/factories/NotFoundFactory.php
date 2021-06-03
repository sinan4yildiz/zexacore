<?php

namespace Database\Factories;

use App\Models\NotFound;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotFoundFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = NotFound::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uri'        => $this->faker->slug,
            'count'      => $this->faker->numberBetween(1, 150),
            'created_at' => $this->faker->dateTimeBetween($startDate = '-6 months', $endDate = 'now', $timezone = null),
            'updated_at' => $this->faker->dateTimeBetween($startDate = '-6 months', $endDate = 'now', $timezone = null),
        ];
    }
}
