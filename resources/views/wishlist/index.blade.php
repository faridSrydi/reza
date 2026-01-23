@extends('layouts.user')

@section('title', 'Wishlist')

@section('user_content')
    <div class="w-full py-2 sm:py-4">
        <div class="flex items-center gap-2 mb-6">
            <a class="text-primary/60 text-sm font-semibold hover:text-primary" href="{{ route('home') }}">Home</a>
            <span class="material-symbols-outlined crumb-heart text-[12px] text-primary">favorite</span>
            <span class="text-primary text-sm font-bold">Wishlist</span>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3 mb-8">
            <div>
                <h1 class="text-4xl font-extrabold text-primary tracking-tight">Your Wishlist</h1>
                <p class="text-primary/60 font-semibold">Saved treats you love</p>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-6 bg-white border-2 border-primary/10 rounded-2xl p-4 text-primary font-bold">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            @forelse ($products as $product)
                @php
                    $image = $product->images->first();
                    $minPrice = $product->variants_min_price ?? $product->variants?->min('price');
                @endphp

                <div class="product-card group relative bg-white p-3 sm:p-4 rounded-xl shadow-xl shadow-primary/5 hover:shadow-primary/10 transition-all border-2 border-transparent hover:border-primary/20">
                    <button type="button"
                        class="heart-anim opacity-100 absolute top-3 right-3 z-10 transition-all duration-300"
                        data-wishlist-toggle
                        data-wishlist-url="{{ route('wishlist.toggle', $product) }}"
                        data-wishlist-active="1"
                        aria-label="Remove from wishlist">
                        <span class="wishlist-bubble inline-flex items-center justify-center h-9 w-9 rounded-2xl backdrop-blur-md">
                            <span class="material-symbols-outlined wishlist-icon is-on text-primary">favorite</span>
                        </span>
                    </button>

                    <a href="{{ route('product.show', $product->slug) }}" class="block">
                        <div class="aspect-square rounded-lg bg-pink-50 mb-4 flex items-center justify-center overflow-hidden">
                            @if ($image)
                                <img class="w-full h-full object-cover group-hover:scale-105 transition-transform"
                                    src="{{ asset('storage/' . ltrim($image->image, '/')) }}" alt="{{ $product->name }}" />
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <span class="text-primary/40 text-xs font-bold uppercase tracking-widest">No Image</span>
                                </div>
                            @endif
                        </div>

                        <div class="space-y-2">
                            <div class="flex justify-between items-start gap-3">
                                <h3 class="text-sm sm:text-lg font-extrabold text-gray-800 leading-tight line-clamp-2">
                                    {{ $product->name }}
                                </h3>
                                <span class="text-primary font-bold whitespace-nowrap text-sm sm:text-base">
                                    @if (is_null($minPrice))
                                        —
                                    @else
                                        Rp {{ number_format($minPrice, 0, ',', '.') }}
                                    @endif
                                </span>
                            </div>

                            <p class="text-xs font-bold text-primary/60 uppercase tracking-widest">
                                {{ $product->category?->name }}
                            </p>

                            <div class="w-full bg-primary/10 text-primary font-bold py-2.5 rounded-full group-hover:bg-primary group-hover:text-white transition-all flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-lg">open_in_new</span>
                                View Details
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-span-full bg-white p-8 rounded-xl border-2 border-primary/10">
                    <p class="text-primary font-bold">Wishlist kamu masih kosong.</p>
                    <p class="text-primary/60 text-sm font-semibold mt-1">Buka Shop dan klik icon hati untuk simpan produk.</p>
                    <a href="{{ route('shop.index') }}" class="inline-flex mt-4 bg-primary text-white font-bold px-6 py-3 rounded-full hover:scale-105 transition-transform">
                        Go to Shop
                    </a>
                </div>
            @endforelse
        </div>

        <div class="mt-10 flex justify-center">
            {{ $products->onEachSide(1)->links() }}
        </div>
    </div>
@endsection
