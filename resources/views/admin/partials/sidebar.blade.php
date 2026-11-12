
@php
    $active = $active ?? '';
    $namaAdmin = auth()->user()->name ?? 'Administrator';

    $menu = [
        [
            'key' => 'dashboard',
            'label' => 'Dashboard',
            'route' => 'admin.dashboard',
            'icon' => 'dashboard',
        ],
        [
            'key' => 'customers',
            'label' => 'Pelanggan',
            'route' => 'admin.customers.index',
            'icon' => 'users',
        ],
        [
            'key' => 'technicians',
            'label' => 'Teknisi',
            'route' => 'admin.technicians.index',
            'icon' => 'tools',
        ],
        [
            'key' => 'services',
            'label' => 'Manajemen Layanan',
            'route' => 'admin.services.index',
            'icon' => 'services',
        ],
        [
            'key' => 'bookings',
            'label' => 'Booking',
            'route' => 'admin.bookings.index',
            'icon' => 'calendar',
        ],
        [
            'key' => 'payments',
            'label' => 'Pembayaran',
            'route' => 'admin.payments.index',
            'icon' => 'payments',
        ],
        [
            'key' => 'reports',
            'label' => 'Laporan',
            'route' => 'admin.reports.index',
            'icon' => 'reports',
        ],
    ];
@endphp

<aside class="hf-sidebar">

    <div class="hf-sidebar-brand">
        <a href="{{ route('admin.dashboard') }}"
           class="hf-brand-icon"
           aria-label="HomeFix Dashboard">

            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m3 10 9-7 9 7"/>
                <path d="M5 9v11h14V9"/>
                <path d="M9 20v-6h6v6"/>
            </svg>
        </a>

        <div class="hf-brand-text">
            <a href="{{ route('admin.dashboard') }}" class="hf-brand-name">
                Home<span>Fix</span>
            </a>
            <p>Admin Panel</p>
        </div>
    </div>

    <nav class="hf-sidebar-nav" aria-label="Navigasi admin">

        <p class="hf-nav-heading">MENU UTAMA</p>

        @foreach ($menu as $item)

            <a
                href="{{ route($item['route']) }}"
                class="hf-nav-link {{ $active === $item['key'] ? 'is-active' : '' }}"
                @if ($active === $item['key']) aria-current="page" @endif
            >

                @if ($item['icon'] === 'dashboard')

                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7" rx="1"/>
                        <rect x="14" y="3" width="7" height="7" rx="1"/>
                        <rect x="14" y="14" width="7" height="7" rx="1"/>
                        <rect x="3" y="14" width="7" height="7" rx="1"/>
                    </svg>

                @elseif ($item['icon'] === 'users')

                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="10" cy="7" r="4"/>
                        <path d="M20 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>

                @elseif ($item['icon'] === 'tools')

                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14.7 6.3a5 5 0 0 0-6.4 6.4L3 18l3 3 5.3-5.3a5 5 0 0 0 6.4-6.4L14 13l-3-3 3.7-3.7Z"/>
                    </svg>

                @elseif ($item['icon'] === 'services')

                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14.7 6.3a5 5 0 0 0-6.4 6.4L3 18l3 3 5.3-5.3a5 5 0 0 0 6.4-6.4L14 13l-3-3 3.7-3.7Z"/>
                        <path d="m15 5 4 4"/>
                    </svg>

                @elseif ($item['icon'] === 'calendar')

                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="5" width="18" height="16" rx="2"/>
                        <path d="M16 3v4M8 3v4M3 10h18"/>
                    </svg>

                @elseif ($item['icon'] === 'payments')

                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="5" width="20" height="14" rx="2"/>
                        <path d="M2 10h20"/>
                        <path d="M6 15h4"/>
                    </svg>

                @elseif ($item['icon'] === 'reports')

                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 19V5"/>
                        <path d="M4 19h17"/>
                        <rect x="7" y="11" width="3" height="5" rx="0.5"/>
                        <rect x="13" y="7" width="3" height="9" rx="0.5"/>
                        <rect x="19" y="9" width="2" height="7" rx="0.5"/>
                    </svg>

                @endif

                <span>{{ $item['label'] }}</span>

                @if ($active === $item['key'])
                    <span class="hf-active-indicator"></span>
                @endif

            </a>

        @endforeach

    </nav>

    <div class="hf-sidebar-bottom">

        <div class="hf-admin-profile">

            <div class="hf-admin-avatar">
                {{ strtoupper(substr($namaAdmin, 0, 1)) }}
            </div>

            <div class="hf-admin-info">
                <p>{{ $namaAdmin }}</p>
                <span>Administrator</span>
            </div>

        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button type="submit" class="hf-logout-button">

                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                    <path d="m16 17 5-5-5-5"/>
                    <path d="M21 12H9"/>
                </svg>

                <span>Keluar dari Akun</span>

            </button>
        </form>

        <p class="hf-sidebar-version">
            HOMEFIX ADMIN · {{ date('Y') }}
        </p>

    </div>

</aside>
