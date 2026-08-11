<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluasi Tagihan Pelanggan</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-custom {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body class="bg-light">

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold m-0 text-dark">📊 Evaluasi Tagihan Pelanggan</h4>
        
        <!-- Filter Periode -->
        <form method="GET" action="{{ route('evaluasi.index') }}" class="d-flex gap-2">
            <input type="hidden" name="filter_mode" value="{{ $filterMode }}">
            <select name="bulan" class="form-select form-select-sm">
                @foreach(range(1, 12) as $m)
                    @php $mPad = str_pad($m, 2, '0', STR_PAD_LEFT); @endphp
                    <option value="{{ $mPad }}" {{ $bulan == $mPad ? 'selected' : '' }}>
                        {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                    </option>
                @endforeach
            </select>
            <select name="tahun" class="form-select form-select-sm">
                @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                    <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
            <button type="submit" class="btn btn-sm btn-primary">Filter</button>
        </form>
    </div>

    <!-- Tombol Mode Switcher -->
    <div class="card card-custom mb-4">
        <div class="card-body p-2 d-flex gap-2">
            <a href="{{ route('evaluasi.index', ['filter_mode' => 'pemakaian', 'bulan' => $bulan, 'tahun' => $tahun]) }}" 
               class="btn btn-sm {{ $filterMode === 'pemakaian' ? 'btn-primary fw-bold' : 'btn-outline-secondary' }}">
                💧 Pemakaian
            </a>
            <a href="{{ route('evaluasi.index', ['filter_mode' => 'wilayah', 'bulan' => $bulan, 'tahun' => $tahun]) }}" 
               class="btn btn-sm {{ $filterMode === 'wilayah' ? 'btn-primary fw-bold' : 'btn-outline-secondary' }}">
                📍Blok
            </a>
            <a href="{{ route('evaluasi.index', ['filter_mode' => 'golongan', 'bulan' => $bulan, 'tahun' => $tahun]) }}" 
               class="btn btn-sm {{ $filterMode === 'golongan' ? 'btn-primary fw-bold' : 'btn-outline-secondary' }}">
                🏷️ Golongan
            </a>
        </div>
    </div>

    <!-- Section GRAFIK (Warna-Warni Batang + Pilihan Jenis Grafik) -->
    <div class="card card-custom mb-4">
        <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center py-3">
            <span>📈 Grafik Distribusi - {{ strtoupper($filterMode) }} ({{ $bulan }}/{{ $tahun }})</span>
            
            <!-- Pilihan Jenis Grafik -->
            <div class="d-flex align-items-center gap-2">
                <label for="chartType" class="form-label mb-0 small text-muted">Tipe Grafik:</label>
                <select id="chartType" class="form-select form-select-sm w-auto fw-bold text-primary">
                    <option value="bar">📊 Batang (Bar)</option>
                    <option value="line">📈 Garis (Line)</option>
                    <option value="doughnut">🍩 Donut (Doughnut)</option>
                    <option value="pie">🥧 Pai (Pie)</option>
                </select>
            </div>
        </div>
        <div class="card-body" style="height: 360px;">
            <canvas id="evaluasiChart"></canvas>
        </div>
    </div>

    <!-- Section TABEL RINGKASAN -->
    <div class="card card-custom mb-4">
        <div class="card-header bg-white fw-bold py-3">
            📋 Ringkasan Data Berdasarkan {{ ucfirst($filterMode) }}
        </div>
        <div class="card-body p-0">
            @if($filterMode === 'wilayah')
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Kode Wilayah</th>
                                <th>Jumlah Pelanggan</th>
                                <th>Total Pakai (m³)</th>
                                <th>Rata-rata Pakai (m³)</th>
                                <th>Total Revenue (Rp)</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dataPerWilayah as $w)
    <tr>
        <td>
            {{-- Ubah $w->kode_wilayah menjadi $w->nama_wilayah --}}
            <span class="badge bg-success">
                {{ $w->nama_wilayah }}
            </span>
        </td>
        <td>{{ number_format($w->jumlah_pelanggan) }}</td>
        <td>{{ number_format($w->total_pakai, 1) }}</td>
        <td>{{ number_format($w->avg_pakai, 1) }}</td>
        <td>Rp {{ number_format($w->total_revenue) }}</td>
        <td>
            <a href="{{ route('evaluasi.index', [
                'bulan' => $bulan,
                'tahun' => $tahun,
                'filter_mode' => 'wilayah',
                'detail_type' => 'wilayah',
                'detail_value' => $w->kode_wilayah_param
            ]) }}" class="btn btn-sm btn-info">
                <i class="fas fa-eye"></i> Lihat List
            </a>
        </td>
    </tr>
    @endforeach
                        </tbody>
                    </table>
                </div>
            @elseif($filterMode === 'golongan')
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Kode Golongan</th>
                                <th>Jumlah Pelanggan</th>
                                <th>Total Pakai (m³)</th>
                                <th>Rata-rata Pakai (m³)</th>
                                <th>Total Revenue (Rp)</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dataPerGolongan as $g)
                            <tr>
                                <td>
    <span class="badge bg-success">
        {{ $masterGolongan[$g->kode_gol] ?? $g->kode_gol }}
    </span>
</td>
                                <td>{{ number_format($g->jumlah_pelanggan) }}</td>
                                <td>{{ number_format($g->total_pakai) }}</td>
                                <td>{{ number_format($g->avg_pakai, 1) }}</td>
                                <td>Rp {{ number_format($g->total_revenue) }}</td>
                                <td>
                                    <a href="{{ route('evaluasi.index', ['bulan' => $bulan, 'tahun' => $tahun, 'filter_mode' => 'golongan', 'detail_type' => 'golongan', 'detail_value' => $g->kode_gol]) }}#detailSection" 
                                       class="btn btn-sm btn-info text-white">
                                        👁️ Lihat List
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <!-- Mode Pemakaian -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Kategori Pemakaian</th>
                                <th>Jumlah Pelanggan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Kategori 0 m3 -->
<tr>
    <td><span class="badge bg-danger">Pemakaian 0 m³</span></td>
    <td>{{ $pelanggan0->total() }}</td>
    <td>
        <a href="{{ route('evaluasi.index', ['bulan'=>$bulan, 'tahun'=>$tahun, 'filter_mode'=>'pemakaian', 'detail_type'=>'kategori', 'detail_value'=>'0']) }}" class="btn btn-sm btn-info">Lihat List</a>
    </td>
</tr>

<!-- Kategori 1 - 14 m3 (BARU) -->
<tr>
    <td><span class="badge bg-primary">Pemakaian 1 - 10 m³</span></td>
    <td>{{ $pelanggan1_10->total() }}</td>
    <td>
        <a href="{{ route('evaluasi.index', ['bulan'=>$bulan, 'tahun'=>$tahun, 'filter_mode'=>'pemakaian', 'detail_type'=>'kategori', 'detail_value'=>'1_10']) }}" class="btn btn-sm btn-info">Lihat List</a>
    </td>
</tr>

<!-- Kategori 15 - 30 m3 -->
<tr>
    <td><span class="badge bg-warning text-dark">Pemakaian 11 - 30 m³</span></td>
    <td>{{ $pelanggan11_30->total() }}</td>
    <td>
        <a href="{{ route('evaluasi.index', ['bulan'=>$bulan, 'tahun'=>$tahun, 'filter_mode'=>'pemakaian', 'detail_type'=>'kategori', 'detail_value'=>'11_30']) }}" class="btn btn-sm btn-info">Lihat List</a>
    </td>
</tr>

<!-- Kategori > 30 m3 -->
<tr>
    <td><span class="badge bg-success">Pemakaian > 30 m³</span></td>
    <td>{{ $pelangganAbove30->total() }}</td>
    <td>
        <a href="{{ route('evaluasi.index', ['bulan'=>$bulan, 'tahun'=>$tahun, 'filter_mode'=>'pemakaian', 'detail_type'=>'kategori', 'detail_value'=>'above_30']) }}" class="btn btn-sm btn-info">Lihat List</a>
    </td>
</tr>
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Section TABEL DETAIL LIST PELANGGAN -->
    @if($detailData)
    <div class="card card-custom border border-info mb-4" id="detailSection">
        <div class="card-header bg-info text-white fw-bold d-flex justify-content-between align-items-center py-3">
            <span>📋 Detail List Pelanggan: {{ strtoupper(str_replace('_', ' ', $detailType)) }} ({{ $detailValue }})</span>
            <span class="badge bg-light text-dark">Total: {{ is_countable($detailData) ? count($detailData) : $detailData->total() }}</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No Sambungan</th>
                            <th>Nama Pelanggan</th>
                            <th>Golongan</th>
                            <th>Pemakaian (m³)</th>
                            <th>Total Rekening (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($detailData as $item)
                        <tr>
                            <td><code>{{ $item->no_sambungan }}</code></td>
                            <td>{{ $item->nama_pelanggan }}</td>
                            <td><span class="badge bg-secondary">{{ $item->kode_gol }}</span></td>
                            <td><strong>{{ $item->pakai }}</strong> m³</td>
                            <td>Rp {{ number_format($item->total_rekening) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-3 text-muted">Data detail tidak ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if(method_exists($detailData, 'links'))
    <div class="p-3 d-flex justify-content-center">
        {{ $detailData->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
@endif
        </div>
    </div>
    @endif
</div>

<!-- Library ChartJS + Plugin DataLabels -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Register plugin datalabels
        Chart.register(ChartDataLabels);

        const ctx = document.getElementById('evaluasiChart').getContext('2d');
        const chartLabels = {!! json_encode($chartLabels) !!};
        const chartData = {!! json_encode($chartData) !!};

        // Palet Warna Keren, Terang, & Beragam untuk Setiap Batang
        const multiColors = [
            '#4f46e5', // Indigo
            '#06b6d4', // Cyan
            '#10b981', // Emerald / Green
            '#f59e0b', // Amber / Yellow
            '#ef4444', // Red
            '#8b5cf6', // Purple
            '#ec4899', // Pink
            '#14b8a6', // Teal
            '#f97316', // Orange
            '#3b82f6', // Blue
            '#84cc16', // Lime
            '#6366f1'  // Violet
        ];

        // Buat warna menyesuaikan jumlah data
        let barColors = [];
        let borderColors = [];
        for (let i = 0; i < chartData.length; i++) {
            barColors.push(multiColors[i % multiColors.length]);
            borderColors.push(multiColors[i % multiColors.length]);
        }

        let myChart;

        function buildChart(type) {
            if (myChart) myChart.destroy();

            const isPieOrDoughnut = ['pie', 'doughnut'].includes(type);

            myChart = new Chart(ctx, {
                type: type,
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Jumlah Pelanggan',
                        data: chartData,
                        // Setiap batang/slice akan menggunakan warna berbeda dari array barColors
                        backgroundColor: type === 'line' ? 'rgba(79, 70, 229, 0.15)' : barColors,
                        borderColor: type === 'line' ? '#4f46e5' : borderColors,
                        borderWidth: 1.5,
                        borderRadius: type === 'bar' ? 6 : 0,
                        fill: type === 'line' ? true : false,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: isPieOrDoughnut,
                            position: 'bottom'
                        },
                        // Angka di atas/di dalam grafik
                        datalabels: {
                            anchor: isPieOrDoughnut ? 'center' : 'end',
                            align: isPieOrDoughnut ? 'center' : 'end',
                            offset: isPieOrDoughnut ? 0 : -4,
                            color: isPieOrDoughnut ? '#ffffff' : '#1e293b',
                            font: {
                                weight: 'bold',
                                size: 12
                            },
                            formatter: function(value) {
                                return value ? value.toLocaleString('id-ID') : 0;
                            }
                        }
                    },
                    scales: isPieOrDoughnut ? {} : {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#f1f5f9' },
                            ticks: { precision: 0 }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        }

        // Render Awal (Default Bar Chart)
        buildChart('bar');

        // Event Listener Switcher Tipe Grafik
        document.getElementById('chartType').addEventListener('change', function () {
            buildChart(this.value);
        });
    });
</script>
</body>
</html>