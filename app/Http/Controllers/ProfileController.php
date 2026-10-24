<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\MahasiswaProfile;

class ProfileController extends Controller
{
    // Menampilkan halaman profil
    public function index()
    {
        // Mengambil data user yang sedang login beserta relasi profilnya
        $user = Auth::user()->load('profil');
        
        return view('profil', compact('user'));
    }

    // Memproses pembaruan data profil
    public function update(Request $request)
    {
        $user = Auth::user();

        // 1. Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'npm' => 'required|string|max:20',
            'no_whatsapp' => 'required|string|max:20',
            'program_studi' => 'required|string|max:100',
            'fakultas' => 'required|string|max:100',
            'angkatan' => 'required|numeric',
        ]);

        // 2. Update tabel users (untuk nama)
        $user->update([
            'name' => $request->name,
        ]);

        // 3. Update tabel mahasiswa_profiles
        $user->profil()->update([
            'npm' => $request->npm,
            'no_whatsapp' => $request->no_whatsapp,
            'program_studi' => $request->program_studi,
            'fakultas' => $request->fakultas,
            'angkatan' => $request->angkatan,
        ]);

        return redirect('/profil')->with('success', 'Data profil berhasil diperbarui!');
    }
}