<?php

namespace Database\Factories\People;

use App\Models\People\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Admin::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'username'       => $this->faker->userName,
            'firstname'      => $this->faker->firstName,
            'lastname'       => $this->faker->lastName,
            'email'          => $this->faker->unique()->safeEmail,
            'password'       => Hash::make('123123'),
            'remember_token' => Str::random(10),
            'api_token'      => Str::random(32),
        ];
    }
}
