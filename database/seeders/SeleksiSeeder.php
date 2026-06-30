<?php

namespace Database\Seeders;

use App\Models\Seleksi;
use App\Models\Pendaftaran;
use App\Models\User;
use Illuminate\Database\Seeder;

class SeleksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kita nonaktifkan pengisian nilai otomatis di sini 
        // agar Anda (Komite) bisa mengetes form input penilaian secara manual di UI.
        
        /*
        $komite = User::where('role', 'Komite')->first();
        $pendaftarans = Pendaftaran::all();

        if ($komite && $pendaftarans->count() > 0) {
            // Beri nilai pada pendaftaran pertama
            $pendaftaran = $pendaftarans->first();

            $nilai_berkas = 85;
            $nilai_wawancara = 90;
            $nilai_prestasi = 80;
            
            $skor_akhir = ($nilai_berkas * 0.30) + ($nilai_wawancara * 0.40) + ($nilai_prestasi * 0.30);

            Seleksi::create([
                'pendaftaran_id' => $pendaftaran->id,
                'penilai_id' => $komite->id,
                'nilai_berkas' => $nilai_berkas,
                'nilai_wawancara' => $nilai_wawancara,
                'nilai_prestasi' => $nilai_prestasi,
                'skor_akhir' => $skor_akhir,
                'catatan' => 'Peserta memiliki potensi yang sangat baik.',
                'rekomendasi' => 'Ya',
            ]);
            
            // Ubah status pendaftaran menjadi Approved untuk pendaftaran pertama ini (sebagai contoh alur selanjutnya)
            $pendaftaran->update(['status_pendaftaran' => 'Verified']);
        }
        */
    }
}
