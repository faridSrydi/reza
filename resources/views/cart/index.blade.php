@extends('layouts.app')

@section('content')
    <style>
        .glossy-pink {
            background: linear-gradient(180deg, #ff5e84 0%, #f42559 100%);
            box-shadow: inset 0 2px 4px rgba(255, 255, 255, 0.4), 0 4px 12px rgba(244, 37, 89, 0.3);
        }

        .candy-stripe {
            background-color: #ffffff;
            background-image: repeating-linear-gradient(45deg, #fffcfd, #fffcfd 10px, #fff1f4 10px, #fff1f4 20px);
        }

        .bubbly-border {
            border: 3px solid #f42559;
        }
    </style>
    <main class="flex-1 max-w-[1280px] mx-auto w-full px-6 py-8">
        <div class="flex items-center gap-2 mb-6">
            <a class="text-primary/60 text-sm font-semibold hover:text-primary transition-colors"
                href="{{ route('home') }}">Home</a>
            <span class="material-symbols-outlined crumb-heart text-[12px] text-primary">favorite</span>
            <span class="text-primary text-sm font-extrabold">Your Sweet Cart</span>
        </div>

        <div class="flex items-center gap-3 mb-8">
            <h1 class="text-3xl font-extrabold text-[#181113] dark:text-white">Your Shopping Cart</h1>
            <span class="text-primary/50 text-xl font-bold">({{ collect($cart)->sum('qty') }} items)</span>
            <span class="material-symbols-outlined text-primary animate-pulse">favorite</span>
        </div>

        <div class="flex flex-col lg:flex-row gap-10">
            <div class="flex-1 space-y-6">
                @forelse ($cart as $item)
                    <div
                        class="bubbly-border bg-white dark:bg-[#2d1a1e] rounded-xl p-6 shadow-xl flex flex-col sm:flex-row gap-6 items-center">
                        {{-- Product Image --}}
                        <div class="w-32 h-32 bg-center bg-no-repeat bg-cover rounded-xl shrink-0"
                            style='background-image: url("{{ $item['image'] ? asset('storage/' . $item['image']) : 'https://lh3.googleusercontent.com/aida-public/AB6AXuBYE3_laJfR0Z7-ogZu_ZEV9oon6E7ikAKkPb97Ij5f4BWlw171zeoh9iRVpr2n5MCD7FX7Da55l8_fcUsbsnllSroBxlLggDnIwr6dhp2g7SkPuUFdSQHrIBN_PhaRCBLgMewCZcX_1dBb7E_tnZ59F7eXWU4fMK65KaNulooM6dhuXmnrEgsFTYPr0UvVjZjHyq3AKF4JAd6VRy_UACvMOrjDWvBDW8bIh43DOr9IVxpfVjxWDBc9IQfc5frVh0yduPfohGhWzLI' }}");'>
                        </div>

                        <div class="flex flex-col flex-1 gap-2 w-full">
                            <div class="flex justify-between items-start">
                                <div>
                                    <span class="text-primary text-xs font-bold uppercase tracking-widest">Sweet
                                        Choice</span>
                                    <h3 class="text-xl font-extrabold text-[#181113] dark:text-white uppercase">
                                        {{ $item['product_name'] }}</h3>
                                    <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Variant ID:
                                        {{ $item['variant_id'] }}</p>
                                </div>
                                <span class="text-2xl font-extrabold text-primary">Rp
                                    {{ number_format($item['price']) }}</span>
                            </div>

                            <div class="flex items-center justify-between mt-4">
                                <form action="{{ route('cart.update') }}" method="POST"
                                    class="flex items-center gap-3 bg-primary/5 p-2 rounded-full">
                                    @csrf
                                    <input type="hidden" name="variant_id" value="{{ $item['variant_id'] }}">

                                    {{-- Decrease Qty --}}
                                    <button name="qty" value="{{ $item['qty'] - 1 }}"
                                        class="w-8 h-8 rounded-full bg-white shadow-sm border border-primary/20 text-primary font-black hover:scale-110 transition-transform active:scale-90 flex items-center justify-center">
                                        <span class="material-symbols-outlined text-sm">remove</span>
                                    </button>

                                    <span
                                        class="text-lg font-bold text-[#181113] dark:text-white px-2">{{ $item['qty'] }}</span>

                                    {{-- Increase Qty --}}
                                    <button name="qty" value="{{ $item['qty'] + 1 }}"
                                        class="w-8 h-8 rounded-full bg-primary text-white shadow-sm font-black hover:scale-110 transition-transform active:scale-90 flex items-center justify-center">
                                        <span class="material-symbols-outlined text-sm">add</span>
                                    </button>
                                </form>

                                {{-- Remove Button --}}
                                <form action="{{ route('cart.remove', $item['variant_id']) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="flex items-center gap-1 text-gray-400 hover:text-red-500 transition-colors font-bold text-sm">
                                        <span class="material-symbols-outlined text-lg">delete</span>
                                        Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-20 bg-primary/5 rounded-3xl border-2 border-dashed border-primary/20">
                        <span class="material-symbols-outlined text-6xl text-primary/30 mb-4">shopping_basket</span>
                        <p class="text-gray-500 font-bold uppercase tracking-widest">Your cart is feeling a bit empty...</p>
                        <a href="{{ route('home') }}"
                            class="inline-block mt-6 bg-primary text-white px-10 py-4 rounded-full font-black hover:scale-105 transition-transform">START
                            SHOPPING</a>
                    </div>
                @endforelse

                @if (count($cart) > 0)
                    <a class="flex items-center justify-center gap-2 mt-8 text-primary font-black hover:underline group"
                        href="{{ route('home') }}">
                        <span
                            class="material-symbols-outlined group-hover:-translate-x-1 transition-transform">arrow_back</span>
                        Back to Candy Shop
                    </a>
                @endif
            </div>

            <div class="w-full lg:w-96">
                <div
                    class="candy-stripe dark:candy-stripe dark:invert-[0.05] rounded-xl bubbly-border shadow-2xl p-8 flex flex-col gap-6 sticky top-28">
                    <div class="flex items-center gap-2 border-b-2 border-dashed border-primary/20 pb-4">
                        <span class="material-symbols-outlined text-primary text-3xl">shopping_cart_checkout</span>
                        <h2 class="text-2xl font-black text-[#181113]">Treat Summary</h2>
                    </div>

                    {{-- Address Selector --}}
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-primary">Shipping To:</label>
                        <div class="relative">
                            <select id="addressSelector"
                                class="w-full appearance-none bg-white/50 border-2 border-primary/10 rounded-xl px-4 py-3 text-sm font-bold focus:ring-primary focus:border-primary outline-none">
                                <option value="">-- SELECT ADDRESS --</option>
                                @foreach ($addresses as $addr)
                                    <option value="{{ $addr->id }}">{{ $addr->name }} ({{ $addr->city }})
                                    </option>
                                @endforeach
                            </select>
                            <span
                                class="material-symbols-outlined absolute right-3 top-3 text-primary pointer-events-none">expand_more</span>
                        </div>
                        <div class="flex justify-end">
                            @php
                                $routeAdd = auth()->user()->hasRole('admin')
                                    ? route('admin.addresses.create')
                                    : route('user.addresses.create');
                            @endphp
                            <a href="{{ $routeAdd }}" class="text-[10px] font-black text-primary underline">+ NEW
                                ADDRESS</a>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex justify-between items-center text-[#181113] font-semibold">
                            <span>Items Total</span>
                            <span>Rp {{ number_format(collect($cart)->sum(fn($i) => $i['price'] * $i['qty'])) }}</span>
                        </div>
                        <div class="flex justify-between items-center text-primary font-bold">
                            <span>Delivery</span>
                            <span class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">local_shipping</span> FREE
                            </span>
                        </div>
                    </div>

                    <div class="border-t-2 border-dashed border-primary/20 pt-6">
                        <div class="flex justify-between items-end">
                            <span class="text-lg font-bold text-[#181113]">Total Price</span>
                            <div class="flex flex-col items-end">
                                <div class="flex items-center gap-1 text-primary">
                                    <span class="material-symbols-outlined text-xs">favorite</span>
                                    <span class="text-3xl font-black tracking-tight">
                                        Rp {{ number_format(collect($cart)->sum(fn($i) => $i['price'] * $i['qty'])) }}
                                    </span>
                                    <span class="material-symbols-outlined text-xs">favorite</span>
                                </div>
                                <span class="text-[10px] font-bold text-primary uppercase">Tax Included</span>
                            </div>
                        </div>
                    </div>

                    <button id="payButton" type="button" {{ empty($cart) ? 'disabled' : '' }}
                        class="glossy-pink w-full py-5 rounded-full text-white text-xl font-black tracking-wide flex items-center justify-center gap-3 hover:scale-[1.02] transition-transform active:scale-95 group shadow-lg disabled:opacity-50">
                        <span
                            class="material-symbols-outlined text-3xl group-hover:rotate-45 transition-transform">icecream</span>
                        PROCEED TO CHECKOUT
                    </button>

                    <div class="flex flex-col items-center gap-2 text-primary/60 font-bold text-xs text-center">
                        <div class="flex items-center gap-4">
                            <span class="material-symbols-outlined">verified_user</span>
                            <span>Sweet & Secure Payment</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-20">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-black text-[#181113] dark:text-white">You Might Also Crave...</h2>
                <a class="text-primary font-bold text-sm" href="{{ route('shop.index') }}">View all snacks →</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                @forelse (($recommendedProducts ?? collect()) as $p)
                    @php
                        $img = $p->images->first();
                        $minPrice = $p->variants_min_price ?? $p->variants?->min('price');
                    @endphp

                    <a href="{{ route('product.show', $p->slug) }}"
                        class="group bg-white dark:bg-[#2d1a1e] rounded-xl p-4 shadow-md hover:shadow-xl transition-all border-b-4 border-primary/20 hover:border-primary">
                        <div class="aspect-square bg-center bg-no-repeat bg-cover rounded-xl mb-4 group-hover:scale-105 transition-transform"
                            @if ($img)
                                style='background-image: url("{{ asset('storage/' . ltrim($img->image, '/')) }}")'
                            @else
                                style='background-image: radial-gradient(circle at top, rgba(244,37,89,0.25), rgba(255,143,177,0.08)), linear-gradient(135deg, rgba(244,37,89,0.12), rgba(255,255,255,0.0))'
                            @endif
                        >
                        </div>

                        <h4 class="font-bold text-[#181113] dark:text-white mb-1 line-clamp-2">{{ $p->name }}</h4>

                        <div class="flex justify-between items-center">
                            <span class="text-primary font-black">
                                @if (is_null($minPrice))
                                    —
                                @else
                                    Rp {{ number_format($minPrice, 0, ',', '.') }}
                                @endif
                            </span>
                            <span
                                class="bg-primary/10 text-primary w-8 h-8 rounded-full flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-sm">open_in_new</span>
                            </span>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center text-gray-500 font-bold">
                        Tambahkan produk dulu untuk melihat rekomendasi sesuai kategori.
                    </div>
                @endforelse
            </div>
        </div>
    </main>

    {{-- MIDTRANS SNAP JS --}}
    @php
        $snapJsUrl = config('services.midtrans.isProduction')
            ? 'https://app.midtrans.com/snap/snap.js'
            : 'https://app.sandbox.midtrans.com/snap/snap.js';
    @endphp
    <script src="{{ $snapJsUrl }}" data-client-key="{{ config('services.midtrans.clientKey') }}"></script>

    <script>
        document.getElementById('payButton')?.addEventListener('click', function(e) {
            e.preventDefault();
            const addressId = document.getElementById('addressSelector').value;

            if (!addressId) {
                (window.__showToast || window.showToast || function(m){ console.warn(m); })('Please select the shipping address first.', 'error');
                return;
            }

            const btn = this;
            const originalText = btn.innerHTML;
            btn.innerHTML =
                `<span class="animate-spin material-symbols-outlined">progress_activity</span> PROCESSING...`;
            btn.disabled = true;

            fetch("{{ route('checkout.store') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json",
                        "Accept": "application/json"
                    },
                    body: JSON.stringify({
                        address_id: addressId
                    })
                })
                .then(async res => {
                    const data = await res.json();
                    if (!res.ok) throw new Error(data.error || 'Server Error');
                    return data;
                })
                .then(data => {
                    snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            window.location.href = data.order_url;
                        },
                        onPending: function(result) {
                            window.location.href = data.order_url;
                        },
                        onError: function(result) {
                            window.location.href = data.order_url;
                        },
                        onClose: function() {
                            window.location.href = data.order_url;
                        }
                    });
                })
                .catch(err => {
                    (window.__showToast || window.showToast || function(m){ console.warn(m); })(err.message || 'Terjadi kesalahan.', 'error');
                    resetButton();
                });

            function resetButton() {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        });
    </script>
@endsection
