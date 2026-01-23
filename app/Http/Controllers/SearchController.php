<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class SearchController extends Controller
{
    public function suggest(Request $request)
    {
        $query = trim((string) $request->input('q', ''));

        if ($query === '' || mb_strlen($query) < 2) {
            return response()->json([
                'query' => $query,
                'products' => [],
                'categories' => [],
            ]);
        }

        $products = Product::query()
            ->with([
                'category:id,name,slug',
                'images:id,product_id,image',
            ])
            ->where('name', 'like', '%' . $query . '%')
            ->orderBy('name')
            ->limit(8)
            ->get(['id', 'name', 'slug', 'category_id'])
            ->map(fn (Product $p) => [
                'name' => $p->name,
                'slug' => $p->slug,
                'url' => route('product.show', $p->slug),
                'category_name' => $p->category?->name,
                'image_url' => $p->images->first()
                    ? asset('storage/' . ltrim((string) $p->images->first()->image, '/'))
                    : null,
            ])
            ->values();

        $categoryColumns = Schema::hasColumn('categories', 'image')
            ? ['name', 'slug', 'image']
            : ['name', 'slug'];

        $categories = Category::query()
            ->where('name', 'like', '%' . $query . '%')
            ->orderBy('name')
            ->limit(6)
            ->get($categoryColumns)
            ->map(fn (Category $c) => [
                'name' => $c->name,
                'slug' => $c->slug,
                'url' => route('shop.index', ['category' => $c->slug]),
                'image_url' => !empty($c->image)
                    ? asset('storage/' . ltrim((string) $c->image, '/'))
                    : null,
            ])
            ->values();

        return response()->json([
            'query' => $query,
            'products' => $products,
            'categories' => $categories,
        ]);
    }
}
