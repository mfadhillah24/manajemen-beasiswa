<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    protected $fillable = [
        'mahasiswa_id',
        'nama_prestasi',
        'tingkat',
        'jenis',
        'file_sertifikat',
        'tahun',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
