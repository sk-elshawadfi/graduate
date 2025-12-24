@extends('layouts.app')



@section('content')
    <section class="container py-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
            <div>
                <p class="text-muted mb-1">Shop handcrafted & planet-friendly stories</p>
                <h1 class="fw-semibold mb-0">All Products</h1>
            </div>
            <div class="d-flex gap-2 mt-3 mt-md-0">
                <input type="search" class="form-control rounded-pill" placeholder="Search decoupage, recycle art">
                <select class="form-select rounded-pill" style="max-width: 200px;">
                    <option>Sort by featured</option>
                    <option>Price: Low to High</option>
                    <option>Price: High to Low</option>
                    <option>Newest</option>
                </select>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-3">
                <div class="filters-card">
                    <h5 class="fw-semibold mb-3">Filters</h5>
                    <div class="mb-4">
                        <p class="text-muted text-uppercase small mb-2">Categories</p>
                        @foreach($categories as $category)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="cat{{ $loop->index }}">
                                <label class="form-check-label" for="cat{{ $loop->index }}">{{ $category->name }}</label>
                            </div>
                        @endforeach
                    </div>
                    <div class="mb-4">
                        <p class="text-muted text-uppercase small mb-2">Price range</p>
                        <input type="range" class="form-range">
                        <div class="d-flex justify-content-between small text-muted">
                            <span>EGP 200</span><span>EGP 3000</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-muted text-uppercase small mb-2">Palette</p>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach(['#c2410c','#1d4ed8','#16a34a','#fbbf24','#ec4899'] as $color)
                                <button class="color-dot" style="background-color: {{ $color }}" type="button"></button>
                            @endforeach
                        </div>
                    </div>
                    <button class="btn btn-primary w-100 mt-4" type="button">Apply filters</button>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="row g-4">
                    @foreach($products as $product)
                        <div class="col-md-6 col-xl-4">
                            @include('partials.product-card', ['product' => $product])
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 d-flex justify-content-center">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
