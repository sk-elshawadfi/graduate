@extends('admin.layouts.app')

@section('page-title', 'Edit Wallet')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.wallets.index') }}">Wallets</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h3 class="card-title">Edit wallet of {{ $wallet->user->name }}</h3></div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.wallets.update', $wallet) }}">
                @include('admin.wallets._form')
                <button class="btn btn-primary mt-3">Update wallet</button>
                <a href="{{ route('admin.wallets.show', $wallet) }}" class="btn btn-outline-secondary mt-3">Cancel</a>
            </form>
        </div>
    </div>
@endsection
