@extends('layouts.app')

@section('page-title', 'Tambah Kupon')

@section('content')
<div class="mx-auto max-w-3xl">
    <div class="card p-6 md:p-8">
        <form method="POST" action="{{ route('admin.coupons.store') }}" class="space-y-4">
            @csrf

            <div>
                <label for="code" class="form-label">Kode Kupon</label>
                <input type="text" id="code" name="code" value="{{ old('code') }}" class="form-input" required>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label for="type" class="form-label">Tipe Kupon</label>
                    <select id="type" name="type" class="form-input" required>
                        <option value="umum" @selected(old('type') === 'umum')>Umum</option>
                        <option value="pengkurban" @selected(old('type') === 'pengkurban')>Pengkurban</option>
                    </select>
                </div>
                <div>
                    <label for="region_id" class="form-label">Wilayah</label>
                    <select id="region_id" name="region_id" class="form-input" required>
                        <option value="">Pilih wilayah</option>
                        @foreach($regions as $region)
                            <option value="{{ $region->id }}" @selected(old('region_id') == $region->id)>{{ $region->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label for="sacrificer_name" class="form-label">Nama Penerima/Pengkurban</label>
                <input type="text" id="sacrificer_name" name="sacrificer_name" value="{{ old('sacrificer_name') }}" class="form-input">
            </div>

            <div>
                <label for="special_request" class="form-label">Catatan</label>
                <textarea id="special_request" name="special_request" rows="4" class="form-input">{{ old('special_request') }}</textarea>
            </div>

            <div>
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-input" required>
                    <option value="available" @selected(old('status') === 'available')>Available</option>
                    <option value="received" @selected(old('status') === 'received')>Received</option>
                    <option value="used" @selected(old('status') === 'used')>Used</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="btn-primary">Simpan</button>
                <a href="{{ route('admin.coupons.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
