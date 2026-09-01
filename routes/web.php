<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\GangguanController;
use App\Http\Controllers\Public\DashboardController;
use App\Http\Controllers\Admin\DrawingController;
use App\Http\Controllers\Admin\EvaluasiController;
use App\Http\Controllers\Admin\GolonganMonitoringController;
use App\Http\Controllers\Admin\RekapController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Models\Gangguan;

Route::prefix('api')->group(function () {

    // Helper privat untuk mengambil data PDAM dengan penanganan Error & Cache
    $getPelangganData = function () {
        $cacheKey = 'data_pelanggan_pdam';

        $data = Cache::remember($cacheKey, 300, function () use ($cacheKey) {
            try {
                // Gunakan User-Agent & parameter '04' (bukan 4)
                $response = Http::withoutVerifying()
                    ->timeout(5)
                    ->withHeaders([
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                        'Accept' => 'application/json',
                    ])
                    ->get('https://pdamsumedang.com/portal/dashboard_api/pelanggan.php', [
                        'of_id' => '04' // Pakai string '04' jika sebelumnya bekerja dengan parameter ini
                    ]);

                if ($response->successful()) {
                    $json = $response->json();
                    if (!empty($json)) {
                        return $json;
                    }
                }
            } catch (\Exception $e) {
                Log::error('Gagal memanggil API PDAM: ' . $e->getMessage());
            }

            return null; // Kembalikan null jika gagal, agar cache TIDAK menyimpan array kosong
        });

        // Jika data null/kosong, hapus cache agar request berikutnya langsung mencoba nembak API lagi
        if (empty($data)) {
            Cache::forget($cacheKey);
            return [];
        }

        return $data;
    };

    // 1. API PELANGGAN REALTIME
    Route::get('/pelanggan/realtime', function () {
    $cacheKey = 'data_pelanggan_realtime_2s';

    // 1. Cek apakah ada data valid di Cache
    if (\Illuminate\Support\Facades\Cache::has($cacheKey)) {
        $pelanggan = \Illuminate\Support\Facades\Cache::get($cacheKey);
    } else {
        // 2. Jika tidak ada di Cache, baru panggil API eksternal
        try {
            $response = \Illuminate\Support\Facades\Http::withoutVerifying()
                ->timeout(3)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                    'Accept'     => 'application/json',
                ])
                ->get('https://pdamsumedang.com/portal/dashboard_api/pelanggan.php', [
                    'of_id' => '04'
                ]);

            if ($response->successful()) {
                $data = $response->json();

                if (!empty($data) && is_array($data)) {
                    $pelanggan = $data;
                    // HANYA simpan ke cache jika data TIDAK kosong
                    \Illuminate\Support\Facades\Cache::put($cacheKey, $pelanggan, 2);
                } else {
                    $pelanggan = [];
                }
            } else {
                $pelanggan = [];
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Realtime API Error: ' . $e->getMessage());
            $pelanggan = [];
        }
    }

    return response()->json([
        'success'   => true,
        'pelanggan' => $pelanggan,
        'count'     => count($pelanggan),
        'timestamp' => now()->toIso8601String()
    ]);
});

    // 2. API CARI PELANGGAN
    Route::get('/pelanggan/cari/{no_pelanggan}', function ($no_pelanggan) use ($getPelangganData) {
        $pelangganList = $getPelangganData();

        if (empty($pelangganList)) {
            return response()->json([
                'success' => false,
                'message' => 'Data API PDAM sedang tidak dapat diakses'
            ], 503);
        }

        $pelanggan = collect($pelangganList)->first(function ($p) use ($no_pelanggan) {
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
                    'no_hp' => $pelanggan['no_hp'] ?? null,
                    'kode_gol_trf' => $pelanggan['kode_gol_trf'] ?? '-',
                ]
            ]);
        }

        return response()->json([
            'success' => false, 
            'message' => 'Pelanggan tidak ditemukan'
        ], 404);
    });

    // API Gangguan Realtime & Statistik tetap seperti sebelumnya...
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


// Evaluasi Tagihan
Route::prefix('evaluasi')->name('evaluasi.')->group(function () {
    Route::get('/', [EvaluasiController::class, 'index'])->name('index');
    Route::post('/upload', [EvaluasiController::class, 'upload'])->name('upload');
    Route::get('/evaluasi', [EvaluasiController::class, 'evaluasi'])->name('evaluasi');
    Route::get('/cari', [EvaluasiController::class, 'cari'])->name('cari');
    Route::get('/cetak-pdf', [EvaluasiController::class, 'cetakPdf'])->name('cetakPdf');
});

// Monitoring Golongan
Route::prefix('golongan')->name('golongan.')->group(function () {
    Route::get('/', [GolonganMonitoringController::class, 'index'])->name('index');
    Route::get('/detail/{noSambungan}', [GolonganMonitoringController::class, 'detail'])->name('detail');
    Route::post('/catat-perubahan', [GolonganMonitoringController::class, 'catatPerubahan'])->name('catat');
    Route::get('/export-pdf', [GolonganMonitoringController::class, 'exportPdf'])->name('export');
});


// Tambahkan route ini


// Rekapitulasi Bulanan
// Route untuk Rekapitulasi
Route::prefix('rekap')->name('rekap.')->group(function () {
    Route::get('/', [RekapController::class, 'index'])->name('index');
    Route::post('/upload', [RekapController::class, 'upload'])->name('upload');
    Route::get('/bulanan', [RekapController::class, 'rekapBulanan'])->name('bulanan');
   // UBAH DARI:
// Route::post('/bulanan/proses', [RekapController::class, 'prosesRekap'])->name('bulanan.proses');

// MENJADI:
Route::match(['get', 'post'], '/bulanan/proses', [RekapController::class, 'prosesRekap'])->name('bulanan.proses');
    Route::get('/bulanan/pdf', [RekapController::class, 'downloadPdf'])->name('bulanan.pdf');
    Route::get('/tiga-bulan-nol', [RekapController::class, 'cariTigaBulanNol'])->name('tigaBulanNol');
    Route::get('/tiga-bulan-nol/pdf', [RekapController::class, 'downloadPdfTigaBulanNol'])->name('tigaBulanNol.pdf');
    
});