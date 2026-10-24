<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('nomor_pengajuan')->unique(); // Contoh: SPU-2026-0001
            $table->enum('jalur', ['reguler', 'transfer']);
            $table->string('dosen_pembimbing_pi')->nullable(); // Khusus transfer
            $table->enum('paket_sidang', ['skripsi', 'komprehensif']);
            $table->foreignId('materi_id')->nullable()->constrained('materi_komprehensif')->nullOnDelete();
            $table->enum('status_pengajuan', ['menunggu', 'proses', 'perbaikan', 'selesai'])->default('menunggu');
            $table->enum('kategori_hasil', ['1', '2a', '2b', '3'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuans');
    }
};
