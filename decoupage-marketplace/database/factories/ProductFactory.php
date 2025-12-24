<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = ucfirst($this->faker->words(3, true));
        $images = collect(range(1, rand(2, 4)))->map(fn () => $this->faker->imageUrl(800, 800, 'fashion', true))->all();

        return [
            'category_id' => Category::factory(),
            'title' => $title,
            'slug' => Str::slug($title . '-' . $this->faker->unique()->numberBetween(10, 999)),
            'sku' => strtoupper(Str::random(10)),
            'thumbnail' => Arr::random($images),
            'short_description' => $this->faker->sentence(10),
            'description' => $this->faker->paragraph(4),
            'price' => $this->faker->randomFloat(2, 100, 2000),
            'stock' => $this->faker->numberBetween(5, 80),
            'images' => $images,
            'is_featured' => $this->faker->boolean(25),
            'status' => 'active',
        ];
    }
}
