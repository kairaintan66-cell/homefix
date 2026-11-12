
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Teknisi - HomeFix</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen antialiased">

    @include('admin.partials.sidebar', ['active' => 'technicians'])

    <main class="hf-admin-content">

        <header class="mb-7">
            <a href="{{ route('admin.technicians.index') }}"
               class="mb-4 inline-flex items-center gap-2 text-sm font-semibold text-emerald-700 hover:text-emerald-900">
                <span aria-hidden="true">←</span>
                Kembali ke Data Teknisi
            </a>

            <p class="mb-1 text-xs font-bold uppercase tracking-[0.16em] text-emerald-700">
                Manajemen Teknisi
            </p>

            <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                Edit Teknisi
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Perbarui informasi {{ $teknisi->user->name ?? 'teknisi' }}.
            </p>
        </header>

        <section class="hf-panel">

            <div class="mb-6 border-b border-slate-100 pb-5">
                <h2 class="font-bold text-slate-900">
                    Perbarui Informasi Teknisi
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Ubah kolom yang diperlukan, lalu simpan perubahan.
                </p>
            </div>

            <form action="{{ route('admin.technicians.update', $teknisi) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                @include('admin.technicians._form', [
                    'teknisi' => $teknisi
                ])

            </form>

        </section>

        <footer class="py-6 text-center text-xs text-slate-400">
            &copy; {{ date('Y') }} HomeFix.
        </footer>

    </main>

</body>
</html>
