<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Coupon;
use App\Models\User;
use App\Models\Region;
use App\Models\ScanHistory;
use App\Models\Setting;
use App\Http\Controllers\Admin\CouponController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $qrCtrl = new CouponController();

        // ─── Settings ─────────────────────────────────────────────
        Setting::set('masjid_name', 'Masjid Al-Ikhlas Tamalanrea');
        Setting::set('tahun_kurban', now()->year);
        Setting::set('app_name', 'SI Qurban');
        Setting::set('app_url', 'http://localhost:8000');

        // ─── Admin ────────────────────────────────────────────────
        User::updateOrCreate(['email' => 'admin@siqurban.local'], [
            'name'     => 'Admin SI Qurban',
            'password' => Hash::make('password'),
            'phone'    => '081234567890',
            'role'     => 'admin',
            'status'   => 'active',
        ]);

        // ─── Panitia ──────────────────────────────────────────────
        $panitiaNames = [
            'Ahmad Fauzi', 'Siti Rahma', 'Muhammad Rizky',
            'Nur Aisyah', 'Bagas Santoso',
        ];
        $panitiaUsers = [];
        foreach ($panitiaNames as $i => $name) {
            $panitiaUsers[] = User::updateOrCreate([
                'email' => 'panitia' . ($i + 1) . '@siqurban.local',
            ], [
                'name'     => $name,
                'password' => Hash::make('password'),
                'phone'    => '0812345' . str_pad((string) ($i + 1), 5, '0', STR_PAD_LEFT),
                'role'     => 'panitia',
                'status'   => 'active',
            ]);
        }

        // ─── Wilayah ──────────────────────────────────────────────
        $regionData = [
            ['name' => 'RT 01 Blok A', 'description' => 'Perumahan Blok A dan sekitarnya'],
            ['name' => 'RT 02 Blok B', 'description' => 'Perumahan Blok B dan sekitarnya'],
            ['name' => 'RT 03 Blok C', 'description' => 'Perumahan Blok C dan sekitarnya'],
            ['name' => 'RT 04 Blok D', 'description' => 'Perumahan Blok D dan sekitarnya'],
            ['name' => 'RT 05 Umum',   'description' => 'Warga umum & dhuafa sekitar masjid'],
        ];

        $regions = collect($regionData)->map(
            fn (array $r) => Region::updateOrCreate(['name' => $r['name']], array_merge($r, ['status' => 'active']))
        );

        // ─── Kupon Pengkurban (24 kupon) ──────────────────────────
        $pengkurbanNames = [
            'H. Mahmud Saleh', 'Hj. Fatimah Zahra', 'Drs. Irfan Hakim',
            'Ustadz Abdul Karim', 'dr. Rina Wulandari', 'Bapak Joko Susilo',
            'Ibu Sari Dewi', 'Prof. Ahmad Dahlan', 'H. Baharuddin',
            'Hj. Nurhayati', 'Muhammad Yusuf', 'Andi Syahril',
        ];

        foreach ($pengkurbanNames as $i => $name) {
            $region = $regions[$i % $regions->count()];
            $code   = 'PKB-' . now()->format('Y') . '-' . strtoupper(Str::random(4)) . str_pad((string) ($i + 1), 3, '0', STR_PAD_LEFT);

            Coupon::updateOrCreate(['code' => $code], [
                'qr_code'         => json_encode(['coupon_code' => $code, 'generated_at' => now()->toIso8601String()]),
                'type'            => 'pengkurban',
                'sacrificer_name' => $name,
                'special_request' => $i % 3 === 0 ? 'Mohon dipisahkan tulang dan daging' : null,
                'region_id'       => $region->id,
                'status'          => 'available',
            ]);
        }

        // ─── Kupon Umum (36 kupon) ────────────────────────────────
        for ($i = 0; $i < 36; $i++) {
            $region = $regions[$i % $regions->count()];
            $code   = 'UMM-' . now()->format('Y') . '-' . strtoupper(Str::random(4)) . str_pad((string) ($i + 1), 3, '0', STR_PAD_LEFT);

            Coupon::updateOrCreate(['code' => $code], [
                'qr_code'   => json_encode(['coupon_code' => $code, 'generated_at' => now()->toIso8601String()]),
                'type'      => 'umum',
                'region_id' => $region->id,
                'status'    => 'available',
            ]);
        }

        // ─── Simulasi scan (beberapa kupon sudah diterima) ────────
        $panitia  = User::where('role', 'panitia')->get();
        $coupons  = Coupon::inRandomOrder()->limit(20)->get();

        foreach ($coupons as $j => $coupon) {
            $panitiaUser = $panitia[$j % $panitia->count()];

            ScanHistory::updateOrCreate([
                'coupon_id' => $coupon->id,
                'user_id'   => $panitiaUser->id,
            ], [
                'scan_time' => now()->subMinutes(rand(10, 240)),
                'notes'     => 'Verifikasi saat pembagian hari pertama',
            ]);

            $coupon->update([
                'status'      => 'received',
                'received_by' => $panitiaUser->name,
                'received_at' => now()->subMinutes(rand(10, 240)),
            ]);
        }

        $this->command->info('✅ Seeder selesai!');
        $this->command->info('   Admin: admin@siqurban.local / password');
        $this->command->info('   Panitia: panitia1@siqurban.local / password');
        $this->command->info('   Total kupon: ' . Coupon::count() . ' | Diterima: ' . Coupon::where('status','received')->count());
    }
}
