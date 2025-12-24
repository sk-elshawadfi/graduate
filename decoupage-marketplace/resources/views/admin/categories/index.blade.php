@extends('admin.layouts.app')

@section('page-title', 'Categories')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Categories</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Categories</h3>
            <div class="card-tools">
                <form method="GET" class="d-inline-block me-2">
                    <div class="input-group input-group-sm">
                        <input type="text" name="search" class="form-control" placeholder="Search name" value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary"><i class="fas fa-search"></i></button>
                    </div>
                </form>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i> Add category</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Featured</th>
                    <th>Display order</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->slug }}</td>
                        <td>
                            <span class="badge {{ $category->is_featured ? 'bg-success' : 'bg-secondary' }}">
                                {{ $category->is_featured ? 'Yes' : 'No' }}
                            </span>
                        </td>
                        <td>{{ $category->display_order }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this category?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted p-4">No categories found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $categories->links() }}
        </div>
    </div>
@endsection
