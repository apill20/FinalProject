<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="d-flex justify-content-end align-items-center mb-4">
                    <div>
                        <a href="{{ route('buku.create')}}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Tambah Buku
                        </a>

                        <a href="{{ route('buku.export') }}" class="btn btn-success me-2">
                            <i class="bi bi-download"></i> Export CSV
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

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
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-body bg-light rounded">
                        <form action="{{ route('buku.search') }}" method="GET">
                            <div class="row g-3 align-items-end">

                                <div class="col-md-3">
                                    <label class="form-label small">Keyword</label>
                                    <input type="text"
                                        name="keyword"
                                        class="form-control"
                                        placeholder="Cari judul, pengarang, penerbit..."
                                        value="{{ request('keyword') }}">
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label small">Kategori</label>
                                    <select name="kategori" class="form-select">
                                        <option value="">Semua Kategori</option>
                                        @foreach($kategoris as $kat)
                                            <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>
                                                {{ $kat }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label small">Tahun</label>
                                    <select name="tahun" class="form-select">
                                        <option value="">Semua Tahun</option>
                                        @foreach($tahuns as $thn)
                                            <option value="{{ $thn }}" {{ request('tahun') == $thn ? 'selected' : '' }}>
                                                {{ $thn }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label small">Ketersediaan</label>
                                    <select name="ketersediaan" class="form-select">
                                        <option value="">Status Stok</option>
                                        <option value="Tersedia" {{ request('ketersediaan') == 'Tersedia' ? 'selected' : '' }}>
                                            Tersedia
                                        </option>
                                        <option value="Habis" {{ request('ketersediaan') == 'Habis' ? 'selected' : '' }}>
                                            Habis
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-3 d-flex gap-2">
                                    <button type="submit" class="btn btn-primary flex-fill">
                                        <i class="bi bi-search"></i> Cari
                                    </button>

                                    <a href="{{ route('buku.index') }}"
                                    class="btn btn-secondary flex-fill">
                                        <i class="bi bi-x-circle"></i> Reset
                                    </a>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

                {{-- FORM UNTUK BULK DELETE DIMULAI DARI SINI --}}
                <form action="{{ route('buku.bulk.delete') }}" method="POST" id="form-bulk-delete">
                    @csrf

                    {{-- Toolbar Bulk Delete --}}
                    @if($bukus->count() > 0)
                    <div class="d-flex align-items-center mb-3">
                        <div class="form-check me-3 mb-0">
                            <input class="form-check-input" type="checkbox" id="select-all" style="cursor: pointer;">
                            <label class="form-check-label fw-bold" for="select-all" style="cursor: pointer;">
                                Pilih Semua
                            </label>
                        </div>
                        <button type="button" class="btn btn-danger btn-sm" id="btn-hapus-massal">
                            <i class="bi bi-trash"></i> Hapus Terpilih
                        </button>
                    </div>
                    @endif

                    {{-- LIST BUKU MEMANJANG --}}
                    <div class="d-flex flex-column gap-3 mb-5">
                        @forelse($bukus as $buku)
                            <div class="card border border-light shadow-sm">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        
                                        {{-- Kiri: Checkbox, Ikon, & Kategori --}}
                                        <div class="col-md-2 text-center border-end">
                                            <div class="text-start mb-2">
                                                <input type="checkbox" name="buku_ids[]" value="{{ $buku->id }}" class="form-check-input buku-checkbox" style="cursor: pointer;">
                                                <label class="form-check-label text-muted" style="font-size: 0.8rem;">Pilih</label>
                                            </div>
                                            <i class="bi bi-book text-primary" style="font-size: 3.5rem;"></i>
                                            <div class="mt-2">
                                                <span class="badge bg-primary rounded-pill px-3">{{ $buku->kategori }}</span>
                                            </div>
                                        </div>

                                        {{-- Tengah: Info Buku --}}
                                        <div class="col-md-7 ps-4">
                                            <h5 class="text-primary fw-bold mb-1">{{ $buku->judul }}</h5>
                                            <div class="text-muted mb-2" style="font-size: 0.85rem;">
                                                <i class="bi bi-person"></i> {{ $buku->pengarang }} | 
                                                <i class="bi bi-building"></i> {{ $buku->penerbit }} | 
                                                <i class="bi bi-calendar"></i> {{ $buku->tahun_terbit }}
                                            </div>
                                            <div class="text-muted mb-3" style="font-size: 0.85rem;">
                                                <i class="bi bi-upc-scan"></i> ISBN: {{ $buku->isbn ?? '-' }}
                                            </div>
                                            <p class="mb-0 text-secondary" style="font-size: 0.9rem;">
                                                {{ Str::limit($buku->deskripsi ?? 'Tidak ada deskripsi.', 100) }}
                                            </p>
                                        </div>

                                        {{-- Kanan: Harga, Stok, & Tombol Aksi --}}
                                        <div class="col-md-3 border-start text-end">
                                            <h5 class="fw-bold text-primary mb-1">Rp {{ number_format($buku->harga, 0, ',', '.') }}</h5>
                                            <div class="mb-3">
                                                @if($buku->stok > 0)
                                                    <span class="badge bg-success"><i class="bi bi-check-circle"></i> Tersedia</span>
                                                    <small class="text-muted d-block mt-1" style="font-size: 0.8rem;">Stok: {{ $buku->stok }} buku</small>
                                                @else
                                                    <span class="badge bg-danger"><i class="bi bi-x-circle"></i> Habis</span>
                                                    <small class="text-muted d-block mt-1" style="font-size: 0.8rem;">Stok: 0</small>
                                                @endif
                                            </div>
                                            
                                            {{-- Tombol Detail, Edit, Hapus (Berjejer ke bawah) --}}
                                            <div class="d-grid gap-2">
                                                <a href="{{ route('buku.show', $buku->id) }}" class="btn btn-info btn-sm text-white">
                                                    <i class="bi bi-eye"></i> Detail
                                                </a>
                                                <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-warning btn-sm">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm btn-delete-satuan" data-id="{{ $buku->id }}" data-judul="{{ $buku->judul }}">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5 w-100">
                                <i class="bi bi-journal-x display-1 text-muted mb-3 d-block"></i>
                                <h5 class="text-muted">Tidak ada buku yang ditemukan.</h5>
                            </div>
                        @endforelse
                    </div>
                {{-- </form> --}}

                {{-- Footer Info --}}
                @if ($bukus->count() > 0)
                    <div class="text-center mt-4 mb-5">
                        <p class="text-muted">
                            Menampilkan {{ $bukus->count() }} buku
                        </p>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>

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

    // 2. SweetAlert Hapus Massal
    const btnHapusMassal = document.getElementById('btn-hapus-massal');
    console.log("BTN =", btnHapusMassal);
    if (btnHapusMassal) {
        btnHapusMassal.addEventListener('click', function() {
            console.log("DIKLIK");
            const checkedBoxes = document.querySelectorAll('.buku-checkbox:checked');
            console.log("Jumlah:", checkedBoxes.length);
            if (checkedBoxes.length === 0) {
                Swal.fire({ icon: 'warning', title: 'Oops...', text: 'Silakan pilih minimal satu buku!' });
                return;
            }
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

    // 3. SweetAlert Hapus Satuan
    document.querySelectorAll('.btn-delete-satuan').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.getAttribute('data-id');
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
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/buku/${id}`;
                    form.innerHTML = `<input type="hidden" name="_token" value="{{ csrf_token() }}"> <input type="hidden" name="_method" value="DELETE">`;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
</script>