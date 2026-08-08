<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Pembayaran;
use App\Models\DetailLayanan;
use App\Models\StokBarang;
use Carbon\Carbon;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Total Pendapatan Hari Ini
        $pendapatanHariIni = Pembayaran::whereDate('tanggal_bayar', Carbon::today())->sum('total_bayar');
        
        // Jumlah Transaksi Selesai Hari Ini
        $transaksiSelesai = DetailLayanan::where('status_antrean', 'Selesai')
            ->whereDate('created_at', Carbon::today())
            ->count();
            
        // Jumlah Antrean Aktif (Menunggu / Cetak)
        $antreanAktif = DetailLayanan::whereIn('status_antrean', ['Menunggu', 'Cetak'])
            ->count();
            
        // Jumlah Barang yang Stoknya Menipis
        $stokMenipis = StokBarang::where('jumlah_stok', '<=', 5)->count();

        return [
            Stat::make('Pendapatan Hari Ini', 'Rp ' . number_format($pendapatanHariIni, 0, ',', '.'))
                ->description('Total uang masuk hari ini')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('Transaksi Selesai', $transaksiSelesai . ' Pesanan')
                ->description('Berhasil diproses hari ini')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('info'),

            Stat::make('Antrean Aktif', $antreanAktif . ' Antrean')
                ->description('Sedang menunggu / dicetak')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Stok Barang Menipis', $stokMenipis . ' Barang')
                ->description('Stok tersisa ≤ 5 pcs/rim')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($stokMenipis > 0 ? 'danger' : 'success'),
        ];
    }
}