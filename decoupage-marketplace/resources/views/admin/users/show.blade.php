@extends('admin.layouts.app')

@section('page-title', 'User Details')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
    <li class="breadcrumb-item active">{{ $user->name }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <img src="https://www.gravatar.com/avatar/{{ md5(strtolower($user->email)) }}?s=120&d=retro" class="img-fluid rounded-circle mb-3" alt="{{ $user->name }}">
                    <h4>{{ $user->name }}</h4>
                    <p class="text-muted mb-1">{{ $user->email }}</p>
                    <p class="text-muted">{{ $user->phone }}</p>
                    <span class="badge {{ $user->is_banned ? 'bg-danger' : 'bg-success' }}">{{ $user->is_banned ? 'Banned' : 'Active' }}</span>
                </div>
                <div class="card-footer">
                    <p class="mb-1"><i class="fas fa-location-dot me-2"></i>{{ $user->address ?? 'No address' }}</p>
                    <p class="mb-1"><i class="fas fa-earth-africa me-2"></i>{{ $user->city }}, {{ $user->country }}</p>
                    <p class="mb-0"><small>Joined {{ $user->created_at->diffForHumans() }}</small></p>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Role & Status</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.users.roles', $user) }}">
                        @csrf
                        <div class="form-group">
                            <label>Role</label>
                            <select name="role" class="form-control">
                                <option value="user" @selected($user->hasRole('user'))>Customer</option>
                                @if(auth()->user()->isSuperAdmin())
                                    <option value="admin" @selected($user->hasRole('admin'))>Admin</option>
                                @endif
                            </select>
                        </div>
                        <button class="btn btn-primary btn-sm mt-2">Update role</button>
                    </form>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <form action="{{ $user->is_banned ? route('admin.users.unban', $user) : route('admin.users.ban', $user) }}" method="POST">
                            @csrf
                            <button class="btn btn-outline-{{ $user->is_banned ? 'success' : 'danger' }} btn-sm">
                                {{ $user->is_banned ? 'Unban user' : 'Ban user' }}
                            </button>
                        </form>
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-secondary btn-sm">Edit profile</a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Wallet</h3>
                </div>
                <div class="card-body">
                    @if($user->wallet)
                        <p class="mb-1">Balance: <strong>EGP {{ number_format($user->wallet->balance, 2) }}</strong></p>
                        <p class="mb-3 text-muted">Status: {{ ucfirst($user->wallet->status) }}</p>
                        <a href="{{ route('admin.wallets.show', $user->wallet) }}" class="btn btn-sm btn-outline-primary">View wallet</a>
                    @else
                        <p class="text-muted mb-0">Wallet has not been created yet.</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Recent Orders</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th>Order</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Placed</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($user->orders as $order)
                            <tr>
                                <td><a href="{{ route('admin.orders.show', $order) }}">{{ $order->order_number }}</a></td>
                                <td>EGP {{ number_format($order->total, 2) }}</td>
                                <td>{{ ucfirst($order->status) }}</td>
                                <td>{{ $order->created_at->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted p-4">No orders yet.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($user->bio)
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Bio</h3>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $user->bio }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
