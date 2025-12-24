@extends('admin.layouts.app')

@section('page-title', 'Activity Log #' . $activityLog->id)

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.activity-logs.index') }}">Activity Logs</a></li>
    <li class="breadcrumb-item active">Log #{{ $activityLog->id }}</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Log details</h3>
        </div>
        <div class="card-body">
            <p><strong>Action:</strong> {{ $activityLog->action }}</p>
            <p><strong>User:</strong> {{ $activityLog->user?->name ?? 'System' }}</p>
            <p><strong>Description:</strong> {{ $activityLog->description ?? 'N/A' }}</p>
            <p><strong>Subject:</strong> {{ $activityLog->subject_type }} #{{ $activityLog->subject_id }}</p>
            <p><strong>IP Address:</strong> {{ $activityLog->ip_address }}</p>
            <p><strong>User agent:</strong> {{ $activityLog->user_agent }}</p>
            <p><strong>Date:</strong> {{ $activityLog->created_at->format('d M Y H:i:s') }}</p>
            @if($activityLog->properties)
                <h5 class="mt-4">Properties</h5>
                <pre class="bg-light p-3 rounded">{{ json_encode($activityLog->properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
            @endif
        </div>
    </div>
@endsection
