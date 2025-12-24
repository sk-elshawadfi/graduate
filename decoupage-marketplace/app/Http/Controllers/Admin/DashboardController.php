<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\RecycleRequest;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $stats = [
            'users' => User::count(),
            'orders' => Order::count(),
            'revenue' => Order::paid()->sum('total'),
            'recycle_requests' => RecycleRequest::count(),
            'wallet_balance' => Wallet::sum('balance'),
        ];

        $recentOrders = Order::with('user')->latest()->take(5)->get();
        $recentRecycle = RecycleRequest::with('user')->latest()->take(5)->get();
        $topProducts = Product::withCount('orderItems')->orderByDesc('order_items_count')->take(5)->get();
        $latestTransactions = Transaction::with('wallet.user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'recentRecycle', 'topProducts', 'latestTransactions'));
    }
}
