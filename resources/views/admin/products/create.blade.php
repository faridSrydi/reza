@extends('layouts.admin')

@section('title', 'Create Sweet Treat')

@section('content')
<main class="flex-1 flex flex-col items-center py-10 px-4 relative overflow-hidden min-h-screen">
    
    {{-- DECORATION BACKGROUND --}}
    <div class="absolute top-20 left-10 opacity-10 rotate-12 pointer-events-none">
        <span class="material-symbols-outlined text-[120px] text-primary">cookie</span>
    </div>
    <div class="absolute bottom-40 right-10 opacity-10 -rotate-12 pointer-events-none">
        <span class="material-symbols-outlined text-[100px] text-primary">cake</span>
    </div>
    <div class="absolute top-1/2 left-5 opacity-5 pointer-events-none">
        <span class="material-symbols-outlined text-[150px] text-primary">favorite</span>
    </div>

    <div class="w-full max-w-[900px] z-10">
        
        {{-- BREADCRUMBS --}}
        <div class="flex flex-wrap gap-2 px-4 mb-6">
            <a class="text-primary/60 dark:text-primary/40 text-sm font-medium hover:text-primary" href="#">Admin</a>
            <span class="material-symbols-outlined crumb-heart text-[12px] text-primary">favorite</span>
            <a class="text-primary/60 dark:text-primary/40 text-sm font-medium hover:text-primary" href="{{ route('admin.products.index') }}">Inventory</a>
            <span class="material-symbols-outlined crumb-heart text-[12px] text-primary">favorite</span>
            <span class="text-primary text-sm font-bold">Add New Product</span>
        </div>

        {{-- HEADER --}}
        <div class="mb-8">
            <h1 class="text-[#181113] dark:text-white tracking-tight text-4xl font-black leading-tight text-center">Create a New Tasty Treat!</h1>
            <p class="text-primary/70 text-center mt-2 font-medium">Fill in the recipe for success! 🧁✨</p>
        </div>

        {{-- FORM CONTAINER --}}
        <div class="bg-white dark:bg-background-dark/80 rounded-[4rem] border-[6px] border-primary shadow-2xl p-8 md:p-12 mb-20 relative">
            
            <form method="POST" enctype="multipart/form-data" action="{{ route('admin.products.store') }}" class="space-y-8">
                @csrf

                <div class="flex flex-col lg:flex-row gap-10">
                    
                    {{-- LEFT COLUMN: IMAGE UPLOAD --}}
                    <div class="flex flex-col items-center gap-4 w-full lg:w-1/3">
                        <label class="text-[#181113] dark:text-white text-base font-bold">Product Photos</label>
                        <p class="text-primary/60 text-xs font-bold">Upload multiple · Drag to reorder</p>
                        
                        {{-- Main Upload Box --}}
                        <div class="relative w-full aspect-square max-w-[280px]">
                            <div class="w-full h-full border-8 border-pink-200 rounded-[2.5rem] bg-pink-50 dark:bg-pink-900/20 flex flex-col items-center justify-center relative cursor-pointer hover:bg-pink-100 transition-colors overflow-hidden group">
                                <div class="absolute inset-4 border-4 border-dashed border-primary/20 rounded-[1.5rem] flex flex-col items-center justify-center pointer-events-none">
                                    <span class="material-symbols-outlined text-primary text-6xl mb-2" style="font-variation-settings: 'FILL' 1">add_a_photo</span>
                                    <span class="text-primary font-bold text-xs uppercase tracking-wider text-center px-4">Click to Upload Images</span>
                                    <span class="text-primary/40 text-[10px] mt-1">(Max 5MB)</span>
                                </div>
                                <input id="productImagesInput" type="file" name="images[]" multiple accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"/>
                            </div>
                        </div>

                        {{-- Image Previews Container --}}
                        <div id="image-preview-wrap" class="w-full mt-2 hidden">
                            <div id="image-preview-container" class="flex gap-2 overflow-x-auto pb-2"></div>
                            <p class="mt-2 text-[11px] font-bold text-primary/50">Tip: drag foto untuk urutan</p>
                        </div>
                    </div>

                    {{-- RIGHT COLUMN: INPUTS --}}
                    <div class="flex-1 space-y-6">
                        
                        {{-- Product Name --}}
                        <div class="flex flex-col gap-2">
                            <label class="flex items-center gap-2 text-[#181113] dark:text-white text-base font-bold pl-2">
                                Product Name <span class="material-symbols-outlined text-primary text-sm" style="font-variation-settings: 'FILL' 1">favorite</span>
                            </label>
                            <input name="name" class="w-full rounded-full border-2 border-primary/10 bg-primary/5 focus:border-primary focus:ring-0 h-14 px-6 text-[#181113] dark:text-white placeholder:text-primary/30 font-medium transition-all" placeholder="Strawberry Sparkle Cookie" type="text" required/>
                        </div>

                        {{-- Category Select --}}
                        <div class="flex flex-col gap-2">
                            <label class="flex items-center gap-2 text-[#181113] dark:text-white text-base font-bold pl-2">
                                Category <span class="material-symbols-outlined text-primary text-sm" style="font-variation-settings: 'FILL' 1">category</span>
                            </label>
                            <div class="relative">
                                <select name="category_id" class="w-full rounded-full border-2 border-primary/10 bg-primary/5 focus:border-primary focus:ring-0 h-14 px-6 text-[#181113] dark:text-white font-medium appearance-none cursor-pointer" required>
                                    <option value="">Select Category 🍭</option>
                                    @foreach ($categories as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-primary">
                                    <span class="material-symbols-outlined">expand_more</span>
                                </div>
                            </div>
                        </div>

                        {{-- Description --}}
                        <div class="flex flex-col gap-2">
                            <label class="flex items-center gap-2 text-[#181113] dark:text-white text-base font-bold pl-2">
                                Description <span class="material-symbols-outlined text-primary text-sm" style="font-variation-settings: 'FILL' 1">edit_note</span>
                            </label>
                            <textarea name="description" class="w-full rounded-[2rem] border-2 border-primary/10 bg-primary/5 focus:border-primary focus:ring-0 min-h-[120px] p-6 text-[#181113] dark:text-white placeholder:text-primary/30 font-medium resize-none" placeholder="Describe how delicious this snack is..."></textarea>
                        </div>

                    </div>
                </div>

                <hr class="border-primary/10 border-2 border-dashed rounded-full my-8">

                {{-- DYNAMIC VARIANTS SECTION --}}
                <div class="space-y-4">
                    <div class="flex justify-between items-center px-2">
                        <h3 class="text-[#181113] dark:text-white text-xl font-black">Flavor & Variants</h3>
                        <button type="button" onclick="addVariant()" class="px-4 py-2 rounded-full bg-secondary/20 text-primary text-xs font-bold uppercase hover:bg-secondary/40 transition-colors flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">add_circle</span> Add Variant
                        </button>
                    </div>

                    {{-- Variant Headers --}}
                    <div class="grid grid-cols-12 gap-4 px-4 text-primary/60 text-xs font-bold uppercase tracking-wider mb-2">
                        <div class="col-span-3">Details (Color/Flavor)</div>
                        <div class="col-span-3">Size</div>
                        <div class="col-span-3">Price ($)</div>
                        <div class="col-span-2">Stock</div>
                        <div class="col-span-1 text-center"></div>
                    </div>

                    <div id="variant-wrapper" class="space-y-3">
                        {{-- Default Row --}}
                        <div class="grid grid-cols-12 gap-3 variant-item group">
                            <div class="col-span-3">
                                <input name="variants[0][color]" placeholder="Red / Strawberry" class="w-full rounded-xl border-2 border-primary/10 bg-primary/5 focus:border-primary focus:ring-0 py-3 px-4 text-sm font-medium placeholder:text-primary/30">
                            </div>
                            <div class="col-span-3">
                                <input name="variants[0][size]" placeholder="Box of 6" class="w-full rounded-xl border-2 border-primary/10 bg-primary/5 focus:border-primary focus:ring-0 py-3 px-4 text-sm font-medium placeholder:text-primary/30">
                            </div>
                            <div class="col-span-3">
                                <input name="variants[0][price]" type="number" step="0.01" placeholder="0.00" class="w-full rounded-xl border-2 border-primary/10 bg-primary/5 focus:border-primary focus:ring-0 py-3 px-4 text-sm font-medium placeholder:text-primary/30">
                            </div>
                            <div class="col-span-2">
                                <input name="variants[0][stock]" type="number" placeholder="0" class="w-full rounded-xl border-2 border-primary/10 bg-primary/5 focus:border-primary focus:ring-0 py-3 px-4 text-sm font-medium placeholder:text-primary/30">
                            </div>
                            <div class="col-span-1 flex justify-center items-center">
                                <button type="button" onclick="removeVariant(this)" class="w-8 h-8 rounded-full bg-red-100 text-red-400 hover:bg-red-500 hover:text-white flex items-center justify-center transition-colors">
                                    <span class="material-symbols-outlined text-lg">close</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SUBMIT BUTTON --}}
                <div class="flex flex-col items-center pt-8">
                    <button class="group relative flex items-center justify-center w-52 h-52 transition-transform duration-300 hover:scale-110 active:scale-95" type="submit">
                        <div class="absolute inset-0 glossy-effect heart-button"></div>
                        <div class="relative z-10 flex flex-col items-center text-white">
                            <span class="material-symbols-outlined text-4xl mb-1">save</span>
                            <span class="font-black text-xl text-center px-4 leading-tight">SAVE<br/>PRODUCT</span>
                        </div>
                    </button>
                </div>

            </form>
        </div>
    </div>
</main>

{{-- JAVASCRIPT LOGIC --}}
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
    let variantIndex = 1;

    function addVariant() {
        const wrapper = document.getElementById('variant-wrapper');
        // HTML string disesuaikan dengan styling tema Candy
        const html = `
        <div class="grid grid-cols-12 gap-3 variant-item group animate-fade-in">
            <div class="col-span-3">
                <input name="variants[${variantIndex}][color]" placeholder="Color/Flavor" class="w-full rounded-xl border-2 border-primary/10 bg-primary/5 focus:border-primary focus:ring-0 py-3 px-4 text-sm font-medium placeholder:text-primary/30">
            </div>
            <div class="col-span-3">
                <input name="variants[${variantIndex}][size]" placeholder="Size" class="w-full rounded-xl border-2 border-primary/10 bg-primary/5 focus:border-primary focus:ring-0 py-3 px-4 text-sm font-medium placeholder:text-primary/30">
            </div>
            <div class="col-span-3">
                <input name="variants[${variantIndex}][price]" type="number" step="0.01" placeholder="0.00" class="w-full rounded-xl border-2 border-primary/10 bg-primary/5 focus:border-primary focus:ring-0 py-3 px-4 text-sm font-medium placeholder:text-primary/30">
            </div>
            <div class="col-span-2">
                <input name="variants[${variantIndex}][stock]" type="number" placeholder="0" class="w-full rounded-xl border-2 border-primary/10 bg-primary/5 focus:border-primary focus:ring-0 py-3 px-4 text-sm font-medium placeholder:text-primary/30">
            </div>
            <div class="col-span-1 flex justify-center items-center">
                <button type="button" onclick="removeVariant(this)" class="w-8 h-8 rounded-full bg-red-100 text-red-400 hover:bg-red-500 hover:text-white flex items-center justify-center transition-colors">
                    <span class="material-symbols-outlined text-lg">close</span>
                </button>
            </div>
        </div>
        `;
        wrapper.insertAdjacentHTML('beforeend', html);
        variantIndex++;
    }

    function removeVariant(button) {
        button.closest('.variant-item').remove();
    }

    (function () {
        const input = document.getElementById('productImagesInput');
        const wrap = document.getElementById('image-preview-wrap');
        const previewContainer = document.getElementById('image-preview-container');
        if (!input || !wrap || !previewContainer) return;

        let selectedFiles = [];
        let sortable = null;

        function syncFileInput() {
            const dt = new DataTransfer();
            selectedFiles.forEach(f => dt.items.add(f));
            input.files = dt.files;
        }

        function render() {
            previewContainer.innerHTML = '';
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
                el.className = 'relative w-24 shrink-0';
                el.dataset.index = String(idx);
                el.innerHTML = `
                    <div class="bg-white p-2 rounded-2xl shadow-sm border-2 border-primary/10">
                        <div class="aspect-square rounded-xl overflow-hidden bg-gray-50">
                            <img src="${url}" alt="${file.name}" class="w-full h-full object-cover" />
                        </div>
                        <div class="mt-2 flex items-center justify-between gap-2">
                            <span class="drag-handle cursor-grab text-primary/60">
                                <span class="material-symbols-outlined text-[18px]">drag_indicator</span>
                            </span>
                            <button type="button" class="remove-image h-7 w-7 rounded-full bg-red-100 text-red-500 hover:bg-red-500 hover:text-white flex items-center justify-center transition-colors" aria-label="Remove">
                                <span class="material-symbols-outlined text-[18px]">close</span>
                            </button>
                        </div>
                    </div>
                `;
                el.querySelector('.remove-image')?.addEventListener('click', () => {
                    selectedFiles.splice(idx, 1);
                    syncFileInput();
                    render();
                });
                previewContainer.appendChild(el);
            });

            if (sortable) sortable.destroy();
            sortable = new Sortable(previewContainer, {
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
            const files = Array.from(e.target.files || []);
            selectedFiles = files;
            syncFileInput();
            render();
        });
    })();
</script>

<style>
    /* Styling tambahan untuk animasi */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-5px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeIn 0.3s ease-out forwards;
    }
</style>
@endsection