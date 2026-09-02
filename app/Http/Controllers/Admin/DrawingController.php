<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JalurPipa;
use App\Models\Bangunan;
use App\Models\TitikPenting;
use App\Models\Zona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class DrawingController extends Controller
{
    public function index()
    {
        $jalurPipa = JalurPipa::all();
        $bangunan = Bangunan::all();
        $titikPenting = TitikPenting::all();
        $zonaList = Zona::all();
        
        // Cache API selama 5 menit (300 detik) agar performa web tetap ngebut
        $pelangganStats = Cache::remember('pelanggan_zona_stats_v3', 300, function () {
            return $this->getPelangganZonaStats();
        });

        return view('admin.drawing.index', compact(
            'jalurPipa',
            'bangunan',
            'titikPenting',
            'zonaList',
            'pelangganStats'
        ));
    }

    private function getPelangganZonaStats()
    {
        try {
            $response = Http::timeout(15)->get('https://pdamsumedang.com/portal/dashboard_api/pelanggan.php?of_id=04');

            if (!$response->successful()) {
                return null;
            }

            $data = $response->json();
        } catch (\Throwable $e) {
            return null;
        }

        $stats = [
            'Zona 1' => ['sr' => 0, 'pakai' => 0, 'jumlah' => 0, 'pelanggan' => []],
            'Zona 2' => ['sr' => 0, 'pakai' => 0, 'jumlah' => 0, 'pelanggan' => []],
            'Zona 3' => ['sr' => 0, 'pakai' => 0, 'jumlah' => 0, 'pelanggan' => []],
            'Zona 4' => ['sr' => 0, 'pakai' => 0, 'jumlah' => 0, 'pelanggan' => []],
            'Zona 5' => ['sr' => 0, 'pakai' => 0, 'jumlah' => 0, 'pelanggan' => []],
            'Lainnya' => ['sr' => 0, 'pakai' => 0, 'jumlah' => 0, 'pelanggan' => []],
        ];

        foreach ($data as $item) {
            $kodeBlok = trim((string) ($item['kode_blok'] ?? ''));
            $alamat   = $this->normalizeText($item['alamat'] ?? '');

            $zone = $this->determineZone($kodeBlok, $alamat);

            // Jika ada kode aneh yang belum terpetakan, masuk Lainnya
            if (!isset($stats[$zone])) {
                $zone = 'Lainnya';
            }

            $stats[$zone]['sr']++;
            $stats[$zone]['pakai'] += (float) ($item['pakai'] ?? 0);
            $stats[$zone]['jumlah'] += (float) ($item['jumlah'] ?? 0);

            $stats[$zone]['pelanggan'][] = [
                'no_pelanggan' => $item['no_pelanggan'] ?? '-',
                'nama' => $item['nama'] ?? '-',
                'alamat' => $item['alamat'] ?? '-',
                'kode_blok' => $kodeBlok,
            ];
        }

        return $stats;
    }

    private function normalizeText($value)
    {
        $value = strtolower(trim((string) $value));
        $value = str_replace(['/', '\\', '-', '_', '.', ','], ' ', $value);
        return trim(preg_replace('/\s+/', ' ', $value));
    }

    private function containsAny(string $text, array $keywords): bool
    {
        $text = ' ' . $text . ' ';
        foreach ($keywords as $keyword) {
            if (str_contains($text, $keyword)) {
                return true;
            }
        }
        return false;
    }

    private function determineZone(string $kode, string $alamat): string
    {
        $kode = trim($kode);

        // PERBAIKAN: Pastikan return value adalah 'Zona X' agar cocok dengan key array $stats
        $map = [
            '304001' => 'Zona 1',
            '301001' => 'Zona 1',
            '301002' => 'Zona 1',
            '301003' => 'Zona 1',
            '301004' => 'Zona 1',
            '301005' => 'Zona 1',
            '301006' => 'Zona 1',
            '301007' => 'Zona 1',
            '302001' => 'Zona 1',
            '302002' => 'Zona 1',
            '303002' => 'Zona 1',
            '303004' => 'Zona 1',
            '304002' => 'Zona 1',
        ];

        // Khusus 0301003 / 301003: punya beberapa zona
        if ($kode === '0301003' || $kode === '301003') {
            if ($this->containsAny($alamat, ['cikiray', 'cikirai'])) {
                return 'Zona 4';
            }
            if ($this->containsAny($alamat, [' jl ', ' jln '])) {
                return 'Zona 5';
            }
            return 'Zona 2';
        }

        return $map[$kode] ?? 'Lainnya';
    }

    public function saveJalur(Request $request)
    {
        $request->validate([
            'nama_jalur' => 'required|string',
            'jenis_jalur' => 'required|in:transmisi,distribusi,tersier',
            'ukuran_pipa' => 'required|string',
            'warna' => 'required|string',
            'ketebalan' => 'nullable|integer',
            'keterangan' => 'nullable|string',
            'coordinates' => 'required|string',
        ]);

        $jalur = JalurPipa::create([
            'nama_jalur' => $request->nama_jalur,
            'jenis_jalur' => $request->jenis_jalur,
            'ukuran_pipa' => $request->ukuran_pipa,
            'warna' => $request->warna,
            'ketebalan' => $request->ketebalan ?? 4,
            'keterangan' => $request->keterangan,
            'coordinates' => $request->coordinates,
        ]);

        return response()->json(['success' => true, 'data' => $jalur]);
    }

    public function saveBangunan(Request $request)
    {
        // PERBAIKAN: Menambahkan validasi untuk field baru
        $request->validate([
            'nama_bangunan' => 'required|string',
            'jenis_bangunan' => 'required|string',
            'warna' => 'required|string',
            'ukuran_bangunan' => 'nullable|string',      // <-- BARU
            'elevasi' => 'nullable|numeric',             // <-- BARU
            'sumber_elevasi' => 'nullable|string',       // <-- BARU
            'keterangan' => 'nullable|string',
            'coordinates' => 'required|string',
        ]);

        $bangunan = Bangunan::create([
            'nama_bangunan' => $request->nama_bangunan,
            'jenis_bangunan' => $request->jenis_bangunan,
            'warna' => $request->warna,
            'ukuran_bangunan' => $request->ukuran_bangunan, // <-- BARU
            'elevasi' => $request->elevasi,                 // <-- BARU
            'sumber_elevasi' => $request->sumber_elevasi,   // <-- BARU
            'keterangan' => $request->keterangan,
            'coordinates' => $request->coordinates,
        ]);

        return response()->json(['success' => true, 'data' => $bangunan]);
    }

    public function saveTitik(Request $request)
    {
        $request->validate([
            'nama_titik' => 'required|string',
            'jenis_titik' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'elevasi' => 'nullable|numeric',
            'ukuran' => 'nullable|string', // Diperlonggar agar fleksibel
            'keterangan' => 'nullable|string',
        ]);

        $titik = TitikPenting::create([
            'nama_titik' => $request->nama_titik,
            'jenis_titik' => $request->jenis_titik,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'elevasi' => $request->elevasi,
            'ukuran' => $request->ukuran,
            'keterangan' => $request->keterangan,
        ]);

        return response()->json(['success' => true, 'data' => $titik]);
    }

    public function saveZona(Request $request)
    {
        $request->validate([
            'nama_zona' => 'required|string',
            'jenis_zona' => 'required|string',
            'warna' => 'required|string',
            'elevasi_min' => 'nullable|numeric',
            'elevasi_max' => 'nullable|numeric',
            'keterangan' => 'nullable|string',
            'coordinates' => 'required|string',
        ]);

        $zona = Zona::create([
            'nama_zona' => $request->nama_zona,
            'jenis_zona' => $request->jenis_zona,
            'warna' => $request->warna,
            'elevasi_min' => $request->elevasi_min,
            'elevasi_max' => $request->elevasi_max,
            'keterangan' => $request->keterangan,
            'coordinates' => $request->coordinates,
        ]);

        return response()->json(['success' => true, 'data' => $zona]);
    }

    public function deleteJalur($id)
    {
        JalurPipa::destroy($id);
        return response()->json(['success' => true]);
    }

    public function deleteBangunan($id)
    {
        Bangunan::destroy($id);
        return response()->json(['success' => true]);
    }

    public function deleteTitik($id)
    {
        TitikPenting::destroy($id);
        return response()->json(['success' => true]);
    }

    public function deleteZona($id)
    {
        Zona::destroy($id);
        return response()->json(['success' => true]);
    }
}