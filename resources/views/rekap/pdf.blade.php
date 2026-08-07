<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Bulanan {{ $bulanList[$bulanDari] }} - {{ $bulanList[$bulanSampai] }} {{ $tahun }}</title>
    <style>
        @page {
            size: landscape;
            margin: 15mm 10mm;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 9px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 5px;
            font-size: 16px;
        }
        h4 {
            text-align: center;
            color: #666;
            margin-top: 0;
            font-size: 12px;
        }
        .info-box {
            background: #f0f0f0;
            padding: 8px;
            margin: 10px 0;
            border-left: 4px solid #007bff;
            font-size: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 4px;
            text-align: center;
        }
        th {
            background: #007bff;
            color: white;
            font-weight: bold;
            font-size: 8px;
        }
        th.nama-col, td.nama-col {
            text-align: left;
            min-width: 120px;
        }
        th.alamat-col, td.alamat-col {
            text-align: left;
            min-width: 100px;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        .total-row {
            background: #e3f2fd !important;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 9px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 8px;
        }
        .badge-zero {
            background: #dc3545;
            color: white;
            padding: 1px 4px;
            border-radius: 2px;
            font-size: 8px;
        }
    </style>
</head>
<body>
    <h2>PDAM TIRTA MEDAL - UNIT DARMARAJA</h2>
    <h4>Rekapitulasi Pemakaian Air: {{ $bulanList[$bulanDari] }} - {{ $bulanList[$bulanSampai] }} {{ $tahun }}</h4>
    
    <div class="info-box">
        <strong>Periode:</strong> {{ $bulanList[$bulanDari] }} - {{ $bulanList[$bulanSampai] }} {{ $tahun }}<br>
        <strong>Total Pelanggan:</strong> {{ $totalPelanggan }}<br>
        <strong>Total Pemakaian:</strong> {{ number_format($totalPakaiKeseluruhan, 0) }} m³<br>
        <strong>Rata-rata:</strong> {{ $totalPelanggan > 0 ? number_format($totalPakaiKeseluruhan / $totalPelanggan, 1) : 0 }} m³/pelanggan
    </div>

    <table>
        <thead>
            <tr>
                <th rowspan="2" style="vertical-align: middle;">No</th>
                <th rowspan="2" style="vertical-align: middle;">No Sambungan</th>
                <th rowspan="2" style="vertical-align: middle;" class="nama-col">Nama Pelanggan</th>
                <th rowspan="2" style="vertical-align: middle;" class="alamat-col">Alamat</th>
                <th rowspan="2" style="vertical-align: middle;">Gol</th>
                <th colspan="{{ count($listBulan) }}">Pemakaian (m³)</th>
                <th rowspan="2" style="vertical-align: middle;">Total</th>
            </tr>
            <tr>
                @foreach($listBulan as $bulan)
                    <th>{{ substr($bulanList[$bulan], 0, 3) }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($tabelData as $index => $row)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $row['no_sambungan'] }}</td>
                <td class="nama-col">{{ $row['nama_pelanggan'] }}</td>
                <td class="alamat-col">{{ $row['alamat'] }}</td>
                <td>{{ $row['kode_gol'] }}</td>
                @foreach($listBulan as $bulan)
                    <td>
                        @if($row['data_per_bulan'][$bulan] == 0)
                            <span class="badge-zero">0</span>
                        @else
                            {{ $row['data_per_bulan'][$bulan] }}
                        @endif
                    </td>
                @endforeach
                <td><strong>{{ $row['total_pakai'] }}</strong></td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="5" style="text-align: right;"><strong>TOTAL:</strong></td>
                @foreach($listBulan as $bulan)
                    <td>
                        <strong>{{ array_sum(array_column($tabelData, 'data_per_bulan.' . $bulan)) }}</strong>
                    </td>
                @endforeach
                <td><strong>{{ $totalPakaiKeseluruhan }}</strong></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ date('d/m/Y H:i:s') }} | PDAM Tirta Medal - Unit Darmaraja
    </div>
</body>
</html>