@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header"><h5>Edit Laporan Gangguan</h5></div>
    <div class="card-body">
        
        {{-- Menampilkan Pesan Error Validasi --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.gangguan.update', $gangguan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <!-- Jenis Gangguan -->
                <div class="col-md-6 mb-3">
                    <label>Jenis Gangguan *</label>
                    <select name="jenis_gangguan" class="form-control" required>
                        <option value="transmisi" {{ old('jenis_gangguan', $gangguan->jenis_gangguan) == 'transmisi' ? 'selected' : '' }}>Transmisi</option>
                        <option value="distribusi" {{ old('jenis_gangguan', $gangguan->jenis_gangguan) == 'distribusi' ? 'selected' : '' }}>Distribusi</option>
                    </select>
                </div>
                
                <!-- Sumber/Jalur -->
                <div class="col-md-6 mb-3">
                    <label>Sumber/Jalur *</label>
                    <select name="sumber_jalur" class="form-control" required>
                        @foreach(['ipa', 'reservoir', 'sumur_bor', 'mata_air', 'sungai', 'jalur_utama', 'jalur_cabang', 'sambungan_rumah'] as $opt)
                            <option value="{{ $opt }}" {{ old('sumber_jalur', $gangguan->sumber_jalur) == $opt ? 'selected' : '' }}>
                                {{ ucwords(str_replace('_', ' ', $opt)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Tipe Kerusakan -->
                <div class="col-md-6 mb-3">
                    <label>Tipe Kerusakan *</label>
                    <select name="tipe_kerusakan" class="form-control" required>
                        @foreach(['bocor', 'pecah', 'mampet', 'korosi', 'rusak_ringan', 'rusak_berat', 'valve_rusak', 'meter_rusak', 'lainnya'] as $opt)
                            <option value="{{ $opt }}" {{ old('tipe_kerusakan', $gangguan->tipe_kerusakan) == $opt ? 'selected' : '' }}>
                                {{ ucwords(str_replace('_', ' ', $opt)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Ukuran Pipa -->
                <div class="col-md-6 mb-3">
                    <label>Ukuran Pipa *</label>
                    <select name="ukuran_pipa" class="form-control" required>
                        @foreach(['6 inch', '4 inch', '3 inch', '2 inch', '1.25 inch', '1 inch', '0.5 inch'] as $opt)
                            <option value="{{ $opt }}" {{ old('ukuran_pipa', $gangguan->ukuran_pipa) == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Status -->
                <div class="col-md-6 mb-3">
                    <label>Status *</label>
                    <select name="status" class="form-control" required>
                        <option value="proses" {{ old('status', $gangguan->status) == 'proses' ? 'selected' : '' }}>Proses</option>
                        <option value="selesai" {{ old('status', $gangguan->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>

                <div class="col-12 mb-3">
                    <label>Lokasi *</label>
                    <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi', $gangguan->lokasi) }}" required>
                </div>
                
                <div class="col-12 mb-3">
                    <label>Wilayah Terdampak *</label>
                    <input type="text" name="wilayah_terdampak" class="form-control" value="{{ old('wilayah_terdampak', $gangguan->wilayah_terdampak) }}" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label>Latitude *</label>
                    <input type="number" step="0.00000001" name="latitude" class="form-control" value="{{ old('latitude', $gangguan->latitude) }}" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label>Longitude *</label>
                    <input type="number" step="0.00000001" name="longitude" class="form-control" value="{{ old('longitude', $gangguan->longitude) }}" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label>Pelapor *</label>
                    <input type="text" name="pelapor" class="form-control" value="{{ old('pelapor', $gangguan->pelapor) }}" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label>No HP Pelapor *</label>
                    <input type="text" name="no_hp_pelapor" class="form-control" value="{{ old('no_hp_pelapor', $gangguan->no_hp_pelapor) }}" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label>Tanggal Laporan *</label>
                    <input type="date" name="tanggal_laporan" class="form-control" value="{{ old('tanggal_laporan', $gangguan->tanggal_laporan) }}" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label>Estimasi Selesai</label>
                    <input type="date" name="estimasi_selesai" class="form-control" value="{{ old('estimasi_selesai', $gangguan->estimasi_selesai) }}">
                </div>
                
                <div class="col-12 mb-3">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $gangguan->deskripsi) }}</textarea>
                </div>
                
                <div class="col-12 mb-3">
                    <label>Foto</label>
                    @if($gangguan->foto)
                        <div class="mb-2">
                            <img src="{{ asset('storage/'.$gangguan->foto) }}" width="150" class="img-thumbnail">
                        </div>
                    @endif
                    <input type="file" name="foto" class="form-control" accept="image/*">
                    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto.</small>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.gangguan.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection