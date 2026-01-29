@extends('layouts.admin')

@section('title', 'Create Category')

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
                <a class="hover:text-primary" href="{{ route('admin.categories.index') }}">Categories</a>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <span>Add New</span>
            </div>
            <h1 class="text-3xl font-bold serif-text">Create New Category</h1>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center gap-3 w-full md:w-auto">
            <a href="{{ route('admin.categories.index') }}"
                class="w-full sm:w-auto text-center px-6 py-2.5 rounded-lg border border-[#f3e7ed] text-sm font-bold hover:bg-gray-50 transition-colors">
                Cancel
            </a>
            <button form="categoryForm" type="submit"
                class="w-full sm:w-auto px-6 py-2.5 rounded-lg bg-primary text-white text-sm font-bold hover:opacity-90 shadow-lg shadow-primary/20 transition-all">
                Save Category
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

    <form id="categoryForm" method="POST" enctype="multipart/form-data" action="{{ route('admin.categories.store') }}">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <section class="form-section-card">
                    <h3 class="text-lg font-bold mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">info</span>
                        Category Information
                    </h3>
                    <div>
                        <label class="input-label" for="category-name">Category Name</label>
                        <input id="category-name" type="text" name="name" value="{{ old('name') }}" required autofocus
                            class="text-input" placeholder="e.g. Skincare" />
                    </div>
                </section>

                <section class="form-section-card">
                    <h3 class="text-lg font-bold mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">image</span>
                        Category Media
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-[160px_1fr] gap-6 items-start">
                        <div class="w-40 h-40 rounded-xl border border-[#f3e7ed] bg-[#fcfaff] overflow-hidden flex items-center justify-center">
                            <img id="categoryImagePreview" class="hidden w-full h-full object-cover" alt="Preview" />
                            <span id="categoryImagePlaceholder" class="text-gray-400 text-xs font-bold">No photo</span>
                        </div>

                        <div>
                            <label class="input-label" for="categoryImageInput">Upload Image</label>
                            <input id="categoryImageInput" type="file" name="image" accept="image/*" class="text-input p-2" />
                            <p class="mt-2 text-xs text-gray-500 font-medium">PNG/JPG/WEBP · max 5MB</p>
                        </div>
                    </div>
                </section>
            </div>

            <div class="space-y-8">
                <section class="form-section-card">
                    <h3 class="text-lg font-bold mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">category</span>
                        Notes
                    </h3>
                    <p class="text-sm text-gray-600">Slug will be generated automatically from the name.</p>
                </section>
            </div>
        </div>

        <div class="mt-12 pt-8 border-t border-[#f3e7ed] flex justify-end gap-4">
            <a href="{{ route('admin.categories.index') }}"
                class="px-6 py-2.5 rounded-lg border border-[#f3e7ed] text-sm font-bold hover:bg-gray-50 transition-colors">
                Cancel
            </a>
            <button type="submit"
                class="px-8 py-2.5 rounded-lg bg-primary text-white text-sm font-bold hover:opacity-90 shadow-lg shadow-primary/20">
                Save Category
            </button>
        </div>
    </form>
</main>

<script>
    (function () {
        const input = document.getElementById('categoryImageInput');
        const img = document.getElementById('categoryImagePreview');
        const ph = document.getElementById('categoryImagePlaceholder');
        if (!input || !img || !ph) return;

        input.addEventListener('change', (e) => {
            const file = e.target.files && e.target.files[0];
            if (!file) {
                img.src = '';
                img.classList.add('hidden');
                ph.classList.remove('hidden');
                return;
            }
            img.src = URL.createObjectURL(file);
            img.classList.remove('hidden');
            ph.classList.add('hidden');
        });
    })();
</script>
@endsection