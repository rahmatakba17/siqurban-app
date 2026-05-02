<?php

namespace App\Livewire;

use App\Events\CouponScanned;
use App\Models\ScanHistory;
use Livewire\Attributes\On;
use Livewire\Component;

class ScanCounter extends Component
{
    public int   $scanToday   = 0;
    public int   $scanTotal   = 0;
    public array $recentScans = [];
    public bool  $reverbActive = false;

    public function mount(): void
    {
        $this->refresh();
    }

    public function refresh(): void
    {
        $this->scanToday = ScanHistory::where('user_id', auth()->id())
            ->whereDate('scan_time', today())
            ->count();

        $this->scanTotal = ScanHistory::where('user_id', auth()->id())->count();

        $this->recentScans = ScanHistory::where('user_id', auth()->id())
            ->with('coupon.region')
            ->orderBy('scan_time', 'desc')
            ->limit(5)
            ->get()
            ->map(fn ($s) => [
                'code'   => $s->coupon?->code ?? '—',
                'region' => $s->coupon?->region?->name ?? '—',
                'time'   => $s->scan_time->format('H:i:s'),
            ])
            ->toArray();
    }

    // Dipanggil oleh event dari ScanController (setelah verifikasi berhasil)
    #[On('coupon-scanned')]
    public function onCouponScanned(): void
    {
        $this->refresh();
    }

    public function render()
    {
        return view('livewire.scan-counter');
    }
}
