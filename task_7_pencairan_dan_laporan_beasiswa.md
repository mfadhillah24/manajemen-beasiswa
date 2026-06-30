# Task 7: Pencairan dan Laporan Beasiswa

## 1. Deskripsi Task
Mengimplementasikan pencatatan pencairan dana beasiswa oleh Admin dan kewajiban pengunggahan laporan pertanggungjawaban (LPJ) oleh Mahasiswa penerima beasiswa.

## 2. Rincian Pekerjaan (Scope of Work)
* **Database & Migrasi**:
  * Membuat tabel `pencairans` (`id`, `pendaftaran_id`, `nominal`, `tanggal_cair`, `bukti_transfer_path`, `file_laporan_pertanggungjawaban`, `status_laporan`, `timestamps`).
* **Model & Relasi**:
  * Model `Pencairan`: Relasi `belongsTo` ke `Pendaftaran`.
  * Model `Pendaftaran`: Tambahkan relasi `hasOne` ke `Pencairan`.
* **Seeder & Dummy Data**:
  * Membuat `PencairanSeeder` untuk menyimulasikan riwayat pencairan dana beasiswa untuk pendaftaran yang berstatus disetujui (`Approved`).
* **Backend (Controller & Logic)**:
  * `PencairanController` (akses Admin): Menginput data pencairan dana dan mengunggah bukti transfer bank.
  * `LaporanController` (akses Mahasiswa): Mengunggah file laporan pertanggungjawaban penggunaan dana.
* **Frontend (Blade Views)**:
  * Panel pengelolaan pencairan beasiswa untuk Admin.
  * Halaman unggah laporan pertanggungjawaban pada dashboard Mahasiswa penerima beasiswa.

## 3. Konvensi & Pola Arsitektur (Existing Pattern)
* Penggunaan tipe data `decimal` untuk nominal keuangan.
* Penyimpanan file bukti transfer dan file laporan di folder terpisah pada storage disk `public`.
* Validasi input transaksi keuangan dan file PDF.

## 4. Rencana Verifikasi
* Melakukan proses input pencairan sebagai Admin dan memastikan status beasiswa berubah.
* Login sebagai Mahasiswa penerima beasiswa, mengunggah laporan pertanggungjawaban, dan memastikan Admin dapat memverifikasi laporan tersebut.
