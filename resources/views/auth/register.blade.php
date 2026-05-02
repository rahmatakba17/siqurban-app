@extends('layouts.guest')

@section('title', 'Register | SI Qurban')

@section('content')
<div class="mx-auto flex min-h-screen max-w-6xl items-center px-4 py-12">
    <div class="grid w-full gap-8 lg:grid-cols-[0.85fr_1.15fr]">
        <section class="card p-8 md:p-10">
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-primary">Buat Akun Panitia</h2>
                <p class="mt-2 text-sm text-stone-500">Registrasi ini akan membuat akun dengan peran panitia agar dapat mengakses dashboard dan verifikasi kupon.</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-input" required>
                </div>

                <div>
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-input" required>
                </div>

                <div>
                    <label for="phone" class="form-label">Nomor Telepon</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" class="form-input" required>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div>
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-input" required>
                    </div>
                    <div>
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required>
                    </div>
                </div>

                <button type="submit" class="btn-primary w-full">Register</button>
            </form>

            <p class="mt-6 text-sm text-stone-500">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-semibold text-primary hover:text-teal-800">Masuk sekarang</a>
            </p>
        </section>

        <section class="rounded-[2rem] bg-primary px-8 py-10 text-white shadow-2xl">
            <p class="mb-4 text-sm uppercase tracking-[0.3em] text-teal-100">Studi Kasus</p>
            <h1 class="text-4xl font-bold leading-tight">Aplikasi distribusi kupon kurban yang mendukung kerja panitia di lapangan.</h1>
            <div class="mt-8 space-y-4 text-teal-50">
                <p>1. Panitia dapat melakukan login dan memverifikasi kupon.</p>
                <p>2. Admin dapat mengelola user, wilayah, serta data kupon secara penuh.</p>
                <p>3. Seluruh proses terdokumentasi untuk mendukung pelaporan akademik dan evaluasi sistem.</p>
            </div>
        </section>
    </div>
</div>
@endsection
