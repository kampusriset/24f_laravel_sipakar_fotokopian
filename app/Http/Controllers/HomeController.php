<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\DetailLayanan;
use App\Models\StokBarang;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index() {
        // Total Antrean (Status: Menunggu)
        $totalAntrean = DetailLayanan::where('status_antrean', 'Menunggu')->count();
        
        // Pekerjaan Hari Ini
        $pekerjaanHariIni = DetailLayanan::whereDate('created_at', Carbon::today())->count();
        
        // Sedang Diproses
        $sedangDiproses = DetailLayanan::where('status_antrean', 'Cetak')->count();
        
        // Pesanan Selesai
        $pesananSelesai = DetailLayanan::where('status_antrean', 'Selesai')
                                        ->whereDate('updated_at', Carbon::today())
                                        ->count();

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
                    'transaksi.total_harga',
                    'transaksi.updated_at'
                )
                ->where('detail_layanan.status_antrean', '=', 'Selesai')
                ->orderBy('transaksi.created_at', 'desc')
                ->take(5)
                ->get();

        $layanan = Layanan::all();
        $stokBarang = StokBarang::all(); 

        if (Auth::user()->role === 'kasir') {
            return view('kasir.home', compact('transaksiTerbaru', 'layanan', 'stokBarang', 'totalAntrean', 'pekerjaanHariIni', 'sedangDiproses', 'pesananSelesai')); 
        }
    }
}