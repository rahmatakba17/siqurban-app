@extends('layouts.app')

@section('page-title', 'Riwayat Scan')

@section('content')
<div class="card p-6">
    <h3 class="text-xl font-bold text-slate-900">Riwayat Scan Anda</h3>
    <div class="mt-5 overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-stone-100 text-stone-600">
                <tr>
                    <th class="px-4 py-3 text-left">Kode Kupon</th>
                    <th class="px-4 py-3 text-left">Nama Penerima</th>
                    <th class="px-4 py-3 text-left">Waktu Scan</th>
                    <th class="px-4 py-3 text-left">Wilayah</th>
                </tr>
            </thead>
            <tbody>
                @forelse($scans as $scan)
                    <tr class="border-b border-stone-100 hover:bg-stone-50">
                        <td class="px-4 py-4 font-mono text-xs">{{ $scan->coupon?->code }}</td>
                        <td class="px-4 py-4">{{ $scan->coupon?->sacrificer_name ?: '-' }}</td>
                        <td class="px-4 py-4">{{ $scan->scan_time->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-4">{{ $scan->coupon?->region?->name ?: '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-stone-500">Belum ada riwayat scan.</td>
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
