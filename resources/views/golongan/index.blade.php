<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Golongan - PDAM Tirta Medal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .chart-container { position: relative; height: 400px; }
    </style>
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('rekap.index') }}">
            <i class="fas fa-arrow-left"></i> Kembali ke Rekap
        </a>
        <div>
            <a href="{{ route('golongan.export', request()->query()) }}" class="btn btn-danger btn-sm">
                <i class="fas fa-file-pdf"></i> Export PDF + Grafik
            </a>
        </div>
    </div>
</nav>

<div class="container-fluid py-4 px-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="fas fa-chart-line"></i> Monitoring & Evaluasi Pelanggan Terfilter</h4>
        </div>
        <div class="card-body">
            
            {{-- FORM PILIH PERIODE --}}
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card border-primary">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-calendar-alt"></i> Pilih Periode</h5>
                        </div>
                        <div class="card-body">
                            <form method="GET" class="row g-3" id="periodeForm">
                                <div class="col-md-3">
                                    <label class="form-label"><strong>Mode Periode</strong></label>
                                    <select name="mode" id="modeSelect" class="form-select" onchange="toggleCustomPeriod()">
                                        <option value="preset" {{ ($mode ?? 'preset') == 'preset' ? 'selected' : '' }}>Preset (3/6/12 Bulan)</option>
                                        <option value="custom" {{ ($mode ?? 'custom') == 'custom' ? 'selected' : '' }}>Custom (Pilih Manual)</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-3" id="presetSection" style="display: {{ ($mode ?? 'custom') == 'preset' ? 'block' : 'none' }};">
                                    <label class="form-label"><strong>Periode Tampilan</strong></label>
                                    <select name="periode" class="form-select">
                                        <option value="3" {{ ($periode ?? 3) == 3 ? 'selected' : '' }}>3 Bulan Terakhir</option>
                                        <option value="6" {{ ($periode ?? '') == 6 ? 'selected' : '' }}>6 Bulan Terakhir</option>
                                        <option value="12" {{ ($periode ?? '') == 12 ? 'selected' : '' }}>12 Bulan Terakhir</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-3" id="customBulanDari" style="display: {{ ($mode ?? 'custom') == 'custom' ? 'block' : 'none' }};">
                                    <label class="form-label"><strong>Bulan Mulai</strong></label>
                                    <select name="bulan_dari" class="form-select">
                                        <option value="">-- Pilih Bulan --</option>
                                        @foreach($bulanList as $kode => $nama)
                                            <option value="{{ $kode }}" {{ ($bulanDari ?? '') == $kode ? 'selected' : '' }}>{{ $nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-md-3" id="customBulanSampai" style="display: {{ ($mode ?? 'custom') == 'custom' ? 'block' : 'none' }};">
                                    <label class="form-label"><strong>Bulan Akhir</strong></label>
                                    <select name="bulan_sampai" class="form-select">
                                        <option value="">-- Pilih Bulan --</option>
                                        @foreach($bulanList as $kode => $nama)
                                            <option value="{{ $kode }}" {{ ($bulanSampai ?? '') == $kode ? 'selected' : '' }}>{{ $nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-md-2" id="customTahun" style="display: {{ ($mode ?? 'custom') == 'custom' ? 'block' : 'none' }};">
                                    <label class="form-label"><strong>Tahun</strong></label>
                                    <input type="number" name="tahun" class="form-control" value="{{ $tahun ?? date('Y') }}" min="2020" max="2030">
                                </div>
                                
                                <div class="col-md-1 d-flex align-items-end" id="customSubmit" style="display: {{ ($mode ?? 'custom') == 'custom' ? 'flex' : 'none' }};">
                                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- FORM FILTER DINAMIS --}}
            {{-- FORM FILTER DINAMIS --}}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card border-info">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-filter"></i> Filter Data Dinamis</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('golongan.index') }}" class="row g-3">
                    {{-- Hidden inputs untuk periode --}}
                    <input type="hidden" name="mode" value="{{ $mode ?? 'custom' }}">
                    @if(($mode ?? 'custom') == 'preset')
                        <input type="hidden" name="periode" value="{{ $periode ?? 3 }}">
                    @else
                        <input type="hidden" name="bulan_dari" value="{{ $bulanDari ?? '' }}">
                        <input type="hidden" name="bulan_sampai" value="{{ $bulanSampai ?? '' }}">
                        <input type="hidden" name="tahun" value="{{ $tahun ?? date('Y') }}">
                    @endif

                    <div class="col-md-3">
    <label class="form-label fw-bold"><i class="fas fa-map-marker-alt text-success"></i> Wilayah</label>
    <select name="filter_wilayah" class="form-select">
        <option value="">-- Semua Wilayah --</option>
        @foreach($wilayahList as $wil)
            @php
                // Ambil nama dari masterWilayah, jika tidak ada fallback ke Kode
                $namaWilayah = $masterWilayah[$wil] ?? 'Wilayah ' . $wil;
            @endphp
            <option value="{{ $wil }}" {{ (string)($filterWilayah ?? '') === (string)$wil ? 'selected' : '' }}>
                {{ $namaWilayah }} ({{ $wil }})
            </option>
        @endforeach
    </select>
</div>
                    
                   <div class="col-md-3">
    <label class="form-label fw-bold"><i class="fas fa-layer-group text-primary"></i> Golongan</label>
    <select name="filter_golongan" class="form-select">
        <option value="">-- Semua Golongan --</option>
        @php
            $master = $masterGolongan ?? [
                '12' => 'Sosial',
                '23' => 'Pemerintah',
                '28' => 'RT C',
                '29' => 'RT D',
                '31' => 'Niaga Besar',
            ];
        @endphp

        @foreach($master as $kode => $nama)
            <option value="{{ $kode }}" {{ (string)($filterGolongan ?? '') === (string)$kode ? 'selected' : '' }}>
                {{ $nama }} ({{ $kode }})
            </option>
        @endforeach
    </select>
</div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold"><i class="fas fa-tachometer-alt text-danger"></i> Kategori Pemakaian</label>
                        <select name="filter_kategori" class="form-select">
                            <option value="semua" {{ ($filterKategori ?? 'semua') === 'semua' ? 'selected' : '' }}>-- Semua Kategori --</option>
                            <option value="0" {{ ($filterKategori ?? '') === '0' ? 'selected' : '' }}>0 m³ (Tidak Pakai)</option>
                            <option value="1-10" {{ ($filterKategori ?? '') === '1-10' ? 'selected' : '' }}>1-10 m³ (Hemat)</option>
                            <option value="11-30" {{ ($filterKategori ?? '') === '11-30' ? 'selected' : '' }}>11-30 m³ (Normal)</option>
                            <option value=">30" {{ ($filterKategori ?? '') === '>30' ? 'selected' : '' }}> >30 m³ (Boros)</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold"><i class="fas fa-chart-pie text-warning"></i> Jenis Grafik</label>
                        <select name="chart_type" class="form-select">
                            <option value="bar" {{ ($chartType ?? 'bar') === 'bar' ? 'selected' : '' }}>📊 Bar (Batang)</option>
                            <option value="line" {{ ($chartType ?? '') === 'line' ? 'selected' : '' }}>📈 Line (Garis)</option>
                            <option value="radar" {{ ($chartType ?? '') === 'radar' ? 'selected' : '' }}>🕸️ Radar</option>
                            <option value="polarArea" {{ ($chartType ?? '') === 'polarArea' ? 'selected' : '' }}>🎯 Polar Area</option>
                        </select>
                    </div>

                    <div class="col-12 text-end mt-3">
                        <a href="{{ route('golongan.index') }}" class="btn btn-outline-secondary btn-sm me-2">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                        <button type="submit" class="btn btn-info text-white">
                            <i class="fas fa-search"></i> Terapkan Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

            {{-- INFO HASIL --}}
            <div class="alert alert-info d-flex justify-content-between align-items-center mb-4">
                <span><i class="fas fa-users"></i> Ditemukan: <strong>{{ count($validCustomers ?? []) }} Pelanggan</strong></span>
                <span class="fw-bold">Periode: {{ $bulanList[$bulanDari] ?? '-' }} - {{ $bulanList[$bulanSampai] ?? '-' }} {{ $tahun ?? '-' }}</span>
            </div>

            {{-- GRAFIK DINAMIS --}}
            @if(count($labels ?? []) > 0)
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card border-primary">
                        <div class="card-header bg-primary text-white d-flex justify-content-between">
                            <h5 class="mb-0"><i class="fas fa-chart-area"></i> Tren Pelanggan Terfilter (Dinamis)</h5>
                            <small>Filter aktif: {{ ucfirst($chartType ?? 'bar') }} Chart</small>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="golonganChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- TABEL DETAIL --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-list"></i> Daftar Detail Pelanggan</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                                <table class="table table-bordered table-striped table-sm mb-0 text-center align-middle">
                                    <thead class="table-light sticky-top">
                                        <tr>
                                            <th>No</th>
                                            <th>No Sambungan</th>
                                            <th class="text-start">Nama</th>
                                            <th class="text-start">Alamat</th>
                                            <th>Gol</th>
                                            <th>Rata-rata</th>
                                            <th>Kategori</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($validCustomers ?? [] as $index => $cust)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $cust['no_sambungan'] }}</td>
                                            <td class="text-start fw-semibold">{{ $cust['nama_pelanggan'] }}</td>
                                            <td class="text-start">{{ $cust['alamat'] }}</td>
                                            <td><span class="badge bg-secondary">{{ $cust['kode_gol'] }}</span></td>
                                            <td class="fw-bold">{{ $cust['avg_pakai'] }} m³</td>
                                            <td>
                                                @if($cust['kategori'] == '0') <span class="badge bg-danger">0 m³</span>
                                                @elseif($cust['kategori'] == '1-10') <span class="badge bg-success">1-10 m³</span>
                                                @elseif($cust['kategori'] == '11-30') <span class="badge bg-info text-dark">11-30 m³</span>
                                                @else <span class="badge bg-warning text-dark"> >30 m³</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-4">
                                                <i class="fas fa-search fa-2x mb-2 d-block"></i>
                                                Belum ada data. Pilih periode dan filter untuk memulai.
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script>
function toggleCustomPeriod() {
    const mode = document.getElementById('modeSelect').value;
    document.getElementById('presetSection').style.display = mode === 'preset' ? 'block' : 'none';
    document.getElementById('customBulanDari').style.display = mode === 'custom' ? 'block' : 'none';
    document.getElementById('customBulanSampai').style.display = mode === 'custom' ? 'block' : 'none';
    document.getElementById('customTahun').style.display = mode === 'custom' ? 'block' : 'none';
    document.getElementById('customSubmit').style.display = mode === 'custom' ? 'flex' : 'none';
}

const ctx = document.getElementById('golonganChart');
if (ctx) {
    const labels = @json($labels ?? []);
    const chartData = @json($chartData ?? []);
    const chartType = @json($chartType ?? 'bar');
    const colors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#C9CBCF'];

    // Register datalabels plugin untuk tampilkan angka
    Chart.register(ChartDataLabels);

    const datasets = Object.keys(chartData).map((gol, index) => ({
        label: 'Golongan ' + gol,
        data: chartData[gol],
        backgroundColor: colors[index % colors.length] + 'CC',
        borderColor: colors[index % colors.length],
        borderWidth: 2,
        tension: 0.3,
        fill: chartType === 'line'
    }));

    new Chart(ctx, {
        type: chartType,
        data: { labels: labels, datasets: datasets },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top', labels: { font: { size: 12 } } },
                tooltip: { 
                    mode: 'index', 
                    intersect: false,
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y + ' pelanggan';
                        }
                    }
                },
                // Konfigurasi DataLabels (angka di chart)
                datalabels: {
                    display: true,
                    color: '#333',
                    font: { weight: 'bold', size: 11 },
                    anchor: 'end',
                    align: 'top',
                    formatter: function(value) {
                        return value > 0 ? value : '';
                    }
                }
            },
            scales: {
                y: { 
                    beginAtZero: true, 
                    ticks: { stepSize: 1, font: { size: 11 } },
                    title: { display: true, text: 'Jumlah Pelanggan' }
                },
                x: { ticks: { font: { size: 11 } } }
            }
        }
    });
}
</script>
</body>
</html>