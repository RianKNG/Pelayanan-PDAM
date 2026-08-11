<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use App\Models\GolonganHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class GolonganMonitoringController extends Controller
{   
    private function getMasterGolongan()
    {
        return [
            '12' => 'Sosial',
            '23' => 'Pemerintah',
            '28' => 'RT C',
            '29' => 'RT D',
            '31' => 'Niaga Besar',
        ];
    }

    private function getMasterWilayah()
    {
        return [
            '304001' => 'Karang Pakuan',
            '301001' => 'Jl. Raya Darmaraja/Blok I',
            '301002' => 'Jl. Kaum Kaler/Blok II',
            '301003' => 'Jl. Raya DMJ/Blok III',
            '301004' => 'Jl. Karang Tanjung/Blok IV',
            '301005' => 'Jl. Kaum Kidul/Blok V',
            '301006' => 'Jl. Desa Darmaraja/Blok VI',
            '301007' => 'Jl. Kamenteng Girang',
            '302001' => 'Jl. Sirnaraga/Blok I',
            '302002' => 'Jl. Cipicung/Blok II',
            '303001' => 'Jl. Dusun Pasar/Blok I',
            '303002' => 'Jl. Dusun Pasar/Blok II',
            '303003' => 'Jl. Dusun Pasar/Blok III',
            '303004' => 'Jl. Dusu Pasar/Blok IV',
            '304002' => 'JLN CINANGSI'
        ];
    }
    
    public function index(Request $request)
    {
        // 1. NORMALISASI FILTER
        $filterKategori = $request->input('filter_kategori');
        if ($filterKategori === '' || $filterKategori === 'semua' || $filterKategori === null) {
            $filterKategori = null;
        }

        $filterGolongan = $request->input('filter_golongan');
        if ($filterGolongan === '' || $filterGolongan === 'semua' || $filterGolongan === null) {
            $filterGolongan = null;
        }

        $filterWilayah = $request->input('filter_wilayah');
        if ($filterWilayah === '' || $filterWilayah === 'semua' || $filterWilayah === null) {
            $filterWilayah = null;
        }

        $chartType = $request->input('chart_type', 'bar');
        $mode = $request->input('mode', 'custom');
        
        $bulanList = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];

        // Mencegah error jika belum ada request sama sekali
        if (!$request->has('bulan_dari') && !$request->has('periode')) {
            return view('golongan.index', [
                'periode' => 3, 'labels' => [], 'chartData' => [],
                'golonganList' => collect(), 'wilayahList' => collect(),
                'perubahanGolongan' => [], 'historiPerubahan' => collect(),
                'mode' => 'custom', 'bulanList' => $bulanList,
                'bulanDari' => '', 'bulanSampai' => '', 'tahun' => date('Y'),
                'validCustomers' => [], 'filterKategori' => null,
                'filterGolongan' => null, 'filterWilayah' => null,
                'chartType' => 'bar',
                'masterGolongan' => $this->getMasterGolongan(),
                'masterWilayah' => $this->getMasterWilayah()
            ]);
        }

        $periode = 3;
        
        if ($mode === 'custom') {
            $bulanDari = $request->input('bulan_dari') ?: '01';
            $bulanSampai = $request->input('bulan_sampai') ?: date('m');
            $tahun = $request->input('tahun') ?: date('Y');
            
            $listBulan = $this->generateListBulan($bulanDari, $bulanSampai);
            $periode = count($listBulan);
        } else {
            $periode = $request->input('periode', '3');
            $bulanSekarang = now();
            $listBulan = [];
            for ($i = $periode - 1; $i >= 0; $i--) {
                $b = $bulanSekarang->copy()->subMonths($i);
                $listBulan[] = $b->format('m');
            }
            $bulanDari = $listBulan[0];
            $bulanSampai = end($listBulan);
            $tahun = date('Y');
        }

        // Ambil semua golongan
        $golonganList = Tagihan::where('tahun', $tahun)
            ->whereIn('bulan', $listBulan)
            ->pluck('kode_gol')->filter()->unique()->sort()->values();

        // ✅ PERBAIKAN 1: Pemotongan Wilayah dengan Pembersihan '0' di Depan (MySQL-Ready)
        $wilayahList = DB::table('tagihans')
            ->where('tahun', $tahun)
            ->whereIn('bulan', $listBulan)
            ->select(DB::raw("LEFT(TRIM(LEADING '0' FROM no_sambungan), 6) as kode_wilayah"))
            ->pluck('kode_wilayah')
            ->filter()
            ->unique()
            ->sort()
            ->values();

        // 2. CHART DATA
        $golonganListForChart = $filterGolongan !== null ? collect([$filterGolongan]) : $golonganList;

        $chartData = [];
        $labels = [];
        
        foreach ($listBulan as $bulan) {
            $namaBulan = $bulanList[$bulan] ?? 'Bulan ' . $bulan;
            $labels[] = $namaBulan . ' ' . $tahun;
            
            foreach ($golonganListForChart as $gol) {
                if (!isset($chartData[$gol])) $chartData[$gol] = [];
                
                $query = DB::table('tagihans')
                    ->where('tahun', $tahun)
                    ->where('bulan', $bulan)
                    ->where('kode_gol', $gol);
                
                // ✅ PERBAIKAN 2: Matching Wilayah menggunakan TRIM LEADING MySQL
                if ($filterWilayah !== null) {
                    $query->whereRaw("LEFT(TRIM(LEADING '0' FROM no_sambungan), 6) = ?", [$filterWilayah]);
                }
                
                if ($filterKategori !== null) {
                    if ($filterKategori === '0') {
                        $query->where('pakai', 0);
                    } elseif ($filterKategori === '1-10') {
                        $query->whereBetween('pakai', [1, 10]);
                    } elseif ($filterKategori === '11-30') {
                        $query->whereBetween('pakai', [11, 30]);
                    } elseif ($filterKategori === '>30') {
                        $query->where('pakai', '>', 30);
                    }
                }
                
                $chartData[$gol][] = $query->count();
            }
        }

        // 3. TABEL DETAIL
        $allData = Tagihan::where('tahun', $tahun)->whereIn('bulan', $listBulan)->get();
        $grouped = $allData->groupBy('no_sambungan');
        $validCustomers = [];

        foreach ($grouped as $no_sambungan => $records) {
            $first = $records->first();
            
            // ✅ PERBAIKAN 3: Normalisasi Wilayah Pelanggan di PHP
            $cleanNoSambungan = ltrim(trim($no_sambungan), '0');
            $wilayahPelanggan = substr($cleanNoSambungan, 0, 6);

            $totalPakai = $records->sum('pakai');
            $avgPakai = $totalPakai / (count($listBulan) ?: 1);
            $kategori = ($avgPakai == 0) ? '0' : (($avgPakai >= 11 && $avgPakai <= 30) ? '11-30' : (($avgPakai > 30) ? '>30' : '1-10'));

            if ($filterWilayah !== null && $wilayahPelanggan !== $filterWilayah) continue;
            if ($filterGolongan !== null && $first->kode_gol !== $filterGolongan) continue;
            if ($filterKategori !== null && $kategori !== $filterKategori) continue;

            $validCustomers[] = [
                'no_sambungan' => $no_sambungan, 
                'nama_pelanggan' => $first->nama_pelanggan,
                'alamat' => $first->alamat, 
                'kode_gol' => $first->kode_gol,
                'total_pakai' => $totalPakai, 
                'avg_pakai' => round($avgPakai, 1), 
                'kategori' => $kategori
            ];
        }

        usort($validCustomers, fn($a, $b) => strcmp($a['nama_pelanggan'], $b['nama_pelanggan']));

        $perubahanGolongan = [];
        if (count($listBulan) >= 2) {
            $bulanLaluIdx = count($listBulan) - 2;
            $bulanIniIdx = count($listBulan) - 1;
            
            foreach ($golonganListForChart as $gol) {
                $jLalu = $chartData[$gol][$bulanLaluIdx] ?? 0;
                $jIni = $chartData[$gol][$bulanIniIdx] ?? 0;
                $selisih = $jIni - $jLalu;
                $status = $selisih > 0 ? 'naik' : ($selisih < 0 ? 'turun' : 'tetap');

                $perubahanGolongan[$gol] = [
                    'bulan_lalu' => $jLalu, 'bulan_ini' => $jIni, 'selisih' => $selisih,
                    'persen' => $jLalu > 0 ? round(($selisih / $jLalu) * 100, 2) : 0,
                    'status' => $status
                ];
            }
        }

        $historiPerubahan = GolonganHistory::with('pelanggan')->orderBy('tanggal_perubahan', 'desc')->limit(20)->get();

        // ✅ PERBAIKAN 4: Mengirim masterGolongan dan masterWilayah ke View
        return view('golongan.index', [
            'periode'           => $periode,
            'labels'            => $labels,
            'chartData'         => $chartData,
            'golonganList'      => $golonganList,
            'wilayahList'       => $wilayahList,
            'perubahanGolongan' => $perubahanGolongan,
            'historiPerubahan'  => $historiPerubahan,
            'mode'              => $mode,
            'bulanList'         => $bulanList,
            'bulanDari'         => $bulanDari,
            'bulanSampai'       => $bulanSampai,
            'tahun'             => $tahun,
            'validCustomers'    => $validCustomers,
            'filterKategori'    => $filterKategori,
            'filterGolongan'    => $filterGolongan,
            'filterWilayah'     => $filterWilayah,
            'chartType'         => $chartType,
            'masterGolongan'    => $this->getMasterGolongan(),
            'masterWilayah'     => $this->getMasterWilayah(),
        ]);
    }

    public function catatPerubahan(Request $request)
    {
        $request->validate(['no_sambungan' => 'required', 'golongan_baru' => 'required', 'tanggal_perubahan' => 'required|date', 'alasan_perubahan' => 'required']);
        $pelanggan = Tagihan::where('no_sambungan', $request->no_sambungan)->firstOrFail();
        GolonganHistory::create([
            'no_sambungan' => $request->no_sambungan, 'golongan_lama' => $pelanggan->kode_gol, 'golongan_baru' => $request->golongan_baru,
            'tanggal_perubahan' => $request->tanggal_perubahan, 'alasan_perubahan' => $request->alasan_perubahan, 'keterangan' => $request->keterangan,
            'bulan' => now()->format('m'), 'tahun' => now()->format('Y')
        ]);
        $pelanggan->update(['kode_gol' => $request->golongan_baru]);
        return back()->with('success', 'Perubahan golongan berhasil dicatat');
    }

    public function exportPdf(Request $request)
    {
        $filterKategori = $request->input('filter_kategori');
        if ($filterKategori === '' || $filterKategori === 'semua' || $filterKategori === null) $filterKategori = null;

        $filterGolongan = $request->input('filter_golongan');
        if ($filterGolongan === '' || $filterGolongan === 'semua' || $filterGolongan === null) $filterGolongan = null;

        $filterWilayah = $request->input('filter_wilayah');
        if ($filterWilayah === '' || $filterWilayah === 'semua' || $filterWilayah === null) $filterWilayah = null;

        $mode = $request->input('mode', 'custom');
        $chartType = $request->input('chart_type', 'bar');
        
        if ($mode === 'custom') {
            $bulanDari = $request->input('bulan_dari') ?: now()->subMonths(2)->format('m'); 
            $bulanSampai = $request->input('bulan_sampai') ?: now()->format('m'); 
            $tahun = $request->input('tahun') ?: date('Y');
            $listBulan = $this->generateListBulan($bulanDari, $bulanSampai);
        } else {
            $periode = $request->input('periode', '3'); 
            $tahun = date('Y'); 
            $listBulan = [];
            for ($i = $periode - 1; $i >= 0; $i--) {
                $listBulan[] = now()->copy()->subMonths($i)->format('m');
            }
            $bulanDari = $listBulan[0]; 
            $bulanSampai = end($listBulan);
        }

        $bulanList = ['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];
        
        $allData = Tagihan::where('tahun', $tahun)->whereIn('bulan', $listBulan)->get();
        $golonganList = $allData->pluck('kode_gol')->filter()->unique()->sort()->values();
        
        $validCustomers = [];
        foreach ($allData->groupBy('no_sambungan') as $no_sambungan => $records) {
            $first = $records->first();
            
            // ✅ PERBAIKAN 5: Normalisasi Wilayah di Export PDF
            $cleanNoSambungan = ltrim(trim($no_sambungan), '0');
            $wilayahPelanggan = substr($cleanNoSambungan, 0, 6);

            if ($filterWilayah !== null && $wilayahPelanggan !== $filterWilayah) continue;
            if ($filterGolongan !== null && $first->kode_gol !== $filterGolongan) continue;
            
            $avgPakai = $records->sum('pakai') / (count($listBulan) ?: 1);
            $kategori = ($avgPakai == 0) ? '0' : (($avgPakai >= 11 && $avgPakai <= 30) ? '11-30' : (($avgPakai > 30) ? '>30' : '1-10'));
            
            if ($filterKategori !== null && $kategori !== $filterKategori) continue;

            $validCustomers[] = [
                'no_sambungan' => $no_sambungan, 
                'nama_pelanggan' => $first->nama_pelanggan, 
                'alamat' => $first->alamat, 
                'kode_gol' => $first->kode_gol, 
                'avg_pakai' => round($avgPakai, 1),
                'kategori' => $kategori
            ];
        }
        
        usort($validCustomers, fn($a, $b) => strcmp($a['nama_pelanggan'], $b['nama_pelanggan']));

        $chartLabels = [];
        $chartDatasets = [];
        $colors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'];
        
        foreach ($listBulan as $bulan) $chartLabels[] = $bulanList[$bulan] ?? $bulan;
        
        $golonganListForChart = $filterGolongan !== null ? collect([$filterGolongan]) : $golonganList;
        $golIdx = 0;
        
        foreach ($golonganListForChart as $gol) {
            $data = [];
            foreach ($listBulan as $bulan) {
                $query = DB::table('tagihans')->where('tahun', $tahun)->where('bulan', $bulan)->where('kode_gol', $gol);
                
                // ✅ PERBAIKAN 6: Matching Wilayah pada Grafik PDF
                if ($filterWilayah !== null) {
                    $query->whereRaw("LEFT(TRIM(LEADING '0' FROM no_sambungan), 6) = ?", [$filterWilayah]);
                }
                
                if ($filterKategori !== null) {
                    if ($filterKategori === '0') $query->where('pakai', 0);
                    elseif ($filterKategori === '1-10') $query->whereBetween('pakai', [1, 10]);
                    elseif ($filterKategori === '11-30') $query->whereBetween('pakai', [11, 30]);
                    elseif ($filterKategori === '>30') $query->where('pakai', '>', 30);
                }
                $data[] = $query->count();
            }
            $chartDatasets[] = ['label' => 'Gol ' . $gol, 'data' => $data, 'color' => $colors[$golIdx % count($colors)]];
            $golIdx++;
        }

        $quickchartDatasets = [];
        foreach ($chartDatasets as $ds) {
            $quickchartDatasets[] = [
                'label' => $ds['label'], 'data' => $ds['data'],
                'backgroundColor' => $ds['color'] . 'CC', 'borderColor' => $ds['color'], 'borderWidth' => 2
            ];
        }
        
        $chartConfig = [
            'type' => $chartType,
            'data' => ['labels' => $chartLabels, 'datasets' => $quickchartDatasets],
            'options' => [
                'responsive' => false,
                'plugins' => ['legend' => ['position' => 'top'], 'title' => ['display' => true, 'text' => 'Tren Pelanggan Terfilter']],
                'scales' => ['y' => ['beginAtZero' => true]]
            ]
        ];
        
        $chartUrl = 'https://quickchart.io/chart?c=' . urlencode(json_encode($chartConfig)) . '&width=700&height=350';

        $chartBase64 = null;
        try {
            $imageContent = file_get_contents($chartUrl);
            if ($imageContent !== false) {
                $chartBase64 = 'data:image/png;base64,' . base64_encode($imageContent);
            }
        } catch (\Exception $e) {
            $chartBase64 = null;
        }

        $filterText = "Gol: " . ($filterGolongan ?: 'Semua') . " | Wilayah: " . ($filterWilayah ?: 'Semua') . " | Kategori: " . ($filterKategori === null ? 'Semua' : $filterKategori . ' m³');

        $pdf = Pdf::loadView('golongan.pdf_list', [
            'validCustomers' => $validCustomers,
            'periodeText' => "{$bulanList[$bulanDari]} - {$bulanList[$bulanSampai]} {$tahun}",
            'filterText' => $filterText,
            'total' => count($validCustomers),
            'chartBase64' => $chartBase64,
            'chartType' => $chartType
        ])
        ->setOption('isRemoteEnabled', true)
        ->setOption('isHtml5ParserEnabled', true);
        
        return $pdf->download("Daftar_Pelanggan_Terfilter.pdf");
    }

    private function generateListBulan($dari, $sampai)
    {
        $list = []; 
        $start = (int)$dari; 
        $end = (int)$sampai;
        
        if ($start < 1 || $start > 12) $start = 1;
        if ($end < 1 || $end > 12) $end = (int)date('m');

        if ($start <= $end) { 
            for ($i = $start; $i <= $end; $i++) {
                $list[] = str_pad($i, 2, '0', STR_PAD_LEFT); 
            }
        } else { 
            for ($i = $start; $i <= 12; $i++) {
                $list[] = str_pad($i, 2, '0', STR_PAD_LEFT); 
            }
            for ($i = 1; $i <= $end; $i++) {
                $list[] = str_pad($i, 2, '0', STR_PAD_LEFT); 
            }
        }
        return $list;
    }
}