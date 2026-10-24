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
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->string('dosen_pembimbing_pi')->nullable()->after('dosen_pembimbing_2');
            $table->string('materi_komprehensif')->nullable()->after('dosen_pembimbing_pi');
            
            // Buat kolom skripsi menjadi nullable (karena anak kompre tidak mengisinya)
            $table->string('judul_skripsi')->nullable()->change();
            $table->string('dosen_pembimbing_1')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            //
        });
    }
};
