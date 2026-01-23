<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::query()
            ->orderBy('name')
            ->get();

        $selectedCategorySlugs = collect($request->input('categories', []))
            ->filter(fn ($slug) => is_string($slug) && $slug !== '')
            ->values();

        // Backward-compatible with single "category" query param.
        if ($selectedCategorySlugs->isEmpty() && $request->filled('category')) {
            $selectedCategorySlugs = collect([(string) $request->category]);
        }

        $minPrice = $request->filled('min_price') ? (int) $request->min_price : null;
        $maxPrice = $request->filled('max_price') ? (int) $request->max_price : null;

        $sort = (string) $request->input('sort', 'default');

        if (!is_null($minPrice) && !is_null($maxPrice) && $minPrice > $maxPrice) {
            [$minPrice, $maxPrice] = [$maxPrice, $minPrice];
        }

        $productsQuery = Product::query()
            ->with(['category', 'images', 'variants'])
            ->withMin('variants', 'price')
            ->when($selectedCategorySlugs->isNotEmpty(), function ($query) use ($selectedCategorySlugs) {
                $query->whereHas('category', function ($q) use ($selectedCategorySlugs) {
                    $q->whereIn('slug', $selectedCategorySlugs->all());
                });
            })
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->q . '%');
            })
            ->when(!is_null($minPrice) || !is_null($maxPrice), function ($query) use ($minPrice, $maxPrice) {
                $query->whereHas('variants', function ($q) use ($minPrice, $maxPrice) {
                    if (!is_null($minPrice)) {
                        $q->where('price', '>=', $minPrice);
                    }
                    if (!is_null($maxPrice)) {
                        $q->where('price', '<=', $maxPrice);
                    }
                });
            });

        // Sorting
        $productsQuery = match ($sort) {
            'price_desc' => $productsQuery
                ->orderByRaw('variants_min_price is null asc')
                ->orderBy('variants_min_price', 'desc'),
            'price_asc' => $productsQuery
                ->orderByRaw('variants_min_price is null asc')
                ->orderBy('variants_min_price', 'asc'),
            'name_asc' => $productsQuery->orderBy('name', 'asc'),
            'name_desc' => $productsQuery->orderBy('name', 'desc'),
            default => $productsQuery->latest(),
        };

        $products = $productsQuery
            ->paginate(12)
            ->withQueryString();

        $activeCategories = $selectedCategorySlugs->isNotEmpty()
            ? $categories->whereIn('slug', $selectedCategorySlugs->all())->values()
            : collect();

        $activeCategory = $activeCategories->count() === 1
            ? $activeCategories->first()
            : null;

        $selectedCategorySlugsArray = $selectedCategorySlugs->all();

        $wishlistProductIds = Auth::check()
            ? DB::table('wishlists')->where('user_id', Auth::id())->pluck('product_id')->all()
            : [];

        return view('shop.index', compact(
            'products',
            'categories',
            'activeCategory',
            'activeCategories',
            'selectedCategorySlugsArray',
            'minPrice',
            'maxPrice',
            'sort',
            'wishlistProductIds'
        ));
    }
}
