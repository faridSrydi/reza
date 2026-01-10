@extends('layouts.app')


@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">


    {{-- ================= HEADER ================= --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                Produk Terbaru
            </h1>
            <p class="text-gray-500 mt-1">
                Temukan produk terbaik sesuai kebutuhanmu
            </p>
        </div>


        {{-- Filter Category --}}
        <form method="GET">
            <select
                name="category"
                onchange="this.form.submit()"
                class="border rounded-lg px-4 py-2 text-gray-700 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
            >
                <option value="">Semua Kategori</option>
                @foreach ($categories as $category)
                    <option
                        value="{{ $category->slug }}"
                        {{ request('category') == $category->slug ? 'selected' : '' }}
                    >
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>


    {{-- ================= PRODUCT GRID ================= --}}
    @if ($products->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($products as $product)
                <a href="{{ route('product.show', $product->slug) }}"
                   class="group border rounded-xl overflow-hidden hover:shadow-lg transition bg-white">


                    {{-- Image --}}
                    <div class="h-48 bg-gray-100 overflow-hidden">
                        <img
                            src="{{ asset('storage/' . ($product->images->first()->image ?? '')) }}"
                            alt="{{ $product->name }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                        >
                    </div>


                    {{-- Content --}}
                    <div class="p-4">
                        <p class="text-sm text-indigo-600 font-medium">
                            {{ $product->category->name }}
                        </p>


                        <h3 class="text-lg font-semibold text-gray-800 mt-1 line-clamp-2">
                            {{ $product->name }}
                        </h3>


                        <p class="text-sm text-gray-500 mt-1">
                            Mulai dari
                        </p>


                        <p class="text-lg font-bold text-indigo-600">
                            Rp {{ number_format($product->variants->min('price')) }}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>


        {{-- Pagination --}}
        <div class="mt-10">
            {{ $products->withQueryString()->links() }}
        </div>
    @else
        <div class="text-center py-20">
            <p class="text-gray-500 text-lg">
                Produk belum tersedia
            </p>
        </div>
    @endif


</div>
@endsection


