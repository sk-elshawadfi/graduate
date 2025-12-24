<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRecycleRequest;
use App\Models\RecycleRequest;
use App\Services\ActivityLogger;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class RecycleRequestController extends Controller
{
    public function __construct(private ActivityLogger $logger)
    {
        $this->middleware(['auth', 'active.user']);
    }

    public function index(): View
    {
        $requests = auth()
            ->user()
            ->recycleRequests()
            ->latest()
            ->paginate(6);

        return view('pages.recycle.index', compact('requests'));
    }

    public function store(StoreRecycleRequest $request): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('recycle', 'public');
        }

        $data['user_id'] = $request->user()->id;

        $recycleRequest = RecycleRequest::create($data);

        $this->logger->log('recycle.submitted', [
            'description' => 'Recycle request submitted',
            'subject_type' => RecycleRequest::class,
            'subject_id' => $recycleRequest->id,
            'properties' => [
                'request_type' => $recycleRequest->request_type,
            ],
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Request submitted! Our team will get back shortly.',
                'request' => $recycleRequest,
            ], 201);
        }

        return redirect()->route('recycle.index')->with('success', 'Request submitted! Our team will get back shortly.');
    }
}
