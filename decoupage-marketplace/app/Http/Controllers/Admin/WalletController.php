<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\WalletRequest;
use App\Models\User;
use App\Models\Wallet;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WalletController extends Controller
{
    public function __construct(private ActivityLogger $logger)
    {
        $this->authorizeResource(Wallet::class, 'wallet');
    }

    public function index(Request $request): View
    {
        $wallets = Wallet::query()
            ->with('user')
            ->when($request->string('search')->toString(), function ($query, $search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($request->string('status')->toString(), fn ($q, $status) => $q->where('status', $status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.wallets.index', compact('wallets'));
    }

    public function create(): View
    {
        return view('admin.wallets.create', [
            'wallet' => new Wallet(),
            'users' => $this->userOptions(),
        ]);
    }

    public function store(WalletRequest $request): RedirectResponse
    {
        $wallet = Wallet::create($request->validated());

        $this->logger->log('wallet.created', [
            'description' => 'Wallet created',
            'subject_type' => Wallet::class,
            'subject_id' => $wallet->id,
        ]);

        return redirect()->route('admin.wallets.index')->with('success', 'Wallet created.');
    }

    public function show(Wallet $wallet): View
    {
        $wallet->load('user', 'transactions.subject');

        return view('admin.wallets.show', compact('wallet'));
    }

    public function edit(Wallet $wallet): View
    {
        return view('admin.wallets.edit', [
            'wallet' => $wallet,
            'users' => $this->userOptions($wallet),
        ]);
    }

    public function update(WalletRequest $request, Wallet $wallet): RedirectResponse
    {
        $wallet->update($request->validated());

        $this->logger->log('wallet.updated', [
            'description' => 'Wallet updated',
            'subject_type' => Wallet::class,
            'subject_id' => $wallet->id,
        ]);

        return redirect()->route('admin.wallets.show', $wallet)->with('success', 'Wallet updated.');
    }

    public function destroy(Wallet $wallet): RedirectResponse
    {
        $wallet->delete();

        $this->logger->log('wallet.deleted', [
            'description' => 'Wallet deleted',
            'subject_type' => Wallet::class,
            'subject_id' => $wallet->id,
        ]);

        return redirect()->route('admin.wallets.index')->with('success', 'Wallet removed.');
    }

    protected function userOptions(?Wallet $wallet = null): array
    {
        return User::query()
            ->where(function ($query) use ($wallet) {
                $query->whereDoesntHave('wallet');
                if ($wallet) {
                    $query->orWhere('id', $wallet->user_id);
                }
            })
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray();
    }
}
