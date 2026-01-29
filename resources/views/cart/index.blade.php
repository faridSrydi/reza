@extends('layouts.app')

@section('content')
    @php
        $cartItems = collect($cart ?? []);
        $itemsCount = (int) $cartItems->sum(fn ($i) => (int) ($i['qty'] ?? 0));
        $subtotal = (int) $cartItems->sum(fn ($i) => (int) ($i['price'] ?? 0) * (int) ($i['qty'] ?? 0));
    @endphp

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#ee2b8c",
                        "background-light": "#f8f6f7",
                        "background-dark": "#221019",
                    },
                    fontFamily: {
                        "display": ["Plus Jakarta Sans", "sans-serif"],
                        "serif": ["Playfair Display", "serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style type="text/tailwindcss">
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24;
        }

        body {
            font-family: "Plus Jakarta Sans", sans-serif;
        }

        .serif-text {
            font-family: "Playfair Display", serif;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
    <main class="flex-grow max-w-[1440px] mx-auto w-full px-6 lg:px-20 py-12">
        <div class="flex flex-col gap-4 mb-10">
            <h1 class="text-4xl font-bold serif-text">Shopping Bag</h1>
            <p class="text-gray-500 dark:text-gray-400">You have {{ $itemsCount }} item(s) in your bag</p>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <div class="lg:col-span-8 flex flex-col gap-8">
                @if(session('success'))
                    <div class="rounded-xl border border-[#f3e7ed] dark:border-[#3d2030] bg-white/70 dark:bg-[#1b0d14]/40 px-5 py-4 text-sm">
                        <span class="font-bold text-primary">{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="rounded-xl border border-[#f3e7ed] dark:border-[#3d2030] bg-white/70 dark:bg-[#1b0d14]/40 px-5 py-4 text-sm">
                        <span class="font-bold text-red-600">{{ session('error') }}</span>
                    </div>
                @endif

                @forelse($cartItems as $variantId => $item)
                    @php
                        $image = $item['image'] ?? null;
                        $imgSrc = $image
                            ? asset('storage/' . ltrim($image, '/'))
                            : ('https://ui-avatars.com/api/?name=' . urlencode((string) ($item['product_name'] ?? 'Item')) . '&background=f3e7ed&color=1b0d14');
                        $qty = (int) ($item['qty'] ?? 1);
                        $price = (int) ($item['price'] ?? 0);
                    @endphp

                    <div class="flex gap-6 pb-8 border-b border-[#f3e7ed] dark:border-[#3d2030]">
                        <div class="w-32 h-40 bg-[#f8f6f7] dark:bg-[#2d1622] rounded-xl overflow-hidden flex-shrink-0">
                            <img src="{{ $imgSrc }}" alt="{{ $item['product_name'] ?? 'Item' }}" class="w-full h-full object-cover" loading="lazy" />
                        </div>

                        <div class="flex flex-col justify-between flex-grow py-1">
                            <div class="flex justify-between items-start gap-4">
                                <div>
                                    <h3 class="text-lg font-bold">{{ $item['product_name'] ?? 'Item' }}</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 italic">Variant ID: {{ $variantId }}</p>
                                </div>
                                <form method="POST" action="{{ route('cart.remove', $variantId) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-primary transition-colors" aria-label="Remove">
                                        <span class="material-symbols-outlined">close</span>
                                    </button>
                                </form>
                            </div>

                            <div class="flex justify-between items-center">
                                <form method="POST" action="{{ route('cart.update') }}" class="flex items-center border border-[#f3e7ed] dark:border-[#3d2030] rounded-lg overflow-hidden">
                                    @csrf
                                    <input type="hidden" name="variant_id" value="{{ $variantId }}" />
                                    <button type="button" class="px-3 py-2 hover:bg-gray-100 dark:hover:bg-[#3d2030] transition-colors" data-qty-minus>
                                        <span class="material-symbols-outlined text-lg leading-none">remove</span>
                                    </button>
                                    <input
                                        name="qty"
                                        value="{{ $qty }}"
                                        min="1"
                                        type="number"
                                        class="w-16 text-center font-medium bg-transparent border-0 focus:ring-0"
                                        data-qty-input />
                                    <button type="button" class="px-3 py-2 hover:bg-gray-100 dark:hover:bg-[#3d2030] transition-colors" data-qty-plus>
                                        <span class="material-symbols-outlined text-lg leading-none">add</span>
                                    </button>
                                </form>
                                <p class="font-bold text-lg">Rp {{ number_format((float) $price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="rounded-2xl border border-[#f3e7ed] dark:border-[#3d2030] bg-white dark:bg-[#1b0d14] p-8 text-center">
                        <p class="font-bold text-primary">Keranjang masih kosong.</p>
                        <a href="{{ route('shop.index') }}" class="inline-flex mt-5 bg-primary text-white font-bold px-6 py-3 rounded-full">
                            Belanja Sekarang
                        </a>
                    </div>
                @endforelse

                @if($cartItems->isNotEmpty())
                    <div class="flex items-center gap-4 py-4 text-sm text-gray-500">
                        <span class="material-symbols-outlined text-primary">local_shipping</span>
                        <span>Checkout akan tersedia setelah login dan pilih alamat.</span>
                    </div>
                @endif
            </div>
            <div class="lg:col-span-4">
                <div
                    class="bg-white dark:bg-[#1b0d14] rounded-2xl p-8 border border-[#f3e7ed] dark:border-[#3d2030] sticky top-32">
                    <h2 class="text-2xl font-bold serif-text mb-6">Order Summary</h2>

                    @auth
                        @php
                            $addressCreateUrl = auth()->user()->hasRole('admin')
                                ? route('admin.addresses.create')
                                : (\Illuminate\Support\Facades\Route::has('addresses.create') ? route('addresses.create') : url('/addresses/create'));
                        @endphp

                        <div class="mb-6">
                            <p class="text-xs font-bold uppercase tracking-widest mb-3 text-gray-400">Shipping Address</p>

                            @if(($addresses ?? collect())->isNotEmpty())
                                <select
                                    id="addressSelect"
                                    class="w-full form-select h-12 border-[#e7cfdb] dark:border-[#3d2030] rounded-lg bg-transparent focus:ring-primary focus:border-primary text-sm">
                                    @foreach($addresses as $addr)
                                        <option value="{{ $addr->id }}">
                                            {{ $addr->name }} — {{ $addr->city }} ({{ $addr->postal_code }})
                                        </option>
                                    @endforeach
                                </select>

                                <a
                                    href="{{ $addressCreateUrl }}"
                                    class="inline-flex mt-3 text-sm font-bold text-primary hover:underline">
                                    + Tambah alamat
                                </a>
                            @else
                                <div class="rounded-lg border border-[#f3e7ed] dark:border-[#3d2030] p-4 text-sm text-gray-500">
                                    Belum ada alamat. Tambahkan alamat untuk checkout.
                                </div>
                                <a
                                    href="{{ $addressCreateUrl }}"
                                    class="inline-flex mt-3 bg-primary text-white font-bold px-4 py-2 rounded-lg text-sm">
                                    Tambah alamat
                                </a>
                            @endif
                        </div>
                    @endauth

                    <div class="flex flex-col gap-4 text-sm mb-6 pb-6 border-b border-[#f3e7ed] dark:border-[#3d2030]">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Subtotal</span>
                            <span class="font-bold">Rp {{ number_format((float) $subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Estimated Shipping</span>
                            <span class="font-bold">Rp 0</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Tax</span>
                            <span class="font-bold text-gray-400">Calculated at checkout</span>
                        </div>
                    </div>
                    <div class="mb-8">
                        <p class="text-xs font-bold uppercase tracking-widest mb-3 text-gray-400">Promo Code</p>
                        <div class="flex gap-2">
                            <input
                                class="flex-1 form-input h-12 border-[#e7cfdb] dark:border-[#3d2030] rounded-lg bg-transparent focus:ring-primary focus:border-primary text-sm"
                                placeholder="Enter code" type="text" />
                            <button
                                class="px-6 h-12 border border-[#1b0d14] dark:border-white rounded-lg text-sm font-bold hover:bg-[#1b0d14] hover:text-white dark:hover:bg-white dark:hover:text-[#1b0d14] transition-all">Apply</button>
                        </div>
                    </div>
                    <div class="flex justify-between items-center mb-8">
                        <span class="text-lg font-bold">Total</span>
                        <span class="text-2xl font-bold text-primary">Rp {{ number_format((float) $subtotal, 0, ',', '.') }}</span>
                    </div>

                    @if($cartItems->isEmpty())
                        <a href="{{ route('shop.index') }}"
                            class="w-full bg-primary text-white font-bold py-4 rounded-xl hover:opacity-90 transition-opacity flex items-center justify-center gap-2 mb-4">
                            Browse Products
                            <span class="material-symbols-outlined text-xl">arrow_forward</span>
                        </a>
                    @else
                        @auth
                            <button
                                id="checkoutButton"
                                type="button"
                                class="w-full bg-primary text-white font-bold py-4 rounded-xl hover:opacity-90 transition-opacity flex items-center justify-center gap-2 mb-4"
                                {{ (($addresses ?? collect())->isEmpty()) ? 'disabled' : '' }}>
                                Proceed to Checkout
                                <span class="material-symbols-outlined text-xl">arrow_forward</span>
                            </button>
                        @else
                            <a href="{{ route('login') }}"
                                class="w-full bg-primary text-white font-bold py-4 rounded-xl hover:opacity-90 transition-opacity flex items-center justify-center gap-2 mb-4">
                                Login untuk Checkout
                                <span class="material-symbols-outlined text-xl">arrow_forward</span>
                            </a>
                        @endauth
                    @endif
                    <div class="flex flex-col gap-4 mt-6">
                        <div class="flex items-center justify-center gap-4 grayscale opacity-40">
                            <img alt="Visa" class="h-4"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuC2Ri5fo9bBwWTFlxuXojUthe2NrTmdGtYVnOosd2258ig85fFXA5v_8v1c3_b4cBN8xm6EdYcuPjdLl3dHZsYJZJWZ_6mbs4Ua891wJ0SNqfmQPUW_jI7Tk1Ln-DmgmJ8KZjrwECZl2DB4yzFm16FPcF-AGt3IcbS2E_CclwizkqFK9HUGkOdWhNZr1ZlfpD7AhoTtsvhlQA1N188IC4zO30-UZ0lySejToxTxqnxb-wvj0uZmphuHffz-a3ujHU9-Aykf9WSkE8k" />
                            <img alt="Mastercard" class="h-6"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuDmba9Rr4lDh6rqHb-hkQl2Gc1Q7p9v6tYcG0U3wl5Em5rttMegw8ge-2IAhQBvL5XWBv--qKlNUnJSHozcbNFUv3RHKxAForOy5pzqKgC3W_yH00WXSevNdnBXLLyBhuKjvyKwmwW8aqmm_B4aNHtv4CgHsgRiH7n2AgPxSGR_jXerX4H3A5WoKkdXcthuGei65gIUs0NXmpHjdUS31i6pcifVc6v8VdE4i8n0jjJxwV-tiUNACM2lEGu_V0jRJzUhgRuPgSC3H1A" />
                            <img alt="PayPal" class="h-4"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuCBoGXmM-COmJqPzy9AB_UeTuwt3NAHrt14voDQOdkYKnCRCJdri5G23PXnBGxwZoniRNKWjmuPAVAB99Dm4p03DABhSAj9OKFnvBLC9fraZ-LDLQ87AxXJ0SpqySDB9oo49ANnCGLLFkC6XiB39SMmX5eriGxvXeugBtNgl7KP6UePHX-vffuHMi8wZEU8SOG9GtAZIwTVchYgKEdsBZGpFiKRJnHYAAbmewZ8UwDJWl3GVVMXmPoJKyI-7ZZZwRaHfOEHT-Goyfg" />
                        </div>
                        <p class="text-center text-[10px] text-gray-400 uppercase tracking-widest">Secure encrypted
                            checkout</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        (function () {
            document.querySelectorAll('form[action$="/cart/update"]').forEach(function (form) {
                var input = form.querySelector('[data-qty-input]');
                var minus = form.querySelector('[data-qty-minus]');
                var plus = form.querySelector('[data-qty-plus]');

                function submit() {
                    form.submit();
                }

                function setQty(nextQty) {
                    var v = Math.max(1, parseInt(nextQty || '1', 10));
                    if (input) input.value = String(v);
                }

                if (minus) minus.addEventListener('click', function () {
                    setQty((input && input.value) ? (parseInt(input.value, 10) - 1) : 1);
                    submit();
                });
                if (plus) plus.addEventListener('click', function () {
                    setQty((input && input.value) ? (parseInt(input.value, 10) + 1) : 2);
                    submit();
                });
                if (input) input.addEventListener('change', function () {
                    submit();
                });
            });
        })();
    </script>

    @auth
        @if($cartItems->isNotEmpty() && ($addresses ?? collect())->isNotEmpty())
            @php
                $snapJsUrl = config('services.midtrans.isProduction')
                    ? 'https://app.midtrans.com/snap/snap.js'
                    : 'https://app.sandbox.midtrans.com/snap/snap.js';
            @endphp
            <script src="{{ $snapJsUrl }}" data-client-key="{{ config('services.midtrans.clientKey') }}"></script>

            <script>
                (function () {
                    var btn = document.getElementById('checkoutButton');
                    var addressSelect = document.getElementById('addressSelect');
                    if (!btn) return;

                    btn.addEventListener('click', function () {
                        if (!addressSelect || !addressSelect.value) {
                            alert('Pilih alamat dulu.');
                            return;
                        }
                        if (typeof snap === 'undefined' || !snap.pay) {
                            alert('Midtrans Snap belum siap. Cek MIDTRANS clientKey dan koneksi internet.');
                            return;
                        }

                        btn.disabled = true;
                        var original = btn.innerHTML;
                        btn.innerHTML = 'Processing...';

                        fetch("{{ route('checkout.store') }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ address_id: addressSelect.value })
                        }).then(async function (res) {
                            var data = await res.json();
                            if (!res.ok) throw new Error(data.error || 'Server Error');
                            return data;
                        }).then(function (data) {
                            snap.pay(data.snap_token, {
                                onSuccess: function () { window.location.href = data.order_url; },
                                onPending: function () { window.location.href = data.order_url; },
                                onError: function () { window.location.href = data.order_url; },
                                onClose: function () {
                                    btn.disabled = false;
                                    btn.innerHTML = original;
                                }
                            });
                        }).catch(function (err) {
                            alert(err.message || 'Terjadi kesalahan.');
                            btn.disabled = false;
                            btn.innerHTML = original;
                        });
                    });
                })();
            </script>
        @endif
    @endauth
@endsection
