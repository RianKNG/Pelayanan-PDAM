<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\GangguanController;
use App\Http\Controllers\Public\DashboardController;
use App\Http\Controllers\Admin\DrawingController;

// ============================================
// 🔥 API ROUTES (TANPA PREFIX ADMIN)
// ============================================
Route::prefix('api')->group(function () {
    
    // 🔥 API PELANGGAN REALTIME (EXISTING)
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
    
    // 🔥 API CARI PELANGGAN (UNTUK AUTO-FILL FORM GANGGUAN)
    Route::get('/pelanggan/cari/{no_pelanggan}', function ($no_pelanggan) {
        try {
            $response = Http::timeout(10)->get('https://pdamsumedang.com/portal/dashboard_api/pelanggan.php', [
                'of_id' => 4
            ]);

            if ($response->successful()) {
                $pelangganList = $response->json();
                
                // Cari pelanggan berdasarkan no_pelanggan
                $pelanggan = collect($pelangganList)->first(function($p) use ($no_pelanggan) {
                    return ($p['no_pelanggan'] ?? '') === $no_pelanggan 
                        || ($p['no_rekening'] ?? '') === $no_pelanggan;
                });
                
                if ($pelanggan) {
                    return response()->json([
                        'success' => true,
                        'pelanggan' => [
                            'no_pelanggan' => $pelanggan['no_pelanggan'] ?? $pelanggan['no_rekening'] ?? '-',
                            'nama' => $pelanggan['nama'] ?? 'Tanpa Nama',
                            'alamat' => $pelanggan['alamat'] ?? '-',
                            'wilayah' => $pelanggan['nama_wilayah'] ?? $pelanggan['cabang'] ?? '-',
                            'no_hp' => $pelanggan['no_hp'] ?? null, // Jika ada di API
                            'kode_gol_trf' => $pelanggan['kode_gol_trf'] ?? '-',
                        ]
                    ]);
                }
                
                return response()->json([
                    'success' => false, 
                    'message' => 'Pelanggan tidak ditemukan'
                ], 404);
            }

            return response()->json(['success' => false, 'message' => 'Gagal mengambil data'], 500);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    });
    
    // 🔥 API GANGGUAN REALTIME (UNTUK DASHBOARD)
    Route::get('/gangguan/realtime', function () {
        try {
            $gangguan = \App\Models\Gangguan::with('fotos')
                ->where('status', '!=', 'selesai')
                ->latest()
                ->get()
                ->map(function($g) {
                    return [
                        'id' => $g->id,
                        'kode_laporan' => $g->kode_laporan,
                        'jenis_gangguan' => $g->jenis_gangguan,
                        'tipe_kerusakan' => $g->tipe_kerusakan,
                        'lokasi' => $g->lokasi,
                        'wilayah_terdampak' => $g->wilayah_terdampak,
                        'latitude' => $g->latitude,
                        'longitude' => $g->longitude,
                        'status' => $g->status,
                        'deskripsi' => $g->deskripsi,
                        'estimasi_selesai' => $g->estimasi_selesai,
                        'ukuran_pipa' => $g->ukuran_pipa,
                        'sumber_laporan' => $g->sumber_laporan,
                        // 🔥 ARRAY FOTO
                        'fotos' => $g->fotos->map(function($foto) {
                            return [
                                'id' => $foto->id,
                                'url' => asset('storage/' . $foto->foto_path),
                                'urutan' => $foto->urutan,
                            ];
                        })->toArray(),
                    ];
                });
            
            return response()->json([
                'success' => true,
                'gangguan' => $gangguan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => $e->getMessage()
            ], 500);
        }
    });
    
    // 🔥 API STATISTIK SUMBER LAPORAN (UNTUK DASHBOARD)
    Route::get('/gangguan/statistik', function () {
        try {
            $stats = [
                'total' => \App\Models\Gangguan::count(),
                'menunggu' => \App\Models\Gangguan::where('status', 'menunggu')->count(),
                'dalam_proses' => \App\Models\Gangguan::where('status', 'dalam_proses')->count(),
                'selesai' => \App\Models\Gangguan::where('status', 'selesai')->count(),
                'sumber_laporan' => [
                    'karyawan' => \App\Models\Gangguan::where('sumber_laporan', 'karyawan')->count(),
                    'pelanggan' => \App\Models\Gangguan::where('sumber_laporan', 'pelanggan')->count(),
                    'non_pelanggan' => \App\Models\Gangguan::where('sumber_laporan', 'non_pelanggan')->count(),
                ]
            ];
            
            return response()->json([
                'success' => true,
                'stats' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => $e->getMessage()
            ], 500);
        }
    });
});

// ============================================
// 🔥 PUBLIC ROUTES
// ============================================
Route::get('/', [DashboardController::class, 'index'])->name('public.dashboard');
Route::get('/laporan/{kode}', [DashboardController::class, 'detail'])->name('public.detail');

// ============================================
// 🔥 ADMIN ROUTES (DENGAN PREFIX ADMIN)
// ============================================
Route::prefix('admin')->name('admin.')->group(function () {
    
    // ============================================
    // 🔥 GANGGUAN ROUTES (LENGKAP DENGAN FOTO & SUMBER LAPORAN)
    // ============================================
    Route::get('/gangguan', [GangguanController::class, 'index'])->name('gangguan.index');
    Route::get('/gangguan/create', [GangguanController::class, 'create'])->name('gangguan.create');
    Route::post('/gangguan', [GangguanController::class, 'store'])->name('gangguan.store');
    Route::get('/gangguan/{gangguan}/edit', [GangguanController::class, 'edit'])->name('gangguan.edit');
    Route::put('/gangguan/{gangguan}', [GangguanController::class, 'update'])->name('gangguan.update');
    Route::delete('/gangguan/{gangguan}', [GangguanController::class, 'destroy'])->name('gangguan.destroy');
    
    // 🔥 ROUTE UNTUK HAPUS 1 FOTO SPESIFIK
    Route::delete('/gangguan-foto/{foto}', [GangguanController::class, 'destroyFoto'])
        ->name('gangguan.foto.destroy');
    
    // 🔥 ROUTE UNTUK REORDER FOTO (OPSIONAL)
    Route::post('/gangguan/{gangguan}/reorder-fotos', [GangguanController::class, 'reorderFotos'])
        ->name('gangguan.reorder-fotos');
    
    // ============================================
    // 🔥 DRAWING ROUTES
    // ============================================
    Route::get('/drawing', [DrawingController::class, 'index'])->name('drawing.index');
    Route::post('/drawing/jalur', [DrawingController::class, 'saveJalur'])->name('drawing.jalur');
    Route::post('/drawing/bangunan', [DrawingController::class, 'saveBangunan'])->name('drawing.bangunan');
    Route::post('/drawing/titik', [DrawingController::class, 'saveTitik'])->name('drawing.titik');
    Route::post('/drawing/zona', [DrawingController::class, 'saveZona'])->name('drawing.zona');
    Route::delete('/drawing/jalur/{id}', [DrawingController::class, 'deleteJalur'])->name('drawing.jalur.delete');
    Route::delete('/drawing/bangunan/{id}', [DrawingController::class, 'deleteBangunan'])->name('drawing.bangunan.delete');
    Route::delete('/drawing/titik/{id}', [DrawingController::class, 'deleteTitik'])->name('drawing.titik.delete');
    Route::delete('/drawing/zona/{id}', [DrawingController::class, 'deleteZona'])->name('drawing.zona.delete');
});