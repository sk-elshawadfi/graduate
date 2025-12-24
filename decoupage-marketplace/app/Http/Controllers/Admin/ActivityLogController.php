<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(ActivityLog::class, 'activity_log');
    }

    public function index(Request $request): View
    {
        $logs = ActivityLog::query()
            ->with('user')
            ->when($request->string('action')->toString(), fn ($q, $action) => $q->where('action', $action))
            ->when($request->string('search')->toString(), function ($query, $search) {
                $query->where('description', 'like', "%{$search}%")
                    ->orWhere('subject_type', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.activity_logs.index', compact('logs'));
    }

    public function show(ActivityLog $activityLog): View
    {
        $activityLog->load('user');

        return view('admin.activity_logs.show', compact('activityLog'));
    }
}
