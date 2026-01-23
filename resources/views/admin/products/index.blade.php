@extends('layouts.admin')

@section('title', 'Product Inventory')

@section('content')
<main class="flex-1 flex flex-col py-10 px-10 relative overflow-hidden min-h-screen">
    {{-- DECORATION BACKGROUND --}}
    <div class="absolute top-40 right-10 opacity-5 rotate-12 pointer-events-none">
        <span class="material-symbols-outlined text-[150px] text-primary">cake</span>
    </div>
    <div class="absolute bottom-20 left-10 opacity-5 -rotate-12 pointer-events-none">
        <span class="material-symbols-outlined text-[120px] text-primary">cookie</span>
    </div>

    {{-- HEADER SECTION --}}
    <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-8 z-10">
        <div class="flex flex-col gap-4 w-full md:w-2/3">
            <h1 class="text-[#181113] dark:text-white text-4xl font-black tracking-tight">Product Inventory 🍭</h1>
            
            {{-- Search Bar --}}
            <form method="GET" action="{{ route('admin.products.index') }}" class="relative w-full max-w-xl">
                <div class="gum-stick bg-gum flex items-center h-12 rounded-lg px-4 border-2 border-primary/20">
                    <span class="material-symbols-outlined text-primary mr-3">search</span>
                    <input
                        class="bg-transparent border-none focus:ring-0 w-full text-primary font-bold placeholder:text-primary/50 text-sm"
                        placeholder="Search name / slug..."
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        autocomplete="off"
                    />
                    @if(request('q'))
                        <a href="{{ route('admin.products.index') }}" class="ml-2 text-primary/60 hover:text-primary font-black text-xs">Clear</a>
                    @endif
                </div>
                <div class="absolute -right-2 -top-1 w-4 h-full bg-white/20 skew-x-12 pointer-events-none"></div>
            </form>
        </div>

        {{-- CREATE BUTTON --}}
        <a href="{{ route('admin.products.create') }}" class="group relative flex flex-col items-center justify-center transition-transform hover:scale-110 active:scale-95">
            <div class="w-24 h-24 bg-primary rounded-full flex items-center justify-center shadow-lg relative z-10 border-4 border-white">
                <span class="material-symbols-outlined text-white text-4xl font-bold">add</span>
            </div>
            <div class="w-2 h-16 bg-[#e2e8f0] rounded-b-full -mt-2 shadow-inner"></div>
            <span class="absolute -bottom-8 whitespace-nowrap text-primary font-black text-xs uppercase tracking-widest">Create New</span>
        </a>
    </div>

    {{-- TABLE CONTAINER --}}
    <div class="bg-white dark:bg-background-dark/80 rounded-[3rem] border-[4px] border-primary/20 shadow-xl overflow-hidden z-10">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="candy-table-header">
                        <th class="p-6 text-primary font-extrabold uppercase text-xs tracking-wider rounded-tl-[2.5rem]">Product</th>
                        <th class="p-6 text-primary font-extrabold uppercase text-xs tracking-wider">Category</th>
                        <th class="p-6 text-primary font-extrabold uppercase text-xs tracking-wider">Price</th>
                        <th class="p-6 text-primary font-extrabold uppercase text-xs tracking-wider">Variants / Stock</th>
                        <th class="p-6 text-primary font-extrabold uppercase text-xs tracking-wider text-right rounded-tr-[2.5rem]">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-primary/5">
                    @forelse($products as $product)
                    <tr class="hover:bg-primary/5 transition-colors group">
                        {{-- Product Name & Image --}}
                        <td class="p-6">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 rounded-2xl bg-primary/10 overflow-hidden border-2 border-primary/5">
                                    @php
                                        $firstImage = optional($product->images->first())->image;
                                        $imgSrc = $firstImage ? asset('storage/' . ltrim($firstImage, '/')) : ('https://ui-avatars.com/api/?name=' . urlencode($product->name) . '&background=random');
                                    @endphp
                                    <img alt="{{ $product->name }}" class="w-full h-full object-cover" src="{{ $imgSrc }}" loading="lazy" />
                                </div>
                                <div>
                                    <p class="font-bold text-[#181113] dark:text-white">{{ $product->name }}</p>
                                    <p class="text-xs text-primary/60 font-medium font-mono">ID: {{ substr(md5($product->id), 0, 8) }}</p>
                                </div>
                            </div>
                        </td>

                        {{-- Category --}}
                        <td class="p-6">
                            <span class="px-4 py-1.5 rounded-full bg-secondary/20 text-primary text-xs font-bold uppercase">
                                {{ $product->category->name ?? 'Uncategorized' }}
                            </span>
                        </td>

                        {{-- Price (Rupiah: ambil harga termurah dari variants) --}}
                        <td class="p-6 font-black text-[#181113] dark:text-white">
                            @php
                                $minPrice = $product->variants->min('price');
                            @endphp
                            {{ $minPrice !== null ? ('Rp ' . number_format((float) $minPrice, 0, ',', '.')) : 'Rp —' }}
                        </td>

                        {{-- Stock / Variants Count --}}
                        <td class="p-6">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full {{ $product->variants->count() > 0 ? 'bg-green-400' : 'bg-red-400' }}"></span>
                                <span class="font-bold text-sm">{{ $product->variants->count() }} Variants</span>
                            </div>
                        </td>

                        {{-- Actions --}}
                        <td class="p-6">
                            <div class="flex justify-end gap-3">
                                {{-- View Button --}}
                                <a href="{{ route('admin.products.show', $product) }}" class="w-10 h-10 rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200 flex items-center justify-center transition-colors">
                                    <span class="material-symbols-outlined text-lg" style="font-variation-settings: 'FILL' 1">visibility</span>
                                </a>

                                {{-- Edit Button --}}
                                <a href="{{ route('admin.products.edit', $product) }}" class="w-10 h-10 rounded-full bg-blue-100 text-blue-500 hover:bg-blue-200 flex items-center justify-center transition-colors">
                                    <span class="material-symbols-outlined text-lg" style="font-variation-settings: 'FILL' 1">edit</span>
                                </a>

                                {{-- Delete Button (Modal) --}}
                                <button
                                    type="button"
                                    class="w-10 h-10 rounded-full bg-orange-100 text-orange-500 hover:bg-orange-200 flex items-center justify-center transition-colors"
                                    data-delete-open
                                    data-delete-name="{{ $product->name }}"
                                    data-delete-action="{{ route('admin.products.destroy', $product) }}"
                                >
                                    <span class="material-symbols-outlined text-lg" style="font-variation-settings: 'FILL' 1">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-10 text-center text-primary/50 font-bold">
                            No sweets found in the jar! 🍪
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION / FOOTER --}}
        <div class="p-6 candy-table-header flex items-center justify-between">
            <span class="text-primary font-bold text-sm">
                @if($products->total() > 0)
                    Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }}
                @else
                    Total: 0
                @endif
            </span>
            
            <div class="text-primary">
                {{ $products->links() }}
            </div>
        </div>
    </div>

    {{-- DELETE CONFIRM MODAL --}}
    <div id="deleteModal" class="fixed inset-0 z-[100] hidden">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" data-delete-close></div>
        <div class="relative min-h-screen flex items-end sm:items-center justify-center p-4">
            <div class="w-full max-w-md bg-white dark:bg-background-dark rounded-[2rem] border-[3px] border-primary/20 shadow-2xl p-6">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-orange-100 text-orange-600 flex items-center justify-center">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1">delete</span>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-[#181113] dark:text-white text-xl font-black">Delete product?</h2>
                        <p class="text-sm text-primary/70 font-semibold mt-1">This will permanently remove <span id="deleteModalName" class="text-[#181113] dark:text-white font-black"></span>.</p>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-3">
                    <button type="button" class="px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 font-black text-gray-700" data-delete-close>
                        Cancel
                    </button>
                    <form id="deleteModalForm" method="POST" action="#" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 rounded-xl bg-orange-500 hover:bg-orange-600 text-white font-black">
                            Yes, delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

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