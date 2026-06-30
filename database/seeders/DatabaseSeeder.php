<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            SettingSeeder::class,
            MahasiswaSeeder::class,
            KategoriBeasiswaSeeder::class,
            BeasiswaSeeder::class,
            PendaftaranSeeder::class,
            DokumenSeeder::class,
            SeleksiSeeder::class,
            PrestasiSeeder::class,
            PencairanSeeder::class,
            PengumumanSeeder::class,
            LogAktivitasSeeder::class,
        ]);
    }
}
