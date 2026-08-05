<?php

namespace App\Filament\Resources\PerangkatPrinters;

use App\Filament\Resources\PerangkatPrinters\Pages\CreatePerangkatPrinter;
use App\Filament\Resources\PerangkatPrinters\Pages\EditPerangkatPrinter;
use App\Filament\Resources\PerangkatPrinters\Pages\ListPerangkatPrinters;
use App\Filament\Resources\PerangkatPrinters\Schemas\PerangkatPrinterForm;
use App\Filament\Resources\PerangkatPrinters\Tables\PerangkatPrintersTable;
use App\Models\PerangkatPrinter;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PerangkatPrinterResource extends Resource
{
    protected static ?string $model = PerangkatPrinter::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'PerangkatPrinter';

    public static function form(Schema $schema): Schema
    {
        return PerangkatPrinterForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PerangkatPrintersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPerangkatPrinters::route('/'),
            'create' => CreatePerangkatPrinter::route('/create'),
            'edit' => EditPerangkatPrinter::route('/{record}/edit'),
        ];
    }
}
