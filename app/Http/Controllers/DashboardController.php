<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Mengarahkan pengguna ke dashboard berdasarkan role.
     */
    public function redirect(): RedirectResponse
    {
        $user = Auth::user();

        // Memastikan pengguna sudah login
        if (!$user) {
            return redirect()->route('login');
        }

        // Mengarahkan berdasarkan role pengguna
        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'teknisi' => redirect()->route('teknisi.dashboard'),
            'pengguna' => redirect()->route('pengguna.dashboard'),

            default => abort(403, 'Role pengguna tidak dikenali.'),
        };
    }
}