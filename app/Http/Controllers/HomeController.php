<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * HOME PAGE
     * Tampilkan semua product + filter category
     */
    public function index(Request $request)
    {
        $categories = Category::query()
            ->orderBy('name')
            ->get();

        $wishlistProductIds = Auth::check()
            ? DB::table('wishlists')->where('user_id', Auth::id())->pluck('product_id')->all()
            : [];

        $newestProducts = Product::query()
            ->with(['category', 'images'])
            ->withMin('variants', 'price')
            ->latest()
            ->take(8)
            ->get();

        $products = Product::with(['category', 'images', 'variants'])
            ->when($request->category, function ($query) use ($request) {
                $query->whereHas('category', function ($q) use ($request) {
                    $q->where('slug', $request->category);
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('home.index', compact('products', 'categories', 'newestProducts', 'wishlistProductIds'));
    }

    /**
     * DETAIL PRODUCT
     */
    public function show($slug)
    {
        $product = Product::with(['category', 'images', 'variants'])
            ->where('slug', $slug)
            ->firstOrFail();

        $wishlistProductIds = Auth::check()
            ? DB::table('wishlists')->where('user_id', Auth::id())->pluck('product_id')->all()
            : [];

        $relatedProductsQuery = Product::query()
            ->with(['category', 'images'])
            ->withMin('variants', 'price')
            ->whereKeyNot($product->id);

        if (!is_null($product->category_id)) {
            $relatedProductsQuery->where('category_id', $product->category_id);
        }

        $relatedProducts = $relatedProductsQuery
            ->inRandomOrder()
            ->take(4)
            ->get();

        $wishlisted = Auth::check()
            ? DB::table('wishlists')
                ->where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->exists()
            : false;

        return view('home.show', compact('product', 'wishlisted', 'relatedProducts', 'wishlistProductIds'));
    }
}

