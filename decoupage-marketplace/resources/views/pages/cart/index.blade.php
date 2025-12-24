@extends('layouts.app')

@php
    $cartItems = [
        ['title' => 'Upcycled Denim Pouf', 'price' => 950, 'qty' => 1, 'image' => 'https://images.unsplash.com/photo-1449247709967-d4461a6a6103?auto=format&fit=crop&w=400&q=80'],
        ['title' => 'Mini Mosaic Tray', 'price' => 420, 'qty' => 2, 'image' => 'https://images.unsplash.com/photo-1519710164239-da123dc03ef4?auto=format&fit=crop&w=400&q=80'],
    ];
@endphp

@section('content')
    <section class="container py-5">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle table-modern mb-0">
                                <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($cartItems as $item)
                                    <tr data-cart-item data-price="{{ $item['price'] }}">
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="{{ $item['image'] }}" alt="" class="rounded-3" style="width:70px;height:70px;object-fit:cover;">
                                                <div>
                                                    <p class="mb-0 fw-semibold">{{ $item['title'] }}</p>
                                                    <small class="text-muted">Handmade • Ready to ship</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group w-auto align-items-center">
                                                <button class="btn btn-outline-primary btn-sm" type="button" data-qty-btn="-1">-</button>
                                                <input type="number" class="form-control text-center" data-qty-input value="{{ $item['qty'] }}" min="1" style="max-width:70px;">
                                                <button class="btn btn-outline-primary btn-sm" type="button" data-qty-btn="1">+</button>
                                            </div>
                                        </td>
                                        <td>EGP {{ number_format($item['price'], 2) }}</td>
                                        <td data-line-total></td>
                                        <td><button class="btn btn-link text-danger" type="button" data-remove-item><i class="fa-solid fa-xmark"></i></button></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="order-summary">
                    <h5 class="fw-semibold mb-3">Order summary</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <strong data-cart-subtotal>EGP 0.00</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping</span>
                        <span data-cart-shipping>EGP 60.00</span>
                    </div>
                    <div class="d-flex justify-content-between border-top pt-3">
                        <span class="fw-semibold">Total</span>
                        <strong data-cart-total>EGP 0.00</strong>
                    </div>
                    <button class="btn btn-primary w-100 mt-4" type="button" onclick="showToast('success', 'Heading to checkout')">Checkout</button>
                    <small class="text-muted d-block mt-2">Wallet credits apply automatically.</small>
                </div>
            </div>
        </div>
    </section>
@endsection
