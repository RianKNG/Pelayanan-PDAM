@extends('layouts.admin')

@section('content')
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary"><div class="card-body">
            <h3>{{ $stats['total'] }}</h3><p>Total Laporan</p>
        </div></div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning"><div class="card-body">
            <h3>{{ $stats['menunggu'] }}</h3><p>Menunggu</p>
        </div></div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info"><div class="card-body">
            <h3>{{ $stats['dalam_proses'] }}</h3><p>Dalam Proses</p>
        </div></div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success"><div class="card-body">
            <h3>{{ $stats['selesai'] }}</h3><p>Selesai</p>
        </div></div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>Data Gangguan</h5>
        <a href="{{ route('admin.gangguan.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah
        </a>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Kode</th><th>Jenis</th><th>Lokasi</th>
                    <th>Status</th><th>Tanggal</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($gangguan as $item)
                <tr>
                    <td>{{ $item->kode_laporan }}</td>
                    <td>{{ ucfirst($item->jenis_gangguan) }}</td>
                    <td>{{ Str::limit($item->lokasi, 30) }}</td>
                    <td>
                        @if($item->status == 'menunggu')
                            <span class="badge bg-warning">Menunggu</span>
                        @elseif($item->status == 'dalam_proses')
                            <span class="badge bg-info">Proses</span>
                        @else
                            <span class="badge bg-success">Selesai</span>
                        @endif
                    </td>
                    <td>{{ $item->tanggal_laporan->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('admin.gangguan.edit', $item) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.gangguan.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $gangguan->links() }}
    </div>
</div>
@endsection