<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SI Qurban — Sistem Distribusi Kupon Kurban Digital</title>
    <meta name="description"
        content="SI Qurban membantu panitia masjid mengelola distribusi daging kurban secara tertib, terdokumentasi, dan mudah dioperasikan.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&family=Amiri:wght@400;700&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>

        .float-anim {
            animation: floatY 4s ease-in-out infinite;
        }

        .float-anim-delay {
            animation: floatY 4s ease-in-out infinite 1.5s;
        }

        @keyframes floatY {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .blob {
            filter: blur(80px);
            animation: blobPulse 8s ease-in-out infinite;
        }

        @keyframes blobPulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }
    </style>
</head>

<body class="text-white overflow-x-hidden" style="background:#050d14">

    {{-- ░░ NAVBAR ░░ --}}
    <nav class="fixed top-0 inset-x-0 z-50 nav-blur">
        <div class="mx-auto max-w-7xl flex items-center justify-between px-6 py-4">
            {{-- Logo --}}
            <div class="flex items-center gap-3">
                <div class="relative">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-teal-500 to-cyan-600 flex items-center justify-center shadow-lg glow-teal">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
                <div>
                    <div class="flex items-baseline gap-2">
                        <span class="text-xl font-black text-white tracking-tight">SI Qurban</span>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-teal-400/70 hidden sm:inline border border-teal-500/30 rounded-full px-2 py-0.5">v2.0</span>
                    </div>
                    <p class="text-[10px] text-slate-500 hidden sm:block">Distribusi Kurban Digital</p>
                </div>
            </div>
            {{-- Nav Actions --}}
            <div class="flex items-center gap-2">
                <a href="#cek-kupon"
                    class="hidden md:inline-flex items-center gap-2 rounded-xl glass px-4 py-2 text-sm font-semibold text-slate-300 hover:text-white hover:glass-strong transition-all">
                    <svg class="w-4 h-4 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Cek Kupon
                </a>
                <a href="{{ route('login') }}"
                    class="text-sm font-semibold text-slate-300 hover:text-white transition px-4 py-2 rounded-xl hover:bg-white/5">Masuk</a>
                <a href="{{ route('register') }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-teal-500 to-cyan-600 px-5 py-2.5 text-sm font-bold text-white hover:from-teal-400 hover:to-cyan-500 transition-all glow-teal">
                    Daftar Panitia
                </a>
            </div>
        </div>
    </nav>

    {{-- ░░ HERO ░░ --}}
    <section class="relative min-h-[100svh] flex items-center pt-24 overflow-hidden">
        {{-- Animated Background Elements --}}
        <div class="absolute top-1/4 -left-32 w-96 h-96 bg-teal-500/20 rounded-full blob pointer-events-none mix-blend-screen"></div>
        <div class="absolute bottom-1/4 -right-32 w-96 h-96 bg-indigo-500/10 rounded-full blob pointer-events-none mix-blend-screen" style="animation-delay: 2s; animation-duration: 10s"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-cyan-500/5 rounded-full blob pointer-events-none mix-blend-screen" style="animation-delay: 4s; animation-duration: 15s"></div>

        <div class="relative mx-auto max-w-7xl px-6 py-20 grid lg:grid-cols-2 gap-16 lg:gap-24 items-center">
            
            {{-- Hero Content --}}
            <div class="relative z-10">
                <div class="inline-flex items-center gap-2 rounded-full glass-strong px-4 py-1.5 text-xs font-bold tracking-widest text-teal-300 mb-8 uppercase border-teal-500/30">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-teal-500"></span>
                    </span>
                    Magister Teknik Informatika 12
                </div>
                
                <h1 class="text-5xl sm:text-6xl lg:text-[4.5rem] font-black leading-[1.1] text-white tracking-tight">
                    Distribusi<br>
                    <span class="gradient-text">Kurban Digital</span><br>
                    Lebih Cerdas.
                </h1>
                
                <p class="mt-8 text-lg sm:text-xl text-slate-400 max-w-xl leading-relaxed font-light">
                    Transformasi manajemen pembagian daging kurban. Dari <strong class="text-slate-200 font-semibold">QR Code otomatis</strong> hingga <strong class="text-slate-200 font-semibold">verifikasi scan 1 detik</strong>. Lebih tertib, transparan, dan aman.
                </p>
                
                <div class="mt-10 flex flex-wrap gap-4 sm:gap-6">
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center justify-center gap-3 rounded-2xl bg-gradient-to-r from-teal-500 to-cyan-600 px-8 py-4 text-base font-bold text-white transition-all hover:scale-[1.02] active:scale-[0.98] glow-teal group">
                        <span>Mulai Sekarang</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                    <a href="#fitur"
                        class="inline-flex items-center justify-center gap-3 rounded-2xl glass-strong px-8 py-4 text-base font-semibold text-slate-200 hover:bg-white/10 hover:text-white transition-all hover:scale-[1.02] active:scale-[0.98]">
                        Lihat Fitur
                    </a>
                </div>

                {{-- Key Stats --}}
                <div class="mt-14 flex items-center gap-6 sm:gap-10 border-t border-slate-800 pt-10">
                    <div>
                        <div class="flex items-baseline gap-1">
                            <p class="text-3xl font-black text-white">100</p>
                            <span class="text-xl font-bold text-teal-400">%</span>
                        </div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest mt-1">Terdata Digital</p>
                    </div>
                    <div class="w-px h-12 bg-slate-800"></div>
                    <div>
                        <div class="flex items-baseline gap-1">
                            <p class="text-3xl font-black text-white">2</p>
                            <span class="text-xl font-bold text-cyan-400">Tipe</span>
                        </div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest mt-1">Sistem Kupon</p>
                    </div>
                    <div class="w-px h-12 bg-slate-800 hidden sm:block"></div>
                    <div class="hidden sm:block">
                        <div class="flex items-baseline gap-1">
                            <p class="text-3xl font-black text-white">< 1</p>
                            <span class="text-xl font-bold text-indigo-400">dtk</span>
                        </div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest mt-1">Scan Verifikasi</p>
                    </div>
                </div>
            </div>

            {{-- Dashboard Mockup --}}
            <div class="relative w-full max-w-lg mx-auto lg:max-w-none perspective-[1000px]">
                <div class="absolute inset-0 bg-gradient-to-tr from-teal-500 to-cyan-500 rounded-[2.5rem] blur-3xl opacity-20 orbit"></div>
                
                <div class="relative float rounded-[2rem] glass p-6 sm:p-8 border-t border-l border-white/20 shadow-2xl overflow-hidden group">
                    <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-white/5 to-transparent pointer-events-none"></div>
                    <div class="absolute -inset-1 opacity-0 group-hover:opacity-100 transition duration-1000 bg-gradient-to-r from-teal-500/20 via-cyan-500/20 to-indigo-500/20 blur-xl pointer-events-none"></div>
                    
                    {{-- Browser header --}}
                    <div class="flex items-center gap-2 mb-6 pb-4 border-b border-white/5">
                        <div class="flex gap-1.5">
                            <div class="w-3 h-3 rounded-full bg-rose-500"></div>
                            <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                            <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                        </div>
                        <div class="mx-auto flex items-center gap-2 px-3 py-1.5 rounded-full bg-black/20 text-[10px] sm:text-xs text-slate-400 font-mono backdrop-blur-sm border border-white/5">
                            <svg class="w-3 h-3 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            app.siqurban.com
                        </div>
                    </div>

                    {{-- Mockup Content --}}
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="rounded-2xl bg-gradient-to-br from-slate-800/80 to-slate-900/80 p-5 border border-slate-700/50 relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-16 h-16 bg-teal-500/10 rounded-bl-full"></div>
                            <p class="text-xs font-semibold text-slate-400 mb-1">Total Kupon</p>
                            <p class="text-3xl font-black text-white">248</p>
                        </div>
                        <div class="rounded-2xl bg-gradient-to-br from-emerald-500/20 to-emerald-900/40 p-5 border border-emerald-500/30 relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-16 h-16 bg-emerald-500/20 rounded-bl-full"></div>
                            <p class="text-xs font-semibold text-emerald-300 mb-1">Telah Diterima</p>
                            <p class="text-3xl font-black text-emerald-400">187</p>
                        </div>
                    </div>
                    
                    <div class="rounded-2xl glass-strong p-5 border border-slate-700/50">
                        <div class="flex items-center justify-between mb-4">
                            <p class="text-xs font-bold text-slate-300 uppercase tracking-widest">Progress Wilayah</p>
                            <span class="text-[10px] px-2 py-1 rounded bg-teal-500/20 text-teal-300 font-bold">Live</span>
                        </div>
                        <div class="space-y-4">
                            @foreach(['Pusat', 'Timur', 'Barat'] as $i => $w)
                                <div>
                                    <div class="flex justify-between text-xs mb-1.5 font-medium">
                                        <span class="text-slate-400">Wilayah {{ $w }}</span>
                                        <span class="text-white">{{ [75, 60, 90][$i] }}%</span>
                                    </div>
                                    <div class="h-2 rounded-full bg-black/40 overflow-hidden relative">
                                        <div class="absolute top-0 left-0 h-full rounded-full bg-gradient-to-r {{ ['from-teal-600 to-teal-400', 'from-cyan-600 to-cyan-400', 'from-indigo-600 to-indigo-400'][$i] }}" style="width:{{ [75, 60, 90][$i] }}%">
                                            <div class="w-full h-full shimmer"></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- QR Code Scan Notification Mockup --}}
                    <div class="absolute -bottom-6 sm:-bottom-8 -left-4 sm:-left-8 glass-strong rounded-2xl p-4 flex items-center gap-4 shadow-2xl border border-emerald-500/30 w-[110%] sm:w-auto transform rotate-[-2deg] z-20">
                        <div class="w-12 h-12 rounded-full bg-emerald-500/20 flex items-center justify-center relative shrink-0">
                            <div class="absolute inset-0 rounded-full pulse-ring"></div>
                            <svg class="w-6 h-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-white mb-0.5">Kupon Terverifikasi!</p>
                            <p class="text-xs text-slate-400">PKB-2026-UNWC001 • Bpk. Ahmad</p>
                        </div>
                        <div class="ml-auto text-xs font-bold text-emerald-400">Baru saja</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ░░ CEK KUPON GUEST ░░ --}}
    <section id="cek-kupon" class="relative py-32 overflow-hidden">
        <div class="section-divider absolute top-0 w-full"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-[#050d14] via-[#05131f] to-[#050d14]"></div>
        
        <div class="relative z-10 w-full max-w-3xl mx-auto px-6">
            <div class="text-center mb-10">
                <span class="badge-pill bg-cyan-500/10 text-cyan-400 border border-cyan-500/20 mb-4">Verifikasi Publik</span>
                <h2 class="text-3xl md:text-4xl font-black text-white mb-4">Lacak Kupon Kurban Anda</h2>
                <p class="text-slate-400">Masukkan kode unik dari panitia untuk melihat status penerimaan daging kurban.</p>
            </div>

            {{-- Search Box --}}
            <div class="glass-strong p-8 sm:p-12 rounded-[2rem] shadow-2xl relative overflow-hidden group">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-teal-500 to-cyan-500"></div>
                <div class="absolute -right-32 -top-32 w-64 h-64 bg-teal-500/10 rounded-full blur-3xl group-hover:bg-teal-500/20 transition-all duration-700"></div>
                
                <form id="couponForm" class="relative z-10">
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                <svg class="w-6 h-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input id="searchCode" type="text" placeholder="Contoh: QURBAN-XXXXX" 
                                   style="padding-left: 3.5rem;"
                                   class="w-full bg-slate-900/50 border border-slate-700/50 rounded-2xl py-5 pr-5 text-lg text-white focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all uppercase tracking-widest font-mono" required>
                        </div>
                        <button type="submit" id="submitBtn" class="bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-400 hover:to-cyan-500 text-white font-bold py-5 px-10 rounded-2xl shadow-lg transition-all flex items-center justify-center gap-3 glow-teal disabled:opacity-70 disabled:cursor-not-allowed">
                            <span id="btnText">Lacak</span>
                            <span id="btnLoading" style="display: none;">Melacak...</span>
                            <svg id="btnIcon" class="w-5 h-5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                    <p id="errorMsg" style="display: none;" class="text-rose-400 text-sm mt-3 ml-3 font-medium"></p>
                </form>

                {{-- Results Area --}}
                <div id="resultArea" style="display: none;" class="mt-10 pt-10 border-t border-slate-700/50 transition-all duration-500 relative z-10">
                    
                    {{-- Sukses --}}
                    <div id="resultSuccess" style="display: none;" class="bg-slate-900/60 border border-slate-700/50 rounded-[1.5rem] p-8 relative overflow-hidden backdrop-blur-md">
                        <div class="absolute -right-6 -bottom-6 opacity-[0.03] pointer-events-none">
                            <svg class="w-64 h-64 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="0.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>

                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                            <div>
                                <h4 class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mb-1.5">Kode Ditemukan</h4>
                                <p id="resCode" class="text-2xl font-mono font-black text-white tracking-widest"></p>
                            </div>
                            <div>
                                <span id="badgeDiterima" style="display: none;" class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm font-bold">
                                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse shadow-[0_0_10px_rgba(52,211,153,0.8)]"></span>
                                    Sudah Diterima
                                </span>
                                <span id="badgeBelum" style="display: none;" class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-400 text-sm font-bold">
                                    <span class="w-2.5 h-2.5 rounded-full bg-amber-400 shadow-[0_0_10px_rgba(251,191,36,0.8)]"></span>
                                    Belum Diambil
                                </span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-y-6 gap-x-8">
                            <div>
                                <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest mb-1">Pekurban</p>
                                <p id="resName" class="text-slate-200 font-semibold text-lg"></p>
                            </div>
                            <div>
                                <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest mb-1">Jenis Hewan</p>
                                <p id="resType" class="text-slate-200 font-semibold text-lg capitalize"></p>
                            </div>
                            <div>
                                <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest mb-1">Wilayah Distribusi</p>
                                <p id="resRegion" class="text-slate-200 font-semibold text-lg"></p>
                            </div>
                            <div id="resTimeContainer" style="display: none;">
                                <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest mb-1">Waktu Diterima</p>
                                <p id="resTime" class="text-emerald-400 font-black text-lg"></p>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-slate-700/50 flex justify-center">
                            <button type="button" onclick="resetSearch()" class="text-sm font-semibold text-slate-400 hover:text-white transition-colors underline underline-offset-4 decoration-slate-600 hover:decoration-white">Lacak Kupon Lain</button>
                        </div>
                    </div>
                    
                    {{-- Tidak Ditemukan --}}
                    <div id="resultNotFound" style="display: none;" class="text-center py-8">
                        <div class="w-20 h-20 rounded-full bg-rose-500/10 flex items-center justify-center mx-auto mb-5 border border-rose-500/20">
                            <svg class="w-10 h-10 text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <h4 class="text-xl text-white font-black mb-3">Kupon Tidak Ditemukan</h4>
                        <p class="text-slate-400 text-sm max-w-sm mx-auto mb-6 leading-relaxed">Kode kupon <strong class="text-white font-mono">tidak valid</strong> atau belum terdaftar di sistem. Periksa kembali huruf dan angkanya.</p>
                        <button type="button" onclick="resetSearch()" class="px-6 py-3 bg-slate-800 border border-slate-700 rounded-xl text-sm font-bold text-white hover:bg-slate-700 transition-colors">Coba Lagi</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ░░ FITUR ░░ --}}
    <section id="fitur" class="py-32 relative">
        <div class="section-divider absolute top-0 w-full"></div>
        <div class="mx-auto max-w-7xl px-6 relative z-10">
            <div class="text-center mb-20">
                <span class="badge-pill bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 mb-4">Solusi Lengkap</span>
                <h2 class="text-4xl md:text-5xl font-black text-white mb-6 tracking-tight">Dirancang Untuk <span class="gradient-text">Kemudahan</span></h2>
                <p class="text-lg text-slate-400 max-w-2xl mx-auto font-light">
                    Meninggalkan cara manual. Menyambut efisiensi dengan alat yang didesain khusus untuk kepanitiaan masjid modern.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 relative">
                {{-- Decorative connecting lines --}}
                <div class="step-connector"></div>

                @php
                    $features = [
                        ['icon' => 'M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z', 'title' => 'Generate Instan', 'desc' => 'Buat ratusan kupon dengan QR Code unik secara massal dalam hitungan detik.', 'color' => 'bg-teal-500/10 text-teal-400 border-teal-500/20'],
                        ['icon' => 'M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z', 'title' => 'Scan QR Code', 'desc' => 'Gunakan kamera smartphone untuk verifikasi cepat saat pengambilan daging.', 'color' => 'bg-cyan-500/10 text-cyan-400 border-cyan-500/20'],
                        ['icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'title' => 'Statistik Real-time', 'desc' => 'Pantau progress distribusi daging secara live dari dashboard admin.', 'color' => 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20'],
                        ['icon' => 'M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12', 'title' => 'Import Excel/CSV', 'desc' => 'Unggah data jamaah dan wilayah dari file spreadsheet untuk setup instan.', 'color' => 'bg-amber-500/10 text-amber-400 border-amber-500/20'],
                        ['icon' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z', 'title' => 'Pemetaan Wilayah', 'desc' => 'Distribusi lebih terorganisir dengan pengelompokan kupon berdasarkan area.', 'color' => 'bg-rose-500/10 text-rose-400 border-rose-500/20'],
                        ['icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z', 'title' => 'Keamanan Multi-Role', 'desc' => 'Pemisahan akses Admin dan Panitia Scan untuk menjaga integritas data.', 'color' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20'],
                    ];
                @endphp
                
                @foreach($features as $i => $f)
                    <div class="card-hover glass p-8 rounded-[2rem] border border-slate-800 bg-[#0a1520] relative z-10">
                        <div class="feature-icon-wrap border {{ $f['color'] }}">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $f['icon'] }}" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3 tracking-tight">{{ $f['title'] }}</h3>
                        <p class="text-sm text-slate-400 leading-relaxed font-light">{{ $f['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ░░ ROLES ░░ --}}
    <section class="bg-[#050d14] py-32 relative overflow-hidden">
        {{-- Background elements --}}
        <div class="absolute top-1/2 left-0 w-[500px] h-[500px] bg-teal-500/5 rounded-full blur-[100px] -translate-y-1/2"></div>
        <div class="absolute top-1/2 right-0 w-[500px] h-[500px] bg-cyan-500/5 rounded-full blur-[100px] -translate-y-1/2"></div>

        <div class="mx-auto max-w-7xl px-6 relative z-10">
            <div class="text-center mb-20">
                <span class="badge-pill bg-teal-500/10 text-teal-400 border border-teal-500/20 mb-4">Akses Terspesialisasi</span>
                <h2 class="text-4xl md:text-5xl font-black text-white mb-6 tracking-tight">Peran Sesuai <span class="gradient-text">Tugas</span></h2>
            </div>
            
            <div class="grid md:grid-cols-2 gap-8 lg:gap-12">
                {{-- Admin Card --}}
                <div class="rounded-[2.5rem] glass p-10 border-t border-l border-white/10 relative overflow-hidden group hover:border-teal-500/30 transition-colors duration-500 bg-gradient-to-br from-[#0a1520] to-[#050d14]">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-teal-500/10 rounded-bl-full group-hover:scale-110 transition-transform duration-700"></div>
                    
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-teal-500 to-cyan-600 flex items-center justify-center mb-8 shadow-lg glow-teal">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                    
                    <h3 class="text-3xl font-black text-white mb-3">Administrator</h3>
                    <p class="text-slate-400 mb-8 font-light">Pemegang kendali penuh. Mengelola seluruh master data, kupon, wilayah, dan memantau analitik distribusi secara keseluruhan.</p>
                    
                    <ul class="space-y-4">
                        @foreach(['Dashboard statistik & grafik distribusi real-time', 'Manajemen user, wilayah, dan pembuatan kupon massal', 'Riwayat scan seluruh panitia dan pantauan aktivitas', 'Rekapitulasi total & ekspor laporan CSV/Excel otomatis', 'Pengaturan sistem: Nama instansi & tahun kurban'] as $item)
                            <li class="flex items-start gap-4 text-slate-300 font-light">
                                <div class="w-6 h-6 rounded-full bg-teal-500/20 flex items-center justify-center shrink-0 mt-0.5">
                                    <svg class="w-3.5 h-3.5 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                {{ $item }}
                            </li>
                        @endforeach
                    </ul>
                </div>
                
                {{-- Panitia Card --}}
                <div class="rounded-[2.5rem] glass p-10 border-t border-l border-white/10 relative overflow-hidden group hover:border-cyan-500/30 transition-colors duration-500 bg-gradient-to-br from-[#0a1520] to-[#050d14]">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-cyan-500/10 rounded-bl-full group-hover:scale-110 transition-transform duration-700"></div>
                    
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-slate-700 to-slate-800 border border-slate-600 flex items-center justify-center mb-8 shadow-lg">
                        <svg class="w-8 h-8 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                        </svg>
                    </div>
                    
                    <h3 class="text-3xl font-black text-white mb-3">Panitia Scan</h3>
                    <p class="text-slate-400 mb-8 font-light">Petugas lapangan di hari H. Bertanggung jawab memverifikasi kehadiran warga dan menyerahkan daging qurban.</p>
                    
                    <ul class="space-y-4">
                        @foreach(['Akses cepat ke antarmuka Scanner QR Code via kamera', 'Input kode kupon manual sebagai alternatif (fallback)', 'Notifikasi instan hasil verifikasi: Diterima / Ditolak', 'Melihat riwayat scan pribadi yang telah dilakukan', 'Update profil akun dan pengelolaan kata sandi pribadi'] as $item)
                            <li class="flex items-start gap-4 text-slate-300 font-light">
                                <div class="w-6 h-6 rounded-full bg-cyan-500/20 flex items-center justify-center shrink-0 mt-0.5">
                                    <svg class="w-3.5 h-3.5 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                {{ $item }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- ░░ CTA ░░ --}}
    <section class="relative py-32 overflow-hidden border-y border-white/5">
        <div class="absolute inset-0 bg-gradient-to-b from-[#0a1520] to-[#050d14]"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-teal-500/10 rounded-full blur-[120px] pointer-events-none"></div>
        
        <div class="relative z-10 mx-auto max-w-4xl px-6 text-center">
            <span class="inline-block text-4xl mb-6 animate-bounce">🕋</span>
            <h2 class="text-5xl md:text-6xl font-black text-white mb-8 tracking-tight leading-tight">Wujudkan Distribusi Kurban <br class="hidden md:block"><span class="gradient-text">Yang Lebih Bermakna</span></h2>
            <p class="text-xl text-slate-400 mb-12 max-w-2xl mx-auto font-light leading-relaxed">Bergabunglah dengan masjid lainnya yang telah beralih ke manajemen kurban digital. Mudah digunakan, aman, dan 100% gratis.</p>
            
            <div class="flex flex-col sm:flex-row gap-5 justify-center items-center">
                <a href="{{ route('register') }}"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-3 rounded-2xl bg-gradient-to-r from-teal-500 to-cyan-600 px-10 py-5 text-lg font-bold text-white transition-all hover:scale-[1.02] active:scale-[0.98] glow-teal group">
                    Mulai Gunakan Sistem
                    <svg class="w-6 h-6 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
                <a href="{{ route('login') }}"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-2xl glass-strong px-10 py-5 text-lg font-semibold text-white hover:bg-white/10 transition-all">
                    Masuk ke Akun Anda
                </a>
            </div>
        </div>
    </section>

    {{-- ░░ FOOTER ░░ --}}
    <footer class="bg-[#050d14] py-12 border-t border-white/5 relative z-10">
        <div class="mx-auto max-w-7xl px-6 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-teal-500 to-cyan-600 flex items-center justify-center shadow-lg shadow-teal-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div>
                    <span class="font-black text-white text-lg tracking-tight block">SI Qurban</span>
                    <span class="text-slate-500 text-xs uppercase tracking-widest font-semibold">Distribusi Kurban Digital</span>
                </div>
            </div>
            <div class="text-center md:text-right">
                <p class="text-slate-400 text-sm font-light">Dikembangkan untuk <strong class="text-slate-200">Magister Teknik Informatika 12</strong></p>
                <p class="text-slate-600 text-xs mt-1">&copy; {{ date('Y') }} SI Qurban. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        function resetSearch() {
            document.getElementById('searchCode').value = '';
            document.getElementById('resultArea').style.display = 'none';
            document.getElementById('resultSuccess').style.display = 'none';
            document.getElementById('resultNotFound').style.display = 'none';
            document.getElementById('errorMsg').style.display = 'none';
            document.getElementById('searchCode').focus();
        }

        document.getElementById('couponForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const searchInput = document.getElementById('searchCode');
            const code = searchInput.value.trim();
            const errorMsg = document.getElementById('errorMsg');
            
            const btnText = document.getElementById('btnText');
            const btnLoading = document.getElementById('btnLoading');
            const btnIcon = document.getElementById('btnIcon');
            const submitBtn = document.getElementById('submitBtn');

            // Reset areas
            document.getElementById('resultArea').style.display = 'none';
            document.getElementById('resultSuccess').style.display = 'none';
            document.getElementById('resultNotFound').style.display = 'none';
            errorMsg.style.display = 'none';

            if (!code || code.length < 4) {
                errorMsg.textContent = 'Kode kupon minimal 4 karakter.';
                errorMsg.style.display = 'block';
                return;
            }

            // Set loading state
            submitBtn.disabled = true;
            btnText.style.display = 'none';
            btnIcon.style.display = 'none';
            btnLoading.style.display = 'inline-block';

            try {
                const response = await fetch('/api/check-coupon/' + encodeURIComponent(code));
                document.getElementById('resultArea').style.display = 'block';
                
                if (response.ok) {
                    const data = await response.json();
                    
                    document.getElementById('resCode').textContent = data.code;
                    document.getElementById('resName').textContent = data.sacrificer_name || 'Hamba Allah';
                    document.getElementById('resType').textContent = data.type;
                    document.getElementById('resRegion').textContent = data.region_name || '-';
                    
                    if (data.status === 'diterima') {
                        document.getElementById('badgeDiterima').style.display = 'inline-flex';
                        document.getElementById('badgeBelum').style.display = 'none';
                        document.getElementById('resTimeContainer').style.display = 'block';
                        document.getElementById('resTime').textContent = (data.received_at || '-') + ' WIB';
                    } else {
                        document.getElementById('badgeDiterima').style.display = 'none';
                        document.getElementById('badgeBelum').style.display = 'inline-flex';
                        document.getElementById('resTimeContainer').style.display = 'none';
                    }

                    document.getElementById('resultSuccess').style.display = 'block';
                } else {
                    document.getElementById('resultNotFound').style.display = 'block';
                }
            } catch (error) {
                console.error(error);
                errorMsg.textContent = 'Terjadi kesalahan koneksi. Silakan coba lagi.';
                errorMsg.style.display = 'block';
            } finally {
                // Remove loading state
                submitBtn.disabled = false;
                btnText.style.display = 'inline-block';
                btnIcon.style.display = 'block';
                btnLoading.style.display = 'none';
            }
        });
    </script>
</body>

</html>