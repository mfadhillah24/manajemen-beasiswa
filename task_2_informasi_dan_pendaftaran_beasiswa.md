# Task 2: Informasi dan Pendaftaran Beasiswa Online

## 1. Deskripsi Task
Membuat fitur pengelolaan kategori beasiswa dan program beasiswa oleh Admin, serta antarmuka pendaftaran online bagi Mahasiswa.

## 2. Rincian Pekerjaan (Scope of Work)
* **Database & Migrasi**:
  * Membuat tabel `kategori_beasiswas` (`id`, `nama_kategori`, `deskripsi`, `timestamps`).
  * Membuat tabel `beasiswas` (`id`, `kategori_beasiswa_id`, `nama_beasiswa`, `deskripsi`, `syarat_ipk_minimal`, `kuota`, `tanggal_buka`, `tanggal_tutup`, `status`, `timestamps`).
  * Membuat tabel `pendaftarans` (`id`, `mahasiswa_id`, `beasiswa_id`, `tanggal_daftar`, `status_pendaftaran`, `timestamps`).
* **Model & Relasi**:
  * Model `KategoriBeasiswa`: Relasi `hasMany` ke `Beasiswa`.
  * Model `Beasiswa`: Relasi `belongsTo` ke `KategoriBeasiswa`, `hasMany` ke `Pendaftaran`.
  * Model `Pendaftaran`: Relasi `belongsTo` ke `Mahasiswa` dan `Beasiswa`.
* **Seeder & Dummy Data**:
  * Membuat `KategoriBeasiswaSeeder` (e.g., Prestasi, Bantuan Biaya, Kemitraan).
  * Membuat `BeasiswaSeeder` dengan data dummy program beasiswa aktif dan tidak aktif.
* **Backend (Controller & Routing)**:
  * `BeasiswaController`: Mengelola CRUD beasiswa (akses Admin).
  * `PendaftaranController`: Mengelola proses pendaftaran mahasiswa (akses Mahasiswa).
* **Frontend (Blade Views)**:
  * Halaman daftar beasiswa terbuka untuk Mahasiswa.
  * Form pendaftaran beasiswa untuk Mahasiswa.
  * Panel manajemen beasiswa untuk Admin.

## 3. Konvensi & Pola Arsitektur (Existing Pattern)
* Menggunakan Eloquent ORM dengan penamaan tabel jamak (*plural*).
* Validasi input menggunakan Laravel Validator/Form Request di Controller dengan pesan error bahasa Indonesia.
* Proteksi rute menggunakan middleware autentikasi dan otorisasi berbasis *role*.

## 4. Rencana Verifikasi
* Menjalankan migrasi dan seeder untuk kategori dan program beasiswa.
* Memastikan hanya Mahasiswa yang dapat mendaftar beasiswa.
* Memastikan validasi tanggal buka/tutup dan syarat IPK berfungsi saat pendaftaran.
