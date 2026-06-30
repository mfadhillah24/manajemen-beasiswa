<?php

namespace Database\Seeders;

use App\Models\Dokumen;
use App\Models\Pendaftaran;
use Illuminate\Database\Seeder;

class DokumenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pendaftarans = Pendaftaran::all();

        foreach ($pendaftarans as $pendaftaran) {
            Dokumen::create([
                'pendaftaran_id' => $pendaftaran->id,
                'jenis_dokumen' => 'KTP',
                'file_path' => 'documents/dummy_ktp.pdf',
                'status_verifikasi' => 'Valid',
            ]);

            Dokumen::create([
                'pendaftaran_id' => $pendaftaran->id,
                'jenis_dokumen' => 'Transkrip Nilai',
                'file_path' => 'documents/dummy_transkrip.pdf',
                'status_verifikasi' => 'Pending',
            ]);
        }
    }
}
