<?php

namespace Database\Seeders;

use App\Models\KategoriBeasiswa;
use Illuminate\Database\Seeder;

class KategoriBeasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'nama_kategori' => 'Beasiswa Prestasi',
                'deskripsi' => 'Beasiswa yang diberikan kepada mahasiswa berprestasi di bidang akademik maupun non-akademik.',
            ],
            [
                'nama_kategori' => 'Beasiswa Bantuan Biaya',
                'deskripsi' => 'Beasiswa bagi mahasiswa kurang mampu secara ekonomi namun memiliki tekad belajar tinggi.',
            ],
            [
                'nama_kategori' => 'Beasiswa Kemitraan',
                'deskripsi' => 'Beasiswa kerja sama antara Kampus Unitama dengan pihak sponsor eksternal.',
            ],
        ];

        foreach ($categories as $category) {
            KategoriBeasiswa::firstOrCreate(
                ['nama_kategori' => $category['nama_kategori']],
                $category
            );
        }
    }
}
