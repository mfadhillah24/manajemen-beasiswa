<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Beasiswa;
use App\Models\Pendaftaran;
use App\Models\Prestasi;
use App\Models\Dokumen;
use App\Models\Seleksi;
use App\Models\Pencairan;
use Faker\Factory as Faker;

class PresentationSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Pastikan ada beasiswa
        $beasiswas = Beasiswa::all();
        if ($beasiswas->isEmpty()) {
            $this->command->info('Silakan jalankan seeder utama dulu, Beasiswa kosong.');
            return;
        }

        // Ambil komite
        $komite = User::where('role', 'Komite')->first();

        $statuses = ['Submitted', 'Verified', 'Approved', 'Rejected'];

        // Hapus data demo sebelumnya jika ada
        User::where('email', 'like', 'mhs_demo%')->delete();

        for ($i = 1; $i <= 15; $i++) {
            // 1. Buat User Mahasiswa
            $user = User::create([
                'name' => $faker->name,
                'email' => "mhs_demo{$i}@gmail.com",
                'password' => Hash::make('password'),
                'role' => 'Mahasiswa',
                'email_verified_at' => now(),
            ]);

            // 2. Buat Profil Mahasiswa
            $mahasiswa = Mahasiswa::create([
                'user_id' => $user->id,
                'nim' => '2200' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'prodi' => $faker->randomElement(['Teknik Informatika', 'Sistem Informasi', 'Ilmu Komputer', 'Manajemen', 'Akuntansi']),
                'fakultas' => $faker->randomElement(['Fakultas Ilmu Komputer', 'Fakultas Ekonomi dan Bisnis']),
                'semester' => $faker->numberBetween(2, 8),
                'ipk' => $faker->randomFloat(2, 2.8, 4.0),
                'no_hp' => $faker->phoneNumber,
            ]);

            // 3. Buat Prestasi
            Prestasi::create([
                'mahasiswa_id' => $mahasiswa->id,
                'nama_prestasi' => $faker->sentence(3),
                'tingkat' => $faker->randomElement(['Lokal', 'Nasional', 'Internasional']),
                'jenis' => $faker->randomElement(['Akademik', 'Non-Akademik']),
                'tahun' => $faker->year(),
                'file_sertifikat' => 'dummy.pdf', // kosongi untuk demo
            ]);

            // 4. Buat Pendaftaran
            $beasiswa = $beasiswas->random();
            // Bobot probabilitas agar lebih realistis: Approved lebih banyak agar ada Pencairan
            $status = $faker->randomElement(['Submitted', 'Verified', 'Verified', 'Approved', 'Approved', 'Approved', 'Rejected']);
            
            $pendaftaran = Pendaftaran::create([
                'mahasiswa_id' => $mahasiswa->id,
                'beasiswa_id' => $beasiswa->id,
                'tanggal_daftar' => now()->subDays($faker->numberBetween(5, 60)),
                'status_pendaftaran' => $status,
            ]);

            // 5. Buat Dokumen (Asumsi sudah upload jika statusnya bukan Submitted (tapi Submitted juga sudah upload biasanya))
            Dokumen::create([
                'pendaftaran_id' => $pendaftaran->id,
                'jenis_dokumen' => 'KHS / Transkrip Nilai',
                'file_path' => 'dummy.pdf',
                'status_verifikasi' => in_array($status, ['Verified', 'Approved', 'Rejected']) ? 'Valid' : 'Pending',
            ]);

            Dokumen::create([
                'pendaftaran_id' => $pendaftaran->id,
                'jenis_dokumen' => 'Kartu Keluarga',
                'file_path' => 'dummy.pdf',
                'status_verifikasi' => in_array($status, ['Verified', 'Approved', 'Rejected']) ? 'Valid' : 'Pending',
            ]);

            // 6. Buat Seleksi jika status Approved / Rejected
            if (in_array($status, ['Approved', 'Rejected']) && $komite) {
                $nilai_berkas = $faker->numberBetween(60, 95);
                $nilai_wawancara = $faker->numberBetween(50, 95);
                $nilai_prestasi = $faker->numberBetween(40, 95);
                $skor_akhir = ($nilai_berkas * 0.3) + ($nilai_wawancara * 0.4) + ($nilai_prestasi * 0.3);

                Seleksi::create([
                    'pendaftaran_id' => $pendaftaran->id,
                    'penilai_id' => $komite->id,
                    'nilai_berkas' => $nilai_berkas,
                    'nilai_wawancara' => $nilai_wawancara,
                    'nilai_prestasi' => $nilai_prestasi,
                    'skor_akhir' => $skor_akhir,
                    'catatan' => 'Penilaian demo dari seeder.',
                    'rekomendasi' => $status == 'Approved' ? 'Ya' : 'Tidak',
                ]);
            }

            // 7. Buat Pencairan jika status Approved
            if ($status == 'Approved') {
                Pencairan::create([
                    'pendaftaran_id' => $pendaftaran->id,
                    'nominal' => $faker->randomElement([1500000, 2000000, 2500000]),
                    'tanggal_cair' => now()->subDays($faker->numberBetween(1, 30)),
                    'bukti_transfer_path' => null, // kosongi untuk demo
                    'file_laporan_pertanggungjawaban' => null,
                    'status_laporan' => $faker->randomElement(['Belum Diunggah', 'Menunggu Verifikasi', 'Disetujui']),
                ]);
            }
        }

        $this->command->info('Data presentasi (15 mahasiswa beserta riwayat beasiswa) berhasil digenerate!');
    }
}
