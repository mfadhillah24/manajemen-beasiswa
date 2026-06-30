<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumumans';

    protected $fillable = [
        'beasiswa_id',
        'judul',
        'konten',
        'tanggal_tampil',
    ];

    protected $casts = [
        'tanggal_tampil' => 'date',
    ];

    public function beasiswa()
    {
        return $this->belongsTo(Beasiswa::class);
    }
}
