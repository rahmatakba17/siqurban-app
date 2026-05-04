@extends('layouts.app')

@section('page-title', 'Scan Kupon')
@section('page-subtitle', 'Verifikasi penerima daging kurban')

@section('content')
<div class="grid gap-6 xl:grid-cols-[1fr_380px]">

    {{-- ░░ PANEL KIRI: Scanner + Form ░░ --}}
    <div class="space-y-6">
        {{-- Nama Penerima Input --}}
        <div class="card p-6 border-2 border-emerald-500/20 bg-emerald-50/50">
            <h3 class="text-base font-bold text-slate-900 mb-2">👤 Nama Penerima Daging</h3>
            <p class="text-sm text-stone-500 mb-3">Wajib diisi dengan nama warga yang mengambil daging kurban sebelum melakukan scan.</p>
            <input type="text" id="receiver_name" class="form-input text-lg font-semibold" placeholder="Contoh: Bpk. Budi Santoso" required>
        </div>

        {{-- Tab selector --}}
        <div class="card p-1 flex gap-1">
            <button id="tab-camera" onclick="switchTab('camera')"
                class="flex-1 flex items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold transition-all bg-primary text-white">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                Scan QR Kamera
            </button>
            <button id="tab-manual" onclick="switchTab('manual')"
                class="flex-1 flex items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold transition-all text-stone-600 hover:bg-stone-100">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Input Manual
            </button>
        </div>

        {{-- Panel Kamera --}}
        <div id="panel-camera" class="card p-6">
            <h3 class="text-base font-bold text-slate-900 mb-2">📷 Scan QR Code via Kamera</h3>
            <p class="text-sm text-stone-500 mb-5">Arahkan kamera ke QR Code pada kartu kupon penerima.</p>
            <div id="qr-reader" class="w-full rounded-2xl overflow-hidden border border-stone-200 bg-stone-50 min-h-[260px]"></div>
            <div id="qr-reader-status" class="mt-3 text-xs text-stone-400 text-center">Kamera siap — arahkan ke QR Code kupon</div>
        </div>

        {{-- Panel Manual --}}
        <div id="panel-manual" class="card p-6 hidden">
            <h3 class="text-base font-bold text-slate-900 mb-2">⌨️ Input Kode Manual</h3>
            <p class="text-sm text-stone-500 mb-5">Masukkan kode kupon secara manual jika kamera tidak tersedia.</p>
            <form id="scan-form" class="space-y-4">
                @csrf
                <div>
                    <label for="coupon_code" class="form-label">Kode Kupon</label>
                    <input type="text" id="coupon_code" name="coupon_code"
                           class="form-input font-mono tracking-wider text-base"
                           placeholder="KPN-20261445-ABCDE3" autocomplete="off">
                </div>
                <button type="submit" class="btn-primary w-full">
                    Verifikasi Kupon
                </button>
            </form>
        </div>

        {{-- Hasil verifikasi --}}
        <div class="card p-6">
            <h3 class="text-base font-bold text-slate-900 mb-4">📋 Hasil Verifikasi</h3>
            <div id="scan-result" class="rounded-2xl bg-stone-50 border border-stone-200 p-5 text-sm text-stone-400 text-center">
                <svg class="w-10 h-10 mx-auto mb-3 text-stone-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01"/></svg>
                Menunggu input kupon...
            </div>
        </div>
    </div>

    {{-- ░░ PANEL KANAN: Livewire Counter ░░ --}}
    <div>
        @livewire('scan-counter')
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
const VERIFY_URL = '{{ route("panitia.scan.verify") }}';
const CSRF       = '{{ csrf_token() }}';

let html5QrCode  = null;
let scannerRunning = false;

// ── Tab switching ────────────────────────────────────────────
function switchTab(tab) {
    const isCamera = tab === 'camera';
    document.getElementById('tab-camera').className = isCamera
        ? 'flex-1 flex items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold transition-all bg-primary text-white'
        : 'flex-1 flex items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold transition-all text-stone-600 hover:bg-stone-100';
    document.getElementById('tab-manual').className = isCamera
        ? 'flex-1 flex items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold transition-all text-stone-600 hover:bg-stone-100'
        : 'flex-1 flex items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold transition-all bg-primary text-white';

    document.getElementById('panel-camera').classList.toggle('hidden', !isCamera);
    document.getElementById('panel-manual').classList.toggle('hidden',  isCamera);

    if (isCamera) startScanner(); else { stopScanner(); document.getElementById('coupon_code').focus(); }
}

// ── QR Scanner ───────────────────────────────────────────────
function startScanner() {
    if (scannerRunning) return;
    html5QrCode = new Html5Qrcode('qr-reader');
    html5QrCode.start(
        { facingMode: 'environment' },
        { fps: 10, qrbox: { width: 250, height: 250 } },
        (decodedText) => {
            let code = decodedText;
            try { const p = JSON.parse(decodedText); if (p.coupon_code) code = p.coupon_code; } catch(_) {}
            
            const receiverName = document.getElementById('receiver_name').value.trim();
            if (!receiverName) {
                alert("Harap isi Nama Penerima Daging terlebih dahulu sebelum scan QR!");
                return; // jangan stop scanner, biarkan jalan tapi kasih alert
            }
            
            stopScanner();
            verifyCoupon(code, 'kamera', receiverName);
        },
        () => {}
    ).then(() => {
        scannerRunning = true;
        document.getElementById('qr-reader-status').textContent = '✅ Kamera aktif — arahkan ke QR Code';
    }).catch(err => {
        document.getElementById('qr-reader-status').textContent = '⚠️ Kamera gagal: ' + err;
    });
}

function stopScanner() {
    if (html5QrCode && scannerRunning) { html5QrCode.stop().catch(()=>{}); scannerRunning = false; }
}

// ── Verify ────────────────────────────────────────────────────
async function verifyCoupon(code, mode = 'manual', receiverName = '') {
    const resultEl = document.getElementById('scan-result');
    resultEl.className = 'rounded-2xl bg-sky-50 border border-sky-200 p-5 text-sm text-sky-700 text-center animate-pulse-soft';
    resultEl.innerHTML = '<p class="font-semibold">🔍 Memverifikasi...</p><p class="text-xs mt-1 font-mono">' + code + '</p>';

    try {
        const res  = await fetch(VERIFY_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            body: JSON.stringify({ coupon_code: code, mode, receiver_name: receiverName }),
        });
        const data = await res.json();

        if (res.ok && data.success) {
            resultEl.className = 'rounded-2xl bg-emerald-50 border border-emerald-200 p-5 text-sm text-emerald-800';
            resultEl.innerHTML = `
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="font-bold text-base">Kupon Valid! ✅</p>
                </div>
                <div class="grid gap-1.5 text-xs">
                    <div class="flex justify-between bg-emerald-100 rounded-xl px-3 py-2">
                        <span class="text-emerald-600">Kode</span><span class="font-mono font-bold">${data.coupon.code}</span>
                    </div>
                    <div class="flex justify-between bg-emerald-100 rounded-xl px-3 py-2">
                        <span class="text-emerald-600">Nama</span><span class="font-semibold">${data.coupon.sacrificer_name || 'Umum'}</span>
                    </div>
                    <div class="flex justify-between bg-emerald-100 rounded-xl px-3 py-2">
                        <span class="text-emerald-600">Wilayah</span><span class="font-semibold">${data.coupon.region || '—'}</span>
                    </div>
                    <div class="flex justify-between bg-emerald-100 rounded-xl px-3 py-2">
                        <span class="text-emerald-600">Penerima</span><span class="font-bold text-emerald-800">${data.coupon.receiver_name}</span>
                    </div>
                </div>`;

            // Trigger Livewire refresh via browser event
            document.dispatchEvent(new CustomEvent('livewire:dispatch', { detail: { component: 'scan-counter', event: 'coupon-scanned' } }));
            window.Livewire?.dispatch('coupon-scanned');

            // Tampilkan Notifikasi Toast Sukses
            window.dispatchEvent(new CustomEvent('notify', {
                detail: {
                    message: `✅ Kupon ${data.coupon.code} berhasil diserahkan ke ${data.coupon.receiver_name}.`,
                    type: 'success'
                }
            }));

            // Kosongkan nama penerima untuk scan berikutnya
            document.getElementById('receiver_name').value = '';

            setTimeout(() => startScanner(), 2500);
        } else {
            resultEl.className = 'rounded-2xl bg-red-50 border border-red-200 p-5 text-sm text-red-800';
            resultEl.innerHTML = `
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="font-bold text-base">Gagal ❌</p>
                </div>
                <p>${data.message || 'Kupon tidak valid.'}</p>
                <p class="text-xs font-mono mt-2 opacity-60">${code}</p>`;
            setTimeout(() => startScanner(), 3000);
        }
    } catch(err) {
        resultEl.className = 'rounded-2xl bg-red-50 border border-red-200 p-5 text-sm text-red-700';
        resultEl.innerHTML = '<p class="font-semibold">Koneksi gagal. Coba lagi.</p>';
        setTimeout(() => startScanner(), 3000);
    }
}

// ── Manual form ─────────────────────────────────────────────
document.getElementById('scan-form').addEventListener('submit', (e) => {
    e.preventDefault();
    const code = document.getElementById('coupon_code').value.trim();
    const receiverName = document.getElementById('receiver_name').value.trim();
    
    if (!receiverName) {
        alert("Harap isi Nama Penerima Daging terlebih dahulu!");
        document.getElementById('receiver_name').focus();
        return;
    }
    
    if (code) { 
        verifyCoupon(code, 'manual', receiverName); 
        document.getElementById('coupon_code').value = ''; 
    }
});

document.addEventListener('DOMContentLoaded', () => startScanner());
window.addEventListener('beforeunload', () => stopScanner());
</script>
@endpush
