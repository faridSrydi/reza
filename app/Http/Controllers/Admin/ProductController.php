<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB; // Penting untuk Data Integrity

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $products = Product::query()
            ->with(['category', 'variants', 'images'])
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub
                        ->where('name', 'like', "%{$q}%")
                        ->orWhere('slug', 'like', "%{$q}%");
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // 1. Validasi
        // Hapus 'images.*' validation yang ketat jika sering error, 
        // kita handle manual di bawah agar lebih aman.
        $request->validate([
            'name'             => 'required|string',
            'category_id'      => 'required|exists:categories,id',
            'description'      => 'required|string',
            'variants'         => 'required|array|min:1',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.stock' => 'required|numeric|min:0',
        ]);

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            // 2. Simpan Data Product Utama
            $product = Product::create([
                'category_id' => $request->category_id,
                'name'        => $request->name,
                'slug'        => \Illuminate\Support\Str::slug($request->name),
                'description' => $request->description,
            ]);

            // 3. LOGIC UPLOAD GAMBAR (ANTI ERROR 500)
            // Kita cek manual apakah input ada dan valid
            if ($request->hasFile('images')) {
                $files = $request->file('images');

                // Pastikan $files adalah array agar bisa di-loop
                if (!is_array($files)) {
                    $files = [$files];
                }

                $sortOrder = 0;
                foreach ($files as $image) {
                    // FILTER WAJIB:
                    // 1. Pastikan $image adalah object UploadedFile (bukan array kosong {})
                    // 2. Pastikan file valid terupload ke server
                    if ($image instanceof \Illuminate\Http\UploadedFile && $image->isValid()) {
                        try {
                            $path = $image->store('products', 'public');
                            $product->images()->create([
                                'image' => $path,
                                'sort_order' => $sortOrder,
                            ]);
                            $sortOrder++;
                        } catch (\Exception $e) {
                            // Jika 1 gambar gagal, skip saja, jangan batalkan semua
                            \Illuminate\Support\Facades\Log::error("Gagal upload gambar: " . $e->getMessage());
                            continue;
                        }
                    }
                }
            }

            // 4. Simpan Variants
            if (is_array($request->variants)) {
                foreach ($request->variants as $variant) {
                    // Pastikan harga & stok ada isinya
                    if (isset($variant['price']) && isset($variant['stock'])) {
                        $product->variants()->create([
                            'color' => $variant['color'] ?? null,
                            'size'  => $variant['size'] ?? null,
                            'price' => $variant['price'],
                            'stock' => $variant['stock'],
                        ]);
                    }
                }
            }

            \Illuminate\Support\Facades\DB::commit();

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Product berhasil ditambahkan');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            // Tampilkan pesan error asli supaya kita tahu salahnya dimana
            return back()
                ->withInput()
                ->withErrors(['error' => 'SYSTEM ERROR: ' . $e->getMessage()]);
        }
    }

    public function show(Product $product)
    {
        $product->load('category', 'images', 'variants');
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $product->load('images', 'variants');

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'             => 'required|string',
            'category_id'      => 'required|exists:categories,id',
            'description'      => 'required|string',
            'images'           => 'nullable|array',
            'images.*'         => 'image|mimes:jpeg,png,jpg,webp|max:5120',
            'image_order'      => 'nullable|array',
            'image_order.*'    => 'integer',
            'variants'         => 'required|array|min:1',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.stock' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            // 1. Update Data Utama
            $product->update([
                'category_id' => $request->category_id,
                'name'        => $request->name,
                'slug'        => Str::slug($request->name),
                'description' => $request->description,
            ]);

            // 2. Hapus Gambar Lama (Jika dipilih)
            if ($request->filled('delete_images')) {
                foreach ($request->delete_images as $imgId) {
                    $image = $product->images()->find($imgId);
                    if ($image) {
                        // Hapus file fisik
                        if (Storage::disk('public')->exists($image->image)) {
                            Storage::disk('public')->delete($image->image);
                        }
                        // Hapus record db
                        $image->delete();
                    }
                }
            }

            // 3. Tambah Gambar Baru
            // 3a. Simpan urutan existing images (jika dikirim dari UI)
            if ($request->filled('image_order')) {
                $orderIds = array_values(array_filter($request->image_order, fn ($v) => is_numeric($v)));
                $orderIndex = 0;
                foreach ($orderIds as $imgId) {
                    $image = $product->images()->find($imgId);
                    if ($image) {
                        $image->update(['sort_order' => $orderIndex]);
                        $orderIndex++;
                    }
                }

                // Re-append any remaining images not in the list
                $remaining = $product->images()->whereNotIn('id', $orderIds)->orderBy('sort_order')->orderBy('id')->get();
                foreach ($remaining as $image) {
                    $image->update(['sort_order' => $orderIndex]);
                    $orderIndex++;
                }
            }

            // 3b. Tambah gambar baru (dengan sort_order setelah yang existing)
            if ($request->hasFile('images')) {
                $nextOrder = (int) ($product->images()->max('sort_order') ?? -1) + 1;
                foreach ($request->file('images') as $image) {
                    if ($image->isValid()) {
                        $path = $image->store('products', 'public');
                        $product->images()->create([
                            'image' => $path,
                            'sort_order' => $nextOrder,
                        ]);
                        $nextOrder++;
                    }
                }
            }

            // 4. Reset & Simpan Variant
            // Hati-hati: Delete all & recreate akan mereset ID variant. 
            // Jika variant ini berelasi dengan Order, sebaiknya gunakan soft delete atau update existing.
            // Namun untuk CRUD sederhana, cara ini oke.
            $product->variants()->delete();

            if ($request->filled('variants')) {
                foreach ($request->variants as $variant) {
                    if (isset($variant['price']) && isset($variant['stock'])) {
                        $product->variants()->create([
                            'color' => $variant['color'] ?? null,
                            'size'  => $variant['size'] ?? null,
                            'price' => $variant['price'],
                            'stock' => $variant['stock'],
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Product berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->withErrors(['error' => 'Gagal update: ' . $e->getMessage()]);
        }
    }

    public function destroy(Product $product)
    {
        try {
            DB::beginTransaction();

            // Hapus gambar fisik dari storage
            foreach ($product->images as $image) {
                if (Storage::disk('public')->exists($image->image)) {
                    Storage::disk('public')->delete($image->image);
                }
            }

            // Hapus produk (Cascading delete akan menghapus images & variants di DB jika diset di migration)
            // Jika tidak cascade, hapus manual:
            $product->images()->delete();
            $product->variants()->delete();
            $product->delete();

            DB::commit();
            return back()->with('success', 'Product berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }
}
