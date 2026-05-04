@extends('layouts.app')

@section('page-title', 'Tambah User Baru')

@section('content')
<div class="mx-auto max-w-xl">
    <div class="card p-6 md:p-8">
        <div style="margin-bottom:1.5rem;">
            <h2 style="font-size:1.2rem;font-weight:800;color:#1e293b;margin-bottom:4px;">Tambah User Baru</h2>
            <p style="font-size:.83rem;color:#94a3b8;">Isi data berikut untuk membuat akun Admin atau Panitia baru.</p>
        </div>

        <form method="POST" action="{{ route('admin.users.store') }}" style="display:flex;flex-direction:column;gap:1rem;">
            @csrf

            <div>
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-input" required>
                @error('name') <span style="font-size:.75rem;color:#dc2626;margin-top:3px;display:block;">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="email" class="form-label">Email <span style="font-weight:400;color:#94a3b8;">(Opsional)</span></label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-input">
                @error('email') <span style="font-size:.75rem;color:#dc2626;margin-top:3px;display:block;">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="phone" class="form-label">No. HP <span style="font-weight:400;color:#94a3b8;">(Opsional)</span></label>
                <input type="text" id="phone" name="phone" value="{{ old('phone') }}" class="form-input">
            </div>

            <div>
                <label for="password" class="form-label">Password</label>
                <div style="position:relative;" x-data="{ show: false }">
                    <input :type="show ? 'text' : 'password'" id="password" name="password" class="form-input" style="padding-right:2.75rem;" required>
                    <button type="button" @click="show = !show" style="position:absolute;top:50%;right:.75rem;transform:translateY(-50%);background:none;border:none;padding:4px;cursor:pointer;color:#94a3b8;display:flex;align-items:center;line-height:0;" onmouseover="this.style.color='#15803d'" onmouseout="this.style.color='#94a3b8'">
                        <svg x-show="!show" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <svg x-show="show" width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:none"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                    </button>
                </div>
                @error('password') <span style="font-size:.75rem;color:#dc2626;margin-top:3px;display:block;">{{ $message }}</span> @enderror
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.85rem;">
                <div>
                    <label for="role" class="form-label">Role</label>
                    <select id="role" name="role" class="form-input" required>
                        <option value="">Pilih Role</option>
                        @if(auth()->user()->role === 'superadmin')
                            <option value="superadmin" @selected(old('role') === 'superadmin')>Super Admin</option>
                            <option value="admin" @selected(old('role') === 'admin')>Admin</option>
                        @endif
                        <option value="panitia" @selected(old('role') === 'panitia')>Panitia</option>
                    </select>
                </div>
                <div>
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-input" required>
                        <option value="active" @selected(old('status') === 'active')>Active</option>
                        <option value="inactive" @selected(old('status') === 'inactive')>Inactive</option>
                    </select>
                </div>
            </div>

            <div style="display:flex;gap:.75rem;margin-top:.5rem;">
                <button type="submit" class="btn-primary">Simpan User</button>
                <a href="{{ route('admin.users.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
