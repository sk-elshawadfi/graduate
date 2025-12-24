@extends('admin.layouts.app')

@section('page-title', 'Order ' . $order->order_number)

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders</a></li>
    <li class="breadcrumb-item active">{{ $order->order_number }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Customer</h3>
                </div>
                <div class="card-body">
                    <p class="fw-semibold mb-1">{{ $order->user->name }}</p>
                    <p class="text-muted mb-0">{{ $order->user->email }}</p>
                    <a href="{{ route('admin.users.show', $order->user) }}" class="btn btn-link px-0">View profile</a>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Shipping</h3>
                </div>
                <div class="card-body">
                    <p class="mb-1">{{ $order->shipping_name }}</p>
                    <p class="mb-1">{{ $order->shipping_phone }}</p>
                    <p class="mb-0 text-muted">
                        {{ $order->shipping_address }}<br>
                        {{ $order->shipping_city }}, {{ $order->shipping_country }} {{ $order->shipping_postal_code }}
                    </p>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Status</h3>
                    <a href="{{ route('admin.orders.status.edit', $order) }}" class="btn btn-sm btn-outline-primary float-end">Update</a>
                </div>
                <div class="card-body">
                    <p class="mb-1">Order status: <span class="badge bg-info">{{ ucfirst($order->status) }}</span></p>
                    <p class="mb-1">Payment status: <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">{{ ucfirst($order->payment_status) }}</span></p>
                    <p class="mb-0">Payment method: {{ strtoupper($order->payment_method) }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Items</h3>
                    <div class="card-tools">
                        <span class="badge bg-secondary">Placed {{ $order->created_at->format('d M Y H:i') }}</span>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>{{ $item->title }}</td>
                                <td>EGP {{ number_format($item->price, 2) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>EGP {{ number_format($item->total, 2) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">Subtotal</th>
                            <th>EGP {{ number_format($order->subtotal, 2) }}</th>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-end">Shipping</th>
                            <th>EGP {{ number_format($order->shipping_cost, 2) }}</th>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-end">Total</th>
                            <th>EGP {{ number_format($order->total, 2) }}</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Transactions</h3>
                </div>
                <div class="card-body">
                    @forelse($order->transactions as $transaction)
                        <div class="d-flex justify-content-between mb-2">
                            <div>
                                <strong>{{ ucfirst($transaction->type) }}</strong>
                                <p class="mb-0 text-muted">{{ $transaction->created_at->format('d M Y H:i') }}</p>
                            </div>
                            <div class="{{ $transaction->type === 'credit' ? 'text-success' : 'text-danger' }}">
                                {{ $transaction->type === 'credit' ? '+' : '-' }} EGP {{ number_format($transaction->amount, 2) }}
                            </div>
                        </div>
                        @if(! $loop->last)
                            <hr>
                        @endif
                    @empty
                        <p class="text-muted mb-0">No transactions linked yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
