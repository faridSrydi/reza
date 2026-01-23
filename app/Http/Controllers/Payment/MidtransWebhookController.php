<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MidtransWebhookController extends Controller
{
    public function notify(Request $request)
    {
        $payload = $request->all();

        $orderId = (string) ($payload['order_id'] ?? '');
        $statusCode = (string) ($payload['status_code'] ?? '');
        $grossAmount = (string) ($payload['gross_amount'] ?? '');
        $signatureKey = (string) ($payload['signature_key'] ?? '');

        $serverKey = (string) config('services.midtrans.serverKey');

        if ($orderId === '' || $serverKey === '') {
            return response()->json(['error' => 'Invalid payload'], 400);
        }

        $expected = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
        if (!hash_equals($expected, $signatureKey)) {
            return response()->json(['error' => 'Invalid signature'], 401);
        }

        $order = Order::query()->where('midtrans_order_id', $orderId)->first();

        if (!$order && str_contains($orderId, '-R')) {
            $base = Str::before($orderId, '-R');
            $order = Order::query()->where('order_number', $base)->first();
        }

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $transactionStatus = (string) ($payload['transaction_status'] ?? '');
        $paymentType = (string) ($payload['payment_type'] ?? '');
        $fraudStatus = (string) ($payload['fraud_status'] ?? '');

        $updates = [
            'midtrans_transaction_status' => $transactionStatus ?: null,
            'midtrans_payment_type' => $paymentType ?: null,
            'midtrans_fraud_status' => $fraudStatus ?: null,
        ];

        switch ($transactionStatus) {
            case 'capture':
            case 'settlement':
                $updates['status'] = 'paid';
                $updates['paid_at'] = now();
                break;
            case 'pending':
                $updates['status'] = 'pending';
                break;
            case 'cancel':
                $updates['status'] = 'cancelled';
                $updates['cancelled_at'] = now();
                break;
            case 'expire':
            case 'deny':
            case 'failure':
                $updates['status'] = 'failed';
                break;
            default:
                // keep existing
                break;
        }

        $order->update($updates);

        return response()->json(['ok' => true]);
    }
}
