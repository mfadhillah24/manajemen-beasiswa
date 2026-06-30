<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LogAktivitas;
use App\Models\User;

class LogAktivitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'Admin')->first();

        $mahasiswa = User::where('role', 'Mahasiswa')->first();

        if ($admin) {
            LogAktivitas::create([
                'user_id' => $admin->id,
                'aktivitas' => 'Login',
                'deskripsi' => 'Admin berhasil login ke sistem',
                'created_at' => now()->subDays(2),
            ]);
            LogAktivitas::create([
                'user_id' => $admin->id,
                'aktivitas' => 'Membuat Beasiswa',
                'deskripsi' => 'Admin membuat program beasiswa baru',
                'created_at' => now()->subDays(2)->addHours(1),
            ]);
        }

        if ($mahasiswa) {
            LogAktivitas::create([
                'user_id' => $mahasiswa->id,
                'aktivitas' => 'Mendaftar Beasiswa',
                'deskripsi' => 'Mahasiswa melakukan pendaftaran beasiswa',
                'created_at' => now()->subDays(1),
            ]);
            LogAktivitas::create([
                'user_id' => $mahasiswa->id,
                'aktivitas' => 'Upload Dokumen',
                'deskripsi' => 'Mahasiswa mengupload berkas persyaratan',
                'created_at' => now()->subDays(1)->addHours(2),
            ]);
        }
    }
}
