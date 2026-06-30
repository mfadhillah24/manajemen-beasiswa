# Task 5: Manajemen Data Akademik Pendaftar

## 1. Deskripsi Task
Membuat profil akademik terperinci mahasiswa dan mengintegrasikannya dengan proses pendaftaran beasiswa guna penyaringan otomatis (misal: syarat IPK minimal).

## 2. Rincian Pekerjaan (Scope of Work)
* **Database & Migrasi**:
  * Membuat tabel `mahasiswas` (`id`, `user_id`, `nim`, `prodi`, `fakultas`, `ipk`, `semester`, `no_hp`, `timestamps`).
* **Model & Relasi**:
  * Model `Mahasiswa`: Relasi `belongsTo` ke `User`, `hasMany` ke `Pendaftaran` dan `Prestasi`.
  * Model `User`: Tambahkan relasi `hasOne` ke `Mahasiswa`.
* **Seeder & Dummy Data**:
  * Memperbarui `UserSeeder` untuk membuat profil `Mahasiswa` terkait ketika user dengan role `Mahasiswa` dibuat.
  * Membuat `MahasiswaSeeder` untuk men-seed data akademik lengkap (NIM, Prodi, IPK, Semester).
* **Backend (Controller & Logic)**:
  * Menyesuaikan pendaftaran beasiswa agar menolak mahasiswa secara otomatis jika IPK mahasiswa di bawah `syarat_ipk_minimal` dari program beasiswa yang dipilih.
  * CRUD data akademik mahasiswa oleh Admin.
* **Frontend (Blade Views)**:
  * Halaman profil mahasiswa (menampilkan data akademik).
  * Panel pengelolaan data mahasiswa bagi Admin.

## 3. Konvensi & Pola Arsitektur (Existing Pattern)
* Hubungan 1-to-1 menggunakan `hasOne` dan `belongsTo`.
* Validasi keunikan NIM (`unique:mahasiswas,nim`).
* Format data float untuk kolom IPK.

## 4. Rencana Verifikasi
* Menjalankan seeder mahasiswa dan memastikan relasi ke tabel `users` terbentuk dengan benar.
* Mencoba mendaftar beasiswa dengan akun mahasiswa yang memiliki IPK di bawah standar dan memastikan sistem menolak dengan pesan yang sesuai.
