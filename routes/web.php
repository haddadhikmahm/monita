<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
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
    Route::post('inspeksi/start', [InspeksiController::class, 'start'])->name('inspeksi.start');
    Route::get('inspeksi/category/{kategori_id}', [InspeksiController::class, 'categoryForm'])->name('inspeksi.category');
    Route::post('inspeksi/category/{kategori_id}', [InspeksiController::class, 'saveCategory'])->name('inspeksi.save_category');
    Route::post('inspeksi/finish', [InspeksiController::class, 'finish'])->name('inspeksi.finish');
    Route::resource('inspeksi', InspeksiController::class);
    Route::get('inspeksi/{id}/pdf', [\App\Http\Controllers\ReportController::class, 'downloadPdf'])->name('inspeksi.pdf');

    // Maintenance
    Route::get('/maintenance', [App\Http\Controllers\MaintenanceController::class, 'index'])->name('maintenance.index');

    // Profile Management
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

