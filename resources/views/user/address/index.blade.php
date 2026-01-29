@extends('layouts.user')

@section('title', 'Addresses')

@section('user_content')
    <div class="w-full">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-10">
            <div>
                <h1 class="text-4xl lg:text-5xl font-bold serif-text mb-2">Saved Addresses</h1>
                <p class="text-gray-500 dark:text-gray-400">Manage your shipping addresses.</p>
            </div>
            <a href="{{ route('addresses.create') }}"
                class="inline-flex items-center justify-center gap-2 bg-primary text-white font-bold px-6 h-12 rounded-full hover:opacity-90 transition-opacity">
                <span class="material-symbols-outlined text-xl">add</span>
                Add Address
            </a>
        </div>

        @if (session('success'))
            <div class="mb-8 bg-white dark:bg-[#1b0d14] border border-[#f3e7ed] dark:border-[#3d2030] rounded-2xl p-4 flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-widest font-bold text-gray-400">Success</p>
                    <p class="font-bold">{{ session('success') }}</p>
                </div>
                <button type="button" onclick="this.parentElement.remove()"
                    class="size-10 rounded-full border border-[#f3e7ed] dark:border-[#3d2030] flex items-center justify-center hover:bg-[#f8f6f7] dark:hover:bg-[#3d2030] transition-colors"
                    aria-label="Dismiss">
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
            </div>
        @endif

        @forelse($addresses as $address)
            <div class="bg-white dark:bg-[#1b0d14] rounded-2xl border border-[#f3e7ed] dark:border-[#3d2030] p-6 mb-6 hover:border-primary/30 transition-all">
                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-6">
                    <div class="min-w-0">
                        <h3 class="text-xl font-bold serif-text">{{ $address->name }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $address->phone }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-300 mt-3 leading-relaxed">
                            {{ $address->address }}<br>
                            {{ $address->city }}, {{ $address->province }} {{ $address->postal_code }}
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 sm:items-center shrink-0">
                        <a href="{{ route('addresses.edit', $address->id) }}"
                            class="inline-flex items-center justify-center gap-2 px-5 h-11 rounded-full border border-[#f3e7ed] dark:border-[#3d2030] text-sm font-bold hover:border-primary transition-colors">
                            <span class="material-symbols-outlined text-xl">edit</span>
                            Edit
                        </a>
                        <form action="{{ route('addresses.destroy', $address->id) }}" method="POST"
                            onsubmit="return confirm('Delete this address?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center justify-center gap-2 px-5 h-11 rounded-full border border-red-200 dark:border-red-500/30 text-sm font-bold text-red-600 hover:bg-red-50 dark:hover:bg-red-500/10 transition-colors">
                                <span class="material-symbols-outlined text-xl">delete</span>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white dark:bg-[#1b0d14] rounded-2xl border border-[#f3e7ed] dark:border-[#3d2030] p-10 text-center">
                <div class="mx-auto size-16 rounded-full bg-primary/10 flex items-center justify-center text-primary mb-4">
                    <span class="material-symbols-outlined text-3xl">location_on</span>
                </div>
                <h3 class="text-2xl font-bold serif-text">No addresses yet</h3>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Add an address to speed up checkout.</p>
                <a href="{{ route('addresses.create') }}"
                    class="inline-flex items-center justify-center gap-2 bg-primary text-white font-bold px-8 h-12 rounded-full hover:opacity-90 transition-opacity mt-6">
                    <span class="material-symbols-outlined text-xl">add</span>
                    Add your first address
                </a>
            </div>
        @endforelse
    </div>
@endsection
