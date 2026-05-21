@extends('layouts.app')

@section('content')
<!-- Breadcrumb Navigation -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('kategori.index') }}">Kategori</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $kategori['nama'] }}</li>
    </ol>
</nav>

<div class="card mb-4 shadow-sm">
    <div class="card-body">
        <h3>Kategori: {{ $kategori['nama'] }}</h3>
        <p class="mb-0">{{ $kategori['deskripsi'] }}</p>
    </div>
</div>

<h4>Daftar Buku Terkait</h4>
<div class="card shadow-sm">
    <div class="card-body">
        @if(count($buku_list) > 0)
        <table class="table table-striped table-hover">
            <thead class="table-primary">
                <tr>
                    <th>No</th>
                    <th>Judul Buku</th>
                    <th>Penulis</th>
                    <th>Tahun Terbit</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($buku_list as $index => $buku)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $buku['judul'] }}</td>
                    <td>{{ $buku['penulis'] }}</td>
                    <td>{{ $buku['tahun'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="alert alert-warning mb-0">Belum ada buku untuk kategori ini.</div>
        @endif
    </div>
</div>
@endsection