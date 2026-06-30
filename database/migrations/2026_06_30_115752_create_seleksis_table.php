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
        Schema::create('seleksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->constrained()->cascadeOnDelete();
            $table->foreignId('penilai_id')->constrained('users')->cascadeOnDelete();
            $table->integer('nilai_berkas')->default(0);
            $table->integer('nilai_wawancara')->default(0);
            $table->integer('nilai_prestasi')->default(0);
            $table->decimal('skor_akhir', 5, 2)->default(0);
            $table->text('catatan')->nullable();
            $table->enum('rekomendasi', ['Ya', 'Tidak']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seleksis');
    }
};
