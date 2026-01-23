@extends('layouts.user')

@section('title', 'Dashboard')

@section('user_content')
@php
    $u = auth()->user();
    $wishlistCount = \Illuminate\Support\Facades\DB::table('wishlists')
        ->where('user_id', $u->id)
        ->count();
    $addressCount = \App\Models\Address::query()
        ->where('user_id', $u->id)
        ->count();
    $memberSince = $u->created_at ? $u->created_at->format('M Y') : null;
@endphp

<div class="space-y-6">
                <section class="relative overflow-hidden rounded-[2.5rem] border-2 border-primary/10 bg-white/85 dark:bg-zinc-900/85 backdrop-blur-md shadow-xl shadow-primary/5 p-6 sm:p-8">
                    <div class="absolute -top-16 -right-16 w-60 h-60 rounded-full bg-primary/10 blur-2xl"></div>
                    <div class="absolute -bottom-16 -left-16 w-60 h-60 rounded-full bg-candy-pink/60 blur-2xl"></div>

                    <div class="relative">
                        <p class="text-[11px] font-black uppercase tracking-widest text-primary/60">Welcome back</p>
                        <h1 class="mt-2 text-3xl sm:text-4xl font-black tracking-tight text-[#181113] dark:text-white">
                            Hi, {{ $u->name ?? 'Sweetie' }}!
                        </h1>
                        <p class="mt-2 text-primary/60 font-semibold max-w-2xl">
                            Manage your wishlist, saved addresses, and keep shopping for your next sweet craving.
                        </p>

                        <div class="mt-6 flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('shop.index') }}"
                                class="inline-flex items-center justify-center gap-2 bg-primary text-white font-black px-6 py-3 rounded-full hover:scale-105 transition-transform shadow-xl shadow-primary/25">
                                <span class="material-symbols-outlined">shopping_bag</span>
                                Shop Now
                            </a>
                            <a href="{{ route('wishlist.index') }}"
                                class="inline-flex items-center justify-center gap-2 bg-primary/5 text-primary font-black px-6 py-3 rounded-full hover:bg-primary/10 transition-colors border-2 border-primary/10">
                                <span class="material-symbols-outlined">favorite</span>
                                View Wishlist
                            </a>
                        </div>
                    </div>
                </section>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-white/85 dark:bg-zinc-900/85 backdrop-blur-md rounded-3xl border-2 border-primary/10 p-6 shadow-xl shadow-primary/5">
                        <div class="flex items-center gap-3 text-primary font-black">
                            <span class="material-symbols-outlined">favorite</span>
                            Wishlist Items
                        </div>
                        <div class="mt-3 text-4xl font-black text-[#181113] dark:text-white">{{ $wishlistCount }}</div>
                        <p class="mt-2 text-primary/60 font-semibold text-sm">Treats you saved for later.</p>
                    </div>
                    <div class="bg-white/85 dark:bg-zinc-900/85 backdrop-blur-md rounded-3xl border-2 border-primary/10 p-6 shadow-xl shadow-primary/5">
                        <div class="flex items-center gap-3 text-primary font-black">
                            <span class="material-symbols-outlined">location_on</span>
                            Saved Addresses
                        </div>
                        <div class="mt-3 text-4xl font-black text-[#181113] dark:text-white">{{ $addressCount }}</div>
                        <p class="mt-2 text-primary/60 font-semibold text-sm">Faster checkout next time.</p>
                    </div>
                    <div class="bg-white/85 dark:bg-zinc-900/85 backdrop-blur-md rounded-3xl border-2 border-primary/10 p-6 shadow-xl shadow-primary/5">
                        <div class="flex items-center gap-3 text-primary font-black">
                            <span class="material-symbols-outlined">cake</span>
                            Member Since
                        </div>
                        <div class="mt-3 text-2xl sm:text-3xl font-black text-[#181113] dark:text-white">{{ $memberSince ?? '—' }}</div>
                        <p class="mt-2 text-primary/60 font-semibold text-sm">Thanks for joining us.</p>
                    </div>
                </div>

                <section class="bg-white/85 dark:bg-zinc-900/85 backdrop-blur-md rounded-[2.5rem] border-2 border-primary/10 p-6 sm:p-8 shadow-xl shadow-primary/5">
                    <div class="flex items-start justify-between gap-6">
                        <div>
                            <h2 class="text-2xl font-black text-[#181113] dark:text-white">Quick Actions</h2>
                            <p class="mt-2 text-primary/60 font-semibold">Jump to what you need in one tap.</p>
                        </div>
                        <span class="material-symbols-outlined text-primary text-3xl">auto_awesome</span>
                    </div>

                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <a href="{{ route('addresses.create') }}"
                            class="group rounded-3xl border-2 border-primary/10 bg-primary/5 p-5 hover:bg-primary/10 transition-colors">
                            <div class="flex items-center gap-3 text-primary font-black">
                                <span class="material-symbols-outlined">add_location</span>
                                Add New Address
                            </div>
                            <p class="mt-2 text-sm font-semibold text-primary/60">Save your shipping address.</p>
                        </a>
                        <a href="{{ route('wishlist.index') }}"
                            class="group rounded-3xl border-2 border-primary/10 bg-primary/5 p-5 hover:bg-primary/10 transition-colors">
                            <div class="flex items-center gap-3 text-primary font-black">
                                <span class="material-symbols-outlined">favorite</span>
                                Open Wishlist
                            </div>
                            <p class="mt-2 text-sm font-semibold text-primary/60">See your saved treats.</p>
                        </a>
                        <a href="{{ route('shop.index') }}"
                            class="group rounded-3xl border-2 border-primary/10 bg-primary/5 p-5 hover:bg-primary/10 transition-colors">
                            <div class="flex items-center gap-3 text-primary font-black">
                                <span class="material-symbols-outlined">storefront</span>
                                Browse Shop
                            </div>
                            <p class="mt-2 text-sm font-semibold text-primary/60">Find something sweet today.</p>
                        </a>
                    </div>

                    <div class="mt-6 rounded-3xl border-2 border-dashed border-primary/15 bg-white/60 dark:bg-zinc-900/40 p-5">
                        <p class="text-sm font-extrabold text-primary">Orders</p>
                        <p class="mt-1 text-sm font-semibold text-primary/60">Order history UI can be added once the orders module is ready.</p>
                    </div>
                </section>
            </div>
</div>
@endsection