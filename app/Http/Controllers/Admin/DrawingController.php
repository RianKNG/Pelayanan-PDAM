<?php
// app/Http/Controllers/Admin/DrawingController.php

namespace App\Http\Controllers\Admin; // ← UBAH: Tambah \Admin

use App\Http\Controllers\Controller;
use App\Models\JalurPipa;
use App\Models\Bangunan;
use App\Models\TitikPenting;
use App\Models\Zona;
use Illuminate\Http\Request;

class DrawingController extends Controller
{
    public function index()
    {
        $jalurPipa = JalurPipa::all();
        $bangunan = Bangunan::all();
        $titikPenting = TitikPenting::all();
        $zonaList = Zona::all();

        return view('admin.drawing.index', compact(
            'jalurPipa',
            'bangunan',
            'titikPenting',
            'zonaList'
        ));
    }

    public function saveJalur(Request $request)
    {
        $request->validate([
            'nama_jalur' => 'required|string',
            'jenis_jalur' => 'required|in:transmisi,distribusi,tersier',
            'ukuran_pipa' => 'required|string',
            'warna' => 'required|string',
            'ketebalan' => 'nullable|integer',
            'keterangan' => 'nullable|string',
            'coordinates' => 'required',
        ]);

        $jalur = JalurPipa::create([
            'nama_jalur' => $request->nama_jalur,
            'jenis_jalur' => $request->jenis_jalur,
            'ukuran_pipa' => $request->ukuran_pipa,
            'warna' => $request->warna,
            'ketebalan' => $request->ketebalan ?? 4,
            'keterangan' => $request->keterangan,
            'coordinates' => $request->coordinates,
        ]);

        return response()->json(['success' => true, 'data' => $jalur]);
    }

    public function saveBangunan(Request $request)
    {
        $request->validate([
            'nama_bangunan' => 'required|string',
            'jenis_bangunan' => 'required|string',
            'warna' => 'required|string',
            'keterangan' => 'nullable|string',
            'coordinates' => 'required',
        ]);

        $bangunan = Bangunan::create([
            'nama_bangunan' => $request->nama_bangunan,
            'jenis_bangunan' => $request->jenis_bangunan,
            'warna' => $request->warna,
            'keterangan' => $request->keterangan,
            'coordinates' => $request->coordinates,
        ]);

        return response()->json(['success' => true, 'data' => $bangunan]);
    }

    public function saveTitik(Request $request)
    {
        $request->validate([
            'nama_titik' => 'required|string',
            'jenis_titik' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'elevasi' => 'nullable|numeric',
            'keterangan' => 'nullable|string',
        ]);

        $titik = TitikPenting::create([
            'nama_titik' => $request->nama_titik,
            'jenis_titik' => $request->jenis_titik,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'elevasi' => $request->elevasi,
            'keterangan' => $request->keterangan,
        ]);

        return response()->json(['success' => true, 'data' => $titik]);
    }

    public function saveZona(Request $request)
    {
        $request->validate([
            'nama_zona' => 'required|string',
            'jenis_zona' => 'required|string',
            'warna' => 'required|string',
            'elevasi_min' => 'nullable|numeric',
            'elevasi_max' => 'nullable|numeric',
            'keterangan' => 'nullable|string',
            'coordinates' => 'required',
        ]);

        $zona = Zona::create([
            'nama_zona' => $request->nama_zona,
            'jenis_zona' => $request->jenis_zona,
            'warna' => $request->warna,
            'elevasi_min' => $request->elevasi_min,
            'elevasi_max' => $request->elevasi_max,
            'keterangan' => $request->keterangan,
            'coordinates' => $request->coordinates,
        ]);

        return response()->json(['success' => true, 'data' => $zona]);
    }

    public function deleteJalur($id)
    {
        JalurPipa::destroy($id);
        return response()->json(['success' => true]);
    }

    public function deleteBangunan($id)
    {
        Bangunan::destroy($id);
        return response()->json(['success' => true]);
    }

    public function deleteTitik($id)
    {
        TitikPenting::destroy($id);
        return response()->json(['success' => true]);
    }

    public function deleteZona($id)
    {
        Zona::destroy($id);
        return response()->json(['success' => true]);
    }
}