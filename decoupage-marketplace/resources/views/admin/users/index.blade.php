@extends('admin.layouts.app')

@section('page-title', 'Users')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Users</li>
@endsection

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Name or email" value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-control">
                        <option value="">All</option>
                        @foreach($roleOptions as $value => $label)
                            <option value="{{ $value }}" @selected(request('role') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="">All</option>
                        <option value="active" @selected(request('status') === 'active')>Active</option>
                        <option value="banned" @selected(request('status') === 'banned')>Banned</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button class="btn btn-primary flex-grow-1"><i class="fas fa-search me-1"></i> Filter</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary"><i class="fas fa-eraser"></i></a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Users</h3>
            <div class="card-tools">
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i> Add user</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>
                            <a href="{{ route('admin.users.show', $user) }}" class="fw-semibold">{{ $user->name }}</a>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @foreach($user->roles as $role)
                                <span class="badge bg-secondary text-uppercase">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            <span class="badge {{ $user->is_banned ? 'bg-danger' : 'bg-success' }}">
                                {{ $user->is_banned ? 'Banned' : 'Active' }}
                            </span>
                        </td>
                        <td>{{ $user->created_at->format('d M Y') }}</td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-primary"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                            <form action="{{ $user->is_banned ? route('admin.users.unban', $user) : route('admin.users.ban', $user) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-sm {{ $user->is_banned ? 'btn-success' : 'btn-warning' }}" onclick="return confirm('Are you sure?');">
                                    <i class="fas fa-user-slash me-1"></i> {{ $user->is_banned ? 'Unban' : 'Ban' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted p-4">No users found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $users->links() }}
        </div>
    </div>
@endsection
