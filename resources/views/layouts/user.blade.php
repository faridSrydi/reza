@extends('layouts.app')

@section('content')
    @php
        $u = auth()->user();
        $wishlistCount = $u
            ? \Illuminate\Support\Facades\DB::table('wishlists')->where('user_id', $u->id)->count()
            : 0;
        $addressCount = $u
            ? \App\Models\Address::query()->where('user_id', $u->id)->count()
            : 0;
        $orderCount = $u
            ? \App\Models\Order::query()->where('user_id', $u->id)->count()
            : 0;
    @endphp

    <main class="min-h-[calc(100vh-88px)] bg-[radial-gradient(#ffd1dc_1px,transparent_1px)] [background-size:24px_24px]">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="grid grid-cols-1 lg:grid-cols-[280px_1fr] gap-6 lg:gap-8">
                <aside class="bg-white/80 dark:bg-zinc-900/80 backdrop-blur-md rounded-3xl border-2 border-primary/10 shadow-xl shadow-primary/5 p-4 sm:p-5 h-fit">
                    <div class="px-2 pb-4 mb-4 border-b border-primary/10">
                        <p class="text-[11px] font-black uppercase tracking-widest text-primary/60">My Account</p>
                        <p class="mt-1 text-primary font-extrabold truncate">{{ $u?->name }}</p>
                        <p class="text-xs font-semibold text-primary/50 truncate">{{ $u?->email }}</p>
                    </div>

                    <nav class="space-y-2">
                        <a href="{{ url('/user/dashboard') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->is('user/dashboard') ? 'bg-primary text-white' : 'hover:bg-primary/10 text-primary' }} font-extrabold transition-colors">
                            <span class="material-symbols-outlined">dashboard</span>
                            Dashboard
                        </a>

                        <a href="{{ route('wishlist.index') }}"
                            class="flex items-center justify-between gap-3 px-4 py-3 rounded-2xl {{ request()->is('wishlist') ? 'bg-primary text-white' : 'hover:bg-primary/10 text-primary' }} font-extrabold transition-colors">
                            <span class="flex items-center gap-3">
                                <span class="material-symbols-outlined">favorite</span>
                                Wishlist
                            </span>
                            <span class="text-xs font-black px-2 py-1 rounded-full {{ request()->is('wishlist') ? 'bg-white/20 text-white' : 'bg-primary/10 text-primary' }}">{{ $wishlistCount }}</span>
                        </a>

                        <a href="{{ route('addresses.index') }}"
                            class="flex items-center justify-between gap-3 px-4 py-3 rounded-2xl {{ request()->is('addresses') || request()->is('addresses/*') ? 'bg-primary text-white' : 'hover:bg-primary/10 text-primary' }} font-extrabold transition-colors">
                            <span class="flex items-center gap-3">
                                <span class="material-symbols-outlined">location_on</span>
                                Addresses
                            </span>
                            <span class="text-xs font-black px-2 py-1 rounded-full {{ request()->is('addresses') || request()->is('addresses/*') ? 'bg-white/20 text-white' : 'bg-primary/10 text-primary' }}">{{ $addressCount }}</span>
                        </a>

                        <a href="{{ route('orders.index') }}"
                            class="flex items-center justify-between gap-3 px-4 py-3 rounded-2xl {{ request()->is('orders') || request()->is('orders/*') ? 'bg-primary text-white' : 'hover:bg-primary/10 text-primary' }} font-extrabold transition-colors">
                            <span class="flex items-center gap-3">
                                <span class="material-symbols-outlined">receipt_long</span>
                                Orders
                            </span>
                            <span class="text-xs font-black px-2 py-1 rounded-full {{ request()->is('orders') || request()->is('orders/*') ? 'bg-white/20 text-white' : 'bg-primary/10 text-primary' }}">{{ $orderCount }}</span>
                        </a>

                        <a href="{{ route('shop.index') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-2xl hover:bg-primary/10 text-primary font-extrabold transition-colors">
                            <span class="material-symbols-outlined">storefront</span>
                            Continue Shopping
                        </a>
                    </nav>

                    <div class="mt-6 pt-4 border-t border-primary/10">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-2xl border-2 border-red-200 text-red-600 font-extrabold hover:bg-red-50 transition-colors">
                                <span class="material-symbols-outlined">logout</span>
                                Log out
                            </button>
                        </form>
                    </div>
                </aside>

                <div>
                    @yield('user_content')
                </div>
            </div>
        </div>
    </main>
@endsection
