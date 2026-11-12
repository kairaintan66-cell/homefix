<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Arahkan halaman kategori lama ke Manajemen Layanan.
     */
    public function index(Request $request)
    {
        return redirect()->route('admin.services.index', [
            'tab' => 'kategori',
            'search' => $request->input('search'),
        ]);
    }

    /**
     * Form tambah kategori.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Simpan kategori baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:categories,name',
            ],
            'description' => ['nullable', 'string'],
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
            'is_active' => ['required', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                ->store('categories', 'public');
        }

        Category::create($validated);

        return redirect()
            ->route('admin.services.index', ['tab' => 'kategori'])
            ->with('success', 'Kategori layanan berhasil ditambahkan.');
    }

    /**
     * Form edit kategori.
     */
    public function edit(Category $kategori)
    {
        return view('admin.categories.edit', [
            'category' => $kategori,
        ]);
    }

    /**
     * Perbarui kategori.
     */
    public function update(Request $request, Category $kategori)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')->ignore($kategori->id),
            ],
            'description' => ['nullable', 'string'],
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
            'is_active' => ['required', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            if ($kategori->image) {
                Storage::disk('public')->delete($kategori->image);
            }

            $validated['image'] = $request->file('image')
                ->store('categories', 'public');
        } else {
            unset($validated['image']);
        }

        $kategori->update($validated);

        return redirect()
            ->route('admin.services.index', ['tab' => 'kategori'])
            ->with('success', 'Kategori layanan berhasil diperbarui.');
    }

    /**
     * Hapus kategori.
     */
    public function destroy(Category $kategori)
    {
        // Kategori tidak boleh dihapus jika masih memiliki layanan.
        if ($kategori->services()->exists()) {
            return redirect()
                ->route('admin.services.index', ['tab' => 'kategori'])
                ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh layanan. Hapus atau pindahkan layanan terkait terlebih dahulu.');
        }

        $image = $kategori->image;

        $kategori->delete();

        if ($image) {
            Storage::disk('public')->delete($image);
        }

        return redirect()
            ->route('admin.services.index', ['tab' => 'kategori'])
            ->with('success', 'Kategori layanan berhasil dihapus.');
    }
}
