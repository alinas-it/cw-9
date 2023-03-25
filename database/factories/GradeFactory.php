<?php

namespace Database\Factories;

use App\Models\News;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Grade>
 */
class GradeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'news_id' => News::inRandomOrder()->first()->id,
            'user_id' =>  User::inRandomOrder()->first()->id,
            'quality' => fake()->randomElement([-1, 1]),
            'relevance' => fake()->randomElement([-1, 1]),
            'satisfaction' => fake()->randomElement([-1, 1])
        ];
    }
}
