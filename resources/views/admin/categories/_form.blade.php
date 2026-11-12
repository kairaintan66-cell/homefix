@php
    $category = $category ?? null;
@endphp

<div class="space-y-6">
    <div>
        <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">
            Nama Kategori <span class="text-red-500">*</span>
        </label>
        <input id="name" name="name" type="text"
               value="{{ old('name', $category?->name) }}"
               required maxlength="255"
               class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100"
               placeholder="Contoh: Elektronik">
        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="description" class="mb-2 block text-sm font-semibold text-slate-700">Deskripsi</label>
        <textarea id="description" name="description" rows="4"
                  class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-emerald-600"
                  placeholder="Jelaskan kategori layanan">{{ old('description', $category?->description) }}</textarea>
        @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="image" class="mb-2 block text-sm font-semibold text-slate-700">Gambar Kategori</label>
        @if ($category?->image)
            <img src="{{ asset('storage/' . $category->image) }}"
                 alt="Gambar {{ $category->name }}"
                 class="mb-3 h-24 w-24 rounded-xl object-cover">
        @endif
        <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp"
               class="block w-full rounded-xl border border-slate-300 p-3 text-sm">
        <p class="mt-1 text-xs text-slate-500">
            Format JPG, PNG, atau WEBP. Maksimal 2 MB.
            @if ($category?->image) Biarkan kosong jika tidak ingin mengganti gambar. @endif
        </p>
        @error('image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="is_active" class="mb-2 block text-sm font-semibold text-slate-700">Status Kategori</label>
        <select id="is_active" name="is_active" required
                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3">
            <option value="1" @selected((string) old('is_active', $category?->is_active ?? 1) === '1')>Aktif</option>
            <option value="0" @selected((string) old('is_active', $category?->is_active ?? 1) === '0')>Nonaktif</option>
        </select>
        @error('is_active') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="flex flex-wrap gap-3 border-t border-slate-200 pt-5">
        <button type="submit"
                class="rounded-xl bg-emerald-700 px-6 py-3 font-semibold text-white transition hover:bg-emerald-800">
            {{ $category ? 'Simpan Perubahan' : 'Tambah Kategori' }}
        </button>
        <a href="{{ route('admin.categories.index') }}"
           class="rounded-xl border border-slate-300 px-6 py-3 font-semibold text-slate-600 hover:bg-slate-50">
            Batal
        </a>
    </div>
</div>
