<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'mahasiswa@gmail.com')->first();

        if ($user) {
            Mahasiswa::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'nim' => '20220140081',
                    'prodi' => 'Teknik Informatika',
                    'fakultas' => 'Teknologi Informasi',
                    'ipk' => 3.75,
                    'semester' => 4,
                    'no_hp' => '081234567890',
                ]
            );
        }

        // Tambahan mahasiswa lain untuk pengujian
        $extraUsers = [
            [
                'name' => 'Siti Aminah',
                'email' => 'siti@gmail.com',
                'nim' => '20220140082',
                'ipk' => 3.40,
                'semester' => 4,
            ],
            [
                'name' => 'Rian Hidayat',
                'email' => 'rian@gmail.com',
                'nim' => '20220140083',
                'ipk' => 2.95, // IPK rendah untuk uji filter beasiswa
                'semester' => 2,
            ],
        ];

        foreach ($extraUsers as $extra) {
            $u = User::firstOrCreate(
                ['email' => $extra['email']],
                [
                    'name' => $extra['name'],
                    'password' => bcrypt('password'),
                    'role' => 'Mahasiswa',
                    'email_verified_at' => now(),
                ]
            );

            Mahasiswa::firstOrCreate(
                ['user_id' => $u->id],
                [
                    'nim' => $extra['nim'],
                    'prodi' => 'Sistem Informasi',
                    'fakultas' => 'Teknologi Informasi',
                    'ipk' => $extra['ipk'],
                    'semester' => $extra['semester'],
                    'no_hp' => '089876543210',
                ]
            );
        }
    }
}
