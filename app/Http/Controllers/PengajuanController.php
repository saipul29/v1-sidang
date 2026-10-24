<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengajuan;
use App\Models\DokumenPengajuan;
use App\Models\RiwayatPengajuan;
use App\Models\PengaturanSistem;

class PengajuanController extends Controller
{
    // Menampilkan halaman form pengajuan
    public function index()
    {
        $user = Auth::user()->load('profil');

        // Cek apakah profil sudah dilengkapi (NPM tidak boleh strip)
        if ($user->profil->npm == '-') {
            return redirect('/profil')->with('error', 'Harap lengkapi data profil Anda terlebih dahulu sebelum melakukan pengajuan sidang.');
        }

        // Cek apakah sudah punya pengajuan yang aktif
        $pengajuanAktif = Pengajuan::where('user_id', $user->id)
                                   ->whereIn('status_pengajuan', ['menunggu', 'proses', 'perbaikan'])
                                   ->first();
                                   
        if ($pengajuanAktif) {
            return redirect('/statuspengajuan')->with('error', 'Anda masih memiliki pengajuan yang sedang berjalan.');
        }

        // Cek Status Pendaftaran untuk dikirim ke Form (UI)
        $statusPendaftaran = PengaturanSistem::where('key', 'status_pendaftaran')->value('value') ?? 'buka';

        // Ambil data materi komprehensif dari pengaturan_sistem
        $materiMentah = PengaturanSistem::where('key', 'materi_komprehensif')->value('value') 
                        ?? "Disain dan Manajemen Jaringan Komputer, Sistem Keamanan Teknologi Informasi, Sistem Operasi\nAnalisis dan Perancangan Sistem Informasi, Interaksi Manusia dan Komputer, Sistem Basis Data 2\nPemrograman Berorientasi Objek, Struktur dan Organisasi Data, Testing dan Implementasi Sistem";
        
        $opsiMateri = array_filter(explode("\n", str_replace("\r", "", $materiMentah)));

        return view('pengajuan', compact('statusPendaftaran', 'opsiMateri'));
    }

    // Memproses data formulir dan file PDF
    public function store(Request $request)
    {
        $statusPendaftaran = PengaturanSistem::where('key', 'status_pendaftaran')->value('value') ?? 'buka';
        if ($statusPendaftaran === 'tutup') {
            return back()->withErrors(['pendaftaran' => 'Pendaftaran sidang saat ini sedang ditutup. Anda tidak dapat mengirim pengajuan.']);
        }

        // 1. Validasi Dasar dan File (Sesuaikan dengan 4 input file baru)
        $rules = [
            'jalur' => 'required|in:reguler,transfer',
            'paket_sidang' => 'required|in:skripsi,komprehensif',
            'file_krs' => 'required|mimes:pdf|max:2048',
            'file_workshop' => 'required|mimes:pdf|max:2048',
            'file_kursus' => 'required|mimes:pdf|max:2048',
            'file_tambahan' => 'required|mimes:pdf|max:5120', // Max 5MB karena gabungan banyak dokumen
        ];

        // Validasi Dinamis: Jika Skripsi vs Jika Komprehensif
        if ($request->paket_sidang === 'skripsi') {
            $rules['judul_skripsi'] = 'required|string|max:255';
            $rules['dosen_pembimbing_1'] = 'required|string|max:255';
        } else {
            $rules['dosen_pembimbing_pi'] = 'required|string|max:255';
            $rules['materi_komprehensif'] = 'required|string';
        }

        $request->validate($rules);

        $user = Auth::user();

        // 2. Buat Data Transaksi Utama
        $tahun = date('Y');
        $urutan = Pengajuan::whereYear('created_at', $tahun)->count() + 1;
        $nomorPengajuan = 'SPU-' . $tahun . '-' . str_pad($urutan, 4, '0', STR_PAD_LEFT);

        $pengajuan = Pengajuan::create([
            'user_id' => $user->id,
            'nomor_pengajuan' => $nomorPengajuan,
            'jalur' => $request->jalur,
            'paket_sidang' => $request->paket_sidang,
            'judul_skripsi' => $request->judul_skripsi,
            'dosen_pembimbing_1' => $request->dosen_pembimbing_1,
            'dosen_pembimbing_2' => $request->dosen_pembimbing_2,
            'dosen_pembimbing_pi' => $request->dosen_pembimbing_pi,
            'materi_komprehensif' => $request->materi_komprehensif,
            'status_pengajuan' => 'menunggu',
        ]);

        // 3. Proses Unggah File PDF (Sesuaikan dengan nama input baru)
        $daftarBerkas = [
            'krs' => $request->file('file_krs'),
            'workshop' => $request->file('file_workshop'),
            'kursus' => $request->file('file_kursus'),
            'berkas_tambahan' => $request->file('file_tambahan'),
        ];

        foreach ($daftarBerkas as $jenis => $file) {
            if ($file) {
                $path = $file->store('dokumen_sidang');

                DokumenPengajuan::create([
                    'pengajuan_id' => $pengajuan->id,
                    'jenis_dokumen' => $jenis,
                    'file_path' => $path,
                    'status_dokumen' => 'menunggu',
                ]);
            }
        }

        // 4. Catat Jejak Riwayat
        RiwayatPengajuan::create([
            'pengajuan_id' => $pengajuan->id,
            'user_id' => $user->id,
            'aksi' => 'Pengajuan Dibuat',
            'deskripsi' => 'Mahasiswa berhasil mengirimkan formulir pendaftaran dan mengunggah berkas awal.',
        ]);

        return redirect('/statuspengajuan')->with('success', 'Pengajuan berhasil dikirim! Silakan pantau status pemeriksaan secara berkala.');
    }

    // Menampilkan halaman daftar status & detail pengajuan
    public function status($id = null)
    {
        $user = Auth::user();
        $pengajuans = Pengajuan::where('user_id', $user->id)->latest()->get();

        if ($id) {
            $pengajuanAktif = Pengajuan::where('user_id', $user->id)->with(['dokumen', 'riwayat.user'])->findOrFail($id);
        } else {
            $pengajuanAktif = Pengajuan::where('user_id', $user->id)->with(['dokumen', 'riwayat.user'])->latest()->first();
        }

        return view('statuspengajuan', compact('pengajuans', 'pengajuanAktif'));
    }

    // Memproses unggah ulang dokumen yang direvisi
    public function revisi(Request $request, $id)
    {
        $dokumen = DokumenPengajuan::findOrFail($id);

        if ($dokumen->pengajuan->user_id !== Auth::id()) {
            abort(403, 'Akses tidak diizinkan.');
        }

        $request->validate([
            'file_revisi' => 'required|mimes:pdf|max:2048'
        ]);

        $path = $request->file('file_revisi')->store('dokumen_sidang');

        $dokumen->update([
            'file_path' => $path,
            'status_dokumen' => 'menunggu',
            'catatan_perbaikan' => null
        ]);

        $pengajuan = $dokumen->pengajuan;
        $masihAdaPerbaikan = $pengajuan->dokumen()->where('status_dokumen', 'perlu_perbaikan')->exists();

        if (!$masihAdaPerbaikan) {
            $pengajuan->update(['status_pengajuan' => 'proses']);
            
            RiwayatPengajuan::create([
                'pengajuan_id' => $pengajuan->id,
                'user_id' => Auth::id(),
                'aksi' => 'Revisi Dikirim',
                'deskripsi' => 'Mahasiswa telah mengunggah ulang seluruh dokumen yang memerlukan perbaikan.',
            ]);
        }

        return back()->with('success', 'Dokumen revisi berhasil diunggah dan dikirim ke Admin!');
    }
}