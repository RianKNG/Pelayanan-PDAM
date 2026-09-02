<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Drawing Map - Jalur Pipa & Bangunan</title>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: 'Segoe UI', sans-serif; }
.header {
    background: linear-gradient(135deg, #1e3c72, #2a5298);
    color: white; padding: 15px 20px;
    display: flex; justify-content: space-between; align-items: center;
}
.main-container { display: flex; height: calc(100vh - 60px); }
#map { flex: 1; height: 100%; position: relative; }
.sidebar {
    width: 380px; background: #f8fafc;
    box-shadow: -2px 0 10px rgba(0,0,0,0.1);
    overflow-y: auto; padding: 15px;
}
.sidebar::-webkit-scrollbar { width: 6px; }
.sidebar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
.sidebar-section {
    background: white; margin-bottom: 12px;
    padding: 15px; border-radius: 10px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}
.sidebar-title {
    font-size: 14px; font-weight: 600; color: #1e293b;
    margin-bottom: 12px; display: flex; align-items: center; gap: 8px;
}
.stats-summary { display: grid; grid-template-columns: repeat(4, 1fr); gap: 6px; margin-bottom: 5px; }
.stat-box { color: white; padding: 10px 6px; border-radius: 8px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
.stat-box.bg-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
.stat-box.bg-success { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
.stat-box.bg-warning { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
.stat-box.bg-info { background: linear-gradient(135deg, #f59e0b 0%, #f97316 100%); }
.stat-number { font-size: 18px; font-weight: 700; margin-bottom: 2px; }
.stat-label { font-size: 9px; opacity: 0.95; font-weight: 500; }
.group-section { margin-bottom: 8px; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; }
.group-header {
    background: #f1f5f9; padding: 10px 12px; cursor: pointer;
    display: flex; align-items: center; gap: 8px;
    font-weight: 600; font-size: 12px; transition: background 0.2s; user-select: none;
}
.group-header:hover { background: #e2e8f0; }
.group-header i { transition: transform 0.3s; font-size: 10px; }
.group-header.collapsed i { transform: rotate(-90deg); }
.group-content { max-height: 1000px; overflow: hidden; transition: max-height 0.3s ease; background: white; }
.group-content.collapsed { max-height: 0; }
.layer-list { display: flex; flex-direction: column; }
.layer-item {
    background: white; padding: 10px 12px;
    border-bottom: 1px solid #f1f5f9;
    display: flex; justify-content: space-between; align-items: center;
    transition: all 0.2s; cursor: pointer;
}
.layer-item:last-child { border-bottom: none; }
.layer-item:hover { background: #f0f9ff; transform: translateX(3px); }
.layer-item.active {
    background: #dbeafe; border-left: 3px solid #3b82f6;
    padding-left: 9px; box-shadow: 0 2px 8px rgba(59, 130, 246, 0.2);
}
.layer-info { flex: 1; min-width: 0; }
.layer-name {
    font-weight: 600; font-size: 13px; color: #1e293b;
    display: flex; align-items: center; gap: 8px; margin-bottom: 3px; word-break: break-word;
}
.color-dot {
    width: 12px; height: 12px; border-radius: 50%;
    display: inline-block; border: 2px solid white;
    box-shadow: 0 0 0 1px currentColor; flex-shrink: 0;
}
.layer-meta { font-size: 11px; color: #64748b; display: flex; align-items: center; gap: 5px; flex-wrap: wrap; }
.btn-delete {
    background: #fee2e2; color: #dc2626; border: none;
    padding: 6px 8px; border-radius: 6px; font-size: 11px;
    cursor: pointer; transition: all 0.2s; flex-shrink: 0; margin-left: 8px;
}
.btn-delete:hover { background: #dc2626; color: white; }
.empty-state { text-align: center; padding: 15px; color: #94a3b8; font-size: 12px; font-style: italic; }
.modal-content { border-radius: 12px; }
.form-label { font-size: 12px; font-weight: 600; color: #475569; }
.color-picker { display: flex; gap: 8px; flex-wrap: wrap; }
.color-option {
    width: 30px; height: 30px; border-radius: 50%;
    cursor: pointer; border: 3px solid transparent; transition: all 0.2s;
}
.color-option:hover, .color-option.selected { border-color: #1e293b; transform: scale(1.1); }
.custom-popup { font-family: 'Segoe UI', sans-serif; min-width: 280px; }
.popup-header {
    font-weight: 700; font-size: 14px; margin-bottom: 8px;
    color: #1e293b; padding-bottom: 6px; border-bottom: 2px solid #e2e8f0;
    display: flex; align-items: center; gap: 6px;
}
.popup-content { font-size: 12px; color: #475569; }
.popup-row {
    margin: 5px 0; display: flex; gap: 8px;
    padding: 4px 0; border-bottom: 1px dashed #f1f5f9;
}
.popup-row:last-child { border-bottom: none; }
.popup-label { font-weight: 600; min-width: 95px; color: #64748b; display: flex; align-items: center; gap: 4px; }
.popup-value { color: #1e293b; flex: 1; }
.elevation-input-group { display: flex; align-items: center; gap: 8px; }
.elevation-input-group input { flex: 1; }
.elevation-unit { font-size: 12px; font-weight: 600; color: #64748b; min-width: 30px; }
.elevation-helper { font-size: 11px; color: #64748b; margin-top: 4px; }
.leaflet-popup-content-wrapper { border-radius: 10px !important; box-shadow: 0 4px 20px rgba(0,0,0,0.15) !important; }
.leaflet-popup-content { margin: 12px !important; }

/* Custom Marker Styles */
.custom-div-icon { background: transparent !important; border: none !important; }
.marker-wrapper { position: relative; display: flex; flex-direction: column; align-items: center; }
.marker-pin {
    display: flex; justify-content: center; align-items: center;
    color: white; box-shadow: 0 3px 10px rgba(0,0,0,0.3);
    border: 3px solid white; transition: transform 0.2s;
    position: relative; z-index: 2;
}
.marker-pin:hover { transform: scale(1.15); z-index: 10; }
.marker-pin i { font-size: 14px; }
.shape-circle { border-radius: 50%; }
.shape-square { border-radius: 6px; }
.shape-pin { border-radius: 50% 50% 50% 0 !important; transform: rotate(-45deg); }
.shape-pin i { transform: rotate(45deg); }
.marker-label {
    position: absolute; top: 100%; left: 50%; transform: translateX(-50%);
    background: rgba(30, 41, 59, 0.9); color: white;
    padding: 2px 8px; border-radius: 10px; font-size: 10px;
    white-space: nowrap; font-weight: 600; margin-top: 4px; z-index: 1;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}
.pulse-ring {
    position: absolute; top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    width: 100%; height: 100%; border-radius: 50%;
    animation: pulse-animation 2s infinite; z-index: 1;
}
@keyframes pulse-animation {
    0% { transform: translate(-50%, -50%) scale(1); opacity: 0.8; }
    70% { transform: translate(-50%, -50%) scale(2.5); opacity: 0; }
    100% { transform: translate(-50%, -50%) scale(1); opacity: 0; }
}

/* Map Controls */
.filter-tabs {
    position: absolute; top: 10px; right: 10px;
    background: white; padding: 8px; border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.15); z-index: 500;
    display: flex; gap: 5px; flex-wrap: wrap; max-width: 420px;
}
.filter-tab {
    padding: 5px 10px; border-radius: 15px;
    background: #f1f5f9; border: 1px solid #e2e8f0;
    font-size: 11px; cursor: pointer; transition: all 0.2s;
    display: flex; align-items: center; gap: 5px;
}
.filter-tab:hover { background: #e2e8f0; }
.filter-tab.active { background: #1e3c72; color: white; border-color: #1e3c72; }

.map-mode-switcher {
    position: absolute; top: 60px; right: 10px;
    background: white; padding: 8px; border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.15); z-index: 500;
    display: flex; flex-direction: column; gap: 6px; min-width: 140px;
}
.map-mode-title {
    font-size: 10px; font-weight: 700; color: #64748b;
    text-transform: uppercase; padding: 0 4px 4px;
    border-bottom: 1px solid #e2e8f0;
    display: flex; align-items: center; gap: 5px;
}
.map-mode-btn {
    display: flex; align-items: center; gap: 8px;
    padding: 8px 10px; border-radius: 8px; cursor: pointer;
    transition: all 0.2s; border: 2px solid transparent;
    background: #f8fafc; font-size: 11px; font-weight: 600; color: #475569;
}
.map-mode-btn:hover { background: #f1f5f9; transform: translateX(-2px); }
.map-mode-btn.active {
    background: linear-gradient(135deg, #1e3c72, #2a5298);
    color: white; border-color: #1e3c72;
    box-shadow: 0 2px 8px rgba(30, 60, 114, 0.3);
}
.map-mode-icon {
    width: 28px; height: 28px; border-radius: 6px;
    display: flex; align-items: center; justify-content: center;
    font-size: 14px; flex-shrink: 0; background: white; color: #1e3c72;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}
.map-mode-btn.active .map-mode-icon { background: rgba(255,255,255,0.2); color: white; }
.map-mode-icon-street { background: linear-gradient(135deg, #e0e7ff, #c7d2fe); }
.map-mode-icon-satellite { background: linear-gradient(135deg, #064e3b, #065f46); color: #10b981 !important; }
.map-mode-icon-hybrid { background: linear-gradient(135deg, #1e3a8a, #3b82f6); color: white !important; }
.map-mode-icon-topo { background: linear-gradient(135deg, #fef3c7, #fde68a); color: #92400e !important; }
.map-mode-icon-dark { background: linear-gradient(135deg, #1f2937, #374151); color: #fbbf24 !important; }

.btn-customize {
    background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    color: white; border: none; padding: 8px 12px; border-radius: 8px;
    font-size: 11px; font-weight: 600; cursor: pointer;
    display: flex; align-items: center; gap: 6px; width: 100%;
    margin-top: 8px; transition: all 0.2s;
}
.btn-customize:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3); }

.mode-toggle { display: flex; gap: 8px; margin-bottom: 12px; }
.mode-toggle-btn {
    flex: 1; padding: 8px; border: 2px solid #e2e8f0; border-radius: 8px;
    background: white; cursor: pointer; text-align: center;
    font-size: 11px; font-weight: 600; transition: all 0.2s;
}
.mode-toggle-btn.active { border-color: #8b5cf6; background: #f5f3ff; color: #7c3aed; }
.mode-content { display: none; }
.mode-content.active { display: block; }

.image-upload-area {
    border: 2px dashed #cbd5e1; border-radius: 10px; padding: 20px;
    text-align: center; cursor: pointer; transition: all 0.3s; background: #f8fafc;
}
.image-upload-area:hover { border-color: #8b5cf6; background: #f5f3ff; }
.image-preview-container { display: none; margin-top: 10px; text-align: center; }
.image-preview-container.show { display: block; }
.image-preview {
    max-width: 80px; max-height: 80px; border-radius: 50%;
    border: 3px solid white; box-shadow: 0 3px 10px rgba(0,0,0,0.2); object-fit: cover;
}
.btn-remove-image {
    background: #fee2e2; color: #dc2626; border: none;
    padding: 4px 10px; border-radius: 6px; font-size: 11px;
    cursor: pointer; margin-top: 8px;
}
</style>
</head>
<body>

<!-- Header -->
<div class="header">
    <div>
        <h5 class="mb-0"><i class="fas fa-draw-polygon"></i> Drawing Map</h5>
        <small>Gambar Jalur Pipa & Bangunan - Kecamatan Darmaraja</small>
    </div>
    <a href="{{ route('admin.gangguan.index') }}" class="btn btn-light btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<!-- Main Container -->
<div class="main-container">
    <!-- Map -->
    <div id="map">
        <!-- Tombol Input Manual & Cek Elevasi -->
        <div style="position: absolute; top: 10px; left: 10px; z-index: 500; display: flex; flex-direction: column; gap: 8px;">
            <button class="btn btn-sm btn-warning text-white shadow"
                onclick="new bootstrap.Modal(document.getElementById('modalManualCoord')).show()"
                style="border-radius: 10px; font-size: 11px; font-weight: 600;">
                <i class="fas fa-keyboard"></i> Input Koordinat Manual
            </button>
            <button id="btnElevasiDiff" class="btn btn-sm btn-info text-white shadow" 
                onclick="toggleElevationDiffMode()"
                style="border-radius: 10px; font-size: 11px; font-weight: 600;">
                <i class="fas fa-ruler-vertical"></i> Cek Selisih Elevasi
            </button>
        </div>

        <!-- LEGENDA POJOK KIRI BAWAH -->
        <div style="position: absolute; bottom: 10px; left: 10px; z-index: 500; background: white; padding: 12px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); font-size: 12px; min-width: 200px;">
            <div style="font-weight: 700; margin-bottom: 8px; color: #1e293b; border-bottom: 2px solid #e2e8f0; padding-bottom: 4px; display: flex; align-items: center; gap: 6px;">
                <i class="fas fa-info-circle text-primary"></i> Keterangan Peta
            </div>
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                <i class="fas fa-building" style="color: #10b981; width: 16px; text-align: center;"></i>
                <span style="color: #475569;">Bangunan (Marker/Polygon)</span>
            </div>
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                <i class="fas fa-map-pin" style="color: #f59e0b; width: 16px; text-align: center;"></i>
                <span style="color: #475569;">Titik Penting</span>
            </div>
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                <div style="width: 16px; height: 4px; background: #3b82f6; border-radius: 2px;"></div>
                <span style="color: #475569;">Jalur Pipa</span>
            </div>
            <div style="display: flex; align-items: center; gap: 8px;">
                <div style="width: 16px; height: 12px; background: rgba(245, 158, 11, 0.3); border: 2px solid #f59e0b; border-radius: 3px;"></div>
                <span style="color: #475569;">Zona Wilayah</span>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="filter-tabs">
            <div class="filter-tab active" data-layer="all" onclick="toggleLayer('all', this)">
                <i class="fas fa-layer-group"></i> Semua
            </div>
            <div class="filter-tab active" data-layer="zona" onclick="toggleLayer('zona', this)">
                <i class="fas fa-map-marked-alt"></i> Zona
            </div>
            <div class="filter-tab active" data-layer="jalur" onclick="toggleLayer('jalur', this)">
                <i class="fas fa-route"></i> Jalur
            </div>
            <div class="filter-tab active" data-layer="bangunan" onclick="toggleLayer('bangunan', this)">
                <i class="fas fa-building"></i> Bangunan
            </div>
            <div class="filter-tab active" data-layer="titik" onclick="toggleLayer('titik', this)">
                <i class="fas fa-map-pin"></i> Titik
            </div>
        </div>

        <!-- MAP MODE SWITCHER -->
        <div class="map-mode-switcher">
            <div class="map-mode-title"><i class="fas fa-map"></i> Mode Peta</div>
            @foreach([
                'street' => ['fa-road', 'Jalan', 'map-mode-icon-street'],
                'satellite' => ['fa-satellite', 'Satelit', 'map-mode-icon-satellite'],
                'hybrid' => ['fa-layer-group', 'Hybrid', 'map-mode-icon-hybrid'],
                'topo' => ['fa-mountain', 'Topografi', 'map-mode-icon-topo'],
                'dark' => ['fa-moon', 'Gelap', 'map-mode-icon-dark'],
            ] as $mode => [$icon, $label, $cls])
            <div class="map-mode-btn {{ $loop->first ? 'active' : '' }}" data-mode="{{ $mode }}" onclick="switchMapMode('{{ $mode }}', this)">
                <div class="map-mode-icon {{ $cls }}"><i class="fas {{ $icon }}"></i></div>
                <span>{{ $label }}</span>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        {{-- Stats Summary --}}
        <div class="sidebar-section">
            <div class="sidebar-title"><i class="fas fa-chart-pie text-primary"></i> Ringkasan Data</div>
            <div class="stats-summary">
                <div class="stat-box bg-info">
                    <div class="stat-number">{{ $zonaList->count() ?? 0 }}</div>
                    <div class="stat-label">Zona</div>
                </div>
                <div class="stat-box bg-primary">
                    <div class="stat-number">{{ $jalurPipa->count() }}</div>
                    <div class="stat-label">Jalur Pipa</div>
                </div>
                <div class="stat-box bg-success">
                    <div class="stat-number">{{ $bangunan->count() }}</div>
                    <div class="stat-label">Bangunan</div>
                </div>
                <div class="stat-box bg-warning">
                    <div class="stat-number">{{ $titikPenting->count() }}</div>
                    <div class="stat-label">Titik Penting</div>
                </div>
            </div>
        </div>

        {{-- BANGUNAN --}}
        <div class="sidebar-section">
            <div class="sidebar-title">
                <i class="fas fa-building text-success"></i>
                <span>Bangunan</span>
                <span class="badge-count">{{ $bangunan->count() }}</span>
            </div>
            @php
                $bangunanGroups = [
                    'reservoir' => ['label' => 'Reservoir', 'items' => $bangunan->where('jenis_bangunan', 'reservoir')],
                    'lainnya'   => ['label' => 'Lainnya',   'items' => $bangunan->where('jenis_bangunan', '!=', 'reservoir')],
                ];
            @endphp
            @foreach($bangunanGroups as $bKey => $bGroup)
            <div class="group-section">
                <div class="group-header" onclick="toggleGroup('bangunan-{{ $bKey }}', this)">
                    <i class="fas fa-chevron-down"></i>
                    <span>{{ $bGroup['label'] }}</span>
                    <span class="badge-count">{{ $bGroup['items']->count() }}</span>
                </div>
                <div id="bangunan-{{ $bKey }}" class="group-content">
                    <div class="layer-list">
                        @forelse($bGroup['items'] as $b)
                        <div class="layer-item" data-id="{{ $b->id }}" data-type="bangunan" onclick="focusOnItem('bangunan', {{ $b->id }})">
                            <div class="layer-info">
                                <div class="layer-name">
                                    <span class="color-dot" style="background: {{ $b->warna }}"></span>
                                    {{ $b->nama_bangunan }}
                                </div>
                                <div class="layer-meta">
                                    @if($b->mode_gambar === 'marker' && $b->luas_bangunan)
                                        <span><i class="fas fa-ruler-combined"></i> {{ $b->luas_bangunan }} m²</span>
                                    @elseif($b->ukuran_bangunan)
                                        <span><i class="fas fa-ruler-combined"></i> {{ $b->ukuran_bangunan }}</span>
                                    @endif
                                    @if($b->elevasi)
                                        <span style="margin-left: 8px;"><i class="fas fa-mountain"></i> {{ $b->elevasi }} mdpl</span>
                                    @endif
                                </div>
                            </div>
                            <button class="btn-delete" onclick="event.stopPropagation(); deleteItem('bangunan', {{ $b->id }})" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        @empty
                        <div class="empty-state">Belum ada data</div>
                        @endforelse
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- TITIK PENTING --}}
        <div class="sidebar-section">
            <div class="sidebar-title">
                <i class="fas fa-map-pin text-warning"></i>
                <span>Titik Penting</span>
                <span class="badge-count">{{ $titikPenting->count() }}</span>
            </div>
            <div id="titik-groups-container">
                @php
                    $jenisTitikList = $titikPenting->pluck('jenis_titik')->unique()->filter();
                @endphp
                @foreach($jenisTitikList as $jenis)
                <div class="group-section">
                    <div class="group-header" onclick="toggleGroup('titik-{{ $jenis }}', this)">
                        <i class="fas fa-chevron-down"></i>
                        <span>{{ ucfirst($jenis) }}</span>
                        <span class="badge-count">{{ $titikPenting->where('jenis_titik', $jenis)->count() }}</span>
                    </div>
                    <div id="titik-{{ $jenis }}" class="group-content">
                        <div class="layer-list">
                            @foreach($titikPenting->where('jenis_titik', $jenis) as $t)
                            <div class="layer-item" data-id="{{ $t->id }}" data-type="titik" onclick="focusOnItem('titik', {{ $t->id }})">
                                <div class="layer-info">
                                    <div class="layer-name">
                                        <i class="fas fa-map-pin" style="color: #f59e0b;"></i>
                                        {{ $t->nama_titik }}
                                    </div>
                                    <div class="layer-meta">
                                        @if($t->elevasi)
                                        <span><i class="fas fa-mountain"></i> {{ $t->elevasi }} mdpl</span>
                                        @endif
                                    </div>
                                </div>
                                <button class="btn-delete" onclick="event.stopPropagation(); deleteItem('titik', {{ $t->id }})" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- ============ MODAL INPUT KOORDINAT MANUAL ============ --}}
<div class="modal fade" id="modalManualCoord" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #f59e0b, #f97316); color: white;">
                <h5 class="modal-title" style="font-size: 14px;"><i class="fas fa-keyboard"></i> Input Manual</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formManualCoord">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Latitude *</label>
                        <input type="text" inputmode="decimal" name="manual_lat" class="form-control form-control-sm" required placeholder="-6.9158">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Longitude *</label>
                        <input type="text" inputmode="decimal" name="manual_lng" class="form-control form-control-sm" required placeholder="108.0753">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-arrow-right"></i> Lanjut Form</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ============ MODAL BANGUNAN ============ --}}
<div class="modal fade" id="modalBangunan" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-building"></i> Simpan Bangunan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formBangunan">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Bangunan *</label>
                        <input type="text" name="nama_bangunan" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Bangunan *</label>
                        <select name="jenis_bangunan" class="form-control" required>
                            @foreach(['reservoir'=>'Reservoir','kantor'=>'Kantor','rumah_pompa'=>'Rumah Pompa','gedung'=>'Gedung','sekolah'=>'Sekolah','rumah_sakit'=>'Rumah Sakit','masjid'=>'Masjid','pasar'=>'Pasar','lainnya'=>'Lainnya'] as $val => $lbl)
                            <option value="{{ $val }}">{{ $lbl }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Mode Gambar *</label>
                        <select name="mode_gambar" id="selectModeBangunan" class="form-control" onchange="toggleBangunanMode(this.value)">
                            <option value="polygon">Polygon (Area)</option>
                            <option value="marker">Marker (Titik)</option>
                        </select>
                    </div>

                    <div class="mb-3" id="fieldUkuranBangunan">
                        <label class="form-label">Ukuran Bangunan</label>
                        <input type="text" name="ukuran_bangunan" class="form-control" placeholder="Cth: 10 x 15 m">
                    </div>
                    <div class="mb-3 d-none" id="fieldLuasBangunan">
                        <label class="form-label">Luas Bangunan</label>
                        <div class="input-group">
                            <input type="number" name="luas_bangunan" class="form-control" placeholder="Cth: 150" step="0.1">
                            <span class="input-group-text">m²</span>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-mountain" style="color: #f59e0b;"></i> Elevasi</label>
                        <div class="elevation-input-group">
                            <input type="number" name="elevasi" class="form-control" placeholder="mdpl" step="0.1">
                            <span class="elevation-unit">mdpl</span>
                        </div>
                        <div class="elevation-helper">
                            <a href="#" onclick="getElevationFromCoords(); return false;" style="color: #3b82f6; font-weight: 600;">
                                <i class="fas fa-crosshairs"></i> Ambil otomatis dari koordinat
                            </a>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Warna</label>
                        <div class="color-picker">
                            @foreach(['#3b82f6','#10b981','#f59e0b','#ef4444'] as $c)
                            <div class="color-option {{ $loop->first ? 'selected' : '' }}" style="background: {{ $c }}" data-color="{{ $c }}"></div>
                            @endforeach
                        </div>
                        <input type="hidden" name="warna" value="#10b981">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ============ MODAL TITIK ============ --}}
<div class="modal fade" id="modalTitik" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-map-pin"></i> Simpan Titik Penting</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formTitik">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Titik *</label>
                        <input type="text" name="nama_titik" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Titik *</label>
                        <select name="jenis_titik" class="form-control" required>
                            <option value="valve">Valve</option>
                            <option value="hydrant">Hydrant</option>
                            <option value="meter">Meter</option>
                            <option value="pompa">Pompa</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-mountain" style="color: #f59e0b;"></i> Elevasi</label>
                        <div class="elevation-input-group">
                            <input type="number" name="elevasi" class="form-control" placeholder="mdpl" step="0.1">
                            <span class="elevation-unit">mdpl</span>
                        </div>
                        <div class="elevation-helper">
                            <a href="#" onclick="getElevationFromCoords(); return false;" style="color: #3b82f6;">
                                <i class="fas fa-crosshairs"></i> Ambil otomatis
                            </a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ============ MODAL JALUR ============ --}}
<div class="modal fade" id="modalJalur" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-route"></i> Simpan Jalur Pipa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formJalur">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Jalur *</label>
                        <input type="text" name="nama_jalur" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Jalur *</label>
                        <select name="jenis_jalur" class="form-control" required>
                            <option value="transmisi">Transmisi</option>
                            <option value="distribusi">Distribusi</option>
                            <option value="tersier">Tersier</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ukuran Pipa *</label>
                        <select name="ukuran_pipa" class="form-control" required>
                            <option value="6 inch">6 inch</option>
                            <option value="4 inch">4 inch</option>
                            <option value="2 inch">2 inch</option>
                            <option value="1 inch">1 inch</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Warna</label>
                        <div class="color-picker">
                            @foreach(['#ef4444','#3b82f6','#10b981','#f59e0b'] as $c)
                            <div class="color-option {{ $loop->first ? 'selected' : '' }}" style="background: {{ $c }}" data-color="{{ $c }}"></div>
                            @endforeach
                        </div>
                        <input type="hidden" name="warna" value="#3b82f6">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// ============================================================
// DATA & STATE
// ============================================================
const jalurData    = @json($jalurPipa);
const bangunanData = @json($bangunan);
const titikData    = @json($titikPenting);
const zonaData     = @json($zonaList ?? []);

let map, drawnItems;
let tempLayer = null, tempType = null, tempCoords = null;
let tempManualMarker = null;

// State untuk Cek Selisih Elevasi
let isElevationDiffMode = false;
let selectedElevPoints = [];
let tempElevLine = null;

const itemLayers = { zona: {}, jalur: {}, bangunan: {}, titik: {} };
const layerGroups = {
    zona: L.layerGroup(), jalur: L.layerGroup(),
    bangunan: L.layerGroup(), titik: L.layerGroup()
};

const defaultBangunanConfig = {
    'reservoir': { mode:'icon', icon:'fa-database', color:'#06b6d4', shape:'pin', label:'Reservoir' },
    'kantor': { mode:'icon', icon:'fa-building', color:'#3b82f6', shape:'square', label:'Kantor' },
    'lainnya': { mode:'icon', icon:'fa-building', color:'#6b7280', shape:'square', label:'Lainnya' }
};
let bangunanConfig = { ...defaultBangunanConfig };

// ============================================================
// BASE MAP
// ============================================================
const baseMaps = {
    street: { layer: () => L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 24 }) },
    satellite: { layer: () => L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', { maxZoom: 22 }) },
    hybrid: { layers: () => [
        L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', { maxZoom: 22 }),
        L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/Reference/World_Boundaries_and_Places/MapServer/tile/{z}/{y}/{x}', { maxZoom: 22 })
    ]},
    topo: { layer: () => L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', { maxZoom: 22 }) },
    dark: { layer: () => L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', { maxZoom: 22 }) }
};

function switchMapMode(mode, element) {
    if (!baseMaps[mode]) return;
    document.querySelectorAll('.map-mode-btn').forEach(btn => btn.classList.remove('active'));
    if (element) element.classList.add('active');

    if (window.activeBaseLayers) {
        window.activeBaseLayers.forEach(l => { if (map.hasLayer(l)) map.removeLayer(l); });
    }
    window.activeBaseLayers = [];

    const cfg = baseMaps[mode];
    const layers = cfg.layers ? cfg.layers() : [cfg.layer()];
    layers.forEach(l => { l.addTo(map); window.activeBaseLayers.push(l); });
    localStorage.setItem('preferredMapMode', mode);
}

// ============================================================
// MARKER BUILDER
// ============================================================
function createCustomMarker(config) {
    const size = config.size || 32;
    const label = config.label || '';
    let html = `<div class="marker-wrapper">`;
    html += `<div class="marker-pin shape-${config.shape || 'circle'}" style="background-color:${config.color || '#3b82f6'};width:${size}px;height:${size}px;">`;
    html += `<i class="fas ${config.icon || 'fa-map-marker-alt'}"></i></div>`;
    if (label) html += `<div class="marker-label">${label}</div>`;
    html += `</div>`;

    return L.divIcon({
        className: 'custom-div-icon',
        html: html,
        iconSize: [size, size + (label ? 20 : 0)],
        iconAnchor: [size / 2, size / 2],
        popupAnchor: [0, -size / 2]
    });
}

// ============================================================
// ELEVATION HELPERS
// ============================================================
async function getElevationFromCoords() {
    if (!tempCoords || !tempCoords.lat || !tempCoords.lng) { 
        alert('Koordinat belum tersedia!'); return; 
    }
    const elevInput = document.querySelector('.modal.show input[name="elevasi"]');
    if (!elevInput) return;
    
    elevInput.value = 'Mengambil...';
    elevInput.disabled = true;
    
    try {
        const res = await fetch(`https://api.open-elevation.com/api/v1/lookup?locations=${tempCoords.lat},${tempCoords.lng}`);
        const data = await res.json();
        if (data.results && data.results[0] && data.results[0].elevation !== undefined) {
            elevInput.value = Math.round(data.results[0].elevation);
        } else {
            elevInput.value = '';
            alert('Gagal mengambil data elevasi.');
        }
    } catch (e) {
        elevInput.value = '';
        alert('Gagal mengambil elevasi. Periksa koneksi.');
    } finally { 
        elevInput.disabled = false; 
    }
}

// ============================================================
// INIT MAP
// ============================================================
function initMap() {
    map = L.map('map', { center: [-6.9240, 108.0673], zoom: 13, minZoom: 12, maxZoom: 22 });

    const preferredMode = localStorage.getItem('preferredMapMode') || 'street';
    switchMapMode(preferredMode, document.querySelector(`.map-mode-btn[data-mode="${preferredMode}"]`));

    drawnItems = new L.FeatureGroup();
    map.addLayer(drawnItems);

    map.addControl(new L.Control.Draw({
        draw: {
            polyline: { shapeOptions: { color: '#3b82f6', weight: 4 } },
            polygon: { shapeOptions: { color: '#10b981', fillColor: '#10b981', fillOpacity: 0.3 } },
            marker: true, circle: false, rectangle: false, circlemarker: false
        },
        edit: { featureGroup: drawnItems, remove: true }
    }));

    map.on(L.Draw.Event.CREATED, function (e) {
        tempLayer = e.layer;
        tempType = e.layerType;
        drawnItems.addLayer(tempLayer);
        tempCoords = tempType === 'marker' ? tempLayer.getLatLng() : tempLayer.getLatLngs();

        if (tempType === 'polyline') {
            new bootstrap.Modal(document.getElementById('modalJalur')).show();
        } else if (tempType === 'polygon') {
            new bootstrap.Modal(document.getElementById('modalBangunan')).show();
        } else if (tempType === 'marker') {
            const isBangunan = confirm('Apakah marker ini untuk BANGUNAN?\nOK = Bangunan (Mode Marker)\nCancel = Titik Penting');
            if (isBangunan) {
                document.getElementById('selectModeBangunan').value = 'marker';
                toggleBangunanMode('marker');
                new bootstrap.Modal(document.getElementById('modalBangunan')).show();
            } else {
                new bootstrap.Modal(document.getElementById('modalTitik')).show();
            }
        }
    });

    loadExistingData();
}

// ============================================================
// LOAD DATA EXISTING
// ============================================================
function loadExistingData() {
    // --- BANGUNAN ---
    bangunanData.forEach(b => {
        try {
            const coords = parseCoordinates(b.coordinates);
            if (!coords || coords.length === 0) return;
            const color = b.warna || '#10b981';
            const config = bangunanConfig[b.jenis_bangunan] || bangunanConfig['lainnya'];
            
            if (b.mode_gambar === 'marker' || coords.length === 1) {
                const latlng = coords[0].length === 2 ? coords[0] : coords;
                const buildingMarker = L.marker(latlng, {
                    icon: createCustomMarker({ ...config, size: 36, label: b.nama_bangunan })
                });
                // PENTING: Simpan data di options agar bisa diklik untuk cek elevasi
                buildingMarker.options.elevation = b.elevasi;
                buildingMarker.options.name = b.nama_bangunan;

                buildingMarker.bindPopup(`
                    <div class="custom-popup">
                        <div class="popup-header"><i class="fas fa-building" style="color:${color}"></i> ${b.nama_bangunan}</div>
                        <div class="popup-content">
                            <div class="popup-row"><span class="popup-label"><i class="fas fa-tag"></i> Jenis:</span><span class="popup-value">${config.label}</span></div>
                            ${b.luas_bangunan ? `<div class="popup-row"><span class="popup-label"><i class="fas fa-ruler-combined"></i> Luas:</span><span class="popup-value" style="font-weight:700;">${b.luas_bangunan} m²</span></div>` : ''}
                            ${b.elevasi ? `<div class="popup-row"><span class="popup-label"><i class="fas fa-mountain"></i> Elevasi:</span><span class="popup-value" style="font-weight:700;color:#f59e0b;">${b.elevasi} mdpl</span></div>` : ''}
                        </div>
                    </div>`, { maxWidth: 300 });
                
                layerGroups.bangunan.addLayer(buildingMarker);
                itemLayers.bangunan[b.id] = { marker: buildingMarker, data: b };
            } else {
                const polygon = L.polygon(coords, { color, fillColor: color, fillOpacity: 0.3, weight: 2 });
                const buildingMarker = L.marker(polygon.getBounds().getCenter(), {
                    icon: createCustomMarker({ ...config, size: 36, label: b.nama_bangunan })
                });
                buildingMarker.options.elevation = b.elevasi;
                buildingMarker.options.name = b.nama_bangunan;

                buildingMarker.bindPopup(`
                    <div class="custom-popup">
                        <div class="popup-header"><i class="fas fa-building" style="color:${color}"></i> ${b.nama_bangunan}</div>
                        <div class="popup-content">
                            <div class="popup-row"><span class="popup-label"><i class="fas fa-tag"></i> Jenis:</span><span class="popup-value">${config.label}</span></div>
                            ${b.ukuran_bangunan ? `<div class="popup-row"><span class="popup-label"><i class="fas fa-ruler-combined"></i> Ukuran:</span><span class="popup-value">${b.ukuran_bangunan}</span></div>` : ''}
                            ${b.elevasi ? `<div class="popup-row"><span class="popup-label"><i class="fas fa-mountain"></i> Elevasi:</span><span class="popup-value" style="font-weight:700;color:#f59e0b;">${b.elevasi} mdpl</span></div>` : ''}
                        </div>
                    </div>`, { maxWidth: 300 });
                
                layerGroups.bangunan.addLayer(polygon);
                layerGroups.bangunan.addLayer(buildingMarker);
                itemLayers.bangunan[b.id] = { polygon, marker: buildingMarker, data: b };
            }
        } catch (e) { console.error('Error bangunan:', e); }
    });

    // --- TITIK ---
    titikData.forEach(t => {
        try {
            const lat = parseFloat(t.latitude), lng = parseFloat(t.longitude);
            if (isNaN(lat) || isNaN(lng)) return;
            const marker = L.marker([lat, lng], {
                icon: createCustomMarker({ mode:'icon', icon:'fa-map-pin', color:'#f59e0b', shape:'circle', size: 32, label: t.elevasi ? `${t.nama_titik} (${t.elevasi}m)` : t.nama_titik, pulse: true })
            });
            // PENTING: Simpan data di options agar bisa diklik untuk cek elevasi
            marker.options.elevation = t.elevasi;
            marker.options.name = t.nama_titik;

            marker.bindPopup(`
                <div class="custom-popup">
                    <div class="popup-header"><i class="fas fa-map-pin" style="color:#f59e0b"></i> ${t.nama_titik}</div>
                    <div class="popup-content">
                        ${t.elevasi ? `<div class="popup-row"><span class="popup-label"><i class="fas fa-mountain"></i> Elevasi:</span><span class="popup-value" style="font-weight:700;color:#f59e0b;">${t.elevasi} mdpl</span></div>` : ''}
                    </div>
                </div>`, { maxWidth: 300 });
            
            layerGroups.titik.addLayer(marker);
            itemLayers.titik[t.id] = marker;
        } catch (e) { console.error('Error titik:', e); }
    });

    // --- JALUR & ZONA (Simplified) ---
    jalurData.forEach(j => {
        try {
            const coords = parseCoordinates(j.coordinates);
            if (!coords) return;
            const polyline = L.polyline(coords, { color: j.warna || '#3b82f6', weight: 4 });
            layerGroups.jalur.addLayer(polyline);
            itemLayers.jalur[j.id] = polyline;
        } catch(e){}
    });
    
    zonaData.forEach(z => {
        try {
            const coords = parseCoordinates(z.coordinates);
            if (!coords) return;
            const polygon = L.polygon(coords, { color: z.warna || '#f59e0b', fillColor: z.warna || '#f59e0b', fillOpacity: 0.2, weight: 2, dashArray: '5, 5' });
            layerGroups.zona.addLayer(polygon);
            itemLayers.zona[z.id] = { polygon };
        } catch(e){}
    });

    Object.values(layerGroups).forEach(group => group.addTo(map));
}

function parseCoordinates(coordData) {
    try {
        if (!coordData) return null;
        let str = String(coordData).trim();
        if (str.startsWith('"') && str.endsWith('"')) str = str.substring(1, str.length - 1);
        str = str.replace(/\\/g, '').trim();
        let coords = JSON.parse(str);
        if (Array.isArray(coords) && coords.length > 0 && Array.isArray(coords[0])) coords = coords[0];
        return coords.map(c => (typeof c === 'object' && c.lat !== undefined) ? [parseFloat(c.lat), parseFloat(c.lng)] : c);
    } catch (e) { return null; }
}

// ============================================================
// FITUR CEK SELISIH ELEVASI (DIPERBAIKI TOTAL)
// ============================================================
function toggleElevationDiffMode() {
    isElevationDiffMode = !isElevationDiffMode;
    const btn = document.getElementById('btnElevasiDiff');
    
    if (isElevationDiffMode) {
        btn.classList.replace('btn-info', 'btn-danger');
        btn.innerHTML = '<i class="fas fa-times"></i> Batal Cek Elevasi';
        map.getContainer().style.cursor = 'crosshair';
        selectedElevPoints = [];
        if (tempElevLine) map.removeLayer(tempElevLine);
        enableMarkerClicksForElev();
    } else {
        btn.classList.replace('btn-danger', 'btn-info');
        btn.innerHTML = '<i class="fas fa-ruler-vertical"></i> Cek Selisih Elevasi';
        map.getContainer().style.cursor = '';
        selectedElevPoints = [];
        if (tempElevLine) map.removeLayer(tempElevLine);
        disableMarkerClicksForElev();
    }
}

function enableMarkerClicksForElev() {
    Object.values(itemLayers.titik).forEach(marker => {
        marker.on('click', handleElevMarkerClick);
    });
    Object.values(itemLayers.bangunan).forEach(item => {
        const target = item.marker || item.polygon;
        target.on('click', handleElevMarkerClick);
    });
}

function disableMarkerClicksForElev() {
    Object.values(itemLayers.titik).forEach(marker => {
        marker.off('click', handleElevMarkerClick);
    });
    Object.values(itemLayers.bangunan).forEach(item => {
        const target = item.marker || item.polygon;
        target.off('click', handleElevMarkerClick);
    });
}

function handleElevMarkerClick(e) {
    if (!isElevationDiffMode) return;
    L.DomEvent.stopPropagation(e);

    const layer = e.target;
    const name = layer.options.name || 'Titik';
    let elev = layer.options.elevation;

    // FALLBACK: Coba baca dari data asli jika options kosong
    if (elev === undefined || elev === null || elev === '') {
        // Cari di itemLayers berdasarkan referensi layer
        for (const [id, item] of Object.entries(itemLayers.bangunan)) {
            if (item.marker === layer || item.polygon === layer) {
                elev = item.data?.elevasi;
                break;
            }
        }
        if (elev === undefined || elev === null || elev === '') {
            for (const [id, marker] of Object.entries(itemLayers.titik)) {
                if (marker === layer) {
                    elev = titikData.find(t => t.id == id)?.elevasi;
                    break;
                }
            }
        }
    }

    // Jika masih kosong, tawarkan input manual
    if (elev === undefined || elev === null || elev === '' || isNaN(parseFloat(elev))) {
        const inputElevasi = prompt(
            `️ Titik "${name}" belum memiliki data elevasi!\n\n` +
            `Masukkan nilai elevasi (mdpl) untuk titik ini:\n` +
            `(Kosongkan & klik Cancel untuk membatalkan)`
        );
        
        if (inputElevasi === null || inputElevasi.trim() === '') {
            alert('❌ Pembatalan: Elevasi harus diisi untuk menghitung selisih.');
            return;
        }
        
        const parsedElev = parseFloat(inputElevasi);
        if (isNaN(parsedElev)) {
            alert('❌ Input tidak valid! Masukkan angka (contoh: 750)');
            return;
        }
        
        // Simpan sementara di memory & options
        elev = parsedElev;
        layer.options.elevation = elev;
        layer.options.name = name;
        
        alert(`✅ Elevasi "${name}" diset sementara: ${elev} mdpl\n(Lanjutkan klik titik kedua)`);
    } else {
        elev = parseFloat(elev);
    }

    selectedElevPoints.push({
        name: name,
        elev: elev,
        latlng: layer.getLatLng ? layer.getLatLng() : layer.getBounds().getCenter()
    });

    if (selectedElevPoints.length === 1) {
        alert(`✅ Titik 1 terpilih: ${name} (${elev} mdpl)\n\nSilakan klik titik kedua di peta.`);
    } else if (selectedElevPoints.length === 2) {
        const p1 = selectedElevPoints[0];
        const p2 = selectedElevPoints[1];
        const selisih = Math.abs(p1.elev - p2.elev).toFixed(2);
        const arah = p1.elev > p2.elev ? 'turun' : 'naik';

        if (tempElevLine) map.removeLayer(tempElevLine);
        tempElevLine = L.polyline([p1.latlng, p2.latlng], {
            color: '#f59e0b', weight: 4, dashArray: '8, 8'
        }).addTo(map);

        // Tampilkan hasil dengan detail
        const pesan = `📏 Ketinggian selisih antara ke 2 titik adalah: ${selisih} meter\n\n` +
                      `📍 Titik 1: ${p1.name} (${p1.elev} mdpl)\n` +
                      `📍 Titik 2: ${p2.name} (${p2.elev} mdpl)\n` +
                      `📐 Arah: ${arah} ${selisih}m dari Titik 1 ke Titik 2`;
        
        alert(pesan);

        setTimeout(() => {
            toggleElevationDiffMode();
        }, 1500);
    }
}

// ============================================================
// UI INTERACTIONS
// ============================================================
function toggleBangunanMode(mode) {
    if (mode === 'marker') {
        document.getElementById('fieldUkuranBangunan').classList.add('d-none');
        document.getElementById('fieldLuasBangunan').classList.remove('d-none');
    } else {
        document.getElementById('fieldUkuranBangunan').classList.remove('d-none');
        document.getElementById('fieldLuasBangunan').classList.add('d-none');
    }
}

function toggleLayer(type, element) {
    if (type === 'all') {
        const isActive = element.classList.contains('active');
        document.querySelectorAll('.filter-tab').forEach(tab => tab.classList.toggle('active', !isActive));
        Object.values(layerGroups).forEach(group => isActive ? map.removeLayer(group) : map.addLayer(group));
    } else {
        element.classList.toggle('active');
        element.classList.contains('active') ? map.addLayer(layerGroups[type]) : map.removeLayer(layerGroups[type]);
    }
}

function toggleGroup(groupId, headerEl) {
    document.getElementById(groupId)?.classList.toggle('collapsed');
    headerEl.classList.toggle('collapsed');
}

function focusOnItem(type, id) {
    document.querySelectorAll('.layer-item').forEach(item => item.classList.remove('active'));
    const target = document.querySelector(`.layer-item[data-type="${type}"][data-id="${id}"]`);
    if (target) { target.classList.add('active'); target.scrollIntoView({ behavior: 'smooth', block: 'nearest' }); }

    const layer = itemLayers[type]?.[id];
    if (!layer) return;

    if (type === 'bangunan') {
        const obj = layer.marker ? layer.marker : layer.polygon;
        const latlng = obj.getLatLng ? obj.getLatLng() : obj.getBounds().getCenter();
        map.flyTo(latlng, 18, { duration: 0.8 });
        setTimeout(() => obj.openPopup(), 800);
    } else if (type === 'titik') {
        map.flyTo(layer.getLatLng(), 18, { duration: 0.8 });
        setTimeout(() => layer.openPopup(), 800);
    }
}

function deleteItem(type, id) {
    if (!confirm(`Yakin hapus ${type} ini?`)) return;
    fetch(`/admin/drawing/${type}/${id}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
    }).then(() => location.reload());
}

// ============================================================
// FORM SUBMIT (DIPERBAIKI UNTUK BANGUNAN)
// ============================================================
// Handler khusus Bangunan untuk memastikan format koordinat [[lat, lng]]
document.getElementById('formBangunan').addEventListener('submit', function (e) {
    e.preventDefault();
    if (!tempCoords) { alert('Koordinat tidak valid! Silakan gambar di peta terlebih dahulu.'); return; }

    // PERBAIKAN UTAMA: Pastikan koordinat selalu berupa array of arrays [[lat, lng]]
    let coordPayload = [];
    if (tempType === 'marker') {
        coordPayload = [[tempCoords.lat, tempCoords.lng]];
    } else {
        coordPayload = tempCoords; // Sudah array of arrays dari polygon
    }

    const formData = new FormData(this);
    formData.append('coordinates', JSON.stringify(coordPayload));
    
    // Pastikan mode_gambar terkirim
    if (!formData.has('mode_gambar')) {
        formData.append('mode_gambar', tempType === 'marker' ? 'marker' : 'polygon');
    }

    fetch('{{ route("admin.drawing.bangunan") }}', {
        method: 'POST', body: formData,
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            drawnItems.clearLayers();
            tempCoords = null;
            tempType = null;
            location.reload();
        } else {
            alert('Error: ' + JSON.stringify(data));
        }
    })
    .catch(err => alert('Error: ' + err));
});

// Handler Titik
document.getElementById('formTitik').addEventListener('submit', function (e) {
    e.preventDefault();
    if (!tempCoords || !tempCoords.lat || !tempCoords.lng) { alert('Koordinat tidak valid!'); return; }
    const formData = new FormData(this);
    formData.append('latitude', tempCoords.lat);
    formData.append('longitude', tempCoords.lng);
    
    fetch('{{ route("admin.drawing.titik") }}', {
        method: 'POST', body: formData,
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            drawnItems.clearLayers();
            tempCoords = null;
            tempType = null;
            location.reload();
        } else alert('Error: ' + JSON.stringify(data));
    })
    .catch(err => alert('Error: ' + err));
});

// Handler Jalur
document.getElementById('formJalur').addEventListener('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    formData.append('coordinates', JSON.stringify(tempCoords));
    
    fetch('{{ route("admin.drawing.jalur") }}', {
        method: 'POST', body: formData,
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            drawnItems.clearLayers();
            tempCoords = null;
            tempType = null;
            location.reload();
        } else alert('Error: ' + JSON.stringify(data));
    })
    .catch(err => alert('Error: ' + err));
});

// Color Picker Logic
document.addEventListener('click', function (e) {
    if (!e.target.classList.contains('color-option')) return;
    const picker = e.target.closest('.color-picker');
    picker.querySelectorAll('.color-option').forEach(o => o.classList.remove('selected'));
    e.target.classList.add('selected');
    const hiddenInput = picker.parentElement.querySelector('input[type="hidden"]');
    if (hiddenInput) hiddenInput.value = e.target.dataset.color;
});

// Input Manual
document.getElementById('formManualCoord').addEventListener('submit', function (e) {
    e.preventDefault();
    const lat = parseFloat(this.manual_lat.value.trim().replace(',', '.'));
    const lng = parseFloat(this.manual_lng.value.trim().replace(',', '.'));
    if (isNaN(lat) || isNaN(lng)) { alert('Format koordinat tidak valid!'); return; }

    tempCoords = { lat, lng };
    if (tempManualMarker) { map.removeLayer(tempManualMarker); tempManualMarker = null; }

    tempManualMarker = L.marker([lat, lng], {
        draggable: true,
        icon: L.divIcon({
            className: 'custom-div-icon',
            html: `<div style="background:#ef4444;width:20px;height:20px;border-radius:50%;border:3px solid white;box-shadow:0 0 10px rgba(0,0,0,0.5);"></div>`,
            iconSize: [20, 20], iconAnchor: [10, 10]
        })
    }).addTo(map);

    map.flyTo([lat, lng], 17, { duration: 1 });
    bootstrap.Modal.getInstance(document.getElementById('modalManualCoord')).hide();
    tempType = 'marker';
    
    const isBangunan = confirm('Apakah titik manual ini untuk BANGUNAN?\nOK = Bangunan\nCancel = Titik Penting');
    if (isBangunan) {
        document.getElementById('selectModeBangunan').value = 'marker';
        toggleBangunanMode('marker');
        new bootstrap.Modal(document.getElementById('modalBangunan')).show();
    } else {
        new bootstrap.Modal(document.getElementById('modalTitik')).show();
    }
});

// ============================================================
// INIT
// ============================================================
document.addEventListener('DOMContentLoaded', initMap);
</script>
</body>
</html>