<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Pembayaran;
use App\Models\DetailLayanan;
use App\Models\Pelanggan;
use App\Models\Layanan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    // Read | Ambil data gabungan dari Layanan & Pelanggan
    public function getMasterData() {
        $pelanggan = Pelanggan::select('id', 'nama')->get();
        $layanan = Layanan::select('id', 'nama_layanan', 'harga_per_lembar')->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'pelanggan' => $pelanggan,
                'layanan' => $layanan,
            ]
        ]);
    }

    // Create
    public function create(Request $request) {
        // Kemanan Database
        DB::beginTransaction();

        try {
            $pelangganId = $request->pelanggan_id;

            $request->validate([
                'nama_pelanggan' => 'required|string',
                'no_hp' => 'nullable|string',
                'alamat' => 'nullable|string',
            ]);

            if(!$pelangganId) {
                $pelangganBaru = Pelanggan::create([
                    'nama' => $request->nama_pelanggan,
                    'no_hp' => $request->no_hp ?? '-',
                    'alamat' => $request->alamat ?? '-',
                ]);
                $pelangganId = $pelangganBaru->id;
            }

            $transaksi = Transaksi::create([
                'pelanggan_id' => $pelangganId,
                'operator_id' => auth('sanctum')->id(),
                'tanggal' => Carbon::now(),
                'total_harga' => $request->total_harga
            ]);

            Pembayaran::create([
                'transaksi_id' => $transaksi->id,
                'total_bayar' => $request->total_harga,
                'metode' => $request->metode,
                'tanggal_bayar' => Carbon::now(),
            ]);

            DetailLayanan::create([
                'transaksi_id' => $transaksi->id,
                'layanan_id' => $request->layanan_id,
                'jumlah_halaman' => $request->jumlah_halaman,
                'harga_satuan' => $request->harga_satuan,
                'file_dokumen' => $request->file_dokumen,
                'subtotal' => $request->total_harga,
                'waktu_deadline' => Carbon::parse($request->waktu_deadline),
                'status_antrean' => 'Menunggu',
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Transaksi berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan transaksi: ' . $e->getMessage()
            ], 500);
        }
    }

    // Update
    public function update(Request $request, $id) {
        $transaksi = Transaksi::find($id);

        if (!$transaksi) {
            return response()->json([
                'status' => 'success',
                'message' => 'Transaksi tidak ditemukan'
            ], 404);
        }

        DB::beginTransaction();

        try {
            $detail = DetailLayanan::where('transaksi_id', $id)->first();
            if($detail) {
                $detail->layanan_id = $request->layanan_id;
                $detail->jumlah_halaman = $request->jumlah_halaman;
                $detail->harga_satuan = $request->harga_satuan;
                $detail->subtotal = $request->total_harga;
                $detail->save();
            }

            $transaksi->total_harga = $request->total_harga;
            $transaksi->save();

            $pembayaran = Pembayaran::where('transsaksi_id', $id)->first();
            if($pembayaran) {
                $pembayaran->total_bayar = $request->total_harga;
                $pembayaran->metode = $request->metode;
                $pembayaran->save();
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Data transaksi berhasil diperbaiki',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'success',
                'message' => 'Gagal edit transaksi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function delete($id) {
        $transaksi = Transaksi::find($id);

        if (!$transaksi) {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaksi tidak ditemukan'
            ], 404);
        }

        DB::beginTransaction();

        try {
            DetailLayanan:where('transaksi_id', $id)->delete();
            Pembayaran:where('transaksi_id', $id)->delete();
            $transaksi->delete();

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'data transaksi berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus transaksi: ' . $e->getMessage()
            ], 500);
        }
    }
}
