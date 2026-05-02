<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kupon — {{ $coupon->code }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #f8fafc; color: #1e293b; }

        .page { max-width: 520px; margin: 2rem auto; padding: 1rem; }

        /* ── Card Kupon ── */
        .coupon-card {
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,.12);
        }

        /* Header */
        .coupon-header {
            background: linear-gradient(135deg, #0f766e 0%, #134e4a 100%);
            color: white;
            padding: 28px 28px 24px;
        }
        .coupon-header-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }
        .coupon-logo { font-size: 22px; font-weight: 900; letter-spacing: -0.5px; }
        .coupon-year {
            background: rgba(255,255,255,.15);
            border-radius: 999px;
            padding: 4px 12px;
            font-size: 12px;
            font-weight: 600;
        }
        .coupon-title { font-size: 13px; font-weight: 500; opacity: .75; margin-bottom: 4px; }
        .coupon-mosque { font-size: 16px; font-weight: 700; }

        /* Badge tipe */
        .type-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 12px;
            background: rgba(255,255,255,.2);
            border-radius: 999px;
            padding: 4px 12px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        /* Body */
        .coupon-body {
            padding: 28px;
            display: flex;
            gap: 24px;
            align-items: flex-start;
        }

        /* QR Code */
        .qr-block {
            flex-shrink: 0;
        }
        .qr-block svg, .qr-block img {
            width: 140px;
            height: 140px;
            border-radius: 12px;
            border: 2px solid #e2e8f0;
            padding: 8px;
            background: white;
        }
        .qr-label {
            text-align: center;
            font-size: 9px;
            color: #94a3b8;
            margin-top: 6px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        /* Info */
        .coupon-info { flex: 1; }
        .info-row { margin-bottom: 14px; }
        .info-label {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #94a3b8;
            margin-bottom: 3px;
        }
        .info-value {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
        }
        .info-code {
            font-family: 'Courier New', monospace;
            font-size: 16px;
            font-weight: 700;
            color: #0f766e;
            background: #f0fdf4;
            border-radius: 8px;
            padding: 6px 10px;
            display: inline-block;
        }

        /* Footer */
        .coupon-footer {
            background: #f8fafc;
            border-top: 2px dashed #e2e8f0;
            padding: 16px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 11px;
            color: #94a3b8;
        }
        .coupon-footer strong { color: #475569; }

        /* Status badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            border-radius: 999px;
            padding: 4px 12px;
            font-size: 12px;
            font-weight: 700;
        }
        .status-available { background: #f0fdf4; color: #16a34a; }
        .status-received   { background: #eff6ff; color: #2563eb; }

        /* Action buttons */
        .actions {
            margin-top: 20px;
            display: flex;
            gap: 12px;
        }
        .btn {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 20px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all .2s;
            text-decoration: none;
        }
        .btn-print { background: #0f766e; color: white; }
        .btn-print:hover { background: #134e4a; }
        .btn-back { background: #f1f5f9; color: #475569; }
        .btn-back:hover { background: #e2e8f0; }

        @media print {
            body { background: white; }
            .page { margin: 0; padding: 0; max-width: 100%; }
            .coupon-card { box-shadow: none; border: 1px solid #e2e8f0; }
            .actions { display: none !important; }
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="coupon-card">
            {{-- Header --}}
            <div class="coupon-header">
                <div class="coupon-header-top">
                    <div class="coupon-logo">🕋 SI Qurban</div>
                    <span class="coupon-year">{{ \App\Models\Setting::get('tahun_kurban', now()->year) }}</span>
                </div>
                <div class="coupon-title">Diselenggarakan oleh</div>
                <div class="coupon-mosque">{{ \App\Models\Setting::get('masjid_name', 'Masjid / Lembaga') }}</div>
                <span class="type-badge">
                    @if($coupon->type === 'pengkurban')
                        🐄 Kupon Pengkurban
                    @else
                        🎫 Kupon Umum
                    @endif
                </span>
            </div>

            {{-- Body --}}
            <div class="coupon-body">
                {{-- QR Code --}}
                <div class="qr-block">
                    {!! $qrSvg !!}
                    <div class="qr-label">Scan untuk verifikasi</div>
                </div>

                {{-- Info --}}
                <div class="coupon-info">
                    <div class="info-row">
                        <div class="info-label">Kode Kupon</div>
                        <div class="info-code">{{ $coupon->code }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Wilayah Distribusi</div>
                        <div class="info-value">{{ $coupon->region?->name ?? '—' }}</div>
                    </div>
                    @if($coupon->sacrificer_name)
                    <div class="info-row">
                        <div class="info-label">Nama Pengkurban</div>
                        <div class="info-value">{{ $coupon->sacrificer_name }}</div>
                    </div>
                    @endif
                    @if($coupon->special_request)
                    <div class="info-row">
                        <div class="info-label">Permintaan Khusus</div>
                        <div class="info-value" style="font-size:12px; color:#64748b">{{ $coupon->special_request }}</div>
                    </div>
                    @endif
                    <div>
                        <div class="info-label">Status</div>
                        <span class="status-badge {{ $coupon->status === 'available' ? 'status-available' : 'status-received' }}">
                            {{ $coupon->status === 'available' ? '✅ Tersedia' : '📦 Sudah Diterima' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="coupon-footer">
                <span>Dibuat: <strong>{{ $coupon->created_at->format('d M Y') }}</strong></span>
                <span>SI Qurban Digital System</span>
                <span>Satu kupon = satu penerima</span>
            </div>
        </div>

        {{-- Actions --}}
        <div class="actions">
            <a href="{{ route('admin.coupons.index') }}" class="btn btn-back">
                ← Kembali
            </a>
            <button onclick="window.print()" class="btn btn-print">
                🖨️ Cetak Kartu Kupon
            </button>
        </div>
    </div>
</body>
</html>
