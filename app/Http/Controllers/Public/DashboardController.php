<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Gangguan;
use App\Models\JalurPipa;
use App\Models\Bangunan;
use App\Models\TitikPenting;
use App\Models\Zona; // ← TAMBAHKAN INI
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil semua data untuk peta jaringan
        $gangguan = Gangguan::orderBy('created_at', 'desc')->get();
        $jalurPipa = JalurPipa::all();
        $bangunan = Bangunan::all();
        $titikPenting = TitikPenting::all();
        $zonaList = Zona::all(); // ← TAMBAHKAN INI

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
            'total_zona' => $zonaList->count(), // ← TAMBAHKAN INI
            'total_pelanggan' => count($pelanggan),
        ];
        
        // Gangguan aktif untuk alert
        $gangguanAktif = $gangguan->where('status', '!=', 'selesai');
        
        return view('public.dashboard', compact(
            'gangguan', 
            'gangguanAktif', // ← TAMBAHKAN INI
            'jalurPipa', 
            'bangunan', 
            'titikPenting', 
            'zonaList', // ← TAMBAHKAN INI
            'stats',
            'pelanggan'
        ));
    }

    public function detail($kode)
    {
        $gangguan = Gangguan::where('kode_laporan', $kode)->firstOrFail();
        return view('public.detail', compact('gangguan'));
    }
}