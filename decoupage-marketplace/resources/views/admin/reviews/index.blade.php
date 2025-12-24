@extends('admin.layouts.app')

@section('page-title', 'Reviews')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Reviews</li>
@endsection

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Product</label>
                    <select name="product_id" class="form-control">
                        <option value="">All</option>
                        @foreach($products as $id => $name)
                            <option value="{{ $id }}" @selected(request('product_id') == $id)>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Rating</label>
                    <select name="rating" class="form-control">
                        <option value="">All</option>
                        @for($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}" @selected(request('rating') == $i)>{{ $i }} stars</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Visibility</label>
                    <select name="status" class="form-control">
                        <option value="">All</option>
                        <option value="visible" @selected(request('status') === 'visible')>Visible</option>
                        <option value="hidden" @selected(request('status') === 'hidden')>Hidden</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                <tr>
                    <th>Product</th>
                    <th>User</th>
                    <th>Rating</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($reviews as $review)
                    <tr>
                        <td>{{ $review->product->title }}</td>
                        <td>{{ $review->user->name }}</td>
                        <td>{{ $review->rating }} ★</td>
                        <td><span class="badge bg-{{ $review->is_visible ? 'success' : 'secondary' }}">{{ $review->is_visible ? 'Visible' : 'Hidden' }}</span></td>
                        <td>{{ $review->created_at->format('d M Y') }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.reviews.edit', $review) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="{{ route('admin.reviews.toggle', $review) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-outline-secondary">{{ $review->is_visible ? 'Hide' : 'Show' }}</button>
                            </form>
                            <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this review?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted p-4">No reviews found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $reviews->links() }}
        </div>
    </div>
@endsection
