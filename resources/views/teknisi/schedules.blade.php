@extends('teknisi.layout')
@section('title', 'Jadwal Saya')
@section('heading', 'Jadwal Ketersediaan')
@section('content')
<section class="welcome"><div><h2>Atur waktu kerja kamu</h2><p>Tentukan hari dan jam ketika kamu tersedia menerima pekerjaan.<br>Perubahan disimpan ke jadwal teknisi di database.</p></div><div class="welcome-icon">🗓</div></section>
@if(!$technician)
    <div class="alert error">Profil teknisi untuk akun ini belum tersedia. Hubungi admin untuk menghubungkan akun dengan data teknisi.</div>
@endif
<div class="day-grid">
@foreach($days as $day)
    @php $schedule = $schedules->get($day); @endphp
    <section class="day-card">
        <div class="day-top"><h3>{{ $day }}</h3><span class="status {{ $schedule && $schedule->is_available ? 'selesai' : 'menunggu' }}">{{ $schedule && $schedule->is_available ? 'Tersedia' : 'Libur / Belum diatur' }}</span></div>
        <form method="POST" action="{{ route('teknisi.jadwal.update') }}">
            @csrf @method('PUT')
            <input type="hidden" name="day" value="{{ $day }}">
            <div class="day-fields">
                <div class="field"><label for="start-{{ $loop->index }}">Jam Mulai</label><input id="start-{{ $loop->index }}" type="time" name="start_time" value="{{ old('day') === $day ? old('start_time') : ($schedule?->start_time ? substr($schedule->start_time,0,5) : '08:00') }}"></div>
                <div class="field"><label for="end-{{ $loop->index }}">Jam Selesai</label><input id="end-{{ $loop->index }}" type="time" name="end_time" value="{{ old('day') === $day ? old('end_time') : ($schedule?->end_time ? substr($schedule->end_time,0,5) : '17:00') }}"></div>
            </div>
            <label class="switch-label" style="margin-top:14px"><input type="checkbox" name="is_available" value="1" {{ old('day') === $day ? (old('is_available') ? 'checked' : '') : ($schedule && $schedule->is_available ? 'checked' : '') }}> Saya tersedia pada hari ini</label>
            <button class="btn" type="submit" {{ !$technician ? 'disabled' : '' }}>Simpan Jadwal</button>
        </form>
    </section>
@endforeach
</div>
@endsection
