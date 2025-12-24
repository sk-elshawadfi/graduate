@extends('admin.layouts.app')

@section('page-title', 'Edit Review')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.reviews.index') }}">Reviews</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Review for {{ $review->product->title }}</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.reviews.update', $review) }}">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="rating">Rating</label>
                            <select name="rating" id="rating" class="form-control">
                                @for($i = 5; $i >= 1; $i--)
                                    <option value="{{ $i }}" @selected(old('rating', $review->rating) == $i)>{{ $i }} stars</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-check mt-3">
                            <input type="checkbox" name="is_visible" value="1" id="is_visible" class="form-check-input" @checked(old('is_visible', $review->is_visible))>
                            <label for="is_visible" class="form-check-label">Visible</label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $review->title) }}">
                        </div>
                        <div class="form-group">
                            <label for="body">Review body</label>
                            <textarea name="body" id="body" rows="4" class="form-control">{{ old('body', $review->body) }}</textarea>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary">Update review</button>
                <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection
