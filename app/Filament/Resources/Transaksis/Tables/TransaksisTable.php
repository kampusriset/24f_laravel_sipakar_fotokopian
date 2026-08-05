<?php

namespace App\Filament\Resources\Transaksis\Tables;

use App\Models\Transaksi;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class TransaksisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (\Illuminate\Database\Eloquent\Builder $query) {
                return $query
                    ->select(
                        'transaksi.*', 
                        'pelanggan.nama as nama_pelanggan', 
                        'detail_layanan.file_dokumen', 
                        'detail_layanan.jumlah_halaman', 
                        'detail_layanan.waktu_deadline', 
                        'detail_layanan.status_antrean', 
                        'layanan.nama_layanan', 
                        'pembayaran.metode', 
                        'transaksi.total_harga as total_bayar'
                    )
                    ->join('pelanggan', 'transaksi.pelanggan_id', '=', 'pelanggan.id')
                    ->join('detail_layanan', 'transaksi.id', '=', 'detail_layanan.transaksi_id')
                    ->join('layanan', 'detail_layanan.layanan_id', '=', 'layanan.id')
                    ->join('pembayaran', 'transaksi.id', '=', 'pembayaran.transaksi_id')
                    ->where('detail_layanan.status_antrean', '=', 'Selesai');
            })
            ->columns([
                TextColumn::make('nama_pelanggan')
                    ->label('Nama Pelanggan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                
                TextColumn::make('file_dokumen')
                    ->label('File')
                    ->formatStateUsing(function ($state) {
                        if (empty($state) || trim($state) === '') {
                            return 'Dokumen Fisik';
                        }
                        return preg_replace('/^\d+_/', '', $state);
                    })
                    ->icon(fn ($state) => $state ? 'heroicon-o-document-text' : 'heroicon-o-document')
                    ->limit(20) 
                    ->tooltip(fn ($state) => $state),

                TextColumn::make('jumlah_halaman')
                    ->label('Halaman')
                    ->alignCenter()
                    ->sortable(),

                TextColumn::make('nama_layanan')
                    ->label('Layanan')
                    ->sortable(),

                TextColumn::make('waktu_deadline')
                    ->label('Tenggat')
                    ->date('d/m/Y')
                    ->sortable(),
                
                TextColumn::make('total_bayar')
                    ->label('Total')
                    ->money('idr')
                    ->color('primary')
                    ->weight('bold')
                    ->sortable(),

                TextColumn::make('metode')
                    ->label('Pembayaran')
                    ->badge(),

                TextColumn::make('status_antrean')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Selesai' => 'success',
                        'Menunggu' => 'warning',
                        'Cetak' => 'info',
                        default => 'gray',
                    }),
            ])
            ->contentGrid([
                // Memastikan tabel tidak memaksa scroll di layar lebar
            ])
            ->filters([
                // Tambahkan filter jika diperlukan
            ])
            ->actions([
                // Tombol Edit
                EditAction::make()
                    ->iconButton()
                    ->tooltip('Edit Transaksi'),

                // Tombol Hapus khusus Admin
                DeleteAction::make()
                    ->iconButton()
                    ->tooltip('Hapus Transaksi')
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