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

    // Admin Only Resources
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('lokasi', LokasiInspeksiController::class);
        Route::resource('kategori', KategoriInspeksiController::class);
        Route::resource('user', UserController::class);
    });

    // Master Data
    Route::get('master-data', [MasterDataController::class, 'index'])->name('master-data.index');
    Route::get('master-data/create', [MasterDataController::class, 'create'])->name('master-data.create')->middleware('role:admin');
    Route::post('master-data', [MasterDataController::class, 'store'])->name('master-data.store')->middleware('role:admin');
    Route::get('master-data/{id}', [MasterDataController::class, 'show'])->name('master-data.show');
    Route::get('master-data/{id}/edit', [MasterDataController::class, 'edit'])->name('master-data.edit')->middleware('role:admin');
    Route::put('master-data/{id}', [MasterDataController::class, 'update'])->name('master-data.update')->middleware('role:admin');
    Route::delete('master-data/{id}', [MasterDataController::class, 'destroy'])->name('master-data.destroy')->middleware('role:admin');

    // Inspeksi
    Route::get('inspeksi/export/pdf', [\App\Http\Controllers\ReportController::class, 'downloadFilteredPdf'])->name('inspeksi.pdf_filtered');
    Route::get('inspeksi/{id}/pdf', [\App\Http\Controllers\ReportController::class, 'downloadPdf'])->name('inspeksi.pdf');
    Route::get('inspeksi', [InspeksiController::class, 'index'])->name('inspeksi.index');

    // Inspection Write actions for admin and petugas only
    Route::middleware(['role:admin,petugas'])->group(function () {
        Route::get('inspeksi/create', [InspeksiController::class, 'create'])->name('inspeksi.create');
        Route::post('inspeksi/start', [InspeksiController::class, 'start'])->name('inspeksi.start');
        Route::get('inspeksi/category/{kategori_id}', [InspeksiController::class, 'categoryForm'])->name('inspeksi.category');
        Route::post('inspeksi/category/{kategori_id}', [InspeksiController::class, 'saveCategory'])->name('inspeksi.save_category');
        Route::post('inspeksi/finish', [InspeksiController::class, 'finish'])->name('inspeksi.finish');
        Route::post('inspeksi', [InspeksiController::class, 'store'])->name('inspeksi.store');
        Route::get('inspeksi/{id}/edit', [InspeksiController::class, 'edit'])->name('inspeksi.edit');
        Route::put('inspeksi/{id}', [InspeksiController::class, 'update'])->name('inspeksi.update');
        Route::delete('inspeksi/{id}', [InspeksiController::class, 'destroy'])->name('inspeksi.destroy');
    });
    Route::get('inspeksi/{id}', [InspeksiController::class, 'show'])->name('inspeksi.show');

    // Maintenance
    Route::get('/maintenance', [App\Http\Controllers\MaintenanceController::class, 'index'])->name('maintenance.index');
    Route::post('/maintenance/{id}/repair', [App\Http\Controllers\MaintenanceController::class, 'repair'])->name('maintenance.repair')->middleware('role:admin,petugas');

    // Profile Management
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

