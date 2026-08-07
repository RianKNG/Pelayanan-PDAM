<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Tagihan - PDAM Tirta Medal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('rekap.index') }}">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
        <div>
            <a href="{{ route('rekap.bulanan') }}" class="btn btn-light btn-sm">
                <i class="fas fa-table"></i> Rekap Bulanan
            </a>
            <a href="{{ route('rekap.tigaBulanNol') }}" class="btn btn-warning btn-sm">
                <i class="fas fa-exclamation-triangle"></i> 3 Bulan 0
            </a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-upload"></i> Upload Data Tagihan Excel</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('rekap.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label"><strong>Bulan</strong></label>
                                <select name="bulan" class="form-select" required>
                                    <option value="">-- Pilih Bulan --</option>
                                    @foreach($bulanList as $kode => $nama)
                                        <option value="{{ $kode }}">{{ $nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><strong>Tahun</strong></label>
                                <input type="number" name="tahun" class="form-control" 
                                       value="{{ date('Y') }}" min="2020" max="2030" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><strong>File Excel</strong></label>
                            <input type="file" name="file" class="form-control" 
                                   accept=".xlsx,.xls,.csv" required>
                            <small class="text-muted">Format: xlsx, xls, atau csv</small>
                        </div>

                        <div class="alert alert-info">
                            <strong>📋 Format Kolom Excel:</strong>
                            <ul class="mb-0 mt-2">
                                <li>No Sambungan, No Rekening, Nama Pelanggan, Alamat</li>
                                <li>Kode Gol, Stand Awal, Stand Akhir, Pakai</li>
                                <li>Harga Air, Beban Tetap, Materai, Total Rekening</li>
                            </ul>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-upload"></i> Upload Data
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-history"></i> Periode Tersedia</h5>
                </div>
                <div class="card-body">
                    @if($periodeTersedia->count() > 0)
                        @foreach($periodeTersedia as $periode)
                            <div class="d-flex justify-content-between align-items-center mb-2 p-2 bg-light rounded">
                                <span>
                                    <strong>{{ $bulanList[$periode->bulan] ?? $periode->bulan }}</strong>
                                    {{ $periode->tahun }}
                                </span>
                                <span class="badge bg-success">{{ $periode->bulan }}</span>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted text-center">Belum ada data</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>