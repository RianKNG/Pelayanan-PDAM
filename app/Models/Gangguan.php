<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gangguan extends Model
{
     protected $table = 'gangguan';

    protected $fillable = [
        'kode_laporan', 'jenis_gangguan', 'sumber_jalur', 'tipe_kerusakan',
        'ukuran_pipa', 'lokasi', 'wilayah_terdampak', 'latitude', 'longitude',
        'foto', 'pelapor', 'no_hp_pelapor', 'status', 'deskripsi',
        'catatan_perbaikan', 'tanggal_laporan', 'estimasi_selesai',
        'selesai_diperbaiki', 'qr_code'
    ];

    protected $casts = [
        'tanggal_laporan' => 'date',
        'estimasi_selesai' => 'date',
        'selesai_diperbaiki' => 'datetime',
    ];

    public static function generateKodeLaporan()
    {
        $date = now()->format('Ymd');
        $lastId = self::whereDate('created_at', now())->count() + 1;
        return 'DRMJ/' . $date . '/' . str_pad($lastId, 3, '0', STR_PAD_LEFT);
    }

}
