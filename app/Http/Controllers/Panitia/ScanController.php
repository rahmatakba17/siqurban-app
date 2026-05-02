<?php

namespace App\Http\Controllers\Panitia;

use App\Events\CouponScanned;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\ScanHistory;
use Illuminate\Http\Request;

class ScanController extends Controller
{
    public function index()
    {
        return view('panitia.scan', [
            'scanToday' => ScanHistory::where('user_id', auth()->id())
                ->whereDate('scan_time', today())
                ->count(),
        ]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
        ]);

        $coupon = Coupon::with('region')->where('code', $request->coupon_code)->first();

        if (! $coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Kupon tidak ditemukan.',
            ], 404);
        }

        if ($coupon->status === 'received') {
            return response()->json([
                'success' => false,
                'message' => 'Kupon sudah pernah digunakan.',
                'coupon'  => [
                    'code'            => $coupon->code,
                    'received_by'     => $coupon->received_by,
                    'received_at'     => $coupon->received_at?->format('d/m/Y H:i'),
                    'sacrificer_name' => $coupon->sacrificer_name,
                ],
            ], 422);
        }

        // ── Record scan ─────────────────────────────────────────
        $scanHistory = ScanHistory::create([
            'coupon_id' => $coupon->id,
            'user_id'   => auth()->id(),
            'scan_time' => now(),
            'notes'     => 'Scan via ' . ($request->input('mode', 'kamera')),
        ]);

        $coupon->update([
            'status'      => 'received',
            'received_by' => auth()->user()->name,
            'received_at' => now(),
        ]);

        $coupon->refresh()->load('region');

        // ── Broadcast via Reverb ─────────────────────────────────
        try {
            broadcast(new CouponScanned($scanHistory->load('user'), $coupon))->toOthers();
        } catch (\Throwable $e) {
            // Reverb tidak wajib aktif — scan tetap berhasil
            logger()->warning('Reverb broadcast failed: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Kupon berhasil diverifikasi.',
            'coupon'  => [
                'code'            => $coupon->code,
                'type'            => $coupon->type,
                'status'          => $coupon->status,
                'sacrificer_name' => $coupon->sacrificer_name,
                'special_request' => $coupon->special_request,
                'region'          => $coupon->region?->name,
                'received_by'     => $coupon->received_by,
                'received_at'     => $coupon->received_at?->format('d/m/Y H:i'),
            ],
        ]);
    }

    public function history()
    {
        $scans = ScanHistory::where('user_id', auth()->id())
            ->with('coupon.region')
            ->orderBy('scan_time', 'desc')
            ->paginate(15);

        return view('panitia.scans', [
            'scans' => $scans,
        ]);
    }
}
