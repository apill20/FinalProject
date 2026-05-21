@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb" class="mt-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/anggota') }}">Anggota</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail: {{ $anggota['nama'] }}</li>
    </ol>
</nav>

<div class="card shadow-sm mt-2" style="max-width: 600px;">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Informasi Anggota: {{ $anggota['kode'] }}</h5>
    </div>
    <div class="card-body">
        <table class="table table-borderless">
            <tr>
                <th style="width: 150px;">Nama Lengkap</th>
                <td>: {{ $anggota['nama'] }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>: {{ $anggota['email'] }}</td>
            </tr>
            <tr>
                <th>Telepon</th>
                <td>: {{ $anggota['telepon'] }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>: {{ $anggota['alamat'] }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>: 
                    @if ($anggota['status'] == 'Aktif')
                        <span class="badge bg-success">Aktif</span>
                    @else
                        <span class="badge bg-danger">Non-Aktif</span>
                    @endif
                </td>
            </tr>
        </table>
        <div class="mt-3">
            <a href="{{ url('/anggota') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection