@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>
        <i class="bi bi-book"></i>
        Daftar Buku
    </h1>
    <div>
        <a href="{{ route('buku.export') }}" class="btn btn-success me-2">
            <i class="bi bi-download"></i> Export CSV
        </a>
        
        <a href="{{ route('buku.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Buku
        </a>
    </div>
</div>


{{-- Statistik Cards --}}
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-primary shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Buku</h6>
                        <h2 class="mb-0">{{ $totalBuku }}</h2>
                    </div>
                    <div class="text-primary">
                        <i class="bi bi-book-fill" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-success shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Buku Tersedia</h6>
                        <h2 class="mb-0">{{ $bukuTersedia }}</h2>
                    </div>
                    <div class="text-success">
                        <i class="bi bi-check-circle-fill" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-danger shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Buku Habis</h6>
                        <h2 class="mb-0">{{ $bukuHabis }}</h2>
                    </div>
                    <div class="text-danger">
                        <i class="bi bi-x-circle-fill" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- FORM PENCARIAN ADVANCED --}}
<div class="card mb-4 shadow-sm border-0 bg-light">
    <div class="card-body">
        <form action="{{ route('buku.search') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-4">
                <input type="text" name="keyword" class="form-control" placeholder="Cari judul, pengarang, penerbit..." value="{{ request('keyword') }}">
            </div>
            <div class="col-md-3">
                <select name="kategori" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kat)
                        <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="tahun" class="form-select">
                    <option value="">Semua Tahun</option>
                    @foreach($tahuns as $thn)
                        <option value="{{ $thn }}" {{ request('tahun') == $thn ? 'selected' : '' }}>{{ $thn }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="ketersediaan" class="form-select">
                    <option value="">Status Stok</option>
                    <option value="Tersedia" {{ request('ketersediaan') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="Habis" {{ request('ketersediaan') == 'Habis' ? 'selected' : '' }}>Habis</option>
                </select>
            </div>
            <div class="col-md-1 d-grid">
                <button type="submit" class="btn btn-success"><i class="bi bi-search"></i></button>
            </div>
        </form>
    </div>
</div>

@if(request()->has('keyword') || request()->has('kategori') || request()->has('tahun') || request()->has('ketersediaan') || isset($kategori))
    <div class="alert alert-info mb-4 d-flex justify-content-between align-items-center">
        <div>
            <i class="bi bi-info-circle"></i> Menampilkan hasil pencarian.
            @isset($kategori) untuk kategori <strong>{{ $kategori }}</strong> @endisset
        </div>
        <a href="{{ route('buku.index') }}" class="btn btn-sm btn-outline-info">Reset Filter</a>
    </div>
@endif

{{-- FORM UNTUK BULK DELETE DIMULAI DARI SINI --}}
<form action="{{ route('buku.bulk-delete') }}" method="POST" id="form-bulk-delete">
    @csrf

    {{-- Toolbar Bulk Delete (Select All & Tombol Hapus) --}}
    @if($bukus->count() > 0)
    <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-white rounded shadow-sm border">
        <div class="form-check mb-0">
            <input class="form-check-input" type="checkbox" id="select-all" style="transform: scale(1.2); cursor: pointer;">
            <label class="form-check-label fw-bold ms-2" for="select-all" style="cursor: pointer;">
                Pilih Semua Buku
            </label>
        </div>
        <button type="button" class="btn btn-danger" id="btn-hapus-massal">
            <i class="bi bi-trash"></i> Hapus yang Dipilih
        </button>
    </div>
    @endif

    {{-- GRID BUKU --}}
    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4 mb-5">
        @forelse($bukus as $buku)
            <div class="col position-relative">
                
                {{-- Checkbox Individual (Ditaruh di pojok kanan atas Card) --}}
                <div class="position-absolute" style="top: 15px; right: 25px; z-index: 10;">
                    <input type="checkbox" name="buku_ids[]" value="{{ $buku->id }}" class="form-check-input buku-checkbox shadow" style="transform: scale(1.5); cursor: pointer;">
                </div>

                {{-- Memanggil komponen card buku --}}
                <x-buku-card :buku="$buku" :showActions="true" />
            </div>
        @empty
            <div class="col-12 text-center py-5 w-100">
                <i class="bi bi-journal-x display-1 text-muted mb-3 d-block"></i>
                <h5 class="text-muted">Tidak ada buku yang ditemukan.</h5>
            </div>
        @endforelse
    </div>
</form>

{{-- Footer Info --}}
@if ($bukus->count() > 0)
    <div class="text-center mt-4 mb-5">
        <p class="text-muted">
            Menampilkan {{ $bukus->count() }} buku
        </p>
    </div>
@endif
@endsection

@push('scripts')
<script>
    // 1. Logika untuk Select All
    const selectAllCheckbox = document.getElementById('select-all');
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            document.querySelectorAll('.buku-checkbox').forEach(cb => {
                cb.checked = this.checked;
            });
        });
    }

    // 2. SweetAlert untuk konfirmasi Hapus Massal (Bulk Delete)
    const btnHapusMassal = document.getElementById('btn-hapus-massal');
    if (btnHapusMassal) {
        btnHapusMassal.addEventListener('click', function() {
            const checkedBoxes = document.querySelectorAll('.buku-checkbox:checked');
            
            // Cek apakah ada yang dicentang
            if (checkedBoxes.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Silakan pilih minimal satu buku yang ingin dihapus!'
                });
                return;
            }

            // Munculkan konfirmasi
            Swal.fire({
                title: 'Hapus Massal?',
                text: `Apakah Anda yakin ingin menghapus ${checkedBoxes.length} buku yang dipilih?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus Semua!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-bulk-delete').submit();
                }
            });
        });
    }

    // 3. SweetAlert untuk Hapus Satuan
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            const judul = this.getAttribute('data-judul');
            
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: `Apakah Anda yakin ingin menghapus buku "${judul}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush