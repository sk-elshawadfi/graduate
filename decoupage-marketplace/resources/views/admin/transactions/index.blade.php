@extends('admin.layouts.app')

@section('page-title', 'Transactions')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Transactions</li>
@endsection

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Reference or user" value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Type</label>
                    <select name="type" class="form-control">
                        <option value="">All</option>
                        <option value="credit" @selected(request('type') === 'credit')>Credit</option>
                        <option value="debit" @selected(request('type') === 'debit')>Debit</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="">All</option>
                        @foreach(['pending','completed','failed'] as $status)
                            <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Transactions</h3>
            <div class="card-tools">
                <a href="{{ route('admin.transactions.create') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus me-1"></i> Record</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                <tr>
                    <th>Reference</th>
                    <th>User</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->reference ?? 'N/A' }}</td>
                        <td>{{ $transaction->wallet->user->name }}</td>
                        <td>{{ ucfirst($transaction->type) }}</td>
                        <td class="{{ $transaction->type === 'credit' ? 'text-success' : 'text-danger' }}">
                            {{ $transaction->type === 'credit' ? '+' : '-' }} EGP {{ number_format($transaction->amount, 2) }}
                        </td>
                        <td>{{ ucfirst($transaction->status) }}</td>
                        <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.transactions.show', $transaction) }}" class="btn btn-sm btn-outline-secondary">View</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted p-4">No transactions found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $transactions->links() }}
        </div>
    </div>
@endsection
