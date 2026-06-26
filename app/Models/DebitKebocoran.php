<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DebitKebocoran extends Model
{
    protected $table = 'debit_kebocoran';
    
    protected $fillable = [
        'ukuran_pipa',
        'tipe_kerusakan',
        'debit_bocor',
        'keterangan'
    ];
    
    protected $casts = [
        'debit_bocor' => 'decimal:2',
    ];
    
    /**
     * Get debit bocor berdasarkan ukuran pipa dan tipe kerusakan
     */
    public static function getDebitBocor($ukuranPipa, $tipeKerusakan)
    {
        $debit = self::where('ukuran_pipa', $ukuranPipa)
                   ->where('tipe_kerusakan', $tipeKerusakan)
                   ->first();
        
        return $debit ? $debit->debit_bocor : 0;
    }
}