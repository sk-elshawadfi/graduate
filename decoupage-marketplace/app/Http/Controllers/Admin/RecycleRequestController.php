<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RecycleRequestRequest;
use App\Models\RecycleRequest;
use App\Models\Transaction;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RecycleRequestController extends Controller
{
    public function __construct(private ActivityLogger $logger)
    {
        $this->authorizeResource(RecycleRequest::class, 'recycleRequest');
    }

    public function index(Request $request): View
    {
        $requests = RecycleRequest::query()
            ->with(['user', 'handler'])
            ->when($request->string('status')->toString(), fn ($q, $status) => $q->where('status', $status))
            ->when($request->string('type')->toString(), fn ($q, $type) => $q->where('request_type', $type))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.recycle_requests.index', compact('requests'));
    }

    public function create(): View
    {
        return view('admin.recycle_requests.create', [
            'recycleRequest' => new RecycleRequest(),
            'users' => $this->userOptions(),
        ]);
    }

    public function store(RecycleRequestRequest $request): RedirectResponse
    {
        $recycleRequest = RecycleRequest::create($this->prepareData($request));
        $this->maybeHandlePayout($recycleRequest);

        $this->logger->log('recycle.admin.created', [
            'description' => 'Recycle request created from admin',
            'subject_type' => RecycleRequest::class,
            'subject_id' => $recycleRequest->id,
        ]);

        return redirect()->route('admin.recycle-requests.index')->with('success', 'Recycle request created.');
    }

    public function show(RecycleRequest $recycleRequest): View
    {
        $recycleRequest->load(['user', 'handler', 'transactions']);

        return view('admin.recycle_requests.show', compact('recycleRequest'));
    }

    public function edit(RecycleRequest $recycleRequest): View
    {
        return view('admin.recycle_requests.edit', [
            'recycleRequest' => $recycleRequest,
            'users' => $this->userOptions(),
        ]);
    }

    public function update(RecycleRequestRequest $request, RecycleRequest $recycleRequest): RedirectResponse
    {
        $recycleRequest->update($this->prepareData($request, $recycleRequest));
        $this->maybeHandlePayout($recycleRequest);

        $this->logger->log('recycle.admin.updated', [
            'description' => 'Recycle request updated from admin',
            'subject_type' => RecycleRequest::class,
            'subject_id' => $recycleRequest->id,
            'properties' => ['status' => $recycleRequest->status],
        ]);

        return redirect()->route('admin.recycle-requests.show', $recycleRequest)->with('success', 'Recycle request updated.');
    }

    public function destroy(RecycleRequest $recycleRequest): RedirectResponse
    {
        $recycleRequest->delete();

        $this->logger->log('recycle.admin.deleted', [
            'description' => 'Recycle request deleted',
            'subject_type' => RecycleRequest::class,
            'subject_id' => $recycleRequest->id,
        ]);

        return redirect()->route('admin.recycle-requests.index')->with('success', 'Recycle request removed.');
    }

    protected function userOptions(): array
    {
        return User::orderBy('name')->pluck('name', 'id')->toArray();
    }

    protected function prepareData(RecycleRequestRequest $request, ?RecycleRequest $existing = null): array
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($existing && $existing->image_path) {
                Storage::disk('public')->delete($existing->image_path);
            }
            $data['image_path'] = $request->file('image')->store('recycle', 'public');
        } elseif (! empty($data['image_path'])) {
            // keep provided path
        } elseif ($existing) {
            $data['image_path'] = $existing->image_path;
        }

        if ($data['status'] !== 'pending') {
            $data['handled_by'] = auth()->id();
            $data['responded_at'] = $existing?->responded_at ?? now();
        } else {
            $data['handled_by'] = $existing?->handled_by;
            $data['responded_at'] = null;
        }

        return $data;
    }

    protected function maybeHandlePayout(RecycleRequest $recycleRequest): void
    {
        if (! in_array($recycleRequest->status, ['approved', 'completed'], true)) {
            return;
        }

        if (! $recycleRequest->admin_price) {
            return;
        }

        $wallet = $recycleRequest->user->wallet()->firstOrCreate([], [
            'balance' => 0,
            'currency' => 'EGP',
        ]);

        $reference = 'REC-' . Str::padLeft((string) $recycleRequest->id, 6, '0');

        $alreadyCredited = $recycleRequest->transactions()
            ->where('reference', $reference)
            ->exists();

        if ($alreadyCredited) {
            return;
        }

        $before = $wallet->balance;
        $after = $before + $recycleRequest->admin_price;
        $wallet->update(['balance' => $after]);

        Transaction::create([
            'wallet_id' => $wallet->id,
            'subject_type' => RecycleRequest::class,
            'subject_id' => $recycleRequest->id,
            'type' => 'credit',
            'status' => 'completed',
            'amount' => $recycleRequest->admin_price,
            'balance_before' => $before,
            'balance_after' => $after,
            'reference' => $reference,
            'description' => 'Recycle request payout',
        ]);
    }
}
