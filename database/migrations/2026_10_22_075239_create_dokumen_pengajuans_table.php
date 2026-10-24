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
        Schema::create('dokumen_pengajuans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_id')->constrained('pengajuans')->cascadeOnDelete();
            $table->string('jenis_dokumen'); // krs, sertifikat_kursus, sertifikat_workshop, manual_book
            $table->string('file_path'); // Alamat fisik file pdf di folder storage
            $table->enum('status_dokumen', ['menunggu', 'lengkap', 'perlu_perbaikan'])->default('menunggu');
            $table->text('catatan_perbaikan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_pengajuans');
    }
};
