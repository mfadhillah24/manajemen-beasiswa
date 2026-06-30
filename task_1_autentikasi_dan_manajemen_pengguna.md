# Task 1: Autentikasi dan Manajemen Pengguna (User Management)

## 1. Deskripsi Task
Menyesuaikan sistem autentikasi dan manajemen pengguna (CRUD) yang sudah ada di Laravel agar selaras dengan peran pengguna (*user roles*) baru yang didefinisikan dalam `PRD.md`. Task ini juga mencakup penyesuaian database, pembuatan data seeder dummy untuk setiap peran, dan pembaruan antarmuka CRUD pengguna.

## 2. Rincian Pekerjaan (Scope of Work)
* **Database & Migrasi**:
  * Mengubah kolom `role` pada tabel `users` (file migrasi `0001_01_01_000000_create_users_table.php`) agar mendukung enum peran baru: `Superadmin`, `Admin`, `Mahasiswa`, `Komite`, `Pimpinan`.
* **Seeder & Dummy Data**:
  * Memperbarui `UserSeeder.php` untuk men-seed pengguna dummy dengan setiap peran baru:
    * `Superadmin`: `tamus@gmail.com`
    * `Admin`: `admin@gmail.com`
    * `Mahasiswa`: `mahasiswa@gmail.com`
    * `Komite`: `komite@gmail.com`
    * `Pimpinan`: `pimpinan@gmail.com`
    * Password default untuk semua akun: `password`.
* **Backend (Controller & Request)**:
  * Memperbarui validasi di [UserController.php](file:///d:/SEMESTER%204/PEMROGRAMAN%20WEB%202/LARAVELL/app-manajemen-beasiswa/app/Http/Controllers/UserController.php) pada method `store` dan `update` agar menerima peran baru tersebut.
* **Frontend (Blade Views)**:
  * Memperbarui dropdown pilihan `role` pada form tambah pengguna (`user.create`) dan edit pengguna (`user.edit`) agar memuat opsi peran baru.
  * Memastikan daftar pengguna (`user.index`) menampilkan label peran baru dengan benar.

## 3. Konvensi & Pola Arsitektur (Existing Pattern)
* Menggunakan **Laravel Controller** standar ([UserController.php](file:///d:/SEMESTER%204/PEMROGRAMAN%20WEB%202/LARAVELL/app-manajemen-beasiswa/app/Http/Controllers/UserController.php)).
* Menggunakan **Form Request Validation** inline di dalam controller dengan pesan kesalahan bahasa Indonesia.
* Menggunakan **DB Transaction** (`DB::beginTransaction()`, `DB::commit()`, `DB::rollBack()`) pada operasi write database.
* Menggunakan session flash message `withSuccess()` dan `withError()` untuk notifikasi.

## 4. Rencana Verifikasi
* Menjalankan perintah `php artisan migrate:fresh --seed`.
* Mencoba login menggunakan masing-masing akun dummy baru.
* Melakukan uji coba CRUD User melalui panel Admin (menguji tambah, edit, dan hapus user dengan peran baru).
