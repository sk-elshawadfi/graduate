<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RecycleRequest>
 */
class RecycleRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'image_path' => $this->faker->imageUrl(600, 600, 'nature', true),
            'description' => $this->faker->paragraph(),
            'request_type' => $this->faker->randomElement(['recycle', 'sell']),
            'admin_price' => $this->faker->optional()->randomFloat(2, 50, 800),
            'status' => 'pending',
            'feedback' => null,
            'responded_at' => null,
        ];
    }
}
