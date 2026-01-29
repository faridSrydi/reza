@extends('layouts.app')

@section('title', $product->name)

@section('content')

    @php
        $images = $product->images ?? collect();
        $mainImage = $images->first();
        $mainImageUrl = $mainImage
            ? asset('storage/' . ltrim($mainImage->image, '/'))
            : ('https://ui-avatars.com/api/?name=' . urlencode($product->name) . '&background=f3e7ed&color=1b0d14');

        $variants = $product->variants ?? collect();
        $defaultVariant = $variants->firstWhere('stock', '>', 0) ?? $variants->first();
        $defaultVariantId = $defaultVariant?->id;
        $defaultVariantPrice = $defaultVariant?->price;
        $defaultVariantStock = $defaultVariant?->stock;

        $categoryName = $product->category?->name;
    @endphp

    <style type="text/tailwindcss">
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24;
        }

        .material-symbols-outlined.fill-1 {
            font-variation-settings: 'FILL' 1, 'wght' 300, 'GRAD' 0, 'opsz' 24;
        }

        body {
            font-family: "Plus Jakarta Sans", sans-serif;
        }

        .serif-text {
            font-family: "Playfair Display", serif;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
    <nav class="px-6 lg:px-20 py-4 flex items-center gap-2 text-xs uppercase tracking-widest text-gray-500">
        <a class="hover:text-primary" href="{{ route('home') }}">Home</a>
        <span class="material-symbols-outlined text-sm">chevron_right</span>
        <a class="hover:text-primary" href="{{ route('shop.index') }}">Shop</a>
        @if($categoryName)
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <a class="hover:text-primary" href="{{ route('shop.index', ['category' => $product->category?->slug]) }}">{{ $categoryName }}</a>
        @endif
        <span class="material-symbols-outlined text-sm">chevron_right</span>
        <span class="text-gray-900 dark:text-gray-200">{{ $product->name }}</span>
    </nav>
    <section class="px-6 lg:px-20 py-6 grid grid-cols-1 lg:grid-cols-2 gap-16">
        <div class="flex gap-4">
            <div class="flex flex-col gap-4 w-20">
                @forelse($images as $img)
                    @php
                        $imgUrl = asset('storage/' . ltrim($img->image, '/'));
                        $isActive = $loop->first;
                    @endphp
                    <button
                        type="button"
                        class="aspect-square rounded-lg overflow-hidden border {{ $isActive ? 'border-2 border-primary' : 'border-gray-200 hover:border-primary' }} transition-colors"
                        data-thumb
                        data-image-url="{{ $imgUrl }}">
                        <img src="{{ $imgUrl }}" alt="{{ $product->name }}" class="w-full h-full object-cover" loading="lazy" />
                    </button>
                @empty
                    <div class="aspect-square rounded-lg overflow-hidden border-2 border-primary">
                        <img src="{{ $mainImageUrl }}" alt="{{ $product->name }}" class="w-full h-full object-cover" loading="lazy" />
                    </div>
                @endforelse
            </div>

            <div class="flex-1 aspect-[4/5] rounded-2xl overflow-hidden bg-white shadow-sm">
                <img id="mainProductImage" src="{{ $mainImageUrl }}" alt="{{ $product->name }}" class="w-full h-full object-cover" />
            </div>
        </div>
        <div class="flex flex-col gap-8">
            <div class="flex flex-col gap-4">
                <div class="flex justify-between items-start gap-6">
                    <h1 class="text-4xl lg:text-5xl font-bold serif-text leading-tight">{{ $product->name }}</h1>
                    @auth
                        @php
                            $inWishlist = in_array($product->id, $wishlistProductIds ?? [], true);
                        @endphp
                        <form method="POST" action="{{ route('wishlist.toggle', $product) }}">
                            @csrf
                            <button
                                type="submit"
                                class="size-12 rounded-full border border-gray-200 flex items-center justify-center hover:bg-primary/5 transition-colors {{ $inWishlist ? 'text-primary' : '' }}"
                                aria-label="Wishlist">
                                <span class="material-symbols-outlined">favorite</span>
                            </button>
                        </form>
                    @endauth
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex text-primary">
                        <span class="material-symbols-outlined fill-1">star</span>
                        <span class="material-symbols-outlined fill-1">star</span>
                        <span class="material-symbols-outlined fill-1">star</span>
                        <span class="material-symbols-outlined fill-1">star</span>
                        <span class="material-symbols-outlined">star_half</span>
                    </div>
                    <span class="text-sm font-medium text-gray-500">(128 Reviews)</span>
                </div>
                <p class="text-3xl font-bold text-primary">
                    <span id="variantPriceText">
                        @if(is_null($defaultVariantPrice))
                            Rp —
                        @else
                            Rp {{ number_format((float) $defaultVariantPrice, 0, ',', '.') }}
                        @endif
                    </span>
                </p>
                <p class="text-gray-600 dark:text-gray-300 leading-relaxed max-w-lg">
                    {{ $product->description ?: 'No description available.' }}
                </p>
            </div>

            <div class="flex flex-col gap-4">
                <span class="text-sm font-bold uppercase tracking-widest">Variant</span>
                @if($variants->isEmpty())
                    <p class="text-sm text-gray-500">No variants available for this product.</p>
                @else
                    <select
                        id="variantSelect"
                        class="w-full rounded-lg border border-gray-200 bg-white dark:bg-background-dark px-4 py-3 text-sm font-medium focus:ring-primary focus:border-primary">
                        @foreach($variants as $variant)
                            @php
                                $labelParts = collect([
                                    $variant->color ? ('Color: ' . $variant->color) : null,
                                    $variant->size ? ('Size: ' . $variant->size) : null,
                                ])->filter()->values();

                                $label = $labelParts->isNotEmpty() ? $labelParts->join(' / ') : ('Variant #' . $variant->id);
                            @endphp
                            <option
                                value="{{ $variant->id }}"
                                data-price="{{ (int) $variant->price }}"
                                data-stock="{{ (int) $variant->stock }}"
                                {{ (int) $variant->id === (int) $defaultVariantId ? 'selected' : '' }}>
                                {{ $label }} — Rp {{ number_format((float) $variant->price, 0, ',', '.') }}
                                @if((int) $variant->stock <= 0)
                                    (Out of stock)
                                @endif
                            </option>
                        @endforeach
                    </select>

                    <p class="text-xs text-gray-500">
                        Stock: <span id="variantStockText">{{ is_null($defaultVariantStock) ? '—' : (int) $defaultVariantStock }}</span>
                    </p>
                @endif
            </div>
            <div class="flex flex-col gap-6">
                <form method="POST" action="{{ route('cart.add') }}" class="flex items-center gap-6">
                    @csrf
                    <input type="hidden" name="variant_id" id="variantIdInput" value="{{ $defaultVariantId }}" />
                    <input type="hidden" name="qty" id="qtyInput" value="1" />

                    <div class="flex items-center border border-gray-200 rounded-lg h-14 bg-white dark:bg-background-dark">
                        <button type="button" id="qtyMinus" class="px-4 h-full flex items-center justify-center hover:text-primary">
                            <span class="material-symbols-outlined">remove</span>
                        </button>
                        <span id="qtyText" class="w-12 text-center font-bold">1</span>
                        <button type="button" id="qtyPlus" class="px-4 h-full flex items-center justify-center hover:text-primary">
                            <span class="material-symbols-outlined">add</span>
                        </button>
                    </div>

                    <button
                        type="submit"
                        class="flex-1 bg-primary text-white font-bold h-14 rounded-lg hover:opacity-90 transition-opacity flex items-center justify-center gap-2"
                        {{ $variants->isEmpty() ? 'disabled' : '' }}>
                        <span class="material-symbols-outlined">shopping_bag</span>
                        Add to Bag
                    </button>
                </form>

                <div class="flex items-center gap-6 py-4 border-t border-b border-gray-100 dark:border-[#3d2030]">
                    <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-tighter">
                        <span class="material-symbols-outlined text-primary">local_shipping</span>
                        Free Shipping
                    </div>
                    <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-tighter">
                        <span class="material-symbols-outlined text-primary">eco</span>
                        Clean Formula
                    </div>
                    <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-tighter">
                        <span class="material-symbols-outlined text-primary">history</span>
                        30-Day Returns
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="px-6 lg:px-20 py-20">
        <div class="max-w-4xl">
            <div class="flex border-b border-gray-200 dark:border-[#3d2030] gap-12 mb-10">
                <button
                    class="pb-4 text-sm font-bold uppercase tracking-widest border-b-2 border-primary">Ingredients</button>
                <button
                    class="pb-4 text-sm font-bold uppercase tracking-widest text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">How
                    to Use</button>
                <button
                    class="pb-4 text-sm font-bold uppercase tracking-widest text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">Customer
                    Reviews</button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div class="flex flex-col gap-4">
                    <h4 class="font-bold serif-text text-xl">Key Ingredients</h4>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                        Octyldodecanol, Polyethylene, Squalane, Microcrystalline Wax, Rosa Damascena Flower Oil,
                        Sodium Hyaluronate, Vitamin E Acetate.
                    </p>
                </div>
                <div class="flex flex-col gap-4">
                    <h4 class="font-bold serif-text text-xl">Why it works</h4>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                        Our proprietary blend of natural waxes and oils ensures a smooth glide-on application while
                        sealing in moisture for a plump, velvet-smooth finish that lasts all day without drying.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section class="px-6 lg:px-20 py-12 bg-white dark:bg-[#1b0d14]/30">
        <h2 class="text-3xl font-bold mb-10 serif-text">Complete the Look</h2>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($relatedProducts as $rp)
                @php
                    $rpFirstImage = optional($rp->images->first())->image;
                    $rpImgSrc = $rpFirstImage
                        ? asset('storage/' . ltrim($rpFirstImage, '/'))
                        : ('https://ui-avatars.com/api/?name=' . urlencode($rp->name) . '&background=f3e7ed&color=1b0d14');
                    $rpMinPrice = $rp->variants_min_price ?? $rp->variants?->min('price');
                @endphp
                <a href="{{ route('product.show', $rp->slug) }}" class="group flex flex-col gap-3">
                    <div class="relative aspect-square rounded-xl overflow-hidden bg-background-light dark:bg-[#2d1622]">
                        <img src="{{ $rpImgSrc }}" alt="{{ $rp->name }}" class="w-full h-full object-cover transition-transform group-hover:scale-110" loading="lazy" />
                    </div>
                    <h4 class="font-bold text-base line-clamp-1">{{ $rp->name }}</h4>
                    <p class="font-bold text-primary">
                        @if(is_null($rpMinPrice))
                            Rp —
                        @else
                            Rp {{ number_format((float) $rpMinPrice, 0, ',', '.') }}
                        @endif
                    </p>
                </a>
            @empty
                <p class="col-span-full text-sm text-gray-500">No related products.</p>
            @endforelse
        </div>
    </section>

    <script>
        (function () {
            var mainImage = document.getElementById('mainProductImage');
            var thumbs = document.querySelectorAll('[data-thumb]');
            thumbs.forEach(function (t) {
                t.addEventListener('click', function () {
                    var url = t.getAttribute('data-image-url');
                    if (mainImage && url) mainImage.src = url;
                });
            });

            var variantSelect = document.getElementById('variantSelect');
            var variantIdInput = document.getElementById('variantIdInput');
            var priceText = document.getElementById('variantPriceText');
            var stockText = document.getElementById('variantStockText');

            function formatRp(value) {
                try {
                    return new Intl.NumberFormat('id-ID').format(value);
                } catch (e) {
                    return String(value);
                }
            }

            function updateVariantUI() {
                if (!variantSelect) return;
                var opt = variantSelect.options[variantSelect.selectedIndex];
                if (!opt) return;

                var variantId = opt.value;
                var price = parseInt(opt.getAttribute('data-price') || '0', 10);
                var stock = parseInt(opt.getAttribute('data-stock') || '0', 10);

                if (variantIdInput) variantIdInput.value = variantId;
                if (priceText) priceText.textContent = 'Rp ' + formatRp(price);
                if (stockText) stockText.textContent = String(stock);
            }

            if (variantSelect) {
                variantSelect.addEventListener('change', updateVariantUI);
                updateVariantUI();
            }

            var qtyMinus = document.getElementById('qtyMinus');
            var qtyPlus = document.getElementById('qtyPlus');
            var qtyText = document.getElementById('qtyText');
            var qtyInput = document.getElementById('qtyInput');

            function setQty(nextQty) {
                var v = Math.max(1, parseInt(nextQty || '1', 10));
                if (qtyText) qtyText.textContent = String(v);
                if (qtyInput) qtyInput.value = String(v);
            }

            if (qtyMinus) qtyMinus.addEventListener('click', function () {
                setQty((qtyInput && qtyInput.value) ? (parseInt(qtyInput.value, 10) - 1) : 1);
            });
            if (qtyPlus) qtyPlus.addEventListener('click', function () {
                setQty((qtyInput && qtyInput.value) ? (parseInt(qtyInput.value, 10) + 1) : 2);
            });
        })();
    </script>


@endsection
