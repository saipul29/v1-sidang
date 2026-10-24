<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatPengajuan extends Model
{
    protected $fillable = [
        'pengajuan_id',
        'user_id',
        'aksi',
        'deskripsi'
    ];

    // Relasi balik ke data pengajuan
    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class);
    }

    // Relasi ke user (siapa yang melakukan aksi ini: admin/mahasiswa)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}