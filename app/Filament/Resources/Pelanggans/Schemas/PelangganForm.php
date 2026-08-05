<?php

namespace App\Filament\Resources\Pelanggans\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\TextInput;
use Filament\Schemas\Components\Textarea;

class PelangganForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->label('Nama Pelanggan')
                    ->required(),
                TextInput::make('no_hp')
                    ->label('No. HP / WhatsApp'),
                Textarea::make('alamat')
                    ->label('Alamat Lengkap'),
            ]);
    }
}
