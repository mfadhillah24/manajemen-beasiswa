<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengumuman;
use App\Models\Beasiswa;

class PengumumanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $beasiswa = Beasiswa::first();

        if ($beasiswa) {
            Pengumuman::create([
                'beasiswa_id' => $beasiswa->id,
                'judul' => 'Pengumuman Hasil Seleksi ' . $beasiswa->nama_beasiswa,
                'konten' => 'Selamat kepada para mahasiswa yang telah dinyatakan lulus seleksi untuk program ' . $beasiswa->nama_beasiswa . '. Silakan cek status Anda di menu pendaftaran dan segera lengkapi berkas untuk tahap pencairan dana. Keputusan komite bersifat final dan tidak dapat diganggu gugat.',
                'tanggal_tampil' => now(),
            ]);

            Pengumuman::create([
                'beasiswa_id' => $beasiswa->id,
                'judul' => 'Jadwal Pencairan Dana Tahap I',
                'konten' => 'Bagi penerima beasiswa, dana tahap I akan mulai dicairkan pada minggu depan. Pastikan nomor rekening yang terdaftar sudah benar dan aktif.',
                'tanggal_tampil' => now()->addDays(2),
            ]);
        }
    }
}
