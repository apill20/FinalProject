<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PerpustakaanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use Illuminate\Support\Facades\DB;
use App\Models\Buku;
use App\Models\Anggota;

//Route Tugas 11 - Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Route Home - Praktikum 11
Route::get('/', function () {
    return view('home');
})->name('home');

// Jalur untuk mengunduh file CSV data buku
Route::get('/buku/export', [BukuController::class, 'export'])->name('buku.export');

// Cari Buku
Route::get('/buku/search', [BukuController::class, 'search'])->name('buku.search');

// Custom route untuk filter kategori
Route::get('/buku/kategori/{kategori}', [BukuController::class, 'filterKategori'])
     ->name('buku.kategori');

// Jalur untuk eksekusi hapus massal
Route::post('/buku/bulk-delete', [BukuController::class, 'bulkDelete'])
     ->name('buku.bulk-delete');

// Resource route untuk Buku
Route::resource('buku', BukuController::class);

// Jalur untuk mengunduh file Excel data anggota
Route::get('/anggota/export', [AnggotaController::class, 'export'])->name('anggota.export');

// Jalur untuk Advanced Search Anggota
Route::get('/anggota/search', [AnggotaController::class, 'search'])->name('anggota.search');
 
// Resource route untuk Anggota (akan dibuat nanti)
Route::resource('anggota', AnggotaController::class);

// Route Default
// Route::get('/', function () {
//     return view('welcome');
// });

// Route Test Koneksi Database (Tetap Dipertahankan)
// Route::get('/test-db', function () {
//     try {
//         DB::connection()->getPdo();
//         $dbName = DB::connection()->getDatabaseName();
//         return "Koneksi database berhasil!<br />Database: <strong>{$dbName}</strong>";
//     } catch (\Exception $e) {
//         return "Koneksi database gagal!<br />Error: " . $e->getMessage();
//     }
// });

// Route Utility Sederhana (Opsional)
// Route::get('/hello', function () {
//     return 'Hello dari Laravel!';
// });

// Route::get('/info', function () {
//     return '<h1>Sistem Perpustakaan</h1><p>Selamat datang!</p>';
// });


//  TESTING BUKU (Versi Upgrade Database - Praktikum 8)
// List semua buku dari database
// Route::get('/buku', function () {
//     $bukus = Buku::all();
    
//     $html = '<h1>Daftar Buku (Database)</h1>';
//     $html .= '<a href="/buku/create">Tambah Buku</a><br /><br />';
//     $html .= '<table border="1" cellpadding="10">';
//     $html .= '<tr>
//                 <th>ID</th>
//                 <th>Kode</th>
//                 <th>Judul</th>
//                 <th>Kategori</th>
//                 <th>Harga</th>
//                 <th>Stok</th>
//                 <th>Aksi</th>
//               </tr>';
    
//     foreach ($bukus as $buku) {
//         $html .= '<tr>';
//         $html .= '<td>' . $buku->id . '</td>';
//         $html .= '<td>' . $buku->kode_buku . '</td>';
//         $html .= '<td>' . $buku->judul . '</td>';
//         $html .= '<td>' . $buku->kategori . '</td>';
//         $html .= '<td>' . $buku->harga_format . '</td>'; // Menggunakan accessor harga_format
//         $html .= '<td>' . $buku->stok . '</td>';
//         $html .= '<td>
//                     <a href="/buku/' . $buku->id . '">Detail</a> | 
//                     <a href="/buku/' . $buku->id . '/edit">Edit</a>
//                   </td>';
//         $html .= '</tr>';
//     }
    
//     $html .= '</table>';
//     return $html;
// });

// Detail single buku dari database
// Route::get('/buku/{id}', function ($id) {
//     $buku = Buku::findOrFail($id);
    
//     $html = '<h1>Detail Buku</h1>';
//     $html .= '<a href="/buku">Kembali</a><br /><br />';
//     $html .= '<table border="1" cellpadding="10">';
//     $html .= '<tr><th>Field</th><th>Value</th></tr>';
//     $html .= '<tr><td>ID</td><td>' . $buku->id . '</td></tr>';
//     $html .= '<tr><td>Kode Buku</td><td>' . $buku->kode_buku . '</td></tr>';
//     $html .= '<tr><td>Judul</td><td>' . $buku->judul . '</td></tr>';
//     $html .= '<tr><td>Kategori</td><td>' . $buku->kategori . '</td></tr>';
//     $html .= '<tr><td>Pengarang</td><td>' . $buku->pengarang . '</td></tr>';
//     $html .= '<tr><td>Penerbit</td><td>' . $buku->penerbit . '</td></tr>';
//     $html .= '<tr><td>Tahun</td><td>' . $buku->tahun_terbit . '</td></tr>';
//     $html .= '<tr><td>ISBN</td><td>' . $buku->isbn . '</td></tr>';
//     $html .= '<tr><td>Harga</td><td>' . $buku->harga_format . '</td></tr>';
//     $html .= '<tr><td>Stok</td><td>' . $buku->stok . '</td></tr>';
//     $html .= '<tr><td>Tersedia?</td><td>' . ($buku->tersedia ? 'Ya' : 'Tidak') . '</td></tr>';
//     $html .= '<tr><td>Created</td><td>' . $buku->created_at . '</td></tr>';
//     $html .= '<tr><td>Updated</td><td>' . $buku->updated_at . '</td></tr>';
//     $html .= '</table>';
    
//     return $html;
// })->where('id', '[0-9]+'); // Memastikan parameter ID berupa angka agar tidak bentrok dengan rute lain


//  TESTING ANGGOTA (Versi Upgrade Database - Praktikum 8)
// List semua anggota dari database
// Route::get('/anggota', function () {
//     $anggotas = Anggota::all();
    
//     $html = '<h1>Daftar Anggota (Database)</h1>';
//     $html .= '<table border="1" cellpadding="10">';
//     $html .= '<tr>
//                 <th>ID</th>
//                 <th>Kode</th>
//                 <th>Nama</th>
//                 <th>Email</th>
//                 <th>Umur</th>
//                 <th>Status</th>
//                 <th>Aksi</th>
//               </tr>';
    
//     foreach ($anggotas as $anggota) {
//         $html .= '<tr>';
//         $html .= '<td>' . $anggota->id . '</td>';
//         $html .= '<td>' . $anggota->kode_anggota . '</td>';
//         $html .= '<td>' . $anggota->nama . '</td>';
//         $html .= '<td>' . $anggota->email . '</td>';
//         $html .= '<td>' . $anggota->umur . ' tahun</td>'; // Menggunakan accessor umur
//         $html .= '<td>' . $anggota->status . '</td>';
//         $html .= '<td><a href="/anggota/' . $anggota->id . '">Detail</a></td>';
//         $html .= '</tr>';
//     }
    
//     $html .= '</table>';
//     return $html;
// });

// Detail single anggota dari database
// Route::get('/anggota/{id}', function ($id) {
//     $anggota = Anggota::findOrFail($id);
    
//     $html = '<h1>Detail Anggota</h1>';
//     $html .= '<a href="/anggota">Kembali</a><br /><br />';
//     $html .= '<table border="1" cellpadding="10">';
//     $html .= '<tr><th>Field</th><th>Value</th></tr>';
//     $html .= '<tr><td>Kode Anggota</td><td>' . $anggota->kode_anggota . '</td></tr>';
//     $html .= '<tr><td>Nama</td><td>' . $anggota->nama . '</td></tr>';
//     $html .= '<tr><td>Email</td><td>' . $anggota->email . '</td></tr>';
//     $html .= '<tr><td>Telepon</td><td>' . $anggota->telepon . '</td></tr>';
//     $html .= '<tr><td>Alamat</td><td>' . $anggota->alamat . '</td></tr>';
//     $html .= '<tr><td>Tanggal Lahir</td><td>' . $anggota->tanggal_lahir->format('d-m-Y') . '</td></tr>';
//     $html .= '<tr><td>Umur</td><td>' . $anggota->umur . ' tahun</td></tr>';
//     $html .= '<tr><td>Jenis Kelamin</td><td>' . $anggota->jenis_kelamin . '</td></tr>';
//     $html .= '<tr><td>Pekerjaan</td><td>' . $anggota->pekerjaan . '</td></tr>';
//     $html .= '<tr><td>Tanggal Daftar</td><td>' . $anggota->tanggal_daftar->format('d-m-Y') . '</td></tr>';
//     $html .= '<tr><td>Lama Anggota</td><td>' . $anggota->lama_anggota . ' hari</td></tr>'; // Menggunakan accessor lama_anggota
//     $html .= '<tr><td>Status</td><td>' . $anggota->status . '</td></tr>';
//     $html .= '</table>';
    
//     return $html;
// })->where('id', '[0-9]+');


// Praktikum 8
// Route::get('/test-query', function () {
//     $html = '<h1>Testing Query Eloquent</h1>';
    
    // Buku tersedia
    // $tersedia = Buku::tersedia()->get();
    // $html .= '<h3>Buku Tersedia (Stok > 0): ' . $tersedia->count() . '</h3>';
    // $html .= '<ul>';
    // foreach ($tersedia as $buku) {
    //     $html .= '<li>' . $buku->judul . ' (Stok: ' . $buku->stok . ')</li>';
    // }
    // $html .= '</ul>';
    
    // Buku Programming
    // $programming = Buku::kategori('Programming')->get();
    // $html .= '<h3>Buku Programming: ' . $programming->count() . '</h3>';
    // $html .= '<ul>';
    // foreach ($programming as $buku) {
    //     $html .= '<li>' . $buku->judul . '</li>';
    // }
    // $html .= '</ul>';
    
    // Anggota Aktif
//     $aktif = Anggota::aktif()->get();
//     $html .= '<h3>Anggota Aktif: ' . $aktif->count() . '</h3>';
//     $html .= '<ul>';
//     foreach ($aktif as $anggota) {
//         $html .= '<li>' . $anggota->nama . ' (' . $anggota->email . ')</li>';
//     }
//     $html .= '</ul>';
    
//     return $html;
// });


// Route tugas 9
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
Route::get('/kategori/search/{keyword}', [KategoriController::class, 'search'])->name('kategori.search');
Route::get('/kategori/{id}', [KategoriController::class, 'show'])->name('kategori.show');

// Route dengan Controller lama (opsional jika view index/show buku controller masih dipakai)
Route::get('/perpustakaan-old', [PerpustakaanController::class, 'index']);
Route::get('/about', [PerpustakaanController::class, 'about']);


// Route tugas 10 - Testing Accessor & Scope
Route::get('/test-accessor-scope', function () {
    // Ambil data (pake take/limit agar halaman tidak penuh jika datanya banyak)
    $bukus = Buku::take(5)->get();
    $bukuTerbaru = Buku::terbaru()->get();
    $bukuMenipis = Buku::stokMenipis()->get();
    
    $anggotas = Anggota::take(5)->get();
    $anggotaBaru = Anggota::terdaftarBulanIni()->get();

    $html = '<!DOCTYPE html><html><head><title>Testing Accessor</title>';
    // Link Bootstrap
    $html .= '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">';
    $html .= '</head><body>';
    
    // Bungkus pakai container agar rapi ke tengah
    $html .= '<div class="container mt-4 mb-5">'; 
    $html .= '<h1 class="text-primary border-bottom pb-2">Testing Accessor & Scope</h1>';
    
    // Test Buku
    $html .= '<h3 class="mt-4 text-secondary">1. Buku dengan status_stok_badge</h3><ul>';
    foreach($bukus as $b) {
        $html .= "<li>{$b->judul} - Stok: {$b->stok} {$b->status_stok_badge}</li>";
    }
    $html .= '</ul>';

    $html .= '<h3 class="mt-4 text-secondary">2. Buku Terbaru (Scope)</h3><ul>';
    foreach($bukuTerbaru as $b) {
        $html .= "<li>{$b->judul} - <span class='badge bg-secondary'>{$b->tahun_label}</span></li>";
    }
    $html .= '</ul>';

    $html .= '<h3 class="mt-4 text-secondary">3. Buku Stok Menipis (Scope)</h3><ul>';
    foreach($bukuMenipis as $b) {
        $html .= "<li>{$b->judul} - Stok: {$b->stok}</li>";
    }
    $html .= '</ul>';

    // Test Anggota
    $html .= '<h3 class="mt-4 text-secondary">4. Anggota dengan status_badge</h3><ul>';
    foreach($anggotas as $a) {
        $html .= "<li>{$a->nama} - {$a->status_badge}</li>";
    }
    $html .= '</ul>';

    $html .= '<h3 class="mt-4 text-secondary">5. Anggota dengan kategori_usia</h3><ul>';
    foreach($anggotas as $a) {
        $html .= "<li>{$a->nama} - Umur: {$a->umur} tahun (<span class='badge bg-dark'>{$a->kategori_usia}</span>)</li>";
    }
    $html .= '</ul>';

    $html .= '<h3 class="mt-4 text-secondary">6. Anggota Terdaftar Bulan Ini (Scope)</h3><ul>';
    foreach($anggotaBaru as $a) {
        $html .= "<li>{$a->nama} - Tgl Daftar: {$a->created_at->format('d-m-Y')}</li>";
    }
    $html .= '</ul>';

    // --- BAGIAN PENUTUP YANG WAJIB ADA ---
    $html .= '</div>'; // Tutup container
    $html .= '</body></html>'; // Tutup body dan html

    return $html;
});

