@extends('layouts.app')

@section('page-title', 'Audit Log (Anti-Fraud)')
@section('page-subtitle', 'Riwayat perubahan data oleh administrator')

@section('content')
<div class="card p-6">
    <div class="flex items-center justify-between mb-5">
        <h3 class="text-xl font-bold text-slate-900">Riwayat Perubahan Sistem</h3>
        <span class="px-3 py-1 bg-amber-100 text-amber-800 text-xs font-bold rounded-full">Keamanan Lanjutan</span>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-stone-100 text-stone-600">
                <tr>
                    <th class="px-4 py-3 text-left">Waktu & IP</th>
                    <th class="px-4 py-3 text-left">Admin</th>
                    <th class="px-4 py-3 text-left">Aksi</th>
                    <th class="px-4 py-3 text-left">Keterangan</th>
                    <th class="px-4 py-3 text-left">Detail Perubahan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr class="border-b border-stone-100 hover:bg-stone-50">
                        <td class="px-4 py-4 align-top">
                            <div class="font-bold text-slate-800">{{ $log->created_at->format('d/m/Y H:i:s') }}</div>
                            <div class="text-[10px] text-stone-400 font-mono mt-1">{{ $log->ip_address ?: 'Unknown IP' }}</div>
                        </td>
                        <td class="px-4 py-4 align-top font-medium">{{ $log->user?->name ?: 'System' }}</td>
                        <td class="px-4 py-4 align-top">
                            <span class="inline-flex px-2 py-1 bg-sky-100 text-sky-700 font-bold text-xs rounded uppercase">{{ str_replace('coupon.', '', $log->action) }}</span>
                            <div class="text-xs text-stone-500 mt-1">ID: {{ $log->model_id }}</div>
                        </td>
                        <td class="px-4 py-4 align-top text-stone-600">{{ $log->description }}</td>
                        <td class="px-4 py-4 align-top">
                            @if($log->action === 'coupon.update' && $log->old_values && $log->new_values)
                                <div class="text-xs space-y-2">
                                    @foreach($log->new_values as $key => $newValue)
                                        @if($key !== 'updated_at' && isset($log->old_values[$key]) && $log->old_values[$key] != $newValue)
                                            <div class="grid grid-cols-[80px_1fr] gap-2">
                                                <span class="font-semibold text-stone-500">{{ $key }}:</span>
                                                <div>
                                                    <span class="line-through text-rose-500 opacity-70">{{ $log->old_values[$key] ?: '(kosong)' }}</span>
                                                    <span class="mx-1">→</span>
                                                    <span class="font-bold text-emerald-600">{{ $newValue ?: '(kosong)' }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @elseif($log->action === 'coupon.delete')
                                <span class="text-xs text-rose-600 font-medium">Data dihapus permanen.</span>
                            @else
                                <span class="text-xs text-stone-400">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-stone-500">Belum ada riwayat audit.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $logs->links() }}
    </div>
</div>
@endsection
