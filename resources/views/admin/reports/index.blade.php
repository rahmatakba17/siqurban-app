@extends('layouts.app')

@section('page-title', 'Laporan & Rekapitulasi')
@section('page-subtitle', 'Statistik distribusi dan ekspor data')

@section('content')
{{-- Stat Cards --}}
<div class="grid gap-4 sm:grid-cols-3 mb-6">
    <div class="stat-card">
        <p class="text-xs font-semibold uppercase tracking-widest text-stone-400">Total Kupon</p>
        <p class="text-4xl font-black text-slate-900 mt-2">{{ number_format($totalCoupons) }}</p>
    </div>
    <div class="stat-card">
        <p class="text-xs font-semibold uppercase tracking-widest text-stone-400">Sudah Diterima</p>
        <p class="text-4xl font-black text-emerald-600 mt-2">{{ number_format($couponReceived) }}</p>
        <div class="mt-3 progress-bar">
            <div class="progress-fill bg-emerald-500" style="width:{{ $totalCoupons > 0 ? round(($couponReceived/$totalCoupons)*100) : 0 }}%"></div>
        </div>
        <p class="text-xs text-stone-400 mt-1">{{ $totalCoupons > 0 ? round(($couponReceived/$totalCoupons)*100) : 0 }}% selesai</p>
    </div>
    <div class="stat-card">
        <p class="text-xs font-semibold uppercase tracking-widest text-stone-400">Total Scan</p>
        <p class="text-4xl font-black text-primary mt-2">{{ number_format($totalScans) }}</p>
    </div>
</div>

<div class="grid gap-6 xl:grid-cols-[1fr_320px]">
    {{-- Chart --}}
    <div class="card p-6">
        <h3 class="text-base font-bold text-slate-900 mb-5">📊 Distribusi per Wilayah</h3>
        <canvas id="reportChart" height="180"></canvas>

        {{-- Progress per wilayah --}}
        <div class="mt-6 space-y-4">
            @foreach($regions as $r)
            <div>
                <div class="flex justify-between text-xs mb-1.5">
                    <span class="font-semibold text-slate-700">{{ $r['name'] }}</span>
                    <span class="text-stone-500">{{ $r['received'] }}/{{ $r['total'] }} — <strong class="text-primary">{{ $r['pct'] }}%</strong></span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width:{{ $r['pct'] }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Panel Aksi --}}
    <div class="space-y-5">
        <div class="card p-5">
            <h3 class="text-sm font-bold text-slate-900 mb-4">📤 Ekspor & Cetak</h3>
            <div class="space-y-3">
                <a href="{{ route('admin.reports.export') }}" class="btn-secondary w-full text-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Unduh CSV
                </a>
                <a href="{{ route('admin.reports.export-excel') }}" class="btn-success w-full text-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Unduh Excel (.xlsx)
                </a>
                <button onclick="window.print()" class="btn-primary w-full text-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Cetak Laporan
                </button>
            </div>
        </div>

        <div class="card p-5">
            <h3 class="text-sm font-bold text-slate-900 mb-4">📍 Ringkasan Wilayah</h3>
            <div class="space-y-2">
                @foreach($regions as $r)
                <div class="flex items-center justify-between py-2 border-b border-stone-100 last:border-0">
                    <span class="text-sm text-slate-700">{{ $r['name'] }}</span>
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-stone-400">{{ $r['received'] }}/{{ $r['total'] }}</span>
                        <span class="badge-{{ $r['pct'] >= 80 ? 'green' : ($r['pct'] >= 40 ? 'amber' : 'stone') }}">{{ $r['pct'] }}%</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- Riwayat Scan Terbaru --}}
<div class="mt-6 card">
    <div class="px-6 py-4 border-b border-stone-100 flex items-center justify-between">
        <h3 class="text-sm font-bold text-slate-900">🕒 Riwayat Scan Terbaru</h3>
        <a href="{{ route('admin.scans') }}" class="text-xs font-semibold text-primary">Lihat Semua →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Petugas</th>
                    <th>Kode Kupon</th>
                    <th>Wilayah</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentScans as $scan)
                <tr>
                    <td class="font-medium text-slate-700">{{ $scan->user?->name ?? '—' }}</td>
                    <td><code class="text-xs bg-stone-100 px-2 py-1 rounded-lg">{{ $scan->coupon?->code ?? '—' }}</code></td>
                    <td><span class="badge-blue">{{ $scan->coupon?->region?->name ?? '—' }}</span></td>
                    <td class="text-stone-500 text-xs">{{ $scan->scan_time->format('d/m/Y H:i') }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center py-8 text-stone-400">Belum ada riwayat scan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    new Chart(document.getElementById('reportChart'), {
        type: 'doughnut',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                data: @json($chartReceived),
                backgroundColor: ['#0f766e','#0ea5e9','#f59e0b','#ef4444','#8b5cf6'],
                borderWidth: 0,
                hoverOffset: 8,
            }]
        },
        options: {
            responsive: true,
            cutout: '65%',
            plugins: {
                legend: { position: 'bottom', labels: { font: { size: 12 }, boxWidth: 12 } },
                tooltip: {
                    callbacks: {
                        label: ctx => ` ${ctx.label}: ${ctx.parsed} kupon diterima`
                    }
                }
            }
        }
    });
});
</script>
@endpush
