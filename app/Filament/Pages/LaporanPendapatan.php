<?php

namespace App\Filament\Pages;

use App\Models\Transaksi;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use BackedEnum;
use UnitEnum;

class LaporanPendapatan extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-presentation-chart-line';
    protected static ?string $navigationLabel = 'Laporan Pendapatan';
    protected static ?string $title = 'Laporan Pendapatan';
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
                    $laporan = DB::table('transaksi')
                    ->join('pelanggan', 'transaksi.pelanggan_id', '=', 'pelanggan.id')
                    ->join('detail_layanan', 'transaksi.id', '=', 'detail_layanan.transaksi_id')
                    ->join('layanan', 'detail_layanan.layanan_id', '=', 'layanan.id')
                    ->join('pembayaran', 'transaksi.id', '=', 'pembayaran.transaksi_id')
                    ->select(
                        'transaksi.*',
                        'pelanggan.nama as nama_pelanggan',
                        'layanan.nama_layanan',
                        'detail_layanan.file_dokumen',
                        'detail_layanan.jumlah_halaman',
                        'pembayaran.metode',
                        'transaksi.total_harga',
                    )
                    ->orderBy('transaksi.updated_at', 'desc')
                    ->get();

                    $totalPendapatan = $laporan->sum('total_harga');

                    // Memanggil view PDF yang sudah ada (admin.cetakPdf)
                    $pdf = Pdf::loadView('admin.cetakPdf', compact('laporan', 'totalPendapatan'));

                    // Mengirim file PDF sebagai respons download ke browser
                    return response()->streamDownload(function () use ($pdf) {
                        echo $pdf->output();
                    }, 'Laporan-Pendapatan-' . date('d-m-Y') . '.pdf');
                }),
        ];
    }

    // --- MENGIRIM DATA KE TAMPILAN BLADE ---
    protected function getViewData(): array
    {
        $transaksis = Transaksi::with(['detail_layanan.layanan', 'pembayaran'])->orderBy('created_at', 'desc')->get();
        
        $totalPendapatan = $transaksis->sum('total_harga'); 

        return [
            'transaksis' => $transaksis,
            'totalPendapatan' => $totalPendapatan,
        ];
    }
}
