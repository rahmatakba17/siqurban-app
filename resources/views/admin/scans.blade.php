@extends('layouts.app')

@section('page-title', 'Riwayat Scan')

@section('content')
<div class="card p-6">
    <h3 class="text-xl font-bold text-slate-900">Riwayat Scan Seluruh Panitia</h3>
    <div class="mt-5 overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-stone-100 text-stone-600">
                <tr>
                    <th class="px-4 py-3 text-left">Panitia Scan</th>
                    <th class="px-4 py-3 text-left">Kode Kupon</th>
                    <th class="px-4 py-3 text-left">Penerima Daging</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Waktu & IP</th>
                </tr>
            </thead>
            <tbody>
                @forelse($scans as $scan)
                    <tr class="border-b border-stone-100 hover:bg-stone-50">
                        <td class="px-4 py-4">
                            <div class="font-medium text-slate-900">{{ $scan->user?->name }}</div>
                            <div class="text-[10px] text-stone-400 mt-1 uppercase tracking-wider">{{ $scan->scan_method === 'manual_input' ? 'Manual Input' : 'Kamera QR' }}</div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="font-mono text-xs font-bold">{{ $scan->coupon?->code }}</div>
                            <div class="text-xs text-stone-500 mt-1">Pekurban: {{ $scan->coupon?->sacrificer_name ?: '-' }}</div>
                        </td>
                        <td class="px-4 py-4 font-semibold text-emerald-700">
                            {{ $scan->coupon?->receiver_name ?: '-' }}
                        </td>
                        <td class="px-4 py-4">
                            @if($scan->status_result === 'success')
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold bg-emerald-100 text-emerald-700">Berhasil</span>
                            @elseif($scan->status_result === 'duplicate')
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold bg-rose-100 text-rose-700">Duplikat</span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold bg-stone-100 text-stone-700">{{ $scan->status_result }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            <div class="text-sm">{{ $scan->scan_time->format('d/m/Y H:i') }}</div>
                            <div class="text-[10px] text-stone-400 font-mono mt-1" title="{{ $scan->device_info }}">{{ $scan->ip_address ?: 'Unknown IP' }}</div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-stone-500">Belum ada riwayat scan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $scans->links() }}
    </div>
</div>
@endsection
