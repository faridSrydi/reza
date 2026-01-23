@extends('layouts.admin')

@section('title', 'Product: ' . $product->name)

@section('content')
    <main class="flex-1 flex flex-col py-10 px-10 relative overflow-hidden min-h-screen">
        {{-- DECORATION BACKGROUND --}}
        <div class="absolute top-24 right-10 opacity-5 rotate-12 pointer-events-none">
            <span class="material-symbols-outlined text-[150px] text-primary">icecream</span>
        </div>
        <div class="absolute bottom-20 left-10 opacity-5 -rotate-12 pointer-events-none">
            <span class="material-symbols-outlined text-[120px] text-primary">cookie</span>
        </div>

        <div class="flex items-center gap-2 mb-6 z-10">
            <a class="text-primary/60 text-sm font-semibold hover:text-primary" href="{{ route('admin.products.index') }}">Products</a>
            <span class="material-symbols-outlined crumb-heart text-[12px] text-primary">favorite</span>
            <span class="text-primary text-sm font-bold">{{ $product->name }}</span>
        </div>

        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-8 z-10">
            <div>
                <div class="flex items-center gap-3 flex-wrap">
                    <h1 class="text-[#181113] dark:text-white text-4xl font-black tracking-tight">Product Detail</h1>
                    <span class="px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-black uppercase tracking-widest">
                        ID: {{ substr(md5($product->id), 0, 8) }}
                    </span>
                </div>
                <div class="text-primary/70 font-semibold mt-1">Slug: <span class="font-mono text-xs">{{ $product->slug }}</span></div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.products.index') }}" class="px-4 py-2 rounded-2xl bg-white dark:bg-background-dark border-2 border-primary/10 text-primary font-black hover:bg-primary/5">
                    Back
                </a>
                <a href="{{ route('admin.products.edit', $product) }}" class="px-4 py-2 rounded-2xl bg-primary text-white font-black hover:brightness-105">
                    Edit
                </a>
            </div>
        </div>

        @php
            $minPrice = $product->variants->min('price');
            $maxPrice = $product->variants->max('price');
            $totalStock = (int) $product->variants->sum('stock');
            $hasImages = $product->images->count() > 0;
            $mainImage = $hasImages ? $product->images->first()->image : null;
        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 z-10">
            {{-- IMAGES --}}
            <div class="bg-white dark:bg-background-dark/80 rounded-3xl border-2 border-primary/10 overflow-hidden h-fit">
                <div class="p-6 border-b border-primary/10 flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-primary/60 uppercase tracking-widest">Gallery</div>
                        <div class="text-lg font-black text-[#181113] dark:text-white">Images</div>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-secondary/20 text-primary text-xs font-black uppercase tracking-widest">
                        {{ $product->images->count() }} pics
                    </span>
                </div>

                <div class="p-6 space-y-4">
                    @if($mainImage)
                        <div class="w-full aspect-square rounded-3xl overflow-hidden border-2 border-primary/10 bg-primary/5">
                            <img
                                src="{{ asset('storage/' . ltrim($mainImage, '/')) }}"
                                alt="{{ $product->name }}"
                                class="w-full h-full object-cover"
                                loading="lazy"
                            />
                        </div>

                        @if($product->images->count() > 1)
                            <div class="grid grid-cols-4 gap-3">
                                @foreach($product->images->skip(1) as $img)
                                    <div class="aspect-square rounded-2xl overflow-hidden border-2 border-primary/10 bg-primary/5">
                                        <img
                                            src="{{ asset('storage/' . ltrim($img->image, '/')) }}"
                                            alt="{{ $product->name }}"
                                            class="w-full h-full object-cover"
                                            loading="lazy"
                                        />
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @else
                        <div class="w-full aspect-square rounded-3xl bg-primary/5 border-2 border-dashed border-primary/20 flex items-center justify-center">
                            <div class="text-center">
                                <div class="text-primary font-black">No images</div>
                                <div class="text-primary/60 text-xs font-semibold">Upload in edit page</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- DETAILS + VARIANTS --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white dark:bg-background-dark/80 rounded-3xl border-2 border-primary/10 overflow-hidden">
                    <div class="p-6 border-b border-primary/10 flex items-start justify-between gap-4">
                        <div>
                            <div class="text-xs font-bold text-primary/60 uppercase tracking-widest">Category</div>
                            <div class="mt-1 inline-flex items-center gap-2">
                                <span class="px-4 py-1.5 rounded-full bg-secondary/20 text-primary text-xs font-black uppercase tracking-widest">
                                    {{ $product->category->name ?? 'Uncategorized' }}
                                </span>
                                <span class="text-primary/60 text-xs font-semibold">Created: {{ $product->created_at?->format('d M Y') }}</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs font-bold text-primary/60 uppercase tracking-widest">Price Range</div>
                            <div class="text-lg font-black text-primary">
                                @if($minPrice === null)
                                    Rp —
                                @elseif($minPrice === $maxPrice)
                                    Rp {{ number_format((float) $minPrice, 0, ',', '.') }}
                                @else
                                    Rp {{ number_format((float) $minPrice, 0, ',', '.') }} – {{ number_format((float) $maxPrice, 0, ',', '.') }}
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="text-xs font-bold text-primary/60 uppercase tracking-widest">Name</div>
                        <div class="text-3xl font-black text-[#181113] dark:text-white mt-1">{{ $product->name }}</div>

                        <div class="mt-6">
                            <div class="text-xs font-bold text-primary/60 uppercase tracking-widest">Description</div>
                            <div class="mt-2 text-sm font-semibold text-[#181113]/80 dark:text-white/80 leading-relaxed whitespace-pre-line">
                                {{ $product->description }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-background-dark/80 rounded-3xl border-2 border-primary/10 overflow-hidden">
                    <div class="p-6 border-b border-primary/10 flex items-center justify-between">
                        <div>
                            <div class="text-xs font-bold text-primary/60 uppercase tracking-widest">Inventory</div>
                            <div class="text-lg font-black text-[#181113] dark:text-white">Variants</div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-black uppercase tracking-widest">{{ $product->variants->count() }} variants</span>
                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-black uppercase tracking-widest">Stock: {{ $totalStock }}</span>
                        </div>
                    </div>

                    <div class="p-6">
                        @if($product->variants->count() === 0)
                            <div class="text-center text-primary/60 font-bold py-10">No variants yet</div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="candy-table-header">
                                            <th class="p-4 text-primary font-extrabold uppercase text-xs tracking-wider">Color</th>
                                            <th class="p-4 text-primary font-extrabold uppercase text-xs tracking-wider">Size</th>
                                            <th class="p-4 text-primary font-extrabold uppercase text-xs tracking-wider text-right">Stock</th>
                                            <th class="p-4 text-primary font-extrabold uppercase text-xs tracking-wider text-right">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-primary/5">
                                        @foreach($product->variants as $v)
                                            <tr class="hover:bg-primary/5 transition-colors">
                                                <td class="p-4 font-black text-[#181113] dark:text-white">{{ $v->color ?: '—' }}</td>
                                                <td class="p-4 font-black text-[#181113] dark:text-white">{{ $v->size ?: '—' }}</td>
                                                <td class="p-4 text-right">
                                                    @if((int) $v->stock > 0)
                                                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-black uppercase tracking-widest">{{ (int) $v->stock }}</span>
                                                    @else
                                                        <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-black uppercase tracking-widest">Out</span>
                                                    @endif
                                                </td>
                                                <td class="p-4 text-right font-black text-primary">Rp {{ number_format((float) $v->price, 0, ',', '.') }}</td>
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
