@extends('admin.layouts.app')

@section('page-title', 'Create Category')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h3 class="card-title">New category</h3></div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.categories.store') }}">
                @include('admin.categories._form')
                <button class="btn btn-primary mt-3">Save category</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary mt-3">Cancel</a>
            </form>
        </div>
    </div>
@endsection
