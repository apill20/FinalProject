@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Daftar Kategori Buku</h2>
    <!-- Fitur search sederhana untuk testing route search -->
    <script>
        function cariKategori() {
            let keyword = document.getElementById('searchInput').value;
            if(keyword) window.location.href = '/kategori/search/' + keyword;
        }
    </script>
    <div class="input-group w-25">
        <input type="text" id="searchInput" class="form-control" placeholder="Cari kategori...">
        <button class="btn btn-outline-secondary" onclick="cariKategori()">Cari</button>
    </div>
</div>

<div class="row">
    @foreach ($kategori_list as $kategori)
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5 class="card-title text-primary">{{ $kategori['nama'] }}</h5>
                <p class="card-text">{{ $kategori['deskripsi'] }}</p>
                <p class="text-muted small">Jumlah Buku: {{ $kategori['jumlah_buku'] }}</p>
            </div>
            <div class="card-footer bg-white border-top-0">
                <a href="{{ route('kategori.show', $kategori['id']) }}" class="btn btn-sm btn-primary w-100">Lihat Detail</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection