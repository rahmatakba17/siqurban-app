<?php

namespace App\Http\Controllers\Api;

use App\Models\Coupon;
use App\Models\ScanHistory;
use Illuminate\Http\Request;

class ReportController
{
    public function index()
    {
        return response()->json([
            'total_coupons' => Coupon::count(),
            'coupon_received' => Coupon::where('status', 'received')->count(),
            'coupon_available' => Coupon::where('status', 'available')->count(),
            'total_scans' => ScanHistory::count(),
        ]);
    }

    public function summary()
    {
        return response()->json([
            'by_region' => Coupon::select('region_id')->with('region')
                ->selectRaw('count(*) as total')
                ->groupBy('region_id')
                ->get(),
            'by_status' => Coupon::selectRaw('status, count(*) as total')
                ->groupBy('status')
                ->get(),
        ]);
    }

    public function export(Request $request)
    {
        // Implementation untuk export laporan
        return response()->json(['message' => 'Export berhasil']);
    }
}
