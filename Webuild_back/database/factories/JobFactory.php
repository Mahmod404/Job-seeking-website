<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->jobTitle(),
            'description' => "Job Description Explain work requirements",
            'category' => "Constriction",
            'salary' => fake()->numberBetween(1000, 10000),
            'location' => fake()->address(),
            'user_id' => 1,
        ];
    }
}