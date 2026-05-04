<?php

use Illuminate\Support\Facades\Route;
use Laravel\Pulse\Facades\Pulse;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\RegionController as AdminRegionController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Panitia\DashboardController as PanitiaDashboardController;
use App\Http\Controllers\Panitia\ScanController as PanitiaScanController;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route(auth()->user()->role === 'admin' ? 'admin.dashboard' : 'panitia.dashboard');
    }
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ─── Admin Routes ────────────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('users', AdminUserController::class)->except(['show']);
    Route::resource('regions', AdminRegionController::class)->except(['show']);
    Route::resource('coupons', AdminCouponController::class);
    Route::post('coupons/import', [AdminCouponController::class, 'import'])->name('coupons.import');
    Route::post('coupons/generate', [AdminCouponController::class, 'generate'])->name('coupons.generate');
    Route::get('coupons/{coupon}/print', [AdminCouponController::class, 'print'])->name('coupons.print');
    Route::get('coupons/print-batch', [AdminCouponController::class, 'printBatch'])->name('coupons.print-batch');

    Route::get('scans', [AdminDashboardController::class, 'scans'])->name('scans');
    Route::get('audit-logs', [AdminDashboardController::class, 'auditLogs'])->name('audit-logs');
    Route::get('reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::get('reports/export', [AdminReportController::class, 'export'])->name('reports.export');
    Route::get('reports/export-excel', [AdminReportController::class, 'exportExcel'])->name('reports.export-excel');
    Route::get('settings', [AdminDashboardController::class, 'settings'])->name('settings');
    Route::post('settings', [AdminDashboardController::class, 'updateSettings'])->name('settings.update');
    Route::get('profile', [AdminDashboardController::class, 'profile'])->name('profile');
    Route::post('profile', [AdminDashboardController::class, 'updateProfile'])->name('profile.update');

    // ─── Laravel Pulse (Monitoring) ─────────────────────────
    Route::get('pulse', function () {
        return view('vendor.pulse.dashboard');
    })->name('pulse');
});

// ─── Panitia Routes ──────────────────────────────────────────
Route::middleware(['auth', 'panitia'])->prefix('panitia')->name('panitia.')->group(function () {
    Route::get('dashboard', [PanitiaDashboardController::class, 'index'])->name('dashboard');

    Route::get('scan', [PanitiaScanController::class, 'index'])->name('scan');
    Route::post('scan/verify', [PanitiaScanController::class, 'verify'])->name('scan.verify');
    Route::get('scans', [PanitiaScanController::class, 'history'])->name('scans');
    Route::get('profile', [PanitiaDashboardController::class, 'profile'])->name('profile');
    Route::post('profile', [PanitiaDashboardController::class, 'updateProfile'])->name('profile.update');
});
