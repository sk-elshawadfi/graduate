@extends('admin.layouts.app')

@section('page-title', 'Wallets')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Wallets</li>
@endsection

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Name or email" value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="">All</option>
                        <option value="active" @selected(request('status') === 'active')>Active</option>
                        <option value="suspended" @selected(request('status') === 'suspended')>Suspended</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Wallets</h3>
            <div class="card-tools">
                <a href="{{ route('admin.wallets.create') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus me-1"></i> Create wallet</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                <tr>
                    <th>User</th>
                    <th>Balance</th>
                    <th>Status</th>
                    <th>Updated</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($wallets as $wallet)
                    <tr>
                        <td>{{ $wallet->user->name }}</td>
                        <td>EGP {{ number_format($wallet->balance, 2) }}</td>
                        <td><span class="badge bg-{{ $wallet->status === 'active' ? 'success' : 'warning' }}">{{ ucfirst($wallet->status) }}</span></td>
                        <td>{{ $wallet->updated_at->diffForHumans() }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.wallets.show', $wallet) }}" class="btn btn-sm btn-outline-secondary">View</a>
                            <a href="{{ route('admin.wallets.edit', $wallet) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="{{ route('admin.wallets.destroy', $wallet) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this wallet?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted p-4">No wallets found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $wallets->links() }}
        </div>
    </div>
@endsection
