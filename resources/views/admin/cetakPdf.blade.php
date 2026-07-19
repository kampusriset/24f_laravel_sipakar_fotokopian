<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Cetak PDF</title>
    <link rel="stylesheet" href="{{ public_path('asset/cetakPdf.css') }}">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            border-bottom: 2px solid #000;
            padding: 10px;
            text-transform: uppercase;
            font-size: 12px;
        }

        td {
            border-bottom: 1px solid #ddd;
            padding: 10px;
            font-size: 13px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .fw-bold {
            font-weight: bold;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .signature {
            margin-top: 50px;
            text-align: right;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>1HZS TOKO FOTOCOPY & PRINT</h2>
        <p>Jl. Contoh Alamat No. 123, Kota, Provinsi, Kode Pos 12345</p>
        <p>Telp: 0812-3456-7890 | Email: email@tokofotocopy.com</p>
    </div>

    <div style="font-weight: bold; text-align: center; margin-bottom: 10px;">LAPORAN PENDAPATAN KESELURUHAN</div>

    <table>
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="15%">ID Transaksi</th>
                <th width="15%">Tanggal</th>
                <th>Layanan</th>
                <th>Metode</th>
                <th width="20%" class="text-right">Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporan as $index => $trx)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $trx->id }}</td>
                <td>{{ date('d/m/Y', strtotime($trx->updated_at)) }}</td>
                <td>{{ $trx->nama_layanan ?? 'Dokumen' }}</td>
                <td>{{ $trx->metode ?? 'Cash' }}</td>
                <td class="text-right">{{ number_format($trx->total_harga, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Belum ada data pendapatan.</td>
            </tr>
            @endforelse

            <tr>
                <td colspan="5" class="text-right fw-bold" style="border-top: 2px solid #000; border-bottom: 2px solid #000; padding: 10px 0;">TOTAL PENDAPATAN :</td>
                <td class="text-right fw-bold" style="border-top: 2px solid #000; border-bottom: 2px solid #000; padding: 10px 0;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="signature">
        <p>Admin Bertugas,</p>
        <br><br><br>
        <p style="text-decoration: underline; font-weight: bold;">{{ Auth::user()->name ?? 'Administrator' }}</p>
    </div>

</body>

</html>