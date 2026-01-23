@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')

    @php
        $admin = auth()->user();
        $adminName = $admin?->name ?? 'Admin';
        $adminInitials = collect(explode(' ', trim($adminName)))
            ->filter()
            ->map(fn($p) => mb_substr($p, 0, 1))
            ->take(2)
            ->join('');
    @endphp

    <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-10 bg-[radial-gradient(#ffd1dc_1px,transparent_1px)] [background-size:24px_24px]">
        <header class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-6 mb-8 lg:mb-10">
            <div>
                <h2 class="text-3xl sm:text-4xl font-black text-[#181113] tracking-tight">Admin Dashboard</h2>
                <p class="text-primary font-medium">Welcome back, {{ $adminName }}!</p>
            </div>
            <div class="flex flex-col sm:flex-row sm:items-center gap-4 sm:gap-6">
                <form method="GET" action="{{ route('admin.search') }}" class="relative group">
                    <div
                        class="absolute inset-0 bg-primary/20 rounded-full blur-xl group-hover:bg-primary/30 transition-all">
                    </div>
                    <div class="relative bg-white px-4 py-3 rounded-full border-4 border-primary/20 flex items-center gap-3" data-admin-live-search-container>
                        <span class="material-symbols-outlined text-primary">search</span>
                        <input
                            name="q"
                            value="{{ request('q') }}"
                            class="border-none focus:ring-0 text-sm font-medium w-[220px] sm:w-72 bg-transparent"
                            placeholder="Search orders, products, users..."
                            type="text"
                            autocomplete="off"
                            data-admin-live-search
                        />

                        <div class="hidden" data-admin-live-search-spinner>
                            <div class="live-search-spinner"></div>
                        </div>
                    </div>
                </form>
                <div class="flex items-center justify-between sm:justify-start gap-4">
                    <div class="text-right">
                        <p class="font-bold text-[#181113]">{{ $adminName }}</p>
                        <p class="text-xs font-bold text-primary uppercase">Admin</p>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-0 lollipop-border rounded-full scale-110"></div>
                        <div class="w-14 h-14 rounded-full bg-white border-4 border-white shadow-lg relative z-10 flex items-center justify-center text-primary font-black">
                            {{ $adminInitials !== '' ? $adminInitials : 'A' }}
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 lg:gap-8 mb-8 lg:mb-10">
            <div
                class="bg-white p-6 sm:p-8 rounded-[2.5rem] sm:rounded-[3rem] border-4 border-primary/10 shadow-sm flex flex-col items-center text-center group hover:border-primary/30 transition-all">
                <div
                    class="donut-shape w-24 h-24 bg-pink-100 flex items-center justify-center mb-4 relative overflow-hidden">
                    <div
                        class="absolute inset-0 bg-[radial-gradient(circle_at_center,_#ff8fb1_2px,transparent_2px)] [background-size:8px_8px] opacity-40">
                    </div>
                    <span class="material-symbols-outlined text-primary text-4xl relative z-10"
                        style="font-variation-settings: 'FILL' 1">payments</span>
                </div>
                <h3 class="text-primary/60 font-bold uppercase tracking-widest text-xs">Total Sales</h3>
                <p class="text-3xl font-black text-[#181113]">{{ number_format($totalSalesQty ?? 0) }}</p>
                <div class="mt-2 text-primary font-bold text-sm flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">inventory_2</span> Items sold (paid)
                </div>
            </div>
            <div
                class="bg-white p-6 sm:p-8 rounded-[2.5rem] sm:rounded-[3rem] border-4 border-primary/10 shadow-sm flex flex-col items-center text-center group hover:border-primary/30 transition-all">
                <div
                    class="donut-shape w-24 h-24 bg-rose-100 flex items-center justify-center mb-4 relative overflow-hidden">
                    <div class="absolute inset-0 bg-primary/10"></div>
                    <div class="absolute top-2 right-4 w-2 h-2 rounded-full bg-white opacity-60"></div>
                    <span class="material-symbols-outlined text-primary text-4xl relative z-10"
                        style="font-variation-settings: 'FILL' 1">shopping_bag</span>
                </div>
                <h3 class="text-primary/60 font-bold uppercase tracking-widest text-xs">Total Orders</h3>
                <p class="text-3xl font-black text-[#181113]">{{ number_format($totalOrders ?? 0) }}</p>
                <div class="mt-2 text-primary font-bold text-sm flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">receipt_long</span> All statuses
                </div>
            </div>
            <div
                class="bg-white p-6 sm:p-8 rounded-[2.5rem] sm:rounded-[3rem] border-4 border-primary/10 shadow-sm flex flex-col items-center text-center group hover:border-primary/30 transition-all">
                <div
                    class="donut-shape w-24 h-24 bg-pink-50 flex items-center justify-center mb-4 relative overflow-hidden">
                    <div class="absolute inset-0 border-[6px] border-primary/20 rounded-full"></div>
                    <span class="material-symbols-outlined text-primary text-4xl relative z-10"
                        style="font-variation-settings: 'FILL' 1">face_6</span>
                </div>
                <h3 class="text-primary/60 font-bold uppercase tracking-widest text-xs">Total Users</h3>
                <p class="text-3xl font-black text-[#181113]">{{ number_format($totalUsers ?? 0) }}</p>
                <div class="mt-2 text-primary font-bold text-sm flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">favorite</span> Registered users
                </div>
            </div>
            <div
                class="bg-white p-6 sm:p-8 rounded-[2.5rem] sm:rounded-[3rem] border-4 border-primary/10 shadow-sm flex flex-col items-center text-center group hover:border-primary/30 transition-all">
                <div
                    class="donut-shape w-24 h-24 bg-rose-50 flex items-center justify-center mb-4 relative overflow-hidden">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,_rgba(244,37,89,0.25)_2px,transparent_2px)] [background-size:10px_10px] opacity-40"></div>
                    <span class="material-symbols-outlined text-primary text-4xl relative z-10"
                        style="font-variation-settings: 'FILL' 1">paid</span>
                </div>
                <h3 class="text-primary/60 font-bold uppercase tracking-widest text-xs">Total Pemasukan</h3>
                <p class="text-3xl font-black text-[#181113]">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</p>
                <div class="mt-2 text-primary font-bold text-sm flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">payments</span> Paid only
                </div>
            </div>
        </div>

        <div class="bg-white p-6 sm:p-10 rounded-[2.75rem] sm:rounded-[4rem] border-4 border-primary shadow-xl relative overflow-hidden mb-8 lg:mb-10">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6 sm:mb-8">
                <div>
                    <h3 class="text-2xl font-black text-[#181113]">Sales Performance</h3>
                    <p class="text-primary/60 font-medium">Last 30 days (paid revenue)</p>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 rounded-full bg-primary/5 text-primary font-bold text-sm hover:bg-primary/10">View orders</a>
            </div>
            <div class="relative h-[260px] sm:h-[300px] w-full flex items-end justify-between gap-2 px-2 sm:px-4 overflow-x-auto">
                <div class="absolute inset-0 flex flex-col justify-between py-2 pointer-events-none opacity-5">
                    <div class="border-b-2 border-primary w-full"></div>
                    <div class="border-b-2 border-primary w-full"></div>
                    <div class="border-b-2 border-primary w-full"></div>
                    <div class="border-b-2 border-primary w-full"></div>
                    <div class="border-b-2 border-primary w-full"></div>
                </div>

                @foreach (($salesPerformance ?? []) as $day)
                    @php
                        $pct = (int) round(($day['revenue'] / ($maxRevenue ?? 1)) * 100);
                        $pct = max(2, min(100, $pct));
                    @endphp
                    <div class="relative flex flex-col items-center justify-end min-w-[34px] w-[34px] h-full" title="{{ $day['labelLong'] ?? $day['date'] }} · Rp {{ number_format($day['revenue'] ?? 0, 0, ',', '.') }} · {{ $day['orders'] ?? 0 }} order">
                        <div class="w-full bg-primary/10 rounded-3xl overflow-hidden border-2 border-primary/10 flex items-end" style="height: 90%;">
                            <div class="w-full bg-primary rounded-3xl" style="height: {{ $pct }}%;"></div>
                        </div>
                        <div class="mt-3 text-[11px] font-black text-primary/50 uppercase">{{ $day['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
            <div class="bg-white p-6 sm:p-8 rounded-[2.5rem] sm:rounded-[3rem] border-4 border-primary/10">
                <h4 class="text-xl font-black text-[#181113] mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">auto_awesome</span>
                    Order Terbaru
                </h4>
                <div class="space-y-4">
                    @forelse (($recentOrders ?? collect()) as $o)
                        @php
                            $name = $o->user?->name ?? 'Guest';
                            $initials = collect(explode(' ', trim($name)))
                                ->filter()
                                ->map(fn($p) => mb_substr($p, 0, 1))
                                ->take(2)
                                ->join('');
                            $badge = match ($o->status) {
                                'paid' => 'bg-green-100 text-green-700',
                                'cancelled' => 'bg-zinc-100 text-zinc-700',
                                'failed' => 'bg-red-100 text-red-700',
                                default => 'bg-primary/10 text-primary',
                            };
                        @endphp
                        <a href="{{ route('admin.orders.show', $o) }}" class="block p-4 bg-primary/5 rounded-2xl hover:bg-primary/10 transition-colors">
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center font-black text-primary shrink-0">
                                        {{ $initials !== '' ? $initials : 'U' }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-black text-sm truncate">{{ $o->order_number }}</p>
                                        <p class="text-xs text-primary/60 font-bold truncate">{{ $name }} · {{ $o->created_at?->format('d M Y H:i') }}</p>
                                    </div>
                                </div>
                                <div class="text-right shrink-0">
                                    <div class="text-primary font-black">Rp {{ number_format($o->total_amount ?? 0, 0, ',', '.') }}</div>
                                    <div class="mt-1 inline-flex px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-widest {{ $badge }}">{{ $o->status }}</div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="p-8 text-center text-primary/60 font-bold">Belum ada order.</div>
                    @endforelse
                </div>
            </div>
            <div class="bg-white p-6 sm:p-8 rounded-[2.5rem] sm:rounded-[3rem] border-4 border-primary/10">
                <h4 class="text-xl font-black text-[#181113] mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">stars</span>
                    User Terbaru
                </h4>
                <div class="space-y-3">
                    @forelse (($recentUsers ?? collect()) as $u)
                        @php
                            $name = $u->name ?? 'User';
                            $initials = collect(explode(' ', trim($name)))
                                ->filter()
                                ->map(fn($p) => mb_substr($p, 0, 1))
                                ->take(2)
                                ->join('');
                        @endphp
                        <div class="flex items-center justify-between gap-4 p-4 bg-primary/5 rounded-2xl">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-10 h-10 rounded-full bg-white border-2 border-primary/15 flex items-center justify-center text-primary font-black shrink-0">
                                    {{ $initials !== '' ? $initials : 'U' }}
                                </div>
                                <div class="min-w-0">
                                    <div class="font-black text-sm truncate">{{ $name }}</div>
                                    <div class="text-xs font-bold text-primary/60 truncate">{{ $u->email }}</div>
                                </div>
                            </div>
                            <div class="text-right shrink-0">
                                <div class="text-[10px] font-black uppercase tracking-widest text-primary/50">Joined</div>
                                <div class="text-xs font-bold text-primary">{{ $u->created_at?->format('d M Y H:i') }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-primary/60 font-bold">Belum ada user.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>
@endsection
