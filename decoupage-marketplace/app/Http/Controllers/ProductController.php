<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->active();

        if ($search = $request->string('search')->toString()) {
            $query->where('title', 'like', "%{$search}%");
        }

        if ($category = $request->string('category')->toString()) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $category));
        }

        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->float('price_min'));
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->float('price_max'));
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::orderBy('display_order')->get();

        return view('pages.products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        abort_if($product->status !== 'active', 404);

        $product->load([
            'category',
            'reviews' => fn ($query) => $query->where('is_visible', true)->latest(),
        ]);

        $related = Product::active()
            ->where('category_id', $product->category_id)
            ->whereNot('id', $product->id)
            ->take(4)
            ->get();

        return view('pages.products.show', compact('product', 'related'));
    }
}
