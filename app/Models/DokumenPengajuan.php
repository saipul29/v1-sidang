<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenPengajuan extends Model
{
    protected $fillable = [
        'pengajuan_id',
        'jenis_dokumen',
        'file_path',
        'status_dokumen',
        'catatan_perbaikan'
    ];

    // Relasi balik ke data pengajuan
    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class);
    }
}