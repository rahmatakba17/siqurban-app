<div wire:poll.15s="refresh">
    {{-- Counter besar --}}
    <div class="card p-6 text-center">
        <p class="text-xs font-semibold uppercase tracking-widest text-stone-400 mb-1">Scan Hari Ini</p>
        <p class="text-7xl font-black text-primary mt-2 transition-all duration-500">
            {{ $scanToday }}
        </p>
        <p class="text-xs text-stone-400 mt-2">verifikasi berhasil</p>
        <div class="mt-3 text-xs text-stone-300 flex items-center justify-center gap-1">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse inline-block"></span>
            Auto-refresh setiap 15 detik
        </div>
    </div>

    {{-- Scan terbaru --}}
    @if(count($recentScans) > 0)
    <div class="card p-4 mt-4">
        <h4 class="text-xs font-bold text-slate-700 mb-3">🕒 Riwayat Scan Terbaru</h4>
        <div class="space-y-2">
            @foreach($recentScans as $scan)
            <div class="flex items-center gap-3 rounded-xl bg-stone-50 px-3 py-2">
                <div class="w-7 h-7 rounded-full bg-primary/10 flex items-center justify-center text-primary text-xs font-bold flex-shrink-0">✓</div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-mono font-semibold text-slate-700 truncate">{{ $scan['code'] }}</p>
                    <p class="text-xs text-stone-400">{{ $scan['region'] }}</p>
                </div>
                <p class="text-xs text-stone-400 flex-shrink-0">{{ $scan['time'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Tips --}}
    <div class="card p-4 mt-4 border-l-4 border-l-primary">
        <h4 class="text-xs font-bold text-slate-900 mb-2">💡 Petunjuk</h4>
        <ul class="text-xs text-stone-500 space-y-1">
            <li>• Counter otomatis refresh setiap 15 detik</li>
            <li>• Scan berhasil = kupon langsung masuk riwayat</li>
            <li>• Kupon yang sudah dipakai tidak bisa scan ulang</li>
        </ul>
    </div>
</div>
