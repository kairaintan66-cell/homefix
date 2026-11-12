
@php
    $service = $service ?? null;
@endphp

<div class="space-y-6">
    <div>
        <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">
            Nama Layanan <span class="text-red-500">*</span>
        </label>
        <input id="name" name="name" type="text"
               value="{{ old('name', $service?->name) }}"
               required maxlength="255"
               class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100"
               placeholder="Contoh: Perbaikan AC">
        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="category_id" class="mb-2 block text-sm font-semibold text-slate-700">
            Kategori <span class="text-red-500">*</span>
        </label>
        <select id="category_id" name="category_id" required
                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 outline-none focus:border-emerald-600">
            <option value="">Pilih kategori</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}"
                    @selected((string) old('category_id', $service?->category_id) === (string) $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="description" class="mb-2 block text-sm font-semibold text-slate-700">
            Deskripsi
        </label>
        <textarea id="description" name="description" rows="4"
                  class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-emerald-600"
                  placeholder="Jelaskan layanan yang diberikan">{{ old('description', $service?->description) }}</textarea>
        @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="grid gap-5 md:grid-cols-2">
        <div>
            <label for="price" class="mb-2 block text-sm font-semibold text-slate-700">
                Harga (Rp) <span class="text-red-500">*</span>
            </label>
            <input id="price" name="price" type="number" min="0" step="100"
                   value="{{ old('price', $service?->price) }}"
                   required
                   class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-emerald-600"
                   placeholder="150000">
            @error('price') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="duration" class="mb-2 block text-sm font-semibold text-slate-700">
                Durasi (menit) <span class="text-red-500">*</span>
            </label>
            <input id="duration" name="duration" type="number" min="1"
                   value="{{ old('duration', $service?->duration ?? 60) }}"
                   required
                   class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-emerald-600"
                   placeholder="60">
            @error('duration') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <div>
        <label for="image" class="mb-2 block text-sm font-semibold text-slate-700">
            Gambar Layanan
        </label>

        @if ($service?->image)
            <img src="{{ asset('storage/' . $service->image) }}"
                 alt="Gambar {{ $service->name }}"
                 class="mb-3 h-24 w-24 rounded-xl object-cover">
        @endif

        <input id="image" name="image" type="file"
               accept="image/jpeg,image/png,image/webp"
               class="block w-full rounded-xl border border-slate-300 p-3 text-sm">
        <p class="mt-1 text-xs text-slate-500">
            Format JPG, PNG, atau WEBP. Maksimal 2 MB.
            @if ($service?->image) Biarkan kosong jika tidak ingin mengganti gambar. @endif
        </p>
        @error('image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="is_active" class="mb-2 block text-sm font-semibold text-slate-700">
            Status Layanan
        </label>
        <select id="is_active" name="is_active" required
                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3">
            <option value="1"
                @selected((string) old('is_active', $service?->is_active ?? 1) === '1')>
                Aktif
            </option>
            <option value="0"
                @selected((string) old('is_active', $service?->is_active ?? 1) === '0')>
                Nonaktif
            </option>
        </select>
        @error('is_active') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="flex flex-wrap gap-3 border-t border-slate-200 pt-5">
        <button type="submit"
                class="rounded-xl bg-emerald-700 px-6 py-3 font-semibold text-white transition hover:bg-emerald-800">
            {{ $service ? 'Simpan Perubahan' : 'Tambah Layanan' }}
        </button>

        <a href="{{ route('admin.services.index') }}"
           class="rounded-xl border border-slate-300 px-6 py-3 font-semibold text-slate-600 hover:bg-slate-50">
            Batal
        </a>
    </div>
</div>
