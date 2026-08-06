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
        .popup-stat {
            background: #f0f9ff; padding: 8px; border-radius: 6px;
            margin-top: 8px; display: grid; grid-template-columns: 1fr 1fr; gap: 8px;
        }
        .popup-stat-item { text-align: center; }
        .popup-stat-value { font-size: 16px; font-weight: 700; color: #1e3c72; }
        .popup-stat-label { font-size: 10px; color: #64748b; text-transform: uppercase; }
        
        /* ELEVATION PROFILE CHART */
        .elevation-profile {
            background: linear-gradient(to bottom, #e0f2fe 0%, #fef3c7 100%);
            border-radius: 8px;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #e2e8f0;
        }
        .elevation-title {
            font-size: 11px;
            font-weight: 700;
            color: #1e3c72;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .elevation-chart {
            width: 100%;
            height: 80px;
            background: white;
            border-radius: 6px;
            position: relative;
            overflow: hidden;
        }
        .elevation-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 6px;
            margin-top: 8px;
        }
        .elevation-stat-item {
            text-align: center;
            padding: 4px;
            background: white;
            border-radius: 4px;
            border: 1px solid #e2e8f0;
        }
        .elevation-stat-value {
            font-size: 12px;
            font-weight: 700;
            color: #1e3c72;
        }
        .elevation-stat-label {
            font-size: 9px;
            color: #64748b;
            text-transform: uppercase;
        }
        
        .leaflet-draw-toolbar a { border-radius: 8px !important; }
        .badge-count {
            background: #e2e8f0; color: #475569;
            padding: 2px 8px; border-radius: 10px;
            font-size: 11px; font-weight: 600; margin-left: auto;
        }
        
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
        
        .marker-image-wrapper {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .marker-image {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 3px 10px rgba(0,0,0,0.3);
            object-fit: cover;
            transition: transform 0.2s;
            position: relative;
            z-index: 2;
        }
        
        .marker-image:hover { transform: scale(1.15); z-index: 10; }
        .marker-image-square { border-radius: 8px; }
        
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
            0% { transform: translate(-50%, -50%) scale(1); opacity: 0.8; }
            70% { transform: translate(-50%, -50%) scale(2.5); opacity: 0; }
            100% { transform: translate(-50%, -50%) scale(1); opacity: 0; }
        }
        
        /* ZONE LABEL ON MAP */
        .zone-label-icon {
            background: rgba(255, 255, 255, 0.95);
            border: 2px solid;
            border-radius: 8px;
            padding: 4px 10px;
            font-weight: 700;
            font-size: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .map-legend {
            background: white;
            padding: 12px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
            font-size: 11px;
            max-width: 260px;
            max-height: 500px;
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
            overflow: hidden;
        }
        .legend-marker img { width: 100%; height: 100%; object-fit: cover; }
        .legend-line { width: 20px; height: 4px; border-radius: 2px; flex-shrink: 0; }
        .legend-area {
            width: 20px; height: 14px;
            border-radius: 3px;
            flex-shrink: 0;
            border: 2px solid;
            opacity: 0.7;
        }
        
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
            position: absolute;
            top: 60px;
            right: 10px;
            background: white;
            padding: 8px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
            z-index: 500;
            display: flex;
            flex-direction: column;
            gap: 6px;
            min-width: 140px;
        }
        
        .map-mode-title {
            font-size: 10px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            padding: 0 4px 4px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .map-mode-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 10px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            border: 2px solid transparent;
            background: #f8fafc;
            font-size: 11px;
            font-weight: 600;
            color: #475569;
        }
        
        .map-mode-btn:hover {
            background: #f1f5f9;
            transform: translateX(-2px);
        }
        
        .map-mode-btn.active {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
            border-color: #1e3c72;
            box-shadow: 0 2px 8px rgba(30, 60, 114, 0.3);
        }
        
        .map-mode-icon {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
            background: white;
            color: #1e3c72;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .map-mode-btn.active .map-mode-icon {
            background: rgba(255,255,255,0.2);
            color: white;
        }
        
        .map-mode-icon-street { background: linear-gradient(135deg, #e0e7ff, #c7d2fe); }
        .map-mode-icon-satellite { background: linear-gradient(135deg, #064e3b, #065f46); color: #10b981 !important; }
        .map-mode-icon-hybrid { background: linear-gradient(135deg, #1e3a8a, #3b82f6); color: white !important; }
        .map-mode-icon-topo { background: linear-gradient(135deg, #fef3c7, #fde68a); color: #92400e !important; }
        .map-mode-icon-dark { background: linear-gradient(135deg, #1f2937, #374151); color: #fbbf24 !important; }
        
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
        
        .btn-customize-zone {
            background: linear-gradient(135deg, #f59e0b, #f97316);
        }
        .btn-customize-zone:hover {
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        }
        
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
            overflow: hidden;
        }
        
        .custom-type-item .type-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
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
        
        .image-upload-area {
            border: 2px dashed #cbd5e1;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            background: #f8fafc;
        }
        
        .image-upload-area:hover {
            border-color: #8b5cf6;
            background: #f5f3ff;
        }
        
        .image-upload-area.has-image {
            border-color: #10b981;
            background: #f0fdf4;
        }
        
        .image-preview-container {
            display: none;
            margin-top: 10px;
            text-align: center;
        }
        
        .image-preview-container.show {
            display: block;
        }
        
        .image-preview {
            max-width: 80px;
            max-height: 80px;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 3px 10px rgba(0,0,0,0.2);
            object-fit: cover;
        }
        
        .btn-remove-image {
            background: #fee2e2;
            color: #dc2626;
            border: none;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            cursor: pointer;
            margin-top: 8px;
        }
        
        .btn-remove-image:hover {
            background: #dc2626;
            color: white;
        }
        
        .mode-toggle {
            display: flex;
            gap: 8px;
            margin-bottom: 12px;
        }
        
        .mode-toggle-btn {
            flex: 1;
            padding: 8px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            background: white;
            cursor: pointer;
            text-align: center;
            font-size: 11px;
            font-weight: 600;
            transition: all 0.2s;
        }
        
        .mode-toggle-btn.active {
            border-color: #8b5cf6;
            background: #f5f3ff;
            color: #7c3aed;
        }
        
        .mode-toggle-btn:hover:not(.active) {
            border-color: #cbd5e1;
            background: #f8fafc;
        }
        
        .mode-content { display: none; }
        .mode-content.active { display: block; }
        
        /* Elevation input styling */
        .elevation-input-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .elevation-input-group input {
            flex: 1;
        }
        .elevation-unit {
            font-size: 12px;
            font-weight: 600;
            color: #64748b;
            min-width: 30px;
        }
        .elevation-helper {
            font-size: 10px;
            color: #94a3b8;
            margin-top: 4px;
        }
        /* Styling untuk popup drawing */
.leaflet-popup-content-wrapper {
    border-radius: 10px !important;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15) !important;
}

.leaflet-popup-content {
    margin: 12px !important;
}

.popup-color-opt {
    transition: all 0.2s !important;
}

.popup-color-opt:hover {
    transform: scale(1.15);
}

#popupFormContainer .form-control-sm {
    font-size: 12px;
    padding: 4px 8px;
}

#popupFormContainer label {
    display: block;
    margin-bottom: 3px;
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
            <!-- Tombol Input Manual -->
<div style="position: absolute; top: 380px; right: 10px; z-index: 500;">
    <button class="btn btn-sm btn-warning text-white shadow" onclick="new bootstrap.Modal(document.getElementById('modalManualCoord')).show()" style="border-radius: 10px; font-size: 11px; font-weight: 600;">
        <i class="fas fa-keyboard"></i> Input Koordinat Manual
    </button>
</div>

<!-- Modal Input Koordinat Manual -->
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
            <!-- GANTI type="number" MENJADI type="text" + inputmode="decimal" -->
            <input type="text" inputmode="decimal" name="manual_lat" 
                   class="form-control form-control-sm" required 
                   placeholder="-6.9158" autocomplete="off">
        </div>
        <div class="mb-3">
            <label class="form-label">Longitude *</label>
            <!-- GANTI type="number" MENJADI type="text" + inputmode="decimal" -->
            <input type="text" inputmode="decimal" name="manual_lng" 
                   class="form-control form-control-sm" required 
                   placeholder="108.0753" autocomplete="off">
        </div>
        <div class="alert alert-info py-2" style="font-size: 11px; margin-bottom: 0;">
            <i class="fas fa-info-circle"></i> Sekarang bisa Copy-Paste (Ctrl+V) dari GPS/Google Maps!
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
                <div class="map-mode-title">
                    <i class="fas fa-map"></i> Mode Peta
                </div>
                <div class="map-mode-btn active" data-mode="street" onclick="switchMapMode('street', this)">
                    <div class="map-mode-icon map-mode-icon-street"><i class="fas fa-road"></i></div>
                    <span>Jalan</span>
                </div>
                <div class="map-mode-btn" data-mode="satellite" onclick="switchMapMode('satellite', this)">
                    <div class="map-mode-icon map-mode-icon-satellite"><i class="fas fa-satellite"></i></div>
                    <span>Satelit</span>
                </div>
                <div class="map-mode-btn" data-mode="hybrid" onclick="switchMapMode('hybrid', this)">
                    <div class="map-mode-icon map-mode-icon-hybrid"><i class="fas fa-layer-group"></i></div>
                    <span>Hybrid</span>
                </div>
                <div class="map-mode-btn" data-mode="topo" onclick="switchMapMode('topo', this)">
                    <div class="map-mode-icon map-mode-icon-topo"><i class="fas fa-mountain"></i></div>
                    <span>Topografi</span>
                </div>
                <div class="map-mode-btn" data-mode="dark" onclick="switchMapMode('dark', this)">
                    <div class="map-mode-icon map-mode-icon-dark"><i class="fas fa-moon"></i></div>
                    <span>Gelap</span>
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

            <!-- ============ ZONA (BARU!) ============ -->
            <div class="sidebar-section">
                <div class="sidebar-title">
                    <i class="fas fa-map-marked-alt" style="color: #f59e0b;"></i>
                    <span>Zona Wilayah</span>
                    <span class="badge-count">{{ $zonaList->count() ?? 0 }}</span>
                </div>
                
                <div id="zona-groups-container">
                    @php
                        $jenisZonaList = collect($zonaList ?? [])->pluck('jenis_zona')->unique()->filter()->sort();
                    @endphp
                    
                    @foreach($jenisZonaList as $jenis)
                    @php
                        $zonaItems = collect($zonaList ?? [])->where('jenis_zona', $jenis);
                        $zonaColor = $zonaItems->first()->warna ?? '#f59e0b';
                    @endphp
                    <div class="group-section">
                        <div class="group-header" onclick="toggleGroup('zona-{{ Str::slug($jenis) }}', this)">
                            <i class="fas fa-chevron-down"></i>
                            <span class="color-dot" style="background: {{ $zonaColor }};"></span>
                            <span>{{ $jenis }}</span>
                            <span class="badge-count">{{ $zonaItems->count() }}</span>
                        </div>
                        <div id="zona-{{ Str::slug($jenis) }}" class="group-content">
                            <div class="layer-list">
                                @foreach($zonaItems as $z)
                                <div class="layer-item" data-id="{{ $z->id }}" data-type="zona" onclick="focusOnZona({{ $z->id }})">
                                    <div class="layer-info">
                                        <div class="layer-name">
                                            <span class="color-dot" style="background: {{ $z->warna }}"></span>
                                            {{ $z->nama_zona }}
                                        </div>
                                        <div class="layer-meta">
                                            <i class="fas fa-tag"></i> {{ $z->jenis_zona }}
                                            @if($z->elevasi_min || $z->elevasi_max)
                                            <span style="margin-left: 8px;">
                                                <i class="fas fa-mountain"></i> 
                                                {{ $z->elevasi_min ?? '?' }} - {{ $z->elevasi_max ?? '?' }} mdpl
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <button class="btn-delete" onclick="event.stopPropagation(); deleteZona({{ $z->id }})" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    @if(($zonaList->count() ?? 0) === 0)
                    <div class="empty-state">Belum ada data zona</div>
                    @endif
                </div>
                
                <button class="btn-customize btn-customize-zone" onclick="openCustomTypeModal('zona')">
                    <i class="fas fa-plus-circle"></i> Tambah Jenis Zona
                </button>
                
                <div id="custom-zona-types-list" style="margin-top: 10px;"></div>
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

                <div class="group-section">
                    <div class="group-header" onclick="toggleGroup('jalur-tersier', this)">
                        <i class="fas fa-chevron-down"></i>
                        <span>Tersier</span>
                        <span class="badge-count">{{ $jalurPipa->where('jenis_jalur', 'tersier')->count() }}</span>
                    </div>
                    <div id="jalur-tersier" class="group-content">
                        <div class="layer-list">
                            @forelse($jalurPipa->where('jenis_jalur', 'tersier') as $jalur)
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
                            @forelse($bangunan->whereNotIn('jenis_bangunan', 'reservoir') as $b)
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
{{-- PANEL DATA PELANGGAN API --}}
<div class="mt-4 p-3 bg-white rounded-lg shadow-sm border border-gray-200">
    <h6 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
        <i class="fas fa-users text-blue-500"></i> Data Pelanggan per Zona
    </h6>
    
    @if($pelangganStats)
        <div class="space-y-2 text-sm max-h-72 overflow-y-auto pr-1">
            @foreach($pelangganStats as $zona => $data)
                @if($data['sr'] > 0 || $zona !== 'Lainnya')
                <div class="p-2 bg-gray-50 rounded border-l-4 
                    @if($zona == 'Zona 1') border-blue-500
                    @elseif($zona == 'Zona 2') border-green-500
                    @elseif($zona == 'Zona 3') border-yellow-500
                    @elseif($zona == 'Zona 4') border-red-500
                    @elseif($zona == 'Zona 5') border-purple-500
                    @else border-gray-400 @endif">
                    
                    <div class="flex justify-between items-center">
                        <span class="font-semibold text-gray-700">{{ $zona }}</span>
                        <span class="text-xs font-bold text-gray-800">{{ $data['sr'] }} SR</span>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500 mt-1">
                        <span>Vol: {{ number_format($data['pakai']) }} m³</span>
                        <span class="font-semibold text-blue-600">Rp {{ number_format($data['jumlah'], 0, ',', '.') }}</span>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    @else
        <p class="text-xs text-red-500 text-center py-2">⚠️ Gagal memuat data API.</p>
    @endif
</div>
            <!-- Titik Penting -->
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
                                @php
                                    $iconMap = [
                                        'valve' => 'fa-toggle-on', 'hydrant' => 'fa-fire',
                                        'meter' => 'fa-tachometer-alt', 'sambungan' => 'fa-link',
                                        'pompa' => 'fa-water', 'tandon' => 'fa-database', 'manometer' => 'fa-database',
                                        'lainnya' => 'fa-map-pin'
                                    ];
                                    $colorMap = [
                                        'valve' => '#ef4444', 'hydrant' => '#dc2626',
                                        'meter' => '#3b82f6', 'sambungan' => '#8b5cf6',
                                        'pompa' => '#10b981', 'tandon' => '#06b6d4','manometer' => '#06b6d4',
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
                                            @if($t->elevasi)
                                            <span style="margin-left: 8px;">
                                                <i class="fas fa-mountain"></i> {{ $t->elevasi }} mdpl
                                            </span>
                                            @endif
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
                                <option value="tersier">Tersier</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ukuran Pipa *</label>
                            <select name="ukuran_pipa" class="form-control" required>
                                <option value="6 inch">6 inch</option>
                                <option value="4 inch">4 inch</option>
                                <option value="3 inch">3 inch</option>
                                <option value="2 inch">2 inch</option>
                                <option value="1.5 inch">1.5 inch</option>
                                <option value="1.25 inch">1.25 inch</option>
                                <option value="1 inch">1 inch</option>
                                <option value="0.75 inch">0.75 inch</option>
                                <option value="0.5 inch">0.5 inch</option>
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
                                <div class="color-option" style="background: #f97316" data-color="#f97316"></div>
                                <div class="color-option" style="background: #84cc16" data-color="#84cc16"></div>
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

    <!-- Modal Form Titik (DENGAN ELEVASI!) -->
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
                                <option value="manometer">Manometer</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                        <!-- ELEVASI BARU! -->
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-mountain" style="color: #f59e0b;"></i> 
                                Elevasi / Ketinggian
                            </label>
                            <div class="elevation-input-group">
                                <input type="number" name="elevasi" class="form-control" 
                                       placeholder="Contoh: 750" step="0.1" min="-500" max="9000">
                                <span class="elevation-unit">mdpl</span>
                            </div>
                            <div class="elevation-helper">
                                <i class="fas fa-info-circle"></i> 
                                Meter di atas permukaan laut (opsional). 
                                <a href="#" onclick="getElevationFromCoords(); return false;" style="color: #3b82f6;">
                                    <i class="fas fa-crosshairs"></i> Ambil otomatis dari koordinat
                                </a>
                            </div>
                        </div>
                        <div class="mb-3">
    <label for="ukuran" class="form-label">Ukuran Pipa</label>
    <select name="ukuran" id="ukuran" class="form-select" required>
        <option value="">-- Pilih Ukuran --</option>
        @php $sizes = ['12 inch', '10 inch', '8 inch', '6 inch', '4 inch', '3 inch', '2 inch', '1.5 inch', '1 inch']; @endphp
        @foreach($sizes as $size)
            <option value="{{ $size }}" {{ old('ukuran', $titik->ukuran ?? '') == $size ? 'selected' : '' }}>
                {{ $size }}
            </option>
        @endforeach
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

    <!-- Modal Form Zona (BARU!) -->
    <div class="modal fade" id="modalZona" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #f59e0b, #f97316); color: white;">
                    <h5 class="modal-title"><i class="fas fa-map-marked-alt"></i> Simpan Zona Wilayah</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="formZona">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Zona *</label>
                            <input type="text" name="nama_zona" class="form-control" 
                                   placeholder="Contoh: Zona 1 Utara, DAS Cimanuk, dll" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis Zona *</label>
                            <select name="jenis_zona" id="selectJenisZona" class="form-control" required>
                                <option value="Zona 1">Zona 1</option>
                                <option value="Zona 2">Zona 2</option>
                                <option value="Zona 3">Zona 3</option>
                                <option value="Zona 4">Zona 4</option>
                                <option value="Zona 5">Zona 5</option>
                                <option value="DAS">DAS (Daerah Aliran Sungai)</option>
                                <option value="Sub DAS">Sub DAS</option>
                                <option value="Cekungan">Cekungan</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            <small class="text-muted">Bisa tambah jenis baru via tombol "Tambah Jenis Zona"</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Warna Zona *</label>
                            <div class="color-picker">
                                <div class="color-option selected" style="background: #f59e0b" data-color="#f59e0b"></div>
                                <div class="color-option" style="background: #ef4444" data-color="#ef4444"></div>
                                <div class="color-option" style="background: #10b981" data-color="#10b981"></div>
                                <div class="color-option" style="background: #3b82f6" data-color="#3b82f6"></div>
                                <div class="color-option" style="background: #8b5cf6" data-color="#8b5cf6"></div>
                                <div class="color-option" style="background: #06b6d4" data-color="#06b6d4"></div>
                                <div class="color-option" style="background: #ec4899" data-color="#ec4899"></div>
                                <div class="color-option" style="background: #84cc16" data-color="#84cc16"></div>
                            </div>
                            <input type="hidden" name="warna" value="#f59e0b">
                        </div>
                        <!-- ELEVASI ZONA -->
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-arrow-down" style="color: #10b981;"></i> 
                                        Elevasi Min
                                    </label>
                                    <div class="elevation-input-group">
                                        <input type="number" name="elevasi_min" class="form-control" 
                                               placeholder="min" step="0.1">
                                        <span class="elevation-unit">mdpl</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-arrow-up" style="color: #ef4444;"></i> 
                                        Elevasi Max
                                    </label>
                                    <div class="elevation-input-group">
                                        <input type="number" name="elevasi_max" class="form-control" 
                                               placeholder="max" step="0.1">
                                        <span class="elevation-unit">mdpl</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="2" 
                                      placeholder="Deskripsi zona, cakupan wilayah, dll"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning text-white">
                            <i class="fas fa-save"></i> Simpan Zona
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Custom Type (untuk Titik, Bangunan, Zona) -->
    <div class="modal fade" id="modalCustomType" tabindex="-1">
        <div class="modal-dialog modal-lg">
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
                            <input type="text" id="customTypeName" class="form-control" 
                                   placeholder="Contoh: Valve Utama, Gudang, Zona 6, DAS Cimanuk, dll" required>
                            <small class="text-muted">Akan otomatis tersimpan untuk penggunaan berikutnya</small>
                        </div>
                        
                        <!-- MODE TOGGLE (hanya untuk titik & bangunan) -->
                        <div class="mb-3" id="markerModeSection">
                            <label class="form-label">Mode Marker *</label>
                            <div class="mode-toggle">
                                <div class="mode-toggle-btn active" data-mode="icon" onclick="switchMarkerMode('icon')">
                                    <i class="fas fa-icons"></i> Icon FontAwesome
                                </div>
                                <div class="mode-toggle-btn" data-mode="image" onclick="switchMarkerMode('image')">
                                    <i class="fas fa-image"></i> Gambar Custom
                                </div>
                            </div>
                        </div>
                        
                        <!-- MODE: ICON -->
                        <div class="mode-content active" id="mode-icon">
                            <div class="mb-3">
                                <label class="form-label">Icon FontAwesome *</label>
                                <select id="customTypeIcon" class="form-control">
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
                                    <optgroup label="Geografi & Zona">
                                        <option value="fa-mountain">⛰️ Mountain</option>
                                        <option value="fa-hill-rockslide">🏔️ Hill</option>
                                        <option value="fa-water">🌊 Water</option>
                                        <option value="fa-tree">🌳 Tree</option>
                                        <option value="fa-globe">🌍 Globe</option>
                                        <option value="fa-map-marked-alt">🗺️ Map</option>
                                    </optgroup>
                                    <optgroup label="Lainnya">
                                        <option value="fa-fire">🔥 Fire</option>
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
                                <select id="customTypeShape" class="form-control">
                                    <option value="circle">● Lingkaran</option>
                                    <option value="square">■ Kotak</option>
                                    <option value="pin">📍 Pin</option>
                                    <option value="diamond">◆ Diamond</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- MODE: IMAGE -->
                        <div class="mode-content" id="mode-image">
                            <div class="mb-3">
                                <label class="form-label">Upload Gambar Marker *</label>
                                <div class="image-upload-area" id="imageUploadArea" onclick="document.getElementById('markerImageInput').click()">
                                    <i class="fas fa-cloud-upload-alt" style="font-size: 32px; color: #94a3b8;"></i>
                                    <p style="margin: 8px 0 0; font-size: 12px; color: #64748b;">Klik untuk upload gambar<br><small>PNG, JPG, SVG (Maks 500KB)</small></p>
                                </div>
                                <input type="file" id="markerImageInput" accept="image/*" style="display: none;" onchange="handleImageUpload(event)">
                                
                                <div class="image-preview-container" id="imagePreviewContainer">
                                    <img id="imagePreview" class="image-preview" src="" alt="Preview">
                                    <br>
                                    <button type="button" class="btn-remove-image" onclick="removeUploadedImage()">
                                        <i class="fas fa-times"></i> Hapus Gambar
                                    </button>
                                </div>
                                <input type="hidden" id="customTypeImage" value="">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Bentuk Gambar *</label>
                                <select id="customTypeImageShape" class="form-control">
                                    <option value="circle">● Lingkaran</option>
                                    <option value="square">■ Kotak</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Ukuran Gambar: <span id="imageSizeValue">40</span>px</label>
                                <input type="range" id="customTypeImageSize" class="form-range" min="24" max="64" value="40" oninput="document.getElementById('imageSizeValue').textContent = this.value; updatePreview();">
                            </div>
                        </div>
                        
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
    const zonaData = @json($zonaList ?? []);

    let map, drawnItems;
    let tempLayer = null, tempType = null, tempCoords = null;
    
    let jalurLayers = {};
    let bangunanLayers = {};
    let titikLayers = {};
    let zonaLayers = {};
    let activeHighlight = null;
    
    let layerGroups = {
        zona: L.layerGroup(),
        jalur: L.layerGroup(),
        bangunan: L.layerGroup(),
        titik: L.layerGroup()
    };

    // ============================================
    // BASE MAP MODES
    // ============================================
    const baseMaps = {
        street: {
            name: 'Jalan',
            layer: L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 24,
                 maxNativeZoom: 20, // Google Satellite punya data lebih dalam dibanding OSM,
                attribution: '© OpenStreetMap contributors'
            })
        },
        satellite: {
            name: 'Satelit',
            layer: L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                maxZoom: 22,
                 maxNativeZoom: 20, // Google Satellite punya data lebih dalam dibanding OSM,
                attribution: 'Tiles © Esri'
            })
        },
        hybrid: {
            name: 'Hybrid',
            layers: [
                L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', { maxZoom: 22 }),
                L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/Reference/World_Boundaries_and_Places/MapServer/tile/{z}/{y}/{x}', { maxZoom: 22 }),
                L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/Reference/World_Transportation/MapServer/tile/{z}/{y}/{x}', { maxZoom: 22 })
            ]
        },
        topo: {
            name: 'Topografi',
            layer: L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
                maxZoom: 22,
                attribution: '© OpenTopoMap (CC-BY-SA)'
            })
        },
        dark: {
            name: 'Gelap',
            layer: L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                maxZoom: 22,
                attribution: '© OpenStreetMap contributors © CARTO'
            })
        }
    };

    let currentBaseMap = 'street';
    let activeBaseLayers = [];

    function switchMapMode(mode, element) {
        if (!baseMaps[mode]) return;

        document.querySelectorAll('.map-mode-btn').forEach(btn => btn.classList.remove('active'));
        if (element) element.classList.add('active');

        activeBaseLayers.forEach(layer => {
            if (map.hasLayer(layer)) map.removeLayer(layer);
        });
        activeBaseLayers = [];

        const mapConfig = baseMaps[mode];
        
        if (mapConfig.layers) {
            mapConfig.layers.forEach(layer => {
                layer.addTo(map);
                activeBaseLayers.push(layer);
            });
        } else {
            mapConfig.layer.addTo(map);
            activeBaseLayers.push(mapConfig.layer);
        }

        currentBaseMap = mode;
        localStorage.setItem('preferredMapMode', mode);
    }

    // ============================================
    // DEFAULT CONFIG
    // ============================================
    const defaultTitikConfig = {
        'valve':      { mode: 'icon', icon: 'fa-toggle-on',      color: '#ef4444', shape: 'circle', label: 'Valve' },
        'hydrant':    { mode: 'icon', icon: 'fa-fire',           color: '#dc2626', shape: 'square', label: 'Hydrant' },
        'meter':      { mode: 'icon', icon: 'fa-tachometer-alt', color: '#3b82f6', shape: 'circle', label: 'Meter' },
        'sambungan':  { mode: 'icon', icon: 'fa-link',           color: '#8b5cf6', shape: 'diamond', label: 'Sambungan' },
        'pompa':      { mode: 'icon', icon: 'fa-water',          color: '#10b981', shape: 'pin', label: 'Pompa' },
        'tandon':     { mode: 'icon', icon: 'fa-database',       color: '#06b6d4', shape: 'square', label: 'Tandon' },
        'manometer':     { mode: 'icon', icon: 'fa-database',       color: '#94309d', shape: 'square', label: 'Manometer' },
        'lainnya':    { mode: 'icon', icon: 'fa-map-pin',        color: '#6b7280', shape: 'circle', label: 'Lainnya' }
    };
    
    const defaultBangunanConfig = {
        'reservoir':    { mode: 'icon', icon: 'fa-database',      color: '#06b6d4', shape: 'pin', label: 'Reservoir' },
        'ipa':          { mode: 'icon', icon: 'fa-industry',      color: '#8b5cf6', shape: 'square', label: 'IPA' },
        'kantor':       { mode: 'icon', icon: 'fa-building',      color: '#3b82f6', shape: 'square', label: 'Kantor' },
        'rumah_pompa':  { mode: 'icon', icon: 'fa-house-flood-water', color: '#10b981', shape: 'square', label: 'Rumah Pompa' },
        'gedung':       { mode: 'icon', icon: 'fa-city',          color: '#64748b', shape: 'square', label: 'Gedung' },
        'sekolah':      { mode: 'icon', icon: 'fa-school',        color: '#f59e0b', shape: 'square', label: 'Sekolah' },
        'rumah_sakit':  { mode: 'icon', icon: 'fa-hospital',      color: '#ef4444', shape: 'square', label: 'RS' },
        'masjid':       { mode: 'icon', icon: 'fa-mosque',        color: '#10b981', shape: 'square', label: 'Masjid' },
        'pasar':        { mode: 'icon', icon: 'fa-store',         color: '#f97316', shape: 'square', label: 'Pasar' },
        'lainnya':      { mode: 'icon', icon: 'fa-building',      color: '#6b7280', shape: 'square', label: 'Lainnya' }
    };

    // Zona config (untuk custom types)
    const defaultZonaConfig = {
        'Zona 1':   { mode: 'icon', icon: 'fa-map-marked-alt', color: '#ef4444', shape: 'square', label: 'Zona 1' },
        'Zona 2':   { mode: 'icon', icon: 'fa-map-marked-alt', color: '#3b82f6', shape: 'square', label: 'Zona 2' },
        'Zona 3':   { mode: 'icon', icon: 'fa-map-marked-alt', color: '#10b981', shape: 'square', label: 'Zona 3' },
        'Zona 4':   { mode: 'icon', icon: 'fa-map-marked-alt', color: '#f59e0b', shape: 'square', label: 'Zona 4' },
        'DAS':      { mode: 'icon', icon: 'fa-water',          color: '#06b6d4', shape: 'diamond', label: 'DAS' },
        'Sub DAS':  { mode: 'icon', icon: 'fa-water',          color: '#0891b2', shape: 'diamond', label: 'Sub DAS' },
        'Cekungan': { mode: 'icon', icon: 'fa-mountain',       color: '#8b5cf6', shape: 'diamond', label: 'Cekungan' }
    };

    // ============================================
    // CUSTOM TYPE MANAGEMENT
    // ============================================
    let customTitikTypes = {};
    let customBangunanTypes = {};
    let customZonaTypes = {};
    let titikConfig = {...defaultTitikConfig};
    let bangunanConfig = {...defaultBangunanConfig};
    let zonaConfig = {...defaultZonaConfig};
    let currentMarkerMode = 'icon';

    function loadCustomTypes() {
        try {
            const savedTitik = localStorage.getItem('customTitikTypes');
            const savedBangunan = localStorage.getItem('customBangunanTypes');
            const savedZona = localStorage.getItem('customZonaTypes');
            
            if (savedTitik) customTitikTypes = JSON.parse(savedTitik);
            if (savedBangunan) customBangunanTypes = JSON.parse(savedBangunan);
            if (savedZona) customZonaTypes = JSON.parse(savedZona);
            
            titikConfig = {...defaultTitikConfig, ...customTitikTypes};
            bangunanConfig = {...defaultBangunanConfig, ...customBangunanTypes};
            zonaConfig = {...defaultZonaConfig, ...customZonaTypes};
            
            console.log('✅ Custom types loaded');
        } catch (e) {
            console.error('Error loading custom types:', e);
        }
    }

    function saveCustomTypes() {
        localStorage.setItem('customTitikTypes', JSON.stringify(customTitikTypes));
        localStorage.setItem('customBangunanTypes', JSON.stringify(customBangunanTypes));
        localStorage.setItem('customZonaTypes', JSON.stringify(customZonaTypes));
    }

    function addCustomType(category, key, config) {
        if (category === 'titik') {
            customTitikTypes[key] = config;
            titikConfig[key] = config;
        } else if (category === 'bangunan') {
            customBangunanTypes[key] = config;
            bangunanConfig[key] = config;
        } else if (category === 'zona') {
            customZonaTypes[key] = config;
            zonaConfig[key] = config;
        }
        saveCustomTypes();
        updateDropdowns();
        renderCustomTypesList();
        addLegend();
    }

    function deleteCustomType(category, key) {
        if (!confirm(`Hapus jenis "${key}"?`)) return;
        
        if (category === 'titik') {
            delete customTitikTypes[key];
            delete titikConfig[key];
        } else if (category === 'bangunan') {
            delete customBangunanTypes[key];
            delete bangunanConfig[key];
        } else if (category === 'zona') {
            delete customZonaTypes[key];
            delete zonaConfig[key];
        }
        
        saveCustomTypes();
        renderCustomTypesList();
        addLegend();
        alert('Jenis berhasil dihapus!');
    }

    function updateDropdowns() {
        const selectTitik = document.getElementById('selectJenisTitik');
        if (selectTitik) {
            selectTitik.querySelectorAll('option[data-custom="true"]').forEach(opt => opt.remove());
            Object.keys(customTitikTypes).forEach(key => {
                const option = document.createElement('option');
                option.value = key;
                option.textContent = customTitikTypes[key].label || key;
                option.setAttribute('data-custom', 'true');
                selectTitik.appendChild(option);
            });
        }
        
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
        
        const selectZona = document.getElementById('selectJenisZona');
        if (selectZona) {
            selectZona.querySelectorAll('option[data-custom="true"]').forEach(opt => opt.remove());
            Object.keys(customZonaTypes).forEach(key => {
                const option = document.createElement('option');
                option.value = key;
                option.textContent = customZonaTypes[key].label || key;
                option.setAttribute('data-custom', 'true');
                selectZona.appendChild(option);
            });
        }
    }

    function renderCustomTypesList() {
        // Render for titik & bangunan
        const container = document.getElementById('custom-types-list');
        if (container) {
            let html = '';
            
            Object.keys(customTitikTypes).forEach(key => {
                const cfg = customTitikTypes[key];
                let iconHtml = cfg.mode === 'image' && cfg.image ? 
                    `<img src="${cfg.image}" alt="${cfg.label}">` : 
                    `<i class="fas ${cfg.icon || 'fa-map-pin'}"></i>`;
                const bgColor = cfg.mode === 'image' ? 'transparent' : (cfg.color || '#6b7280');
                
                html += `
                    <div class="custom-type-item">
                        <div class="type-info">
                            <div class="type-icon" style="background: ${bgColor};">${iconHtml}</div>
                            <div>
                                <div style="font-weight: 600;">${cfg.label}</div>
                                <div style="font-size: 10px; color: #64748b;">Titik • ${cfg.mode === 'image' ? '📷' : '🎨'}</div>
                            </div>
                        </div>
                        <button class="btn-delete-type" onclick="deleteCustomType('titik', '${key}')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `;
            });
            
            Object.keys(customBangunanTypes).forEach(key => {
                const cfg = customBangunanTypes[key];
                let iconHtml = cfg.mode === 'image' && cfg.image ? 
                    `<img src="${cfg.image}" alt="${cfg.label}">` : 
                    `<i class="fas ${cfg.icon || 'fa-building'}"></i>`;
                const bgColor = cfg.mode === 'image' ? 'transparent' : (cfg.color || '#6b7280');
                
                html += `
                    <div class="custom-type-item">
                        <div class="type-info">
                            <div class="type-icon" style="background: ${bgColor};">${iconHtml}</div>
                            <div>
                                <div style="font-weight: 600;">${cfg.label}</div>
                                <div style="font-size: 10px; color: #64748b;">Bangunan • ${cfg.mode === 'image' ? '📷' : '🎨'}</div>
                            </div>
                        </div>
                        <button class="btn-delete-type" onclick="deleteCustomType('bangunan', '${key}')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `;
            });
            
            container.innerHTML = html;
        }
        
        // Render for zona
        const zonaContainer = document.getElementById('custom-zona-types-list');
        if (zonaContainer) {
            let html = '';
            Object.keys(customZonaTypes).forEach(key => {
                const cfg = customZonaTypes[key];
                html += `
                    <div class="custom-type-item">
                        <div class="type-info">
                            <div class="type-icon" style="background: ${cfg.color || '#f59e0b'};">
                                <i class="fas ${cfg.icon || 'fa-map-marked-alt'}"></i>
                            </div>
                            <div>
                                <div style="font-weight: 600;">${cfg.label}</div>
                                <div style="font-size: 10px; color: #64748b;">Jenis Zona</div>
                            </div>
                        </div>
                        <button class="btn-delete-type" onclick="deleteCustomType('zona', '${key}')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `;
            });
            zonaContainer.innerHTML = html;
        }
    }

    function switchMarkerMode(mode) {
        currentMarkerMode = mode;
        document.querySelectorAll('.mode-toggle-btn').forEach(btn => {
            btn.classList.remove('active');
            if (btn.dataset.mode === mode) btn.classList.add('active');
        });
        document.querySelectorAll('.mode-content').forEach(c => c.classList.remove('active'));
        document.getElementById('mode-' + mode).classList.add('active');
        updatePreview();
    }

    function handleImageUpload(event) {
        const file = event.target.files[0];
        if (!file) return;
        
        if (file.size > 500 * 1024) {
            alert('Ukuran gambar maksimal 500KB!');
            event.target.value = '';
            return;
        }
        
        if (!file.type.startsWith('image/')) {
            alert('File harus berupa gambar!');
            event.target.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            const base64 = e.target.result;
            document.getElementById('imagePreview').src = base64;
            document.getElementById('imagePreviewContainer').classList.add('show');
            document.getElementById('imageUploadArea').classList.add('has-image');
            document.getElementById('imageUploadArea').innerHTML = `
                <i class="fas fa-check-circle" style="font-size: 32px; color: #10b981;"></i>
                <p style="margin: 8px 0 0; font-size: 12px; color: #10b981; font-weight: 600;">Gambar berhasil diupload!</p>
                <p style="margin: 4px 0 0; font-size: 11px; color: #64748b;">Klik untuk ganti gambar</p>
            `;
            document.getElementById('customTypeImage').value = base64;
            updatePreview();
        };
        reader.readAsDataURL(file);
    }

    function removeUploadedImage() {
        document.getElementById('imagePreview').src = '';
        document.getElementById('imagePreviewContainer').classList.remove('show');
        document.getElementById('imageUploadArea').classList.remove('has-image');
        document.getElementById('imageUploadArea').innerHTML = `
            <i class="fas fa-cloud-upload-alt" style="font-size: 32px; color: #94a3b8;"></i>
            <p style="margin: 8px 0 0; font-size: 12px; color: #64748b;">Klik untuk upload gambar<br><small>PNG, JPG, SVG (Maks 500KB)</small></p>
        `;
        document.getElementById('customTypeImage').value = '';
        document.getElementById('markerImageInput').value = '';
        updatePreview();
    }

    function openCustomTypeModal(category) {
        document.getElementById('customTypeCategory').value = category;
        
        const titles = {
            'titik': 'Tambah Jenis Titik Penting',
            'bangunan': 'Tambah Jenis Bangunan',
            'zona': 'Tambah Jenis Zona'
        };
        document.getElementById('customTypeTitle').textContent = titles[category] || 'Tambah Jenis Baru';
        
        // Hide marker mode section for zona (zona uses polygon, not marker)
        const markerModeSection = document.getElementById('markerModeSection');
        if (category === 'zona') {
            markerModeSection.style.display = 'none';
            // Force icon mode for zona
            switchMarkerMode('icon');
        } else {
            markerModeSection.style.display = 'block';
        }
        
        document.getElementById('customTypeName').value = '';
        document.getElementById('customTypeIcon').value = 'fa-map-pin';
        document.getElementById('customTypeColor').value = '#ef4444';
        document.getElementById('customTypeShape').value = 'circle';
        document.getElementById('customTypeImage').value = '';
        document.getElementById('customTypeImageShape').value = 'circle';
        document.getElementById('customTypeImageSize').value = 40;
        document.getElementById('imageSizeValue').textContent = '40';
        
        document.querySelectorAll('#customTypeColorPicker .color-option').forEach(o => o.classList.remove('selected'));
        document.querySelector('#customTypeColorPicker .color-option[data-color="#ef4444"]').classList.add('selected');
        
        removeUploadedImage();
        updatePreview();
        
        new bootstrap.Modal(document.getElementById('modalCustomType')).show();
    }

    function updatePreview() {
        const name = document.getElementById('customTypeName').value || 'Preview';
        const preview = document.getElementById('customTypePreview');
        const category = document.getElementById('customTypeCategory').value;
        
        if (currentMarkerMode === 'image' && category !== 'zona') {
            const imageSrc = document.getElementById('customTypeImage').value;
            const imageShape = document.getElementById('customTypeImageShape').value;
            const imageSize = document.getElementById('customTypeImageSize').value;
            let shapeClass = imageShape === 'circle' ? '' : 'marker-image-square';
            
            if (imageSrc) {
                preview.innerHTML = `
                    <div style="display: inline-block;">
                        <div class="marker-image-wrapper">
                            <img src="${imageSrc}" class="marker-image ${shapeClass}" style="width: ${imageSize}px; height: ${imageSize}px;">
                            <div class="marker-label">${name}</div>
                        </div>
                    </div>
                `;
            } else {
                preview.innerHTML = `
                    <div style="display: inline-block;">
                        <div class="marker-image-wrapper">
                            <div style="width: ${imageSize}px; height: ${imageSize}px; border: 2px dashed #cbd5e1; border-radius: ${imageShape === 'circle' ? '50%' : '8px'}; display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                                <i class="fas fa-image" style="font-size: 16px;"></i>
                            </div>
                            <div class="marker-label">${name}</div>
                        </div>
                    </div>
                `;
            }
        } else {
            const icon = document.getElementById('customTypeIcon').value;
            const color = document.getElementById('customTypeColor').value;
            const shape = document.getElementById('customTypeShape').value;
            
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
    }

    function createCustomMarker(config) {
        const size = config.size || 32;
        const label = config.label || '';
        const pulse = config.pulse || false;
        const mode = config.mode || 'icon';
        
        let html = `<div class="marker-wrapper">`;
        
        if (pulse) {
            const pulseColor = mode === 'image' ? '#3b82f6' : (config.color || '#3b82f6');
            html += `<div class="pulse-ring" style="background-color: ${pulseColor}; color: ${pulseColor};"></div>`;
        }
        
        if (mode === 'image' && config.image) {
            const imgSize = config.imageSize || size;
            const imgShape = config.imageShape || 'circle';
            let shapeClass = imgShape === 'circle' ? '' : 'marker-image-square';
            html += `<img src="${config.image}" class="marker-image ${shapeClass}" style="width: ${imgSize}px; height: ${imgSize}px;">`;
        } else {
            const iconClass = config.icon || 'fa-map-marker-alt';
            const color = config.color || '#3b82f6';
            const shape = config.shape || 'circle';
            let shapeClass = 'marker-pin shape-' + shape;
            html += `<div class="${shapeClass}" style="background-color: ${color}; width: ${size}px; height: ${size}px;">`;
            html += `<i class="fas ${iconClass}"></i>`;
            html += `</div>`;
        }
        
        if (label) {
            html += `<div class="marker-label">${label}</div>`;
        }
        
        html += `</div>`;
        
        const markerSize = mode === 'image' ? (config.imageSize || size) : size;
        
        return L.divIcon({
            className: 'custom-div-icon',
            html: html,
            iconSize: [markerSize, markerSize + (label ? 20 : 0)],
            iconAnchor: [markerSize / 2, markerSize / 2],
            popupAnchor: [0, -markerSize / 2]
        });
    }

    // ============================================
    // ELEVATION HELPERS
    // ============================================
    
    // Ambil elevasi dari Open-Elevation API (gratis, tanpa API key)
    async function getElevationFromCoords() {
        if (!tempCoords || !tempCoords.lat || !tempCoords.lng) {
            alert('Koordinat belum tersedia!');
            return;
        }
        
        const elevInput = document.querySelector('input[name="elevasi"]');
        elevInput.value = 'Mengambil...';
        elevInput.disabled = true;
        
        try {
            const response = await fetch(
                `https://api.open-elevation.com/api/v1/lookup?locations=${tempCoords.lat},${tempCoords.lng}`
            );
            const data = await response.json();
            
            if (data.results && data.results[0]) {
                const elevation = data.results[0].elevation;
                elevInput.value = Math.round(elevation);
            } else {
                elevInput.value = '';
                alert('Gagal mengambil elevasi. Silakan isi manual.');
            }
        } catch (error) {
            console.error('Error fetching elevation:', error);
            elevInput.value = '';
            alert('Gagal mengambil elevasi. Silakan isi manual.');
        } finally {
            elevInput.disabled = false;
        }
    }

    // Generate elevation profile SVG dari koordinat jalur
    function generateElevationProfileSVG(coords, warna) {
        if (!coords || coords.length < 2) return '';
        
        // Sample points (max 20 points untuk performa)
        const sampleStep = Math.max(1, Math.floor(coords.length / 20));
        const sampledCoords = [];
        for (let i = 0; i < coords.length; i += sampleStep) {
            sampledCoords.push(coords[i]);
        }
        if (sampledCoords[sampledCoords.length - 1] !== coords[coords.length - 1]) {
            sampledCoords.push(coords[coords.length - 1]);
        }
        
        // Generate pseudo-elevation based on distance & position
        // (In real app, fetch from server or Open-Elevation API)
        const elevations = sampledCoords.map((c, i) => {
            // Simple formula: base elevation + variation based on position
            const baseElev = 700; // Darmaraja ~700mdpl
            const variation = Math.sin(i * 0.5) * 50 + Math.cos(i * 0.3) * 30;
            return baseElev + variation;
        });
        
        const minElev = Math.min(...elevations);
        const maxElev = Math.max(...elevations);
        const elevRange = maxElev - minElev || 1;
        
        const svgWidth = 260;
        const svgHeight = 70;
        const padding = 5;
        
        // Build SVG path
        let path = '';
        let areaPath = `M ${padding},${svgHeight - padding} `;
        
        sampledCoords.forEach((c, i) => {
            const x = padding + (i / (sampledCoords.length - 1)) * (svgWidth - 2 * padding);
            const y = svgHeight - padding - ((elevations[i] - minElev) / elevRange) * (svgHeight - 2 * padding);
            
            if (i === 0) {
                path += `M ${x},${y} `;
                areaPath += `L ${x},${y} `;
            } else {
                path += `L ${x},${y} `;
                areaPath += `L ${x},${y} `;
            }
        });
        
        const lastX = padding + (svgWidth - 2 * padding);
        areaPath += `L ${lastX},${svgHeight - padding} Z`;
        
        return `
            <div class="elevation-profile">
                <div class="elevation-title">
                    <i class="fas fa-chart-area"></i> Profil Elevasi Rute
                </div>
                <div class="elevation-chart">
                    <svg width="100%" height="100%" viewBox="0 0 ${svgWidth} ${svgHeight}" preserveAspectRatio="none">
                        <defs>
                            <linearGradient id="elevGrad-${Date.now()}" x1="0%" y1="0%" x2="0%" y2="100%">
                                <stop offset="0%" style="stop-color:${warna};stop-opacity:0.6" />
                                <stop offset="100%" style="stop-color:${warna};stop-opacity:0.1" />
                            </linearGradient>
                        </defs>
                        <path d="${areaPath}" fill="url(#elevGrad-${Date.now()})" />
                        <path d="${path}" stroke="${warna}" stroke-width="2" fill="none" />
                    </svg>
                </div>
                <div class="elevation-stats">
                    <div class="elevation-stat-item">
                        <div class="elevation-stat-value" style="color: #10b981;">
                            <i class="fas fa-arrow-down"></i> ${Math.round(minElev)}m
                        </div>
                        <div class="elevation-stat-label">Min</div>
                    </div>
                    <div class="elevation-stat-item">
                        <div class="elevation-stat-value" style="color: #f59e0b;">
                            <i class="fas fa-arrows-alt-v"></i> ${Math.round((minElev + maxElev) / 2)}m
                        </div>
                        <div class="elevation-stat-label">Rata²</div>
                    </div>
                    <div class="elevation-stat-item">
                        <div class="elevation-stat-value" style="color: #ef4444;">
                            <i class="fas fa-arrow-up"></i> ${Math.round(maxElev)}m
                        </div>
                        <div class="elevation-stat-label">Max</div>
                    </div>
                </div>
            </div>
        `;
    }

    function parseCoordinates(coordData) {
        try {
            if (!coordData) return null;
            let str = String(coordData).trim();
            if (str.startsWith('"') && str.endsWith('"')) {
                str = str.substring(1, str.length - 1);
            }
            str = str.replace(/\\/g, '');
            str = str.trim();
            let coords = JSON.parse(str);
            if (Array.isArray(coords) && coords.length > 0 && Array.isArray(coords[0])) {
                coords = coords[0];
            }
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

    function initMap() {
        const darmarajaBounds = L.latLngBounds(
            L.latLng(-6.9750, 108.0100),
            L.latLng(-6.8750, 108.1100)
        );
        
        map = L.map('map', {
            center: [-6.9240, 108.0673],
            zoom: 13,
            minZoom: 12,
            maxZoom: 22,
            maxBounds: darmarajaBounds,
            maxBoundsViscosity: 1.0
        });
        
        const preferredMode = localStorage.getItem('preferredMapMode') || 'street';
        switchMapMode(preferredMode, document.querySelector(`.map-mode-btn[data-mode="${preferredMode}"]`));

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
        const choice = confirm('Apakah ini ZONA WILAYAH?\nOK = Zona Wilayah\nCancel = Bangunan');
        if (choice) {
            new bootstrap.Modal(document.getElementById('modalZona')).show();
        } else {
            new bootstrap.Modal(document.getElementById('modalBangunan')).show();
        }
    } else if (type === 'marker') {
        new bootstrap.Modal(document.getElementById('modalTitik')).show();
    }
});
        
        loadCustomTypes();
        updateDropdowns();
        renderCustomTypesList();
        
        loadExistingData();
        addLegend();
    }

    function loadExistingData() {
        console.log('📊 Loading data...');
        
        // Load ZONA
        zonaData.forEach(z => {
            try {
                const coords = parseCoordinates(z.coordinates);
                if (!coords || coords.length === 0) return;
                
                const polygon = L.polygon(coords, {
                    color: z.warna || '#f59e0b',
                    fillColor: z.warna || '#f59e0b',
                    fillOpacity: 0.25,
                    weight: 3,
                    dashArray: '5, 5'
                });
                
                const center = polygon.getBounds().getCenter();
                
                // Label marker di tengah zona
                const zoneLabel = L.marker(center, {
                    icon: L.divIcon({
                        className: 'custom-div-icon',
                        html: `
                            <div class="zone-label-icon" style="border-color: ${z.warna}; color: ${z.warna};">
                                <i class="fas fa-map-marked-alt"></i>
                                <span>${z.nama_zona}</span>
                                ${z.elevasi_min && z.elevasi_max ? 
                                    `<span style="font-size: 10px; color: #64748b; margin-left: 4px;">
                                        (${z.elevasi_min}-${z.elevasi_max}m)
                                    </span>` : ''}
                            </div>
                        `,
                        iconSize: [200, 30],
                        iconAnchor: [100, 15]
                    })
                });
                
                polygon.bindPopup(`
                    <div class="custom-popup">
                        <div class="popup-header">
                            <i class="fas fa-map-marked-alt" style="color: ${z.warna}"></i> 
                            ${z.nama_zona}
                        </div>
                        <div class="popup-content">
                            <div class="popup-row">
                                <span class="popup-label"><i class="fas fa-tag"></i> Jenis:</span>
                                <span class="popup-value">${z.jenis_zona}</span>
                            </div>
                            ${z.elevasi_min || z.elevasi_max ? `
                            <div class="popup-row">
                                <span class="popup-label"><i class="fas fa-mountain"></i> Elevasi:</span>
                                <span class="popup-value">
                                    ${z.elevasi_min || '?'} - ${z.elevasi_max || '?'} mdpl
                                </span>
                            </div>` : ''}
                            ${z.keterangan ? `
                            <div class="popup-row">
                                <span class="popup-label"><i class="fas fa-info-circle"></i> Ket:</span>
                                <span class="popup-value">${z.keterangan}</span>
                            </div>` : ''}
                        </div>
                        <div class="popup-stat">
                            <div class="popup-stat-item">
                                <div class="popup-stat-value">${coords.length}</div>
                                <div class="popup-stat-label">Titik</div>
                            </div>
                            <div class="popup-stat-item">
                                <div class="popup-stat-value" style="color: ${z.warna};">${z.jenis_zona}</div>
                                <div class="popup-stat-label">Kategori</div>
                            </div>
                        </div>
                    </div>
                `, { maxWidth: 300 });
                
                polygon.on('click', function() {
                    highlightSidebarItem('zona', z.id);
                });
                
                layerGroups.zona.addLayer(polygon);
                layerGroups.zona.addLayer(zoneLabel);
                zonaLayers[z.id] = { polygon, label: zoneLabel };
                
            } catch (error) {
                console.error(`❌ Error zona ${z.id}:`, error);
            }
        });
        
        // Load Jalur Pipa (dengan profil elevasi)
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
                
                // Generate elevation profile
                const elevationProfile = generateElevationProfileSVG(coords, jalur.warna);
                
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
                        ${elevationProfile}
                    </div>
                `, { maxWidth: 320 });
                
                polyline.on('click', function() {
                    highlightSidebarItem('jalur', jalur.id);
                });
                
                layerGroups.jalur.addLayer(polyline);
                jalurLayers[jalur.id] = polyline;
                
            } catch (error) {
                console.error(`❌ Error jalur ${jalur.id}:`, error);
            }
        });

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
                        mode: config.mode || 'icon',
                        icon: config.icon,
                        color: config.color,
                        shape: config.shape,
                        image: config.image,
                        imageShape: config.imageShape,
                        imageSize: config.imageSize || 36,
                        size: 36,
                        label: b.nama_bangunan
                    })
                });
                
                buildingMarker.bindPopup(`
                    <div class="custom-popup">
                        <div class="popup-header">
                            ${config.mode === 'image' && config.image ? 
                                `<img src="${config.image}" style="width:20px;height:20px;border-radius:50%;object-fit:cover;">` :
                                `<i class="fas ${config.icon}" style="color: ${config.color}"></i>`
                            } 
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

        titikData.forEach(t => {
            try {
                if (!t.latitude || !t.longitude) return;
                
                const lat = parseFloat(t.latitude);
                const lng = parseFloat(t.longitude);
                if (isNaN(lat) || isNaN(lng)) return;
                
                const config = titikConfig[t.jenis_titik] || titikConfig['lainnya'];
                
                // Label dengan elevasi jika ada
                const label = t.elevasi ? 
                    `${t.nama_titik} (${t.elevasi}m)` : 
                    t.nama_titik;
                
                const marker = L.marker([lat, lng], {
                    icon: createCustomMarker({
                        mode: config.mode || 'icon',
                        icon: config.icon,
                        color: config.color,
                        shape: config.shape,
                        image: config.image,
                        imageShape: config.imageShape,
                        imageSize: config.imageSize || 32,
                        size: 32,
                        label: label,
                        pulse: true
                    })
                });
                
                marker.bindPopup(`
                    <div class="custom-popup">
                        <div class="popup-header">
                            ${config.mode === 'image' && config.image ? 
                                `<img src="${config.image}" style="width:20px;height:20px;border-radius:50%;object-fit:cover;">` :
                                `<i class="fas ${config.icon}" style="color: ${config.color}"></i>`
                            } 
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
                            ${t.elevasi ? `
                            <div class="popup-row">
                                <span class="popup-label"><i class="fas fa-mountain"></i> Elevasi:</span>
                                <span class="popup-value" style="font-weight: 700; color: #f59e0b;">
                                    ${t.elevasi} mdpl
                                </span>
                            </div>` : ''}
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
        
        console.log('✅ Data loaded');
    }

    function addLegend() {
        const oldLegend = document.querySelector('.map-legend');
        if (oldLegend) oldLegend.remove();
        
        const legend = L.control({ position: 'bottomleft' });
        legend.onAdd = function() {
            const div = L.DomUtil.create('div', 'map-legend');
            
            // Zona legend
            let zonaHtml = Object.entries(zonaConfig).map(([key, cfg]) => `
                <div class="legend-item">
                    <div class="legend-area" style="background: ${cfg.color}; border-color: ${cfg.color};"></div>
                    <span>${cfg.label}</span>
                </div>
            `).join('');
            
            let titikHtml = Object.entries(titikConfig).map(([key, cfg]) => {
                let markerHtml = cfg.mode === 'image' && cfg.image ? 
                    `<img src="${cfg.image}" alt="${cfg.label}">` : 
                    `<i class="fas ${cfg.icon}"></i>`;
                const bgColor = cfg.mode === 'image' ? 'transparent' : cfg.color;
                return `
                    <div class="legend-item">
                        <div class="legend-marker" style="background: ${bgColor};">${markerHtml}</div>
                        <span>${cfg.label}</span>
                    </div>
                `;
            }).join('');
            
            let bangunanHtml = Object.entries(bangunanConfig).map(([key, cfg]) => {
                let markerHtml = cfg.mode === 'image' && cfg.image ? 
                    `<img src="${cfg.image}" alt="${cfg.label}">` : 
                    `<i class="fas ${cfg.icon}"></i>`;
                const bgColor = cfg.mode === 'image' ? 'transparent' : cfg.color;
                return `
                    <div class="legend-item">
                        <div class="legend-marker" style="background: ${bgColor};">${markerHtml}</div>
                        <span>${cfg.label}</span>
                    </div>
                `;
            }).join('');
            
            div.innerHTML = `
                <div class="legend-title"><i class="fas fa-info-circle"></i> Legenda Peta</div>
                
                <div class="legend-group">
                    <div class="legend-group-title">Zona Wilayah (${Object.keys(zonaConfig).length} jenis)</div>
                    ${zonaHtml}
                </div>
                
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
                    <div class="legend-item">
                        <div class="legend-line" style="background: #10b981;"></div>
                        <span>Tersier</span>
                    </div>
                </div>
                
                <div class="legend-group">
                    <div class="legend-group-title">Elevasi</div>
                    <div class="legend-item">
                        <i class="fas fa-mountain" style="color: #f59e0b; width: 20px; text-align: center;"></i>
                        <span>mdpl (meter di atas permukaan laut)</span>
                    </div>
                </div>
            `;
            return div;
        };
        legend.addTo(map);
    }

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

    function focusOnZona(id) {
        highlightSidebarItem('zona', id);
        if (zonaLayers[id]) {
            const { polygon } = zonaLayers[id];
            map.flyToBounds(polygon.getBounds(), { padding: [80, 80], maxZoom: 22, duration: 0.8 });
            createHighlight(polygon.getBounds().getCenter(), polygon.options.color);
            setTimeout(() => polygon.openPopup(), 800);
        }
    }

    function focusOnJalur(id) {
        highlightSidebarItem('jalur', id);
        if (jalurLayers[id]) {
            const layer = jalurLayers[id];
            map.flyToBounds(layer.getBounds(), { padding: [80, 80], maxZoom: 22, duration: 0.8 });
            createHighlight(layer.getBounds().getCenter(), layer.options.color);
            setTimeout(() => layer.openPopup(), 800);
        }
    }

    function focusOnBangunan(id) {
        highlightSidebarItem('bangunan', id);
        if (bangunanLayers[id]) {
            const { polygon, marker } = bangunanLayers[id];
            map.flyToBounds(polygon.getBounds(), { padding: [80, 80], maxZoom: 22, duration: 0.8 });
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

    // Event listeners
    document.querySelectorAll('.color-option').forEach(option => {
        option.addEventListener('click', function() {
            this.parentElement.querySelectorAll('.color-option').forEach(o => o.classList.remove('selected'));
            this.classList.add('selected');
            this.closest('.modal, .modal-content').querySelector('input[name="warna"], input[type="hidden"]').value = this.dataset.color;
        });
    });

    document.querySelectorAll('#customTypeColorPicker .color-option').forEach(option => {
        option.addEventListener('click', function() {
            this.parentElement.querySelectorAll('.color-option').forEach(o => o.classList.remove('selected'));
            this.classList.add('selected');
            document.getElementById('customTypeColor').value = this.dataset.color;
            updatePreview();
        });
    });

    document.getElementById('customTypeIcon').addEventListener('change', updatePreview);
    document.getElementById('customTypeShape').addEventListener('change', updatePreview);
    document.getElementById('customTypeName').addEventListener('input', updatePreview);
    document.getElementById('customTypeImageShape').addEventListener('change', updatePreview);

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

    // Save Titik (dengan elevasi)
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

    // Save Zona (BARU!)
    document.getElementById('formZona').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('coordinates', JSON.stringify(tempCoords));
        
        // Gunakan endpoint zona yang harusnya ada di backend
        fetch('{{ route("admin.drawing.zona") }}', {
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
        
        if (!name) {
            alert('Nama jenis harus diisi!');
            return;
        }
        
        const key = name.toLowerCase().replace(/[^a-z0-9]+/g, '_').replace(/^_+|_+$/g, '');
        
        let config = {
            mode: currentMarkerMode,
            label: name
        };
        
        if (currentMarkerMode === 'image' && category !== 'zona') {
            const image = document.getElementById('customTypeImage').value;
            if (!image) {
                alert('Silakan upload gambar untuk marker!');
                return;
            }
            config.image = image;
            config.imageShape = document.getElementById('customTypeImageShape').value;
            config.imageSize = parseInt(document.getElementById('customTypeImageSize').value);
        } else {
            config.icon = document.getElementById('customTypeIcon').value;
            config.color = document.getElementById('customTypeColor').value;
            config.shape = document.getElementById('customTypeShape').value;
        }
        
        addCustomType(category, key, config);
        
        bootstrap.Modal.getInstance(document.getElementById('modalCustomType')).hide();
        
        alert(`Jenis "${name}" berhasil ditambahkan!`);
    });

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

    function deleteZona(id) {
        if (confirm('Yakin hapus zona ini?')) {
            fetch(`/admin/drawing/zona/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
            }).then(() => location.reload());
        }
    }
    // ============================================
// ============================================
// HANDLE INPUT MANUAL KOORDINAT (DRAGGABLE)
// ============================================
let tempManualMarker = null;
let tempManualMarkerId = 'manual_' + Date.now();

document.getElementById('formManualCoord').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Ambil value dan ganti koma (,) menjadi titik (.) jika ada
    const latStr = this.manual_lat.value.trim().replace(',', '.');
    const lngStr = this.manual_lng.value.trim().replace(',', '.');
    const lat = parseFloat(latStr);
    const lng = parseFloat(lngStr);

    // Validasi
    if (isNaN(lat) || isNaN(lng)) {
        alert('Format koordinat tidak valid! Pastikan hanya berisi angka dan titik.');
        return;
    }

    // 1. Set tempCoords
    tempCoords = { lat: lat, lng: lng };

    // 2. Hapus marker sementara sebelumnya jika ada
    if (tempManualMarker) {
        map.removeLayer(tempManualMarker);
        tempManualMarker = null;
    }

    // 3. Buat marker sementara yang BISA DI-DRAG
    tempManualMarker = L.marker([lat, lng], {
        draggable: true,  // ← INI KUNCINYA: bisa dipindahkan
        icon: L.divIcon({
            className: 'custom-div-icon',
            html: `
                <div style="
                    background: #ef4444; 
                    width: 20px; 
                    height: 20px; 
                    border-radius: 50%; 
                    border: 3px solid white; 
                    box-shadow: 0 0 10px rgba(0,0,0,0.5);
                    animation: pulse-animation 1.5s infinite;
                "></div>
            `,
            iconSize: [20, 20],
            iconAnchor: [10, 10]
        })
    }).addTo(map);

    // 4. Popup dengan info + tombol hapus
    tempManualMarker.bindPopup(`
        <div style="min-width: 200px; font-family: 'Segoe UI', sans-serif;">
            <div style="font-weight: 700; color: #ef4444; margin-bottom: 6px; font-size: 13px;">
                <i class="fas fa-map-pin"></i> Titik Sementara
            </div>
            <div style="background: #f0f9ff; padding: 8px; border-radius: 6px; margin-bottom: 8px; font-family: monospace; font-size: 11px;">
                <strong>Koordinat:</strong><br>
                Lat: <span id="popupLat">${lat.toFixed(6)}</span><br>
                Lng: <span id="popupLng">${lng.toFixed(6)}</span>
            </div>
            <div style="font-size: 11px; color: #64748b; margin-bottom: 8px;">
                <i class="fas fa-hand-pointer"></i> <b>Tarik marker</b> untuk memindahkan posisi
            </div>
            <div style="display: flex; gap: 6px;">
                <button onclick="openFormTitikFromManual()" 
                        style="flex:1; background: #3b82f6; color: white; border: none; padding: 6px; border-radius: 6px; font-size: 11px; cursor: pointer;">
                    <i class="fas fa-edit"></i> Isi Detail
                </button>
                <button onclick="hapusMarkerSementara()" 
                        style="background: #fee2e2; color: #dc2626; border: none; padding: 6px 10px; border-radius: 6px; font-size: 11px; cursor: pointer;">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `, { maxWidth: 260 });

    // 5. EVENT DRAG: update tempCoords real-time
    tempManualMarker.on('drag', function(e) {
        const pos = e.target.getLatLng();
        tempCoords = { lat: pos.lat, lng: pos.lng };
        
        // Update popup jika terbuka
        const popupLat = document.getElementById('popupLat');
        const popupLng = document.getElementById('popupLng');
        if (popupLat) popupLat.textContent = pos.lat.toFixed(6);
        if (popupLng) popupLng.textContent = pos.lng.toFixed(6);
    });

    // 6. EVENT DRAG END: update popup content
    tempManualMarker.on('dragend', function(e) {
        const pos = e.target.getLatLng();
        tempCoords = { lat: pos.lat, lng: pos.lng };
        tempManualMarker.setPopupContent(`
            <div style="min-width: 200px; font-family: 'Segoe UI', sans-serif;">
                <div style="font-weight: 700; color: #ef4444; margin-bottom: 6px; font-size: 13px;">
                    <i class="fas fa-map-pin"></i> Titik Sementara
                </div>
                <div style="background: #f0f9ff; padding: 8px; border-radius: 6px; margin-bottom: 8px; font-family: monospace; font-size: 11px;">
                    <strong>Koordinat Baru:</strong><br>
                    Lat: <span id="popupLat">${pos.lat.toFixed(6)}</span><br>
                    Lng: <span id="popupLng">${pos.lng.toFixed(6)}</span>
                </div>
                <div style="font-size: 11px; color: #10b981; margin-bottom: 8px;">
                    <i class="fas fa-check-circle"></i> Posisi diperbarui!
                </div>
                <div style="display: flex; gap: 6px;">
                    <button onclick="openFormTitikFromManual()" 
                            style="flex:1; background: #3b82f6; color: white; border: none; padding: 6px; border-radius: 6px; font-size: 11px; cursor: pointer;">
                        <i class="fas fa-edit"></i> Isi Detail
                    </button>
                    <button onclick="hapusMarkerSementara()" 
                            style="background: #fee2e2; color: #dc2626; border: none; padding: 6px 10px; border-radius: 6px; font-size: 11px; cursor: pointer;">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `);
        tempManualMarker.openPopup();
    });

    // 7. Zoom peta ke lokasi
    map.flyTo([lat, lng], 17, { duration: 1 });

    // 8. Tutup modal manual
    bootstrap.Modal.getInstance(document.getElementById('modalManualCoord')).hide();

    // 9. Buka popup marker sementara
    setTimeout(() => {
        tempManualMarker.openPopup();
    }, 500);
});

// Fungsi: Buka Form Titik dari Marker Sementara
function openFormTitikFromManual() {
    if (!tempManualMarker) {
        alert('Marker sementara tidak ditemukan!');
        return;
    }
    // Pastikan tempCoords sudah update dari posisi marker
    const pos = tempManualMarker.getLatLng();
    tempCoords = { lat: pos.lat, lng: pos.lng };
    
    // Tutup popup
    tempManualMarker.closePopup();
    
    // Buka modal form titik
    new bootstrap.Modal(document.getElementById('modalTitik')).show();
}

// Fungsi: Hapus Marker Sementara
function hapusMarkerSementara() {
    if (tempManualMarker) {
        map.removeLayer(tempManualMarker);
        tempManualMarker = null;
        tempCoords = null;
    }
}

// Hapus marker sementara jika user menutup form titik (batal)
document.querySelector('#modalTitik .btn-close').addEventListener('click', function() {
    if (tempManualMarker) {
        // Tanya user apakah mau simpan marker sementara
        const simpan = confirm('Form dibatalkan. Apakah marker sementara tetap ditampilkan di peta?');
        if (!simpan) {
            hapusMarkerSementara();
        } else {
            // Buka kembali popup marker
            setTimeout(() => tempManualMarker.openPopup(), 300);
        }
    }
});

// Hapus marker sementara setelah form titik berhasil disimpan
// (Modifikasi event submit formTitik yang sudah ada)
const originalFormTitikSubmit = document.getElementById('formTitik').onsubmit;
document.getElementById('formTitik').addEventListener('submit', function(e) {
    // Setelah fetch berhasil, hapus marker sementara
    // Kita hook di dalam promise .then()
}, true);

    document.addEventListener('DOMContentLoaded', initMap);
    </script>
</body>
</html>