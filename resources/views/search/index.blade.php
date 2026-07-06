<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hasil Pencarian: <span class="text-primary">"{{ $keyword }}"</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                {{-- Tabs Navigasi --}}
                <ul class="nav nav-tabs mb-4" id="searchTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-bold text-dark" data-bs-toggle="tab" data-bs-target="#tab-buku" type="button" role="tab">
                            <i class="bi bi-book me-1"></i> Buku 
                            <span class="badge bg-primary ms-1">{{ $results['buku']->count() }}</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold text-dark" data-bs-toggle="tab" data-bs-target="#tab-anggota" type="button" role="tab">
                            <i class="bi bi-people me-1"></i> Anggota 
                            <span class="badge bg-success ms-1">{{ $results['anggota']->count() }}</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold text-dark" data-bs-toggle="tab" data-bs-target="#tab-transaksi" type="button" role="tab">
                            <i class="bi bi-receipt me-1"></i> Transaksi 
                            <span class="badge bg-warning text-dark ms-1">{{ $results['transaksi']->count() }}</span>
                        </button>
                    </li>
                </ul>
             
                {{-- Konten Tabs --}}
                <div class="tab-content">
                    {{-- Tab Buku --}}
                    <div class="tab-pane fade show active" id="tab-buku" role="tabpanel">
                        @forelse($results['buku'] as $buku)
                            <div class="card mb-3 shadow-sm border-start border-4 border-primary">
                                <div class="card-body">
                                    <h5 class="mb-1">{!! str_ireplace($keyword, '<mark class="bg-warning px-1 rounded">'.$keyword.'</mark>', e($buku->judul)) !!}</h5>
                                    <p class="mb-0 text-muted">Penulis: {{ $buku->penulis }} | Stok Tersedia: <strong>{{ $buku->stok }}</strong></p>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-light text-center border">
                                <i class="bi bi-search d-block fs-1 text-muted mb-2"></i>
                                Tidak ada buku yang cocok dengan pencarianmu.
                            </div>
                        @endforelse
                    </div>
             
                    {{-- Tab Anggota --}}
                    <div class="tab-pane fade" id="tab-anggota" role="tabpanel">
                        @forelse($results['anggota'] as $anggota)
                            <div class="card mb-3 shadow-sm border-start border-4 border-success">
                                <div class="card-body">
                                    <h5 class="mb-1">{!! str_ireplace($keyword, '<mark class="bg-warning px-1 rounded">'.$keyword.'</mark>', e($anggota->nama)) !!}</h5>
                                    <p class="mb-0 text-muted">Kode: {{ $anggota->kode_anggota ?? '-' }} | Email: {{ $anggota->email }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-light text-center border">
                                <i class="bi bi-search d-block fs-1 text-muted mb-2"></i>
                                Tidak ada anggota yang cocok dengan pencarianmu.
                            </div>
                        @endforelse
                    </div>
             
                    {{-- Tab Transaksi --}}
                    <div class="tab-pane fade" id="tab-transaksi" role="tabpanel">
                        @forelse($results['transaksi'] as $trx)
                            <div class="card mb-3 shadow-sm border-start border-4 border-warning">
                                <div class="card-body">
                                    <h5 class="mb-1"><a href="{{ route('transaksi.show', $trx->id) }}" class="text-decoration-none">{!! str_ireplace($keyword,'<mark class="bg-warning px-1 rounded">'.$keyword.'</mark>',e($trx->buku->judul)) !!}</a></h5>
                                    <p class="mb-0">Peminjam: <strong>{{ $trx->anggota->nama }}</strong> | Buku: {{ $trx->buku->judul }}</p>
                                    <span class="badge bg-{{ $trx->status === 'Dipinjam' ? 'warning text-dark' : 'success' }} mt-2">{{ $trx->status }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-light text-center border">
                                <i class="bi bi-search d-block fs-1 text-muted mb-2"></i>
                                Tidak ada transaksi yang cocok dengan pencarianmu.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Script Bootstrap untuk membuat Tab berfungsi --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>