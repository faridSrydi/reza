<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

<div class="bg-white p-6 rounded shadow max-w-4xl mx-auto">
    <h1 class="text-xl font-bold mb-4">Tambah Product</h1>

    <form method="POST"
          enctype="multipart/form-data"
          action="{{ route('admin.products.store') }}"
          class="space-y-4">
        @csrf

        {{-- Nama --}}
        <input name="name"
               class="w-full border p-2 rounded"
               placeholder="Nama Product">

        {{-- Kategori --}}
        <select name="category_id"
                class="w-full border p-2 rounded">
            <option value="">-- Kategori --</option>
            @foreach($categories as $c)
                <option value="{{ $c->id }}">{{ $c->name }}</option>
            @endforeach
        </select>

        {{-- Deskripsi --}}
        <textarea name="description"
                  rows="4"
                  class="w-full border p-2 rounded"
                  placeholder="Deskripsi"></textarea>

        {{-- Images --}}
        <input type="file"
               name="images[]"
               multiple
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
                {{-- Variant pertama --}}
                <div class="grid grid-cols-5 gap-2 variant-item">
                    <input name="variants[0][color]"
                           placeholder="Warna"
                           class="border p-2 rounded">

                    <input name="variants[0][size]"
                           placeholder="Ukuran"
                           class="border p-2 rounded">

                    <input name="variants[0][price]"
                           placeholder="Harga"
                           class="border p-2 rounded">

                    <input name="variants[0][stock]"
                           placeholder="Stok"
                           class="border p-2 rounded">

                    <button type="button"
                            onclick="removeVariant(this)"
                            class="bg-red-500 text-white rounded">
                        ✕
                    </button>
                </div>
            </div>
        </div>

        {{-- ACTION --}}
        <div class="flex justify-end">
            <button
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
                Simpan Product
            </button>
        </div>
    </form>
</div>

{{-- SCRIPT --}}
<script>
let variantIndex = 1;

function addVariant() {
    const wrapper = document.getElementById('variant-wrapper');

    const html = `
        <div class="grid grid-cols-5 gap-2 variant-item">
            <input name="variants[${variantIndex}][color]"
                   placeholder="Warna"
                   class="border p-2 rounded">

            <input name="variants[${variantIndex}][size]"
                   placeholder="Ukuran"
                   class="border p-2 rounded">

            <input name="variants[${variantIndex}][price]"
                   placeholder="Harga"
                   class="border p-2 rounded">

            <input name="variants[${variantIndex}][stock]"
                   placeholder="Stok"
                   class="border p-2 rounded">

            <button type="button"
                    onclick="removeVariant(this)"
                    class="bg-red-500 text-white rounded">
                ✕
            </button>
        </div>
    `;

    wrapper.insertAdjacentHTML('beforeend', html);
    variantIndex++;
}

function removeVariant(button) {
    button.closest('.variant-item').remove();
}
</script>

</body>
</html>
