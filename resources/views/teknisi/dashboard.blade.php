@extends('teknisi.layout')
@section('title', 'Dashboard')
@section('heading', 'Dashboard')
@section('content')
<section class="welcome"><div><h2>Halo, {{ $user->name }}! 👋</h2><p>Selamat datang di panel teknisi HomeFix.<br>Kelola pesanan dan pantau pekerjaan servis kamu di sini.</p></div><div class="welcome-icon">🛠</div></section>
<section class="stats">
    <article class="stat"><div class="stat-head"><span class="stat-label">TOTAL PESANAN</span><span class="stat-icon">▤</span></div><div class="stat-number">{{ number_format($totalBooking, 0, ',', '.') }}</div><div class="stat-note">Semua pesanan yang ditugaskan</div></article>
    <article class="stat"><div class="stat-head"><span class="stat-label">MENUNGGU</span><span class="stat-icon">◷</span></div><div class="stat-number">{{ number_format($menunggu, 0, ',', '.') }}</div><div class="stat-note">Menunggu atau dikonfirmasi</div></article>
    <article class="stat"><div class="stat-head"><span class="stat-label">BERLANGSUNG</span><span class="stat-icon">⚙</span></div><div class="stat-number">{{ number_format($berlangsung, 0, ',', '.') }}</div><div class="stat-note">Sedang dalam pengerjaan</div></article>
    <article class="stat"><div class="stat-head"><span class="stat-label">SELESAI</span><span class="stat-icon">✓</span></div><div class="stat-number">{{ number_format($selesai, 0, ',', '.') }}</div><div class="stat-note">Pekerjaan berstatus selesai</div></article>
</section>
<section class="panel">
    <div class="panel-head"><div><h2>Pesanan Terbaru</h2><p>Ringkasan pesanan yang ditugaskan kepada kamu.</p></div><a class="btn" href="{{ route('teknisi.pesanan') }}">Lihat Semua</a></div>
    @if($bookings->count())
    <div class="table-wrap"><table><thead><tr><th>Kode Pesanan</th><th>Pelanggan</th><th>Layanan</th><th>Jadwal</th><th>Total</th><th>Status</th></tr></thead><tbody>
    @foreach($bookings as $booking)
        @php
            $labels = ['menunggu'=>'Menunggu','dikonfirmasi'=>'Dikonfirmasi','diproses'=>'Diproses','sedang_dikerjakan'=>'Sedang Dikerjakan','selesai'=>'Selesai','dibatalkan'=>'Dibatalkan'];
            $serviceNames = $booking->details->map(fn($detail) => $detail->service?->name)->filter()->unique()->implode(', ');
        @endphp
        <tr><td><span class="booking-code">{{ $booking->booking_code }}</span></td><td><span class="customer">{{ $booking->user?->name ?? 'Pelanggan' }}</span><span class="subtext">{{ $booking->address?->city ?? 'Alamat belum tersedia' }}</span></td><td>{{ $serviceNames ?: 'Layanan HomeFix' }}</td><td>{{ $booking->booking_date?->format('d/m/Y') ?? '-' }}<span class="subtext">{{ $booking->booking_time ? \Carbon\Carbon::parse($booking->booking_time)->format('H:i') : '-' }} WIB</span></td><td><span class="price">Rp {{ number_format((float)$booking->total_price,0,',','.') }}</span></td><td><span class="status {{ $booking->status }}">{{ $labels[$booking->status] ?? ucfirst(str_replace('_',' ',$booking->status)) }}</span></td></tr>
    @endforeach
    </tbody></table></div>
    @else<div class="empty"><div class="empty-icon">📋</div><strong>Belum ada pesanan</strong><p>Pesanan yang ditugaskan kepada kamu akan muncul di sini.</p></div>@endif
</section>
@endsection
