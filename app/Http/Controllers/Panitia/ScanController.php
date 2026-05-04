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
            'coupon_code'   => 'required|string',
            'receiver_name' => 'required|string|max:255',
            'mode'          => 'nullable|string',
        ]);

        $ipAddress  = $request->ip();
        $deviceInfo = substr($request->userAgent() ?? 'Unknown', 0, 500);
        $scanMethod = $request->input('mode', 'qr_camera') === 'manual' ? 'manual_input' : 'qr_camera';

        return \Illuminate\Support\Facades\DB::transaction(function () use ($request, $ipAddress, $deviceInfo, $scanMethod) {
            // Gunakan lockForUpdate untuk mencegah race condition (2 panitia scan bersamaan)
            $coupon = Coupon::with('region')->where('code', $request->coupon_code)->lockForUpdate()->first();

            if (! $coupon) {
                // Walaupun tidak ketemu, kita bisa catat (opsional) atau kembalikan 404 langsung
                return response()->json([
                    'success' => false,
                    'message' => 'Kupon tidak ditemukan.',
                ], 404);
            }

            if ($coupon->status === 'received') {
                // Catat upaya duplikat
                ScanHistory::create([
                    'coupon_id'     => $coupon->id,
                    'user_id'       => auth()->id(),
                    'scan_time'     => now(),
                    'notes'         => 'Mencoba scan kupon yang sudah diterima',
                    'ip_address'    => $ipAddress,
                    'device_info'   => $deviceInfo,
                    'scan_method'   => $scanMethod,
                    'status_result' => 'duplicate',
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Kupon sudah pernah digunakan.',
                    'coupon'  => [
                        'code'            => $coupon->code,
                        'received_by'     => $coupon->received_by,
                        'received_at'     => $coupon->received_at?->format('d/m/Y H:i'),
                        'sacrificer_name' => $coupon->sacrificer_name,
                        'receiver_name'   => $coupon->receiver_name,
                    ],
                ], 422);
            }

            // ── Record scan berhasil ─────────────────────────────────────────
            $scanHistory = ScanHistory::create([
                'coupon_id'     => $coupon->id,
                'user_id'       => auth()->id(),
                'scan_time'     => now(),
                'notes'         => 'Scan sukses via ' . $scanMethod,
                'ip_address'    => $ipAddress,
                'device_info'   => $deviceInfo,
                'scan_method'   => $scanMethod,
                'status_result' => 'success',
            ]);

            $coupon->update([
                'status'             => 'received',
                'received_by'        => auth()->user()->name,
                'received_at'        => now(),
                'scanned_by_user_id' => auth()->id(),
                'receiver_name'      => $request->receiver_name,
            ]);

            $coupon->refresh()->load('region');

            // ── Broadcast via Reverb ─────────────────────────────────
            try {
                broadcast(new CouponScanned($scanHistory->load('user'), $coupon))->toOthers();
            } catch (\Throwable $e) {
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
                    'receiver_name'   => $coupon->receiver_name,
                    'received_at'     => $coupon->received_at?->format('d/m/Y H:i'),
                ],
            ]);
        });
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
