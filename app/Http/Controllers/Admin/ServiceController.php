<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    /**
     * Halaman utama Manajemen Layanan.
     * Menampilkan tab Kategori dan Daftar Layanan.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $tab = $request->input('tab', 'layanan');

        if (!in_array($tab, ['kategori', 'layanan'])) {
            $tab = 'layanan';
        }

        // Data layanan.
        $services = Service::with('category')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'ilike', "%{$search}%")
                        ->orWhereHas('category', function ($categoryQuery) use ($search) {
                            $categoryQuery->where('name', 'ilike', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(10, ['*'], 'layanan_page')
            ->withQueryString();

        // Data kategori.
        $categories = Category::withCount('services')
            ->when($search, function ($query, $search) {
                $query->where('name', 'ilike', "%{$search}%");
            })
            ->latest()
            ->paginate(10, ['*'], 'kategori_page')
            ->withQueryString();

        // Statistik layanan.
        $totalLayanan = Service::count();
        $layananAktif = Service::where('is_active', true)->count();
        $layananNonaktif = Service::where('is_active', false)->count();

        // Statistik kategori.
        $totalKategori = Category::count();
        $kategoriAktif = Category::where('is_active', true)->count();
        $kategoriNonaktif = Category::where('is_active', false)->count();

        return view('admin.services.index', compact(
            'services',
            'categories',
            'totalLayanan',
            'layananAktif',
            'layananNonaktif',
            'totalKategori',
            'kategoriAktif',
            'kategoriNonaktif',
            'search',
            'tab'
        ));
    }

    /**
     * Form tambah layanan.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.services.create', compact('categories'));
    }

    /**
     * Simpan layanan baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration' => ['required', 'integer', 'min:1'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'is_active' => ['required', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                ->store('services', 'public');
        }

        Service::create($validated);

        return redirect()
            ->route('admin.services.index', ['tab' => 'layanan'])
            ->with('success', 'Layanan berhasil ditambahkan.');
    }

    /**
     * Form edit layanan.
     */
    public function edit(Service $layanan)
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.services.edit', [
            'service' => $layanan,
            'categories' => $categories,
        ]);
    }

    /**
     * Perbarui layanan.
     */
    public function update(Request $request, Service $layanan)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration' => ['required', 'integer', 'min:1'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'is_active' => ['required', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            if ($layanan->image) {
                Storage::disk('public')->delete($layanan->image);
            }

            $validated['image'] = $request->file('image')
                ->store('services', 'public');
        } else {
            unset($validated['image']);
        }

        $layanan->update($validated);

        return redirect()
            ->route('admin.services.index', ['tab' => 'layanan'])
            ->with('success', 'Layanan berhasil diperbarui.');
    }

    /**
     * Hapus layanan.
     */
    public function destroy(Service $layanan)
    {
        // Cegah penghapusan layanan yang sudah digunakan dalam booking.
        $hasBooking = DB::table('booking_details')
            ->where('service_id', $layanan->id)
            ->exists();

        if ($hasBooking) {
            return redirect()
                ->route('admin.services.index', ['tab' => 'layanan'])
                ->with('error', 'Layanan tidak dapat dihapus karena sudah digunakan dalam booking. Nonaktifkan layanan jika tidak ingin ditampilkan.');
        }

        DB::transaction(function () use ($layanan) {
            if (DB::getSchemaBuilder()->hasTable('technician_services')) {
                DB::table('technician_services')
                    ->where('service_id', $layanan->id)
                    ->delete();
            }

            $layanan->delete();
        });

        if ($layanan->image) {
            Storage::disk('public')->delete($layanan->image);
        }

        return redirect()
            ->route('admin.services.index', ['tab' => 'layanan'])
            ->with('success', 'Layanan berhasil dihapus.');
    }
}
