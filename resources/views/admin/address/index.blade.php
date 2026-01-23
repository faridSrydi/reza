@extends('layouts.app')

@section('title', 'Addresses')

@section('content')
    <main class="flex-1 max-w-[1280px] mx-auto w-full px-6 py-8">
        <div class="flex items-center gap-2 mb-6">
            <a class="text-primary/60 text-sm font-semibold hover:text-primary transition-colors" href="{{ route('home') }}">Home</a>
            <span class="material-symbols-outlined crumb-heart text-[12px] text-primary">favorite</span>
            <span class="text-primary text-sm font-bold">Addresses</span>
        </div>

        <div class="flex flex-col md:flex-row items-center justify-between gap-6 mb-8">
            <div class="flex flex-col gap-2 text-center md:text-left">
                <h1 class="text-4xl md:text-5xl font-extrabold text-primary tracking-tight">Addresses</h1>
                <p class="text-primary/60 font-semibold">Kelola alamat pengiriman kamu.</p>
            </div>

            <a href="{{ route('admin.addresses.create') }}" class="flex flex-col items-center gap-1 group">
                    <div
                        class="relative flex size-24 items-center justify-center rounded-full lollipop-gradient text-white shadow-lg shadow-primary/30 transition-transform group-hover:scale-110 active:scale-95 overflow-hidden">
                        <div
                            class="absolute inset-0 bg-[radial-gradient(circle_at_30%_30%,rgba(255,255,255,0.4),transparent)]">
                        </div>
                        <span class="material-symbols-outlined text-4xl font-bold">add</span>
                    </div>
                    <div
                        class="w-2 h-8 bg-orange-200 dark:bg-orange-900 rounded-b-full shadow-sm -mt-1 group-hover:h-10 transition-all">
                    </div>
                    <span class="text-xs font-black uppercase tracking-widest text-primary mt-2">New Spot</span>
            </a>
        </div>

            {{-- NOTIFICATION --}}
        @if (session('success'))
            <div class="mb-8 p-4 bg-primary/5 border-l-4 border-primary flex items-center justify-between rounded-r-xl">
                    <span class="text-sm font-bold uppercase tracking-wide text-primary">
                        ✨ {{ session('success') }}
                    </span>
                    <button onclick="this.parentElement.remove()"
                        class="text-xs font-black text-primary/40 hover:text-primary transition-colors">X</button>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8">

                @forelse($addresses as $address)
                    <div class="relative group">
                        <div
                            class="h-full bg-white dark:bg-background-dark/40 border-4 border-primary/10 rounded-xl p-8 pt-12 shadow-xl shadow-primary/5 flex flex-col gap-4 relative overflow-hidden transition-all hover:border-primary/30 hover:-translate-y-1">

                            <div class="absolute top-0 left-0 right-0 h-8 bg-primary/5 envelope-flap"></div>

                            <div
                                class="absolute top-4 left-1/2 -translate-x-1/2 flex items-center justify-center size-12 bg-primary rounded-full shadow-md text-white z-10 border-4 border-white dark:border-background-dark">
                                <span class="material-symbols-outlined font-bold fill-1">favorite</span>
                            </div>

                            <div class="flex justify-between items-start mt-4">
                                <div class="flex flex-col">
                                    <span
                                        class="inline-flex items-center px-3 py-1 bg-primary/10 text-primary text-[10px] font-black uppercase tracking-wider rounded-full mb-2 w-fit">
                                        ID: {{ substr(md5($address->id), 0, 4) }}
                                    </span>
                                    <h3 class="text-2xl font-black text-[#181113] dark:text-white uppercase tracking-tight">
                                        {{ $address->name }}
                                    </h3>
                                </div>
                                <div class="text-primary/20 group-hover:text-primary transition-colors">
                                    <span class="material-symbols-outlined text-3xl font-bold">stars</span>
                                </div>
                            </div>

                            <div class="space-y-2 text-primary/70 font-medium">
                                <p class="flex items-center gap-2 text-sm">
                                    <span class="material-symbols-outlined text-primary text-base">phone_iphone</span>
                                    <span class="font-bold">{{ $address->phone }}</span>
                                </p>
                                <div class="flex gap-2">
                                    <span
                                        class="material-symbols-outlined text-primary text-base shrink-0">location_on</span>
                                    <p class="text-sm leading-relaxed">
                                        {{ $address->address }}<br>
                                        {{ $address->city }}, {{ $address->province }}<br>
                                        <span class="font-black text-primary/90">Postal Code:
                                            {{ $address->postal_code }}</span>
                                    </p>
                                </div>
                            </div>

                            <div class="flex gap-3 mt-auto pt-4">
                                <a href="{{ route('admin.addresses.edit', $address->id) }}"
                                    class="flex-1 flex items-center justify-center gap-2 px-4 py-3 bg-orange-500 text-white rounded-full font-black text-xs uppercase tracking-widest shadow-md shadow-orange-500/20 hover:scale-105 active:scale-95 transition-transform">
                                    <span class="material-symbols-outlined text-lg">edit</span> Edit
                                </a>

                                <form action="{{ route('admin.addresses.destroy', $address->id) }}" method="POST"
                                    class="flex-1" onsubmit="return confirm('Hapus spot camilan ini selamanya? 🍭')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-emerald-600 text-white rounded-full font-black text-xs uppercase tracking-widest shadow-md shadow-emerald-600/20 hover:scale-105 active:scale-95 transition-transform">
                                        <span class="material-symbols-outlined text-lg">delete</span> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div
                        class="col-span-1 md:col-span-2 border-4 border-dashed border-primary/20 rounded-2xl p-20 flex flex-col items-center justify-center gap-6 text-center bg-primary/5">
                        <div
                            class="size-24 rounded-full bg-white flex items-center justify-center text-primary/20 shadow-inner">
                            <span class="material-symbols-outlined text-6xl">map</span>
                        </div>
                        <div>
                            <h4 class="text-2xl font-black text-primary uppercase">No Snack-Spots Found!</h4>
                            <p class="text-primary/60 font-medium italic mt-2">Your candy map is empty. Let's add a place to
                                deliver your treats!</p>
                        </div>
                        <a href="{{ route('admin.addresses.create') }}"
                            class="px-8 py-4 bg-primary text-white rounded-full font-black uppercase tracking-widest shadow-lg hover:scale-110 transition-transform">
                            Create Your First Spot &rarr;
                        </a>
                    </div>
                @endforelse

                @if ($addresses->isNotEmpty())
                    <a href="{{ route('admin.addresses.create') }}"
                        class="border-4 border-dashed border-primary/20 rounded-xl p-8 flex flex-col items-center justify-center gap-4 text-center group cursor-pointer hover:bg-primary/5 transition-all">
                        <div
                            class="size-16 rounded-full bg-primary/10 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-4xl">add_location</span>
                        </div>
                        <div>
                            <h4 class="text-xl font-black text-primary uppercase">Add another spot?</h4>
                            <p class="text-primary/60 text-sm italic">The more spots, the more snacks!</p>
                        </div>
                    </a>
                @endif

            </div>

        {{-- Back Link --}}
        <div class="mt-12">
            <a href="{{ route('cart.index') }}"
                class="inline-flex items-center gap-2 text-xs font-black uppercase tracking-[0.2em] text-primary/40 hover:text-primary transition-colors">
                <span class="material-symbols-outlined text-sm">arrow_back</span> Back to Cart
            </a>
        </div>
    </main>

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .filled-icon {
            font-variation-settings: 'FILL' 1;
        }

        .lollipop-gradient {
            background: linear-gradient(135deg, #F42559 0%, #ff8da7 100%);
        }

        .envelope-flap {
            clip-path: polygon(0 0, 100% 0, 50% 100%);
        }

        .fill-1 {
            font-variation-settings: 'FILL' 1;
        }
    </style>
@endsection
