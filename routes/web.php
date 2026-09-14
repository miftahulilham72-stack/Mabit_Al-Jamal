<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PanitiaController;
use App\Http\Controllers\SesiPanitiaController;
use App\Http\Controllers\AbsensiPanitiaController;
use Illuminate\Support\Facades\Route;

// ================================================================
// GUEST ROUTES (Belum Login)
// ================================================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ================================================================
// KIOSK ROUTES (Bisa diakses tanpa login - untuk panitia)
// ================================================================
Route::get('/absensi/kiosk', [AbsensiPanitiaController::class, 'kiosk'])->name('absensi.kiosk');
Route::post('/absensi/kiosk/store', [AbsensiPanitiaController::class, 'kioskStore'])->name('absensi.kiosk.store');
Route::get('/absensi/counter', [AbsensiPanitiaController::class, 'counter'])->name('absensi.counter');
Route::get('/panitia/cari/{id_panitia}', [PanitiaController::class, 'cari'])->name('panitia.cari');

// ================================================================
// ADMIN ROUTES (Harus Login)
// ================================================================
Route::middleware(['auth', 'admin'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/', fn() => redirect('/dashboard'));
    
    // ===== PANITIA ROUTES =====
    Route::get('/panitia', [PanitiaController::class, 'index'])->name('panitia.index');
    Route::post('/panitia', [PanitiaController::class, 'store'])->name('panitia.store');
    Route::get('/panitia/{id}/edit', [PanitiaController::class, 'edit'])->name('panitia.edit');
    Route::put('/panitia/{id}', [PanitiaController::class, 'update'])->name('panitia.update');
    Route::delete('/panitia/{id}', [PanitiaController::class, 'destroy'])->name('panitia.destroy');
    Route::post('/panitia/{id}/toggle-active', [PanitiaController::class, 'toggleActive'])->name('panitia.toggle');
    
    // ===== SESI ROUTES =====
    Route::get('/sesi', [SesiPanitiaController::class, 'index'])->name('sesi.index');
    Route::post('/sesi', [SesiPanitiaController::class, 'store'])->name('sesi.store');
    Route::put('/sesi/{id}', [SesiPanitiaController::class, 'update'])->name('sesi.update');
    Route::delete('/sesi/{id}', [SesiPanitiaController::class, 'destroy'])->name('sesi.destroy');
    Route::post('/sesi/{id}/toggle-active', [SesiPanitiaController::class, 'toggleActive'])->name('sesi.toggle');
    
    // ===== ABSENSI ROUTES =====
    Route::get('/absensi/log', [AbsensiPanitiaController::class, 'log'])->name('absensi.log');
    Route::get('/absensi/manual', [AbsensiPanitiaController::class, 'manual'])->name('absensi.manual');
    Route::post('/absensi/manual-store', [AbsensiPanitiaController::class, 'manualStore'])->name('absensi.manual.store');
    
    // ===== EXPORT =====
    Route::get('/absensi/export-excel', [AbsensiPanitiaController::class, 'exportExcel'])->name('absensi.export.excel');
    Route::get('/absensi/export-pdf', [AbsensiPanitiaController::class, 'exportPdf'])->name('absensi.export.pdf');
});