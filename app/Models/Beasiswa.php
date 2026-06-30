<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beasiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori_beasiswa_id',
        'nama_beasiswa',
        'deskripsi',
        'syarat_ipk_minimal',
        'kuota',
        'tanggal_buka',
        'tanggal_tutup',
        'status',
    ];

    protected $casts = [
        'tanggal_buka' => 'date',
        'tanggal_tutup' => 'date',
        'syarat_ipk_minimal' => 'double',
        'kuota' => 'integer',
    ];

    public function kategoriBeasiswa()
    {
        return $this->belongsTo(KategoriBeasiswa::class, 'kategori_beasiswa_id');
    }

    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class);
    }
}
