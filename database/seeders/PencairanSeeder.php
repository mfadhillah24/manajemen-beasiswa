<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\Pendaftaran;
use App\Models\Pencairan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class PencairanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cari pendaftaran dengan status Approved
        // Karena PendaftaranSeeder membuat dengan status Verified,
        // kita buat satu data pendaftaran Approved secara khusus untuk seeder ini
        $mahasiswa1 = Mahasiswa::where('nim', '20220140081')->first();

        if (!$mahasiswa1) {
            return;
        }

        // Cari atau buat pendaftaran dengan status Approved untuk demo pencairan
        $pendaftaran = Pendaftaran::with('pencairan')
            ->where('mahasiswa_id', $mahasiswa1->id)
            ->whereDoesntHave('pencairan')
            ->first();

        if (!$pendaftaran) {
            return;
        }

        // Ubah status pendaftaran menjadi Approved
        $pendaftaran->update(['status_pendaftaran' => 'Approved']);

        // Buat folder jika belum ada
        Storage::disk('public')->makeDirectory('bukti_transfer');

        // Buat file dummy bukti transfer
        $buktiPath = 'bukti_transfer/dummy_bukti_transfer.pdf';
        Storage::disk('public')->put($buktiPath, 'Ini adalah isi file bukti transfer dummy.');

        Pencairan::create([
            'pendaftaran_id'              => $pendaftaran->id,
            'nominal'                     => 5000000.00,
            'tanggal_cair'               => now()->subDays(10),
            'bukti_transfer_path'         => $buktiPath,
            'file_laporan_pertanggungjawaban' => null,
            'status_laporan'              => 'Belum Diunggah',
            'catatan_admin'               => null,
        ]);
    }
}
