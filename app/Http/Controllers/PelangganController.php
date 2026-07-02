<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggan = Pelanggan::with(['wilayah', 'golongan'])->get();
        return view('dashboard', compact('pelanggan'));
    }
    
    public function realtime()
    {
        $pelanggan = Pelanggan::with(['wilayah', 'golongan'])
            ->select([
                'no_pelanggan',
                'nama',
                'jumlah',
                'pakai',
                'kode_gol_trf',
                'nama_wilayah',
                'koordinator',
                'lokasi',
                'tanggal_pembayaran_loket',
                'tanggal_pembayaran_ppob'
            ])
            ->get();
            
        return response()->json([
            'success' => true,
            'pelanggan' => $pelanggan,
            'timestamp' => now()
        ]);
    }
    
}