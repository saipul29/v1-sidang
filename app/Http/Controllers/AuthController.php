<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MahasiswaProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Memproses form pendaftaran
    public function registerPost(Request $request)
    {
        // 1. Validasi data dari form
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'no_whatsapp' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // 2. Simpan data ke tabel users
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'mahasiswa', // Set bawaan sebagai mahasiswa
        ]);

        // 3. Buat profil kosong untuk tabel mahasiswa_profiles
        MahasiswaProfile::create([
            'user_id' => $user->id,
            'npm' => '-', 
            'no_whatsapp' => $request->no_whatsapp,
            'program_studi' => '-',
            'fakultas' => '-',
            'angkatan' => date('Y'),
        ]);

        // 4. Langsung login-kan setelah daftar dan arahkan ke dashboard mahasiswa
        Auth::login($user);
        return redirect('/dashboard')->with('success', 'Pendaftaran akun berhasil! Selamat datang di Sistem Informasi Pengajuan Sidang.');
    }

    // Memproses form login
    public function loginPost(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Cek role setelah login berhasil
            if (Auth::user()->role === 'admin') {
                // Arahkan admin ke halaman dasbor admin
                return redirect()->intended('/admin/dashboard');
            }

            // Arahkan mahasiswa ke halaman dasbor mahasiswa
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ]);
    }

    // Memproses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}