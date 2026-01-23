<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $slug = Str::slug($request->name);
        if (Category::query()->where('slug', $slug)->exists()) {
            return back()
                ->withInput()
                ->withErrors(['name' => 'Category already exists. Please use a different name.'])
                ->with('toast', [
                    'type' => 'error',
                    'message' => 'Oops! That category already exists.',
                ]);
        }

        $imagePath = null;
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imagePath = $request->file('image')->store('categories', 'public');
        }

        try {
            Category::create([
                'name' => $request->name,
                'slug' => $slug,
                'image' => $imagePath,
            ]);
        } catch (QueryException $e) {
            // Duplicate slug (race condition / concurrent request)
            if ((string) ($e->getCode()) === '23000') {
                if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }

                return back()
                    ->withInput()
                    ->withErrors(['name' => 'Category already exists. Please use a different name.'])
                    ->with('toast', [
                        'type' => 'error',
                        'message' => 'Oops! That category already exists.',
                    ]);
            }

            throw $e;
        }

        return redirect()
            ->route('admin.categories.index')
            ->with('toast', ['type' => 'success', 'message' => 'Category created successfully!']);
    }

    public function edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $slug = Str::slug($request->name);
        if (Category::query()->where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
            return back()
                ->withInput()
                ->withErrors(['name' => 'Category already exists. Please use a different name.'])
                ->with('toast', [
                    'type' => 'error',
                    'message' => 'Oops! That category already exists.',
                ]);
        }

        $imagePath = $category->image;
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('categories', 'public');
        }

        try {
            $category->update([
                'name' => $request->name,
                'slug' => $slug,
                'image' => $imagePath,
            ]);
        } catch (QueryException $e) {
            if ((string) ($e->getCode()) === '23000') {
                return back()
                    ->withInput()
                    ->withErrors(['name' => 'Category already exists. Please use a different name.'])
                    ->with('toast', [
                        'type' => 'error',
                        'message' => 'Oops! That category already exists.',
                    ]);
            }

            throw $e;
        }

        return redirect()
            ->route('admin.categories.index')
            ->with('toast', ['type' => 'success', 'message' => 'Category updated successfully!']);
    }

    public function destroy(Category $category)
    {
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category berhasil dihapus');
    }
}
