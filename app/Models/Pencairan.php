<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pencairan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pendaftaran_id',
        'nominal',
        'tanggal_cair',
        'bukti_transfer_path',
        'file_laporan_pertanggungjawaban',
        'status_laporan',
        'catatan_admin',
    ];

    protected $casts = [
        'nominal'      => 'decimal:2',
        'tanggal_cair' => 'date',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }
}
