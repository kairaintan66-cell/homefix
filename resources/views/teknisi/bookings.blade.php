
@extends('teknisi.layout')

@section('title', 'Pesanan Saya')
@section('heading', 'Pesanan Saya')

@section('content')

<section class="panel">

    <div class="panel-head">
        <div>
            <h2>Daftar Pesanan</h2>
            <p>Lihat pesanan pelanggan dan kelola proses pengerjaan layanan.</p>
        </div>

        <span class="count-pill">
            {{ $bookings->total() }} pesanan
        </span>
    </div>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    {{-- Informasi status teknisi --}}
    @if(!$technician)

        <div class="alert alert-danger">
            <strong>Profil Teknisi Belum Tersedia</strong>
            <p>Silakan hubungi Admin HomeFix untuk melengkapi profil teknisi.</p>
        </div>

    @elseif(!$technician->is_verified)

        <div class="alert alert-warning">
            <strong>Akun Belum Diverifikasi</strong>
            <p>
                Akun Anda sedang menunggu pemeriksaan Admin.
                Anda belum dapat melihat, menerima, atau mengelola pesanan
                sampai proses verifikasi selesai.
            </p>
        </div>

    @elseif(!$technician->is_available)

        <div class="alert alert-warning">
            <strong>Status Teknisi Tidak Tersedia</strong>
            <p>
                Akun Anda sudah diverifikasi, tetapi saat ini belum tersedia
                untuk menerima pesanan baru. Pesanan yang sudah menjadi
                tanggung jawab Anda tetap dapat dikelola.
            </p>
        </div>

    @else

        <div class="alert alert-success">
            <strong>Anda Siap Menerima Pesanan</strong>
            <p>
                Akun telah diverifikasi dan status ketersediaan aktif.
                Anda dapat menerima pesanan pelanggan yang tersedia.
            </p>
        </div>

    @endif

    @if($bookings->count())

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Kode Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Layanan</th>
                        <th>Jadwal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($bookings as $booking)

                        @php
                            $labels = [
                                'menunggu' => 'Menunggu',
                                'dikonfirmasi' => 'Diterima',
                                'diproses' => 'Diproses',
                                'sedang_dikerjakan' => 'Sedang Dikerjakan',
                                'selesai' => 'Selesai',
                                'dibatalkan' => 'Dibatalkan',
                            ];

                            $serviceNames = $booking->details
                                ->map(fn($detail) => $detail->service?->name)
                                ->filter()
                                ->unique()
                                ->implode(', ');

                            $isUnassigned = $booking->technician_id === null;

                            $isMyBooking = !$isUnassigned &&
                                (int) $booking->technician_id === (int) ($technician?->id);

                            $priceStatus = $booking->price_status ?? 'belum_diisi';

                            $canSubmitPrice = in_array(
                                $priceStatus,
                                ['belum_diisi', 'ditolak'],
                                true
                            );

                        @endphp

                        <tr>

                            {{-- Kode Pesanan --}}
                            <td>
                                <span class="booking-code">
                                    {{ $booking->booking_code }}
                                </span>

                                <span class="subtext">
                                    {{ $booking->notes
                                        ? \Illuminate\Support\Str::limit($booking->notes, 55)
                                        : 'Tidak ada catatan' }}
                                </span>
                            </td>

                            {{-- Pelanggan --}}
                            <td>
                                <span class="customer">
                                    {{ $booking->user?->name ?? 'Pelanggan' }}
                                </span>

                                <span class="subtext">
                                    {{ $booking->address?->address
                                        ?? $booking->address?->city
                                        ?? 'Alamat belum tersedia' }}
                                </span>

                                <span class="subtext">
                                    {{ $booking->address?->phone ?? '-' }}
                                </span>
                            </td>

                            {{-- Layanan --}}
                            <td>
                                {{ $serviceNames ?: 'Layanan HomeFix' }}
                            </td>

                            {{-- Jadwal --}}
                            <td>
                                {{ $booking->booking_date
                                    ? \Illuminate\Support\Carbon::parse($booking->booking_date)->format('d/m/Y')
                                    : '-' }}

                                <span class="subtext">
                                    {{ $booking->booking_time
                                        ? \Illuminate\Support\Carbon::parse($booking->booking_time)->format('H:i')
                                        : '-' }} WIB
                                </span>
                            </td>

                            {{-- Total --}}
                            <td>
                                <span class="price">
                                    Rp {{ number_format((float) $booking->total_price, 0, ',', '.') }}
                                </span>
                            </td>

                            {{-- Status --}}
                            <td>
                                <span class="status {{ $booking->status }}">
                                    {{ $labels[$booking->status]
                                        ?? ucfirst(str_replace('_', ' ', $booking->status)) }}
                                </span>

                                @if($isUnassigned && $booking->status === 'menunggu')
                                    <span class="subtext">
                                        Menunggu teknisi
                                    </span>
                                @endif

                                @if($isMyBooking && $booking->status === 'dikonfirmasi')

                                    @if($priceStatus === 'menunggu_persetujuan')
                                        <span class="subtext" style="color:#d97706;">
                                            Menunggu persetujuan biaya
                                        </span>
                                    @elseif($priceStatus === 'disetujui')
                                        <span class="subtext" style="color:#15803d;">
                                            Biaya disetujui pelanggan
                                        </span>
                                    @elseif($priceStatus === 'ditolak')
                                        <span class="subtext" style="color:#dc2626;">
                                            Biaya ditolak, perlu diperbaiki
                                        </span>
                                    @else
                                        <span class="subtext">
                                            Belum ada rincian biaya
                                        </span>
                                    @endif

                                @endif
                            </td>

                            {{-- Tindakan --}}
                            <td>

                                {{-- Booking belum diambil --}}
                                @if(
                                    $technician &&
                                    $technician->is_verified &&
                                    $technician->is_available &&
                                    $isUnassigned &&
                                    $booking->status === 'menunggu'
                                )

                                    <div class="flex flex-col gap-2">

                                        {{-- Terima --}}
                                        <form
                                            method="POST"
                                            action="{{ route('teknisi.pesanan.status', $booking) }}"
                                            onsubmit="return confirm('Yakin ingin menerima pesanan ini?')"
                                        >
                                            @csrf
                                            @method('PATCH')

                                            <input type="hidden" name="status" value="dikonfirmasi">

                                            <button type="submit" class="btn small">
                                                Terima
                                            </button>
                                        </form>

                                        {{-- Batalkan --}}
                                        <form
                                            method="POST"
                                            action="{{ route('teknisi.pesanan.status', $booking) }}"
                                            onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')"
                                        >
                                            @csrf
                                            @method('PATCH')

                                            <input type="hidden" name="status" value="dibatalkan">

                                            <button
                                                type="submit"
                                                class="btn small"
                                                style="background:#dc2626;"
                                            >
                                                Batalkan
                                            </button>
                                        </form>

                                    </div>

                                {{-- Form rincian biaya setelah booking diterima --}}
                                @elseif(
                                    $isMyBooking &&
                                    $booking->status === 'dikonfirmasi' &&
                                    $canSubmitPrice
                                )

                                    <div style="min-width:230px;">

                                        <form
                                            method="POST"
                                            action="{{ route('teknisi.pesanan.harga', $booking) }}"
                                            class="price-form"
                                            data-price-form
                                            onsubmit="return confirm('Kirim rincian biaya ini kepada pelanggan?')"
                                        >
                                            @csrf
                                            @method('PATCH')

                                            <strong style="display:block; margin-bottom:10px;">
                                                Rincian Biaya Pemeriksaan
                                            </strong>

                                            <label style="display:block; margin-bottom:5px;">
                                                Biaya Jasa (Rp)
                                            </label>

                                            <input
                                                type="number"
                                                name="service_cost"
                                                class="price-input"
                                                min="0"
                                                step="1"
                                                value="{{ old('service_cost', $booking->service_cost ?? 0) }}"
                                                required
                                                style="width:100%; margin-bottom:10px;"
                                            >

                                            <label style="display:block; margin-bottom:5px;">
                                                Biaya Material (Rp)
                                            </label>

                                            <input
                                                type="number"
                                                name="material_cost"
                                                class="price-input"
                                                min="0"
                                                step="1"
                                                value="{{ old('material_cost', $booking->material_cost ?? 0) }}"
                                                style="width:100%; margin-bottom:10px;"
                                            >

                                            <label style="display:block; margin-bottom:5px;">
                                                Biaya Tambahan (Rp)
                                            </label>

                                            <input
                                                type="number"
                                                name="additional_cost"
                                                class="price-input"
                                                min="0"
                                                step="1"
                                                value="{{ old('additional_cost', $booking->additional_cost ?? 0) }}"
                                                style="width:100%; margin-bottom:10px;"
                                            >

                                            <label style="display:block; margin-bottom:5px;">
                                                Total Biaya (Rp)
                                            </label>

                                            <input
                                                type="text"
                                                class="total-price-input"
                                                value="Rp 0"
                                                readonly
                                                style="width:100%; margin-bottom:10px; background:#f0fdf4; font-weight:bold;"
                                            >

                                            <label style="display:block; margin-bottom:5px;">
                                                Catatan Pemeriksaan
                                            </label>

                                            <textarea
                                                name="inspection_notes"
                                                rows="3"
                                                placeholder="Jelaskan hasil pemeriksaan dan kebutuhan perbaikan..."
                                                style="width:100%; margin-bottom:10px;"
                                            >{{ old('inspection_notes', $booking->inspection_notes) }}</textarea>

                                            <button
                                                type="submit"
                                                class="btn small"
                                                style="background:#15803d; width:100%;"
                                            >
                                                Kirim Rincian Biaya
                                            </button>

                                        </form>

                                    </div>

                                {{-- Menunggu persetujuan pelanggan --}}
                                @elseif(
                                    $isMyBooking &&
                                    $booking->status === 'dikonfirmasi' &&
                                    $priceStatus === 'menunggu_persetujuan'
                                )

                                    <span class="subtext" style="color:#d97706;">
                                        Rincian biaya sudah dikirim.
                                        Menunggu persetujuan pelanggan.
                                    </span>

                                {{-- Pelanggan sudah menyetujui biaya --}}
                                @elseif(
                                    $isMyBooking &&
                                    in_array($booking->status, ['dikonfirmasi', 'diproses']) &&
                                    $priceStatus === 'disetujui'
                                )

                                    <form
                                        method="POST"
                                        action="{{ route('teknisi.pesanan.status', $booking) }}"
                                        onsubmit="return confirm('Mulai mengerjakan pesanan ini?')"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <input type="hidden" name="status" value="sedang_dikerjakan">

                                        <button type="submit" class="btn small">
                                            Mulai Dikerjakan
                                        </button>
                                    </form>

                                {{-- Pekerjaan sedang berlangsung --}}
                                @elseif(
                                    $isMyBooking &&
                                    $booking->status === 'sedang_dikerjakan'
                                )

                                    <form
                                        method="POST"
                                        action="{{ route('teknisi.pesanan.status', $booking) }}"
                                        onsubmit="return confirm('Apakah pekerjaan sudah benar-benar selesai?')"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <input type="hidden" name="status" value="selesai">

                                        <button type="submit" class="btn small">
                                            Tandai Selesai
                                        </button>
                                    </form>

                                @else

                                    <span class="subtext">
                                        Tidak ada tindakan
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($bookings->hasPages())
            <div class="pagination">
                {{ $bookings->links() }}
            </div>
        @endif

    @else

        <div class="empty">
            <div class="empty-icon">📋</div>

            <strong>
                @if(!$technician || !$technician->is_verified)
                    Menunggu Verifikasi Admin
                @else
                    Belum Ada Pesanan
                @endif
            </strong>

            <p>
                @if(!$technician || !$technician->is_verified)
                    Pesanan akan tersedia setelah akun teknisi diverifikasi oleh Admin.
                @elseif(!$technician->is_available)
                    Belum ada pesanan yang menjadi tanggung jawab Anda.
                    Aktifkan ketersediaan melalui pengaturan Admin untuk menerima pesanan baru.
                @else
                    Booking pelanggan yang belum diambil atau sudah ditugaskan
                    kepada Anda akan tampil di sini.
                @endif
            </p>
        </div>

    @endif

</section>

{{-- JavaScript perhitungan otomatis total biaya --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('[data-price-form]').forEach(function (form) {

        const serviceInput = form.querySelector('[name="service_cost"]');
        const materialInput = form.querySelector('[name="material_cost"]');
        const additionalInput = form.querySelector('[name="additional_cost"]');
        const totalInput = form.querySelector('.total-price-input');

        function calculateTotal() {

            const service = Number(serviceInput.value) || 0;
            const material = Number(materialInput.value) || 0;
            const additional = Number(additionalInput.value) || 0;

            const total = service + material + additional;

            totalInput.value = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        }

        serviceInput.addEventListener('input', calculateTotal);
        materialInput.addEventListener('input', calculateTotal);
        additionalInput.addEventListener('input', calculateTotal);

        calculateTotal();

    });

});
</script>

@endsection
