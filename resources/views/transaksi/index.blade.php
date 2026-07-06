<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="d-flex justify-content-end align-items-center mb-4">
                    <div>
                        {{-- <a href="{{ route('laporan.index') }}" class="btn btn-info text-white me-2">
                            <i class="bi bi-file-earmark-bar-graph"></i> Lihat Laporan
                        </a> --}}
                        <a href="{{ route('transaksi.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Pinjam Buku
                        </a>
                    </div>
                </div>

                {{-- Flash Message --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    </div>
                @endif
                 
                {{-- Statistik --}}
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card border-primary h-100">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-2">Total Transaksi</h6>
                                    <h2 class="mb-0">{{ $transaksis->count() }}</h2>
                                </div>

                                <i class="bi bi-arrow-left-right text-primary" style="font-size: 3rem;"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card border-warning h-100">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-2">Sedang Dipinjam</h6>
                                    <h2 class="mb-0">{{ $transaksis->where('status','Dipinjam')->count() }}</h2>
                                </div>

                                <i class="bi bi-book-half text-warning" style="font-size: 3rem;"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card border-success h-100">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-2">Sudah Dikembalikan</h6>
                                    <h2 class="mb-0">{{ $transaksis->where('status','Dikembalikan')->count() }}</h2>
                                </div>

                                <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                 
                {{-- Tabel Transaksi --}}
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Transaksi</th>
                                        <th>Anggota</th>
                                        <th>Buku</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Tanggal Kembali</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transaksis as $transaksi)
                                    @php
                                        $isTerlambat = $transaksi->status == 'Dipinjam' && \Carbon\Carbon::parse($transaksi->tanggal_kembali)->isPast();
                                        $hariTerlambat = \Carbon\Carbon::parse($transaksi->tanggal_kembali)->diffInDays(now()->startOfDay(), false);
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><code>{{ $transaksi->kode_transaksi }}</code></td>
                                        <td>{{ $transaksi->anggota->nama }}</td>
                                        <td>{{ $transaksi->buku->judul }}</td>
                                        <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_pinjam)->format('d M Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_kembali)->format('d M Y') }}</td>
                                        <td>
                                            @if($transaksi->status == 'Dipinjam')
                                                <span class="badge bg-warning text-dark">Dipinjam</span>
                                                {{-- SPESIFIKASI TUGAS 3: BADGE TERLAMBAT MERAH --}}
                                                @if($isTerlambat)
                                                    <span class="badge bg-danger d-block mt-1">
                                                        <i class="bi bi-clock"></i> Terlambat {{ $hariTerlambat }} Hari
                                                    </span>
                                                @endif
                                            @else
                                                <span class="badge bg-success">Dikembalikan</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('transaksi.show', $transaksi->id) }}" 
                                               class="btn btn-sm btn-info text-white">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">
                                            Belum ada transaksi
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
</x-app-layout>