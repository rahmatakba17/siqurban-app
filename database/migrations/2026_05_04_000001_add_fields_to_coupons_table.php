<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            // FK ke user (panitia) yang melakukan scan — anti-fraud
            $table->foreignId('scanned_by_user_id')
                ->nullable()
                ->after('received_at')
                ->constrained('users')
                ->nullOnDelete();

            // Nama penerima daging (diisi panitia saat scan)
            $table->string('receiver_name')->nullable()->after('scanned_by_user_id');

            // Catatan tambahan panitia saat penyerahan
            $table->text('receiver_notes')->nullable()->after('receiver_name');
        });
    }

    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropForeign(['scanned_by_user_id']);
            $table->dropColumn(['scanned_by_user_id', 'receiver_name', 'receiver_notes']);
        });
    }
};
