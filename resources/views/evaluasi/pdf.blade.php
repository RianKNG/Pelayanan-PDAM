<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $judul }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; }
        h2 { text-align: center; color: #333; margin-bottom: 5px; }
        h4 { text-align: center; color: #666; margin-top: 0; }
        .info-box { background: #f0f0f0; padding: 10px; margin: 15px 0; border-left: 4px solid #007bff; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background: #007bff; color: white; font-weight: bold; }
        tr:nth-child(even) { background: #f9f9f9; }
        .total-row { background: #e3f2fd !important; font-weight: bold; }
        .footer { text-align: center; margin-top: 30px; font-size: 10px; color: #666; border-top: 1px solid #ddd; padding-top: 10px; }
        .badge-danger { background: #dc3545; color: white; padding: 2px 6px; border-radius: 3px; }
    </style>
</head>
<body>
    <h2>PDAM TIRTA MEDAL - UNIT DARMARAJA</h2>
    <h4>{{ $judul }}</h4>
    
    <div class="info-box">
        <strong>Periode:</strong> {{ $namaBulan }} {{ $tahun }}<br>
        <strong>Total Data:</strong> {{ $total }} pelanggan<br>
        <strong>Total Pemakaian:</strong> {{ number_format($totalPakai, 0) }} m³<br>
        <strong>Total Revenue:</strong> Rp {{ number_format($totalRevenue, 0) }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No Sambungan</th>
                <th>No Rekening</th>
                <th>Nama Pelanggan</th>
                <th>Alamat</th>
                <th>Gol</th>
                <th>Stand Awal</th>
                <th>Stand Akhir</th>
                <th>Pakai</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->no_sambungan }}</td>
                <td>{{ $item->no_rekening }}</td>
                <td>{{ $item->nama_pelanggan }}</td>
                <td>{{ $item->alamat }}</td>
                <td>{{ $item->kode_gol }}</td>
                <td>{{ $item->stand_awal }}</td>
                <td>{{ $item->stand_akhir }}</td>
                <td>
                    @if($item->pakai == 0)
                        <span class="badge-danger">{{ $item->pakai }}</span>
                    @else
                        {{ $item->pakai }}
                    @endif
                </td>
                <td>Rp {{ number_format($item->total_rekening, 0) }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="8" style="text-align: right;"><strong>TOTAL:</strong></td>
                <td><strong>{{ number_format($totalPakai, 0) }} m³</strong></td>
                <td><strong>Rp {{ number_format($totalRevenue, 0) }}</strong></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ date('d/m/Y H:i:s') }} | PDAM Tirta Medal - Unit Darmaraja
    </div>
</body>
</html>