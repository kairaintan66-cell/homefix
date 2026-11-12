
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pelanggan - HomeFix</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">

<div class="min-h-screen lg:flex">

    {{-- Sidebar Admin --}}
    @include('admin.partials.sidebar', ['active' => 'customers'])

    {{-- Konten Utama --}}
    <main class="min-w-0 flex-1 px-4 py-6 sm:px-6 lg:ml-64 lg:px-8 lg:py-8">

        {{-- Header --}}
        <header class="mb-7 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-emerald-700">
                    HomeFix / Admin
                </p>

                <h1 class="mt-2 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                    Manajemen Pelanggan
                </h1>

                <p class="mt-2 text-sm text-slate-500">
                    Kelola akun pelanggan yang terdaftar di HomeFix.
                </p>
            </div>

            <a href="{{ route('admin.customers.create') }}"
               class="inline-flex items-center justify-center gap-2 self-start rounded-xl bg-emerald-700 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-800 sm:self-auto">
                <span class="text-lg">+</span>
                Tambah Pelanggan
            </a>
        </header>

        {{-- Notifikasi --}}
        @if (session('success'))
            <div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                <p class="font-semibold">Periksa kembali data yang dimasukkan.</p>
                <ul class="mt-2 list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Daftar Pelanggan --}}
        <section class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm">

            {{-- Judul dan Pencarian --}}
            <div class="flex flex-col gap-4 border-b border-slate-100 p-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                <div>
                    <h2 class="font-bold text-slate-900">
                        Daftar Pelanggan
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        {{ $customers->total() }} pelanggan terdaftar
                    </p>
                </div>

                <form method="GET"
                      action="{{ route('admin.customers.index') }}"
                      class="flex w-full gap-2 sm:w-auto">

                    <input
                        type="text"
                        name="search"
                        value="{{ $search ?? '' }}"
                        placeholder="Cari nama atau email..."
                        aria-label="Cari pelanggan berdasarkan nama atau email"
                        class="min-w-0 flex-1 rounded-xl border border-slate-300 px-3 py-2.5 text-sm outline-none transition focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100 sm:w-64 sm:flex-none"
                    >

                    <button
                        type="submit"
                        class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                    >
                        Cari
                    </button>

                    @if (request('search'))
                        <a href="{{ route('admin.customers.index') }}"
                           class="rounded-xl border border-slate-200 px-3 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            {{-- Tabel --}}
            <div class="overflow-x-auto">
                <table class="w-full min-w-[760px] text-left text-sm">

                    <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-5 py-4 font-semibold sm:px-6">
                                Pelanggan
                            </th>
                            <th class="px-5 py-4 font-semibold">
                                Email
                            </th>
                            <th class="px-5 py-4 font-semibold">
                                Total Booking
                            </th>
                            <th class="px-5 py-4 font-semibold">
                                Terdaftar
                            </th>
                            <th class="px-5 py-4 text-right font-semibold">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse ($customers as $customer)
                            <tr class="transition hover:bg-slate-50/70">

                                {{-- Informasi Pelanggan --}}
                                <td class="px-5 py-4 sm:px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-emerald-100 font-bold text-emerald-800">
                                            {{ strtoupper(substr($customer->name ?? 'P', 0, 1)) }}
                                        </div>

                                        <div>
                                            <p class="font-semibold text-slate-900">
                                                {{ $customer->name }}
                                            </p>

                                            <p class="mt-1 text-xs text-slate-500">
                                                ID #{{ $customer->id }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Email --}}
                                <td class="px-5 py-4 text-slate-600">
                                    {{ $customer->email }}
                                </td>

                                {{-- Total Booking --}}
                                <td class="px-5 py-4">
                                    <span class="inline-flex rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                                        {{ $customer->bookings_count ?? 0 }} booking
                                    </span>
                                </td>

                                {{-- Tanggal Terdaftar --}}
                                <td class="whitespace-nowrap px-5 py-4 text-slate-600">
                                    {{ $customer->created_at?->format('d M Y') ?? '-' }}
                                </td>

                                {{-- Aksi --}}
                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-end gap-3">

                                        <a
                                            href="{{ route('admin.customers.edit', $customer) }}"
                                            class="font-semibold text-emerald-700 transition hover:text-emerald-900"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route('admin.customers.destroy', $customer) }}"
                                            onsubmit="return confirm('Yakin ingin menghapus pelanggan ini?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="font-semibold text-red-600 transition hover:text-red-800"
                                            >
                                                Hapus
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-14 text-center">

                                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-2xl text-slate-400">
                                        ♙
                                    </div>

                                    <p class="mt-4 font-semibold text-slate-700">
                                        Belum ada pelanggan
                                    </p>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Data pelanggan dengan role pengguna akan tampil di sini.
                                    </p>

                                    @if (request('search'))
                                        <a href="{{ route('admin.customers.index') }}"
                                           class="mt-4 inline-flex font-semibold text-emerald-700 hover:text-emerald-900">
                                            Tampilkan semua pelanggan
                                        </a>
                                    @endif

                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($customers->hasPages())
                <div class="border-t border-slate-100 px-5 py-4 sm:px-6">
                    {{ $customers->appends(request()->query())->links() }}
                </div>
            @endif

        </section>

        {{-- Footer --}}
        <footer class="py-6 text-center text-xs text-slate-400">
            &copy; {{ date('Y') }} HomeFix. Solusi perawatan rumah yang praktis.
        </footer>

    </main>
</div>

</body>
</html>
