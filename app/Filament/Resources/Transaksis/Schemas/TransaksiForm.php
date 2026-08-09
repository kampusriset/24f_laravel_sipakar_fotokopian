<?php

namespace App\Filament\Resources\Transaksis\Schemas;

use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Placeholder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transaksi;

class TransaksiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Informasi Dasar')
                    ->description('Data asli pesanan tidak dapat diubah.')
                    ->schema([
                        Placeholder::make('nama_pelanggan_display')
                            ->label('Nama Pelanggan')
                            ->content(fn (?Transaksi $record): string => optional($record?->pelanggan)->nama ?? '-'),
                        
                        Placeholder::make('file_dokumen_display')
                            ->label('Nama File / Layanan')
                            ->content(function (?Transaksi $record): string {
                                $file = optional($record?->detailLayanan)->file_dokumen;
                                if (empty($file) || trim($file) === '') {
                                    return 'Dokumen Fisik';
                                }
                                return preg_replace('/^\d+_/', '', $file);
                            }),
                    ])->columns(2),

                Section::make('Penyesuaian Transaksi')
                    ->description('Edit data di bawah ini jika terdapat perubahan pesanan.')
                    ->schema([
                        Placeholder::make('status_antrean')
                            ->label('Status Pesanan')
                            ->content('Selesai'),
                        
                        Select::make('metode')
                            ->label('Metode Pembayaran')
                            ->options([
                                'Cash' => 'Cash',
                                'QRIS' => 'QRIS',
                            ]),
                        
                        TextInput::make('jumlah_halaman')
                            ->label('Jumlah Lembar')
                            ->numeric()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($set, $record, $state) {
                                if ($record && $record->detail_layanan && $record->detail_layanan->layanan) {
                                    
                                    // Mengambil data harga dari tabel layanan
                                    $hargaPerLembar = $record->detail_layanan->layanan->harga_per_lembar;
                                    
                                    // Kalkulasi perhitungan harga
                                    $totalHargaBaru = (int) $state * $hargaPerLembar;
                                    
                                    // Merubah hasil perhitungan 
                                    $set('total_harga', $totalHargaBaru);
                                }
                            }),
                        
                        TextInput::make('total_harga')
                            ->label('Total Harga Akhir')
                            ->numeric()
                            ->prefix('Rp')
                            ->readOnly(),
                    ])->columns(2),
            ]);
    }
}