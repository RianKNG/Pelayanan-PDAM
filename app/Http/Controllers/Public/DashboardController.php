<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Gangguan;
use App\Models\JalurPipa;
use App\Models\Bangunan;
use App\Models\TitikPenting;
use App\Models\Zona;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB; // <-- Ditambahkan untuk menyegarkan koneksi DB

class DashboardController extends Controller
{
    public function index()
    {
        // ==================================================
        // 1. AMBIL DATA PELANGGAN DARI API EKSTERNAL DULUAN
        // Lakukan ini SEBELUM melakukan query DB agar koneksi DB tidak idle
        // ==================================================
        $cacheKey = 'data_pelanggan_pdam';
        $dataCadangan = Cache::get($cacheKey, []);

        $pelanggan = Cache::remember($cacheKey, 300, function () use ($dataCadangan) {
            try {
                $response = Http::withoutVerifying()
                    ->timeout(2)
                    ->get('https://pdamsumedang.com/portal/dashboard_api/pelanggan.php?of_id=04');

                if ($response->successful()) {
                    $baru = $response->json();
                    if (!empty($baru) && is_array($baru)) {
                        Log::info('Data pelanggan berhasil diperbarui dari API');
                        return $baru;
                    }
                }
            } catch (\Exception $e) {
                Log::warning('API PDAM lambat/error: ' . $e->getMessage());
            }

            return $dataCadangan ?: [];
        });

        if (!is_array($pelanggan)) {
            $pelanggan = [];
        }

        // ==================================================
        // 2. RECONNECT DATABASE (PENCEGAH ERROR HAS GONE AWAY)
        // ==================================================
        DB::reconnect();

        // ==================================================
        // 3. LOAD DATA LOKAL (BARU DIJALANKAN SETELAH API SELESAI)
        // ==================================================
        $gangguan = Gangguan::with('fotos')->orderBy('created_at', 'desc')->get();
        $jalurPipa = JalurPipa::all();
        $bangunan = Bangunan::all();
        $titikPenting = TitikPenting::all();
        $zonaList = Zona::all();

        // Hitung statistik
        $stats = [
            'total' => $gangguan->count(),
            'menunggu' => $gangguan->where('status', 'menunggu')->count(),
            'dalam_proses' => $gangguan->where('status', 'dalam_proses')->count(),
            'selesai' => $gangguan->where('status', 'selesai')->count(),
            'total_jalur' => $jalurPipa->count(),
            'total_bangunan' => $bangunan->count(),
            'total_titik' => $titikPenting->count(),
            'total_zona' => $zonaList->count(),
            'total_pelanggan' => count($pelanggan),
        ];

        // Gangguan aktif untuk alert
        $gangguanAktif = $gangguan->where('status', '!=', 'selesai');

        // Foto Fallback & Format Data
        $gangguanFotosData = [];
        foreach ($gangguan as $g) {
            if ($g->fotos && $g->fotos->count() > 0) {
                $gangguanFotosData[$g->id] = $g->fotos->map(function ($foto) {
                    return [
                        'id' => $foto->id,
                        'url' => asset('storage/' . $foto->foto_path),
                        'urutan' => $foto->urutan,
                    ];
                })->toArray();
            } elseif (!empty($g->foto)) {
                $gangguanFotosData[$g->id] = [
                    [
                        'id' => 'main_' . $g->id,
                        'url' => asset('storage/' . $g->foto),
                        'urutan' => 0,
                    ]
                ];
            }
        }

        return view('public.dashboard', compact(
            'gangguan',
            'gangguanAktif',
            'jalurPipa',
            'bangunan',
            'titikPenting',
            'zonaList',
            'stats',
            'pelanggan',
            'gangguanFotosData'
        ));
    }
}