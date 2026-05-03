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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #0f766e 0%, #134e4a 40%, #1a2e2b 100%);
        }

        .feature-card:hover {
            transform: translateY(-4px);
        }

        .feature-card {
            transition: all 0.25s ease;
        }

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

<body class="bg-slate-950 text-white overflow-x-hidden">

    {{-- ░░ NAVBAR ░░ --}}
    <nav class="fixed top-0 inset-x-0 z-50 border-b border-white/10 bg-slate-950/80 backdrop-blur-xl">
        <div class="mx-auto max-w-7xl flex items-center justify-between px-4 py-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-primary flex items-center justify-center shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div>
                    <span class="text-xl font-bold text-white">SI Qurban</span>
                    <span
                        class="ml-2 text-[10px] font-semibold uppercase tracking-wider text-primary/80 hidden sm:inline">v2.0</span>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="#cek-kupon"
                    class="hidden md:inline-flex items-center gap-2 rounded-xl bg-white/10 px-4 py-2 text-sm font-semibold text-white border border-white/20 hover:bg-white/20 transition shadow-lg">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Cek Kupon
                </a>
                <a href="{{ route('login') }}"
                    class="text-sm font-medium text-stone-300 hover:text-white transition px-4 py-2 rounded-xl hover:bg-white/5">Masuk</a>
                <a href="{{ route('register') }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white hover:bg-teal-600 transition shadow-lg shadow-primary/30">
                    Daftar Panitia
                </a>
            </div>
        </div>
    </nav>

    {{-- ░░ HERO ░░ --}}
    <section class="relative min-h-screen flex items-center pt-20 overflow-hidden">
        {{-- Blobs --}}
        <div class="absolute top-20 left-1/4 w-96 h-96 bg-primary/30 rounded-full blob pointer-events-none"></div>
        <div class="absolute bottom-10 right-1/4 w-64 h-64 bg-teal-400/20 rounded-full blob pointer-events-none"
            style="animation-delay:2s"></div>

        <div class="relative mx-auto max-w-7xl px-4 py-24 grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <div
                    class="inline-flex items-center gap-2 rounded-full border border-primary/40 bg-primary/10 px-4 py-1.5 text-sm font-semibold text-primary mb-8">
                    <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                    Design By — Magister Teknik Informatika
                </div>
                <h1 class="text-5xl md:text-6xl font-black leading-tight text-white">
                    Distribusi<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-teal-400">Kurban
                        Digital</span><br>
                    Lebih Tertib
                </h1>
                <p class="mt-6 text-lg text-stone-400 max-w-lg leading-relaxed">
                    SI Qurban membantu panitia masjid dan lembaga mengelola distribusi daging kurban — dari generate
                    kupon QR Code hingga verifikasi scan saat pembagian.
                </p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center gap-2 rounded-2xl bg-primary px-6 py-3.5 text-base font-bold text-white shadow-xl shadow-primary/40 hover:bg-teal-600 transition-all hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        Daftar Sekarang
                    </a>
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-6 py-3.5 text-base font-semibold text-white hover:bg-white/10 transition-all hover:-translate-y-0.5">
                        Masuk ke Dashboard
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                {{-- Stats --}}
                <div class="mt-12 flex flex-wrap gap-8">
                    <div>
                        <p class="text-3xl font-black text-white">100%</p>
                        <p class="text-sm text-stone-400 mt-1">Terdata Digital</p>
                    </div>
                    <div class="w-px bg-white/10"></div>
                    <div>
                        <p class="text-3xl font-black text-white">2 Tipe</p>
                        <p class="text-sm text-stone-400 mt-1">Kupon Didukung</p>
                    </div>
                    <div class="w-px bg-white/10"></div>
                    <div>
                        <p class="text-3xl font-black text-white">QR Code</p>
                        <p class="text-sm text-stone-400 mt-1">Scan & Verifikasi</p>
                    </div>
                </div>
            </div>

            {{-- Dashboard mockup --}}
            <div class="relative float-anim">
                <div class="rounded-3xl border border-white/10 bg-white/5 backdrop-blur-sm p-6 shadow-2xl">
                    <div class="flex items-center gap-2 mb-5">
                        <div class="w-3 h-3 rounded-full bg-red-500"></div>
                        <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                        <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                        <span class="ml-2 text-xs text-stone-500">dashboard.siqurban.local</span>
                    </div>
                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <div class="rounded-2xl bg-primary/20 border border-primary/20 p-4">
                            <p class="text-xs text-primary/70">Total Kupon</p>
                            <p class="text-3xl font-black text-white mt-1">248</p>
                        </div>
                        <div class="rounded-2xl bg-emerald-500/20 border border-emerald-500/20 p-4">
                            <p class="text-xs text-emerald-400/70">Sudah Diterima</p>
                            <p class="text-3xl font-black text-white mt-1">187</p>
                        </div>
                    </div>
                    <div class="rounded-2xl bg-white/5 border border-white/10 p-4">
                        <p class="text-xs text-stone-400 mb-3">Progress Distribusi</p>
                        <div class="space-y-2">
                            @foreach(['Pusat', 'Timur', 'Barat'] as $i => $w)
                                <div>
                                    <div class="flex justify-between text-xs mb-1">
                                        <span class="text-stone-300">Wilayah {{ $w }}</span>
                                        <span class="text-primary">{{ [75, 60, 90][$i] }}%</span>
                                    </div>
                                    <div class="h-1.5 rounded-full bg-white/10">
                                        <div class="h-full rounded-full bg-primary" style="width:{{ [75, 60, 90][$i] }}%">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    {{-- QR Code sample --}}
                    <div class="mt-4 flex items-center gap-3 rounded-2xl border border-white/10 bg-white/5 p-3">
                        <div class="w-12 h-12 rounded-xl bg-white p-1.5 flex-shrink-0">
                            <svg viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                                <rect width="9" height="9" x="0" y="0" fill="#0f766e" />
                                <rect width="7" height="7" x="1" y="1" fill="#fff" />
                                <rect width="5" height="5" x="2" y="2" fill="#0f766e" />
                                <rect width="9" height="9" x="12" y="0" fill="#0f766e" />
                                <rect width="7" height="7" x="13" y="1" fill="#fff" />
                                <rect width="5" height="5" x="14" y="2" fill="#0f766e" />
                                <rect width="9" height="9" x="0" y="12" fill="#0f766e" />
                                <rect width="7" height="7" x="1" y="13" fill="#fff" />
                                <rect width="5" height="5" x="2" y="14" fill="#0f766e" />
                                <rect width="1" height="1" x="12" y="12" fill="#0f766e" />
                                <rect width="1" height="1" x="14" y="12" fill="#0f766e" />
                                <rect width="1" height="1" x="16" y="14" fill="#0f766e" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-white">KPN-20261445-ABCDE3</p>
                            <p class="text-xs text-stone-400">Wilayah Pusat • Pengkurban</p>
                        </div>
                        <span
                            class="ml-auto text-[10px] font-bold text-emerald-400 rounded-full bg-emerald-400/10 px-2 py-1">Diterima</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ░░ CEK KUPON GUEST ░░ --}}
    <section id="cek-kupon" class="relative py-24 bg-slate-950 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-primary/5 to-transparent"></div>
        <div class="relative z-10 w-full max-w-2xl mx-auto px-4">
            {{-- Search Box --}}
            <div class="bg-white/10 backdrop-blur-xl border border-white/20 p-8 rounded-3xl shadow-2xl shadow-primary/20">
                <h3 class="text-2xl font-bold text-white mb-2 text-center">Cek Status Kupon Anda</h3>
                <p class="text-stone-400 text-center mb-8 text-sm">Masukkan kode unik pada kupon kurban Anda untuk melihat detail dan status penerimaan daging.</p>
                
                <form id="couponForm" class="relative">
                    <div class="flex flex-col md:flex-row gap-3">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input id="searchCode" type="text" placeholder="Contoh: QURBAN-XXXXX" 
                                   style="padding-left: 3rem;"
                                   class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 pr-4 text-white placeholder-stone-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition uppercase tracking-wider font-mono" required>
                        </div>
                        <button type="submit" id="submitBtn" class="bg-primary hover:bg-teal-600 text-white font-bold py-4 px-8 rounded-2xl shadow-lg transition-all flex items-center justify-center gap-2 group disabled:opacity-70">
                            <span id="btnText">Periksa</span>
                            <span id="btnLoading" style="display: none;">Memeriksa...</span>
                            <svg id="btnIcon" class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                    <p id="errorMsg" style="display: none;" class="text-red-400 text-sm mt-2 ml-2"></p>
                </form>

                {{-- Results Area --}}
                <div id="resultArea" style="display: none;" class="mt-8 pt-8 border-t border-white/10 transition-all duration-300">
                    
                    {{-- Sukses --}}
                    <div id="resultSuccess" style="display: none;" class="bg-white/5 border border-white/10 rounded-2xl p-6 relative overflow-hidden">
                        <div class="absolute -right-6 -bottom-6 opacity-5 pointer-events-none">
                            <svg class="w-48 h-48 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>

                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h4 class="text-stone-400 text-xs font-semibold uppercase tracking-wider mb-1">Hasil Pencarian</h4>
                                <p id="resCode" class="text-xl font-mono font-bold text-white tracking-widest"></p>
                            </div>
                            <div>
                                <span id="badgeDiterima" style="display: none;" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-emerald-500/20 border border-emerald-500/30 text-emerald-400 text-sm font-bold shadow-[0_0_15px_rgba(16,185,129,0.2)]">
                                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                    Sudah Diterima
                                </span>
                                <span id="badgeBelum" style="display: none;" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-amber-500/20 border border-amber-500/30 text-amber-400 text-sm font-bold shadow-[0_0_15px_rgba(245,158,11,0.2)]">
                                    <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                                    Belum Diambil
                                </span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-y-4 gap-x-6 text-sm">
                            <div>
                                <p class="text-stone-500 text-xs uppercase mb-0.5">Nama Pengkurban</p>
                                <p id="resName" class="text-stone-200 font-medium"></p>
                            </div>
                            <div>
                                <p class="text-stone-500 text-xs uppercase mb-0.5">Jenis Kurban</p>
                                <p id="resType" class="text-stone-200 font-medium capitalize"></p>
                            </div>
                            <div>
                                <p class="text-stone-500 text-xs uppercase mb-0.5">Wilayah Penyaluran</p>
                                <p id="resRegion" class="text-stone-200 font-medium"></p>
                            </div>
                            <div id="resTimeContainer" style="display: none;">
                                <p class="text-stone-500 text-xs uppercase mb-0.5">Waktu Pengambilan</p>
                                <p id="resTime" class="text-emerald-400 font-bold"></p>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-center">
                            <button type="button" onclick="resetSearch()" class="text-sm text-stone-400 hover:text-white transition underline underline-offset-4">Cek Kupon Lain</button>
                        </div>
                    </div>
                    
                    {{-- Tidak Ditemukan --}}
                    <div id="resultNotFound" style="display: none;" class="text-center py-6">
                        <div class="w-16 h-16 rounded-full bg-red-500/10 flex items-center justify-center mx-auto mb-4 border border-red-500/20">
                            <svg class="w-8 h-8 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <h4 class="text-white font-bold mb-2">Kupon Tidak Ditemukan</h4>
                        <p class="text-stone-400 text-sm max-w-sm mx-auto mb-4">Pastikan kode yang Anda masukkan sudah benar (misal: QURBAN-XXXX). Periksa kembali huruf besar dan kecilnya atau hubungi panitia.</p>
                        <button type="button" onclick="resetSearch()" class="px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-sm text-white hover:bg-white/10 transition">Coba Lagi</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ░░ FITUR ░░ --}}
    <section class="bg-slate-900 py-24">
        <div class="mx-auto max-w-7xl px-4">
            <div class="text-center mb-16">
                <p class="text-sm font-semibold uppercase tracking-widest text-primary mb-3">Fitur Unggulan</p>
                <h2 class="text-4xl font-black text-white">Semua yang Dibutuhkan Panitia</h2>
                <p class="mt-4 text-stone-400 max-w-2xl mx-auto">Dari generate kupon otomatis hingga scan QR Code saat
                    pembagian — semuanya terintegrasi dalam satu sistem.</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                    $features = [
                        ['icon' => 'M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z', 'title' => 'Generate Kupon Otomatis', 'desc' => 'Buat ratusan kupon sekaligus dengan satu klik, lengkap dengan QR Code unik tiap kupon.', 'color' => 'from-teal-500/20 to-teal-600/10'],
                        ['icon' => 'M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z', 'title' => 'Scan QR via Kamera', 'desc' => 'Panitia cukup arahkan kamera ke QR Code untuk verifikasi instan tanpa input manual.', 'color' => 'from-sky-500/20 to-sky-600/10'],
                        ['icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'title' => 'Laporan & Rekap Otomatis', 'desc' => 'Dashboard statistik real-time + ekspor laporan ke CSV & Excel dengan satu klik.', 'color' => 'from-violet-500/20 to-violet-600/10'],
                        ['icon' => 'M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12', 'title' => 'Import Excel Pengkurban', 'desc' => 'Upload data pengkurban dari file Excel/CSV secara batch — hemat waktu entry manual.', 'color' => 'from-amber-500/20 to-amber-600/10'],
                        ['icon' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z', 'title' => 'Manajemen Wilayah', 'desc' => 'Kelola distribusi per wilayah dengan progress bar dan statistik penerimaan per area.', 'color' => 'from-rose-500/20 to-rose-600/10'],
                        ['icon' => 'M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1', 'title' => 'Multi-Role Akses', 'desc' => 'Admin kelola semua data; Panitia fokus pada verifikasi kupon — hak akses terpisah jelas.', 'color' => 'from-emerald-500/20 to-emerald-600/10'],
                    ];
                @endphp
                @foreach($features as $f)
                    <div class="feature-card rounded-2xl border border-white/10 bg-white/5 p-6">
                        <div
                            class="w-12 h-12 rounded-2xl bg-gradient-to-br {{ $f['color'] }} flex items-center justify-center mb-4 border border-white/10">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $f['icon'] }}" />
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-white mb-2">{{ $f['title'] }}</h3>
                        <p class="text-sm text-stone-400 leading-relaxed">{{ $f['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ░░ ROLES ░░ --}}
    <section class="bg-slate-950 py-24">
        <div class="mx-auto max-w-7xl px-4">
            <div class="text-center mb-16">
                <p class="text-sm font-semibold uppercase tracking-widest text-primary mb-3">Dua Jenis Pengguna</p>
                <h2 class="text-4xl font-black text-white">Dirancang untuk Admin & Panitia</h2>
            </div>
            <div class="grid md:grid-cols-2 gap-6">
                <div class="rounded-3xl border border-primary/30 bg-primary/5 p-8">
                    <div class="w-14 h-14 rounded-2xl bg-primary/20 flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-2">👤 Admin</h3>
                    <p class="text-stone-400 mb-6 text-sm">Kontrol penuh atas seluruh sistem distribusi kupon kurban.
                    </p>
                    <ul class="space-y-2.5">
                        @foreach(['Dashboard statistik & grafik distribusi', 'Kelola user, wilayah, dan kupon', 'Generate & import kupon massal', 'Riwayat scan semua panitia', 'Rekapitulasi & ekspor laporan CSV/Excel', 'Pengaturan nama masjid & tahun kurban'] as $item)
                            <li class="flex items-start gap-2.5 text-sm text-stone-300">
                                <svg class="w-4 h-4 text-primary shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $item }}
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="rounded-3xl border border-sky-500/30 bg-sky-500/5 p-8">
                    <div class="w-14 h-14 rounded-2xl bg-sky-500/20 flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-2">🧾 Panitia</h3>
                    <p class="text-stone-400 mb-6 text-sm">Fokus pada verifikasi saat hari pembagian daging kurban.</p>
                    <ul class="space-y-2.5">
                        @foreach(['Dashboard statistik scan hari ini', 'Scan QR Code via kamera browser', 'Input kode kupon manual jika perlu', 'Riwayat verifikasi pribadi', 'Notifikasi langsung hasil verifikasi', 'Profil akun & ubah password'] as $item)
                            <li class="flex items-start gap-2.5 text-sm text-stone-300">
                                <svg class="w-4 h-4 text-sky-400 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $item }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- ░░ CTA ░░ --}}
    <section class="hero-gradient py-24">
        <div class="mx-auto max-w-3xl px-4 text-center">
            <p class="text-sm font-semibold uppercase tracking-widest text-teal-300 mb-4">🕋 Siap Digunakan</p>
            <h2 class="text-4xl font-black text-white mb-6">Wujudkan Distribusi Kurban yang Lebih Bermakna</h2>
            <p class="text-teal-100/80 text-lg mb-10">Daftarkan akun panitia dan mulai kelola kupon kurban secara
                digital hari ini. Gratis, cepat, dan mudah digunakan.</p>
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="{{ route('register') }}"
                    class="inline-flex items-center gap-2 rounded-2xl bg-white px-8 py-4 text-base font-bold text-primary shadow-xl hover:bg-stone-100 transition-all hover:-translate-y-0.5">
                    Mulai Sekarang — Gratis
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
                <a href="{{ route('login') }}"
                    class="inline-flex items-center gap-2 rounded-2xl border border-white/30 px-8 py-4 text-base font-semibold text-white hover:bg-white/10 transition-all">
                    Sudah Punya Akun? Masuk
                </a>
            </div>
        </div>
    </section>

    {{-- ░░ FOOTER ░░ --}}
    <footer class="bg-slate-950 border-t border-white/10 py-10">
        <div class="mx-auto max-w-7xl px-4 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-primary/20 flex items-center justify-center">
                    <svg class="w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <span class="font-bold text-white">SI Qurban</span>
                <span class="text-stone-500 text-sm">— Magister Teknik Informatika 12</span>
            </div>
            <!-- <p class="text-stone-500 text-sm">Laravel 12 · TailwindCSS · MySQL · Docker</p> -->
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