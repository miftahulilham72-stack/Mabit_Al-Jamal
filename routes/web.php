<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PanitiaController;
use App\Http\Controllers\SesiPanitiaController;
use App\Http\Controllers\AbsensiPanitiaController;
use Illuminate\Support\Facades\Route;

// ================================================================
// GUEST ROUTES
// ================================================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ================================================================
// KIOSK ROUTES (Untuk Display Kiosk)
// ================================================================
Route::get('/kiosk', [AbsensiPanitiaController::class, 'kiosk'])->name('kiosk');
Route::get('/kiosk/counter', [AbsensiPanitiaController::class, 'counter'])->name('kiosk.counter');

// ================================================================
// FORM ABSENSI DARI HP PANITIA (Tanpa Login - via Token)
// ================================================================
Route::get('/absen/{token}', [AbsensiPanitiaController::class, 'formHP'])->name('absen.form');
Route::post('/absen/{token}/submit', [AbsensiPanitiaController::class, 'submitHP'])->name('absen.submit');
Route::get('/absen/cari/{id_panitia}', [AbsensiPanitiaController::class, 'cariPanitia'])->name('absen.cari');

// ================================================================
// ADMIN ROUTES (Harus Login)
// ================================================================
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/', fn() => redirect('/dashboard'));
    
    // Panitia
    Route::get('/panitia', [PanitiaController::class, 'index'])->name('panitia.index');
    Route::post('/panitia', [PanitiaController::class, 'store'])->name('panitia.store');
    Route::get('/panitia/{id}/edit', [PanitiaController::class, 'edit'])->name('panitia.edit');
    Route::put('/panitia/{id}', [PanitiaController::class, 'update'])->name('panitia.update');
    Route::delete('/panitia/{id}', [PanitiaController::class, 'destroy'])->name('panitia.destroy');
    Route::post('/panitia/{id}/toggle-active', [PanitiaController::class, 'toggleActive'])->name('panitia.toggle');
    Route::get('/panitia/cari/{id_panitia}', [PanitiaController::class, 'cari'])->name('panitia.cari');
    
    // Sesi
    Route::get('/sesi', [SesiPanitiaController::class, 'index'])->name('sesi.index');
    Route::post('/sesi', [SesiPanitiaController::class, 'store'])->name('sesi.store');
    Route::put('/sesi/{id}', [SesiPanitiaController::class, 'update'])->name('sesi.update');
    Route::delete('/sesi/{id}', [SesiPanitiaController::class, 'destroy'])->name('sesi.destroy');
    Route::post('/sesi/{id}/toggle-active', [SesiPanitiaController::class, 'toggleActive'])->name('sesi.toggle');
    Route::post('/sesi/{id}/hapus-dengan-password', [SesiPanitiaController::class, 'hapusDenganPassword'])->name('sesi.hapus.password');
    
    // Absensi
    Route::get('/absensi/log', [AbsensiPanitiaController::class, 'log'])->name('absensi.log');
    Route::get('/absensi/manual', [AbsensiPanitiaController::class, 'manual'])->name('absensi.manual');
    Route::post('/absensi/manual-store', [AbsensiPanitiaController::class, 'manualStore'])->name('absensi.manual.store');
    
    // Export
    Route::get('/absensi/export-excel', [AbsensiPanitiaController::class, 'exportExcel'])->name('absensi.export.excel');
    Route::get('/absensi/export-pdf', [AbsensiPanitiaController::class, 'exportPdf'])->name('absensi.export.pdf');
});