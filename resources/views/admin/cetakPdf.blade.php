<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pendapatan PDF</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            font-size: 20px;
            font-weight: bold;
            color: #111;
        }
        .header p {
            margin: 5px 0;
            font-size: 12px;
            color: #555;
        }
        .garis-kop {
            border: 0;
            border-top: 2px solid #e5e7eb;
            margin-bottom: 20px;
        }

        .judul-laporan {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 20px;
            letter-spacing: 1px;
        }

        .table-data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .table-data th, .table-data td {
            border-bottom: 1px solid #f3f4f6;
            padding: 10px 5px;
            text-align: left;
        }
        .table-data th {
            color: #6b7280;
            font-size: 10px;
            text-transform: uppercase;
            border-bottom: 2px solid #e5e7eb;
        }
        .table-data td.text-right, .table-data th.text-right {
            text-align: right;
        }
        .table-data td.text-center, .table-data th.text-center {
            text-align: center;
        }
        .text-blue {
            color: #0ea5e9;
            font-weight: bold;
        }
        .badge {
            border: 1px solid #d1d5db;
            padding: 3px 6px;
            border-radius: 4px;
            font-size: 10px;
            color: #4b5563;
        }

        .table-footer {
            width: 100%;
            border: none;
            margin-top: 30px;
        }
        .table-footer td {
            border: none;
            padding: 0;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>1HZS TOKO FOTOCOPY & PRINT</h2>
        <p>Jl. Contoh Alamat No. 123, Solo, Jawa Tengah, Kode Pos 12345</p>
        <p>📞 0812-3456-7890 &nbsp;|&nbsp;1HZS@tokofotocopy.com</p>
    </div>

    <hr class="garis-kop">

    <div class="judul-laporan">
        LAPORAN PENDAPATAN 1HZS FOTOCOPY & PRINT
    </div>

    <!-- TABEL DATA TRANSAKSI -->
    <table class="table-data">
        <thead>
            <tr>
                <th class="text-center" style="width: 5%;">NO</th>
                <th style="width: 15%;">ID TRANSAKSI</th>
                <th style="width: 15%;">TANGGAL</th>
                <th style="width: 30%;">LAYANAN</th>
                <th style="width: 15%;">METODE</th>
                <th class="text-right" style="width: 20%;">TOTAL HARGA</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporan as $index => $transaksi)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-blue">{{ $transaksi->id }}</td>
                    <td>{{ $transaksi->created_at->format('d/m/Y') }}</td>
                    <td>{{ $transaksi->detail_layanan->layanan->nama_layanan ?? '-' }}</td>
                    <td><span class="badge">{{ $transaksi->metode_pembayaran ?? 'Cash' }}</span></td>
                    <td class="text-right font-bold">Rp {{ number_format($transaksi->total_harga ?? 0, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 30px; color: #6b7280;">
                        Belum ada data transaksi pendapatan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- TOTAL PENDAPATAN & TANDA TANGAN -->
    <table class="table-footer">
        <tr>
            <td style="width: 50%;"></td>
            <td style="width: 50%;">
                <table style="width: 100%; border: none;">
                    <tr>
                        <td style="text-align: left; font-weight: bold; color: #6b7280; font-size: 12px; padding-bottom: 40px;">
                            TOTAL PENDAPATAN :
                        </td>
                        <td style="text-align: right; font-weight: bold; font-size: 18px; padding-bottom: 40px;">
                            Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center;">
                        @php
                            date_default_timezone_set('Asia/Jakarta');
                            
                            $bulanIndo = [
                                '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', 
                                '04' => 'April', '05' => 'Mei', '06' => 'Juni', 
                                '07' => 'Juli', '08' => 'Agustus', '09' => 'September', 
                                '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                            ];
                            
                            $tgl = date('d');
                            $bln = $bulanIndo[date('m')];
                            $thn = date('Y');
                            
                            $tanggalCetak = "Solo, " . $tgl . " " . $bln . " " . $thn;

                            $namaPetugas = 'Administrator';
                            if (auth()->check()) {
                                $user = auth()->user();
                                $operator = \Illuminate\Support\Facades\DB::table('operator')
                                    ->where('user_id', $user->id)
                                    ->first();
                                
                                if ($operator && !empty($operator->name)) {
                                    $namaPetugas = $operator->name;
                                } else {
                                    $namaPetugas = 'Admin (' . $user->email . ')';
                                }
                            }
                        @endphp

                        <!-- Tanggal Real-Time -->
                        <p style="color: #6b7280; font-size: 12px; margin-bottom: 5px;">{{ $tanggalCetak }}</p>
                        <p style="color: #6b7280; font-size: 12px; margin-bottom: 50px;">Admin Bertugas,</p>
                        
                        <!-- Nama Petugas -->
                        <p style="font-weight: bold; text-decoration: underline; font-size: 12px;">
                            <!-- {{ $namaPetugas }} -->
                            Administrator
                        </p>
                    </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>
</html>