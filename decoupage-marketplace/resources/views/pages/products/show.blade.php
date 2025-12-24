@extends('layouts.app')



@section('content')
    <section class="container py-5">
        <div class="row g-5">
            <div class="col-lg-6">
            <div class="col-lg-6">
                <div class="row g-3">
                    @forelse($product->images ?? [] as $image)
                        <div class="col-6" data-aos="zoom-in">
                            <a href="{{ $image }}" data-lightbox="product-gallery">
                                <img src="{{ $image }}" alt="{{ $product->title }}" class="img-fluid rounded-4 shadow-sm">
                            </a>
                        </div>
                    @empty
                         <div class="col-12" data-aos="zoom-in">
                            <a href="{{ $product->primary_image ?? 'https://via.placeholder.com/600x600' }}" data-lightbox="product-gallery">
                                <img src="{{ $product->primary_image ?? 'https://via.placeholder.com/600x600' }}" alt="{{ $product->title }}" class="img-fluid rounded-4 shadow-sm">
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
            <div class="col-lg-6">
                <p class="text-muted text-uppercase small">{{ $product->category->name ?? 'Limited release' }}</p>
                <h1 class="fw-bold">{{ $product->title }}</h1>
                <div class="d-flex align-items-center gap-3 mb-3">
                    <h2 class="text-primary fw-semibold">EGP {{ number_format($product->price, 2) }}</h2>
                    <span class="badge badge-stock bg-success text-white">{{ $product->stock }} in stock</span>
                </div>
                <p class="text-muted">{{ $product->description }}</p>
                <div class="d-flex gap-3 align-items-center my-4">
                    <div class="input-group w-auto">
                        <button class="btn btn-outline-primary" type="button" data-qty-btn="-1">-</button>
                        <input type="number" class="form-control text-center" value="1" min="1" style="max-width: 80px;" data-qty-input>
                        <button class="btn btn-outline-primary" type="button" data-qty-btn="1">+</button>
                    </div>
                    <button class="btn btn-primary px-4" type="button" onclick="showToast('success', 'Added to cart')">
                        <i class="fa-solid fa-cart-plus me-2"></i> Add to cart
                    </button>
                </div>
                <div class="mt-4">
                    <ul class="nav nav-pills mb-3" id="productTab" role="tablist">
                        @foreach(['description' => 'Description', 'reviews' => 'Reviews', 'shipping' => 'Shipping'] as $key => $label)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ $key }}-tab" data-bs-toggle="pill" data-bs-target="#{{ $key }}" type="button">{{ $label }}</button>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="description">
                            <p>Each piece is sealed for moisture resistance, making it suitable for indoor/outdoor styling. Delivered with certificate of authenticity.</p>
                        </div>
                        <div class="tab-pane fade" id="reviews">
                            <div class="mb-3">
                                <h5>Customer Voices</h5>
                                @forelse($product->reviews as $review)
                                    <div class="d-flex gap-3 align-items-center mb-3">
                                        <div class="avatar bg-primary bg-opacity-10 rounded-circle p-3"><i class="fa-solid fa-user text-primary"></i></div>
                                        <div>
                                            <p class="mb-0 fw-semibold">{{ $review->user->name ?? 'Anonymous' }}</p>
                                            <small class="text-muted">“{{ $review->body }}”</small>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-muted">No reviews yet.</p>
                                @endforelse
                            </div>
                            <form class="row g-3">
                                <div class="col-md-6 floating-label">
                                    <input type="text" class="form-control" placeholder=" " id="reviewName">
                                    <label for="reviewName">Name</label>
                                </div>
                                <div class="col-md-6 floating-label">
                                    <input type="email" class="form-control" placeholder=" " id="reviewEmail">
                                    <label for="reviewEmail">Email</label>
                                </div>
                                <div class="col-12 floating-label">
                                    <textarea class="form-control" rows="3" placeholder=" " id="reviewMessage"></textarea>
                                    <label for="reviewMessage">Share your thoughts</label>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-outline-primary" type="button" onclick="showToast('success', 'Review submitted!')">Submit review</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="shipping">
                            <ul class="list-unstyled text-muted">
                                <li><i class="fa-solid fa-truck-fast me-2 text-primary"></i>Same-week delivery across Egypt</li>
                                <li><i class="fa-solid fa-shield-check me-2 text-primary"></i>Secure packaging with eco padding</li>
                                <li><i class="fa-solid fa-gift me-2 text-primary"></i>Complimentary handwritten note</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
