<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'firstname'      => $this->faker->firstName,
            'lastname'       => $this->faker->lastName,
            'title'          => $this->faker->jobTitle,
            'email'          => $this->faker->unique()->safeEmail,
            'password'       => Hash::make('123123'),
            'remember_token' => Str::random(10),
            'is_active'      => $this->faker->numberBetween(0, 1),
            'created_at'     => $this->faker->dateTimeBetween($startDate = '-2 years', $endDate = 'now', $timezone = null),
            'updated_at'     => null,
        ];
    }
}
