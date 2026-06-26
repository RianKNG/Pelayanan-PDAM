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
        'coordinates', 
        'keterangan'
    ];
    
    protected $casts = [
        'coordinates' => 'array',  // ← TAMBAHKAN INI!
    ];
}