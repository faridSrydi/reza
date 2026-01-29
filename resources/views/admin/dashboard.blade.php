@extends('layouts.admin')

@section('title', 'Dashboard Overview')

@section('content')

    @php
        $admin = auth()->user();
        $adminName = $admin?->name ?? 'Admin';
        $adminFirstName = trim(explode(' ', trim($adminName))[0] ?? $adminName);

        $lastBars = collect($salesPerformance ?? [])->take(-8)->values();
        $barMax = (int) (collect($lastBars)->max('revenue') ?: 1);

        $statusPill = fn($status) => match ($status) {
            'paid' => 'bg-green-100 text-green-700',
            'cancelled' => 'bg-zinc-100 text-zinc-700',
            'failed' => 'bg-red-100 text-red-700',
            'pending' => 'bg-blue-100 text-blue-700',
            default => 'bg-gray-100 text-gray-700',
        };
    @endphp

    <main class="flex-1 p-4 sm:p-6 lg:p-8">
        <header class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-8 sm:mb-10">
            <div>
                <h1 class="text-3xl font-bold serif-text">Dashboard Overview</h1>
                <p class="text-gray-500 text-sm mt-1">Welcome back, {{ $adminFirstName }}. Here's what's happening today.</p>
            </div>
            <div class="hidden sm:flex items-center gap-4">
                <button type="button"
                    class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium shadow-sm hover:bg-gray-50 transition-colors">
                    <span class="material-symbols-outlined text-xl">calendar_today</span>
                    Last 30 Days
                </button>
                <button type="button"
                    class="bg-primary text-white px-6 py-2 rounded-lg text-sm font-bold shadow-lg shadow-primary/20 hover:opacity-90 transition-opacity">
                    Export Data
                </button>
            </div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 mb-8 sm:mb-10">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <div class="flex justify-between items-start mb-4">
                    <div class="size-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-3xl">payments</span>
                    </div>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1 uppercase tracking-wider">Total Revenue</h3>
                <div class="flex items-end justify-between">
                    <p class="text-3xl font-bold serif-text">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</p>
                    <div class="h-10 w-24">
                        <svg class="w-full h-full" viewBox="0 0 100 40">
                            <path d="M0,35 Q10,10 20,30 T40,15 T60,25 T80,5 T100,20" fill="none" stroke="#ee2b8c" stroke-width="2" vector-effect="non-scaling-stroke"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <div class="flex justify-between items-start mb-4">
                    <div class="size-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-3xl">shopping_bag</span>
                    </div>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1 uppercase tracking-wider">Total Orders</h3>
                <div class="flex items-end justify-between">
                    <p class="text-3xl font-bold serif-text">{{ number_format($totalOrders ?? 0) }}</p>
                    <div class="h-10 w-24">
                        <svg class="w-full h-full" viewBox="0 0 100 40">
                            <path d="M0,20 Q15,35 30,20 T60,10 T90,30 T100,25" fill="none" stroke="#ee2b8c" stroke-width="2" vector-effect="non-scaling-stroke"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <div class="flex justify-between items-start mb-4">
                    <div class="size-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-3xl">person</span>
                    </div>
                </div>
                <h3 class="text-gray-500 text-sm font-medium mb-1 uppercase tracking-wider">Active Users</h3>
                <div class="flex items-end justify-between">
                    <p class="text-3xl font-bold serif-text">{{ number_format($totalUsers ?? 0) }}</p>
                    <div class="h-10 w-24">
                        <svg class="w-full h-full" viewBox="0 0 100 40">
                            <path d="M0,10 Q25,5 50,30 T100,35" fill="none" stroke="#ee2b8c" stroke-width="2" vector-effect="non-scaling-stroke"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
            <div class="lg:col-span-2 bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-100">
                <div class="flex justify-between items-center mb-8">
                    <h3 class="text-xl font-bold serif-text">Sales Performance</h3>
                    <div class="flex gap-4">
                        <div class="flex items-center gap-2">
                            <div class="size-3 rounded-full bg-primary"></div>
                            <span class="text-xs text-gray-500 font-medium">Revenue</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="size-3 rounded-full bg-primary/20"></div>
                            <span class="text-xs text-gray-500 font-medium">Target</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-end justify-between h-64 gap-2">
                    @foreach ($lastBars as $bar)
                        @php
                            $pct = (int) round(((int) ($bar['revenue'] ?? 0) / $barMax) * 100);
                            $pct = max(4, min(100, $pct));
                        @endphp
                        <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end" title="{{ $bar['labelLong'] ?? $bar['date'] }} · Rp {{ number_format($bar['revenue'] ?? 0, 0, ',', '.') }}">
                            <div class="w-full chart-bar rounded-t-lg" style="height: {{ $pct }}%"></div>
                            <span class="text-[10px] font-bold text-gray-400">{{ $bar['label'] ?? '' }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-100">
                <div class="flex justify-between items-center mb-8">
                    <h3 class="text-xl font-bold serif-text">Recent Sales</h3>
                    <a class="text-xs text-primary font-bold uppercase tracking-widest hover:underline" href="{{ route('admin.orders.index') }}">View All</a>
                </div>
                <div class="space-y-6">
                    @forelse (($recentOrders ?? collect())->take(6) as $o)
                        @php
                            $firstItemName = $o->items->first()->product_name ?? null;
                            $title = $firstItemName ?: ($o->order_number ?? 'Order');
                        @endphp
                        <div class="flex items-center gap-4">
                            <div class="size-10 rounded-full bg-gray-200 bg-cover border border-gray-100 flex items-center justify-center text-gray-600 font-bold">
                                {{ mb_substr($title, 0, 1) }}
                            </div>
                            <div class="flex-1 overflow-hidden">
                                <p class="text-sm font-bold truncate">{{ $title }}</p>
                                <p class="text-[10px] text-gray-500">{{ $o->created_at?->diffForHumans() }}</p>
                            </div>
                            <p class="text-sm font-bold text-gray-800">Rp {{ number_format($o->total_amount ?? 0, 0, ',', '.') }}</p>
                        </div>
                    @empty
                        <div class="text-sm text-gray-500">No recent sales.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="mt-8 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 sm:p-6 lg:p-8 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-xl font-bold serif-text">Latest Orders</h3>
                <div class="hidden sm:flex gap-2">
                    <a href="{{ route('admin.orders.index') }}" class="text-sm px-4 py-2 border border-gray-200 rounded-lg hover:bg-gray-50">View Orders</a>
                </div>
            </div>
            <div class="overflow-x-auto no-scrollbar">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50 text-[10px] uppercase tracking-widest text-gray-500 font-bold">
                            <th class="px-4 sm:px-6 lg:px-8 py-4">Order ID</th>
                            <th class="px-4 sm:px-6 lg:px-8 py-4">Customer</th>
                            <th class="px-4 sm:px-6 lg:px-8 py-4">Product</th>
                            <th class="px-4 sm:px-6 lg:px-8 py-4">Status</th>
                            <th class="px-4 sm:px-6 lg:px-8 py-4">Amount</th>
                            <th class="px-4 sm:px-6 lg:px-8 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse (($recentOrders ?? collect())->take(8) as $o)
                            @php
                                $customer = $o->user?->name ?? 'Guest';
                                $product = $o->items->first()->product_name ?? '-';
                                $pill = $statusPill($o->status);
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 sm:px-6 lg:px-8 py-4 text-sm font-medium">{{ $o->order_number }}</td>
                                <td class="px-4 sm:px-6 lg:px-8 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="size-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-600">
                                            {{ mb_substr($customer, 0, 1) }}
                                        </div>
                                        <span class="text-sm font-medium">{{ $customer }}</span>
                                    </div>
                                </td>
                                <td class="px-4 sm:px-6 lg:px-8 py-4 text-sm text-gray-500">{{ $product }}</td>
                                <td class="px-4 sm:px-6 lg:px-8 py-4">
                                    <span class="px-3 py-1 {{ $pill }} text-[10px] font-bold rounded-full uppercase tracking-tighter">{{ $o->status }}</span>
                                </td>
                                <td class="px-4 sm:px-6 lg:px-8 py-4 text-sm font-bold">Rp {{ number_format($o->total_amount ?? 0, 0, ',', '.') }}</td>
                                <td class="px-4 sm:px-6 lg:px-8 py-4 text-right">
                                    <a href="{{ route('admin.orders.show', $o) }}" class="text-gray-400 hover:text-primary" aria-label="View">
                                        <span class="material-symbols-outlined">more_horiz</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 sm:px-6 lg:px-8 py-8 text-center text-sm text-gray-500">No orders yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 bg-gray-50 border-t border-gray-100 text-center">
                <a href="{{ route('admin.orders.index') }}" class="text-sm font-bold text-gray-500 hover:text-primary transition-colors">Show More Transactions</a>
            </div>
        </div>
    </main>
@endsection
