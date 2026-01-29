@extends('layouts.admin')

@section('title', 'Product: ' . $product->name)

@push('styles')
    <style type="text/tailwindcss">
        .detail-card {
            @apply bg-white border border-[#f3e7ed] rounded-2xl shadow-sm overflow-hidden;
        }

        .detail-card-header {
            @apply px-6 py-5 border-b border-[#f3e7ed] bg-[#faf8f9];
        }

        .kpi-label {
            @apply text-xs font-bold uppercase tracking-wider text-gray-500;
        }
    </style>
@endpush

@section('content')
@php
    $minPrice = $product->variants->min('price');
    $maxPrice = $product->variants->max('price');
    $totalStock = (int) $product->variants->sum('stock');
    $mainImage = optional($product->images->first())->image;

    $sku = 'PRD-' . str_pad((string) $product->id, 4, '0', STR_PAD_LEFT);

    if ($totalStock <= 0) {
        $stockDot = 'bg-red-500';
        $stockText = 'Out of Stock';
        $stockTextClass = 'text-red-600';
    } elseif ($totalStock <= 10) {
        $stockDot = 'bg-amber-500';
        $stockText = 'Low Stock';
        $stockTextClass = 'text-amber-600';
    } else {
        $stockDot = 'bg-emerald-500';
        $stockText = 'In Stock';
        $stockTextClass = 'text-emerald-600';
    }
@endphp

<header class="lg:sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-[#f3e7ed] px-4 sm:px-6 lg:px-8 py-4">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-sm text-gray-500 mb-1">
                <a class="hover:text-primary" href="{{ route('admin.products.index') }}">Products</a>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <span>{{ $product->name }}</span>
            </div>
            <div class="flex items-center gap-3 flex-wrap">
                <h1 class="text-3xl font-bold serif-text">Product Details</h1>
                <span class="px-3 py-1 rounded-full bg-[#f3e7ed] text-[#9a4c73] text-xs font-bold">SKU: {{ $sku }}</span>
            </div>
            <p class="text-sm text-gray-500 mt-1">Slug: <span class="font-mono">{{ $product->slug }}</span></p>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center gap-3 w-full md:w-auto">
            <a href="{{ route('admin.products.index') }}"
                class="w-full sm:w-auto text-center px-6 py-2.5 rounded-lg border border-[#f3e7ed] text-sm font-bold hover:bg-gray-50 transition-colors">
                Back
            </a>
            <a href="{{ route('admin.products.edit', $product) }}"
                class="w-full sm:w-auto text-center px-6 py-2.5 rounded-lg bg-primary text-white text-sm font-bold hover:opacity-90 shadow-lg shadow-primary/20 transition-all">
                Edit Product
            </a>
        </div>
    </div>
</header>

<main class="p-4 sm:p-6 lg:p-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="detail-card h-fit">
            <div class="detail-card-header flex items-center justify-between gap-4">
                <div>
                    <p class="kpi-label">Product Media</p>
                    <p class="text-lg font-bold">Images</p>
                </div>
                <span class="px-3 py-1 rounded-full bg-[#f3e7ed] text-[#9a4c73] text-xs font-bold">{{ $product->images->count() }} files</span>
            </div>

            <div class="p-6 space-y-4">
                @if ($mainImage)
                    <div class="aspect-square rounded-xl border border-[#f3e7ed] bg-gray-50 overflow-hidden">
                        <img src="{{ asset('storage/' . ltrim($mainImage, '/')) }}" alt="{{ $product->name }}" class="w-full h-full object-cover" loading="lazy" />
                    </div>

                    @if ($product->images->count() > 1)
                        <div class="grid grid-cols-4 gap-3">
                            @foreach ($product->images->skip(1)->take(8) as $img)
                                <div class="aspect-square rounded-lg border border-[#f3e7ed] bg-gray-50 overflow-hidden">
                                    <img src="{{ asset('storage/' . ltrim($img->image, '/')) }}" alt="{{ $product->name }}" class="w-full h-full object-cover" loading="lazy" />
                                </div>
                            @endforeach
                        </div>
                    @endif
                @else
                    <div class="aspect-square rounded-xl border-2 border-dashed border-[#f3e7ed] bg-[#fcfaff] flex items-center justify-center">
                        <div class="text-center">
                            <p class="text-sm font-bold">No images</p>
                            <p class="text-xs text-gray-500">Upload images from Edit page</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="lg:col-span-2 space-y-8">
            <div class="detail-card">
                <div class="detail-card-header flex items-start justify-between gap-6">
                    <div>
                        <p class="kpi-label">Category</p>
                        <div class="mt-2">
                            <span class="px-3 py-1 rounded-full bg-[#f3e7ed] text-[#9a4c73] text-xs font-bold">
                                {{ $product->category->name ?? 'Uncategorized' }}
                            </span>
                            <span class="ml-2 text-xs text-gray-500">Created: {{ $product->created_at?->format('d M Y') }}</span>
                        </div>
                    </div>

                    <div class="text-right">
                        <p class="kpi-label">Price Range</p>
                        <p class="text-lg font-bold text-primary mt-1">
                            @if ($minPrice === null)
                                Rp —
                            @elseif ($minPrice === $maxPrice)
                                Rp {{ number_format((float) $minPrice, 0, ',', '.') }}
                            @else
                                Rp {{ number_format((float) $minPrice, 0, ',', '.') }} – {{ number_format((float) $maxPrice, 0, ',', '.') }}
                            @endif
                        </p>
                    </div>
                </div>

                <div class="p-6">
                    <p class="kpi-label">Name</p>
                    <p class="text-2xl font-bold mt-1">{{ $product->name }}</p>

                    <div class="mt-6">
                        <p class="kpi-label">Description</p>
                        <p class="mt-2 text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ $product->description }}</p>
                    </div>
                </div>
            </div>

            <div class="detail-card">
                <div class="detail-card-header flex items-start justify-between gap-6">
                    <div>
                        <p class="kpi-label">Inventory</p>
                        <p class="text-lg font-bold">Variants</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="px-3 py-1 rounded-full bg-[#f3e7ed] text-[#9a4c73] text-xs font-bold">{{ $product->variants->count() }} variants</span>
                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white border border-[#f3e7ed] text-xs font-bold">
                            <span class="size-2 rounded-full {{ $stockDot }}"></span>
                            <span class="{{ $stockTextClass }}">{{ $stockText }}{{ $stockText !== 'Out of Stock' ? ' (' . $totalStock . ')' : '' }}</span>
                        </span>
                    </div>
                </div>

                <div class="p-6">
                    @if ($product->variants->count() === 0)
                        <div class="text-center text-sm text-gray-500 py-10">No variants yet.</div>
                    @else
                        <div class="overflow-x-auto no-scrollbar">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-[#f3e7ed] bg-[#faf8f9]">
                                        <th class="px-4 py-3 text-xs font-bold uppercase tracking-wider text-gray-500">Color</th>
                                        <th class="px-4 py-3 text-xs font-bold uppercase tracking-wider text-gray-500">Size</th>
                                        <th class="px-4 py-3 text-xs font-bold uppercase tracking-wider text-gray-500 text-right">Stock</th>
                                        <th class="px-4 py-3 text-xs font-bold uppercase tracking-wider text-gray-500 text-right">Price</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#f3e7ed]">
                                    @foreach ($product->variants as $v)
                                        @php
                                            $vStock = (int) $v->stock;
                                            if ($vStock <= 0) {
                                                $vBadge = 'bg-red-50 text-red-700';
                                                $vText = 'Out';
                                            } elseif ($vStock <= 10) {
                                                $vBadge = 'bg-amber-50 text-amber-700';
                                                $vText = (string) $vStock;
                                            } else {
                                                $vBadge = 'bg-emerald-50 text-emerald-700';
                                                $vText = (string) $vStock;
                                            }
                                        @endphp
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-4 py-3 text-sm font-semibold">{{ $v->color ?: '—' }}</td>
                                            <td class="px-4 py-3 text-sm font-semibold">{{ $v->size ?: '—' }}</td>
                                            <td class="px-4 py-3 text-right">
                                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $vBadge }}">{{ $vText }}</span>
                                            </td>
                                            <td class="px-4 py-3 text-right text-sm font-bold">Rp {{ number_format((float) $v->price, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
