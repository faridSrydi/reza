@extends('layouts.app')


@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-extrabold mb-8 text-gray-800">Keranjang Belanja</h1>


    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">


        {{-- LIST ITEM --}}
        <div class="lg:col-span-2 space-y-4">
            @forelse ($cart as $item)
                <div class="bg-white border rounded-2xl p-5 flex gap-4 items-center shadow-sm">
                    <div class="flex-1">
                        <h3 class="font-bold text-gray-900 text-lg">{{ $item['product_name'] }}</h3>
                        <p class="text-indigo-600 font-semibold">Rp {{ number_format($item['price']) }}</p>
                    </div>


                    <div class="flex items-center bg-gray-50 rounded-lg p-1 border">
                        <form action="{{ route('cart.update') }}" method="POST" class="flex items-center">
                            @csrf
                            <input type="hidden" name="variant_id" value="{{ $item['variant_id'] }}">
                            <button name="qty" value="{{ $item['qty'] - 1 }}" class="w-8 h-8 flex items-center justify-center hover:text-indigo-600">−</button>
                            <span class="w-10 text-center font-bold text-sm">{{ $item['qty'] }}</span>
                            <button name="qty" value="{{ $item['qty'] + 1 }}" class="w-8 h-8 flex items-center justify-center hover:text-indigo-600">+</button>
                        </form>
                    </div>


                    <div class="text-right min-w-[120px]">
                        <p class="font-bold text-gray-900">Rp {{ number_format($item['price'] * $item['qty']) }}</p>
                        <form action="{{ route('cart.remove', $item['variant_id']) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="text-xs text-red-500 hover:underline mt-1">Hapus</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white p-12 text-center rounded-2xl border border-dashed border-gray-300">
                    <p class="text-gray-500">Keranjang Anda masih kosong.</p>
                    <a href="{{ route('home') }}" class="text-indigo-600 font-bold mt-2 inline-block">Mulai Belanja →</a>
                </div>
            @endforelse
        </div>


        {{-- SUMMARY & CHECKOUT --}}
        <div class="space-y-6">
            <div class="bg-white border rounded-2xl p-6 shadow-sm sticky top-6">
                <h2 class="font-bold text-xl mb-6 text-gray-800 border-b pb-4">Checkout Details</h2>


                {{-- PILIH ALAMAT --}}
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Alamat Pengiriman</label>
                    <select id="addressSelector" class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-3 bg-gray-50 text-sm">
                        <option value="">-- Pilih Alamat Tersimpan --</option>
                        @foreach($addresses as $addr)
                            <option value="{{ $addr->id }}">
                                {{ $addr->name }} ({{ $addr->city }})
                            </option>
                        @endforeach
                    </select>
                    <div class="mt-3">
                        @php
                            $routeAdd = auth()->user()->hasRole('admin') ? route('admin.addresses.create') : route('user.addresses.create');
                        @endphp
                        <a href="{{ $routeAdd }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 underline">
                            + Tambah Alamat Baru
                        </a>
                    </div>
                </div>


                <div class="space-y-3 mb-6">
                    <div class="flex justify-between text-gray-600">
                        <span>Total Barang</span>
                        <span>{{ collect($cart)->sum('qty') }} pcs</span>
                    </div>
                    <div class="flex justify-between text-xl font-black text-gray-900 pt-3 border-t">
                        <span>Total Bayar</span>
                        <span class="text-indigo-600">Rp {{ number_format(collect($cart)->sum(fn($i) => $i['price'] * $i['qty'])) }}</span>
                    </div>
                </div>


                <button id="payButton"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-4 rounded-xl font-bold text-lg shadow-lg shadow-indigo-200 transition-all active:scale-95 disabled:opacity-50"
                    {{ empty($cart) ? 'disabled' : '' }}>
                    Bayar Sekarang
                </button>
            </div>
        </div>


    </div>
</div>


{{-- MIDTRANS SNAP JS --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('services.midtrans.clientKey') }}"></script>


<script>
document.getElementById('payButton')?.addEventListener('click', function (e) {
    e.preventDefault();
    const addressId = document.getElementById('addressSelector').value;


    if (!addressId) {
        alert('Mohon pilih alamat pengiriman terlebih dahulu!');
        return;
    }


    const btn = this;
    btn.innerHTML = `<span class="animate-pulse">Processing...</span>`;
    btn.disabled = true;


    fetch("{{ route('checkout.store') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json",
            "Accept": "application/json"
        },
        body: JSON.stringify({
            address_id: addressId
        })
    })
    .then(async res => {
        const data = await res.json();
        if (!res.ok) throw new Error(data.error || 'Server Error');
        return data;
    })
    .then(data => {
        snap.pay(data.snap_token, {
            onSuccess: function(result) {
                alert("Pembayaran Berhasil!");
                window.location.href = '/';
            },
            onPending: function(result) {
                alert("Menunggu pembayaran...");
                location.reload();
            },
            onError: function(result) {
                alert("Pembayaran gagal!");
                btn.innerHTML = "Bayar Sekarang";
                btn.disabled = false;
            },
            onClose: function() {
                btn.innerHTML = "Bayar Sekarang";
                btn.disabled = false;
            }
        });
    })
    .catch(err => {
        alert(err.message);
        btn.innerHTML = "Bayar Sekarang";
        btn.disabled = false;
    });
});
</script>
@endsection
