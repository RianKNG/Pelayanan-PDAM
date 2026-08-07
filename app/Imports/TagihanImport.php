<?php
namespace App\Imports;

use App\Models\Tagihan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TagihanImport implements ToModel, WithHeadingRow
{
    protected $bulan;
    protected $tahun;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function model(array $row)
    {
        return new Tagihan([
            'no_sambungan'   => $row['no_sambungan'] ?? $row['nosambungan'] ?? null,
            'no_rekening'    => $row['no_rekening'] ?? $row['norekening'] ?? null,
            'nama_pelanggan' => $row['nama_pelanggan'] ?? $row['namapelanggan'] ?? null,
            'alamat'         => $row['alamat'] ?? null,
            'kode_gol'       => $row['kode_gol'] ?? $row['kodegol'] ?? null,
            'stand_awal'     => $row['stand_awal'] ?? $row['standawal'] ?? 0,
            'stand_akhir'    => $row['stand_akhir'] ?? $row['standakhir'] ?? 0,
            'pakai'          => $row['pakai'] ?? 0,
            'harga_air'      => $row['harga_air'] ?? $row['hargaair'] ?? 0,
            'beban_tetap'    => $row['beban_tetap'] ?? $row['bebantetap'] ?? 0,
            'materai'        => $row['materai'] ?? 0,
            'total_rekening' => $row['total_rekening'] ?? $row['totalrekening'] ?? 0,
            'bulan'          => $this->bulan,
            'tahun'          => $this->tahun,
        ]);
    }

    public function headingRow(): int
    {
        return 1;
    }
}