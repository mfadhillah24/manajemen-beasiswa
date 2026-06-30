# Task 8: Pengumuman Hasil Seleksi dan Log Audit Aktivitas

## 1. Deskripsi Task
Mengimplementasikan modul publikasi pengumuman hasil seleksi oleh Pimpinan/Admin, serta pencatatan log aktivitas sistem secara otomatis demi transparansi.

## 2. Rincian Pekerjaan (Scope of Work)
* **Database & Migrasi**:
  * Membuat tabel `pengumumans` (`id`, `beasiswa_id`, `judul`, `konten`, `tanggal_tampil`, `timestamps`).
  * Membuat tabel `log_aktivitass` (`id`, `user_id`, `aktivitas`, `deskripsi`, `created_at`).
* **Model & Relasi**:
  * Model `Pengumuman`: Relasi `belongsTo` ke `Beasiswa`.
  * Model `LogAktivitas`: Relasi `belongsTo` ke `User`.
* **Seeder & Dummy Data**:
  * Membuat `PengumumanSeeder` untuk menyajikan pengumuman kelulusan awal.
  * Membuat `LogAktivitasSeeder` untuk mensimulasikan beberapa log aktivitas pengguna di masa lalu.
* **Backend (Controller, Middleware & Event)**:
  * `PengumumanController`: CRUD pengumuman (akses Admin) dan tampilan pengumuman (akses Publik/Mahasiswa).
  * Membuat **Middleware** atau **Event Listener** untuk merekam secara otomatis setiap aktivitas penting ke dalam tabel `log_aktivitass` (misal: login gagal/sukses, perubahan status pendaftaran, pengisian nilai oleh komite).
* **Frontend (Blade Views)**:
  * Halaman pengumuman kelulusan di dashboard Mahasiswa.
  * Panel riwayat Log Aktivitas untuk Admin/Pimpinan.

## 3. Konvensi & Pola Arsitektur (Existing Pattern)
* Logging otomatis menggunakan model helper atau middleware global.
* Query log diurutkan berdasarkan `created_at` terbaru (`latest()`).

## 4. Rencana Verifikasi
* Melakukan beberapa tindakan di aplikasi (misal: login, verifikasi berkas) lalu memeriksa apakah tindakan tersebut tercatat otomatis di tabel `log_aktivitass`.
* Memastikan pengumuman hasil seleksi muncul di dashboard mahasiswa yang mendaftar pada program beasiswa bersangkutan.
