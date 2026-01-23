<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        $products = $request->user()
            ->wishlistProducts()
            ->with(['category', 'images', 'variants'])
            ->withMin('variants', 'price')
            ->orderByPivot('created_at', 'desc')
            ->paginate(12);

        return view('wishlist.index', compact('products'));
    }

    public function toggle(Request $request, Product $product)
    {
        $user = $request->user();

        $exists = $user->wishlistProducts()
            ->where('products.id', $product->id)
            ->exists();

        if ($exists) {
            $user->wishlistProducts()->detach($product->id);
            $inWishlist = false;
        } else {
            $user->wishlistProducts()->attach($product->id);
            $inWishlist = true;
        }

        if ($request->expectsJson()) {
            return response()->json([
                'in_wishlist' => $inWishlist,
            ]);
        }

        return back();
    }

    public function destroy(Request $request, Product $product)
    {
        $request->user()->wishlistProducts()->detach($product->id);

        return back()->with('success', 'Removed from wishlist.');
    }
}
