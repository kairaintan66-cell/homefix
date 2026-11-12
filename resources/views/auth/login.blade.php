<x-guest-layout>

<style>
    * {
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', sans-serif;
        margin: 0;
        background: #f8faf9;
    }

    .login-page {
        min-height: 100vh;
        display: grid;
        grid-template-columns: 1fr 1fr;
    }

    /* LEFT SIDE */
    .login-left {
        background: linear-gradient(145deg, #14532d, #166534, #15803d);
        padding: 65px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .login-left::before {
        content: "";
        position: absolute;
        width: 450px;
        height: 450px;
        border: 1px solid rgba(255,255,255,.12);
        border-radius: 50%;
        right: -180px;
        top: 100px;
    }

    .login-left::after {
        content: "";
        position: absolute;
        width: 320px;
        height: 320px;
        border: 1px solid rgba(255,255,255,.12);
        border-radius: 50%;
        right: -110px;
        top: 165px;
    }

    .brand {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .brand-icon {
        width: 46px;
        height: 46px;
        border-radius: 13px;
        background: white;
        color: #15803d;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 25px;
        font-weight: 900;
    }

    .brand-name {
        font-size: 25px;
        font-weight: 800;
        letter-spacing: -.7px;
    }

    .brand-name span {
        color: #bbf7d0;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        max-width: 520px;
        margin: 50px 0;
    }

    .hero-label {
        display: inline-block;
        padding: 8px 14px;
        background: rgba(255,255,255,.13);
        border: 1px solid rgba(255,255,255,.2);
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .5px;
    }

    .hero-content h1 {
        font-size: clamp(34px, 4vw, 49px);
        line-height: 1.2;
        margin: 25px 0 18px;
        font-weight: 800;
        letter-spacing: -1.5px;
    }

    .hero-content h1 span {
        color: #bbf7d0;
    }

    .hero-content p {
        max-width: 420px;
        color: #dcfce7;
        font-size: 15px;
        line-height: 1.9;
    }

    .feature-list {
        display: grid;
        gap: 15px;
        margin-top: 35px;
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 14px;
        color: #f0fdf4;
    }

    .feature-check {
        width: 25px;
        height: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255,255,255,.15);
        border-radius: 50%;
        font-size: 12px;
    }

    .left-footer {
        position: relative;
        z-index: 2;
        color: #bbf7d0;
        font-size: 12px;
    }

    /* RIGHT SIDE */
    .login-right {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 45px 35px;
        background: #f8faf9;
    }

    .login-form-wrapper {
        width: 100%;
        max-width: 440px;
    }

    .mobile-brand {
        display: none;
    }

    .form-heading {
        margin-bottom: 30px;
    }

    .form-heading h2 {
        color: #172b21;
        font-size: 30px;
        font-weight: 800;
        letter-spacing: -.8px;
        margin: 0 0 9px;
    }

    .form-heading p {
        color: #84918a;
        font-size: 14px;
        margin: 0;
    }

    .form-label {
        display: block;
        color: #33483b;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 9px;
    }

    .role-options {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        margin-bottom: 24px;
    }

    .role-option {
        position: relative;
        cursor: pointer;
    }

    .role-option input {
        position: absolute;
        opacity: 0;
    }

    .role-card {
        border: 1px solid #e2e8e4;
        background: white;
        border-radius: 12px;
        min-height: 85px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: .2s;
        color: #64746a;
    }

    .role-icon {
        font-size: 22px;
    }

    .role-name {
        font-size: 12px;
        font-weight: 700;
    }

    .role-option input:checked + .role-card {
        background: #f0fdf4;
        border: 1.5px solid #16a34a;
        color: #15803d;
        box-shadow: 0 0 0 2px rgba(22,163,74,.08);
    }

    .role-option:hover .role-card {
        border-color: #86efac;
    }

    .role-option input:focus-visible + .role-card {
        outline: 2px solid #15803d;
        outline-offset: 3px;
    }

    .input-group {
        margin-bottom: 19px;
    }

    .input-wrapper {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a39a;
        font-size: 16px;
        pointer-events: none;
    }

    .form-input {
        width: 100%;
        height: 49px;
        border: 1px solid #e2e8e4;
        border-radius: 10px;
        padding: 0 15px 0 43px;
        outline: none;
        background: white;
        color: #172b21;
        font-size: 13px;
        transition: .2s;
    }

    .form-input:focus {
        border-color: #16a34a;
        box-shadow: 0 0 0 3px rgba(22,163,74,.09);
    }

    .password-input {
        padding-right: 85px;
    }

    .toggle-password {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        border: none;
        background: none;
        color: #15803d;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
    }

    .form-options {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin: 5px 0 25px;
    }

    .remember {
        display: flex;
        align-items: center;
        gap: 7px;
        color: #718078;
        font-size: 12px;
    }

    .remember input {
        accent-color: #15803d;
    }

    .forgot-link {
        color: #15803d;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
    }

    .login-button {
        width: 100%;
        height: 50px;
        border: none;
        border-radius: 10px;
        background: #15803d;
        color: white;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: .2s;
        box-shadow: 0 5px 12px rgba(21,128,61,.15);
    }

    .login-button:hover {
        background: #166534;
        transform: translateY(-1px);
    }

    .register-text {
        text-align: center;
        margin-top: 25px;
        color: #84918a;
        font-size: 13px;
    }

    .register-text a {
        color: #15803d;
        font-weight: 700;
        text-decoration: none;
    }

    .register-text a:hover,
    .forgot-link:hover {
        text-decoration: underline;
    }

    .form-error {
        color: #dc2626;
        font-size: 12px;
        margin-top: 6px;
    }

    @media (max-width: 850px) {
        .login-page {
            grid-template-columns: 1fr;
        }

        .login-left {
            display: none;
        }

        .login-right {
            min-height: 100vh;
            padding: 35px 22px;
        }

        .mobile-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 35px;
        }

        .mobile-brand .brand-icon {
            background: #15803d;
            color: white;
        }

        .mobile-brand .brand-name {
            color: #14532d;
        }
    }

    @media (max-width: 420px) {
        .login-right {
            padding: 25px 17px;
        }

        .form-heading h2 {
            font-size: 26px;
        }

        .role-options {
            gap: 6px;
        }

        .role-card {
            min-height: 78px;
        }
    }
</style>

<div class="login-page">

    <!-- BAGIAN KIRI -->
    <section class="login-left">

        <div class="brand">
            <div class="brand-icon">H</div>

            <div class="brand-name">
                Home<span>Fix.</span>
            </div>
        </div>

        <div class="hero-content">

            <span class="hero-label">
                HOME SERVICE PLATFORM
            </span>

            <h1>
                Rumah Nyaman,<br>
                Hidup Lebih <span>Mudah.</span>
            </h1>

            <p>
                Temukan teknisi profesional untuk membantu berbagai
                kebutuhan perbaikan dan perawatan rumah Anda.
                Praktis, mudah, dan terpercaya melalui HomeFix.
            </p>

            <div class="feature-list">

                <div class="feature-item">
                    <span class="feature-check">✓</span>
                    Teknisi sesuai kebutuhan Anda
                </div>

                <div class="feature-item">
                    <span class="feature-check">✓</span>
                    Pemesanan layanan lebih praktis
                </div>

                <div class="feature-item">
                    <span class="feature-check">✓</span>
                    Pantau proses layanan dengan mudah
                </div>

            </div>

        </div>

        <div class="left-footer">
            © {{ date('Y') }} HomeFix. All rights reserved.
        </div>

    </section>


    <!-- BAGIAN KANAN -->
    <section class="login-right">

        <div class="login-form-wrapper">

            <!-- Brand untuk HP -->
            <div class="mobile-brand">

                <div class="brand-icon">H</div>

                <div class="brand-name">
                    Home<span>.</span>Fix
                </div>

            </div>

            <div class="form-heading">

                <h2>Selamat Datang!</h2>

                <p>
                    Silakan masuk ke akun HomeFix Anda.
                </p>

            </div>

            <x-auth-session-status
                class="mb-4"
                :status="session('status')"
            />

            <form method="POST" action="{{ route('login') }}">

                @csrf

                <!-- PILIH ROLE -->
                <div>

                    <label class="form-label">
                        Masuk sebagai
                    </label>

                    <div class="role-options">

                        <label class="role-option">

                            <input
                                type="radio"
                                name="role"
                                value="admin"
                                {{ old('role') === 'admin' ? 'checked' : '' }}
                                required
                            >

                            <span class="role-card">
                                <span class="role-icon">🛡️</span>
                                <span class="role-name">Admin</span>
                            </span>

                        </label>

                        <label class="role-option">

                            <input
                                type="radio"
                                name="role"
                                value="pengguna"
                                {{ old('role', 'pengguna') === 'pengguna' ? 'checked' : '' }}
                                required
                            >

                            <span class="role-card">
                                <span class="role-icon">👤</span>
                                <span class="role-name">Pengguna</span>
                            </span>

                        </label>

                        <label class="role-option">

                            <input
                                type="radio"
                                name="role"
                                value="teknisi"
                                {{ old('role') === 'teknisi' ? 'checked' : '' }}
                                required
                            >

                            <span class="role-card">
                                <span class="role-icon">🔧</span>
                                <span class="role-name">Teknisi</span>
                            </span>

                        </label>

                    </div>

                    <x-input-error
                        :messages="$errors->get('role')"
                        class="form-error"
                    />

                </div>


                <!-- EMAIL -->
                <div class="input-group">

                    <label for="email" class="form-label">
                        Alamat Email
                    </label>

                    <div class="input-wrapper">

                        <span class="input-icon">✉</span>

                        <input
                            id="email"
                            class="form-input"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="Masukkan email Anda"
                        >

                    </div>

                    <x-input-error
                        :messages="$errors->get('email')"
                        class="form-error"
                    />

                </div>


                <!-- PASSWORD -->
                <div class="input-group">

                    <label for="password" class="form-label">
                        Password
                    </label>

                    <div class="input-wrapper">

                        <span class="input-icon">🔒</span>

                        <input
                            id="password"
                            class="form-input password-input"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="Masukkan password Anda"
                        >

                        <button
                            type="button"
                            class="toggle-password"
                            onclick="togglePassword()"
                            id="togglePassword"
                        >
                            Lihat
                        </button>

                    </div>

                    <x-input-error
                        :messages="$errors->get('password')"
                        class="form-error"
                    />

                </div>


                <!-- REMEMBER ME -->
                <div class="form-options">

                    <label class="remember" for="remember_me">

                        <input
                            id="remember_me"
                            type="checkbox"
                            name="remember"
                        >

                        Ingat saya

                    </label>

                    @if (Route::has('password.request'))

                        <a
                            href="{{ route('password.request') }}"
                            class="forgot-link"
                        >
                            Lupa password?
                        </a>

                    @endif

                </div>


                <!-- LOGIN BUTTON -->
                <button type="submit" class="login-button">
                    Masuk ke HomeFix →
                </button>

            </form>


            <!-- REGISTER -->
            @if (Route::has('register'))

                <div class="register-text">

                    Belum memiliki akun?

                    <a href="{{ route('register') }}">
                        Daftar sekarang
                    </a>

                </div>

            @endif

        </div>

    </section>

</div>


<script>
    function togglePassword() {

        const password = document.getElementById('password');
        const button = document.getElementById('togglePassword');

        if (password.type === 'password') {

            password.type = 'text';
            button.textContent = 'Sembunyikan';

        } else {

            password.type = 'password';
            button.textContent = 'Lihat';

        }
    }
</script>

</x-guest-layout>
