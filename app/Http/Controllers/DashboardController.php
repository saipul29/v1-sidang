<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengajuan;
use App\Models\DokumenPengajuan;
use App\Models\PengaturanSistem;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load('profil');

        // 1. Hitung Statistik Pengajuan Mahasiswa
        $totalPengajuan = Pengajuan::where('user_id', $user->id)->count();
        $menunggu = Pengajuan::where('user_id', $user->id)->where('status_pengajuan', 'menunggu')->count();
        $perbaikan = Pengajuan::where('user_id', $user->id)->where('status_pengajuan', 'perbaikan')->count();
        $selesai = Pengajuan::where('user_id', $user->id)->whereIn('status_pengajuan', ['disetujui', 'selesai'])->count();

        // 2. Ambil 5 Pengajuan Terbaru
        $pengajuans = Pengajuan::where('user_id', $user->id)->latest()->take(5)->get();

        // 3. Ambil Dokumen yang Memiliki Catatan Perbaikan
        $dokumenPerbaikan = DokumenPengajuan::whereHas('pengajuan', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('status_dokumen', 'perbaikan')->get();

        // 4. Cek Status Pendaftaran dari Tabel Pengaturan Sistem
        $statusPendaftaran = PengaturanSistem::where('key', 'status_pendaftaran')->value('value') ?? 'buka';

        return view('dashboard', compact(
            'user', 
            'totalPengajuan', 
            'menunggu', 
            'perbaikan', 
            'selesai', 
            'pengajuans', 
            'dokumenPerbaikan',
            'statusPendaftaran'
        ));
    }
}