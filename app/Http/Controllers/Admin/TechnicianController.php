<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Technician;
use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class TechnicianController extends Controller
{
    public function index(Request $request)
    {
        $query = Technician::with(['user', 'services']);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                    ->orWhere('email', 'ilike', "%{$search}%");
            });
        }

        $technicians = $query->latest()->paginate(10)->withQueryString();

        return view('admin.technicians.index', compact('technicians'));
    }

    /**
     * Form tambah teknisi.
     */
    public function create()
    {
        $services = Service::orderBy('name')->get();

        return view('admin.technicians.create', compact('services'));
    }

    /**
     * Menyimpan teknisi beserta keahliannya.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string'],
            'bio' => ['nullable', 'string'],
            'is_available' => ['required', 'boolean'],
            'is_verified' => ['required', 'boolean'],

            // Keahlian teknisi.
            'service_ids' => ['required', 'array', 'min:1'],
            'service_ids.*' => [
                'required',
                'integer',
                'distinct',
                'exists:services,id',
            ],
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'teknisi',
            ]);

            $technician = $user->technician()->create([
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'bio' => $validated['bio'] ?? null,
                'is_available' => $validated['is_available'],
                'is_verified' => $validated['is_verified'],
            ]);

            // Simpan pilihan keahlian ke technician_services.
            $technician->services()->sync($validated['service_ids']);
        });

        return redirect()
            ->route('admin.technicians.index')
            ->with('success', 'Teknisi berhasil ditambahkan beserta keahliannya.');
    }

    /**
     * Form edit teknisi.
     */
    public function edit(Technician $teknisi)
    {
        $teknisi->load(['user', 'services']);

        $services = Service::orderBy('name')->get();

        $selectedServices = $teknisi->services
            ->pluck('id')
            ->toArray();

        return view('admin.technicians.edit', compact(
            'teknisi',
            'services',
            'selectedServices'
        ));
    }

    /**
     * Memperbarui data dan keahlian teknisi.
     */
    public function update(Request $request, Technician $teknisi)
    {
        $teknisi->load('user');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($teknisi->user_id),
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string'],
            'bio' => ['nullable', 'string'],
            'is_available' => ['required', 'boolean'],
            'is_verified' => ['required', 'boolean'],

            // Keahlian teknisi.
            'service_ids' => ['required', 'array', 'min:1'],
            'service_ids.*' => [
                'required',
                'integer',
                'distinct',
                'exists:services,id',
            ],
        ]);

        DB::transaction(function () use ($validated, $teknisi) {
            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
            ];

            if (!empty($validated['password'])) {
                $userData['password'] = Hash::make($validated['password']);
            }

            $teknisi->user->update($userData);

            $teknisi->update([
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'bio' => $validated['bio'] ?? null,
                'is_available' => $validated['is_available'],
                'is_verified' => $validated['is_verified'],
            ]);

            // Perbarui seluruh pilihan keahlian teknisi.
            $teknisi->services()->sync($validated['service_ids']);
        });

        return redirect()
            ->route('admin.technicians.index')
            ->with('success', 'Data teknisi dan keahliannya berhasil diperbarui.');
    }

    /**
     * Menghapus teknisi.
     */
    public function destroy(Technician $teknisi)
    {
        if (
            $teknisi->bookings()->exists() ||
            $teknisi->reviews()->exists()
        ) {
            return back()->with(
                'error',
                'Teknisi tidak dapat dihapus karena masih memiliki riwayat booking atau ulasan.'
            );
        }

        DB::transaction(function () use ($teknisi) {
            $teknisi->user()->delete();
        });

        return redirect()
            ->route('admin.technicians.index')
            ->with('success', 'Teknisi berhasil dihapus.');
    }
}
