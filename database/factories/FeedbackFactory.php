<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Feedback>
 */
class FeedbackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 100), // Adjust the range as needed
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'votes' => $this->faker->numberBetween(0, 100), // Adjust the range as needed
            'category' => $this->faker->randomElement(['bug', 'feature', 'improvement', 'other']),
        ];
    }
}
