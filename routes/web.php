<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataInspeksiController;
use App\Http\Controllers\InspeksiController;
use App\Http\Controllers\KategoriInspeksiController;
use App\Http\Controllers\LokasiInspeksiController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Redirect welcome to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Master Data
    Route::resource('lokasi', LokasiInspeksiController::class);
    Route::resource('kategori', KategoriInspeksiController::class);
    Route::resource('master-data', MasterDataController::class);
    Route::resource('user', UserController::class);

    // Inspeksi
    Route::resource('inspeksi', InspeksiController::class);
    Route::get('inspeksi/{id}/pdf', [\App\Http\Controllers\ReportController::class, 'downloadPdf'])->name('inspeksi.pdf');
    Route::get('report/rekap', [\App\Http\Controllers\ReportController::class, 'rekap'])->name('report.rekap');
});
