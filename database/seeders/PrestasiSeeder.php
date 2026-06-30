<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\Prestasi;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class PrestasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cari user mahasiswa
        $user = User::where('email', 'mahasiswa@gmail.com')->first();
        if (!$user || !$user->mahasiswa) {
            return;
        }

        $mahasiswa = $user->mahasiswa;

        // Buat file sertifikat dummy
        Storage::disk('public')->makeDirectory('sertifikats');
        
        $prestasis = [
            [
                'nama_prestasi' => 'Juara 1 Lomba Web Design Nasional',
                'tingkat' => 'Nasional',
                'jenis' => 'Akademik',
                'tahun' => 2024,
            ],
            [
                'nama_prestasi' => 'Peserta Pertukaran Mahasiswa Internasional',
                'tingkat' => 'Internasional',
                'jenis' => 'Non-Akademik',
                'tahun' => 2023,
            ]
        ];

        foreach ($prestasis as $index => $prestasi) {
            // Simulasi upload file dummy
            $fileName = 'dummy_sertifikat_' . $index . '.jpg';
            // copy file dummy jika ada, atau buat file text kosong
            Storage::disk('public')->put('sertifikats/' . $fileName, 'Ini adalah isi dari sertifikat dummy ' . $prestasi['nama_prestasi']);

            Prestasi::create([
                'mahasiswa_id' => $mahasiswa->id,
                'nama_prestasi' => $prestasi['nama_prestasi'],
                'tingkat' => $prestasi['tingkat'],
                'jenis' => $prestasi['jenis'],
                'file_sertifikat' => 'sertifikats/' . $fileName,
                'tahun' => $prestasi['tahun'],
            ]);
        }
    }
}
