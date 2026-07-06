<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\GangguanController;
use App\Http\Controllers\Public\DashboardController;
use App\Http\Controllers\Admin\DrawingController;

// ============================================
// API ROUTES (TANPA PREFIX ADMIN)
// ============================================
Route::prefix('api')->group(function () {
    Route::get('/pelanggan/realtime', function () {
        try {
            $response = Http::timeout(10)->get('https://pdamsumedang.com/portal/dashboard_api/pelanggan.php', [
                'of_id' => 4
            ]);

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'pelanggan' => $response->json(),
                    'timestamp' => now()
                ]);
            }

            return response()->json(['success' => false, 'message' => 'Gagal mengambil data'], 500);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    });
});

// ============================================
// PUBLIC ROUTES
// ============================================
Route::get('/', [DashboardController::class, 'index'])->name('public.dashboard');
Route::get('/laporan/{kode}', [DashboardController::class, 'detail'])->name('public.detail');

// ============================================
// ADMIN ROUTES (DENGAN PREFIX ADMIN)
// ============================================
Route::prefix('admin')->name('admin.')->group(function () {
    
    // Gangguan routes
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
Route::post('/drawing/zona', [DrawingController::class, 'saveZona'])->name('drawing.zona'); // BARU
Route::delete('/drawing/jalur/{id}', [DrawingController::class, 'deleteJalur'])->name('drawing.jalur.delete');
Route::delete('/drawing/bangunan/{id}', [DrawingController::class, 'deleteBangunan'])->name('drawing.bangunan.delete');
Route::delete('/drawing/titik/{id}', [DrawingController::class, 'deleteTitik'])->name('drawing.titik.delete');
Route::delete('/drawing/zona/{id}', [DrawingController::class, 'deleteZona'])->name('drawing.zona.delete'); // BARU
    
});