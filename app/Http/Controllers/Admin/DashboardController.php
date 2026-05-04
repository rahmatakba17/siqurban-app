<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSettingsRequest;
use App\Models\Coupon;
use App\Models\Setting;
use App\Models\ScanHistory;
use App\Models\Region;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCoupons    = Coupon::count();
        $couponReceived  = Coupon::where('status', 'received')->count();
        $couponAvailable = Coupon::where('status', 'available')->count();
        $totalScans      = ScanHistory::count();

        // Statistik per wilayah dengan progress
        $regions = Region::with(['coupons'])->get()->map(function ($region) {
            $total    = $region->coupons->count();
            $received = $region->coupons->where('status', 'received')->count();
            $pct      = $total > 0 ? round(($received / $total) * 100) : 0;

            return [
                'name'     => $region->name,
                'total'    => $total,
                'received' => $received,
                'pct'      => $pct,
            ];
        });

        // Distribusi per tipe
        $totalUmum       = Coupon::where('type', 'umum')->count();
        $totalPengkurban = Coupon::where('type', 'pengkurban')->count();

        // Scan terbaru
        $recentScans = ScanHistory::with('coupon.region', 'user')
            ->orderBy('scan_time', 'desc')
            ->limit(8)
            ->get();

        // Data chart: distribusi received per wilayah (untuk Chart.js)
        $chartLabels   = $regions->pluck('name');
        $chartReceived = $regions->pluck('received');
        $chartTotal    = $regions->pluck('total');

        return view('admin.dashboard', compact(
            'totalCoupons', 'couponReceived', 'couponAvailable', 'totalScans',
            'regions', 'totalUmum', 'totalPengkurban', 'recentScans',
            'chartLabels', 'chartReceived', 'chartTotal'
        ));
    }

    public function scans()
    {
        $scans = ScanHistory::with('coupon', 'user')
            ->orderBy('scan_time', 'desc')
            ->paginate(20);

        return view('admin.scans', [
            'scans' => $scans,
        ]);
    }

    public function auditLogs()
    {
        $logs = \App\Models\AuditLog::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.audit-logs', [
            'logs' => $logs,
        ]);
    }

    public function settings()
    {
        return view('admin.settings', [
            'settings' => [
                'app_name'    => Setting::get('app_name', config('app.name')),
                'app_url'     => Setting::get('app_url', config('app.url')),
                'masjid_name' => Setting::get('masjid_name', 'Masjid Raya SI Qurban'),
                'tahun_kurban' => Setting::get('tahun_kurban', now()->year),
            ],
        ]);
    }

    public function updateSettings(UpdateSettingsRequest $request)
    {
        foreach ($request->validated() as $key => $value) {
            Setting::set($key, $value);
        }

        return back()->with('success', 'Pengaturan berhasil diperbarui.');
    }

    public function profile()
    {
        return view('admin.profile', [
            'user' => auth()->user(),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $rules = [
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ];

        if ($request->filled('password')) {
            $rules['password']              = 'required|min:6|confirmed';
            $rules['password_confirmation'] = 'required';
        }

        $validated = $request->validate($rules);

        $user->name  = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? $user->phone;

        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
