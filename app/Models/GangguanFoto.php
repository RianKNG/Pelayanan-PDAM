<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GangguanFoto extends Model
{
    protected $table = 'gangguan_fotos';
    
    protected $fillable = [
        'gangguan_id',
        'foto_path',
        'keterangan',
        'urutan',
    ];

    public function gangguan()
    {
       // Tambahkan 'gangguan' (nama tabel Anda) sebagai argumen kedua
    return $this->belongsTo(Gangguan::class, 'gangguan_id', 'id');
    }
}