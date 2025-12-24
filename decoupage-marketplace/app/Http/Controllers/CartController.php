<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(private CartService $cart)
    {
    }

    public function index(): View
    {
        return view('pages.cart.index', [
            'items' => $this->cart->items(),
            'totals' => $this->cart->totals(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        $product = Product::findOrFail($data['product_id']);

        if ($product->stock <= 0) {
            return response()->json([
                'message' => 'This product is currently out of stock.',
            ], 422);
        }

        $items = $this->cart->add($product, $data['quantity'] ?? 1);

        return response()->json([
            'items' => $items,
            'totals' => $this->cart->totals(),
            'message' => "{$product->title} added to your bag.",
        ]);
    }

    public function update(Request $request, int $productId): JsonResponse
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $items = $this->cart->updateQuantity($productId, $data['quantity']);

        return response()->json([
            'items' => $items,
            'totals' => $this->cart->totals(),
        ]);
    }

    public function destroy(int $productId): JsonResponse
    {
        $items = $this->cart->remove($productId);

        return response()->json([
            'items' => $items,
            'totals' => $this->cart->totals(),
        ]);
    }
}
