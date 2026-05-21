<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategori_data = [
            [
                'nama_kategori' => 'Programming', 
                'deskripsi' => 'Buku seputar bahasa pemrograman dan algoritma.', 
                'icon' => 'code-slash', 
                'warna' => 'primary'
            ],
            [
                'nama_kategori' => 'Database', 
                'deskripsi' => 'Buku seputar SQL, NoSQL, dan manajemen basis data.', 
                'icon' => 'database', 'warna' => 'success'],
            [
                'nama_kategori' => 'Web Design', 
                'deskripsi' => 'Buku seputar UI/UX, CSS, dan desain antarmuka web.', 
                'icon' => 'palette', 'warna' => 'info'
            ],
            [
                'nama_kategori' => 'Networking', 
                'deskripsi' => 'Buku seputar jaringan komputer dan keamanan.', 
                'icon' => 'wifi', 'warna' => 'warning'
            ],
            [
                'nama_kategori' => 'Data Science', 
                'deskripsi' => 'Buku seputar analisis data, statistik, dan machine learning.', 
                'icon' => 'graph-up', 'warna' => 'danger'
            ],
        ];

        // Looping untuk memasukkan setiap baris data ke tabel kategori
        foreach ($kategori_data as $data) {
            Kategori::create($data);
        }
    }
}