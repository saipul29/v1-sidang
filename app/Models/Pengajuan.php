<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    protected $fillable = [
        'user_id',
        'nomor_pengajuan',
        'jalur',
        'dosen_pembimbing_pi',
        'paket_sidang',
        'materi_id',
        'status_pengajuan',
        'kategori_hasil'
    ];

    // Relasi balik ke mahasiswa yang mengajukan
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi 1-to-Many ke dokumen berkas
    public function dokumen()
    {
        return $this->hasMany(DokumenPengajuan::class);
    }

    // Relasi 1-to-Many ke riwayat/log proses
    public function riwayat()
    {
        return $this->hasMany(RiwayatPengajuan::class);
    }
}