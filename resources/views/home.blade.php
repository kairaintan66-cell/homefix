<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>HomeFix - Layanan Perbaikan Rumah</title>

    @vite(['resources/css/home.css'])
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <a href="#beranda" class="logo">HomeFix</a>

        <ul class="nav-links">
            <li><a href="#beranda">Beranda</a></li>
            <li><a href="#layanan">Layanan</a></li>
            <li><a href="#cara-kerja">Cara Kerja</a></li>
            <li><a href="#tentang">Tentang Kami</a></li>
        </ul>

        <div class="nav-buttons">
            @auth
                <a href="{{ route('dashboard') }}" class="btn-login">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-login">
                    Masuk
                </a>

                <a href="{{ route('register') }}" class="btn-register">
                    Daftar
                </a>
            @endauth
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero" id="beranda">
        <div class="hero-content">
            <span class="hero-badge">Solusi Perbaikan Rumah</span>

            <h1>
                Rumah Nyaman,
                <br>
                <span>Masalah Beres.</span>
            </h1>

            <p>
                Temukan teknisi terpercaya untuk membantu memperbaiki
                berbagai kebutuhan rumah Anda dengan mudah, cepat,
                dan praktis.
            </p>

            <div class="hero-actions">
                @auth
                    <a href="{{ route('dashboard') }}" class="hero-button">
                        Buka Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}" class="hero-button">
                        Pesan Layanan
                    </a>
                @endauth

                <a href="#cara-kerja" class="hero-secondary">
                    Lihat Cara Kerja
                    <span>↓</span>
                </a>
            </div>

            <div class="hero-trust">
                <div class="trust-item">
                    <strong>{{ $categories->count() }}+</strong>
                    <span>Kategori Layanan</span>
                </div>

                <div class="trust-line"></div>

                <div class="trust-item">
                    <strong>{{ \App\Models\Service::count() }}+</strong>
                    <span>Layanan Tersedia</span>
                </div>

                <div class="trust-line"></div>

                <div class="trust-item">
                    <strong>24/7</strong>
                    <span>Pesan Kapan Saja</span>
                </div>
            </div>
        </div>

        <div class="hero-visual">
            <div class="hero-image">
                <div class="hero-visual-content">
                    <div class="house-icon">⌂</div>

                    <span>HOME SERVICE</span>

                    <h3>Rumah Lebih Nyaman</h3>

                    <p>
                        Teknisi siap membantu kebutuhan rumah Anda.
                    </p>
                </div>
            </div>

            <div class="hero-floating-card">
                <div class="floating-icon">✓</div>

                <div>
                    <strong>Teknisi Terverifikasi</strong>
                    <small>Siap membantu Anda</small>
                </div>
            </div>

            <div class="hero-floating-card second">
                <div class="floating-icon">★</div>

                <div>
                    <strong>Layanan Terpercaya</strong>
                    <small>Mudah &amp; praktis</small>
                </div>
            </div>
        </div>
    </section>

    <!-- LAYANAN -->
    <section class="services" id="layanan">
        <div class="section-header">
            <span class="section-badge">Layanan Kami</span>

            <h2>
                Solusi untuk Berbagai
                <br>
                <span>Kebutuhan Rumah</span>
            </h2>

            <p>
                Pilih layanan yang sesuai dengan kebutuhan rumah Anda
                dan temukan teknisi yang siap membantu.
            </p>
        </div>

        <div class="services-grid">
            @forelse ($categories as $index => $category)
                <a
                    href="{{ route('services.index', ['category' => $category->id]) }}"
                    class="service-card-link"
                    aria-label="Lihat layanan kategori {{ $category->name }}"
                >
                    <div class="service-card">
                        <div class="service-top">
                            <div class="service-icon">
                                @switch(strtolower($category->name))
                                    @case('elektronik')
                                        ⚡
                                        @break

                                    @case('ac')
                                        ❄
                                        @break

                                    @case('plumbing')
                                    @case('air & plumbing')
                                        🔧
                                        @break

                                    @case('kebersihan')
                                        ✨
                                        @break

                                    @case('listrik')
                                        💡
                                        @break

                                    @default
                                        ⌂
                                @endswitch
                            </div>

                            <span class="service-number">
                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>

                        <h3>{{ $category->name }}</h3>

                        <p>
                            {{ $category->description ?: 'Temukan layanan yang sesuai dengan kebutuhan rumah Anda.' }}
                        </p>

                        <div class="service-arrow">→</div>
                    </div>
                </a>
            @empty
                <div class="service-card">
                    <div class="service-top">
                        <div class="service-icon">⌂</div>
                    </div>

                    <h3>Belum Ada Kategori</h3>

                    <p>
                        Kategori layanan akan ditampilkan setelah tersedia
                        di database HomeFix.
                    </p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- CARA KERJA -->
    <section class="how-it-works" id="cara-kerja">
        <div class="section-header">
            <span class="section-badge">Cara Kerja</span>

            <h2>
                Pesan Layanan dengan
                <br>
                <span>3 Langkah Mudah</span>
            </h2>

            <p>
                HomeFix membantu Anda menemukan teknisi dan memesan
                layanan rumah tanpa proses yang rumit.
            </p>
        </div>

        <div class="steps">
            <div class="step">
                <div class="step-number">01</div>

                <div class="step-content">
                    <span class="step-label">LANGKAH PERTAMA</span>
                    <h3>Pilih Layanan</h3>

                    <p>
                        Pilih jenis layanan yang sesuai dengan
                        kebutuhan perbaikan rumah Anda.
                    </p>
                </div>
            </div>

            <div class="step">
                <div class="step-number">02</div>

                <div class="step-content">
                    <span class="step-label">LANGKAH KEDUA</span>
                    <h3>Buat Pesanan</h3>

                    <p>
                        Tentukan jadwal, alamat, dan detail kebutuhan
                        layanan Anda.
                    </p>
                </div>
            </div>

            <div class="step">
                <div class="step-number">03</div>

                <div class="step-content">
                    <span class="step-label">LANGKAH KETIGA</span>
                    <h3>Teknisi Datang</h3>

                    <p>
                        Teknisi akan datang sesuai jadwal dan membantu
                        menyelesaikan masalah di rumah Anda.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- TENTANG HOMEFIX -->
    <section class="about" id="tentang">
        <div class="about-content">
            <div class="about-visual">
                <div class="about-image">
                    <div class="about-main-icon">⌂</div>

                    <span>HOMEFIX</span>

                    <strong>
                        Your Home,
                        <br>
                        Our Solution.
                    </strong>
                </div>

                <div class="about-stat">
                    <strong>100%</strong>

                    <span>
                        Fokus pada
                        <br>
                        kebutuhan rumah
                    </span>
                </div>
            </div>

            <div class="about-text">
                <span class="section-badge">Tentang HomeFix</span>

                <h2>
                    Solusi Praktis untuk
                    <span>Rumah Anda</span>
                </h2>

                <p>
                    HomeFix adalah platform yang membantu pengguna
                    menemukan teknisi untuk berbagai kebutuhan
                    perbaikan dan perawatan rumah.
                </p>

                <p>
                    Dengan proses pemesanan yang mudah, pengguna dapat
                    menentukan layanan, memilih jadwal, dan memantau
                    proses pengerjaan melalui satu platform.
                </p>

                <div class="about-features">
                    <div class="about-feature">
                        <div>✓</div>
                        <span>Teknisi Terverifikasi</span>
                    </div>

                    <div class="about-feature">
                        <div>✓</div>
                        <span>Pemesanan Mudah</span>
                    </div>

                    <div class="about-feature">
                        <div>✓</div>
                        <span>Jadwal Fleksibel</span>
                    </div>

                    <div class="about-feature">
                        <div>✓</div>
                        <span>Rating &amp; Ulasan</span>
                    </div>
                </div>

                @auth
                    <a href="{{ route('dashboard') }}" class="hero-button">
                        Buka Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}" class="hero-button">
                        Mulai Sekarang
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- TEKNISI -->
    <section class="technicians">
        <div class="section-header">
            <span class="section-badge">Teknisi HomeFix</span>

            <h2>
                Teknisi yang Siap
                <br>
                <span>Membantu Anda</span>
            </h2>

            <p>
                HomeFix menghubungkan Anda dengan teknisi sesuai
                kebutuhan layanan rumah.
            </p>
        </div>

        <div class="technician-info">
            <div class="technician-card">
                <div class="technician-icon">✓</div>
                <span class="technician-label">VERIFIED</span>

                <h3>Teknisi Terverifikasi</h3>

                <p>
                    Teknisi melalui proses verifikasi sebelum dapat
                    menerima pesanan.
                </p>
            </div>

            <div class="technician-card">
                <div class="technician-icon">★</div>
                <span class="technician-label">RATING</span>

                <h3>Rating &amp; Ulasan</h3>

                <p>
                    Pengguna dapat memberikan rating dan ulasan
                    setelah layanan selesai.
                </p>
            </div>

            <div class="technician-card">
                <div class="technician-icon">◷</div>
                <span class="technician-label">FLEXIBLE</span>

                <h3>Jadwal Fleksibel</h3>

                <p>
                    Teknisi dapat mengatur jadwal dan ketersediaan
                    layanan mereka.
                </p>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta">
        <div class="cta-content">
            <span class="section-badge">HOMEFIX</span>

            <h2>
                Siap Membuat Rumah Anda
                <br>
                <span>Lebih Nyaman?</span>
            </h2>

            <p>
                Temukan teknisi yang sesuai dan pesan layanan
                perbaikan rumah dengan mudah melalui HomeFix.
            </p>

            @auth
                <a href="{{ route('dashboard') }}" class="cta-button">
                    Buka Dashboard
                    <span>→</span>
                </a>
            @else
                <a href="{{ route('register') }}" class="cta-button">
                    Mulai Pesan Layanan
                    <span>→</span>
                </a>
            @endauth
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-brand">
                <div class="footer-logo">HomeFix</div>

                <p>
                    Solusi mudah untuk berbagai kebutuhan
                    perbaikan dan perawatan rumah.
                </p>

                <div class="footer-status">
                    <span></span>
                    Layanan siap membantu Anda
                </div>
            </div>

            <div class="footer-links">
                <h4>Navigasi</h4>

                <a href="#beranda">Beranda</a>
                <a href="#layanan">Layanan</a>
                <a href="#cara-kerja">Cara Kerja</a>
                <a href="#tentang">Tentang Kami</a>
            </div>

            <div class="footer-links">
                <h4>Akun</h4>

                @auth
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                @else
                    <a href="{{ route('login') }}">Masuk</a>
                    <a href="{{ route('register') }}">Daftar</a>
                @endauth
            </div>
        </div>

        <div class="footer-bottom">
            <p>
                © {{ date('Y') }} HomeFix. All rights reserved.
            </p>

            <span>Made for better homes.</span>
        </div>
    </footer>

</body>
</html>
