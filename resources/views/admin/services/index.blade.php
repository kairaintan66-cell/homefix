
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Layanan - HomeFix</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50 text-slate-800">

@include('admin.partials.sidebar', ['active' => 'services'])

<main class="hf-admin-content">

    @php
        $tab = in_array($tab ?? 'layanan', ['kategori', 'layanan'])
            ? ($tab ?? 'layanan')
            : 'layanan';
    @endphp

    <!-- HEADER -->
    <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
        <div>
            <p class="mb-1 text-sm font-medium text-emerald-700">
                Manajemen
            </p>

            <h1 class="text-3xl font-bold text-slate-900">
                Manajemen Layanan
            </h1>

            <p class="mt-2 text-sm text-slate-500">
                Kelola kategori dan layanan perbaikan rumah HomeFix.
            </p>
        </div>

        @if ($tab === 'kategori')
            <a href="{{ route('admin.categories.create') }}"
               class="rounded-xl bg-emerald-700 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-800">
                + Tambah Kategori
            </a>
        @else
            <a href="{{ route('admin.services.create') }}"
               class="rounded-xl bg-emerald-700 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-800">
                + Tambah Layanan
            </a>
        @endif
    </div>

    <!-- NOTIFIKASI -->
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

    @if ($errors->any())
        <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <p class="mb-2 font-semibold">Terjadi kesalahan:</p>
            <ul class="list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- STATISTIK -->
    <div class="mb-7 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        <div class="hf-stat-card">
            <p class="hf-stat-label">Total Kategori</p>
            <p class="hf-stat-value">{{ $totalKategori }}</p>
            <p class="hf-stat-description">Kategori terdaftar</p>
        </div>

        <div class="hf-stat-card">
            <p class="hf-stat-label">Kategori Aktif</p>
            <p class="hf-stat-value text-emerald-700">{{ $kategoriAktif }}</p>
            <p class="hf-stat-description">Kategori tersedia</p>
        </div>

        <div class="hf-stat-card">
            <p class="hf-stat-label">Total Layanan</p>
            <p class="hf-stat-value">{{ $totalLayanan }}</p>
            <p class="hf-stat-description">Semua layanan terdaftar</p>
        </div>

        <div class="hf-stat-card">
            <p class="hf-stat-label">Layanan Aktif</p>
            <p class="hf-stat-value text-emerald-700">{{ $layananAktif }}</p>
            <p class="hf-stat-description">Tersedia untuk pelanggan</p>
        </div>

    </div>

    <section class="hf-panel">

        <!-- TAB NAVIGASI -->
        <div class="mb-6 flex flex-wrap gap-2 border-b border-slate-200 pb-4">

            <a href="{{ route('admin.services.index', ['tab' => 'kategori']) }}"
               class="rounded-xl px-5 py-3 text-sm font-semibold transition
               {{ $tab === 'kategori'
                    ? 'bg-emerald-700 text-white shadow-sm'
                    : 'bg-slate-100 text-slate-600 hover:bg-emerald-50 hover:text-emerald-700' }}">
                Kategori
                <span class="ml-1">({{ $totalKategori }})</span>
            </a>

            <a href="{{ route('admin.services.index', ['tab' => 'layanan']) }}"
               class="rounded-xl px-5 py-3 text-sm font-semibold transition
               {{ $tab === 'layanan'
                    ? 'bg-emerald-700 text-white shadow-sm'
                    : 'bg-slate-100 text-slate-600 hover:bg-emerald-50 hover:text-emerald-700' }}">
                Daftar Layanan
                <span class="ml-1">({{ $totalLayanan }})</span>
            </a>

        </div>

        <!-- PENCARIAN -->
        <form method="GET"
              action="{{ route('admin.services.index') }}"
              class="mb-6 flex flex-col gap-3 sm:flex-row">

            <input type="hidden" name="tab" value="{{ $tab }}">

            <input
                type="text"
                name="search"
                value="{{ $search }}"
                placeholder="{{ $tab === 'kategori' ? 'Cari nama kategori...' : 'Cari nama layanan atau kategori...' }}"
                class="min-w-0 flex-1 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100"
            >

            <button type="submit"
                    class="rounded-xl bg-slate-800 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-900">
                Cari
            </button>

            @if ($search)
                <a href="{{ route('admin.services.index', ['tab' => $tab]) }}"
                   class="rounded-xl border border-slate-200 px-5 py-3 text-center text-sm font-semibold text-slate-600 hover:bg-slate-50">
                    Reset
                </a>
            @endif

        </form>

        <!-- TAB KATEGORI -->
        @if ($tab === 'kategori')

            <div class="mb-5">
                <h2 class="text-lg font-bold text-slate-900">
                    Daftar Kategori
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Kelola kategori layanan yang tersedia di HomeFix.
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[750px] text-left text-sm">

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
                                            <img
                                                src="{{ asset('storage/' . $category->image) }}"
                                                alt="{{ $category->name }}"
                                                class="h-12 w-12 rounded-xl border border-slate-100 object-cover"
                                            >
                                        @else
                                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     class="h-6 w-6"
                                                     fill="none"
                                                     viewBox="0 0 24 24"
                                                     stroke="currentColor">
                                                    <rect x="3" y="3" width="8" height="8" rx="1"/>
                                                    <rect x="13" y="3" width="8" height="8" rx="1"/>
                                                    <rect x="3" y="13" width="8" height="8" rx="1"/>
                                                    <rect x="13" y="13" width="8" height="8" rx="1"/>
                                                </svg>
                                            </div>
                                        @endif

                                        <div>
                                            <p class="font-semibold text-slate-800">
                                                {{ $category->name }}
                                            </p>
                                            <p class="mt-1 text-xs text-slate-400">
                                                ID: {{ $category->id }}
                                            </p>
                                        </div>

                                    </div>
                                </td>

                                <td class="px-4 py-4 text-slate-600">
                                    <p class="max-w-xs truncate">
                                        {{ $category->description ?: 'Tidak ada deskripsi' }}
                                    </p>
                                </td>

                                <td class="px-4 py-4">
                                    <span class="rounded-full bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700">
                                        {{ $category->services_count }} Layanan
                                    </span>
                                </td>

                                <td class="px-4 py-4">
                                    @if ($category->is_active)
                                        <span class="rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="rounded-full bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-600">
                                            Nonaktif
                                        </span>
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
                                    <p class="font-semibold text-slate-700">
                                        Belum ada kategori
                                    </p>

                                    <p class="mt-2 text-sm text-slate-500">
                                        Tambahkan kategori pertama untuk HomeFix.
                                    </p>

                                    <a href="{{ route('admin.categories.create') }}"
                                       class="mt-4 inline-block font-semibold text-emerald-700 hover:underline">
                                        + Tambah kategori
                                    </a>
                                </td>
                            </tr>

                        @endforelse

                    </tbody>
                </table>
            </div>

            <div class="mt-5">
                {{ $categories->appends(request()->except('layanan_page'))->appends(['tab' => 'kategori'])->links() }}
            </div>

        <!-- TAB DAFTAR LAYANAN -->
        @else

            <div class="mb-5">
                <h2 class="text-lg font-bold text-slate-900">
                    Daftar Layanan
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Informasi layanan yang dikelola oleh admin.
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[850px] text-left text-sm">

                    <thead>
                        <tr class="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                            <th class="px-4 py-4">Layanan</th>
                            <th class="px-4 py-4">Kategori</th>
                            <th class="px-4 py-4">Harga</th>
                            <th class="px-4 py-4">Durasi</th>
                            <th class="px-4 py-4">Status</th>
                            <th class="px-4 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse ($services as $service)

                            <tr class="transition hover:bg-slate-50">

                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">

                                        @if ($service->image)
                                            <img
                                                src="{{ asset('storage/' . $service->image) }}"
                                                alt="{{ $service->name }}"
                                                class="h-12 w-12 rounded-xl border border-slate-100 object-cover"
                                            >
                                        @else
                                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     class="h-6 w-6"
                                                     fill="none"
                                                     viewBox="0 0 24 24"
                                                     stroke="currentColor">
                                                    <path stroke-linecap="round"
                                                          stroke-linejoin="round"
                                                          stroke-width="1.7"
                                                          d="M11.42 15.17 17.25 9.34a2.83 2.83 0 0 0-4-4l-5.83 5.83m4 4-2.83 2.83a2.83 2.83 0 0 1-4-4l2.83-2.83m4 4 4 4"/>
                                                </svg>
                                            </div>
                                        @endif

                                        <div>
                                            <p class="font-semibold text-slate-800">
                                                {{ $service->name }}
                                            </p>

                                            <p class="mt-1 max-w-xs truncate text-xs text-slate-500">
                                                {{ $service->description ?: 'Tidak ada deskripsi' }}
                                            </p>
                                        </div>

                                    </div>
                                </td>

                                <td class="px-4 py-4 text-slate-600">
                                    {{ $service->category?->name ?? 'Tanpa kategori' }}
                                </td>

                                <td class="px-4 py-4 font-semibold text-slate-800">
                                    Rp{{ number_format((float) $service->price, 0, ',', '.') }}
                                </td>

                                <td class="px-4 py-4 text-slate-600">
                                    {{ $service->duration }} menit
                                </td>

                                <td class="px-4 py-4">
                                    @if ($service->is_active)
                                        <span class="rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="rounded-full bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-600">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>

                                <td class="px-4 py-4">
                                    <div class="flex items-center justify-end gap-2">

                                        <a href="{{ route('admin.services.edit', $service) }}"
                                           class="rounded-lg border border-emerald-200 px-3 py-2 text-xs font-semibold text-emerald-700 hover:bg-emerald-50">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.services.destroy', $service) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus layanan ini?')">

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
                                <td colspan="6" class="px-4 py-14 text-center">
                                    <p class="font-semibold text-slate-700">
                                        Belum ada layanan
                                    </p>

                                    <p class="mt-2 text-sm text-slate-500">
                                        Tambahkan layanan baru atau ubah kata kunci pencarian.
                                    </p>

                                    <a href="{{ route('admin.services.create') }}"
                                       class="mt-4 inline-block font-semibold text-emerald-700 hover:underline">
                                        + Tambah layanan pertama
                                    </a>
                                </td>
                            </tr>

                        @endforelse

                    </tbody>
                </table>
            </div>

            <div class="mt-5">
                {{ $services->appends(request()->except('kategori_page'))->appends(['tab' => 'layanan'])->links() }}
            </div>

        @endif

    </section>

    <footer class="py-6 text-center text-xs text-slate-400">
        &copy; {{ date('Y') }} HomeFix.
    </footer>

</main>

</body>
</html>
