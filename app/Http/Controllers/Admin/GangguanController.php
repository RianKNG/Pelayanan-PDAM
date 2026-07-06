<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gangguan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GangguanController extends Controller
{
    public function index()
    {
        $gangguan = Gangguan::latest()->paginate(10);
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
    // 1. Validasi manual untuk menangkap error jika gagal
    $validator = \Validator::make($request->all(), [
        'jenis_gangguan' => 'required|in:transmisi,distribusi',
        'sumber_jalur' => 'required',
        'tipe_kerusakan' => 'required',
        'ukuran_pipa' => 'required',
        'lokasi' => 'required',
        'wilayah_terdampak' => 'required',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'foto' => 'nullable|mimes:jpeg,jpg,png,gif|max:2048',
        'pelapor' => 'required',
        'no_hp_pelapor' => 'required',
        'tanggal_laporan' => 'required|date',
        'estimasi_selesai' => 'nullable|date',
        'deskripsi' => 'nullable',
    ]);

    // 2. Jika validasi gagal, DD akan langsung menampilkan kolom mana yang error!
    if ($validator->fails()) {
        dd($validator->errors()->all());
    }

    // 3. Jika lolos validasi, ambil data yang sudah valid
    $validated = $validator->validated();

    if ($request->hasFile('foto')) {
        $validated['foto'] = $request->file('foto')->store('gangguan', 'public');
    }

    $validated['kode_laporan'] = Gangguan::generateKodeLaporan();
    $validated['status'] = 'menunggu';

    Gangguan::create($validated);

    return redirect()->route('admin.gangguan.index')
        ->with('success', 'Data berhasil ditambahkan');
}


    public function edit(Gangguan $gangguan)
{
    return view('admin.gangguan.edit', compact('gangguan'));
}

public function update(Request $request, Gangguan $gangguan)
{
    // 1. Validasi
    $validated = $request->validate([
        'jenis_gangguan' => 'required',
        'sumber_jalur' => 'required',
        'tipe_kerusakan' => 'required',
        'ukuran_pipa' => 'required',
        'lokasi' => 'required',
        'wilayah_terdampak' => 'required',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'pelapor' => 'required',
        'no_hp_pelapor' => 'required',
        'status' => 'required',
        'tanggal_laporan' => 'required|date',
        'estimasi_selesai' => 'nullable|date',
    ]);

    try {
        // 2. Logic tambahan
        if ($request->status === 'selesai' && !$gangguan->selesai_diperbaiki) {
            $validated['selesai_diperbaiki'] = now();
        }

        // 3. Update data
        $gangguan->update($validated);

        // 4. Redirect sukses
        return redirect()->route('admin.gangguan.index')
            ->with('success', 'Data berhasil diperbarui!');

    } catch (\Exception $e) {
        // 5. Redirect gagal
        return redirect()->back()
            ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())
            ->withInput(); // Mengembalikan inputan sebelumnya agar user tidak perlu mengisi ulang
    }
}

    public function destroy(Gangguan $gangguan)
    {
        if ($gangguan->foto) Storage::disk('public')->delete($gangguan->foto);
        $gangguan->delete();
        return back()->with('success', 'Data dihapus');
    }
    
}