<x-filament-panels::page>

    <!-- BAGIAN 1: KARTU METRIK MENGGUNAKAN GRID BAWAAN -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
        
        <x-filament::section>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <p style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: gray; margin-bottom: 0.25rem;">Pendapatan</p>
                    <h4 style="font-size: 1.25rem; font-weight: bold;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h4>
                </div>
                <x-heroicon-m-wallet style="width: 2.5rem; height: 2.5rem; color: #3b82f6;" />
            </div>
        </x-filament::section>

        <x-filament::section>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <p style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: gray; margin-bottom: 0.25rem;">Jumlah Pesanan</p>
                    <h4 style="font-size: 1.25rem; font-weight: bold;">{{ number_format($totalPesanan) }}</h4>
                </div>
                <x-heroicon-m-shopping-bag style="width: 2.5rem; height: 2.5rem; color: #a855f7;" />
            </div>
        </x-filament::section>

        <x-filament::section>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <p style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: gray; margin-bottom: 0.25rem;">Pelanggan</p>
                    <h4 style="font-size: 1.25rem; font-weight: bold;">{{ number_format($totalPelanggan) }}</h4>
                </div>
                <x-heroicon-m-users style="width: 2.5rem; height: 2.5rem; color: #10b981;" />
            </div>
        </x-filament::section>

        <x-filament::section>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <p style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: gray; margin-bottom: 0.25rem;">Layanan Terlaris</p>
                    <h4 style="font-size: 1.125rem; font-weight: bold;">{{ $namaLayananTerlaris }}</h4>
                </div>
                <x-heroicon-m-star style="width: 2.5rem; height: 2.5rem; color: #f59e0b;" />
            </div>
        </x-filament::section>

    </div>

    <!-- BAGIAN 2: KERTAS LAPORAN TRANSAKSI -->
    <x-filament::section>
        
        <!-- HEADER KOP SURAT -->
        <div style="text-align: center; margin-bottom: 2rem; margin-top: 1rem;">
            <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 0.5rem;">1HZS TOKO FOTOCOPY & PRINT</h2>
            <p style="color: gray; font-size: 0.875rem;">Jl. Contoh Alamat No. 123, Solo, Jawa Tengah, Kode Pos 12345</p>
            <p style="color: gray; font-size: 0.875rem; margin-top: 0.25rem;">📞 0812-3456-7890 &nbsp;|&nbsp; ✉️ 1HZS@tokofotocopy.com</p>
        </div>

        <hr style="border: 0; border-top: 1px solid #e5e7eb; margin: 2rem 0;" />

        <div style="text-align: center; font-weight: bold; font-size: 1.125rem; letter-spacing: 0.05em; margin-bottom: 2rem;">
            LAPORAN PENDAPATAN 1HZS FOTOCOPY & PRINT
        </div>

        <!-- TABEL TRANSAKSI -->
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
                <thead>
                    <tr style="border-bottom: 2px solid #e5e7eb; color: gray;">
                        <th style="padding: 1rem 0.5rem;">NO</th>
                        <th style="padding: 1rem 0.5rem;">ID TRANSAKSI</th>
                        <th style="padding: 1rem 0.5rem;">TANGGAL</th>
                        <th style="padding: 1rem 0.5rem;">LAYANAN</th>
                        <th style="padding: 1rem 0.5rem;">METODE</th>
                        <th style="padding: 1rem 0.5rem; text-align: right;">TOTAL HARGA</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $index => $transaksi)
                        <tr style="border-bottom: 1px solid #f3f4f6;">
                            <td style="padding: 1rem 0.5rem;">{{ $index + 1 }}</td>
                            <td style="padding: 1rem 0.5rem; color: #0ea5e9; font-weight: 500;">{{ $transaksi->id }}</td>
                            <td style="padding: 1rem 0.5rem;">{{ $transaksi->created_at->format('d/m/Y') }}</td>
                            <td style="padding: 1rem 0.5rem;">{{ $transaksi->detail_layanan->layanan->nama_layanan ?? '-' }}</td>
                            <td style="padding: 1rem 0.5rem;">
                                <span style="border: 1px solid #d1d5db; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem;">
                                    {{ $transaksi->metode_pembayaran ?? 'Cash' }}
                                </span>
                            </td>
                            <td style="padding: 1rem 0.5rem; text-align: right; font-weight: 500;">Rp {{ number_format($transaksi->total_harga ?? 0, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding: 2rem; text-align: center; color: gray;">Belum ada data transaksi pendapatan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <hr style="border: 0; border-top: 1px solid #e5e7eb; margin: 2rem 0;" />

        <!-- TANDA TANGAN & TOTAL AKHIR -->
        <div style="display: flex; justify-content: flex-end; margin-top: 2rem; margin-bottom: 1rem;">
            <div style="width: 100%; max-width: 320px;">
                
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem;">
                    <span style="font-weight: 500; color: gray;">TOTAL PENDAPATAN :</span>
                    <span style="font-size: 1.25rem; font-weight: bold;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
                </div>

                <div style="text-align: center;">
                    <p style="color: gray; margin-bottom: 5rem; font-size: 0.875rem;">Admin Bertugas,</p>
                    <p style="font-weight: bold; text-decoration: underline; text-underline-offset: 4px;">
                        {{ auth()->user()->name ?? 'Administrator' }}
                    </p>
                </div>

            </div>
        </div>

    </x-filament::section>

</x-filament-panels::page>