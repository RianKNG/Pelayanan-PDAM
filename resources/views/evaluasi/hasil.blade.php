<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluasi {{ $namaBulan }} {{ $tahun }} - PDAM Tirta Medal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('evaluasi.index') }}">
            <i class="fas fa-arrow-left"></i> Kembali ke Upload
        </a>
        <div>
            <a href="{{ route('golongan.index') }}" class="btn btn-light btn-sm">
                <i class="fas fa-chart-line"></i> Monitoring Golongan
            </a>
        </div>
    </div>
</nav>

<div class="container-fluid px-4">
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between">
            <h4 class="mb-0">
                <i class="fas fa-chart-line"></i> Evaluasi Tagihan {{ $namaBulan }} {{ $tahun }}
            </h4>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body text-center">
                            <h6>Total Pelanggan</h6>
                            <h2>{{ $totalPelanggan }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <h6>Total Pemakaian</h6>
                            <h2>{{ number_format($totalPakai, 0) }} m³</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body text-center">
                            <h6>Rata-rata</h6>
                            <h2>{{ number_format($rataPakai, 1) }} m³</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body text-center">
                            <h6>Total Revenue</h6>
                            <h2>Rp {{ number_format($totalRevenue, 0) }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card border-danger">
                        <div class="card-body text-center">
                            <h5 class="text-danger">
                                <i class="fas fa-exclamation-triangle"></i> {{ $tigaBulanNol->count() }}
                            </h5>
                            <p>3 Bulan 0 Kubik</p>
                            <a href="{{ route('evaluasi.cetakPdf', ['bulan' => $bulan, 'tahun' => $tahun, 'jenis' => '0_bulan']) }}" class="btn btn-danger btn-sm">
                                <i class="fas fa-file-pdf"></i> Cetak PDF
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-info">
                        <div class="card-body text-center">
                            <h5 class="text-info">{{ $pakai15_30->count() }}</h5>
                            <p>Pemakaian 15-30 m³</p>
                            <a href="{{ route('evaluasi.cetakPdf', ['bulan' => $bulan, 'tahun' => $tahun, 'jenis' => '15_30']) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-file-pdf"></i> Cetak PDF
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-warning">
                        <div class="card-body text-center">
                            <h5 class="text-warning">{{ $pakaiLebih30->count() }}</h5>
                            <p>Pemakaian > 30 m³</p>
                            <a href="{{ route('evaluasi.cetakPdf', ['bulan' => $bulan, 'tahun' => $tahun, 'jenis' => 'lebih_30']) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-file-pdf"></i> Cetak PDF
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-success">
                        <div class="card-body text-center">
                            <h5 class="text-success">{{ $totalPelanggan }}</h5>
                            <p>Semua Pelanggan</p>
                            <a href="{{ route('evaluasi.cetakPdf', ['bulan' => $bulan, 'tahun' => $tahun, 'jenis' => 'semua']) }}" class="btn btn-success btn-sm">
                                <i class="fas fa-file-pdf"></i> Cetak PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            @if($tigaBulanNol->count() > 0)
            <div class="card mb-4 border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-exclamation-triangle"></i> Pelanggan 3 Bulan 0 Kubik ({{ $tigaBulanNol->count() }})
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Sambungan</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>Gol</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tigaBulanNol as $index => $t)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $t->no_sambungan }}</td>
                                    <td>{{ $t->nama_pelanggan }}</td>
                                    <td>{{ $t->alamat }}</td>
                                    <td>{{ $t->kode_gol }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-chart-pie"></i> Statistik Per Golongan</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Golongan</th>
                                    <th>Jumlah</th>
                                    <th>Total Pakai (m³)</th>
                                    <th>Rata-rata (m³)</th>
                                    <th>Total Revenue</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($statGolongan as $sg)
                                <tr>
                                    <td><strong>{{ $sg->kode_gol }}</strong></td>
                                    <td>{{ $sg->jumlah }}</td>
                                    <td>{{ number_format($sg->total_pakai, 0) }}</td>
                                    <td>{{ number_format($sg->rata_pakai, 1) }}</td>
                                    <td>Rp {{ number_format($sg->total_revenue, 0) }}</td>
                                    <td>
                                        <a href="{{ route('evaluasi.cetakPdf', ['bulan' => $bulan, 'tahun' => $tahun, 'jenis' => 'golongan', 'golongan' => $sg->kode_gol]) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>