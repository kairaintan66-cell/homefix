<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Aturan validasi login.
     */
    public function rules(): array
    {
        return [
            'role' => ['required', 'in:admin,pengguna,teknisi'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Mengizinkan request login.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Memeriksa email, password, dan role akun.
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $role = $this->input('role');

        $authenticated = Auth::attempt([
            'email' => $this->input('email'),
            'password' => $this->input('password'),
            'role' => $role,
        ], $this->boolean('remember'));

        if (! $authenticated) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => 'Email, password, atau pilihan peran tidak sesuai.',
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Membatasi percobaan login yang gagal.
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Kunci pembatasan percobaan login.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(
            Str::lower($this->string('email')->toString())
            . '|'
            . $this->ip()
        );
    }
}
