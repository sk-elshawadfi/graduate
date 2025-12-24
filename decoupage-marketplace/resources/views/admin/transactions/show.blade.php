@extends('admin.layouts.app')

@section('page-title', 'Transaction ' . ($transaction->reference ?? $transaction->id))

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.transactions.index') }}">Transactions</a></li>
    <li class="breadcrumb-item active">{{ $transaction->reference ?? $transaction->id }}</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Transaction details</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Wallet owner:</strong> {{ $transaction->wallet->user->name }}</p>
                    <p><strong>Type:</strong> {{ ucfirst($transaction->type) }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($transaction->status) }}</p>
                    <p><strong>Amount:</strong> EGP {{ number_format($transaction->amount, 2) }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Balance before:</strong> EGP {{ number_format($transaction->balance_before, 2) }}</p>
                    <p><strong>Balance after:</strong> EGP {{ number_format($transaction->balance_after, 2) }}</p>
                    <p><strong>Reference:</strong> {{ $transaction->reference ?? 'N/A' }}</p>
                    <p><strong>Date:</strong> {{ $transaction->created_at->format('d M Y H:i') }}</p>
                </div>
            </div>
            @if($transaction->description)
                <div class="alert alert-info mt-3">
                    {{ $transaction->description }}
                </div>
            @endif
            @if($transaction->subject_type)
                <p class="mb-0"><strong>Subject:</strong> {{ $transaction->subject_type }} #{{ $transaction->subject_id }}</p>
            @endif
        </div>
    </div>
@endsection
