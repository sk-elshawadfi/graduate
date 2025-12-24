@extends('admin.layouts.app')

@section('page-title', 'Create Recycle Request')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.recycle-requests.index') }}">Recycle Requests</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h3 class="card-title">New request</h3></div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.recycle-requests.store') }}" enctype="multipart/form-data">
                @include('admin.recycle_requests._form')
                <button class="btn btn-primary mt-3">Save request</button>
                <a href="{{ route('admin.recycle-requests.index') }}" class="btn btn-outline-secondary mt-3">Cancel</a>
            </form>
        </div>
    </div>
@endsection
