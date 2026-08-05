<?php

namespace App\Filament\Resources\StokBarangs\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;

class StokBarangForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_barang')
                    ->label('Nama Barang')
                    ->placeholder('Contoh: Kertas A4')
                    ->required()
                    ->maxLength(255),

                TextInput::make('kategori')
                    ->label('Kategori')
                    ->placeholder('Contoh: Kertas')
                    ->required()
                    ->maxLength(255),

                TextInput::make('jumlah_stok')
                    ->label('Jumlah Stok')
                    ->placeholder('Contoh: 50')
                    ->numeric()
                    ->required()
                    ->minValue(1),

                TextInput::make('satuan')
                    ->label('Satuan Barang')
                    ->placeholder('Contoh: Rim / Pcs / Lembar')
                    ->required()
                    ->maxLength(255),
            ]);
    }
}