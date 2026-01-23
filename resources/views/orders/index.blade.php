@extends('layouts.user')

@section('title', 'Orders')

@section('user_content')
    <div class="w-full py-2 sm:py-4">
        <div class="flex items-center gap-2 mb-6">
            <a class="text-primary/60 text-sm font-semibold hover:text-primary" href="{{ route('home') }}">Home</a>
            <span class="material-symbols-outlined crumb-heart text-[12px] text-primary">favorite</span>
            <span class="text-primary text-sm font-bold">Orders</span>
        </div>

        <div class="flex items-end justify-between gap-4 mb-8">
            <div>
                <h1 class="text-4xl font-extrabold text-primary tracking-tight">Orders</h1>
                <p class="text-primary/60 font-semibold">Riwayat checkout & status pembayaran kamu.</p>
            </div>
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

        <div class="bg-white rounded-3xl border-2 border-primary/10 overflow-hidden">
            <div class="p-6 border-b border-primary/10">
                <h2 class="text-primary font-black">Daftar Order</h2>
            </div>

            <div class="divide-y divide-primary/10">
                @forelse ($orders as $order)
                    <a href="{{ route('orders.show', $order) }}" class="block p-6 hover:bg-primary/5 transition-colors">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <div>
                                <div class="text-primary font-black">{{ $order->order_number }}</div>
                                <div class="text-xs font-bold text-primary/60 uppercase tracking-widest">{{ $order->created_at->format('d M Y H:i') }}</div>
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
    </div>
@endsection
