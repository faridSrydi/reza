@extends('layouts.admin')

@section('title', 'Products')

@section('content')

@php
    $q = request('q');
    $firstItem = $products->firstItem() ?? 0;
    $lastItem = $products->lastItem() ?? 0;
    $total = $products->total() ?? 0;

    $page = $products->currentPage();
    $lastPage = $products->lastPage();

    $startPage = max(1, $page - 1);
    $endPage = min($lastPage, $page + 1);
    if ($endPage - $startPage < 2) {
        $startPage = max(1, $endPage - 2);
        $endPage = min($lastPage, $startPage + 2);
    }

    $pageRange = $lastPage > 0 ? range($startPage, $endPage) : [];
@endphp

<header class="lg:sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-[#f3e7ed] px-4 sm:px-6 lg:px-8 py-4">
    <div class="flex items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <h1 class="text-2xl font-bold serif-text">Products</h1>
        </div>

        <div class="flex items-center gap-3 sm:gap-6">
            <form method="GET" action="{{ route('admin.products.index') }}" class="hidden md:flex flex-col min-w-64 h-10">
                <div class="flex w-full flex-1 items-stretch rounded-lg h-full bg-[#f3e7ed]">
                    <div class="text-[#9a4c73] flex items-center justify-center pl-4">
                        <span class="material-symbols-outlined text-xl">search</span>
                    </div>
                    <input name="q" value="{{ $q }}"
                        class="form-input flex w-full min-w-0 flex-1 border-none bg-transparent focus:outline-0 focus:ring-0 h-full placeholder:text-[#9a4c73] px-3 text-sm font-normal"
                        placeholder="Search by name, slug..." />
                </div>
            </form>

            <a href="{{ route('admin.products.create') }}"
                class="flex items-center gap-2 bg-primary text-white px-5 sm:px-6 py-2.5 rounded-lg text-sm font-bold shadow-lg hover:opacity-90 transition-opacity">
                <span class="material-symbols-outlined text-xl">add</span>
                <span class="hidden sm:inline">Add New Product</span>
                <span class="sm:hidden">Add</span>
            </a>
        </div>
    </div>
</header>

<div class="p-4 sm:p-6 lg:p-8">
    @if (session('success'))
        <div class="mb-6 bg-white border border-[#f3e7ed] rounded-2xl p-4 text-sm text-gray-700">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->has('error'))
        <div class="mb-6 bg-white border border-red-200 rounded-2xl p-4 text-sm text-red-600">
            {{ $errors->first('error') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-[#f3e7ed] overflow-hidden shadow-sm">
        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-[#f3e7ed] bg-[#faf8f9]">
                        <th class="px-4 sm:px-6 py-5 text-xs font-bold uppercase tracking-wider text-gray-500">Product</th>
                        <th class="px-4 sm:px-6 py-5 text-xs font-bold uppercase tracking-wider text-gray-500">Category</th>
                        <th class="px-4 sm:px-6 py-5 text-xs font-bold uppercase tracking-wider text-gray-500">Price</th>
                        <th class="px-4 sm:px-6 py-5 text-xs font-bold uppercase tracking-wider text-gray-500">Stock Status</th>
                        <th class="px-4 sm:px-6 py-5 text-xs font-bold uppercase tracking-wider text-gray-500 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f3e7ed]">
                    @forelse ($products as $product)
                        @php
                            $firstImage = optional($product->images->first())->image;
                            $imgSrc = $firstImage ? asset('storage/' . ltrim($firstImage, '/')) : ('https://ui-avatars.com/api/?name=' . urlencode($product->name) . '&background=f3e7ed&color=9a4c73');

                            $minPrice = $product->variants->min('price');
                            $stock = (int) $product->variants->sum('stock');

                            if ($stock <= 0) {
                                $stockDot = 'bg-red-500';
                                $stockText = 'Out of Stock';
                                $stockTextClass = 'text-red-600';
                            } elseif ($stock <= 10) {
                                $stockDot = 'bg-amber-500';
                                $stockText = 'Low Stock';
                                $stockTextClass = 'text-amber-600';
                            } else {
                                $stockDot = 'bg-emerald-500';
                                $stockText = 'In Stock';
                                $stockTextClass = 'text-emerald-600';
                            }

                            $sku = 'PRD-' . str_pad((string) $product->id, 4, '0', STR_PAD_LEFT);
                        @endphp

                        <tr class="hover:bg-gray-50 transition-colors group">
                            <td class="px-4 sm:px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="size-14 rounded-lg bg-cover bg-center border border-[#f3e7ed] flex-shrink-0"
                                        style='background-image: url("{{ $imgSrc }}");'>
                                    </div>
                                    <div>
                                        <p class="font-bold text-sm">{{ $product->name }}</p>
                                        <p class="text-xs text-gray-500 uppercase tracking-tight">SKU: {{ $sku }}</p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-4 sm:px-6 py-4">
                                <span class="px-3 py-1 bg-[#f3e7ed] text-[#9a4c73] text-xs font-bold rounded-full">
                                    {{ $product->category->name ?? 'Uncategorized' }}
                                </span>
                            </td>

                            <td class="px-4 sm:px-6 py-4 font-semibold text-sm">
                                {{ $minPrice !== null ? ('Rp ' . number_format((float) $minPrice, 0, ',', '.')) : 'Rp —' }}
                            </td>

                            <td class="px-4 sm:px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <span class="size-2 rounded-full {{ $stockDot }}"></span>
                                    <span class="text-xs font-medium {{ $stockTextClass }}">{{ $stockText }}{{ $stockText !== 'Out of Stock' ? ' (' . $stock . ')' : '' }}</span>
                                </div>
                            </td>

                            <td class="px-4 sm:px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="p-2 text-gray-400 hover:text-primary transition-colors" aria-label="Edit">
                                        <span class="material-symbols-outlined text-xl">edit</span>
                                    </a>
                                    <button type="button" class="p-2 text-gray-400 hover:text-red-500 transition-colors" aria-label="Delete"
                                        data-delete-open data-delete-name="{{ $product->name }}" data-delete-action="{{ route('admin.products.destroy', $product) }}">
                                        <span class="material-symbols-outlined text-xl">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 sm:px-6 py-10 text-center text-sm text-gray-500">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 sm:px-6 py-5 border-t border-[#f3e7ed] flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <p class="text-sm text-gray-500">
                Showing <span class="font-bold text-[#1b0d14]">{{ $firstItem }}</span> to <span class="font-bold text-[#1b0d14]">{{ $lastItem }}</span> of <span class="font-bold text-[#1b0d14]">{{ $total }}</span> results
            </p>

            <div class="flex gap-2">
                <a class="size-10 rounded-lg border border-[#f3e7ed] flex items-center justify-center text-gray-400 hover:bg-gray-50 transition-colors {{ $products->onFirstPage() ? 'pointer-events-none opacity-50' : '' }}"
                    href="{{ $products->previousPageUrl() ?? '#' }}" aria-label="Previous">
                    <span class="material-symbols-outlined">chevron_left</span>
                </a>

                @foreach ($pageRange as $p)
                    @if ($p === $page)
                        <span class="size-10 rounded-lg bg-primary text-white flex items-center justify-center text-sm font-bold">{{ $p }}</span>
                    @else
                        <a class="size-10 rounded-lg border border-[#f3e7ed] flex items-center justify-center text-sm font-bold hover:bg-gray-50 transition-colors"
                            href="{{ $products->url($p) }}">{{ $p }}</a>
                    @endif
                @endforeach

                <a class="size-10 rounded-lg border border-[#f3e7ed] flex items-center justify-center text-gray-400 hover:bg-gray-50 transition-colors {{ $products->hasMorePages() ? '' : 'pointer-events-none opacity-50' }}"
                    href="{{ $products->nextPageUrl() ?? '#' }}" aria-label="Next">
                    <span class="material-symbols-outlined">chevron_right</span>
                </a>
            </div>
        </div>
    </div>
</div>

{{-- DELETE CONFIRM MODAL --}}
<div id="deleteModal" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" data-delete-close></div>
    <div class="relative min-h-screen flex items-end sm:items-center justify-center p-4">
        <div class="w-full max-w-md bg-white rounded-2xl border border-[#f3e7ed] shadow-2xl p-6">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center">
                    <span class="material-symbols-outlined">delete</span>
                </div>
                <div class="flex-1">
                    <h2 class="text-[#1b0d14] text-xl font-bold">Delete product?</h2>
                    <p class="text-sm text-gray-600 mt-1">This will permanently remove <span id="deleteModalName" class="text-[#1b0d14] font-bold"></span>.</p>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-3">
                <button type="button" class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 font-bold text-gray-700" data-delete-close>
                    Cancel
                </button>
                <form id="deleteModalForm" method="POST" action="#" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white font-bold">
                        Yes, delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        var modal = document.getElementById('deleteModal');
        var form = document.getElementById('deleteModalForm');
        var nameEl = document.getElementById('deleteModalName');

        function openModal(productName, actionUrl) {
            if (!modal || !form || !nameEl) return;
            nameEl.textContent = productName || '';
            form.setAttribute('action', actionUrl || '#');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            if (!modal) return;
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }

        document.addEventListener('click', function (e) {
            var openBtn = e.target && e.target.closest ? e.target.closest('[data-delete-open]') : null;
            if (openBtn) {
                e.preventDefault();
                openModal(openBtn.getAttribute('data-delete-name'), openBtn.getAttribute('data-delete-action'));
                return;
            }

            var closeBtn = e.target && e.target.closest ? e.target.closest('[data-delete-close]') : null;
            if (closeBtn) {
                e.preventDefault();
                closeModal();
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeModal();
        });
    })();
</script>
@endsection