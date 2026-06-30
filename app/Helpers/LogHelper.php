<?php

namespace App\Helpers;

use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

class LogHelper
{
    public static function record($aktivitas, $deskripsi = null)
    {
        if (Auth::check()) {
            LogAktivitas::create([
                'user_id' => Auth::id(),
                'aktivitas' => $aktivitas,
                'deskripsi' => $deskripsi,
            ]);
        }
    }
}
