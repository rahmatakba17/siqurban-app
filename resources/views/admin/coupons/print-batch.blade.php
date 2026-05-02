<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Batch Kupon — SI Qurban</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #f8fafc; }

        /* Grid 2 kartu per baris */
        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            padding: 24px;
            max-width: 1100px;
            margin: 0 auto;
        }

        .coupon-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,.08);
            page-break-inside: avoid;
        }
        .coupon-header {
            background: linear-gradient(135deg, #0f766e 0%, #134e4a 100%);
            color: white;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .coupon-header .logo { font-size: 14px; font-weight: 900; }
        .type-chip {
            background: rgba(255,255,255,.2);
            border-radius: 999px;
            padding: 3px 10px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .coupon-body {
            padding: 16px 20px;
            display: flex;
            gap: 16px;
            align-items: flex-start;
        }
        .qr-block svg, .qr-block img {
            width: 100px;
            height: 100px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            padding: 6px;
            background: white;
        }
        .coupon-info { flex: 1; }
        .info-label { font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: #94a3b8; margin-bottom: 2px; }
        .info-value { font-size: 13px; font-weight: 600; color: #1e293b; margin-bottom: 10px; }
        .info-code { font-family: monospace; font-size: 12px; font-weight: 700; color: #0f766e; }
        .coupon-footer {
            border-top: 1.5px dashed #e2e8f0;
            padding: 8px 20px;
            font-size: 9px;
            color: #94a3b8;
            display: flex;
            justify-content: space-between;
        }

        .actions {
            padding: 20px 24px;
            display: flex;
            gap: 12px;
        }
        .btn {
            padding: 10px 20px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-print { background: #0f766e; color: white; }
        .btn-back  { background: #f1f5f9; color: #475569; text-decoration: none; }

        @media print {
            body { background: white; }
            .actions { display: none; }
            .grid { padding: 0; gap: 10px; }
        }
    </style>
</head>
<body>
    <div class="actions">
        <a href="{{ route('admin.coupons.index') }}" class="btn btn-back">← Kembali</a>
        <button onclick="window.print()" class="btn btn-print">🖨️ Cetak Semua ({{ $couponsWithQr->count() }} Kupon)</button>
    </div>

    <div class="grid">
        @foreach($couponsWithQr as $item)
        @php $coupon = $item['coupon']; $qrSvg = $item['qrSvg']; @endphp
        <div class="coupon-card">
            <div class="coupon-header">
                <span class="logo">🕋 SI Qurban</span>
                <span class="type-chip">{{ ucfirst($coupon->type) }}</span>
            </div>
            <div class="coupon-body">
                <div class="qr-block">{!! $qrSvg !!}</div>
                <div class="coupon-info">
                    <div class="info-label">Kode</div>
                    <div class="info-code">{{ $coupon->code }}</div>
                    <div class="info-label" style="margin-top:8px">Wilayah</div>
                    <div class="info-value">{{ $coupon->region?->name ?? '—' }}</div>
                    @if($coupon->sacrificer_name)
                    <div class="info-label">Pengkurban</div>
                    <div class="info-value" style="font-size:12px">{{ $coupon->sacrificer_name }}</div>
                    @endif
                </div>
            </div>
            <div class="coupon-footer">
                <span>{{ $coupon->created_at->format('d M Y') }}</span>
                <span>Satu kupon = satu penerima</span>
            </div>
        </div>
        @endforeach
    </div>
</body>
</html>
