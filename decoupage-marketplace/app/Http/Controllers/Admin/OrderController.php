<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrderStatusRequest;
use App\Models\Order;
use App\Models\Transaction;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(private ActivityLogger $logger)
    {
        $this->authorizeResource(Order::class, 'order');
    }

    public function index(Request $request): View
    {
        $orders = Order::query()
            ->with('user')
            ->when($request->string('search')->toString(), function ($query, $search) {
                $query->where(function ($builder) use ($search) {
                    $builder
                        ->where('order_number', 'like', "%{$search}%")
                        ->orWhereHas('user', fn ($q) => $q->where('name', 'like', "%{$search}%"));
                });
            })
            ->when($request->string('status')->toString(), fn ($q, $status) => $q->where('status', $status))
            ->when($request->string('payment_status')->toString(), fn ($q, $status) => $q->where('payment_status', $status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load(['items.product', 'user', 'transactions']);

        return view('admin.orders.show', compact('order'));
    }

    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();

        $this->logger->log('order.deleted', [
            'description' => 'Order deleted by admin',
            'subject_type' => Order::class,
            'subject_id' => $order->id,
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'Order deleted.');
    }

    public function editStatus(Order $order): View
    {
        $this->authorize('update', $order);

        return view('admin.orders.status', compact('order'));
    }

    public function updateStatus(OrderStatusRequest $request, Order $order): RedirectResponse
    {
        $this->authorize('update', $order);

        $data = $request->validated();
        $originalPaymentStatus = $order->payment_status;

        $order->update($data);

        if ($originalPaymentStatus !== 'paid' && $data['payment_status'] === 'paid') {
            $this->logger->log('order.paid', [
                'description' => 'Payment status updated to paid by admin',
                'subject_type' => Order::class,
                'subject_id' => $order->id,
            ]);
        } else {
            $this->logger->log('order.status.updated', [
                'description' => 'Order status updated by admin',
                'subject_type' => Order::class,
                'subject_id' => $order->id,
                'properties' => ['status' => $order->status],
            ]);
        }

        if ($order->payment_status === 'paid' && $order->payment_method === 'wallet') {
            $wallet = $order->user->wallet;

            if ($wallet) {
                $transactionExists = $order->transactions()
                    ->where('type', 'debit')
                    ->exists();

                if (! $transactionExists) {
                    $before = $wallet->balance;
                    $after = max(0, $before - $order->total);

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
                        'description' => 'Wallet payment captured by admin',
                    ]);
                }
            }
        }

        return redirect()->route('admin.orders.show', $order)->with('success', 'Order status updated.');
    }
}
