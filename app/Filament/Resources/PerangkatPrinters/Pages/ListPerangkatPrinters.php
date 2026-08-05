<?php

namespace App\Filament\Resources\PerangkatPrinters\Pages;

use App\Filament\Resources\PerangkatPrinters\PerangkatPrinterResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPerangkatPrinters extends ListRecords
{
    protected static string $resource = PerangkatPrinterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
