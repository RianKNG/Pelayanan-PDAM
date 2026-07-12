<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gangguan;
use App\Models\GangguanFoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GangguanController extends Controller
{
    public function index()
    {
        $gangguan = Gangguan::with('fotos')->latest()->paginate(10);
        $stats = [
            'total' => Gangguan::count(),
            'menunggu' => Gangguan::where('status', 'menunggu')->count(),
            'dalam_proses' => Gangguan::where('status', 'dalam_proses')->count(),
            'selesai' => Gangguan::where('status', 'selesai')->count(),
        ];
        return view('admin.gangguan.index', compact('gangguan', 'stats'));
    }

    public function create()
    {
        return view('admin.gangguan.create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'jenis_gangguan' => 'required|in:transmisi,distribusi',
        'sumber_jalur' => 'required',
        'tipe_kerusakan' => 'required',
        'ukuran_pipa' => 'required',
        'lokasi' => 'required',
        'wilayah_terdampak' => 'required',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'foto' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        'foto_tambahan.*' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        'pelapor' => 'required',
        'no_hp_pelapor' => 'required',
        'tanggal_laporan' => 'required|date',
        'estimasi_selesai' => 'nullable|date',
        'deskripsi' => 'nullable',
    ]);

    // Upload foto utama
    if ($request->hasFile('foto')) {
        $validated['foto'] = $request->file('foto')->store('gangguan', 'public');
    }

    // 🔥 Upload foto tambahan
    $fotoTambahan = [];
    if ($request->hasFile('foto_tambahan')) {
        foreach ($request->file('foto_tambahan') as $file) {
            $fotoTambahan[] = $file->store('gangguan', 'public');
        }
    }
    $validated['foto_tambahan'] = !empty($fotoTambahan) ? $fotoTambahan : null;

    $validated['kode_laporan'] = Gangguan::generateKodeLaporan();
    $validated['status'] = 'menunggu';

    Gangguan::create($validated);

    return redirect()->route('admin.gangguan.index')
        ->with('success', 'Data gangguan berhasil ditambahkan');
}
// ============================================
// 🔥 METHOD EDIT - TAMPILKAN FORM EDIT
// ============================================
public function edit(Gangguan $gangguan)
{
    // Load relasi fotos agar bisa ditampilkan di form
    $gangguan->load('fotos');
    
    return view('admin.gangguan.edit', compact('gangguan'));
}

public function update(Request $request, Gangguan $gangguan)
{
    $validated = $request->validate([
        'jenis_gangguan' => 'required',
        'sumber_jalur' => 'required',
        'tipe_kerusakan' => 'required',
        'ukuran_pipa' => 'required',
        'lokasi' => 'required',
        'wilayah_terdampak' => 'required',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'foto' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        'foto_tambahan.*' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        'status' => 'required',
        'tanggal_laporan' => 'required|date',
        'estimasi_selesai' => 'nullable|date',
        'deskripsi' => 'nullable',
    ]);

    // Upload foto utama baru (jika ada)
    if ($request->hasFile('foto')) {
        // Hapus foto lama
        if ($gangguan->foto) {
            Storage::disk('public')->delete($gangguan->foto);
        }
        $validated['foto'] = $request->file('foto')->store('gangguan', 'public');
    }

    // 🔥 Tambah foto tambahan baru
    if ($request->hasFile('foto_tambahan')) {
        $fotoTambahan = $gangguan->foto_tambahan ?? [];
        foreach ($request->file('foto_tambahan') as $file) {
            $fotoTambahan[] = $file->store('gangguan', 'public');
        }
        $validated['foto_tambahan'] = $fotoTambahan;
    }

    $gangguan->update($validated);

    return redirect()->route('admin.gangguan.index')
        ->with('success', 'Data gangguan berhasil diperbarui');
}

    // 🔥 METHOD BARU: Hapus 1 foto spesifik
    public function destroyFoto(GangguanFoto $foto)
    {
        $gangguanId = $foto->gangguan_id;
        
        // Hapus file
        if ($foto->foto_path) {
            Storage::disk('public')->delete($foto->foto_path);
        }
        
        $foto->delete();

        return redirect()->back()->with('success', 'Foto berhasil dihapus');
    }

    public function destroy(Gangguan $gangguan)
    {
        // Hapus semua foto terkait
        foreach ($gangguan->fotos as $foto) {
            if ($foto->foto_path) {
                Storage::disk('public')->delete($foto->foto_path);
            }
        }
        
        // Hapus foto utama (backward compatibility)
        if ($gangguan->foto) {
            Storage::disk('public')->delete($gangguan->foto);
        }
        
        $gangguan->delete();
        return back()->with('success', 'Data dihapus');
    }
}