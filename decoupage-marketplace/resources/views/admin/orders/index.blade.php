@extends('admin.layouts.app')

@section('page-title', 'Orders')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Orders</li>
@endsection

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Order # or customer" value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Order status</label>
                    <select name="status" class="form-control">
                        <option value="">All</option>
                        @foreach(['pending','processing','completed','cancelled'] as $status)
                            <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Payment status</label>
                    <select name="payment_status" class="form-control">
                        <option value="">All</option>
                        @foreach(['pending','paid','refunded'] as $status)
                            <option value="{{ $status }}" @selected(request('payment_status') === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary"><i class="fas fa-search me-1"></i> Filter</button>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th>Placed</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td><a href="{{ route('admin.orders.show', $order) }}">{{ $order->order_number }}</a></td>
                        <td>{{ $order->user->name }}</td>
                        <td>EGP {{ number_format($order->total, 2) }}</td>
                        <td><span class="badge bg-{{ $order->status === 'completed' ? 'success' : 'secondary' }}">{{ ucfirst($order->status) }}</span></td>
                        <td><span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">{{ ucfirst($order->payment_status) }}</span></td>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.orders.status.edit', $order) }}" class="btn btn-sm btn-outline-primary">Update status</a>
                            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this order?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted p-4">No orders found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $orders->links() }}
        </div>
    </div>
@endsection
