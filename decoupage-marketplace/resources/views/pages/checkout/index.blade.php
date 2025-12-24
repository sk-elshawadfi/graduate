@extends('layouts.app')

@section('content')
    <section class="container py-5">
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body">
                        <h5 class="fw-semibold mb-4">Shipping details</h5>
                        <form class="row g-3">
                            @foreach(['Full name','Email','Phone','Address','City','Country'] as $field)
                                <div class="{{ in_array($field, ['Address']) ? 'col-12' : 'col-md-6' }} floating-label">
                                    <input type="text" class="form-control" placeholder=" " id="{{ Str::slug($field) }}">
                                    <label for="{{ Str::slug($field) }}">{{ $field }}</label>
                                </div>
                            @endforeach
                            <div class="col-12 mt-4">
                                <h6 class="fw-semibold mb-2">Payment method</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="payment-option">
                                            <input type="radio" name="payment" checked>
                                            <div>
                                                <strong>Wallet balance</strong>
                                                <p class="mb-0 text-muted small">Use earned credits</p>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="payment-option">
                                            <input type="radio" name="payment">
                                            <div>
                                                <strong>Cash on delivery</strong>
                                                <p class="mb-0 text-muted small">Pay when delivered</p>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="order-summary mb-4">
                    <h5 class="fw-semibold mb-3">Order review</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span><strong>EGP 1,950</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping</span><strong>EGP 60</strong>
                    </div>
                    <div class="d-flex justify-content-between border-top pt-3">
                        <span class="fw-semibold">Total</span><strong>EGP 2,010</strong>
                    </div>
                    <button class="btn btn-primary w-100 mt-4" type="button" onclick="document.getElementById('checkoutSuccess').classList.remove('d-none');showToast('success','Order placed successfully!')">Place order</button>
                    <div class="alert alert-success mt-3 d-none" id="checkoutSuccess">
                        <i class="fa-solid fa-circle-check me-2"></i>Your order is confirmed! Check dashboard for live status.
                    </div>
                </div>
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body text-center">
                        <i class="fa-solid fa-shield-halved fa-2x text-primary mb-3"></i>
                        <p class="mb-1 fw-semibold">Secure checkout</p>
                        <p class="text-muted small mb-0">SSL encrypted • 24h artisan support • Pay in Arabic or English</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
