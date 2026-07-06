<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Perpustakaan
        </h1>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                {{-- Statistics Cards --}}
                <div class="row g-3 mb-4">
                    @foreach([
                        ['Total Buku', $stats['total_buku'], 'bi-book', 'text-primary'],
                        ['Anggota Aktif', $stats['total_anggota'], 'bi-people', 'text-success'],
                        ['Sedang Dipinjam', $stats['sedang_dipinjam'], 'bi-journal-arrow-up', 'text-info'],
                        ['Terlambat', $stats['terlambat'], 'bi-exclamation-triangle', 'text-danger'],
                        ['Transaksi Hari Ini', $stats['transaksi_hari_ini'], 'bi-calendar-check', 'text-warning'],
                        ['Buku Tersedia', $stats['buku_tersedia'], 'bi-bookshelf', 'text-secondary'],
                        ['Total Transaksi', $stats['total_transaksi'], 'bi-receipt', 'text-dark'],
                        ['Denda Bulan Ini', 'Rp ' . number_format($stats['denda_bulan_ini'], 0, ',', '.'), 'bi-cash', 'text-danger'],
                    ] as [$label, $value, $icon, $color])
                    <div class="col-md-3">
                        <div class="card h-100 border-secondary-subtle">
                            <div class="card-body d-flex align-items-center">
                                <i class="bi {{ $icon }} fs-2 {{ $color }} me-3"></i>
                                <div>
                                    <div class="text-muted small">{{ $label }}</div>
                                    <div class="h5 mb-0 fw-bold">{{ $value }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Charts --}}
                <div class="row mb-4">
                    <div class="col-md-7">
                        <div class="card border-secondary-subtle">
                            <div class="card-body">
                                <h6>Transaksi 6 Bulan Terakhir</h6>
                                <canvas id="chartTransaksi" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="card border-secondary-subtle h-100">
                            <div class="card-body">
                                <h6>Top 5 Buku Populer</h6>
                                <canvas id="chartBuku"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- List Top 5 & Recent Transaksi --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card border-secondary-subtle">
                            <div class="card-body">
                                <h6>Top 5 Buku Populer</h6>
                                <ul class="list-group list-group-flush mt-3">
                                    @foreach($bukuPopuler as $buku)
                                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <div>
                                            <div class="fw-bold">{{ $loop->iteration }}. {{ $buku->judul }}</div>
                                            <small class="text-muted">Kategori: {{ $buku->kategori }}</small>
                                        </div>
                                        <span class="badge bg-primary rounded-pill">{{ $buku->transaksis_count }}x Pinjam</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-secondary-subtle">
                            <div class="card-body">
                                <h6>Top 5 Anggota Aktif</h6>
                                <ul class="list-group list-group-flush mt-3">
                                    @foreach($anggotaAktif as $anggota)
                                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <div>
                                            <div class="fw-bold">{{ $loop->iteration }}. {{ $anggota->nama }}</div>
                                            <small class="text-muted">ID Anggota: {{ $anggota->id }}</small>
                                        </div>
                                        <span class="badge bg-success rounded-pill">{{ $anggota->transaksis_count }}x Pinjam</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Recent Transactions --}}
                <div class="card border-secondary-subtle">
                    <div class="card-body">
                        <h6>Transaksi Terbaru</h6>
                        <table class="table mt-3">
                            <thead><tr><th>Kode</th><th>Anggota</th><th>Buku</th><th>Tgl Pinjam</th><th>Status</th></tr></thead>
                            <tbody>
                                @foreach($recentTransaksi as $trx)
                                <tr>
                                    <td class="text-danger fw-bold">{{ $trx->kode_transaksi }}</td>
                                    <td>{{ $trx->anggota->nama }}</td>
                                    <td>{{ $trx->buku->judul }}</td>
                                    <td>{{ \Carbon\Carbon::parse($trx->tanggal_pinjam)->format('d/m/Y') }}</td>
                                    <td><span class="badge {{ $trx->status == 'Dipinjam' ? 'bg-warning text-dark' : 'bg-success' }}">{{ $trx->status }}</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Line Chart - Transaksi
        new Chart(document.getElementById('chartTransaksi'), {
            type: 'line',
            data: {
                labels: @json($chartData->pluck('bulan')),
                datasets: [
                    {
                        label: 'Peminjaman',
                        data: @json($chartData->pluck('pinjam')),
                        borderColor: '#0d6efd',
                        backgroundColor: 'rgba(13,110,253,.1)',
                        tension: 0.3
                    },
                    {
                        label: 'Pengembalian',
                        data: @json($chartData->pluck('kembali')),
                        borderColor: '#198754',
                        backgroundColor: 'rgba(25,135,84,.1)',
                        tension: 0.3
                    }
                ]
            },
            options: {
                responsive: true
            }
        });

        // Pie Chart Buku Populer
        new Chart(document.getElementById('chartBuku'), {
            type: 'pie',
            data: {
                labels: @json($bukuPopuler->pluck('judul')),
                datasets: [{
                    data: @json($bukuPopuler->pluck('transaksis_count')),
                    backgroundColor: [
                        '#0d6efd',
                        '#198754',
                        '#ffc107',
                        '#dc3545',
                        '#6f42c1'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>

</x-app-layout>