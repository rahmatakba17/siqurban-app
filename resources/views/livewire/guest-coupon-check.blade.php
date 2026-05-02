<div>
    <div class="relative w-full max-w-2xl mx-auto z-10">
        {{-- Search Box --}}
        <div class="bg-white/10 backdrop-blur-xl border border-white/20 p-8 rounded-3xl shadow-2xl shadow-primary/20">
            <h3 class="text-2xl font-bold text-white mb-2 text-center">Cek Status Kupon Anda</h3>
            <p class="text-stone-400 text-center mb-8 text-sm">Masukkan kode unik pada kupon kurban Anda untuk melihat detail dan status penerimaan daging.</p>
            
            <form wire:submit="search" class="relative">
                <div class="flex flex-col md:flex-row gap-3">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input wire:model="searchCode" type="text" placeholder="Contoh: QURBAN-XXXXX" 
                               class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 pl-12 pr-4 text-white placeholder-stone-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition uppercase tracking-wider font-mono">
                    </div>
                    <button type="submit" class="bg-primary hover:bg-teal-600 text-white font-bold py-4 px-8 rounded-2xl shadow-lg transition-all flex items-center justify-center gap-2 group">
                        <span wire:loading.remove wire:target="search">Periksa</span>
                        <span wire:loading wire:target="search">Memeriksa...</span>
                        <svg wire:loading.remove wire:target="search" class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
                @error('searchCode')
                    <p class="text-red-400 text-sm mt-2 ml-2">{{ $message }}</p>
                @enderror
            </form>

            {{-- Results Area --}}
            @if($hasSearched)
                <div class="mt-8 pt-8 border-t border-white/10" wire:transition>
                    @if($coupon)
                        <div class="bg-white/5 border border-white/10 rounded-2xl p-6 relative overflow-hidden">
                            {{-- Watermark / background icon --}}
                            <div class="absolute -right-6 -bottom-6 opacity-5 pointer-events-none">
                                <svg class="w-48 h-48 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>

                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h4 class="text-stone-400 text-xs font-semibold uppercase tracking-wider mb-1">Hasil Pencarian</h4>
                                    <p class="text-xl font-mono font-bold text-white tracking-widest">{{ $coupon->code }}</p>
                                </div>
                                <div>
                                    @if($coupon->status === 'diterima')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-emerald-500/20 border border-emerald-500/30 text-emerald-400 text-sm font-bold shadow-[0_0_15px_rgba(16,185,129,0.2)]">
                                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                            Sudah Diterima
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-amber-500/20 border border-amber-500/30 text-amber-400 text-sm font-bold shadow-[0_0_15px_rgba(245,158,11,0.2)]">
                                            <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                                            Belum Diambil
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-y-4 gap-x-6 text-sm">
                                <div>
                                    <p class="text-stone-500 text-xs uppercase mb-0.5">Nama Pengkurban</p>
                                    <p class="text-stone-200 font-medium">{{ $coupon->sacrificer_name ?? 'Hamba Allah' }}</p>
                                </div>
                                <div>
                                    <p class="text-stone-500 text-xs uppercase mb-0.5">Jenis Kurban</p>
                                    <p class="text-stone-200 font-medium capitalize">{{ $coupon->type }}</p>
                                </div>
                                <div>
                                    <p class="text-stone-500 text-xs uppercase mb-0.5">Wilayah Penyaluran</p>
                                    <p class="text-stone-200 font-medium">{{ $coupon->region ? $coupon->region->name : '-' }}</p>
                                </div>
                                @if($coupon->status === 'diterima')
                                    <div>
                                        <p class="text-stone-500 text-xs uppercase mb-0.5">Waktu Pengambilan</p>
                                        <p class="text-emerald-400 font-bold">
                                            {{ $coupon->received_at ? $coupon->received_at->format('d M Y - H:i') : '-' }} WIB
                                        </p>
                                    </div>
                                @endif
                            </div>

                            <div class="mt-6 flex justify-center">
                                <button wire:click="resetSearch" class="text-sm text-stone-400 hover:text-white transition underline underline-offset-4">Cek Kupon Lain</button>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-6">
                            <div class="w-16 h-16 rounded-full bg-red-500/10 flex items-center justify-center mx-auto mb-4 border border-red-500/20">
                                <svg class="w-8 h-8 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <h4 class="text-white font-bold mb-2">Kupon Tidak Ditemukan</h4>
                            <p class="text-stone-400 text-sm max-w-sm mx-auto mb-4">Pastikan kode yang Anda masukkan sudah benar (misal: QURBAN-XXXX). Periksa kembali huruf besar dan kecilnya atau hubungi panitia.</p>
                            <button wire:click="resetSearch" class="px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-sm text-white hover:bg-white/10 transition">Coba Lagi</button>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
