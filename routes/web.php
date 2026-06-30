<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BeasiswaController;
use App\Http\Controllers\PendaftaranController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('login.authenticate');
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('login.logout');
    Route::post('/switch-user', [LoginController::class, 'switchUser'])->name('login.switch_user');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/dashboard/show', [DashboardController::class, 'show'])->name('dashboard.show');
    Route::get('/dashboard/edit', [DashboardController::class, 'edit'])->name('dashboard.edit');
    Route::put('/dashboard/update', [DashboardController::class, 'update'])->name('dashboard.update');

    Route::resource('/user', UserController::class)->middleware('role:Superadmin');
    Route::resource('/beasiswa', BeasiswaController::class)->middleware('role:Superadmin,Admin');
    
    Route::resource('/pendaftaran', PendaftaranController::class)->only(['index', 'create', 'store', 'show'])->middleware('role:Mahasiswa,Admin,Komite');
    Route::patch('/pendaftaran/{pendaftaran}/verify', [App\Http\Controllers\PendaftaranController::class, 'verify'])->name('pendaftaran.verify')->middleware('role:Admin,Komite');
    
    Route::post('/dokumen/{pendaftaran}', [App\Http\Controllers\DokumenController::class, 'store'])->name('dokumen.store')->middleware('role:Mahasiswa');
    Route::delete('/dokumen/{dokumen}', [App\Http\Controllers\DokumenController::class, 'destroy'])->name('dokumen.destroy')->middleware('role:Mahasiswa');
    Route::patch('/dokumen/{dokumen}/verify', [App\Http\Controllers\DokumenController::class, 'verifyDocument'])->name('dokumen.verify')->middleware('role:Admin,Komite');

    Route::get('/seleksi', [App\Http\Controllers\SeleksiController::class, 'index'])->name('seleksi.index')->middleware('role:Komite,Admin,Pimpinan');
    Route::get('/seleksi/{pendaftaran}/create', [App\Http\Controllers\SeleksiController::class, 'create'])->name('seleksi.create')->middleware('role:Komite');
    Route::post('/seleksi/{pendaftaran}', [App\Http\Controllers\SeleksiController::class, 'store'])->name('seleksi.store')->middleware('role:Komite');
    Route::get('/seleksi/detail/{seleksi}', [App\Http\Controllers\SeleksiController::class, 'show'])->name('seleksi.show')->middleware('role:Komite,Admin,Pimpinan');

    Route::resource('/akademik', App\Http\Controllers\MahasiswaController::class)->except(['show', 'destroy'])->middleware('role:Admin,Superadmin');
    Route::get('/profil-akademik', [App\Http\Controllers\MahasiswaController::class, 'profile'])->name('akademik.profile')->middleware('role:Mahasiswa');

    Route::resource('/prestasi', App\Http\Controllers\PrestasiController::class)->except(['show'])->middleware('role:Mahasiswa');

    // Pencairan (Admin)
    Route::resource('/pencairan', App\Http\Controllers\PencairanController::class)->only(['index', 'create', 'store', 'show'])->middleware('role:Admin,Superadmin,Pimpinan');
    Route::patch('/pencairan/{pencairan}/verifikasi-laporan', [App\Http\Controllers\PencairanController::class, 'verifikasiLaporan'])->name('pencairan.verifikasi_laporan')->middleware('role:Admin,Superadmin');

    // Laporan LPJ (Mahasiswa)
    Route::get('/riwayat-pencairan', [App\Http\Controllers\PencairanController::class, 'riwayatMahasiswa'])->name('pencairan.riwayat')->middleware('role:Mahasiswa');
    Route::patch('/pencairan/{pencairan}/upload-laporan', [App\Http\Controllers\PencairanController::class, 'uploadLaporan'])->name('pencairan.upload_laporan')->middleware('role:Mahasiswa');

    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::put('/setting/{setting}/update', [SettingController::class, 'update'])->name('setting.update');

    // Pengumuman
    Route::resource('/pengumuman', App\Http\Controllers\PengumumanController::class)->except(['show'])->middleware('role:Admin,Superadmin,Pimpinan,Mahasiswa');

    // Log Aktivitas
    Route::get('/log-aktivitas', [App\Http\Controllers\LogAktivitasController::class, 'index'])->name('log-aktivitas.index')->middleware('role:Admin,Superadmin,Pimpinan');
});
