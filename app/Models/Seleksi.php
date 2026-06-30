<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seleksi extends Model
{
    protected $fillable = [
        'pendaftaran_id',
        'penilai_id',
        'nilai_berkas',
        'nilai_wawancara',
        'nilai_prestasi',
        'skor_akhir',
        'catatan',
        'rekomendasi',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }

    public function penilai()
    {
        return $this->belongsTo(User::class, 'penilai_id');
    }
}
