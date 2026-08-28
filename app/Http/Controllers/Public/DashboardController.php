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

class DashboardController extends Controller
{
    public function index()
    {
        // Load data lokal — cepat dan selalu tersedia
        $gangguan = Gangguan::with('fotos')->orderBy('created_at', 'desc')->get();
        $jalurPipa = JalurPipa::all();
        $bangunan = Bangunan::all();
        $titikPenting = TitikPenting::all();
        $zonaList = Zona::all();

        // ==================================================
        // AMBIL DATA PELANGGAN DARI API EKSTERNAL
        // ==================================================
        $cacheKey = 'data_pelanggan_pdam';

        // ✅ SELALU ambil cache lama DULU sebagai cadangan
        $dataCadangan = Cache::get($cacheKey, []);

        $pelanggan = Cache::remember($cacheKey, 300, function () use ($cacheKey, $dataCadangan) {
            try {
                // Timeout 2 detik — kalau API lambat, langsung pakai data lama
                $response = Http::withoutVerifying()
                    ->timeout(2)
                    ->get('https://pdamsumedang.com/portal/dashboard_api/pelanggan.php?of_id=04');

                if ($response->successful()) {
                    $baru = $response->json();
                    if (!empty($baru) && is_array($baru)) {
                        Log::info('Data pelanggan berhasil diperbarui dari API');
                        return $baru; // ✅ Ada data baru → simpan ke cache
                    }
                }
            } catch (\Exception $e) {
                Log::warning('API PDAM lambat/error: ' . $e->getMessage());
            }

            // ❌ API gagal / kosong → kembalikan data yang sudah ada sebelumnya
            return $dataCadangan ?: [];
        });

        // Pastikan $pelanggan selalu berupa array
        if (!is_array($pelanggan)) {
            $pelanggan = [];
        }

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