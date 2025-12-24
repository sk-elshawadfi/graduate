<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TransactionRequest;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function __construct(private ActivityLogger $logger)
    {
        $this->authorizeResource(Transaction::class, 'transaction');
    }

    public function index(Request $request): View
    {
        $transactions = Transaction::query()
            ->with('wallet.user')
            ->when($request->string('type')->toString(), fn ($q, $type) => $q->where('type', $type))
            ->when($request->string('status')->toString(), fn ($q, $status) => $q->where('status', $status))
            ->when($request->string('search')->toString(), function ($query, $search) {
                $query->where(function ($builder) use ($search) {
                    $builder->where('reference', 'like', "%{$search}%")
                        ->orWhereHas('wallet.user', fn ($q) => $q->where('name', 'like', "%{$search}%"));
                });
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.transactions.index', compact('transactions'));
    }

    public function create(): View
    {
        return view('admin.transactions.create', [
            'wallets' => $this->walletOptions(),
        ]);
    }

    public function store(TransactionRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $wallet = Wallet::with('user')->findOrFail($data['wallet_id']);
        $before = $wallet->balance;
        $after = $before;

        if ($data['status'] === 'completed') {
            if ($data['type'] === 'credit') {
                $after = $before + $data['amount'];
            } else {
                if ($before < $data['amount']) {
                    return back()->withInput()->with('error', 'Wallet balance is not enough to complete this debit.');
                }
                $after = $before - $data['amount'];
            }

            $wallet->update(['balance' => $after]);
        }

        $subjectType = $data['subject_type'] ?? null;
        $subjectId = $data['subject_id'] ?? null;

        $transaction = Transaction::create(array_merge($data, [
            'balance_before' => $before,
            'balance_after' => $after,
            'subject_type' => $subjectType ?: null,
            'subject_id' => $subjectId ?: null,
        ]));

        $this->logger->log('transaction.created', [
            'description' => 'Manual transaction created',
            'subject_type' => Transaction::class,
            'subject_id' => $transaction->id,
        ]);

        return redirect()->route('admin.transactions.show', $transaction)->with('success', 'Transaction recorded.');
    }

    public function show(Transaction $transaction): View
    {
        $transaction->load('wallet.user');

        return view('admin.transactions.show', compact('transaction'));
    }

    protected function walletOptions(): array
    {
        return Wallet::with('user')
            ->get()
            ->mapWithKeys(function (Wallet $wallet) {
                $label = "{$wallet->user->name} ({$wallet->user->email})";

                return [$wallet->id => $label];
            })
            ->toArray();
    }
}
