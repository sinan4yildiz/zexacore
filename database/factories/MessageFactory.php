<?php

namespace Database\Factories;

use App\Models\Message;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Message::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'subject'    => rtrim($this->faker->sentence($nbWords = rand(3, 7)), '.'),
            'text'       => $this->faker->paragraph($nbSentences = rand(3, 20)),
            'name'       => $this->faker->name,
            'email'      => $this->faker->unique()->safeEmail,
            'telephone'  => $this->faker->tollFreePhoneNumber,
            'unread'     => $this->faker->numberBetween(0, 1),
            'created_at' => $this->faker->dateTimeBetween($startDate = '-6 months', $endDate = 'now', $timezone = null),
            'updated_at' => null,
        ];
    }
}
