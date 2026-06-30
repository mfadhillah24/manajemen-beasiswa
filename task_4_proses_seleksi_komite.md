# Task 4: Proses Seleksi oleh Komite

## 1. Deskripsi Task
Membangun modul penilaian bagi Komite Seleksi untuk mengevaluasi pendaftar yang telah lolos verifikasi berkas administrasi.

## 2. Rincian Pekerjaan (Scope of Work)
* **Database & Migrasi**:
  * Membuat tabel `seleksis` (`id`, `pendaftaran_id`, `penilai_id`, `nilai_berkas`, `nilai_wawancara`, `nilai_prestasi`, `skor_akhir`, `catatan`, `rekomendasi`, `timestamps`).
* **Model & Relasi**:
  * Model `Seleksi`: Relasi `belongsTo` ke `Pendaftaran` dan `User` (sebagai penilai).
* **Seeder & Dummy Data**:
  * Membuat `SeleksiSeeder` untuk mengisi riwayat penilaian oleh akun Komite.
* **Backend (Controller & Kalkulasi)**:
  * `SeleksiController` (akses Komite Seleksi):
    * Menampilkan daftar pendaftar dengan status `Verified`.
    * Menyimpan input nilai komite dan otomatis menghitung `skor_akhir` berdasarkan formula pembobotan.
    * Menyimpan rekomendasi hasil akhir (`Ya` / `Tidak`).
* **Frontend (Blade Views)**:
  * Dashboard khusus Komite Seleksi.
  * Form penilaian pendaftar (input skor berkas, wawancara, prestasi, dan catatan).

## 3. Konvensi & Pola Arsitektur (Existing Pattern)
* Otorisasi ketat menggunakan Middleware atau Gates (`can:komite`).
* Validasi input rentang skor (misal: 0 - 100).
* Operasi database dibungkus dalam DB Transaction.

## 4. Rencana Verifikasi
* Login sebagai Komite Seleksi, melakukan penilaian pada mahasiswa pendaftar.
* Memastikan perhitungan `skor_akhir` dihitung dengan benar di backend sebelum disimpan.
