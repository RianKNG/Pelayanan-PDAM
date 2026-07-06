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
        #map { flex: 1; height: 100%; }
        
        /* Sidebar */
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
        
        .stats-summary { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; margin-bottom: 5px; }
        .stat-box { color: white; padding: 12px 8px; border-radius: 8px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .stat-box.bg-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .stat-box.bg-success { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
        .stat-box.bg-warning { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
        .stat-number { font-size: 22px; font-weight: 700; margin-bottom: 3px; }
        .stat-label { font-size: 10px; opacity: 0.95; font-weight: 500; }
        
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
        .layer-meta { font-size: 11px; color: #64748b; display: flex; align-items: center; gap: 5px; }
        
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
        
        /* Custom Popup */
        .custom-popup { font-family: 'Segoe UI', sans-serif; min-width: 260px; }
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
        .popup-stat {
            background: #f0f9ff; padding: 8px; border-radius: 6px;
            margin-top: 8px; display: grid; grid-template-columns: 1fr 1fr; gap: 8px;
        }
        .popup-stat-item { text-align: center; }
        .popup-stat-value { font-size: 16px; font-weight: 700; color: #1e3c72; }
        .popup-stat-label { font-size: 10px; color: #64748b; text-transform: uppercase; }
        
        .leaflet-draw-toolbar a { border-radius: 8px !important; }
        .badge-count {
            background: #e2e8f0; color: #475569;
            padding: 2px 8px; border-radius: 10px;
            font-size: 11px; font-weight: 600; margin-left: auto;
        }
        
        /* ============================== */
        /* CUSTOM MARKER STYLES           */
        /* ============================== */
        .custom-div-icon { background: transparent !important; border: none !important; }
        
        .marker-wrapper {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .marker-pin {
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            box-shadow: 0 3px 10px rgba(0,0,0,0.3);
            border: 3px solid white;
            transition: transform 0.2s;
            position: relative;
            z-index: 2;
        }
        
        .marker-pin:hover { transform: scale(1.15); z-index: 10; }
        .marker-pin i { font-size: 14px; }
        
        .shape-circle { border-radius: 50%; }
        .shape-square { border-radius: 6px; }
        .shape-pin { border-radius: 50% 50% 50% 0 !important; transform: rotate(-45deg); }
        .shape-pin i { transform: rotate(45deg); }
        .shape-diamond { border-radius: 4px; transform: rotate(45deg); }
        .shape-diamond i { transform: rotate(-45deg); }
        
        .marker-label {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(30, 41, 59, 0.9);
            color: white;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 10px;
            white-space: nowrap;
            font-weight: 600;
            margin-top: 4px;
            z-index: 1;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        
        .pulse-ring {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            height: 100%;
            border-radius: 50%;
            animation: pulse-animation 2s infinite;
            z-index: 1;
        }
        
        @keyframes pulse-animation {
            0% { transform: translate(-50%, -50%) scale(1); opacity: 0.8; box-shadow: 0 0 0 0 currentColor; }
            70% { transform: translate(-50%, -50%) scale(2.5); opacity: 0; box-shadow: 0 0 0 20px currentColor; }
            100% { transform: translate(-50%, -50%) scale(1); opacity: 0; }
        }
        
        /* Legend Map */
        .map-legend {
            background: white;
            padding: 12px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
            font-size: 11px;
            max-width: 240px;
            max-height: 450px;
            overflow-y: auto;
        }
        .legend-title { font-weight: 700; margin-bottom: 8px; color: #1e293b; font-size: 12px; }
        .legend-group { margin-bottom: 10px; }
        .legend-group-title {
            font-size: 10px; color: #64748b;
            text-transform: uppercase; font-weight: 600;
            margin-bottom: 4px; padding-bottom: 2px;
            border-bottom: 1px solid #e2e8f0;
        }
        .legend-item {
            display: flex; align-items: center; gap: 8px;
            margin: 3px 0; padding: 2px;
            border-radius: 4px;
        }
        .legend-marker {
            width: 20px; height: 20px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 10px; border: 2px solid white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2); flex-shrink: 0;
        }
        .legend-line { width: 20px; height: 4px; border-radius: 2px; flex-shrink: 0; }
        
        /* Filter Tabs */
        .filter-tabs {
            position: absolute; top: 10px; right: 10px;
            background: white; padding: 8px; border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.15); z-index: 500;
            display: flex; gap: 5px; flex-wrap: wrap; max-width: 320px;
        }
        .filter-tab {
            padding: 5px 10px; border-radius: 15px;
            background: #f1f5f9; border: 1px solid #e2e8f0;
            font-size: 11px; cursor: pointer; transition: all 0.2s;
            display: flex; align-items: center; gap: 5px;
        }
        .filter-tab:hover { background: #e2e8f0; }
        .filter-tab.active { background: #1e3c72; color: white; border-color: #1e3c72; }
        
        /* Customize Button */
        .btn-customize {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            width: 100%;
            margin-top: 8px;
            transition: all 0.2s;
        }
        .btn-customize:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
        }
        
        /* Custom Type Item */
        .custom-type-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 6px 10px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            margin-bottom: 5px;
            font-size: 11px;
        }
        
        .custom-type-item .type-info {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .custom-type-item .type-icon {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 10px;
        }
        
        .btn-delete-type {
            background: transparent;
            color: #dc2626;
            border: none;
            padding: 2px 6px;
            cursor: pointer;
            font-size: 11px;
        }
        
        .btn-delete-type:hover {
            background: #fee2e2;
            border-radius: 4px;
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
        <div id="map" style="position: relative;">
            <!-- Filter Tabs -->
            <div class="filter-tabs">
                <div class="filter-tab active" data-layer="all" onclick="toggleLayer('all', this)">
                    <i class="fas fa-layer-group"></i> Semua
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
        </div>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Stats Summary -->
            <div class="sidebar-section">
                <div class="sidebar-title">
                    <i class="fas fa-chart-pie text-primary"></i> Ringkasan Data
                </div>
                <div class="stats-summary">
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

            <!-- Jalur Pipa -->
            <div class="sidebar-section">
                <div class="sidebar-title">
                    <i class="fas fa-route text-primary"></i>
                    <span>Jalur Pipa</span>
                    <span class="badge-count">{{ $jalurPipa->count() }}</span>
                </div>
                
                <div class="group-section">
                    <div class="group-header" onclick="toggleGroup('jalur-transmisi', this)">
                        <i class="fas fa-chevron-down"></i>
                        <span>Transmisi</span>
                        <span class="badge-count">{{ $jalurPipa->where('jenis_jalur', 'transmisi')->count() }}</span>
                    </div>
                    <div id="jalur-transmisi" class="group-content">
                        <div class="layer-list">
                            @forelse($jalurPipa->where('jenis_jalur', 'transmisi') as $jalur)
                            <div class="layer-item" data-id="{{ $jalur->id }}" data-type="jalur" onclick="focusOnJalur({{ $jalur->id }})">
                                <div class="layer-info">
                                    <div class="layer-name">
                                        <span class="color-dot" style="background: {{ $jalur->warna }}"></span>
                                        {{ $jalur->nama_jalur }}
                                    </div>
                                    <div class="layer-meta">
                                        <i class="fas fa-ruler"></i> {{ $jalur->ukuran_pipa }}
                                    </div>
                                </div>
                                <button class="btn-delete" onclick="event.stopPropagation(); deleteJalur({{ $jalur->id }})" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            @empty
                            <div class="empty-state">Belum ada data</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="group-section">
                    <div class="group-header" onclick="toggleGroup('jalur-distribusi', this)">
                        <i class="fas fa-chevron-down"></i>
                        <span>Distribusi</span>
                        <span class="badge-count">{{ $jalurPipa->where('jenis_jalur', 'distribusi')->count() }}</span>
                    </div>
                    <div id="jalur-distribusi" class="group-content">
                        <div class="layer-list">
                            @forelse($jalurPipa->where('jenis_jalur', 'distribusi') as $jalur)
                            <div class="layer-item" data-id="{{ $jalur->id }}" data-type="jalur" onclick="focusOnJalur({{ $jalur->id }})">
                                <div class="layer-info">
                                    <div class="layer-name">
                                        <span class="color-dot" style="background: {{ $jalur->warna }}"></span>
                                        {{ $jalur->nama_jalur }}
                                    </div>
                                    <div class="layer-meta">
                                        <i class="fas fa-ruler"></i> {{ $jalur->ukuran_pipa }}
                                    </div>
                                </div>
                                <button class="btn-delete" onclick="event.stopPropagation(); deleteJalur({{ $jalur->id }})" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            @empty
                            <div class="empty-state">Belum ada data</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bangunan -->
            <div class="sidebar-section">
                <div class="sidebar-title">
                    <i class="fas fa-building text-success"></i>
                    <span>Bangunan</span>
                    <span class="badge-count">{{ $bangunan->count() }}</span>
                </div>
                
                <div class="group-section">
                    <div class="group-header" onclick="toggleGroup('bangunan-reservoir', this)">
                        <i class="fas fa-chevron-down"></i>
                        <span>Reservoir</span>
                        <span class="badge-count">{{ $bangunan->where('jenis_bangunan', 'reservoir')->count() }}</span>
                    </div>
                    <div id="bangunan-reservoir" class="group-content">
                        <div class="layer-list">
                            @forelse($bangunan->where('jenis_bangunan', 'reservoir') as $b)
                            <div class="layer-item" data-id="{{ $b->id }}" data-type="bangunan" onclick="focusOnBangunan({{ $b->id }})">
                                <div class="layer-info">
                                    <div class="layer-name">
                                        <span class="color-dot" style="background: {{ $b->warna }}"></span>
                                        {{ $b->nama_bangunan }}
                                    </div>
                                </div>
                                <button class="btn-delete" onclick="event.stopPropagation(); deleteBangunan({{ $b->id }})" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            @empty
                            <div class="empty-state">Belum ada data</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="group-section">
                    <div class="group-header" onclick="toggleGroup('bangunan-lainnya', this)">
                        <i class="fas fa-chevron-down"></i>
                        <span>Lainnya</span>
                        <span class="badge-count">{{ $bangunan->whereNotIn('jenis_bangunan', ['reservoir'])->count() }}</span>
                    </div>
                    <div id="bangunan-lainnya" class="group-content">
                        <div class="layer-list">
                            @forelse($bangunan->whereNotIn('jenis_bangunan', ['reservoir']) as $b)
                            <div class="layer-item" data-id="{{ $b->id }}" data-type="bangunan" onclick="focusOnBangunan({{ $b->id }})">
                                <div class="layer-info">
                                    <div class="layer-name">
                                        <span class="color-dot" style="background: {{ $b->warna }}"></span>
                                        {{ $b->nama_bangunan }}
                                    </div>
                                    <div class="layer-meta">
                                        <i class="fas fa-tag"></i> {{ ucfirst(str_replace('_', ' ', $b->jenis_bangunan)) }}
                                    </div>
                                </div>
                                <button class="btn-delete" onclick="event.stopPropagation(); deleteBangunan({{ $b->id }})" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            @empty
                            <div class="empty-state">Belum ada data</div>
                            @endforelse
                        </div>
                    </div>
                </div>
                
                <button class="btn-customize" onclick="openCustomTypeModal('bangunan')">
                    <i class="fas fa-plus-circle"></i> Tambah Jenis Bangunan
                </button>
            </div>

            <!-- Titik Penting -->
            <div class="sidebar-section">
                <div class="sidebar-title">
                    <i class="fas fa-map-pin text-warning"></i>
                    <span>Titik Penting</span>
                    <span class="badge-count">{{ $titikPenting->count() }}</span>
                </div>
                
                <!-- Group by jenis_titik dinamis -->
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
                                @php
                                    $iconMap = [
                                        'valve' => 'fa-toggle-on', 'hydrant' => 'fa-fire',
                                        'meter' => 'fa-tachometer-alt', 'sambungan' => 'fa-link',
                                        'pompa' => 'fa-water', 'tandon' => 'fa-database',
                                        'lainnya' => 'fa-map-pin'
                                    ];
                                    $colorMap = [
                                        'valve' => '#ef4444', 'hydrant' => '#dc2626',
                                        'meter' => '#3b82f6', 'sambungan' => '#8b5cf6',
                                        'pompa' => '#10b981', 'tandon' => '#06b6d4',
                                        'lainnya' => '#6b7280'
                                    ];
                                    $icon = $iconMap[$t->jenis_titik] ?? 'fa-map-pin';
                                    $color = $colorMap[$t->jenis_titik] ?? '#6b7280';
                                @endphp
                                <div class="layer-item" data-id="{{ $t->id }}" data-type="titik" onclick="focusOnTitik({{ $t->id }})">
                                    <div class="layer-info">
                                        <div class="layer-name">
                                            <i class="fas {{ $icon }}" style="color: {{ $color }}"></i>
                                            {{ $t->nama_titik }}
                                        </div>
                                        <div class="layer-meta">
                                            <i class="fas fa-tag"></i> {{ ucfirst($t->jenis_titik) }}
                                        </div>
                                    </div>
                                    <button class="btn-delete" onclick="event.stopPropagation(); deleteTitik({{ $t->id }})" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    @if($titikPenting->count() === 0)
                    <div class="empty-state">Belum ada data titik penting</div>
                    @endif
                </div>
                
                <button class="btn-customize" onclick="openCustomTypeModal('titik')">
                    <i class="fas fa-plus-circle"></i> Tambah Jenis Titik
                </button>
                
                <!-- Custom Types List -->
                <div id="custom-types-list" style="margin-top: 10px;"></div>
            </div>
        </div>
    </div>

    <!-- Modal Form Jalur -->
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
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ukuran Pipa *</label>
                            <select name="ukuran_pipa" class="form-control" required>
                                <option value="6 inch">6 inch</option>
                                <option value="4 inch">4 inch</option>
                                <option value="3 inch">3 inch</option>
                                <option value="2 inch">2 inch</option>
                                <option value="1.25 inch">1.25 inch</option>
                                <option value="1 inch">1 inch</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Warna</label>
                            <div class="color-picker">
                                <div class="color-option selected" style="background: #ef4444" data-color="#ef4444"></div>
                                <div class="color-option" style="background: #3b82f6" data-color="#3b82f6"></div>
                                <div class="color-option" style="background: #10b981" data-color="#10b981"></div>
                                <div class="color-option" style="background: #f59e0b" data-color="#f59e0b"></div>
                                <div class="color-option" style="background: #8b5cf6" data-color="#8b5cf6"></div>
                                <div class="color-option" style="background: #06b6d4" data-color="#06b6d4"></div>
                            </div>
                            <input type="hidden" name="warna" value="#ef4444">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ketebalan: <span id="ketebalanValue">4</span>px</label>
                            <input type="range" name="ketebalan" class="form-range" min="2" max="10" value="4" oninput="document.getElementById('ketebalanValue').textContent = this.value">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="2"></textarea>
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

    <!-- Modal Form Bangunan -->
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
                            <select name="jenis_bangunan" id="selectJenisBangunan" class="form-control" required>
                                <option value="reservoir">Reservoir</option>
                                <option value="ipa">IPA</option>
                                <option value="kantor">Kantor</option>
                                <option value="rumah_pompa">Rumah Pompa</option>
                                <option value="gedung">Gedung</option>
                                <option value="sekolah">Sekolah</option>
                                <option value="rumah_sakit">Rumah Sakit</option>
                                <option value="masjid">Masjid</option>
                                <option value="pasar">Pasar</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Warna</label>
                            <div class="color-picker">
                                <div class="color-option selected" style="background: #3b82f6" data-color="#3b82f6"></div>
                                <div class="color-option" style="background: #10b981" data-color="#10b981"></div>
                                <div class="color-option" style="background: #f59e0b" data-color="#f59e0b"></div>
                                <div class="color-option" style="background: #ef4444" data-color="#ef4444"></div>
                            </div>
                            <input type="hidden" name="warna" value="#3b82f6">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="2"></textarea>
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

    <!-- Modal Form Titik -->
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
                            <select name="jenis_titik" id="selectJenisTitik" class="form-control" required>
                                <option value="valve">Valve</option>
                                <option value="hydrant">Hydrant</option>
                                <option value="meter">Meter</option>
                                <option value="sambungan">Sambungan</option>
                                <option value="pompa">Pompa</option>
                                <option value="tandon">Tandon</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="2"></textarea>
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

    <!-- Modal Custom Type -->
    <div class="modal fade" id="modalCustomType" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white;">
                    <h5 class="modal-title"><i class="fas fa-magic"></i> <span id="customTypeTitle">Tambah Jenis Baru</span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="formCustomType">
                    <div class="modal-body">
                        <input type="hidden" id="customTypeCategory" value="">
                        
                        <div class="mb-3">
                            <label class="form-label">Nama Jenis *</label>
                            <input type="text" id="customTypeName" class="form-control" placeholder="Contoh: Valve Utama, Gudang, dll" required>
                            <small class="text-muted">Akan otomatis tersimpan untuk penggunaan berikutnya</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Icon FontAwesome *</label>
                            <select id="customTypeIcon" class="form-control" required>
                                <optgroup label="Umum">
                                    <option value="fa-map-pin">📍 Map Pin</option>
                                    <option value="fa-star">⭐ Star</option>
                                    <option value="fa-heart">❤️ Heart</option>
                                    <option value="fa-bookmark">🔖 Bookmark</option>
                                </optgroup>
                                <optgroup label="Infrastruktur">
                                    <option value="fa-bolt">⚡ Bolt</option>
                                    <option value="fa-cog">⚙️ Cog</option>
                                    <option value="fa-wrench">🔧 Wrench</option>
                                    <option value="fa-tools">🛠️ Tools</option>
                                    <option value="fa-industry">🏭 Industry</option>
                                    <option value="fa-warehouse">📦 Warehouse</option>
                                </optgroup>
                                <optgroup label="Valve & Pipe">
                                    <option value="fa-toggle-on">🔘 Toggle On</option>
                                    <option value="fa-faucet">🚰 Faucet</option>
                                    <option value="fa-shower">🚿 Shower</option>
                                    <option value="fa-water">💧 Water</option>
                                </optgroup>
                                <optgroup label="Bangunan">
                                    <option value="fa-building">🏢 Building</option>
                                    <option value="fa-home">🏠 Home</option>
                                    <option value="fa-school">🏫 School</option>
                                    <option value="fa-hospital">🏥 Hospital</option>
                                    <option value="fa-mosque">🕌 Mosque</option>
                                    <option value="fa-store">🏪 Store</option>
                                    <option value="fa-church">⛪ Church</option>
                                </optgroup>
                                <optgroup label="Lainnya">
                                    <option value="fa-fire">🔥 Fire</option>
                                    <option value="fa-tree">🌳 Tree</option>
                                    <option value="fa-car">🚗 Car</option>
                                    <option value="fa-truck">🚚 Truck</option>
                                    <option value="fa-bus">🚌 Bus</option>
                                </optgroup>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Warna Marker *</label>
                            <div class="color-picker" id="customTypeColorPicker">
                                <div class="color-option selected" style="background: #ef4444" data-color="#ef4444"></div>
                                <div class="color-option" style="background: #dc2626" data-color="#dc2626"></div>
                                <div class="color-option" style="background: #f59e0b" data-color="#f59e0b"></div>
                                <div class="color-option" style="background: #10b981" data-color="#10b981"></div>
                                <div class="color-option" style="background: #3b82f6" data-color="#3b82f6"></div>
                                <div class="color-option" style="background: #8b5cf6" data-color="#8b5cf6"></div>
                                <div class="color-option" style="background: #06b6d4" data-color="#06b6d4"></div>
                                <div class="color-option" style="background: #ec4899" data-color="#ec4899"></div>
                                <div class="color-option" style="background: #6b7280" data-color="#6b7280"></div>
                            </div>
                            <input type="hidden" id="customTypeColor" value="#ef4444">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Bentuk Marker *</label>
                            <select id="customTypeShape" class="form-control" required>
                                <option value="circle">● Lingkaran</option>
                                <option value="square">■ Kotak</option>
                                <option value="pin">📍 Pin</option>
                                <option value="diamond">◆ Diamond</option>
                            </select>
                        </div>
                        
                        <!-- Preview -->
                        <div class="mb-3">
                            <label class="form-label">Preview</label>
                            <div id="customTypePreview" style="padding: 20px; background: #f1f5f9; border-radius: 8px; text-align: center;">
                                <div style="display: inline-block;">
                                    <div class="marker-wrapper">
                                        <div class="marker-pin shape-circle" style="background: #ef4444; width: 36px; height: 36px;">
                                            <i class="fas fa-map-pin"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed); border: none;">
                            <i class="fas fa-save"></i> Simpan Jenis
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Data dari database
    const jalurData = @json($jalurPipa);
    const bangunanData = @json($bangunan);
    const titikData = @json($titikPenting);

    let map, drawnItems;
    let tempLayer = null, tempType = null, tempCoords = null;
    
    let jalurLayers = {};
    let bangunanLayers = {};
    let titikLayers = {};
    let activeHighlight = null;
    
    let layerGroups = {
        jalur: L.layerGroup(),
        bangunan: L.layerGroup(),
        titik: L.layerGroup()
    };

    // ============================================
    // KONFIGURASI CUSTOM MARKER (DEFAULT)
    // ============================================
    const defaultTitikConfig = {
        'valve':      { icon: 'fa-toggle-on',      color: '#ef4444', shape: 'circle', label: 'Valve' },
        'hydrant':    { icon: 'fa-fire',           color: '#dc2626', shape: 'square', label: 'Hydrant' },
        'meter':      { icon: 'fa-tachometer-alt', color: '#3b82f6', shape: 'circle', label: 'Meter' },
        'sambungan':  { icon: 'fa-link',           color: '#8b5cf6', shape: 'diamond', label: 'Sambungan' },
        'pompa':      { icon: 'fa-water',          color: '#10b981', shape: 'pin', label: 'Pompa' },
        'tandon':     { icon: 'fa-database',       color: '#06b6d4', shape: 'square', label: 'Tandon' },
        'lainnya':    { icon: 'fa-map-pin',        color: '#6b7280', shape: 'circle', label: 'Lainnya' }
    };
    
    const defaultBangunanConfig = {
        'reservoir':    { icon: 'fa-database',      color: '#06b6d4', shape: 'pin', label: 'Reservoir' },
        'ipa':          { icon: 'fa-industry',      color: '#8b5cf6', shape: 'square', label: 'IPA' },
        'kantor':       { icon: 'fa-building',      color: '#3b82f6', shape: 'square', label: 'Kantor' },
        'rumah_pompa':  { icon: 'fa-house-flood-water', color: '#10b981', shape: 'square', label: 'Rumah Pompa' },
        'gedung':       { icon: 'fa-city',          color: '#64748b', shape: 'square', label: 'Gedung' },
        'sekolah':      { icon: 'fa-school',        color: '#f59e0b', shape: 'square', label: 'Sekolah' },
        'rumah_sakit':  { icon: 'fa-hospital',      color: '#ef4444', shape: 'square', label: 'RS' },
        'masjid':       { icon: 'fa-mosque',        color: '#10b981', shape: 'square', label: 'Masjid' },
        'pasar':        { icon: 'fa-store',         color: '#f97316', shape: 'square', label: 'Pasar' },
        'lainnya':      { icon: 'fa-building',      color: '#6b7280', shape: 'square', label: 'Lainnya' }
    };

    // ============================================
    // CUSTOM TYPE MANAGEMENT (localStorage)
    // ============================================
    let customTitikTypes = {};
    let customBangunanTypes = {};
    let titikConfig = {...defaultTitikConfig};
    let bangunanConfig = {...defaultBangunanConfig};

    function loadCustomTypes() {
        try {
            const savedTitik = localStorage.getItem('customTitikTypes');
            const savedBangunan = localStorage.getItem('customBangunanTypes');
            
            if (savedTitik) customTitikTypes = JSON.parse(savedTitik);
            if (savedBangunan) customBangunanTypes = JSON.parse(savedBangunan);
            
            // Merge dengan default config
            titikConfig = {...defaultTitikConfig, ...customTitikTypes};
            bangunanConfig = {...defaultBangunanConfig, ...customBangunanTypes};
            
            console.log('✅ Custom types loaded:', {
                titik: Object.keys(customTitikTypes).length,
                bangunan: Object.keys(customBangunanTypes).length
            });
        } catch (e) {
            console.error('Error loading custom types:', e);
        }
    }

    function saveCustomTypes() {
        localStorage.setItem('customTitikTypes', JSON.stringify(customTitikTypes));
        localStorage.setItem('customBangunanTypes', JSON.stringify(customBangunanTypes));
    }

    function addCustomType(category, key, config) {
        if (category === 'titik') {
            customTitikTypes[key] = config;
            titikConfig[key] = config;
        } else if (category === 'bangunan') {
            customBangunanTypes[key] = config;
            bangunanConfig[key] = config;
        }
        saveCustomTypes();
        updateDropdowns();
        renderCustomTypesList();
        addLegend();
    }

    function deleteCustomType(category, key) {
        if (!confirm(`Hapus jenis "${key}"? Data yang sudah menggunakan jenis ini akan tetap ada tapi menggunakan icon default.`)) {
            return;
        }
        
        if (category === 'titik') {
            delete customTitikTypes[key];
            delete titikConfig[key];
        } else if (category === 'bangunan') {
            delete customBangunanTypes[key];
            delete bangunanConfig[key];
        }
        
        saveCustomTypes();
        renderCustomTypesList();
        addLegend();
        alert('Jenis berhasil dihapus!');
    }

    function updateDropdowns() {
        // Update dropdown jenis titik
        const selectTitik = document.getElementById('selectJenisTitik');
        if (selectTitik) {
            // Hapus custom options lama
            selectTitik.querySelectorAll('option[data-custom="true"]').forEach(opt => opt.remove());
            
            // Tambahkan custom types
            Object.keys(customTitikTypes).forEach(key => {
                const option = document.createElement('option');
                option.value = key;
                option.textContent = customTitikTypes[key].label || key;
                option.setAttribute('data-custom', 'true');
                selectTitik.appendChild(option);
            });
        }
        
        // Update dropdown jenis bangunan
        const selectBangunan = document.getElementById('selectJenisBangunan');
        if (selectBangunan) {
            selectBangunan.querySelectorAll('option[data-custom="true"]').forEach(opt => opt.remove());
            
            Object.keys(customBangunanTypes).forEach(key => {
                const option = document.createElement('option');
                option.value = key;
                option.textContent = customBangunanTypes[key].label || key;
                option.setAttribute('data-custom', 'true');
                selectBangunan.appendChild(option);
            });
        }
    }

    function renderCustomTypesList() {
        const container = document.getElementById('custom-types-list');
        if (!container) return;
        
        let html = '';
        
        // Render custom titik types
        Object.keys(customTitikTypes).forEach(key => {
            const cfg = customTitikTypes[key];
            html += `
                <div class="custom-type-item">
                    <div class="type-info">
                        <div class="type-icon" style="background: ${cfg.color};">
                            <i class="fas ${cfg.icon}"></i>
                        </div>
                        <div>
                            <div style="font-weight: 600;">${cfg.label}</div>
                            <div style="font-size: 10px; color: #64748b;">Titik Penting</div>
                        </div>
                    </div>
                    <button class="btn-delete-type" onclick="deleteCustomType('titik', '${key}')" title="Hapus">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
        });
        
        // Render custom bangunan types
        Object.keys(customBangunanTypes).forEach(key => {
            const cfg = customBangunanTypes[key];
            html += `
                <div class="custom-type-item">
                    <div class="type-info">
                        <div class="type-icon" style="background: ${cfg.color};">
                            <i class="fas ${cfg.icon}"></i>
                        </div>
                        <div>
                            <div style="font-weight: 600;">${cfg.label}</div>
                            <div style="font-size: 10px; color: #64748b;">Bangunan</div>
                        </div>
                    </div>
                    <button class="btn-delete-type" onclick="deleteCustomType('bangunan', '${key}')" title="Hapus">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
        });
        
        container.innerHTML = html;
    }

    // ============================================
    // MODAL CUSTOM TYPE HANDLERS
    // ============================================
    function openCustomTypeModal(category) {
        document.getElementById('customTypeCategory').value = category;
        document.getElementById('customTypeTitle').textContent = 
            category === 'titik' ? 'Tambah Jenis Titik Penting' : 'Tambah Jenis Bangunan';
        
        // Reset form
        document.getElementById('customTypeName').value = '';
        document.getElementById('customTypeIcon').value = 'fa-map-pin';
        document.getElementById('customTypeColor').value = '#ef4444';
        document.getElementById('customTypeShape').value = 'circle';
        
        // Reset color picker
        document.querySelectorAll('#customTypeColorPicker .color-option').forEach(o => o.classList.remove('selected'));
        document.querySelector('#customTypeColorPicker .color-option[data-color="#ef4444"]').classList.add('selected');
        
        updatePreview();
        
        new bootstrap.Modal(document.getElementById('modalCustomType')).show();
    }

    function updatePreview() {
        const icon = document.getElementById('customTypeIcon').value;
        const color = document.getElementById('customTypeColor').value;
        const shape = document.getElementById('customTypeShape').value;
        const name = document.getElementById('customTypeName').value || 'Preview';
        
        const preview = document.getElementById('customTypePreview');
        preview.innerHTML = `
            <div style="display: inline-block;">
                <div class="marker-wrapper">
                    <div class="marker-pin shape-${shape}" style="background: ${color}; width: 36px; height: 36px;">
                        <i class="fas ${icon}"></i>
                    </div>
                    <div class="marker-label">${name}</div>
                </div>
            </div>
        `;
    }

    // ============================================
    // CUSTOM MARKER FUNCTION
    // ============================================
    function createCustomMarker(config) {
        const size = config.size || 32;
        const iconClass = config.icon || 'fa-map-marker-alt';
        const color = config.color || '#3b82f6';
        const shape = config.shape || 'circle';
        const label = config.label || '';
        const pulse = config.pulse || false;
        
        let shapeClass = 'marker-pin shape-' + shape;
        
        let html = `<div class="marker-wrapper">`;
        
        if (pulse) {
            html += `<div class="pulse-ring" style="background-color: ${color}; color: ${color};"></div>`;
        }
        
        html += `<div class="${shapeClass}" style="background-color: ${color}; width: ${size}px; height: ${size}px;">`;
        html += `<i class="fas ${iconClass}"></i>`;
        html += `</div>`;
        
        if (label) {
            html += `<div class="marker-label">${label}</div>`;
        }
        
        html += `</div>`;
        
        return L.divIcon({
            className: 'custom-div-icon',
            html: html,
            iconSize: [size, size + (label ? 20 : 0)],
            iconAnchor: [size / 2, size / 2],
            popupAnchor: [0, -size / 2]
        });
    }

    // ============================================
    // PARSER KOORDINAT (ROBUST)
    // ============================================
    function parseCoordinates(coordData) {
        try {
            if (!coordData) return null;
            
            let str = String(coordData).trim();
            
            // Hapus double quote di awal/akhir
            if (str.startsWith('"') && str.endsWith('"')) {
                str = str.substring(1, str.length - 1);
            }
            
            // Unescape backslash
            str = str.replace(/\\/g, '');
            
            // Trim lagi
            str = str.trim();
            
            // Parse JSON
            let coords = JSON.parse(str);
            
            // Handle nested array [[{lat,lng},...]]
            if (Array.isArray(coords) && coords.length > 0 && Array.isArray(coords[0])) {
                coords = coords[0];
            }
            
            // Convert {lat, lng} ke [lat, lng]
            coords = coords.map(c => {
                if (typeof c === 'object' && c !== null) {
                    if (c.lat !== undefined && c.lng !== undefined) {
                        return [parseFloat(c.lat), parseFloat(c.lng)];
                    }
                }
                return c;
            });
            
            return coords;
        } catch (e) {
            console.error('Error parsing coordinates:', e, coordData);
            return null;
        }
    }

    // ============================================
    // INITIALIZE MAP
    // ============================================
    function initMap() {
        const darmarajaBounds = L.latLngBounds(
            L.latLng(-6.9750, 108.0100),
            L.latLng(-6.8750, 108.1100)
        );
        
        map = L.map('map', {
            center: [-6.9240, 108.0673],
            zoom: 13,
            minZoom: 12,
            maxZoom: 18,
            maxBounds: darmarajaBounds,
            maxBoundsViscosity: 1.0
        });
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        const darmarajaPolygon = [
            [-6.9584, 108.0315], [-6.9421, 108.0242],
            [-6.9315, 108.0198], [-6.9202, 108.0211],
            [-6.9110, 108.0322], [-6.8985, 108.0410],
            [-6.8842, 108.0556], [-6.8810, 108.0695],
            [-6.8892, 108.0841], [-6.9011, 108.0920],
            [-6.9154, 108.0985], [-6.9320, 108.0950],
            [-6.9488, 108.0862], [-6.9595, 108.0711],
            [-6.9680, 108.0544], [-6.9642, 108.0398],
            [-6.9584, 108.0315]
        ];
        
        L.polygon(darmarajaPolygon, {
            color: '#1e3c72',
            fillColor: '#1e3c72',
            fillOpacity: 0.05,
            weight: 3,
            dashArray: '10, 5'
        }).addTo(map).bindPopup(`
            <div style="text-align:center; padding:10px; min-width:200px;">
                <h6 style="color:#1e3c72; margin:0; font-weight:700;">
                    <i class="fas fa-map-marker-alt"></i> KECAMATAN DARMARAJA
                </h6>
                <small class="text-muted">Kabupaten Sumedang, Jawa Barat</small>
            </div>
        `);

        L.marker([-6.9158, 108.0753], {
            icon: L.divIcon({
                className: 'custom-div-icon',
                html: `
                    <div style="
                        background: rgba(30, 60, 114, 0.9);
                        color: white;
                        padding: 6px 16px;
                        border-radius: 15px;
                        font-weight: 700;
                        font-size: 13px;
                        letter-spacing: 2px;
                        box-shadow: 0 3px 10px rgba(0,0,0,0.3);
                        border: 2px solid white;
                        white-space: nowrap;
                    ">
                        <i class="fas fa-map-marker-alt"></i> DARMARAJA
                    </div>
                `,
                iconSize: [180, 35],
                iconAnchor: [90, 17]
            })
        }).addTo(map);

        Object.values(layerGroups).forEach(group => group.addTo(map));

        drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        var drawControl = new L.Control.Draw({
            draw: {
                polyline: { shapeOptions: { color: '#3b82f6', weight: 4 } },
                polygon: { shapeOptions: { color: '#10b981', fillColor: '#10b981', fillOpacity: 0.3 } },
                marker: true,
                circle: false, rectangle: false, circlemarker: false
            },
            edit: { featureGroup: drawnItems, remove: true }
        });
        map.addControl(drawControl);

        map.on(L.Draw.Event.CREATED, function (e) {
            var layer = e.layer;
            var type = e.layerType;

            drawnItems.addLayer(layer);
            tempLayer = layer;
            tempType = type;
            
            if (type === 'marker') {
                tempCoords = layer.getLatLng();
            } else {
                tempCoords = layer.getLatLngs();
            }

            if (type === 'polyline') {
                new bootstrap.Modal(document.getElementById('modalJalur')).show();
            } else if (type === 'polygon') {
                new bootstrap.Modal(document.getElementById('modalBangunan')).show();
            } else if (type === 'marker') {
                new bootstrap.Modal(document.getElementById('modalTitik')).show();
            }
        });
        
        // Load custom types dari localStorage
        loadCustomTypes();
        updateDropdowns();
        renderCustomTypesList();
        
        loadExistingData();
        addLegend();
    }

    // ============================================
    // LOAD DATA
    // ============================================
    function loadExistingData() {
        console.log('📊 Loading data...');
        
        // Load Jalur Pipa
        jalurData.forEach(jalur => {
            try {
                const coords = parseCoordinates(jalur.coordinates);
                if (!coords || coords.length === 0) return;
                
                const polyline = L.polyline(coords, {
                    color: jalur.warna || '#3b82f6',
                    weight: parseInt(jalur.ketebalan) || 4,
                    opacity: 0.8
                });
                
                const jarak = calculateDistance(coords);
                const jarakKm = (jarak / 1000).toFixed(2);
                
                polyline.bindPopup(`
                    <div class="custom-popup">
                        <div class="popup-header">
                            <i class="fas fa-route" style="color: ${jalur.warna}"></i> 
                            ${jalur.nama_jalur}
                        </div>
                        <div class="popup-content">
                            <div class="popup-row">
                                <span class="popup-label"><i class="fas fa-layer-group"></i> Jenis:</span>
                                <span class="popup-value">${jalur.jenis_jalur.toUpperCase()}</span>
                            </div>
                            <div class="popup-row">
                                <span class="popup-label"><i class="fas fa-ruler-horizontal"></i> Ukuran:</span>
                                <span class="popup-value">${jalur.ukuran_pipa}</span>
                            </div>
                            <div class="popup-row">
                                <span class="popup-label"><i class="fas fa-paint-brush"></i> Ketebalan:</span>
                                <span class="popup-value">${jalur.ketebalan || 4}px</span>
                            </div>
                            ${jalur.keterangan ? `
                            <div class="popup-row">
                                <span class="popup-label"><i class="fas fa-info-circle"></i> Ket:</span>
                                <span class="popup-value">${jalur.keterangan}</span>
                            </div>` : ''}
                        </div>
                        <div class="popup-stat">
                            <div class="popup-stat-item">
                                <div class="popup-stat-value">${coords.length}</div>
                                <div class="popup-stat-label">Titik</div>
                            </div>
                            <div class="popup-stat-item">
                                <div class="popup-stat-value">${jarakKm} km</div>
                                <div class="popup-stat-label">Panjang</div>
                            </div>
                        </div>
                    </div>
                `, { maxWidth: 300 });
                
                polyline.on('click', function() {
                    highlightSidebarItem('jalur', jalur.id);
                });
                
                layerGroups.jalur.addLayer(polyline);
                jalurLayers[jalur.id] = polyline;
                
            } catch (error) {
                console.error(`❌ Error jalur ${jalur.id}:`, error);
            }
        });

        // Load Bangunan
        bangunanData.forEach(b => {
            try {
                const coords = parseCoordinates(b.coordinates);
                if (!coords || coords.length === 0) return;
                
                const polygon = L.polygon(coords, {
                    color: b.warna || '#10b981',
                    fillColor: b.warna || '#10b981',
                    fillOpacity: 0.3,
                    weight: 2
                });
                
                const config = bangunanConfig[b.jenis_bangunan] || bangunanConfig['lainnya'];
                const center = polygon.getBounds().getCenter();
                
                const buildingMarker = L.marker(center, {
                    icon: createCustomMarker({
                        icon: config.icon,
                        color: config.color,
                        shape: config.shape,
                        size: 36,
                        label: b.nama_bangunan
                    })
                });
                
                buildingMarker.bindPopup(`
                    <div class="custom-popup">
                        <div class="popup-header">
                            <i class="fas ${config.icon}" style="color: ${config.color}"></i> 
                            ${b.nama_bangunan}
                        </div>
                        <div class="popup-content">
                            <div class="popup-row">
                                <span class="popup-label"><i class="fas fa-tag"></i> Jenis:</span>
                                <span class="popup-value">${config.label}</span>
                            </div>
                            ${b.keterangan ? `
                            <div class="popup-row">
                                <span class="popup-label"><i class="fas fa-info-circle"></i> Ket:</span>
                                <span class="popup-value">${b.keterangan}</span>
                            </div>` : ''}
                        </div>
                    </div>
                `, { maxWidth: 300 });
                
                polygon.on('click', function() {
                    highlightSidebarItem('bangunan', b.id);
                });
                
                layerGroups.bangunan.addLayer(polygon);
                layerGroups.bangunan.addLayer(buildingMarker);
                bangunanLayers[b.id] = { polygon, marker: buildingMarker };
                
            } catch (error) {
                console.error(`❌ Error bangunan ${b.id}:`, error);
            }
        });

        // Load Titik Penting
        titikData.forEach(t => {
            try {
                if (!t.latitude || !t.longitude) return;
                
                const lat = parseFloat(t.latitude);
                const lng = parseFloat(t.longitude);
                if (isNaN(lat) || isNaN(lng)) return;
                
                const config = titikConfig[t.jenis_titik] || titikConfig['lainnya'];
                
                const marker = L.marker([lat, lng], {
                    icon: createCustomMarker({
                        icon: config.icon,
                        color: config.color,
                        shape: config.shape,
                        size: 32,
                        label: t.nama_titik,
                        pulse: true
                    })
                });
                
                marker.bindPopup(`
                    <div class="custom-popup">
                        <div class="popup-header">
                            <i class="fas ${config.icon}" style="color: ${config.color}"></i> 
                            ${t.nama_titik}
                        </div>
                        <div class="popup-content">
                            <div class="popup-row">
                                <span class="popup-label"><i class="fas fa-tag"></i> Jenis:</span>
                                <span class="popup-value">${config.label}</span>
                            </div>
                            <div class="popup-row">
                                <span class="popup-label"><i class="fas fa-crosshairs"></i> Koordinat:</span>
                                <span class="popup-value">${lat.toFixed(6)}, ${lng.toFixed(6)}</span>
                            </div>
                            ${t.keterangan ? `
                            <div class="popup-row">
                                <span class="popup-label"><i class="fas fa-info-circle"></i> Ket:</span>
                                <span class="popup-value">${t.keterangan}</span>
                            </div>` : ''}
                        </div>
                    </div>
                `, { maxWidth: 300 });
                
                marker.on('click', function() {
                    highlightSidebarItem('titik', t.id);
                });
                
                layerGroups.titik.addLayer(marker);
                titikLayers[t.id] = marker;
                
            } catch (error) {
                console.error(`❌ Error titik ${t.id}:`, error);
            }
        });
        
        console.log('✅ Data loaded:', {
            jalur: Object.keys(jalurLayers).length,
            bangunan: Object.keys(bangunanLayers).length,
            titik: Object.keys(titikLayers).length
        });
    }

    // ============================================
    // LEGEND
    // ============================================
    function addLegend() {
        // Hapus legend lama
        const oldLegend = document.querySelector('.map-legend');
        if (oldLegend) oldLegend.remove();
        
        const legend = L.control({ position: 'bottomleft' });
        legend.onAdd = function() {
            const div = L.DomUtil.create('div', 'map-legend');
            
            let titikHtml = Object.entries(titikConfig).map(([key, cfg]) => `
                <div class="legend-item">
                    <div class="legend-marker" style="background: ${cfg.color};">
                        <i class="fas ${cfg.icon}"></i>
                    </div>
                    <span>${cfg.label}</span>
                </div>
            `).join('');
            
            let bangunanHtml = Object.entries(bangunanConfig).map(([key, cfg]) => `
                <div class="legend-item">
                    <div class="legend-marker" style="background: ${cfg.color};">
                        <i class="fas ${cfg.icon}"></i>
                    </div>
                    <span>${cfg.label}</span>
                </div>
            `).join('');
            
            div.innerHTML = `
                <div class="legend-title"><i class="fas fa-info-circle"></i> Legenda Peta</div>
                
                <div class="legend-group">
                    <div class="legend-group-title">Titik Penting (${Object.keys(titikConfig).length} jenis)</div>
                    ${titikHtml}
                </div>
                
                <div class="legend-group">
                    <div class="legend-group-title">Bangunan (${Object.keys(bangunanConfig).length} jenis)</div>
                    ${bangunanHtml}
                </div>
                
                <div class="legend-group">
                    <div class="legend-group-title">Jalur Pipa</div>
                    <div class="legend-item">
                        <div class="legend-line" style="background: #ef4444;"></div>
                        <span>Transmisi</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-line" style="background: #3b82f6;"></div>
                        <span>Distribusi</span>
                    </div>
                </div>
            `;
            return div;
        };
        legend.addTo(map);
    }

    // ============================================
    // FILTER & INTERACTION
    // ============================================
    function toggleLayer(type, element) {
        if (type === 'all') {
            const isActive = element.classList.contains('active');
            document.querySelectorAll('.filter-tab').forEach(tab => {
                if (isActive) tab.classList.remove('active');
                else tab.classList.add('active');
            });
            
            Object.values(layerGroups).forEach(group => {
                if (isActive) map.removeLayer(group);
                else map.addLayer(group);
            });
        } else {
            element.classList.toggle('active');
            const isActive = element.classList.contains('active');
            
            if (isActive) map.addLayer(layerGroups[type]);
            else map.removeLayer(layerGroups[type]);
        }
    }

    function calculateDistance(coordinates) {
        let total = 0;
        for (let i = 0; i < coordinates.length - 1; i++) {
            const p1 = L.latLng(coordinates[i]);
            const p2 = L.latLng(coordinates[i + 1]);
            total += p1.distanceTo(p2);
        }
        return total;
    }

    function toggleGroup(groupId, headerEl) {
        const group = document.getElementById(groupId);
        if (group.classList.contains('collapsed')) {
            group.classList.remove('collapsed');
            headerEl.classList.remove('collapsed');
        } else {
            group.classList.add('collapsed');
            headerEl.classList.add('collapsed');
        }
    }

    function highlightSidebarItem(type, id) {
        document.querySelectorAll('.layer-item').forEach(item => item.classList.remove('active'));
        const targetItem = document.querySelector(`.layer-item[data-type="${type}"][data-id="${id}"]`);
        if (targetItem) {
            targetItem.classList.add('active');
            targetItem.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }

    function clearHighlight() {
        if (activeHighlight) {
            map.removeLayer(activeHighlight);
            activeHighlight = null;
        }
    }

    function createHighlight(center, color = '#3b82f6') {
        clearHighlight();
        activeHighlight = L.circleMarker(center, {
            radius: 15, color: color, fillColor: color,
            fillOpacity: 0.3, weight: 3
        }).addTo(map);
    }

    function focusOnJalur(id) {
        highlightSidebarItem('jalur', id);
        if (jalurLayers[id]) {
            const layer = jalurLayers[id];
            map.flyToBounds(layer.getBounds(), { padding: [80, 80], maxZoom: 16, duration: 0.8 });
            createHighlight(layer.getBounds().getCenter(), layer.options.color);
            setTimeout(() => layer.openPopup(), 800);
        }
    }

    function focusOnBangunan(id) {
        highlightSidebarItem('bangunan', id);
        if (bangunanLayers[id]) {
            const { polygon, marker } = bangunanLayers[id];
            map.flyToBounds(polygon.getBounds(), { padding: [80, 80], maxZoom: 17, duration: 0.8 });
            createHighlight(polygon.getBounds().getCenter(), polygon.options.color);
            setTimeout(() => marker.openPopup(), 800);
        }
    }

    function focusOnTitik(id) {
        highlightSidebarItem('titik', id);
        if (titikLayers[id]) {
            const layer = titikLayers[id];
            map.flyTo(layer.getLatLng(), 18, { duration: 0.8 });
            createHighlight(layer.getLatLng(), '#f59e0b');
            setTimeout(() => layer.openPopup(), 800);
        }
    }

    // ============================================
    // FORM HANDLERS
    // ============================================
    document.querySelectorAll('.color-option').forEach(option => {
        option.addEventListener('click', function() {
            this.parentElement.querySelectorAll('.color-option').forEach(o => o.classList.remove('selected'));
            this.classList.add('selected');
            this.closest('.modal, .modal-content').querySelector('input[name="warna"], input[type="hidden"]').value = this.dataset.color;
        });
    });

    // Custom type color picker
    document.querySelectorAll('#customTypeColorPicker .color-option').forEach(option => {
        option.addEventListener('click', function() {
            this.parentElement.querySelectorAll('.color-option').forEach(o => o.classList.remove('selected'));
            this.classList.add('selected');
            document.getElementById('customTypeColor').value = this.dataset.color;
            updatePreview();
        });
    });

    // Preview update on change
    document.getElementById('customTypeIcon').addEventListener('change', updatePreview);
    document.getElementById('customTypeShape').addEventListener('change', updatePreview);
    document.getElementById('customTypeName').addEventListener('input', updatePreview);

    // Save Jalur
    document.getElementById('formJalur').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('coordinates', JSON.stringify(tempCoords));
        fetch('{{ route("admin.drawing.jalur") }}', {
            method: 'POST', body: formData,
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
        }).then(res => res.json()).then(data => {
            if (data.success) location.reload();
            else alert('Error: ' + JSON.stringify(data));
        }).catch(err => alert('Error: ' + err));
    });

    // Save Bangunan
    document.getElementById('formBangunan').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('coordinates', JSON.stringify(tempCoords));
        fetch('{{ route("admin.drawing.bangunan") }}', {
            method: 'POST', body: formData,
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
        }).then(res => res.json()).then(data => {
            if (data.success) location.reload();
            else alert('Error: ' + JSON.stringify(data));
        }).catch(err => alert('Error: ' + err));
    });

    // Save Titik
    document.getElementById('formTitik').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        if (tempCoords && tempCoords.lat && tempCoords.lng) {
            formData.append('latitude', tempCoords.lat);
            formData.append('longitude', tempCoords.lng);
        } else {
            alert('Koordinat tidak valid!');
            return;
        }

        fetch('{{ route("admin.drawing.titik") }}', {
            method: 'POST', body: formData,
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
        }).then(res => res.json()).then(data => {
            if (data.success) location.reload();
            else alert('Error: ' + JSON.stringify(data));
        }).catch(err => alert('Error: ' + err));
    });

    // Save Custom Type
    document.getElementById('formCustomType').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const category = document.getElementById('customTypeCategory').value;
        const name = document.getElementById('customTypeName').value.trim();
        const icon = document.getElementById('customTypeIcon').value;
        const color = document.getElementById('customTypeColor').value;
        const shape = document.getElementById('customTypeShape').value;
        
        if (!name) {
            alert('Nama jenis harus diisi!');
            return;
        }
        
        // Generate key dari nama
        const key = name.toLowerCase().replace(/[^a-z0-9]+/g, '_').replace(/^_+|_+$/g, '');
        
        const config = {
            icon: icon,
            color: color,
            shape: shape,
            label: name
        };
        
        addCustomType(category, key, config);
        
        bootstrap.Modal.getInstance(document.getElementById('modalCustomType')).hide();
        
        alert(`Jenis "${name}" berhasil ditambahkan! Silakan refresh halaman untuk melihat perubahan di sidebar.`);
    });

    // Delete functions
    function deleteJalur(id) {
        if (confirm('Yakin hapus jalur ini?')) {
            fetch(`/admin/drawing/jalur/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
            }).then(() => location.reload());
        }
    }

    function deleteBangunan(id) {
        if (confirm('Yakin hapus bangunan ini?')) {
            fetch(`/admin/drawing/bangunan/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
            }).then(() => location.reload());
        }
    }

    function deleteTitik(id) {
        if (confirm('Yakin hapus titik ini?')) {
            fetch(`/admin/drawing/titik/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
            }).then(() => location.reload());
        }
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', initMap);
    </script>
</body>
</html>