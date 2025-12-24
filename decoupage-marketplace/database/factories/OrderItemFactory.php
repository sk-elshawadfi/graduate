<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quantity = $this->faker->numberBetween(1, 3);
        $price = $this->faker->randomFloat(2, 100, 500);

        return [
            'order_id' => Order::factory(),
            'product_id' => Product::factory(),
            'title' => $this->faker->sentence(3),
            'price' => $price,
            'quantity' => $quantity,
            'total' => $price * $quantity,
            'meta' => ['note' => $this->faker->word()],
        ];
    }
}
