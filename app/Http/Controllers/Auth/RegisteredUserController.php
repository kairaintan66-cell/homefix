<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Menampilkan halaman registrasi.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Memproses registrasi pengguna baru.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi data registrasi
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'role' => [
                'required',
                'in:pengguna,teknisi',
            ],

            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults(),
            ],
        ]);

        // Membuat akun dan profil teknisi dalam satu transaksi
        $user = DB::transaction(function () use ($validated) {

            // Membuat akun pengguna
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
            ]);

            // Jika mendaftar sebagai teknisi,
            // otomatis membuat profil teknisi
            if ($validated['role'] === 'teknisi') {

                $user->technician()->create([
                    'phone' => null,
                    'address' => null,
                    'bio' => null,
                    'rating' => 0,
                    'is_available' => false,
                    'is_verified' => false,
                ]);
            }

            return $user;
        });

        // Mengirim event registrasi
        event(new Registered($user));

        // Login otomatis setelah registrasi
        Auth::login($user);

        // Memperbarui session
        $request->session()->regenerate();

        // Mengarahkan berdasarkan role
        return redirect()->route('dashboard');
    }
}