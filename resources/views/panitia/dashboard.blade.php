@extends('layouts.app')

@section('page-title', 'Dashboard Panitia')

@section('content')
<div class="grid gap-5 md:grid-cols-3">
    <div class="card p-6">
        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-stone-400">Scan Hari Ini</p>
        <p class="mt-3 text-4xl font-bold text-primary">{{ $scanToday }}</p>
    </div>
    <div class="card p-6">
        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-stone-400">Total Scan</p>
        <p class="mt-3 text-4xl font-bold text-emerald-600">{{ $totalScans }}</p>
    </div>
    <div class="card p-6">
        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-stone-400">Status Akun</p>
        <p class="mt-3 text-2xl font-bold text-slate-900">{{ ucfirst(auth()->user()->status) }}</p>
    </div>
</div>

<div class="mt-6 grid gap-6 xl:grid-cols-[0.9fr_1.1fr]">
    <div class="card p-6">
        <h3 class="text-xl font-bold text-slate-900">Aksi Cepat</h3>
        <div class="mt-6 grid gap-3">
            <a href="{{ route('panitia.scan') }}" class="btn-primary">Verifikasi Kupon</a>
            <a href="{{ route('panitia.scans') }}" class="btn-secondary">Lihat Riwayat Scan</a>
            <a href="{{ route('panitia.profile') }}" class="btn-secondary">Perbarui Profil</a>
        </div>
    </div>

    <div class="card p-6">
        <h3 class="text-xl font-bold text-slate-900">Scan Terakhir</h3>
        @if($latestScan)
            <div class="mt-5 rounded-2xl bg-stone-50 p-5">
                <p class="text-sm text-stone-500">Kode Kupon</p>
                <p class="mt-1 font-mono text-lg font-bold text-slate-900">{{ $latestScan->coupon?->code }}</p>
                <p class="mt-4 text-sm text-stone-500">Wilayah</p>
                <p class="mt-1 font-semibold text-slate-900">{{ $latestScan->coupon?->region?->name ?: '-' }}</p>
                <p class="mt-4 text-sm text-stone-500">Waktu</p>
                <p class="mt-1 font-semibold text-slate-900">{{ $latestScan->scan_time->format('d/m/Y H:i') }}</p>
            </div>
        @else
            <p class="mt-5 text-stone-500">Belum ada aktivitas scan.</p>
        @endif
    </div>
</div>
@endsection
