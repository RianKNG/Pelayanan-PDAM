<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Jaringan Pipa - PDAM Tirta Medal Sumedang</title>
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Inter', sans-serif; 
            background: #f8fafc;
            overflow-x: hidden;
        }
        
        .top-info-bar {
            background: linear-gradient(135deg, #0f172a 0%, #1e3c72 50%, #2a5298 100%);
            color: white;
            padding: 10px 0;
            box-shadow: 0 2px 15px rgba(15, 23, 42, 0.2);
            position: relative;
            z-index: 1000;
        }
        
        .top-info-container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .brand-section { display: flex; align-items: center; gap: 12px; }
        
        .brand-logo {
            width: 42px; height: 42px;
            background: linear-gradient(135deg, #06b6d4, #0891b2);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
            box-shadow: 0 4px 12px rgba(6, 182, 212, 0.4);
        }
        
        .brand-text h1 { font-size: 16px; font-weight: 700; margin: 0; letter-spacing: 0.5px; }
        .brand-text small { font-size: 11px; opacity: 0.8; }
        
        .alert-section {
            display: flex; align-items: center; gap: 15px;
            background: rgba(245, 158, 11, 0.15);
            border: 1px solid rgba(245, 158, 11, 0.3);
            padding: 8px 15px; border-radius: 10px;
            backdrop-filter: blur(10px);
        }
        
        .alert-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            animation: pulse-soft 2s infinite;
        }
        
        @keyframes pulse-soft {
            0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.4); }
            50% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(245, 158, 11, 0); }
        }
        
        .alert-text { font-size: 12px; }
        .alert-text strong { display: block; font-size: 13px; margin-bottom: 2px; }
        .alert-text small { opacity: 0.85; }
        
        .alert-count {
            background: #f59e0b; color: white;
            padding: 4px 10px; border-radius: 12px;
            font-weight: 700; font-size: 14px;
        }
        
        /* Notification Bar - PERLAMBATAN 60 DETIK */
        .notification-bar {
            background: rgba(16, 185, 129, 0.2);
            border: 1px solid rgba(16, 185, 129, 0.4);
            border-radius: 10px;
            padding: 8px 15px;
            flex: 1;
            max-width: 600px;
            overflow: hidden;
            position: relative;
        }
        
        .notification-title {
            font-size: 10px;
            opacity: 0.9;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
        }
        
        .notification-scroll {
            overflow: hidden;
            white-space: nowrap;
            position: relative;
        }
        
        .notification-scroll-content {
            display: inline-block;
            animation: scroll-left 60s linear infinite; /* DIPERLAMBAT dari 20s ke 60s */
            font-size: 11px;
        }
        
        .notification-item {
            display: inline-block;
            margin-right: 30px;
            padding: 4px 12px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 15px;
            backdrop-filter: blur(5px);
        }
        
        .notification-item strong { color: #fff; font-weight: 700; }
        .notification-item .amount { color: #86efac; font-weight: 700; }
        .notification-item .location { color: #fcd34d; font-size: 10px; }
        
        @keyframes scroll-left {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }
        
        .contact-bar {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 10px 0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        
        .contact-container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-around;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .contact-item {
            display: flex; align-items: center; gap: 10px;
            font-size: 13px; color: #475569;
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 10px;
            transition: all 0.2s;
            cursor: pointer;
        }
        
        .contact-item:hover {
            background: #f0f9ff;
            transform: translateY(-2px);
            color: #0369a1;
        }
        
        .contact-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #e0f2fe, #bae6fd);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #0369a1; font-size: 14px;
            flex-shrink: 0;
        }
        
        .contact-icon.whatsapp { 
            background: linear-gradient(135deg, #d1fae5, #a7f3d0); 
            color: #047857; 
        }
        .contact-item:hover .contact-icon.whatsapp {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }
        
        .contact-icon.location { background: linear-gradient(135deg, #fef3c7, #fde68a); color: #92400e; }
        .contact-icon.clock { background: linear-gradient(135deg, #ede9fe, #ddd6fe); color: #6d28d9; }
        
        .contact-text strong {
            display: block;
            font-size: 10px;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
            font-weight: 600;
        }
        
        .contact-text span {
            font-weight: 600;
            color: #1e293b;
            font-size: 13px;
        }
        
        .wa-qr-btn {
            background: #25D366;
            color: white;
            border: none;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 10px;
            margin-left: 5px;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .wa-qr-btn:hover {
            background: #128C7E;
            transform: scale(1.05);
        }
        
        .main-wrapper {
            display: flex;
            height: calc(100vh - 130px);
            position: relative;
        }
        
        #map { flex: 1; height: 100%; z-index: 1; }
        
        .sidebar {
            width: 450px;
            background: white;
            box-shadow: -2px 0 15px rgba(0,0,0,0.08);
            overflow-y: auto;
            z-index: 100;
            transition: transform 0.3s ease;
        }
        
        .sidebar::-webkit-scrollbar { width: 6px; }
        .sidebar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        
        .sidebar-header {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
            padding: 18px 20px;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        
        .sidebar-header h5 {
            margin: 0; font-size: 15px; font-weight: 600;
            display: flex; align-items: center; gap: 8px;
        }
        
        .sidebar-header small { opacity: 0.85; font-size: 11px; display: block; margin-top: 3px; }
        .sidebar-content { padding: 15px; }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-bottom: 15px;
        }
        
        .stats-grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
            margin-bottom: 15px;
        }
        
        .stat-card {
            padding: 12px; border-radius: 12px;
            text-align: center; color: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            transition: all 0.2s;
            position: relative; overflow: hidden;
            cursor: pointer;
        }
        
        .stat-card::before {
            content: '';
            position: absolute; top: -50%; right: -50%;
            width: 100%; height: 100%;
            background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
        }
        
        .stat-card:hover { 
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        }
        
        .stat-total { background: linear-gradient(135deg, #6366f1, #4f46e5); }
        .stat-menunggu { background: linear-gradient(135deg, #f59e0b, #d97706); }
        .stat-proses { background: linear-gradient(135deg, #0ea5e9, #0284c7); }
        .stat-selesai { background: linear-gradient(135deg, #10b981, #059669); }
        .stat-jalur { background: linear-gradient(135deg, #06b6d4, #0891b2); }
        .stat-bangunan { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
        .stat-kantor { background: linear-gradient(135deg, #10b981, #059669); }
        .stat-ppob { background: linear-gradient(135deg, #f59e0b, #d97706); }
        .stat-belum { background: linear-gradient(135deg, #ef4444, #dc2626); }
        
        .stat-icon { font-size: 18px; opacity: 0.3; position: absolute; top: 8px; right: 8px; }
        .stat-value { font-size: 22px; font-weight: 700; margin: 0; position: relative; }
        .stat-label {
            font-size: 9px; opacity: 0.9;
            text-transform: uppercase; letter-spacing: 0.5px;
            margin-top: 3px; position: relative;
        }
        
        .revenue-card {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 15px;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        .revenue-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 70%);
        }
        
        .revenue-title {
            font-size: 11px;
            opacity: 0.9;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
            position: relative;
        }
        
        .revenue-amount {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 5px;
            position: relative;
        }
        
        .revenue-kubikasi {
            font-size: 12px;
            opacity: 0.9;
            position: relative;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .section-title {
            font-size: 12px; font-weight: 600; color: #64748b;
            text-transform: uppercase; letter-spacing: 1px;
            margin: 15px 0 10px 0;
            padding-bottom: 6px;
            border-bottom: 2px solid #e2e8f0;
            display: flex; align-items: center; gap: 8px;
        }
        
        .list-item {
            padding: 12px; border: 1px solid #e2e8f0;
            border-radius: 10px; margin-bottom: 8px;
            cursor: pointer; transition: all 0.2s;
            background: white;
        }
        
        .list-item:hover {
            background: #f0f9ff; border-color: #0ea5e9;
            transform: translateX(3px);
            box-shadow: 0 2px 8px rgba(14, 165, 233, 0.1);
        }
        
        .list-item-header {
            display: flex; justify-content: space-between;
            align-items: center; margin-bottom: 5px;
        }
        
        .list-item-title {
            font-weight: 600; font-size: 13px; color: #1e293b;
            display: flex; align-items: center; gap: 8px;
        }
        
        .color-indicator { width: 20px; height: 4px; border-radius: 2px; }
        
        .control-buttons {
            position: fixed;
            right: 20px; top: 150px;
            z-index: 1001;
            display: flex; flex-direction: column; gap: 10px;
        }
        
        .control-btn {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white; border: none;
            padding: 10px 16px; border-radius: 10px;
            box-shadow: 0 4px 15px rgba(30, 60, 114, 0.3);
            cursor: pointer; font-weight: 600; font-size: 13px;
            display: flex; align-items: center; gap: 8px;
            transition: all 0.3s;
        }
        
        .control-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 60, 114, 0.4);
        }
        
        .control-btn.expand { background: linear-gradient(135deg, #10b981, #059669); }
        .control-btn.expand.active { background: linear-gradient(135deg, #ef4444, #dc2626); }
        
        /* VOICE CONTROL BUTTON */
        .control-btn.voice { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
        .control-btn.voice.active { 
            background: linear-gradient(135deg, #10b981, #059669); 
        }
        .control-btn.voice.muted { 
            background: linear-gradient(135deg, #6b7280, #4b5563); 
        }
        
        /* VOICE PANEL */
        .voice-panel {
            position: fixed;
            right: 20px;
            top: 320px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            padding: 20px;
            z-index: 1002;
            width: 280px;
            display: none;
            animation: slideInRight 0.3s ease;
        }
        
        .voice-panel.active {
            display: block;
        }
        
        @keyframes slideInRight {
            from { transform: translateX(50px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        .voice-panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e2e8f0;
        }
        
        .voice-panel-title {
            font-size: 14px;
            font-weight: 700;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .voice-panel-close {
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            font-size: 16px;
            padding: 4px;
        }
        
        .voice-panel-close:hover {
            color: #ef4444;
        }
        
        .voice-option {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s;
            margin-bottom: 8px;
            border: 2px solid #e2e8f0;
        }
        
        .voice-option:hover {
            background: #f0f9ff;
            border-color: #0ea5e9;
        }
        
        .voice-option.selected {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            border-color: #3b82f6;
        }
        
        .voice-option-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }
        
        .voice-option.selected .voice-option-icon {
            background: rgba(255,255,255,0.3);
        }
        
        .voice-option-info {
            flex: 1;
        }
        
        .voice-option-name {
            font-weight: 600;
            font-size: 13px;
            margin-bottom: 2px;
        }
        
        .voice-option-desc {
            font-size: 10px;
            opacity: 0.8;
        }
        
        .voice-control-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #e2e8f0;
        }
        
        .voice-control-label {
            font-size: 11px;
            color: #64748b;
            font-weight: 600;
            min-width: 60px;
        }
        
        .voice-control-row input[type="range"] {
            flex: 1;
            accent-color: #3b82f6;
        }
        
        .voice-test-btn {
            width: 100%;
            margin-top: 12px;
            padding: 10px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s;
        }
        
        .voice-test-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }
        
        /* LAYER CONTROL CUSTOM */
        .custom-layer-control {
            position: absolute;
            top: 20px;
            left: 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            z-index: 500;
            padding: 10px;
            max-width: 200px;
        }
        
        .layer-control-title {
            font-size: 11px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
            padding-bottom: 6px;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .layer-btn-group {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 6px;
        }
        
        .layer-btn {
            padding: 8px 6px;
            border: 2px solid #e2e8f0;
            background: white;
            border-radius: 8px;
            cursor: pointer;
            font-size: 10px;
            font-weight: 600;
            color: #64748b;
            transition: all 0.2s;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
        }
        
        .layer-btn:hover {
            border-color: #3b82f6;
            color: #3b82f6;
            transform: translateY(-2px);
        }
        
        .layer-btn.active {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            border-color: #3b82f6;
        }
        
        .layer-btn i {
            font-size: 16px;
        }
        
        /* NOTIFICATION TOAST */
        .toast-notification {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            padding: 12px 20px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            z-index: 9999;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            font-weight: 600;
            animation: toastSlide 0.3s ease;
            max-width: 400px;
        }
        
        .toast-notification.success {
            border-left: 4px solid #10b981;
            color: #065f46;
        }
        
        .toast-notification.info {
            border-left: 4px solid #3b82f6;
            color: #1e40af;
        }
        
        .toast-notification.warning {
            border-left: 4px solid #f59e0b;
            color: #92400e;
        }
        
        @keyframes toastSlide {
            from { transform: translate(-50%, -50px); opacity: 0; }
            to { transform: translate(-50%, 0); opacity: 1; }
        }
        
        .legend {
            position: absolute;
            bottom: 20px; left: 20px;
            background: white; padding: 15px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            z-index: 500; max-width: 240px; font-size: 12px;
        }
        
        .legend-title {
            font-weight: 700; margin-bottom: 10px;
            color: #1e293b; font-size: 13px;
            display: flex; align-items: center; gap: 6px;
        }
        
        .legend-group { margin-bottom: 10px; }
        
        .legend-group-title {
            font-size: 10px; color: #64748b;
            text-transform: uppercase; font-weight: 600;
            margin-bottom: 4px; padding-bottom: 2px;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .legend-item { display: flex; align-items: center; gap: 8px; margin: 4px 0; }
        .legend-color { width: 20px; height: 4px; border-radius: 2px; }
        
        .legend-marker {
            width: 16px; height: 16px; border-radius: 50%;
            border: 2px solid white;
            box-shadow: 0 0 0 1px rgba(0,0,0,0.2);
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 8px;
        }
        
        .legend-pelanggan {
            position: absolute;
            bottom: 20px;
            right: 20px;
            background: white;
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            z-index: 500;
            max-width: 250px;
            font-size: 12px;
        }
        
        .legend-pelanggan-title {
            font-weight: 700;
            margin-bottom: 10px;
            color: #1e293b;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .legend-pelanggan-item {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 5px 0;
            font-size: 11px;
        }
        
        .legend-pelanggan-marker {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 2px solid white;
            box-shadow: 0 0 0 1px rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 8px;
        }
        
        .custom-div-icon { background: transparent !important; border: none !important; }
        
        .marker-wrapper {
            position: relative;
            display: flex; flex-direction: column; align-items: center;
        }
        
        .marker-banner {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white; padding: 5px 12px; border-radius: 15px;
            font-size: 10px; font-weight: 700; white-space: nowrap;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.5);
            margin-bottom: 4px; border: 2px solid white;
            letter-spacing: 0.3px;
            animation: shake 2s infinite;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-2px); }
            20%, 40%, 60%, 80% { transform: translateX(2px); }
        }
        
        @keyframes pulse-red {
            0% { transform: translate(-50%, -50%) scale(1); opacity: 0.8; }
            50% { transform: translate(-50%, -50%) scale(1.5); opacity: 0.4; }
            100% { transform: translate(-50%, -50%) scale(1); opacity: 0.8; }
        }
        
        .marker-pin {
            display: flex; justify-content: center; align-items: center;
            color: white;
            box-shadow: 0 3px 10px rgba(0,0,0,0.3);
            border: 3px solid white;
            transition: transform 0.2s;
            position: relative; z-index: 2;
        }
        
        .marker-pin:hover { transform: scale(1.15); z-index: 10; }
        
        .shape-circle { border-radius: 50%; }
        .shape-square { border-radius: 6px; }
        .shape-pin { border-radius: 50% 50% 50% 0 !important; transform: rotate(-45deg); }
        .shape-pin i { transform: rotate(45deg); }
        
        .marker-label {
            position: absolute; top: 100%; left: 50%;
            transform: translateX(-50%);
            background: rgba(30, 41, 59, 0.9);
            color: white; padding: 2px 6px; border-radius: 8px;
            font-size: 9px; white-space: nowrap;
            font-weight: 600; margin-top: 4px;
        }
        
        .pulse-ring {
            position: absolute; top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            width: 100%; height: 100%; border-radius: 50%;
            animation: pulse-animation 2s infinite;
            z-index: 1;
        }
        
        @keyframes pulse-animation {
            0% { transform: translate(-50%, -50%) scale(1); opacity: 0.7; box-shadow: 0 0 0 0 currentColor; }
            70% { transform: translate(-50%, -50%) scale(2.2); opacity: 0; box-shadow: 0 0 0 15px currentColor; }
            100% { transform: translate(-50%, -50%) scale(1); opacity: 0; }
        }
        
        .empty-state {
            text-align: center; padding: 20px;
            color: #94a3b8; font-size: 12px; font-style: italic;
        }
        
        .main-wrapper.is-fullscreen {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            z-index: 99999 !important;
            background: white;
        }
        
        .main-wrapper.is-fullscreen #map {
            height: 100vh !important;
        }
        
        .main-wrapper.is-fullscreen .top-info-bar,
        .main-wrapper.is-fullscreen .contact-bar {
            display: none !important;
        }
        
        .main-wrapper.is-fullscreen .sidebar {
            height: 100vh;
        }
        
        .wa-modal-content {
            border-radius: 20px;
            overflow: hidden;
        }
        
        .wa-modal-header {
            background: linear-gradient(135deg, #25D366, #128C7E);
            color: white;
            padding: 20px;
            text-align: center;
        }
        
        .wa-modal-header h4 { margin: 0; font-weight: 700; }
        .wa-modal-header small { opacity: 0.9; }
        
        .wa-qr-container {
            padding: 30px;
            text-align: center;
            background: white;
        }
        
        #wa-qrcode {
            display: inline-block;
            padding: 15px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(37, 211, 102, 0.2);
            margin-bottom: 20px;
        }
        
        .wa-info {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 12px;
            padding: 15px;
            margin-top: 15px;
        }
        
        .wa-info-item {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 8px 0;
            font-size: 13px;
            color: #065f46;
        }
        
        .wa-info-item i { color: #10b981; width: 20px; }
        
        .wa-btn-direct {
            background: linear-gradient(135deg, #25D366, #128C7E);
            color: white;
            border: none;
            padding: 14px 24px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-top: 15px;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3);
            text-decoration: none;
        }
        
        .wa-btn-direct:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 211, 102, 0.4);
            color: white;
        }
        
        .gangguan-card {
            margin-bottom: 12px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.2s;
            background: white;
        }

        .gangguan-card:hover {
            border-color: #0ea5e9;
            transform: translateX(3px);
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.15);
        }

        .gangguan-card.active {
            border-color: #3b82f6;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.25);
        }

        .gangguan-card-header {
            padding: 10px 14px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .gangguan-card-header.status-menunggu {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
        }

        .gangguan-card-header.status-dalam_proses {
            background: linear-gradient(135deg, #60a5fa, #3b82f6);
        }

        .gangguan-card-header.status-selesai {
            background: linear-gradient(135deg, #34d399, #10b981);
        }

        .gangguan-card-code {
            font-weight: 700;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .gangguan-card-status {
            background: rgba(255,255,255,0.25);
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            backdrop-filter: blur(5px);
        }

        .gangguan-card-body { padding: 12px 14px; }
        .gangguan-info-block { margin-bottom: 10px; }

        .gangguan-info-label {
            font-size: 9px;
            color: #64748b;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 3px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .gangguan-info-value {
            font-weight: 600;
            color: #1e293b;
            font-size: 13px;
        }

        .gangguan-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-bottom: 10px;
        }

        .gangguan-grid-item {
            background: #f8fafc;
            padding: 8px;
            border-radius: 6px;
        }

        .gangguan-grid-item .label {
            font-size: 9px;
            color: #64748b;
            font-weight: 600;
            margin-bottom: 2px;
        }

        .gangguan-grid-item .value {
            font-weight: 600;
            color: #1e293b;
            font-size: 11px;
        }

        .estimasi-box {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            padding: 12px;
            border-radius: 10px;
            border-left: 4px solid #f59e0b;
            margin-top: 10px;
        }

        .estimasi-box-title {
            font-size: 10px;
            color: #92400e;
            font-weight: 700;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .estimasi-item { margin-bottom: 8px; }
        .estimasi-item:last-child { margin-bottom: 0; }

        .estimasi-label {
            font-size: 9px;
            color: #78350f;
            font-weight: 600;
            margin-bottom: 2px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .estimasi-value {
            font-weight: 700;
            color: #92400e;
            font-size: 12px;
        }

        .estimasi-value.big {
            font-size: 20px;
            color: #dc2626;
            display: flex;
            align-items: baseline;
            gap: 4px;
        }

        .estimasi-value.big .unit {
            font-size: 10px;
            color: #92400e;
            font-weight: 600;
        }

        .estimasi-sub {
            font-size: 9px;
            color: #78350f;
            margin-top: 2px;
        }

        .estimasi-sub strong { color: #dc2626; }
        
        @keyframes slideIn {
            from { transform: translateX(400px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(400px); opacity: 0; }
        }
        
        @media (max-width: 768px) {
            .top-info-container { flex-direction: column; text-align: center; }
            .contact-container { flex-direction: column; }
            .notification-bar { max-width: 100%; }
            .sidebar { 
                position: fixed; right: 0; top: 0;
                height: 100vh; transform: translateX(100%);
                width: 100%;
                max-width: 400px;
            }
            .sidebar.active { transform: translateX(0); }
            .main-wrapper { height: calc(100vh - 200px); }
            .legend { max-width: 180px; font-size: 11px; }
            .legend-pelanggan { max-width: 180px; font-size: 11px; right: 10px; bottom: 10px; }
            .control-buttons {
                top: auto; bottom: 20px; right: 10px;
                flex-direction: row;
            }
            .voice-panel {
                right: 10px;
                top: auto;
                bottom: 80px;
                width: calc(100% - 20px);
                max-width: 320px;
            }
            .custom-layer-control {
                top: 10px;
                left: 10px;
                max-width: 180px;
            }
        }
    </style>
</head>
<body>
    <div class="top-info-bar">
        <div class="top-info-container">
            <div class="brand-section">
                <div class="brand-logo">
                    <i class="fas fa-tint"></i>
                </div>
                <div class="brand-text">
                    <h1>PDAM TIRTA MEDAL</h1>
                    <small>Sistem Monitoring Jaringan - Unit Darmaraja</small>
                </div>
            </div>
            
            @php
                $gangguanAktif = isset($gangguanAktif) ? $gangguanAktif : collect($gangguan ?? [])->where('status', '!=', 'selesai');
                $totalAktif = $gangguanAktif->count();
            @endphp
            
            @if($totalAktif > 0)
            <div class="alert-section">
                <div class="alert-icon">
                    <i class="fas fa-info-circle"></i>
                </div>
                <div class="alert-text">
                    <strong>Informasi Pelayanan</strong>
                    <small>Terdapat {{ $totalAktif }} gangguan aktif yang sedang ditangani</small>
                </div>
                <div class="alert-count">{{ $totalAktif }}</div>
            </div>
            @else
            <div class="alert-section" style="background: rgba(16, 185, 129, 0.15); border-color: rgba(16, 185, 129, 0.3);">
                <div class="alert-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="alert-text">
                    <strong>Pelayanan Normal</strong>
                    <small>Semua jaringan beroperasi dengan baik</small>
                </div>
            </div>
            @endif
            
            <div class="notification-bar" id="notificationBar" style="display: none;">
                <div class="notification-title">
                    <i class="fas fa-money-bill-wave"></i> Pembayaran Terbaru
                </div>
                <div class="notification-scroll">
                    <div class="notification-scroll-content" id="notificationContent">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="contact-bar">
        <div class="contact-container">
            <a href="tel:+622621500000" class="contact-item">
                <div class="contact-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <div class="contact-text">
                    <strong>Call Center</strong>
                    <span>(0262) 1500-XXX</span>
                </div>
            </a>
            
            <div class="contact-item" style="cursor: default;">
                <a href="https://wa.me/6281234567890?text=Halo%20PDAM%20Tirta%20Medal%2C%20saya%20ingin%20melaporkan%20gangguan" 
                   target="_blank" 
                   class="contact-item" 
                   style="padding: 0; margin: 0;">
                    <div class="contact-icon whatsapp">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                    <div class="contact-text">
                        <strong>WhatsApp</strong>
                        <span>0812-3456-7890</span>
                    </div>
                </a>
                <button class="wa-qr-btn" onclick="showWAQR()" title="Lihat QR Code">
                    <i class="fas fa-qrcode"></i> QR
                </button>
            </div>
            
            <a href="https://maps.google.com/?q=PDAM+Tirta+Medal+Darmaraja+Sumedang" 
               target="_blank" 
               class="contact-item">
                <div class="contact-icon location">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="contact-text">
                    <strong>Unit Darmaraja</strong>
                    <span>Jl. Raya Darmaraja, Sumedang</span>
                </div>
            </a>
            
            <div class="contact-item" style="cursor: default;">
                <div class="contact-icon clock">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="contact-text">
                    <strong>Jam Layanan</strong>
                    <span>Senin - Sabtu, 08.00 - 16.00</span>
                </div>
            </div>
        </div>
    </div>

    <div class="main-wrapper" id="mainWrapper">
        <div id="map"></div>
        
        <!-- CUSTOM LAYER CONTROL -->
        <div class="custom-layer-control" id="layerControl">
            <div class="layer-control-title">
                <i class="fas fa-layer-group"></i> Mode Peta
            </div>
            <div class="layer-btn-group">
                <button class="layer-btn active" data-layer="street" onclick="switchLayer('street')">
                    <i class="fas fa-map"></i>
                    <span>Jalan</span>
                </button>
                <button class="layer-btn" data-layer="satellite" onclick="switchLayer('satellite')">
                    <i class="fas fa-satellite"></i>
                    <span>Satelit</span>
                </button>
                <button class="layer-btn" data-layer="terrain" onclick="switchLayer('terrain')">
                    <i class="fas fa-mountain"></i>
                    <span>Medan</span>
                </button>
                <button class="layer-btn" data-layer="dark" onclick="switchLayer('dark')">
                    <i class="fas fa-moon"></i>
                    <span>Gelap</span>
                </button>
            </div>
        </div>
        
        <div class="control-buttons">
            <button class="control-btn" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i> Info Jaringan
            </button>
            <button class="control-btn expand" id="expandBtn" onclick="toggleFullscreen()">
                <i class="fas fa-expand" id="expandIcon"></i> 
                <span id="expandText">Fullscreen</span>
            </button>
            <button class="control-btn voice active" id="voiceBtn" onclick="toggleVoicePanel()">
                <i class="fas fa-volume-up" id="voiceIcon"></i> 
                <span id="voiceText">Suara</span>
            </button>
        </div>
        
        <!-- VOICE CONTROL PANEL -->
        <div class="voice-panel" id="voicePanel">
            <div class="voice-panel-header">
                <div class="voice-panel-title">
                    <i class="fas fa-microphone-alt"></i>
                    Pengaturan Suara
                </div>
                <button class="voice-panel-close" onclick="toggleVoicePanel()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="voice-option selected" id="voice-female" onclick="selectVoice('female')">
                <div class="voice-option-icon">
                    <i class="fas fa-venus"></i>
                </div>
                <div class="voice-option-info">
                    <div class="voice-option-name">Suara Perempuan</div>
                    <div class="voice-option-desc">Lebih lembut dan jelas</div>
                </div>
            </div>
            
            <div class="voice-option" id="voice-male" onclick="selectVoice('male')">
                <div class="voice-option-icon">
                    <i class="fas fa-mars"></i>
                </div>
                <div class="voice-option-info">
                    <div class="voice-option-name">Suara Laki-laki</div>
                    <div class="voice-option-desc">Lebih berat dan tegas</div>
                </div>
            </div>
            
            <div class="voice-control-row">
                <div class="voice-control-label">Volume</div>
                <input type="range" min="0" max="100" value="80" id="volumeSlider"
                       oninput="setVoiceVolume(this.value)">
                <span id="volumeValue" style="font-size: 11px; font-weight: 600; min-width: 30px;">80%</span>
            </div>
            
            <div class="voice-control-row">
                <div class="voice-control-label">Kecepatan</div>
                <input type="range" min="50" max="150" value="90" id="rateSlider"
                       oninput="setVoiceRate(this.value)">
                <span id="rateValue" style="font-size: 11px; font-weight: 600; min-width: 30px;">0.9x</span>
            </div>
            
            <button class="voice-test-btn" onclick="testVoice()">
                <i class="fas fa-play"></i> Test Suara
            </button>
            
            <div style="margin-top: 12px; padding: 10px; background: #f0f9ff; border-radius: 8px; font-size: 10px; color: #1e40af;">
                <i class="fas fa-info-circle"></i> Suara akan otomatis berbunyi saat ada pembayaran baru atau gangguan aktif
            </div>
        </div>
        
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h5><i class="fas fa-network-wired"></i> Informasi Jaringan</h5>
                <small>Kecamatan Darmaraja, Kab. Sumedang</small>
            </div>
            <div class="sidebar-content">
                <div class="stats-grid">
                    <div class="stat-card stat-total">
                        <i class="fas fa-list stat-icon"></i>
                        <div class="stat-value">{{ $stats['total'] ?? 0 }}</div>
                        <div class="stat-label">Total Gangguan</div>
                    </div>
                    <div class="stat-card stat-menunggu">
                        <i class="fas fa-clock stat-icon"></i>
                        <div class="stat-value">{{ $stats['menunggu'] ?? 0 }}</div>
                        <div class="stat-label">Menunggu</div>
                    </div>
                    <div class="stat-card stat-proses">
                        <i class="fas fa-spinner stat-icon"></i>
                        <div class="stat-value">{{ $stats['dalam_proses'] ?? 0 }}</div>
                        <div class="stat-label">Dalam Proses</div>
                    </div>
                    <div class="stat-card stat-selesai">
                        <i class="fas fa-check stat-icon"></i>
                        <div class="stat-value">{{ $stats['selesai'] ?? 0 }}</div>
                        <div class="stat-label">Selesai</div>
                    </div>
                </div>
                
                <div class="stats-grid">
                    <div class="stat-card stat-jalur">
                        <i class="fas fa-route stat-icon"></i>
                        <div class="stat-value">{{ ($jalurPipa ?? collect())->count() }}</div>
                        <div class="stat-label">Jalur Pipa</div>
                    </div>
                    <div class="stat-card stat-bangunan">
                        <i class="fas fa-building stat-icon"></i>
                        <div class="stat-value">{{ ($bangunan ?? collect())->count() }}</div>
                        <div class="stat-label">Bangunan</div>
                    </div>
                </div>

                <div class="section-title">
                    <i class="fas fa-exclamation-triangle text-danger"></i> 
                    Gangguan Aktif
                    <span class="badge bg-danger ms-auto">{{ $gangguanAktif->count() }}</span>
                </div>
                
                @forelse($gangguanAktif as $gang)
                @if(is_object($gang))
                <div class="gangguan-card" data-id="{{ $gang->id }}" data-type="gangguan" onclick="focusOnGangguan({{ $gang->id }})">
                    <div class="gangguan-card-header status-{{ $gang->status }}">
                        <div class="gangguan-card-code">
                            <i class="fas fa-exclamation-circle"></i> 
                            {{ $gang->kode_laporan }}
                        </div>
                        <span class="gangguan-card-status">
                            {{ ucfirst(str_replace('_', ' ', $gang->status)) }}
                        </span>
                    </div>
                    
                    <div class="gangguan-card-body">
                        <div class="gangguan-info-block">
                            <div class="gangguan-info-label">
                                <i class="fas fa-map-marker-alt"></i> Lokasi
                            </div>
                            <div class="gangguan-info-value">{{ $gang->lokasi }}</div>
                        </div>
                        
                        <div class="gangguan-grid-2">
                            <div class="gangguan-grid-item">
                                <div class="label"><i class="fas fa-tools"></i> Kondisi</div>
                                <div class="value">{{ ucfirst(str_replace('_', ' ', $gang->tipe_kerusakan)) }}</div>
                            </div>
                            <div class="gangguan-grid-item">
                                <div class="label"><i class="fas fa-users"></i> Dampak</div>
                                <div class="value">{{ Str::limit($gang->wilayah_terdampak, 15) }}</div>
                            </div>
                        </div>
                        
                        <div class="estimasi-box">
                            <div class="estimasi-box-title">
                                <i class="fas fa-calculator"></i> Estimasi Real-Time
                            </div>
                            
                            <div class="estimasi-item">
                                <div class="estimasi-label">
                                    <i class="fas fa-ruler-horizontal"></i> Ukuran Pipa
                                </div>
                                <div class="estimasi-value">{{ $gang->ukuran_pipa }}</div>
                            </div>
                            
                            <div class="estimasi-item">
                                <div class="estimasi-label">
                                    <i class="fas fa-tint-slash"></i> Potensi Kehilangan Air
                                </div>
                                <div class="estimasi-value big">
                                    {{ number_format($gang->debit_bocor ?? 0, 0) }}
                                    <span class="unit">m³/jam</span>
                                </div>
                                <div class="estimasi-sub">
                                    Total: <strong>{{ number_format($gang->total_kehilangan_air ?? 0, 1) }} m³</strong> 
                                    (durasi {{ $gang->durasi_jam ?? 0 }} jam)
                                </div>
                            </div>
                            
                            @if($gang->estimasi_selesai)
                            <div class="estimasi-item">
                                <div class="estimasi-label">
                                    <i class="fas fa-calendar-check"></i> Estimasi Selesai
                                </div>
                                <div class="estimasi-value" style="color: #059669;">
                                    {{ \Carbon\Carbon::parse($gang->estimasi_selesai)->format('d/m/Y') }}
                                </div>
                            </div>
                            @endif
                        </div>
                        
                        @if($gang->deskripsi)
                        <div style="margin-top: 10px; padding: 8px; background: #f1f5f9; border-radius: 6px;">
                            <div style="font-size: 9px; color: #64748b; font-weight: 600; margin-bottom: 2px;">
                                <i class="fas fa-info-circle"></i> DESKRIPSI
                            </div>
                            <div style="font-size: 11px; color: #475569;">
                                {{ Str::limit($gang->deskripsi, 80) }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
                @empty
                <div class="empty-state">
                    <i class="fas fa-check-circle" style="font-size: 32px; color: #10b981; margin-bottom: 8px;"></i>
                    <div>Tidak ada gangguan aktif</div>
                    <small style="color: #94a3b8;">Semua jaringan beroperasi normal</small>
                </div>
                @endforelse

                <div class="section-title">
                    <i class="fas fa-route"></i> Jalur Pipa
                </div>
                @forelse($jalurPipa ?? [] as $jalur)
                <div class="list-item" data-id="{{ $jalur->id }}" data-type="jalur" onclick="focusOnJalur({{ $jalur->id }})">
                    <div class="layer-info">
                        <div class="layer-name">
                            <span class="color-dot" style="background: {{ $jalur->warna }};"></span>
                            {{ $jalur->nama_jalur }}
                        </div>
                        <div class="layer-meta">
                            <i class="fas fa-ruler"></i> {{ $jalur->ukuran_pipa }}
                        </div>
                    </div>
                </div>
                @empty
                <div class="empty-state">Belum ada data jalur pipa</div>
                @endforelse

                <div class="section-title">
                    <i class="fas fa-building"></i> Bangunan
                </div>
                @forelse($bangunan ?? [] as $b)
                <div class="list-item" data-id="{{ $b->id }}" data-type="bangunan" onclick="focusOnBangunan({{ $b->id }})">
                    <div class="layer-info">
                        <div class="layer-name">
                            <span class="color-dot" style="background: {{ $b->warna }};"></span>
                            {{ $b->nama_bangunan }}
                        </div>
                        <div class="layer-meta">
                            <i class="fas fa-tag"></i> {{ ucfirst(str_replace('_', ' ', $b->jenis_bangunan)) }}
                        </div>
                    </div>
                </div>
                @empty
                <div class="empty-state">Belum ada data bangunan</div>
                @endforelse
            </div>
        </div>
        
        <div class="legend">
            <div class="legend-title"><i class="fas fa-info-circle"></i> Legenda Peta</div>
            
            <div class="legend-group">
                <div class="legend-group-title">Jalur Pipa</div>
                <div class="legend-item">
                    <div class="legend-color" style="background: #ef4444;"></div>
                    <span>Transmisi</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background: #3b82f6;"></div>
                    <span>Distribusi</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background: #10b981;"></div>
                    <span>Tersier</span>
                </div>
            </div>
            
            <div class="legend-group">
                <div class="legend-group-title">Bangunan</div>
                <div class="legend-item">
                    <div class="legend-marker" style="background: #06b6d4;"><i class="fas fa-database"></i></div>
                    <span>Reservoir</span>
                </div>
                <div class="legend-item">
                    <div class="legend-marker" style="background: #8b5cf6;"><i class="fas fa-industry"></i></div>
                    <span>IPA</span>
                </div>
                <div class="legend-item">
                    <div class="legend-marker" style="background: #3b82f6;"><i class="fas fa-building"></i></div>
                    <span>Kantor</span>
                </div>
            </div>
            
            <div class="legend-group">
                <div class="legend-group-title">Gangguan</div>
                <div class="legend-item">
                    <div class="legend-marker" style="background: #ef4444;"><i class="fas fa-exclamation"></i></div>
                    <span>Aktif (Merah)</span>
                </div>
                <div class="legend-item">
                    <div class="legend-marker" style="background: #f59e0b;"><i class="fas fa-tools"></i></div>
                    <span>Proses (Kuning)</span>
                </div>
                <div class="legend-item">
                    <div class="legend-marker" style="background: #10b981;"><i class="fas fa-check"></i></div>
                    <span>Selesai (Hijau)</span>
                </div>
            </div>
        </div>
        
        <div class="legend-pelanggan">
            <div class="legend-pelanggan-title">
                <i class="fas fa-users"></i> Status Pembayaran
            </div>
            <div class="legend-pelanggan-item">
                <div class="legend-pelanggan-marker" style="background: #10b981;">
                    <i class="fas fa-building"></i>
                </div>
                <span>Bayar di Kantor</span>
            </div>
            <div class="legend-pelanggan-item">
                <div class="legend-pelanggan-marker" style="background: #f59e0b;">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <span>Bayar di PPOB</span>
            </div>
            <div class="legend-pelanggan-item">
                <div class="legend-pelanggan-marker" style="background: #ef4444;">
                    <i class="fas fa-times"></i>
                </div>
                <span>Belum Bayar</span>
            </div>
            <div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #e2e8f0; font-size: 10px; color: #64748b;">
                <i class="fas fa-info-circle"></i> Klik kartu statistik untuk filter
            </div>
        </div>
    </div>

    <div class="modal fade" id="waQRModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content wa-modal-content">
                <div class="wa-modal-header">
                    <i class="fab fa-whatsapp" style="font-size: 40px;"></i>
                    <h4 class="mt-2">WhatsApp PDAM Tirta Medal</h4>
                    <small>Scan QR Code atau klik tombol di bawah</small>
                </div>
                <div class="wa-qr-container">
                    <div id="wa-qrcode"></div>
                    
                    <div class="wa-info">
                        <div class="wa-info-item">
                            <i class="fas fa-phone"></i>
                            <span><strong>0812-3456-7890</strong></span>
                        </div>
                        <div class="wa-info-item">
                            <i class="fas fa-clock"></i>
                            <span>Senin - Sabtu, 08.00 - 16.00 WIB</span>
                        </div>
                        <div class="wa-info-item">
                            <i class="fas fa-info-circle"></i>
                            <span>Layanan pengaduan & informasi pelanggan</span>
                        </div>
                    </div>
                    
                    <a href="https://wa.me/6281234567890?text=Halo%20PDAM%20Tirta%20Medal%2C%20saya%20ingin%20melaporkan%20gangguan" 
                       target="_blank" 
                       class="wa-btn-direct">
                        <i class="fab fa-whatsapp"></i>
                        Buka WhatsApp Langsung
                    </a>
                    
                    <button type="button" class="btn btn-light mt-2" data-bs-dismiss="modal" style="width: 100%;">
                        <i class="fas fa-times"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    
    <script>
        const jalurPipaData = @json($jalurPipa ?? []);
        const bangunanData = @json($bangunan ?? []);
        const gangguanData = @json($gangguan ?? []);
        const titikPentingData = @json($titikPenting ?? []);
        const pelangganDataFromLaravel = @json($pelanggan ?? []);
        
        let map;
        let jalurLayers = {};
        let markerLayers = {};
        let pelangganLayers = {};
        let pelangganClusterGroup;
        let isFullscreen = false;
        let waQRGenerated = false;
        let totalRevenue = 0;
        let totalKubikasi = 0;
        
        // Layer peta
        let currentLayer = 'street';
        let baseLayers = {};
        let currentBaseLayer = null;
        
        // Voice settings
        let voiceSettings = {
            enabled: true,
            gender: 'female',
            volume: 0.8,
            rate: 0.9,
            pitch: 1.0
        };
        let availableVoices = [];
        let currentVoice = null;
        let voiceLoaded = false;

        // ============================================
        // UTILITY FUNCTIONS
        // ============================================
        
        function parseKoordinator(koordinatorStr) {
            try {
                if (!koordinatorStr) return null;
                const coords = koordinatorStr.split(',').map(c => parseFloat(c.trim()));
                if (coords.length === 2 && !isNaN(coords[0]) && !isNaN(coords[1])) {
                    return [coords[0], coords[1]];
                }
                return null;
            } catch (e) {
                console.error('Error parsing koordinator:', e);
                return null;
            }
        }

        function formatRupiah(angka) {
            if (!angka || angka === 0) return 'Rp 0';
            return 'Rp ' + parseInt(angka).toLocaleString('id-ID');
        }

        function formatDate(dateStr) {
            if (!dateStr || dateStr === '-' || dateStr === '.') return '-';
            const date = new Date(dateStr);
            return date.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
        }

        function getStatusColor(golongan) {
            const colors = {
                'R1': '#3b82f6', 'R2': '#60a5fa', 'R3': '#93c5fd',
                'B1': '#10b981', 'B2': '#34d399', 'B3': '#6ee7b7',
                'I1': '#f59e0b', 'I2': '#fbbf24', 'I3': '#fcd34d',
                'S1': '#8b5cf6', 'S2': '#a78bfa'
            };
            return colors[golongan] || '#6b7280';
        }

        function isInArea(lat, lng) {
            return lat >= -6.98 && lat <= -6.80 && lng >= 107.80 && lng <= 108.15;
        }

        function parseCoordinates(coordString) {
            try {
                if (!coordString) return null;
                let str = String(coordString).trim();
                
                if (str.startsWith('"') && str.endsWith('"')) {
                    str = str.substring(1, str.length - 1);
                }
                
                str = str.replace(/\\/g, '');
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
                console.error('Error parsing coordinates:', e);
                return null;
            }
        }

        function hasPointInArea(coords) {
            if (!coords || !Array.isArray(coords)) return false;
            return coords.some(c => isInArea(c[0], c[1]));
        }
        
        // Toast notification
        function showNotification(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `toast-notification ${type}`;
            
            const iconMap = {
                'success': 'fa-check-circle',
                'info': 'fa-info-circle',
                'warning': 'fa-exclamation-triangle'
            };
            
            toast.innerHTML = `
                <i class="fas ${iconMap[type] || 'fa-info-circle'}"></i>
                <span>${message}</span>
            `;
            
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.style.animation = 'toastSlide 0.3s ease reverse';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // ============================================
        // LAYER CONTROL FUNCTIONS
        // ============================================
        
        function initBaseLayers() {
            baseLayers = {
                street: L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '© OpenStreetMap'
                }),
                satellite: L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                    maxZoom: 19,
                    attribution: '© Esri World Imagery'
                }),
                terrain: L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
                    maxZoom: 17,
                    attribution: '© OpenTopoMap'
                }),
                dark: L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                    maxZoom: 19,
                    attribution: '© CARTO'
                })
            };
        }
        
        function switchLayer(layerName) {
            if (!baseLayers[layerName]) return;
            
            // Remove current layer
            if (currentBaseLayer) {
                map.removeLayer(currentBaseLayer);
            }
            
            // Add new layer
            currentBaseLayer = baseLayers[layerName];
            currentBaseLayer.addTo(map);
            currentLayer = layerName;
            
            // Update UI
            document.querySelectorAll('.layer-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            document.querySelector(`.layer-btn[data-layer="${layerName}"]`).classList.add('active');
            
            const layerNames = {
                'street': 'Peta Jalan',
                'satellite': 'Citra Satelit',
                'terrain': 'Peta Medan',
                'dark': 'Mode Gelap'
            };
            
            showNotification(`Beralih ke ${layerNames[layerName]}`, 'info');
        }

        // ============================================
        // VOICE NOTIFICATION SYSTEM
        // ============================================
        
        function loadVoices() {
            if (!('speechSynthesis' in window)) {
                console.warn('Web Speech API tidak didukung');
                return;
            }
            
            availableVoices = speechSynthesis.getVoices();
            
            if (availableVoices.length === 0) {
                speechSynthesis.onvoiceschanged = function() {
                    availableVoices = speechSynthesis.getVoices();
                    setDefaultVoice();
                    voiceLoaded = true;
                };
            } else {
                setDefaultVoice();
                voiceLoaded = true;
            }
        }

        function setDefaultVoice() {
            // Cari voice Indonesia
            const idVoices = availableVoices.filter(v => v.lang.startsWith('id'));
            
            if (idVoices.length > 0) {
                if (voiceSettings.gender === 'female') {
                    currentVoice = idVoices.find(v => 
                        v.name.toLowerCase().includes('female') || 
                        v.name.toLowerCase().includes('wanita') ||
                        v.name.toLowerCase().includes('perempuan')
                    ) || idVoices[0];
                } else {
                    currentVoice = idVoices.find(v => 
                        v.name.toLowerCase().includes('male') || 
                        v.name.toLowerCase().includes('pria') ||
                        v.name.toLowerCase().includes('laki')
                    ) || idVoices[idVoices.length - 1];
                }
            } else if (availableVoices.length > 0) {
                // Fallback ke voice default
                if (voiceSettings.gender === 'female') {
                    currentVoice = availableVoices.find(v => 
                        v.name.toLowerCase().includes('female') || 
                        v.name.toLowerCase().includes('woman')
                    ) || availableVoices[0];
                } else {
                    currentVoice = availableVoices.find(v => 
                        v.name.toLowerCase().includes('male') || 
                        v.name.toLowerCase().includes('man')
                    ) || availableVoices[availableVoices.length - 1];
                }
            }
        }

        function speak(text, priority = 'normal') {
            if (!voiceSettings.enabled) return;
            if (!('speechSynthesis' in window)) return;
            
            // Cancel previous speech
            speechSynthesis.cancel();
            
            setTimeout(() => {
                const utterance = new SpeechSynthesisUtterance(text);
                
                if (currentVoice) {
                    utterance.voice = currentVoice;
                }
                
                utterance.volume = voiceSettings.volume;
                utterance.rate = voiceSettings.rate;
                utterance.pitch = voiceSettings.pitch;
                utterance.lang = 'id-ID';
                
                speechSynthesis.speak(utterance);
            }, 100);
        }

        function announcePayment(payment) {
            if (!voiceSettings.enabled) return;
            const text = `Pembayaran diterima dari ${payment.nama}, sebesar ${formatRupiah(payment.jumlah)}, melalui ${payment.lokasi}`;
            speak(text);
        }

        function announceGangguan(gangguan) {
            if (!voiceSettings.enabled) return;
            const statusText = gangguan.status === 'menunggu' ? 'menunggu penanganan' : 
                               gangguan.status === 'dalam_proses' ? 'sedang ditangani' : 'telah selesai';
            
            const text = `Perhatian! Gangguan ${gangguan.tipe_kerusakan.replace('_', ' ')} di ${gangguan.lokasi}, status ${statusText}`;
            speak(text, 'high');
        }

        function toggleVoicePanel() {
            const panel = document.getElementById('voicePanel');
            const btn = document.getElementById('voiceBtn');
            const icon = document.getElementById('voiceIcon');
            
            panel.classList.toggle('active');
            
            if (panel.classList.contains('active')) {
                btn.classList.add('active');
                btn.classList.remove('muted');
                icon.className = 'fas fa-volume-up';
            }
        }

        function selectVoice(gender) {
            voiceSettings.gender = gender;
            
            document.querySelectorAll('.voice-option').forEach(opt => {
                opt.classList.remove('selected');
            });
            document.getElementById(`voice-${gender}`).classList.add('selected');
            
            setDefaultVoice();
            testVoice();
        }

        function setVoiceVolume(value) {
            voiceSettings.volume = value / 100;
            document.getElementById('volumeValue').textContent = value + '%';
        }
        
        function setVoiceRate(value) {
            voiceSettings.rate = value / 100;
            document.getElementById('rateValue').textContent = (value / 100).toFixed(1) + 'x';
        }

        function testVoice() {
            const text = voiceSettings.gender === 'female' ? 
                'Halo, ini adalah suara perempuan untuk notifikasi PDAM Tirta Medal Sumedang' :
                'Halo, ini adalah suara laki-laki untuk notifikasi PDAM Tirta Medal Sumedang';
            
            speak(text);
        }
        
        // Initialize voices
        if ('speechSynthesis' in window) {
            loadVoices();
        }

        // ============================================
        // NOTIFICATION SYSTEM
        // ============================================
        
        function updateNotificationBar(recentPayments) {
            const notificationBar = document.getElementById('notificationBar');
            const notificationContent = document.getElementById('notificationContent');
            
            if (recentPayments.length === 0) {
                notificationBar.style.display = 'none';
                return;
            }
            
            notificationBar.style.display = 'block';
            
            let html = '';
            recentPayments.forEach((payment, index) => {
                html += `
                    <div class="notification-item">
                        <strong>${payment.nama}</strong> 
                        <span class="amount">${formatRupiah(payment.jumlah)}</span> 
                        <span style="color: #86efac;">(${payment.kubikasi} m³)</span>
                        <span class="location">
                            <i class="fas fa-${payment.lokasi === 'Kantor' ? 'building' : 'mobile-alt'}"></i> 
                            ${payment.lokasi}
                        </span>
                    </div>
                `;
                
                // Announce first payment (latest) dengan delay
                if (index === 0) {
                    setTimeout(() => announcePayment(payment), 2000);
                }
            });
            
            notificationContent.innerHTML = html + html;
        }

        // ============================================
        // PAYMENT STATUS FUNCTIONS
        // ============================================
        
        function getPaymentStatus(pelanggan) {
            const hasLoket = pelanggan.tanggal_pembayaran_loket && 
                             pelanggan.tanggal_pembayaran_loket !== '-' && 
                             pelanggan.tanggal_pembayaran_loket !== '.' &&
                             pelanggan.tanggal_pembayaran_loket !== null;
            
            const hasPPOB = pelanggan.tanggal_pembayaran_ppob && 
                           pelanggan.tanggal_pembayaran_ppob !== '-' && 
                           pelanggan.tanggal_pembayaran_ppob !== '.' &&
                           pelanggan.tanggal_pembayaran_ppob !== null;
            
            if (hasLoket) {
                return {
                    status: 'Kantor',
                    color: '#10b981',
                    icon: 'fa-building',
                    tanggal: pelanggan.tanggal_pembayaran_loket
                };
            } else if (hasPPOB) {
                return {
                    status: 'PPOB',
                    color: '#f59e0b',
                    icon: 'fa-mobile-alt',
                    tanggal: pelanggan.tanggal_pembayaran_ppob
                };
            } else {
                return {
                    status: 'Belum Bayar',
                    color: '#ef4444',
                    icon: 'fa-times',
                    tanggal: null
                };
            }
        }

        // ============================================
        // REVENUE & KUBIKASI CALCULATION
        // ============================================
        
        function calculateRevenue() {
            totalRevenue = 0;
            totalKubikasi = 0;
            let recentPayments = [];
            
            pelangganDataFromLaravel.forEach(pelanggan => {
                const paymentStatus = getPaymentStatus(pelanggan);
                if (paymentStatus.status !== 'Belum Bayar') {
                    totalRevenue += parseFloat(pelanggan.jumlah) || 0;
                    totalKubikasi += parseFloat(pelanggan.pakai) || 0;
                    
                    if (paymentStatus.tanggal) {
                        recentPayments.push({
                            nama: pelanggan.nama || 'Pelanggan',
                            jumlah: parseFloat(pelanggan.jumlah) || 0,
                            kubikasi: parseFloat(pelanggan.pakai) || 0,
                            lokasi: paymentStatus.status,
                            tanggal: paymentStatus.tanggal
                        });
                    }
                }
            });
            
            recentPayments.sort((a, b) => new Date(b.tanggal) - new Date(a.tanggal));
            const top3Payments = recentPayments.slice(0, 3);
            
            updateRevenueDisplay();
            updateNotificationBar(top3Payments);
        }
        
        function updateRevenueDisplay() {
            const revenueElement = document.getElementById('revenue-display');
            if (revenueElement) {
                revenueElement.innerHTML = `
                    <div class="revenue-title">
                        <i class="fas fa-coins"></i> Total Pendapatan Hari Ini
                    </div>
                    <div class="revenue-amount">
                        ${formatRupiah(totalRevenue)}
                    </div>
                    <div class="revenue-kubikasi">
                        <i class="fas fa-tint"></i> 
                        <strong>${totalKubikasi.toFixed(1)} m³</strong> total pemakaian
                    </div>
                `;
            }
        }

        // ============================================
        // PELANGGAN FUNCTIONS
        // ============================================
        
        function loadPelanggan() {
            console.log('📊 Loading pelanggan:', pelangganDataFromLaravel.length, 'data');
            
            if (!pelangganDataFromLaravel || pelangganDataFromLaravel.length === 0) {
                console.warn('⚠️ Tidak ada data pelanggan');
                return;
            }
            
            pelangganClusterGroup = L.markerClusterGroup({
                maxClusterRadius: 50,
                spiderfyOnMaxZoom: true,
                showCoverageOnHover: false,
                zoomToBoundsOnClick: true,
                iconCreateFunction: function(cluster) {
                    const count = cluster.getChildCount();
                    let color = '#3b82f6';
                    let size = '28px';
                    
                    if (count > 50) {
                        color = '#ef4444';
                        size = '36px';
                    } else if (count > 20) {
                        color = '#f59e0b';
                        size = '32px';
                    }
                    
                    return L.divIcon({
                        html: `<div style="background:${color};color:white;width:${size};height:${size};border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:12px;border:3px solid white;box-shadow:0 2px 8px rgba(0,0,0,0.3);">${count}</div>`,
                        className: 'marker-cluster-custom',
                        iconSize: L.point(parseInt(size), parseInt(size))
                    });
                }
            });
            
            const groupedData = {
                byPayment: {},
                byGolongan: {},
                byWilayah: {},
                totalKantor: 0,
                totalPPOB: 0,
                totalBelumBayar: 0,
                countKantor: 0,
                countPPOB: 0,
                countBelumBayar: 0
            };
            
            let markersAdded = 0;
            
            pelangganDataFromLaravel.forEach(pelanggan => {
                const paymentStatus = getPaymentStatus(pelanggan);
                
                if (!groupedData.byPayment[paymentStatus.status]) {
                    groupedData.byPayment[paymentStatus.status] = [];
                }
                groupedData.byPayment[paymentStatus.status].push(pelanggan);
                
                const jumlah = parseFloat(pelanggan.jumlah) || 0;
                const kubikasi = parseFloat(pelanggan.pakai) || 0;
                
                if (paymentStatus.status === 'Kantor') {
                    groupedData.totalKantor += jumlah;
                    groupedData.countKantor++;
                } else if (paymentStatus.status === 'PPOB') {
                    groupedData.totalPPOB += jumlah;
                    groupedData.countPPOB++;
                } else {
                    groupedData.totalBelumBayar += jumlah;
                    groupedData.countBelumBayar++;
                }
                
                const gol = pelanggan.kode_gol_trf || 'Lainnya';
                if (!groupedData.byGolongan[gol]) groupedData.byGolongan[gol] = [];
                groupedData.byGolongan[gol].push(pelanggan);
                
                const wilayah = pelanggan.nama_wilayah || 'Tidak Diketahui';
                if (!groupedData.byWilayah[wilayah]) groupedData.byWilayah[wilayah] = [];
                groupedData.byWilayah[wilayah].push(pelanggan);
                
                const coords = parseKoordinator(pelanggan.koordinator);
                if (!coords || !isInArea(coords[0], coords[1])) return;
                
                const marker = L.marker(coords, {
                    icon: L.divIcon({
                        className: 'custom-div-icon',
                        html: `
                            <div style="
                                background: ${paymentStatus.color};
                                width: 18px;
                                height: 18px;
                                border-radius: 50%;
                                border: 2px solid white;
                                box-shadow: 0 2px 6px rgba(0,0,0,0.3);
                                display: flex;
                                align-items: center;
                                justify-content: center;
                            ">
                                <i class="fas ${paymentStatus.icon}" style="color: white; font-size: 8px;"></i>
                            </div>
                        `,
                        iconSize: [18, 18],
                        iconAnchor: [9, 9]
                    }),
                    zIndexOffset: 100
                });
                
                marker.bindPopup(`
                    <div style="min-width:250px; font-family: 'Inter', sans-serif; font-size: 12px;">
                        <div style="background: ${paymentStatus.color}; color: white; padding: 8px; border-radius: 6px 6px 0 0; font-weight: 700;">
                            <i class="fas ${paymentStatus.icon}"></i> ${pelanggan.nama || 'Tanpa Nama'}
                        </div>
                        <div style="padding: 10px;">
                            <div style="margin-bottom: 6px;"><strong>No:</strong> ${pelanggan.no_pelanggan}</div>
                            <div style="margin-bottom: 6px;"><strong>Golongan:</strong> ${gol}</div>
                            <div style="margin-bottom: 6px;"><strong>Wilayah:</strong> ${wilayah}</div>
                            <div style="margin-bottom: 6px;">
                                <strong>Status:</strong> 
                                <span style="color: ${paymentStatus.color}; font-weight: 700;">
                                    <i class="fas ${paymentStatus.icon}"></i> ${paymentStatus.status}
                                </span>
                            </div>
                            <div style="margin-bottom: 6px;">
                                <strong>Pemakaian:</strong> ${kubikasi} m³
                            </div>
                            ${paymentStatus.tanggal ? `
                            <div style="margin-bottom: 6px;">
                                <strong>Tgl Bayar:</strong> ${formatDate(paymentStatus.tanggal)}
                            </div>
                            ` : ''}
                            <div style="background: #fef3c7; padding: 6px; border-radius: 4px; margin-top: 8px;">
                                <strong>Tagihan:</strong> ${formatRupiah(pelanggan.jumlah)}
                            </div>
                        </div>
                    </div>
                `, { maxWidth: 280 });
                
                pelangganClusterGroup.addLayer(marker);
                pelangganLayers[`pelanggan_${pelanggan.no_pelanggan}`] = {
                    marker: marker,
                    coords: coords,
                    golongan: gol,
                    wilayah: wilayah,
                    paymentStatus: paymentStatus.status
                };
                markersAdded++;
            });
            
            map.addLayer(pelangganClusterGroup);
            
            console.log('✅ Pelanggan loaded:', {
                total: markersAdded,
                byPayment: Object.fromEntries(Object.entries(groupedData.byPayment).map(([k, v]) => [k, v.length])),
                totalKantor: groupedData.totalKantor,
                totalPPOB: groupedData.totalPPOB
            });
            
            updatePelangganStats(groupedData);
        }

        function updatePelangganStats(groupedData) {
            const statsContainer = document.querySelector('.sidebar-content');
            if (!statsContainer) return;
            
            const pelangganStatsHTML = `
                <div id="revenue-display" class="revenue-card">
                    <div class="revenue-title">
                        <i class="fas fa-coins"></i> Total Pendapatan Hari Ini
                    </div>
                    <div class="revenue-amount">
                        ${formatRupiah(totalRevenue)}
                    </div>
                    <div class="revenue-kubikasi">
                        <i class="fas fa-tint"></i> 
                        <strong>${totalKubikasi.toFixed(1)} m³</strong> total pemakaian
                    </div>
                </div>
                
                <div class="section-title" style="margin-top: 20px; cursor: pointer;" onclick="resetPelangganFilter()">
                    <i class="fas fa-money-bill-wave text-success"></i> 
                    Penerimaan Pembayaran <small style="color: #94a3b8; font-size: 10px; margin-left: auto;">(klik untuk reset)</small>
                </div>
                
                <div class="stats-grid-3">
                    <div class="stat-card stat-kantor" onclick="filterByPayment('Kantor')" title="Klik untuk tampilkan di peta">
                        <i class="fas fa-building stat-icon"></i>
                        <div class="stat-value">${groupedData.countKantor}</div>
                        <div class="stat-label">Kantor</div>
                    </div>
                    <div class="stat-card stat-ppob" onclick="filterByPayment('PPOB')" title="Klik untuk tampilkan di peta">
                        <i class="fas fa-mobile-alt stat-icon"></i>
                        <div class="stat-value">${groupedData.countPPOB}</div>
                        <div class="stat-label">PPOB</div>
                    </div>
                    <div class="stat-card stat-belum" onclick="filterByPayment('Belum Bayar')" title="Klik untuk tampilkan di peta">
                        <i class="fas fa-times-circle stat-icon"></i>
                        <div class="stat-value">${groupedData.countBelumBayar}</div>
                        <div class="stat-label">Belum Bayar</div>
                    </div>
                </div>
                
                <div style="background: linear-gradient(135deg, #10b981, #059669); padding: 12px; border-radius: 10px; margin-bottom: 10px; color: white; cursor: pointer; transition: all 0.2s;" onclick="filterByPayment('Kantor')" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="font-size: 10px; opacity: 0.9; margin-bottom: 4px;">
                        <i class="fas fa-building"></i> Total Masuk ke Kantor
                    </div>
                    <div style="font-size: 18px; font-weight: 700;">
                        ${formatRupiah(groupedData.totalKantor)}
                    </div>
                </div>
                
                <div style="background: linear-gradient(135deg, #f59e0b, #d97706); padding: 12px; border-radius: 10px; margin-bottom: 10px; color: white; cursor: pointer; transition: all 0.2s;" onclick="filterByPayment('PPOB')" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="font-size: 10px; opacity: 0.9; margin-bottom: 4px;">
                        <i class="fas fa-mobile-alt"></i> Total Masuk ke PPOB
                    </div>
                    <div style="font-size: 18px; font-weight: 700;">
                        ${formatRupiah(groupedData.totalPPOB)}
                    </div>
                </div>
                
                <div style="background: linear-gradient(135deg, #ef4444, #dc2626); padding: 12px; border-radius: 10px; margin-bottom: 15px; color: white; cursor: pointer; transition: all 0.2s;" onclick="filterByPayment('Belum Bayar')" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="font-size: 10px; opacity: 0.9; margin-bottom: 4px;">
                        <i class="fas fa-exclamation-triangle"></i> Total Belum Dibayar
                    </div>
                    <div style="font-size: 18px; font-weight: 700;">
                        ${formatRupiah(groupedData.totalBelumBayar)}
                    </div>
                </div>
                
                <div class="section-title">
                    <i class="fas fa-chart-pie"></i> 
                    Berdasarkan Golongan
                </div>
                <div id="golongan-list">
                    ${Object.entries(groupedData.byGolongan).map(([gol, data]) => `
                        <div class="list-item" onclick="filterPelangganByGolongan('${gol}')" style="cursor: pointer;">
                            <div class="list-item-header">
                                <div class="list-item-title">
                                    <span class="color-indicator" style="background: ${getStatusColor(gol)};"></span>
                                    Golongan ${gol}
                                </div>
                                <span class="badge" style="background: ${getStatusColor(gol)}20; color: ${getStatusColor(gol)};">${data.length}</span>
                            </div>
                        </div>
                    `).join('')}
                </div>
                
                <div class="section-title">
                    <i class="fas fa-map"></i> 
                    Berdasarkan Wilayah
                </div>
                <div id="wilayah-list">
                    ${Object.entries(groupedData.byWilayah).slice(0, 5).map(([wilayah, data]) => `
                        <div class="list-item" onclick="filterPelangganByWilayah('${wilayah}')" style="cursor: pointer;">
                            <div class="list-item-header">
                                <div class="list-item-title">
                                    <i class="fas fa-map-marker-alt" style="color: #64748b;"></i>
                                    ${wilayah}
                                </div>
                                <span class="badge bg-secondary">${data.length}</span>
                            </div>
                        </div>
                    `).join('')}
                    ${Object.keys(groupedData.byWilayah).length > 5 ? `<div style="text-align: center; padding: 8px; color: #64748b; font-size: 11px;">+${Object.keys(groupedData.byWilayah).length - 5} wilayah lainnya</div>` : ''}
                </div>
            `;
            
            const gangguanSection = statsContainer.querySelector('.section-title');
            if (gangguanSection) {
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = pelangganStatsHTML;
                gangguanSection.parentNode.insertBefore(tempDiv, gangguanSection.nextSibling);
            }
        }

        function filterByPayment(paymentType) {
            if (pelangganClusterGroup) {
                map.removeLayer(pelangganClusterGroup);
            }
            
            pelangganClusterGroup = L.markerClusterGroup({
                maxClusterRadius: 50,
                spiderfyOnMaxZoom: true,
                showCoverageOnHover: false,
                zoomToBoundsOnClick: true
            });
            
            const filtered = pelangganDataFromLaravel.filter(p => {
                const status = getPaymentStatus(p);
                return status.status === paymentType;
            });
            
            const bounds = [];
            
            filtered.forEach(p => {
                const data = pelangganLayers[`pelanggan_${p.no_pelanggan}`];
                if (data && data.coords) {
                    pelangganClusterGroup.addLayer(data.marker);
                    bounds.push(data.coords);
                }
            });
            
            map.addLayer(pelangganClusterGroup);
            
            if (bounds.length > 0) {
                map.fitBounds(L.latLngBounds(bounds), { padding: [50, 50] });
            }
            
            showNotification(`Menampilkan ${filtered.length} pelanggan ${paymentType}`, 'success');
        }

        function resetPelangganFilter() {
            if (pelangganClusterGroup) {
                map.removeLayer(pelangganClusterGroup);
            }
            
            pelangganClusterGroup = L.markerClusterGroup({
                maxClusterRadius: 50,
                spiderfyOnMaxZoom: true,
                showCoverageOnHover: false,
                zoomToBoundsOnClick: true
            });
            
            Object.values(pelangganLayers).forEach(data => {
                pelangganClusterGroup.addLayer(data.marker);
            });
            
            map.addLayer(pelangganClusterGroup);
            showNotification('Menampilkan semua pelanggan', 'info');
        }

        function filterPelangganByGolongan(golongan) {
            if (pelangganClusterGroup) {
                map.removeLayer(pelangganClusterGroup);
            }
            
            pelangganClusterGroup = L.markerClusterGroup({
                maxClusterRadius: 50,
                spiderfyOnMaxZoom: true,
                showCoverageOnHover: false,
                zoomToBoundsOnClick: true
            });
            
            const filtered = pelangganDataFromLaravel.filter(p => p.kode_gol_trf === golongan);
            const bounds = [];
            
            filtered.forEach(p => {
                const data = pelangganLayers[`pelanggan_${p.no_pelanggan}`];
                if (data && data.coords) {
                    pelangganClusterGroup.addLayer(data.marker);
                    bounds.push(data.coords);
                }
            });
            
            map.addLayer(pelangganClusterGroup);
            
            if (bounds.length > 0) {
                map.fitBounds(L.latLngBounds(bounds), { padding: [50, 50] });
            }
            
            showNotification(`Filter: Golongan ${golongan} (${filtered.length} pelanggan)`, 'info');
        }

        function filterPelangganByWilayah(wilayah) {
            if (pelangganClusterGroup) {
                map.removeLayer(pelangganClusterGroup);
            }
            
            pelangganClusterGroup = L.markerClusterGroup({
                maxClusterRadius: 50,
                spiderfyOnMaxZoom: true,
                showCoverageOnHover: false,
                zoomToBoundsOnClick: true
            });
            
            const filtered = pelangganDataFromLaravel.filter(p => p.nama_wilayah === wilayah);
            const bounds = [];
            
            filtered.forEach(p => {
                const data = pelangganLayers[`pelanggan_${p.no_pelanggan}`];
                if (data && data.coords) {
                    pelangganClusterGroup.addLayer(data.marker);
                    bounds.push(data.coords);
                }
            });
            
            map.addLayer(pelangganClusterGroup);
            
            if (bounds.length > 0) {
                map.fitBounds(L.latLngBounds(bounds), { padding: [50, 50] });
            }
            
            showNotification(`Filter: Wilayah ${wilayah} (${filtered.length} pelanggan)`, 'info');
        }

        // ============================================
        // WHATSAPP QR CODE
        // ============================================
        
        function showWAQR() {
            const modal = new bootstrap.Modal(document.getElementById('waQRModal'));
            modal.show();
            
            if (!waQRGenerated) {
                const qrContainer = document.getElementById('wa-qrcode');
                qrContainer.innerHTML = '';
                
                new QRCode(qrContainer, {
                    text: 'https://wa.me/6281234567890?text=Halo%20PDAM%20Tirta%20Medal',
                    width: 220,
                    height: 220,
                    colorDark: '#128C7E',
                    colorLight: '#ffffff',
                    correctLevel: QRCode.CorrectLevel.H
                });
                
                waQRGenerated = true;
            }
        }

        // ============================================
        // FULLSCREEN
        // ============================================
        
        function toggleFullscreen() {
            const mainWrapper = document.getElementById('mainWrapper');
            const expandBtn = document.getElementById('expandBtn');
            
            if (!isFullscreen) {
                if (mainWrapper.requestFullscreen) {
                    mainWrapper.requestFullscreen();
                } else if (mainWrapper.webkitRequestFullscreen) {
                    mainWrapper.webkitRequestFullscreen();
                } else if (mainWrapper.msRequestFullscreen) {
                    mainWrapper.msRequestFullscreen();
                }
                
                mainWrapper.classList.add('is-fullscreen');
                isFullscreen = true;
                
                expandBtn.classList.add('active');
                expandBtn.innerHTML = '<i class="fas fa-compress"></i> <span>Keluar Fullscreen</span>';
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.webkitExitFullscreen) {
                    document.webkitExitFullscreen();
                } else if (document.msExitFullscreen) {
                    document.msExitFullscreen();
                }
                
                mainWrapper.classList.remove('is-fullscreen');
                isFullscreen = false;
                
                expandBtn.classList.remove('active');
                expandBtn.innerHTML = '<i class="fas fa-expand"></i> <span>Fullscreen</span>';
            }
            
            setTimeout(() => {
                if (map) map.invalidateSize();
            }, 300);
        }

        document.addEventListener('fullscreenchange', syncFullscreenState);
        document.addEventListener('webkitfullscreenchange', syncFullscreenState);

        function syncFullscreenState() {
            const mainWrapper = document.getElementById('mainWrapper');
            const expandBtn = document.getElementById('expandBtn');
            
            if (!document.fullscreenElement && !document.webkitFullscreenElement) {
                mainWrapper.classList.remove('is-fullscreen');
                isFullscreen = false;
                expandBtn.classList.remove('active');
                expandBtn.innerHTML = '<i class="fas fa-expand"></i> <span>Fullscreen</span>';
                
                setTimeout(() => {
                    if (map) map.invalidateSize();
                }, 300);
            }
        }

        // ============================================
        // MARKER FUNCTIONS
        // ============================================
        
        function createGangguanMarker(gangguan) {
            const statusConfig = {
                'menunggu': { color: '#ef4444', icon: 'fa-clock', text: 'Menunggu' },
                'dalam_proses': { color: '#f59e0b', icon: 'fa-tools', text: 'Proses' },
                'selesai': { color: '#10b981', icon: 'fa-check', text: 'Selesai' }
            };
            
            const damageIcons = {
                'bocor': 'fa-tint', 'pecah': 'fa-bomb', 'mampet': 'fa-ban',
                'korosi': 'fa-rust', 'rusak_ringan': 'fa-exclamation',
                'rusak_berat': 'fa-exclamation-triangle', 'valve_rusak': 'fa-toggle-on',
                'meter_rusak': 'fa-tachometer-alt', 'lainnya': 'fa-question'
            };
            
            const config = statusConfig[gangguan.status] || statusConfig['menunggu'];
            const damageIcon = damageIcons[gangguan.tipe_kerusakan] || 'fa-question';
            const isActive = gangguan.status !== 'selesai';
            
            const html = `
                <div class="marker-wrapper">
                    ${isActive ? `
                    <div class="marker-banner">
                        <i class="fas fa-exclamation-triangle"></i> 
                        GANGGUAN AKTIF
                    </div>
                    ` : ''}
                    
                    <div style="position: relative; width: 50px; height: 50px;">
                        ${isActive ? `
                        <div class="pulse-ring" style="background: ${config.color}; color: ${config.color}; animation: pulse-red 1.5s infinite;"></div>
                        ` : ''}
                        
                        <div class="marker-pin shape-circle" 
                             style="background: ${config.color}; width: 50px; height: 50px; border: 4px solid white; box-shadow: 0 4px 15px rgba(0,0,0,0.4);">
                            <i class="fas ${damageIcon}" style="font-size: 22px; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));"></i>
                        </div>
                        
                        <div style="position: absolute; top: -2px; right: -2px; 
                                    background: white; color: ${config.color};
                                    width: 22px; height: 22px; border-radius: 50%;
                                    display: flex; align-items: center; justify-content: center;
                                    font-size: 11px; border: 3px solid ${config.color};
                                    box-shadow: 0 2px 8px rgba(0,0,0,0.3); font-weight: 700;">
                            <i class="fas ${config.icon}"></i>
                        </div>
                    </div>
                    
                    <div class="marker-label" style="background: ${config.color}; font-weight: 700; font-size: 10px; padding: 3px 8px;">
                        ${gangguan.kode_laporan}
                    </div>
                </div>
            `;
            
            return L.divIcon({
                className: 'custom-div-icon',
                html: html,
                iconSize: [110, 120],
                iconAnchor: [55, 60],
                popupAnchor: [0, -60]
            });
        }

        function createBangunanMarker(bangunan) {
            const iconMap = {
                'reservoir': { icon: 'fa-database', color: '#06b6d4', shape: 'pin' },
                'ipa': { icon: 'fa-industry', color: '#8b5cf6', shape: 'square' },
                'kantor': { icon: 'fa-building', color: '#3b82f6', shape: 'square' },
                'rumah_pompa': { icon: 'fa-house-flood-water', color: '#10b981', shape: 'square' },
                'sekolah': { icon: 'fa-school', color: '#f59e0b', shape: 'square' },
                'rumah_sakit': { icon: 'fa-hospital', color: '#ef4444', shape: 'square' },
                'masjid': { icon: 'fa-mosque', color: '#10b981', shape: 'square' },
                'pasar': { icon: 'fa-store', color: '#f97316', shape: 'square' },
                'lainnya': { icon: 'fa-building', color: '#6b7280', shape: 'square' }
            };
            
            const config = iconMap[bangunan.jenis_bangunan] || iconMap['lainnya'];
            
            const html = `
                <div class="marker-wrapper">
                    <div class="marker-pin shape-${config.shape}" 
                         style="background: ${config.color}; width: 34px; height: 34px;">
                        <i class="fas ${config.icon}"></i>
                    </div>
                    <div class="marker-label">${bangunan.nama_bangunan}</div>
                </div>
            `;
            
            return L.divIcon({
                className: 'custom-div-icon',
                html: html,
                iconSize: [34, 50],
                iconAnchor: [17, 17],
                popupAnchor: [0, -17]
            });
        }

        // ============================================
        // INITIALIZE MAP
        // ============================================
        
        function initMap() {
            const areaBounds = L.latLngBounds(
                L.latLng(-6.98, 107.80),
                L.latLng(-6.80, 108.15)
            );
            
            map = L.map('map', {
                center: [-6.88, 107.97],
                zoom: 14,
                minZoom: 11,
                maxZoom: 18,
                maxBounds: areaBounds,
                maxBoundsViscosity: 0.8,
                zoomControl: false
            });
            
            // Add zoom control di kanan atas
            L.control.zoom({
                position: 'topright'
            }).addTo(map);
            
            // Initialize base layers
            initBaseLayers();
            
            // Set default layer (street)
            currentBaseLayer = baseLayers.street;
            currentBaseLayer.addTo(map);
            
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
                color: '#3b82f6',
                fillColor: '#3b82f6',
                fillOpacity: 0.1,
                weight: 3,
                dashArray: '10, 5'
            }).addTo(map).bindPopup(`
                <div style="text-align:center; padding:10px;">
                    <h6 style="color:#1e3c72; margin:0;">
                        <i class="fas fa-map-marker-alt"></i> KECAMATAN DARMARAJA
                    </h6>
                    <small>Kab. Sumedang, Jawa Barat</small>
                </div>
            `);
            
            const polygonCenter = L.polygon(darmarajaPolygon).getBounds().getCenter();
            
            const darmarajaLabel = L.marker([polygonCenter.lat, polygonCenter.lng], {
                icon: L.divIcon({
                    className: 'custom-div-icon',
                    html: `
                        <div id="darmaraja-label" style="
                            background: rgba(30, 60, 114, 0.9);
                            color: white;
                            padding: 8px 20px;
                            border-radius: 20px;
                            font-weight: 700;
                            font-size: 14px;
                            letter-spacing: 2px;
                            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
                            border: 3px solid white;
                            white-space: nowrap;
                            transition: opacity 0.3s;
                        ">
                            <i class="fas fa-map-marker-alt"></i> DARMARAJA
                        </div>
                    `,
                    iconSize: [200, 40],
                    iconAnchor: [100, 20]
                }),
                interactive: false
            }).addTo(map);
            
            map.on('zoomend', function() {
                const label = document.getElementById('darmaraja-label');
                if (label) {
                    if (map.getZoom() >= 14) {
                        label.style.opacity = '0';
                        label.style.pointerEvents = 'none';
                    } else {
                        label.style.opacity = '1';
                        label.style.pointerEvents = 'auto';
                    }
                }
            });
            
            loadJalurPipa();
            loadBangunan();
            loadGangguan();
            loadTitikPenting();
            loadPelanggan();
            
            calculateRevenue();
            
            // Announce gangguan aktif pertama setelah 3 detik
            const activeGangguan = gangguanData.filter(g => g.status !== 'selesai');
            if (activeGangguan.length > 0) {
                setTimeout(() => {
                    announceGangguan(activeGangguan[0]);
                }, 3000);
            }
            
            console.log('📊 Data loaded:', {
                jalur: Object.keys(jalurLayers).length,
                bangunan: Object.keys(markerLayers).filter(k => k.startsWith('bangunan_')).length,
                gangguan: Object.keys(markerLayers).filter(k => k.startsWith('gangguan_')).length,
                titik: Object.keys(markerLayers).filter(k => k.startsWith('titik_')).length,
                pelanggan: Object.keys(pelangganLayers).length
            });
        }

        function loadJalurPipa() {
            jalurPipaData.forEach(jalur => {
                try {
                    const coords = parseCoordinates(jalur.coordinates);
                    if (!coords || coords.length === 0) return;
                    if (!hasPointInArea(coords)) return;
                    
                    const polyline = L.polyline(coords, {
                        color: jalur.warna,
                        weight: parseInt(jalur.ketebalan) || 4,
                        opacity: 0.85
                    }).addTo(map);
                    
                    let jarak = 0;
                    for (let i = 0; i < coords.length - 1; i++) {
                        jarak += L.latLng(coords[i]).distanceTo(L.latLng(coords[i+1]));
                    }
                    const jarakKm = (jarak / 1000).toFixed(2);
                    
                    polyline.bindPopup(`
                        <div style="min-width:250px;">
                            <h6 style="background:${jalur.warna};color:white;padding:10px;border-radius:8px 8px 0 0;margin:0;">
                                <i class="fas fa-route"></i> ${jalur.nama_jalur}
                            </h6>
                            <div style="padding:12px; font-size:12px;">
                                <div style="display:flex;justify-content:space-between;padding:6px 0;border-bottom:1px dashed #e2e8f0;">
                                    <span style="color:#64748b;">Jenis:</span>
                                    <strong>${jalur.jenis_jalur.toUpperCase()}</strong>
                                </div>
                                <div style="display:flex;justify-content:space-between;padding:6px 0;border-bottom:1px dashed #e2e8f0;">
                                    <span style="color:#64748b;">Ukuran:</span>
                                    <strong>${jalur.ukuran_pipa}</strong>
                                </div>
                                <div style="display:flex;justify-content:space-between;padding:6px 0;">
                                    <span style="color:#64748b;">Panjang:</span>
                                    <strong style="color:#0369a1;">${jarakKm} km</strong>
                                </div>
                                ${jalur.keterangan ? `
                                <div style="margin-top:8px;padding-top:8px;border-top:1px dashed #e2e8f0;color:#64748b;font-size:11px;">
                                    <i class="fas fa-info-circle"></i> ${jalur.keterangan}
                                </div>` : ''}
                            </div>
                        </div>
                    `, { maxWidth: 300 });
                    
                    jalurLayers[jalur.id] = polyline;
                } catch (e) {
                    console.error('Error loading jalur', jalur.id, e);
                }
            });
        }

        function loadBangunan() {
            bangunanData.forEach(bangunan => {
                try {
                    const coords = parseCoordinates(bangunan.coordinates);
                    if (!coords || coords.length === 0) return;
                    if (!hasPointInArea(coords)) return;
                    
                    const polygon = L.polygon(coords, {
                        color: bangunan.warna,
                        fillColor: bangunan.warna,
                        fillOpacity: 0.25,
                        weight: 2
                    }).addTo(map);
                    
                    const center = polygon.getBounds().getCenter();
                    const marker = L.marker(center, {
                        icon: createBangunanMarker(bangunan)
                    }).addTo(map);
                    
                    const iconMap = {
                        'reservoir': { icon: 'fa-database', color: '#06b6d4' },
                        'ipa': { icon: 'fa-industry', color: '#8b5cf6' },
                        'kantor': { icon: 'fa-building', color: '#3b82f6' },
                        'lainnya': { icon: 'fa-building', color: '#6b7280' }
                    };
                    const config = iconMap[bangunan.jenis_bangunan] || iconMap['lainnya'];
                    
                    marker.bindPopup(`
                        <div style="min-width:220px;">
                            <h6 style="background:${config.color};color:white;padding:10px;border-radius:8px 8px 0 0;margin:0;">
                                <i class="fas ${config.icon}"></i> ${bangunan.nama_bangunan}
                            </h6>
                            <div style="padding:12px; font-size:12px;">
                                <div style="display:flex;justify-content:space-between;padding:6px 0;">
                                    <span style="color:#64748b;">Jenis:</span>
                                    <strong>${bangunan.jenis_bangunan.toUpperCase()}</strong>
                                </div>
                                ${bangunan.keterangan ? `
                                <div style="margin-top:8px;padding-top:8px;border-top:1px dashed #e2e8f0;color:#64748b;font-size:11px;">
                                    <i class="fas fa-info-circle"></i> ${bangunan.keterangan}
                                </div>` : ''}
                            </div>
                        </div>
                    `);
                    
                    markerLayers[`bangunan_${bangunan.id}`] = marker;
                } catch (e) {
                    console.error('Error loading bangunan', bangunan.id, e);
                }
            });
        }

        function loadGangguan() {
            gangguanData.forEach(gangguan => {
                try {
                    const lat = parseFloat(gangguan.latitude);
                    const lng = parseFloat(gangguan.longitude);
                    if (isNaN(lat) || isNaN(lng)) return;
                    
                    const marker = L.marker([lat, lng], {
                        icon: createGangguanMarker(gangguan)
                    }).addTo(map);
                    
                    const statusConfig = {
                        'menunggu': { color: '#ef4444', text: 'Menunggu', bg: '#fee2e2' },
                        'dalam_proses': { color: '#f59e0b', text: 'Dalam Proses', bg: '#fef3c7' },
                        'selesai': { color: '#10b981', text: 'Selesai', bg: '#d1fae5' }
                    };
                    const config = statusConfig[gangguan.status] || statusConfig['menunggu'];
                    
                    marker.bindPopup(`
                        <div style="min-width:300px;">
                            <div style="background:linear-gradient(135deg, ${config.color}, ${config.color}dd);color:white;padding:12px;text-align:center;">
                                <div style="font-size:11px;opacity:0.9;margin-bottom:3px;">
                                    <i class="fas fa-info-circle"></i> INFORMASI PELAYANAN
                                </div>
                                <div style="font-weight:700;font-size:13px;">
                                    ${gangguan.status === 'selesai' ? 'Gangguan Telah Selesai' : 'Mohon Maaf Pelayanan Terganggu'}
                                </div>
                            </div>
                            <div style="padding:15px;">
                                <h6 style="margin:0 0 12px 0; color:#1e293b; font-size:15px;">
                                    ${gangguan.kode_laporan}
                                </h6>
                                
                                <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:12px;">
                                    <div style="background:${config.bg};padding:10px;border-radius:8px;text-align:center;">
                                        <div style="font-size:10px;color:#64748b;">STATUS</div>
                                        <div style="font-weight:700;color:${config.color};font-size:12px;">
                                            <i class="fas fa-circle" style="font-size:8px;"></i> ${config.text}
                                        </div>
                                    </div>
                                    <div style="background:#f1f5f9;padding:10px;border-radius:8px;text-align:center;">
                                        <div style="font-size:10px;color:#64748b;">TIPE</div>
                                        <div style="font-weight:700;color:#1e293b;font-size:12px;">
                                            ${gangguan.tipe_kerusakan ? gangguan.tipe_kerusakan.toUpperCase() : '-'}
                                        </div>
                                    </div>
                                </div>
                                
                                <div style="margin-bottom:10px;">
                                    <div style="font-size:11px;color:#64748b;margin-bottom:3px;">
                                        <i class="fas fa-map-marker-alt"></i> Lokasi
                                    </div>
                                    <div style="font-weight:600;color:#1e293b;">${gangguan.lokasi || '-'}</div>
                                </div>
                                
                                <div style="margin-bottom:10px;">
                                    <div style="font-size:11px;color:#64748b;margin-bottom:3px;">
                                        <i class="fas fa-users"></i> Wilayah Terdampak
                                    </div>
                                    <div style="font-weight:600;color:#1e293b;">${gangguan.wilayah_terdampak || '-'}</div>
                                </div>
                                
                                <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:12px;">
                                    <div style="background:#f0f9ff;padding:8px;border-radius:8px;text-align:center;">
                                        <div style="font-size:9px;color:#64748b;">JENIS</div>
                                        <div style="font-weight:700;color:#0369a1;font-size:11px;">
                                            ${gangguan.jenis_gangguan ? gangguan.jenis_gangguan.toUpperCase() : '-'}
                                        </div>
                                    </div>
                                    <div style="background:#f0f9ff;padding:8px;border-radius:8px;text-align:center;">
                                        <div style="font-size:9px;color:#64748b;">UKURAN</div>
                                        <div style="font-weight:700;color:#0369a1;font-size:11px;">
                                            ${gangguan.ukuran_pipa || '-'}
                                        </div>
                                    </div>
                                </div>
                                
                                ${gangguan.deskripsi ? `
                                <div style="background:#fef3c7;padding:10px;border-radius:8px;border-left:3px solid #f59e0b;margin-bottom:12px;">
                                    <div style="font-size:10px;color:#92400e;font-weight:600;">
                                        <i class="fas fa-info-circle"></i> DESKRIPSI
                                    </div>
                                    <div style="font-size:12px;color:#78350f;margin-top:3px;">${gangguan.deskripsi}</div>
                                </div>
                                ` : ''}
                                
                                <div style="background:linear-gradient(135deg,#ecfdf5,#d1fae5);padding:12px;border-radius:8px;text-align:center;">
                                    <div style="font-size:11px;color:#065f46;margin-bottom:4px;">
                                        <i class="fas fa-calendar-check"></i> Estimasi Penyelesaian
                                    </div>
                                    <div style="font-weight:700;color:#064e3b;font-size:14px;">
                                        ${gangguan.estimasi_selesai 
                                            ? new Date(gangguan.estimasi_selesai).toLocaleDateString('id-ID', {
                                                day: 'numeric', month: 'long', year: 'numeric'
                                              })
                                            : '-'}
                                    </div>
                                </div>
                                
                                <a href="https://wa.me/6281234567890?text=Halo%2C%20saya%20ingin%20menanyakan%20gangguan%20${encodeURIComponent(gangguan.kode_laporan)}%20di%20${encodeURIComponent(gangguan.lokasi)}" 
                                   target="_blank"
                                   style="display:block;background:linear-gradient(135deg,#25D366,#128C7E);color:white;padding:10px;border-radius:8px;text-align:center;text-decoration:none;margin-top:12px;font-weight:600;">
                                    <i class="fab fa-whatsapp"></i> Laporkan via WhatsApp
                                </a>
                            </div>
                        </div>
                    `, { maxWidth: 350 });
                    
                    markerLayers[`gangguan_${gangguan.id}`] = marker;
                } catch (e) {
                    console.error('Error loading gangguan', gangguan.id, e);
                }
            });
        }

        function loadTitikPenting() {
            const iconMap = {
                'valve': { icon: 'fa-toggle-on', color: '#ef4444' },
                'hydrant': { icon: 'fa-fire', color: '#dc2626' },
                'meter': { icon: 'fa-tachometer-alt', color: '#3b82f6' },
                'sambungan': { icon: 'fa-link', color: '#8b5cf6' },
                'pompa': { icon: 'fa-water', color: '#10b981' },
                'tandon': { icon: 'fa-database', color: '#06b6d4' },
                'lainnya': { icon: 'fa-map-pin', color: '#6b7280' }
            };
            
            titikPentingData.forEach(titik => {
                try {
                    const lat = parseFloat(titik.latitude);
                    const lng = parseFloat(titik.longitude);
                    if (isNaN(lat) || isNaN(lng)) return;
                    if (!isInArea(lat, lng)) return;
                    
                    const config = iconMap[titik.jenis_titik] || iconMap['lainnya'];
                    
                    const html = `
                        <div class="marker-wrapper">
                            <div class="marker-pin shape-circle" 
                                 style="background:${config.color};width:28px;height:28px;">
                                <i class="fas ${config.icon}"></i>
                            </div>
                            <div class="marker-label">${titik.nama_titik}</div>
                        </div>
                    `;
                    
                    const marker = L.marker([lat, lng], {
                        icon: L.divIcon({
                            className: 'custom-div-icon',
                            html: html,
                            iconSize: [28, 40],
                            iconAnchor: [14, 14]
                        })
                    }).addTo(map);
                    
                    marker.bindPopup(`
                        <div style="min-width:200px;">
                            <h6 style="background:${config.color};color:white;padding:10px;border-radius:8px 8px 0 0;margin:0;">
                                <i class="fas ${config.icon}"></i> ${titik.nama_titik}
                            </h6>
                            <div style="padding:12px;font-size:12px;">
                                <div><strong>Jenis:</strong> ${titik.jenis_titik}</div>
                                ${titik.keterangan ? `<div style="margin-top:5px;"><strong>Ket:</strong> ${titik.keterangan}</div>` : ''}
                            </div>
                        </div>
                    `);
                    
                    markerLayers[`titik_${titik.id}`] = marker;
                } catch (e) {
                    console.error('Error loading titik', titik.id, e);
                }
            });
        }

        // ============================================
        // INTERACTIVE FUNCTIONS
        // ============================================
        
        function focusOnJalur(id) {
            if (jalurLayers[id]) {
                map.fitBounds(jalurLayers[id].getBounds(), { padding: [50, 50] });
                jalurLayers[id].openPopup();
                if (window.innerWidth < 768) toggleSidebar();
            }
        }

        function focusOnBangunan(id) {
            const marker = markerLayers[`bangunan_${id}`];
            if (marker) {
                map.setView(marker.getLatLng(), 17);
                marker.openPopup();
                if (window.innerWidth < 768) toggleSidebar();
            }
        }

        function focusOnGangguan(id) {
            document.querySelectorAll('.gangguan-card, .list-item').forEach(item => {
                item.classList.remove('active');
            });
            
            const targetItem = document.querySelector(`.gangguan-card[data-id="${id}"]`);
            if (targetItem) {
                targetItem.classList.add('active');
                targetItem.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
            
            if (markerLayers[`gangguan_${id}`]) {
                const marker = markerLayers[`gangguan_${id}`];
                map.flyTo(marker.getLatLng(), 17, { duration: 0.8 });
                setTimeout(() => marker.openPopup(), 800);
            }
            
            if (window.innerWidth < 768) toggleSidebar();
        }

        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'F11') {
                e.preventDefault();
                toggleFullscreen();
            }
        });

        document.addEventListener('DOMContentLoaded', initMap);
    </script>
</body>
</html>