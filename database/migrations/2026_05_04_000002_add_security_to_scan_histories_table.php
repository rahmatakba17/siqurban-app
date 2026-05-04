<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('scan_histories', function (Blueprint $table) {
            // IP address & device fingerprint
            $table->string('ip_address', 45)->nullable()->after('notes');
            $table->string('device_info', 500)->nullable()->after('ip_address');

            // Cara scan: kamera QR atau input manual
            $table->enum('scan_method', ['qr_camera', 'manual_input'])->default('qr_camera')->after('device_info');

            // Status hasil scan — catat SEMUA upaya termasuk gagal
            $table->enum('status_result', ['success', 'duplicate', 'not_found'])->default('success')->after('scan_method');

            $table->index('status_result');
            $table->index('ip_address');
        });
    }

    public function down(): void
    {
        Schema::table('scan_histories', function (Blueprint $table) {
            $table->dropColumn(['ip_address', 'device_info', 'scan_method', 'status_result']);
        });
    }
};
