<?php

namespace Tests\Feature;

use App\Models\Region;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCrudFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_user_region_and_coupon(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $userResponse = $this->post(route('admin.users.store'), [
            'name' => 'Panitia Operasional',
            'email' => 'operasional@example.com',
            'password' => 'password123',
            'phone' => '081111111111',
            'role' => 'panitia',
            'status' => 'active',
        ]);
        $userResponse->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', ['email' => 'operasional@example.com']);

        $regionResponse = $this->post(route('admin.regions.store'), [
            'name' => 'Wilayah Tengah',
            'description' => 'Area distribusi utama',
            'status' => 'active',
        ]);
        $regionResponse->assertRedirect(route('admin.regions.index'));
        $this->assertDatabaseHas('regions', ['name' => 'Wilayah Tengah']);

        $region = Region::where('name', 'Wilayah Tengah')->firstOrFail();

        $couponResponse = $this->post(route('admin.coupons.store'), [
            'code' => 'KPN-UJI-001',
            'type' => 'umum',
            'sacrificer_name' => 'Penerima Uji',
            'special_request' => 'Tanpa cabai',
            'region_id' => $region->id,
            'status' => 'available',
        ]);
        $couponResponse->assertRedirect(route('admin.coupons.index'));
        $this->assertDatabaseHas('coupons', ['code' => 'KPN-UJI-001']);
    }

    public function test_region_validation_rejects_duplicate_name(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        Region::create([
            'name' => 'Wilayah Timur',
            'description' => 'Data awal',
            'status' => 'active',
        ]);

        $response = $this->from(route('admin.regions.create'))->post(route('admin.regions.store'), [
            'name' => 'Wilayah Timur',
            'description' => 'Data duplikat',
            'status' => 'active',
        ]);

        $response->assertRedirect(route('admin.regions.create'));
        $response->assertSessionHasErrors('name');
    }
}
