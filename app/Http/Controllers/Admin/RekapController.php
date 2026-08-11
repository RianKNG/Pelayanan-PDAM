<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use App\Imports\TagihanImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class RekapController extends Controller
{       // ============================================================
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
    public function index()
    {
        $periodeTersedia = Tagihan::select('bulan', 'tahun')->distinct()->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get();
        $bulanList = ['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];
        return view('rekap.index', compact('periodeTersedia', 'bulanList'));
    }

    public function upload(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv', 'bulan' => 'required|in:01,02,03,04,05,06,07,08,09,10,11,12', 'tahun' => 'required|digits:4']);
        try {
            Tagihan::where('bulan', $request->bulan)->where('tahun', $request->tahun)->delete();
            Excel::import(new TagihanImport($request->bulan, $request->tahun), $request->file('file'));
            return back()->with('success', "✅ Data " . $this->getNamaBulan($request->bulan) . " {$request->tahun} berhasil diupload!");
        } catch (\Exception $e) {
            return back()->with('error', "❌ Gagal upload: " . $e->getMessage());
        }
    }

    public function rekapBulanan()
    {
        $periodeTersedia = Tagihan::select('bulan', 'tahun')->distinct()->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get();
        $bulanList = ['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];
        return view('rekap.bulanan', compact('periodeTersedia', 'bulanList'));
    }

    public function prosesRekap(Request $request)
    {
        $request->validate(['bulan_dari' => 'required', 'bulan_sampai' => 'required', 'tahun' => 'required|digits:4']);
        $bulanDari = $request->bulan_dari; 
        $bulanSampai = $request->bulan_sampai; 
        $tahun = $request->tahun;
        $filterKategori = $request->filter_kategori ?? 'semua';
        $filterGolongan = $request->filter_golongan ?? '';
        $filterWilayah = $request->filter_wilayah ?? '';
        $listBulan = $this->generateListBulan($bulanDari, $bulanSampai);

        $tagihanAll = Tagihan::where('tahun', $tahun)->whereIn('bulan', $listBulan)->get();
        $golonganList = $tagihanAll->pluck('kode_gol')->unique()->sort()->values();
        $wilayahList = $tagihanAll->map(fn($i) => substr($i->no_sambungan, 0, 6))->unique()->sort()->values();

        $tabelData = [];
        foreach ($tagihanAll->groupBy('no_sambungan') as $noSambungan => $tagihans) {
            $first = $tagihans->first();
            $row = ['no_sambungan' => $noSambungan, 'no_rekening' => $first->no_rekening, 'nama_pelanggan' => $first->nama_pelanggan, 'alamat' => $first->alamat, 'kode_gol' => $first->kode_gol, 'data_per_bulan' => []];
            foreach ($listBulan as $bulan) {
                $tBulan = $tagihans->where('bulan', $bulan)->first();
                $row['data_per_bulan'][$bulan] = $tBulan ? $tBulan->pakai : 0;
            }
            $row['total_pakai'] = array_sum($row['data_per_bulan']);
            $row['rata_pakai'] = $row['total_pakai'] / count($listBulan);
            $row['kategori'] = ($row['rata_pakai'] == 0) ? '0' : (($row['rata_pakai'] >= 11 && $row['rata_pakai'] <= 30) ? '11-30' : (($row['rata_pakai'] > 30) ? '>30' : '1-10'));
            $tabelData[] = $row;
        }

        $filtered = $tabelData;
        if ($filterKategori !== 'semua') $filtered = array_filter($filtered, fn($r) => $r['kategori'] === $filterKategori);
        if ($filterGolongan !== '') $filtered = array_filter($filtered, fn($r) => $r['kode_gol'] === $filterGolongan);
        if ($filterWilayah !== '') $filtered = array_filter($filtered, fn($r) => substr($r['no_sambungan'], 0, 6) === $filterWilayah);
        
        $tabelData = array_values($filtered);
        usort($tabelData, fn($a, $b) => strcmp($a['nama_pelanggan'], $b['nama_pelanggan']));

        $bulanList = ['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];
        
        // ✅ PERBAIKAN: Gunakan array [] bukan compact() yang salah
        return view('rekap.hasil', [
            'tabelData' => $tabelData, 'listBulan' => $listBulan, 'bulanList' => $bulanList, 
            'tahun' => $tahun, 'bulanDari' => $bulanDari, 'bulanSampai' => $bulanSampai, 
            'golonganList' => $golonganList, 'wilayahList' => $wilayahList, 
            'filterKategori' => $filterKategori, 'filterGolongan' => $filterGolongan, 'filterWilayah' => $filterWilayah
        ]);
    }

    public function downloadPdf(Request $request)
    {
        $request->validate(['bulan_dari' => 'required', 'bulan_sampai' => 'required', 'tahun' => 'required']);
        $bulanDari = $request->bulan_dari; $bulanSampai = $request->bulan_sampai; $tahun = $request->tahun;
        $filterKategori = $request->filter ?? 'semua';
        $listBulan = $this->generateListBulan($bulanDari, $bulanSampai);

        $tagihanAll = Tagihan::where('tahun', $tahun)->whereIn('bulan', $listBulan)->get();
        $tabelData = [];
        foreach ($tagihanAll->groupBy('no_sambungan') as $noSambungan => $tagihans) {
            $first = $tagihans->first();
            $row = ['no_sambungan' => $noSambungan, 'no_rekening' => $first->no_rekening, 'nama_pelanggan' => $first->nama_pelanggan, 'alamat' => $first->alamat, 'kode_gol' => $first->kode_gol, 'data_per_bulan' => []];
            foreach ($listBulan as $bulan) {
                $tBulan = $tagihans->where('bulan', $bulan)->first();
                $row['data_per_bulan'][$bulan] = $tBulan ? $tBulan->pakai : 0;
            }
            $row['total_pakai'] = array_sum($row['data_per_bulan']);
            $row['rata_pakai'] = $row['total_pakai'] / count($listBulan);
            $row['kategori'] = ($row['rata_pakai'] == 0) ? '0' : (($row['rata_pakai'] >= 11 && $row['rata_pakai'] <= 30) ? '11-30' : (($row['rata_pakai'] > 30) ? '>30' : '1-10'));
            $tabelData[] = $row;
        }

        $filtered = $tabelData;
        if ($filterKategori !== 'semua') $filtered = array_filter($filtered, fn($r) => $r['kategori'] === $filterKategori);
        $tabelData = array_values($filtered);
        usort($tabelData, fn($a, $b) => strcmp($a['nama_pelanggan'], $b['nama_pelanggan']));

        $bulanList = ['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];
        
        $pdf = Pdf::loadView('rekap.pdf', [
            'tabelData' => $tabelData, 'listBulan' => $listBulan, 'bulanList' => $bulanList, 
            'tahun' => $tahun, 'bulanDari' => $bulanDari, 'bulanSampai' => $bulanSampai, 
            'totalPelanggan' => count($tabelData), 'totalPakaiKeseluruhan' => array_sum(array_column($tabelData, 'total_pakai')), 
            'filterKategori' => $filterKategori
        ]);
        
        return $pdf->download("Rekap_{$bulanList[$bulanDari]}_sampai_{$bulanList[$bulanSampai]}_{$tahun}.pdf");
    }

    public function cariTigaBulanNol(Request $request)
    {
        $request->validate(['bulan' => 'required', 'tahun' => 'required|digits:4']);
        $tigaBulanNol = $this->getTigaBulanNolData($request->bulan, $request->tahun);
        $bulanList = ['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];
        
        // ✅ PERBAIKAN: Gunakan array [] bukan compact() yang salah
        return view('rekap.tiga_bulan_nol', [
            'tigaBulanNol' => $tigaBulanNol,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'bulanList' => $bulanList
        ]);
    }

    public function downloadPdfTigaBulanNol(Request $request)
    {
        $request->validate(['bulan' => 'required', 'tahun' => 'required']);
        $tigaBulanNol = $this->getTigaBulanNolData($request->bulan, $request->tahun);
        $bulanList = ['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];
        
        // ✅ PERBAIKAN: Gunakan array [] bukan compact() yang salah
        $pdf = Pdf::loadView('rekap.pdf_tiga_bulan_nol', [
            'tigaBulanNol' => $tigaBulanNol,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'bulanList' => $bulanList,
            'total' => $tigaBulanNol->count()
        ]);
        
        return $pdf->download("Pelanggan_3_Bulan_0_{$bulanList[$request->bulan]}_{$request->tahun}.pdf");
    }

    private function getTigaBulanNolData($bulan, $tahun)
    {
        $bInt = (int)$bulan; $tInt = (int)$tahun;
        $b1 = str_pad($bInt - 1, 2, '0', STR_PAD_LEFT); $t1 = ($bInt == 1) ? $tInt - 1 : $tInt; if($bInt == 1) $b1 = '12';
        $b2 = str_pad($bInt - 2, 2, '0', STR_PAD_LEFT); $t2 = ($bInt <= 2) ? $tInt - 1 : $tInt; if($bInt <= 2) $b2 = str_pad(12 + ($bInt - 2), 2, '0', STR_PAD_LEFT);
        return DB::table('tagihans as t1')
            ->join('tagihans as t2', fn($j) => $j->on('t1.no_sambungan', '=', 't2.no_sambungan')->where('t2.bulan', $b1)->where('t2.tahun', $t1))
            ->join('tagihans as t3', fn($j) => $j->on('t1.no_sambungan', '=', 't3.no_sambungan')->where('t3.bulan', $b2)->where('t3.tahun', $t2))
            ->where('t1.bulan', $bulan)->where('t1.tahun', $tahun)->where('t1.pakai', 0)->where('t2.pakai', 0)->where('t3.pakai', 0)
            ->select('t1.*')->get();
    }

    private function generateListBulan($dari, $sampai)
    {
        $list = []; $start = (int)$dari; $end = (int)$sampai;
        if ($start <= $end) { for ($i = $start; $i <= $end; $i++) $list[] = str_pad($i, 2, '0', STR_PAD_LEFT); } 
        else { for ($i = $start; $i <= 12; $i++) $list[] = str_pad($i, 2, '0', STR_PAD_LEFT); for ($i = 1; $i <= $end; $i++) $list[] = str_pad($i, 2, '0', STR_PAD_LEFT); }
        return $list;
    }

    private function getNamaBulan($angka)
    {
        $bulan = ['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];
        return $bulan[$angka] ?? $angka;
    }
}