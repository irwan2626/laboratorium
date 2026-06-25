<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KerusakanController;
use App\Http\Controllers\KepalaLabController;
use App\Http\Controllers\LaboratoriumController;
use App\Http\Controllers\PeralatanController;
use App\Http\Controllers\KategoriKerusakanController;

Route::get('/', [HomeController::class, 'index']);

Route::get('/dashboard', [DashboardController::class, 'redirectByRole'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');

    Route::get('/admin/laboratorium', [LaboratoriumController::class, 'index'])->name('admin.laboratorium.index');
    Route::get('/admin/peralatan', [PeralatanController::class, 'index'])->name('admin.peralatan.index');
    Route::get('/admin/kategori-kerusakan', [KategoriKerusakanController::class, 'index'])->name('admin.kategori-kerusakan.index');
    Route::get('/admin/laporan', [KerusakanController::class, 'laporan'])->name('admin.laporan.index');
    Route::resource('users', UserController::class);
});

Route::middleware(['auth', 'role:asisten'])->group(function () {
    Route::get('/asisten/dashboard', [KerusakanController::class, 'dashboard'])->name('asisten.dashboard');
    Route::get('/scan', [KerusakanController::class, 'scan']);
    Route::get('/kerusakan/create/{kode}', [KerusakanController::class, 'create']);
    Route::post('/kerusakan/store', [KerusakanController::class, 'store']);
    Route::get('/kerusakan/{kerusakan}/edit', [KerusakanController::class, 'edit']);
    Route::put('/kerusakan/{kerusakan}', [KerusakanController::class, 'update']);
    Route::delete('/kerusakan/{kerusakan}', [KerusakanController::class, 'destroy']);
    Route::get('/data-kerusakan', [KerusakanController::class, 'dataKerusakan']);
});

Route::middleware(['auth', 'role:kepala_lab'])->group(function () {
    Route::get('/kepala_lab/dashboard', [KepalaLabController::class, 'dashboard'])->name('kepala_lab.dashboard');
    Route::get('/kepala_lab/laporan/export-excel', [KepalaLabController::class, 'exportExcel'])->name('kepala_lab.laporan.excel');
    Route::get('/kepala_lab/laporan/export-pdf', [KepalaLabController::class, 'exportPdf'])->name('kepala_lab.laporan.pdf');
});

require __DIR__.'/auth.php';
