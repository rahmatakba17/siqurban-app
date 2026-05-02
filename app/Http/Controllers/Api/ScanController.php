<?php

namespace App\Http\Controllers\Api;

use App\Models\ScanHistory;
use Illuminate\Http\Request;

class ScanController
{
    public function index()
    {
        $scans = ScanHistory::with('coupon', 'user')->paginate(20);
        return response()->json($scans);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'coupon_id' => 'required|exists:coupons,id',
        ]);

        $scan = ScanHistory::create([
            'coupon_id' => $validated['coupon_id'],
            'user_id' => auth()->id(),
            'scan_time' => now(),
        ]);

        return response()->json($scan, 201);
    }
}
