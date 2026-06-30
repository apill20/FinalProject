<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Transaksi Peminjaman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- Breadcrumb --}}
                <div class="row">
                    <div class="col-12 mb-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('transaksi.index') }}">Transaksi</a></li>
                                <li class="breadcrumb-item active"><code>{{ $transaksi->kode_transaksi }}</code></li>
                            </ol>
                        </nav>
                    </div>
                </div>

                {{-- Flash Message Alert --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    </div>
                @endif

                {{-- SPESIFIKASI TUGAS 3: REMINDER WARNING KETERLAMBATAN --}}
                @if($transaksi->status == 'Dipinjam' && \Carbon\Carbon::parse($transaksi->tanggal_kembali)->isPast())
                    @php
                        $hariTerlambat = \Carbon\Carbon::parse($transaksi->tanggal_kembali)->diffInDays(now()->startOfDay(), false);
                    @endphp
                    <div class="alert alert-danger d-flex align-items-center mb-4 p-3 shadow-sm" role="alert">
                        <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                        <div>
                            <strong>Peringatan Keterlambatan!</strong> Peminjaman buku ini telah melewati batas waktu pengembalian selama <span class="badge bg-danger fs-6">{{ $hariTerlambat }} Hari</span>. Mohon segera proses pengembalian buku dan tagih denda anggota yang bersangkutan.
                        </div>
                    </div>
                @endif

                <div class="row">
                    {{-- Kolom Kiri: Informasi Utama Transaksi --}}
                    <div class="col-md-8">
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="bi bi-info-circle"></i> Informasi Transaksi
                                </h5>
                                <span class="badge bg-light text-primary fw-bold">{{ $transaksi->kode_transaksi }}</span>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="200" class="fw-bold text-muted">Nama Anggota</td>
                                        <td>: {{ $transaksi->anggota->nama }} (<code>{{ $transaksi->anggota->kode_anggota }}</code>)</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">Judul Buku</td>
                                        <td>: <span class="text-primary fw-bold">{{ $transaksi->buku->judul }}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">Tanggal Pinjam</td>
                                        <td>: <i class="bi bi-calendar-event"></i> {{ \Carbon\Carbon::parse($transaksi->tanggal_pinjam)->format('d M Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-muted">Batas Kembali</td>
                                        <td>: <i class="bi bi-calendar-x"></i> {{ \Carbon\Carbon::parse($transaksi->tanggal_kembali)->format('d M Y') }}</td>
                                    </tr>
                                    
                                    {{-- Jika Sudah Dikembalikan --}}
                                    @if($transaksi->status == 'Dikembalikan')
                                        <tr>
                                            <td class="fw-bold text-muted">Tanggal Dikembalikan</td>
                                            <td>: <i class="bi bi-calendar-check text-success"></i> {{ \Carbon\Carbon::parse($transaksi->tanggal_dikembalikan)->format('d M Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-muted">Denda Keterlambatan</td>
                                            <td>: 
                                                @if($transaksi->denda > 0)
                                                    <span class="text-danger fw-bold fs-5">Rp {{ number_format($transaksi->denda, 0, ',', '.') }}</span>
                                                @else
                                                    <span class="text-success fw-bold"><i class="bi bi-shield-check"></i> Tidak ada denda (Tepat Waktu)</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif

                                    <tr>
                                        <td class="fw-bold text-muted">Keterangan</td>
                                        <td>: {{ $transaksi->keterangan ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Kolom Kanan: Status & Tombol Aksi Pengembalian --}}
                    <div class="col-md-4">
                        {{-- Card Status --}}
                        <div class="card shadow-sm mb-3">
                            <div class="card-header bg-secondary text-white">
                                <h6 class="mb-0"><i class="bi bi-activity"></i> Status Transaksi</h6>
                            </div>
                            <div class="card-body text-center py-4">
                                @if($transaksi->status == 'Dipinjam')
                                    <div class="alert alert-warning mb-0 text-dark fw-bold">
                                        <i class="bi bi-clock-history fs-3 d-block mb-2"></i>
                                        Buku Sedang Dipinjam
                                    </div>
                                @else
                                    <div class="alert alert-success mb-0 fw-bold">
                                        <i class="bi bi-check-circle-fill fs-3 d-block mb-2"></i>
                                        Buku Sudah Dikembalikan
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Card Tombol Aksi --}}
                        <div class="card shadow-sm">
                            <div class="card-body d-grid gap-2">
                                
                                {{-- Menggunakan Metode PUT agar sinkron dengan web.php --}}
                                @if($transaksi->status == 'Dipinjam')
                                    <form action="{{ route('transaksi.kembalikan', $transaksi->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin memproses pengembalian buku ini?')">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-success w-100 py-2">
                                            <i class="bi bi-arrow-counterclockwise"></i> Kembalikan Buku
                                        </button>
                                    </form>
                                @endif

                                <a href="{{ route('transaksi.index') }}" class="btn btn-outline-primary py-2">
                                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>