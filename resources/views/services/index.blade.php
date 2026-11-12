<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Layanan {{ $category->name }} | HomeFix</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --green: #237a57;
            --green-dark: #185b40;
            --green-light: #eaf5ee;
            --text: #1f2937;
            --muted: #6b7280;
            --border: #e5ebe7;
            --white: #ffffff;
            --background: #f7faf8;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: var(--background);
            color: var(--text);
            line-height: 1.6;
        }

        a {
            text-decoration: none;
        }

        .navbar {
            background: var(--white);
            padding: 18px 7%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            border-bottom: 1px solid var(--border);
        }

        .logo {
            color: var(--green-dark);
            font-size: 25px;
            font-weight: 800;
            letter-spacing: -0.7px;
        }

        .logo span {
            color: #7cae8e;
        }

        .back-link {
            color: var(--muted);
            font-size: 14px;
            font-weight: 600;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: var(--green);
        }

        .container {
            max-width: 1150px;
            margin: 0 auto;
            padding: 55px 24px 80px;
        }

        .breadcrumb {
            color: var(--muted);
            font-size: 13px;
            margin-bottom: 18px;
        }

        .breadcrumb a {
            color: var(--green);
        }

        .page-header {
            margin-bottom: 32px;
        }

        .eyebrow {
            display: inline-block;
            color: var(--green-dark);
            background: var(--green-light);
            padding: 6px 13px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 14px;
        }

        .page-header h1 {
            font-size: clamp(27px, 4vw, 38px);
            line-height: 1.25;
            letter-spacing: -1px;
            margin-bottom: 12px;
        }

        .page-header p {
            max-width: 600px;
            color: var(--muted);
            font-size: 15px;
        }

        .result-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            color: var(--muted);
            font-size: 13px;
        }

        .service-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 22px;
        }

        .service-card {
            display: flex;
            flex-direction: column;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 17px;
            padding: 25px;
            min-width: 0;
            box-shadow: 0 5px 18px rgba(25, 75, 49, 0.035);
            transition: transform 0.2s, box-shadow 0.2s,
                        border-color 0.2s;
        }

        .service-card:hover {
            transform: translateY(-4px);
            border-color: #b8d8c4;
            box-shadow: 0 12px 28px rgba(25, 75, 49, 0.09);
        }

        .service-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            border-radius: 13px;
            background: var(--green-light);
            color: var(--green-dark);
            font-size: 23px;
            margin-bottom: 20px;
        }

        .service-card h2 {
            font-size: 18px;
            line-height: 1.4;
            margin-bottom: 10px;
            overflow-wrap: anywhere;
        }

        .description {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.8;
            margin-bottom: 22px;
            flex-grow: 1;
            overflow-wrap: anywhere;
        }

        .service-info {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 11px 0;
            border-top: 1px solid #f0f3f1;
            color: var(--muted);
            font-size: 13px;
        }

        .service-info strong {
            color: var(--text);
            font-weight: 600;
        }

        .service-bottom {
            margin-top: 17px;
        }

        .price-label {
            color: var(--muted);
            font-size: 12px;
            margin-bottom: 3px;
        }

        .price {
            color: var(--green-dark);
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin-bottom: 17px;
        }

        .detail-button {
            display: block;
            width: 100%;
            text-align: center;
            padding: 12px 16px;
            border-radius: 10px;
            background: var(--green);
            color: var(--white);
            font-size: 13px;
            font-weight: 700;
            transition: background 0.2s;
        }

        .detail-button:hover {
            background: var(--green-dark);
        }

        .empty-state {
            background: var(--white);
            border: 1px dashed #cbd9cf;
            border-radius: 16px;
            padding: 55px 22px;
            text-align: center;
        }

        .empty-icon {
            font-size: 38px;
            margin-bottom: 12px;
        }

        .empty-state h2 {
            font-size: 20px;
            margin-bottom: 8px;
        }

        .empty-state p {
            color: var(--muted);
            font-size: 14px;
        }

        .footer {
            text-align: center;
            padding: 23px 20px;
            border-top: 1px solid var(--border);
            color: var(--muted);
            font-size: 12px;
        }

        @media (max-width: 900px) {
            .service-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .container {
                padding-top: 42px;
            }
        }

        @media (max-width: 560px) {
            .navbar {
                padding: 17px 5%;
            }

            .logo {
                font-size: 22px;
            }

            .back-link {
                font-size: 12px;
                text-align: right;
            }

            .container {
                padding: 35px 18px 55px;
            }

            .service-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .service-card {
                padding: 22px;
            }

            .page-header h1 {
                letter-spacing: -0.5px;
            }

            .result-info {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <a href="{{ route('home') }}" class="logo">
            Home<span>Fix</span>
        </a>

        <a href="{{ route('home') }}" class="back-link">
            &larr; Kembali ke Beranda
        </a>
    </nav>

    <main class="container">

        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            &nbsp; / &nbsp; Layanan
            &nbsp; / &nbsp; {{ $category->name }}
        </div>

        <header class="page-header">
            <span class="eyebrow">LAYANAN HOMEFIX</span>

            <h1>Layanan {{ $category->name }}</h1>

            <p>
                Temukan layanan perbaikan dan perawatan rumah yang sesuai
                dengan kebutuhanmu. Pilih layanan dan lihat informasi
                harga serta estimasi waktu pengerjaan.
            </p>
        </header>

        <div class="result-info">
            <span>
                Menampilkan {{ $services->count() }} layanan
            </span>

            <span>Harga dalam Rupiah (IDR)</span>
        </div>

        @forelse ($services as $service)

            @if ($loop->first)
                <div class="service-grid">
            @endif

            <article class="service-card">

                <div class="service-icon" aria-hidden="true">
                    @php
                        $name = strtolower($service->name);

                        if (str_contains($name, 'ac')) {
                            $icon = '❄';
                        } elseif (
                            str_contains($name, 'pipa') ||
                            str_contains($name, 'keran')
                        ) {
                            $icon = '♧';
                        } elseif (
                            str_contains($name, 'lampu') ||
                            str_contains($name, 'listrik')
                        ) {
                            $icon = '☼';
                        } elseif (
                            str_contains($name, 'tv') ||
                            str_contains($name, 'elektronik') ||
                            str_contains($name, 'kulkas')
                        ) {
                            $icon = '▣';
                        } else {
                            $icon = '⌂';
                        }
                    @endphp

                    {{ $icon }}
                </div>

                <h2>{{ $service->name }}</h2>

                <p class="description">
                    {{ $service->description ?: 'Layanan perbaikan profesional untuk membantu kebutuhan rumahmu.' }}
                </p>

                <div class="service-info">
                    <span aria-hidden="true">◷</span>

                    <span>
                        Estimasi:
                        <strong>
                            @if ($service->duration)
                                {{ $service->duration }} menit
                            @else
                                Belum ditentukan
                            @endif
                        </strong>
                    </span>
                </div>

                <div class="service-bottom">
                    <p class="price-label">Mulai dari</p>

                    <p class="price">
                        Rp {{ number_format((float) $service->price, 0, ',', '.') }}
                    </p>

                    @if (auth()->check() && auth()->user()->role === 'pengguna')
                        <a
                            href="{{ route('bookings.create', ['service' => $service->id]) }}"
                            class="detail-button"
                        >
                            Pesan Layanan &rarr;
                        </a>
                    @elseif (auth()->check())
                        <a
                            href="{{ route('dashboard') }}"
                            class="detail-button"
                        >
                            Buka Dashboard &rarr;
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="detail-button"
                        >
                            Masuk untuk Memesan &rarr;
                        </a>
                    @endif
                </div>

            </article>

            @if ($loop->last)
                </div>
            @endif

        @empty

            <div class="empty-state">
                <div class="empty-icon">⌂</div>

                <h2>Belum Ada Layanan</h2>

                <p>
                    Saat ini belum ada layanan aktif dalam kategori
                    {{ $category->name }}.
                    Silakan cek kembali nanti.
                </p>
            </div>

        @endforelse

    </main>

    <footer class="footer">
        &copy; {{ date('Y') }} HomeFix. Solusi Perawatan Rumah Lebih Mudah.
    </footer>

</body>
</html>
