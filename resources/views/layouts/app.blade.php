<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'SI Qurban')) — @yield('page-title', 'Dashboard')</title>
    <meta name="description" content="SI Qurban — Sistem Informasi Distribusi Kupon Kurban Digital">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    
    <!-- Real-time Notifications: Pusher & Echo via CDN -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>
    <script>
        window.Pusher = Pusher;
        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: '{{ config("broadcasting.connections.reverb.key") }}',
            wsHost: '{{ config("broadcasting.connections.reverb.options.host") }}' || window.location.hostname,
            wsPort: {{ config("broadcasting.connections.reverb.options.port") ?? 8090 }},
            wssPort: {{ config("broadcasting.connections.reverb.options.port") ?? 8090 }},
            forceTLS: false,
            disableStats: true,
            enabledTransports: ['ws', 'wss'],
        });
    </script>
</head>
<body class="h-full bg-stone-50" x-data="{ sidebarOpen: false }">

    {{-- ░░ MOBILE OVERLAY ░░ --}}
    <div x-show="sidebarOpen" x-cloak
         class="fixed inset-0 z-20 bg-black/40 backdrop-blur-sm lg:hidden"
         @click="sidebarOpen = false"></div>

    <div class="min-h-screen lg:grid lg:grid-cols-[260px_minmax(0,1fr)]">

        {{-- ░░░░░░░░░░░░░░░░░ SIDEBAR ░░░░░░░░░░░░░░░░░ --}}
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
               class="fixed inset-y-0 left-0 z-30 w-[260px] bg-white border-r border-stone-200 flex flex-col transition-transform duration-300 lg:relative lg:flex lg:inset-auto lg:z-auto">

            {{-- Logo --}}
            <div class="px-5 py-5 border-b border-stone-100">
                <a href="/" class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-primary flex items-center justify-center shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-base font-bold text-slate-900">SI Qurban</p>
                        <p class="text-xs text-stone-400">Distribusi Daging Kurban</p>
                    </div>
                </a>
            </div>

            {{-- Role badge --}}
            <div class="px-5 py-3 border-b border-stone-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-sm">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-slate-900 truncate">{{ auth()->user()->name }}</p>
                        <span class="inline-flex items-center rounded-full bg-primary/10 px-2 py-0.5 text-xs font-semibold text-primary capitalize">
                            {{ auth()->user()->role }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
                @if(auth()->user()->role === 'admin')
                    <p class="px-3 pt-1 pb-2 text-[10px] font-semibold uppercase tracking-widest text-stone-400">Menu Utama</p>
                    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Dashboard
                    </a>
                    <p class="px-3 pt-4 pb-2 text-[10px] font-semibold uppercase tracking-widest text-stone-400">Manajemen</p>
                    <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        Data User
                    </a>
                    <a href="{{ route('admin.regions.index') }}" class="nav-item {{ request()->routeIs('admin.regions.*') ? 'active' : '' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Data Wilayah
                    </a>
                    <a href="{{ route('admin.coupons.index') }}" class="nav-item {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                        Data Kupon
                    </a>
                    <p class="px-3 pt-4 pb-2 text-[10px] font-semibold uppercase tracking-widest text-stone-400">Monitoring</p>
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        Riwayat Scan
                    </a>
                    <a href="{{ route('admin.audit-logs') }}" class="nav-item {{ request()->routeIs('admin.audit-logs') ? 'active' : '' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        Audit Logs
                    </a>
                    <a href="{{ route('admin.reports.index') }}" class="nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        Laporan & Rekap
                    </a>
                    <p class="px-3 pt-4 pb-2 text-[10px] font-semibold uppercase tracking-widest text-stone-400">Sistem</p>
                    <a href="{{ route('admin.settings') }}" class="nav-item {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Pengaturan
                    </a>
                    <a href="{{ route('admin.profile') }}" class="nav-item {{ request()->routeIs('admin.profile') ? 'active' : '' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Profil Akun
                    </a>
                    <a href="{{ route('admin.pulse') }}" class="nav-item {{ request()->routeIs('admin.pulse') ? 'active' : '' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        🔭 Monitoring Pulse
                    </a>
                @else
                    <p class="px-3 pt-1 pb-2 text-[10px] font-semibold uppercase tracking-widest text-stone-400">Menu Panitia</p>
                    <a href="{{ route('panitia.dashboard') }}" class="nav-item {{ request()->routeIs('panitia.dashboard') ? 'active' : '' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Dashboard
                    </a>
                    <a href="{{ route('panitia.scan') }}" class="nav-item {{ request()->routeIs('panitia.scan') ? 'active' : '' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                        Scan Kupon
                    </a>
                    <a href="{{ route('panitia.scans') }}" class="nav-item {{ request()->routeIs('panitia.scans') ? 'active' : '' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        Riwayat Scan
                    </a>
                    <a href="{{ route('panitia.profile') }}" class="nav-item {{ request()->routeIs('panitia.profile') ? 'active' : '' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Profil Akun
                    </a>
                @endif
            </nav>

            {{-- Logout --}}
            <div class="px-3 py-4 border-t border-stone-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-item w-full text-red-600 hover:bg-red-50 hover:text-red-700">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        {{-- ░░░░░░░░░░░░░░░░░ MAIN AREA ░░░░░░░░░░░░░░░░░ --}}
        <div class="min-w-0 flex flex-col">

            {{-- Top bar --}}
            <header class="sticky top-0 z-10 bg-white/90 backdrop-blur border-b border-stone-200">
                <div class="flex items-center gap-4 px-4 md:px-6 py-4">
                    {{-- Hamburger --}}
                    <button @click="sidebarOpen = !sidebarOpen"
                            class="lg:hidden p-2 rounded-xl text-stone-500 hover:bg-stone-100"
                            aria-label="Toggle menu">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <div class="flex-1 min-w-0">
                        <h1 class="text-lg font-bold text-slate-900 truncate">@yield('page-title', 'Dashboard')</h1>
                        <p class="text-xs text-stone-400 mt-0.5">@yield('page-subtitle', 'Sistem Informasi Distribusi Kurban')</p>
                    </div>
                    <div class="flex items-center gap-3">
                        {{-- Notification Bell (Dropdown) --}}
                        <div class="relative">
                            <button @click="showDropdown = !showDropdown" @click.away="showDropdown = false" 
                                    class="relative p-2 rounded-xl text-stone-500 hover:bg-stone-100 focus:outline-none">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                {{-- Badge --}}
                                <template x-if="toasts.length > 0">
                                    <span class="absolute top-1 right-1 flex items-center justify-center w-4 h-4 text-[9px] font-bold text-white bg-red-500 rounded-full border-2 border-white" x-text="toasts.length"></span>
                                </template>
                            </button>

                            {{-- Dropdown Panel --}}
                            <div x-show="showDropdown" x-cloak
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl border border-stone-100 overflow-hidden z-50 origin-top-right flex flex-col max-h-[80vh]">
                                
                                <div class="px-4 py-3 border-b border-stone-100 flex items-center justify-between bg-stone-50">
                                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800">Notifikasi</h3>
                                    <template x-if="toasts.length > 0">
                                        <button @click="clearAll()" class="text-[10px] font-bold text-stone-500 hover:text-red-600 transition-colors">Bersihkan Semua</button>
                                    </template>
                                </div>

                                <div class="overflow-y-auto flex-1">
                                    <template x-if="toasts.length === 0">
                                        <div class="p-6 text-center text-stone-400 text-xs">Belum ada notifikasi.</div>
                                    </template>
                                    <template x-for="toast in toasts" :key="toast.id">
                                        <div class="p-4 border-b border-stone-50 hover:bg-stone-50 transition-colors flex items-start gap-3 relative group">
                                            {{-- Icon --}}
                                            <div class="shrink-0 mt-0.5">
                                                <template x-if="toast.type === 'info'"><svg class="w-5 h-5 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></template>
                                                <template x-if="toast.type === 'success'"><svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></template>
                                                <template x-if="toast.type === 'warning'"><svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg></template>
                                            </div>
                                            {{-- Content --}}
                                            <div class="flex-1 pr-6">
                                                <p class="text-xs font-medium text-slate-800 leading-snug" x-text="toast.message"></p>
                                                <p class="text-[10px] text-stone-400 mt-1 font-mono" x-text="toast.time"></p>
                                            </div>
                                            {{-- Delete Button (Shows on hover) --}}
                                            <button @click.stop="removeToast(toast.id)" class="absolute right-3 top-3 opacity-0 group-hover:opacity-100 text-stone-400 hover:text-red-500 transition-all">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <span class="hidden md:flex items-center gap-2 rounded-xl border border-stone-200 px-3 py-2 text-sm">
                            <div class="w-6 h-6 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-xs">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="font-medium text-slate-700">{{ auth()->user()->name }}</span>
                        </span>
                    </div>
                </div>
            </header>

            {{-- Content --}}
            <main class="flex-1 px-4 py-6 md:px-6">

                {{-- Flash success --}}
                @if (session('success'))
                    <div id="flash-success" class="toast-success mb-4" role="alert">
                        <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                {{-- Flash errors --}}
                @if ($errors->any())
                    <div id="flash-error" class="toast-error mb-4" role="alert">
                        <svg class="w-5 h-5 text-red-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <ul class="space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Auto-dismiss flash messages
        document.addEventListener('DOMContentLoaded', () => {
            ['flash-success','flash-error'].forEach(id => {
                const el = document.getElementById(id);
                if (el) setTimeout(() => el.style.display = 'none', 5000);
            });
        });
    </script>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('notificationCenter', () => ({
                showDropdown: false,
                toasts: [],
                addToast(message, type = 'info', time = null) {
                    const id = Date.now() + Math.random();
                    if (!time) {
                        const d = new Date();
                        time = d.getHours().toString().padStart(2, '0') + ':' + d.getMinutes().toString().padStart(2, '0');
                    }
                    this.toasts.unshift({ id, message, type, time }); // Add to top

                    // Opsi: Mainkan suara pop ringan bila ada notif masuk
                    // let audio = new Audio('/ting.mp3'); audio.play().catch(()=>{});
                },
                removeToast(id) {
                    this.toasts = this.toasts.filter(t => t.id !== id);
                    if(this.toasts.length === 0) this.showDropdown = false;
                },
                clearAll() {
                    this.toasts = [];
                    this.showDropdown = false;
                },
                init() {
                    window.addEventListener('notify', (e) => {
                        this.addToast(e.detail.message, e.detail.type || 'info');
                    });

                    if (window.Echo) {
                        const role = '{{ auth()->user()->role ?? "guest" }}';

                        if (role === 'admin') {
                            window.Echo.private('admin.notifications')
                                .listen('.panitia.logged.in', (e) => {
                                    this.addToast(e.message, e.type, e.time);
                                })
                                .listen('.system.data.changed', (e) => {
                                    this.addToast(e.message, e.type, e.time);
                                })
                                .listen('.coupon.scanned', (e) => {
                                    this.addToast(e.message, e.type, e.time);
                                });
                        }

                        if (role === 'panitia') {
                            window.Echo.private('panitia.notifications')
                                .listen('.system.data.changed', (e) => {
                                    this.addToast(e.message, e.type, e.time);
                                })
                                .listen('.coupon.scanned', (e) => {});
                        }
                    }
                }
            }));
        });
    </script>

    @livewireScripts
    @stack('scripts')
</body>
</html>
