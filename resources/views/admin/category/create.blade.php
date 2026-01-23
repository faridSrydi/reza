@extends('layouts.admin')

@section('title', 'Create Category')

@section('content')
<main class="flex-1 flex flex-col items-center py-10 px-4 relative overflow-hidden min-h-screen">
    {{-- DECORATION BACKGROUND --}}
    <div class="absolute top-24 left-10 opacity-10 rotate-12 pointer-events-none">
        <span class="material-symbols-outlined text-[120px] text-primary">category</span>
    </div>
    <div class="absolute bottom-32 right-10 opacity-10 -rotate-12 pointer-events-none">
        <span class="material-symbols-outlined text-[100px] text-primary">sell</span>
    </div>

    <div class="w-full max-w-[760px] z-10">
        {{-- BREADCRUMBS --}}
        <div class="flex flex-wrap gap-2 px-4 mb-6">
            <a class="text-primary/60 text-sm font-medium hover:text-primary" href="{{ route('admin.dashboard') }}">Admin</a>
            <span class="material-symbols-outlined crumb-heart text-[12px] text-primary">favorite</span>
            <a class="text-primary/60 text-sm font-medium hover:text-primary" href="{{ route('admin.categories.index') }}">Categories</a>
            <span class="material-symbols-outlined crumb-heart text-[12px] text-primary">favorite</span>
            <span class="text-primary text-sm font-bold">Create</span>
        </div>

        {{-- HEADER --}}
        <div class="mb-8">
            <h1 class="text-[#181113] tracking-tight text-4xl font-black leading-tight text-center">Create a New Category!</h1>
            <p class="text-primary/70 text-center mt-2 font-medium">Keep the jar organized 🫙✨</p>
        </div>

        {{-- FORM CONTAINER --}}
        <div class="bg-white rounded-[3rem] border-[6px] border-primary shadow-2xl p-8 md:p-12 mb-20 relative">
            <form method="POST" enctype="multipart/form-data" action="{{ route('admin.categories.store') }}" class="space-y-8">
                @csrf

                <div class="flex flex-col gap-2">
                    <label class="flex items-center gap-2 text-[#181113] text-base font-bold pl-2">
                        Category Name
                        <span class="material-symbols-outlined text-primary text-sm" style="font-variation-settings:'FILL' 1">sell</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="w-full rounded-full border-2 border-primary/10 bg-primary/5 focus:border-primary focus:ring-0 h-14 px-6 text-[#181113] placeholder:text-primary/30 font-medium transition-all"
                        placeholder="Snacks & Candy" />

                    @error('name')
                        <p class="text-sm font-bold text-primary">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col gap-2">
                    <label class="flex items-center gap-2 text-[#181113] text-base font-bold pl-2">
                        Category Photo
                        <span class="material-symbols-outlined text-primary text-sm" style="font-variation-settings:'FILL' 1">photo_camera</span>
                    </label>

                    <div class="grid grid-cols-1 sm:grid-cols-[160px_1fr] gap-4 items-start">
                        <div class="w-40 h-40 rounded-[2rem] border-4 border-primary/10 bg-primary/5 overflow-hidden flex items-center justify-center">
                            <img id="categoryImagePreview" class="hidden w-full h-full object-cover" alt="Preview" />
                            <span id="categoryImagePlaceholder" class="text-primary/50 font-bold text-xs">No photo</span>
                        </div>

                        <div class="space-y-2">
                            <input id="categoryImageInput" type="file" name="image" accept="image/*"
                                class="block w-full text-sm font-bold text-primary file:mr-4 file:rounded-full file:border-0 file:bg-primary/10 file:px-4 file:py-2 file:text-primary hover:file:bg-primary/20" />
                            @error('image')
                                <p class="text-sm font-bold text-primary">{{ $message }}</p>
                            @enderror
                            <p class="text-xs font-bold text-primary/50">PNG/JPG/WEBP · max 5MB</p>
                        </div>
                    </div>
                </div>

                <hr class="border-primary/10 border-2 border-dashed rounded-full my-8">

                <div class="flex flex-col sm:flex-row gap-3 justify-end">
                    <a href="{{ route('admin.categories.index') }}"
                        class="inline-flex items-center justify-center px-6 h-12 rounded-full border-2 border-primary/15 bg-white text-primary font-black hover:bg-primary/5 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 px-6 h-12 rounded-full bg-primary text-white font-extrabold hover:opacity-95 active:scale-[0.99] transition-all">
                        <span class="material-symbols-outlined text-[20px]" style="font-variation-settings:'FILL' 1">save</span>
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
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