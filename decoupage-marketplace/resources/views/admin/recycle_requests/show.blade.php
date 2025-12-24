@extends('admin.layouts.app')

@section('page-title', 'Recycle Request #' . $recycleRequest->id)

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.recycle-requests.index') }}">Recycle Requests</a></li>
    <li class="breadcrumb-item active">Request #{{ $recycleRequest->id }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Customer</h3>
                    <a href="{{ route('admin.users.show', $recycleRequest->user) }}" class="btn btn-link btn-sm">View profile</a>
                </div>
                <div class="card-body">
                    <p class="mb-1">{{ $recycleRequest->user->name }}</p>
                    <p class="mb-1 text-muted">{{ $recycleRequest->user->email }}</p>
                    <p class="mb-0">{{ $recycleRequest->user->phone }}</p>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Status</h3>
                    <a href="{{ route('admin.recycle-requests.edit', $recycleRequest) }}" class="btn btn-sm btn-outline-primary float-end">Edit</a>
                </div>
                <div class="card-body">
                    <p class="mb-1">Type: {{ ucfirst($recycleRequest->request_type) }}</p>
                    <p class="mb-1">Status: <span class="badge bg-info">{{ ucfirst($recycleRequest->status) }}</span></p>
                    <p class="mb-1">Admin price: {{ $recycleRequest->admin_price ? 'EGP ' . number_format($recycleRequest->admin_price, 2) : 'N/A' }}</p>
                    <p class="mb-0">Handled by: {{ $recycleRequest->handler?->name ?? 'Pending assignment' }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Details</h3>
                </div>
                <div class="card-body">
                    @if($recycleRequest->image_path)
                        <img src="{{ asset('storage/' . $recycleRequest->image_path) }}" class="img-fluid rounded mb-3" alt="Recycle image">
                    @endif
                    <p>{{ $recycleRequest->description }}</p>
                    @if($recycleRequest->feedback)
                        <div class="alert alert-info mt-3">
                            <strong>Feedback:</strong> {{ $recycleRequest->feedback }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Wallet Transactions</h3>
                </div>
                <div class="card-body">
                    @forelse($recycleRequest->transactions as $transaction)
                        <div class="d-flex justify-content-between mb-2">
                            <div>
                                <strong>{{ ucfirst($transaction->type) }}</strong>
                                <p class="mb-0 text-muted">{{ $transaction->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="{{ $transaction->type === 'credit' ? 'text-success' : 'text-danger' }}">
                                {{ $transaction->type === 'credit' ? '+' : '-' }} EGP {{ number_format($transaction->amount, 2) }}
                            </div>
                        </div>
                        @if(! $loop->last)
                            <hr>
                        @endif
                    @empty
                        <p class="text-muted mb-0">No wallet activity yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
