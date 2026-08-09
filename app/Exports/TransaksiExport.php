<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransaksiExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        return Transaksi::with(['detail_layanan.layanan', 'pembayaran'])
            ->whereHas('detail_layanan', function ($query) {
                $query->where('status_antrean', 'Selesai');
            })
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            ['1HZS TOKO FOTOCOPY & PRINT'],
            ['Jl. Contoh Alamat No. 123, Solo, Jawa Tengah, Kode Pos 12345'],
            ['0812-3456-7890 | 1HZS@tokofotocopy.com'],
            [''],
            ['LAPORAN PENDAPATAN 1HZS FOTOCOPY & PRINT'],
            [''],
            [
                'NO',
                'ID TRANSAKSI',
                'TANGGAL',
                'LAYANAN',
                'METODE PEMBAYARAN',
                'TOTAL HARGA (Rp)',
            ]
        ];
    }

    public function map($transaksi): array
    {
        static $no = 1;
        
        $metode = '-';
        if ($transaksi->pembayaran) {
            $metode = $transaksi->pembayaran->metode;
        } elseif (isset($transaksi->metode_pembayaran)) {
            $metode = $transaksi->metode_pembayaran;
        }

        return [
            $no++,
            $transaksi->id,
            $transaksi->created_at->format('d/m/Y'),
            $transaksi->detail_layanan->layanan->nama_layanan ?? '-',
            $metode,
            $transaksi->total_harga,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:F1');
        $sheet->mergeCells('A2:F2');
        $sheet->mergeCells('A3:F3');
        $sheet->mergeCells('A5:F5');

        $sheet->getStyle('A1:A5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            
            5 => ['font' => ['bold' => true, 'size' => 12]],
            
            7 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E5E7EB']
                ]
            ],
        ];
    }
}