<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * HOME PAGE
     * Tampilkan semua product + filter category
     */
    public function index(Request $request)
    {
        $categories = Category::all();

        $products = Product::with(['category', 'images', 'variants'])
            ->when($request->category, function ($query) use ($request) {
                $query->whereHas('category', function ($q) use ($request) {
                    $q->where('slug', $request->category);
                });
            })
            ->latest()
            ->paginate(12);

        return view('home.index', compact('products', 'categories'));
    }

    /**
     * DETAIL PRODUCT
     */
    public function show($slug)
    {
        $product = Product::with(['category', 'images', 'variants'])
            ->where('slug', $slug)
            ->firstOrFail();

        return view('home.show', compact('product'));
    }
}

