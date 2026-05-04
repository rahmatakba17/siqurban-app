<?php

namespace App\Http\Controllers\Api;

use App\Models\Coupon;
use App\Models\Region;
use Illuminate\Http\Request;

class CouponController
{
    public function index()
    {
        $coupons = Coupon::with('region')->paginate(20);
        return response()->json($coupons);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:coupons',
            'type' => 'required|in:pengkurban,umum',
            'sacrificer_name' => 'nullable|string',
            'special_request' => 'nullable|string',
            'region_id' => 'required|exists:regions,id',
        ]);

        $coupon = Coupon::create($validated);
        return response()->json($coupon, 201);
    }

    public function show(Coupon $coupon)
    {
        return response()->json($coupon->load('region'));
    }

    public function scan(Request $request, Coupon $coupon)
    {
        if ($coupon->status === 'received') {
            return response()->json(['message' => 'Kupon sudah digunakan'], 422);
        }

        $coupon->update([
            'status' => 'received',
            'received_by' => auth()->user()->name,
            'received_at' => now(),
        ]);

        return response()->json($coupon);
    }

    public function import(Request $request)
    {
        // Implementation untuk import Excel
        return response()->json(['message' => 'Import berhasil']);
    }

    public function checkPublic($code)
    {
        $coupon = Coupon::with(['region', 'scannedByUser'])->where('code', strtoupper(trim($code)))->first();
        
        if (!$coupon) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json([
            'code' => $coupon->code,
            'status' => $coupon->status,
            'sacrificer_name' => $coupon->sacrificer_name,
            'type' => $coupon->type,
            'region_name' => $coupon->region ? $coupon->region->name : '-',
            'received_at' => $coupon->received_at ? $coupon->received_at->format('d M Y - H:i') : null,
            'scanned_by' => $coupon->scannedByUser ? $coupon->scannedByUser->name : $coupon->received_by,
            'receiver_name' => $coupon->receiver_name,
        ]);
    }
}
