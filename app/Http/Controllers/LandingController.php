<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;

class LandingController extends Controller
{
    // Menangani Pencarian Global (Search Bar utama)
    public function cekStatus(Request $request)
    {
        $search = $request->input('search');
        
        $query = Pengajuan::with(['user.profil'])->whereNotNull('kategori_hasil');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                })->orWhereHas('user.profil', function($q2) use ($search) {
                    $q2->where('npm', 'like', "%{$search}%");
                });
            });
        }

        $pengajuans = $query->latest()->get();

        return view('hasil-pencarian', compact('pengajuans', 'search'));
    }

    // Menampilkan 3 Kartu Kategori
    public function kategoriIndex()
    {
        return view('kategori');
    }

    // Menampilkan Tabel Spesifik per Kategori
    public function kategoriDetail(Request $request, $tipe)
    {
        $search = $request->input('search');
        
        // Memetakan Tipe Kategori ke value database (1, 2a, 2b, 3)
        $kategoriValues = [];
        $kategoriTitle = '';
        $kategoriDesc = '';

        if ($tipe == '1') {
            $kategoriValues = ['1']; // Berkas Lengkap
            $kategoriTitle = 'Berkas lengkap';
            $kategoriDesc = 'Mahasiswa sudah berhasil melengkapi berkas.';
        } elseif ($tipe == '2') {
            $kategoriValues = ['2a', '3']; // Kendala Berkas & Pembayaran
            $kategoriTitle = 'Berkas salah / pembayaran kurang';
            $kategoriDesc = 'Berkas atau pembayaran perlu dilengkapi.';
        } elseif ($tipe == '3') {
            $kategoriValues = ['2b']; // Kendala Nilai
            $kategoriTitle = 'Menunggu nilai (perbaiki nilai)';
            $kategoriDesc = 'Nilai belum tersedia atau perlu diperbaiki.';
        } else {
            abort(404);
        }

        $query = Pengajuan::with(['user.profil'])->whereIn('kategori_hasil', $kategoriValues);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                })->orWhereHas('user.profil', function($q2) use ($search) {
                    $q2->where('npm', 'like', "%{$search}%");
                });
            });
        }

        $pengajuans = $query->latest()->get();

        return view('hasil-pencarian', compact('pengajuans', 'search', 'kategoriTitle', 'kategoriDesc', 'tipe'));
    }
}