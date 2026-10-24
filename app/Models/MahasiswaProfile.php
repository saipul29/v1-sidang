<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MahasiswaProfile extends Model
{
    // Mendaftarkan kolom yang diizinkan untuk diisi
    protected $fillable = [
        'user_id',
        'npm',
        'no_whatsapp',
        'program_studi',
        'fakultas',
        'angkatan'
    ];

    // Relasi balik ke tabel users
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}