<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Layanan - HomeFix</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-50 text-gray-800">

    {{-- Navbar --}}
    <nav class="border-b border-gray-100 bg-white">
        <div class="mx-auto flex max-w-5xl items-center justify-between px-5 py-4">

            <a href="{{ route('home') }}" class="text-2xl font-bold text-emerald-700">
                HomeFix<span class="text-emerald-500">.</span>
            </a>

            <a href="{{ route('pengguna.dashboard') }}"
               class="inline-flex items-center gap-2 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2.5 text-sm font-semibold text-emerald-700 transition hover:bg-emerald-100">
                <span>←</span>
                Kembali ke Dashboard
            </a>

        </div>
    </nav>

    <main class="mx-auto max-w-5xl px-5 py-10">

        {{-- Header --}}
        <div class="mb-8">
            <p class="mb-2 text-sm font-semibold uppercase tracking-wider text-emerald-700">
                Pemesanan Layanan
            </p>

            <h1 class="text-3xl font-bold text-gray-900">
                Pesan Layanan HomeFix
            </h1>

            <p class="mt-2 text-gray-500">
                Lengkapi formulir berikut untuk membuat pesanan layanan.
            </p>
        </div>

        {{-- Pesan Error --}}
        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                <p class="mb-2 font-semibold">Periksa kembali data berikut:</p>

                <ul class="list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid gap-8 md:grid-cols-3">

            {{-- Form Pemesanan --}}
            <section class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm md:col-span-2">

                <form action="{{ route('bookings.store', ['service' => $service->id]) }}" method="POST">
                    @csrf

                    {{-- Informasi Pemesan --}}
                    <h2 class="mb-5 text-lg font-bold">
                        Informasi Pemesan
                    </h2>

                    <div class="mb-4">
                        <label for="recipient_name" class="mb-2 block text-sm font-medium">
                            Nama Penerima
                        </label>

                        <input
                            id="recipient_name"
                            name="recipient_name"
                            type="text"
                            value="{{ old('recipient_name', auth()->user()->name) }}"
                            required
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                    </div>

                    <div class="mb-4">
                        <label for="phone" class="mb-2 block text-sm font-medium">
                            Nomor Telepon
                        </label>

                        <input
                            id="phone"
                            name="phone"
                            type="tel"
                            value="{{ old('phone') }}"
                            required
                            placeholder="Contoh: 081234567890"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                    </div>

                    <div class="mb-4">
                        <label for="address" class="mb-2 block text-sm font-medium">
                            Alamat Lengkap
                        </label>

                        <textarea
                            id="address"
                            name="address"
                            rows="3"
                            required
                            placeholder="Nama jalan, nomor rumah, RT/RW, dan patokan"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-100">{{ old('address') }}</textarea>
                    </div>

                    <div class="mb-6">
                        <label for="city" class="mb-2 block text-sm font-medium">
                            Kota/Kabupaten
                        </label>

                        <input
                            id="city"
                            name="city"
                            type="text"
                            value="{{ old('city') }}"
                            required
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                    </div>

                    <div class="mb-8">
                        <label for="postal_code" class="mb-2 block text-sm font-medium">
                            Kode Pos
                            <span class="font-normal text-gray-400">(Opsional)</span>
                        </label>

                        <input
                            id="postal_code"
                            name="postal_code"
                            type="text"
                            value="{{ old('postal_code') }}"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                    </div>

                    <hr class="mb-8 border-gray-100">

                    {{-- Jadwal Pengerjaan --}}
                    <h2 class="mb-5 text-lg font-bold">
                        Jadwal Pengerjaan
                    </h2>

                    <div class="mb-4 grid gap-4 sm:grid-cols-2">

                        <div>
                            <label for="booking_date" class="mb-2 block text-sm font-medium">
                                Tanggal
                            </label>

                            <input
                                id="booking_date"
                                name="booking_date"
                                type="date"
                                min="{{ date('Y-m-d') }}"
                                value="{{ old('booking_date') }}"
                                required
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                        </div>

                        <div>
                            <label for="booking_time" class="mb-2 block text-sm font-medium">
                                Waktu
                            </label>

                            <input
                                id="booking_time"
                                name="booking_time"
                                type="time"
                                value="{{ old('booking_time') }}"
                                required
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                        </div>

                    </div>

                    <div class="mb-8">
                        <label for="notes" class="mb-2 block text-sm font-medium">
                            Catatan
                            <span class="font-normal text-gray-400">(Opsional)</span>
                        </label>

                        <textarea
                            id="notes"
                            name="notes"
                            rows="3"
                            placeholder="Jelaskan kendala atau detail tambahan"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-100">{{ old('notes') }}</textarea>
                    </div>

                    <hr class="mb-8 border-gray-100">

                    {{-- Tombol Pesan --}}
                    <button
                        type="submit"
                        class="w-full rounded-xl bg-emerald-700 px-6 py-3.5 font-semibold text-white transition hover:bg-emerald-800">
                        Buat Pesanan
                    </button>

                </form>
            </section>

            {{-- Ringkasan Pesanan --}}
            <aside class="h-fit rounded-2xl border border-emerald-100 bg-white p-6 shadow-sm">

                <h2 class="mb-5 text-lg font-bold">
                    Ringkasan Pesanan
                </h2>

                <p class="mb-2 text-sm text-gray-500">
                    Layanan yang dipilih
                </p>

                <h3 class="text-xl font-bold text-gray-900">
                    {{ $service->name }}
                </h3>

                <div class="my-5 border-t border-gray-100"></div>

                <div class="mb-4 flex items-center justify-between gap-3 text-sm">
                    <span class="text-gray-500">Estimasi durasi</span>

                    <span class="font-medium">
                        {{ $service->duration }} menit
                    </span>
                </div>

                <div class="mb-5">
                    <span class="text-gray-600">Total biaya</span>

                    <p class="mt-2 text-xl font-bold text-emerald-700">
                        Menunggu pemeriksaan
                    </p>
                </div>

                <div class="rounded-xl bg-emerald-50 p-4 text-sm leading-relaxed text-emerald-800">
                    Biaya layanan akan ditentukan oleh teknisi setelah melakukan pemeriksaan.
                    Kamu dapat melihat rincian biaya dan menyetujuinya sebelum pengerjaan dimulai.
                </div>

            </aside>

        </div>
    </main>

    {{-- Footer --}}
    <footer class="mt-10 border-t border-gray-100 bg-white py-5 text-center text-sm text-gray-500">
        &copy; {{ date('Y') }} HomeFix. Solusi perawatan rumah yang praktis.
    </footer>

</body>
</html>