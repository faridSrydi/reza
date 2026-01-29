@extends('layouts.user')

@section('title', 'Add Address')

@section('user_content')
    <div class="w-full">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-10">
            <div>
                <h1 class="text-4xl lg:text-5xl font-bold serif-text mb-2">Add Address</h1>
                <p class="text-gray-500 dark:text-gray-400">Add a new shipping address for your orders.</p>
            </div>
            <a href="{{ route('addresses.index') }}"
                class="inline-flex items-center justify-center gap-2 px-5 h-11 rounded-full border border-[#f3e7ed] dark:border-[#3d2030] text-sm font-bold hover:border-primary transition-colors">
                <span class="material-symbols-outlined text-xl">arrow_back</span>
                Back
            </a>
        </div>

        @if ($errors->any())
            <div class="mb-8 bg-white dark:bg-[#1b0d14] border border-[#f3e7ed] dark:border-[#3d2030] rounded-2xl p-4">
                <p class="text-xs uppercase tracking-widest font-bold text-red-600">Please check your input</p>
                <ul class="mt-2 text-sm text-gray-600 dark:text-gray-300 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white dark:bg-[#1b0d14] rounded-2xl border border-[#f3e7ed] dark:border-[#3d2030] p-8">
            <form action="{{ route('addresses.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold uppercase tracking-wider text-gray-400" for="name">Name</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required
                            class="form-input w-full h-12 px-4 rounded-lg bg-[#f8f6f7] dark:bg-[#2d1622] border-[#f3e7ed] dark:border-[#3d2030] text-sm focus:ring-primary"
                            placeholder="Recipient name" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold uppercase tracking-wider text-gray-400" for="phone">Phone</label>
                        <input id="phone" name="phone" type="text" value="{{ old('phone') }}" required
                            class="form-input w-full h-12 px-4 rounded-lg bg-[#f8f6f7] dark:bg-[#2d1622] border-[#f3e7ed] dark:border-[#3d2030] text-sm focus:ring-primary"
                            placeholder="08xx..." />
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-bold uppercase tracking-wider text-gray-400" for="address">Address</label>
                    <textarea id="address" name="address" rows="4" required
                        class="form-input w-full px-4 py-3 rounded-lg bg-[#f8f6f7] dark:bg-[#2d1622] border-[#f3e7ed] dark:border-[#3d2030] text-sm focus:ring-primary"
                        placeholder="Street, house number, notes...">{{ old('address') }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold uppercase tracking-wider text-gray-400" for="city">City</label>
                        <input id="city" name="city" type="text" value="{{ old('city') }}" required
                            class="form-input w-full h-12 px-4 rounded-lg bg-[#f8f6f7] dark:bg-[#2d1622] border-[#f3e7ed] dark:border-[#3d2030] text-sm focus:ring-primary" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold uppercase tracking-wider text-gray-400" for="province">Province</label>
                        <input id="province" name="province" type="text" value="{{ old('province') }}" required
                            class="form-input w-full h-12 px-4 rounded-lg bg-[#f8f6f7] dark:bg-[#2d1622] border-[#f3e7ed] dark:border-[#3d2030] text-sm focus:ring-primary" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold uppercase tracking-wider text-gray-400" for="postal_code">Postal Code</label>
                        <input id="postal_code" name="postal_code" type="text" value="{{ old('postal_code') }}" required
                            class="form-input w-full h-12 px-4 rounded-lg bg-[#f8f6f7] dark:bg-[#2d1622] border-[#f3e7ed] dark:border-[#3d2030] text-sm focus:ring-primary" />
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 sm:justify-end pt-2">
                    <a href="{{ route('addresses.index') }}"
                        class="inline-flex items-center justify-center px-7 h-12 rounded-full border border-[#f3e7ed] dark:border-[#3d2030] text-sm font-bold hover:border-primary transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center px-8 h-12 rounded-full bg-primary text-white text-sm font-bold hover:opacity-90 transition-opacity">
                        Save Address
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection