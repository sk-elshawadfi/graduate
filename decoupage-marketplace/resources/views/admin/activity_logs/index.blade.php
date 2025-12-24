@extends('admin.layouts.app')

@section('page-title', 'Activity Logs')

@section('breadcrumbs')
    <li class="breadcrumb-item active">Activity Logs</li>
@endsection

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Description or subject" value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Action</label>
                    <input type="text" name="action" class="form-control" placeholder="order.placed" value="{{ request('action') }}">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                <tr>
                    <th>Action</th>
                    <th>User</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td>{{ $log->action }}</td>
                        <td>{{ $log->user?->name ?? 'System' }}</td>
                        <td>{{ $log->description }}</td>
                        <td>{{ $log->created_at->format('d M Y H:i') }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.activity-logs.show', $log) }}" class="btn btn-sm btn-outline-secondary">View</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted p-4">No logs found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $logs->links() }}
        </div>
    </div>
@endsection
