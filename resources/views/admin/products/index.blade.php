<!DOCTYPE html>
<html>
<head>
    <title>Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

<div class="bg-white p-6 rounded shadow">
    <div class="flex justify-between mb-4">
        <h1 class="text-xl font-bold">Data Product</h1>
        <a href="{{ route('admin.products.create') }}"
           class="bg-green-600 text-white px-4 py-2 rounded">
           + Tambah
        </a>
    </div>

    <table class="w-full border">
        <thead class="bg-gray-200">
        <tr>
            <th class="p-2">Nama</th>
            <th>Kategori</th>
            <th>Variant</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
        <tr class="border-b">
            <td class="p-2">{{ $product->name }}</td>
            <td>{{ $product->category->name }}</td>
            <td>{{ $product->variants->count() }}</td>
            <td class="space-x-2">
                <a href="{{ route('admin.products.show',$product) }}" class="text-blue-600">Detail</a>
                <a href="{{ route('admin.products.edit',$product) }}" class="text-yellow-600">Edit</a>
                <form method="POST" action="{{ route('admin.products.destroy',$product) }}" class="inline">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('Hapus?')" class="text-red-600">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>

</body>
</html>
