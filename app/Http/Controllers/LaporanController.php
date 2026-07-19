<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailLayanan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index()
    {
        $laporan = DB::table('transaksi')
            ->join('pelanggan', 'transaksi.pelanggan_id', '=', 'pelanggan.id')
            ->join('detail_layanan', 'transaksi.id', '=', 'detail_layanan.transaksi_id')
            ->join('layanan', 'detail_layanan.layanan_id', '=', 'layanan.id')
            ->join('pembayaran', 'transaksi.id', '=', 'pembayaran.transaksi_id')
            ->select(
                'transaksi.*',
                'pelanggan.nama as nama_pelanggan',
                'layanan.nama_layanan',
                'detail_layanan.file_dokumen',
                'detail_layanan.jumlah_halaman',
                'pembayaran.metode',
                'transaksi.total_harga',
            )
            ->where('detail_layanan.status_antrean', 'Selesai')
            ->orderBy('transaksi.updated_at', 'desc')
            ->get();

        $totalPendapatan = $laporan->sum('total_harga');

        return view('admin.laporan', compact('laporan', 'totalPendapatan'));
    }

    public function cetakPdf()
    {
        $laporan = DB::table('transaksi')
            ->join('detail_layanan', 'transaksi.id', '=', 'detail_layanan.transaksi_id')
            ->join('layanan', 'detail_layanan.layanan_id', '=', 'layanan.id')
            ->join('pembayaran', 'transaksi.id', '=', 'pembayaran.transaksi_id')
            ->select(
                'transaksi.*',
                'layanan.nama_layanan',
                'pembayaran.metode'
            )
            ->where('detail_layanan.status_antrean', 'Selesai')
            ->orderBy('transaksi.updated_at', 'desc')
            ->get();

        $totalPendapatan = $laporan->sum('total_harga');

        $pdf = Pdf::loadView('admin.cetakPdf', compact('laporan', 'totalPendapatan'));

        return $pdf->download('Laporan-' . date('d-m-y') . '.pdf');
    }
}
