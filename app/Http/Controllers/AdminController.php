<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengajuan;
use App\Models\DokumenPengajuan;
use App\Models\RiwayatPengajuan;
use App\Models\PengaturanSistem;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller implements HasMiddleware
{
    // Pengecekan keamanan (Cara baru Laravel 11)
    public static function middleware(): array
    {
        return [
            new Middleware(function ($request, $next) {
                if (Auth::user()->role !== 'admin') {
                    abort(403, 'Akses Ditolak. Anda bukan Admin.');
                }
                return $next($request);
            }),
        ];
    }

    // Menampilkan Dasbor Admin (Rekap & Tabel Antrean)
    public function dashboard()
    {
        // Menghitung statistik
        $stats = [
            'total' => Pengajuan::count(),
            'menunggu' => Pengajuan::where('status_pengajuan', 'menunggu')->count(),
            'proses' => Pengajuan::where('status_pengajuan', 'proses')->count(),
            'selesai' => Pengajuan::whereIn('status_pengajuan', ['disetujui', 'selesai'])->count(),
        ];

        // Mengambil semua data pengajuan beserta nama mahasiswa
        $pengajuans = Pengajuan::with('user.profil')->latest()->get();

        return view('admin.dashboard', compact('stats', 'pengajuans'));
    }

    // Menampilkan Detail Pengajuan Mahasiswa untuk Diverifikasi
    public function detail($id)
    {
        $pengajuan = Pengajuan::with(['user.profil', 'dokumen', 'riwayat'])->findOrFail($id);

        // Ubah status otomatis dari 'menunggu' menjadi 'proses' saat admin membuka detailnya
        if ($pengajuan->status_pengajuan === 'menunggu') {
            $pengajuan->update(['status_pengajuan' => 'proses']);
            
            RiwayatPengajuan::create([
                'pengajuan_id' => $pengajuan->id,
                'user_id' => Auth::id(),
                'aksi' => 'Pemeriksaan Dimulai',
                'deskripsi' => 'Petugas sedang memeriksa berkas pengajuan Anda.',
            ]);
        }

        return view('admin.detail', compact('pengajuan'));
    }

    // Menyimpan catatan perbaikan pada satu dokumen tertentu
    public function updateDokumen(Request $request, $id)
    {
        $dokumen = DokumenPengajuan::findOrFail($id);
        
        $request->validate([
            'status_dokumen' => 'required|in:lengkap,perlu_perbaikan',
            'catatan_perbaikan' => 'nullable|string'
        ]);

        $dokumen->update([
            'status_dokumen' => $request->status_dokumen,
            'catatan_perbaikan' => $request->status_dokumen === 'perlu_perbaikan' ? $request->catatan_perbaikan : null
        ]);

        return back()->with('success', 'Status dokumen berhasil diperbarui.');
    }

    // Mengubah status akhir pengajuan
    public function updateStatusPengajuan(Request $request, $id)
    {
        $pengajuan = Pengajuan::findOrFail($id);

        $request->validate([
            'status_pengajuan' => 'required|in:perlu_perbaikan,disetujui',
            'deskripsi_riwayat' => 'required|string'
        ]);

        // CEGAT DISINI: 
        // Jika form mengirim 'disetujui', simpan sebagai 'selesai'
        // Jika form mengirim 'perlu_perbaikan', simpan ke tabel pengajuans sebagai 'perbaikan'
        $statusDatabase = $request->status_pengajuan === 'disetujui' ? 'selesai' : 'perbaikan';

        $pengajuan->update([
            'status_pengajuan' => $statusDatabase
        ]);

        // Catat di riwayat
        RiwayatPengajuan::create([
            'pengajuan_id' => $pengajuan->id,
            'user_id' => Auth::id(),
            'aksi' => $request->status_pengajuan === 'disetujui' ? 'Pengajuan Disetujui' : 'Butuh Perbaikan',
            'deskripsi' => $request->deskripsi_riwayat,
        ]);

        return redirect('/admin/dashboard')->with('success', 'Status pengajuan mahasiswa berhasil diselesaikan.');
    }
    
    // Mengubah status buka/tutup pendaftaran
    public function togglePendaftaran()
    {
        $pengaturan = PengaturanSistem::firstOrCreate(
            ['key' => 'status_pendaftaran'],
            ['value' => 'buka']
        );

        $pengaturan->update([
            'value' => $pengaturan->value === 'buka' ? 'tutup' : 'buka'
        ]);

        return back()->with('success', 'Status pendaftaran sidang berhasil diubah!');
    }

    // Menampilkan file PDF langsung di browser
    public function lihatDokumen($id)
    {
        $dok = DokumenPengajuan::findOrFail($id);
        
        if (!Storage::exists($dok->file_path)) {
            abort(404, 'File PDF tidak ditemukan di server.');
        }

        // Menampilkan file ke browser secara aman
        return Storage::response($dok->file_path);
    }
}