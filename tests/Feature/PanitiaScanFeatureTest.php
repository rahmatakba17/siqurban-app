<?php

namespace Tests\Feature;

use App\Models\Coupon;
use App\Models\Region;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PanitiaScanFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_panitia_can_verify_coupon(): void
    {
        $panitia = User::factory()->create(['role' => 'panitia']);
        $region = Region::create([
            'name' => 'Wilayah Utara',
            'description' => 'Wilayah pengujian',
            'status' => 'active',
        ]);

        $coupon = Coupon::create([
            'code' => 'KPN-SCAN-001',
            'qr_code' => '{}',
            'type' => 'umum',
            'region_id' => $region->id,
            'status' => 'available',
        ]);

        $response = $this->actingAs($panitia)->postJson(route('panitia.scan.verify'), [
            'coupon_code' => $coupon->code,
        ]);

        $response->assertOk()->assertJson(['success' => true]);
        $this->assertDatabaseHas('coupons', [
            'id' => $coupon->id,
            'status' => 'received',
        ]);
        $this->assertDatabaseHas('scan_histories', [
            'coupon_id' => $coupon->id,
            'user_id' => $panitia->id,
        ]);
    }
}
