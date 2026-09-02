<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bangunan extends Model
{
    protected $table = 'bangunan';
    
   protected $fillable = [
    'nama_bangunan',
    'jenis_bangunan',
    'warna',
    'keterangan',
    'coordinates',
    'ukuran_bangunan',    // <-- Tambahkan ini
    'elevasi',            // <-- Tambahkan ini
    'sumber_elevasi',     // <-- Tambahkan ini
];
    
    protected $casts = [
        'coordinates' => 'array',  // ← TAMBAHKAN INI!
    ];
}