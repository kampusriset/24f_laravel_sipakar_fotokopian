<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('transaksi')
            ->join('pelanggan', 'transaksi.pelanggan_id', '=', 'pelanggan.id')
            ->join('detail_layanan', 'transaksi.id', '=', 'detail_layanan.transaksi_id')
            ->join('layanan', 'detail_layanan.layanan_id', '=', 'layanan.id')
            ->join('pembayaran', 'transaksi.id', '=', 'pembayaran.transaksi_id')
            ->select(
                'transaksi.id as id_transaksi',
                'pelanggan.nama as nama_pelanggan',
                'layanan.nama_layanan',
                'detail_layanan.file_dokumen',
                'detail_layanan.jumlah_halaman',
                'pembayaran.metode',
                'detail_layanan.status_antrean',
                'transaksi.total_harga',
                'transaksi.updated_at'
            )
            ->where('detail_layanan.status_antrean', '=', 'Selesai')
            ->orderBy('transaksi.updated_at', 'desc');

        // Logika Pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            
            $query->where(function($q) use ($search) {
                $q->where('transaksi.id', 'like', "%{$search}%")
                    ->orWhere('pelanggan.nama', 'like', "%{$search}%")
                    ->orWhere('detail_layanan.file_dokumen', 'like', "%{$search}%");
            });
        }

        $riwayatTransaksi = $query->paginate(10);

        return view('riwayat', compact('riwayatTransaksi'));

    }
}