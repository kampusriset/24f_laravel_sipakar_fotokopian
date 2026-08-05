<?php

namespace App\Filament\Resources\PerangkatPrinters\Pages;

use App\Filament\Resources\PerangkatPrinters\PerangkatPrinterResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPerangkatPrinter extends EditRecord
{
    protected static string $resource = PerangkatPrinterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
