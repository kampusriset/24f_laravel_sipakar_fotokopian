<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Riwayat Transaksi Pelanggan</h4>
                <a href="{{ url('/') }}" class="btn btn-sm btn-light">Kembali ke Dashboard</a>
            </div>
            <div class="card-body">
                
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Nama Pelanggan</th>
                                <th>File Dokumen</th>
                                <th>Jumlah Halaman</th>
                                <th>Metode Pembayaran</th>
                                <th>Status Antrean</th>
                                <th>Tanggal Selesai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayatTransaksi as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><strong>{{ $item->nama_pelanggan }}</strong></td>
                                    <td><code class="text-secondary">{{ $item->file_dokumen ?? '-' }}</code></td>
                                    <td>{{ $item->jumlah_halaman }} Lembar</td>
                                    <td><span class="badge bg-info text-dark">{{ $item->metode }}</span></td>
                                    <td>
                                        <span class="badge {{ $item->status_antrean == 'Selesai' ? 'bg-success' : 'bg-warning text-dark' }}">
                                            {{ $item->status_antrean }}
                                        </span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($item->updated_at)->translatedFormat('d F Y, H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        <strong>Tidak ada data riwayat transaksi di database.</strong>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>