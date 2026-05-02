@extends('layouts.app')

@section('page-title', 'Pengaturan')

@section('content')
<div class="mx-auto max-w-3xl">
    <div class="card p-6 md:p-8">
        <h3 class="text-xl font-bold text-slate-900">Pengaturan Aplikasi</h3>
        <p class="mt-2 text-sm text-stone-500">Konfigurasi ini digunakan untuk identitas sistem pada dashboard dan laporan.</p>

        <form method="POST" action="{{ route('admin.settings.update') }}" class="mt-6 space-y-5">
            @csrf

            <div>
                <label for="app_name" class="form-label">Nama Aplikasi</label>
                <input type="text" id="app_name" name="app_name" value="{{ old('app_name', $settings['app_name']) }}" class="form-input" required>
            </div>

            <div>
                <label for="app_url" class="form-label">URL Aplikasi</label>
                <input type="url" id="app_url" name="app_url" value="{{ old('app_url', $settings['app_url']) }}" class="form-input" required>
            </div>

            <div>
                <label for="masjid_name" class="form-label">Nama Masjid/Lembaga</label>
                <input type="text" id="masjid_name" name="masjid_name" value="{{ old('masjid_name', $settings['masjid_name']) }}" class="form-input" required>
            </div>

            <div>
                <label for="tahun_kurban" class="form-label">Tahun Kurban</label>
                <input type="number" id="tahun_kurban" name="tahun_kurban" value="{{ old('tahun_kurban', $settings['tahun_kurban']) }}" class="form-input" required>
            </div>

            <button type="submit" class="btn-primary">Simpan Pengaturan</button>
        </form>
    </div>
</div>
@endsection
