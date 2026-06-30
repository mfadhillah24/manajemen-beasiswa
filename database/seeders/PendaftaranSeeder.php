<?php

namespace Database\Seeders;

use App\Models\Beasiswa;
use App\Models\Mahasiswa;
use App\Models\Pendaftaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PendaftaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mahasiswa1 = Mahasiswa::where('nim', '20220140081')->first();
        $mahasiswa2 = Mahasiswa::where('nim', '20220140082')->first();
        
        $beasiswaPrestasi = Beasiswa::where('nama_beasiswa', 'Beasiswa Unggulan Akademik Unitama 2026')->first();
        $beasiswaBantuan = Beasiswa::where('nama_beasiswa', 'Beasiswa Bidikmisi Kampus Unitama')->first();

        if ($mahasiswa1 && $beasiswaPrestasi) {
            Pendaftaran::create([
                'mahasiswa_id' => $mahasiswa1->id,
                'beasiswa_id' => $beasiswaPrestasi->id,
                'tanggal_daftar' => now(),
                'status_pendaftaran' => 'Verified', // Set to Verified so Komite can see it
            ]);
        }

        if ($mahasiswa2 && $beasiswaBantuan) {
             Pendaftaran::create([
                'mahasiswa_id' => $mahasiswa2->id,
                'beasiswa_id' => $beasiswaBantuan->id,
                'tanggal_daftar' => now(),
                'status_pendaftaran' => 'Submitted',
            ]);
        }
    }
}
