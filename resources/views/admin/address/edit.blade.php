@extends('layouts.app')

@section('title', 'Edit Alamat')

@section('content')
    <main class="flex-1 max-w-[1280px] mx-auto w-full px-6 py-8">
        <div class="flex items-center gap-2 mb-6">
            <a class="text-primary/60 text-sm font-semibold hover:text-primary transition-colors" href="{{ route('home') }}">Home</a>
            <span class="material-symbols-outlined crumb-heart text-[12px] text-primary">favorite</span>
            <a class="text-primary/60 text-sm font-semibold hover:text-primary transition-colors" href="{{ route('admin.addresses.index') }}">Addresses</a>
            <span class="material-symbols-outlined crumb-heart text-[12px] text-primary">favorite</span>
            <span class="text-primary text-sm font-bold">Edit</span>
        </div>

        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 mb-8">
            <div class="flex flex-col gap-2">
                <h1 class="text-3xl md:text-4xl font-extrabold text-primary tracking-tight">Edit Alamat</h1>
                <p class="text-primary/60 font-semibold">Perbarui data alamat pengiriman.</p>
            </div>
            <a href="{{ route('admin.addresses.index') }}"
                class="inline-flex items-center gap-2 text-xs font-black uppercase tracking-[0.2em] text-primary/40 hover:text-primary transition-colors">
                <span class="material-symbols-outlined text-sm">arrow_back</span> Kembali
            </a>
        </div>

        @if ($errors->any())
            <div class="mb-8 p-4 bg-primary/5 border-l-4 border-primary rounded-r-xl">
                <p class="text-sm font-bold uppercase tracking-wide text-primary">Periksa input kamu</p>
                <ul class="mt-2 text-sm text-primary/70 font-semibold list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="candy-cane-border rounded-xl p-1 bg-white/80 dark:bg-white/5">
            <div class="relative bg-white dark:bg-background-dark/40 border-4 border-primary/10 rounded-xl p-8 shadow-xl shadow-primary/5 overflow-hidden">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_30%,_var(--tw-gradient-stops))] from-primary/10 via-transparent to-transparent"></div>

                <div class="relative z-10">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="flex flex-col items-center gap-1 shrink-0">
                            <div class="relative flex size-14 items-center justify-center rounded-full lollipop-gradient text-white shadow-lg shadow-primary/30 overflow-hidden">
                                <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_30%,rgba(255,255,255,0.45),transparent)]"></div>
                                <span class="material-symbols-outlined text-3xl font-bold fill-1 relative">edit</span>
                            </div>
                            <div class="w-2 h-6 bg-orange-200 dark:bg-orange-900 rounded-b-full shadow-sm -mt-1"></div>
                        </div>

                        <div class="min-w-0 flex-1">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-widest text-primary/60">Update Snack-Spot</p>
                                    <h2 class="text-2xl font-extrabold text-[#181113] dark:text-white tracking-tight">Edit Alamat</h2>
                                    <p class="text-primary/60 font-semibold text-sm mt-1">Biar kurir nggak nyasar.</p>
                                </div>
                                <span class="shrink-0 inline-flex items-center px-3 py-1 bg-primary/10 text-primary text-[10px] font-black uppercase tracking-wider rounded-full">
                                    ID: {{ substr(md5($address->id), 0, 6) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('admin.addresses.update', $address->id) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-primary/60 uppercase tracking-widest">
                            Label / Nama Penerima <span class="text-red-600">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', $address->name) }}" required
                            class="w-full bg-white dark:bg-background-dark border-2 border-primary/20 rounded-xl px-4 py-3 text-sm font-semibold text-primary focus:border-primary focus:ring-0 outline-none placeholder:text-primary/40" />
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-primary/60 uppercase tracking-widest">
                            Nomor Telepon <span class="text-red-600">*</span>
                        </label>
                        <input type="text" name="phone" value="{{ old('phone', $address->phone) }}" required
                            class="w-full bg-white dark:bg-background-dark border-2 border-primary/20 rounded-xl px-4 py-3 text-sm font-semibold text-primary focus:border-primary focus:ring-0 outline-none placeholder:text-primary/40" />
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-primary/60 uppercase tracking-widest">
                        Alamat Lengkap <span class="text-red-600">*</span>
                    </label>
                    <textarea name="address" rows="4" required
                        class="w-full bg-white dark:bg-background-dark border-2 border-primary/20 rounded-xl px-4 py-3 text-sm font-semibold text-primary focus:border-primary focus:ring-0 outline-none placeholder:text-primary/40">{{ old('address', $address->address) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-primary/60 uppercase tracking-widest">
                            Kota / Kab <span class="text-red-600">*</span>
                        </label>
                        <input type="text" name="city" value="{{ old('city', $address->city) }}" required
                            class="w-full bg-white dark:bg-background-dark border-2 border-primary/20 rounded-xl px-4 py-3 text-sm font-semibold text-primary focus:border-primary focus:ring-0 outline-none" />
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-primary/60 uppercase tracking-widest">
                            Provinsi <span class="text-red-600">*</span>
                        </label>
                        <input type="text" name="province" value="{{ old('province', $address->province) }}" required
                            class="w-full bg-white dark:bg-background-dark border-2 border-primary/20 rounded-xl px-4 py-3 text-sm font-semibold text-primary focus:border-primary focus:ring-0 outline-none" />
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-primary/60 uppercase tracking-widest">
                            Kode Pos <span class="text-red-600">*</span>
                        </label>
                        <input type="text" name="postal_code" value="{{ old('postal_code', $address->postal_code) }}" required
                            class="w-full bg-white dark:bg-background-dark border-2 border-primary/20 rounded-xl px-4 py-3 text-sm font-semibold text-primary focus:border-primary focus:ring-0 outline-none" />
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 sm:justify-end pt-2">
                    <a href="{{ route('admin.addresses.index') }}"
                        class="inline-flex items-center justify-center rounded-full px-8 py-4 text-xs font-black uppercase tracking-widest border-2 border-primary/20 text-primary hover:bg-primary/5 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-full px-10 py-4 bg-primary text-white text-xs font-black uppercase tracking-widest shadow-lg shadow-primary/20 hover:scale-105 active:scale-95 transition-transform">
                        Update
                    </button>
                </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .filled-icon {
            font-variation-settings: 'FILL' 1;
        }

        .fill-1 {
            font-variation-settings: 'FILL' 1;
        }

        .lollipop-gradient {
            background: linear-gradient(135deg, #F42559 0%, #ff8da7 100%);
        }

        .candy-cane-border {
            background: repeating-linear-gradient(45deg, #F42559, #F42559 10px, #ffffff 10px, #ffffff 20px);
        }
    </style>
@endsection