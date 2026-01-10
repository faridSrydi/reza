<!DOCTYPE html>
<html>

<head>
    <title>Detail Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">

    <div class="bg-white p-6 rounded shadow max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold">{{ $product->name }}</h1>
        <p class="text-gray-600 mb-4">{{ $product->category->name }}</p>

        <p class="mb-4">{{ $product->description }}</p>

        <div class="flex gap-2 mb-4">
            @foreach ($product->images as $img)
                <img src="{{ asset('storage/' . $img->image) }}" class="w-24 rounded">
            @endforeach
        </div>

        <h3 class="font-bold">Variant</h3>
        <ul class="list-disc ml-6">
            @foreach ($product->variants as $v)
                <li>
                    {{ $v->color }} {{ $v->size }} –
                    Rp {{ number_format($v->price) }} |
                    Stok {{ $v->stock }}
                </li>
            @endforeach
        </ul>

        <a href="{{ route('admin.products.index') }}" class="inline-block mt-4 text-blue-600">
            ← Kembali
        </a>
    </div>

</body>

</html>
