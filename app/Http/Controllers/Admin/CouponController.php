<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GenerateCouponRequest;
use App\Http\Requests\ImportCouponRequest;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use App\Models\Coupon;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Output\QROutputInterface;
use chillerlan\QRCode\Data\QRMatrix;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        $query = Coupon::with('region')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('region_id')) {
            $query->where('region_id', $request->region_id);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('code', 'like', '%' . $request->search . '%')
                  ->orWhere('sacrificer_name', 'like', '%' . $request->search . '%');
            });
        }

        $coupons = $query->paginate(15)->withQueryString();
        $regions = Region::where('status', 'active')->orderBy('name')->get();

        return view('admin.coupons.index', [
            'coupons' => $coupons,
            'regions' => $regions,
        ]);
    }

    public function create()
    {
        return view('admin.coupons.create', [
            'regions' => Region::where('status', 'active')->orderBy('name')->get(),
        ]);
    }

    public function store(StoreCouponRequest $request)
    {
        $validated = $request->validated();

        Coupon::create([
            ...$validated,
            'qr_code' => $this->buildCouponPayload($validated['code']),
        ]);

        return redirect()->route('admin.coupons.index')->with('success', 'Kupon berhasil ditambahkan.');
    }

    public function generate(GenerateCouponRequest $request)
    {
        $validated = $request->validated();

        $count = 0;
        for ($i = 0; $i < $validated['quantity']; $i++) {
            $code = 'KPN-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6)) . $i;

            Coupon::create([
                'code'      => $code,
                'qr_code'   => $this->buildCouponPayload($code),
                'type'      => $validated['type'],
                'region_id' => $validated['region_id'],
                'status'    => 'available',
            ]);

            $count++;
        }

        return back()->with('success', "$count kupon berhasil dibuat.");
    }

    public function import(ImportCouponRequest $request)
    {
        $validated = $request->validated();
        $handle = fopen($validated['file']->getRealPath(), 'r');
        $imported = 0;

        if ($handle === false) {
            return back()->withErrors(['file' => 'File CSV tidak dapat dibaca.']);
        }

        while (($row = fgetcsv($handle)) !== false) {
            $code = trim((string) ($row[0] ?? ''));

            if (strtolower($code) === 'kode') {
                continue;
            }

            if ($code === '' || Coupon::where('code', $code)->exists()) {
                continue;
            }

            Coupon::create([
                'code'             => $code,
                'qr_code'          => $this->buildCouponPayload($code),
                'type'             => $validated['type'],
                'region_id'        => $validated['region_id'],
                'sacrificer_name'  => trim((string) ($row[1] ?? '')) ?: null,
                'special_request'  => trim((string) ($row[2] ?? '')) ?: null,
                'status'           => 'available',
            ]);
            $imported++;
        }

        fclose($handle);

        return back()->with('success', "Import CSV selesai. {$imported} kupon berhasil ditambahkan.");
    }

    public function show(Coupon $coupon)
    {
        return view('admin.coupons.show', [
            'coupon' => $coupon->load('region', 'scanHistories.user'),
            'qrSvg'  => $this->generateQrSvg($coupon->code),
        ]);
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', [
            'coupon'  => $coupon,
            'regions' => Region::where('status', 'active')->orderBy('name')->get(),
        ]);
    }

    public function update(UpdateCouponRequest $request, Coupon $coupon)
    {
        $validated = $request->validated();
        $validated['qr_code'] = $this->buildCouponPayload($validated['code']);

        $oldValues = $coupon->getAttributes();
        $coupon->update($validated);

        \App\Models\AuditLog::create([
            'user_id'     => auth()->id(),
            'action'      => 'coupon.update',
            'model_type'  => 'Coupon',
            'model_id'    => $coupon->id,
            'old_values'  => $oldValues,
            'new_values'  => $coupon->getAttributes(),
            'ip_address'  => request()->ip(),
            'description' => 'Admin mengubah data kupon',
        ]);

        return redirect()->route('admin.coupons.index')->with('success', 'Kupon berhasil diperbarui.');
    }

    public function destroy(Coupon $coupon)
    {
        $oldValues = $coupon->getAttributes();
        $id = $coupon->id;
        
        $coupon->delete();

        \App\Models\AuditLog::create([
            'user_id'     => auth()->id(),
            'action'      => 'coupon.delete',
            'model_type'  => 'Coupon',
            'model_id'    => $id,
            'old_values'  => $oldValues,
            'new_values'  => null,
            'ip_address'  => request()->ip(),
            'description' => 'Admin menghapus kupon',
        ]);

        return back()->with('success', 'Kupon berhasil dihapus.');
    }

    public function print(Coupon $coupon)
    {
        return view('admin.coupons.print', [
            'coupon' => $coupon->load('region'),
            'qrSvg'  => $this->generateQrSvg($coupon->code),
        ]);
    }

    public function printBatch(Request $request)
    {
        $ids = array_filter(explode(',', $request->query('ids', '')));
        $coupons = Coupon::with('region')->whereIn('id', $ids)->get();

        $couponsWithQr = $coupons->map(fn ($c) => [
            'coupon' => $c,
            'qrSvg'  => $this->generateQrSvg($c->code),
        ]);

        return view('admin.coupons.print-batch', compact('couponsWithQr'));
    }

    /**
     * Generate SVG QR Code dari kode kupon.
     */
    public function generateQrSvg(string $code): string
    {
        try {
            $options = new QROptions([
                'outputType'   => QROutputInterface::MARKUP_SVG,
                'eccLevel'     => QRCode::ECC_H,
                'imageBase64'  => false,
                'svgViewBox'   => true,
                'svgAddXmlHeader' => false,
                'scale'        => 5,
                'quietzoneSize' => 2,
            ]);

            return (new QRCode($options))->render($code);
        } catch (\Throwable $e) {
            return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><rect width="100" height="100" fill="#f3f4f6"/><text x="50" y="55" text-anchor="middle" fill="#6b7280" font-size="10">QR Error</text></svg>';
        }
    }

    /**
     * Build payload JSON untuk kolom qr_code (disimpan di DB sebagai identitas).
     */
    protected function buildCouponPayload(string $code): string
    {
        return json_encode([
            'coupon_code'  => $code,
            'generated_at' => now()->toIso8601String(),
        ], JSON_UNESCAPED_SLASHES);
    }
}
