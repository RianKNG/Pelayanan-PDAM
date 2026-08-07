<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GolonganHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_sambungan', 'golongan_lama', 'golongan_baru',
        'tanggal_perubahan', 'alasan_perubahan', 'keterangan',
        'bulan', 'tahun'
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Tagihan::class, 'no_sambungan', 'no_sambungan');
    }

    public static function namaBulan($angka)
    {
        return Tagihan::namaBulan($angka);
    }
}