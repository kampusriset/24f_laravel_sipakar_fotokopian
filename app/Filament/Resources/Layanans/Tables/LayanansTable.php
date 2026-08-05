<?php

namespace App\Filament\Resources\Layanans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;


class LayanansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no')
                    ->label('No')
                    ->rowIndex(),

                TextColumn::make('nama_layanan')
                    ->label('Nama Layanan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('harga_per_lembar')
                    ->label('Harga per Lembar')
                    ->money('idr')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->iconButton()
                    ->tooltip('Edit Layanan'),

                DeleteAction::make()
                    ->iconButton()
                    ->tooltip('Hapus Layanan')
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
