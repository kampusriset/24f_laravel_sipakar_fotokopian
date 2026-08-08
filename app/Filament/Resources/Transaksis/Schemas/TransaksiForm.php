<?php

namespace App\Filament\Resources\Transaksis\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Placeholder;
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
                        Select::make('status_antrean')
                            ->label('Status Pesanan')
                            ->default('Selesai')
                            ->disabled()
                            ->dehydrated(),
                        
                        Select::make('metode')
                            ->label('Metode Pembayaran')
                            ->options([
                                'Cash' => 'Cash',
                                'QRIS' => 'QRIS',
                                'Transfer' => 'Transfer',
                            ]),
                        
                        TextInput::make('jumlah_halaman')
                            ->label('Jumlah Lembar')
                            ->numeric(),
                        
                        TextInput::make('total_harga')
                            ->label('Total Harga Akhir')
                            ->numeric()
                            ->prefix('Rp'),
                    ])->columns(2),
            ]);
    }
}