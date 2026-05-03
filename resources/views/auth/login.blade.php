@extends('layouts.guest')

@section('title', 'Login | SI Qurban')

@section('content')
<style>
    body { background: #f8f4ed !important; font-family: 'Plus Jakarta Sans', sans-serif; }
    .bg-hijau { background: linear-gradient(160deg, #15803d 0%, #166534 100%); }
    .text-hijau { color: #15803d; }
    .btn-hijau { background: #15803d; color: white; transition: all 0.2s; }
    .btn-hijau:hover { background: #166534; transform: translateY(-1px); }
    .input-field { border: 2px solid #d1fae5; border-radius: 12px; transition: border-color 0.2s; background: #f8fafc; }
    .input-field:focus { border-color: #15803d; outline: none; background: #fff; box-shadow: 0 0 0 4px rgba(21,128,61,0.1); }
</style>

<div class="mx-auto flex min-h-screen max-w-6xl items-center px-4 py-12">
    <div class="grid w-full gap-8 lg:grid-cols-[1.2fr_0.8fr]">
        <section class="rounded-[2rem] bg-hijau px-8 py-12 text-white shadow-[0_20px_50px_rgba(21,128,61,0.15)] relative overflow-hidden">
            {{-- Islamic Pattern Overlay --}}
            <div class="absolute inset-0 opacity-[0.03]" style="background-image:url(&quot;data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E&quot;);"></div>
            
            <div class="relative z-10">
                <span class="inline-block bg-white/20 text-white border border-white/30 rounded-full px-4 py-1.5 text-xs font-bold uppercase tracking-widest mb-6">
                    Sistem Digital
                </span>
                <h1 class="max-w-xl text-4xl md:text-5xl font-extrabold leading-[1.15]">
                    Distribusi <span class="text-[#fde68a]">Kurban</span><br>Secara Tertib & Cepat.
                </h1>
                <p class="mt-6 max-w-lg text-green-50 text-lg leading-relaxed font-medium">
                    SI Qurban membantu panitia mengelola data pekurban dan memverifikasi pengambilan daging kurban dengan mudah dan akurat.
                </p>
                <div class="mt-10 grid gap-4 sm:grid-cols-3">
                    <div class="rounded-2xl border border-white/20 bg-white/10 p-5 backdrop-blur-sm">
                        <div class="text-2xl mb-2">📱</div>
                        <p class="text-sm text-green-100 font-semibold mb-1">Fitur</p>
                        <p class="text-lg font-bold">Verifikasi Cepat</p>
                    </div>
                    <div class="rounded-2xl border border-white/20 bg-white/10 p-5 backdrop-blur-sm">
                        <div class="text-2xl mb-2">📊</div>
                        <p class="text-sm text-green-100 font-semibold mb-1">Laporan</p>
                        <p class="text-lg font-bold">Data Real-time</p>
                    </div>
                    <div class="rounded-2xl border border-white/20 bg-white/10 p-5 backdrop-blur-sm">
                        <div class="text-2xl mb-2">🕌</div>
                        <p class="text-sm text-green-100 font-semibold mb-1">Akses</p>
                        <p class="text-lg font-bold">Multi-Panitia</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="rounded-[2rem] bg-white p-8 md:p-10 shadow-xl border border-gray-100 flex flex-col justify-center">
            <div class="mb-8 text-center">
                <div class="w-16 h-16 bg-green-50 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-green-100 text-3xl">🕌</div>
                <h2 class="text-3xl font-extrabold text-hijau">Masuk ke Sistem</h2>
                <p class="mt-2 text-sm text-gray-500 font-medium">Silakan login menggunakan akun admin atau panitia.</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-1.5 uppercase tracking-wide">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="input-field w-full px-4 py-3" required autofocus>
                </div>

                <div>
                    <label for="password" class="block text-sm font-bold text-gray-700 mb-1.5 uppercase tracking-wide">Password</label>
                    <input type="password" id="password" name="password" class="input-field w-full px-4 py-3" required>
                </div>

                <button type="submit" class="btn-hijau w-full py-3.5 rounded-xl font-bold text-lg shadow-md mt-4">Masuk</button>
            </form>

            <p class="mt-8 text-center text-sm font-medium text-gray-500">
                Belum memiliki akun?
                <a href="{{ route('register') }}" class="font-bold text-hijau hover:underline underline-offset-4">Daftar sebagai panitia</a>
            </p>
        </section>
    </div>
</div>
@endsection
