@extends('admin.layouts.app')

@section('page-title', 'Edit Product')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h3 class="card-title">Edit {{ $product->title }}</h3></div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.products.update', $product) }}">
                @include('admin.products._form')
                <button class="btn btn-primary mt-3">Update product</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary mt-3">Cancel</a>
            </form>
        </div>
    </div>
@endsection
