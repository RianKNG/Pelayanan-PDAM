<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Peta Jaringan Pipa - PDAM UP Darmaraja</title>

<!-- Leaflet & Plugins CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
<link rel="stylesheet" href="https://unpkg.com/@raruto/leaflet-elevation/dist/leaflet-elevation.min.css" />

<!-- Bootstrap & Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

<style>
/* ============================================
   1. RESET & BASE
============================================ */
* { margin: 0; padding: 0; box-sizing: border-box; }
:root { --scroll-duration: 60s; }
body { font-family: "Inter", sans-serif; background: #0f172a; overflow: hidden; height: 100vh; }

/* ============================================
   2. TOP NAVBAR & PROGRESS
============================================ */
.top-navbar { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: white; padding: 6px 0; box-shadow: 0 2px 10px rgba(0,0,0,0.3); position: relative; z-index: 1000; border-bottom: 1px solid rgba(255,255,255,0.05); }
.top-navbar-container { max-width: 1600px; margin: 0 auto; padding: 0 16px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; }
.brand-section { display: flex; align-items: center; gap: 8px; }
.brand-logo { width: 32px; height: 32px; background: linear-gradient(135deg, #06b6d4, #0891b2); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 16px; box-shadow: 0 2px 8px rgba(6,182,212,0.4); }
.brand-text h1 { font-size: 13px; font-weight: 700; margin: 0; letter-spacing: 0.3px; }
.brand-text small { font-size: 9px; opacity: 0.7; }
.contact-info-bar { display: flex; align-items: center; gap: 15px; background: rgba(255,255,255,0.05); padding: 4px 12px; border-radius: 8px; }
.contact-item-nav { display: flex; align-items: center; gap: 6px; font-size: 11px; padding: 3px 8px; background: rgba(255,255,255,0.1); border-radius: 6px; transition: all 0.2s; }
.contact-item-nav:hover { background: rgba(255,255,255,0.2); transform: translateY(-1px); }
.wa-qr-btn-nav { background: #25d366; color: white; border: none; padding: 3px 8px; border-radius: 6px; font-size: 9px; cursor: pointer; margin-left: 5px; transition: all 0.2s; }
.wa-qr-btn-nav:hover { background: #128c7e; transform: scale(1.05); }
.alert-section { display: flex; align-items: center; gap: 8px; background: rgba(245,158,11,0.15); border: 1px solid rgba(245,158,11,0.3); padding: 4px 10px; border-radius: 8px; font-size: 10px; }
.alert-icon { width: 24px; height: 24px; background: linear-gradient(135deg, #f59e0b, #d97706); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 10px; }
.alert-text strong { display: block; font-size: 10px; }
.alert-text small { opacity: 0.8; font-size: 9px; }
.alert-count { background: #f59e0b; color: white; padding: 2px 8px; border-radius: 10px; font-weight: 700; font-size: 11px; }

.notification-bar { background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.3); border-radius: 8px; padding: 4px 10px; flex: 1; max-width: 400px; overflow: hidden; }
.notification-title { font-size: 8px; opacity: 0.9; margin-bottom: 2px; font-weight: 600; }
.notification-scroll { overflow: hidden; white-space: nowrap; }
.notification-scroll-content { display: inline-block; animation: scroll-left var(--scroll-duration, 60s) linear infinite; font-size: 9px; }
.notification-item { display: inline-block; margin-right: 20px; padding: 2px 8px; background: rgba(255,255,255,0.1); border-radius: 10px; }
.notification-item.new-payment { animation: flashNew 2s ease; }
.notification-item strong { color: #fff; font-size: 9px; }
.notification-item .amount { color: #86efac; font-size: 9px; }
.notification-item .location { color: #fcd34d; font-size: 8px; }
@keyframes flashNew { 0%,100% { background: rgba(255,255,255,0.1); } 50% { background: linear-gradient(135deg, #10b981, #059669); } }
@keyframes scroll-left { 0% { transform: translateX(100%); } 100% { transform: translateX(-100%); } }

.unit-progress-bar { background: linear-gradient(135deg, #1e293b 0%, #334155 100%); padding: 8px 0; border-bottom: 1px solid rgba(255,255,255,0.05); position: relative; z-index: 999; }
.unit-progress-container { max-width: 1600px; margin: 0 auto; padding: 0 16px; padding-right: 280px; display: flex; align-items: center; gap: 16px; }
.unit-image-wrapper { width: 150px !important; height: 100px !important; border-radius: 10px; overflow: hidden; flex-shrink: 0; box-shadow: 0 4px 12px rgba(0,0,0,0.3); border: 2px solid rgba(255,255,255,0.1); background: #1e293b; }
.unit-image-wrapper img { width: 100% !important; height: 100% !important; object-fit: cover; }
.unit-info { flex-shrink: 0; color: white; min-width: 140px; }
.unit-info h3 { font-size: 11px; font-weight: 700; margin-bottom: 2px; color: #fbbf24; }
.unit-info p { font-size: 9px; opacity: 0.8; margin: 0; }
.unit-narrate-btn { background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; border: none; padding: 4px 10px; border-radius: 6px; font-size: 9px; font-weight: 600; cursor: pointer; margin-top: 4px; display: flex; align-items: center; gap: 4px; transition: all 0.3s; }
.unit-narrate-btn:hover { transform: scale(1.05); }

/* ============================================
   3. CIRCULAR PROGRESS & REVENUE
============================================ */
.revenue-progress-section { flex: 1; color: white; display: flex; align-items: center; gap: 16px; }
.revenue-middle { flex: 1; }
.circular-progress-wrapper { position: relative; width: 110px; height: 110px; flex-shrink: 0; }
.circular-progress-svg { transform: rotate(-90deg); }
.circular-track { fill: none; stroke: rgba(255,255,255,0.08); stroke-width: 8; }
.circular-fill { fill: none; stroke: url(#progressGradient); stroke-width: 8; stroke-linecap: round; stroke-dasharray: 283; stroke-dashoffset: 283; transition: stroke-dashoffset 2s cubic-bezier(0.4,0,0.2,1), filter 1s ease; }
.circular-dot { position: absolute; top: 50%; left: 50%; width: 10px; height: 10px; margin: -5px 0 0 -5px; border-radius: 50%; background: #fde68a; box-shadow: 0 0 8px rgba(245,158,11,1); transform: rotate(0deg) translateY(-49px); transition: transform 2s; z-index: 3; }
.circular-percentage { position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%); text-align: center; }
.circular-percentage span { display: block; font-size: 22px; font-weight: 900; color: #fde68a; text-shadow: 0 0 10px rgba(245,158,11,0.9); }
.circular-percentage small { display: block; font-size: 7px; font-weight: 700; letter-spacing: 2px; color: rgba(255,255,255,0.6); margin-top: 2px; }
.revenue-progress-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px; }
.revenue-progress-title { font-size: 9px; font-weight: 600; display: flex; align-items: center; gap: 4px; opacity: 0.9; }
.revenue-progress-stats { display: flex; gap: 8px; font-size: 9px; }
.revenue-progress-stat { display: flex; align-items: center; gap: 4px; background: rgba(255,255,255,0.1); padding: 2px 8px; border-radius: 10px; }
.revenue-progress-details { display: grid; grid-template-columns: repeat(2, 1fr); gap: 6px; }
.revenue-detail-card { background: rgba(255,255,255,0.08); padding: 4px 8px; border-radius: 6px; border: 1px solid rgba(255,255,255,0.1); }
.revenue-detail-label { font-size: 7px; color: rgba(255,255,255,0.7); text-transform: uppercase; margin-bottom: 1px; display: flex; align-items: center; gap: 3px; }
.revenue-detail-value { font-size: 11px; font-weight: 700; color: white; }
.revenue-detail-value.warning { color: #fbbf24; }
.revenue-detail-value.danger { color: #f87171; }
.revenue-detail-value.success { color: #86efac; }

.wilayah-progress-strip { flex-shrink: 0; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 10px; padding: 6px 10px; }
.wilayah-strip-title { font-size: 8px; font-weight: 700; color: rgba(255,255,255,0.7); margin-bottom: 4px; display: flex; align-items: center; gap: 4px; }
.wilayah-progress-grid { display: flex; gap: 10px; align-items: center; max-width: 340px; overflow-x: auto; }
.wilayah-ring-card { text-align: center; cursor: pointer; flex-shrink: 0; transition: transform 0.2s; }
.wilayah-ring-card:hover { transform: scale(1.1); }
.wilayah-ring-wrapper { position: relative; width: 52px; height: 52px; margin: 0 auto; }
.wilayah-ring-pct { position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%); font-size: 10px; font-weight: 800; }
.wilayah-ring-name { margin-top: 2px; font-size: 7px; font-weight: 700; color: rgba(255,255,255,0.85); white-space: nowrap; }
.wilayah-ring-detail { font-size: 6px; color: rgba(255,255,255,0.5); }

/* ============================================
   4. MAIN LAYOUT & SIDEBAR
============================================ */
.main-wrapper { display: flex; height: calc(100vh - 110px); position: relative; margin-right: 260px; }
#map { flex: 1; height: 100%; z-index: 1; background: #1e293b; }

.sidebar { position: fixed !important; right: 0 !important; top: 110px !important; bottom: 0 !important; width: 260px !important; background: white; box-shadow: -2px 0 15px rgba(0,0,0,0.2); z-index: 999; display: flex; flex-direction: column; border-radius: 12px 0 0 0; overflow: hidden; }
.sidebar-header { background: linear-gradient(135deg, #1e3c72, #2a5298); color: white; padding: 10px 14px; position: sticky; top: 0; z-index: 10; }
.sidebar-header h5 { margin: 0; font-size: 12px; font-weight: 600; display: flex; align-items: center; gap: 6px; }
.sidebar-header small { opacity: 0.8; font-size: 9px; display: block; margin-top: 2px; }
.sidebar-content { padding: 10px; overflow-y: auto; overflow-x: hidden; flex: 1; min-height: 0; scroll-behavior: smooth; background: #f8fafc; }
.sidebar-content::-webkit-scrollbar { width: 4px; }
.sidebar-content::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 2px; }

/* ============================================
   5. SEARCH, STATS & CARDS
============================================ */
.search-container { background: linear-gradient(135deg, #f0f9ff, #e0f2fe); padding: 8px; border-radius: 8px; margin-bottom: 10px; border: 1px solid #bae6fd; }
.search-title { font-size: 9px; font-weight: 700; color: #0369a1; margin-bottom: 6px; display: flex; align-items: center; gap: 4px; text-transform: uppercase; }
.search-row { display: flex; gap: 4px; margin-bottom: 6px; }
.search-input { flex: 1; min-width: 0; padding: 6px 8px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 10px; background: white; }
.search-input:focus { outline: none; border-color: #3b82f6; }
.search-select { padding: 6px 4px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 9px; background: white; min-width: 65px; flex-shrink: 0; }
.search-btn { padding: 6px 10px; background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 10px; display: flex; align-items: center; gap: 4px; }
.search-btn:hover { transform: translateY(-1px); }
.search-btn.clear { background: linear-gradient(135deg, #94a3b8, #64748b); }
.search-results { max-height: 150px; overflow-y: auto; margin-top: 6px; }
.search-result-item { padding: 6px 8px; background: white; border: 1px solid #e2e8f0; border-radius: 6px; margin-bottom: 4px; cursor: pointer; transition: all 0.2s; font-size: 10px; display: flex; justify-content: space-between; align-items: center; }
.search-result-item:hover { background: #f0f9ff; border-color: #3b82f6; transform: translateX(2px); }
.search-result-item .sr-name { font-weight: 600; color: #1e293b; }
.search-result-item .sr-detail { color: #64748b; font-size: 8px; }
.search-result-item .sr-badge { background: #3b82f6; color: white; padding: 1px 6px; border-radius: 8px; font-size: 8px; font-weight: 700; }
.search-empty { text-align: center; padding: 8px; color: #94a3b8; font-size: 10px; font-style: italic; }

.stats-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 6px; margin-bottom: 10px; }
.stat-card { padding: 8px; border-radius: 8px; text-align: center; color: white; box-shadow: 0 2px 6px rgba(0,0,0,0.1); transition: all 0.2s; position: relative; overflow: hidden; cursor: pointer; }
.stat-card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
.stat-total { background: linear-gradient(135deg, #6366f1, #4f46e5); }
.stat-menunggu { background: linear-gradient(135deg, #f59e0b, #d97706); }
.stat-proses { background: linear-gradient(135deg, #0ea5e9, #0284c7); }
.stat-selesai { background: linear-gradient(135deg, #10b981, #059669); }
.stat-bangunan { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
.stat-icon { font-size: 14px; opacity: 0.3; position: absolute; top: 4px; right: 4px; }
.stat-value { font-size: 18px; font-weight: 700; margin: 0; position: relative; }
.stat-label { font-size: 8px; opacity: 0.9; text-transform: uppercase; letter-spacing: 0.3px; margin-top: 2px; position: relative; }

.revenue-card { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 12px; border-radius: 10px; margin-bottom: 10px; box-shadow: 0 2px 8px rgba(16,185,129,0.3); cursor: pointer; }
.revenue-title { font-size: 9px; opacity: 0.9; margin-bottom: 4px; display: flex; align-items: center; gap: 4px; }
.revenue-amount { font-size: 20px; font-weight: 800; margin-bottom: 2px; }
.revenue-kubikasi { font-size: 10px; opacity: 0.9; display: flex; align-items: center; gap: 4px; }
.section-title { font-size: 10px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin: 10px 0 6px 0; padding-bottom: 4px; border-bottom: 2px solid #e2e8f0; display: flex; align-items: center; gap: 6px; }
.list-item { padding: 8px; border: 1px solid #e2e8f0; border-radius: 8px; margin-bottom: 6px; cursor: pointer; transition: all 0.2s; background: white; }
.list-item:hover { background: #f0f9ff; border-color: #0ea5e9; transform: translateX(2px); }

/* ============================================
   6. CONTROLS, LAYERS & VOICE PANEL
============================================ */
.control-buttons { position: fixed; left: 10px; top: 220px; z-index: 1001; display: flex; flex-direction: column; gap: 6px; }
.control-btn { background: linear-gradient(135deg, #1e3c72, #2a5298); color: white; border: none; padding: 8px 12px; border-radius: 8px; box-shadow: 0 2px 8px rgba(30,60,114,0.4); cursor: pointer; font-weight: 600; font-size: 11px; display: flex; align-items: center; gap: 6px; transition: all 0.3s; }
.control-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(30,60,114,0.5); }
.control-btn.expand.active { background: linear-gradient(135deg, #ef4444, #dc2626); }
.control-btn.voice.active { background: linear-gradient(135deg, #10b981, #059669); }
.control-btn.live.active { background: linear-gradient(135deg, #10b981, #059669); animation: pulse-live 2s infinite; }
@keyframes pulse-live { 0%,100% { box-shadow: 0 2px 8px rgba(16,185,129,0.3); } 50% { box-shadow: 0 2px 15px rgba(16,185,129,0.6); } }

.custom-layer-control { position: fixed; top: 480px; left: 10px; background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.2); z-index: 1001; padding: 8px; max-width: 160px; }
.layer-control-title { font-size: 9px; font-weight: 700; color: #1e293b; margin-bottom: 6px; display: flex; align-items: center; gap: 4px; padding-bottom: 4px; border-bottom: 1px solid #e2e8f0; }
.layer-btn-group { display: grid; grid-template-columns: repeat(2, 1fr); gap: 4px; }
.layer-btn { padding: 6px 4px; border: 2px solid #e2e8f0; background: white; border-radius: 6px; cursor: pointer; font-size: 9px; font-weight: 600; color: #64748b; transition: all 0.2s; display: flex; flex-direction: column; align-items: center; gap: 2px; }
.layer-btn:hover { border-color: #3b82f6; color: #3b82f6; }
.layer-btn.active { background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; border-color: #3b82f6; }

.voice-panel { position: fixed; right: 10px; top: 120px; background: white; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.2); padding: 14px; z-index: 1002; width: 340px; display: none; max-height: 85vh; overflow-y: auto; }
.voice-panel.active { display: block; animation: slideInRight 0.3s ease; }
@keyframes slideInRight { from { transform: translateX(50px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
.voice-panel-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; padding-bottom: 8px; border-bottom: 2px solid #e2e8f0; }
.voice-panel-title { font-size: 12px; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 6px; }
.voice-panel-close { background: none; border: none; color: #94a3b8; cursor: pointer; font-size: 14px; }
.voice-select-group { margin-bottom: 8px; }
.voice-select-label { font-size: 9px; font-weight: 600; color: #64748b; margin-bottom: 3px; display: block; }
.voice-select { width: 100%; padding: 6px; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 10px; background: #f8fafc; }
.voice-control-row { display: flex; align-items: center; gap: 8px; margin-top: 6px; }
.voice-control-label { font-size: 9px; color: #64748b; font-weight: 600; min-width: 60px; }
.voice-control-row input[type="range"] { flex: 1; accent-color: #3b82f6; }
.voice-btn-group { display: grid; grid-template-columns: 1fr 1fr; gap: 6px; }
.voice-btn { padding: 6px; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 9px; display: flex; align-items: center; justify-content: center; gap: 4px; transition: all 0.2s; }
.voice-btn.play { background: linear-gradient(135deg, #10b981, #059669); color: white; }
.voice-btn.stop { background: linear-gradient(135deg, #ef4444, #dc2626); color: white; }
.voice-btn.repeat { background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; }
.voice-btn:hover { transform: translateY(-1px); }
.voice-btn:disabled { opacity: 0.5; cursor: not-allowed; }
.voice-status-indicator { display: flex; align-items: center; gap: 6px; margin-top: 6px; padding: 6px; background: white; border-radius: 6px; font-size: 8px; }
.voice-status-dot { width: 6px; height: 6px; border-radius: 50%; background: #94a3b8; }
.voice-status-dot.active { background: #10b981; }
.gangguan-voice-control, .payment-voice-control, .music-control, .scroll-control, .youtube-control, .mute-control, .reminder-control { margin-top: 10px; padding: 10px; border-radius: 8px; border: 2px solid; }
.gangguan-voice-control { background: linear-gradient(135deg, #fef3c7, #fde68a); border-color: #f59e0b; }
.payment-voice-control { background: linear-gradient(135deg, #d1fae5, #a7f3d0); border-color: #10b981; }
.music-control { background: linear-gradient(135deg, #e0e7ff, #c7d2fe); border-color: #6366f1; }
.scroll-control { background: linear-gradient(135deg, #fce7f3, #fbcfe8); border-color: #ec4899; }
.youtube-control { background: linear-gradient(135deg, #fee2e2, #fecaca); border-color: #ef4444; }
.mute-control, .reminder-control { background: linear-gradient(135deg, #fef3c7, #fde68a); border-color: #f59e0b; }
.voice-control-title { font-size: 9px; font-weight: 700; margin-bottom: 6px; display: flex; align-items: center; gap: 4px; }
.gangguan-voice-control .voice-control-title { color: #92400e; }
.payment-voice-control .voice-control-title { color: #065f46; }
.music-control .voice-control-title { color: #3730a3; }
.scroll-control .voice-control-title { color: #9d174d; }
.youtube-control .voice-control-title { color: #991b1b; }
.mute-control .voice-control-title, .reminder-control .voice-control-title { color: #92400e; }

/* ============================================
   7. LIVE INFO PANEL & MARKERS
============================================ */
.live-info-panel { 
    position: fixed !important; bottom: 15px !important; right: 275px !important; left: auto !important; transform: none !important;
    background: linear-gradient(135deg, rgba(15, 23, 42, 0.92), rgba(30, 58, 138, 0.92)) !important;
    backdrop-filter: blur(16px) saturate(150%) !important; color: white; padding: 10px 16px !important; border-radius: 12px !important; 
    border: 1px solid rgba(239, 68, 68, 0.4) !important; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.35) !important; z-index: 9997 !important; 
    display: flex; align-items: center; gap: 14px !important; min-width: 340px !important; max-width: 420px !important;
    animation: slideInRightPanel 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) !important; transition: all 0.3s ease !important;
}
.live-info-panel:hover { transform: translateY(-2px) !important; border-color: rgba(239, 68, 68, 0.6) !important; }
@keyframes slideInRightPanel { from { transform: translateX(30px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
.live-info-panel .live-indicator { display: flex; align-items: center; gap: 6px; padding: 5px 12px !important; background: linear-gradient(135deg, #ef4444, #dc2626) !important; border-radius: 20px !important; font-size: 10px !important; font-weight: 800 !important; letter-spacing: 1px !important; flex-shrink: 0; }
.live-info-panel .live-dot { width: 7px; height: 7px; background: white; border-radius: 50%; animation: live-pulse 1.5s infinite; }
@keyframes live-pulse { 0%,100% { opacity: 1; transform: scale(1); } 50% { opacity: 0.5; transform: scale(1.3); } }
.live-info-panel .customer-info { flex: 1; display: flex; flex-direction: column; gap: 2px; min-width: 0; }
.live-info-panel .customer-name { font-size: 13px !important; font-weight: 800 !important; color: #fbbf24 !important; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.live-info-panel .customer-detail { font-size: 9px !important; opacity: 0.85 !important; color: #cbd5e1 !important; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.live-info-panel .customer-amount { font-size: 14px !important; font-weight: 900 !important; color: #f87171 !important; padding: 5px 12px !important; background: rgba(239, 68, 68, 0.15) !important; border-radius: 10px !important; border: 1px solid rgba(239, 68, 68, 0.3) !important; white-space: nowrap !important; flex-shrink: 0; }
.live-info-panel .counter { text-align: center; padding: 5px 10px !important; background: rgba(255, 255, 255, 0.08) !important; border-radius: 10px !important; border: 1px solid rgba(255, 255, 255, 0.1) !important; min-width: 55px !important; flex-shrink: 0; }
.live-info-panel .counter-num { font-size: 15px !important; font-weight: 900 !important; color: #fbbf24 !important; line-height: 1.1; }
.live-info-panel .counter-label { font-size: 7px !important; opacity: 0.7 !important; text-transform: uppercase !important; letter-spacing: 1px !important; margin: 2px 0 !important; }

.unpaid-marker-wrapper { position: relative; display: flex; flex-direction: column; align-items: center; pointer-events: none; }
.unpaid-marker-pin { width: 14px; height: 14px; background: linear-gradient(135deg, #ef4444, #dc2626); border-radius: 50%; border: 2px solid white; display: flex; align-items: center; justify-content: center; color: white; font-size: 7px; box-shadow: 0 1px 4px rgba(239,68,68,0.5); position: relative; z-index: 2; transition: all 0.3s ease; pointer-events: auto; }
.unpaid-marker-pulse { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 14px; height: 14px; border-radius: 50%; background: rgba(239,68,68,0.3); animation: unpaid-pulse 2s infinite; z-index: 1; }
@keyframes unpaid-pulse { 0% { transform: translate(-50%,-50%) scale(1); opacity: 0.6; } 100% { transform: translate(-50%,-50%) scale(2); opacity: 0; } }
.unpaid-marker-label { position: absolute; top: -20px; left: 50%; transform: translateX(-50%); background: linear-gradient(135deg, #dc2626, #991b1b); color: white; padding: 1px 6px; border-radius: 8px; font-size: 7px; font-weight: 700; white-space: nowrap; box-shadow: 0 1px 4px rgba(0,0,0,0.3); border: 1px solid white; z-index: 3; max-width: 100px; overflow: hidden; text-overflow: ellipsis; opacity: 0; transition: opacity 0.3s; }
.unpaid-marker-wrapper:hover .unpaid-marker-label, .unpaid-marker-wrapper.highlighted .unpaid-marker-label { opacity: 1; }
.unpaid-marker-amount { position: absolute; bottom: -16px; left: 50%; transform: translateX(-50%); background: #fbbf24; color: #7c2d12; padding: 1px 5px; border-radius: 5px; font-size: 7px; font-weight: 800; white-space: nowrap; box-shadow: 0 1px 3px rgba(0,0,0,0.2); z-index: 3; opacity: 0; transition: opacity 0.3s; }
.unpaid-marker-wrapper:hover .unpaid-marker-amount, .unpaid-marker-wrapper.highlighted .unpaid-marker-amount { opacity: 1; }
.unpaid-marker-wrapper.highlighted .unpaid-marker-pin { background: linear-gradient(135deg, #fbbf24, #f59e0b); box-shadow: 0 2px 12px rgba(251,191,36,0.8); transform: scale(1.8); width: 20px; height: 20px; }
.unpaid-marker-wrapper.highlighted .unpaid-marker-pulse { background: rgba(251,191,36,0.5); }
.pelanggan-marker-small { width: 10px; height: 10px; border-radius: 50%; border: 2px solid white; box-shadow: 0 1px 3px rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center; transition: all 0.3s ease; }
.pelanggan-marker-small:hover { transform: scale(1.5); box-shadow: 0 2px 8px rgba(0,0,0,0.4); }

/* ============================================
   8. TOAST, LEGEND & ROUTING
============================================ */
.toast-notification { position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background: white; padding: 10px 16px; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.2); z-index: 99999; display: flex; align-items: center; gap: 8px; font-size: 12px; font-weight: 600; animation: toastSlide 0.3s ease; max-width: 350px; }
.toast-notification.success { border-left: 4px solid #10b981; color: #065f46; }
.toast-notification.info { border-left: 4px solid #3b82f6; color: #1e40af; }
.toast-notification.warning { border-left: 4px solid #f59e0b; color: #92400e; }
.toast-notification.live { border-left: 4px solid #ef4444; color: #991b1b; background: #fef2f2; }
.toast-notification.payment { border-left: 4px solid #10b981; color: #065f46; background: #ecfdf5; }
@keyframes toastSlide { from { transform: translate(-50%, -50px); opacity: 0; } to { transform: translate(-50%, 0); opacity: 1; } }

.legend { position: absolute; bottom: 10px; left: 10px; background: white; padding: 10px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.15); z-index: 500; max-width: 180px; font-size: 10px; }
.legend-title { font-weight: 700; margin-bottom: 6px; color: #1e293b; font-size: 11px; display: flex; align-items: center; gap: 4px; }
.legend-group { margin-bottom: 6px; }
.legend-group-title { font-size: 8px; color: #64748b; text-transform: uppercase; font-weight: 600; margin-bottom: 2px; padding-bottom: 2px; border-bottom: 1px solid #e2e8f0; }
.legend-item { display: flex; align-items: center; gap: 6px; margin: 2px 0; }
.legend-marker { width: 12px; height: 12px; border-radius: 50%; border: 2px solid white; box-shadow: 0 0 0 1px rgba(0,0,0,0.2); display: flex; align-items: center; justify-content: center; color: white; font-size: 6px; }
.legend-pelanggan { position: absolute; bottom: 10px; right: 270px; background: white; padding: 10px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.15); z-index: 500; max-width: 200px; font-size: 10px; }
.legend-pelanggan-title { font-weight: 700; margin-bottom: 6px; color: #1e293b; font-size: 11px; display: flex; align-items: center; gap: 4px; }
.legend-pelanggan-item { display: flex; align-items: center; gap: 6px; margin: 3px 0; font-size: 9px; }
.legend-pelanggan-marker { width: 12px; height: 12px; border-radius: 50%; border: 2px solid white; box-shadow: 0 0 0 1px rgba(0,0,0,0.2); display: flex; align-items: center; justify-content: center; color: white; font-size: 6px; }

.gangguan-card { margin-bottom: 8px; border: 2px solid #e2e8f0; border-radius: 8px; overflow: hidden; cursor: pointer; transition: all 0.2s; background: white; }
.gangguan-card:hover { border-color: #0ea5e9; transform: translateX(2px); box-shadow: 0 2px 8px rgba(14,165,233,0.15); }
.gangguan-card-header { padding: 6px 10px; color: white; display: flex; justify-content: space-between; align-items: center; }
.gangguan-card-header.status-menunggu { background: linear-gradient(135deg, #fbbf24, #f59e0b); }
.gangguan-card-header.status-dalam_proses { background: linear-gradient(135deg, #60a5fa, #3b82f6); }
.gangguan-card-header.status-selesai { background: linear-gradient(135deg, #34d399, #10b981); }
.gangguan-card-code { font-weight: 700; font-size: 11px; display: flex; align-items: center; gap: 4px; }
.gangguan-card-status { background: rgba(255,255,255,0.25); padding: 2px 8px; border-radius: 10px; font-size: 8px; font-weight: 600; text-transform: uppercase; }
.gangguan-card-body { padding: 8px 10px; }
.gangguan-info-block { margin-bottom: 6px; }
.gangguan-info-label { font-size: 8px; color: #64748b; font-weight: 700; text-transform: uppercase; margin-bottom: 2px; display: flex; align-items: center; gap: 3px; }
.gangguan-info-value { font-weight: 600; color: #1e293b; font-size: 11px; }
.gangguan-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 6px; margin-bottom: 6px; }
.gangguan-grid-item { background: #f8fafc; padding: 6px; border-radius: 5px; }
.gangguan-grid-item .label { font-size: 8px; color: #64748b; font-weight: 600; margin-bottom: 1px; }
.gangguan-grid-item .value { font-weight: 600; color: #1e293b; font-size: 10px; }
.estimasi-box { background: linear-gradient(135deg, #fef3c7, #fde68a); padding: 8px; border-radius: 8px; border-left: 3px solid #f59e0b; margin-top: 6px; }
.estimasi-box-title { font-size: 8px; color: #92400e; font-weight: 700; margin-bottom: 6px; display: flex; align-items: center; gap: 4px; text-transform: uppercase; }
.estimasi-item { margin-bottom: 4px; }
.estimasi-label { font-size: 8px; color: #78350f; font-weight: 600; margin-bottom: 1px; display: flex; align-items: center; gap: 3px; }
.estimasi-value { font-weight: 700; color: #92400e; font-size: 10px; }
.estimasi-value.big { font-size: 16px; color: #dc2626; display: flex; align-items: baseline; gap: 3px; }
.estimasi-value.big .unit { font-size: 8px; color: #92400e; font-weight: 600; }
.estimasi-sub { font-size: 8px; color: #78350f; margin-top: 1px; }
.estimasi-sub strong { color: #dc2626; }
.empty-state { text-align: center; padding: 12px; color: #94a3b8; font-size: 10px; font-style: italic; }

.wilayah-card { margin-bottom: 10px; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; }
.wilayah-header { background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; padding: 6px 10px; font-weight: 600; font-size: 11px; display: flex; justify-content: space-between; align-items: center; }
.wilayah-blok-list { padding: 6px; }

.leaflet-routing-container { background: white !important; border-radius: 12px !important; box-shadow: 0 4px 20px rgba(0,0,0,0.3) !important; padding: 12px !important; max-width: 350px !important; font-size: 11px !important; }
.route-summary-box { background: linear-gradient(135deg,#3b82f6,#2563eb) !important; color: white !important; padding: 8px 12px !important; border-radius: 8px !important; margin-bottom: 8px !important; font-weight: 700 !important; text-align: center !important; }
.turn-direction { display: flex; align-items: center; padding: 6px 0; border-bottom: 1px solid #e2e8f0; }
.turn-direction i { margin-right: 10px; color: #3b82f6; width: 20px; text-align: center; font-size: 14px; }
.turn-direction span { flex: 1; color: #334155; font-size: 12px; }
.turn-direction .distance { color: #64748b; font-size: 11px; margin-left: 8px; font-weight: 600; }
.elevation-btn { width: 100%; margin-top: 8px; padding: 8px; background: linear-gradient(135deg, #10b981, #059669); color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 700; font-size: 11px; display: flex; align-items: center; justify-content: center; gap: 6px; }

/* ============================================
   9. FULLSCREEN & RESPONSIVE
============================================ */
.main-wrapper.is-fullscreen .sidebar, .main-wrapper.is-fullscreen .control-buttons, .main-wrapper.is-fullscreen .custom-layer-control, .main-wrapper.is-fullscreen .legend, .main-wrapper.is-fullscreen .legend-pelanggan { display: none !important; }
.main-wrapper.is-fullscreen .top-navbar { display: flex !important; position: fixed !important; top: 0 !important; left: 0 !important; right: 0 !important; z-index: 9999998 !important; }
.main-wrapper.is-fullscreen .unit-progress-bar { display: flex !important; position: fixed !important; top: 50px !important; left: 0 !important; right: 0 !important; z-index: 9999997 !important; }
.main-wrapper.is-fullscreen #map { height: calc(100vh - 110px) !important; margin-top: 110px !important; }
.main-wrapper.is-fullscreen .unit-image-wrapper { width: 200px !important; height: 130px !important; display: block !important; position: relative !important; top: auto !important; left: auto !important; z-index: 10 !important; border-radius: 10px !important; box-shadow: 0 4px 12px rgba(0,0,0,0.3) !important; border: 2px solid rgba(255,255,255,0.1) !important; }

@media (max-width: 768px) {
    .top-navbar-container { flex-direction: column; text-align: center; }
    .unit-progress-container { flex-direction: column; padding-right: 16px; }
    .main-wrapper { margin-right: 0; height: calc(100vh - 150px); }
    .sidebar { width: 100% !important; max-width: 320px !important; top: auto !important; bottom: 0 !important; right: 0 !important; transform: translateY(100%) !important; }
    .sidebar.active { transform: translateY(0) !important; }
    .legend { max-width: 150px; font-size: 9px; }
    .legend-pelanggan { max-width: 150px; font-size: 9px; right: 10px; bottom: 10px; }
    .control-buttons { left: 10px; top: auto; bottom: 10px; flex-direction: row; flex-wrap: wrap; }
    .custom-layer-control { top: auto; bottom: 60px; left: 10px; max-width: 150px; }
    .voice-panel { right: 10px; top: auto; bottom: 60px; width: calc(100% - 20px); max-width: 340px; }
    .live-info-panel { right: 10px !important; bottom: 10px !important; min-width: auto !important; max-width: calc(100% - 20px) !important; padding: 8px 12px !important; gap: 8px !important; flex-wrap: wrap !important; }
    .live-info-panel .customer-name { font-size: 11px !important; }
    .live-info-panel .customer-amount { font-size: 12px !important; }
    .revenue-progress-details { grid-template-columns: repeat(2, 1fr); }
    .revenue-progress-section { flex-direction: column; }
    .circular-progress-wrapper { width: 80px; height: 80px; }
    .wilayah-progress-strip { display: none; }
}
/* ============================================
ANIMASI LOGO BERGELANTUNGAN (LEBIH TERLIHAT)
============================================ */
@keyframes swing-logo-kuat {
    0% { transform: rotate(-12deg); }
    50% { transform: rotate(12deg); }
    100% { transform: rotate(-12deg); }
}

.unit-image-wrapper {
    animation: swing-logo-kuat 2.5s ease-in-out infinite;
    transform-origin: top center; /* ✅ Titik gantung di bagian atas tengah */
}
</style>
</head>
<body>
<audio id="backgroundMusic" loop preload="none"></audio>
<div id="youtubePlayerContainer" style="position:fixed;bottom:-200px;right:-200px;width:1px;height:1px;opacity:0;pointer-events:none;z-index:-1;"></div>

<!-- SVG DEFS -->
<svg style="position:absolute;width:0;height:0">
<defs>
<linearGradient id="progressGradient" x1="0%" y1="0%" x2="100%" y2="100%">
<stop offset="0%" style="stop-color:#fde68a" />
<stop offset="50%" style="stop-color:#f59e0b" />
<stop offset="100%" style="stop-color:#fde68a" />
</linearGradient>
</defs>
</svg>

<!-- TOP NAVBAR -->
<div class="top-navbar">
<div class="top-navbar-container">
<div class="brand-section">
<div class="brand-logo"><i class="fas fa-tint"></i></div>
<div class="brand-text">
<h1>PDAM UP - DARMARAJA</h1>
<small>Sistem Monitoring Jaringan</small>
</div>
</div>
<div class="contact-info-bar">
<div class="contact-item-nav"><i class="fas fa-headset"></i><span>Call Center: <strong>088294979966</strong></span></div>
<div class="contact-item-nav" style="background: rgba(37,211,102,0.2)"><i class="fab fa-whatsapp"></i><span>WhatsApp: <strong>088294979966</strong></span><button class="wa-qr-btn-nav" onclick="showWAQR()"><i class="fas fa-qrcode"></i> QR</button></div>
</div>
@php $gangguanAktif = isset($gangguanAktif) ? $gangguanAktif : collect($gangguan ?? [])->where('status', '!=', 'selesai'); $totalAktif = $gangguanAktif->count(); @endphp
@if($totalAktif > 0)
<div class="alert-section">
<div class="alert-icon"><i class="fas fa-info-circle"></i></div>
<div class="alert-text"><strong>Informasi Gangguan</strong><small>{{ $totalAktif }} gangguan aktif</small></div>
<div class="alert-count">{{ $totalAktif }}</div>
</div>
@else
<div class="alert-section" style="background: rgba(16,185,129,0.15); border-color: rgba(16,185,129,0.3);">
<div class="alert-icon" style="background: linear-gradient(135deg, #10b981, #059669)"><i class="fas fa-check-circle"></i></div>
<div class="alert-text"><strong>Pelayanan Normal</strong><small>Semua jaringan beroperasi baik</small></div>
</div>
@endif
<div class="notification-bar" id="notificationBar" style="display: none">
<div class="notification-title"><i class="fas fa-money-bill-wave"></i> Pembayaran Terbaru</div>
<div class="notification-scroll"><div class="notification-scroll-content" id="notificationContent"></div></div>
</div>
</div>
</div>

<!-- UNIT PROGRESS BAR -->
<div class="unit-progress-bar">
<div class="unit-progress-container">
<div class="unit-image-wrapper">
<img src="{{ asset('img/logo.PNG') }}" alt="Unit PDAM Darmaraja" style="width:200px; height:150px; object-fit:cover; border-radius:22px; box-shadow:0 0 0 4px rgba(255,255,255,0.9),0 0 0 8px rgba(59,130,246,0.6),0 12px 30px rgba(59,130,246,0.3); background:linear-gradient(135deg,#dbeafe,#93c5fd);" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22200%22 height=%22150%22%3E%3Crect fill=%22%231e3c72%22 width=%22200%22 height=%22150%22 rx=%2222%22/%3E%3Ctext x=%22100%22 y=%2275%22 text-anchor=%22middle%22 fill=%22white%22 font-size=%2216%22 font-weight=%22bold%22%3EPDAM%3C/text%3E%3C/svg%3E'">
</div>
<div class="unit-info">
<h3><i class="fas fa-building"></i> Unit Cabang Darmaraja</h3>
<p>Kec. Darmaraja, Kab. Sumedang</p>
<button class="unit-narrate-btn" onclick="narrateUnitProfile()"><i class="fas fa-volume-up"></i> Dengarkan Profil</button>
</div>
<div class="revenue-progress-section">
<div class="circular-progress-wrapper">
<svg class="circular-progress-svg" width="110" height="110" viewBox="0 0 100 100">
<circle class="circular-track" cx="50" cy="50" r="45" />
<circle class="circular-fill" id="circularProgressFill" cx="50" cy="50" r="45" />
</svg>
<div class="circular-dot" id="circularDot"></div>
<div class="circular-percentage"><span id="circularPercentage">0%</span><small>TARGET</small></div>
</div>
<div class="revenue-middle">
<div class="revenue-progress-header">
<div class="revenue-progress-title"><i class="fas fa-chart-line"></i><span>PROGRES PENDAPATAN BULAN INI</span></div>
<div class="revenue-progress-stats">
<div class="revenue-progress-stat"><i class="fas fa-calendar-day"></i><span>Hari ke-<strong id="currentDayOfMonth">0</strong></span></div>
<div class="revenue-progress-stat"><i class="fas fa-hourglass-half"></i><span>Sisa <strong id="remainingDays">0</strong> hari</span></div>
</div>
</div>
<div class="revenue-progress-details">
<div class="revenue-detail-card"><div class="revenue-detail-label"><i class="fas fa-coins"></i><span>Target</span></div><div class="revenue-detail-value" id="targetRevenue">Rp 0</div></div>
<div class="revenue-detail-card"><div class="revenue-detail-label"><i class="fas fa-money-bill-wave"></i><span>Terkumpul</span></div><div class="revenue-detail-value success" id="collectedRevenue">Rp 0</div></div>
<div class="revenue-detail-card"><div class="revenue-detail-label"><i class="fas fa-exclamation-triangle"></i><span>Sisa+Denda</span></div><div class="revenue-detail-value warning" id="remainingRevenue">Rp 0</div></div>
<div class="revenue-detail-card"><div class="revenue-detail-label"><i class="fas fa-tachometer-alt"></i><span>Rata²/Hari</span></div><div class="revenue-detail-value danger" id="dailyTarget">Rp 0</div></div>
</div>
</div>
<div class="wilayah-progress-strip">
<div class="wilayah-strip-title"><i class="fas fa-chart-pie"></i> PROGRES PER WILAYAH</div>
<div class="wilayah-progress-grid" id="wilayahProgressGrid"></div>
</div>
</div>
</div>

<!-- MAIN WRAPPER -->
<div class="main-wrapper" id="mainWrapper">
<div id="map"></div>
<div class="live-info-panel" id="liveInfoPanel" style="display: none">
<div class="live-indicator"><div class="live-dot"></div><span>LIVE</span></div>
<div class="customer-info"><div class="customer-name" id="liveCustomerName">-</div><div class="customer-detail" id="liveCustomerDetail">-</div></div>
<div class="customer-amount" id="liveCustomerAmount">Rp 0</div>
<div class="counter"><div class="counter-num" id="liveCounterCurrent">0</div><div class="counter-label">dari</div><div class="counter-num" id="liveCounterTotal">0</div></div>
</div>
<div class="custom-layer-control" id="layerControl">
<div class="layer-control-title"><i class="fas fa-layer-group"></i> Mode Peta</div>
<div class="layer-btn-group">
<button class="layer-btn" data-layer="street" onclick="switchLayer('street')"><i class="fas fa-map"></i><span>Jalan</span></button>
<button class="layer-btn active" data-layer="satellite" onclick="switchLayer('satellite')"><i class="fas fa-satellite"></i><span>Satelit</span></button>
<button class="layer-btn" data-layer="terrain" onclick="switchLayer('terrain')"><i class="fas fa-mountain"></i><span>Medan</span></button>
<button class="layer-btn" data-layer="dark" onclick="switchLayer('dark')"><i class="fas fa-moon"></i><span>Gelap</span></button>
</div>
</div>
<div class="control-buttons">
<button class="control-btn" onclick="toggleSidebar()"><i class="fas fa-bars"></i> Info</button>
<button class="control-btn expand" id="expandBtn" onclick="toggleFullscreen()"><i class="fas fa-expand"></i> <span>Fullscreen</span></button>
<button class="control-btn voice active" id="voiceBtn" onclick="toggleVoicePanel()"><i class="fas fa-sliders-h"></i> <span>Suara</span></button>
<button class="control-btn live" id="liveBtn" onclick="toggleLiveDashboard()"><i class="fas fa-broadcast-tower"></i> <span id="liveText">LIVE OFF</span></button>
<button class="control-btn" id="clearRouteBtn" onclick="clearRoute()" style="background:linear-gradient(135deg,#64748b,#475569);display:none;"><i class="fas fa-times"></i> <span>Hapus Rute</span></button>
</div>

<!-- VOICE PANEL -->
<div class="voice-panel" id="voicePanel">
<div class="voice-panel-header">
<div class="voice-panel-title"><i class="fas fa-sliders-h"></i> Panel Kontrol Suara</div>
<button class="voice-panel-close" onclick="toggleVoicePanel()"><i class="fas fa-times"></i></button>
</div>
<div class="reminder-control">
<div class="voice-control-title"><i class="fas fa-bell"></i> PENGINGAT OTOMATIS</div>
<div class="voice-control-row"><div class="voice-control-label"><i class="fas fa-coffee"></i> Istirahat</div><input type="time" id="reminderIstTime" value="12:00" style="flex:1;padding:5px;border:1px solid #f59e0b;border-radius:6px;font-size:10px;"></div>
<div class="voice-control-row"><div class="voice-control-label"><i class="fas fa-home"></i> Pulang</div><input type="time" id="reminderPulangTime" value="16:00" style="flex:1;padding:5px;border:1px solid #f59e0b;border-radius:6px;font-size:10px;"></div>
<div class="voice-control-row"><div class="voice-control-label"><i class="fas fa-mosque"></i> Jumat</div><input type="time" id="reminderPulangJumat" value="16:30" style="flex:1;padding:5px;border:1px solid #f59e0b;border-radius:6px;font-size:10px;"></div>
<div class="voice-btn-group" style="margin-top:8px;">
<button class="voice-btn play" onclick="toggleReminder(true)" id="btnReminderOn"><i class="fas fa-bell"></i> Aktif</button>
<button class="voice-btn stop" onclick="toggleReminder(false)" id="btnReminderOff"><i class="fas fa-bell-slash"></i> Nonaktif</button>
<button class="voice-btn" style="background:linear-gradient(135deg,#8b5cf6,#7c3aed);color:white;grid-column:span 2" onclick="testReminder('ist')"><i class="fas fa-vial"></i> Test Istirahat</button>
<button class="voice-btn" style="background:linear-gradient(135deg,#ec4899,#db2777);color:white;grid-column:span 2" onclick="testReminder('pulang')"><i class="fas fa-vial"></i> Test Pulang</button>
</div>
<div class="voice-status-indicator" style="margin-top:6px;"><div class="voice-status-dot active" id="reminderStatusDot"></div><span id="reminderStatusText">Pengingat Aktif</span></div>
</div>
<div class="music-control">
<div class="voice-control-title"><i class="fas fa-music"></i> KONTROL MUSIK LATAR</div>
<label class="voice-select-label">Pilih Musik:</label>
<select class="voice-select" id="musicSelect" onchange="changeMusic()">
<option value="">-- Pilih Musik --</option>
<option value="musik1.mp3">🎵 Musik 1 (Tenang)</option>
<option value="musik2.mp3">🎶 Musik 2 (Semangat)</option>
<option value="musik3.mp3">🎵 Musik 3 (Klasik)</option>
<option value="musik4.mp3">🌧️ Musik 4 (Alam)</option>
<option value="musik5.mp3">🎧 Musik 5 (Lo-Fi)</option>
</select>
<div class="voice-control-row"><div class="voice-control-label">Volume</div><input type="range" min="0" max="100" value="30" id="musicVolumeSlider" oninput="setMusicVolume(this.value)" /><span id="musicVolumeValue" style="font-size:9px;font-weight:600;min-width:30px">30%</span></div>
<div class="voice-btn-group" style="margin-top:6px">
<button class="voice-btn play" id="btnPlayMusic" onclick="playMusic()"><i class="fas fa-play"></i> Putar</button>
<button class="voice-btn stop" id="btnStopMusic" onclick="stopMusic()" disabled><i class="fas fa-stop"></i> Stop</button>
<button class="voice-btn repeat" id="btnLoopMusic" onclick="toggleLoopMusic()" style="background:linear-gradient(135deg,#6366f1,#4f46e5)"><i class="fas fa-redo"></i> Rotasi</button>
</div>
</div>
<div class="youtube-control">
<div class="voice-control-title"><i class="fab fa-youtube"></i> YOUTUBE MUSIC</div>
<div class="voice-control-row"><input type="text" id="youtubeUrl" placeholder="Paste link YouTube..." style="flex:1;padding:6px;border:1px solid #e2e8f0;border-radius:6px;font-size:9px;" /></div>
<div class="voice-btn-group" style="margin-top:6px">
<button class="voice-btn play" onclick="loadYouTube()"><i class="fab fa-youtube"></i> Putar</button>
<button class="voice-btn stop" onclick="stopYouTube()"><i class="fas fa-stop"></i> Stop</button>
</div>
<div class="voice-control-row" style="margin-top:6px"><div class="voice-control-label">Volume</div><input type="range" min="0" max="100" value="50" id="youtubeVolumeSlider" oninput="setYouTubeVolume(this.value)" /><span id="youtubeVolumeValue" style="font-size:9px;font-weight:600;min-width:30px">50%</span></div>
</div>
<div class="mute-control">
<div class="voice-control-title"><i class="fas fa-volume-mute"></i> MUTE SUARA LIVE</div>
<div class="voice-btn-group"><button class="voice-btn" id="btnMuteLive" onclick="toggleMuteLive()" style="background:linear-gradient(135deg,#ef4444,#dc2626);grid-column:span 2"><i class="fas fa-volume-up"></i> <span id="muteLiveText">Mute Suara Live</span></button></div>
<div class="voice-status-indicator" style="margin-top:6px;"><div class="voice-status-dot active" id="muteLiveStatusDot"></div><span id="muteLiveStatusText">Suara Live Aktif</span></div>
</div>
<div class="gangguan-voice-control">
<div class="voice-control-title"><i class="fas fa-exclamation-triangle"></i> SUARA GANGGUAN</div>
<div class="voice-select-group"><label class="voice-select-label">🎤 Gender:</label><select class="voice-select" id="gangguanGenderSelect" onchange="updateGangguanGender()"><option value="male">👨 Laki-laki</option><option value="female" selected>👩 Perempuan</option></select></div>
<div class="voice-select-group"><label class="voice-select-label">🎤 Pilih Suara:</label><select class="voice-select" id="gangguanVoiceSelect" onchange="updateVoiceIndex()"><option value="0">1. Default</option><option value="1">2. Alternatif 1</option><option value="2">3. Alternatif 2</option><option value="3" selected>4. Alternatif 3</option><option value="4">5. Alternatif 4</option></select></div>
<div class="voice-btn-group">
<button class="voice-btn play" id="btnPlayGangguan" onclick="playGangguanVoice()" disabled><i class="fas fa-play"></i> Putar</button>
<button class="voice-btn stop" id="btnStopGangguan" onclick="stopGangguanVoice()" disabled><i class="fas fa-stop"></i> Stop</button>
<button class="voice-btn repeat" id="btnRepeatGangguan" onclick="toggleRepeatGangguan()"><i class="fas fa-redo"></i> Ulang</button>
</div>
<div class="voice-status-indicator"><div class="voice-status-dot" id="gangguanVoiceStatusDot"></div><span id="gangguanVoiceStatusText">Siap</span></div>
</div>
<div class="payment-voice-control">
<div class="voice-control-title"><i class="fas fa-money-bill-wave"></i> SUARA PELANGGAN</div>
<div class="voice-select-group"><label class="voice-select-label">🎤 Gender:</label><select class="voice-select" id="paymentGenderSelect" onchange="updatePaymentGender()"><option value="female" selected>👩 Perempuan</option><option value="male">👨 Laki-laki</option></select></div>
<div class="voice-select-group"><label class="voice-select-label">🎤 Pilih Suara:</label><select class="voice-select" id="paymentVoiceSelect" onchange="updateVoiceIndex()"><option value="0">1. Default</option><option value="1">2. Alternatif 1</option><option value="2">3. Alternatif 2</option><option value="3" selected>4. Alternatif 3</option><option value="4">5. Alternatif 4</option></select></div>
<div class="voice-btn-group">
<button class="voice-btn play" id="btnPlayPayment" onclick="playLast5Payments()"><i class="fas fa-play"></i> Baca Terakhir</button>
<button class="voice-btn stop" id="btnStopPayment" onclick="stopPaymentVoice()" disabled><i class="fas fa-stop"></i> Stop</button>
<button class="voice-btn repeat" id="btnRepeatPayment" onclick="toggleRepeatPayment()"><i class="fas fa-redo"></i> Auto</button>
</div>
<div class="voice-status-indicator"><div class="voice-status-dot" id="paymentVoiceStatusDot"></div><span id="paymentVoiceStatusText">Siap</span></div>
</div>
<div class="scroll-control">
<div class="voice-control-title"><i class="fas fa-broadcast-tower"></i> LIVE DASHBOARD</div>
<div class="voice-control-row"><div class="voice-control-label">Kecepatan</div><input type="range" min="3" max="20" value="7" id="liveSpeedSlider" oninput="setLiveSpeed(this.value)" /><span id="liveSpeedValue" style="font-size:9px;font-weight:600;min-width:35px">7 detik</span></div>
<div class="voice-btn-group" style="margin-top:6px">
<button class="voice-btn play" id="btnLiveStart" onclick="startLiveCycle()"><i class="fas fa-play"></i> Mulai</button>
<button class="voice-btn stop" id="btnLiveStop" onclick="stopLiveCycle()" disabled><i class="fas fa-stop"></i> Stop</button>
</div>
</div>
<div style="margin-top:10px;padding:10px;background:linear-gradient(135deg,#f1f5f9,#e2e8f0);border-radius:8px;border:2px solid #94a3b8;">
<div class="voice-control-title" style="color:#334155"><i class="fas fa-cog"></i> PENGATURAN</div>
<div class="voice-control-row"><div class="voice-control-label">Volume</div><input type="range" min="0" max="100" value="80" id="volumeSlider" oninput="setVoiceVolume(this.value)" /><span id="volumeValue" style="font-size:9px;font-weight:600;min-width:30px">80%</span></div>
<button class="voice-test-btn" onclick="testVoice()"><i class="fas fa-play"></i> Test Suara</button>
</div>
<div class="scroll-control">
<div class="voice-control-title"><i class="fas fa-tachometer-alt"></i> KECEPATAN TULISAN</div>
<div class="voice-control-row"><div class="voice-control-label">Kecepatan</div><input type="range" min="10" max="200" value="60" id="scrollSpeedSlider" oninput="setScrollSpeed(this.value)" /><span id="scrollSpeedValue" style="font-size:9px;font-weight:600;min-width:60px">Normal</span></div>
</div>
</div>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
<div class="sidebar-header"><h5><i class="fas fa-network-wired"></i> Informasi Jaringan</h5><small>Kecamatan Darmaraja, Kab. Sumedang</small></div>
<div class="sidebar-content" id="sidebarContent">
<div class="search-container">
<div class="search-title"><i class="fas fa-search"></i> Pencarian Pelanggan</div>
<div class="search-row">
<input type="text" class="search-input" id="searchInput" placeholder="No. Sambungan / Nama..." oninput="performSearch()" />
<select class="search-select" id="searchFilter" onchange="performSearch()"><option value="all">Semua</option><option value="Kantor">Kantor</option><option value="PPOB">PPOB</option><option value="Belum Bayar">Belum Bayar</option></select>
</div>
<div class="search-row">
<button class="search-btn" onclick="performSearch()"><i class="fas fa-search"></i> Cari</button>
<button class="search-btn clear" onclick="clearSearch()"><i class="fas fa-times"></i> Reset</button>
</div>
<div class="search-results" id="searchResults"></div>
</div>
<div id="today-stats-card" class="revenue-card" style="background:linear-gradient(135deg,#3b82f6,#1d4ed8);margin-bottom:10px;">
<div class="revenue-title"><i class="fas fa-calendar-day"></i> <span id="today-date">Hari Ini</span></div>
<div class="revenue-amount" id="today-amount">Rp 0</div>
<div class="revenue-kubikasi"><i class="fas fa-users"></i> <strong id="today-count">0</strong> rekening • <strong id="today-kubikasi">0</strong> m³</div>
</div>
<div class="stats-grid">
<div class="stat-card stat-total"><i class="fas fa-list stat-icon"></i><div class="stat-value">{{ $stats['total'] ?? 0 }}</div><div class="stat-label">Total Gangguan</div></div>
<div class="stat-card stat-menunggu"><i class="fas fa-clock stat-icon"></i><div class="stat-value">{{ $stats['menunggu'] ?? 0 }}</div><div class="stat-label">Menunggu</div></div>
<div class="stat-card stat-proses"><i class="fas fa-spinner stat-icon"></i><div class="stat-value">{{ $stats['dalam_proses'] ?? 0 }}</div><div class="stat-label">Proses</div></div>
<div class="stat-card stat-selesai"><i class="fas fa-check stat-icon"></i><div class="stat-value">{{ $stats['selesai'] ?? 0 }}</div><div class="stat-label">Selesai</div></div>
</div>
<div class="stats-grid">
<div class="stat-card stat-bangunan"><i class="fas fa-building stat-icon"></i><div class="stat-value">{{ ($bangunan ?? collect())->count() }}</div><div class="stat-label">Bangunan</div></div>
<div class="stat-card" style="background:linear-gradient(135deg,#f59e0b,#d97706)"><i class="fas fa-map-marked-alt stat-icon"></i><div class="stat-value">{{ ($zonaList ?? collect())->count() }}</div><div class="stat-label">Zona</div></div>
<div class="stat-card" style="background:linear-gradient(135deg,#06b6d4,#0891b2)"><i class="fas fa-map-pin stat-icon"></i><div class="stat-value">{{ ($titikPenting ?? collect())->count() }}</div><div class="stat-label">Titik Penting</div></div>
<div class="stat-card" style="background:linear-gradient(135deg,#10b981,#059669);"><i class="fas fa-users stat-icon"></i><div class="stat-value">{{ count($pelanggan ?? []) }}</div><div class="stat-label">Total Pelanggan</div></div>
</div>
<div class="section-title"><i class="fas fa-exclamation-triangle text-danger"></i> Gangguan Aktif <span class="badge bg-danger ms-auto">{{ $gangguanAktif->count() }}</span></div>
@forelse($gangguanAktif as $gang)
@if(is_object($gang))
<div class="gangguan-card" data-id="{{ $gang->id }}" data-type="gangguan" onclick="focusOnGangguan({{ $gang->id }})">
<div class="gangguan-card-header status-{{ $gang->status }}">
<div class="gangguan-card-code"><i class="fas fa-exclamation-circle"></i> {{ $gang->kode_laporan }}</div>
<span class="gangguan-card-status">{{ ucfirst(str_replace('_', ' ', $gang->status)) }}</span>
</div>
<div class="gangguan-card-body">
<div class="gangguan-info-block"><div class="gangguan-info-label"><i class="fas fa-map-marker-alt"></i> Lokasi</div><div class="gangguan-info-value">{{ $gang->lokasi }}</div></div>
<div class="gangguan-grid-2">
<div class="gangguan-grid-item"><div class="label"><i class="fas fa-tools"></i> Kondisi</div><div class="value">{{ ucfirst(str_replace('_', ' ', $gang->tipe_kerusakan)) }}</div></div>
<div class="gangguan-grid-item"><div class="label"><i class="fas fa-users"></i> Dampak</div><div class="value">{{ Str::limit($gang->wilayah_terdampak, 15) }}</div></div>
</div>
<div class="estimasi-box">
<div class="estimasi-box-title"><i class="fas fa-calculator"></i> Estimasi Real-Time</div>
<div class="estimasi-item"><div class="estimasi-label"><i class="fas fa-ruler-horizontal"></i> Ukuran Pipa</div><div class="estimasi-value">{{ $gang->ukuran_pipa }}</div></div>
<div class="estimasi-item"><div class="estimasi-label"><i class="fas fa-tint-slash"></i> Potensi Kehilangan</div><div class="estimasi-value big">{{ number_format($gang->debit_bocor ?? 0, 0) }}<span class="unit">m³/jam</span></div><div class="estimasi-sub">Total: <strong>{{ number_format($gang->total_kehilangan_air ?? 0, 1) }} m³</strong> ({{ $gang->durasi_jam ?? 0 }} jam)</div></div>
@if($gang->estimasi_selesai)<div class="estimasi-item"><div class="estimasi-label"><i class="fas fa-calendar-check"></i> Estimasi Selesai</div><div class="estimasi-value" style="color:#059669">{{ \Carbon\Carbon::parse($gang->estimasi_selesai)->format('d/m/Y') }}</div></div>@endif
</div>
@if($gang->deskripsi)<div style="margin-top:6px;padding:6px;background:#f1f5f9;border-radius:5px;"><div style="font-size:8px;color:#64748b;font-weight:600;margin-bottom:1px;"><i class="fas fa-info-circle"></i> DESKRIPSI</div><div style="font-size:9px;color:#475569">{{ Str::limit($gang->deskripsi, 80) }}</div></div>@endif
</div>
</div>
@endif
@empty
<div class="empty-state"><i class="fas fa-check-circle" style="font-size:24px;color:#10b981;margin-bottom:6px"></i><div>Tidak ada gangguan aktif</div></div>
@endforelse
<div class="section-title"><i class="fas fa-building"></i> Bangunan</div>
@forelse($bangunan ?? [] as $b)
<div class="list-item" data-id="{{ $b->id }}" data-type="bangunan" onclick="focusOnBangunan({{ $b->id }})"><div class="layer-info"><div class="layer-name"><span class="color-dot" style="background:{{ $b->warna }};"></span> {{ $b->nama_bangunan }}</div><div class="layer-meta"><i class="fas fa-tag"></i> {{ ucfirst(str_replace('_', ' ', $b->jenis_bangunan)) }}</div></div></div>
@empty
<div class="empty-state">Belum ada data bangunan</div>
@endforelse
<div class="section-title"><i class="fas fa-map-marked-alt" style="color:#f59e0b;"></i> Zona Wilayah <span class="badge bg-warning ms-auto">{{ ($zonaList ?? collect())->count() }}</span></div>
@forelse($zonaList ?? [] as $z)
<div class="list-item" data-id="{{ $z->id }}" data-type="zona" onclick="focusOnZona({{ $z->id }})"><div class="layer-info"><div class="layer-name"><span class="color-dot" style="background:{{ $z->warna }};"></span> {{ $z->nama_zona }}</div><div class="layer-meta"><i class="fas fa-tag"></i> {{ $z->jenis_zona }}@if($z->elevasi_min || $z->elevasi_max)<span style="margin-left:8px;"><i class="fas fa-mountain"></i> {{ $z->elevasi_min ?? '?' }}-{{ $z->elevasi_max ?? '?' }} mdpl</span>@endif</div></div></div>
@empty
<div class="empty-state">Belum ada data zona</div>
@endforelse
<div class="section-title"><i class="fas fa-map-marked-alt text-primary"></i> Wilayah & Blok</div>
<div id="wilayah-blok-container"><div class="text-center py-3 text-muted"><i class="fas fa-spinner fa-spin"></i> Memuat data wilayah...</div></div>
</div>
</div>

<!-- LEGEND -->
<div class="legend">
<div class="legend-title"><i class="fas fa-info-circle"></i> Legenda Peta</div>
<div class="legend-group"><div class="legend-group-title">Bangunan</div>
<div class="legend-item"><div class="legend-marker" style="background:#06b6d4"><i class="fas fa-database"></i></div><span>Reservoir</span></div>
<div class="legend-item"><div class="legend-marker" style="background:#8b5cf6"><i class="fas fa-industry"></i></div><span>IPA</span></div>
<div class="legend-item"><div class="legend-marker" style="background:#3b82f6"><i class="fas fa-building"></i></div><span>Kantor</span></div>
</div>
<div class="legend-group"><div class="legend-group-title">Gangguan</div>
<div class="legend-item"><div class="legend-marker" style="background:#ef4444"><i class="fas fa-exclamation"></i></div><span>Aktif</span></div>
<div class="legend-item"><div class="legend-marker" style="background:#f59e0b"><i class="fas fa-tools"></i></div><span>Proses</span></div>
<div class="legend-item"><div class="legend-marker" style="background:#10b981"><i class="fas fa-check"></i></div><span>Selesai</span></div>
</div>
</div>
<div class="legend-pelanggan">
<div class="legend-pelanggan-title"><i class="fas fa-users"></i> Status Pembayaran</div>
<div class="legend-pelanggan-item"><div class="legend-pelanggan-marker" style="background:#10b981"><i class="fas fa-building"></i></div><span>Bayar di Kantor</span></div>
<div class="legend-pelanggan-item"><div class="legend-pelanggan-marker" style="background:#f59e0b"><i class="fas fa-mobile-alt"></i></div><span>Bayar di PPOB</span></div>
<div class="legend-pelanggan-item"><div class="legend-pelanggan-marker" style="background:#ef4444"><i class="fas fa-times"></i></div><span>Belum Bayar</span></div>
</div>

<!-- WA QR MODAL -->
<div class="modal fade" id="waQRModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered"><div class="modal-content">
<div class="modal-header" style="background:linear-gradient(135deg,#128C7E,#25d366);color:white;text-align:center;display:block;">
<i class="fab fa-whatsapp" style="font-size:40px"></i><h4 class="mt-2">WhatsApp PDAM Tirta Medal</h4><small>Scan QR Code atau klik tombol di bawah</small>
<button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-2" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body text-center">
<div id="wa-qrcode" style="display:inline-block;"></div>
<div style="margin-top:10px;font-size:12px;"><div><i class="fas fa-phone"></i> <strong>088294979966</strong></div><div><i class="fas fa-clock"></i> Senin - Sabtu, 08.00 - 16.00 WIB</div></div>
<a href="https://wa.me/6288294979966?text=Halo%20PDAM%20Tirta%20Medal" target="_blank" class="btn btn-success mt-2 w-100"><i class="fab fa-whatsapp"></i> Buka WhatsApp</a>
<button type="button" class="btn btn-light mt-2 w-100" data-bs-dismiss="modal"><i class="fas fa-times"></i> Tutup</button>
</div>
</div></div>
</div>

<!-- SCRIPTS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.min.js"></script>
<script src="https://unpkg.com/@raruto/leaflet-elevation/dist/leaflet-elevation.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script src="https://www.youtube.com/iframe_api"></script>

<script>
// ============================================
// 1. DATA DARI LARAVEL & KONFIGURASI
// ============================================
const jalurPipaData = @json($jalurPipa ?? []);
const bangunanData = @json($bangunan ?? []);
const gangguanData = @json($gangguan ?? []);
const titikPentingData = @json($titikPenting ?? []);
const pelangganDataFromLaravel = @json($pelanggan ?? []);
const zonaData = @json($zonaList ?? []);
const gangguanFotosData = @json($gangguanFotosData ?? []);
const API_REALTIME_URL = '/api/pelanggan/realtime';
const POLLING_INTERVAL = 2000; // ✅ Dipercepat ke 10 detik agar lebih responsif
let isFetchingPayments = false; // ✅ GUARD: Mencegah request menumpuk jika internet lambat

// ============================================
// 2. GLOBAL STATE & CACHE
// ============================================
let map, jalurLayers = {}, markerLayers = {}, pelangganLayers = {}, pelangganClusterGroup, zonaLayers = {};
let isFullscreen = false, totalRevenue = 0, totalKubikasi = 0;
let currentLayer = 'street', baseLayers = {}, currentBaseLayer = null;
let isMusicPlaying = false, isMusicPaused = false, autoRotateMusic = true, currentMusicType = '', currentPlaylistIndex = 0;
let isLiveDashboardActive = false, highlightedMarkerElement = null;
let liveCycleInterval = null, liveCycleIndex = 0, liveCycleSpeed = 7000;
let isLiveMuted = false;
let realtimePollingInterval = null, lastKnownPaymentTimestamps = {}, isFirstLoad = true;
let lastActivityTime = Date.now(), sidebarScrollDirection = 1, sidebarScrollInterval;
let youtubePlayer = null, isYoutubeReady = false;
let petaSlideshowControlInstance = null, petaSlideshowPhotos = [], petaSlideshowIndex = 0, petaSlideshowInterval = null, currentImgSlot = 1;
let audioUnlocked = false;
let currentRouteControl = null, userLocationMarker = null, userLocation = null, routeStartMarker = null, routeDestMarker = null, routingLoaded = false, elevationControl = null;
let reminderEnabled = true, reminderTimeout = null;
let lastTriggered = { ist: '', pulang: '' };
// ============================================
// VARIABEL UNTUK NARASI PROGRES HARIAN (JAM 1 SIANG)
// ============================================


// ✅ ANTI-SPAM CACHE UNTUK PEMBAYARAN
if (typeof window.processedPaymentKeys === 'undefined') {
    window.processedPaymentKeys = new Set();
}
let isInitialLoadComplete = false;

const REMINDER_MESSAGES = {
  ist: ["Waktu istirahat telah tiba. Jangan lupa makan siang. Tetap semangat!","Istirahat dulu yuk. Jaga kesehatan agar tetap produktif.","Saatnya rehat sejenak. Refresh pikiran, lanjutkan pekerjaan dengan segar."],
  pulang: ["Waktu pulang telah tiba. Terima kasih atas kerja keras hari ini. Hati-hati di jalan!","Simpan peralatan, rapikan meja, dan pulang dengan selamat.","Alhamdulillah hari ini selesai. Sampai jumpa besok, jaga kesehatan!"]
};

// ✅ TAMBAHKAN FUNGSI INI DI SINI:
function initReminderAutoActive() {
    // 1. Paksa status logika menjadi AKTIF
    reminderEnabled = true;

    // 2. Update UI agar terlihat hijau/aktif
    const dot = document.getElementById('reminderStatusDot');
    const txt = document.getElementById('reminderStatusText');
    if (dot) dot.className = 'voice-status-dot active';
    if (txt) txt.textContent = 'Pengingat Aktif (Otomatis)';

    // 3. Langsung jalankan timer penjadwalan
    if (typeof scheduleNextReminder === 'function') {
        scheduleNextReminder();
    }
    console.log('✅ Sistem Pengingat otomatis AKTIF tanpa perlu diklik');
}
const voiceProfiles = [{ name: 'Default', pitch: 1.0, rate: 0.95 },{ name: 'Alternatif 1', pitch: 1.1, rate: 0.90 },{ name: 'Alternatif 2', pitch: 0.9, rate: 1.00 },{ name: 'Alternatif 3', pitch: 1.2, rate: 0.85 },{ name: 'Alternatif 4', pitch: 0.8, rate: 1.05 }];
const musicFolder = '/audio/';
const musicPlaylist = ['musik1.mp3','musik2.mp3','musik3.mp3','musik4.mp3','musik5.mp3'];
const ID_KEYWORDS = ['indonesia','bahasa indonesia','id-id','indonesian','damayanti','andika','ardian','gadis','ardi','bimo','siti','ratu'];
const FEMALE_KEYWORDS = ['female','wanita','perempuan','woman','girl','damayanti','gadis','siti','ratu','samantha','victoria','zira'];
const MALE_KEYWORDS = ['male','pria','laki','man','boy','andika','ardian','ardi','bimo','david','mark','daniel'];
let voiceSettings = { enabled: true, volume: 0.8, gangguanGender: 'female', gangguanVoiceIndex: 3, paymentGender: 'female', paymentVoiceIndex: 3 };
let availableVoices = [], indonesianVoices = [], indonesianFemaleVoices = [], indonesianMaleVoices = [];
let isGangguanVoicePlaying = false, isGangguanVoicePaused = false, repeatGangguanVoice = false, activeGangguanList = [];
let isPaymentVoicePlaying = false, isPaymentVoicePaused = false, repeatPaymentVoice = false, last5Payments = [], currentPaymentIndex = 0;
let voiceQueue = [], isVoiceSpeaking = false, isNarrating = false, currentNarrationIndex = 0, narrationPaused = false;
let unpaidCustomerMarkers = [], unpaidCustomerList = [];
let displayedPct = 0, lastDataHash = '';
// ============================================
// VARIABEL NARASI PROGRES HARIAN (JAM 1 SIANG > 85%)
// ============================================
let hasSpokenDailyProgress = false; // Agar hanya bunyi 1x sehari
let lastSpokenDate = '';            // Untuk mendeteksi pergantian hari
// ============================================
// 3. UTILITY FUNCTIONS
// ============================================
function throttle(fn, wait = 100) {
  let last = 0;
  return function(...args) { const now = Date.now(); if (now - last >= wait) { last = now; fn.apply(this, args); } };
}
function parseKoordinator(s) { try { if (!s) return null; const c = s.split(',').map(x => parseFloat(x.trim())); return (c.length === 2 && !isNaN(c[0]) && !isNaN(c[1])) ? c : null; } catch(e) { return null; } }
function formatRupiah(a) { return (!a || a === 0) ? 'Rp 0' : 'Rp ' + parseInt(a).toLocaleString('id-ID'); }
function formatDate(s) { return (!s || s === '-' || s === '.') ? '-' : new Date(s).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }); }
function isInArea(lat, lng) { return lat >= -6.98 && lat <= -6.80 && lng >= 107.80 && lng <= 108.15; }
function parseCoordinates(s) {
  try {
    if (!s) return null;
    let str = String(s).trim();
    if (str.startsWith('"') && str.endsWith('"')) str = str.substring(1, str.length - 1);
    str = str.replace(/\\/g, '');
    let coords = JSON.parse(str);
    if (Array.isArray(coords) && coords.length > 0 && Array.isArray(coords[0])) coords = coords[0];
    return coords.map(c => (typeof c === 'object' && c !== null && c.lat !== undefined && c.lng !== undefined) ? [parseFloat(c.lat), parseFloat(c.lng)] : c);
  } catch(e) { return null; }
}
function hasPointInArea(coords) { return coords && Array.isArray(coords) && coords.some(c => isInArea(c[0], c[1])); }
function showNotification(msg, type = 'info') {
  const toast = document.createElement('div');
  toast.className = `toast-notification ${type}`;
  const icons = { success: 'fa-check-circle', info: 'fa-info-circle', warning: 'fa-exclamation-triangle', live: 'fa-broadcast-tower', payment: 'fa-money-bill-wave' };
  toast.innerHTML = `<i class="fas ${icons[type] || 'fa-info-circle'}"></i><span>${msg}</span>`;
  document.body.appendChild(toast);
  setTimeout(() => { toast.style.animation = 'toastSlide 0.3s ease reverse'; setTimeout(() => toast.remove(), 300); }, 3000);
}
function getPaymentStatus(p) {
  const hasLoket = p.tanggal_pembayaran_loket && !['-','.','',null].includes(p.tanggal_pembayaran_loket);
  const hasPPOB = p.tanggal_pembayaran_ppob && !['-','.','',null].includes(p.tanggal_pembayaran_ppob);
  if (hasLoket) return { status: 'Kantor', color: '#10b981', icon: 'fa-building', tanggal: p.tanggal_pembayaran_loket, metode: 'Kantor' };
  if (hasPPOB) return { status: 'PPOB', color: '#f59e0b', icon: 'fa-mobile-alt', tanggal: p.tanggal_pembayaran_ppob, metode: 'PPOB' };
  return { status: 'Belum Bayar', color: '#ef4444', icon: 'fa-times', tanggal: null, metode: null };
}
function toTitleCase(str) { return str ? str.replace(/\w\S*/g, t => t.charAt(0).toUpperCase() + t.substr(1).toLowerCase()) : str; }
function convertRegionRomanToNumber(name) {
  if (!name) return name;
  const map = { X:'10',IX:'9',VIII:'8',VII:'7',VI:'6',V:'5',IV:'4',III:'3',II:'2',I:'1' };
  return name.replace(/\b(X|IX|VIII|VII|VI|V|IV|III|II|I)\b/g, m => map[m] || m);
}
function formatNameForSpeech(name) { return name ? toTitleCase(name.trim().replace(/\s+/g, ' ').toLowerCase()) : 'Pelanggan'; }
function cleanSpacedLetters(text) {
  if (!text) return text;
  const parts = text.trim().split(/\s+/);
  if (parts.length >= 2 && parts.every(p => p.length === 1 && /^[A-Za-z]$/.test(p))) {
    const joined = parts.join('');
    return joined.charAt(0).toUpperCase() + joined.slice(1).toLowerCase();
  }
  return text;
}
function ubahRomawiKeAngka(teks) {
  if (!teks) return teks;
  let hasil = teks;
  hasil = hasil.replace(/IIII\b/g, '4'); hasil = hasil.replace(/III\b/g, '3'); hasil = hasil.replace(/II\b/g, '2');
  hasil = hasil.replace(/IV\b/g, '4'); hasil = hasil.replace(/I\b/g, '1');
  return hasil;
}

// ============================================
// 4. REMINDER SYSTEM
// ============================================
function toggleReminder(state) {
  reminderEnabled = state;
  const dot = document.getElementById('reminderStatusDot');
  const txt = document.getElementById('reminderStatusText');
  if (state) { dot.className = 'voice-status-dot active'; txt.textContent = 'Pengingat Aktif'; scheduleNextReminder(); showNotification('🔔 Pengingat diaktifkan', 'success'); }
  else { dot.className = 'voice-status-dot paused'; txt.textContent = 'Pengingat Nonaktif'; if (reminderTimeout) { clearTimeout(reminderTimeout); reminderTimeout = null; } showNotification('🔕 Pengingat dimatikan', 'warning'); }
}
function scheduleNextReminder() {
  if (reminderTimeout) clearTimeout(reminderTimeout);
  if (!reminderEnabled) return;
  const now = new Date();
  const istTime = document.getElementById('reminderIstTime')?.value || '12:00';
  const isFriday = now.getDay() === 5;
  const pulangTime = isFriday ? (document.getElementById('reminderPulangJumat')?.value || '16:30') : (document.getElementById('reminderPulangTime')?.value || '16:00');
  const [istH, istM] = istTime.split(':').map(Number);
  const [pH, pM] = pulangTime.split(':').map(Number);
  const targets = [{ h: istH, m: istM, type: 'ist' },{ h: pH, m: pM, type: 'pulang' }];
  let next = null;
  targets.forEach(t => { const target = new Date(); target.setHours(t.h, t.m, 0, 0); if (target > now && (!next || target < next.time)) next = { time: target, type: t.type }; });
  if (next) { const delay = next.time - now; reminderTimeout = setTimeout(() => { triggerReminder(next.type); scheduleNextReminder(); }, delay); }
}
function triggerReminder(type) {
    const messages = REMINDER_MESSAGES[type];
    const msg = messages[Math.floor(Math.random() * messages.length)];
    showBigReminder(type, msg);
    const label = type === 'ist' ? '⏰ ISTIRAHAT' : '🏠 PULANG';
    showNotification(`${label}: ${msg.substring(0, 50)}...`, type === 'ist' ? 'warning' : 'info');
    
    // ✅ PERBAIKAN: Paksa gunakan suara LAKI-LAKI ('male') untuk pengingat
    if (voiceSettings.enabled) {
        speak(msg, 'male'); 
    }
}
function showBigReminder(type, msg) {
  document.querySelectorAll('.big-reminder-overlay').forEach(el => el.remove());
  const overlay = document.createElement('div');
  overlay.className = 'big-reminder-overlay';
  overlay.style.cssText = `position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.7);backdrop-filter:blur(8px);z-index:99999;display:flex;align-items:center;justify-content:center;animation:fadeIn 0.3s ease;`;
  const colors = { ist: { bg: 'linear-gradient(135deg,#f59e0b,#d97706)', icon: 'fa-coffee', title: '⏰ WAKTU ISTIRAHAT' }, pulang: { bg: 'linear-gradient(135deg,#ec4899,#db2777)', icon: 'fa-home', title: '🏠 WAKTU PULANG' } };
  const c = colors[type];
  overlay.innerHTML = `<div style="background:white;border-radius:20px;padding:40px;max-width:500px;text-align:center;box-shadow:0 20px 60px rgba(0,0,0,0.5);animation:popIn 0.5s cubic-bezier(0.34,1.56,0.64,1);"><div style="width:100px;height:100px;margin:0 auto 20px;border-radius:50%;background:${c.bg};display:flex;align-items:center;justify-content:center;animation:pulse-reminder 2s infinite;"><i class="fas ${c.icon}" style="font-size:50px;color:white;"></i></div><h2 style="color:#1e293b;font-size:28px;margin-bottom:15px;font-weight:800;">${c.title}</h2><p style="color:#475569;font-size:16px;line-height:1.6;margin-bottom:25px;">${msg}</p><div style="font-size:12px;color:#94a3b8;margin-bottom:20px;"><i class="fas fa-clock"></i> ${new Date().toLocaleTimeString('id-ID')} WIB</div><button onclick="this.closest('.big-reminder-overlay').remove()" style="background:${c.bg};color:white;border:none;padding:12px 40px;border-radius:30px;font-size:14px;font-weight:700;cursor:pointer;box-shadow:0 4px 15px rgba(0,0,0,0.2);"><i class="fas fa-check"></i> Mengerti</button></div>`;
  document.body.appendChild(overlay);
  setTimeout(() => { if (overlay.parentNode) overlay.remove(); }, 30000);
}
function testReminder(type) { const msg = REMINDER_MESSAGES[type][0]; showBigReminder(type, msg); showNotification(`🧪 Test pengingat ${type === 'ist' ? 'istirahat' : 'pulang'}`, 'info'); if (voiceSettings.enabled) speak(msg, voiceSettings.paymentGender); }

// ============================================
// 5. ROUTING & ELEVATION
// ============================================
function getIndonesianInstruction(step) {
  const type = step.maneuver.type;
  const modifier = step.maneuver.modifier || '';
  const name = step.name || '';
  const road = (name && name !== 'road' && name !== 'path' && name !== 'residential') ? name : 'jalan ini';
  switch (type) {
    case 'depart': return `Berangkat dari lokasi Anda`;
    case 'arrive': return `Anda telah sampai di tujuan`;
    case 'turn':
      if (modifier === 'left') return `Belok kiri ke ${road}`;
      if (modifier === 'right') return `Belok kanan ke ${road}`;
      if (modifier === 'slight left') return `Belok agak ke kiri ke ${road}`;
      if (modifier === 'slight right') return `Belok agak ke kanan ke ${road}`;
      return `Belok ke ${road}`;
    case 'continue': case 'new name': return `Lurus terus di ${road}`;
    case 'roundabout': case 'rotary': return `Masuk bundaran, ambil keluaran ke ${road}`;
    case 'merge': return `Bergabung ke arah ${modifier} ke ${road}`;
    case 'fork':
      if (modifier === 'left') return `Ambil jalan kiri ke ${road}`;
      if (modifier === 'right') return `Ambil jalan kanan ke ${road}`;
      return `Ambil jalan di persimpangan ke ${road}`;
    case 'end of road':
      if (modifier === 'left') return `Akhir jalan, belok kiri ke ${road}`;
      if (modifier === 'right') return `Akhir jalan, belok kanan ke ${road}`;
      return `Akhir jalan, belok ke ${road}`;
    default: return `Lanjutkan ke ${road}`;
  }
}
async function showRouteTo(lat, lng, label = 'Tujuan') {
  showNotification('⏳ Memuat modul navigasi...', 'info');
  const ok = await ensureRoutingLoaded();
  if (!ok) return;
  getUserLocation((start) => {
    clearRoute(true);
    routeStartMarker = L.marker(start, { icon: L.divIcon({ className: 'custom-div-icon', html: `<div style="background:linear-gradient(135deg,#3b82f6,#2563eb);width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;border:3px solid white;box-shadow:0 2px 12px rgba(59,130,246,0.6);font-size:13px;"><i class="fas fa-location-arrow"></i></div>`, iconSize: [32, 32], iconAnchor: [16, 16] }) }).addTo(map).bindPopup(`<div style="text-align:center"><strong>📍 Lokasi Anda</strong><br><small>Titik awal navigasi</small></div>`);
    routeDestMarker = L.marker([lat, lng], { icon: L.divIcon({ className: 'custom-div-icon', html: `<div style="background:linear-gradient(135deg,#ef4444,#dc2626);width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;border:3px solid white;box-shadow:0 2px 12px rgba(239,68,68,0.6);font-size:13px;"><i class="fas fa-flag-checkered"></i></div>`, iconSize: [32, 32], iconAnchor: [16, 16] }) }).addTo(map);
    
    currentRouteControl = L.Routing.control({
      waypoints: [ L.latLng(start[0], start[1]), L.latLng(lat, lng) ],
      routeWhileDragging: false, showAlternatives: true, addWaypoints: false, draggableWaypoints: false, fitSelectedRoutes: true,
      lineOptions: { styles: [{ color: '#3b82f6', opacity: 0.95, weight: 6 },{ color: '#ffffff', opacity: 0.4, weight: 2 }] },
      altLineOptions: { styles: [{ color: '#94a3b8', opacity: 0.5, weight: 4, dashArray: '8,6' }] },
      createMarker: () => null,
      // ✅ PERBAIKAN: Gunakan 'en' untuk mencegah crash, tapi kita terjemahkan manual di bawah
      formatter: new L.Routing.Formatter({ language: 'en', units: 'metric' }),
      router: L.Routing.osrmv1({ serviceUrl: 'https://router.project-osrm.org/route/v1' })
    }).addTo(map);

    currentRouteControl.on('routesfound', function(e) {
      const route = e.routes[0];
      const jarakKm = (route.summary.totalDistance / 1000).toFixed(2);
      const waktuMenit = Math.ceil(route.summary.totalTime / 60);
      showNotification(`🗺️ Rute ke ${label}: ${jarakKm} km • ±${waktuMenit} menit`, 'success');
      const container = document.querySelector('.leaflet-routing-container');
      if (container) {
        let html = `<div class="route-summary-box"><i class="fas fa-route"></i> ${jarakKm} km • ±${waktuMenit} menit</div>`;
        html += `<div style="margin-top:10px; font-weight:700; color:#1e293b; margin-bottom:8px; font-size:13px;">📋 Petunjuk Arah:</div>`;
        let ttsText = `Rute ke ${label}. Jarak ${jarakKm} kilometer, estimasi waktu ${waktuMenit} menit. `;
        if (route.legs && route.legs[0] && route.legs[0].steps) {
          route.legs[0].steps.forEach((step) => {
            if (step.maneuver.type === 'depart' || step.maneuver.type === 'arrive') return;
            const instruction = getIndonesianInstruction(step);
            const distText = step.distance > 1000 ? (step.distance/1000).toFixed(1) + ' km' : Math.round(step.distance) + ' m';
            let icon = 'fa-arrow-up';
            if (step.maneuver.modifier && step.maneuver.modifier.includes('left')) icon = 'fa-arrow-turn-up fa-rotate-270';
            if (step.maneuver.modifier && step.maneuver.modifier.includes('right')) icon = 'fa-arrow-turn-up fa-rotate-90';
            if (step.maneuver.type === 'roundabout' || step.maneuver.type === 'rotary') icon = 'fa-circle-notch';
            html += `<div class="turn-direction"><i class="fas ${icon}"></i><span>${instruction}</span><span class="distance">${distText}</span></div>`;
            ttsText += `${instruction}. `;
          });
        }
        html += `<button class="elevation-btn" onclick="showElevationProfile()"><i class="fas fa-chart-area"></i> Lihat Profil Elevasi</button>`;
        html += `<button class="elevation-btn" onclick="speakRouteInstructions()" style="background:linear-gradient(135deg,#8b5cf6,#7c3aed)"><i class="fas fa-volume-up"></i> Bacakan Petunjuk</button>`;
        container.innerHTML = html;
        window.currentRouteTTS = ttsText;
        window.currentRouteCoords = route.coordinates;
      }
      map.flyTo([lat, lng], 16, { duration: 1.2 });
    });
    currentRouteControl.on('routingerror', function() { showNotification('❌ Gagal menghitung rute. Coba lagi.', 'warning'); clearRoute(); });
    const btn = document.getElementById('clearRouteBtn');
    if (btn) btn.style.display = 'flex';
  });
}
async function ensureRoutingLoaded() {
  if (routingLoaded) return true;
  return new Promise((resolve) => {
    const link = document.createElement('link'); link.rel = 'stylesheet'; link.href = 'https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css'; document.head.appendChild(link);
    const script = document.createElement('script'); script.src = 'https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.min.js';
    script.onload = () => { routingLoaded = true; resolve(true); };
    script.onerror = () => { showNotification('❌ Gagal memuat routing', 'warning'); resolve(false); };
    document.head.appendChild(script);
  });
}
function getUserLocation(callback) {
  // ✅ KOORDINAT PRESISI KANTOR UNIT DARMARAJA
  const DARMAKOORDINAT = [-6.917821785545315, 108.07163674919619];
  
  // Directly bypass geolocation for Kiosk mode to ensure routing starts from the office
  userLocation = DARMAKOORDINAT;
  
  if (typeof callback === 'function') {
    callback(userLocation);
  }
}
function clearRoute(silent = false) {
  // ✅ PERBAIKAN: Tambahkan pengecekan null/undefined
  if (currentRouteControl && typeof currentRouteControl.remove === 'function') {
    try { map.removeControl(currentRouteControl); } catch(e) {}
    currentRouteControl = null;
  }
  if (routeStartMarker && typeof routeStartMarker.remove === 'function') {
    try { map.removeLayer(routeStartMarker); } catch(e) {}
    routeStartMarker = null;
  }
  if (routeDestMarker && typeof routeDestMarker.remove === 'function') {
    try { map.removeLayer(routeDestMarker); } catch(e) {}
    routeDestMarker = null;
  }
  if (elevationControl && typeof elevationControl.remove === 'function') {
    try { map.removeControl(elevationControl); } catch(e) {}
    elevationControl = null;
  }
  const btn = document.getElementById('clearRouteBtn');
  if (btn) btn.style.display = 'none';
  if (!silent) showNotification('🗑️ Rute dihapus', 'info');
}

function showElevationProfile() {
  if (!window.currentRouteCoords || !window.currentRouteCoords.length) {
    showNotification('❌ Tidak ada data rute', 'warning');
    return;
  }
  
  // ✅ PERBAIKAN: Toggle hapus control jika tombol diklik ulang
  if (elevationControl && typeof elevationControl.remove === 'function') {
    try { map.removeControl(elevationControl); } catch(e) {}
    elevationControl = null;
    return;
  }
  
  // Inisialisasi control elevasi
  try {
    elevationControl = L.control.elevation({
      position: "bottomleft",
      theme: "lightblue-theme",
      width: 400,
      height: 125,
      margins: { top: 10, right: 20, bottom: 25, left: 40 },
      useHeightIndicator: true,
      interpolation: "curveLinear",
      hoverNumber: { decimalsX: 2, decimalsY: 0 },
      detached: false,
      elevationDiv: null
    }).addTo(map);
    
    const lineCoords = window.currentRouteCoords.map((c, index) => [
      c.lng,
      c.lat,
      c.alt !== undefined ? c.alt : (c.elevation !== undefined ? c.elevation : 100 + (index % 50) * 2)
    ]);
    
    const geojson = {
      type: 'Feature',
      properties: {},
      geometry: {
        type: 'LineString',
        coordinates: lineCoords
      }
    };
    
    elevationControl.addData(geojson);
    showNotification('📈 Profil elevasi ditampilkan', 'info');
  } catch(e) {
    console.error('❌ Error menampilkan elevasi:', e);
    showNotification('❌ Gagal menampilkan elevasi', 'warning');
  }
}
function speakRouteInstructions() { if (window.currentRouteTTS) { showNotification('🔊 Membacakan petunjuk arah...', 'info'); speak(window.currentRouteTTS, 'female'); } }
function goToLocation(lat, lng, zoom = 17, options = {}) {
  if (!map || isNaN(lat) || isNaN(lng)) { showNotification('❌ Koordinat tidak valid', 'warning'); return false; }
  map.flyTo([lat, lng], zoom, { duration: 1.2 });
  if (options.openPopup && options.markerId) { setTimeout(() => { const m = markerLayers[options.markerId] || pelangganLayers[options.markerId]?.marker; if (m) m.openPopup(); }, 1200); }
  return true;
}

// ============================================
// 6. AUDIO UNLOCK & YOUTUBE
// ============================================
function initAudioUnlock() {
  const unlockHandler = () => {
    if (audioUnlocked) return;
    audioUnlocked = true;
    console.log('🔓 Audio unlocked');
    if ('speechSynthesis' in window) { const u = new SpeechSynthesisUtterance(' '); u.volume = 0; speechSynthesis.speak(u); setTimeout(() => speechSynthesis.cancel(), 100); }
    const audioEl = document.getElementById('backgroundMusic');
    if (audioEl && audioEl.src && audioEl.src !== window.location.href) audioEl.play().catch(() => {});
    document.removeEventListener('click', unlockHandler);
    document.removeEventListener('touchstart', unlockHandler);
    document.removeEventListener('keydown', unlockHandler);
  };
  document.addEventListener('click', unlockHandler, { once: false });
  document.addEventListener('touchstart', unlockHandler, { once: false });
  document.addEventListener('keydown', unlockHandler, { once: false });
}
function extractYouTubeId(url) { const m = url.match(/^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/); return (m && m[2].length === 11) ? m[2] : null; }
function loadYouTube() {
  const url = document.getElementById('youtubeUrl').value.trim();
  if (!url) { showNotification('❌ Paste link YouTube dulu', 'warning'); return; }
  const videoId = extractYouTubeId(url);
  if (!videoId) { showNotification('❌ Link tidak valid', 'warning'); return; }
  if (!window.YT) {
    showNotification('⏳ Memuat YouTube...', 'info');
    const tag = document.createElement('script'); tag.src = 'https://www.youtube.com/iframe_api';
    tag.onload = () => { const checkReady = setInterval(() => { if (window.YT && window.YT.Player) { clearInterval(checkReady); isYoutubeReady = true; createYouTubePlayer(videoId); } }, 100); };
    document.head.appendChild(tag);
  } else { createYouTubePlayer(videoId); }
}
function createYouTubePlayer(videoId) {
  if (youtubePlayer) { try { youtubePlayer.destroy(); } catch(e) {} }
  document.getElementById('youtubePlayerContainer').innerHTML = '<div id="ytPlayer"></div>';
  youtubePlayer = new YT.Player('ytPlayer', { height: '1', width: '1', videoId: videoId, playerVars: { autoplay: 1, controls: 0, loop: 1, playlist: videoId }, events: { onReady: (e) => { e.target.setVolume(document.getElementById('youtubeVolumeSlider')?.value || 50); e.target.playVideo(); showNotification('🎵 Musik diputar', 'success'); }, onError: () => showNotification('❌ Video tidak bisa diputar', 'warning') } });
}
function stopYouTube() { if (youtubePlayer && typeof youtubePlayer.stopVideo === 'function') { try { youtubePlayer.stopVideo(); youtubePlayer.destroy(); } catch(e) {} } youtubePlayer = null; document.getElementById('youtubePlayerContainer').innerHTML = ''; showNotification('⏹️ YouTube dihentikan', 'info'); }
function setYouTubeVolume(v) { document.getElementById('youtubeVolumeValue').textContent = v + '%'; if (youtubePlayer && typeof youtubePlayer.setVolume === 'function') youtubePlayer.setVolume(parseInt(v)); }

// ============================================
// 7. MUTE LIVE & CIRCULAR PROGRESS
// ============================================
function toggleMuteLive() { isLiveMuted = !isLiveMuted; syncMuteUI(); }
function syncMuteUI() {
  const btn = document.getElementById('btnMuteLive'); const statusDot = document.getElementById('muteLiveStatusDot'); const statusText = document.getElementById('muteLiveStatusText');
  if (!btn) return;
  if (isLiveMuted) { btn.style.background = 'linear-gradient(135deg,#10b981,#059669)'; btn.innerHTML = '<i class="fas fa-volume-mute"></i> <span id="muteLiveText">Unmute Suara Live</span>'; if (statusDot) statusDot.className = 'voice-status-dot paused'; if (statusText) statusText.textContent = 'Suara Live Dimatikan'; }
  else { btn.style.background = 'linear-gradient(135deg,#ef4444,#dc2626)'; btn.innerHTML = '<i class="fas fa-volume-up"></i> <span id="muteLiveText">Mute Suara Live</span>'; if (statusDot) statusDot.className = 'voice-status-dot active'; if (statusText) statusText.textContent = 'Suara Live Aktif'; }
}
function initAutoLive() { isLiveMuted = true; syncMuteUI(); if (unpaidCustomerList.length > 0) { startLiveCycle(); showNotification('🔴 LIVE aktif otomatis — suara mute, klik Unmute di Panel Suara untuk mengaktifkan', 'live'); } }
function updateCircularProgress(percentage) {
  const fill = document.getElementById('circularProgressFill'); const dot = document.getElementById('circularDot'); const pctEl = document.getElementById('circularPercentage');
  if (!fill) return;
  let main, light, glow;
  if (percentage < 40) { main = '#ef4444'; light = '#fca5a5'; glow = '239,68,68'; }
  else if (percentage < 70) { main = '#f59e0b'; light = '#fde68a'; glow = '245,158,11'; }
  else { main = '#10b981'; light = '#a7f3d0'; glow = '16,185,129'; }
  const stops = document.querySelectorAll('#progressGradient stop');
  if (stops.length >= 3) { stops[0].style.stopColor = light; stops[1].style.stopColor = main; stops[2].style.stopColor = light; }
  fill.style.filter = `drop-shadow(0 0 8px rgba(${glow},0.8))`;
  if (pctEl) { pctEl.style.color = light; pctEl.style.textShadow = `0 0 10px rgba(${glow},0.9), 0 0 22px rgba(${glow},0.6), 0 2px 3px rgba(0,0,0,0.9)`; }
  if (dot) { dot.style.background = light; dot.style.boxShadow = `0 0 8px rgba(${glow},1), 0 0 18px rgba(${glow},0.7)`; const r = (dot.closest('.circular-progress-wrapper').offsetWidth / 2) * 0.9; dot.style.transform = `rotate(${percentage * 3.6}deg) translateY(-${r}px)`; }
  const C = 2 * Math.PI * 45; fill.style.strokeDasharray = C; fill.style.strokeDashoffset = C - (percentage / 100) * C;
  animateCounter(displayedPct, percentage, 2000); displayedPct = percentage;
}
function animateCounter(from, to, duration) {
  const el = document.getElementById('circularPercentage'); if (!el) return;
  const start = performance.now();
  function frame(now) { const t = Math.min((now - start) / duration, 1); const eased = 1 - Math.pow(1 - t, 3); el.textContent = (from + (to - from) * eased).toFixed(1) + '%'; if (t < 1) requestAnimationFrame(frame); }
  requestAnimationFrame(frame);
}

// ============================================
// 8. REVENUE & TODAY STATS
// ============================================
function calculateMonthlyRevenue() {
  const now = new Date(); const currentDay = now.getDate(); const daysInMonth = new Date(now.getFullYear(), now.getMonth() + 1, 0).getDate(); const remainingDays = daysInMonth - currentDay;
  let totalTarget = 0, totalCollected = 0, totalUnpaidWithPenalty = 0, totalKubikasiTarget = 0, totalKubikasiCollected = 0;
  pelangganDataFromLaravel.forEach(p => {
    const jumlah = parseFloat(p.jumlah) || 0; const kubikasi = parseFloat(p.pakai) || 0;
    const hasLoket = p.tanggal_pembayaran_loket && !['-','.','',null].includes(p.tanggal_pembayaran_loket);
    const hasPPOB = p.tanggal_pembayaran_ppob && !['-','.','',null].includes(p.tanggal_pembayaran_ppob);
    totalKubikasiTarget += kubikasi;
    if (hasLoket || hasPPOB) { totalCollected += jumlah; totalKubikasiCollected += kubikasi; }
    else { let tagihan = jumlah; if (currentDay > 20) tagihan += 5000; if (jumlah > 1000000) tagihan += 10000; totalUnpaidWithPenalty += tagihan; }
    totalTarget += jumlah;
  });
  return { totalTarget, totalCollected, totalUnpaidWithPenalty, percentage: totalTarget > 0 ? (totalCollected / totalTarget) * 100 : 0, currentDay, daysInMonth, remainingDays, dailyTarget: remainingDays > 0 ? totalUnpaidWithPenalty / remainingDays : 0, totalKubikasiTarget, totalKubikasiCollected };
}
// GANTI dengan versi super ringan ini:
function updateRevenueDisplay() {
    // Langsung update tanpa perlu hashing array yang berat
    updateRevenueProgress();
    updateTodayStatsDisplay();
}
function updateRevenueProgress() {
    const stats = calculateMonthlyRevenue(); 
    updateCircularProgress(stats.percentage);
    
    document.getElementById('currentDayOfMonth').textContent = stats.currentDay; 
    document.getElementById('remainingDays').textContent = stats.remainingDays;
    document.getElementById('targetRevenue').textContent = formatRupiah(stats.totalTarget) + ' || ' + stats.totalKubikasiTarget.toFixed(1) + ' M³';
    document.getElementById('collectedRevenue').textContent = formatRupiah(stats.totalCollected) + ' || ' + stats.totalKubikasiCollected.toFixed(1) + ' M³';
    document.getElementById('remainingRevenue').textContent = formatRupiah(stats.totalUnpaidWithPenalty); 
    document.getElementById('dailyTarget').textContent = formatRupiah(stats.dailyTarget);
    
    renderWilayahProgress();

    // ✅ LOGIKA BARU: Cek Jam 1 Siang (13:00) & Progres > 85%
    const now = new Date();
    const currentDateStr = now.toDateString(); // Contoh: "Mon Aug 31 2026"
    const currentHour = now.getHours();        // 13 = jam 1 siang

    // 1. Reset flag jika hari sudah berganti
    if (lastSpokenDate !== currentDateStr) {
        hasSpokenDailyProgress = false;
        lastSpokenDate = currentDateStr;
    }

    // 2. Cek kondisi: Jam >= 13, belum dibacakan hari ini, DAN progres >= 85%
    if (currentHour >= 13 && !hasSpokenDailyProgress && stats.percentage >= 85.0) {
        hasSpokenDailyProgress = true; // Tandai sudah dibacakan hari ini (anti-spam)
        setTimeout(() => narrateProgressUpdate(stats), 1500); // Delay 1.5 detik agar UI stabil
    }
}
function calculateWilayahProgress() {
  const mapWil = {};
  pelangganDataFromLaravel.forEach(p => {
    const w = p.nama_wilayah || 'Tidak Diketahui';
    if (!mapWil[w]) mapWil[w] = { target: 0, collected: 0, count: 0, paid: 0 };
    mapWil[w].target += parseFloat(p.jumlah) || 0; mapWil[w].count++;
    if (getPaymentStatus(p).status !== 'Belum Bayar') { mapWil[w].collected += parseFloat(p.jumlah) || 0; mapWil[w].paid++; }
  });
  return mapWil;
}
function renderWilayahProgress() {
  const grid = document.getElementById('wilayahProgressGrid'); if (!grid) return;
  const C = 2 * Math.PI * 26; let html = '';
  Object.entries(calculateWilayahProgress()).sort((a, b) => (b[1].collected / (b[1].target || 1)) - (a[1].collected / (a[1].target || 1))).forEach(([wilayah, d]) => {
    const pct = d.target > 0 ? (d.collected / d.target) * 100 : 0;
    const color = pct < 40 ? '#ef4444' : pct < 70 ? '#f59e0b' : '#10b981';
    const offset = C - (pct / 100) * C;
    html += `<div class="wilayah-ring-card" onclick="focusOnWilayah('${wilayah.replace(/'/g, "\\'")}')"><div class="wilayah-ring-wrapper"><svg width="52" height="52" viewBox="0 0 60 60"><circle cx="30" cy="30" r="26" fill="none" stroke="rgba(255,255,255,0.15)" stroke-width="6"/><circle cx="30" cy="30" r="26" fill="none" stroke="${color}" stroke-width="6" stroke-linecap="round" stroke-dasharray="${C}" stroke-dashoffset="${C}" data-offset="${offset}" transform="rotate(-90 30 30)" style="transition: stroke-dashoffset 1.5s ease;"/></svg><div class="wilayah-ring-pct" style="color:${color}">${pct.toFixed(0)}%</div></div><div class="wilayah-ring-name">${wilayah}</div><div class="wilayah-ring-detail">${d.paid}/${d.count} lunas</div></div>`;
  });
  grid.innerHTML = html; setTimeout(() => { grid.querySelectorAll('circle[data-offset]').forEach(c => c.style.strokeDashoffset = c.getAttribute('data-offset')); }, 150);
}
function calculateTodayStats() {
  const todayStr = new Date().toISOString().split('T')[0]; let totalToday = 0, countToday = 0, kubikasiToday = 0;
  pelangganDataFromLaravel.forEach(p => { const s = getPaymentStatus(p); if (s.tanggal) { const d = new Date(s.tanggal).toISOString().split('T')[0]; if (d === todayStr) { totalToday += parseFloat(p.jumlah) || 0; kubikasiToday += parseFloat(p.pakai) || 0; countToday++; } } });
  return { totalToday, countToday, kubikasiToday };
}
let lastTodayHash = '';
// ✅ VERSI RINGAN: Tanpa hashing array yang berat
function updateRevenueDisplay() {
    updateRevenueProgress();
}

let lastTodayUpdate = 0;
function updateTodayStatsDisplay() {
    // Hanya update maksimal 1x per menit untuk menghemat CPU
    const now = Date.now();
    if (now - lastTodayUpdate < 60000) return; 
    lastTodayUpdate = now;

    const stats = calculateTodayStats(); 
    const nowDate = new Date(); 
    const dateStr = nowDate.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
    const timeStr = nowDate.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', hour12: false });
    
    document.getElementById('today-date').innerHTML = `<div style="font-size:9px;opacity:0.85;">Pembayaran Hari Ini</div><div style="font-size:11px;font-weight:700;">${dateStr}</div><div style="font-size:10px;opacity:0.9;"><i class="fas fa-clock"></i> ${timeStr} WIB</div>`;
    document.getElementById('today-amount').textContent = formatRupiah(stats.totalToday) + ' || M³ ' + stats.kubikasiToday.toFixed(1);
    document.getElementById('today-count').textContent = stats.countToday; 
    document.getElementById('today-kubikasi').textContent = stats.kubikasiToday.toFixed(1);
}

// HAPUS BARIS INI JIKA ADA DI BAWAH: setInterval(updateTodayStatsDisplay, 6000);

// ============================================
// 9. VOICE SYSTEM
// ============================================
function isIndonesianVoice(voice) { if (!voice) return false; const lang = (voice.lang || '').toLowerCase(), name = (voice.name || '').toLowerCase(); if (lang.startsWith('id')) return true; return ID_KEYWORDS.some(k => name.includes(k)); }
function detectGender(voice) { if (!voice) return 'unknown'; const name = (voice.name || '').toLowerCase(); if (FEMALE_KEYWORDS.some(k => name.includes(k))) return 'female'; if (MALE_KEYWORDS.some(k => name.includes(k))) return 'male'; return 'unknown'; }
function loadVoices() { if (!('speechSynthesis' in window)) return; availableVoices = speechSynthesis.getVoices(); categorizeIndonesianVoices(); if (availableVoices.length === 0) speechSynthesis.onvoiceschanged = () => { availableVoices = speechSynthesis.getVoices(); categorizeIndonesianVoices(); }; }
function categorizeIndonesianVoices() {
  indonesianVoices = []; indonesianFemaleVoices = []; indonesianMaleVoices = [];
  availableVoices.forEach(v => { if (isIndonesianVoice(v)) { indonesianVoices.push(v); const g = detectGender(v); if (g === 'female') indonesianFemaleVoices.push(v); else if (g === 'male') indonesianMaleVoices.push(v); } });
  if (!indonesianVoices.length) indonesianVoices = [...availableVoices];
  if (!indonesianFemaleVoices.length) indonesianFemaleVoices = [...indonesianVoices];
  if (!indonesianMaleVoices.length) indonesianMaleVoices = [...indonesianVoices];
}
function speak(text, gender = 'female', callback) {
    if (!voiceSettings.enabled || !('speechSynthesis' in window)) { if (callback) callback(); return; }
    
    try { speechSynthesis.cancel(); } catch(e) {}
    
    const audioEl = document.getElementById('backgroundMusic'); 
    const wasPlaying = isMusicPlaying && !isMusicPaused; 
    const origVol = audioEl ? audioEl.volume : 0.3;
    if (wasPlaying && audioEl) audioEl.volume = Math.max(0.05, origVol * 0.3);

    // ✅ OPTIMASI: Langsung proses tanpa setTimeout bertumpuk
    const trySpeak = (retry = 0) => {
        if (availableVoices.length === 0 && retry < 10) { 
            setTimeout(() => trySpeak(retry + 1), 200); 
            return; 
        }
        
        try {
            const u = new SpeechSynthesisUtterance(text); 
            u.lang = 'id-ID';
            
            const idx = gender === 'female' ? voiceSettings.paymentVoiceIndex : voiceSettings.gangguanVoiceIndex;
            const pool = gender === 'female' ? indonesianFemaleVoices : indonesianMaleVoices;
            
            if (pool.length) u.voice = pool[idx % pool.length] || pool[0]; 
            else if (indonesianVoices.length) u.voice = indonesianVoices[0];
            
            const p = voiceProfiles[idx] || voiceProfiles[0]; 
            u.pitch = p.pitch; 
            u.rate = p.rate; 
            u.volume = voiceSettings.volume;
            
            u.onend = () => { if (wasPlaying && audioEl) audioEl.volume = origVol; if (callback) callback(); };
            u.onerror = () => { if (wasPlaying && audioEl) audioEl.volume = origVol; if (callback) callback(); };
            
            // ✅ LANGSUNG SPEAK (Tanpa delay 50ms)
            speechSynthesis.speak(u); 
        } catch(e) { 
            if (callback) callback(); 
        }
    };
    
    trySpeak();
}
function addToVoiceQueue(text, gender = 'female', callback = null) { voiceQueue.push({ text, gender, callback }); processVoiceQueue(); }
function processVoiceQueue() { if (isVoiceSpeaking || !voiceQueue.length) return; isVoiceSpeaking = true; const item = voiceQueue.shift(); speak(item.text, item.gender, () => { isVoiceSpeaking = false; if (item.callback) item.callback(); setTimeout(processVoiceQueue, 500); }); }
function clearVoiceQueue() { voiceQueue = []; isVoiceSpeaking = false; try { speechSynthesis.cancel(); } catch(e) {} }
function updateGangguanGender() { voiceSettings.gangguanGender = document.getElementById('gangguanGenderSelect').value; }
function updatePaymentGender() { voiceSettings.paymentGender = document.getElementById('paymentGenderSelect').value; }
function updateVoiceIndex() { voiceSettings.gangguanVoiceIndex = parseInt(document.getElementById('gangguanVoiceSelect').value); voiceSettings.paymentVoiceIndex = parseInt(document.getElementById('paymentVoiceSelect').value); }
function testVoice() { speak('Halo, ini test suara PDAM UP Darmaraja.', voiceSettings.paymentGender); }
function setVoiceVolume(v) { voiceSettings.volume = v / 100; document.getElementById('volumeValue').textContent = v + '%'; }
function toggleVoicePanel() { document.getElementById('voicePanel').classList.toggle('active'); }

// ============================================
// 10. MUSIC & GANGGUAN VOICE
// ============================================
function changeMusic() { const t = document.getElementById('musicSelect').value; if (!t) return; currentMusicType = t; const i = musicPlaylist.indexOf(t); if (i !== -1) currentPlaylistIndex = i; const a = document.getElementById('backgroundMusic'); a.src = musicFolder + t; a.load(); a.oncanplaythrough = () => { if (!isMusicPlaying) playMusic(); }; }
function playMusic() { const a = document.getElementById('backgroundMusic'); if (!a.src || a.src === window.location.href) { showNotification('❌ Pilih musik dulu', 'warning'); return; } a.volume = parseInt(document.getElementById('musicVolumeSlider').value) / 100; a.loop = false; a.onended = () => { if (autoRotateMusic) playNextTrack(); }; a.play().then(() => { isMusicPlaying = true; isMusicPaused = false; document.getElementById('btnPlayMusic').disabled = true; document.getElementById('btnStopMusic').disabled = false; }).catch(() => showNotification('❌ Klik halaman dulu', 'warning')); }
function playNextTrack() { currentPlaylistIndex = (currentPlaylistIndex + 1) % musicPlaylist.length; currentMusicType = musicPlaylist[currentPlaylistIndex]; const a = document.getElementById('backgroundMusic'); a.src = musicFolder + currentMusicType; a.load(); a.oncanplaythrough = () => a.play(); }
function pauseMusic() { const a = document.getElementById('backgroundMusic'); if (!isMusicPlaying) return; if (isMusicPaused) { a.play(); isMusicPaused = false; } else { a.pause(); isMusicPaused = true; } }
function stopMusic() { const a = document.getElementById('backgroundMusic'); a.pause(); a.currentTime = 0; isMusicPlaying = false; isMusicPaused = false; document.getElementById('btnPlayMusic').disabled = false; document.getElementById('btnStopMusic').disabled = true; }
function toggleLoopMusic() { autoRotateMusic = !autoRotateMusic; }
function setMusicVolume(v) { document.getElementById('backgroundMusic').volume = v / 100; document.getElementById('musicVolumeValue').textContent = v + '%'; }
function setScrollSpeed(v) { const duration = 210 - v; document.documentElement.style.setProperty('--scroll-duration', duration + 's'); const c = document.getElementById('notificationContent'); if (c) { c.style.animation = 'none'; c.offsetHeight; c.style.animation = `scroll-left ${duration}s linear infinite`; } let label = 'Normal'; if (v < 40) label = 'Sangat Lambat'; else if (v < 70) label = 'Lambat'; else if (v < 130) label = 'Cepat'; else label = 'Sangat Cepat'; document.getElementById('scrollSpeedValue').textContent = label; }
function formatGangguanVoiceText(g) { const kode = g.kode_laporan.split('').join(' '); const status = g.status === 'menunggu' ? 'Menunggu' : g.status === 'dalam_proses' ? 'Dalam Proses' : 'Selesai'; let lokasi = toTitleCase(cleanSpacedLetters(g.lokasi || '-').toLowerCase()); lokasi = convertRegionRomanToNumber(lokasi); let wilayah = toTitleCase(cleanSpacedLetters(g.wilayah_terdampak || '-').toLowerCase()); wilayah = convertRegionRomanToNumber(wilayah); return `Gangguan nomor ${kode}. Status: ${status}. Lokasi: ${lokasi}. Wilayah Terdampak: ${wilayah}. Ukuran pipa: ${g.ukuran_pipa || '-'}.`; }
function playGangguanVoiceLoop() { if (!isGangguanVoicePlaying || isGangguanVoicePaused) return; if (!activeGangguanList.length) { updateGangguanVoiceStatus('idle', 'Tidak ada gangguan'); return; } let idx = 0; (function playNext() { if (!isGangguanVoicePlaying || isGangguanVoicePaused) return; if (idx >= activeGangguanList.length) { if (repeatGangguanVoice) { idx = 0; setTimeout(playNext, 2000); } else stopGangguanVoice(); return; } updateGangguanVoiceStatus('playing', `Memutar: ${activeGangguanList[idx].kode_laporan}`); addToVoiceQueue(formatGangguanVoiceText(activeGangguanList[idx]), voiceSettings.gangguanGender, () => { idx++; setTimeout(playNext, 1500); }); })(); }
function playGangguanVoice() { if (!activeGangguanList.length) { showNotification('❌ Tidak ada gangguan aktif', 'warning'); return; } isGangguanVoicePlaying = true; isGangguanVoicePaused = false; updateGangguanVoiceStatus('playing', `Memutar ${activeGangguanList.length} gangguan`); updateGangguanVoiceButtons(); playGangguanVoiceLoop(); }
function pauseGangguanVoice() { if (!isGangguanVoicePlaying) return; isGangguanVoicePaused = !isGangguanVoicePaused; if (isGangguanVoicePaused) try { speechSynthesis.pause(); } catch(e){} else try { speechSynthesis.resume(); } catch(e){} updateGangguanVoiceStatus(isGangguanVoicePaused ? 'paused' : 'playing', isGangguanVoicePaused ? 'Dijeda' : 'Dilanjutkan'); updateGangguanVoiceButtons(); }
function stopGangguanVoice() { isGangguanVoicePlaying = false; isGangguanVoicePaused = false; try { speechSynthesis.cancel(); } catch(e){} updateGangguanVoiceStatus('idle', 'Dihentikan'); updateGangguanVoiceButtons(); }
function toggleRepeatGangguan() { repeatGangguanVoice = !repeatGangguanVoice; }
function updateGangguanVoiceStatus(s, t) { const d = document.getElementById('gangguanVoiceStatusDot'); d.className = 'voice-status-dot' + (s === 'playing' ? ' active' : s === 'paused' ? ' paused' : ''); document.getElementById('gangguanVoiceStatusText').textContent = t; }
function updateGangguanVoiceButtons() { const h = activeGangguanList.length > 0; document.getElementById('btnPlayGangguan').disabled = isGangguanVoicePlaying || !h; document.getElementById('btnStopGangguan').disabled = !isGangguanVoicePlaying && !isGangguanVoicePaused; }

// ============================================
// 11. PAYMENT VOICE & NARRATION
// ============================================
function playPaymentSequence() { if (!isPaymentVoicePlaying || isPaymentVoicePaused) return; if (currentPaymentIndex >= last5Payments.length) { if (repeatPaymentVoice) { currentPaymentIndex = 0; setTimeout(playPaymentSequence, 2000); } else stopPaymentVoice(); return; } const p = last5Payments[currentPaymentIndex]; updatePaymentVoiceStatus('playing', `Memutar: ${p.nama}`); const nama = formatNameForSpeech(p.nama); const metode = p.metode === 'PPOB' ? 'P. P. O. B.' : 'Kantor Unit Cabang'; const text = `Terima kasih kepada Yang Terhormat, ${nama}, telah melakukan pembayaran di ${metode}.`; addToVoiceQueue(text, voiceSettings.paymentGender, () => { currentPaymentIndex++; setTimeout(playPaymentSequence, 1500); }); }
function playLast5Payments() { if (!last5Payments.length) { showNotification('❌ Belum ada data pembayaran', 'warning'); return; } isPaymentVoicePlaying = true; isPaymentVoicePaused = false; currentPaymentIndex = 0; updatePaymentVoiceStatus('playing', `Memutar ${last5Payments.length} pembayaran`); updatePaymentVoiceButtons(); playPaymentSequence(); }
function pausePaymentVoice() { if (!isPaymentVoicePlaying) return; isPaymentVoicePaused = !isPaymentVoicePaused; if (isPaymentVoicePaused) try { speechSynthesis.pause(); } catch(e){} else try { speechSynthesis.resume(); } catch(e){} updatePaymentVoiceStatus(isPaymentVoicePaused ? 'paused' : 'playing', isPaymentVoicePaused ? 'Dijeda' : 'Dilanjutkan'); updatePaymentVoiceButtons(); }
function stopPaymentVoice() { isPaymentVoicePlaying = false; isPaymentVoicePaused = false; currentPaymentIndex = 0; try { speechSynthesis.cancel(); } catch(e){} updatePaymentVoiceStatus('idle', 'Dihentikan'); updatePaymentVoiceButtons(); }
function toggleRepeatPayment() { repeatPaymentVoice = !repeatPaymentVoice; }
function updatePaymentVoiceStatus(s, t) { const d = document.getElementById('paymentVoiceStatusDot'); d.className = 'voice-status-dot' + (s === 'playing' ? ' active' : s === 'paused' ? ' paused' : ''); document.getElementById('paymentVoiceStatusText').textContent = t; }
function updatePaymentVoiceButtons() { const h = last5Payments.length > 0; document.getElementById('btnPlayPayment').disabled = isPaymentVoicePlaying || !h; document.getElementById('btnStopPayment').disabled = !isPaymentVoicePlaying && !isPaymentVoicePaused; }
function generateDynamicNarration() { const n = []; n.push("Selamat datang di Sistem Monitoring PDAM Unit Pelaksana Darmaraja."); const total = pelangganDataFromLaravel.length; let kantor = 0, ppob = 0, belum = 0; pelangganDataFromLaravel.forEach(p => { const s = getPaymentStatus(p); if (s.status === 'Kantor') kantor++; else if (s.status === 'PPOB') ppob++; else belum++; }); n.push(`Saat ini kami melayani ${total} pelanggan. ${kantor} membayar di kantor, ${ppob} melalui PPOB, dan ${belum} belum membayar.`); const aktif = gangguanData.filter(g => g.status !== 'selesai').length; n.push(aktif > 0 ? `Terdapat ${aktif} gangguan aktif.` : 'Seluruh jaringan beroperasi normal.'); const stats = calculateMonthlyRevenue(); n.push(`Progres pendapatan bulan ini ${stats.percentage.toFixed(1)} persen, terkumpul ${formatRupiah(stats.totalCollected)} dari target ${formatRupiah(stats.totalTarget)}.`); return n; }
function narrateUnitProfile() { if (isNarrating) { isNarrating = false; clearVoiceQueue(); showNotification('❌ Narasi dihentikan', 'info'); return; } isNarrating = true; currentNarrationIndex = 0; if (isLiveDashboardActive) stopLiveCycle(); const narrations = generateDynamicNarration(); (function playNext() { if (!isNarrating || currentNarrationIndex >= narrations.length) { isNarrating = false; showNotification('✅ Narasi selesai', 'success'); return; } speak(narrations[currentNarrationIndex], voiceSettings.paymentGender, () => { currentNarrationIndex++; setTimeout(playNext, 800); }); })(); }

// ============================================
// 12. REALTIME POLLING & PAYMENT HANDLER (ANTI-SPAM)
// ============================================
function startRealtimePolling() { initializePaymentTimestamps(); realtimePollingInterval = setInterval(checkNewPayments, POLLING_INTERVAL); setTimeout(checkNewPayments, 1500); }
function initializePaymentTimestamps() { pelangganDataFromLaravel.forEach(p => { const s = getPaymentStatus(p); if (s.tanggal) lastKnownPaymentTimestamps[p.no_pelanggan] = s.tanggal; }); isFirstLoad = false; }
// ============================================
// REALTIME POLLING (VERSI RINGAN & CEPAT)
// ============================================
// ============================================
// 1. GLOBAL STATE & CACHE ANTI-SPAM
// ============================================
if (typeof window.processedPaymentKeys === 'undefined') {
    window.processedPaymentKeys = new Set();
}
// ============================================
// 1. FUNGSI PEMBERSIH TEKS SUPER (SEMUA DALAM 1)
// ============================================
// ============================================
// FUNGSI PEMBERSIH TEKS (ANTI DUPLIKASI & SALAH BACA)
// ============================================
function sanitizeTextForTTS(text) {
    // 1. Cek data kosong
    if (!text || text === '-' || String(text).toLowerCase() === 'null' || String(text).toLowerCase() === 'undefined') {
        return '';
    }
    
    let clean = String(text).trim();
    
    // 2. Hapus karakter slash (\ atau /)
    clean = clean.replace(/[\\\/]/g, ' ');
    
    // 3. Perbaiki singkatan
    clean = clean.replace(/\bKp\.?\b/gi, 'Kampung');
    clean = clean.replace(/\bH\.?\b/gi, 'Haji');
    clean = clean.replace(/\bHj\.?\b/gi, 'Hajah');
    clean = clean.replace(/\bJl\.?\b/gi, 'Jalan');
    clean = clean.replace(/\bNo\.?\b/gi, 'Nomor');
    clean = clean.replace(/\bRT\b/gi, 'Er Te');
    clean = clean.replace(/\bRW\b/gi, 'Er We');
    
    // 4. Gabungkan huruf spasi (A J A -> AJA)
    clean = clean.replace(/\b([A-Za-z])\s+(?=[A-Za-z]\b)/g, '$1');
    
    // 5. Ubah ke lowercase lalu Title Case
    clean = clean.toLowerCase().replace(/\b\w/g, char => char.toUpperCase());
    
    // 6. ✅ PERBAIKAN: Hapus duplikasi "Wilayah Wilayah" -> "Wilayah"
    clean = clean.replace(/\bWilayah\s+Wilayah\b/gi, 'Wilayah');
    
    // 7. Perbaiki Romawi ke Angka
    clean = clean.replace(/\bWilayah\s+IV\b/gi, 'Wilayah 4')
                 .replace(/\bWilayah\s+III\b/gi, 'Wilayah 3')
                 .replace(/\bWilayah\s+II\b/gi, 'Wilayah 2')
                 .replace(/\bWilayah\s+I\b/gi, 'Wilayah 1');
    
    // 8. Bersihkan spasi ganda
    return clean.replace(/\s+/g, ' ').trim();
}
// ============================================
// 2. REALTIME POLLING (HANYA AMBIL 1 TERBARU)
// ============================================
async function checkNewPayments() {
    // ✅ CEK GUARD: Jika request sebelumnya belum selesai, skip agar tidak menumpuk
    if (isFetchingPayments) return;
    isFetchingPayments = true;

    try {
        const res = await fetch(API_REALTIME_URL + '?t=' + Date.now());
        if (!res.ok) return;
        const result = await res.json();
        if (!result.success || !result.pelanggan) return;

        const newPayments = [];
        result.pelanggan.forEach(p => {
            const mapped = {
                no_pelanggan: p.no_pelanggan || p.no_rekening || '-',
                nama: p.nama || 'Tanpa Nama',
                jumlah: p.jumlah || '0',
                pakai: p.pakai || '0',
                kode_gol_trf: p.kode_gol_trf || '-',
                nama_wilayah: p.nama_wilayah || p.cabang || '-',
                koordinator: p.koordinator || '',
                tanggal_pembayaran_loket: p.tanggal_pembayaran_loket || null,
                tanggal_pembayaran_ppob: p.tanggal_pembayaran_ppob || null
            };
            const s = getPaymentStatus(mapped);
            if (s.tanggal) {
                const last = lastKnownPaymentTimestamps[mapped.no_pelanggan];
                if (!last || last !== s.tanggal) {
                    newPayments.push({ ...mapped, statusInfo: s, isNewPayment: !last });
                    lastKnownPaymentTimestamps[mapped.no_pelanggan] = s.tanggal;
                }
            }
        });

        if (newPayments.length && !isFirstLoad) {
            const trulyNewPayments = newPayments.filter(p => p.isNewPayment);
            if (trulyNewPayments.length > 0) {
                trulyNewPayments.sort((a, b) => new Date(b.statusInfo?.tanggal || 0) - new Date(a.statusInfo?.tanggal || 0));
                const singleLatestPayment = trulyNewPayments[0];
                
                // ✅ LANGSUNG BUNYIKAN SUARA (Prioritas Utama)
                handlePaymentReceived(singleLatestPayment);
                
                // Update UI di background
                setTimeout(() => { if (typeof updateRevenueDisplay === 'function') updateRevenueDisplay(); }, 100);
            }
        }
    } catch(e) {
        console.error('Polling error:', e);
    } finally {
        // ✅ BUKA KUNCI: Agar polling 2 detik berikutnya bisa jalan
        isFetchingPayments = false;
    }
}

function stopRealtimePolling() { 
    if (typeof realtimePollingInterval !== 'undefined' && realtimePollingInterval) { 
        clearInterval(realtimePollingInterval); 
        realtimePollingInterval = null; 
    } 
}

// ============================================
// 3. FUNGSI UTAMA PEMBAYARAN REALTIME (VERSI FINAL)
// ============================================
// ============================================
// FUNGSI PEMBAYARAN REALTIME (VERSI FINAL)
// ============================================
function handlePaymentReceived(pelanggan) {
    if (!pelanggan || typeof pelanggan !== 'object') return;

    // 1. Ekstraksi Data
    const namaRaw = pelanggan.nama || pelanggan.nama_pelanggan || '';
    const alamatRaw = pelanggan.nama_blok || pelanggan.alamat || '';
    const wilayahRaw = pelanggan.nama_wilayah || '';

    // 2. Sanitasi Teks
    const namaBersih = sanitizeTextForTTS(namaRaw);
    const alamatBersih = sanitizeTextForTTS(alamatRaw);
    const wilayahBersih = sanitizeTextForTTS(wilayahRaw);

    // 3. Anti-Spam Cache
    const idUnik = pelanggan.no_pelanggan || pelanggan.id || 'ID_UNKNOWN';
    const tanggalAtauJam = pelanggan.tanggal_pembayaran_loket || pelanggan.tanggal_pembayaran_ppob || Date.now();
    const paymentKey = `${idUnik}_${tanggalAtauJam}`.trim();

    if (window.processedPaymentKeys.has(paymentKey)) {
        console.log('⏳ Skip suara: Transaksi ini sudah dibacakan.');
        return;
    }
    window.processedPaymentKeys.add(paymentKey);
    if (window.processedPaymentKeys.size > 100) {
        window.processedPaymentKeys.delete(window.processedPaymentKeys.values().next().value);
    }

    // 4. Deteksi PPOB vs Kantor
    const metode = pelanggan?.statusInfo?.metode || (pelanggan.tanggal_pembayaran_ppob && pelanggan.tanggal_pembayaran_ppob !== '-' ? 'PPOB' : 'Kantor');
    const isPPOB = String(metode).toUpperCase() === 'PPOB';

    // 5. ✅ Susun Kalimat Suara (Hanya sebut data yang ada)
    let kalimatLokasi = '';
    if (alamatBersih && wilayahBersih) {
        kalimatLokasi = `, di ${alamatBersih}, ${wilayahBersih}`;
    } else if (alamatBersih) {
        kalimatLokasi = `, di ${alamatBersih}`;
    } else if (wilayahBersih) {
        kalimatLokasi = `,${wilayahBersih}`;
    }

    const namaFinal = namaBersih || 'Pelanggan';
    const sumber = isPPOB ? 'PPOB' : 'Kantor Unit Darmaraja';
    const pembuka = isPPOB ? 'INFO PPOB. ' : '';

    const fullMessage = `${pembuka}Pembayaran dari ${namaFinal}${kalimatLokasi}. Telah berhasil diterima melalui ${sumber}. Terima kasih.`;

    console.log(' Payment received:', fullMessage);

    // 6. Notifikasi Visual
    if (typeof showNotification === 'function') {
        showNotification(isPPOB ? `📲 INFO PPOB: ${namaFinal}` : `💰 Pembayaran: ${namaFinal}`, 'payment');
    }

    // 7. Eksekusi Suara (Langsung, tanpa delay)
    if (typeof speak === 'function') {
        speak(fullMessage, 'female');
    } else if ('speechSynthesis' in window) {
        const utterance = new SpeechSynthesisUtterance(fullMessage);
        utterance.lang = 'id-ID';
        utterance.rate = 1.0;
        speechSynthesis.speak(utterance);
    }
}

// ============================================
// 4. FUNGSI TEST (Untuk Debugging di Console)
// ============================================
function testPaymentNotification() {
    console.log('🧪 Testing pembayaran KANTOR...');
    window.isInitialLoadComplete = true;
    const dummy = { 
        no_pelanggan: 'TEST-KANTOR-' + Date.now(), 
        nama: 'A J A', 
        nama_blok: 'BLOK C3 / 12', 
        alamat: 'Jl. Raya Darmaraja No. 45', 
        nama_wilayah: 'WILAYAH I', 
        jumlah: '604800', 
        pakai: '71', 
        kode_gol_trf: 'RT.D', 
        statusInfo: { status: 'Kantor', color: '#10b981', icon: 'fa-building', tanggal: new Date().toISOString(), metode: 'Kantor' } 
    };
    handlePaymentReceived(dummy);
    if (typeof updateUIAfterPayment === 'function') updateUIAfterPayment(dummy);
}

function testPaymentPPOB() {
    console.log('🧪 Testing pembayaran PPOB...');
    window.isInitialLoadComplete = true;
    const dummy = { 
        no_pelanggan: 'TEST-PPOB-' + Date.now(), 
        nama: 'H. ACENG SUHANDI', 
        nama_blok: 'BLOK A2 / 07', 
        alamat: 'Kp. Cieunteung RT 02 RW 05', 
        nama_wilayah: 'WILAYAH III', 
        jumlah: '418600', 
        pakai: '52', 
        kode_gol_trf: 'RT.D', 
        statusInfo: { status: 'PPOB', color: '#f59e0b', icon: 'fa-mobile-alt', tanggal: new Date().toISOString(), metode: 'PPOB' } 
    };
    handlePaymentReceived(dummy);
    if (typeof updateUIAfterPayment === 'function') updateUIAfterPayment(dummy);
}
function updateUIAfterPayment(pelanggan) {
  const bar = document.getElementById('notificationBar'), content = document.getElementById('notificationContent'); if (!bar || !content) return;
  bar.style.display = 'block'; const metode = pelanggan.statusInfo?.metode === 'PPOB' ? 'PPOB' : 'Kantor'; const icon = metode === 'PPOB' ? 'fa-mobile-alt' : 'fa-building';
  const html = `<div class="notification-item new-payment"><strong>${pelanggan.nama}</strong> <span class="amount">${formatRupiah(pelanggan.jumlah)}</span> <span class="location"><i class="fas ${icon}"></i> ${metode}</span></div>`;
  content.innerHTML = html + html; content.style.animation = 'none'; content.offsetHeight; content.style.animation = `scroll-left ${getComputedStyle(document.documentElement).getPropertyValue('--scroll-duration')} linear infinite`;
}
function updateNotificationBar(payments) {
  const bar = document.getElementById('notificationBar'), content = document.getElementById('notificationContent'); if (!payments.length) { bar.style.display = 'none'; return; }
  bar.style.display = 'block'; last5Payments = payments.slice(0, 5); let html = '';
  payments.forEach(p => { html += `<div class="notification-item"><strong>${p.nama}</strong> <span class="amount">${formatRupiah(p.jumlah)}</span> <span class="location"><i class="fas fa-${p.lokasi === 'Kantor' ? 'building' : 'mobile-alt'}"></i> ${p.lokasi}</span></div>`; });
  content.innerHTML = html + html; updatePaymentVoiceButtons();
}
function calculateRevenue() {
  totalRevenue = 0; totalKubikasi = 0; let recent = [];
  pelangganDataFromLaravel.forEach(p => { const s = getPaymentStatus(p); if (s.status !== 'Belum Bayar') { totalRevenue += parseFloat(p.jumlah) || 0; totalKubikasi += parseFloat(p.pakai) || 0; if (s.tanggal) recent.push({ nama: p.nama || 'Pelanggan', jumlah: parseFloat(p.jumlah) || 0, kubikasi: parseFloat(p.pakai) || 0, lokasi: p.nama_wilayah || '-', tanggal: s.tanggal, metode: s.metode }); } });
  recent.sort((a, b) => new Date(b.tanggal) - new Date(a.tanggal)); updateNotificationBar(recent.slice(0, 10));
}
let hasSpokenAt88Percent = false;

function updateRevenueProgress() {
    const stats = calculateMonthlyRevenue(); 
    updateCircularProgress(stats.percentage);
    
    document.getElementById('currentDayOfMonth').textContent = stats.currentDay; 
    document.getElementById('remainingDays').textContent = stats.remainingDays;
    document.getElementById('targetRevenue').textContent = formatRupiah(stats.totalTarget) + ' || ' + stats.totalKubikasiTarget.toFixed(1) + ' M³';
    document.getElementById('collectedRevenue').textContent = formatRupiah(stats.totalCollected) + ' || ' + stats.totalKubikasiCollected.toFixed(1) + ' M³';
    document.getElementById('remainingRevenue').textContent = formatRupiah(stats.totalUnpaidWithPenalty); 
    document.getElementById('dailyTarget').textContent = formatRupiah(stats.dailyTarget);
    
    renderWilayahProgress();
    
    // ✅ HAPUS atau KOMENTARI baris berikut jika ada:
    // if (stats.percentage >= 85) narrateProgressUpdate(stats);
    // narrateProgressUpdate(stats);
}
// ============================================
// NARASI PROGRES HARIAN (JAM 1 SIANG, > 85%)
// ============================================
function narrateProgressUpdate(stats) {
    if (!voiceSettings.enabled) return;

    const pct = stats.percentage.toFixed(1);
    const daysPassed = stats.currentDay;
    const daysLeft = stats.remainingDays;

    let text = `Darmaraja tim yang hebat. `;
    text += `Saat ini progres pendapatan sudah mencapai ${pct} persen. `;
    text += `Jumlah hari berjalan ${daysPassed} hari. `;

    if (daysLeft > 0) {
        text += `Dengan estimasi sisa ${daysLeft} hari, ayo tingkatkan performa agar target tercapai. Semangat!`;
    } else {
        text += `Hari ini adalah hari terakhir bulan ini. Mari kita tutup bulan ini dengan hasil maksimal!`;
    }

    showNotification('📢 Membacakan update progres harian...', 'info');
    // ✅ Paksa suara LAKI-LAKI
    speak(text, 'male');
}

function startDailyProgressChecker() {
    // Jalankan pengecekan setiap 1 menit (60000 ms)
    setInterval(() => {
        const now = new Date();
        const currentDateStr = now.toDateString(); // Contoh: "Mon Aug 31 2026"
        const currentHour = now.getHours();        // 13 = jam 1 siang
        
        // 1. Reset kunci jika hari sudah berganti
        if (lastSpokenDate !== currentDateStr) {
            hasSpokenDailyProgress = false;
            lastSpokenDate = currentDateStr;
        }
        
        // 2. SYARAT MUTLAK 1: Jam harus >= 13 (1 Siang) DAN belum dibacakan hari ini
        if (currentHour >= 13 && !hasSpokenDailyProgress) {
            const stats = calculateMonthlyRevenue();
            
            // 3. SYARAT MUTLAK 2: Progres harus >= 85%
            if (stats.percentage >= 85.0) {
                hasSpokenDailyProgress = true; // ✅ KUNCI DITUTUP: Tidak akan bunyi lagi hari ini
                setTimeout(() => narrateProgressUpdate(stats), 1500);
                console.log("✅ Narasi progres dibacakan (Jam >= 13, Progres > 85%)");
            } else {
                console.log(`⏳ Jam sudah >= 13, tapi progres baru ${stats.percentage.toFixed(1)}%. Menunggu > 85%.`);
            }
        }
    }, 60000); // Cek setiap 1 menit
}
// ============================================
// 14. LIVE DASHBOARD & MAP LAYERS
// ============================================
function createUnpaidMarker(pelanggan, coords) { return L.marker(coords, { icon: L.divIcon({ className: 'custom-div-icon', html: `<div class="unpaid-marker-wrapper"><div class="unpaid-marker-label">${pelanggan.nama || '-'}</div><div class="unpaid-marker-pulse"></div><div class="unpaid-marker-pin"><i class="fas fa-exclamation"></i></div><div class="unpaid-marker-amount">${formatRupiah(pelanggan.jumlah)}</div></div>`, iconSize: [14, 14], iconAnchor: [7, 7], popupAnchor: [0, -10] }), zIndexOffset: 300 }); }
function loadUnpaidCustomerMarkers() {
  unpaidCustomerMarkers.forEach(m => map.removeLayer(m)); unpaidCustomerMarkers = []; unpaidCustomerList = [];
  pelangganDataFromLaravel.forEach(p => {
    if (getPaymentStatus(p).status !== 'Belum Bayar') return;
    const coords = parseKoordinator(p.koordinator); if (!coords || !isInArea(coords[0], coords[1])) return;
    const marker = createUnpaidMarker(p, coords); const wilayah = convertRegionRomanToNumber(p.nama_wilayah || '-');
    marker.bindPopup(`<div style="min-width:220px;"><div style="background:linear-gradient(135deg,#ef4444,#dc2626);color:white;padding:8px;border-radius:6px 6px 0 0;font-weight:700;">BELUM BAYAR</div><div style="padding:10px;"><strong>${p.nama}</strong><br>No: ${p.no_pelanggan}<br>Wilayah: ${wilayah}<div style="margin-top:8px;padding:8px;background:#fef2f2;border-radius:6px;"><strong style="color:#dc2626;">${formatRupiah(p.jumlah)}</strong></div><div style="margin-top:8px;"><button onclick="showRouteTo(${coords[0]},${coords[1]},'${(p.nama||'Pelanggan').replace(/'/g,"\\'")}')" style="width:100%;padding:6px;background:linear-gradient(135deg,#10b981,#059669);color:white;border:none;border-radius:5px;font-size:10px;cursor:pointer;font-weight:600;"><i class="fas fa-route"></i> Navigasi ke Lokasi</button></div></div></div>`);
    marker.addTo(map); unpaidCustomerMarkers.push(marker); unpaidCustomerList.push({ marker, coords, data: p, nama: p.nama || '-', jumlah: parseFloat(p.jumlah) || 0, wilayah });
  });
  document.getElementById('liveCounterTotal').textContent = unpaidCustomerList.length;
  if (!unpaidCustomerList.length && isLiveDashboardActive) { showNotification('✅ Semua sudah bayar', 'success'); stopLiveCycle(); }
}
function highlightUnpaidMarker(index) {
  if (index < 0 || index >= unpaidCustomerList.length) return;
  const c = unpaidCustomerList[index]; map.flyTo(c.coords, 18, { duration: 1.5 }); setTimeout(() => c.marker.openPopup(), 1500); updateLiveInfoPanel(c, index);
  if (voiceSettings.enabled && !isLiveMuted) {
    speak(`Pelanggan ${formatNameForSpeech(c.nama)}, belum membayar ${formatRupiah(c.jumlah)}.`, voiceSettings.paymentGender, () => { if (isLiveDashboardActive) { if (liveCycleInterval) clearTimeout(liveCycleInterval); liveCycleInterval = setTimeout(() => { liveCycleIndex = (liveCycleIndex + 1) % unpaidCustomerList.length; highlightUnpaidMarker(liveCycleIndex); }, 3000); } });
  } else if (isLiveDashboardActive) { if (liveCycleInterval) clearTimeout(liveCycleInterval); liveCycleInterval = setTimeout(() => { liveCycleIndex = (liveCycleIndex + 1) % unpaidCustomerList.length; highlightUnpaidMarker(liveCycleIndex); }, liveCycleSpeed); }
}
function updateLiveInfoPanel(c, i) { const p = document.getElementById('liveInfoPanel'); if (!p) return; p.style.display = 'flex'; document.getElementById('liveCustomerName').textContent = c.nama; document.getElementById('liveCustomerDetail').textContent = `${c.wilayah} • No. ${c.data.no_pelanggan}`; document.getElementById('liveCustomerAmount').textContent = formatRupiah(c.jumlah); document.getElementById('liveCounterCurrent').textContent = i + 1; document.getElementById('liveCounterTotal').textContent = unpaidCustomerList.length; }
function startLiveCycle() { if (!unpaidCustomerList.length) { showNotification('❌ Tidak ada pelanggan belum bayar', 'warning'); return; } isLiveDashboardActive = true; liveCycleIndex = 0; highlightUnpaidMarker(0); document.getElementById('btnLiveStart').disabled = true; document.getElementById('btnLiveStop').disabled = false; document.getElementById('liveBtn').classList.add('active'); document.getElementById('liveText').textContent = 'LIVE ON'; showNotification(`🔴 LIVE: ${unpaidCustomerList.length} pelanggan belum bayar`, 'live'); }
function stopLiveCycle() { if (liveCycleInterval) { clearTimeout(liveCycleInterval); liveCycleInterval = null; } isLiveDashboardActive = false; document.getElementById('btnLiveStart').disabled = false; document.getElementById('btnLiveStop').disabled = true; document.getElementById('liveBtn').classList.remove('active'); document.getElementById('liveText').textContent = 'LIVE OFF'; document.getElementById('liveInfoPanel').style.display = 'none'; map.flyTo([-6.88, 107.97], 14, { duration: 1 }); }
function toggleLiveDashboard() { isLiveDashboardActive ? stopLiveCycle() : startLiveCycle(); }
function setLiveSpeed(v) { liveCycleSpeed = v * 1000; document.getElementById('liveSpeedValue').textContent = v + ' detik'; }
function initBaseLayers() { baseLayers = { street: L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19, attribution: '© OpenStreetMap' }), satellite: L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', { maxZoom: 19, attribution: '© Esri' }), terrain: L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', { maxZoom: 17, attribution: '© OpenTopoMap' }), dark: L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', { maxZoom: 19, attribution: '© CARTO' }) }; }
function switchLayer(name) { if (!baseLayers[name]) return; if (currentBaseLayer) map.removeLayer(currentBaseLayer); currentBaseLayer = baseLayers[name]; currentBaseLayer.addTo(map); currentLayer = name; document.querySelectorAll('.layer-btn').forEach(b => b.classList.remove('active')); document.querySelector(`.layer-btn[data-layer="${name}"]`)?.classList.add('active'); }

// ============================================
// 15. MAP INITIALIZATION
// ============================================
function initMap() {
  const bounds = L.latLngBounds(L.latLng(-6.98, 107.80), L.latLng(-6.80, 108.15));
  map = L.map('map', { center: [-6.918, 108.074], zoom: 16, minZoom: 11, maxZoom: 18, maxBounds: bounds, maxBoundsViscosity: 0.8, zoomControl: false, preferCanvas: true,fadeAnimation: false,markerZoomAnimation: false});
  L.control.zoom({ position: 'topright' }).addTo(map);
  initBaseLayers(); currentBaseLayer = baseLayers[currentLayer]; currentBaseLayer.addTo(map);
  const polygon = [[-6.9584,108.0315],[-6.9421,108.0242],[-6.9315,108.0198],[-6.9202,108.0211],[-6.9110,108.0322],[-6.8985,108.0410],[-6.8842,108.0556],[-6.8810,108.0695],[-6.8892,108.0841],[-6.9011,108.0920],[-6.9154,108.0985],[-6.9320,108.0950],[-6.9488,108.0862],[-6.9595,108.0711],[-6.9680,108.0544],[-6.9642,108.0398],[-6.9584,108.0315]];
  L.polygon(polygon, { color: '#3b82f6', fillColor: '#3b82f6', fillOpacity: 0.1, weight: 3, dashArray: '10, 5' }).addTo(map);
  
  loadBangunan(); loadGangguan(); loadTitikPenting(); loadPelanggan(); loadZona();
  calculateRevenue(); loadUnpaidCustomerMarkers(); loadWilayahDanBlok();
  updateTodayStatsDisplay(); updateRevenueProgress();
  if (gangguanData.length) { activeGangguanList = gangguanData.filter(g => g.status !== 'selesai'); updateGangguanVoiceButtons(); }
  initSidebarAutoScroll(); setScrollSpeed(60);
  document.getElementById('searchResults').innerHTML = '<div class="search-empty">Ketik untuk mencari pelanggan</div>';
  
  startRealtimePolling();
  setTimeout(initAutoLive, 2000);
  initAudioUnlock();
  // setTimeout(() => { if (reminderEnabled) scheduleNextReminder(); }, 2000);
  // ✅ Auto aktifkan UI & Timer Pengingat 2 detik setelah peta dimuat
  setTimeout(() => { initReminderAutoActive(); },2000);
  // ✅ TANDAI LOAD SELESAI
  window.isInitialLoadComplete = true;
      // ✅ Auto aktifkan UI & Timer Pengingat 2 detik setelah peta dimuath
    // ✅ Aktifkan scheduler narasi progres harian jam 1 siang
    startDailyProgressChecker();
    
    // ✅ TANDAI LOAD SELESAI
    window.isInitialLoadComplete = true;
    console.log('✅ Initial load selesai - Suara realtime AKTIF untuk pembayaran BARU saja');

  // ✅ TAMBAHKAN INI: Tampilkan Elevasi Kantor saat pertama kali dimuat
  setTimeout(() => {
    // 1. Hapus kontrol elevasi lama jika ada (mencegah duplikat/error)
    if (typeof elevationControl !== 'undefined' && elevationControl) {
      try { map.removeControl(elevationControl); } catch(e) {}
      elevationControl = null;
    }
    
    // 2. Cari data bangunan dengan jenis 'kantor' dari database
    const kantor = bangunanData.find(b => b.jenis_bangunan === 'kantor' || (b.nama_bangunan && b.nama_bangunan.toLowerCase().includes('kantor')));
    
    // Fallback ke koordinat exact PC Anda jika data kantor belum ada di database
    let targetLat = -6.917821785545315; 
    let targetLng = 108.07163674919619;
    
    if (kantor && kantor.coordinates) {
      const coords = parseCoordinates(kantor.coordinates);
      if (coords && coords.length > 0) {
        targetLat = coords[0][0];
        targetLng = coords[0][1];
        console.log('✅ Menggunakan koordinat kantor dari database:', targetLat, targetLng);
      }
    } else {
      console.log('ℹ️ Tidak ada data "kantor" di DB, pakai koordinat default PC Anda');
    }
    
    // 3. Buat data rute dummy di sekitar lokasi target untuk memicu grafik elevasi
    window.currentRouteCoords = [
      { lng: targetLng - 0.0008, lat: targetLat - 0.0008, alt: 145 },
      { lng: targetLng - 0.0004, lat: targetLat - 0.0004, alt: 148 },
      { lng: targetLng, lat: targetLat, alt: 152 }, // Titik pusat kantor
      { lng: targetLng + 0.0004, lat: targetLat + 0.0004, alt: 148 },
      { lng: targetLng + 0.0008, lat: targetLat + 0.0008, alt: 145 }
    ];
    
    // 4. Panggil fungsi untuk menampilkan grafik elevasi di pojok kiri bawah peta
    showElevationProfile();
    
    // 5. Zoom otomatis ke lokasi kantor agar langsung terlihat jelas
    map.flyTo([targetLat, targetLng], 16, { duration: 1.5 });
    
    console.log('✅ Grafik elevasi kantor berhasil ditampilkan!');
  }, 2500); // ⏱️ Delay 2.5 detik agar peta dan library elevation siap sepenuhnya
}
function loadBangunan() { bangunanData.forEach(b => { try { const c = parseCoordinates(b.coordinates); if (!c || !c.length || !hasPointInArea(c)) return; const poly = L.polygon(c, { color: b.warna, fillColor: b.warna, fillOpacity: 0.25, weight: 2 }).addTo(map); const center = poly.getBounds().getCenter(); const icons = { reservoir: { i: 'fa-database', c: '#06b6d4' }, ipa: { i: 'fa-industry', c: '#8b5cf6' }, kantor: { i: 'fa-building', c: '#3b82f6' } }; const cfg = icons[b.jenis_bangunan] || { i: 'fa-building', c: '#6b7280' }; const m = L.marker(center, { icon: L.divIcon({ className: 'custom-div-icon', html: `<div style="background:${cfg.c};width:34px;height:34px;border-radius:8px;display:flex;align-items:center;justify-content:center;color:white;border:2px solid white;box-shadow:0 2px 8px rgba(0,0,0,0.3);"><i class="fas ${cfg.i}"></i></div>`, iconSize: [34, 34], iconAnchor: [17, 17] }) }).addTo(map); m.bindPopup(`<div style="min-width:180px;"><strong>${b.nama_bangunan}</strong><br>${b.jenis_bangunan}<div style="margin-top:8px;"><button onclick="showRouteTo(${center.lat},${center.lng},'${(b.nama_bangunan||'Bangunan').replace(/'/g,"\\'")}')" style="width:100%;padding:6px;background:linear-gradient(135deg,#8b5cf6,#7c3aed);color:white;border:none;border-radius:5px;font-size:10px;cursor:pointer;font-weight:600;"><i class="fas fa-route"></i> Navigasi ke Lokasi</button></div></div>`); markerLayers[`bangunan_${b.id}`] = m; } catch(e) {} }); }
function loadGangguan() { gangguanData.forEach(g => { try { const lat = parseFloat(g.latitude), lng = parseFloat(g.longitude); if (isNaN(lat) || isNaN(lng)) return; const colors = { menunggu: '#ef4444', dalam_proses: '#f59e0b', selesai: '#10b981' }; const c = colors[g.status] || '#ef4444'; const m = L.marker([lat, lng], { icon: L.divIcon({ className: 'custom-div-icon', html: `<div style="background:${c};width:40px;height:40px;border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;border:3px solid white;box-shadow:0 3px 10px rgba(0,0,0,0.4);font-size:16px;"><i class="fas fa-exclamation-triangle"></i></div>`, iconSize: [40, 40], iconAnchor: [20, 20] }) }).addTo(map); m.bindPopup(`<div style="min-width:200px;"><strong style="color:${c}">${g.kode_laporan}</strong><br>${g.lokasi || '-'}<br>Status: ${g.status}<div style="margin-top:8px;display:flex;gap:4px;"><button onclick="focusOnGangguan(${g.id})" style="flex:1;padding:6px;background:linear-gradient(135deg,#3b82f6,#2563eb);color:white;border:none;border-radius:5px;font-size:10px;cursor:pointer;font-weight:600;"><i class="fas fa-search-location"></i> Lihat</button><button onclick="showRouteTo(${lat},${lng},'Gangguan ${g.kode_laporan}')" style="flex:1;padding:6px;background:linear-gradient(135deg,#ef4444,#dc2626);color:white;border:none;border-radius:5px;font-size:10px;cursor:pointer;font-weight:600;"><i class="fas fa-route"></i> Rute</button></div></div>`); markerLayers[`gangguan_${g.id}`] = m; } catch(e) {} }); }
function loadTitikPenting() { titikPentingData.forEach(t => { try { const lat = parseFloat(t.latitude), lng = parseFloat(t.longitude); if (isNaN(lat) || isNaN(lng) || !isInArea(lat, lng)) return; const m = L.marker([lat, lng], { icon: L.divIcon({ className: 'custom-div-icon', html: `<div style="background:#3b82f6;width:24px;height:24px;border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;border:2px solid white;font-size:10px;"><i class="fas fa-map-pin"></i></div>`, iconSize: [24, 24], iconAnchor: [12, 12] }) }).addTo(map); m.bindPopup(`<strong>${t.nama_titik}</strong><br>${t.jenis_titik}`); markerLayers[`titik_${t.id}`] = m; } catch(e) {} }); }
function loadZona() { zonaData.forEach(z => { try { const coords = parseCoordinates(z.coordinates); if (!coords || !coords.length || !hasPointInArea(coords)) return; const polygon = L.polygon(coords, { color: z.warna || '#f59e0b', fillColor: z.warna || '#f59e0b', fillOpacity: 0.2, weight: 3, dashArray: '8, 5' }).addTo(map); zonaLayers[z.id] = { polygon }; } catch(e) {} }); }
function loadPelanggan() {
  if (!pelangganDataFromLaravel.length) return;
  pelangganClusterGroup = L.markerClusterGroup({ maxClusterRadius: 50, spiderfyOnMaxZoom: true, showCoverageOnHover: false, iconCreateFunction: function(cluster) { const count = cluster.getChildCount(); let color = '#3b82f6', size = 24; if (count > 50) { color = '#ef4444'; size = 30; } else if (count > 20) { color = '#f59e0b'; size = 27; } return L.divIcon({ html: `<div style="background:${color};color:white;width:${size}px;height:${size}px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:11px;border:3px solid white;">${count}</div>`, iconSize: L.point(size, size) }); } });
  pelangganDataFromLaravel.forEach(p => { const s = getPaymentStatus(p); if (s.status === 'Belum Bayar') return; const coords = parseKoordinator(p.koordinator); if (!coords || !isInArea(coords[0], coords[1])) return; const m = L.marker(coords, { icon: L.divIcon({ className: 'custom-div-icon', html: `<div class="pelanggan-marker-small" style="background:${s.color};"><i class="fas ${s.icon}" style="color:white;font-size:5px;"></i></div>`, iconSize: [10, 10], iconAnchor: [5, 5] }), zIndexOffset: 500 }); m.bindPopup(`<div style="min-width:200px;"><strong>${p.nama}</strong><br>No: ${p.no_pelanggan}<br>Status: <span style="color:${s.color};font-weight:700">${s.status}</span><br>Tagihan: ${formatRupiah(p.jumlah)}<div style="margin-top:8px;display:flex;gap:4px;"><button onclick="goToLocation(${coords[0]},${coords[1]},18,{markerId:'pelanggan_${p.no_pelanggan}',openPopup:true})" style="flex:1;padding:6px;background:linear-gradient(135deg,#3b82f6,#2563eb);color:white;border:none;border-radius:5px;font-size:10px;cursor:pointer;font-weight:600;"><i class="fas fa-search-location"></i> Lihat</button><button onclick="showRouteTo(${coords[0]},${coords[1]},'${(p.nama||'Pelanggan').replace(/'/g,"\\'")}')" style="flex:1;padding:6px;background:linear-gradient(135deg,#10b981,#059669);color:white;border:none;border-radius:5px;font-size:10px;cursor:pointer;font-weight:600;"><i class="fas fa-route"></i> Rute</button></div></div>`); pelangganClusterGroup.addLayer(m); pelangganLayers[`pelanggan_${p.no_pelanggan}`] = { marker: m, coords }; });
  map.addLayer(pelangganClusterGroup);
}
function loadWilayahDanBlok() {
  const container = document.getElementById('wilayah-blok-container');
  try {
    const wilayahMap = {};
    pelangganDataFromLaravel.forEach(p => { const w = p.nama_wilayah || 'Tidak Diketahui'; if (!wilayahMap[w]) wilayahMap[w] = { count: 0, status: { Kantor: 0, PPOB: 0, 'Belum Bayar': 0 } }; wilayahMap[w].count++; const s = getPaymentStatus(p); wilayahMap[w].status[s.status] = (wilayahMap[w].status[s.status] || 0) + 1; });
    let html = '';
    Object.entries(wilayahMap).sort((a, b) => b[1].count - a[1].count).forEach(([w, d]) => { html += `<div class="wilayah-card"><div class="wilayah-header" onclick="focusOnWilayah('${w.replace(/'/g, "\\'")}')"><span><i class="fas fa-map-marker-alt"></i> ${w}</span><span style="background:rgba(255,255,255,0.2);padding:2px 8px;border-radius:12px;font-size:11px;">${d.count}</span></div><div class="wilayah-blok-list" style="padding:6px;font-size:9px;">🏢 ${d.status['Kantor'] || 0} | 📱 ${d.status['PPOB'] || 0} | ⚠️ ${d.status['Belum Bayar'] || 0}</div></div>`; });
    container.innerHTML = html || '<div class="empty-state">Tidak ada data</div>';
  } catch(e) { container.innerHTML = '<div class="empty-state">Gagal memuat</div>'; }
}

// ============================================
// 16. SEARCH & FOCUS
// ============================================
function performSearch() {
  const q = document.getElementById('searchInput').value.trim().toLowerCase(); const filter = document.getElementById('searchFilter').value; const rc = document.getElementById('searchResults');
  if (!q && filter === 'all') { rc.innerHTML = '<div class="search-empty">Ketik untuk mencari</div>'; return; }
  let results = pelangganDataFromLaravel.filter(p => { const s = getPaymentStatus(p); if (filter !== 'all' && s.status !== filter) return false; if (!q) return true; return (p.no_pelanggan || '').toLowerCase().includes(q) || (p.nama || '').toLowerCase().includes(q); }).slice(0, 20);
  if (!results.length) { rc.innerHTML = '<div class="search-empty">Tidak ditemukan</div>'; return; }
  rc.innerHTML = results.map(p => { const s = getPaymentStatus(p); return `<div class="search-result-item" onclick="focusOnPelanggan('${p.no_pelanggan}')"><div><div class="sr-name">${p.nama}</div><div class="sr-detail">No: ${p.no_pelanggan}</div></div><div class="sr-badge" style="background:${s.color};">${s.status}</div></div>`; }).join('');
}
function clearSearch() { document.getElementById('searchInput').value = ''; document.getElementById('searchFilter').value = 'all'; document.getElementById('searchResults').innerHTML = '<div class="search-empty">Ketik untuk mencari</div>'; }
function focusOnPelanggan(no) { const d = pelangganLayers[`pelanggan_${no}`]; if (d) { map.flyTo(d.coords, 18, { duration: 1 }); setTimeout(() => d.marker.openPopup(), 1000); } else { const u = unpaidCustomerList.find(x => x.data.no_pelanggan === no); if (u) { map.flyTo(u.coords, 18, { duration: 1 }); setTimeout(() => u.marker.openPopup(), 1000); } else showNotification('❌ Tidak ditemukan', 'warning'); } }
function focusOnBangunan(id) { const m = markerLayers[`bangunan_${id}`]; if (m) { map.setView(m.getLatLng(), 17); m.openPopup(); } }
function focusOnZona(id) { if (zonaLayers[id]) map.fitBounds(zonaLayers[id].polygon.getBounds(), { padding: [80, 80], maxZoom: 16 }); }
function focusOnGangguan(id) { const m = markerLayers[`gangguan_${id}`]; if (m) { map.flyTo(m.getLatLng(), 17, { duration: 0.8 }); setTimeout(() => m.openPopup(), 800); } }
function focusOnWilayah(nama) { const coords = []; pelangganDataFromLaravel.forEach(p => { if ((p.nama_wilayah || '-') === nama) { const c = parseKoordinator(p.koordinator); if (c && isInArea(c[0], c[1])) coords.push(c); } }); if (!coords.length) { showNotification('❌ Tidak ada koordinat', 'warning'); return; } map.fitBounds(L.latLngBounds(coords), { padding: [100, 100], maxZoom: 15 }); }
function toggleSidebar() { document.getElementById('sidebar').classList.toggle('active'); }
function toggleFullscreen() { const w = document.getElementById('mainWrapper'), b = document.getElementById('expandBtn'); if (!document.fullscreenElement) { w.requestFullscreen?.(); w.classList.add('is-fullscreen'); isFullscreen = true; b.classList.add('active'); b.innerHTML = '<i class="fas fa-compress"></i> <span>Keluar</span>'; } else { document.exitFullscreen?.(); w.classList.remove('is-fullscreen'); isFullscreen = false; b.classList.remove('active'); b.innerHTML = '<i class="fas fa-expand"></i> <span>Fullscreen</span>'; } setTimeout(() => map?.invalidateSize(), 300); }
document.addEventListener('fullscreenchange', () => { if (!document.fullscreenElement) { document.getElementById('mainWrapper').classList.remove('is-fullscreen'); isFullscreen = false; document.getElementById('expandBtn').classList.remove('active'); document.getElementById('expandBtn').innerHTML = '<i class="fas fa-expand"></i> <span>Fullscreen</span>'; } setTimeout(() => map?.invalidateSize(), 300); });
function initSidebarAutoScroll() { 
    const sb = document.getElementById('sidebarContent'); 
    if (!sb) return; 
    
    // ✅ OPTIMASI: Ubah dari 50 menjadi 150 (3x lebih ringan, tapi tetap mulus)
    sidebarScrollInterval = setInterval(() => { 
        if (Date.now() - lastActivityTime > 30000 && sb.scrollHeight > sb.clientHeight + 50) { 
            sb.scrollTop += sidebarScrollDirection; 
            if (sb.scrollTop >= sb.scrollHeight - sb.clientHeight - 5) sidebarScrollDirection = -1; 
            else if (sb.scrollTop <= 0) sidebarScrollDirection = 1; 
        } 
    }, 150); // <-- UBAH DI SINI
    
    ['mousemove', 'click', 'keypress'].forEach(e => document.addEventListener(e, throttle(() => lastActivityTime = Date.now(), 500))); 
}
let waQRGenerated = false;
function showWAQR() { new bootstrap.Modal(document.getElementById('waQRModal')).show(); if (!waQRGenerated) { new QRCode(document.getElementById('wa-qrcode'), { text: 'https://wa.me/6288294979966', width: 200, height: 200, colorDark: '#128C7E', colorLight: '#ffffff' }); waQRGenerated = true; } }
function changeSlideshow(dir) { /* placeholder */ }

// ============================================
// 17. INIT
// ============================================
document.addEventListener('DOMContentLoaded', () => { loadVoices(); setTimeout(loadVoices, 500); initMap(); });
window.addEventListener('beforeunload', stopRealtimePolling);
window.addEventListener('resize', throttle(() => map?.invalidateSize(), 250));
</script>
</body>
</html>