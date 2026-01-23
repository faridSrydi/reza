@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
    <main class="flex-1 flex flex-col py-10 px-4 sm:px-8 lg:px-10 relative overflow-hidden min-h-screen">
        {{-- DECORATION BACKGROUND --}}
        <div class="absolute top-32 right-10 opacity-5 rotate-12 pointer-events-none">
            <span class="material-symbols-outlined text-[150px] text-primary">category</span>
        </div>

        <div class="absolute bottom-24 left-10 opacity-5 -rotate-12 pointer-events-none">
            <span class="material-symbols-outlined text-[120px] text-primary">icecream</span>
        </div>

        {{-- HEADER SECTION --}}
        <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-8 z-10">
            <div class="flex flex-col gap-3 w-full md:w-2/3">
                <h1 class="text-[#181113] text-4xl font-black tracking-tight">Category Jar 🍬</h1>
                <p class="text-primary/70 font-medium">Organize sweets by flavor, vibe, and crunch.</p>
            </div>

            {{-- CREATE BUTTON --}}
            <a href="{{ route('admin.categories.create') }}"
                class="group relative flex flex-col items-center justify-center transition-transform hover:scale-110 active:scale-95">
                <div class="w-24 h-24 bg-primary rounded-full flex items-center justify-center shadow-lg relative z-10 border-4 border-white">
                    <span class="material-symbols-outlined text-white text-4xl font-bold">add</span>
                </div>
                <div class="w-2 h-16 bg-[#e2e8f0] rounded-b-full -mt-2 shadow-inner"></div>
                <span class="absolute -bottom-8 whitespace-nowrap text-primary font-black text-xs uppercase tracking-widest">Create New</span>
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 z-10">
                <div class="bg-white rounded-[2rem] border-[3px] border-primary/20 shadow-lg p-5 flex items-start gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-green-100 text-green-600 flex items-center justify-center border-2 border-green-200 shrink-0">
                        <span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1">check_circle</span>
                    </div>
                    <div>
                        <p class="text-[11px] font-black uppercase tracking-widest text-primary/60">Sweet update</p>
                        <p class="text-sm font-bold text-[#181113]">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- TABLE CONTAINER --}}
        <div class="bg-white rounded-[3rem] border-[4px] border-primary/20 shadow-xl overflow-hidden z-10">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-primary/5">
                            <th class="p-6 text-primary font-extrabold uppercase text-xs tracking-wider w-16 text-center rounded-tl-[2.5rem]">No</th>
                            <th class="p-6 text-primary font-extrabold uppercase text-xs tracking-wider w-24">Photo</th>
                            <th class="p-6 text-primary font-extrabold uppercase text-xs tracking-wider">Category</th>
                            <th class="p-6 text-primary font-extrabold uppercase text-xs tracking-wider">Slug</th>
                            <th class="p-6 text-primary font-extrabold uppercase text-xs tracking-wider text-right rounded-tr-[2.5rem]">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-primary/5">
                        @forelse ($categories as $category)
                            <tr class="hover:bg-primary/5 transition-colors group">
                                <td class="p-6 text-center font-black text-primary/50">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="p-6">
                                    <div class="w-14 h-14 rounded-2xl border-4 border-primary/10 bg-primary/5 overflow-hidden flex items-center justify-center">
                                        @if ($category->image)
                                            <img class="w-full h-full object-cover" alt="{{ $category->name }}" src="{{ asset('storage/' . ltrim($category->image, '/')) }}" />
                                        @else
                                            <span class="material-symbols-outlined text-primary/40" style="font-variation-settings:'FILL' 1">image</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="p-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-2xl bg-secondary/20 text-primary flex items-center justify-center border-2 border-primary/10">
                                            <span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1">sell</span>
                                        </div>
                                        <div>
                                            <p class="font-black text-[#181113] group-hover:text-primary transition-colors">{{ $category->name }}</p>
                                            <p class="text-xs text-primary/60 font-medium font-mono">ID: {{ substr(md5($category->id), 0, 8) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-6">
                                    <span class="px-4 py-1.5 rounded-full bg-primary/5 text-primary text-xs font-bold font-mono">
                                        /{{ $category->slug }}
                                    </span>
                                </td>
                                <td class="p-6">
                                    <div class="flex justify-end gap-3">
                                        <a href="{{ route('admin.categories.edit', $category) }}"
                                            class="w-10 h-10 rounded-full bg-blue-100 text-blue-500 hover:bg-blue-200 flex items-center justify-center transition-colors"
                                            aria-label="Edit">
                                            <span class="material-symbols-outlined text-lg" style="font-variation-settings:'FILL' 1">edit</span>
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-block"
                                            onsubmit="return confirm('Delete category: {{ addslashes($category->name) }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-10 h-10 rounded-full bg-orange-100 text-orange-600 hover:bg-orange-200 flex items-center justify-center transition-colors"
                                                aria-label="Delete">
                                                <span class="material-symbols-outlined text-lg" style="font-variation-settings:'FILL' 1">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-10 text-center text-primary/50 font-bold">
                                    No categories yet — add your first one! 🍭
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-6 bg-primary/5 flex items-center justify-between">
                <span class="text-primary font-bold text-sm">Total: {{ $categories->count() }} Records</span>
            </div>
        </div>
    </main>
@endsection