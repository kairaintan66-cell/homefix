
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Teknisi - HomeFix</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">

<div class="min-h-screen lg:flex">

    {{-- Sidebar Admin --}}
    @include('admin.partials.sidebar', ['active' => 'technicians'])

    {{-- Konten Utama --}}
    <main class="min-w-0 flex-1 lg:ml-64">

        {{-- Header --}}
        <header class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-200 bg-white px-5 py-5 sm:px-8">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-emerald-700">
                    HomeFix / Manajemen
                </p>
                <h1 class="mt-2 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                    Manajemen Teknisi
                </h1>
                <p class="mt-1 text-sm text-slate-500">
                    Kelola akun, informasi, dan ketersediaan teknisi HomeFix.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <div class="hidden text-right sm:block">
                    <p class="text-sm font-semibold text-slate-800">
                        {{ auth()->user()->name ?? 'Administrator' }}
                    </p>
                    <p class="text-xs text-slate-500">Administrator</p>
                </div>

                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-emerald-100 font-bold text-emerald-800">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
            </div>
        </header>

        <div class="space-y-6 p-4 sm:p-6 lg:p-8">

            {{-- Notifikasi --}}
            @if (session('success'))
                <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <p class="font-semibold">Data belum dapat diproses:</p>
                    <ul class="mt-2 list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Statistik --}}
            <section class="grid grid-cols-1 gap-4 sm:grid-cols-3">

                <article class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Total Teknisi</p>
                    <div class="mt-3 flex items-center justify-between">
                        <h2 class="text-3xl font-bold text-slate-900">
                            {{ $technicians->total() }}
                        </h2>
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-100 text-xl text-emerald-700">
                            ⚒
                        </span>
                    </div>
                    <p class="mt-2 text-xs text-slate-400">Jumlah seluruh data teknisi</p>
                </article>

                <article class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Tersedia</p>
                    <div class="mt-3 flex items-center justify-between">
                        <h2 class="text-3xl font-bold text-emerald-700">
                            {{ (clone $technicians)->getCollection()->where('is_available', true)->count() }}
                        </h2>
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-100 text-xl font-bold text-emerald-700">
                            ✓
                        </span>
                    </div>
                    <p class="mt-2 text-xs text-slate-400">Teknisi pada halaman ini</p>
                </article>

                <article class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Terverifikasi</p>
                    <div class="mt-3 flex items-center justify-between">
                        <h2 class="text-3xl font-bold text-teal-700">
                            {{ (clone $technicians)->getCollection()->where('is_verified', true)->count() }}
                        </h2>
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-teal-100 text-xl font-bold text-teal-700">
                            ✓
                        </span>
                    </div>
                    <p class="mt-2 text-xs text-slate-400">Teknisi pada halaman ini</p>
                </article>

            </section>

            {{-- Daftar Teknisi --}}
            <section class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm">

                <div class="flex flex-col gap-4 border-b border-slate-100 p-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">Daftar Teknisi</h2>
                        <p class="mt-1 text-sm text-slate-500">
                            Kelola akun dan informasi teknisi HomeFix.
                        </p>
                    </div>

                    <a href="{{ route('admin.technicians.create') }}"
                       class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-700 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-800">
                        <span class="text-lg">+</span>
                        Tambah Teknisi
                    </a>
                </div>

                {{-- Pencarian --}}
                <div class="border-b border-slate-100 p-5">
                    <form action="{{ route('admin.technicians.index') }}"
                          method="GET"
                          class="flex flex-col gap-3 sm:flex-row">

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari nama atau email teknisi..."
                            aria-label="Cari teknisi"
                            class="min-w-0 flex-1 rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100"
                        >

                        <button type="submit"
                                class="rounded-xl bg-emerald-700 px-6 py-3 text-sm font-semibold text-white transition hover:bg-emerald-800">
                            Cari
                        </button>

                        @if (request('search'))
                            <a href="{{ route('admin.technicians.index') }}"
                               class="rounded-xl border border-slate-200 px-5 py-3 text-center text-sm font-medium text-slate-600 transition hover:bg-slate-50">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>

                {{-- Tabel Teknisi --}}
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[850px] text-left text-sm">

                        <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                            <tr>
                                <th class="px-6 py-4 font-semibold">Teknisi</th>
                                <th class="px-6 py-4 font-semibold">Telepon</th>
                                <th class="px-6 py-4 font-semibold">Ketersediaan</th>
                                <th class="px-6 py-4 font-semibold">Verifikasi</th>
                                <th class="px-6 py-4 text-right font-semibold">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">

                            @forelse ($technicians as $technician)
                                <tr class="transition hover:bg-emerald-50/40">

                                    {{-- Identitas --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-full bg-emerald-100 font-bold text-emerald-800">
                                                {{ strtoupper(substr($technician->user->name ?? '?', 0, 1)) }}
                                            </div>

                                            <div>
                                                <p class="font-semibold text-slate-900">
                                                    {{ $technician->user->name ?? 'Akun tidak ditemukan' }}
                                                </p>
                                                <p class="mt-1 text-xs text-slate-500">
                                                    {{ $technician->user->email ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Telepon --}}
                                    <td class="whitespace-nowrap px-6 py-4 text-slate-600">
                                        {{ $technician->phone ?: '-' }}
                                    </td>

                                    

                                    {{-- Ketersediaan --}}
                                    <td class="px-6 py-4">
                                        @if ($technician->is_available)
                                            <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1.5 text-xs font-semibold text-emerald-700">
                                                Tersedia
                                            </span>
                                        @else
                                            <span class="inline-flex rounded-full bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-600">
                                                Tidak tersedia
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Verifikasi --}}
                                    <td class="px-6 py-4">
                                        @if ($technician->is_verified)
                                            <span class="inline-flex rounded-full bg-teal-100 px-3 py-1.5 text-xs font-semibold text-teal-700">
                                                Terverifikasi
                                            </span>
                                        @else
                                            <span class="inline-flex rounded-full bg-amber-100 px-3 py-1.5 text-xs font-semibold text-amber-700">
                                                Belum diverifikasi
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-2">

                                            <a href="{{ route('admin.technicians.edit', $technician) }}"
                                               class="rounded-lg border border-emerald-200 px-3 py-2 text-xs font-semibold text-emerald-700 transition hover:bg-emerald-50">
                                                Edit
                                            </a>

                                            <form
                                                action="{{ route('admin.technicians.destroy', $technician) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus teknisi ini?')"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="rounded-lg border border-red-200 px-3 py-2 text-xs font-semibold text-red-600 transition hover:bg-red-50"
                                                >
                                                    Hapus
                                                </button>
                                            </form>

                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-14 text-center">
                                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-50 text-2xl">
                                            ⚒
                                        </div>

                                        <p class="mt-4 font-semibold text-slate-800">
                                            Belum ada data teknisi
                                        </p>

                                        <p class="mt-1 text-sm text-slate-500">
                                            Tambahkan teknisi baru atau ubah kata pencarian.
                                        </p>

                                        @if (request('search'))
                                            <a href="{{ route('admin.technicians.index') }}"
                                               class="mt-4 inline-flex font-semibold text-emerald-700 hover:text-emerald-900">
                                                Tampilkan semua teknisi
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($technicians->hasPages())
                    <div class="border-t border-slate-100 px-5 py-4 sm:px-6">
                        {{ $technicians->appends(request()->query())->links() }}
                    </div>
                @endif

            </section>

            {{-- Footer --}}
            <footer class="py-4 text-center text-xs text-slate-400">
                &copy; {{ date('Y') }} HomeFix. Solusi perawatan rumah yang praktis.
            </footer>

        </div>
    </main>
</div>

</body>
</html>
