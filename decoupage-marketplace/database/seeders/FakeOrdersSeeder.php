<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class FakeOrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::role('user')->get();
        $products = Product::all();

        if ($users->isEmpty() || $products->isEmpty()) {
            return;
        }

        for ($i = 0; $i < 10; $i++) {
            $user = $users->random();
            $shippingName = $user->name;
            $order = Order::factory()->create([
                'user_id' => $user->id,
                'shipping_name' => $shippingName,
                'shipping_email' => $user->email,
                'shipping_phone' => $user->phone ?? fake()->phoneNumber(),
                'shipping_address' => $user->address ?? fake()->streetAddress(),
                'shipping_city' => $user->city ?? fake()->city(),
                'shipping_country' => $user->country ?? 'Egypt',
            ]);

            $selectedProducts = $products->random(rand(2, 4));

            $subtotal = 0;
            foreach ($selectedProducts as $product) {
                $quantity = rand(1, 3);
                $lineTotal = $product->price * $quantity;
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'title' => $product->title,
                    'price' => $product->price,
                    'quantity' => $quantity,
                    'total' => $lineTotal,
                    'meta' => [
                        'thumbnail' => $product->primary_image,
                    ],
                ]);
                $subtotal += $lineTotal;
            }

            $shipping = rand(30, 80);
            $order->update([
                'subtotal' => $subtotal,
                'shipping_cost' => $shipping,
                'total' => $subtotal + $shipping,
                'placed_at' => now()->subDays(rand(1, 30)),
            ]);

            if ($order->payment_method === 'wallet') {
                $wallet = $user->wallet()->firstOrCreate([], [
                    'balance' => 1000,
                    'currency' => 'EGP',
                ]);

                if ($wallet->balance >= $order->total) {
                    $before = $wallet->balance;
                    $after = $before - $order->total;
                    $wallet->update(['balance' => $after]);

                    Transaction::create([
                        'wallet_id' => $wallet->id,
                        'subject_type' => Order::class,
                        'subject_id' => $order->id,
                        'type' => 'debit',
                        'status' => 'completed',
                        'amount' => $order->total,
                        'balance_before' => $before,
                        'balance_after' => $after,
                        'reference' => 'ORD-' . $order->id,
                        'description' => 'Order payment',
                    ]);

                    $order->update(['payment_status' => 'paid']);
                }
            } elseif ($order->payment_method === 'cod' && rand(0, 1)) {
                $order->update(['payment_status' => 'paid']);
            }

            ActivityLog::create([
                'user_id' => $user->id,
                'action' => 'order.placed',
                'description' => "Order {$order->order_number} created",
                'subject_type' => Order::class,
                'subject_id' => $order->id,
                'properties' => [
                    'total' => $order->total,
                    'items' => $order->items()->count(),
                ],
            ]);
        }
    }
}
