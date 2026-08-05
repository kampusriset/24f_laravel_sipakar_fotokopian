<?php

namespace App\Filament\Resources\PerangkatPrinters\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PerangkatPrintersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no')
                    ->label('No')
                    ->rowIndex(),

                TextColumn::make('nama_printer')
                    ->label('Nama Printer')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Aktif' => 'success',
                        'Perbaikan' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->iconButton()
                    ->tooltip('Edit Printer'),

                DeleteAction::make()
                    ->iconButton()
                    ->tooltip('Hapus Printer')
                    ->visible(function () {
                        /** @var \App\Models\User $user */
                        $user = auth()->user();
                        return $user?->role === 'admin';
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(function () {
                            /** @var \App\Models\User $user */
                            $user = auth()->user();
                            return $user?->role === 'admin';
                        }),
                ]),
            ]);
    }
}