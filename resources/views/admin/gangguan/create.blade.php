@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h4>Tambah Data Gangguan</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.gangguan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Jenis Gangguan *</label>
                            <select name="jenis_gangguan" class="form-control" required>
                                <option value="">-- Pilih --</option>
                                <option value="transmisi">Transmisi</option>
                                <option value="distribusi">Distribusi</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Tipe Kerusakan *</label>
                            <select name="tipe_kerusakan" class="form-control" required>
                                <option value="">-- Pilih --</option>
                                <option value="bocor">Bocor</option>
                                <option value="pecah">Pecah</option>
                                <option value="mampet">Mampet</option>
                                <option value="rusak_ringan">Rusak Ringan</option>
                                <option value="rusak_berat">Rusak Berat</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Sumber Jalur *</label>
                            <input type="text" name="sumber_jalur" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Ukuran Pipa *</label>
                            <input type="text" name="ukuran_pipa" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Lokasi *</label>
                    <input type="text" name="lokasi" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Wilayah Terdampak *</label>
                    <input type="text" name="wilayah_terdampak" class="form-control" required>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Latitude *</label>
                            <input type="number" step="any" name="latitude" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Longitude *</label>
                            <input type="number" step="any" name="longitude" class="form-control" required>
                        </div>
                    </div>
                </div>

                {{-- 🔥 UPLOAD MULTIPLE FOTO --}}
                <div class="mb-3">
                    <label>Foto Gangguan (Maksimal 10 foto)</label>
                    <input type="file" name="fotos[]" class="form-control" multiple accept="image/*" id="fotoInput">
                    <small class="text-muted">Anda bisa pilih beberapa foto sekaligus</small>
                    
                    {{-- Preview --}}
                    <div id="fotoPreview" class="mt-2 d-flex flex-wrap gap-2"></div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Pelapor *</label>
                            <input type="text" name="pelapor" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>No HP Pelapor *</label>
                            <input type="text" name="no_hp_pelapor" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Tanggal Laporan *</label>
                            <input type="date" name="tanggal_laporan" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Estimasi Selesai</label>
                            <input type="date" name="estimasi_selesai" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('admin.gangguan.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </form>
        </div>
    </div>
</div>

<script>
// 🔥 Preview Multiple Foto
document.getElementById('fotoInput').addEventListener('change', function(e) {
    const preview = document.getElementById('fotoPreview');
    preview.innerHTML = '';
    
    if (this.files) {
        Array.from(this.files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'position-relative';
                div.innerHTML = `
                    <img src="${e.target.result}" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                    <div class="badge bg-primary position-absolute top-0 start-0 m-1">${index + 1}</div>
                `;
                preview.appendChild(div);
            }
            reader.readAsDataURL(file);
        });
    }
});
</script>
@endsection