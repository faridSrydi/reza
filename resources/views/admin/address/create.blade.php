@extends('layouts.app')


@section('content')
<div class="max-w-2xl mx-auto mt-10 p-8 bg-white rounded-lg shadow-md border-t-4 border-indigo-600">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Tambah Alamat Baru</h2>
        <p class="text-sm text-gray-500">Silakan isi formulir di bawah untuk menambahkan alamat pengiriman Anda.</p>
    </div>


    <form action="{{ route('admin.addresses.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 gap-5">
            <div>
                <label class="block text-sm font-semibold text-gray-700">Nama Penerima / Label Alamat</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full mt-1 border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-indigo-500 outline-none transition"
                    placeholder="Contoh: Rumah Utama / Kantor" required>
            </div>


            <div>
                <label class="block text-sm font-semibold text-gray-700">Nomor Telepon</label>
                <input type="text" name="phone" value="{{ old('phone') }}"
                    class="w-full mt-1 border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-indigo-500 outline-none transition"
                    placeholder="0812xxxxxxxx" required>
            </div>


            <div>
                <label class="block text-sm font-semibold text-gray-700">Alamat Lengkap</label>
                <textarea name="address" rows="3"
                    class="w-full mt-1 border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-indigo-500 outline-none transition"
                    placeholder="Nama jalan, blok, nomor rumah..." required>{{ old('address') }}</textarea>
            </div>


            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Kota/Kabupaten</label>
                    <input type="text" name="city" value="{{ old('city') }}"
                        class="w-full mt-1 border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-indigo-500 outline-none" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Provinsi</label>
                    <input type="text" name="province" value="{{ old('province') }}"
                        class="w-full mt-1 border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-indigo-500 outline-none" required>
                </div>
            </div>


            <div>
                <label class="block text-sm font-semibold text-gray-700">Kode Pos</label>
                <input type="text" name="postal_code" value="{{ old('postal_code') }}"
                    class="w-full mt-1 border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-indigo-500 outline-none" required>
            </div>
        </div>


        <div class="mt-8 flex gap-4">
            <button type="submit" class="flex-1 bg-indigo-600 text-white py-3 rounded-lg font-bold hover:bg-indigo-700 transition shadow-md">
                Simpan Alamat
            </button>
            <a href="{{ route('admin.addresses.index') }}" class="flex-1 text-center bg-gray-100 text-gray-600 py-3 rounded-lg font-bold hover:bg-gray-200 transition">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
