@extends('admin.layouts.app')

@section('page-title', 'Edit Category')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h3 class="card-title">Edit {{ $category->name }}</h3></div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.categories.update', $category) }}">
                @include('admin.categories._form')
                <button class="btn btn-primary mt-3">Update category</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary mt-3">Cancel</a>
            </form>
        </div>
    </div>
@endsection
