@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    @php
        $minPrice = $product->variants->min('price');
    @endphp

    <main class="flex-1 max-w-[1280px] mx-auto w-full px-6 py-8">
        <div class="flex flex-wrap items-center gap-2 pb-6">
            <a class="text-primary/60 text-sm font-semibold hover:text-primary" href="/">Home</a>
            <span class="material-symbols-outlined crumb-heart text-[12px] text-primary">favorite</span>
            <a class="text-primary/60 text-sm font-semibold hover:text-primary"
                href="{{ route('home', ['category' => $product->category->slug]) }}">
                {{ $product->category->name }}
            </a>
            <span class="material-symbols-outlined crumb-heart text-[12px] text-primary">favorite</span>
            <span class="text-primary text-sm font-bold">{{ $product->name }}</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <div class="flex flex-col gap-4">
                <div
                    class="swiper productMainSwiper relative w-full">
                    <div class="swiper-wrapper">
                        @foreach ($product->images as $image)
                            <div class="swiper-slide">
                                <div class="relative z-[1] w-full flex items-center justify-center p-3 sm:p-4">
                                    <div
                                        class="relative inline-flex items-center justify-center rounded-3xl overflow-hidden bg-white dark:bg-white/5 shadow-xl border-4 border-primary/5">
                                        <div
                                            class="absolute inset-0 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-primary/10 via-transparent to-transparent z-0">
                                        </div>
                                        <img src="{{ asset('storage/' . $image->image) }}"
                                            class="relative z-[1] w-auto h-auto max-w-[90vw] md:max-w-[520px] lg:max-w-[620px] max-h-[70vh] object-contain"
                                            alt="{{ $product->name }}">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($product->images->count() > 1)
                        <button type="button"
                            class="product-swiper-prev group absolute left-3 top-1/2 -translate-y-1/2 z-10 h-11 w-11 sm:h-12 sm:w-12 rounded-2xl border-2 border-primary/15 bg-white/80 backdrop-blur-md shadow-lg shadow-primary/15 hover:bg-primary hover:text-white transition-all active:scale-95"
                            aria-label="Previous image">
                            <span class="material-symbols-outlined text-primary group-hover:text-white">chevron_left</span>
                        </button>
                        <button type="button"
                            class="product-swiper-next group absolute right-3 top-1/2 -translate-y-1/2 z-10 h-11 w-11 sm:h-12 sm:w-12 rounded-2xl border-2 border-primary/15 bg-white/80 backdrop-blur-md shadow-lg shadow-primary/15 hover:bg-primary hover:text-white transition-all active:scale-95"
                            aria-label="Next image">
                            <span class="material-symbols-outlined text-primary group-hover:text-white">chevron_right</span>
                        </button>
                    @endif
                </div>

                <div class="swiper productThumbSwiper w-full">
                    <div class="swiper-wrapper">
                        @foreach ($product->images as $image)
                            <div
                                class="swiper-slide !w-[72px] !h-[72px] sm:!w-[84px] sm:!h-[84px] rounded-2xl border-2 border-transparent bg-white/70 dark:bg-white/10 p-2 cursor-pointer transition-all shadow-sm">
                                <img src="{{ asset('storage/' . $image->image) }}" class="w-full h-full object-contain"
                                    alt="Thumbnail">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-8">
                <div class="relative">
                    <div class="flex items-start justify-between">
                        <div class="flex flex-col gap-1">
                            <p class="text-xs font-bold text-primary/60 uppercase tracking-widest">
                                {{ $product->category?->name }}
                            </p>
                            <h1 class="text-4xl md:text-5xl font-extrabold text-primary tracking-tight leading-tight">
                                {{ $product->name }}
                            </h1>
                        </div>
                        <div class="shrink-0 flex flex-col items-end gap-3">
                            <button type="button"
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-full border-2 border-primary/15 bg-white/70 dark:bg-white/10 backdrop-blur-md hover:border-primary/30 transition-all"
                                data-wishlist-toggle
                                data-wishlist-url="{{ route('wishlist.toggle', $product) }}"
                                data-wishlist-active="{{ ($wishlisted ?? false) ? '1' : '0' }}"
                                aria-label="Toggle wishlist">
                                <span class="material-symbols-outlined wishlist-icon {{ ($wishlisted ?? false) ? 'is-on text-primary' : 'text-primary/40' }}">favorite</span>
                                <span class="text-sm font-extrabold text-primary">Wishlist</span>
                            </button>

                            <div class="text-right">
                                <p class="text-xs font-bold text-primary/60 uppercase tracking-widest">Harga</p>
                                <div id="display_price" class="text-primary font-extrabold text-2xl leading-none">
                                @if (is_null($minPrice))
                                    —
                                @else
                                    Rp {{ number_format($minPrice, 0, ',', '.') }}
                                @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="text-primary/70 text-lg font-medium mt-4 italic">
                        "{{ $product->description_short ?? 'Sweet, fluffy, and magically delicious!' }}"</p>
                </div>

                <form action="{{ route('cart.add') }}" method="POST" class="flex flex-col gap-8">
                    @csrf
                    <input type="hidden" name="product_name" value="{{ $product->name }}">
                    <input type="hidden" id="selected_price" name="price" value="{{ $minPrice ?? 0 }}">

                    <div class="flex flex-col gap-4">
                        <p class="font-bold uppercase tracking-wider text-sm">Select Variant</p>
                        <div class="flex flex-wrap gap-4">
                            @foreach ($product->variants as $variant)
                                <label
                                    class="group flex flex-col items-center gap-2 cursor-pointer {{ $variant->stock == 0 ? 'opacity-30' : '' }}">
                                    <input type="radio" name="variant_id" value="{{ $variant->id }}"
                                        data-price="{{ $variant->price }}" onchange="updatePrice(this)"
                                        class="peer sr-only" {{ $variant->stock == 0 ? 'disabled' : 'required' }}>

                                    <div class="size-12 rounded-full border-[3px] border-primary/20 flex items-center justify-center transition-all 
                                    peer-checked:border-primary peer-checked:bg-primary/10 group-hover:scale-110 macaron-shadow"
                                        style="background-color: {{ $variant->hex_color ?? '#FCA5A5' }}">
                                        @if ($variant->stock == 0)
                                            <span class="text-[8px] text-white font-bold">X</span>
                                        @endif
                                    </div>
                                    <span class="text-[10px] font-bold text-primary uppercase">{{ $variant->size }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex flex-col gap-4 mt-4">
                        <div class="flex items-center gap-4">
                            <div
                                class="flex items-center bg-white dark:bg-white/10 rounded-full border-2 border-primary/20 p-1">
                                <button type="button" onclick="this.nextElementSibling.stepDown()"
                                    class="size-10 flex items-center justify-center rounded-full hover:bg-primary/10 text-primary">
                                    <span class="material-symbols-outlined">remove</span>
                                </button>
                                <input type="number" name="qty" value="1" min="1"
                                    class="w-12 text-center font-black text-lg bg-transparent border-none focus:ring-0">
                                <button type="button" onclick="this.previousElementSibling.stepUp()"
                                    class="size-10 flex items-center justify-center rounded-full hover:bg-primary/10 text-primary">
                                    <span class="material-symbols-outlined">add</span>
                                </button>
                            </div>
                            <p class="text-sm font-bold text-primary/60 uppercase">
                                {{ $product->variants->sum('stock') > 0 ? 'In Stock (Limited)' : 'Out of Stock' }}
                            </p>
                        </div>

                        <button type="submit" {{ $product->variants->sum('stock') == 0 ? 'disabled' : '' }}
                            class="bg-primary text-white glossy-button rounded-full py-5 px-8 flex items-center justify-center gap-3 shadow-[0_8px_20px_-5px_rgba(244,37,89,0.5)] active:scale-95 transition-all disabled:opacity-50 disabled:grayscale">
                            <span class="material-symbols-outlined text-3xl">icecream</span>
                            <span class="text-xl font-black uppercase tracking-tighter">
                                {{ $product->variants->sum('stock') == 0 ? 'Sold Out' : 'Add to Shopping Cart' }}
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-20">
            <div class="candy-cane-border rounded-xl p-1 bg-white">
                <div class="bg-white p-10 rounded-lg">
                    <div class="flex items-center gap-4 mb-6">
                        <span class="material-symbols-outlined text-primary text-4xl">celebration</span>
                        <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight text-gray-900">Detail
                            {{ $product->name }}</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                        <div class="md:col-span-2 text-lg leading-relaxed text-[#181113]/80">
                            {!! $product->description !!}
                        </div>
                        <div class="bg-primary/5 rounded-xl p-6 border border-primary/20">
                            <h3 class="font-black uppercase mb-4 text-primary text-sm">Ingredients & Info</h3>
                            <p class="text-xs font-medium leading-relaxed opacity-70 italic">
                                {{ $product->ingredients ?? 'Komposisi belum tersedia.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="mt-16">
            <div class="flex items-end justify-between px-2 mb-8">
                <div>
                    <h2 class="text-3xl font-black mb-2">Produk yang disarankan</h2>
                    <p class="text-zinc-500 font-medium">
                        {{ $product->category?->name ? 'Kategori: ' . $product->category->name : 'Pilihan untuk kamu' }}
                    </p>
                </div>
                <a class="text-primary font-bold hover:underline flex items-center gap-1" href="{{ route('shop.index', ['category' => $product->category?->slug]) }}">
                    Lihat di Shop <span class="material-symbols-outlined text-sm">open_in_new</span>
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                @forelse (($relatedProducts ?? collect()) as $rp)
                    @php
                        $img = $rp->images->first();
                        $minPrice = $rp->variants_min_price ?? $rp->variants?->min('price');
                        $isWishlisted = in_array($rp->id, $wishlistProductIds ?? [], true);
                    @endphp

                    <a href="{{ route('product.show', $rp->slug) }}"
                        class="product-card group relative bg-white p-3 sm:p-4 rounded-xl shadow-xl shadow-primary/5 hover:shadow-primary/10 transition-all border-2 border-transparent hover:border-primary/20">
                        <button type="button"
                            class="heart-anim {{ $isWishlisted ? 'opacity-100' : 'opacity-0' }} absolute top-3 right-3 z-10 transition-all duration-300"
                            data-wishlist-toggle
                            data-wishlist-url="{{ route('wishlist.toggle', $rp) }}"
                            data-wishlist-active="{{ $isWishlisted ? '1' : '0' }}"
                            aria-label="Toggle wishlist">
                            <span class="wishlist-bubble inline-flex items-center justify-center h-9 w-9 rounded-2xl backdrop-blur-md">
                                <span class="material-symbols-outlined wishlist-icon {{ $isWishlisted ? 'is-on text-primary' : 'text-primary/40' }}">favorite</span>
                            </span>
                        </button>

                        <div class="aspect-square rounded-lg bg-pink-50 mb-4 flex items-center justify-center overflow-hidden">
                            @if ($img)
                                <img class="w-full h-full object-cover group-hover:scale-105 transition-transform"
                                    src="{{ asset('storage/' . ltrim($img->image, '/')) }}" alt="{{ $rp->name }}" />
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <span class="text-primary/40 text-xs font-bold uppercase tracking-widest">No Image</span>
                                </div>
                            @endif
                        </div>

                        <div class="space-y-2">
                            <div class="flex justify-between items-start gap-3">
                                <h3 class="text-sm sm:text-lg font-extrabold text-gray-800 leading-tight line-clamp-2">
                                    {{ $rp->name }}
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
                                {{ $rp->category?->name }}
                            </p>

                            <div class="w-full bg-primary/10 text-primary font-bold py-2.5 rounded-full group-hover:bg-primary group-hover:text-white transition-all flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-lg">open_in_new</span>
                                View Details
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center text-zinc-500 font-medium">
                        Belum ada produk lain di kategori ini.
                    </div>
                @endforelse
            </div>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        var thumbSwiper = new Swiper(".productThumbSwiper", {
            spaceBetween: 10,
            slidesPerView: 'auto',
            watchSlidesProgress: true,
            freeMode: true,
        });

        var mainSwiper = new Swiper(".productMainSwiper", {
            spaceBetween: 10,
            navigation: {
                nextEl: ".product-swiper-next",
                prevEl: ".product-swiper-prev",
            },
            thumbs: {
                swiper: thumbSwiper,
            },
            grabCursor: true,
            autoHeight: true,
        });

        function updatePrice(element) {
            const price = element.getAttribute('data-price');
            document.getElementById('selected_price').value = price;
            document.getElementById('display_price').innerText = 'Rp ' + Number(price).toLocaleString('id-ID');
        }
    </script>

    <style>
        .macaron-shadow {
            box-shadow: 0 4px 0 rgba(0, 0, 0, 0.1);
        }

        .productThumbSwiper .swiper-slide-thumb-active {
            border-color: #F42559 !important;
            /* Tailwind primary */
            opacity: 1;
        }

        .productThumbSwiper .swiper-slide {
            opacity: 0.75;
        }

        .productThumbSwiper .swiper-slide-thumb-active {
            opacity: 1;
        }

        .candy-cane-border {
            background: repeating-linear-gradient(45deg, #F42559, #F42559 10px, #ffffff 10px, #ffffff 20px);
        }

        /* Hide arrows in number input */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
@endsection
