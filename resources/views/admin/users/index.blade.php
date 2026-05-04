@extends('layouts.app')

@section('page-title', 'Kelola User')

@section('content')
<div class="mb-6 flex items-center justify-between gap-4">
    <div>
        <h2 class="text-xl font-bold text-slate-900">Daftar User</h2>
        <p class="text-sm text-stone-500">Kelola akun admin dan panitia dari halaman ini.</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn-primary">Tambah User</a>
</div>

<div class="card p-6">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-stone-100 text-stone-600">
                <tr>
                    <th class="px-4 py-3 text-left">Nama</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">No. HP</th>
                    <th class="px-4 py-3 text-left">Role</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr class="border-b border-stone-100 hover:bg-stone-50">
                        <td class="px-4 py-4 font-semibold text-slate-900">{{ $user->name }}</td>
                        <td class="px-4 py-4">{{ $user->email }}</td>
                        <td class="px-4 py-4">{{ $user->phone }}</td>
                        <td class="px-4 py-4">
                            @php
                                $roleClass = 'bg-teal-100 text-teal-700'; // Default panitia
                                if ($user->role === 'admin') $roleClass = 'bg-amber-100 text-amber-700';
                                if ($user->role === 'superadmin') $roleClass = 'bg-purple-100 text-purple-700 font-bold';
                            @endphp
                            <span class="rounded-full px-3 py-1 {{ $roleClass }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            <span class="rounded-full px-3 py-1 {{ $user->status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-stone-200 text-stone-700' }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            @if(auth()->user()->role === 'superadmin' || (auth()->user()->role === 'admin' && !in_array($user->role, ['admin', 'superadmin'])))
                                <div class="flex flex-wrap gap-3 items-center">
                                    @if($user->status === 'inactive')
                                        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="active">
                                            <input type="hidden" name="name" value="{{ $user->name }}">
                                            <input type="hidden" name="role" value="{{ $user->role }}">
                                            <button type="submit" class="font-semibold text-emerald-600 hover:text-emerald-800 bg-emerald-100 px-2 py-1 rounded">Aktifkan</button>
                                        </form>
                                    @endif
                                    <a href="{{ route('admin.users.edit', $user) }}" class="font-semibold text-primary hover:text-teal-800">Edit</a>
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-semibold text-red-600 hover:text-red-700" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                    </form>
                                </div>
                            @else
                                <span class="text-stone-400 italic text-xs">Akses Terbatas</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-stone-500">Belum ada user yang tersimpan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $users->links() }}
    </div>
</div>
@endsection
