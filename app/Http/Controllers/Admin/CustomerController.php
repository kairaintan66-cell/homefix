<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CustomerController extends Controller
{
    /**
     * Menampilkan daftar pelanggan.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $customers = User::query()
            ->where('role', 'pengguna')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'ilike', "%{$search}%")
                        ->orWhere('email', 'ilike', "%{$search}%");
                });
            })
            ->withCount('bookings')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.customers.index', compact(
            'customers',
            'search'
        ));
    }

    /**
     * Menampilkan formulir tambah pelanggan.
     */
    public function create(): View
    {
        return view('admin.customers.create');
    }

    /**
     * Menyimpan pelanggan baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'pengguna',
        ]);

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir edit pelanggan.
     */
    public function edit(User $customer): View|RedirectResponse
    {
        if ($customer->role !== 'pengguna') {
            return redirect()
                ->route('admin.customers.index')
                ->with('error', 'Akun yang dipilih bukan pelanggan.');
        }

        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Memperbarui data pelanggan.
     */
    public function update(
        Request $request,
        User $customer
    ): RedirectResponse {
        if ($customer->role !== 'pengguna') {
            return redirect()
                ->route('admin.customers.index')
                ->with('error', 'Akun yang dipilih bukan pelanggan.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($customer->id),
            ],
            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);

        $customer->name = $validated['name'];
        $customer->email = $validated['email'];

        if (!empty($validated['password'])) {
            $customer->password = Hash::make($validated['password']);
        }

        $customer->save();

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    /**
     * Menghapus pelanggan yang belum memiliki booking.
     */
    public function destroy(User $customer): RedirectResponse
    {
        if ($customer->role !== 'pengguna') {
            return redirect()
                ->route('admin.customers.index')
                ->with('error', 'Akun yang dipilih bukan pelanggan.');
        }

        if ($customer->bookings()->exists()) {
            return redirect()
                ->route('admin.customers.index')
                ->with(
                    'error',
                    'Pelanggan tidak dapat dihapus karena sudah memiliki riwayat booking.'
                );
        }

        $customer->delete();

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Pelanggan berhasil dihapus.');
    }
}
