@extends('admin.layouts.app')

@section('page-title', 'Create Product')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h3 class="card-title">New product</h3></div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.products.store') }}">
                @include('admin.products._form')
                <button class="btn btn-primary mt-3">Save product</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary mt-3">Cancel</a>
            </form>
        </div>
    </div>
@endsection
