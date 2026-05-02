<?php

namespace App\Http\Controllers\Panitia;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\ScanHistory;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('panitia.dashboard', [
            'scanToday' => $user->scanHistories()->whereDate('scan_time', today())->count(),
            'totalScans' => $user->scanHistories()->count(),
            'latestScan' => ScanHistory::where('user_id', $user->id)->with('coupon.region')->latest('scan_time')->first(),
        ]);
    }

    public function profile()
    {
        return view('panitia.profile');
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = auth()->user();
        $user->update($request->validated());

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
