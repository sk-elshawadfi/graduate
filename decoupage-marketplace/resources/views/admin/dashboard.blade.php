@extends('admin.layouts.app')

@section('page-title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-md-2 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ number_format($stats['users']) }}</h3>
                    <p>Total Users</p>
                </div>
                <div class="icon"><i class="fas fa-users"></i></div>
                <a href="{{ route('admin.users.index') }}" class="small-box-footer">Manage Users <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ number_format($stats['orders']) }}</h3>
                    <p>Orders</p>
                </div>
                <div class="icon"><i class="fas fa-bag-shopping"></i></div>
                <a href="{{ route('admin.orders.index') }}" class="small-box-footer">View Orders <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>EGP {{ number_format($stats['revenue'], 2) }}</h3>
                    <p>Paid Revenue</p>
                </div>
                <div class="icon"><i class="fas fa-coins"></i></div>
                <a href="{{ route('admin.orders.index') }}" class="small-box-footer">Order Reports <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ number_format($stats['recycle_requests']) }}</h3>
                    <p>Recycle Requests</p>
                </div>
                <div class="icon"><i class="fas fa-recycle"></i></div>
                <a href="{{ route('admin.recycle-requests.index') }}" class="small-box-footer">Review Requests <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-md-3 col-12">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>EGP {{ number_format($stats['wallet_balance'], 2) }}</h3>
                    <p>Wallet Balance In System</p>
                </div>
                <div class="icon"><i class="fas fa-wallet"></i></div>
                <a href="{{ route('admin.wallets.index') }}" class="small-box-footer">Manage Wallets <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">Latest Orders</h3>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-primary float-end">View all</a>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($recentOrders as $order)
                            <tr>
                                <td><a href="{{ route('admin.orders.show', $order) }}">{{ $order->order_number }}</a></td>
                                <td>{{ $order->user->name }}</td>
                                <td>EGP {{ number_format($order->total, 2) }}</td>
                                <td><span class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'processing' ? 'info' : 'secondary') }}">{{ ucfirst($order->status) }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted py-4">No orders yet.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">Recycle Queue</h3>
                </div>
                <div class="card-body">
                    @forelse($recentRecycle as $request)
                        <div class="d-flex align-items-start mb-3">
                            <div class="flex-grow-1">
                                <h5 class="mb-1">{{ $request->user->name }} <small class="text-muted">{{ $request->created_at->diffForHumans() }}</small></h5>
                                <p class="mb-1 text-muted">{{ \Illuminate\Support\Str::limit($request->description, 80) }}</p>
                                <span class="badge bg-light text-dark">{{ ucfirst($request->request_type) }}</span>
                                <span class="badge bg-primary">{{ ucfirst($request->status) }}</span>
                            </div>
                            <a href="{{ route('admin.recycle-requests.edit', $request) }}" class="btn btn-sm btn-outline-primary">Review</a>
                        </div>
                        @if(! $loop->last)
                            <hr>
                        @endif
                    @empty
                        <p class="text-muted mb-0">No recycle requests yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Top Performing Products</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Orders</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($topProducts as $product)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.products.show', $product) }}">{{ $product->title }}</a>
                                </td>
                                <td>{{ $product->category?->name }}</td>
                                <td>{{ $product->order_items_count }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted py-3">No products available.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Latest Wallet Transactions</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th>Reference</th>
                            <th>User</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($latestTransactions as $transaction)
                            <tr>
                                <td>{{ $transaction->reference ?? 'N/A' }}</td>
                                <td>{{ $transaction->wallet->user->name }}</td>
                                <td class="{{ $transaction->type === 'credit' ? 'text-success' : 'text-danger' }}">
                                    {{ $transaction->type === 'credit' ? '+' : '-' }} EGP {{ number_format($transaction->amount, 2) }}
                                </td>
                                <td><span class="badge bg-{{ $transaction->status === 'completed' ? 'success' : 'secondary' }}">{{ ucfirst($transaction->status) }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted py-3">No transactions found.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
