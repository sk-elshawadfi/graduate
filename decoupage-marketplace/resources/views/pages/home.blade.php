@extends('layouts.app')



@section('content')
    <section class="container py-5">
        <div class="hero" data-aos="fade-up">
            <div class="row g-4 align-items-center">
                <div class="col-lg-7">
                    <p class="badge-soft text-uppercase mb-3">Curated Handmade + Recycling Hub</p>
                    <h1>Shop soulful decoupage & give recyclables a second golden life.</h1>
                    <p class="lead mt-3 mb-4">Discover local artists, shop eco-friendly collections, and send us your recyclables for store credit. Cairo-based, globally inspired.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="/products" class="btn btn-light text-dark px-4 py-2">Shop Now</a>
                        <a href="/recycle" class="btn btn-outline-light px-4 py-2">Recycle Item</a>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="bg-white bg-opacity-10 rounded-4 p-4 hero-stats">
                        <div class="d-flex justify-content-between text-center">
                            <div>
                                <h3 class="fw-bold">+350</h3><p class="text-uppercase small">Artisans</p>
                            </div>
                            <div>
                                <h3 class="fw-bold">12k</h3><p class="text-uppercase small">Orders</p>
                            </div>
                            <div>
                                <h3 class="fw-bold">4.9★</h3><p class="text-uppercase small">Reviews</p>
                            </div>
                        </div>
                        <p class="small mt-3 text-white-50">Free delivery for orders above EGP 1000. Earn wallet points with every recycle submission.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-semibold">Featured Stories</h2>
        </div>
        <div class="swiper featured-swiper" data-aos="fade-up">
            <div class="swiper-wrapper">
                @foreach($featuredProducts as $product)
                    <div class="swiper-slide">
                        @include('partials.product-card', ['product' => $product])
                    </div>
                @endforeach
            </div>
            <div class="swiper-button-next featured-next"></div>
            <div class="swiper-button-prev featured-prev"></div>
        </div>
    </section>

    <section class="container py-5">
        <div class="row g-3">
            @foreach($categories as $category)
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="category-pill text-center h-100">
                        <i class="fa-solid fa-box-open fa-2x text-primary mb-3"></i>
                        <h6 class="fw-semibold">{{ $category->name }}</h6>
                        <p class="text-muted small">{{ Str::limit($category->description ?? 'Explore curated drops.', 40) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="container py-5">
        <div class="row g-4 align-items-center">
            <div class="col-lg-6">
                <h2 class="fw-semibold mb-3">Before / After gallery</h2>
                <p class="text-muted mb-4">Witness how discarded furniture transforms into gallery-worthy centerpieces using sustainable decoupage, gold foil, and recycled textiles.</p>
                <a href="/recycle" class="btn btn-primary px-4">Start your transformation</a>
            </div>
            <div class="col-lg-6">
                <div class="row g-3 before-after">
                    @foreach($beforeAfter as $index => $image)
                        <div class="col-6" data-aos="zoom-in" data-aos-delay="{{ $index * 100 }}">
                            <img src="{{ $image }}" alt="Before after {{ $index }}">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="container py-5">
        <div class="row g-4">
            <div class="col-lg-6">
                <h2 class="fw-semibold mb-3">What our community says</h2>
                <div class="swiper testimonial-swiper">
                    <div class="swiper-wrapper">
                        @foreach($reviews as $review)
                            <div class="swiper-slide">
                                <div class="testimonial">
                                    <p class="lead">“{{ Str::limit($review->body, 120) }}”</p>
                                    <p class="fw-semibold mb-0">{{ $review->user->name }}</p>
                                    <small class="text-muted">Verified creator</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination mt-3"></div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="newsletter">
                    <h3 class="fw-bold">Join our eco-circle</h3>
                    <p>Weekly artisan drops, recycling tips, and access to exclusive workshops.</p>
                    <form class="row g-3">
                        <div class="col-md-8">
                            <input type="email" class="form-control rounded-pill" placeholder="Email address">
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-light w-100 text-primary">Subscribe</button>
                        </div>
                    </form>
                    <small class="d-block mt-3">We speak English & Arabic – pick your preference anytime.</small>
                </div>
            </div>
        </div>
    </section>
@endsection
