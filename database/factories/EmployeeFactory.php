<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->email(),
            'phone' => fake()->unique()->e164PhoneNumber(),
            'address' => fake()->address(),
            'department' => fake()->company(),
            'position' => fake()->jobTitle(),
            'date_of_joining' => fake()->date(),
        ];
    }
}
