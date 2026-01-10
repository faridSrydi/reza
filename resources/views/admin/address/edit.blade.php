@extends('layouts.app')


@section('content')
<div class="max-w-2xl mx-auto mt-10 p-8 bg-white rounded-lg shadow-md border-t-4 border-yellow-500">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Edit Alamat Anda</h2>
        <p class="text-sm text-gray-500">Perbarui informasi alamat pengiriman Anda di bawah ini.</p>
    </div>


    <form action="{{ route('admin.addresses.update', $address->id) }}" method="POST">
        @csrf
        @method('PUT')


        <div class="grid grid-cols-1 gap-5">
            <div>
                <label class="block text-sm font-semibold text-gray-700">Nama Penerima / Label Alamat</label>
                <input type="text" name="name" value="{{ old('name', $address->name) }}"
                    class="w-full mt-1 border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-yellow-500 outline-none transition" required>
            </div>


            <div>
                <label class="block text-sm font-semibold text-gray-700">Nomor Telepon</label>
                <input type="text" name="phone" value="{{ old('phone', $address->phone) }}"
                    class="w-full mt-1 border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-yellow-500 outline-none transition" required>
            </div>


            <div>
                <label class="block text-sm font-semibold text-gray-700">Alamat Lengkap</label>
                <textarea name="address" rows="3"
                    class="w-full mt-1 border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-yellow-500 outline-none transition" required>{{ old('address', $address->address) }}</textarea>
            </div>


            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Kota/Kabupaten</label>
                    <input type="text" name="city" value="{{ old('city', $address->city) }}"
                        class="w-full mt-1 border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-yellow-500 outline-none" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Provinsi</label>
                    <input type="text" name="province" value="{{ old('province', $address->province) }}"
                        class="w-full mt-1 border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-yellow-500 outline-none" required>
                </div>
            </div>


            <div>
                <label class="block text-sm font-semibold text-gray-700">Kode Pos</label>
                <input type="text" name="postal_code" value="{{ old('postal_code', $address->postal_code) }}"
                    class="w-full mt-1 border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-yellow-500 outline-none" required>
            </div>
        </div>


        <div class="mt-8 flex gap-4">
            <button type="submit" class="flex-1 bg-yellow-500 text-white py-3 rounded-lg font-bold hover:bg-yellow-600 transition shadow-md">
                Update Alamat
            </button>
            <a href="{{ route('admin.addresses.index') }}" class="flex-1 text-center bg-gray-100 text-gray-600 py-3 rounded-lg font-bold hover:bg-gray-200 transition">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
