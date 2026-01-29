@extends('layouts.app')

@section('content')
          <!-- Hero Section -->
        <section class="px-6 lg:px-20 py-6">
            <div class="relative w-full aspect-[21/9] min-h-[500px] overflow-hidden rounded-xl bg-cover bg-center flex items-center px-12 lg:px-24"
                data-alt="High-end beauty model with glowing skin and pink makeup"
                style='background-image: linear-gradient(to right, rgba(0, 0, 0, 0.4) 0%, rgba(0, 0, 0, 0) 100%), url("https://lh3.googleusercontent.com/aida-public/AB6AXuDFeTl7PnG9U0aHcyHFA3ogsywCj940rvmBlVRIyq9my06vaxkI_CkIoErnt0GWFebrwjKGINyCUWsPOOsdke3L5PtjvCpBFMD-aGQL2Dmupx_Bx8cIL82O6SRVFBj2PJroYNZ1u3X0scLk2BqydpkyVzx_U2hDmXk5BPrJQAf_5CESRe69VB-mKY6XCKrICACEPL34stqbS5AxGJFCpVimFlTWfNQhAO0u4-mj6yqwuB0g939FgoTfpTZyDCbym7yHwLJTycxrFBM");'>
                <div class="max-w-xl flex flex-col gap-6">
                    <div class="flex flex-col gap-2">
                        <span class="text-white/80 uppercase tracking-[0.2em] text-sm font-bold">Bunga Cosmetics</span>
                        <h1 class="text-white text-5xl lg:text-7xl font-bold leading-tight serif-text">
                            The Summer <br /><span class="italic font-normal">Glow</span> Collection
                        </h1>
                        <p class="text-white/90 text-lg font-light leading-relaxed max-w-md">
                            Experience the pinnacle of luxury makeup and skincare. Infused with diamond dust and floral
                            extracts.
                        </p>
                    </div>
                    <div class="flex gap-4">
                        <a href="{{ route('shop.index') }}"
                            class="flex min-w-[160px] cursor-pointer items-center justify-center rounded-lg h-14 px-8 bg-primary text-white text-base font-bold transition-transform hover:scale-105">
                            Shop Now
                        </a>
                        <a href="#categories"
                            class="flex min-w-[160px] cursor-pointer items-center justify-center rounded-lg h-14 px-8 bg-white/20 backdrop-blur-md border border-white/30 text-white text-base font-bold transition-colors hover:bg-white/30">
                            Discover
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <!-- Category Grid -->
        <section id="categories" class="px-6 lg:px-20 py-12">
            <h2 class="text-2xl font-bold mb-8 serif-text">Shop by Category</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-6">
                @forelse($categories as $category)
                    @php
                        $categoryImg = $category->image
                            ? asset('storage/' . ltrim($category->image, '/'))
                            : ('https://ui-avatars.com/api/?name=' . urlencode($category->name) . '&background=f3e7ed&color=1b0d14');
                        $isActive = request('category') === $category->slug;
                    @endphp

                    <a href="{{ route('home', ['category' => $category->slug]) }}"
                        class="group flex flex-col items-center gap-4 cursor-pointer {{ $isActive ? 'opacity-100' : '' }}"
                        aria-label="Category: {{ $category->name }}">
                        <div
                            class="relative size-32 lg:size-48 rounded-full overflow-hidden border border-[#e7cfdb] transition-transform group-hover:scale-105">
                            <div class="absolute inset-0 {{ $isActive ? 'bg-primary/25' : 'bg-primary/10' }} group-hover:bg-primary/20 transition-colors"></div>
                            <div class="w-full h-full bg-cover bg-center" style='background-image: url("{{ $categoryImg }}");'>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-center">{{ $category->name }}</h3>
                    </a>
                @empty
                    <div class="col-span-full text-primary/70 font-semibold">
                        Belum ada kategori.
                    </div>
                @endforelse
            </div>
        </section>
        <!-- New Arrivals / Carousel -->
        <section class="px-6 lg:px-20 py-12 bg-white dark:bg-[#1b0d14]/50">
            <div class="flex items-end justify-between mb-8">
                <div>
                    <span class="text-primary font-bold uppercase tracking-widest text-xs">Fresh Picks</span>
                    <h2 class="text-3xl font-bold serif-text">New Arrivals</h2>
                </div>
                <div class="flex gap-2">
                    <button
                        class="size-10 rounded-full border border-[#f3e7ed] dark:border-[#3d2030] flex items-center justify-center hover:bg-primary hover:text-white transition-colors">
                        <span class="material-symbols-outlined">chevron_left</span>
                    </button>
                    <button
                        class="size-10 rounded-full border border-[#f3e7ed] dark:border-[#3d2030] flex items-center justify-center hover:bg-primary hover:text-white transition-colors">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </button>
                </div>
            </div>
            <div class="flex gap-6 overflow-x-auto pb-4 no-scrollbar">
                @forelse($newestProducts as $product)
                    @php
                        $firstImage = optional($product->images->first())->image;
                        $imgSrc = $firstImage
                            ? asset('storage/' . ltrim($firstImage, '/'))
                            : ('https://ui-avatars.com/api/?name=' . urlencode($product->name) . '&background=f3e7ed&color=1b0d14');
                        $minPrice = $product->variants_min_price ?? null;
                    @endphp

                    <a href="{{ route('product.show', $product->slug) }}" class="min-w-[280px] group block">
                        <div class="relative aspect-[3/4] bg-[#f8f6f7] dark:bg-[#2d1622] rounded-xl overflow-hidden mb-4">
                            <div class="w-full h-full bg-cover bg-center transition-transform duration-500 group-hover:scale-110"
                                style='background-image: url("{{ $imgSrc }}");'>
                            </div>
                            <div
                                class="absolute bottom-4 left-4 right-4 translate-y-12 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                                <div
                                    class="w-full h-11 bg-white text-[#1b0d14] font-bold rounded-lg shadow-xl text-sm hover:bg-primary hover:text-white flex items-center justify-center">
                                    View
                                </div>
                            </div>
                            <span
                                class="absolute top-4 left-4 bg-primary text-white text-[10px] font-bold px-2 py-1 rounded">NEW</span>
                        </div>
                        <h3 class="font-bold text-lg mb-1 line-clamp-1">{{ $product->name }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2 line-clamp-1">
                            {{ $product->category?->name ?? 'Uncategorized' }}
                        </p>
                        <p class="font-bold text-primary">
                            @if (is_null($minPrice))
                                Rp —
                            @else
                                Rp {{ number_format((float) $minPrice, 0, ',', '.') }}
                            @endif
                        </p>
                    </a>
                @empty
                    <div class="text-primary/70 font-semibold">Belum ada produk terbaru.</div>
                @endforelse
            </div>
        </section>
        <!-- Best Sellers Section -->
        <section class="px-6 lg:px-20 py-12">
            <h2 class="text-3xl font-bold mb-10 serif-text text-center">
                {{ request('category') ? 'Products' : 'Latest Products' }}
            </h2>

            @if(request('category'))
                <div class="mb-8 text-center">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-primary font-bold hover:underline">
                        <span class="material-symbols-outlined">close</span>
                        Clear category filter
                    </a>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse($products as $product)
                    @php
                        $image = optional($product->images->first())->image;
                        $imgSrc = $image
                            ? asset('storage/' . ltrim($image, '/'))
                            : ('https://ui-avatars.com/api/?name=' . urlencode($product->name) . '&background=f3e7ed&color=1b0d14');
                        $minPrice = $product->variants->min('price');
                        $inWishlist = in_array($product->id, $wishlistProductIds ?? [], true);
                    @endphp

                    <div class="flex flex-col gap-3">
                        <a href="{{ route('product.show', $product->slug) }}"
                            class="relative aspect-square rounded-xl overflow-hidden group bg-white border border-[#f3e7ed]">
                            <div class="w-full h-full bg-cover bg-center group-hover:scale-105 transition-transform duration-500"
                                style='background-image: url("{{ $imgSrc }}");'>
                            </div>

                            @auth
                                <button type="button"
                                    class="absolute top-4 right-4 size-10 rounded-full bg-white shadow-md flex items-center justify-center transition-colors {{ $inWishlist ? 'text-primary' : 'text-gray-400 hover:text-primary' }}"
                                    data-wishlist-toggle
                                    data-wishlist-url="{{ route('wishlist.toggle', $product) }}"
                                    data-wishlist-active="{{ $inWishlist ? 1 : 0 }}"
                                    aria-label="Wishlist">
                                    <span class="material-symbols-outlined">favorite</span>
                                </button>
                            @endauth
                        </a>

                        <div class="flex justify-between items-start gap-3">
                            <div>
                                <h4 class="font-bold text-base line-clamp-2">{{ $product->name }}</h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold mt-1">
                                    {{ $product->category?->name ?? 'Uncategorized' }}
                                </p>
                            </div>
                            <span class="font-bold text-primary whitespace-nowrap">
                                @if (is_null($minPrice))
                                    Rp —
                                @else
                                    Rp {{ number_format((float) $minPrice, 0, ',', '.') }}
                                @endif
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-primary/70 font-semibold">
                        Belum ada produk.
                    </div>
                @endforelse
            </div>

            @if(method_exists($products, 'links'))
                <div class="mt-10 flex justify-center">
                    {{ $products->onEachSide(1)->links() }}
                </div>
            @endif
        </section>
        <!-- Newsletter Section -->
        <section class="px-6 lg:px-20 py-20">
            <div
                class="bg-primary/5 dark:bg-[#3d2030] rounded-2xl p-10 lg:p-20 text-center flex flex-col items-center gap-6">
                <span class="material-symbols-outlined text-5xl text-primary">mail</span>
                <h2 class="text-3xl lg:text-5xl font-bold serif-text">Join the Bunga Cosmetics List</h2>
                <p class="text-lg text-gray-600 dark:text-gray-300 max-w-lg">
                    Subscribe for exclusive access to new product launches, makeup masterclasses, and private events.
                </p>
                <div class="flex w-full max-w-md gap-3 mt-4">
                    <input
                        class="form-input flex-1 border-[#e7cfdb] dark:border-[#522d41] rounded-lg bg-white dark:bg-[#1b0d14] focus:ring-primary h-14"
                        placeholder="Email address" type="email" />
                    <button
                        class="bg-primary text-white font-bold px-8 rounded-lg h-14 hover:opacity-90 transition-opacity">
                        Subscribe
                    </button>
                </div>
            </div>
        </section>
        <!-- Brand Values -->
        <section class="px-6 lg:px-20 py-12 border-t border-[#f3e7ed] dark:border-[#3d2030]">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="flex flex-col items-center text-center gap-2">
                    <span class="material-symbols-outlined text-primary text-3xl">eco</span>
                    <h5 class="font-bold text-sm uppercase tracking-widest">100% Vegan</h5>
                </div>
                <div class="flex flex-col items-center text-center gap-2">
                    <span class="material-symbols-outlined text-primary text-3xl">potted_plant</span>
                    <h5 class="font-bold text-sm uppercase tracking-widest">Cruelty Free</h5>
                </div>
                <div class="flex flex-col items-center text-center gap-2">
                    <span class="material-symbols-outlined text-primary text-3xl">workspace_premium</span>
                    <h5 class="font-bold text-sm uppercase tracking-widest">Premium Quality</h5>
                </div>
                <div class="flex flex-col items-center text-center gap-2">
                    <span class="material-symbols-outlined text-primary text-3xl">local_shipping</span>
                    <h5 class="font-bold text-sm uppercase tracking-widest">Global Shipping</h5>
                </div>
            </div>
        </section>
@endsection