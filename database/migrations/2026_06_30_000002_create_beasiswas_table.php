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
        Schema::create('beasiswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_beasiswa_id')->constrained('kategori_beasiswas')->cascadeOnDelete();
            $table->string('nama_beasiswa');
            $table->text('deskripsi')->nullable();
            $table->double('syarat_ipk_minimal')->default(0.0);
            $table->integer('kuota')->default(0);
            $table->date('tanggal_buka');
            $table->date('tanggal_tutup');
            $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beasiswas');
    }
};
