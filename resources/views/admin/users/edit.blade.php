@extends('layouts.app')

@section('page-title', 'Edit User')

@section('content')
<div class="mx-auto max-w-3xl">
    <div class="card p-6 md:p-8">
        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="form-label">Nama</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="form-input" required>
                @error('name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="email" class="form-label">Email (Opsional)</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="form-input">
                @error('email') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="phone" class="form-label">No. HP</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" class="form-input" required>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label for="role" class="form-label">Role</label>
                    <select id="role" name="role" class="form-input" required>
                        @if(auth()->user()->role === 'superadmin')
                            <option value="superadmin" @selected(old('role', $user->role) === 'superadmin')>Super Admin</option>
                            <option value="admin" @selected(old('role', $user->role) === 'admin')>Admin</option>
                        @endif
                        <option value="panitia" @selected(old('role', $user->role) === 'panitia')>Panitia</option>
                    </select>
                </div>

                <div>
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-input" required>
                        <option value="active" @selected(old('status', $user->status) === 'active')>Active</option>
                        <option value="inactive" @selected(old('status', $user->status) === 'inactive')>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="btn-primary">Update</button>
                <a href="{{ route('admin.users.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
