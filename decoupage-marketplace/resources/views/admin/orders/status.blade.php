@extends('admin.layouts.app')

@section('page-title', 'Update Order Status')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.orders.show', $order) }}">{{ $order->order_number }}</a></li>
    <li class="breadcrumb-item active">Update status</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Update {{ $order->order_number }}</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.orders.status.update', $order) }}">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Order status</label>
                            <select name="status" id="status" class="form-control">
                                @foreach(['pending','processing','completed','cancelled'] as $status)
                                    <option value="{{ $status }}" @selected(old('status', $order->status) === $status)>{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="payment_status">Payment status</label>
                            <select name="payment_status" id="payment_status" class="form-control">
                                @foreach(['pending','paid','refunded'] as $status)
                                    <option value="{{ $status }}" @selected(old('payment_status', $order->payment_status) === $status)>{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea name="notes" id="notes" rows="3" class="form-control">{{ old('notes', $order->notes) }}</textarea>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary">Update status</button>
                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection
