
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Layanan - HomeFix</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-800">

@include('admin.partials.sidebar', ['active' => 'services'])

<main class="hf-admin-content">
    <div class="mb-7">
        <a href="{{ route('admin.services.index') }}"
           class="text-sm font-semibold text-emerald-700 hover:underline">
            ← Kembali ke Layanan
        </a>
        <h1 class="mt-4 text-3xl font-bold text-slate-900">Edit Layanan</h1>
        <p class="mt-2 text-sm text-slate-500">
            Perbarui informasi {{ $service->name }}.
        </p>
    </div>

    <section class="hf-panel max-w-4xl">
        @if ($errors->any())
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                <p class="mb-2 font-semibold">Periksa kembali data berikut:</p>
                <ul class="list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.services.update', $service) }}"
              method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.services._form')
        </form>
    </section>
</main>

</body>
</html>
