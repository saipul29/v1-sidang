<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Wajib ditambahkan untuk memproses file
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

        // 1. Validasi Dasar dan File
        $rules = [
            'jalur' => 'required|in:reguler,transfer',
            'paket_sidang' => 'required|in:skripsi,komprehensif',
            'file_krs' => 'required|mimes:pdf|max:2048',
            'file_workshop' => 'required|mimes:pdf|max:2048',
            'file_kursus' => 'required|mimes:pdf|max:2048',
            'file_tambahan' => 'required|mimes:pdf|max:5120',
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

        // 3. Proses Unggah File PDF (Disimpan di folder public/dokumen agar bisa dipreview)
        $daftarBerkas = [
            'krs' => $request->file('file_krs'),
            'workshop' => $request->file('file_workshop'),
            'kursus' => $request->file('file_kursus'),
            'berkas_tambahan' => $request->file('file_tambahan'),
        ];

        foreach ($daftarBerkas as $jenis => $file) {
            if ($file) {
                $filename = time() . '_' . $jenis . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('public/dokumen', $filename);

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

    // Menampilkan halaman daftar status & detail pengajuan (Dengan Filter & Search)
    public function status(Request $request, $id = null)
    {
        $user = Auth::user();

        // Tampilan Detail
        if ($id) {
            $pengajuanAktif = Pengajuan::where('user_id', $user->id)
                                       ->with(['dokumen', 'riwayat.user'])
                                       ->findOrFail($id);
            return view('statuspengajuan', compact('pengajuanAktif'));
        }

        // Tampilan Daftar (Menangkap query pencarian dan dropdown)
        $query = Pengajuan::where('user_id', $user->id);

        if ($request->filled('search')) {
            $query->where('nomor_pengajuan', 'like', "%{$request->search}%");
        }

        if ($request->filled('status')) {
            $query->where('status_pengajuan', $request->status);
        }

        $pengajuans = $query->latest()->get();

        return view('statuspengajuan', compact('pengajuans'));
    }

    // Memproses unggah ulang dokumen yang direvisi (Gabungan logika revisi)
    public function uploadRevisi(Request $request, $id)
    {
        // Validasi file yang diunggah harus PDF dan maksimal 2MB
        $request->validate([
            'file_revisi' => 'required|mimes:pdf|max:2048'
        ], [
            'file_revisi.required' => 'Harap pilih file PDF terlebih dahulu.',
            'file_revisi.mimes' => 'File harus berformat PDF.',
            'file_revisi.max' => 'Ukuran file maksimal 2MB.'
        ]);

        $dokumen = DokumenPengajuan::findOrFail($id);

        // Keamanan: Pastikan dokumen ini milik mahasiswa yang sedang login
        if ($dokumen->pengajuan->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        if ($request->hasFile('file_revisi')) {
            // Hapus file lama di server agar tidak menumpuk
            if (Storage::exists($dokumen->file_path)) {
                Storage::delete($dokumen->file_path);
            }

            // Simpan file PDF yang baru
            $file = $request->file('file_revisi');
            $filename = time() . '_revisi_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/dokumen', $filename);

            // Update database: Ubah status dokumen kembali ke 'menunggu'
            $dokumen->update([
                'file_path' => $path,
                'status_dokumen' => 'menunggu', 
                'catatan_perbaikan' => null // Kosongkan catatan karena sudah diperbaiki
            ]);

            // Catat di Riwayat agar Admin tahu mahasiswa sudah revisi individual
            RiwayatPengajuan::create([
                'pengajuan_id' => $dokumen->pengajuan_id,
                'user_id' => Auth::id(),
                'aksi' => 'Revisi Dokumen: ' . ucwords(str_replace('_', ' ', $dokumen->jenis_dokumen)),
                'deskripsi' => 'Mahasiswa telah mengunggah ulang dokumen. Menunggu verifikasi ulang.',
            ]);

            // Mengecek apakah semua dokumen yang perlu diperbaiki sudah diunggah ulang
            $pengajuan = $dokumen->pengajuan;
            $masihAdaPerbaikan = $pengajuan->dokumen()->whereIn('status_dokumen', ['perlu_perbaikan', 'perbaikan'])->exists();

            if (!$masihAdaPerbaikan && $pengajuan->status_pengajuan == 'perbaikan') {
                $pengajuan->update(['status_pengajuan' => 'proses']);
                
                RiwayatPengajuan::create([
                    'pengajuan_id' => $pengajuan->id,
                    'user_id' => Auth::id(),
                    'aksi' => 'Seluruh Revisi Selesai',
                    'deskripsi' => 'Mahasiswa telah mengunggah ulang seluruh dokumen yang memerlukan perbaikan. Status kembali diproses.',
                ]);
            }
        }

        return back()->with('success', 'Dokumen revisi berhasil diunggah! Silakan tunggu admin memverifikasi ulang.');
    }

    // Menampilkan PDF tanpa error 403
    public function lihatDokumen($id)
    {
        $dokumen = DokumenPengajuan::findOrFail($id);

        // Keamanan tambahan: Pastikan dokumen ini milik mahasiswa yang sedang login
        if ($dokumen->pengajuan->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin melihat dokumen ini.');
        }

        if (!Storage::exists($dokumen->file_path)) {
            abort(404, 'File PDF tidak ditemukan di server.');
        }

        return Storage::response($dokumen->file_path);
    }
}