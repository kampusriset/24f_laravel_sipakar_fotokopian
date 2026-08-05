<?php

namespace App\Filament\Resources\Layanans\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;

class LayananForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_layanan')
                    ->label('Nama Layanan')
                    ->placeholder('Contoh: Print Warna')
                    ->required()
                    ->maxLength(255),

                TextInput::make('harga_per_lembar')
                    ->label('Harga per Lembar')
                    ->placeholder('Contoh: 1000')
                    ->numeric()
                    ->prefix('Rp')
                    ->required()
                    ->minValue(0),
            ]);
    }
}
