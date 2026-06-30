<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1><i class="bi bi-file-earmark-bar-graph"></i> Laporan Transaksi</h1>
                    
                    {{-- Tombol Export PDF, membawa serta parameter pencarian (request()->query()) --}}
                    <a href="{{ route('transaksi.export-pdf', request()->query()) }}" class="btn btn-danger">
                        <i class="bi bi-file-pdf"></i> Export PDF
                    </a>
                </div>

                {{-- FORM FILTER --}}
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-body bg-light rounded">
                        <form action="{{ route('transaksi.laporan') }}" method="GET">
                            <div class="row g-3 align-items-end">
                                
                                <div class="col-md-2">
                                    <label class="form-label small">Dari Tanggal</label>
                                    <input type="date" name="dari_tanggal" class="form-control" value="{{ request('dari_tanggal') }}">
                                </div>
                                
                                <div class="col-md-2">
                                    <label class="form-label small">Sampai Tanggal</label>
                                    <input type="date" name="sampai_tanggal" class="form-control" value="{{ request('sampai_tanggal') }}">
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="form-label small">Pilih Anggota</label>
                                    <select name="anggota_id" class="form-select">
                                        <option value="">Semua Anggota</option>
                                        @foreach($anggotas as $anggota)
                                            <option value="{{ $anggota->id }}" {{ request('anggota_id') == $anggota->id ? 'selected' : '' }}>
                                                {{ $anggota->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-md-2">
                                    <label class="form-label small">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="">Semua Status</option>
                                        <option value="Dipinjam" {{ request('status') == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                        <option value="Dikembalikan" {{ request('status') == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-3 d-flex gap-2">
                                    <button type="submit" class="btn btn-primary flex-fill">
                                        <i class="bi bi-funnel"></i> Filter
                                    </button>
                                    <a href="{{ route('transaksi.laporan') }}" class="btn btn-secondary flex-fill">
                                        <i class="bi bi-x-circle"></i> Reset
                                    </a>
                                </div>
                                
                            </div>
                        </form>
                    </div>
                </div>

                {{-- KOTAK STATISTIK --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card border-primary h-100">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Total Transaksi</h6>
                                    <h3 class="mb-0">{{ $totalTransaksi }} Transaksi</h3>
                                </div>
                                <i class="bi bi-arrow-left-right text-primary" style="font-size: 2.5rem;"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-danger h-100">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Total Denda Terkumpul</h6>
                                    <h3 class="mb-0 text-danger">Rp {{ number_format($totalDenda, 0, ',', '.') }}</h3>
                                </div>
                                <i class="bi bi-cash-coin text-danger" style="font-size: 2.5rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TABEL DATA --}}
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Anggota</th>
                                <th>Buku</th>
                                <th>Tgl Pinjam</th>
                                <th>Tgl Kembali</th>
                                <th>Status</th>
                                <th>Denda</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksis as $trx)
                            @php
                                // Logika Denda Berjalan
                                $nominalDenda = 0;
                                if($trx->status == 'Dikembalikan') {
                                    $nominalDenda = $trx->denda ?? 0;
                                } else {
                                    $batas = \Carbon\Carbon::parse($trx->tanggal_kembali)->startOfDay();
                                    $sekarang = now()->startOfDay();
                                    if ($batas->isPast() && $sekarang->greaterThan($batas)) {
                                        $nominalDenda = $batas->diffInDays($sekarang) * 5000;
                                    }
                                }
                            @endphp
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center"><code>{{ $trx->kode_transaksi }}</code></td>
                                <td>{{ $trx->anggota->nama }}</td>
                                <td>{{ $trx->buku->judul }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($trx->tanggal_pinjam)->format('d/m/Y') }}</td>
                                <td class="text-center">
                                    @if($trx->status == 'Dikembalikan')
                                        {{ \Carbon\Carbon::parse($trx->tanggal_dikembalikan)->format('d/m/Y') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($trx->status == 'Dipinjam')
                                        <span class="badge bg-warning text-dark">Dipinjam</span>
                                    @else
                                        <span class="badge bg-success">Dikembalikan</span>
                                    @endif
                                </td>
                                <td class="text-end fw-bold {{ $nominalDenda > 0 ? 'text-danger' : '' }}">
                                    {{ $nominalDenda > 0 ? 'Rp '.number_format($nominalDenda, 0, ',', '.') : '-' }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    Tidak ada data transaksi yang sesuai dengan filter.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Tombol Kembali di Bawah --}}
                <div class="mt-4 pt-3 border-top">
                    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali ke Daftar Transaksi
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>