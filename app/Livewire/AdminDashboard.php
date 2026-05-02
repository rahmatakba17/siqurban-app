<?php

namespace App\Livewire;

use App\Models\Coupon;
use App\Models\Region;
use App\Models\ScanHistory;
use Livewire\Component;

class AdminDashboard extends Component
{
    public int $refreshInterval = 15; // detik

    public function render()
    {
        $totalCoupons    = Coupon::count();
        $couponReceived  = Coupon::where('status', 'received')->count();
        $couponAvailable = Coupon::where('status', 'available')->count();
        $totalScans      = ScanHistory::count();
        $scansToday      = ScanHistory::whereDate('scan_time', today())->count();

        $regions = Region::with('coupons')->get()->map(function ($r) {
            $total    = $r->coupons->count();
            $received = $r->coupons->where('status', 'received')->count();
            return [
                'name'     => $r->name,
                'total'    => $total,
                'received' => $received,
                'pct'      => $total > 0 ? round(($received / $total) * 100) : 0,
            ];
        });

        $recentScans = ScanHistory::with('coupon.region', 'user')
            ->orderBy('scan_time', 'desc')
            ->limit(8)
            ->get();

        $chartLabels   = $regions->pluck('name');
        $chartReceived = $regions->pluck('received');
        $chartTotal    = $regions->pluck('total');

        return view('livewire.admin-dashboard', compact(
            'totalCoupons', 'couponReceived', 'couponAvailable',
            'totalScans', 'scansToday', 'regions', 'recentScans',
            'chartLabels', 'chartReceived', 'chartTotal'
        ));
    }
}
