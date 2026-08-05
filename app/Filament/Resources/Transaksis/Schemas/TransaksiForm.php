<?php

namespace App\Filament\Resources\Transaksis\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Utilities\Get;

class TransaksiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            // ->components([
            //     Section::make('Input Antrean Baru')
            //         ->description('Masukkan detail pesanan pelanggan ke dalam sistem.')
            //         ->components([
            //             TextInput::make('nama_pelanggan')
            //                 ->required()
            //                 ->placeholder('Contoh: Budi Mahasiswa'),
                        
            //             TextInput::make('no_hp')
            //                 ->label('No HP / Whatsapp')
            //                 ->placeholder('Contoh: 081234567890'),

            //             TextInput::make('alamat')
            //                 ->columnSpanFull()
            //                 ->placeholder('Contoh: Jl. Slamet Riyadi, Solo'),

            //             Select::make('sumber_dokumen')
            //                 ->options([
            //                     'digital' => 'Dokumen Digital (Upload File PDF)',
            //                     'fisik' => 'Dokumen Fisik (Input Manual Halaman)',
            //                 ])
            //                 ->required()
            //                 ->live(), 

            //             Select::make('layanan_id')
            //                 ->relationship('layanan', 'nama_layanan') 
            //                 ->required()
            //                 ->label('Jenis Layanan'),

            //             FileUpload::make('file_dokumen')
            //                 ->label('File Dokumen PDF')
            //                 ->acceptedFileTypes(['application/pdf'])
            //                 ->visible(fn (Get $get) => $get('sumber_dokumen') === 'digital')
            //                 ->required(fn (Get $get) => $get('sumber_dokumen') === 'digital'),

            //             TextInput::make('jumlah_halaman')
            //                 ->label('Jumlah Halaman (Manual)')
            //                 ->numeric()
            //                 ->minValue(1)
            //                 ->visible(fn (Get $get) => $get('sumber_dokumen') === 'fisik')
            //                 ->required(fn (Get $get) => $get('sumber_dokumen') === 'fisik'),

            //             TimePicker::make('waktu_deadline')
            //                 ->required(),

            //             Select::make('metode')
            //                 ->options([
            //                     'Cash' => 'Cash',
            //                     'QRIS' => 'QRIS',
            //                 ])
            //                 ->required(),

            //             Select::make('status_antrean')
            //                 ->options([
            //                     'Menunggu' => 'Menunggu',
            //                     'Cetak' => 'Cetak',
            //                     'Selesai' => 'Selesai',
            //                 ])
            //                 ->default('Menunggu')
            //                 ->required(),
            //         ])->columns(2)
            // ]);
            ->schema([
                // Tambahkan field form di sini jika diperlukan
            ]);
    }
}
