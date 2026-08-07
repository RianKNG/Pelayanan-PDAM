<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Pelanggan Terfilter</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 10px; margin: 20px; }
        h2 { text-align: center; margin-bottom: 5px; font-size: 16px; color: #007bff; }
        h4 { text-align: center; margin-top: 0; font-size: 12px; color: #555; }
        .info-box { 
            background: #f8f9fa; padding: 10px; margin: 15px 0; 
            border-left: 4px solid #007bff; border-radius: 4px;
        }
        .info-box strong { color: #007bff; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; font-size: 9px; }
        th { background: #007bff; color: white; font-weight: bold; text-align: center; }
        .text-center { text-align: center; }
        .footer { 
            text-align: center; margin-top: 20px; font-size: 9px; color: #666; 
            border-top: 1px solid #ddd; padding-top: 8px;
        }
        .chart-img { 
            width: 100%; max-width: 750px; margin: 15px auto; 
            display: block; border: 1px solid #ddd;
        }
        .badge-0 { background: #dc3545; color: white; padding: 2px 6px; border-radius: 3px; }
        .badge-1-10 { background: #28a745; color: white; padding: 2px 6px; border-radius: 3px; }
        .badge-11-30 { background: #17a2b8; color: white; padding: 2px 6px; border-radius: 3px; }
        .badge-30 { background: #ffc107; color: black; padding: 2px 6px; border-radius: 3px; }
    </style>
</head>
<body>
    <h2>PDAM TIRTA MEDAL - UNIT DARMARAJA</h2>
    <h4>Laporan Evaluasi Pelanggan Terfilter</h4>
    
    <div class="info-box">
        <strong>📅 Periode:</strong> {{ $periodeText }}<br>
        <strong>🔍 Filter Aktif:</strong> {{ $filterText }}<br>
        <strong> Total Pelanggan:</strong> {{ $total }} pelanggan<br>
        <strong> Jenis Grafik:</strong> {{ ucfirst($chartType) }}
    </div>

    {{-- ✅ GRAFIK DARI QUICKCHART.IO --}}
    <h4 style="margin-top: 20px; color: #007bff;">📈 Tren Pelanggan Per Golongan</h4>
    @if(isset($chartBase64) && $chartBase64)
    <img src="{{ $chartBase64 }}" class="chart-img" alt="Grafik Tren" style="width: 100%; max-width: 650px; height: auto;">
@elseif(isset($chartUrl) && $chartUrl)
    <img src="{{ $chartUrl }}" class="chart-img" alt="Grafik Tren" style="width: 100%; max-width: 650px; height: auto;">
@else
    <p style="color: red; font-style: italic;">Grafik tidak dapat dimuat.</p>
@endif

    {{-- TABEL DETAIL --}}
    <h4 style="margin-top: 20px; color: #007bff;">📋 Daftar Detail Pelanggan</h4>
    <table>
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="15%" class="text-center">No Sambungan</th>
                <th width="25%">Nama Pelanggan</th>
                <th width="10%" class="text-center">Gol</th>
                <th width="10%" class="text-center">Rata-rata</th>
                <th width="10%" class="text-center">Kategori</th>
                <th width="25%">Alamat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($validCustomers as $index => $cust)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $cust['no_sambungan'] }}</td>
                <td>{{ $cust['nama_pelanggan'] }}</td>
                <td class="text-center">{{ $cust['kode_gol'] }}</td>
                <td class="text-center">{{ $cust['avg_pakai'] }} m³</td>
                <td class="text-center">
                    @if($cust['kategori'] == '0') <span class="badge-0">0 m³</span>
                    @elseif($cust['kategori'] == '1-10') <span class="badge-1-10">1-10 m³</span>
                    @elseif($cust['kategori'] == '11-30') <span class="badge-11-30">11-30 m³</span>
                    @else <span class="badge-30"> >30 m³</span>
                    @endif
                </td>
                <td>{{ $cust['alamat'] }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada data yang sesuai dengan filter.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ date('d/m/Y H:i:s') }} | PDAM Tirta Medal - Sistem Monitoring Golongan
    </div>
</body>
</html>