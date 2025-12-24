<?php

namespace Database\Factories;

use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $before = $this->faker->randomFloat(2, 100, 2000);
        $amount = $this->faker->randomFloat(2, 50, 600);
        $type = $this->faker->randomElement(['credit', 'debit']);
        $after = $type === 'credit' ? $before + $amount : $before - $amount;

        return [
            'wallet_id' => Wallet::factory(),
            'subject_type' => null,
            'subject_id' => null,
            'type' => $type,
            'status' => 'completed',
            'amount' => $amount,
            'balance_before' => $before,
            'balance_after' => max($after, 0),
            'reference' => 'TX-' . strtoupper($this->faker->bothify('??####')),
            'description' => $this->faker->sentence(),
        ];
    }
}
