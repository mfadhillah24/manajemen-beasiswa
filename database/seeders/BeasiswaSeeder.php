<?php

namespace Database\Seeders;

use App\Models\Beasiswa;
use App\Models\KategoriBeasiswa;
use Illuminate\Database\Seeder;

class BeasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prestasi = KategoriBeasiswa::where('nama_kategori', 'Beasiswa Prestasi')->first();
        $bantuan = KategoriBeasiswa::where('nama_kategori', 'Beasiswa Bantuan Biaya')->first();
        $kemitraan = KategoriBeasiswa::where('nama_kategori', 'Beasiswa Kemitraan')->first();

        $beasiswas = [
            [
                'kategori_beasiswa_id' => $prestasi->id,
                'nama_beasiswa' => 'Beasiswa Unggulan Akademik Unitama 2026',
                'deskripsi' => 'Diberikan kepada mahasiswa dengan IPK minimal 3.50.',
                'syarat_ipk_minimal' => 3.50,
                'kuota' => 20,
                'tanggal_buka' => '2026-06-01',
                'tanggal_tutup' => '2026-07-31',
                'status' => 'Aktif',
            ],
            [
                'kategori_beasiswa_id' => $bantuan->id,
                'nama_beasiswa' => 'Beasiswa Bidikmisi Kampus Unitama',
                'deskripsi' => 'Diberikan kepada mahasiswa kurang mampu secara ekonomi dengan syarat IPK minimal 3.00.',
                'syarat_ipk_minimal' => 3.00,
                'kuota' => 50,
                'tanggal_buka' => '2026-06-15',
                'tanggal_tutup' => '2026-08-15',
                'status' => 'Aktif',
            ],
            [
                'kategori_beasiswa_id' => $kemitraan->id,
                'nama_beasiswa' => 'Beasiswa Kemitraan Bank Syariah 2026',
                'deskripsi' => 'Program beasiswa dari mitra perbankan untuk mahasiswa semester 4 ke atas dengan IPK minimal 3.25.',
                'syarat_ipk_minimal' => 3.25,
                'kuota' => 10,
                'tanggal_buka' => '2026-05-01',
                'tanggal_tutup' => '2026-06-15',
                'status' => 'Nonaktif',
            ],
        ];

        foreach ($beasiswas as $beasiswa) {
            Beasiswa::firstOrCreate(
                ['nama_beasiswa' => $beasiswa['nama_beasiswa']],
                $beasiswa
            );
        }
    }
}
