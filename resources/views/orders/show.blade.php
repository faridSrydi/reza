@extends('layouts.user')

@section('title', 'Order ' . $order->order_number)

@section('user_content')
    @php
        $statusBadge = match ($order->status) {
            'paid' => 'bg-green-100 text-green-700',
            'cancelled' => 'bg-zinc-100 text-zinc-700',
            'failed' => 'bg-red-100 text-red-700',
            default => 'bg-primary/10 text-primary',
        };
    @endphp

    <main class="w-full py-2 sm:py-4">
        <div class="flex items-center gap-2 mb-6">
            <a class="text-primary/60 text-sm font-semibold hover:text-primary" href="{{ route('home') }}">Home</a>
            <span class="material-symbols-outlined crumb-heart text-[12px] text-primary">favorite</span>
            <a class="text-primary/60 text-sm font-semibold hover:text-primary" href="{{ route('orders.index') }}">Orders</a>
            <span class="material-symbols-outlined crumb-heart text-[12px] text-primary">favorite</span>
            <span class="text-primary text-sm font-bold">{{ $order->order_number }}</span>
        </div>

        @if (session('success'))
            <div class="mb-6 bg-white border-2 border-primary/10 rounded-2xl p-4 text-primary font-bold">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-6 bg-white border-2 border-red-200 rounded-2xl p-4 text-red-600 font-bold">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white rounded-3xl border-2 border-primary/10 overflow-hidden">
                <div class="p-6 border-b border-primary/10">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h1 class="text-3xl font-extrabold text-primary">Order Detail</h1>
                            <p class="text-primary/60 font-semibold">{{ $order->order_number }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-widest {{ $statusBadge }}">
                            {{ $order->status }}
                        </span>
                    </div>
                </div>

                <div class="p-6">
                    <div class="space-y-4">
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
            </div>

            <div class="bg-white rounded-3xl border-2 border-primary/10 p-6 h-fit">
                <div class="space-y-4">
                    <div>
                        <div class="text-xs font-bold text-primary/60 uppercase tracking-widest">Total</div>
                        <div class="text-3xl font-black text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</div>
                    </div>

                    <div class="border-t border-primary/10 pt-4">
                        <div class="text-xs font-bold text-primary/60 uppercase tracking-widest">Shipping Address</div>
                        <div class="text-sm font-bold text-[#181113]">
                            {{ $order->address?->name ?? '—' }}
                        </div>
                        <div class="text-sm text-[#181113]/70">
                            {{ $order->address?->address ?? '' }}
                            {{ $order->address?->city ? ', ' . $order->address->city : '' }}
                        </div>
                    </div>

                    <div class="border-t border-primary/10 pt-4 space-y-3">
                        @if ($order->is_payable)
                            <button type="button" id="payNowButton"
                                class="w-full bg-primary text-white py-4 rounded-full font-black hover:scale-[1.02] transition-transform active:scale-95">
                                Pay with Midtrans
                            </button>
                        @endif

                        @if ($order->is_cancellable)
                            <form method="POST" action="{{ route('orders.cancel', $order) }}">
                                @csrf
                                <button type="submit"
                                    class="w-full bg-white border-2 border-primary/20 text-primary py-4 rounded-full font-black hover:bg-primary/5 transition-colors">
                                    Cancel Order
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('shop.index') }}"
                            class="block text-center w-full bg-primary/10 text-primary py-4 rounded-full font-black hover:bg-primary hover:text-white transition-colors">
                            Go to Shop
                        </a>
                    </div>

                    <div class="text-xs font-bold text-primary/50 uppercase tracking-widest">
                        Midtrans status: {{ $order->midtrans_transaction_status ?? '—' }}
                    </div>
                </div>
            </div>
        </div>

        {{-- MIDTRANS SNAP JS --}}
        @php
            $snapJsUrl = config('services.midtrans.isProduction')
                ? 'https://app.midtrans.com/snap/snap.js'
                : 'https://app.sandbox.midtrans.com/snap/snap.js';
        @endphp
        <script src="{{ $snapJsUrl }}" data-client-key="{{ config('services.midtrans.clientKey') }}"></script>

        <script>
            (function() {
                var payBtn = document.getElementById('payNowButton');
                if (!payBtn) return;

                payBtn.addEventListener('click', function() {
                    payBtn.disabled = true;
                    var original = payBtn.innerHTML;
                    payBtn.innerHTML = '<span class="material-symbols-outlined animate-spin">progress_activity</span> PROCESSING...';

                    fetch("{{ route('orders.pay', $order) }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                            'Accept': 'application/json'
                        }
                    }).then(async function(res) {
                        var data = await res.json();
                        if (!res.ok) throw new Error(data.error || 'Server Error');
                        return data;
                    }).then(function(data) {
                        snap.pay(data.snap_token, {
                            onSuccess: function() { window.location.href = data.order_url; },
                            onPending: function() { window.location.href = data.order_url; },
                            onError: function() { window.location.href = data.order_url; },
                            onClose: function() {
                                payBtn.disabled = false;
                                payBtn.innerHTML = original;
                            }
                        });
                    }).catch(function(err) {
                        (window.__showToast || window.showToast || function(m){ console.warn(m); })(err.message || 'Terjadi kesalahan.', 'error');
                        payBtn.disabled = false;
                        payBtn.innerHTML = original;
                    });
                });
            })();
        </script>
    </main>
@endsection
