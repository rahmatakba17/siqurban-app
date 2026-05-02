<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Region;
use App\Models\ScanHistory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ReportController extends Controller
{
    public function index()
    {
        $totalCoupons   = Coupon::count();
        $couponReceived = Coupon::where('status', 'received')->count();
        $totalScans     = ScanHistory::count();

        $regions = Region::withCount([
            'coupons',
            'coupons as coupons_received_count' => fn ($q) => $q->where('status', 'received'),
        ])->get()->map(function ($r) {
            return [
                'name'     => $r->name,
                'total'    => $r->coupons_count,
                'received' => $r->coupons_received_count,
                'pct'      => $r->coupons_count > 0
                    ? round(($r->coupons_received_count / $r->coupons_count) * 100)
                    : 0,
            ];
        });

        $recentScans = ScanHistory::with('coupon.region', 'user')
            ->latest('scan_time')
            ->limit(10)
            ->get();

        // Data Chart.js
        $chartLabels   = $regions->pluck('name');
        $chartTotal    = $regions->pluck('total');
        $chartReceived = $regions->pluck('received');

        return view('admin.reports.index', compact(
            'totalCoupons', 'couponReceived', 'totalScans',
            'regions', 'recentScans', 'chartLabels', 'chartTotal', 'chartReceived'
        ));
    }

    public function export()
    {
        $rows = collect([
            ['Kode', 'Tipe', 'Wilayah', 'Status', 'Nama Pengkurban', 'Permintaan Khusus', 'Diterima Oleh', 'Waktu Diterima'],
        ])->merge(
            Coupon::with('region')->get()->map(fn (Coupon $c) => [
                $c->code,
                ucfirst($c->type),
                $c->region?->name ?? '-',
                ucfirst($c->status),
                $c->sacrificer_name ?? '-',
                $c->special_request ?? '-',
                $c->received_by ?? '-',
                optional($c->received_at)?->format('d-m-Y H:i') ?? '-',
            ])
        );

        $stream = fopen('php://temp', 'r+');
        fprintf($stream, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM
        foreach ($rows as $row) {
            fputcsv($stream, $row);
        }
        rewind($stream);
        $csv = stream_get_contents($stream);
        fclose($stream);

        return response($csv, 200, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="laporan-siqurban-' . now()->format('Ymd-His') . '.csv"',
        ]);
    }

    public function exportExcel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Kupon');

        // Header style
        $headerStyle = [
            'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '0D6E56']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ];

        $headers = ['Kode', 'Tipe', 'Wilayah', 'Status', 'Nama Pengkurban', 'Permintaan Khusus', 'Diterima Oleh', 'Waktu Diterima'];
        $cols = range('A', 'H');

        foreach ($headers as $i => $h) {
            $cell = $cols[$i] . '1';
            $sheet->setCellValue($cell, $h);
            $sheet->getStyle($cell)->applyFromArray($headerStyle);
        }

        // Data rows
        $row = 2;
        Coupon::with('region')->get()->each(function (Coupon $c) use ($sheet, &$row) {
            $sheet->setCellValue("A{$row}", $c->code);
            $sheet->setCellValue("B{$row}", ucfirst($c->type));
            $sheet->setCellValue("C{$row}", $c->region?->name ?? '-');
            $sheet->setCellValue("D{$row}", ucfirst($c->status));
            $sheet->setCellValue("E{$row}", $c->sacrificer_name ?? '-');
            $sheet->setCellValue("F{$row}", $c->special_request ?? '-');
            $sheet->setCellValue("G{$row}", $c->received_by ?? '-');
            $sheet->setCellValue("H{$row}", optional($c->received_at)?->format('d-m-Y H:i') ?? '-');

            // Zebra striping
            if ($row % 2 === 0) {
                $sheet->getStyle("A{$row}:H{$row}")->applyFromArray([
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F0FDF9']],
                ]);
            }
            $row++;
        });

        // Auto width
        foreach ($cols as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $filename = 'laporan-siqurban-' . now()->format('Ymd-His') . '.xlsx';
        $writer   = new Xlsx($spreadsheet);

        return response()->stream(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Cache-Control'       => 'max-age=0',
        ]);
    }
}
