<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LandingController;

// Landing Page
Route::get('/', function () {
    return view('landingpage');
});

// Autentikasi (Hanya bisa diakses tamu / belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', function () { return view('login'); })->name('login');
    Route::get('/daftar', function () { return view('daftar'); });
    Route::post('/login', [AuthController::class, 'loginPost']);
    Route::post('/daftar', [AuthController::class, 'registerPost']);
    Route::get('/cek-status', [LandingController::class, 'cekStatus']);
    Route::get('/kategori', [LandingController::class, 'kategoriIndex']);
    Route::get('/kategori/{tipe}', [LandingController::class, 'kategoriDetail']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Halaman Mahasiswa (Hanya bisa diakses jika SUDAH login)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    
    // Rute Pengajuan Sidang
    Route::get('/pengajuan', [PengajuanController::class, 'index']);
    Route::post('/pengajuan/store', [PengajuanController::class, 'store']); // Rute POST untuk submit form
    
    // Rute Status Pengajuan (Ditambahkan {id?} agar bisa melihat detail spesifik)
    Route::get('/statuspengajuan/{id?}', [PengajuanController::class, 'status']);
    
    // Rute Profil
    Route::get('/profil', [ProfileController::class, 'index']);
    Route::post('/profil/update', [ProfileController::class, 'update']);
    
    // Rute Revisi Dokumen (Jika mahasiswa diminta perbaikan)
    Route::post('/dokumen/{id}/revisi', [PengajuanController::class, 'revisi']);
    // Rute untuk menangani unggah ulang dokumen revisi oleh mahasiswa
    Route::post('/dokumen/{id}/revisi', [App\Http\Controllers\PengajuanController::class, 'uploadRevisi']);
    // Rute untuk melihat PDF mahasiswa
    Route::get('/dokumen/{id}/lihat', [App\Http\Controllers\PengajuanController::class, 'lihatDokumen']);
});

// ==========================================
// RUTE ADMIN / STAF PRODI
// ==========================================
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/pengajuan/{id}', [AdminController::class, 'detail']);
    Route::post('/dokumen/{id}/update', [AdminController::class, 'updateDokumen']);
    Route::post('/pengajuan/{id}/update', [AdminController::class, 'updateStatusPengajuan']);
    Route::post('/pengaturan/toggle-pendaftaran', [AdminController::class, 'togglePendaftaran']);
    Route::get('/dokumen/{id}/lihat', [AdminController::class, 'lihatDokumen']);
});