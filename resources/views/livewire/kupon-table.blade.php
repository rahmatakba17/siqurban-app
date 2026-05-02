<div>
    {{-- ─── Flash notify via Livewire event ─── --}}
    <div x-data="{ show: false, msg: '', type: 'success' }"
         x-on:notify.window="show=true; msg=$event.detail.message; type=$event.detail.type; setTimeout(()=>show=false,4000)"
         x-show="show" x-transition
         :class="type==='success' ? 'toast-success' : 'toast-error'"
         class="mb-4" style="display:none">
        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path x-show="type==='success'" stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            <path x-show="type==='error'" stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span x-text="msg"></span>
    </div>

    {{-- ─── Mini stat bar ─── --}}
    <div class="grid grid-cols-3 gap-3 mb-4">
        <div class="card p-3 text-center">
            <p class="text-xs text-stone-400">Total</p>
            <p class="text-2xl font-black text-slate-900">{{ number_format($totalCoupons) }}</p>
        </div>
        <div class="card p-3 text-center">
            <p class="text-xs text-stone-400">Diterima</p>
            <p class="text-2xl font-black text-emerald-600">{{ number_format($totalReceived) }}</p>
        </div>
        <div class="card p-3 text-center">
            <p class="text-xs text-stone-400">Tersedia</p>
            <p class="text-2xl font-black text-sky-600">{{ number_format($totalAvail) }}</p>
        </div>
    </div>

    {{-- ─── Filter Bar (reaktif — tanpa submit) ─── --}}
    <div class="card p-4 mb-4">
        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
            <div>
                <label class="form-label text-xs">🔍 Cari Kode / Nama</label>
                <input type="text" wire:model.live.debounce.300ms="search"
                       class="form-input text-sm" placeholder="Ketik untuk cari...">
            </div>
            <div>
                <label class="form-label text-xs">Status</label>
                <select wire:model.live="status" class="form-select text-sm">
                    <option value="">Semua Status</option>
                    <option value="available">✅ Tersedia</option>
                    <option value="received">📦 Diterima</option>
                </select>
            </div>
            <div>
                <label class="form-label text-xs">Tipe</label>
                <select wire:model.live="type" class="form-select text-sm">
                    <option value="">Semua Tipe</option>
                    <option value="umum">🎫 Umum</option>
                    <option value="pengkurban">🐄 Pengkurban</option>
                </select>
            </div>
            <div>
                <label class="form-label text-xs">Wilayah</label>
                <select wire:model.live="region_id" class="form-select text-sm">
                    <option value="0">Semua Wilayah</option>
                    @foreach($regions as $region)
                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex items-center justify-between mt-3">
            <p class="text-xs text-stone-400">
                {{ $coupons->total() }} kupon ditemukan
                <span wire:loading class="ml-2 animate-pulse-soft text-primary">⟳ memuat...</span>
            </p>
            @if($search || $status || $type || $region_id)
                <button wire:click="resetFilters" class="btn-secondary text-xs">✕ Reset Filter</button>
            @endif
            <a href="{{ route('admin.coupons.create') }}" class="btn-success text-xs ml-auto">
                + Tambah Kupon
            </a>
        </div>
    </div>

    {{-- ─── Tabel ─── --}}
    <div class="card overflow-hidden">
        <div wire:loading.class="opacity-50 pointer-events-none">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>QR</th>
                        <th>Kode</th>
                        <th>Tipe</th>
                        <th>Nama</th>
                        <th>Wilayah</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($coupons as $coupon)
                    <tr wire:key="coupon-{{ $coupon->id }}">
                        <td>
                            <a href="{{ route('admin.coupons.print', $coupon) }}" target="_blank"
                               class="inline-flex w-8 h-8 items-center justify-center rounded-xl border border-stone-200 text-primary hover:bg-primary/5">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01"/></svg>
                            </a>
                        </td>
                        <td><code class="text-xs bg-stone-100 px-2 py-1 rounded-lg font-mono">{{ $coupon->code }}</code></td>
                        <td>
                            @if($coupon->type === 'pengkurban')
                                <span class="badge-amber">🐄 Pengkurban</span>
                            @else
                                <span class="badge-stone">🎫 Umum</span>
                            @endif
                        </td>
                        <td class="text-slate-700 text-sm">{{ $coupon->sacrificer_name ?: '—' }}</td>
                        <td>
                            @if($coupon->region)
                                <span class="badge-blue">{{ $coupon->region->name }}</span>
                            @else
                                <span class="text-stone-400">—</span>
                            @endif
                        </td>
                        <td>
                            @if($coupon->status === 'available')
                                <span class="badge-green">✅ Tersedia</span>
                            @else
                                <span class="badge-blue">📦 Diterima</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.coupons.show', $coupon) }}"
                                   class="text-xs font-semibold text-primary hover:text-teal-800">Detail</a>
                                <span class="text-stone-200">|</span>
                                <a href="{{ route('admin.coupons.edit', $coupon) }}"
                                   class="text-xs font-semibold text-amber-600 hover:text-amber-700">Edit</a>
                                <span class="text-stone-200">|</span>
                                <button wire:click="deleteCoupon({{ $coupon->id }})"
                                        wire:confirm="Hapus kupon {{ $coupon->code }}?"
                                        class="text-xs font-semibold text-red-600 hover:text-red-700">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-stone-400 py-12">
                            <svg class="w-12 h-12 mx-auto mb-3 text-stone-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                            Tidak ada kupon ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-4 border-t border-stone-100">
            {{ $coupons->links() }}
        </div>
    </div>
</div>
