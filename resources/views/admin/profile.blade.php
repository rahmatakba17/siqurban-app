@extends('layouts.app')

@section('page-title', 'Profil Akun')
@section('page-subtitle', 'Kelola informasi akun dan keamanan')

@section('content')
<div class="max-w-2xl">
    <div class="card overflow-hidden">
        {{-- Cover --}}
        <div class="h-24 bg-gradient-to-r from-primary to-teal-400"></div>

        {{-- Avatar + info --}}
        <div class="px-6 pb-6">
            <div class="-mt-10 mb-4 flex items-end gap-4">
                <div class="w-20 h-20 rounded-2xl border-4 border-white bg-primary flex items-center justify-center text-white text-3xl font-black shadow-lg">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="pb-2">
                    <p class="text-lg font-bold text-slate-900">{{ $user->name }}</p>
                    <span class="badge-green capitalize">{{ $user->role }}</span>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.profile.update') }}" class="space-y-5">
                @csrf

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="form-input" required>
                    </div>
                    <div>
                        <label for="phone" class="form-label">Nomor Telepon</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" class="form-input" placeholder="0812...">
                    </div>
                </div>

                <div>
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="form-input" required>
                </div>

                <hr class="border-stone-200">
                <p class="text-sm font-semibold text-slate-700">Ubah Password <span class="font-normal text-stone-400">(kosongkan jika tidak ingin mengubah)</span></p>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="password" class="form-label">Password Baru</label>
                        <input type="password" id="password" name="password" class="form-input" placeholder="Min. 6 karakter">
                    </div>
                    <div>
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" placeholder="Ulangi password">
                    </div>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Info akun --}}
    <div class="card p-5 mt-5">
        <h3 class="text-sm font-bold text-slate-900 mb-4">ℹ️ Informasi Akun</h3>
        <div class="grid gap-3 sm:grid-cols-2 text-sm">
            <div class="flex justify-between py-2 border-b border-stone-100">
                <span class="text-stone-500">Role</span>
                <span class="font-semibold capitalize text-slate-700">{{ $user->role }}</span>
            </div>
            <div class="flex justify-between py-2 border-b border-stone-100">
                <span class="text-stone-500">Status</span>
                <span class="badge-green capitalize">{{ $user->status }}</span>
            </div>
            <div class="flex justify-between py-2 border-b border-stone-100">
                <span class="text-stone-500">Terdaftar</span>
                <span class="font-semibold text-slate-700">{{ $user->created_at->format('d M Y') }}</span>
            </div>
            <div class="flex justify-between py-2 border-b border-stone-100">
                <span class="text-stone-500">Update Terakhir</span>
                <span class="font-semibold text-slate-700">{{ $user->updated_at->format('d M Y H:i') }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
