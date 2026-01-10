@extends('layouts.app')


@section('content')
<div class="max-w-6xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Alamat Saya</h2>
        <a href="{{ route('user.addresses.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
            + Tambah Alamat Baru
        </a>
    </div>


    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif


    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @forelse($addresses as $address)
            <div class="border p-5 rounded-xl hover:border-blue-500 transition relative">
                <h3 class="font-bold text-lg text-gray-900">{{ $address->name }}</h3>
                <p class="text-gray-600">{{ $address->phone }}</p>
                <p class="text-gray-500 mt-2 text-sm">
                    {{ $address->address }}, {{ $address->city }}, {{ $address->province }}, {{ $address->postal_code }}
                </p>


                <div class="mt-4 flex space-x-3">
                    <a href="{{ route('user.addresses.edit', $address->id) }}" class="text-sm text-yellow-600 hover:text-yellow-700 font-semibold">Edit</a>
                    <form action="{{ route('user.addresses.destroy', $address->id) }}" method="POST" onsubmit="return confirm('Hapus alamat ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-sm text-red-600 hover:text-red-700 font-semibold">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-2 text-center py-10 text-gray-500">
                Belum ada alamat yang terdaftar.
            </div>
        @endforelse
    </div>
</div>
@endsection
