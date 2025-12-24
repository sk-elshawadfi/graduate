<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReviewRequest;
use App\Models\Product;
use App\Models\Review;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function __construct(private ActivityLogger $logger)
    {
        $this->authorizeResource(Review::class, 'review');
    }

    public function index(Request $request): View
    {
        $reviews = Review::query()
            ->with(['user', 'product'])
            ->when($request->string('status')->toString(), fn ($q, $status) => $q->where('is_visible', $status === 'visible'))
            ->when($request->integer('product_id'), fn ($q, $productId) => $q->where('product_id', $productId))
            ->when($request->integer('rating'), fn ($q, $rating) => $q->where('rating', $rating))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $products = Product::orderBy('title')->pluck('title', 'id');

        return view('admin.reviews.index', compact('reviews', 'products'));
    }

    public function edit(Review $review): View
    {
        return view('admin.reviews.edit', compact('review'));
    }

    public function update(ReviewRequest $request, Review $review): RedirectResponse
    {
        $data = $request->validated();
        $data['is_visible'] = $request->boolean('is_visible');
        $review->update($data);

        $this->logger->log('review.updated', [
            'description' => 'Review updated by admin',
            'subject_type' => Review::class,
            'subject_id' => $review->id,
        ]);

        return redirect()->route('admin.reviews.index')->with('success', 'Review updated.');
    }

    public function destroy(Review $review): RedirectResponse
    {
        $review->delete();

        $this->logger->log('review.deleted', [
            'description' => 'Review deleted by admin',
            'subject_type' => Review::class,
            'subject_id' => $review->id,
        ]);

        return redirect()->route('admin.reviews.index')->with('success', 'Review deleted.');
    }

    public function toggleVisibility(Review $review): RedirectResponse
    {
        $this->authorize('update', $review);

        $review->update(['is_visible' => ! $review->is_visible]);

        $this->logger->log('review.visibility', [
            'description' => 'Review visibility toggled',
            'subject_type' => Review::class,
            'subject_id' => $review->id,
            'properties' => ['visible' => $review->is_visible],
        ]);

        return back()->with('success', 'Review visibility updated.');
    }
}
