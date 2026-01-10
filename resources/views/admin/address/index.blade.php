@extends('layouts.app')


@section('content')
<div class="max-w-6xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Alamat Saya (Admin)</h2>
            <p class="text-sm text-gray-500">Kelola daftar alamat pengiriman Anda sendiri</p>
        </div>
        <a href="{{ route('admin.addresses.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm transition">
            + Tambah Alamat
        </a>
    </div>


    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif


    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 text-gray-700 border-b">
                <tr>
                    <th class="p-4 text-sm font-semibold uppercase">Penerima</th>
                    <th class="p-4 text-sm font-semibold uppercase">Telepon</th>
                    <th class="p-4 text-sm font-semibold uppercase">Alamat Lengkap</th>
                    <th class="p-4 text-sm font-semibold uppercase text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($addresses as $address)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="p-4 text-sm font-bold text-gray-800">{{ $address->name }}</td>
                    <td class="p-4 text-sm text-gray-600">{{ $address->phone }}</td>
                    <td class="p-4 text-sm text-gray-600">
                        {{ $address->address }}, {{ $address->city }}, {{ $address->province }} ({{ $address->postal_code }})
                    </td>
                    <td class="p-4 flex justify-center space-x-2">
                        <a href="{{ route('admin.addresses.edit', $address->id) }}" class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500 shadow-sm text-xs">
                            Edit
                        </a>
                        <form action="{{ route('admin.addresses.destroy', $address->id) }}" method="POST" onsubmit="return confirm('Hapus alamat ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 shadow-sm text-xs">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-8 text-center text-gray-500">Belum ada alamat yang ditambahkan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection


