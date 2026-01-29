<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config as MidtransConfig;
use App\Models\Address;
use App\Models\Product;
use App\Models\ProductVariant; // <--- PENTING: Jangan lupa ini!
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * CART / SHOW
     */
    public function index()
    {
        $cart = session('cart', []);
        // Ambil alamat milik user yang sedang login (baik admin/user biasa)
        $addresses = Auth::check()
            ? Address::where('user_id', Auth::id())->get()
            : collect();

        $recommendedProducts = collect();

        if (!empty($cart)) {
            $variantIds = collect($cart)
                ->pluck('variant_id')
                ->filter()
                ->unique()
                ->values();

            $variants = ProductVariant::query()
                ->with(['product.category'])
                ->whereIn('id', $variantIds)
                ->get();

            $categoryIds = $variants
                ->map(fn ($v) => $v->product?->category_id)
                ->filter()
                ->unique()
                ->values();

            $productIdsInCart = $variants
                ->map(fn ($v) => $v->product?->id)
                ->filter()
                ->unique()
                ->values();

            if ($categoryIds->isNotEmpty()) {
                $recommendedProducts = Product::query()
                    ->with(['category', 'images'])
                    ->withMin('variants', 'price')
                    ->whereIn('category_id', $categoryIds)
                    ->when($productIdsInCart->isNotEmpty(), fn ($q) => $q->whereNotIn('id', $productIdsInCart))
                    ->inRandomOrder()
                    ->take(4)
                    ->get();
            }
        }

        return view('cart.index', compact('cart', 'addresses', 'recommendedProducts'));
    }

    /**
     * ADD TO CART (INI BAGIAN YANG SUDAH DIPERBAIKI)
     */
    public function addToCart(Request $request)
    {
        $validated = $request->validate([
            'variant_id' => 'required|integer|exists:product_variants,id',
            'qty' => 'required|integer|min:1',
        ]);

        $cart = session('cart', []);

        // Ambil Variant + Product + Images, supaya nama/price/image konsisten (tidak dari request)
        $variant = ProductVariant::with('product.images')->findOrFail($validated['variant_id']);

        if ((int) $variant->stock <= 0) {
            return back()->with('error', 'Stok produk habis.');
        }

        $qtyToAdd = min((int) $validated['qty'], (int) $variant->stock);

        $productName = (string) ($variant->product?->name ?? 'Item');
        $price = (int) $variant->price;

        $productImage = $variant->product?->images?->first()?->image;

        if (isset($cart[$variant->id])) {
            $cart[$variant->id]['qty'] = min(
                (int) $variant->stock,
                (int) ($cart[$variant->id]['qty'] ?? 0) + $qtyToAdd
            );
            $cart[$variant->id]['image'] = $productImage;
            $cart[$variant->id]['price'] = $price;
            $cart[$variant->id]['product_name'] = $productName;
        } else {
            $cart[$variant->id] = [
                'variant_id' => $variant->id,
                'product_name' => $productName,
                'price' => $price,
                'qty' => $qtyToAdd,
                'image' => $productImage,
            ];
        }

        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambah ke keranjang!');
    }

    /**
     * UPDATE QTY (+ / -)
     */
    public function updateQty(Request $request)
    {
        $validated = $request->validate([
            'variant_id' => 'required|integer',
            'qty' => 'required|integer|min:1',
        ]);

        $cart = session('cart', []);

        if (isset($cart[$validated['variant_id']])) {
            $cart[$validated['variant_id']]['qty'] = (int) $validated['qty'];
        }

        session(['cart' => $cart]);

        return back();
    }

    /**
     * REMOVE ITEM
     */
    public function remove($variantId)
    {
        $cart = session('cart', []);
        unset($cart[$variantId]);

        session(['cart' => $cart]);

        return back();
    }

    /**
     * MIDTRANS CHECKOUT
     */
    public function store(Request $request)
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return response()->json(['error' => 'Keranjang kosong'], 400);
        }

        $request->validate([
            'address_id' => 'required|exists:addresses,id'
        ]);

        $address = Address::query()
            ->where('id', $request->address_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $total = (int) collect($cart)->sum(fn ($i) => (int) $i['price'] * (int) $i['qty']);

        try {
            $order = DB::transaction(function () use ($address, $cart, $total) {
                $orderNumber = 'ORD-' . now()->format('ymdHis') . '-' . Auth::id() . '-' . random_int(100, 999);

                $order = Order::create([
                    'user_id' => Auth::id(),
                    'address_id' => $address->id,
                    'order_number' => $orderNumber,
                    'midtrans_order_id' => $orderNumber,
                    'total_amount' => $total,
                    'status' => 'pending',
                    'payment_attempt' => 1,
                ]);

                foreach ($cart as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_variant_id' => $item['variant_id'] ?? null,
                        'product_name' => $item['product_name'] ?? 'Item',
                        'price' => (int) ($item['price'] ?? 0),
                        'qty' => (int) ($item['qty'] ?? 1),
                    ]);
                }

                return $order;
            });

            MidtransConfig::$serverKey = config('services.midtrans.serverKey');
            MidtransConfig::$isProduction = (bool) config('services.midtrans.isProduction');
            MidtransConfig::$isSanitized = (bool) config('services.midtrans.isSanitized');
            MidtransConfig::$is3ds = (bool) config('services.midtrans.is3ds');

            $params = [
                'transaction_details' => [
                    'order_id' => $order->midtrans_order_id,
                    'gross_amount' => (int) $order->total_amount,
                ],
                'customer_details' => [
                    'first_name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'phone' => $address->phone,
                    'shipping_address' => [
                        'first_name' => $address->name,
                        'phone' => $address->phone,
                        'address' => $address->address,
                        'city' => $address->city,
                        'postal_code' => $address->postal_code,
                        'country_code' => 'IDN',
                    ],
                ],
                'item_details' => collect($cart)
                    ->map(function ($item) {
                        return [
                            'id' => (string) ($item['variant_id'] ?? ''),
                            'price' => (int) ($item['price'] ?? 0),
                            'quantity' => (int) ($item['qty'] ?? 1),
                            'name' => (string) ($item['product_name'] ?? 'Item'),
                        ];
                    })
                    ->values()
                    ->all(),
            ];

            $snapToken = Snap::getSnapToken($params);

            $order->update([
                'snap_token' => $snapToken,
            ]);

            session()->forget('cart');

            return response()->json([
                'snap_token' => $snapToken,
                'order_url' => route('orders.show', $order),
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
