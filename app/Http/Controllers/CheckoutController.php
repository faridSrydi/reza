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
        $addresses = Address::where('user_id', Auth::id())->get();

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
        // 1. Validasi input
        $request->validate([
            'variant_id'   => 'required',
            'product_name' => 'required',
            'price'        => 'required|numeric',
            'qty'          => 'required|integer|min:1',
        ]);

        $cart = session('cart', []);

        // 2. AMBIL GAMBAR DARI DATABASE
        // Start dari Variant -> Product -> Images
        $variant = ProductVariant::with('product.images')->find($request->variant_id);

        $productImage = null;

        // Cek apakah rantai relasinya lengkap & ada gambarnya
        if ($variant && $variant->product && $variant->product->images->isNotEmpty()) {
            // Ambil path gambar pertama
            $productImage = $variant->product->images->first()->image;
        }

        // 3. MASUKKAN KE KERANJANG
        if (isset($cart[$request->variant_id])) {
            // Jika produk sudah ada, tambah qty DAN update gambar (biar gambar muncul)
            $cart[$request->variant_id]['qty'] += $request->qty;
            $cart[$request->variant_id]['image'] = $productImage;
        } else {
            // Jika belum ada, masukkan data baru BESERTA IMAGE
            $cart[$request->variant_id] = [
                'variant_id'   => $request->variant_id,
                'product_name' => $request->product_name,
                'price'        => $request->price,
                'qty'          => $request->qty,
                'image'        => $productImage // <--- KUNCI SUPAYA GAMBAR MUNCUL
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
        $cart = session('cart', []);

        if (isset($cart[$request->variant_id])) {
            $cart[$request->variant_id]['qty'] = max(1, $request->qty);
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
