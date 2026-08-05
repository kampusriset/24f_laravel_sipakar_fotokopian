<?php

namespace App\Filament\Resources\PerangkatPrinters\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class PerangkatPrinterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_printer')
                    ->label('Nama Printer')
                    ->placeholder('Contoh: Printer Canon')
                    ->required()
                    ->maxLength(255),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'Aktif' => 'Aktif',
                        'Perbaikan' => 'Perbaikan',
                    ])
                    ->default('Aktif')
                    ->required(),
            ]);
    }
}
