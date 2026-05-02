<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scan_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coupon_id')->constrained('coupons')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('scan_time');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('coupon_id');
            $table->index('user_id');
            $table->index('scan_time');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scan_histories');
    }
};
