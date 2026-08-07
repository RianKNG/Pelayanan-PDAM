<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Bulanan Dinamis - PDAM Tirta Medal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('rekap.index') }}">
            <i class="fas fa-arrow-left"></i> Kembali ke Upload
        </a>
        <div>
            <a href="{{ route('rekap.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-home"></i> Dashboard
            </a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                <i class="fas fa-calendar-alt"></i> Rekapitulasi Bulanan Dinamis
            </h4>
        </div>
        <div class="card-body">
            <form action="{{ route('rekap.bulanan.proses') }}" method="POST">
                @csrf
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label class="form-label"><strong>Bulan Dari</strong></label>
                        <select name="bulan_dari" class="form-select" required>
                            <option value="">-- Pilih Bulan --</option>
                            @foreach($bulanList as $kode => $nama)
                                <option value="{{ $kode }}">{{ $nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"><strong>Bulan Sampai</strong></label>
                        <select name="bulan_sampai" class="form-select" required>
                            <option value="">-- Pilih Bulan --</option>
                            @foreach($bulanList as $kode => $nama)
                                <option value="{{ $kode }}">{{ $nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"><strong>Tahun</strong></label>
                        <input type="number" name="tahun" class="form-control" 
                               value="{{ date('Y') }}" min="2020" max="2030" required>
                    </div>
                </div>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> 
                    <strong>Contoh:</strong> Pilih "Januari" sampai "Maret" untuk melihat data 3 bulan pertama
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-100">
                    <i class="fas fa-search"></i> Tampilkan Rekap
                </button>
            </form>
        </div>
    </div>

    <div class="card shadow mt-4">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="fas fa-history"></i> Periode Tersedia</h5>
        </div>
        <div class="card-body">
            @if($periodeTersedia->count() > 0)
                <div class="row">
                    @foreach($periodeTersedia as $periode)
                        <div class="col-md-3 mb-2">
                            <div class="p-2 bg-light rounded text-center">
                                <strong>{{ $bulanList[$periode->bulan] ?? $periode->bulan }}</strong>
                                {{ $periode->tahun }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted text-center">Belum ada data</p>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>