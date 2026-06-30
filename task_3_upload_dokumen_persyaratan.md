# Task 3: Upload Dokumen Persyaratan

## 1. Deskripsi Task
Mengimplementasikan modul pengunggahan berkas digital (dokumen persyaratan) oleh Mahasiswa sebagai syarat pendaftaran beasiswa, serta antarmuka verifikasi berkas oleh Admin.

## 2. Rincian Pekerjaan (Scope of Work)
* **Database & Migrasi**:
  * Membuat tabel `dokumens` (`id`, `pendaftaran_id`, `jenis_dokumen`, `file_path`, `status_verifikasi`, `timestamps`).
* **Model & Relasi**:
  * Model `Dokumen`: Relasi `belongsTo` ke `Pendaftaran`.
* **Seeder & Dummy Data**:
  * Membuat `DokumenSeeder` yang mensimulasikan unggahan dokumen PDF/gambar untuk pendaftaran dummy.
* **Backend (Controller & Storage)**:
  * Menangani penyimpanan file menggunakan `Storage::disk('public')` ke folder `documents/`.
  * Validasi tipe file (PDF, JPG, PNG) dan ukuran maksimal (2MB).
  * Method verifikasi dokumen oleh Admin (`verifyDocument`) untuk mengubah status verifikasi menjadi `Valid` atau `Invalid`.
* **Frontend (Blade Views)**:
  * Form upload dokumen pada langkah pendaftaran mahasiswa.
  * Halaman detail pendaftaran pada sisi Admin untuk melihat dan memverifikasi dokumen (menggunakan iframe/preview gambar).

## 3. Konvensi & Pola Arsitektur (Existing Pattern)
* File disimpan menggunakan disk `public` bawaan Laravel dengan helper `store()`.
* Penggunaan `Storage::disk('public')->delete()` saat dokumen diubah atau dihapus.
* Menampilkan pesan validasi dalam bahasa Indonesia.

## 4. Rencana Verifikasi
* Menguji unggah berkas dengan format ilegal (misal: .docx, .zip) dan ukuran > 2MB untuk memastikan penolakan sistem.
* Memverifikasi berkas melalui akun Admin dan memastikan status dokumen terupdate di database.
