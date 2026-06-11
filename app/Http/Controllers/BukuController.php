<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
use App\Models\Buku;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 1. Ambil semua data buku dari database
        $bukus = Buku::latest()->get();
        
        // 2. Data Unik untuk Dropdown Form Advanced Search (Tugas 3)
        $kategoris = Buku::select('kategori')->distinct()->pluck('kategori');
        $tahuns = Buku::select('tahun_terbit')->distinct()->pluck('tahun_terbit')->sortDesc();
        
        // 3. Statistik Lama Tetap Dipertahankan
        $totalBuku = Buku::count();
        $bukuTersedia = Buku::where('stok', '>', 0)->count();
        $bukuHabis = Buku::where('stok', 0)->count();
        
        // Return view dengan gabungan data lama + baru
        return view('buku.index', compact(
            'bukus',
            'kategoris',
            'tahuns',
            'totalBuku',
            'bukuTersedia',
            'bukuHabis'
        ));
    }

    /**
     * Fitur Pencarian & Filter Advanced (Tugas 3)
     */
    public function search(Request $request)
    {
        $query = Buku::query();
        
        // Filter Keyword (mencari di judul, pengarang, penerbit)
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('judul', 'like', "%{$keyword}%")
                  ->orWhere('pengarang', 'like', "%{$keyword}%")
                  ->orWhere('penerbit', 'like', "%{$keyword}%");
            });
        }

        // Filter Kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter Tahun
        if ($request->filled('tahun')) {
            $query->where('tahun_terbit', $request->tahun);
        }

        // Filter Ketersediaan
        if ($request->filled('ketersediaan')) {
            if ($request->ketersediaan == 'Tersedia') {
                $query->where('stok', '>', 0);
            } elseif ($request->ketersediaan == 'Habis') {
                $query->where('stok', '<=', 0);
            }
        }
        
        // Eksekusi query hasil pencarian
        $bukus = $query->latest()->get();
        
        // Ambil data dropdown agar form pencarian tidak kosong/error
        $kategoris = Buku::select('kategori')->distinct()->pluck('kategori');
        $tahuns = Buku::select('tahun_terbit')->distinct()->pluck('tahun_terbit')->sortDesc();

        // Hitung ulang statistik berdasarkan hasil pencarian saat ini
        $totalBuku = $bukus->count();
        $bukuTersedia = $bukus->where('stok', '>', 0)->count();
        $bukuHabis = $bukus->where('stok', 0)->count();

        return view('buku.index', compact(
            'bukus', 
            'kategoris', 
            'tahuns', 
            'totalBuku', 
            'bukuTersedia', 
            'bukuHabis'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('buku.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBukuRequest $request)
    {
        try {
            // Create buku baru dengan validasi data
            Buku::create($request->validated());

            // Redirect dengan success message
            return redirect()->route('buku.index')
            ->with('success', 'Buku berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Redirect dengan error message jika gagal
            return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Gagal menambahkan buku:'. $e->getMessage());
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $buku = Buku::findOrFail($id);
        return view('buku.show', compact('buku'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $buku = Buku::findOrFail($id);
        return view('buku.edit', compact('buku'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBukuRequest $request, string $id)
    {
        try {
            $buku = Buku::findOrFail($id);

            // Update buku dengan validated data
            $buku->update($request->validated());

            //Redirect dengan success message
            return redirect()
                    ->route('buku.index')
                    ->with('success', 'Buku berhasil diperbarui!');
        } catch (\Exception $e) {
            // Redirect dengan error message jika gagal
            return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Gagal memperbarui buku:'. $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $buku = Buku::findOrFail($id);
            $judulBuku = $buku->judul;

            // Delete buku
            $buku->delete();

            // Redirect dengan success message
            return redirect()
                    ->route('buku.index')
                    ->with('success', "Buku '{$judulBuku}' berhasil dihapus!");
        } catch (\Exception $e) {
            // Redirect dengan error message jika gagal
            return redirect()
                    ->back()
                    ->with('error', 'Gagal menghapus buku:'. $e->getMessage());
        }
    }
    
    /**
     * Filter buku berdasarkan kategori (Rute Kustom Lama)
     */
    public function filterKategori($kategori)
    {
        $bukus = Buku::where('kategori', $kategori)->latest()->get();
        
        // Ditambahkan data dropdown agar layout indeks baru tidak jebol/error
        $kategoris = Buku::select('kategori')->distinct()->pluck('kategori');
        $tahuns = Buku::select('tahun_terbit')->distinct()->pluck('tahun_terbit')->sortDesc();

        $totalBuku = $bukus->count();
        $bukuTersedia = $bukus->where('stok', '>', 0)->count();
        $bukuHabis = $bukus->where('stok', 0)->count();
        
        return view('buku.index', compact(
            'bukus',
            'kategoris',
            'tahuns',
            'totalBuku',
            'bukuTersedia',
            'bukuHabis',
            'kategori'
        ));
    }

    public function bulkDelete(Request $request)
    {
        // Ambil kumpulan ID yang dicentang
        $ids = $request->buku_ids;

        // Antisipasi jika user langsung klik hapus tanpa mencentang apa pun
        if (empty($ids)) {
            return redirect()->back()->with('error', 'Silakan pilih minimal satu buku yang ingin dihapus!');
        }

        // Eksekusi hapus massal
        Buku::whereIn('id', $ids)->delete();

        return redirect()->route('buku.index')
                        ->with('success', count($ids) . ' buku berhasil dihapus!');
    }

    public function export()
    {
        // Ambil semua data buku dari database
        $bukus = Buku::all();
        
        // Tentukan nama file unik menggunakan format tanggal dan jam saat ini
        $filename = 'buku_' . date('Y-m-d_His') . '.csv';
        
        // Set bimbingan header HTTP agar browser mengenali ini sebagai download file CSV
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        // Proses pembuatan file CSV secara streaming
        $callback = function() use ($bukus) {
            $file = fopen('php://output', 'w');
            
            // 1. Membuat Baris Header CSV
            fputcsv($file, [
                'Kode Buku', 'Judul', 'Kategori', 'Pengarang', 
                'Penerbit', 'Tahun', 'ISBN', 'Harga', 'Stok'
            ]);
            
            // 2. Memasukkan Baris Data Buku
            foreach ($bukus as $buku) {
                fputcsv($file, [
                    $buku->kode_buku,
                    $buku->judul,
                    $buku->kategori,
                    $buku->pengarang,
                    $buku->penerbit,
                    $buku->tahun_terbit,
                    $buku->isbn,
                    $buku->harga,
                    $buku->stok,
                ]);
            }
            
            fclose($file);
        };
        
        // Kembalikan respon berupa stream download
        return response()->stream($callback, 200, $headers);
    }
}