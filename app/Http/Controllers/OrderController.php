<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Snap;
use Midtrans\Config as MidtransConfig;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::query()
            ->with('items')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $this->authorizeOrder($order);

        $order->load(['items', 'address']);

        return view('orders.show', compact('order'));
    }

    public function cancel(Request $request, Order $order)
    {
        $this->authorizeOrder($order);

        if (!$order->is_cancellable) {
            return back()->with('error', 'Order tidak bisa dibatalkan.');
        }

        $order->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);

        return back()->with('success', 'Order berhasil dibatalkan.');
    }

    public function pay(Request $request, Order $order)
    {
        $this->authorizeOrder($order);

        if (!$order->is_payable) {
            return response()->json(['error' => 'Order tidak bisa dibayar lagi.'], 422);
        }

        $order->loadMissing('items');

        $nextAttempt = (int) $order->payment_attempt + 1;
        $midtransOrderId = $order->order_number . '-R' . $nextAttempt;

        $order->update([
            'payment_attempt' => $nextAttempt,
            'midtrans_order_id' => $midtransOrderId,
        ]);

        MidtransConfig::$serverKey = config('services.midtrans.serverKey');
        MidtransConfig::$isProduction = (bool) config('services.midtrans.isProduction');
        MidtransConfig::$isSanitized = (bool) config('services.midtrans.isSanitized');
        MidtransConfig::$is3ds = (bool) config('services.midtrans.is3ds');

        $params = [
            'transaction_details' => [
                'order_id' => $order->midtrans_order_id,
                'gross_amount' => (int) $order->total_amount,
            ],
            'item_details' => $order->items->map(function ($item) {
                return [
                    'id' => (string) ($item->product_variant_id ?? $item->id),
                    'price' => (int) $item->price,
                    'quantity' => (int) $item->qty,
                    'name' => $item->product_name,
                ];
            })->values()->all(),
        ];

        $snapToken = Snap::getSnapToken($params);

        $order->update([
            'snap_token' => $snapToken,
            'status' => 'pending',
        ]);

        return response()->json([
            'snap_token' => $snapToken,
            'order_url' => route('orders.show', $order),
        ]);
    }

    private function authorizeOrder(Order $order): void
    {
        abort_unless($order->user_id === Auth::id(), 403);
    }
}
