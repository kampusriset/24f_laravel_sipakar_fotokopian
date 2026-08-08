<?php

namespace App\Filament\Resources\Transaksis\Pages;

use App\Filament\Resources\Transaksis\TransaksiResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTransaksi extends EditRecord
{
    protected static string $resource = TransaksiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $transaksi = $this->record;

        $detail = $transaksi->detailLayanan()->first();

        $data['status_antrean'] = $detail?->status_antrean;
        $data['jumlah_halaman'] = $detail?->jumlah_halaman;

        $pembayaran = $transaksi->pembayaran()->first();
        $data['metode'] = $pembayaran?->metode;

        return $data;
    }

    // Menyimpan kembali perubahan data ke tabel relasi
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $transaksi = $this->record;

        $detail = $transaksi->detail_Layanan()->first();
        if ($detail) {
            $detail->update([
                'status_antrean' => $data['status_antrean'] ?? null,
                'jumlah_halaman' => $data['jumlah_halaman'] ?? null,
            ]);
        }

        $pembayaran = $transaksi->pembayaran()->first();
        if ($pembayaran) {
            $pembayaran->update([
                'metode' => $data['metode'] ?? null,
            ]);
        }

        unset($data['status_antrean'], $data['jumlah_halaman'], $data['metode']);

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}