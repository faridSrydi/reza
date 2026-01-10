<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Category</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen p-8">

    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-xl font-bold">Category</h1>
            <a href="{{ route('admin.categories.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
                + Tambah Category
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-2 border">No</th>
                    <th class="p-2 border">Nama</th>
                    <th class="p-2 border">Slug</th>
                    <th class="p-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr class="text-center">
                        <td class="p-2 border">{{ $loop->iteration }}</td>
                        <td class="p-2 border">{{ $category->name }}</td>
                        <td class="p-2 border">{{ $category->slug }}</td>
                        <td class="p-2 border">
                            <a href="{{ route('admin.categories.edit', $category) }}"
                                class="text-blue-600 mr-3">Edit</a>

                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                class="inline" onsubmit="return confirm('Yakin hapus?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-4 text-center">Belum ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>

</body>

</html>
