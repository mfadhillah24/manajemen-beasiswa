<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pencairans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->constrained('pendaftarans')->cascadeOnDelete();
            $table->decimal('nominal', 15, 2);
            $table->date('tanggal_cair');
            $table->string('bukti_transfer_path')->nullable();
            $table->string('file_laporan_pertanggungjawaban')->nullable();
            $table->enum('status_laporan', ['Belum Diunggah', 'Menunggu Verifikasi', 'Disetujui', 'Ditolak'])->default('Belum Diunggah');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pencairans');
    }
};
