<?php

namespace App\Filament\Resources\StokBarangs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StokBarangsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_barang')
                    ->label('Nama Barang')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('kategori')
                    ->label('Kategori')
                    ->searchable()
                    ->sortable()
                    ->badge(),

                TextColumn::make('jumlah_stok')
                    ->label('Stok')
                    ->alignCenter()
                    ->badge()
                    ->color(fn ($state) => $state <= 5 ? 'danger' : 'success')
                    ->sortable(),

                TextColumn::make('satuan')
                    ->label('Satuan Barang')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make()
                    ->iconButton()
                    ->tooltip('Edit Barang'),

                DeleteAction::make()
                    ->iconButton()
                    ->tooltip('Hapus Barang')
                    ->visible(function () {
                        /** @var \App\Models\User $user */
                        $user = auth()->user();
                        return $user->role === 'admin';
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(function () {
                            /** @var \App\Models\User $user */
                            $user = auth()->user();
                            return $user->role === 'admin';
                        }),
                ]),
            ]);
    }
}
