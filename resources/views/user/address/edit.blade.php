@extends('layouts.app')


@section('content')
<div class="max-w-2xl mx-auto mt-10 p-8 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">{{ isset($address) ? 'Edit Alamat' : 'Tambah Alamat' }}</h2>


    <form action="{{ isset($address) ? route('user.addresses.update', $address->id) : route('user.addresses.store') }}" method="POST">
        @csrf
        @if(isset($address)) @method('PUT') @endif


        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Penerima</label>
                <input type="text" name="name" value="{{ old('name', $address->name ?? '') }}" class="w-full mt-1 border rounded-md p-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">No. Telepon</label>
                <input type="text" name="phone" value="{{ old('phone', $address->phone ?? '') }}" class="w-full mt-1 border rounded-md p-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                <textarea name="address" rows="3" class="w-full mt-1 border rounded-md p-2" required>{{ old('address', $address->address ?? '') }}</textarea>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Kota</label>
                    <input type="text" name="city" value="{{ old('city', $address->city ?? '') }}" class="w-full mt-1 border rounded-md p-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Provinsi</label>
                    <input type="text" name="province" value="{{ old('province', $address->province ?? '') }}" class="w-full mt-1 border rounded-md p-2" required>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Kode Pos</label>
                <input type="text" name="postal_code" value="{{ old('postal_code', $address->postal_code ?? '') }}" class="w-full mt-1 border rounded-md p-2" required>
            </div>
        </div>


        <div class="mt-6 flex items-center justify-between">
            <a href="{{ route('user.addresses.index') }}" class="text-gray-600 hover:underline text-sm">Kembali</a>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                Simpan Alamat
            </button>
        </div>
    </form>
</div>
@endsection


