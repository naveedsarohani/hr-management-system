<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->title(),
            'description' => fake()->paragraph(),
        ];
    }
}
