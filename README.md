# Tugas Pemrograman Web 2

**Nama:** Ari Maulida Aprilia

**NIM:** 60324068 

---

Sistem Informasi Perpustakaan berbasis **Laravel 13** yang digunakan untuk mengelola data buku, anggota, transaksi peminjaman, pencarian global, dashboard statistik, serta laporan transaksi.

---

## 📌 Fitur

### Authentication
- Login
- Register
- Logout
- Profile Management
- Protected Route (Middleware Authentication)

### Dashboard
- Top 5 Buku Populer
- Top 5 Anggota Populer
- Statistik Transaksi
- Grafik Statistik

### Manajemen Buku
- Tambah Buku
- Edit Buku
- Hapus Buku
- Detail Buku
- Export CSV
- Bulk Delete
- Advanced Search & Filter

### Manajemen Anggota
- Tambah Anggota
- Edit Anggota
- Hapus Anggota
- Detail Anggota
- Export Excel
- Advanced Search & Filter

### Manajemen Transaksi
- Peminjaman Buku
- Pengembalian Buku
- Perhitungan Denda Otomatis
- Update Stok Otomatis
- Detail Transaksi

### Global Search
- Pencarian Buku
- Pencarian Anggota
- Pencarian Transaksi
- Highlight Keyword
- Tab Result

### Laporan
- Filter Tanggal
- Filter Status
- Filter Anggota
- Statistik Laporan
- Export PDF

# 📷 Dokumentasi Tampilan

## 1. Register
Menampilkan Halaman Register 

> ![Halaman Register](ss/final/register.png)

---

## 2. Login
Menampilkan halaman login sebagai autentikasi pengguna.
> ![Halaman Login](ss/final/login.jpeg)

---

## 3. Profile

Halaman Profil digunakan untuk mengelola data akun pengguna, seperti mengubah informasi profil, memperbarui kata sandi, dan mengelola akun.

> ![Halaman Profile](ss/final/profil.jpeg)

---

## 4. Dashboard

Menampilkan ringkasan statistik serta shortcut menuju fitur utama.

> ![Halaman Dashboard](ss/final/dahboard.jpeg)
---

## 5. Manajemen Buku

Pengguna dapat menambah, mengubah, menghapus, mencari, memfilter, melakukan bulk delete, dan mengekspor data buku.

> Halaman Buku 
![Halaman Buku](ss/final/buku.jpeg)

>Halaman Form Tambah Buku 
![Form Tambah Buku](ss/final/formTambahBuku.jpeg)

> Halaman Detail Buku
![Detail Buku](ss/final/detailBuku%20(2).jpeg)

> Update Form Buku
![Update Form Buku](ss/final/updateForm.jpeg)

> Hasil Filter buku
![Filter Buku](ss/final/hasilFilterBuku.jpeg)

> Sweet Alert dan BulkDelete
![Sweet Alert](ss/final/sweetAlert.png)
![Bulk Delete](ss/final/hasilBulkDelete.png)

> Hasil Export CSV
![Hasil Export CSV](ss/final/csv.png)
![Hasil Export CSV](ss/final/hasilcsv.png)


---

## 6. Manajemen Anggota

Mengelola data anggota perpustakaan beserta fitur pencarian dan export data.

> Halaman Anggota
![Halaman Anggota](ss/final/anggota.jpeg)

>Halaman Form Tambah Anggota
![Form Tambah Anggota](ss/final/formTambahAnggota.jpeg)

> Hasil Filter Anggota
![Filter Anggota](ss/final/filterAnggota.jpeg)

> Halaman Detail Anggota
![Detail Anggota](ss/final/detailAnggota.jpeg)

> Hasil Update Anggota
![Hasil Update Anggota](ss/final/updateAnggota.jpeg)

---

## 7. Manajemen Transaksi

Mengelola proses peminjaman dan pengembalian buku secara otomatis, termasuk pengurangan stok dan perhitungan denda.

> Halaman Transaksi
![Halaman Transaksi](ss/final/transaksi.jpeg)

>Halaman Form Pinjam Buku
![Form Tambah Transaksi](ss/final/formPinjamBuku.jpeg)

> Halaman Detail Transaksi
![Detail Transaksi](ss/final/detailPeminjaman.jpeg)

> Sweet Alert Kembalikan Buku
![Sweet Alert Kembalikan Buku](ss/final/sweetAlertTransaksi.png)

> Detail Jika Buku Kembali Tepat Waktu
![Buku Kembali Tepat Waktu](ss/final/tepatWaktu.jpeg)

> Detail Jika Buku Kembali Terlambat
![Buku Kembali Terlambat](ss/final/detailTerlambat.jpeg)
![Buku Kembali Terlambat](ss/final/terlambarDikembalikan.jpeg)

---

## 8. Global Search

Memudahkan pengguna mencari data buku, anggota, maupun transaksi dalam satu halaman pencarian.

> Global Search
![Halaman Transaksi](ss/final/globalSearchBuku.jpeg)

>Halaman Form Pinjam Buku
![Form Tambah Transaksi](ss/final/globalSearchAnggota.png)

> Halaman Detail Transaksi
![Detail Transaksi](ss/final/globalSearchLaporan.png)

> Jika Data Tidak Ditemukan, maka di Buku, Anggota, Maupun Laporan kosong(Tidak ada pencarian yang cocok)
![Detail Transaksi](ss/final/globalSearchNull.png)

---

## 9. Laporan Transaksi

Menampilkan laporan transaksi lengkap dengan fitur filter, statistik, cetak, dan export PDF.
> Halaman Laporan Transaksi
![Halaman Laporan Transaksi](ss/final/laporan.jpeg)

> Hasil Filter Laporan Bulan Mei - dimana bulan Mei belum ada Transaksi
![Hasil Filter Laporan Bulan Mei](ss/final/hasilFilterLaporan.jpeg)

> Hasil Filter Laporan Bulan Juni
![Hasil Filter Laporan Bulan Juni](ss/final/filterLaporan.jpeg)
*(Note: Disitu tertulis denda keseluruhan 170.ooo karna menghitung dari semua transaksi - TRX-010 terlambat mengembalikan buku (6 hari) dan otomatis denda)*

> Hasil Export PDF
![Hasil Export PDF](ss/final/hasilPDF.png)
