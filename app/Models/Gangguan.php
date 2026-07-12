<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gangguan extends Model
{
    // 🔥 PENTING: Nama tabel di database Anda adalah 'gangguan' (singular)
    protected $table = 'gangguan';

    protected $fillable = [
        'kode_laporan',
        'jenis_gangguan',
        'sumber_jalur',
        'tipe_kerusakan',
        'ukuran_pipa',
        'lokasi',
        'wilayah_terdampak',
        'latitude',
        'longitude',
        'foto',
        'pelapor',
        'no_hp_pelapor',
        'tanggal_laporan',
        'estimasi_selesai',
        'deskripsi',
        'status',
        'selesai_diperbaiki',
        'debit_bocor',
        'total_kehilangan_air',
        'durasi_jam',
        'catatan_perbaikan',
        'qr_code',
        // Kolom sumber laporan
        'sumber_laporan',
        'nik_karyawan', 'nama_karyawan', 'telp_karyawan',
        'no_pelanggan_lapor', 'nama_pelanggan_lapor', 'telp_pelanggan_lapor',
        'nik_non_pelanggan', 'nama_non_pelanggan', 'alamat_non_pelanggan', 'telp_non_pelanggan',
    ];

    protected $casts = [
        'tanggal_laporan' => 'date',
        'estimasi_selesai' => 'date',
        'selesai_diperbaiki' => 'datetime',
    ];

    // 🔥 INI YANG HILANG: Relasi ke tabel foto (Multiple Foto)
    public function fotos()
    {
        // Asumsi tabel foto Anda bernama 'gangguan_fotos'
        return $this->hasMany(GangguanFoto::class, 'gangguan_id')->orderBy('urutan');
    }

    // Helper generate kode laporan
    public static function generateKodeLaporan()
    {
        $last = self::latest()->first();
        if (!$last) return 'GGN-001';
        
        // Ambil angka dari kode laporan terakhir (misal GGN-001 -> 1)
        preg_match('/\d+/', $last->kode_laporan, $matches);
        $number = isset($matches[0]) ? (int) $matches[0] : 0;
        
        return 'GGN-' . str_pad($number + 1, 3, '0', STR_PAD_LEFT);
    }
}