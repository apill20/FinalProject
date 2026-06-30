<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\TransaksiController;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Route;
 
// Public routes (tanpa auth)
Route::get('/', function () {
    return redirect()->route('login');
});

    // Protected routes (dengan auth middleware)
    Route::middleware(['auth'])->group(function () {

    // Dashboard
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');

    // Gantikan semua Route::get('/dashboard')
Route::get('/dashboard', function () {
    $transaksiTerlambat = Transaksi::with(['anggota', 'buku'])
        ->where('status', 'Dipinjam')
        ->where('tanggal_kembali', '<', now()->startOfDay())
        ->get();

    $jumlahTerlambat = $transaksiTerlambat->count();

    return view('dashboard', compact('transaksiTerlambat', 'jumlahTerlambat'));
})->middleware(['auth', 'verified'])->name('dashboard');
 
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
 
    // Buku - CRUD
    Route::get('/buku/export', [BukuController::class, 'export'])->name('buku.export');
    Route::get('/buku/search', [BukuController::class, 'search'])->name('buku.search');
    Route::get('/buku/kategori/{kategori}', [BukuController::class, 'filterKategori'])->name('buku.kategori');
    Route::delete('/buku/bulk-delete', [BukuController::class, 'bulkDelete'])->name('buku.bulk.delete');
    Route::resource('buku', BukuController::class);
 
    // Anggota - CRUD
    Route::get('/anggota/export', [AnggotaController::class, 'export'])->name('anggota.export');
    Route::get('/anggota/search', [AnggotaController::class, 'search'])->name('anggota.search');
    Route::resource('anggota', AnggotaController::class);
 
    // Transaksi - CRUD + Custom routes
    // Rute untuk Laporan Transaksi
    Route::get('/transaksi/laporan', [App\Http\Controllers\TransaksiController::class, 'laporan'])->name('transaksi.laporan');
    Route::get('/transaksi/laporan/pdf', [App\Http\Controllers\TransaksiController::class, 'exportPdf'])->name('transaksi.export-pdf');
    Route::resource('transaksi', TransaksiController::class);
    Route::put('/transaksi/{id}/kembalikan', [TransaksiController::class, 'kembalikan'])->name('transaksi.kembalikan');
});
 
require __DIR__.'/auth.php';