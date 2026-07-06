<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight d-print-none">
            {{ __('Laporan Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="d-flex justify-content-end align-items-center mb-4 d-print-none">
                    <a href="{{ route('laporan.export-pdf', request()->query()) }}" class="btn btn-danger">
                        <i class="bi bi-file-pdf"></i> Export PDF
                    </a>
                </div>

                {{-- KOTAK STATISTIK (Disesuaikan jadi 4 kotak dengan tema minimalis) --}}
                <div class="row g-3 mb-4">
                    {{-- Total Transaksi --}}
                    <div class="col-md-3">
                        <div class="card border-primary h-100 shadow-sm">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1" style="font-size: 0.85rem;">Total Transaksi Keseluruhan</h6>
                                    <h3 class="mb-0">{{ $summary['total'] }}</h3>
                                </div>
                                <i class="bi bi-arrow-left-right text-primary" style="font-size: 2.5rem;"></i>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Sedang Dipinjam --}}
                    <div class="col-md-3">
                        <div class="card border-warning h-100 shadow-sm">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1" style="font-size: 0.85rem;">Buku Sedang Dipinjam</h6>
                                    <h3 class="mb-0 text-warning" style="color: #d39e00 !important;">{{ $summary['dipinjam'] }}</h3>
                                </div>
                                <i class="bi bi-book-half text-warning" style="font-size: 2.5rem;"></i>
                            </div>
                        </div>
                    </div>

                    {{-- Sudah Dikembalikan --}}
                    <div class="col-md-3">
                        <div class="card border-success h-100 shadow-sm">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1" style="font-size: 0.85rem;">Buku Dikembalikan</h6>
                                    <h3 class="mb-0 text-success">{{ $summary['dikembalikan'] }}</h3>
                                </div>
                                <i class="bi bi-check-circle-fill text-success" style="font-size: 2.5rem;"></i>
                            </div>
                        </div>
                    </div>

                    {{-- Total Denda --}}
                    <div class="col-md-3">
                        <div class="card border-danger h-100 shadow-sm">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1" style="font-size: 0.85rem;">Total Denda Keseluruhan</h6>
                                    <h4 class="mb-0 text-danger fw-bold">Rp {{ number_format($summary['total_denda'], 0, ',', '.') }}</h4>
                                </div>
                                <i class="bi bi-cash-coin text-danger" style="font-size: 2.5rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>

                                {{-- FORM FILTER --}}
                <div class="card mb-4 border-0 shadow-sm d-print-none">
                    <div class="card-body bg-light rounded">
                        <form action="{{ route('laporan.index') }}" method="GET">
                            <div class="row g-3 align-items-end">
                                
                                <div class="col-md-2">
                                    <label class="form-label small">Dari Tanggal</label>
                                    <input type="date" name="dari" class="form-control" value="{{ request('dari') }}">
                                </div>
                                
                                <div class="col-md-2">
                                    <label class="form-label small">Sampai Tanggal</label>
                                    <input type="date" name="sampai" class="form-control" value="{{ request('sampai') }}">
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
                                    <a href="{{ route('laporan.index') }}" class="btn btn-secondary flex-fill">
                                        <i class="bi bi-x-circle"></i> Reset
                                    </a>
                                </div>
                                
                            </div>
                        </form>
                    </div>
                </div>

                {{-- TABEL DATA --}}
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
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
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><span class="text-danger">{{ $trx->kode_transaksi }}</span></td>
                                        <td class="text-start">{{ $trx->anggota->nama }}</td>
                                        <td class="text-start">{{ $trx->buku->judul }}</td>
                                        <td>{{ \Carbon\Carbon::parse($trx->tanggal_pinjam)->format('d/m/Y') }}</td>
                                        <td>
                                            @if($trx->status == 'Dikembalikan' && $trx->tanggal_dikembalikan)
                                                {{ \Carbon\Carbon::parse($trx->tanggal_dikembalikan)->format('d/m/Y') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if($trx->status == 'Dipinjam')
                                                <span class="badge bg-warning text-dark px-3 py-1">Dipinjam</span>
                                            @else
                                                <span class="badge bg-success">Dikembalikan</span>
                                            @endif
                                        </td>
                                        <td class="text-danger">
                                            {{ $trx->denda > 0 ? 'Rp ' . number_format($trx->denda, 0, ',', '.') : '-' }}
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
    @media print {

        .d-print-none{
            display:none !important;
        }

        .card{
            border:none !important;
            box-shadow:none !important;
        }

        nav,
        footer{
            display:none !important;
        }

        body{
            background:#fff !important;
        }

        table{
            font-size:12px;
        }

    }
    </style>
</x-app-layout>