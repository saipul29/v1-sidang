<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Mengubah tipe data ENUM menjadi VARCHAR agar bisa menerima teks status apapun
        DB::statement("ALTER TABLE dokumen_pengajuans MODIFY COLUMN status_dokumen VARCHAR(50) DEFAULT 'menunggu'");
        DB::statement("ALTER TABLE pengajuans MODIFY COLUMN status_pengajuan VARCHAR(50) DEFAULT 'menunggu'");
    }

    public function down(): void
    {
        // 
    }
};