<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kategori - HomeFix</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-800">

@include('admin.partials.sidebar', ['active' => 'categories'])

<main class="hf-admin-content">
    <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
        <div>
            <p class="mb-1 text-sm font-medium text-emerald-700">Manajemen</p>
            <h1 class="text-3xl font-bold text-slate-900">Kategori Layanan</h1>
            <p class="mt-2 text-sm text-slate-500">
                Kelola kategori layanan yang tersedia di HomeFix.
            </p>
        </div>

        <a href="{{ route('admin.categories.create') }}"
           class="rounded-xl bg-emerald-700 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-800">
            + Tambah Kategori
        </a>
    </div>

    @if (session('success'))
        <div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-7 grid grid-cols-1 gap-4 sm:grid-cols-3">
        <div class="hf-stat-card">
            <p class="hf-stat-label">Total Kategori</p>
            <p class="hf-stat-value">{{ $totalKategori }}</p>
            <p class="hf-stat-description">Semua kategori terdaftar</p>
        </div>
        <div class="hf-stat-card">
            <p class="hf-stat-label">Kategori Aktif</p>
            <p class="hf-stat-value text-emerald-700">{{ $kategoriAktif }}</p>
            <p class="hf-stat-description">Ditampilkan untuk pelanggan</p>
        </div>
        <div class="hf-stat-card">
            <p class="hf-stat-label">Kategori Nonaktif</p>
            <p class="hf-stat-value text-amber-600">{{ $kategoriNonaktif }}</p>
            <p class="hf-stat-description">Tidak ditampilkan sebagai kategori aktif</p>
        </div>
    </div>

    <section class="hf-panel">
        <form method="GET" action="{{ route('admin.categories.index') }}"
              class="mb-6 flex flex-col gap-3 sm:flex-row">
            <input type="text" name="search" value="{{ $search }}"
                   placeholder="Cari nama kategori..."
                   class="min-w-0 flex-1 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100">
            <button type="submit"
                    class="rounded-xl bg-slate-800 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-900">
                Cari
            </button>
            @if ($search)
                <a href="{{ route('admin.categories.index') }}"
                   class="rounded-xl border border-slate-200 px-5 py-3 text-center text-sm font-semibold text-slate-600 hover:bg-slate-50">
                    Reset
                </a>
            @endif
        </form>

        <div class="mb-4">
            <h2 class="text-lg font-bold text-slate-900">Daftar Kategori</h2>
            <p class="mt-1 text-sm text-slate-500">Informasi kategori yang dikelola oleh admin.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[760px] text-left text-sm">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                        <th class="px-4 py-4">Kategori</th>
                        <th class="px-4 py-4">Deskripsi</th>
                        <th class="px-4 py-4">Jumlah Layanan</th>
                        <th class="px-4 py-4">Status</th>
                        <th class="px-4 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($categories as $category)
                        <tr class="transition hover:bg-slate-50">
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-3">
                                    @if ($category->image)
                                        <img src="{{ asset('storage/' . $category->image) }}"
                                             alt="{{ $category->name }}"
                                             class="h-12 w-12 rounded-xl border border-slate-100 object-cover">
                                    @else
                                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
                                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none"
                                                 stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M4 20h16M6 17V7l6-3 6 3v10M9 10h6M9 13h6"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <span class="font-semibold text-slate-800">{{ $category->name }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-slate-600">
                                <span class="block max-w-xs truncate">
                                    {{ $category->description ?: 'Tidak ada deskripsi' }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-slate-600">
                                {{ $category->services_count }} layanan
                            </td>
                            <td class="px-4 py-4">
                                @if ($category->is_active)
                                    <span class="rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700">Aktif</span>
                                @else
                                    <span class="rounded-full bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-600">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.categories.edit', $category) }}"
                                       class="rounded-lg border border-emerald-200 px-3 py-2 text-xs font-semibold text-emerald-700 hover:bg-emerald-50">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="rounded-lg border border-red-200 px-3 py-2 text-xs font-semibold text-red-600 hover:bg-red-50">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-14 text-center">
                                <p class="font-semibold text-slate-700">Belum ada kategori</p>
                                <p class="mt-2 text-sm text-slate-500">Tambahkan kategori baru atau ubah kata kunci pencarian.</p>
                                <a href="{{ route('admin.categories.create') }}"
                                   class="mt-4 inline-block font-semibold text-emerald-700 hover:underline">
                                    + Tambah kategori pertama
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-5">{{ $categories->links() }}</div>
    </section>

    <footer class="py-6 text-center text-xs text-slate-400">&copy; {{ date('Y') }} HomeFix.</footer>
</main>
</body>
</html>
