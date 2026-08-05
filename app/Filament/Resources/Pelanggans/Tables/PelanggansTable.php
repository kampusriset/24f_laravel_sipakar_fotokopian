<?php

namespace App\Filament\Resources\Pelanggans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PelanggansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('rowIndex')
                    ->rowIndex()
                    ->label('No'),

                TextColumn::make('nama')
                    ->label('Nama Pelanggan')
                    ->searchable(),

                TextColumn::make('no_hp')
                    ->label('No. HP')
                    ->default('-')
                    ->searchable(),

                TextColumn::make('alamat')
                    ->label('Alamat')
                    ->default('-'),

                TextColumn::make('created_at')
                    ->label('Tgl Terdaftar')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
