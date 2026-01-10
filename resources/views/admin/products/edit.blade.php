<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">

<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Edit Product</h1>

    <form method="POST"
          enctype="multipart/form-data"
          action="{{ route('admin.products.update', $product) }}"
          class="space-y-4">
        @csrf
        @method('PUT')

        {{-- Nama --}}
        <input name="name"
               value="{{ $product->name }}"
               class="w-full border p-2 rounded">

        {{-- Kategori --}}
        <select name="category_id"
                class="w-full border p-2 rounded">
            @foreach($categories as $c)
                <option value="{{ $c->id }}"
                    @selected($product->category_id == $c->id)>
                    {{ $c->name }}
                </option>
            @endforeach
        </select>

        {{-- Deskripsi --}}
        <textarea name="description"
                  rows="4"
                  class="w-full border p-2 rounded">{{ $product->description }}</textarea>

        {{-- GAMBAR --}}
        <div>
            <h3 class="font-bold mb-2">Gambar Saat Ini</h3>
            <div class="flex gap-3 flex-wrap">
                @foreach($product->images as $img)
                    <label class="relative">
                        <img src="{{ asset('storage/'.$img->image) }}"
                             class="w-24 h-24 object-cover rounded border">

                        <input type="checkbox"
                               name="delete_images[]"
                               value="{{ $img->id }}"
                               class="absolute top-1 right-1">
                        <span class="absolute top-1 right-6 bg-red-600 text-white text-xs px-1 rounded">
                            Hapus
                        </span>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- TAMBAH GAMBAR --}}
        <input type="file" name="images[]" multiple
               class="w-full border p-2 rounded">

        {{-- VARIANT --}}
        <div>
            <div class="flex justify-between items-center mb-2">
                <h3 class="font-bold text-lg">Variant Product</h3>
                <button type="button"
                        onclick="addVariant()"
                        class="bg-green-600 text-white px-3 py-1 rounded text-sm">
                    + Tambah Variant
                </button>
            </div>

            <div id="variant-wrapper" class="space-y-2">
                @foreach($product->variants as $i => $v)
                    <div class="grid grid-cols-5 gap-2 variant-item">
                        <input name="variants[{{ $i }}][color]"
                               value="{{ $v->color }}"
                               class="border p-2 rounded">

                        <input name="variants[{{ $i }}][size]"
                               value="{{ $v->size }}"
                               class="border p-2 rounded">

                        <input name="variants[{{ $i }}][price]"
                               value="{{ $v->price }}"
                               class="border p-2 rounded">

                        <input name="variants[{{ $i }}][stock]"
                               value="{{ $v->stock }}"
                               class="border p-2 rounded">

                        <button type="button"
                                onclick="removeVariant(this)"
                                class="bg-red-500 text-white rounded">
                            ✕
                        </button>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ACTION --}}
        <div class="flex justify-between">
            <a href="{{ route('admin.products.index') }}"
               class="text-gray-600">
                ← Kembali
            </a>

            <button class="bg-blue-600 text-white px-6 py-2 rounded">
                Update Product
            </button>
        </div>
    </form>
</div>

<script>
let variantIndex = {{ $product->variants->count() }};

function addVariant() {
    const wrapper = document.getElementById('variant-wrapper');
    wrapper.insertAdjacentHTML('beforeend', `
        <div class="grid grid-cols-5 gap-2 variant-item">
            <input name="variants[${variantIndex}][color]" class="border p-2 rounded">
            <input name="variants[${variantIndex}][size]" class="border p-2 rounded">
            <input name="variants[${variantIndex}][price]" class="border p-2 rounded">
            <input name="variants[${variantIndex}][stock]" class="border p-2 rounded">
            <button type="button"
                    onclick="removeVariant(this)"
                    class="bg-red-500 text-white rounded">✕</button>
        </div>
    `);
    variantIndex++;
}

function removeVariant(btn) {
    btn.closest('.variant-item').remove();
}
</script>

</body>
</html>
