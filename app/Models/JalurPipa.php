<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JalurPipa extends Model
{
    protected $table = 'jalur_pipa';
    
    protected $fillable = [
        'nama_jalur', 
        'jenis_jalur', 
        'ukuran_pipa', 
        'warna', 
        'ketebalan', 
        'coordinates', 
        'keterangan'
    ];
    
    protected $casts = [
        'coordinates' => 'array',  // ← TAMBAHKAN INI!
        'ketebalan' => 'integer'
    ];
}