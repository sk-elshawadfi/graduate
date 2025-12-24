@extends('admin.layouts.app')

@section('page-title', 'Recycle Requests')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Recycle Requests</li>
@endsection

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="">All</option>
                        @foreach(['pending','reviewing','approved','rejected','completed'] as $status)
                            <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Type</label>
                    <select name="type" class="form-control">
                        <option value="">All</option>
                        <option value="recycle" @selected(request('type') === 'recycle')>Recycle</option>
                        <option value="sell" @selected(request('type') === 'sell')>Sell</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-primary"><i class="fas fa-search me-1"></i> Filter</button>
                    <a href="{{ route('admin.recycle-requests.index') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Requests</h3>
            <div class="card-tools">
                <a href="{{ route('admin.recycle-requests.create') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus me-1"></i> Add request</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                <tr>
                    <th>User</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Admin price</th>
                    <th>Submitted</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($requests as $request)
                    <tr>
                        <td>{{ $request->user->name }}</td>
                        <td>{{ ucfirst($request->request_type) }}</td>
                        <td><span class="badge bg-info">{{ ucfirst($request->status) }}</span></td>
                        <td>{{ $request->admin_price ? 'EGP ' . number_format($request->admin_price, 2) : '-' }}</td>
                        <td>{{ $request->created_at->diffForHumans() }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.recycle-requests.show', $request) }}" class="btn btn-sm btn-outline-secondary">View</a>
                            <a href="{{ route('admin.recycle-requests.edit', $request) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="{{ route('admin.recycle-requests.destroy', $request) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this request?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted p-4">No requests found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $requests->links() }}
        </div>
    </div>
@endsection
