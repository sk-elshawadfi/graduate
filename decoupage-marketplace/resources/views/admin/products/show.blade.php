@extends('admin.layouts.app')

@section('page-title', $product->title)

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
    <li class="breadcrumb-item active">{{ $product->title }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body text-center">
                    <img src="{{ $product->primary_image ?? 'https://via.placeholder.com/400x300?text=No+Image' }}" class="img-fluid rounded mb-3" alt="{{ $product->title }}">
                    <h3>{{ $product->title }}</h3>
                    <p class="text-muted mb-1">{{ $product->category?->name }}</p>
                    <p class="h4 mb-3">EGP {{ number_format($product->price, 2) }}</p>
                    <div class="d-flex justify-content-between">
                        <span>SKU: {{ $product->sku }}</span>
                        <span>Stock: {{ $product->stock }}</span>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-{{ $product->status === 'active' ? 'success' : 'secondary' }}">{{ ucfirst($product->status) }}</span>
                        @if($product->is_featured)
                            <span class="badge bg-warning text-dark">Featured</span>
                        @endif
                    </div>
                </div>
            </div>
            @if($product->images)
                <div class="card">
                    <div class="card-header"><h3 class="card-title">Gallery</h3></div>
                    <div class="card-body">
                        <div class="row g-2">
                            @foreach($product->images as $image)
                                <div class="col-6">
                                    <img src="{{ $image }}" class="img-fluid rounded" alt="Gallery image">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Description</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted">{{ $product->short_description }}</p>
                    <p>{{ $product->description }}</p>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Reviews</h3>
                    <a href="{{ route('admin.reviews.index', ['product_id' => $product->id]) }}" class="btn btn-sm btn-outline-primary float-end">Manage reviews</a>
                </div>
                <div class="card-body">
                    @forelse($product->reviews as $review)
                        <div class="mb-3">
                            <h5 class="mb-1">{{ $review->user->name }} <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small></h5>
                            <p class="mb-1 text-warning">
                                @for($i = 0; $i < $review->rating; $i++)
                                    <i class="fas fa-star"></i>
                                @endfor
                            </p>
                            <p>{{ $review->body }}</p>
                        </div>
                        @if(! $loop->last)
                            <hr>
                        @endif
                    @empty
                        <p class="text-muted mb-0">No reviews available.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
