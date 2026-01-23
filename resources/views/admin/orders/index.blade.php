@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
    <main class="flex-1 w-full px-6 py-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-4xl font-black text-[#181113]">Orders</h1>
                <p class="text-primary/60 font-semibold">Daftar transaksi customer.</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl border-2 border-primary/10 overflow-hidden">
            <div class="p-6 border-b border-primary/10">
                <h2 class="text-primary font-black">All Orders</h2>
            </div>

            <div class="divide-y divide-primary/10">
                @forelse ($orders as $order)
                    <a href="{{ route('admin.orders.show', $order) }}" class="block p-6 hover:bg-primary/5 transition-colors">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                            <div>
                                <div class="text-primary font-black">{{ $order->order_number }}</div>
                                <div class="text-xs font-bold text-primary/60 uppercase tracking-widest">
                                    {{ $order->user?->name ?? '—' }} · {{ $order->created_at->format('d M Y H:i') }}
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-widest
                                    @if ($order->status === 'paid') bg-green-100 text-green-700
                                    @elseif ($order->status === 'cancelled') bg-zinc-100 text-zinc-700
                                    @elseif ($order->status === 'failed') bg-red-100 text-red-700
                                    @else bg-primary/10 text-primary @endif">
                                    {{ $order->status }}
                                </span>
                                <div class="text-primary font-black">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="p-10 text-center text-primary/60 font-bold">Belum ada order.</div>
                @endforelse
            </div>

            <div class="p-6">
                {{ $orders->links() }}
            </div>
        </div>
    </main>
@endsection
