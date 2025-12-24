<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class CartService
{
    public const SESSION_KEY = 'cart.items';

    public function items(): Collection
    {
        return collect(Session::get(self::SESSION_KEY, []));
    }

    public function add(Product $product, int $quantity = 1): array
    {
        $items = $this->items();

        if ($product->stock <= 0) {
            return $items->toArray();
        }
        $existing = $items->firstWhere('id', $product->id);

        if ($existing) {
            $items = $items->map(function (array $item) use ($product, $quantity) {
                if ($item['id'] === $product->id) {
                    $item['quantity'] = min($item['quantity'] + $quantity, $product->stock);
                }

                return $item;
            });
        } else {
            $items->push([
                'id' => $product->id,
                'title' => $product->title,
                'price' => $product->price,
                'quantity' => min($quantity, $product->stock),
                'thumbnail' => $product->primary_image,
                'slug' => $product->slug,
            ]);
        }

        $this->persist($items);

        return $items->toArray();
    }

    public function updateQuantity(int $productId, int $quantity): array
    {
        $product = Product::find($productId);

        $items = $this->items()->map(function (array $item) use ($productId, $quantity, $product) {
            if ($item['id'] === $productId) {
                $max = $product?->stock ?? $quantity;
                $item['quantity'] = max(1, min($quantity, $max));
            }

            return $item;
        });

        $this->persist($items);

        return $items->toArray();
    }

    public function remove(int $productId): array
    {
        $items = $this->items()->reject(fn (array $item) => $item['id'] === $productId)->values();
        $this->persist($items);

        return $items->toArray();
    }

    public function clear(): void
    {
        Session::forget(self::SESSION_KEY);
    }

    public function totals(): array
    {
        $items = $this->items();
        $subtotal = $items->reduce(fn ($carry, $item) => $carry + ($item['price'] * $item['quantity']), 0);
        $shipping = $items->isEmpty() ? 0 : 60;

        return [
            'subtotal' => round($subtotal, 2),
            'shipping' => $shipping,
            'total' => round($subtotal + $shipping, 2),
        ];
    }

    protected function persist(Collection $items): void
    {
        Session::put(self::SESSION_KEY, $items->toArray());
    }
}
