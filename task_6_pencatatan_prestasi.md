# Task 6: Pencatatan Prestasi Akademik & Non-Akademik

## 1. Deskripsi Task
Mengimplementasikan fitur pencatatan portofolio prestasi mahasiswa yang dapat digunakan sebagai nilai tambah dalam proses seleksi beasiswa.

## 2. Rincian Pekerjaan (Scope of Work)
* **Database & Migrasi**:
  * Membuat tabel `prestasis` (`id`, `mahasiswa_id`, `nama_prestasi`, `tingkat`, `jenis`, `file_sertifikat`, `tahun`, `timestamps`).
* **Model & Relasi**:
  * Model `Prestasi`: Relasi `belongsTo` ke `Mahasiswa`.
* **Seeder & Dummy Data**:
  * Membuat `PrestasiSeeder` untuk men-seed data prestasi dummy (sertifikat menggunakan file dummy) yang terhubung ke mahasiswa.
* **Backend (Controller & Storage)**:
  * `PrestasiController`: Mengelola CRUD prestasi bagi Mahasiswa.
  * Validasi input prestasi (nama prestasi wajib diisi, tingkat & jenis berupa enum/pilihan terbatas, sertifikat wajib berupa gambar/pdf max 2MB).
* **Frontend (Blade Views)**:
  * Form tambah/edit prestasi pada dashboard Mahasiswa.
  * Tab daftar prestasi pada profil Mahasiswa yang dapat dilihat oleh Admin dan Komite Seleksi.

## 3. Konvensi & Pola Arsitektur (Existing Pattern)
* Pengolahan file sertifikat menggunakan storage disk `public` bawaan.
* Validasi input inline di Controller dengan pesan error bahasa Indonesia.
* Relasi Eloquent untuk menampilkan daftar prestasi mahasiswa secara dinamis.

## 4. Rencana Verifikasi
* Menambahkan data prestasi baru sebagai Mahasiswa dan memastikan file sertifikat berhasil diunggah.
* Memastikan Admin dan Komite Seleksi dapat melihat daftar prestasi tersebut pada halaman detail mahasiswa/pendaftar.
