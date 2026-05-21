# Tugas Praktikum Pemrograman Web - Pertemuan 11

**Nama:** Ari Maulida Aprilia

**NIM:** 60324068 

---

## Tugas 1: Migration Tabel Kategori

Pada bagian ini, dilakukan pembuatan file migration dan seeder untuk menerapkan normalisasi database dengan memisahkan kategori buku.

### 1. File Migration `create_kategori_table`
Menambahkan struktur tabel kategori (id, nama_kategori, deskripsi, icon, warna, timestamps).
![Screenshot Migration](ss/p10/MKode.png)

### 2. Eksekusi Database (Migrate:Fresh & Seed)
Hasil eksekusi pembuatan tabel dan pengisian seeder di terminal yang sukses berjalan tanpa error.
![Screenshot Terminal](ss/p10/hsilMigrationSeeder.png)

---

## Tugas 2: Model Accessor & Scope

Pada bagian ini, ditambahkan fitur Accessor untuk manipulasi output (seperti badge HTML) dan Scope untuk filter query pada Model Buku dan Anggota.

### 1. Model Buku (`Buku.php`)
Penambahan method `getStatusStokBadgeAttribute`, `getTahunLabelAttribute`, `scopeStokMenipis`, `scopeHargaRange`, dan `scopeTerbaru`.
![Screenshot Model Buku](ss/p10/MBuku.png)

### 2. Model Anggota (`Anggota.php`)
Penambahan method `getStatusBadgeAttribute`, `getKategoriUsiaAttribute`, `scopeJenisKelamin`, dan `scopeTerdaftarBulanIni`.
![Screenshot Model Anggota](ss/p10/MAnggota.png)

---

## Hasil Testing Route

Pengujian hasil Accessor dan Scope yang dipanggil melalui endpoint `/test-accessor-scope`.
![Screenshot Model Anggota](ss/p10/testing.jpeg)
