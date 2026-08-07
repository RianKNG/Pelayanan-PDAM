<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use App\Imports\TagihanImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class EvaluasiController extends Controller
{
    // ============================================================
    // 📌 MASTER DATA GOLONGAN & WILAYAH
    // ============================================================
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
            '301001' => 'Jl. Raya Darmaraja I',
            '303001' => 'Jl. Raya Darmaraja I',
            
            '301002' => 'Kaum Kaler',
            '302002' => 'Kaum Kaler',

            '301003' => 'Jl. Darmaraja III & Cikiray',
            '301004' => 'Jl. Darmaraja IV & Karangtanjung',
            '301005' => 'Kaum Kidul',
            '301006' => 'Desa Darmaraja I',
            '301007' => 'Kamenteng',

            '302001' => 'Sinaraga',

            '303002' => 'Dsn Pasar II',
            '303003' => 'Dsn Pasar III',
            '303004' => 'Dsn Pasar Blok IV',

            '304001' => 'Karangpakuan & Ancol',
            '304002' => 'Cinangsi & Cipicung',
            '030400' => 'Darmaraja I',
        ];
    }

    public function index(Request $request)
    {
        // 1. Ambil Parameter Request
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));
        $filterMode = $request->input('filter_mode', 'pemakaian');
        
        $detailType = $request->input('detail_type');   
        $detailValue = $request->input('detail_value'); 

        // Load Master Mapping
        $masterGolongan = $this->getMasterGolongan();
        $masterWilayah  = $this->getMasterWilayah();

        // Base Query berdasarkan Bulan & Tahun
        $queryBase = DB::table('tagihans') 
            ->where('bulan', $bulan)
            ->where('tahun', $tahun);

        // -------------------------------------------------------------
        // 2. DATA UNTUK TABEL RINGKASAN & PEMAKAIAN
        // -------------------------------------------------------------
        
        // Mode Pemakaian (Lengkap seluruh spektrum agar total pas)
        $pelanggan0       = (clone $queryBase)->where('pakai', 0)->paginate(10, ['*'], 'p_0');
        $pelanggan1_14    = (clone $queryBase)->whereBetween('pakai', [1, 14])->paginate(10, ['*'], 'p_1_14');
        $pelanggan15_30   = (clone $queryBase)->whereBetween('pakai', [15, 30])->paginate(10, ['*'], 'p_15_30');
        $pelangganAbove30 = (clone $queryBase)->where('pakai', '>', 30)->paginate(10, ['*'], 'p_above30');

        // Mode Wilayah (SQL Group By 6 Digit Pertama No Sambungan)
        $rawWilayah = DB::table('tagihans')
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->select(
                DB::raw('SUBSTRING(no_sambungan, 1, 6) as kode_wilayah'),
                DB::raw('COUNT(DISTINCT no_sambungan) as jumlah_pelanggan'),
                DB::raw('SUM(pakai) as total_pakai'),
                DB::raw('SUM(total_rekening) as total_revenue')
            )
            ->groupBy(DB::raw('SUBSTRING(no_sambungan, 1, 6)'))
            ->get();

        // Grouping Ulang di PHP (Menggabungkan nama wilayah yang sama)
        $groupedWilayah = [];
        foreach ($rawWilayah as $item) {
            $namaWilayah = $masterWilayah[$item->kode_wilayah] ?? "Wilayah ({$item->kode_wilayah})";

            if (isset($groupedWilayah[$namaWilayah])) {
                $groupedWilayah[$namaWilayah]->jumlah_pelanggan += (int) $item->jumlah_pelanggan;
                $groupedWilayah[$namaWilayah]->total_pakai += (float) $item->total_pakai;
                $groupedWilayah[$namaWilayah]->total_revenue += (float) $item->total_revenue;
                $groupedWilayah[$namaWilayah]->kode_wilayah_list[] = $item->kode_wilayah;
            } else {
                $groupedWilayah[$namaWilayah] = (object) [
                    'nama_wilayah'      => $namaWilayah,
                    'jumlah_pelanggan'  => (int) $item->jumlah_pelanggan,
                    'total_pakai'       => (float) $item->total_pakai,
                    'total_revenue'     => (float) $item->total_revenue,
                    'kode_wilayah_list' => [$item->kode_wilayah],
                ];
            }
        }

        // Hitung Rata-rata & Format Kode Parameter
        foreach ($groupedWilayah as $group) {
            $group->avg_pakai = $group->jumlah_pelanggan > 0 
                ? round($group->total_pakai / $group->jumlah_pelanggan, 1) 
                : 0;
            $group->kode_wilayah_param = implode(',', $group->kode_wilayah_list);
        }

        $dataPerWilayah = collect(array_values($groupedWilayah));

        // Mode Golongan
        $dataPerGolongan = (clone $queryBase)
            ->select(
                'kode_gol',
                DB::raw('COUNT(*) as jumlah_pelanggan'),
                DB::raw('SUM(pakai) as total_pakai'),
                DB::raw('AVG(pakai) as avg_pakai'),
                DB::raw('SUM(total_rekening) as total_revenue')
            )
            ->groupBy('kode_gol')
            ->get();

        // -------------------------------------------------------------
        // 3. LOGIC DETAIL LIST PELANGGAN
        // -------------------------------------------------------------
        // Inisialisasi awal agar tidak undefined di compact()
        $detailData = null;

        if ($detailType && !is_null($detailValue)) {
            if ($detailType === 'kategori') {
                if ((string)$detailValue === '0') {
                    $detailData = (clone $queryBase)->where('pakai', 0)->orderBy('nama_pelanggan')->paginate(50);
                } elseif ($detailValue === '1_14') {
                    $detailData = (clone $queryBase)->whereBetween('pakai', [1, 14])->orderBy('nama_pelanggan')->paginate(50);
                } elseif ($detailValue === '15_30') {
                    $detailData = (clone $queryBase)->whereBetween('pakai', [15, 30])->orderBy('nama_pelanggan')->paginate(50);
                } elseif ($detailValue === 'above_30') {
                    $detailData = (clone $queryBase)->where('pakai', '>', 30)->orderBy('nama_pelanggan')->paginate(50);
                }
            } elseif ($detailType === 'wilayah') {
                $kodeList = explode(',', $detailValue);
                $detailData = (clone $queryBase)
                    ->whereIn(DB::raw('SUBSTRING(no_sambungan, 1, 6)'), $kodeList)
                    ->orderBy('nama_pelanggan')
                    ->paginate(50);
            } elseif ($detailType === 'golongan') {
                $detailData = (clone $queryBase)
                    ->where('kode_gol', $detailValue)
                    ->orderBy('nama_pelanggan')
                    ->paginate(50);
            }
        }

        // -------------------------------------------------------------
        // 4. PERSIAPAN DATA UNTUK GRAFIK
        // -------------------------------------------------------------
        $chartLabels = [];
        $chartData   = [];

        if ($filterMode === 'wilayah') {
            $chartLabels = $dataPerWilayah->pluck('nama_wilayah')->toArray();
            $chartData   = $dataPerWilayah->pluck('jumlah_pelanggan')->toArray();
        } elseif ($filterMode === 'golongan') {
            $chartLabels = $dataPerGolongan->map(function($item) use ($masterGolongan) {
                return $masterGolongan[$item->kode_gol] ?? "Gol. {$item->kode_gol}";
            })->toArray();
            $chartData   = $dataPerGolongan->pluck('jumlah_pelanggan')->toArray();
        } else {
            // Pemakaian (Semua Kategori)
            $chartLabels = ['0 m³', '1 - 14 m³', '15 - 30 m³', '> 30 m³'];
            $chartData   = [
                $pelanggan0->total(),
                $pelanggan1_14->total(),
                $pelanggan15_30->total(),
                $pelangganAbove30->total()
            ];
        }

        // 5. Render View
        return view('evaluasi.index', compact(
            'bulan', 
            'tahun', 
            'filterMode', 
            'dataPerWilayah', 
            'dataPerGolongan', 
            'pelanggan0', 
            'pelanggan1_14', 
            'pelanggan15_30', 
            'pelangganAbove30', 
            'detailData', 
            'detailType', 
            'detailValue', 
            'chartLabels', 
            'chartData',
            'masterGolongan',
            'masterWilayah'
        ));
    }

    // ✅ METHOD EVALUASI
    public function evaluasi(Request $request)
    {
        $request->validate(['bulan' => 'required', 'tahun' => 'required']);

        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $namaBulan = Tagihan::namaBulan($bulan);

        $queryBase = Tagihan::periode($bulan, $tahun);

        $statGolongan = (clone $queryBase)
            ->select('kode_gol', 
                DB::raw('COUNT(*) as jumlah'),
                DB::raw('SUM(pakai) as total_pakai'),
                DB::raw('AVG(pakai) as rata_pakai'),
                DB::raw('SUM(total_rekening) as total_revenue')
            )
            ->groupBy('kode_gol')
            ->orderBy('kode_gol')
            ->get();

        $totalPelanggan = (clone $queryBase)->count();
        $totalPakai     = (clone $queryBase)->sum('pakai');
        $totalRevenue   = (clone $queryBase)->sum('total_rekening');
        $rataPakai      = $totalPelanggan > 0 ? $totalPakai / $totalPelanggan : 0;

        $tigaBulanNol = $this->getPelanggan3Bulan0($bulan, $tahun);
        $pakai15_30   = (clone $queryBase)->whereBetween('pakai', [15, 30])->get();
        $pakaiLebih30 = (clone $queryBase)->where('pakai', '>', 30)->get();
        $tagihanPeriode = (clone $queryBase)->get();

        $masterGolongan = $this->getMasterGolongan();

        return view('evaluasi.hasil', compact(
            'bulan', 'tahun', 'namaBulan', 'tagihanPeriode',
            'tigaBulanNol', 'pakai15_30', 'pakaiLebih30',
            'statGolongan', 'totalPelanggan', 'totalPakai',
            'totalRevenue', 'rataPakai', 'masterGolongan'
        ));
    }

    private function getPelanggan3Bulan0($bulan, $tahun)
    {
        $bulanInt = (int)$bulan;
        $tahunInt = (int)$tahun;
        
        $bulanSebelum1 = str_pad($bulanInt - 1, 2, '0', STR_PAD_LEFT);
        $tahunSebelum1 = $tahunInt;
        if ($bulanInt == 1) { $bulanSebelum1 = '12'; $tahunSebelum1 = $tahunInt - 1; }
        
        $bulanSebelum2 = str_pad($bulanInt - 2, 2, '0', STR_PAD_LEFT);
        $tahunSebelum2 = $tahunInt;
        if ($bulanInt <= 2) {
            $bulanSebelum2 = str_pad(12 + ($bulanInt - 2), 2, '0', STR_PAD_LEFT);
            $tahunSebelum2 = $tahunInt - 1;
        }

        return DB::table('tagihans as t1')
            ->join('tagihans as t2', function($join) use ($bulanSebelum1, $tahunSebelum1) {
                $join->on('t1.no_sambungan', '=', 't2.no_sambungan')
                     ->where('t2.bulan', '=', $bulanSebelum1)
                     ->where('t2.tahun', '=', $tahunSebelum1);
            })
            ->join('tagihans as t3', function($join) use ($bulanSebelum2, $tahunSebelum2) {
                $join->on('t1.no_sambungan', '=', 't3.no_sambungan')
                     ->where('t3.bulan', '=', $bulanSebelum2)
                     ->where('t3.tahun', '=', $tahunSebelum2);
            })
            ->where('t1.bulan', $bulan)
            ->where('t1.tahun', $tahun)
            ->where('t1.pakai', 0)
            ->where('t2.pakai', 0)
            ->where('t3.pakai', 0)
            ->select('t1.*')
            ->get();
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
            'bulan' => 'required|in:01,02,03,04,05,06,07,08,09,10,11,12',
            'tahun' => 'required|digits:4',
        ]);

        try {
            Tagihan::where('bulan', $request->bulan)
                   ->where('tahun', $request->tahun)
                   ->delete();

            Excel::import(
                new TagihanImport($request->bulan, $request->tahun),
                $request->file('file')
            );

            $namaBulan = Tagihan::namaBulan($request->bulan);
            return back()->with('success', "✅ Data {$namaBulan} {$request->tahun} berhasil diupload!");
        } catch (\Exception $e) {
            return back()->with('error', "❌ Gagal upload: " . $e->getMessage());
        }
    }

    public function cari(Request $request)
    {
        $query = Tagihan::query();
        
        if ($request->filled('no_sambungan')) {
            $query->where('no_sambungan', 'like', '%' . $request->no_sambungan . '%');
        }
        if ($request->filled('nama')) {
            $query->where('nama_pelanggan', 'like', '%' . $request->nama . '%');
        }
        if ($request->filled('bulan') && $request->filled('tahun')) {
            $query->periode($request->bulan, $request->tahun);
        }
        if ($request->filled('kategori')) {
            if ($request->kategori == '0_bulan') $query->where('pakai', 0);
            elseif ($request->kategori == '15_30') $query->whereBetween('pakai', [15, 30]);
            elseif ($request->kategori == 'lebih_30') $query->where('pakai', '>', 30);
        }

        $hasil = $query->orderBy('nama_pelanggan')->paginate(50);
        
        return view('evaluasi.cari', ['hasil' => $hasil, 'request' => $request]);
    }

    public function cetakPdf(Request $request)
    {
        $request->validate([
            'bulan' => 'required',
            'tahun' => 'required',
            'jenis' => 'required|in:semua,0_bulan,15_30,lebih_30,golongan'
        ]);

        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $jenis = $request->jenis;
        $namaBulan = Tagihan::namaBulan($bulan);
        $golongan = $request->golongan ?? null;

        $query = Tagihan::periode($bulan, $tahun);
        $judul = "Evaluasi Tagihan {$namaBulan} {$tahun}";

        switch ($jenis) {
            case 'semua':
                $query->orderBy('nama_pelanggan');
                $judul .= " - Semua Pelanggan";
                break;
            case '0_bulan':
                $data = $this->getPelanggan3Bulan0($bulan, $tahun);
                $judul .= " - 3 Bulan 0 Kubik";
                break;
            case '15_30':
                $query->whereBetween('pakai', [15, 30])->orderBy('pakai', 'desc');
                $judul .= " - Pemakaian 15-30 m³";
                break;
            case 'lebih_30':
                $query->where('pakai', '>', 30)->orderBy('pakai', 'desc');
                $judul .= " - Pemakaian > 30 m³";
                break;
            case 'golongan':
                $query->golongan($golongan)->orderBy('nama_pelanggan');
                
                $masterGolongan = $this->getMasterGolongan();
                $namaGol = $masterGolongan[$golongan] ?? $golongan;
                $judul .= " - Golongan {$namaGol}";
                break;
        }

        if ($jenis !== '0_bulan') {
            $data = $query->get();
        }

        $pdf = Pdf::loadView('evaluasi.pdf', [
            'data' => $data, 
            'judul' => $judul, 
            'bulan' => $bulan,
            'tahun' => $tahun, 
            'namaBulan' => $namaBulan, 
            'jenis' => $jenis,
            'total' => is_countable($data) ? count($data) : $data->count(), 
            'totalPakai' => $data->sum('pakai'),
            'totalRevenue' => $data->sum('total_rekening'),
            'masterGolongan' => $this->getMasterGolongan()
        ]);

        $filename = "Evaluasi_{$namaBulan}_{$tahun}_{$jenis}.pdf";
        return $pdf->download($filename);
    }
}