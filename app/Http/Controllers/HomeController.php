<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index() {
        $transaksiTerbaru = DB::table('transaksi')
                ->join('pelanggan', 'transaksi.pelanggan_id', '=', 'pelanggan.id')
                ->join('detail_layanan', 'transaksi.id', '=', 'detail_layanan.transaksi_id')
                ->join('layanan', 'detail_layanan.layanan_id', '=', 'layanan.id')
                ->join('pembayaran', 'transaksi.id', '=', 'pembayaran.transaksi_id')
                ->select(
                    'transaksi.id as id_transaksi',
                    'pelanggan.nama as nama_pelanggan',
                    'detail_layanan.file_dokumen',
                    'detail_layanan.jumlah_halaman',
                    'layanan.nama_layanan',
                    'detail_layanan.waktu_deadline',
                    'pembayaran.metode',
                    'detail_layanan.status_antrean',
                    'transaksi.total_harga'
                )
                ->where('detail_layanan.status_antrean', '=', 'Selesai')
                ->orderBy('transaksi.created_at', 'desc')
                ->take(5)
                ->get();

        $layanan = Layanan::all();
        // return view('home', compact('transaksiTerbaru', 'layanan'));
        if (Auth::user()->role === 'admin') {
            return view('admin.home', compact('transaksiTerbaru', 'layanan'));
        } else {
            return view('kasir.home', compact('transaksiTerbaru', 'layanan'));
        }
    }
}
