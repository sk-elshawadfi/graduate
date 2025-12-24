<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->words(2, true);

        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name . '-' . $this->faker->unique()->word()),
            'description' => $this->faker->sentence(12),
            'image_url' => $this->faker->imageUrl(640, 480, 'abstract', true),
            'is_featured' => $this->faker->boolean(30),
            'display_order' => $this->faker->numberBetween(1, 50),
        ];
    }
}
