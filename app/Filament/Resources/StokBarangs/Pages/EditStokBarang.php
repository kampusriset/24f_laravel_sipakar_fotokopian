<?php

namespace App\Filament\Resources\StokBarangs\Pages;

use App\Filament\Resources\StokBarangs\StokBarangResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStokBarang extends EditRecord
{
    protected static string $resource = StokBarangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
