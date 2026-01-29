@extends('layouts.admin')

@section('title', 'Addresses')

@section('content')
    <header class="lg:sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-[#f3e7ed] px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <h1 class="text-2xl font-bold serif-text">Addresses</h1>
            </div>

            <a href="{{ route('admin.addresses.create') }}"
                class="flex items-center gap-2 bg-primary text-white px-5 sm:px-6 py-2.5 rounded-lg text-sm font-bold shadow-lg hover:opacity-90 transition-opacity">
                <span class="material-symbols-outlined text-xl">add</span>
                <span class="hidden sm:inline">Add New Address</span>
                <span class="sm:hidden">Add</span>
            </a>
        </div>
    </header>

    <main class="p-4 sm:p-6 lg:p-8">
        @if (session('success'))
            <div class="mb-6 bg-white border border-[#f3e7ed] rounded-2xl p-4 text-sm text-gray-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl border border-[#f3e7ed] overflow-hidden shadow-sm">
            <div class="overflow-x-auto no-scrollbar">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-[#f3e7ed] bg-[#faf8f9]">
                            <th class="px-4 sm:px-6 py-5 text-xs font-bold uppercase tracking-wider text-gray-500">Recipient</th>
                            <th class="px-4 sm:px-6 py-5 text-xs font-bold uppercase tracking-wider text-gray-500">Phone</th>
                            <th class="px-4 sm:px-6 py-5 text-xs font-bold uppercase tracking-wider text-gray-500">Address</th>
                            <th class="px-4 sm:px-6 py-5 text-xs font-bold uppercase tracking-wider text-gray-500 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f3e7ed]">
                        @forelse ($addresses as $address)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 sm:px-6 py-4">
                                    <div>
                                        <p class="font-bold text-sm">{{ $address->name }}</p>
                                        <p class="text-xs text-gray-500 uppercase tracking-tight">ID: {{ str_pad((string) $address->id, 4, '0', STR_PAD_LEFT) }}</p>
                                    </div>
                                </td>

                                <td class="px-4 sm:px-6 py-4">
                                    <span class="text-sm font-medium text-gray-700">{{ $address->phone }}</span>
                                </td>

                                <td class="px-4 sm:px-6 py-4">
                                    <p class="text-sm text-gray-700 leading-relaxed">
                                        {{ $address->address }}<br>
                                        <span class="text-gray-500">{{ $address->city }}, {{ $address->province }} {{ $address->postal_code }}</span>
                                    </p>
                                </td>

                                <td class="px-4 sm:px-6 py-4">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.addresses.edit', $address->id) }}"
                                            class="p-2 text-gray-400 hover:text-primary transition-colors" aria-label="Edit">
                                            <span class="material-symbols-outlined text-xl">edit</span>
                                        </a>
                                        <form action="{{ route('admin.addresses.destroy', $address->id) }}" method="POST" class="inline-block"
                                            onsubmit="return confirm('Delete this address?');">
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
                                <td colspan="4" class="px-4 sm:px-6 py-10 text-center text-sm text-gray-500">No addresses found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
@endsection
