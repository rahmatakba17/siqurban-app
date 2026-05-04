<div wire:poll.15s>
    {{-- ─── Stat Cards ─── --}}
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4 stagger mb-6">
        <div class="stat-card animate-fade-in-up">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-widest text-stone-400">Total Kupon</p>
                <div class="w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                </div>
            </div>
            <p class="text-4xl font-black text-slate-900 mt-2">{{ number_format($totalCoupons) }}</p>
        </div>

        <div class="stat-card animate-fade-in-up">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-widest text-stone-400">Diterima</p>
                <div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-4xl font-black text-emerald-600 mt-2">{{ number_format($couponReceived) }}</p>
            <div class="mt-3 progress-bar">
                <div class="progress-fill bg-emerald-500" style="width: {{ $totalCoupons > 0 ? round(($couponReceived/$totalCoupons)*100) : 0 }}%"></div>
            </div>
            <p class="text-xs text-stone-400 mt-1">{{ $totalCoupons > 0 ? round(($couponReceived/$totalCoupons)*100) : 0 }}% terdistribusi</p>
        </div>

        <div class="stat-card animate-fade-in-up">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-widest text-stone-400">Tersedia</p>
                <div class="w-9 h-9 rounded-xl bg-sky-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
            </div>
            <p class="text-4xl font-black text-sky-600 mt-2">{{ number_format($couponAvailable) }}</p>
        </div>

        <div class="stat-card animate-fade-in-up">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold uppercase tracking-widest text-stone-400">Scan Hari Ini</p>
                <div class="w-9 h-9 rounded-xl bg-amber-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01"/></svg>
                </div>
            </div>
            <p class="text-4xl font-black text-amber-500 mt-2">{{ number_format($scansToday) }}</p>
            <p class="text-xs text-stone-400 mt-1 flex items-center gap-1">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse inline-block"></span>
                Live refresh 15 detik
            </p>
        </div>
    </div>

    {{-- ─── Chart + Wilayah ─── --}}
    <div class="grid gap-6 xl:grid-cols-[1fr_360px] mb-6">
        <div class="card p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-base font-bold text-slate-900">Distribusi per Wilayah</h2>
                <span class="badge-green flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>Live
                </span>
            </div>
            <canvas id="regionChart" height="200"></canvas>
        </div>

        <div class="space-y-4">
            <div class="card p-5">
                <h3 class="text-sm font-bold text-slate-900 mb-4">⚡ Aksi Cepat</h3>
                <div class="grid gap-2">
                    <a href="{{ route('admin.coupons.index') }}" class="btn-primary text-sm">Kelola Kupon</a>
                    <a href="{{ route('admin.regions.index') }}" class="btn-secondary text-sm">Tambah Wilayah</a>
                    <a href="{{ route('admin.users.index') }}" class="btn-secondary text-sm">Tambah Panitia</a>
                    <a href="{{ route('admin.reports.index') }}" class="btn-secondary text-sm">Lihat Laporan</a>
                    <a href="{{ route('admin.pulse') }}" class="btn-ghost text-sm border border-stone-200">
                        🔭 Monitor Pulse
                    </a>
                </div>
            </div>

            <div class="card p-5">
                <h3 class="text-sm font-bold text-slate-900 mb-4">📍 Progress per Wilayah</h3>
                <div class="space-y-4">
                    @forelse($regions as $region)
                    <div>
                        <div class="flex items-center justify-between text-xs mb-1.5">
                            <span class="font-medium text-slate-700">{{ $region['name'] }}</span>
                            <span class="font-semibold text-primary">{{ $region['received'] }}/{{ $region['total'] }}</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ $region['pct'] }}%"></div>
                        </div>
                        <p class="text-xs text-stone-400 mt-1">{{ $region['pct'] }}% terdistribusi</p>
                    </div>
                    @empty
                    <p class="text-xs text-stone-400">Belum ada wilayah.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// ── Chart.js (reinit setelah Livewire update) ─────────────────
let regionChart = null;

function initChart() {
    const canvas = document.getElementById('regionChart');
    if (!canvas) return;
    if (regionChart) regionChart.destroy();

    regionChart = new Chart(canvas, {
        type: 'bar',
        data: {
            labels:   @json($chartLabels),
            datasets: [
                { label: 'Sudah Diterima', data: @json($chartReceived), backgroundColor: '#0f766e', borderRadius: 8, borderSkipped: false },
                { label: 'Total Kupon',    data: @json($chartTotal),    backgroundColor: '#e2e8f0', borderRadius: 8, borderSkipped: false },
            ]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'top', labels: { font: { size: 12 }, boxWidth: 12 } } },
            scales: {
                x: { grid: { display: false } },
                y: { beginAtZero: true, grid: { color: '#f1f5f9' } }
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', initChart);
document.addEventListener('livewire:navigated', initChart);
// Re-init chart setelah Livewire polling update
Livewire.hook('morph.updated', () => { setTimeout(initChart, 100); });


</script>
@endpush
