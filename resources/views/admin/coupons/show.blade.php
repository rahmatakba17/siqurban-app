@extends('layouts.app')

@section('page-title', 'Detail Kupon')

@section('content')
<div class="grid gap-6 xl:grid-cols-[0.9fr_1.1fr]">
    <div class="card p-6">
        <h3 class="text-xl font-bold text-slate-900">Informasi Kupon</h3>
        <div class="mt-5 space-y-4 text-sm">
            <div>
                <p class="text-stone-500">Kode</p>
                <p class="font-mono text-slate-900">{{ $coupon->code }}</p>
            </div>
            <div>
                <p class="text-stone-500">Tipe</p>
                <p class="font-semibold text-slate-900">{{ ucfirst($coupon->type) }}</p>
            </div>
            <div>
                <p class="text-stone-500">Wilayah</p>
                <p class="font-semibold text-slate-900">{{ $coupon->region?->name ?: '-' }}</p>
            </div>
            <div>
                <p class="text-stone-500">Nama Penerima/Pengkurban</p>
                <p class="font-semibold text-slate-900">{{ $coupon->sacrificer_name ?: '-' }}</p>
            </div>
            <div>
                <p class="text-stone-500">Catatan</p>
                <p class="font-semibold text-slate-900">{{ $coupon->special_request ?: '-' }}</p>
            </div>
            <div>
                <p class="text-stone-500">Status</p>
                <p class="font-semibold text-slate-900">{{ ucfirst($coupon->status) }}</p>
            </div>
        </div>
    </div>

    <div class="card p-6">
        <h3 class="text-xl font-bold text-slate-900">Riwayat Scan</h3>
        <div class="mt-5 space-y-4">
            @forelse($coupon->scanHistories as $scan)
                <div class="rounded-2xl bg-stone-50 p-4">
                    <p class="font-semibold text-slate-900">{{ $scan->user?->name }}</p>
                    <p class="text-sm text-stone-500">{{ $scan->scan_time->format('d/m/Y H:i') }}</p>
                    <p class="mt-2 text-sm text-stone-700">{{ $scan->notes ?: 'Tanpa catatan tambahan.' }}</p>
                </div>
            @empty
                <p class="text-stone-500">Kupon ini belum pernah diverifikasi.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
