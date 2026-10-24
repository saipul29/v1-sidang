<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;

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