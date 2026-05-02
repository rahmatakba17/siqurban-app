<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->longText('qr_code')->nullable();
            $table->enum('type', ['pengkurban', 'umum'])->default('umum');
            $table->string('sacrificer_name')->nullable();
            $table->text('special_request')->nullable();
            $table->foreignId('region_id')->constrained('regions')->onDelete('cascade');
            $table->enum('status', ['available', 'received', 'used'])->default('available');
            $table->string('received_by')->nullable();
            $table->timestamp('received_at')->nullable();
            $table->timestamps();

            $table->index('code');
            $table->index('status');
            $table->index('region_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
