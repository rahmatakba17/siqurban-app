@extends('layouts.guest')

@section('title', 'Login | SI Qurban')

@section('content')
<div class="mx-auto flex min-h-screen max-w-6xl items-center px-4 py-12">
    <div class="grid w-full gap-8 lg:grid-cols-[1.2fr_0.8fr]">
        <section class="rounded-[2rem] bg-slate-900 px-8 py-10 text-white shadow-2xl">
            <p class="mb-4 text-sm uppercase tracking-[0.3em] text-teal-200">Rekayasa Perangkat Lunak</p>
            <h1 class="max-w-xl text-4xl font-bold leading-tight">SI Qurban membantu panitia mendistribusikan kupon kurban secara tertib, cepat, dan terdokumentasi.</h1>
            <p class="mt-6 max-w-2xl text-slate-300">Aplikasi ini dikembangkan dengan Laravel, TailwindCSS, dan MySQL untuk memenuhi kebutuhan tugas proyek mata kuliah Rekayasa Perangkat Lunak.</p>
            <div class="mt-8 grid gap-4 md:grid-cols-3">
                <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                    <p class="text-sm text-slate-300">Fitur</p>
                    <p class="mt-2 text-lg font-semibold">Login & Register</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                    <p class="text-sm text-slate-300">Fitur</p>
                    <p class="mt-2 text-lg font-semibold">CRUD Data Inti</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                    <p class="text-sm text-slate-300">Fitur</p>
                    <p class="mt-2 text-lg font-semibold">Dashboard User</p>
                </div>
            </div>
        </section>

        <section class="card p-8 md:p-10">
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-primary">Masuk ke Sistem</h2>
                <p class="mt-2 text-sm text-stone-500">Silakan login menggunakan akun admin atau panitia yang telah terdaftar.</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-input" required autofocus>
                </div>

                <div>
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-input" required>
                </div>

                <button type="submit" class="btn-primary w-full">Login</button>
            </form>

            <p class="mt-6 text-sm text-stone-500">
                Belum memiliki akun?
                <a href="{{ route('register') }}" class="font-semibold text-primary hover:text-teal-800">Daftar sebagai panitia</a>
            </p>
        </section>
    </div>
</div>
@endsection
