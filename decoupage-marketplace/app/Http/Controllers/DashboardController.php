<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $user = auth()->user();
        $wallet = $user->wallet;
        $transactions = $wallet ? $wallet->transactions()->latest()->take(5)->get() : collect();

        return view('pages.dashboard.index', [
            'user' => $user,
            'wallet' => $wallet,
            'orders' => $user->orders()->latest()->with('items')->paginate(5),
            'recycleRequests' => $user->recycleRequests()->latest()->take(5)->get(),
            'transactions' => $transactions,
        ]);
    }
}
