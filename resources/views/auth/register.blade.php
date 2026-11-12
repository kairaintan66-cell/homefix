
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - HomeFix</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            box-sizing: border-box;
        }

        html {
            min-height: 100%;
        }

        body {
            font-family: Arial, sans-serif;
            min-height: 100vh;
            margin: 0;
            overflow-x: hidden;
        }

        .register-card {
            width: 100%;
            max-width: 1050px;
            min-height: 650px;
            height: auto;
            display: grid;
            grid-template-columns: 0.9fr 1.1fr;
            overflow: hidden;
            border-radius: 20px;
            background: white;
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.08);
        }

        .register-left {
            background: #14532d;
            color: white;
            padding: 45px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .register-right {
            min-width: 0;
            padding: 35px 55px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .form-input {
            display: block;
            width: 100%;
            padding: 11px 15px;
            border: 1px solid #d1d5db;
            border-radius: 9px;
            font-size: 14px;
            outline: none;
            background: white;
            transition: 0.2s;
        }

        .form-input:focus {
            border-color: #15803d;
            box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.1);
        }

        .form-label {
            display: block;
            margin-bottom: 6px;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
        }

        .password-button {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            padding: 5px;
            background: white;
            font-size: 12px;
            font-weight: 600;
            color: #15803d;
            cursor: pointer;
        }

        .register-submit {
            display: block;
            width: 100%;
            min-height: 48px;
            padding: 13px 15px;
            border: none;
            border-radius: 9px;
            background: #15803d;
            color: white;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            visibility: visible;
            opacity: 1;
            position: relative;
            z-index: 2;
        }

        .register-submit:hover {
            background: #166534;
        }

        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .register-card {
                grid-template-columns: 1fr;
                max-width: 480px;
                min-height: auto;
            }

            .register-left {
                display: none;
            }

            .register-right {
                padding: 35px 25px;
            }
        }
    </style>
</head>

<body class="bg-[#f3f6f4] flex items-start justify-center p-5">

    <div class="register-card my-5">

        <!-- BAGIAN KIRI -->
        <div class="register-left">

            <div>
                <a href="/" class="text-3xl font-extrabold tracking-tight">
                    HomeFix<span class="text-green-300">.</span>
                </a>

                <p class="text-sm text-green-100 mt-2">
                    Solusi Perawatan Rumah Anda
                </p>
            </div>

            <div>
                <div class="w-16 h-16 rounded-2xl bg-white/10 flex items-center justify-center text-3xl mb-7">
                    🏡
                </div>

                <h1 class="text-4xl font-bold leading-tight">
                    Bergabung Bersama HomeFix
                </h1>

                <p class="mt-5 text-sm leading-7 text-green-100">
                    Dapatkan kemudahan dalam menemukan layanan
                    perbaikan dan perawatan rumah melalui teknisi
                    yang sesuai dengan kebutuhan Anda.
                </p>

                <div class="mt-9 space-y-5">

                    <div class="flex items-center gap-3">
                        <span class="w-7 h-7 rounded-full bg-green-400/20 flex items-center justify-center text-green-300">
                            ✓
                        </span>
                        <span class="text-sm">Pemesanan layanan lebih praktis</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <span class="w-7 h-7 rounded-full bg-green-400/20 flex items-center justify-center text-green-300">
                            ✓
                        </span>
                        <span class="text-sm">Pantau status pesanan</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <span class="w-7 h-7 rounded-full bg-green-400/20 flex items-center justify-center text-green-300">
                            ✓
                        </span>
                        <span class="text-sm">Terhubung dengan teknisi</span>
                    </div>

                </div>
            </div>

            <p class="text-xs text-green-200">
                © {{ date('Y') }} HomeFix. All rights reserved.
            </p>

        </div>

        <!-- BAGIAN KANAN -->
        <div class="register-right">

            <div class="mb-5">
                <p class="text-xs font-bold tracking-widest text-green-700">
                    BUAT AKUN BARU
                </p>

                <h2 class="text-3xl font-bold text-gray-800 mt-2">
                    Registrasi
                </h2>

                <p class="text-sm text-gray-500 mt-2">
                    Lengkapi informasi berikut untuk membuat akun.
                </p>
            </div>

            <!-- ERROR VALIDASI -->
            @if ($errors->any())
                <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-3">
                @csrf

                <!-- NAMA -->
                <div>
                    <label for="name" class="form-label">
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Masukkan nama lengkap"
                        class="form-input"
                        required
                        autofocus
                        autocomplete="name"
                    >
                </div>

                <!-- EMAIL -->
                <div>
                    <label for="email" class="form-label">
                        Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="contoh@email.com"
                        class="form-input"
                        required
                        autocomplete="username"
                    >
                </div>

                <!-- ROLE -->
                <div>
                    <label for="role" class="form-label">
                        Daftar Sebagai
                    </label>

                    <select
                        id="role"
                        name="role"
                        class="form-input"
                        required
                    >
                        <option value="pengguna" {{ old('role', 'pengguna') == 'pengguna' ? 'selected' : '' }}>
                            Pengguna
                        </option>

                        <option value="teknisi" {{ old('role') == 'teknisi' ? 'selected' : '' }}>
                            Teknisi
                        </option>
                    </select>

                    <p class="text-xs text-gray-400 mt-1">
                        Akun Admin dibuat oleh pengelola HomeFix.
                    </p>
                </div>

                <!-- PASSWORD -->
                <div>
                    <label for="password" class="form-label">
                        Password
                    </label>

                    <div class="relative">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Masukkan password"
                            class="form-input pr-24"
                            required
                            autocomplete="new-password"
                        >

                        <button
                            type="button"
                            onclick="togglePassword('password', this)"
                            class="password-button"
                        >
                            Lihat
                        </button>
                    </div>
                </div>

                <!-- KONFIRMASI PASSWORD -->
                <div>
                    <label for="password_confirmation" class="form-label">
                        Konfirmasi Password
                    </label>

                    <div class="relative">
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="Ulangi password"
                            class="form-input pr-24"
                            required
                            autocomplete="new-password"
                        >

                        <button
                            type="button"
                            onclick="togglePassword('password_confirmation', this)"
                            class="password-button"
                        >
                            Lihat
                        </button>
                    </div>
                </div>

                <!-- TOMBOL BUAT AKUN -->
                <button type="submit" class="register-submit">
                    Buat Akun
                </button>

            </form>

            <!-- LINK LOGIN -->
            <div class="text-center mt-4 mb-2">
                <p class="text-sm text-gray-500">
                    Sudah punya akun?

                    <a
                        href="{{ route('login') }}"
                        class="font-bold text-green-700 hover:text-green-900"
                    >
                        Masuk sekarang
                    </a>
                </p>
            </div>

        </div>
    </div>

    <script>
        function togglePassword(id, button) {
            const input = document.getElementById(id);

            if (input.type === 'password') {
                input.type = 'text';
                button.textContent = 'Sembunyikan';
            } else {
                input.type = 'password';
                button.textContent = 'Lihat';
            }
        }
    </script>

</body>
</html>
