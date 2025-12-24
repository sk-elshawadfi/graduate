@extends('admin.layouts.app')

@section('page-title', 'Wallet Details')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.wallets.index') }}">Wallets</a></li>
    <li class="breadcrumb-item active">{{ $wallet->user->name }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-1">{{ $wallet->user->name }}</h4>
                    <p class="text-muted">{{ $wallet->user->email }}</p>
                    <p class="h3">EGP {{ number_format($wallet->balance, 2) }}</p>
                    <p>Status: <span class="badge bg-{{ $wallet->status === 'active' ? 'success' : 'warning' }}">{{ ucfirst($wallet->status) }}</span></p>
                    <a href="{{ route('admin.wallets.edit', $wallet) }}" class="btn btn-outline-primary btn-sm">Edit wallet</a>
                    <a href="{{ route('admin.transactions.create', ['wallet_id' => $wallet->id]) }}" class="btn btn-primary btn-sm">New transaction</a>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Transactions</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th>Reference</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($wallet->transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->reference ?? 'N/A' }}</td>
                                <td>{{ ucfirst($transaction->type) }}</td>
                                <td class="{{ $transaction->type === 'credit' ? 'text-success' : 'text-danger' }}">
                                    {{ $transaction->type === 'credit' ? '+' : '-' }} EGP {{ number_format($transaction->amount, 2) }}
                                </td>
                                <td>{{ ucfirst($transaction->status) }}</td>
                                <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted p-4">No transactions yet.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
