<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subtotal = $this->faker->randomFloat(2, 300, 4000);
        $shipping = $this->faker->randomFloat(2, 20, 80);

        return [
            'user_id' => User::factory(),
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'status' => $this->faker->randomElement(['pending', 'processing', 'completed']),
            'payment_status' => $this->faker->randomElement(['pending', 'paid']),
            'payment_method' => $this->faker->randomElement(['cod', 'wallet']),
            'subtotal' => $subtotal,
            'shipping_cost' => $shipping,
            'total' => $subtotal + $shipping,
            'shipping_name' => $this->faker->name(),
            'shipping_email' => $this->faker->safeEmail(),
            'shipping_phone' => $this->faker->phoneNumber(),
            'shipping_address' => $this->faker->streetAddress(),
            'shipping_city' => $this->faker->city(),
            'shipping_country' => $this->faker->country(),
            'shipping_postal_code' => $this->faker->postcode(),
            'notes' => $this->faker->sentence(),
            'placed_at' => now()->subDays(rand(1, 60)),
        ];
    }
}
