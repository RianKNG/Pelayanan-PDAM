<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Gangguan;
use App\Models\JalurPipa;
use App\Models\Bangunan;
use App\Models\TitikPenting;
use App\Models\Zona;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
        public function index()
    {
        // 🔥 PENTING: Load data gangguan beserta relasi 'fotos'
        $gangguan = Gangguan::with('fotos')->orderBy('created_at', 'desc')->get();
        $jalurPipa = JalurPipa::all();
        $bangunan = Bangunan::all();
        $titikPenting = TitikPenting::all();
        $zonaList = Zona::all();

        // Ambil data pelanggan dari API PDAM Sumedang
        $response = Http::withoutVerifying()
                        ->get('https://pdamsumedang.com/portal/dashboard_api/pelanggan.php?of_id=04');
        
        $pelanggan = [];
        if ($response->successful()) {
            $pelanggan = $response->json();
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
        
        // ============================================
        // 🔥 PERBAIKAN: HAPUS pemanggilan getAllFotos()
        // Gunakan relasi 'fotos' langsung dengan fallback ke kolom 'foto' utama
        // ============================================
        $gangguanFotosData = [];
        foreach ($gangguan as $g) {
            // 1. Cek jika ada foto dari relasi tabel gangguan_fotos (Multiple Foto)
            if ($g->fotos && $g->fotos->count() > 0) {
                $gangguanFotosData[$g->id] = $g->fotos->map(function($foto) {
                    return [
                        'id' => $foto->id,
                        'url' => asset('storage/' . $foto->foto_path),
                        'urutan' => $foto->urutan,
                    ];
                })->toArray();
            } 
            // 2. Fallback: Jika tidak ada foto di tabel gangguan_fotos, cek kolom 'foto' utama (Single Foto)
            elseif (!empty($g->foto)) {
                $gangguanFotosData[$g->id] = [
                    [
                        'id' => 'main_' . $g->id,
                        'url' => asset('storage/' . $g->foto),
                        'urutan' => 0,
                    ]
                ];
            }
        }
        
        // ✅ PASTIKAN gangguanFotosData MASUK KE COMPACT
        return view('public.dashboard', compact(
            'gangguan', 
            'gangguanAktif',
            'jalurPipa', 
            'bangunan', 
            'titikPenting', 
            'zonaList',
            'stats',
            'pelanggan',
            'gangguanFotosData' // ← INI HARUS ADA!
        ));
    }
}