<?php

namespace Database\Factories;

use App\Models\NotFound;
use App\Models\Redirection;
use Illuminate\Database\Eloquent\Factories\Factory;

class RedirectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Redirection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'from'       => NotFound::all()->random(1)->first()->uri,
            'to'         => env('APP_URL') . $this->faker->slug,
            'count'      => $this->faker->numberBetween(1, 150),
            'created_at' => $this->faker->dateTimeBetween($startDate = '-6 months', $endDate = 'now', $timezone = null),
            'updated_at' => $this->faker->dateTimeBetween($startDate = '-6 months', $endDate = 'now', $timezone = null),
        ];
    }
}
