<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\RecycleRequest;
use App\Models\Review;

class HomeController extends Controller
{
    public function __invoke()
    {
        $featuredProducts = Product::with('category')->active()->where('is_featured', true)->take(8)->get();
        $categories = Category::orderBy('display_order')->take(6)->get();
        $latestRequests = RecycleRequest::latest()->with('user')->take(5)->get();
        $reviews = Review::with(['user', 'product'])->where('is_visible', true)->latest()->take(4)->get();

        $beforeAfter = [
            'https://images.unsplash.com/photo-1449247709967-d4461a6a6103?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1501045661006-fcebe0257c3f?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1470240731273-7821a6eeb6bd?auto=format&fit=crop&w=800&q=80',
        ];

        return view('pages.home', compact('featuredProducts', 'categories', 'latestRequests', 'reviews', 'beforeAfter'));
    }
}
