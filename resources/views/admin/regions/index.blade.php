@extends('layouts.app')

@section('page-title', 'Kelola Wilayah')

@section('content')
<div class="mb-6 flex items-center justify-between gap-4">
    <div>
        <h2 class="text-xl font-bold text-slate-900">Daftar Wilayah Distribusi</h2>
        <p class="text-sm text-stone-500">Data wilayah dipakai untuk mengelompokkan kupon kurban.</p>
    </div>
    <a href="{{ route('admin.regions.create') }}" class="btn-primary">Tambah Wilayah</a>
</div>

<div class="card p-6">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-stone-100 text-stone-600">
                <tr>
                    <th class="px-4 py-3 text-left">Nama Wilayah</th>
                    <th class="px-4 py-3 text-left">Deskripsi</th>
                    <th class="px-4 py-3 text-left">Total Kupon</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($regions as $region)
                    <tr class="border-b border-stone-100 hover:bg-stone-50">
                        <td class="px-4 py-4 font-semibold text-slate-900">{{ $region->name }}</td>
                        <td class="px-4 py-4 text-stone-600">{{ $region->description ?: '-' }}</td>
                        <td class="px-4 py-4 font-semibold text-primary">{{ $region->coupons_count }}</td>
                        <td class="px-4 py-4">
                            <span class="rounded-full px-3 py-1 {{ $region->status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-stone-200 text-stone-700' }}">
                                {{ ucfirst($region->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex gap-3">
                                <a href="{{ route('admin.regions.edit', $region) }}" class="font-semibold text-primary hover:text-teal-800">Edit</a>
                                <form method="POST" action="{{ route('admin.regions.destroy', $region) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-semibold text-red-600 hover:text-red-700" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-stone-500">Belum ada wilayah yang tersimpan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $regions->links() }}
    </div>
</div>
@endsection
