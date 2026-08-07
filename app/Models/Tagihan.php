<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_sambungan', 'no_rekening', 'nama_pelanggan', 'alamat',
        'kode_gol', 'stand_awal', 'stand_akhir', 'pakai',
        'harga_air', 'beban_tetap', 'materai', 'total_rekening',
        'bulan', 'tahun'
    ];

    public static function namaBulan($angka)
    {
        $bulan = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
            '04' => 'April', '05' => 'Mei', '06' => 'Juni',
            '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
            '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];
        return $bulan[$angka] ?? $angka;
    }

    public function scopePeriode($query, $bulan, $tahun)
    {
        return $query->where('bulan', $bulan)->where('tahun', $tahun);
    }

    public function scopeGolongan($query, $kodeGol)
    {
        return $query->where('kode_gol', $kodeGol);
    }
}