<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(private ActivityLogger $logger)
    {
        $this->authorizeResource(Category::class, 'category');
    }

    public function index(Request $request): View
    {
        $categories = Category::query()
            ->when($request->string('search')->toString(), function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy('display_order')
            ->paginate(15)
            ->withQueryString();

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.categories.create', ['category' => new Category()]);
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        $category = Category::create($request->validated());

        $this->logger->log('category.created', [
            'description' => 'Category created',
            'subject_type' => Category::class,
            'subject_id' => $category->id,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category created.');
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update($request->validated());

        $this->logger->log('category.updated', [
            'description' => 'Category updated',
            'subject_type' => Category::class,
            'subject_id' => $category->id,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        $this->logger->log('category.deleted', [
            'description' => 'Category deleted',
            'subject_type' => Category::class,
            'subject_id' => $category->id,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category removed.');
    }
}
