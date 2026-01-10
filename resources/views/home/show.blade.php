@extends('layouts.app')


@section('title', $product->name)


@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">


        {{-- ================= IMAGE GALLERY ================= --}}
        <div>
            <div class="border rounded-xl overflow-hidden shadow-sm bg-white">
                <img
                    id="mainImage"
                    src="{{ asset('storage/' . ($product->images->first()->image ?? '')) }}"
                    alt="{{ $product->name }}"
                    class="w-full h-96 object-contain"
                >
            </div>


            <div class="flex gap-3 mt-4 overflow-x-auto pb-2">
                @foreach ($product->images as $image)
                    <img
                        src="{{ asset('storage/'.$image->image) }}"
                        onclick="document.getElementById('mainImage').src = this.src"
                        class="w-20 h-20 object-cover rounded-lg border hover:border-indigo-500 cursor-pointer transition flex-shrink-0"
                        alt="{{ $product->name }}"
                    >
                @endforeach
            </div>
        </div>


        {{-- ================= PRODUCT INFO ================= --}}
        <div>
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3 text-sm text-gray-500">
                    <li><a href="{{ route('home') }}" class="hover:text-indigo-600">Home</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li class="text-indigo-600 font-semibold">{{ $product->category->name }}</li>
                </ol>
            </nav>


            <h1 class="text-3xl font-bold text-gray-900 mt-2">
                {{ $product->name }}
            </h1>


            <p class="text-gray-600 mt-4 leading-relaxed">
                {{ $product->description }}
            </p>


            {{-- ================= ADD TO CART FORM ================= --}}
            <form action="{{ route('cart.add') }}" method="POST" class="mt-8">
                @csrf


                {{-- Data Produk yang dibutuhkan Controller --}}
                <input type="hidden" name="product_name" value="{{ $product->name }}">
                {{-- Harga Default (akan diupdate via JS saat pilih variant jika ingin lebih dinamis) --}}
                <input type="hidden" id="selected_price" name="price" value="{{ $product->variants->min('price') }}">


                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    Pilih Variant & Ukuran
                </h3>


                <div class="space-y-3">
                    @foreach ($product->variants as $variant)
                        <label
                            class="group flex items-center justify-between border rounded-xl p-4 cursor-pointer hover:border-indigo-500 hover:bg-indigo-50/30 transition
                            {{ $variant->stock == 0 ? 'opacity-50 cursor-not-allowed bg-gray-50' : '' }}"
                        >
                            <div class="flex items-center gap-4">
                                <input
                                    type="radio"
                                    name="variant_id"
                                    value="{{ $variant->id }}"
                                    data-price="{{ $variant->price }}"
                                    onclick="document.getElementById('selected_price').value = this.getAttribute('data-price'); document.getElementById('display_price').innerText = 'Rp ' + Number(this.getAttribute('data-price')).toLocaleString()"
                                    class="w-5 h-5 text-indigo-600 focus:ring-indigo-500"
                                    {{ $variant->stock == 0 ? 'disabled' : 'required' }}
                                >


                                <div>
                                    <p class="font-bold text-gray-800 group-hover:text-indigo-700">
                                        {{ $variant->color ?? 'Standard' }} {{ $variant->size ? '- Size ' . $variant->size : '' }}
                                    </p>
                                    <p class="text-sm text-gray-500 italic">
                                        Sisa Stok: {{ $variant->stock }}
                                    </p>
                                </div>
                            </div>


                            <div class="text-right">
                                <p class="font-bold text-gray-900">
                                    Rp {{ number_format($variant->price) }}
                                </p>
                                @if ($variant->stock > 0)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                        Tersedia
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                        Habis
                                    </span>
                                @endif
                            </div>
                        </label>
                    @endforeach
                </div>


                {{-- ================= QUANTITY & PRICE DISPLAY ================= --}}
                <div class="mt-8 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-gray-600 font-medium">Kuantitas</span>
                        <div class="flex items-center border rounded-lg bg-white">
                            <button type="button" onclick="this.nextElementSibling.stepDown()" class="px-3 py-1 hover:text-indigo-600 font-bold">−</button>
                            <input type="number" name="qty" value="1" min="1" class="w-12 text-center border-none focus:ring-0 text-sm font-semibold">
                            <button type="button" onclick="this.previousElementSibling.stepUp()" class="px-3 py-1 hover:text-indigo-600 font-bold">+</button>
                        </div>
                    </div>


                    <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                        <span class="text-gray-800 font-bold text-lg">Subtotal</span>
                        <span id="display_price" class="text-2xl font-black text-indigo-600">
                            Rp {{ number_format($product->variants->min('price')) }}
                        </span>
                    </div>
                </div>


                {{-- ================= ACTION BUTTON ================= --}}
                <div class="mt-6 flex flex-col sm:flex-row gap-4">
                    <button
                        type="submit"
                        class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white py-4 rounded-xl font-bold text-lg shadow-lg shadow-indigo-200 transition-all active:scale-95 disabled:bg-gray-400 disabled:shadow-none"
                        {{ $product->variants->sum('stock') == 0 ? 'disabled' : '' }}>
                        @if($product->variants->sum('stock') == 0)
                            Stok Habis
                        @else
                            Tambah ke Keranjang
                        @endif
                    </button>


                    <a href="{{ route('home') }}"
                       class="sm:w-32 flex items-center justify-center border border-gray-300 text-gray-600 py-4 rounded-xl font-semibold hover:bg-white hover:border-gray-400 transition">
                        Batal
                    </a>
                </div>
            </form>


            <p class="mt-4 text-xs text-center text-gray-400 italic">
                * Pastikan Anda telah memilih variant yang benar sebelum menekan tombol tambah.
            </p>
        </div>
    </div>
</div>
@endsection
