<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'           => rtrim($this->faker->realText(rand(30, 80)), '.'),
            'language_code'   => $this->faker->randomElement($array = Language::all()->pluck('code')),
            'content_type_id' => $this->faker->numberBetween(1, 4),
            'user_id'         => $this->faker->numberBetween(1, 4),
            'views'           => $this->faker->numberBetween(10, 4500),
            'sort_order'      => $this->faker->numberBetween(1, 30),
            'created_at'      => $this->faker->dateTimeBetween($startDate = '-2 years', $endDate = 'now', $timezone = null),
            'is_active'       => $this->faker->numberBetween(0, 1),
        ];
    }
}
