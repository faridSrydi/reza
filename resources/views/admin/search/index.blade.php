@extends('layouts.admin')

@section('title', 'Search')

@section('content')
    <main class="flex-1 w-full px-6 py-8">
        <div class="flex items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-4xl font-black text-[#181113]">Search</h1>
                <p class="text-primary/60 font-semibold">Cari produk, order, atau user.</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl border-2 border-primary/10 p-6 mb-8">
            <form method="GET" action="{{ route('admin.search') }}" class="flex flex-col md:flex-row gap-3">
                <div class="flex-1 relative" data-admin-live-search-container>
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-primary">search</span>
                    <input
                        name="q"
                        value="{{ $q }}"
                        placeholder="Search orders, products, users..."
                        type="text"
                        autocomplete="off"
                        data-admin-live-search
                        class="w-full rounded-full border-2 border-primary/10 bg-primary/5 focus:border-primary focus:ring-0 h-12 pl-12 pr-12 font-semibold"
                    />

                    <div class="absolute right-4 top-1/2 -translate-y-1/2 hidden" data-admin-live-search-spinner>
                        <div class="live-search-spinner"></div>
                    </div>
                </div>
                <button type="submit" class="h-12 px-6 rounded-full bg-primary text-white font-black">Search</button>
            </form>
        </div>

        @if ($q === '')
            <div class="bg-white rounded-3xl border-2 border-primary/10 p-10 text-center text-primary/60 font-bold">
                Masukkan kata kunci untuk mulai mencari.
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="bg-white rounded-3xl border-2 border-primary/10 overflow-hidden">
                    <div class="p-6 border-b border-primary/10">
                        <div class="flex items-center justify-between">
                            <h2 class="text-primary font-black">Products</h2>
                            <span class="text-xs font-black text-primary/60">{{ $products->count() }}</span>
                        </div>
                    </div>
                    <div class="divide-y divide-primary/10">
                        @forelse ($products as $p)
                            @php
                                $img = $p->images->first();
                            @endphp
                            <a href="{{ route('admin.products.show', $p) }}" class="block p-5 hover:bg-primary/5 transition-colors">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-2xl bg-primary/10 overflow-hidden shrink-0">
                                        @if ($img)
                                            <img src="{{ asset('storage/' . ltrim($img->image, '/')) }}" class="w-full h-full object-cover" alt="{{ $p->name }}">
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-black text-[#181113] truncate">{{ $p->name }}</div>
                                        <div class="text-xs font-bold text-primary/60 truncate">{{ $p->category?->name ?? '—' }}</div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="p-6 text-primary/60 font-bold">No products.</div>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white rounded-3xl border-2 border-primary/10 overflow-hidden">
                    <div class="p-6 border-b border-primary/10">
                        <div class="flex items-center justify-between">
                            <h2 class="text-primary font-black">Orders</h2>
                            <span class="text-xs font-black text-primary/60">{{ $orders->count() }}</span>
                        </div>
                    </div>
                    <div class="divide-y divide-primary/10">
                        @forelse ($orders as $o)
                            <a href="{{ route('admin.orders.show', $o) }}" class="block p-5 hover:bg-primary/5 transition-colors">
                                <div class="flex items-center justify-between gap-3">
                                    <div class="min-w-0">
                                        <div class="font-black text-[#181113] truncate">{{ $o->order_number }}</div>
                                        <div class="text-xs font-bold text-primary/60 truncate">{{ $o->user?->name ?? '—' }}</div>
                                    </div>
                                    <div class="text-right shrink-0">
                                        <div class="font-black text-primary">Rp {{ number_format($o->total_amount ?? 0, 0, ',', '.') }}</div>
                                        <div class="text-[10px] font-black uppercase tracking-widest text-primary/60">{{ $o->status }}</div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="p-6 text-primary/60 font-bold">No orders.</div>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white rounded-3xl border-2 border-primary/10 overflow-hidden">
                    <div class="p-6 border-b border-primary/10">
                        <div class="flex items-center justify-between">
                            <h2 class="text-primary font-black">Users</h2>
                            <span class="text-xs font-black text-primary/60">{{ $users->count() }}</span>
                        </div>
                    </div>
                    <div class="divide-y divide-primary/10">
                        @forelse ($users as $u)
                            <div class="p-5">
                                <div class="font-black text-[#181113] truncate">{{ $u->name }}</div>
                                <div class="text-xs font-bold text-primary/60 truncate">{{ $u->email }}</div>
                                <div class="text-[10px] font-black uppercase tracking-widest text-primary/40 mt-1">Joined {{ $u->created_at?->format('d M Y H:i') }}</div>
                            </div>
                        @empty
                            <div class="p-6 text-primary/60 font-bold">No users.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        @endif
    </main>
@endsection
