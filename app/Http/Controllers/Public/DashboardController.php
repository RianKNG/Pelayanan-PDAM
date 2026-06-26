<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Gangguan;
use App\Models\JalurPipa;
use App\Models\Bangunan;
use App\Models\TitikPenting;
use App\Models\DebitKebocoran;
use Illuminate\Support\Facades\Http; // <-- Pastikan ini di-import

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil semua data untuk peta jaringan
        $gangguan = Gangguan::orderBy('created_at', 'desc')->get();
        $jalurPipa = JalurPipa::all();
        $bangunan = Bangunan::all();
        $titikPenting = TitikPenting::all();

        // 2. Ambil data pelanggan dari API PDAM Sumedang
        $response = Http::withoutVerifying() // Gunakan ini jika ada masalah SSL/HTTPS pada lokal
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
            'total_pelanggan' => count($pelanggan), // Tambahan statistik jika diperlukan
        ];
        
        
        return view('public.dashboard', compact(
            'gangguan', 
            'jalurPipa', 
            'bangunan', 
            'titikPenting', 
            'stats',
            'pelanggan' // <-- Variabel baru dimasukkan ke sini
        ));
    }

    public function detail($kode)
    {
        $gangguan = Gangguan::where('kode_laporan', $kode)->firstOrFail();
        return view('public.detail', compact('gangguan'));
    }
}