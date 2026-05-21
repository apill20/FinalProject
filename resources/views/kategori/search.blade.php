@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h2>Hasil Pencarian Kategori</h2>
    <p>Menampilkan hasil untuk kata kunci: <strong>"{{ $keyword }}"</strong></p>
    <a href="{{ route('kategori.index') }}" class="btn btn-secondary btn-sm">Kembali ke Semua Kategori</a>
</div>

<div class="row">
    @forelse ($hasil_pencarian as $kategori)
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100 border-primary">
            <div class="card-body">
                <!-- Highlight Keyword menggunakan PHP string replace -->
                <h5 class="card-title text-primary">
                    {!! str_ireplace($keyword, '<span class="highlight">'.$keyword.'</span>', $kategori['nama']) !!}
                </h5>
                <p class="card-text">
                    {!! str_ireplace($keyword, '<span class="highlight">'.$keyword.'</span>', $kategori['deskripsi']) !!}
                </p>
                <p class="text-muted small">Jumlah Buku: {{ $kategori['jumlah_buku'] }}</p>
            </div>
            <div class="card-footer bg-white border-top-0">
                <a href="{{ route('kategori.show', $kategori['id']) }}" class="btn btn-sm btn-primary w-100">Lihat Detail</a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-danger">Kategori dengan kata kunci "{{ $keyword }}" tidak ditemukan.</div>
    </div>
    @endforelse
</div>
@endsection