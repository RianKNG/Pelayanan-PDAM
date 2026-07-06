<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TitikPenting extends Model
{
    // app/Models/TitikPenting.php - tambahkan 'elevasi' di fillable & casts
    protected $table = 'titik_penting';
protected $fillable = [
    'nama_titik',
    'jenis_titik',
    'latitude',
    'longitude',
    'elevasi', // BARU
    'keterangan',
];

protected $casts = [
    'latitude' => 'decimal:8',
    'longitude' => 'decimal:8',
    'elevasi' => 'decimal:2', // BARU
];
}