<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    // mengamankan nama tabel agar laravel tidak mencari tabel 'kategoris'
    protected $table = 'kategori';

    // kolom yang diizinkan untuk diisi secara massal (Mass Assignment)
    protected $fillable = [
        'nama_kategori',
        'deskripsi',
        'icon',
        'warna',
    ];
}
