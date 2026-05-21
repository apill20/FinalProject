<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KategoriController extends Controller
{
    // Data Dummy Kategori
    private function getKategoriData()
    {
        return [
            ['id' => 1, 'nama' => 'Programming', 'deskripsi' => 'Buku pemrograman dan coding', 'jumlah_buku' => 25],
            ['id' => 2, 'nama' => 'Database', 'deskripsi' => 'Buku manajemen basis data SQL & NoSQL', 'jumlah_buku' => 15],
            ['id' => 3, 'nama' => 'Jaringan', 'deskripsi' => 'Buku infrastruktur dan keamanan jaringan', 'jumlah_buku' => 10],
            ['id' => 4, 'nama' => 'Desain', 'deskripsi' => 'Buku UI/UX dan desain grafis', 'jumlah_buku' => 20],
            ['id' => 5, 'nama' => 'Sistem Operasi', 'deskripsi' => 'Buku panduan Windows, Linux, dan Mac', 'jumlah_buku' => 12],
        ];
    }

    // Data Dummy Buku
    private function getBukuData()
    {
        return [
            ['id' => 1, 'kategori_id' => 1, 'judul' => 'Belajar Laravel 10', 'penulis' => 'Taylor Otwell', 'tahun' => 2023],
            ['id' => 2, 'kategori_id' => 1, 'judul' => 'PHP untuk Pemula', 'penulis' => 'Rasmus Lerdorf', 'tahun' => 2022],
            ['id' => 3, 'kategori_id' => 2, 'judul' => 'Mastering MySQL', 'penulis' => 'Michael Widenius', 'tahun' => 2021],
            ['id' => 4, 'kategori_id' => 3, 'judul' => 'Jaringan Komputer Dasar', 'penulis' => 'Andrew S. Tanenbaum', 'tahun' => 2020],
        ];
    }

    // a. Method index() - Daftar Kategori
    public function index()
    {
        $kategori_list = $this->getKategoriData();
        return view('kategori.index', compact('kategori_list'));
    }

    // b. Method show($id) - Detail Kategori
    public function show($id)
    {
        $kategori_list = $this->getKategoriData();
        $semua_buku = $this->getBukuData();

        // Cari kategori berdasarkan ID
        $kategori = collect($kategori_list)->firstWhere('id', (int)$id);
        
        if (!$kategori) {
            abort(404);
        }

        // Cari buku yang memiliki kategori_id sesuai dengan ID yang diminta
        $buku_list = collect($semua_buku)->where('kategori_id', (int)$id)->all();

        return view('kategori.show', compact('kategori', 'buku_list'));
    }

    // c. Method search($keyword) - Cari Kategori
    public function search($keyword)
    {
        $kategori_list = $this->getKategoriData();
        
        // Filter array kategori jika nama atau deskripsinya mengandung keyword (case-insensitive)
        $hasil_pencarian = collect($kategori_list)->filter(function ($item) use ($keyword) {
            return stripos($item['nama'], $keyword) !== false || stripos($item['deskripsi'], $keyword) !== false;
        })->all();

        return view('kategori.search', compact('hasil_pencarian', 'keyword'));
    }
}