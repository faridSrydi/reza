@extends('layouts.admin')

@section('title', 'Categories')

@push('styles')
    <style type="text/tailwindcss">
        .pill {
            @apply px-3 py-1 rounded-full bg-[#f3e7ed] text-[#9a4c73] text-xs font-bold;
        }
    </style>
@endpush

@section('content')
<header class="lg:sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-[#f3e7ed] px-4 sm:px-6 lg:px-8 py-4">
    <div class="flex items-center justify-between gap-4">
        <h1 class="text-2xl font-bold serif-text">Categories</h1>

        <a href="{{ route('admin.categories.create') }}"
            class="flex items-center gap-2 bg-primary text-white px-5 sm:px-6 py-2.5 rounded-lg text-sm font-bold shadow-lg hover:opacity-90 transition-opacity">
            <span class="material-symbols-outlined text-xl">add</span>
            <span class="hidden sm:inline">Add New Category</span>
            <span class="sm:hidden">Add</span>
        </a>
    </div>
</header>

<main class="p-4 sm:p-6 lg:p-8">
    <div class="bg-white rounded-2xl border border-[#f3e7ed] overflow-hidden shadow-sm">
        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-[#f3e7ed] bg-[#faf8f9]">
                        <th class="px-4 sm:px-6 py-5 text-xs font-bold uppercase tracking-wider text-gray-500">Category</th>
                        <th class="px-4 sm:px-6 py-5 text-xs font-bold uppercase tracking-wider text-gray-500">Slug</th>
                        <th class="px-4 sm:px-6 py-5 text-xs font-bold uppercase tracking-wider text-gray-500">Products</th>
                        <th class="px-4 sm:px-6 py-5 text-xs font-bold uppercase tracking-wider text-gray-500 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f3e7ed]">
                    @forelse ($categories as $category)
                        @php
                            $imgSrc = $category->image
                                ? asset('storage/' . ltrim($category->image, '/'))
                                : ('https://ui-avatars.com/api/?name=' . urlencode($category->name) . '&background=f3e7ed&color=9a4c73');
                        @endphp

                        <tr class="hover:bg-gray-50 transition-colors group">
                            <td class="px-4 sm:px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="size-14 rounded-lg bg-cover bg-center border border-[#f3e7ed] flex-shrink-0"
                                        style='background-image: url("{{ $imgSrc }}");'>
                                    </div>
                                    <div>
                                        <p class="font-bold text-sm">{{ $category->name }}</p>
                                        <p class="text-xs text-gray-500 uppercase tracking-tight">ID: {{ str_pad((string) $category->id, 4, '0', STR_PAD_LEFT) }}</p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-4 sm:px-6 py-4">
                                <span class="pill font-mono">/{{ $category->slug }}</span>
                            </td>

                            <td class="px-4 sm:px-6 py-4">
                                <span class="pill">{{ (int) ($category->products_count ?? 0) }}</span>
                            </td>

                            <td class="px-4 sm:px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="p-2 text-gray-400 hover:text-primary transition-colors" aria-label="Edit">
                                        <span class="material-symbols-outlined text-xl">edit</span>
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-block"
                                        onsubmit="return confirm('Delete category: {{ addslashes($category->name) }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-gray-400 hover:text-red-500 transition-colors" aria-label="Delete">
                                            <span class="material-symbols-outlined text-xl">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 sm:px-6 py-10 text-center text-sm text-gray-500">No categories found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-5 border-t border-[#f3e7ed] flex items-center justify-between">
            <p class="text-sm text-gray-500">Total: <span class="font-bold text-[#1b0d14]">{{ $categories->count() }}</span></p>
        </div>
    </div>
</main>
@endsection