@extends('layouts.app')

@section('content')
<div class="card shadow-sm mt-4">
    <div class="card-header bg-white">
        <h2 class="mb-0">Daftar Anggota Perpustakaan</h2>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th>No</th>
                    <th>Kode Anggota</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($anggota_list as $index => $anggota)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $anggota['kode'] }}</td>
                        <td>{{ $anggota['nama'] }}</td>
                        <td>{{ $anggota['email'] }}</td>
                        <td>
                            @if ($anggota['status'] == 'Aktif')
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-danger">Non-Aktif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ url('/anggota/'.$anggota['id']) }}" class="btn btn-sm btn-primary">Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection