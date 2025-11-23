<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TargetDemographic>
 */
class TargetDemographicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'description' => fake()->text(),
            'amount' => fake()->randomFloat(2, 0, 1),
            'ethics' => fake()->words(3, true)
        ];
    }
}
