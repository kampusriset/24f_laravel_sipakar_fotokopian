<?php

namespace App\Filament\Resources\Transaksis;

use App\Filament\Resources\Transaksis\Pages\ListTransaksis;
use App\Filament\Resources\Transaksis\Schemas\TransaksiForm;
use App\Filament\Resources\Transaksis\Tables\TransaksisTable;
use App\Filament\Resources\Transaksis\Pages;
use App\Models\Transaksi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Forms\Form;

class TransaksiResource extends Resource
{
    protected static ?string $model = Transaksi::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationLabel = 'Riwayat Transaksi';
    protected static ?string $modelLabel = 'Riwayat Transaksi';
    protected static ?string $pluralModelLabel = 'Riwayat Transaksi';

    protected static ?string $recordTitleAttribute = 'Transaksi';

    public static function form(Schema $schema): Schema
    {
        return TransaksiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TransaksisTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    // CREATE (Kasir)
    public static function canCreate(): bool
    {
        /** @var \App\Models\User|null $user */
        $user = auth()->user();
        
        return $user?->role === 'kasir'; 
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTransaksis::route('/'),
            'edit' => Pages\EditTransaksi::route('/{record}/edit'),
        ];
    }
}