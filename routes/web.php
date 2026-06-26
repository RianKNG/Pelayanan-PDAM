<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\GangguanController;
use App\Http\Controllers\Public\DashboardController;
use App\Http\Controllers\Admin\DrawingController;

// Public
Route::get('/', [DashboardController::class, 'index'])->name('public.dashboard');
Route::get('/laporan/{kode}', [DashboardController::class, 'detail'])->name('public.detail');

// Admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/gangguan', [GangguanController::class, 'index'])->name('gangguan.index');
    Route::get('/gangguan/create', [GangguanController::class, 'create'])->name('gangguan.create');
    Route::post('/gangguan', [GangguanController::class, 'store'])->name('gangguan.store');
    Route::get('/gangguan/{gangguan}/edit', [GangguanController::class, 'edit'])->name('gangguan.edit');
    Route::put('/gangguan/{gangguan}', [GangguanController::class, 'update'])->name('gangguan.update');
    Route::delete('/gangguan/{gangguan}', [GangguanController::class, 'destroy'])->name('gangguan.destroy');

     // Drawing routes
    Route::get('/drawing', [DrawingController::class, 'index'])->name('drawing.index');
    Route::post('/drawing/jalur', [DrawingController::class, 'saveJalur'])->name('drawing.jalur');
    Route::post('/drawing/bangunan', [DrawingController::class, 'saveBangunan'])->name('drawing.bangunan');
    Route::post('/drawing/titik', [DrawingController::class, 'saveTitik'])->name('drawing.titik');
    Route::delete('/drawing/jalur/{id}', [DrawingController::class, 'deleteJalur'])->name('drawing.jalur.delete');
    Route::delete('/drawing/bangunan/{id}', [DrawingController::class, 'deleteBangunan'])->name('drawing.bangunan.delete');
    Route::delete('/drawing/titik/{id}', [DrawingController::class, 'deleteTitik'])->name('drawing.titik.delete');

});