@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <style>
        .filled-icon {
            font-variation-settings: 'FILL' 1;
        }

        .product-card:hover .heart-anim {
            opacity: 1;
            transform: translateY(-6px) scale(1.04);
        }

        .wishlist-bubble {
            background: linear-gradient(135deg, rgba(255, 235, 240, 0.95), rgba(255, 255, 255, 0.85));
            border: 2px solid rgba(244, 37, 89, 0.18);
            box-shadow: 0 10px 30px -12px rgba(244, 37, 89, 0.35);
        }

        .wishlist-bubble .material-symbols-outlined {
            font-size: 18px;
        }
    </style>

    <main class="flex-1 max-w-[1280px] mx-auto w-full px-6 py-8">

        <!-- Hero Section -->
        <section class="relative overflow-hidden rounded-3xl mb-12">
            <div class="swiper homeHeroSwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="grid lg:grid-cols-2 bg-gradient-to-br from-[#ffdde5] to-[#f42559]/10 rounded-3xl min-h-[380px] sm:min-h-[460px] lg:min-h-[520px] items-center p-6 sm:p-10 lg:p-12 relative">
                            <span class="material-symbols-outlined absolute top-10 left-10 text-primary/20 text-6xl">favorite</span>
                            <span class="material-symbols-outlined absolute bottom-10 right-1/2 text-primary/20 text-5xl">stars</span>
                            <span class="material-symbols-outlined absolute top-20 right-20 text-primary/20 text-7xl">icecream</span>
                            <div class="relative z-10 space-y-8">
                                <div class="space-y-4">
                                    <span class="inline-block bg-white/80 px-4 py-1.5 rounded-full text-primary text-sm font-extrabold tracking-wider uppercase">New Collection</span>
                                    <h1 class="text-4xl sm:text-5xl lg:text-7xl font-black text-[#181113] leading-[1.1] tracking-tight">
                                        Sweet Cravings <br /><span class="text-primary">Delivered!</span>
                                    </h1>
                                    <p class="text-lg text-zinc-600 font-medium max-w-md">
                                        Indulge in our collection of whimsical snacks and delightful treats.
                                    </p>
                                </div>
                                <a href="{{ route('shop.index') }}" class="group inline-flex items-center gap-3 bg-primary text-white px-8 py-5 rounded-full font-black text-lg shadow-xl shadow-primary/40 hover:scale-105 transition-transform">
                                    Shop All Sweets
                                    <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                                </a>
                            </div>
                            <div class="relative hidden sm:flex justify-center items-center">
                                <div class="absolute inset-0 bg-white/40 blur-3xl rounded-full scale-75"></div>
                                <img class="relative z-10 w-full max-w-[260px] md:max-w-md drop-shadow-2xl" alt="Candy mascot" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAJchAPKLokWH_wn16f8dui80gevWVoDmg17nmrgwgmKkGXapu9ZFCxPUyZHeBn4UKvjNU5dNY_922HOavzvPd96LZw_gwJ59QUNKxrwm56LZacOdZNVHThNYvqSxC-t9cC4PlDW2OgI2xC9jQCWRnF8x61vIOFJkdTVXYbGQbXYoMhrkbmAb4Fxj-jEebBfJRTXlTMX4nadKiUSv6etXB0muPtaot3vCvLMOMEM1UVV-j_mqrJX4iHGC6deMUnVa4I82ie021MU64" />
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="grid lg:grid-cols-2 bg-gradient-to-br from-[#fff5cf] to-[#f42559]/10 rounded-3xl min-h-[380px] sm:min-h-[460px] lg:min-h-[520px] items-center p-6 sm:p-10 lg:p-12 relative">
                            <span class="material-symbols-outlined absolute top-10 left-10 text-primary/20 text-6xl">local_mall</span>
                            <span class="material-symbols-outlined absolute bottom-10 right-1/2 text-primary/20 text-5xl">auto_awesome</span>
                            <span class="material-symbols-outlined absolute top-20 right-20 text-primary/20 text-7xl">cookie</span>
                            <div class="relative z-10 space-y-8">
                                <div class="space-y-4">
                                    <span class="inline-block bg-white/80 px-4 py-1.5 rounded-full text-primary text-sm font-extrabold tracking-wider uppercase">Fresh Drops</span>
                                    <h2 class="text-4xl sm:text-5xl lg:text-7xl font-black text-[#181113] leading-[1.1] tracking-tight">
                                        New Treats <br /><span class="text-primary">Every Week</span>
                                    </h2>
                                    <p class="text-lg text-zinc-600 font-medium max-w-md">
                                        Discover the newest snacks added by our admin.
                                    </p>
                                </div>
                                <a href="#best-sellers" class="group inline-flex items-center gap-3 bg-primary text-white px-8 py-5 rounded-full font-black text-lg shadow-xl shadow-primary/40 hover:scale-105 transition-transform">
                                    See Newest
                                    <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                                </a>
                            </div>
                            <div class="relative hidden sm:flex justify-center items-center">
                                <div class="absolute inset-0 bg-white/40 blur-3xl rounded-full scale-75"></div>
                                <img class="relative z-10 w-full max-w-[260px] md:max-w-md drop-shadow-2xl" alt="Sweet snacks" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBv1fqkcqk1p9q_MdQilDQ8V4-yXiWbkdWV2gJhWL8J6HAO7KYGNfjdq7o4FJnQLOvoSDdZaCR9PPw3J_7T9MJ3jbcBGayvouS9uUDzzGUt_jUiMPk8nT2Aqw1-KUsq8d3ZSNjXGzQbCTCxpLxSQmt6ZZ5tNDJTSUaGplqJ28PWpQEwf-qGppTd2nyUBiFpIZhBX2510fJNUhrgy-kPnwuCHKY0GfR9P9IDtCPciuEJqrq0zQYA7Yp7FF49EnRLDcBDSSzPthB-MnQ" />
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="grid lg:grid-cols-2 bg-gradient-to-br from-[#dff7ff] to-[#f42559]/10 rounded-3xl min-h-[380px] sm:min-h-[460px] lg:min-h-[520px] items-center p-6 sm:p-10 lg:p-12 relative">
                            <span class="material-symbols-outlined absolute top-10 left-10 text-primary/20 text-6xl">category</span>
                            <span class="material-symbols-outlined absolute bottom-10 right-1/2 text-primary/20 text-5xl">shopping_bag</span>
                            <span class="material-symbols-outlined absolute top-20 right-20 text-primary/20 text-7xl">cake</span>
                            <div class="relative z-10 space-y-8">
                                <div class="space-y-4">
                                    <span class="inline-block bg-white/80 px-4 py-1.5 rounded-full text-primary text-sm font-extrabold tracking-wider uppercase">Browse Categories</span>
                                    <h2 class="text-4xl sm:text-5xl lg:text-7xl font-black text-[#181113] leading-[1.1] tracking-tight">
                                        Find Your <br /><span class="text-primary">Perfect Flavor</span>
                                    </h2>
                                    <p class="text-lg text-zinc-600 font-medium max-w-md">
                                        Swipe categories and jump right into the shop.
                                    </p>
                                </div>
                                <a href="#categories" class="group inline-flex items-center gap-3 bg-primary text-white px-8 py-5 rounded-full font-black text-lg shadow-xl shadow-primary/40 hover:scale-105 transition-transform">
                                    Explore
                                    <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                                </a>
                            </div>
                            <div class="relative hidden sm:flex justify-center items-center">
                                <div class="absolute inset-0 bg-white/40 blur-3xl rounded-full scale-75"></div>
                                <img class="relative z-10 w-full max-w-[260px] md:max-w-md drop-shadow-2xl" alt="Category shopping" src="{{asset('assets/images/slider/slider1.jpg')}}" />
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" class="home-hero-prev group absolute left-4 top-1/2 -translate-y-1/2 z-10 h-12 w-12 rounded-2xl border-2 border-primary/15 bg-white/80 backdrop-blur-md shadow-lg shadow-primary/15 hover:bg-primary hover:text-white transition-all active:scale-95" aria-label="Previous slide">
                    <span class="material-symbols-outlined text-primary group-hover:text-white">chevron_left</span>
                </button>
                <button type="button" class="home-hero-next group absolute right-4 top-1/2 -translate-y-1/2 z-10 h-12 w-12 rounded-2xl border-2 border-primary/15 bg-white/80 backdrop-blur-md shadow-lg shadow-primary/15 hover:bg-primary hover:text-white transition-all active:scale-95" aria-label="Next slide">
                    <span class="material-symbols-outlined text-primary group-hover:text-white">chevron_right</span>
                </button>

                <div class="home-hero-pagination absolute bottom-4 left-0 right-0 flex justify-center z-10"></div>
            </div>
        </section>
        <!-- Browse Categories -->
        <section id="categories" class="mb-16">
            <div class="flex items-end justify-between px-2 mb-8">
                <div>
                    <h2 class="text-3xl font-black mb-2">Sweet Categories</h2>
                    <p class="text-zinc-500 font-medium">Find exactly what your heart desires</p>
                </div>
                <a class="text-primary font-bold hover:underline flex items-center gap-1" href="{{ route('shop.index') }}">
                    View All <span class="material-symbols-outlined text-sm">open_in_new</span>
                </a>
            </div>
            <div class="relative">
                <div class="swiper homeCategoriesSwiper">
                    <div class="swiper-wrapper">
                        @foreach ($categories as $category)
                            <div class="swiper-slide">
                                <a href="{{ route('shop.index', ['category' => $category->slug]) }}" class="group block">
                                    <div class="relative aspect-square rounded-2xl overflow-hidden mb-4 bg-white shadow-md shadow-primary/5 transition-all duration-300 group-hover:-translate-y-1 group-hover:shadow-xl group-hover:shadow-primary/15">
                                        <div class="w-full h-full bg-cover bg-center"
                                            @if ($category->image)
                                                style='background-image: url("{{ asset('storage/' . ltrim($category->image, '/')) }}")'
                                            @else
                                                style='background-image: radial-gradient(circle at top, rgba(244,37,89,0.25), rgba(255,143,177,0.08)), linear-gradient(135deg, rgba(244,37,89,0.12), rgba(255,255,255,0.0))'
                                            @endif
                                        >
                                            <div class="w-full h-full"></div>
                                        </div>
                                    </div>
                                    <h3 class="text-xl font-black text-center group-hover:text-primary transition-colors">{{ $category->name }}</h3>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <div class="home-categories-pagination mt-6 flex justify-center"></div>
                </div>
            </div>
        </section>
        <!-- Featured Sweets -->
        <section id="best-sellers" class="mb-20">
            <div class="flex items-end justify-between px-2 mb-8">
                <div>
                    <h2 class="text-3xl font-black mb-2">Best Sellers</h2>
                    <p class="text-zinc-500 font-medium">Newest products just added</p>
                </div>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                @forelse ($newestProducts as $product)
                    @php
                        $img = $product->images->first();
                        $minPrice = $product->variants_min_price ?? $product->variants?->min('price');
                        $wishlisted = in_array($product->id, $wishlistProductIds ?? [], true);
                    @endphp
                    <a href="{{ route('product.show', $product->slug) }}"
                        class="product-card group relative bg-white p-3 sm:p-4 rounded-xl shadow-xl shadow-primary/5 hover:shadow-primary/10 transition-all border-2 border-transparent hover:border-primary/20">
                        <button type="button"
                            class="heart-anim {{ $wishlisted ? 'opacity-100' : 'opacity-0' }} absolute top-3 right-3 z-10 transition-all duration-300"
                            data-wishlist-toggle
                            data-wishlist-url="{{ route('wishlist.toggle', $product) }}"
                            data-wishlist-active="{{ $wishlisted ? '1' : '0' }}"
                            aria-label="Toggle wishlist">
                            <span class="wishlist-bubble inline-flex items-center justify-center h-9 w-9 rounded-2xl backdrop-blur-md">
                                <span class="material-symbols-outlined wishlist-icon {{ $wishlisted ? 'is-on text-primary' : 'text-primary/40' }}">favorite</span>
                            </span>
                        </button>

                        <div class="aspect-square rounded-lg bg-pink-50 mb-4 flex items-center justify-center overflow-hidden">
                            @if ($img)
                                <img class="w-full h-full object-cover group-hover:scale-105 transition-transform"
                                    src="{{ asset('storage/' . ltrim($img->image, '/')) }}" alt="{{ $product->name }}" />
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
                @empty
                    <div class="col-span-full text-center text-zinc-500 font-medium">
                        No products yet.
                    </div>
                @endforelse
            </div>

            <div class="mt-10 flex justify-center">
                <a href="{{ route('shop.index') }}"
                    class="inline-flex items-center gap-3 bg-primary text-white px-10 py-4 rounded-full font-black text-sm sm:text-base shadow-xl shadow-primary/30 hover:shadow-primary/40 hover:scale-105 transition-all active:scale-95">
                    Go to Shop
                    <span class="material-symbols-outlined">shopping_bag</span>
                </a>
            </div>
        </section>
        <!-- Newsletter Section -->
        <section class="mb-12">
            <div
                class="bg-primary rounded-xl p-8 lg:p-16 flex flex-col lg:flex-row items-center justify-between gap-12 text-white overflow-hidden relative">
                <span
                    class="material-symbols-outlined absolute top-[-20px] right-[-20px] text-white/10 text-9xl">heart_plus</span>
                <div class="space-y-4 max-w-lg relative z-10">
                    <h2 class="text-4xl font-black">Join the Sweet Life!</h2>
                    <p class="text-white/80 font-medium">Get exclusive discounts, early access to new snacks, and sweet
                        surprises delivered to your inbox.</p>
                </div>
                <form class="flex flex-col sm:flex-row w-full max-w-md gap-3 relative z-10">
                    <input
                        class="flex-1 bg-white/20 border-2 border-white/30 rounded-full py-4 px-6 text-white placeholder:text-white/60 focus:ring-0 focus:border-white transition-all"
                        placeholder="Enter your email" type="email" />
                    <button
                        class="bg-white text-primary px-8 py-4 rounded-full font-black hover:bg-candy-pink transition-colors"
                        type="submit">Subscribe</button>
                </form>
            </div>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        (function () {
            // Hero slider
            new Swiper('.homeHeroSwiper', {
                loop: true,
                autoplay: {
                    delay: 3500,
                    disableOnInteraction: false,
                },
                navigation: {
                    nextEl: '.home-hero-next',
                    prevEl: '.home-hero-prev',
                },
                pagination: {
                    el: '.home-hero-pagination',
                    clickable: true,
                },
                speed: 700,
            });

            // Categories carousel
            new Swiper('.homeCategoriesSwiper', {
                loop: {{ $categories->count() > 3 ? 'true' : 'false' }},
                slidesPerView: 2,
                spaceBetween: 20,
                autoplay: {
                    delay: 2500,
                    disableOnInteraction: false,
                },
                grabCursor: true,
                pagination: {
                    el: '.home-categories-pagination',
                    clickable: true,
                },
                breakpoints: {
                    768: {
                        slidesPerView: 3,
                    },
                    1024: {
                        slidesPerView: 4,
                    },
                },
            });
        })();
    </script>
@endsection
