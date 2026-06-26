<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TitikPenting extends Model
{
    protected $table = 'titik_penting';
    
    protected $fillable = [
        'nama_titik', 'jenis_titik', 'latitude', 
        'longitude', 'keterangan'
    ];
}