@extends('layouts.app') 

@section('title', 'Shop')

@section('content')

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .filled-star {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            color: #ee2b8c;
        }

        body {
            font-family: "Plus Jakarta Sans", sans-serif;
        }
    </style>
    <main class="max-w-[1440px] mx-auto px-4 lg:px-20 py-8">
        @php
            $pageTitle = $activeCategory?->name
                ?? ($activeCategories?->isNotEmpty() ? 'Selected Categories' : 'Shop');
        @endphp

        <!-- Breadcrumbs -->
        <div class="flex items-center gap-2 mb-8 text-sm text-[#9a4c73] dark:text-[#c48ba8]">
            <a class="hover:text-primary" href="{{ route('home') }}">Home</a>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <span class="text-[#1b0d14] dark:text-white font-semibold">Shop</span>
            @if ($activeCategory)
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <span class="text-[#1b0d14] dark:text-white font-semibold">{{ $activeCategory->name }}</span>
            @endif
        </div>

        <div class="flex flex-col lg:flex-row gap-10">
            <!-- Sidebar Filters -->
            <aside class="w-full lg:w-64 flex-shrink-0">
                <form method="GET" action="{{ route('shop.index') }}" class="sticky top-24 space-y-8">
                    <div>
                        <h3 class="text-lg font-bold mb-4 flex items-center justify-between">
                            Filters
                            <a class="text-xs font-normal text-primary hover:underline" href="{{ route('shop.index') }}">Clear all</a>
                        </h3>
                    </div>

                    <!-- Search -->
                    <div class="space-y-3">
                        <h4 class="font-semibold text-sm uppercase tracking-wider text-[#9a4c73] dark:text-[#c48ba8]">Search</h4>
                        <input
                            name="q"
                            value="{{ request('q') }}"
                            class="w-full rounded-lg border border-[#e7cfdb] dark:border-[#3a202d] bg-white dark:bg-background-dark px-4 py-2 text-sm focus:ring-primary"
                            placeholder="Search products..." />
                    </div>

                    <!-- Category Filter -->
                    <div class="space-y-3">
                        <h4 class="font-semibold text-sm uppercase tracking-wider text-[#9a4c73] dark:text-[#c48ba8]">Category</h4>
                        <div class="space-y-2">
                            @forelse($categories as $category)
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input
                                        class="rounded border-[#e7cfdb] text-primary focus:ring-primary size-4"
                                        type="checkbox"
                                        name="categories[]"
                                        value="{{ $category->slug }}"
                                        {{ in_array($category->slug, $selectedCategorySlugsArray ?? [], true) ? 'checked' : '' }}
                                    />
                                    <span class="text-sm group-hover:text-primary transition-colors">{{ $category->name }}</span>
                                </label>
                            @empty
                                <p class="text-sm text-[#9a4c73] dark:text-[#c48ba8]">No categories.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Price Filter -->
                    <div class="space-y-3">
                        <h4 class="font-semibold text-sm uppercase tracking-wider text-[#9a4c73] dark:text-[#c48ba8]">Price Range (Rp)</h4>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold text-[#9a4c73] dark:text-[#c48ba8] mb-1">Min</label>
                                <input
                                    name="min_price"
                                    value="{{ request('min_price') }}"
                                    type="number"
                                    min="0"
                                    class="w-full rounded-lg border border-[#e7cfdb] dark:border-[#3a202d] bg-white dark:bg-background-dark px-4 py-2 text-sm focus:ring-primary"
                                    placeholder="0" />
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-[#9a4c73] dark:text-[#c48ba8] mb-1">Max</label>
                                <input
                                    name="max_price"
                                    value="{{ request('max_price') }}"
                                    type="number"
                                    min="0"
                                    class="w-full rounded-lg border border-[#e7cfdb] dark:border-[#3a202d] bg-white dark:bg-background-dark px-4 py-2 text-sm focus:ring-primary"
                                    placeholder="" />
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="sort" value="{{ $sort ?? request('sort', 'default') }}" />

                    <button
                        class="w-full bg-primary text-white py-2.5 rounded-lg text-sm font-bold shadow-lg flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-lg">tune</span>
                        Apply Filters
                    </button>
                </form>
            </aside>

            <!-- Main Content Area -->
            <section class="flex-1">
                <!-- Toolbar -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8 gap-4">
                    <div>
                        <h1 class="text-2xl font-bold mb-1">{{ $pageTitle }}</h1>
                        <p class="text-sm text-[#9a4c73] dark:text-[#c48ba8]">
                            @if($products->total() > 0)
                                Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }} products
                            @else
                                No products found
                            @endif
                        </p>
                    </div>

                    <div class="flex items-center gap-4">
                        <form method="GET" action="{{ route('shop.index') }}" class="relative inline-block">
                            @foreach(($selectedCategorySlugsArray ?? []) as $slug)
                                <input type="hidden" name="categories[]" value="{{ $slug }}" />
                            @endforeach
                            @if(request('q'))
                                <input type="hidden" name="q" value="{{ request('q') }}" />
                            @endif
                            @if(request('min_price') !== null)
                                <input type="hidden" name="min_price" value="{{ request('min_price') }}" />
                            @endif
                            @if(request('max_price') !== null)
                                <input type="hidden" name="max_price" value="{{ request('max_price') }}" />
                            @endif

                            <select
                                name="sort"
                                onchange="this.form.submit()"
                                class="appearance-none bg-white dark:bg-background-dark border border-[#f3e7ed] dark:border-[#3a202d] rounded-lg px-4 py-2 pr-10 text-sm font-medium focus:ring-primary outline-none cursor-pointer">
                                <option value="default" {{ ($sort ?? 'default') === 'default' ? 'selected' : '' }}>Sort: Newest</option>
                                <option value="price_asc" {{ ($sort ?? '') === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_desc" {{ ($sort ?? '') === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="name_asc" {{ ($sort ?? '') === 'name_asc' ? 'selected' : '' }}>Name: A–Z</option>
                                <option value="name_desc" {{ ($sort ?? '') === 'name_desc' ? 'selected' : '' }}>Name: Z–A</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-lg">expand_more</span>
                        </form>
                    </div>
                </div>

                @if(($activeCategories ?? collect())->isNotEmpty())
                    <div class="flex flex-wrap gap-2 mb-6">
                        @foreach($activeCategories as $cat)
                            <a href="{{ route('shop.index', array_merge(request()->except(['page', 'category', 'categories']), ['category' => $cat->slug])) }}"
                                class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-primary/10 text-primary text-xs font-bold">
                                {{ $cat->name }}
                            </a>
                        @endforeach
                    </div>
                @endif

                <!-- Product Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8">
                    @forelse($products as $product)
                        @php
                            $firstImage = optional($product->images->first())->image;
                            $imgSrc = $firstImage
                                ? asset('storage/' . ltrim($firstImage, '/'))
                                : ('https://ui-avatars.com/api/?name=' . urlencode($product->name) . '&background=f3e7ed&color=1b0d14');
                            $minPrice = $product->variants_min_price ?? $product->variants?->min('price');
                            $inWishlist = in_array($product->id, $wishlistProductIds ?? [], true);
                        @endphp

                        <div class="group relative flex flex-col bg-white dark:bg-[#2d1522] rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300">
                            <a href="{{ route('product.show', $product->slug) }}" class="relative aspect-[4/5] overflow-hidden bg-[#f3e7ed] block">
                                <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                    alt="{{ $product->name }}"
                                    src="{{ $imgSrc }}" loading="lazy" />

                                @auth
                                    <div class="absolute top-3 right-3">
                                        <button type="button"
                                            class="size-8 rounded-full bg-white/90 backdrop-blur flex items-center justify-center shadow-md {{ $inWishlist ? 'text-primary' : 'text-[#1b0d14] hover:text-primary' }}"
                                            data-wishlist-toggle
                                            data-wishlist-url="{{ route('wishlist.toggle', $product) }}"
                                            data-wishlist-active="{{ $inWishlist ? 1 : 0 }}"
                                            aria-label="Wishlist">
                                            <span class="material-symbols-outlined text-xl">favorite</span>
                                        </button>
                                    </div>
                                @endauth

                                <div class="absolute bottom-0 left-0 right-0 p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                                    <div class="w-full bg-primary text-white py-2.5 rounded-lg text-sm font-bold shadow-lg flex items-center justify-center gap-2">
                                        <span class="material-symbols-outlined text-lg">open_in_new</span>
                                        View Details
                                    </div>
                                </div>
                            </a>

                            <div class="p-5 flex-1 flex flex-col">
                                <span class="text-[10px] uppercase tracking-widest text-[#9a4c73] dark:text-[#c48ba8] font-bold mb-1">
                                    {{ $product->category?->name ?? 'Uncategorized' }}
                                </span>
                                <h3 class="font-bold text-[#1b0d14] dark:text-white mb-2 line-clamp-1">{{ $product->name }}</h3>

                                <div class="mt-auto flex items-center justify-between">
                                    <span class="text-lg font-bold text-primary">
                                        @if (is_null($minPrice))
                                            Rp —
                                        @else
                                            Rp {{ number_format((float) $minPrice, 0, ',', '.') }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full bg-white dark:bg-[#2d1522] rounded-xl p-8 text-center border border-[#f3e7ed] dark:border-[#3a202d]">
                            <p class="text-primary font-bold">No products match your filters.</p>
                            <a href="{{ route('shop.index') }}" class="inline-flex mt-4 bg-primary text-white font-bold px-6 py-3 rounded-full hover:scale-105 transition-transform">
                                Clear filters
                            </a>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-16 flex items-center justify-center">
                    {{ $products->onEachSide(1)->links() }}
                </div>
            </section>
        </div>
    </main>

@endsection
