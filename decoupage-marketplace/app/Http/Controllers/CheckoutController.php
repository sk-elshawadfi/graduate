<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Services\ActivityLogger;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(
        private CartService $cart,
        private ActivityLogger $logger
    ) {
        $this->middleware(['auth', 'active.user']);
    }

    public function index(): RedirectResponse|View
    {
        $items = $this->cart->items();

        if ($items->isEmpty()) {
            return redirect()->route('products.index')->with('warning', 'Add at least one product to checkout.');
        }

        return view('pages.checkout.index', [
            'items' => $items,
            'totals' => $this->cart->totals(),
        ]);
    }

    public function store(CheckoutRequest $request): RedirectResponse
    {
        $items = $this->cart->items();

        if ($items->isEmpty()) {
            return redirect()->route('products.index')->withErrors(['cart' => 'Your cart is empty.']);
        }

        $totals = $this->cart->totals();
        $user = $request->user();

        $order = Order::create(array_merge($request->validated(), [
            'user_id' => $user->id,
            'status' => 'processing',
            'subtotal' => $totals['subtotal'],
            'shipping_cost' => $totals['shipping'],
            'total' => $totals['total'],
            'payment_status' => 'pending',
            'placed_at' => now(),
        ]));

        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'title' => $item['title'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'total' => $item['price'] * $item['quantity'],
                'meta' => [
                    'thumbnail' => $item['thumbnail'],
                ],
            ]);
        }

        if ($order->payment_method === 'wallet') {
            $wallet = $user->wallet;

            if (! $wallet || $wallet->balance < $order->total) {
                $order->update(['status' => 'pending']);

                return back()
                    ->withErrors(['payment_method' => 'Insufficient wallet balance. Choose Cash on Delivery or top up your wallet.'])
                    ->withInput();
            }

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
                'reference' => 'CHK-' . $order->id,
                'description' => 'Wallet payment for checkout',
            ]);

            $order->update(['payment_status' => 'paid']);
        }

        $this->logger->log('order.placed', [
            'description' => 'Checkout completed',
            'subject_type' => Order::class,
            'subject_id' => $order->id,
            'properties' => [
                'total' => $order->total,
                'items' => $items->count(),
                'payment_method' => $order->payment_method,
            ],
        ]);

        $this->cart->clear();

        return redirect()->route('checkout.confirmation', $order)->with('success', 'Order placed successfully!');
    }

    public function confirmation(Order $order): View
    {
        $this->authorize('view', $order);

        $order->load('items');

        return view('pages.checkout.confirmation', compact('order'));
    }
}
