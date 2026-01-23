@extends('layouts.admin')

@section('title', 'Order ' . $order->order_number)

@section('content')
    <main class="flex-1 w-full px-6 py-8">
        <div class="flex items-center gap-2 mb-6">
            <a class="text-primary/60 text-sm font-semibold hover:text-primary" href="{{ route('admin.orders.index') }}">Orders</a>
            <span class="material-symbols-outlined crumb-heart text-[12px] text-primary">favorite</span>
            <span class="text-primary text-sm font-bold">{{ $order->order_number }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white rounded-3xl border-2 border-primary/10 overflow-hidden">
                <div class="p-6 border-b border-primary/10">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-black text-[#181113]">Order Detail</h1>
                            <p class="text-primary/60 font-semibold">Customer: {{ $order->user?->name ?? '—' }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-widest
                            @if ($order->status === 'paid') bg-green-100 text-green-700
                            @elseif ($order->status === 'cancelled') bg-zinc-100 text-zinc-700
                            @elseif ($order->status === 'failed') bg-red-100 text-red-700
                            @else bg-primary/10 text-primary @endif">
                            {{ $order->status }}
                        </span>
                    </div>
                </div>

                <div class="p-6 space-y-4">
                    @foreach ($order->items as $item)
                        <div class="flex items-center justify-between gap-4 border-2 border-primary/10 rounded-2xl p-4">
                            <div>
                                <div class="font-black text-[#181113]">{{ $item->product_name }}</div>
                                <div class="text-xs font-bold text-primary/60 uppercase tracking-widest">Qty: {{ $item->qty }}</div>
                            </div>
                            <div class="text-right">
                                <div class="text-primary font-black">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                                <div class="text-xs font-bold text-primary/60 uppercase tracking-widest">Subtotal: Rp {{ number_format($item->price * $item->qty, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-3xl border-2 border-primary/10 p-6 h-fit">
                <div class="space-y-4">
                    <div>
                        <div class="text-xs font-bold text-primary/60 uppercase tracking-widest">Total</div>
                        <div class="text-3xl font-black text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</div>
                    </div>

                    <div class="border-t border-primary/10 pt-4">
                        <div class="text-xs font-bold text-primary/60 uppercase tracking-widest">Shipping Address</div>
                        <div class="text-sm font-bold text-[#181113]">{{ $order->address?->name ?? '—' }}</div>
                        <div class="text-sm text-[#181113]/70">{{ $order->address?->address ?? '' }}{{ $order->address?->city ? ', ' . $order->address->city : '' }}</div>
                    </div>

                    <div class="border-t border-primary/10 pt-4">
                        <div class="text-xs font-bold text-primary/60 uppercase tracking-widest">Midtrans</div>
                        <div class="text-sm font-bold text-[#181113]">Order ID: {{ $order->midtrans_order_id }}</div>
                        <div class="text-sm text-[#181113]/70">Status: {{ $order->midtrans_transaction_status ?? '—' }}</div>
                        <div class="text-sm text-[#181113]/70">Payment: {{ $order->midtrans_payment_type ?? '—' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
