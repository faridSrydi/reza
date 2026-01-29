@extends('layouts.admin')

@section('title', 'Edit Product')

@push('styles')
    <style type="text/tailwindcss">
        .form-section-card {
            @apply bg-white border border-[#f3e7ed] rounded-2xl p-6 shadow-sm;
        }

        .input-label {
            @apply block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2;
        }

        .text-input {
            @apply w-full border-[#f3e7ed] rounded-lg bg-[#fcfaff] focus:ring-primary focus:border-primary text-sm p-3;
        }
    </style>
@endpush

@section('content')
<header class="lg:sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-[#f3e7ed] px-4 sm:px-6 lg:px-8 py-4">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-sm text-gray-500 mb-1">
                <a class="hover:text-primary" href="{{ route('admin.products.index') }}">Products</a>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <span>Edit</span>
            </div>
            <h1 class="text-3xl font-bold serif-text">Edit Product</h1>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center gap-3 w-full md:w-auto">
            <a href="{{ route('admin.products.index') }}"
                class="w-full sm:w-auto text-center px-6 py-2.5 rounded-lg border border-[#f3e7ed] text-sm font-bold hover:bg-gray-50 transition-colors">
                Cancel
            </a>
            <button form="productForm" type="submit"
                class="w-full sm:w-auto px-6 py-2.5 rounded-lg bg-primary text-white text-sm font-bold hover:opacity-90 shadow-lg shadow-primary/20 transition-all">
                Save Changes
            </button>
        </div>
    </div>
</header>

<main class="p-4 sm:p-6 lg:p-8">
    @if ($errors->any())
        <div class="mb-6 bg-white border border-red-200 rounded-2xl p-4">
            <p class="text-sm font-bold text-red-600 mb-2">Please fix the errors below:</p>
            <ul class="text-sm text-red-600 list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="productForm" method="POST" enctype="multipart/form-data" action="{{ route('admin.products.update', $product) }}">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <section class="form-section-card">
                    <h3 class="text-lg font-bold mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">info</span>
                        Product Information
                    </h3>

                    <div class="space-y-6">
                        <div>
                            <label class="input-label" for="product-name">Product Name</label>
                            <input class="text-input" id="product-name" name="name" value="{{ old('name', $product->name) }}" placeholder="e.g. Velvet Rose Matte Lipstick" type="text" required />
                        </div>

                        <div>
                            <label class="input-label" for="description">Description</label>
                            <textarea class="text-input resize-none" id="description" name="description" placeholder="Provide a detailed description of the product..." rows="6" required>{{ old('description', $product->description) }}</textarea>
                        </div>
                    </div>
                </section>

                <section class="form-section-card">
                    <h3 class="text-lg font-bold mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">image</span>
                        Product Media
                    </h3>

                    <div class="space-y-6">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest text-gray-500 mb-3">Existing images</p>

                            @if ($product->images->count() > 0)
                                <div id="existingImagesWrap">
                                    <div id="existingImagesSortable" class="grid grid-cols-4 md:grid-cols-6 gap-4">
                                        @foreach ($product->images as $img)
                                            <div class="relative" data-image-id="{{ $img->id }}">
                                                <div class="aspect-square rounded-lg border border-[#f3e7ed] bg-gray-50 overflow-hidden">
                                                    <img src="{{ asset('storage/' . ltrim($img->image, '/')) }}" alt="Product" class="w-full h-full object-cover" />
                                                </div>
                                                <div class="mt-2 flex items-center justify-between gap-2">
                                                    <span class="drag-handle cursor-grab text-gray-400 hover:text-primary" title="Drag to reorder">
                                                        <span class="material-symbols-outlined text-[18px]">drag_indicator</span>
                                                    </span>
                                                    <label class="inline-flex items-center gap-2 text-[11px] font-bold text-gray-600 cursor-pointer select-none">
                                                        <input type="checkbox" name="delete_images[]" value="{{ $img->id }}" class="rounded border-[#f3e7ed] text-primary focus:ring-primary" />
                                                        Delete
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div id="imageOrderInputs" class="hidden">
                                        @foreach ($product->images as $img)
                                            <input type="hidden" name="image_order[]" value="{{ $img->id }}">
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <p class="text-sm text-gray-500">No existing images yet.</p>
                            @endif
                        </div>

                        <div class="border-t border-[#f3e7ed] pt-6">
                            <p class="text-xs font-bold uppercase tracking-widest text-gray-500 mb-3">Add new images</p>
                            <label for="newImagesInput"
                                class="block border-2 border-dashed border-[#f3e7ed] rounded-xl p-12 text-center hover:border-primary/50 transition-colors cursor-pointer group bg-[#fcfaff]">
                                <span class="material-symbols-outlined text-5xl text-gray-300 group-hover:text-primary transition-colors mb-4">upload_file</span>
                                <p class="text-sm font-bold mb-1">Drag and drop product images here</p>
                                <p class="text-xs text-gray-500 mb-6">Support JPEG, PNG, WEBP (Max 5MB)</p>
                                <span class="inline-flex px-6 py-2 bg-white border border-[#f3e7ed] rounded-lg text-xs font-bold shadow-sm">Select Files</span>
                                <input id="newImagesInput" type="file" name="images[]" multiple accept="image/*" class="hidden" />
                            </label>

                            <div id="newImagesPreviewWrap" class="mt-6 hidden">
                                <div class="flex items-center justify-between mb-3">
                                    <p class="text-xs font-bold uppercase tracking-widest text-gray-500">New uploads</p>
                                    <p class="text-xs font-bold text-primary/70">Drag to reorder</p>
                                </div>
                                <div id="newImagesPreview" class="grid grid-cols-4 md:grid-cols-6 gap-4"></div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="form-section-card">
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <h3 class="text-lg font-bold flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">inventory_2</span>
                            Variants
                        </h3>
                        <button type="button" onclick="addVariant()"
                            class="px-4 py-2 rounded-lg bg-primary/10 text-primary text-xs font-bold hover:bg-primary/15 transition-colors flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">add</span>
                            Add Variant
                        </button>
                    </div>

                    <div class="hidden md:grid md:grid-cols-12 gap-4 text-gray-500 text-xs font-bold uppercase tracking-wider">
                        <div class="md:col-span-3">Color</div>
                        <div class="md:col-span-3">Size</div>
                        <div class="md:col-span-3">Price (Rp)</div>
                        <div class="md:col-span-2">Stock</div>
                        <div class="md:col-span-1"></div>
                    </div>

                    <div id="variant-wrapper" class="space-y-3 mt-4">
                        @foreach ($product->variants as $i => $v)
                            <div class="variant-item grid grid-cols-1 md:grid-cols-12 gap-3">
                                <div class="md:col-span-3">
                                    <label class="input-label md:hidden">Color</label>
                                    <input name="variants[{{ $i }}][color]" value="{{ old('variants.' . $i . '.color', $v->color) }}" placeholder="e.g. Rose" class="text-input" />
                                </div>
                                <div class="md:col-span-3">
                                    <label class="input-label md:hidden">Size</label>
                                    <input name="variants[{{ $i }}][size]" value="{{ old('variants.' . $i . '.size', $v->size) }}" placeholder="e.g. 10ml" class="text-input" />
                                </div>
                                <div class="md:col-span-3">
                                    <label class="input-label md:hidden">Price (Rp)</label>
                                    <input name="variants[{{ $i }}][price]" value="{{ old('variants.' . $i . '.price', $v->price) }}" type="number" step="1" min="0" placeholder="0" class="text-input" required />
                                </div>
                                <div class="md:col-span-2">
                                    <label class="input-label md:hidden">Stock</label>
                                    <input name="variants[{{ $i }}][stock]" value="{{ old('variants.' . $i . '.stock', $v->stock) }}" type="number" step="1" min="0" placeholder="0" class="text-input" required />
                                </div>
                                <div class="md:col-span-1 flex md:justify-end md:items-end">
                                    <button type="button" onclick="removeVariant(this)" aria-label="Remove variant"
                                        class="h-10 w-10 rounded-lg border border-[#f3e7ed] hover:border-red-200 hover:bg-red-50 text-gray-500 hover:text-red-600 transition-colors flex items-center justify-center">
                                        <span class="material-symbols-outlined">close</span>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>

            <div class="space-y-8">
                <section class="form-section-card">
                    <h3 class="text-lg font-bold mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">payments</span>
                        Pricing
                    </h3>
                    <p class="text-sm text-gray-600">Pricing is managed per variant. Set the price in the Variants section.</p>
                </section>

                <section class="form-section-card">
                    <h3 class="text-lg font-bold mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">category</span>
                        Organization
                    </h3>
                    <div class="space-y-6">
                        <div>
                            <label class="input-label" for="category">Category</label>
                            <select class="text-input appearance-none" id="category" name="category_id" required>
                                @foreach ($categories as $c)
                                    <option value="{{ $c->id }}" @selected(old('category_id', $product->category_id) == $c->id)>{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <div class="mt-12 pt-8 border-t border-[#f3e7ed] flex justify-end gap-4">
            <a href="{{ route('admin.products.index') }}"
                class="px-6 py-2.5 rounded-lg border border-[#f3e7ed] text-sm font-bold hover:bg-gray-50 transition-colors">
                Cancel
            </a>
            <button type="submit"
                class="px-8 py-2.5 rounded-lg bg-primary text-white text-sm font-bold hover:opacity-90 shadow-lg shadow-primary/20">
                Save Changes
            </button>
        </div>
    </form>
</main>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
    let variantIndex = {{ $product->variants->count() }};

    function addVariant() {
        const wrapper = document.getElementById('variant-wrapper');
        const html = `
            <div class="grid grid-cols-12 gap-3 variant-item group animate-fade-in">
                <div class="col-span-3">
                    <input name="variants[${variantIndex}][color]" placeholder="Color/Flavor" class="w-full rounded-xl border-2 border-primary/10 bg-primary/5 focus:border-primary focus:ring-0 py-3 px-4 text-sm font-medium placeholder:text-primary/30" />
                </div>
                <div class="col-span-3">
                    <input name="variants[${variantIndex}][size]" placeholder="Size" class="w-full rounded-xl border-2 border-primary/10 bg-primary/5 focus:border-primary focus:ring-0 py-3 px-4 text-sm font-medium placeholder:text-primary/30" />
                </div>
                <div class="col-span-3">
                    <input name="variants[${variantIndex}][price]" type="number" step="0.01" placeholder="0.00" class="w-full rounded-xl border-2 border-primary/10 bg-primary/5 focus:border-primary focus:ring-0 py-3 px-4 text-sm font-medium placeholder:text-primary/30" />
                </div>
                <div class="col-span-2">
                    <input name="variants[${variantIndex}][stock]" type="number" placeholder="0" class="w-full rounded-xl border-2 border-primary/10 bg-primary/5 focus:border-primary focus:ring-0 py-3 px-4 text-sm font-medium placeholder:text-primary/30" />
                </div>
                <div class="col-span-1 flex justify-center items-center">
                    <button type="button" onclick="removeVariant(this)" class="w-8 h-8 rounded-full bg-red-100 text-red-400 hover:bg-red-500 hover:text-white flex items-center justify-center transition-colors" aria-label="Remove variant">
                        <span class="material-symbols-outlined text-lg">close</span>
                    </button>
                </div>
            </div>
        `;
        wrapper.insertAdjacentHTML('beforeend', html);
        variantIndex++;
    }

    function removeVariant(btn) {
        btn.closest('.variant-item')?.remove();
    }

    (function () {
        // Existing images reorder
        const existingList = document.getElementById('existingImagesSortable');
        const orderInputs = document.getElementById('imageOrderInputs');
        if (existingList && orderInputs) {
            function syncExistingOrderInputs() {
                orderInputs.innerHTML = '';
                existingList.querySelectorAll('[data-image-id]').forEach((el) => {
                    const id = el.getAttribute('data-image-id');
                    if (!id) return;
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'image_order[]';
                    input.value = id;
                    orderInputs.appendChild(input);
                });
            }

            new Sortable(existingList, {
                animation: 150,
                handle: '.drag-handle',
                ghostClass: 'opacity-50',
                onEnd: syncExistingOrderInputs,
            });

            syncExistingOrderInputs();
        }

        // New images preview + reorder (sync FileList)
        const input = document.getElementById('newImagesInput');
        const wrap = document.getElementById('newImagesPreviewWrap');
        const preview = document.getElementById('newImagesPreview');
        if (!input || !wrap || !preview) return;

        let selectedFiles = [];
        let sortable = null;

        function syncFileInput() {
            const dt = new DataTransfer();
            selectedFiles.forEach(f => dt.items.add(f));
            input.files = dt.files;
        }

        function render() {
            preview.innerHTML = '';
            if (selectedFiles.length === 0) {
                wrap.classList.add('hidden');
                if (sortable) {
                    sortable.destroy();
                    sortable = null;
                }
                return;
            }
            wrap.classList.remove('hidden');

            selectedFiles.forEach((file, idx) => {
                const url = URL.createObjectURL(file);
                const el = document.createElement('div');
                el.className = 'relative';
                el.innerHTML = `
                    <div class="aspect-square rounded-lg border border-[#f3e7ed] bg-gray-50 overflow-hidden">
                        <img src="${url}" alt="${file.name}" class="w-full h-full object-cover" />
                    </div>
                    <div class="mt-2 flex items-center justify-between gap-2">
                        <span class="drag-handle cursor-grab text-gray-400 hover:text-primary" title="Drag to reorder">
                            <span class="material-symbols-outlined text-[18px]">drag_indicator</span>
                        </span>
                        <button type="button" class="remove-image h-8 w-8 rounded-lg border border-[#f3e7ed] hover:border-red-200 hover:bg-red-50 text-gray-400 hover:text-red-600 flex items-center justify-center transition-colors" aria-label="Remove">
                            <span class="material-symbols-outlined text-[18px]">close</span>
                        </button>
                    </div>
                `;
                el.querySelector('.remove-image')?.addEventListener('click', () => {
                    selectedFiles.splice(idx, 1);
                    syncFileInput();
                    render();
                });
                preview.appendChild(el);
            });

            if (sortable) sortable.destroy();
            sortable = new Sortable(preview, {
                animation: 150,
                handle: '.drag-handle',
                ghostClass: 'opacity-50',
                onEnd: (evt) => {
                    if (evt.oldIndex == null || evt.newIndex == null) return;
                    const moved = selectedFiles.splice(evt.oldIndex, 1)[0];
                    selectedFiles.splice(evt.newIndex, 0, moved);
                    syncFileInput();
                    render();
                }
            });
        }

        input.addEventListener('change', (e) => {
            selectedFiles = Array.from(e.target.files || []);
            syncFileInput();
            render();
        });
    })();
</script>
@endsection