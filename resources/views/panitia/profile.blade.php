@extends('layouts.app')

@section('page-title', 'Profil Panitia')

@section('content')
<div class="mx-auto max-w-3xl">
    <div class="card p-6 md:p-8">
        <h3 class="text-xl font-bold text-slate-900">Perbarui Profil</h3>
        <p class="mt-2 text-sm text-stone-500">Panitia dapat memperbarui nama dan nomor telepon pada halaman ini.</p>

        <form method="POST" action="{{ route('panitia.profile.update') }}" class="mt-6 space-y-5">
            @csrf

            <div>
                <label for="name" class="form-label">Nama</label>
                <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" class="form-input" required>
            </div>

            <div>
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" value="{{ auth()->user()->email }}" class="form-input bg-stone-100" disabled>
            </div>

            <div>
                <label for="phone" class="form-label">No. HP</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}" class="form-input" required>
            </div>

            <button type="submit" class="btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection
