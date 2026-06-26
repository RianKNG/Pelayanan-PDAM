<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JalurPipa;
use App\Models\Bangunan;
use App\Models\TitikPenting;
use Illuminate\Http\Request;

class DrawingController extends Controller
{
    /**
     * Menampilkan halaman drawing
     */
    public function index()
    {
        return ('oke');
    }
    // public function index()
    // {
    //     $jalurPipa = JalurPipa::all();
    //     $bangunan = Bangunan::all();
    //     $titikPenting = TitikPenting::all();
        
    //     return view('admin.drawing.index', compact('jalurPipa', 'bangunan', 'titikPenting'));
    // }

    /**
     * Simpan jalur pipa
     */
    public function saveJalur(Request $request)
    {
        $validated = $request->validate([
            'nama_jalur' => 'required',
            'jenis_jalur' => 'required|in:transmisi,distribusi',
            'ukuran_pipa' => 'required',
            'warna' => 'required',
            'ketebalan' => 'required|integer',
            'coordinates' => 'required|json',
            'keterangan' => 'nullable'
        ]);

        JalurPipa::create($validated);
        
        return response()->json(['success' => true, 'message' => 'Jalur pipa disimpan']);
    }

    /**
     * Simpan bangunan
     */
    public function saveBangunan(Request $request)
    {
        $validated = $request->validate([
            'nama_bangunan' => 'required',
            'jenis_bangunan' => 'required',
            'warna' => 'required',
            'coordinates' => 'required|json',
            'keterangan' => 'nullable'
        ]);

        Bangunan::create($validated);
        
        return response()->json(['success' => true, 'message' => 'Bangunan disimpan']);
    }

    /**
     * Simpan titik penting
     */
    public function saveTitik(Request $request)
    {
        $validated = $request->validate([
            'nama_titik' => 'required',
            'jenis_titik' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'keterangan' => 'nullable'
        ]);

        TitikPenting::create($validated);
        
        return response()->json(['success' => true, 'message' => 'Titik penting disimpan']);
    }

    /**
     * Hapus jalur pipa
     */
    public function deleteJalur($id)
    {
        JalurPipa::destroy($id);
        return response()->json(['success' => true]);
    }

    /**
     * Hapus bangunan
     */
    public function deleteBangunan($id)
    {
        Bangunan::destroy($id);
        return response()->json(['success' => true]);
    }

    /**
     * Hapus titik penting
     */
    public function deleteTitik($id)
    {
        TitikPenting::destroy($id);
        return response()->json(['success' => true]);
    }
}