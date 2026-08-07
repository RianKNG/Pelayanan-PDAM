<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Rekap - PDAM Tirta Medal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('rekap.bulanan') }}"><i class="fas fa-arrow-left"></i> Kembali ke Pilih Periode</a>
        <a href="{{ route('rekap.bulanan.pdf', ['bulan_dari' => $bulanDari, 'bulan_sampai' => $bulanSampai, 'tahun' => $tahun, 'filter' => $filterKategori]) }}" class="btn btn-danger btn-sm">
            <i class="fas fa-file-pdf"></i> Download PDF
        </a>
    </div>
</nav>

<div class="container-fluid px-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="fas fa-table"></i> Rekap: {{ $bulanList[$bulanDari] }} - {{ $bulanList[$bulanSampai] }} {{ $tahun }}</h4>
        </div>
        <div class="card-body">
            
            {{-- ✅ FORM FILTER PENCARIAN DINAMIS --}}
            <form method="GET" action="{{ route('rekap.bulanan.proses') }}" class="mb-4 p-3 bg-light rounded border">
                <input type="hidden" name="bulan_dari" value="{{ $bulanDari }}">
                <input type="hidden" name="bulan_sampai" value="{{ $bulanSampai }}">
                <input type="hidden" name="tahun" value="{{ $tahun }}">
                
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-bold"><i class="fas fa-tachometer-alt text-danger"></i> Kategori Pemakaian</label>
                        <select name="filter_kategori" class="form-select">
                            <option value="semua" {{ $filterKategori == 'semua' ? 'selected' : '' }}>-- Semua Kategori --</option>
                            <option value="0" {{ $filterKategori == '0' ? 'selected' : '' }}>0 m³ (Tidak Pakai)</option>
                            <option value="1-10" {{ $filterKategori == '1-10' ? 'selected' : '' }}>1-10 m³ (Hemat)</option>
                            <option value="11-30" {{ $filterKategori == '11-30' ? 'selected' : '' }}>11-30 m³ (Normal)</option>
                            <option value=">30" {{ $filterKategori == '>30' ? 'selected' : '' }}> >30 m³ (Boros)</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label fw-bold"><i class="fas fa-layer-group text-primary"></i> Golongan</label>
                        <select name="filter_golongan" class="form-select">
                            <option value="">-- Semua Golongan --</option>
                            @foreach($golonganList as $gol)
                                <option value="{{ $gol }}" {{ $filterGolongan == $gol ? 'selected' : '' }}>Golongan {{ $gol }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold"><i class="fas fa-map-marker-alt text-success"></i> Wilayah (6 digit)</label>
                        <select name="filter_wilayah" class="form-select">
                            <option value="">-- Semua Wilayah --</option>
                            @foreach($wilayahList as $wil)
                                <option value="{{ $wil }}" {{ $filterWilayah == $wil ? 'selected' : '' }}>Wilayah {{ $wil }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Cari
                        </button>
                        <a href="{{ route('rekap.bulanan.proses', ['bulan_dari' => $bulanDari, 'bulan_sampai' => $bulanSampai, 'tahun' => $tahun]) }}" class="btn btn-secondary">
                            <i class="fas fa-redo"></i>
                        </a>
                    </div>
                </div>
            </form>

            {{-- INFORMASI HASIL PENCARIAN --}}
            <div class="alert alert-info d-flex justify-content-between align-items-center">
                <span>
                    <i class="fas fa-users"></i> 
                    Ditemukan: <strong>{{ count($tabelData) }} Pelanggan</strong> 
                    @if($filterKategori != 'semua' || $filterGolongan != '' || $filterWilayah != '')
                        yang sesuai dengan filter.
                    @else
                        pada periode ini.
                    @endif
                </span>
                <span class="fw-bold">
                    Total Pemakaian: {{ number_format(array_sum(array_column($tabelData, 'total_pakai')), 0) }} m³
                </span>
            </div>

            @if(count($tabelData) === 0)
                <div class="alert alert-warning text-center">
                    <i class="fas fa-exclamation-circle"></i> Tidak ada data pelanggan yang sesuai dengan filter yang dipilih.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-sm text-center align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th rowspan="2">No</th>
                                <th rowspan="2">No Sambungan</th>
                                <th rowspan="2" class="text-start">Nama Pelanggan</th>
                                <th rowspan="2" class="text-start">Alamat</th>
                                <th rowspan="2">Gol</th>
                                <th colspan="{{ count($listBulan) }}">Pemakaian per Bulan (m³)</th>
                                <th rowspan="2">Total</th>
                                <th rowspan="2">Rata-rata</th>
                                <th rowspan="2">Kategori</th>
                            </tr>
                            <tr>
                                @foreach($listBulan as $bulan)
                                    <th style="font-size: 11px;">{{ $bulanList[$bulan] }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tabelData as $index => $row)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $row['no_sambungan'] }}</td>
                                <td class="text-start fw-semibold">{{ $row['nama_pelanggan'] }}</td>
                                <td class="text-start">{{ $row['alamat'] }}</td>
                                <td><span class="badge bg-secondary">{{ $row['kode_gol'] }}</span></td>
                                @foreach($listBulan as $bulan)
                                    <td>
                                        @if($row['data_per_bulan'][$bulan] == 0)
                                            <span class="badge bg-danger">0</span>
                                        @else
                                            {{ $row['data_per_bulan'][$bulan] }}
                                        @endif
                                    </td>
                                @endforeach
                                <td class="fw-bold">{{ $row['total_pakai'] }}</td>
                                <td class="fw-bold">{{ number_format($row['rata_pakai'], 1) }}</td>
                                <td>
                                    @if($row['kategori'] == '0')
                                        <span class="badge bg-danger">0 m³</span>
                                    @elseif($row['kategori'] == '1-10')
                                        <span class="badge bg-success">1-10 m³</span>
                                    @elseif($row['kategori'] == '11-30')
                                        <span class="badge bg-info text-dark">11-30 m³</span>
                                    @elseif($row['kategori'] == '>30')
                                        <span class="badge bg-warning text-dark"> >30 m³</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-secondary fw-bold">
                            <tr>
                                <td colspan="5" class="text-end">TOTAL:</td>
                                @foreach($listBulan as $bulan)
                                    <td>{{ array_sum(array_column($tabelData, 'data_per_bulan.' . $bulan)) }}</td>
                                @endforeach
                                <td>{{ array_sum(array_column($tabelData, 'total_pakai')) }}</td>
                                <td>{{ number_format(array_sum(array_column($tabelData, 'rata_pakai')) / max(count($tabelData), 1), 1) }}</td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>