<x-filament-panels::page>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class', 
        }
    </script>

    <style>
        aside.fi-sidebar,
        nav.fi-sidebar-nav,
        .fi-sidebar-header {
            display: none !important;
            visibility: hidden !important;
            width: 0 !important;
        }

        .fi-main-ctn, 
        .fi-page,
        main.fi-main {
            width: 100% !important;
            max-width: 100% !important;
            margin-left: 0 !important;
            padding: 1.5rem !important;
        }

        header.fi-topbar {
            width: 100% !important;
            padding-left: 1.5rem !important;
            padding-right: 1.5rem !important;
        }
    </style>

    <div class="p-8 bg-white rounded-xl shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 dark:text-white">
        
        <!-- HEADER LAPORAN -->
        <div class="mb-8 text-center">
            <h2 class="mb-1 text-2xl font-bold">1HZS TOKO FOTOCOPY & PRINT</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Jl. Contoh Alamat No. 123, Kota, Provinsi, Kode Pos 12345</p>
            
            <div class="flex items-center justify-center gap-3 mt-2 text-sm text-gray-500 dark:text-gray-400">
                <div class="flex items-center gap-1.5">
                    <x-heroicon-m-phone class="w-4 h-4 text-gray-400 dark:text-gray-500" /> 
                    <span>0812-3456-7890</span>
                </div>
                <span class="text-gray-300 dark:text-gray-600">|</span>
                <div class="flex items-center gap-1.5">
                    <x-heroicon-m-envelope class="w-4 h-4 text-gray-400 dark:text-gray-500" /> 
                    <span>1HZS@tokofotocopy.com</span>
                </div>
            </div>
        </div>

        <div class="my-6 border-t border-gray-200 dark:border-gray-700"></div>

        <div class="mb-6 text-lg font-bold text-center uppercase tracking-wider">
            LAPORAN PENDAPATAN 1HZS FOTOCOPY & PRINT
        </div>

        <!-- TABEL DATA TRANSAKSI -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left whitespace-nowrap">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-gray-600 uppercase border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
                        <th scope="col" class="px-4 py-3">NO</th>
                        <th scope="col" class="px-4 py-3">ID TRANSAKSI</th>
                        <th scope="col" class="px-4 py-3">TANGGAL</th>
                        <th scope="col" class="px-4 py-3">LAYANAN</th>
                        <th scope="col" class="px-4 py-3">METODE PEMBAYARAN</th>
                        <th scope="col" class="px-4 py-3 text-right">TOTAL HARGA</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($transaksis as $index => $transaksi)
                    <tr class="transition-colors border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800/50">
                        <td class="px-4 py-4 text-gray-500 dark:text-gray-400">{{ $index + 1 }}</td>
                        <td class="px-4 py-4 font-medium text-sky-500 dark:text-sky-400">{{ $transaksi->id }}</td>
                        <td class="px-4 py-4">{{ $transaksi->created_at->format('d/m/Y') }}</td>
                        
                        <td class="px-4 py-4">{{ $transaksi->detail_layanan->layanan->nama_layanan ?? '-' }}</td>
                        
                        <td class="px-4 py-4">
                            <span class="px-2.5 py-1 text-xs border border-gray-300 rounded-md text-gray-600 dark:text-gray-400 dark:border-gray-600">
                                {{ $transaksi->metode_pembayaran ?? 'Cash' }}
                            </span>
                        </td>
                        
                        <td class="px-4 py-4 font-medium text-right">Rp {{ number_format($transaksi->total_harga ?? 0, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                Belum ada data transaksi pendapatan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="my-6 border-t border-gray-200 dark:border-gray-700"></div>

        <!-- TOTAL PENDAPATAN & TANDA TANGAN -->
        <div class="flex justify-end mt-8">
            <div class="w-full max-w-xs">
                
                <div class="flex items-center justify-between mb-12">
                    <span class="font-medium text-gray-500 dark:text-gray-400">TOTAL PENDAPATAN :</span>
                    <span class="text-xl font-bold">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
                </div>

                <div class="text-center">
                    <p class="mb-16 text-sm text-gray-500 dark:text-gray-400">Admin Bertugas,</p>
                    <p class="text-sm font-bold underline underline-offset-4 decoration-2">
                        {{ auth()->user()->name ?? 'Administrator' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>