
@php
    $teknisi = $teknisi ?? null;
    $user = $teknisi?->user;

    // Ambil keahlian lama atau pilihan sebelumnya jika validasi gagal.
    $selectedServiceIds = old(
        'service_ids',
        $teknisi ? $teknisi->services->pluck('id')->toArray() : []
    );
@endphp

@if ($errors->any())
    <div class="mb-6 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
        <p class="font-semibold">Periksa kembali data yang dimasukkan.</p>
        <ul class="mt-2 list-inside list-disc">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid grid-cols-1 gap-5 md:grid-cols-2">

    <div>
        <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">
            Nama Lengkap <span class="text-rose-500">*</span>
        </label>
        <input
            id="name"
            name="name"
            type="text"
            value="{{ old('name', $user?->name ?? '') }}"
            required
            maxlength="255"
            autocomplete="name"
            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100"
            placeholder="Masukkan nama teknisi"
        >
    </div>

    <div>
        <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">
            Email <span class="text-rose-500">*</span>
        </label>
        <input
            id="email"
            name="email"
            type="email"
            value="{{ old('email', $user?->email ?? '') }}"
            required
            maxlength="255"
            autocomplete="email"
            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100"
            placeholder="teknisi@email.com"
        >
    </div>

    <div>
        <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">
            Password
            @if (!$teknisi)
                <span class="text-rose-500">*</span>
            @endif
        </label>
        <input
            id="password"
            name="password"
            type="password"
            {{ !$teknisi ? 'required' : '' }}
            minlength="8"
            autocomplete="new-password"
            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100"
            placeholder="{{ $teknisi ? 'Kosongkan jika tidak diganti' : 'Minimal 8 karakter' }}"
        >
        @if ($teknisi)
            <p class="mt-1.5 text-xs text-slate-500">
                Kosongkan jika password tidak ingin diubah.
            </p>
        @endif
    </div>

    <div>
        <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-slate-700">
            Konfirmasi Password
        </label>
        <input
            id="password_confirmation"
            name="password_confirmation"
            type="password"
            {{ !$teknisi ? 'required' : '' }}
            minlength="8"
            autocomplete="new-password"
            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100"
            placeholder="Ulangi password"
        >
    </div>

    <div>
        <label for="phone" class="mb-2 block text-sm font-semibold text-slate-700">
            Nomor Telepon
        </label>
        <input
            id="phone"
            name="phone"
            type="tel"
            value="{{ old('phone', $teknisi?->phone ?? '') }}"
            maxlength="25"
            autocomplete="tel"
            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100"
            placeholder="Contoh: 081234567890"
        >
    </div>

    <div>
        <label for="photo" class="mb-2 block text-sm font-semibold text-slate-700">
            Foto Teknisi
        </label>
        <input
            id="photo"
            name="photo"
            type="file"
            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
            class="block w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-emerald-50 file:px-3 file:py-2 file:text-xs file:font-semibold file:text-emerald-700"
        >
        <p class="mt-1.5 text-xs text-slate-500">
            JPG, PNG, atau WEBP. Maksimal 2 MB.
        </p>

        @if ($teknisi?->photo)
            <div class="mt-3 flex items-center gap-3">
                <img
                    src="{{ asset('storage/' . $teknisi->photo) }}"
                    alt="Foto teknisi"
                    class="h-14 w-14 rounded-xl border border-slate-200 object-cover"
                >
                <span class="text-xs text-slate-500">Foto saat ini</span>
            </div>
        @endif
    </div>

    <div class="md:col-span-2">
        <label for="address" class="mb-2 block text-sm font-semibold text-slate-700">
            Alamat
        </label>
        <textarea
            id="address"
            name="address"
            rows="3"
            maxlength="1000"
            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100"
            placeholder="Masukkan alamat teknisi"
        >{{ old('address', $teknisi?->address ?? '') }}</textarea>
    </div>

    <div class="md:col-span-2">
        <label for="bio" class="mb-2 block text-sm font-semibold text-slate-700">
            Deskripsi / Keahlian
        </label>
        <textarea
            id="bio"
            name="bio"
            rows="4"
            maxlength="2000"
            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100"
            placeholder="Ceritakan pengalaman atau keahlian teknisi"
        >{{ old('bio', $teknisi?->bio ?? '') }}</textarea>
    </div>

    {{-- PILIHAN KEAHLIAN LAYANAN --}}
    <div class="md:col-span-2">
        <div class="mb-3">
            <label class="block text-sm font-semibold text-slate-700">
                Keahlian Layanan <span class="text-rose-500">*</span>
            </label>
            <p class="mt-1 text-xs text-slate-500">
                Pilih satu atau beberapa layanan yang dapat dikerjakan teknisi.
            </p>
        </div>

        @if (isset($services) && $services->count() > 0)
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($services as $service)
                    <label
                        for="service_{{ $service->id }}"
                        class="flex cursor-pointer items-start gap-3 rounded-xl border border-slate-200 bg-white p-4 transition hover:border-emerald-400 hover:bg-emerald-50"
                    >
                        <input
                            type="checkbox"
                            id="service_{{ $service->id }}"
                            name="service_ids[]"
                            value="{{ $service->id }}"
                            @checked(
                                is_array($selectedServiceIds) &&
                                in_array($service->id, $selectedServiceIds)
                            )
                            class="mt-1 h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500"
                        >

                        <span class="text-sm font-medium text-slate-700">
                            {{ $service->name }}
                        </span>
                    </label>
                @endforeach
            </div>
        @else
            <div class="rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800">
                Belum ada layanan yang tersedia. Tambahkan layanan terlebih dahulu melalui menu Layanan.
            </div>
        @endif

        @error('service_ids')
            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
        @enderror

        @error('service_ids.*')
            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="is_available" class="mb-2 block text-sm font-semibold text-slate-700">
            Status Ketersediaan
        </label>
        <select
            id="is_available"
            name="is_available"
            required
            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100"
        >
            <option value="1" @selected((string) old('is_available', $teknisi?->is_available ?? 1) === '1')>
                Tersedia
            </option>
            <option value="0" @selected((string) old('is_available', $teknisi?->is_available ?? 1) === '0')>
                Tidak tersedia
            </option>
        </select>
    </div>

    <div>
        <label for="is_verified" class="mb-2 block text-sm font-semibold text-slate-700">
            Status Verifikasi
        </label>
        <select
            id="is_verified"
            name="is_verified"
            required
            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100"
        >
            <option value="0" @selected((string) old('is_verified', $teknisi?->is_verified ?? 0) === '0')>
                Belum diverifikasi
            </option>
            <option value="1" @selected((string) old('is_verified', $teknisi?->is_verified ?? 0) === '1')>
                Terverifikasi
            </option>
        </select>
    </div>

</div>

<div class="mt-8 flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
    <a
        href="{{ route('admin.technicians.index') }}"
        class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50"
    >
        Batal
    </a>

    <button
        type="submit"
        class="inline-flex items-center justify-center rounded-xl bg-emerald-700 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-800"
    >
        {{ $teknisi ? 'Simpan Perubahan' : 'Simpan Teknisi' }}
    </button>
</div>
