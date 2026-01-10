<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'variants')->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'                 => 'required|string',
            'category_id'          => 'required|exists:categories,id',
            'description'          => 'required|string',
            'images.*'             => 'nullable|image|max:2048',
            'variants'             => 'required|array|min:1',
            'variants.*.price'     => 'required|numeric|min:0',
            'variants.*.stock'     => 'required|numeric|min:0',
        ]);

        $product = Product::create([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
        ]);

        /** ----------------
         * UPLOAD GAMBAR
         * ---------------- */
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $product->images()->create([
                    'image' => $path
                ]);
            }
        }

        /** ----------------
         * VARIANT
         * ---------------- */
        foreach ($request->variants as $variant) {
            $product->variants()->create([
                'color' => $variant['color'] ?? null,
                'size'  => $variant['size'] ?? null,
                'price' => $variant['price'],
                'stock' => $variant['stock'],
            ]);
        }

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product berhasil ditambahkan');
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
            'name'                 => 'required|string',
            'category_id'          => 'required|exists:categories,id',
            'description'          => 'required|string',
            'images.*'             => 'nullable|image|max:2048',
            'variants'             => 'required|array|min:1',
            'variants.*.price'     => 'required|numeric|min:0',
            'variants.*.stock'     => 'required|numeric|min:0',
        ]);

        $product->update([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
        ]);

        /** ----------------
         * HAPUS GAMBAR LAMA
         * ---------------- */
        if ($request->filled('delete_images')) {
            foreach ($request->delete_images as $imgId) {
                $image = $product->images()->find($imgId);
                if ($image) {
                    Storage::disk('public')->delete($image->image);
                    $image->delete();
                }
            }
        }

        /** ----------------
         * TAMBAH GAMBAR BARU
         * ---------------- */
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $product->images()->create([
                    'image' => $path
                ]);
            }
        }

        /** ----------------
         * RESET & SIMPAN VARIANT
         * ---------------- */
        $product->variants()->delete();

        foreach ($request->variants as $variant) {
            $product->variants()->create([
                'color' => $variant['color'] ?? null,
                'size'  => $variant['size'] ?? null,
                'price' => $variant['price'],
                'stock' => $variant['stock'],
            ]);
        }

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product berhasil diperbarui');
    }

    public function destroy(Product $product)
    {
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image);
        }

        $product->delete();

        return back()->with('success', 'Product berhasil dihapus');
    }
}
