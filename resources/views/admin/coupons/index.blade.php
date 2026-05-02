@extends('layouts.app')

@section('page-title', 'Kelola Kupon')
@section('page-subtitle', 'Generate, import, cetak, dan kelola kupon distribusi')

@section('content')
<div class="xl:grid xl:grid-cols-[1fr_320px] gap-6">
    {{-- Livewire table (kiri) --}}
    <div>
        @livewire('kupon-table')
    </div>

    {{-- Panel Generate + Import (kanan, statis) --}}
    <div class="space-y-5 mt-6 xl:mt-0">
        {{-- Generate --}}
        <div class="card p-5">
            <h3 class="text-sm font-bold text-slate-900 mb-4">⚡ Generate Otomatis</h3>
            <form method="POST" action="{{ route('admin.coupons.generate') }}" class="space-y-3">
                @csrf
                <div>
                    <label for="gen_region_id" class="form-label text-xs">Wilayah</label>
                    <select id="gen_region_id" name="region_id" class="form-select text-sm" required>
                        <option value="">Pilih wilayah</option>
                        @foreach(\App\Models\Region::where('status','active')->orderBy('name')->get() as $region)
                            <option value="{{ $region->id }}">{{ $region->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="gen_quantity" class="form-label text-xs">Jumlah</label>
                    <input type="number" id="gen_quantity" name="quantity" value="10" min="1" max="500" class="form-input text-sm" required>
                </div>
                <div>
                    <label for="gen_type" class="form-label text-xs">Tipe Kupon</label>
                    <select id="gen_type" name="type" class="form-select text-sm" required>
                        <option value="umum">🎫 Umum</option>
                        <option value="pengkurban">🐄 Pengkurban</option>
                    </select>
                </div>
                <button type="submit" class="btn-primary w-full text-sm">⚡ Generate Kupon</button>
            </form>
        </div>

        {{-- Import CSV --}}
        <div class="card p-5">
            <h3 class="text-sm font-bold text-slate-900 mb-1">📥 Import CSV</h3>
            <p class="text-xs text-stone-400 mb-4">Format: <code class="bg-stone-100 px-1 rounded">kode, nama, catatan</code></p>
            <form method="POST" action="{{ route('admin.coupons.import') }}" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <div>
                    <label for="imp_region" class="form-label text-xs">Wilayah</label>
                    <select id="imp_region" name="region_id" class="form-select text-sm" required>
                        <option value="">Pilih wilayah</option>
                        @foreach(\App\Models\Region::where('status','active')->orderBy('name')->get() as $region)
                            <option value="{{ $region->id }}">{{ $region->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="imp_type" class="form-label text-xs">Tipe</label>
                    <select id="imp_type" name="type" class="form-select text-sm" required>
                        <option value="pengkurban">🐄 Pengkurban</option>
                        <option value="umum">🎫 Umum</option>
                    </select>
                </div>
                <div>
                    <label for="imp_file" class="form-label text-xs">File CSV</label>
                    <input type="file" id="imp_file" name="file" class="form-input text-sm" accept=".csv" required>
                </div>
                <button type="submit" class="btn-secondary w-full text-sm">📥 Import Data</button>
            </form>
        </div>
    </div>
</div>
@endsection
