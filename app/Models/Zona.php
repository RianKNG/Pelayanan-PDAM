<?php
// app/Models/Zona.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{
    use HasFactory;

    protected $table = 'zona';

    protected $fillable = [
        'nama_zona',
        'jenis_zona',
        'warna',
        'elevasi_min',
        'elevasi_max',
        'coordinates',
        'keterangan',
    ];

    protected $casts = [
        'coordinates' => 'array',
        'elevasi_min' => 'decimal:2',
        'elevasi_max' => 'decimal:2',
    ];
}