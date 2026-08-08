<?php

namespace App\Filament\Pages;

use App\Models\Transaksi;
use App\Models\DetailLayanan;
use App\Models\Layanan;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use BackedEnum;
use UnitEnum;

class LaporanPendapatan extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-presentation-chart-line';
    protected static string|UnitEnum|null $navigationGroup = 'Karyawan';

    protected string $view = 'filament.pages.laporan-pendapatan';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('download_pdf')
                ->label('Download PDF')
                ->color('danger') 
                ->icon('heroicon-o-document-arrow-down')
                ->action(function () {
                    $laporan = Transaksi::with(['pelanggan', 'detail_layanan.layanan', 'pembayaran'])
                                ->orderBy('updated_at', 'desc')
                                ->get();

                    $totalPendapatan = $laporan->sum('total_harga');

                    $pdf = Pdf::loadView('admin.cetakPdf', compact('laporan', 'totalPendapatan'));

                    return response()->streamDownload(function () use ($pdf) {
                        echo $pdf->output();
                    }, 'Laporan-Pendapatan-' . date('d-m-Y') . '.pdf');
                }),
        ];
    }

    protected function getViewData(): array
    {
        // Ambil semua data transaksi untuk tabel
        $transaksis = Transaksi::with(['detail_layanan.layanan', 'pembayaran'])->orderBy('created_at', 'desc')->get();
        
        // Kalkulasi Metrik (Untuk Card Informasi)
        $totalPendapatan = $transaksis->sum('total_harga');
        $totalPesanan = $transaksis->count();
        $totalPelanggan = $transaksis->unique('pelanggan_id')->count();

        // Cari Layanan Terlaris
        $layananTerlaris = DB::table('detail_layanan')
            ->select('layanan_id', DB::raw('count(*) as total'))
            ->groupBy('layanan_id')
            ->orderBy('total', 'desc')
            ->first();

        $namaLayananTerlaris = '-';
        if ($layananTerlaris) {
            $layanan = Layanan::find($layananTerlaris->layanan_id);
            $namaLayananTerlaris = $layanan ? $layanan->nama_layanan : '-';
        }

        return [
            'transaksis' => $transaksis,
            'totalPendapatan' => $totalPendapatan,
            'totalPesanan' => $totalPesanan,
            'totalPelanggan' => $totalPelanggan,
            'namaLayananTerlaris' => $namaLayananTerlaris,
        ];
    }
}