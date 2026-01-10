<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Midtrans\Snap;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;


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


        return view('cart.index', compact('cart', 'addresses'));
    }


/**
 * ADD TO CART
 */
public function addToCart(Request $request)
{
    // Validasi input
    $request->validate([
        'variant_id'   => 'required',
        'product_name' => 'required',
        'price'        => 'required|numeric',
        'qty'          => 'required|integer|min:1',
    ]);


    $cart = session('cart', []);


    // Jika produk sudah ada di cart, tambahkan qty nya saja
    if (isset($cart[$request->variant_id])) {
        $cart[$request->variant_id]['qty'] += $request->qty;
    } else {
        // Jika belum ada, masukkan data baru
        $cart[$request->variant_id] = [
            'variant_id'   => $request->variant_id,
            'product_name' => $request->product_name,
            'price'        => $request->price,
            'qty'          => $request->qty,
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


        $address = Address::findOrFail($request->address_id);
        $total = collect($cart)->sum(fn ($i) => $i['price'] * $i['qty']);


        // Parameter Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => 'ORDER-' . time() . '-' . Auth::id(),
                'gross_amount' => (int) $total,
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
                    'country_code' => 'IDN'
                ],
            ],
            // Item details (Opsional, agar muncul rincian di Midtrans)
            'item_details' => collect($cart)->map(function($item) {
                return [
                    'id' => $item['variant_id'],
                    'price' => (int) $item['price'],
                    'quantity' => (int) $item['qty'],
                    'name' => $item['product_name']
                ];
            })->values()->all(),
        ];


        try {
            $snapToken = Snap::getSnapToken($params);
            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
