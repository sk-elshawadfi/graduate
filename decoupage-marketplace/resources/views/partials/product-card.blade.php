@props(['product'])
<div class="product-card card border-0 shadow-sm h-100" data-aos="fade-up">
    <div class="ratio ratio-4x3 position-relative">
        <img src="{{ $product->primary_image ?? 'https://via.placeholder.com/600x400?text=Decoupage+Art' }}" alt="{{ $product->title }}" class="card-img-top object-fit-cover rounded-top-4">
        <span class="badge badge-soft position-absolute top-0 start-0 m-3">{{ $product->is_featured ? 'Featured' : ($product->created_at->diffInDays(now()) < 7 ? 'New' : 'Available') }}</span>
        <button class="btn btn-light rounded-pill btn-like" type="button"><i class="fa-regular fa-heart"></i></button>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <p class="text-muted small mb-0">{{ $product->category->name ?? 'Upcycled' }}</p>
            <span class="fw-semibold text-primary">EGP {{ number_format($product->price ?? 0, 2) }}</span>
        </div>
        <h5 class="card-title fs-6 fw-semibold">{{ $product->title }}</h5>
        <p class="card-text text-muted small">{{ Str::limit($product->short_description ?? '', 80) }}</p>
        <div class="d-flex justify-content-between align-items-center mt-3">
            <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary rounded-pill btn-sm">View</a>
            <button class="btn btn-primary rounded-pill btn-sm" type="button" onclick="showToast('success', 'Added to cart!')">
                <i class="fa-solid fa-cart-plus me-1"></i> Add
            </button>
        </div>
    </div>
</div>
