<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fullname' => fake()->name(),
            'birthdate' => fake()->dateTimeBetween('-40 years', '-20 years')->format('Y-m-d'),
            'sex' => fake()->numberBetween(0, 1),
            'phone' => '0' . fake()->numerify('#########'),
        ];
    }
}
