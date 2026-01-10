<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Category</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white p-6 rounded shadow w-full max-w-md">

        <h1 class="text-xl font-bold mb-4">Edit Category</h1>

        <form method="POST" action="{{ route('admin.categories.update', $category) }}">
            @csrf
            @method('PUT')

            <input type="text" name="name" value="{{ old('name', $category->name) }}"
                class="w-full border p-2 rounded mb-3" required>

            @error('name')
                <p class="text-red-600 text-sm mb-2">{{ $message }}</p>
            @enderror

            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 border rounded">
                    Batal
                </a>
                <button class="bg-blue-600 text-white px-4 py-2 rounded">
                    Update
                </button>
            </div>
        </form>

    </div>

</body>

</html>
