@extends('layouts.admin')

@section('title', 'Edit Address')

@section('content')
    <header class="lg:sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-[#f3e7ed] px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <h1 class="text-2xl font-bold serif-text">Edit Address</h1>
            </div>

            <a href="{{ route('admin.addresses.index') }}"
                class="inline-flex items-center justify-center gap-2 px-4 h-10 rounded-lg border border-[#f3e7ed] text-sm font-bold hover:border-primary transition-colors">
                <span class="material-symbols-outlined text-xl">arrow_back</span>
                Back
            </a>
        </div>
    </header>

    <main class="p-4 sm:p-6 lg:p-8">
        @if ($errors->any())
            <div class="mb-6 bg-white border border-[#f3e7ed] rounded-2xl p-4">
                <p class="text-xs uppercase tracking-widest font-bold text-red-600">Please check your input</p>
                <ul class="mt-2 text-sm text-gray-600 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-2xl border border-[#f3e7ed] p-6 sm:p-8 shadow-sm">
            <form action="{{ route('admin.addresses.update', $address->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold uppercase tracking-wider text-gray-400" for="name">Name</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $address->name ?? '') }}" required
                            class="form-input w-full h-12 px-4 rounded-lg bg-[#f8f6f7] border-[#f3e7ed] text-sm focus:ring-primary" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold uppercase tracking-wider text-gray-400" for="phone">Phone</label>
                        <input id="phone" name="phone" type="text" value="{{ old('phone', $address->phone ?? '') }}" required
                            class="form-input w-full h-12 px-4 rounded-lg bg-[#f8f6f7] border-[#f3e7ed] text-sm focus:ring-primary" />
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-sm font-bold uppercase tracking-wider text-gray-400" for="address">Address</label>
                    <textarea id="address" name="address" rows="4" required
                        class="form-input w-full px-4 py-3 rounded-lg bg-[#f8f6f7] border-[#f3e7ed] text-sm focus:ring-primary">{{ old('address', $address->address ?? '') }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold uppercase tracking-wider text-gray-400" for="city">City</label>
                        <input id="city" name="city" type="text" value="{{ old('city', $address->city ?? '') }}" required
                            class="form-input w-full h-12 px-4 rounded-lg bg-[#f8f6f7] border-[#f3e7ed] text-sm focus:ring-primary" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold uppercase tracking-wider text-gray-400" for="province">Province</label>
                        <input id="province" name="province" type="text" value="{{ old('province', $address->province ?? '') }}" required
                            class="form-input w-full h-12 px-4 rounded-lg bg-[#f8f6f7] border-[#f3e7ed] text-sm focus:ring-primary" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-bold uppercase tracking-wider text-gray-400" for="postal_code">Postal Code</label>
                        <input id="postal_code" name="postal_code" type="text" value="{{ old('postal_code', $address->postal_code ?? '') }}" required
                            class="form-input w-full h-12 px-4 rounded-lg bg-[#f8f6f7] border-[#f3e7ed] text-sm focus:ring-primary" />
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 sm:justify-end pt-2">
                    <a href="{{ route('admin.addresses.index') }}"
                        class="inline-flex items-center justify-center px-6 h-12 rounded-lg border border-[#f3e7ed] text-sm font-bold hover:border-primary transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center px-7 h-12 rounded-lg bg-primary text-white text-sm font-bold hover:opacity-90 transition-opacity">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </main>
@endsection
