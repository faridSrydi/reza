<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $products = collect();
        $orders = collect();
        $users = collect();

        if ($q !== '') {
            $products = Product::query()
                ->with(['category', 'images'])
                ->where(function ($query) use ($q) {
                    $query
                        ->where('name', 'like', "%{$q}%")
                        ->orWhere('slug', 'like', "%{$q}%");
                })
                ->latest()
                ->take(10)
                ->get();

            $orders = Order::query()
                ->with('user')
                ->where(function ($query) use ($q) {
                    $query
                        ->where('order_number', 'like', "%{$q}%")
                        ->orWhere('midtrans_order_id', 'like', "%{$q}%");
                })
                ->latest()
                ->take(10)
                ->get();

            $users = User::query()
                ->where(function ($query) use ($q) {
                    $query
                        ->where('name', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%");
                })
                ->latest()
                ->take(10)
                ->get();
        }

        return view('admin.search.index', [
            'q' => $q,
            'products' => $products,
            'orders' => $orders,
            'users' => $users,
        ]);
    }

    public function suggest(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        if ($q === '') {
            return response()->json([
                'q' => $q,
                'products' => [],
                'orders' => [],
                'users' => [],
            ]);
        }

        $products = Product::query()
            ->with(['category', 'images'])
            ->where(function ($query) use ($q) {
                $query
                    ->where('name', 'like', "%{$q}%")
                    ->orWhere('slug', 'like', "%{$q}%");
            })
            ->latest()
            ->take(6)
            ->get()
            ->map(function (Product $p) {
                $img = $p->images->first();
                return [
                    'id' => $p->id,
                    'name' => $p->name,
                    'category' => $p->category?->name,
                    'image' => $img ? asset('storage/' . ltrim($img->image, '/')) : null,
                    'url' => route('admin.products.show', $p),
                ];
            })
            ->values();

        $orders = Order::query()
            ->with('user')
            ->where(function ($query) use ($q) {
                $query
                    ->where('order_number', 'like', "%{$q}%")
                    ->orWhere('midtrans_order_id', 'like', "%{$q}%");
            })
            ->latest()
            ->take(6)
            ->get()
            ->map(function (Order $o) {
                return [
                    'id' => $o->id,
                    'order_number' => $o->order_number,
                    'customer' => $o->user?->name,
                    'status' => $o->status,
                    'total_amount' => (float) ($o->total_amount ?? 0),
                    'url' => route('admin.orders.show', $o),
                ];
            })
            ->values();

        $users = User::query()
            ->where(function ($query) use ($q) {
                $query
                    ->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            })
            ->latest()
            ->take(6)
            ->get()
            ->map(function (User $u) {
                return [
                    'id' => $u->id,
                    'name' => $u->name,
                    'email' => $u->email,
                    'initials' => Str::upper(Str::of($u->name ?? 'U')->trim()->substr(0, 2)),
                ];
            })
            ->values();

        return response()->json([
            'q' => $q,
            'products' => $products,
            'orders' => $orders,
            'users' => $users,
        ]);
    }
}
