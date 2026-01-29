@extends('layouts.user') {{-- Sesuaikan dengan layout utama Anda --}}

@section('title', 'Dashboard')

@section('user_content')
{{-- 1. LOGIKA PHP DARI KODE BAWAH --}}
@php
    $u = auth()->user();
    
    // Menghitung Wishlist
    $wishlistCount = \Illuminate\Support\Facades\DB::table('wishlists')
        ->where('user_id', $u->id)
        ->count();

    // Menghitung Alamat
    $addressCount = \App\Models\Address::query()
        ->where('user_id', $u->id)
        ->count();

    // Format Tanggal Bergabung
    $memberSince = $u->created_at ? $u->created_at->format('M Y') : 'N/A';
    
    // (Opsional) Jika Anda punya model Order, bisa ditambahkan disini
    // $orderCount = \App\Models\Order::where('user_id', $u->id)->count();
    $orderCount = 0; // Placeholder jika belum ada model Order
@endphp

{{-- 2. STRUKTUR HTML DARI KODE ATAS (Dengan Data Dinamis) --}}
<div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-12">
    <div>
        {{-- Menggunakan Nama User Dinamis --}}
        <h1 class="text-5xl font-bold serif-text mb-2">Hello, {{ explode(' ', $u->name)[0] }}!</h1>
        <p class="text-gray-500 dark:text-gray-400">Welcome back to your beauty sanctuary.</p>
    </div>
    
    <div class="flex items-center gap-6 bg-white dark:bg-[#1b0d14] p-6 rounded-2xl border border-[#f3e7ed] dark:border-[#3d2030]">
        <div class="size-14 rounded-full bg-primary/10 flex items-center justify-center text-primary">
            <span class="material-symbols-outlined text-3xl">star</span>
        </div>
        <div>
            <p class="text-xs uppercase tracking-widest font-bold text-gray-400 mb-1">Membership Status</p>
            <p class="text-lg font-bold">Gold Tier Member</p>
            {{-- Menampilkan Member Since sesuai logika kode bawah --}}
            <p class="text-sm text-primary">Member Since {{ $memberSince }}</p>
        </div>
    </div>
</div>

{{-- GRID STATISTIK --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
    <a href="#" class="group bg-white dark:bg-[#1b0d14] p-8 rounded-2xl border border-[#f3e7ed] dark:border-[#3d2030] hover:border-primary/30 transition-all">
        <p class="text-sm font-bold uppercase tracking-widest text-gray-400 mb-2">Total Orders</p>
        <p class="text-4xl font-bold serif-text group-hover:text-primary transition-colors">{{ $orderCount }}</p>
    </a>

    {{-- Saya mengganti 'Reward Points' dari desain asli menjadi 'Saved Addresses' agar sesuai dengan logika kode bawah --}}
    <a href="{{ route('addresses.create') }}" class="group bg-white dark:bg-[#1b0d14] p-8 rounded-2xl border border-[#f3e7ed] dark:border-[#3d2030] hover:border-primary/30 transition-all">
        <p class="text-sm font-bold uppercase tracking-widest text-gray-400 mb-2">Saved Addresses</p>
        <p class="text-4xl font-bold serif-text text-primary">{{ $addressCount }}</p>
    </a>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-12">
    {{-- BAGIAN ORDER TERAKHIR (UI Tetap dipertahankan, Data Statis) --}}
    {{-- Kode bawah Anda mencatat "Order history UI can be added...", jadi ini saya biarkan sebagai UI statis untuk mockup --}}
    <div class="xl:col-span-2">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold serif-text">My Last Order</h3>
            <a class="text-sm font-bold text-primary hover:underline" href="#">View All Orders</a>
        </div>
        <div class="bg-white dark:bg-[#1b0d14] p-8 rounded-2xl border border-[#f3e7ed] dark:border-[#3d2030]">
            <div class="flex flex-wrap justify-between gap-6 mb-10">
                <div>
                    <p class="text-xs uppercase tracking-widest font-bold text-gray-400 mb-1">Order Number</p>
                    <p class="font-bold text-lg">#LX-882910</p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-widest font-bold text-gray-400 mb-1">Order Date</p>
                    <p class="font-bold text-lg">Oct 12, 2023</p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-widest font-bold text-gray-400 mb-1">Order Total</p>
                    <p class="font-bold text-lg">$148.50</p>
                </div>
                <div class="bg-green-50 dark:bg-green-900/20 text-green-600 px-4 py-2 rounded-full h-fit self-center">
                    <p class="text-xs font-bold uppercase tracking-widest">Shipped</p>
                </div>
            </div>
            
            {{-- Progress Bar Order --}}
            <div class="relative py-4 mb-8">
                <div class="flex items-center justify-between gap-2">
                    <div class="flex flex-col items-center gap-3 flex-1">
                        <div class="status-dot bg-primary"></div>
                        <span class="text-xs font-bold text-center">Confirmed</span>
                    </div>
                    <div class="status-line active"></div>
                    <div class="flex flex-col items-center gap-3 flex-1">
                        <div class="status-dot bg-primary"></div>
                        <span class="text-xs font-bold text-center">Processing</span>
                    </div>
                    <div class="status-line active"></div>
                    <div class="flex flex-col items-center gap-3 flex-1">
                        <div class="status-dot bg-primary"></div>
                        <span class="text-xs font-bold text-center">Shipped</span>
                    </div>
                    <div class="status-line"></div>
                    <div class="flex flex-col items-center gap-3 flex-1">
                        <div class="status-dot bg-gray-200 dark:bg-[#3d2030]"></div>
                        <span class="text-xs font-bold text-gray-400 text-center">Delivered</span>
                    </div>
                </div>
            </div>

            <div class="flex gap-4 border-t border-[#f3e7ed] dark:border-[#3d2030] pt-8">
                <div class="size-20 rounded-lg bg-gray-100 dark:bg-[#3d2030] overflow-hidden flex-shrink-0">
                    {{-- Placeholder Image --}}
                    <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">
                        <span class="material-symbols-outlined">image</span>
                    </div>
                </div>
                <div class="flex-grow">
                    <h4 class="font-bold">Divine Glow Foundation</h4>
                    <p class="text-sm text-gray-500 mb-2">Shade: Porcelain</p>
                    <p class="text-sm font-bold">$65.00</p>
                </div>
                <button class="px-6 h-10 border border-[#f3e7ed] dark:border-[#3d2030] rounded-full text-xs font-bold uppercase tracking-widest hover:border-primary transition-colors self-center">Track Package</button>
            </div>
        </div>
    </div>

    {{-- BAGIAN RECOMMENDATION / QUICK ACTIONS --}}
    <div>
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold serif-text">Quick Actions</h3>
        </div>
        <div class="flex flex-col gap-6">
            {{-- Quick Action: Shop --}}
            <div class="group bg-white dark:bg-[#1b0d14] rounded-2xl border border-[#f3e7ed] dark:border-[#3d2030] p-6 hover:shadow-lg transition-all">
                <div class="flex items-center gap-4 mb-4">
                     <div class="size-10 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined">storefront</span>
                    </div>
                    <div>
                        <h4 class="font-bold serif-text text-lg">Browse Shop</h4>
                        <p class="text-xs text-gray-500 uppercase tracking-widest">New Arrivals</p>
                    </div>
                </div>
                <a href="{{ route('shop.index') }}" class="block w-full text-center bg-[#1b0d14] dark:bg-white text-white dark:text-[#1b0d14] font-bold py-3 rounded-full hover:bg-primary dark:hover:bg-primary dark:hover:text-white transition-colors">
                    Go to Shop
                </a>
            </div>

             {{-- Quick Action: Add Address --}}
            <div class="bg-primary/5 dark:bg-primary/10 p-6 rounded-2xl border border-primary/10">
                <h4 class="font-bold mb-2 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">add_location</span>
                    Need to ship elsewhere?
                </h4>
                <p class="text-sm text-gray-600 dark:text-gray-400 italic mb-4">"Add a new address to speed up your checkout process."</p>
                <a href="{{ route('addresses.create') }}" class="text-sm font-bold text-primary hover:underline">Add New Address &rarr;</a>
            </div>
        </div>
    </div>
</div>
@endsection