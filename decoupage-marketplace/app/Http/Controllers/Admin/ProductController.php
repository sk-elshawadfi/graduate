<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(private ActivityLogger $logger)
    {
        $this->authorizeResource(Product::class, 'product');
    }

    public function index(Request $request): View
    {
        $query = Product::query()->with('category');

        if ($search = $request->string('search')->toString()) {
            $query->where(function ($builder) use ($search) {
                $builder
                    ->where('title', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        if ($status = $request->string('status')->toString()) {
            $query->where('status', $status);
        }

        if ($category = $request->integer('category_id')) {
            $query->where('category_id', $category);
        }

        $products = $query->latest()->paginate(12)->withQueryString();

        return view('admin.products.index', [
            'products' => $products,
            'categories' => $this->categoryOptions(),
        ]);
    }

    public function create(): View
    {
        return view('admin.products.create', [
            'product' => new Product(),
            'categories' => $this->categoryOptions(),
        ]);
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        $product = Product::create($this->transformData($request));

        $this->logger->log('product.created', [
            'description' => 'Product created',
            'subject_type' => Product::class,
            'subject_id' => $product->id,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    }

    public function show(Product $product): View
    {
        $product->load('category', 'reviews.user');

        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product): View
    {
        return view('admin.products.edit', [
            'product' => $product,
            'categories' => $this->categoryOptions(),
        ]);
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $product->update($this->transformData($request));

        $this->logger->log('product.updated', [
            'description' => 'Product updated',
            'subject_type' => Product::class,
            'subject_id' => $product->id,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        $this->logger->log('product.deleted', [
            'description' => 'Product deleted',
            'subject_type' => Product::class,
            'subject_id' => $product->id,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product removed.');
    }

    protected function transformData(ProductRequest $request): array
    {
        $data = $request->validated();
        $data['is_featured'] = $request->boolean('is_featured');

        if (! empty($data['images'])) {
            $data['images'] = $this->parseImages($data['images']);
        } else {
            $data['images'] = null;
        }

        return $data;
    }

    protected function parseImages(?string $images): ?array
    {
        if (! $images) {
            return null;
        }

        $list = Collection::make(preg_split('/\r\n|[\r\n]/', $images))
            ->filter()
            ->map(fn ($url) => trim($url))
            ->filter()
            ->values()
            ->all();

        return empty($list) ? null : $list;
    }

    protected function categoryOptions(): array
    {
        return Category::orderBy('name')
            ->pluck('name', 'id')
            ->toArray();
    }
}
