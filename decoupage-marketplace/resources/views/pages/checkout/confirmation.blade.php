@extends('layouts.app')

@section('content')
<div class="container py-5 text-center">
    <div class="card border-0 shadow-sm mx-auto" style="max-width: 600px;">
        <div class="card-body p-5">
            <i class="fa-solid fa-circle-check text-success fa-3x mb-3"></i>
            <h2 class="fw-bold">Thank you!</h2>
            <p class="text-muted">Your order <strong>{{ $order->order_number }}</strong> has been received. We'll notify you when it's ready to ship.</p>
            <ul class="list-unstyled text-start mt-4">
                <li class="mb-2"><strong>Total:</strong> EGP {{ number_format($order->total, 2) }}</li>
                <li class="mb-2"><strong>Payment:</strong> {{ ucfirst($order->payment_method) }} ({{ $order->payment_status }})</li>
                <li><strong>Shipping to:</strong> {{ $order->shipping_address }}, {{ $order->shipping_city }}</li>
            </ul>
            <a href="{{ route('dashboard') }}" class="btn btn-primary mt-3">View dashboard</a>
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary mt-3">Continue shopping</a>
        </div>
    </div>
</div>
@endsection
