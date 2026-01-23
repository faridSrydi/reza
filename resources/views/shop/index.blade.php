@extends('layouts.app')

@section('title', 'Shop')

@section('content')
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .filled-icon {
            font-variation-settings: 'FILL' 1;
        }

        /* Custom Lollipop Checkbox Style */
        .lollipop-checkbox {
            appearance: none;
            width: 24px;
            height: 24px;
            border: 3px solid #f42559;
            border-radius: 50%;
            cursor: pointer;
            position: relative;
            background: white;
            transition: all 0.2s ease;
        }

        .lollipop-checkbox:checked {
            background: radial-gradient(circle, #f42559 40%, white 45%, #f42559 50%);
        }

        .lollipop-checkbox::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 3px;
            height: 8px;
            background-color: #f42559;
            border-radius: 2px;
        }

        /* Wavy Border for Sidebar */
        .wavy-border {
            border: 4px solid #f42559;
            border-radius: 40px 20px 40px 20px;
        }

        /* Subtle Pattern Background */
        .bg-pattern {
            background-color: #f8f5f6;
            background-image: radial-gradient(#f42559 0.5px, transparent 0.5px), radial-gradient(#f42559 0.5px, #f8f5f6 0.5px);
            background-size: 20px 20px;
            background-position: 0 0, 10px 10px;
            opacity: 0.1;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        /* Hover Heart Animation */
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

        /* Mobile filter bottom-sheet */
        .filter-overlay {
            opacity: 0;
            pointer-events: none;
            transition: opacity 220ms ease;
        }

        .filter-overlay.is-open {
            opacity: 1;
            pointer-events: auto;
        }

        .filter-sheet {
            transform: translateY(18px);
            opacity: 0;
            transition: transform 280ms cubic-bezier(0.22, 1, 0.36, 1), opacity 220ms ease;
        }

        .filter-overlay.is-open .filter-sheet {
            transform: translateY(0);
            opacity: 1;
        }
    </style>

    <main class="flex-1 max-w-[1280px] mx-auto w-full px-6 py-8">
        {{-- Breadcrumbs --}}
        <div class="flex items-center gap-2 mb-6">
            <a class="text-primary/60 text-sm font-semibold hover:text-primary" href="{{ route('home') }}">Home</a>
            <span class="material-symbols-outlined crumb-heart text-[12px] text-primary">favorite</span>
            <a class="text-primary/60 text-sm font-semibold hover:text-primary" href="{{ route('shop.index') }}">Shop</a>

            @if (isset($activeCategories) && $activeCategories->isNotEmpty())
                <span class="material-symbols-outlined crumb-heart text-[12px] text-primary">favorite</span>
                @if ($activeCategories->count() === 1)
                    <span class="text-primary text-sm font-bold">{{ $activeCategories->first()->name }}</span>
                @else
                    <span class="text-primary text-sm font-bold">{{ $activeCategories->count() }} categories</span>
                @endif
            @endif
        </div>
        <div class="flex flex-col md:flex-row gap-8">
            <!-- SideNavBar (Desktop) -->
            <aside class="hidden md:block w-full md:w-64 flex-shrink-0">
                <div class="wavy-border bg-white dark:bg-background-dark p-6 space-y-8 sticky top-24">
                    <div>
                        <h3 class="text-primary text-lg font-extrabold mb-1">Filters</h3>
                        <p class="text-primary/50 text-xs font-medium uppercase tracking-widest">Refine your hunt</p>
                    </div>
                    <form method="GET" action="{{ route('shop.index') }}" class="space-y-6">
                        <input type="hidden" name="sort" value="{{ request('sort', 'default') }}" />

                        {{-- Category Filter (multi) --}}
                        <div>
                            <div class="flex items-center gap-2 text-primary font-bold mb-3">
                                <span class="material-symbols-outlined">category</span>
                                <span>Category</span>
                            </div>

                            <div class="space-y-2">
                                @foreach ($categories as $category)
                                    <label class="flex items-center gap-3 px-3 py-2 rounded-xl border-2 border-primary/10 hover:border-primary/20 transition-colors cursor-pointer">
                                        <input
                                            class="lollipop-checkbox"
                                            type="checkbox"
                                            name="categories[]"
                                            value="{{ $category->slug }}"
                                            @checked(in_array($category->slug, (array) ($selectedCategorySlugsArray ?? []), true))
                                        />
                                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-200">{{ $category->name }}</span>
                                    </label>
                                @endforeach
                            </div>

                            <a href="{{ route('shop.index') }}" class="inline-flex mt-3 text-xs font-bold text-primary/70 hover:text-primary underline">
                                Reset categories
                            </a>
                        </div>

                        {{-- Price Range --}}
                        <div>
                            <div class="flex items-center gap-2 text-primary font-bold mb-3">
                                <span class="material-symbols-outlined">payments</span>
                                <span>Price</span>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <input name="min_price" value="{{ request('min_price') }}" placeholder="Min" inputmode="numeric"
                                    class="w-full bg-white dark:bg-background-dark border-2 border-primary/20 rounded-xl px-4 py-2 text-sm font-semibold text-primary focus:border-primary focus:ring-0 outline-none placeholder:text-primary/40" />
                                <input name="max_price" value="{{ request('max_price') }}" placeholder="Max" inputmode="numeric"
                                    class="w-full bg-white dark:bg-background-dark border-2 border-primary/20 rounded-xl px-4 py-2 text-sm font-semibold text-primary focus:border-primary focus:ring-0 outline-none placeholder:text-primary/40" />
                            </div>
                            <p class="text-[11px] text-primary/50 font-semibold mt-2">Masukkan angka tanpa titik/koma. Contoh: 10000</p>
                        </div>

                        {{-- Search --}}
                        <div>
                            <div class="flex items-center gap-2 text-primary font-bold mb-3">
                                <span class="material-symbols-outlined">search</span>
                                <span>Search</span>
                            </div>
                            <input name="q" value="{{ request('q') }}" placeholder="Cari produk..." type="text"
                                class="w-full bg-white dark:bg-background-dark border-2 border-primary/20 rounded-xl px-4 py-2 text-sm font-semibold text-primary focus:border-primary focus:ring-0 outline-none placeholder:text-primary/40" />
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <a href="{{ route('shop.index') }}"
                                class="w-full inline-flex items-center justify-center py-3 rounded-xl border-2 border-primary/20 text-primary font-extrabold hover:border-primary/40 hover:bg-primary/5 transition-colors">
                                Reset
                            </a>
                            <button
                                class="w-full bg-primary text-white font-bold py-3 rounded-xl hover:scale-105 transition-transform shadow-lg shadow-primary/20">
                                Apply
                            </button>
                        </div>
                    </form>
                </div>
            </aside>
            <!-- Main Content Area -->
            <div class="flex-1">
                <!-- Mobile: Filter Hamburger -->
                <div class="md:hidden mb-4 px-4">
                    <button id="mobileFilterButton" type="button"
                        class="w-full flex items-center justify-between gap-3 px-4 py-3 rounded-2xl border-2 border-primary/15 bg-white/80 dark:bg-background-dark/60 backdrop-blur-md text-primary font-extrabold shadow-lg shadow-primary/5"
                        aria-controls="mobileFilterOverlay" aria-expanded="false">
                        <span class="flex items-center gap-2">
                            <span class="material-symbols-outlined filled-icon">tune</span>
                            Filters
                        </span>
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8 px-4">
                    <div class="min-w-0">
                        <h1 class="text-4xl font-extrabold text-primary tracking-tight">
                            @if (isset($activeCategories) && $activeCategories->count() === 1)
                                {{ $activeCategories->first()->name }}
                            @elseif (isset($activeCategories) && $activeCategories->count() > 1)
                                Selected Categories
                            @else
                                All Products
                            @endif
                        </h1>
                        <p class="text-primary/60 font-semibold">Found {{ $products->total() }} products</p>
                    </div>

                    <form method="GET" action="{{ route('shop.index') }}" class="w-full sm:w-auto">
                        @foreach ((array) ($selectedCategorySlugsArray ?? []) as $slug)
                            <input type="hidden" name="categories[]" value="{{ $slug }}" />
                        @endforeach
                        <input type="hidden" name="q" value="{{ request('q') }}" />
                        <input type="hidden" name="min_price" value="{{ request('min_price') }}" />
                        <input type="hidden" name="max_price" value="{{ request('max_price') }}" />

                        <label class="block">
                            <span class="sr-only">Sort</span>
                            <select name="sort" onchange="this.form.submit()"
                                class="w-full sm:w-[260px] bg-white dark:bg-background-dark border-2 border-primary/20 rounded-2xl px-4 py-3 text-sm font-extrabold text-primary focus:border-primary focus:ring-0 outline-none">
                                <option value="default" @selected(request('sort', 'default') === 'default')>Default</option>
                                <option value="price_desc" @selected(request('sort') === 'price_desc')>Harga: tertinggi → terendah</option>
                                <option value="price_asc" @selected(request('sort') === 'price_asc')>Harga: terendah → tertinggi</option>
                                <option value="name_asc" @selected(request('sort') === 'name_asc')>Nama: A → Z</option>
                                <option value="name_desc" @selected(request('sort') === 'name_desc')>Nama: Z → A</option>
                            </select>
                        </label>
                    </form>
                </div>
                <!-- Product Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                    @forelse ($products as $product)
                        @php
                            $image = $product->images->first();
                            $minPrice = $product->variants->min('price');
                            $wishlisted = in_array($product->id, $wishlistProductIds ?? [], true);
                        @endphp

                        <a href="{{ route('product.show', $product->slug) }}"
                            class="product-card group relative bg-white dark:bg-background-dark p-3 sm:p-4 rounded-xl shadow-xl shadow-primary/5 hover:shadow-primary/10 transition-all border-2 border-transparent hover:border-primary/20">
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

                            <div
                                class="aspect-square rounded-lg bg-pink-50 dark:bg-primary/5 mb-4 flex items-center justify-center overflow-hidden">
                                @if ($image)
                                    <img class="w-full h-full object-cover group-hover:scale-105 transition-transform"
                                        src="{{ asset('storage/' . $image->image) }}" alt="{{ $product->name }}" />
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <span class="text-primary/40 text-xs font-bold uppercase tracking-widest">No
                                            Image</span>
                                    </div>
                                @endif
                            </div>

                            <div class="space-y-2">
                                <div class="flex justify-between items-start gap-3">
                                    <h3
                                        class="text-lg font-extrabold text-gray-800 dark:text-white leading-tight line-clamp-2">
                                        {{ $product->name }}
                                    </h3>
                                    <span class="text-primary font-bold whitespace-nowrap">
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

                                <div
                                    class="w-full bg-primary/10 text-primary font-bold py-2.5 rounded-full group-hover:bg-primary group-hover:text-white transition-all flex items-center justify-center gap-2">
                                    <span class="material-symbols-outlined text-lg">open_in_new</span>
                                    View Details
                                </div>
                            </div>
                        </a>
                    @empty
                        <div
                            class="col-span-full bg-white dark:bg-background-dark p-8 rounded-xl border-2 border-primary/10">
                            <p class="text-primary font-bold">Tidak ada produk ditemukan.</p>
                            <p class="text-primary/60 text-sm font-semibold mt-1">Coba ganti kategori atau kata kunci
                                pencarian.</p>
                        </div>
                    @endforelse
                </div>
                <!-- Pagination -->
                <div class="mt-12 flex justify-center">
                    {{ $products->onEachSide(1)->links() }}
                </div>
            </div>
        </div>
    </main>

    <!-- Mobile Filter Bottom Sheet -->
    <div id="mobileFilterOverlay" class="md:hidden filter-overlay fixed inset-0 z-50">
        <div class="absolute inset-0 bg-black/40" data-close-filter></div>
        <div class="absolute inset-x-0 bottom-0 p-3">
            <div class="filter-sheet w-full max-w-[640px] mx-auto bg-white dark:bg-background-dark shadow-2xl border-2 border-primary/15 rounded-3xl">
                <div class="p-4 border-b border-primary/10 flex items-center justify-between gap-3">
                    <div>
                        <div class="text-primary font-extrabold text-lg">Filters</div>
                        <div class="text-primary/50 text-xs font-medium uppercase tracking-widest">Refine your hunt</div>
                    </div>
                    <button type="button" class="h-10 w-10 rounded-xl border-2 border-primary/15 bg-candy-pink/60 text-primary flex items-center justify-center" data-close-filter aria-label="Close filters">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <div class="p-4 overflow-y-auto max-h-[70vh]">
                    <div class="wavy-border bg-white dark:bg-background-dark p-5 space-y-8">
                        <form method="GET" action="{{ route('shop.index') }}" class="space-y-6">
                            <input type="hidden" name="sort" value="{{ request('sort', 'default') }}" />

                            {{-- Category Filter (multi) --}}
                            <div>
                                <div class="flex items-center gap-2 text-primary font-bold mb-3">
                                    <span class="material-symbols-outlined">category</span>
                                    <span>Category</span>
                                </div>

                                <div class="space-y-2">
                                    @foreach ($categories as $category)
                                        <label class="flex items-center gap-3 px-3 py-2 rounded-xl border-2 border-primary/10 hover:border-primary/20 transition-colors cursor-pointer">
                                            <input
                                                class="lollipop-checkbox"
                                                type="checkbox"
                                                name="categories[]"
                                                value="{{ $category->slug }}"
                                                @checked(in_array($category->slug, (array) ($selectedCategorySlugsArray ?? []), true))
                                            />
                                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-200">{{ $category->name }}</span>
                                        </label>
                                    @endforeach
                                </div>

                                <a href="{{ route('shop.index') }}" class="inline-flex mt-3 text-xs font-bold text-primary/70 hover:text-primary underline">
                                    Reset categories
                                </a>
                            </div>

                            {{-- Price Range --}}
                            <div>
                                <div class="flex items-center gap-2 text-primary font-bold mb-3">
                                    <span class="material-symbols-outlined">payments</span>
                                    <span>Price</span>
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <input name="min_price" value="{{ request('min_price') }}" placeholder="Min" inputmode="numeric"
                                        class="w-full bg-white dark:bg-background-dark border-2 border-primary/20 rounded-xl px-4 py-2 text-sm font-semibold text-primary focus:border-primary focus:ring-0 outline-none placeholder:text-primary/40" />
                                    <input name="max_price" value="{{ request('max_price') }}" placeholder="Max" inputmode="numeric"
                                        class="w-full bg-white dark:bg-background-dark border-2 border-primary/20 rounded-xl px-4 py-2 text-sm font-semibold text-primary focus:border-primary focus:ring-0 outline-none placeholder:text-primary/40" />
                                </div>
                            </div>

                            {{-- Search --}}
                            <div>
                                <div class="flex items-center gap-2 text-primary font-bold mb-3">
                                    <span class="material-symbols-outlined">search</span>
                                    <span>Search</span>
                                </div>
                                <input name="q" value="{{ request('q') }}" placeholder="Cari produk..." type="text"
                                    class="w-full bg-white dark:bg-background-dark border-2 border-primary/20 rounded-xl px-4 py-2 text-sm font-semibold text-primary focus:border-primary focus:ring-0 outline-none placeholder:text-primary/40" />
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <a href="{{ route('shop.index') }}"
                                    class="w-full inline-flex items-center justify-center py-3 rounded-xl border-2 border-primary/20 text-primary font-extrabold hover:border-primary/40 hover:bg-primary/5 transition-colors">
                                    Reset
                                </a>
                                <button
                                    class="w-full bg-primary text-white font-bold py-3 rounded-xl hover:scale-105 transition-transform shadow-lg shadow-primary/20">
                                    Apply
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function () {
            var openBtn = document.getElementById('mobileFilterButton');
            var overlay = document.getElementById('mobileFilterOverlay');

            function open() {
                if (!overlay) return;
                overlay.classList.add('is-open');
                if (openBtn) openBtn.setAttribute('aria-expanded', 'true');
                document.body.style.overflow = 'hidden';
            }

            function close() {
                if (!overlay) return;
                overlay.classList.remove('is-open');
                if (openBtn) openBtn.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
            }

            if (openBtn && overlay) {
                openBtn.addEventListener('click', open);
                overlay.addEventListener('click', function (e) {
                    if (e.target && e.target.hasAttribute('data-close-filter')) close();
                });
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape') close();
                });
            }
        })();
    </script>

@endsection
