@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header"><h5>Tambah Laporan Gangguan</h5></div>
    <div class="card-body">
        <form action="{{ route('admin.gangguan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Jenis Gangguan *</label>
                    <select name="jenis_gangguan" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="transmisi">Transmisi</option>
                        <option value="distribusi">Distribusi</option>
                    </select>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label>Sumber/Jalur *</label>
                    <select name="sumber_jalur" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="ipa">IPA</option>
                        <option value="reservoir">Reservoir</option>
                        <option value="sumur_bor">Sumur Bor</option>
                        <option value="mata_air">Mata Air</option>
                        <option value="sungai">Sungai</option>
                        <option value="jalur_utama">Jalur Utama</option>
                        <option value="jalur_cabang">Jalur Cabang</option>
                        <option value="sambungan_rumah">Sambungan Rumah</option>
                    </select>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label>Tipe Kerusakan *</label>
                    <select name="tipe_kerusakan" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="bocor">Bocor</option>
                        <option value="pecah">Pecah</option>
                        <option value="mampet">Mampet</option>
                        <option value="korosi">Korosi</option>
                        <option value="rusak_ringan">Rusak Ringan</option>
                        <option value="rusak_berat">Rusak Berat</option>
                        <option value="valve_rusak">Valve Rusak</option>
                        <option value="meter_rusak">Meter Rusak</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label>Ukuran Pipa *</label>
                    <select name="ukuran_pipa" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="6 inch">6 inch</option>
                        <option value="4 inch">4 inch</option>
                        <option value="3 inch">3 inch</option>
                        <option value="2 inch">2 inch</option>
                        <option value="1.25 inch">1.25 inch</option>
                        <option value="1 inch">1 inch</option>
                        <option value="0.5 inch">0.5 inch</option>
                    </select>
                </div>
                
                <div class="col-12 mb-3">
                    <label>Lokasi *</label>
                    <input type="text" name="lokasi" class="form-control" required>
                </div>
                
                <div class="col-12 mb-3">
                    <label>Wilayah Terdampak *</label>
                    <input type="text" name="wilayah_terdampak" class="form-control" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label>Latitude *</label>
                    <input type="number" step="0.00000001" name="latitude" class="form-control" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label>Longitude *</label>
                    <input type="number" step="0.00000001" name="longitude" class="form-control" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label>Pelapor *</label>
                    <input type="text" name="pelapor" class="form-control" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label>No HP Pelapor *</label>
                    <input type="text" name="no_hp_pelapor" class="form-control" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label>Tanggal Laporan *</label>
                    <input type="date" name="tanggal_laporan" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label>Estimasi Selesai</label>
                    <input type="date" name="estimasi_selesai" class="form-control">
                </div>
                
                <div class="col-12 mb-3">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                </div>
                
                <div class="col-12 mb-3">
                    <label>Foto</label>
                    <input type="file" name="foto" class="form-control" accept="image/*">
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.gangguan.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection