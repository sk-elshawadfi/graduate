@extends('admin.layouts.app')

@section('page-title', 'Create Wallet')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.wallets.index') }}">Wallets</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h3 class="card-title">New wallet</h3></div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.wallets.store') }}">
                @include('admin.wallets._form')
                <button class="btn btn-primary mt-3">Save wallet</button>
                <a href="{{ route('admin.wallets.index') }}" class="btn btn-outline-secondary mt-3">Cancel</a>
            </form>
        </div>
    </div>
@endsection
