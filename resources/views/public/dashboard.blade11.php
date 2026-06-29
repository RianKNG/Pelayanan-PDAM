<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Peta Jaringan Pipa - PDAM UP Darmaraja</title>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
:root { --scroll-duration: 60s; }
body { font-family: 'Inter', sans-serif; background: #f8fafc; overflow-x: hidden; }

/* 🔥 PROGRESS BAR PENDAPATAN */
.revenue-progress-container {
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    padding: 12px 0;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    border-bottom: 2px solid rgba(255,255,255,0.1);
}
.revenue-progress-wrapper {
    max-width: 1600px;
    margin: 0 auto;
    padding: 0 20px;
}
.revenue-progress-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
    color: white;
}
.revenue-progress-title {
    font-size: 11px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 6px;
    opacity: 0.9;
}
.revenue-progress-stats {
    display: flex;
    gap: 15px;
    font-size: 11px;
}
.revenue-progress-stat {
    display: flex;
    align-items: center;
    gap: 5px;
    background: rgba(255,255,255,0.1);
    padding: 4px 10px;
    border-radius: 12px;
    backdrop-filter: blur(10px);
}
.revenue-progress-stat i {
    font-size: 10px;
}
.revenue-progress-stat strong {
    font-weight: 700;
}
.revenue-progress-bar-container {
    position: relative;
    height: 28px;
    background: rgba(255,255,255,0.1);
    border-radius: 14px;
    overflow: hidden;
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.2);
}
.revenue-progress-bar {
    height: 100%;
    background: linear-gradient(90deg, #10b981 0%, #059669 50%, #047857 100%);
    border-radius: 14px;
    transition: width 1s ease-in-out;
    position: relative;
    overflow: hidden;
    box-shadow: 0 0 20px rgba(16, 185, 129, 0.5);
}
.revenue-progress-bar::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    animation: shimmer 2s infinite;
}
@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}
.revenue-progress-percentage {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 12px;
    font-weight: 800;
    color: white;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    z-index: 2;
}
.revenue-progress-details {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
    margin-top: 10px;
}
.revenue-detail-card {
    background: rgba(255,255,255,0.1);
    padding: 8px 12px;
    border-radius: 8px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.15);
}
.revenue-detail-label {
    font-size: 9px;
    color: rgba(255,255,255,0.7);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 3px;
    display: flex;
    align-items: center;
    gap: 4px;
}
.revenue-detail-value {
    font-size: 14px;
    font-weight: 700;
    color: white;
}
.revenue-detail-value.warning {
    color: #fbbf24;
}
.revenue-detail-value.danger {
    color: #f87171;
}
.revenue-detail-value.success {
    color: #86efac;
}

.top-info-bar { background: linear-gradient(135deg, #0f172a 0%, #1e3c72 50%, #2a5298 100%); color: white; padding: 10px 0; box-shadow: 0 2px 15px rgba(15, 23, 42, 0.2); position: relative; z-index: 1000; }
.top-info-container { max-width: 1600px; margin: 0 auto; padding: 0 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; }
.brand-section { display: flex; align-items: center; gap: 12px; }
.brand-logo { width: 42px; height: 42px; background: linear-gradient(135deg, #06b6d4, #0891b2); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px; box-shadow: 0 4px 12px rgba(6, 182, 212, 0.4); }
.brand-text h1 { font-size: 16px; font-weight: 700; margin: 0; letter-spacing: 0.5px; }
.brand-text small { font-size: 11px; opacity: 0.8; }
.alert-section { display: flex; align-items: center; gap: 15px; background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.3); padding: 8px 15px; border-radius: 10px; backdrop-filter: blur(10px); }
.alert-icon { width: 36px; height: 36px; background: linear-gradient(135deg, #f59e0b, #d97706); border-radius: 50%; display: flex; align-items: center; justify-content: center; animation: pulse-soft 2s infinite; }
@keyframes pulse-soft { 0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.4); } 50% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(245, 158, 11, 0); } }
.alert-text { font-size: 12px; }
.alert-text strong { display: block; font-size: 13px; margin-bottom: 2px; }
.alert-text small { opacity: 0.85; }
.alert-count { background: #f59e0b; color: white; padding: 4px 10px; border-radius: 12px; font-weight: 700; font-size: 14px; }
.notification-bar { background: rgba(16, 185, 129, 0.2); border: 1px solid rgba(16, 185, 129, 0.4); border-radius: 10px; padding: 8px 15px; flex: 1; max-width: 600px; overflow: hidden; position: relative; }
.notification-title { font-size: 10px; opacity: 0.9; margin-bottom: 4px; display: flex; align-items: center; gap: 6px; font-weight: 600; }
.notification-scroll { overflow: hidden; white-space: nowrap; position: relative; }
.notification-scroll-content { display: inline-block; animation: scroll-left var(--scroll-duration, 60s) linear infinite; font-size: 11px; }
.notification-item { display: inline-block; margin-right: 30px; padding: 4px 12px; background: rgba(255, 255, 255, 0.15); border-radius: 15px; backdrop-filter: blur(5px); transition: all 0.3s ease; }
.notification-item.active-sync { background: linear-gradient(135deg, #fbbf24, #f59e0b) !important; transform: scale(1.15); box-shadow: 0 0 20px rgba(251, 191, 36, 0.8); }
.notification-item.active-sync strong, .notification-item.active-sync .amount, .notification-item.active-sync .location { color: #7c2d12 !important; font-weight: 800 !important; }
.notification-item strong { color: #fff; font-weight: 700; }
.notification-item .amount { color: #86efac; font-weight: 700; }
.notification-item .location { color: #fcd34d; font-size: 10px; }
@keyframes scroll-left { 0% { transform: translateX(100%); } 100% { transform: translateX(-100%); } }
.contact-bar { background: white; border-bottom: 1px solid #e2e8f0; padding: 10px 0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
.contact-container { max-width: 1600px; margin: 0 auto; padding: 0 20px; display: flex; justify-content: space-around; align-items: center; flex-wrap: wrap; gap: 15px; }
.contact-item { display: flex; align-items: center; gap: 10px; font-size: 13px; color: #475569; text-decoration: none; padding: 6px 12px; border-radius: 10px; transition: all 0.2s; cursor: pointer; }
.contact-item:hover { background: #f0f9ff; transform: translateY(-2px); color: #0369a1; }
.contact-icon { width: 36px; height: 36px; background: linear-gradient(135deg, #e0f2fe, #bae6fd); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #0369a1; font-size: 14px; flex-shrink: 0; }
.contact-icon.whatsapp { background: linear-gradient(135deg, #d1fae5, #a7f3d0); color: #047857; }
.contact-icon.location { background: linear-gradient(135deg, #fef3c7, #fde68a); color: #92400e; }
.contact-icon.clock { background: linear-gradient(135deg, #ede9fe, #ddd6fe); color: #6d28d9; }
.contact-text strong { display: block; font-size: 10px; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 2px; font-weight: 600; }
.contact-text span { font-weight: 600; color: #1e293b; font-size: 13px; }
.wa-qr-btn { background: #25D366; color: white; border: none; padding: 4px 8px; border-radius: 6px; font-size: 10px; margin-left: 5px; cursor: pointer; transition: all 0.2s; }
.wa-qr-btn:hover { background: #128C7E; transform: scale(1.05); }
.main-wrapper { display: flex; height: calc(100vh - 200px); position: relative; margin-right: 420px; }
#map { flex: 1; height: 100%; z-index: 1; }
.sidebar { position: fixed !important; right: 0 !important; top: 190px !important; bottom: 20px !important; width: 400px !important; background: white; box-shadow: -2px 0 15px rgba(0,0,0,0.15); z-index: 999; display: flex; flex-direction: column; transform: translateX(0) !important; border-radius: 12px 0 0 12px; overflow: hidden; }
.sidebar-header { background: linear-gradient(135deg, #1e3c72, #2a5298); color: white; padding: 15px 20px; position: sticky; top: 0; z-index: 10; }
.sidebar-header h5 { margin: 0; font-size: 15px; font-weight: 600; display: flex; align-items: center; gap: 8px; }
.sidebar-header small { opacity: 0.85; font-size: 11px; display: block; margin-top: 3px; }
.sidebar-content { padding: 15px; overflow-y: auto; flex: 1; scroll-behavior: smooth; }
.sidebar-content::-webkit-scrollbar { width: 6px; }
.sidebar-content::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
.search-container { background: linear-gradient(135deg, #f0f9ff, #e0f2fe); padding: 12px; border-radius: 12px; margin-bottom: 15px; border: 2px solid #bae6fd; }
.search-title { font-size: 11px; font-weight: 700; color: #0369a1; margin-bottom: 8px; display: flex; align-items: center; gap: 6px; text-transform: uppercase; letter-spacing: 0.5px; }
.search-row { display: flex; gap: 6px; margin-bottom: 8px; }
.search-input { flex: 1; padding: 8px 10px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 12px; background: white; }
.search-input:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
.search-select { padding: 8px 6px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 11px; background: white; min-width: 110px; }
.search-btn { padding: 8px 14px; background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 12px; display: flex; align-items: center; gap: 5px; }
.search-btn:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3); }
.search-btn.clear { background: linear-gradient(135deg, #94a3b8, #64748b); }
.search-results { max-height: 200px; overflow-y: auto; margin-top: 8px; }
.search-result-item { padding: 8px 10px; background: white; border: 1px solid #e2e8f0; border-radius: 8px; margin-bottom: 5px; cursor: pointer; transition: all 0.2s; font-size: 11px; display: flex; justify-content: space-between; align-items: center; }
.search-result-item:hover { background: #f0f9ff; border-color: #3b82f6; transform: translateX(3px); }
.search-result-item .sr-name { font-weight: 600; color: #1e293b; }
.search-result-item .sr-detail { color: #64748b; font-size: 10px; }
.search-result-item .sr-badge { background: #3b82f6; color: white; padding: 2px 8px; border-radius: 10px; font-size: 9px; font-weight: 700; }
.search-empty { text-align: center; padding: 10px; color: #94a3b8; font-size: 11px; font-style: italic; }
.stats-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; margin-bottom: 15px; }
.stats-grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; margin-bottom: 15px; }
.stat-card { padding: 12px; border-radius: 12px; text-align: center; color: white; box-shadow: 0 4px 12px rgba(0,0,0,0.08); transition: all 0.2s; position: relative; overflow: hidden; cursor: pointer; }
.stat-card::before { content: ''; position: absolute; top: -50%; right: -50%; width: 100%; height: 100%; background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%); }
.stat-card:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(0,0,0,0.15); }
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
.stat-label { font-size: 9px; opacity: 0.9; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 3px; position: relative; }
.revenue-card { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 20px; border-radius: 15px; margin-bottom: 15px; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3); position: relative; overflow: hidden; cursor: pointer; }
.revenue-card::before { content: ''; position: absolute; top: -50%; right: -50%; width: 100%; height: 100%; background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 70%); }
.revenue-title { font-size: 11px; opacity: 0.9; margin-bottom: 8px; display: flex; align-items: center; gap: 6px; position: relative; }
.revenue-amount { font-size: 28px; font-weight: 800; margin-bottom: 5px; position: relative; }
.revenue-kubikasi { font-size: 12px; opacity: 0.9; position: relative; display: flex; align-items: center; gap: 5px; }
.section-title { font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 1px; margin: 15px 0 10px 0; padding-bottom: 6px; border-bottom: 2px solid #e2e8f0; display: flex; align-items: center; gap: 8px; }
.list-item { padding: 12px; border: 1px solid #e2e8f0; border-radius: 10px; margin-bottom: 8px; cursor: pointer; transition: all 0.2s; background: white; }
.list-item:hover { background: #f0f9ff; border-color: #0ea5e9; transform: translateX(3px); box-shadow: 0 2px 8px rgba(14, 165, 233, 0.1); }
.list-item-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px; }
.list-item-title { font-weight: 600; font-size: 13px; color: #1e293b; display: flex; align-items: center; gap: 8px; }
.color-indicator { width: 20px; height: 4px; border-radius: 2px; }
.control-buttons { 
    position: fixed; 
    left: 20px;  /* ← Pindah ke kiri */
    top: 120px;  /* ← Sesuaikan agar sejajar/ dibawah zoom */
    z-index: 1001; 
    display: flex; 
    flex-direction: column; 
    gap: 10px; 
}
.control-btn { background: linear-gradient(135deg, #1e3c72, #2a5298); color: white; border: none; padding: 10px 16px; border-radius: 10px; box-shadow: 0 4px 15px rgba(30, 60, 114, 0.3); cursor: pointer; font-weight: 600; font-size: 13px; display: flex; align-items: center; gap: 8px; transition: all 0.3s; }
.control-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(30, 60, 114, 0.4); }
.control-btn.expand { background: linear-gradient(135deg, #10b981, #059669); }
.control-btn.expand.active { background: linear-gradient(135deg, #ef4444, #dc2626); }
.control-btn.voice { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
.control-btn.voice.active { background: linear-gradient(135deg, #10b981, #059669); }
.control-btn.live { background: linear-gradient(135deg, #ec4899, #db2777); }
.control-btn.live.active { background: linear-gradient(135deg, #10b981, #059669); animation: pulse-live 2s infinite; }
@keyframes pulse-live { 0%, 100% { box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3); } 50% { box-shadow: 0 4px 25px rgba(16, 185, 129, 0.6); } }
.voice-panel { position: fixed; right: 20px; top: 390px; background: white; border-radius: 15px; box-shadow: 0 10px 40px rgba(0,0,0,0.15); padding: 20px; z-index: 1002; width: 420px; display: none; animation: slideInRight 0.3s ease; max-height: 85vh; overflow-y: auto; }
.voice-panel::-webkit-scrollbar { width: 6px; }
.voice-panel::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
.voice-panel.active { display: block; }
@keyframes slideInRight { from { transform: translateX(50px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
.voice-panel-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid #e2e8f0; }
.voice-panel-title { font-size: 14px; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 8px; }
.voice-panel-close { background: none; border: none; color: #94a3b8; cursor: pointer; font-size: 16px; padding: 4px; }
.voice-panel-close:hover { color: #ef4444; }
.voice-select-group { margin-bottom: 12px; }
.voice-select-label { font-size: 11px; font-weight: 600; color: #64748b; margin-bottom: 5px; display: block; }
.voice-select { width: 100%; padding: 8px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 12px; background: #f8fafc; }
.voice-control-row { display: flex; align-items: center; gap: 10px; margin-top: 10px; }
.voice-control-label { font-size: 11px; color: #64748b; font-weight: 600; min-width: 70px; }
.voice-control-row input[type="range"] { flex: 1; accent-color: #3b82f6; }
.voice-test-btn { width: 100%; margin-top: 12px; padding: 10px; background: linear-gradient(135deg, #10b981, #059669); color: white; border: none; border-radius: 10px; cursor: pointer; font-weight: 600; font-size: 12px; display: flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.2s; }
.voice-test-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); }
.gangguan-voice-control, .payment-voice-control, .music-control, .scroll-control { margin-top: 15px; padding: 15px; border-radius: 12px; border: 2px solid; }
.gangguan-voice-control { background: linear-gradient(135deg, #fef3c7, #fde68a); border-color: #f59e0b; }
.payment-voice-control { background: linear-gradient(135deg, #d1fae5, #a7f3d0); border-color: #10b981; }
.music-control { background: linear-gradient(135deg, #e0e7ff, #c7d2fe); border-color: #6366f1; }
.scroll-control { background: linear-gradient(135deg, #fce7f3, #fbcfe8); border-color: #ec4899; }
.voice-control-title { font-size: 11px; font-weight: 700; margin-bottom: 10px; display: flex; align-items: center; gap: 6px; }
.gangguan-voice-control .voice-control-title { color: #92400e; }
.payment-voice-control .voice-control-title { color: #065f46; }
.music-control .voice-control-title { color: #3730a3; }
.scroll-control .voice-control-title { color: #9d174d; }
.voice-btn-group { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
.voice-btn { padding: 10px; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 11px; display: flex; align-items: center; justify-content: center; gap: 6px; transition: all 0.2s; }
.voice-btn.play { background: linear-gradient(135deg, #10b981, #059669); color: white; }
.voice-btn.pause { background: linear-gradient(135deg, #f59e0b, #d97706); color: white; }
.voice-btn.stop { background: linear-gradient(135deg, #ef4444, #dc2626); color: white; }
.voice-btn.repeat { background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; }
.voice-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
.voice-btn:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }
.voice-status-indicator { display: flex; align-items: center; gap: 8px; margin-top: 10px; padding: 8px; background: white; border-radius: 8px; font-size: 10px; }
.voice-status-dot { width: 8px; height: 8px; border-radius: 50%; background: #94a3b8; }
.voice-status-dot.active { background: #10b981; animation: pulse-dot 1s infinite; }
.voice-status-dot.paused { background: #f59e0b; }
@keyframes pulse-dot { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }
.youtube-input-group { display: flex; gap: 6px; margin-top: 8px; }
.youtube-input { flex: 1; padding: 8px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 11px; }
.youtube-btn { padding: 8px 12px; background: #ef4444; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 11px; font-weight: 600; }
.youtube-btn:hover { background: #dc2626; }
.youtube-status, .music-status { font-size: 10px; margin-top: 6px; display: flex; align-items: center; gap: 4px; padding: 6px; background: white; border-radius: 6px; }
.youtube-status { color: #b91c1c; }
.music-status { color: #3730a3; }
.custom-layer-control { 
    position: fixed;  
    top: 320px;  /* ← Di bawah tombol kontrol (4 tombol x ~70px) */
    left: 20px;  
    z-index: 1001;
    background: white; 
    border-radius: 12px; 
    box-shadow: 0 4px 20px rgba(0,0,0,0.1); 
    padding: 10px; 
    max-width: 200px; 
}
.layer-control-title { font-size: 11px; font-weight: 700; color: #1e293b; margin-bottom: 8px; display: flex; align-items: center; gap: 6px; padding-bottom: 6px; border-bottom: 1px solid #e2e8f0; }
.layer-btn-group { display: grid; grid-template-columns: repeat(2, 1fr); gap: 6px; }
.layer-btn { padding: 8px 6px; border: 2px solid #e2e8f0; background: white; border-radius: 8px; cursor: pointer; font-size: 10px; font-weight: 600; color: #64748b; transition: all 0.2s; display: flex; flex-direction: column; align-items: center; gap: 4px; }
.layer-btn:hover { border-color: #3b82f6; color: #3b82f6; transform: translateY(-2px); }
.layer-btn.active { background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; border-color: #3b82f6; }
.layer-btn i { font-size: 16px; }
.live-info-panel { position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); background: linear-gradient(135deg, rgba(15, 23, 42, 0.95), rgba(30, 58, 138, 0.95)); color: white; padding: 12px 20px; border-radius: 15px; box-shadow: 0 8px 32px rgba(0,0,0,0.3); z-index: 500; display: flex; align-items: center; gap: 20px; backdrop-filter: blur(10px); border: 2px solid rgba(239, 68, 68, 0.5); min-width: 500px; animation: slideUp 0.5s ease; }
@keyframes slideUp { from { transform: translate(-50%, 50px); opacity: 0; } to { transform: translate(-50%, 0); opacity: 1; } }
.live-info-panel .live-indicator { display: flex; align-items: center; gap: 8px; padding: 6px 12px; background: linear-gradient(135deg, #ef4444, #dc2626); border-radius: 20px; font-size: 11px; font-weight: 700; }
.live-info-panel .live-dot { width: 10px; height: 10px; background: white; border-radius: 50%; animation: live-pulse 1.5s infinite; }
@keyframes live-pulse { 0%, 100% { opacity: 1; transform: scale(1); } 50% { opacity: 0.5; transform: scale(1.3); } }
.live-info-panel .customer-info { flex: 1; display: flex; flex-direction: column; gap: 2px; }
.live-info-panel .customer-name { font-size: 14px; font-weight: 700; color: #fbbf24; }
.live-info-panel .customer-detail { font-size: 11px; opacity: 0.9; }
.live-info-panel .customer-amount { font-size: 16px; font-weight: 800; color: #f87171; padding: 6px 12px; background: rgba(239, 68, 68, 0.2); border-radius: 10px; border: 1px solid rgba(239, 68, 68, 0.5); }
.live-info-panel .counter { text-align: center; padding: 4px 12px; background: rgba(255, 255, 255, 0.1); border-radius: 10px; }
.live-info-panel .counter-num { font-size: 18px; font-weight: 800; color: #fbbf24; }
.live-info-panel .counter-label { font-size: 9px; opacity: 0.8; text-transform: uppercase; }
.unpaid-marker-wrapper { position: relative; display: flex; flex-direction: column; align-items: center; animation: marker-bounce 2s infinite; }
@keyframes marker-bounce { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-3px); } }
.unpaid-marker-pin { width: 24px; height: 24px; background: linear-gradient(135deg, #ef4444, #dc2626); border-radius: 50%; border: 2px solid white; display: flex; align-items: center; justify-content: center; color: white; font-size: 10px; box-shadow: 0 2px 8px rgba(239, 68, 68, 0.6); position: relative; z-index: 2; }
.unpaid-marker-pulse { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 24px; height: 24px; border-radius: 50%; background: rgba(239, 68, 68, 0.4); animation: unpaid-pulse 2s infinite; z-index: 1; }
@keyframes unpaid-pulse { 0% { transform: translate(-50%, -50%) scale(1); opacity: 0.8; } 100% { transform: translate(-50%, -50%) scale(2.5); opacity: 0; } }
.unpaid-marker-label { position: absolute; top: -24px; left: 50%; transform: translateX(-50%); background: linear-gradient(135deg, #dc2626, #991b1b); color: white; padding: 2px 8px; border-radius: 10px; font-size: 9px; font-weight: 700; white-space: nowrap; box-shadow: 0 2px 6px rgba(0,0,0,0.3); border: 1.5px solid white; z-index: 3; max-width: 120px; overflow: hidden; text-overflow: ellipsis; }
.unpaid-marker-amount { position: absolute; bottom: -18px; left: 50%; transform: translateX(-50%); background: #fbbf24; color: #7c2d12; padding: 1px 6px; border-radius: 6px; font-size: 8px; font-weight: 800; white-space: nowrap; box-shadow: 0 2px 4px rgba(0,0,0,0.2); z-index: 3; }
.unpaid-marker-wrapper.highlighted .unpaid-marker-pin { background: linear-gradient(135deg, #fbbf24, #f59e0b); box-shadow: 0 4px 20px rgba(251, 191, 36, 0.8); transform: scale(1.5); }
.unpaid-marker-wrapper.highlighted .unpaid-marker-pulse { background: rgba(251, 191, 36, 0.5); }
.toast-notification { position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background: white; padding: 12px 20px; border-radius: 10px; box-shadow: 0 4px 20px rgba(0,0,0,0.15); z-index: 9999; display: flex; align-items: center; gap: 10px; font-size: 13px; font-weight: 600; animation: toastSlide 0.3s ease; max-width: 400px; }
.toast-notification.success { border-left: 4px solid #10b981; color: #065f46; }
.toast-notification.info { border-left: 4px solid #3b82f6; color: #1e40af; }
.toast-notification.warning { border-left: 4px solid #f59e0b; color: #92400e; }
.toast-notification.live { border-left: 4px solid #ef4444; color: #991b1b; background: #fef2f2; }
@keyframes toastSlide { from { transform: translate(-50%, -50px); opacity: 0; } to { transform: translate(-50%, 0); opacity: 1; } }
.legend { position: absolute; bottom: 20px; left: 20px; background: white; padding: 15px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); z-index: 500; max-width: 240px; font-size: 12px; }
.legend-title { font-weight: 700; margin-bottom: 10px; color: #1e293b; font-size: 13px; display: flex; align-items: center; gap: 6px; }
.legend-group { margin-bottom: 10px; }
.legend-group-title { font-size: 10px; color: #64748b; text-transform: uppercase; font-weight: 600; margin-bottom: 4px; padding-bottom: 2px; border-bottom: 1px solid #e2e8f0; }
.legend-item { display: flex; align-items: center; gap: 8px; margin: 4px 0; }
.legend-color { width: 20px; height: 4px; border-radius: 2px; }
.legend-marker { width: 16px; height: 16px; border-radius: 50%; border: 2px solid white; box-shadow: 0 0 0 1px rgba(0,0,0,0.2); display: flex; align-items: center; justify-content: center; color: white; font-size: 8px; }
.legend-pelanggan { position: absolute; bottom: 20px; right: 430px; background: white; padding: 15px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); z-index: 500; max-width: 250px; font-size: 12px; }
.legend-pelanggan-title { font-weight: 700; margin-bottom: 10px; color: #1e293b; font-size: 13px; display: flex; align-items: center; gap: 6px; }
.legend-pelanggan-item { display: flex; align-items: center; gap: 8px; margin: 5px 0; font-size: 11px; }
.legend-pelanggan-marker { width: 16px; height: 16px; border-radius: 50%; border: 2px solid white; box-shadow: 0 0 0 1px rgba(0,0,0,0.2); display: flex; align-items: center; justify-content: center; color: white; font-size: 8px; }
.custom-div-icon { background: transparent !important; border: none !important; }
.marker-wrapper { position: relative; display: flex; flex-direction: column; align-items: center; }
.marker-banner { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; padding: 5px 12px; border-radius: 15px; font-size: 10px; font-weight: 700; white-space: nowrap; box-shadow: 0 2px 8px rgba(239, 68, 68, 0.5); margin-bottom: 4px; border: 2px solid white; letter-spacing: 0.3px; animation: shake 2s infinite; }
@keyframes shake { 0%, 100% { transform: translateX(0); } 10%, 30%, 50%, 70%, 90% { transform: translateX(-2px); } 20%, 40%, 60%, 80% { transform: translateX(2px); } }
@keyframes pulse-red { 0% { transform: translate(-50%, -50%) scale(1); opacity: 0.8; } 50% { transform: translate(-50%, -50%) scale(1.5); opacity: 0.4; } 100% { transform: translate(-50%, -50%) scale(1); opacity: 0.8; } }
.marker-pin { display: flex; justify-content: center; align-items: center; color: white; box-shadow: 0 3px 10px rgba(0,0,0,0.3); border: 3px solid white; transition: transform 0.2s; position: relative; z-index: 2; }
.marker-pin:hover { transform: scale(1.15); z-index: 10; }
.shape-circle { border-radius: 50%; }
.shape-square { border-radius: 6px; }
.marker-label { position: absolute; top: 100%; left: 50%; transform: translateX(-50%); background: rgba(30, 41, 59, 0.9); color: white; padding: 2px 6px; border-radius: 8px; font-size: 9px; white-space: nowrap; font-weight: 600; margin-top: 4px; }
.pulse-ring { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 100%; height: 100%; border-radius: 50%; animation: pulse-animation 2s infinite; z-index: 1; }
@keyframes pulse-animation { 0% { transform: translate(-50%, -50%) scale(1); opacity: 0.7; box-shadow: 0 0 0 0 currentColor; } 70% { transform: translate(-50%, -50%) scale(2.2); opacity: 0; box-shadow: 0 0 0 15px currentColor; } 100% { transform: translate(-50%, -50%) scale(1); opacity: 0; } }
.empty-state { text-align: center; padding: 20px; color: #94a3b8; font-size: 12px; font-style: italic; }
.main-wrapper.is-fullscreen { position: fixed !important; top: 0 !important; left: 0 !important; width: 100vw !important; height: 100vh !important; z-index: 99999 !important; background: white; margin-right: 0 !important; }
.main-wrapper.is-fullscreen #map { height: 100vh !important; }
.main-wrapper.is-fullscreen .top-info-bar, .main-wrapper.is-fullscreen .contact-bar, .main-wrapper.is-fullscreen .sidebar, .main-wrapper.is-fullscreen .revenue-progress-container { display: none !important; }
.wa-modal-content { border-radius: 20px; overflow: hidden; }
.wa-modal-header { background: linear-gradient(135deg, #25D366, #128C7E); color: white; padding: 20px; text-align: center; }
.wa-modal-header h4 { margin: 0; font-weight: 700; }
.wa-modal-header small { opacity: 0.9; }
.wa-qr-container { padding: 30px; text-align: center; background: white; }
#wa-qrcode { display: inline-block; padding: 15px; background: white; border-radius: 15px; box-shadow: 0 4px 20px rgba(37, 211, 102, 0.2); margin-bottom: 20px; }
.wa-info { background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; padding: 15px; margin-top: 15px; }
.wa-info-item { display: flex; align-items: center; gap: 10px; margin: 8px 0; font-size: 13px; color: #065f46; }
.wa-info-item i { color: #10b981; width: 20px; }
.wa-btn-direct { background: linear-gradient(135deg, #25D366, #128C7E); color: white; border: none; padding: 14px 24px; border-radius: 12px; font-weight: 600; font-size: 14px; display: inline-flex; align-items: center; gap: 10px; margin-top: 15px; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3); text-decoration: none; }
.wa-btn-direct:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(37, 211, 102, 0.4); color: white; }
.gangguan-card { margin-bottom: 12px; border: 2px solid #e2e8f0; border-radius: 12px; overflow: hidden; cursor: pointer; transition: all 0.2s; background: white; }
.gangguan-card:hover { border-color: #0ea5e9; transform: translateX(3px); box-shadow: 0 4px 12px rgba(14, 165, 233, 0.15); }
.gangguan-card.active { border-color: #3b82f6; box-shadow: 0 4px 15px rgba(59, 130, 246, 0.25); }
.gangguan-card-header { padding: 10px 14px; color: white; display: flex; justify-content: space-between; align-items: center; }
.gangguan-card-header.status-menunggu { background: linear-gradient(135deg, #fbbf24, #f59e0b); }
.gangguan-card-header.status-dalam_proses { background: linear-gradient(135deg, #60a5fa, #3b82f6); }
.gangguan-card-header.status-selesai { background: linear-gradient(135deg, #34d399, #10b981); }
.gangguan-card-code { font-weight: 700; font-size: 13px; display: flex; align-items: center; gap: 6px; }
.gangguan-card-status { background: rgba(255,255,255,0.25); padding: 3px 10px; border-radius: 12px; font-size: 10px; font-weight: 600; text-transform: uppercase; backdrop-filter: blur(5px); }
.gangguan-card-body { padding: 12px 14px; }
.gangguan-info-block { margin-bottom: 10px; }
.gangguan-info-label { font-size: 9px; color: #64748b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 3px; display: flex; align-items: center; gap: 4px; }
.gangguan-info-value { font-weight: 600; color: #1e293b; font-size: 13px; }
.gangguan-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 10px; }
.gangguan-grid-item { background: #f8fafc; padding: 8px; border-radius: 6px; }
.gangguan-grid-item .label { font-size: 9px; color: #64748b; font-weight: 600; margin-bottom: 2px; }
.gangguan-grid-item .value { font-weight: 600; color: #1e293b; font-size: 11px; }
.estimasi-box { background: linear-gradient(135deg, #fef3c7, #fde68a); padding: 12px; border-radius: 10px; border-left: 4px solid #f59e0b; margin-top: 10px; }
.estimasi-box-title { font-size: 10px; color: #92400e; font-weight: 700; margin-bottom: 10px; display: flex; align-items: center; gap: 5px; text-transform: uppercase; letter-spacing: 0.5px; }
.estimasi-item { margin-bottom: 8px; }
.estimasi-item:last-child { margin-bottom: 0; }
.estimasi-label { font-size: 9px; color: #78350f; font-weight: 600; margin-bottom: 2px; display: flex; align-items: center; gap: 4px; }
.estimasi-value { font-weight: 700; color: #92400e; font-size: 12px; }
.estimasi-value.big { font-size: 20px; color: #dc2626; display: flex; align-items: baseline; gap: 4px; }
.estimasi-value.big .unit { font-size: 10px; color: #92400e; font-weight: 600; }
.estimasi-sub { font-size: 9px; color: #78350f; margin-top: 2px; }
.estimasi-sub strong { color: #dc2626; }
.wilayah-card { margin-bottom: 15px; border: 1px solid #e2e8f0; border-radius: 10px; overflow: hidden; }
.wilayah-header { background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; padding: 10px 12px; font-weight: 600; font-size: 13px; display: flex; justify-content: space-between; align-items: center; }
.wilayah-blok-list { padding: 8px; }
.blok-item { display: flex; justify-content: space-between; align-items: center; padding: 8px 10px; margin: 4px 0; background: #f8fafc; border-radius: 6px; font-size: 12px; cursor: pointer; transition: all 0.2s; }
.blok-item:hover { background: #e0f2fe; }
@media (max-width: 768px) {
.top-info-container { flex-direction: column; text-align: center; }
.contact-container { flex-direction: column; }
.notification-bar { max-width: 100%; }
.sidebar { width: 100% !important; max-width: 400px !important; top: auto !important; bottom: 80px !important; right: 0 !important; transform: translateY(100%) !important; }
.sidebar.active { transform: translateY(0) !important; }
.main-wrapper { margin-right: 0; height: calc(100vh - 200px); }
.legend { max-width: 180px; font-size: 11px; }
.legend-pelanggan { max-width: 180px; font-size: 11px; right: 10px; bottom: 10px; }
.control-buttons { top: auto; bottom: 20px; right: 10px; flex-direction: row; }
.voice-panel { right: 10px; top: auto; bottom: 80px; width: calc(100% - 20px); max-width: 420px; }
.custom-layer-control { top: 10px; left: 10px; max-width: 180px; }
.live-info-panel { min-width: auto; width: calc(100% - 40px); flex-wrap: wrap; gap: 10px; }
.revenue-progress-details { grid-template-columns: repeat(2, 1fr); }
}
</style>
</head>
<body>
<audio id="backgroundMusic" loop preload="auto"></audio>
<div id="youtubePlayerContainer" style="position: fixed; bottom: -200px; right: -200px; width: 1px; height: 1px; opacity: 0; pointer-events: none; z-index: -1;"></div>

<!-- 🔥 PROGRESS BAR PENDAPATAN -->
<div class="revenue-progress-container">
<div class="revenue-progress-wrapper">
<div class="revenue-progress-header">
<div class="revenue-progress-title">
<i class="fas fa-chart-line"></i>
<span>PROGRES PENDAPATAN BULAN INI</span>
</div>
<div class="revenue-progress-stats">
<div class="revenue-progress-stat">
<i class="fas fa-calendar-day"></i>
<span>Hari ke-<strong id="currentDayOfMonth">0</strong></span>
</div>
<div class="revenue-progress-stat">
<i class="fas fa-hourglass-half"></i>
<span>Sisa <strong id="remainingDays">0</strong> hari</span>
</div>
</div>
</div>
<div class="revenue-progress-bar-container">
<div class="revenue-progress-bar" id="revenueProgressBar" style="width: 0%;"></div>
<div class="revenue-progress-percentage" id="revenueProgressPercentage">0%</div>
</div>
<div class="revenue-progress-details">
<div class="revenue-detail-card">
<div class="revenue-detail-label">
<i class="fas fa-coins"></i>
<span>Target Bulan Ini</span>
</div>
<div class="revenue-detail-value" id="targetRevenue">Rp 0</div>
</div>
<div class="revenue-detail-card">
<div class="revenue-detail-label">
<i class="fas fa-money-bill-wave"></i>
<span>Sudah Terkumpul</span>
</div>
<div class="revenue-detail-value success" id="collectedRevenue">Rp 0</div>
</div>
<div class="revenue-detail-card">
<div class="revenue-detail-label">
<i class="fas fa-exclamation-triangle"></i>
<span>Sisa Tagihan</span>
</div>
<div class="revenue-detail-value warning" id="remainingRevenue">Rp 0</div>
</div>
<div class="revenue-detail-card">
<div class="revenue-detail-label">
<i class="fas fa-tachometer-alt"></i>
<span>Rata-rata/Hari</span>
</div>
<div class="revenue-detail-value danger" id="dailyTarget">Rp 0</div>
</div>
</div>
</div>
</div>

<div class="top-info-bar">
<div class="top-info-container">
<div class="brand-section">
<div class="brand-logo"><i class="fas fa-tint"></i></div>
<div class="brand-text"><h1>PDAM UP - DARMARAJA</h1><small>Sistem Monitoring Jaringan - Unit Darmaraja</small></div>
</div>
@php
$gangguanAktif = isset($gangguanAktif) ? $gangguanAktif : collect($gangguan ?? [])->where('status', '!=', 'selesai');
$totalAktif = $gangguanAktif->count();
@endphp
@if($totalAktif > 0)
<div class="alert-section">
<div class="alert-icon"><i class="fas fa-info-circle"></i></div>
<div class="alert-text"><strong>Informasi Gangguan</strong><small>Terdapat {{ $totalAktif }} gangguan aktif yang sedang ditangani</small></div>
<div class="alert-count">{{ $totalAktif }}</div>
</div>
@else
<div class="alert-section" style="background: rgba(16, 185, 129, 0.15); border-color: rgba(16, 185, 129, 0.3);">
<div class="alert-icon" style="background: linear-gradient(135deg, #10b981, #059669);"><i class="fas fa-check-circle"></i></div>
<div class="alert-text"><strong>Pelayanan Normal</strong><small>Semua jaringan beroperasi dengan baik</small></div>
</div>
@endif
<div class="notification-bar" id="notificationBar" style="display: none;">
<div class="notification-title"><i class="fas fa-money-bill-wave"></i> Pembayaran Terbaru</div>
<div class="notification-scroll"><div class="notification-scroll-content" id="notificationContent"></div></div>
</div>
</div>
</div>
<div class="contact-bar">
<div class="contact-container">
<a href="tel:+622621500000" class="contact-item"><div class="contact-icon"><i class="fas fa-headset"></i></div><div class="contact-text"><strong>Call Center</strong><span>(0262) 1500-XXX</span></div></a>
<div class="contact-item" style="cursor: default;">
<a href="https://wa.me/6281234567890?text=Halo%20PDAM%20Tirta%20Medal%2C%20saya%20ingin%20melaporkan%20gangguan" target="_blank" class="contact-item" style="padding: 0; margin: 0;"><div class="contact-icon whatsapp"><i class="fab fa-whatsapp"></i></div><div class="contact-text"><strong>WhatsApp</strong><span>0812-3456-7890</span></div></a>
<button class="wa-qr-btn" onclick="showWAQR()" title="Lihat QR Code"><i class="fas fa-qrcode"></i> QR</button>
</div>
<a href="https://maps.google.com/?q=PDAM+Tirta+Medal+Darmaraja+Sumedang" target="_blank" class="contact-item"><div class="contact-icon location"><i class="fas fa-map-marker-alt"></i></div><div class="contact-text"><strong>Unit Darmaraja</strong><span>Jl. Raya Darmaraja, Sumedang</span></div></a>
<div class="contact-item" style="cursor: default;"><div class="contact-icon clock"><i class="fas fa-clock"></i></div><div class="contact-text"><strong>Jam Layanan</strong><span>Senin - Sabtu, 08.00 - 16.00</span></div></div>
</div>
</div>
<div class="main-wrapper" id="mainWrapper">
<div id="map"></div>
<div class="live-info-panel" id="liveInfoPanel" style="display: none;">
<div class="live-indicator"><div class="live-dot"></div><span>LIVE</span></div>
<div class="customer-info">
<div class="customer-name" id="liveCustomerName">-</div>
<div class="customer-detail" id="liveCustomerDetail">-</div>
</div>
<div class="customer-amount" id="liveCustomerAmount">Rp 0</div>
<div class="counter">
<div class="counter-num" id="liveCounterCurrent">0</div>
<div class="counter-label">dari</div>
<div class="counter-num" id="liveCounterTotal">0</div>
</div>
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
<button class="control-btn" onclick="toggleSidebar()"><i class="fas fa-bars"></i> Info Jaringan</button>
<button class="control-btn expand" id="expandBtn" onclick="toggleFullscreen()"><i class="fas fa-expand" id="expandIcon"></i> <span id="expandText">Fullscreen</span></button>
<button class="control-btn voice active" id="voiceBtn" onclick="toggleVoicePanel()"><i class="fas fa-sliders-h" id="voiceIcon"></i> <span id="voiceText">Kontrol Suara</span></button>
<button class="control-btn live" id="liveBtn" onclick="toggleLiveDashboard()"><i class="fas fa-broadcast-tower" id="liveIcon"></i> <span id="liveText">LIVE OFF</span></button>
</div>
<div class="voice-panel" id="voicePanel">
<div class="voice-panel-header">
<div class="voice-panel-title"><i class="fas fa-sliders-h"></i> Panel Kontrol Suara</div>
<button class="voice-panel-close" onclick="toggleVoicePanel()"><i class="fas fa-times"></i></button>
</div>
<div class="music-control">
<div class="voice-control-title"><i class="fas fa-music"></i> KONTROL MUSIK LATAR</div>
<label class="voice-select-label">🎵 Pilih Musik dari Folder:</label>
<select class="voice-select" id="musicSelect" onchange="changeMusic()">
<option value="">-- Pilih Musik --</option>
<option value="musik1.mp3">🎵 Musik 1 (Tenang)</option>
<option value="musik2.mp3">🎶 Musik 2 (Semangat)</option>
<option value="musik3.mp3">🎹 Musik 3 (Klasik)</option>
<option value="musik4.mp3">🌧️ Musik 4 (Alam)</option>
<option value="musik5.mp3">🎧 Musik 5 (Lo-Fi)</option>
</select>
<div class="voice-control-row">
<div class="voice-control-label">Volume Musik</div>
<input type="range" min="0" max="100" value="30" id="musicVolumeSlider" oninput="setMusicVolume(this.value)">
<span id="musicVolumeValue" style="font-size: 11px; font-weight: 600; min-width: 35px;">30%</span>
</div>
<div class="voice-btn-group" style="margin-top: 10px;">
<button class="voice-btn play" id="btnPlayMusic" onclick="playMusic()"><i class="fas fa-play"></i> Putar</button>
<button class="voice-btn pause" id="btnPauseMusic" onclick="pauseMusic()" disabled><i class="fas fa-pause"></i> Pause</button>
<button class="voice-btn stop" id="btnStopMusic" onclick="stopMusic()" disabled><i class="fas fa-stop"></i> Stop</button>
<button class="voice-btn repeat" id="btnLoopMusic" onclick="toggleLoopMusic()" style="background: linear-gradient(135deg, #6366f1, #4f46e5);"><i class="fas fa-redo"></i> Rotasi: ON</button>
</div>
<div class="music-status" id="musicStatus" style="display: none;">
<i class="fas fa-music"></i> <span id="musicStatusText">Musik diputar</span>
</div>
<div style="margin-top: 12px; padding-top: 12px; border-top: 2px dashed #c7d2fe;">
<label class="voice-select-label">📺 Atau Putar YouTube:</label>
<div class="youtube-input-group">
<input type="text" class="youtube-input" id="youtubeUrl" placeholder="URL atau ID YouTube">
<button class="youtube-btn" onclick="playYouTube()"><i class="fab fa-youtube"></i> Putar</button>
</div>
<div class="voice-control-row" style="margin-top: 8px;">
<div class="voice-control-label">Volume YT</div>
<input type="range" min="0" max="100" value="100" id="youtubeVolumeSlider" oninput="setYouTubeVolume(this.value)">
<span id="youtubeVolumeValue" style="font-size: 11px; font-weight: 600; min-width: 35px;">100%</span>
</div>
<div class="youtube-status" id="youtubeStatus" style="display: none;">
<i class="fas fa-check-circle"></i> <span id="youtubeStatusText">YouTube diputar</span>
</div>
<button class="voice-btn stop" id="btnStopYouTube" onclick="stopYouTube()" disabled style="width: 100%; margin-top: 6px; padding: 6px; font-size: 10px;"><i class="fas fa-stop"></i> Stop YouTube</button>
</div>
</div>
<div class="gangguan-voice-control">
<div class="voice-control-title"><i class="fas fa-exclamation-triangle"></i> KONTROL SUARA GANGGUAN</div>
<div class="voice-select-group">
<label class="voice-select-label">🎤 Pilih Gender Suara Gangguan:</label>
<select class="voice-select" id="gangguanGenderSelect" onchange="updateGangguanGender()">
<option value="male">👨 Laki-laki</option>
<option value="female" selected>👩 Perempuan</option>
</select>
</div>
<div class="voice-select-group">
<label class="voice-select-label">🎤 Pilih Suara (5 Pilihan):</label>
<select class="voice-select" id="gangguanVoiceSelect" onchange="updateVoiceIndex()">
<option value="0">1. Default</option>
<option value="1">2. Alternatif 1</option>
<option value="2">3. Alternatif 2</option>
<option value="3" selected>4. Alternatif 3 ⭐</option>
<option value="4">5. Alternatif 4</option>
</select>
</div>
<div class="voice-btn-group">
<button class="voice-btn play" id="btnPlayGangguan" onclick="playGangguanVoice()" disabled><i class="fas fa-play"></i> Putar</button>
<button class="voice-btn pause" id="btnPauseGangguan" onclick="pauseGangguanVoice()" disabled><i class="fas fa-pause"></i> Pause</button>
<button class="voice-btn stop" id="btnStopGangguan" onclick="stopGangguanVoice()" disabled><i class="fas fa-stop"></i> Stop</button>
<button class="voice-btn repeat" id="btnRepeatGangguan" onclick="toggleRepeatGangguan()"><i class="fas fa-redo"></i> Ulang: OFF</button>
</div>
<div class="voice-status-indicator">
<div class="voice-status-dot" id="gangguanVoiceStatusDot"></div>
<span id="gangguanVoiceStatusText">Siap - Tidak ada gangguan aktif</span>
</div>
</div>
<div class="payment-voice-control">
<div class="voice-control-title"><i class="fas fa-money-bill-wave"></i> KONTROL SUARA PELANGGAN</div>
<div class="voice-select-group">
<label class="voice-select-label">🎤 Pilih Gender Suara Pembayaran:</label>
<select class="voice-select" id="paymentGenderSelect" onchange="updatePaymentGender()">
<option value="female" selected>👩 Perempuan</option>
<option value="male">👨 Laki-laki</option>
</select>
</div>
<div class="voice-select-group">
<label class="voice-select-label">🎤 Pilih Suara (5 Pilihan):</label>
<select class="voice-select" id="paymentVoiceSelect" onchange="updateVoiceIndex()">
<option value="0">1. Default</option>
<option value="1">2. Alternatif 1</option>
<option value="2">3. Alternatif 2</option>
<option value="3" selected>4. Alternatif 3 ⭐</option>
<option value="4">5. Alternatif 4</option>
</select>
</div>
<div class="voice-btn-group">
<button class="voice-btn play" id="btnPlayPayment" onclick="playLast5Payments()"><i class="fas fa-play"></i> 5 Terakhir</button>
<button class="voice-btn pause" id="btnPausePayment" onclick="pausePaymentVoice()" disabled><i class="fas fa-pause"></i> Pause</button>
<button class="voice-btn stop" id="btnStopPayment" onclick="stopPaymentVoice()" disabled><i class="fas fa-stop"></i> Stop</button>
<button class="voice-btn repeat" id="btnRepeatPayment" onclick="toggleRepeatPayment()"><i class="fas fa-redo"></i> Auto: OFF</button>
</div>
<div class="voice-status-indicator">
<div class="voice-status-dot" id="paymentVoiceStatusDot"></div>
<span id="paymentVoiceStatusText">Siap - Menunggu pembayaran</span>
</div>
</div>
<div class="scroll-control">
<div class="voice-control-title"><i class="fas fa-broadcast-tower"></i> LIVE DASHBOARD</div>
<div class="voice-control-row">
<div class="voice-control-label">Kecepatan</div>
<input type="range" min="3" max="20" value="7" id="liveSpeedSlider" oninput="setLiveSpeed(this.value)">
<span id="liveSpeedValue" style="font-size: 11px; font-weight: 600; min-width: 40px;">7 detik</span>
</div>
<div class="voice-btn-group" style="margin-top: 10px;">
<button class="voice-btn play" id="btnLiveStart" onclick="startLiveCycle()"><i class="fas fa-play"></i> Mulai</button>
<button class="voice-btn stop" id="btnLiveStop" onclick="stopLiveCycle()" disabled><i class="fas fa-stop"></i> Stop</button>
</div>
</div>
<div style="margin-top: 15px; padding: 15px; background: linear-gradient(135deg, #f1f5f9, #e2e8f0); border-radius: 12px; border: 2px solid #94a3b8;">
<div class="voice-control-title" style="color: #334155;"><i class="fas fa-cog"></i> PENGATURAN UMUM</div>
<div class="voice-control-row">
<div class="voice-control-label">Volume Suara</div>
<input type="range" min="0" max="100" value="80" id="volumeSlider" oninput="setVoiceVolume(this.value)">
<span id="volumeValue" style="font-size: 11px; font-weight: 600; min-width: 35px;">80%</span>
</div>
<button class="voice-test-btn" onclick="testVoice()"><i class="fas fa-play"></i> Test Suara</button>
</div>
<div class="scroll-control">
<div class="voice-control-title"><i class="fas fa-tachometer-alt"></i> KECEPATAN TULISAN BERJALAN</div>
<div class="voice-control-row">
<div class="voice-control-label">Kecepatan</div>
<input type="range" min="10" max="200" value="60" id="scrollSpeedSlider" oninput="setScrollSpeed(this.value)">
<span id="scrollSpeedValue" style="font-size: 11px; font-weight: 600; min-width: 80px;">Normal</span>
</div>
</div>
</div>
<div class="sidebar" id="sidebar">
<div class="sidebar-header"><h5><i class="fas fa-network-wired"></i> Informasi Jaringan</h5><small>Kecamatan Darmaraja, Kab. Sumedang</small></div>
<div class="sidebar-content" id="sidebarContent">
<!-- 🔥 SEARCH BOX -->
<div class="search-container">
<div class="search-title"><i class="fas fa-search"></i> Pencarian Pelanggan</div>
<div class="search-row">
<input type="text" class="search-input" id="searchInput" placeholder="No. Sambungan / Nama / Wilayah..." oninput="performSearch()">
<select class="search-select" id="searchFilter" onchange="performSearch()">
<option value="all">Semua Status</option>
<option value="Kantor">Kantor</option>
<option value="PPOB">PPOB</option>
<option value="Belum Bayar">Belum Bayar</option>
</select>
</div>
<div class="search-row">
<button class="search-btn" onclick="performSearch()"><i class="fas fa-search"></i> Cari</button>
<button class="search-btn clear" onclick="clearSearch()"><i class="fas fa-times"></i> Reset</button>
</div>
<div class="search-results" id="searchResults"></div>
</div>
<!-- 🔥 STATISTIK HARI INI -->
<div id="today-stats-card" class="revenue-card" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8); margin-bottom: 15px;">
<div class="revenue-title"><i class="fas fa-calendar-day"></i> <span id="today-date">Hari Ini</span></div>
<div class="revenue-amount" id="today-amount">Rp 0</div>
<div class="revenue-kubikasi"><i class="fas fa-users"></i> <strong id="today-count">0</strong> rekening • <strong id="today-kubikasi">0</strong> m³</div>
</div>
<div class="stats-grid">
<div class="stat-card stat-total"><i class="fas fa-list stat-icon"></i><div class="stat-value">{{ $stats['total'] ?? 0 }}</div><div class="stat-label">Total Gangguan</div></div>
<div class="stat-card stat-menunggu"><i class="fas fa-clock stat-icon"></i><div class="stat-value">{{ $stats['menunggu'] ?? 0 }}</div><div class="stat-label">Menunggu</div></div>
<div class="stat-card stat-proses"><i class="fas fa-spinner stat-icon"></i><div class="stat-value">{{ $stats['dalam_proses'] ?? 0 }}</div><div class="stat-label">Dalam Proses</div></div>
<div class="stat-card stat-selesai"><i class="fas fa-check stat-icon"></i><div class="stat-value">{{ $stats['selesai'] ?? 0 }}</div><div class="stat-label">Selesai</div></div>
</div>
<div class="stats-grid">
<div class="stat-card stat-jalur"><i class="fas fa-route stat-icon"></i><div class="stat-value">{{ ($jalurPipa ?? collect())->count() }}</div><div class="stat-label">Jalur Pipa</div></div>
<div class="stat-card stat-bangunan"><i class="fas fa-building stat-icon"></i><div class="stat-value">{{ ($bangunan ?? collect())->count() }}</div><div class="stat-label">Bangunan</div></div>
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
<div class="estimasi-item"><div class="estimasi-label"><i class="fas fa-tint-slash"></i> Potensi Kehilangan Air</div><div class="estimasi-value big">{{ number_format($gang->debit_bocor ?? 0, 0) }}<span class="unit">m³/jam</span></div><div class="estimasi-sub">Total: <strong>{{ number_format($gang->total_kehilangan_air ?? 0, 1) }} m³</strong> (durasi {{ $gang->durasi_jam ?? 0 }} jam)</div></div>
@if($gang->estimasi_selesai)
<div class="estimasi-item"><div class="estimasi-label"><i class="fas fa-calendar-check"></i> Estimasi Selesai</div><div class="estimasi-value" style="color: #059669;">{{ \Carbon\Carbon::parse($gang->estimasi_selesai)->format('d/m/Y') }}</div></div>
@endif
</div>
@if($gang->deskripsi)
<div style="margin-top: 10px; padding: 8px; background: #f1f5f9; border-radius: 6px;"><div style="font-size: 9px; color: #64748b; font-weight: 600; margin-bottom: 2px;"><i class="fas fa-info-circle"></i> DESKRIPSI</div><div style="font-size: 11px; color: #475569;">{{ Str::limit($gang->deskripsi, 80) }}</div></div>
@endif
</div>
</div>
@endif
@empty
<div class="empty-state"><i class="fas fa-check-circle" style="font-size: 32px; color: #10b981; margin-bottom: 8px;"></i><div>Tidak ada gangguan aktif</div><small style="color: #94a3b8;">Semua jaringan beroperasi normal</small></div>
@endforelse
<div class="section-title"><i class="fas fa-route"></i> Jalur Pipa</div>
@forelse($jalurPipa ?? [] as $jalur)
<div class="list-item" data-id="{{ $jalur->id }}" data-type="jalur" onclick="focusOnJalur({{ $jalur->id }})"><div class="layer-info"><div class="layer-name"><span class="color-dot" style="background: {{ $jalur->warna }};"></span> {{ $jalur->nama_jalur }}</div><div class="layer-meta"><i class="fas fa-ruler"></i> {{ $jalur->ukuran_pipa }}</div></div></div>
@empty
<div class="empty-state">Belum ada data jalur pipa</div>
@endforelse
<div class="section-title"><i class="fas fa-building"></i> Bangunan</div>
@forelse($bangunan ?? [] as $b)
<div class="list-item" data-id="{{ $b->id }}" data-type="bangunan" onclick="focusOnBangunan({{ $b->id }})"><div class="layer-info"><div class="layer-name"><span class="color-dot" style="background: {{ $b->warna }};"></span> {{ $b->nama_bangunan }}</div><div class="layer-meta"><i class="fas fa-tag"></i> {{ ucfirst(str_replace('_', ' ', $b->jenis_bangunan)) }}</div></div></div>
@empty
<div class="empty-state">Belum ada data bangunan</div>
@endforelse
<div class="section-title"><i class="fas fa-map-marked-alt text-primary"></i> Wilayah & Blok</div>
<div id="wilayah-blok-container">
<div class="text-center py-3 text-muted">
<i class="fas fa-spinner fa-spin"></i> Memuat data wilayah...
</div>
</div>
</div>
</div>
<div class="legend">
<div class="legend-title"><i class="fas fa-info-circle"></i> Legenda Peta</div>
<div class="legend-group"><div class="legend-group-title">Jalur Pipa</div><div class="legend-item"><div class="legend-color" style="background: #ef4444;"></div><span>Transmisi</span></div><div class="legend-item"><div class="legend-color" style="background: #3b82f6;"></div><span>Distribusi</span></div><div class="legend-item"><div class="legend-color" style="background: #10b981;"></div><span>Tersier</span></div></div>
<div class="legend-group"><div class="legend-group-title">Bangunan</div><div class="legend-item"><div class="legend-marker" style="background: #06b6d4;"><i class="fas fa-database"></i></div><span>Reservoir</span></div><div class="legend-item"><div class="legend-marker" style="background: #8b5cf6;"><i class="fas fa-industry"></i></div><span>IPA</span></div><div class="legend-item"><div class="legend-marker" style="background: #3b82f6;"><i class="fas fa-building"></i></div><span>Kantor</span></div></div>
<div class="legend-group"><div class="legend-group-title">Gangguan</div><div class="legend-item"><div class="legend-marker" style="background: #ef4444;"><i class="fas fa-exclamation"></i></div><span>Aktif (Merah)</span></div><div class="legend-item"><div class="legend-marker" style="background: #f59e0b;"><i class="fas fa-tools"></i></div><span>Proses (Kuning)</span></div><div class="legend-item"><div class="legend-marker" style="background: #10b981;"><i class="fas fa-check"></i></div><span>Selesai (Hijau)</span></div></div>
</div>
<div class="legend-pelanggan">
<div class="legend-pelanggan-title"><i class="fas fa-users"></i> Status Pembayaran</div>
<div class="legend-pelanggan-item"><div class="legend-pelanggan-marker" style="background: #10b981;"><i class="fas fa-building"></i></div><span>Bayar di Kantor</span></div>
<div class="legend-pelanggan-item"><div class="legend-pelanggan-marker" style="background: #f59e0b;"><i class="fas fa-mobile-alt"></i></div><span>Bayar di PPOB</span></div>
<div class="legend-pelanggan-item"><div class="legend-pelanggan-marker" style="background: #ef4444;"><i class="fas fa-times"></i></div><span>Belum Bayar</span></div>
</div>
</div>
<div class="modal fade" id="waQRModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered"><div class="modal-content wa-modal-content">
<div class="wa-modal-header"><i class="fab fa-whatsapp" style="font-size: 40px;"></i><h4 class="mt-2">WhatsApp PDAM Tirta Medal</h4><small>Scan QR Code atau klik tombol di bawah</small></div>
<div class="wa-qr-container"><div id="wa-qrcode"></div>
<div class="wa-info"><div class="wa-info-item"><i class="fas fa-phone"></i><span><strong>0812-3456-7890</strong></span></div><div class="wa-info-item"><i class="fas fa-clock"></i><span>Senin - Sabtu, 08.00 - 16.00 WIB</span></div><div class="wa-info-item"><i class="fas fa-info-circle"></i><span>Layanan pengaduan & informasi pelanggan</span></div></div>
<a href="https://wa.me/6281234567890?text=Halo%20PDAM%20Tirta%20Medal%2C%20saya%20ingin%20melaporkan%20gangguan" target="_blank" class="wa-btn-direct"><i class="fab fa-whatsapp"></i> Buka WhatsApp Langsung</a>
<button type="button" class="btn btn-light mt-2" data-bs-dismiss="modal" style="width: 100%;"><i class="fas fa-times"></i> Tutup</button>
</div></div></div>
</div>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
// ============================================
// 🔥 YOUTUBE IFRAME API
// ============================================
var tag = document.createElement('script');
tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
let ytPlayer = null;
let ytOriginalVolume = 100;
let ytUserVolume = 100;
let isYouTubeDucked = false;
let isYouTubeAPIReady = false;
function onYouTubeIframeAPIReady() {
isYouTubeAPIReady = true;
console.log('✅ YouTube IFrame API Ready');
}
// ============================================
// DATA DARI LARAVEL
// ============================================
const jalurPipaData = @json($jalurPipa ?? []);
const bangunanData = @json($bangunan ?? []);
const gangguanData = @json($gangguan ?? []);
const titikPentingData = @json($titikPenting ?? []);
const pelangganDataFromLaravel = @json($pelanggan ?? []);
// ============================================
// VARIABEL GLOBAL
// ============================================
let map, jalurLayers = {}, markerLayers = {}, pelangganLayers = {}, pelangganClusterGroup;
let isFullscreen = false, waQRGenerated = false, totalRevenue = 0, totalKubikasi = 0;
let currentLayer = 'satellite', baseLayers = {}, currentBaseLayer = null;
const voiceProfiles = [
{ name: 'Default', pitch: 1.0, rate: 0.95 },
{ name: 'Alternatif 1', pitch: 1.1, rate: 0.90 },
{ name: 'Alternatif 2', pitch: 0.9, rate: 1.00 },
{ name: 'Alternatif 3', pitch: 1.2, rate: 0.85 },
{ name: 'Alternatif 4', pitch: 0.8, rate: 1.05 }
];
const musicFolder = '/audio/';
const musicPlaylist = ['musik1.mp3', 'musik2.mp3', 'musik3.mp3', 'musik4.mp3', 'musik5.mp3'];
const musicNames = {
'musik1.mp3': 'Musik 1 (Tenang)',
'musik2.mp3': 'Musik 2 (Semangat)',
'musik3.mp3': 'Musik 3 (Klasik)',
'musik4.mp3': 'Musik 4 (Alam)',
'musik5.mp3': 'Musik 5 (Lo-Fi)'
};
let currentPlaylistIndex = 0;
let autoRotateMusic = true;
let voiceSettings = {
enabled: true, volume: 0.8,
gangguanGender: 'female', gangguanVoiceIndex: 3,
paymentGender: 'female', paymentVoiceIndex: 3
};
let availableVoices = [];
let indonesianVoices = [], indonesianFemaleVoices = [], indonesianMaleVoices = [];
const ID_KEYWORDS = ['indonesia', 'bahasa indonesia', 'id-id', 'indonesian', 'damayanti', 'andika', 'ardian', 'gadis', 'ardi', 'bimo', 'siti', 'ratu'];
const FEMALE_KEYWORDS = ['female', 'wanita', 'perempuan', 'woman', 'girl', 'damayanti', 'gadis', 'siti', 'ratu', 'samantha', 'victoria', 'zira'];
const MALE_KEYWORDS = ['male', 'pria', 'laki', 'man', 'boy', 'andika', 'ardian', 'ardi', 'bimo', 'david', 'mark', 'daniel'];
let gangguanVoiceInterval = null, isGangguanVoicePlaying = false, isGangguanVoicePaused = false, repeatGangguanVoice = false, activeGangguanList = [];
let paymentVoiceInterval = null, isPaymentVoicePlaying = false, isPaymentVoicePaused = false, repeatPaymentVoice = false, last5Payments = [], currentPaymentIndex = 0;
let lastActivityTime = Date.now(), sidebarScrollDirection = 1, sidebarScrollInterval, isSidebarAutoScrolling = false;
let isMusicPlaying = false, isMusicPaused = false, musicLoop = true;
let currentMusicType = '';
let isYouTubePlaying = false;
let unpaidCustomerMarkers = [], unpaidCustomerList = [];
let liveCycleInterval = null, liveCycleIndex = 0, liveCycleSpeed = 7000;
let isLiveDashboardActive = false, highlightedMarkerElement = null;
let voiceQueue = [];
let isVoiceSpeaking = false;

// ============================================
// 🔥 FUNGSI HITUNG PENDAPATAN BULANAN
// ============================================
function calculateMonthlyRevenue() {
    const now = new Date();
    const currentYear = now.getFullYear();
    const currentMonth = now.getMonth();
    const currentDay = now.getDate();
    
    // Hitung jumlah hari dalam bulan ini
    const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
    const remainingDays = daysInMonth - currentDay;
    
    let totalTarget = 0;
    let totalCollected = 0;
    let totalUnpaid = 0;
    
    pelangganDataFromLaravel.forEach(p => {
        const jumlah = parseFloat(p.jumlah) || 0;
        const pakai = parseFloat(p.pakai) || 0;
        
        // Hitung tagihan dengan denda dan materai
        let tagihanFinal = jumlah;
        
        // Cek apakah sudah bayar
        const hasLoket = p.tanggal_pembayaran_loket && p.tanggal_pembayaran_loket !== '-' && p.tanggal_pembayaran_loket !== '.' && p.tanggal_pembayaran_loket !== null;
        const hasPPOB = p.tanggal_pembayaran_ppob && p.tanggal_pembayaran_ppob !== '-' && p.tanggal_pembayaran_ppob !== '.' && p.tanggal_pembayaran_ppob !== null;
        
        if (hasLoket || hasPPOB) {
            // Sudah bayar
            totalCollected += jumlah;
        } else {
            // Belum bayar - hitung dengan denda
            // Tagihan otomatis > tanggal 20 setiap bulan tambah 5000
            if (currentDay > 20) {
                tagihanFinal += 5000; // Denda keterlambatan
            }
            
            // Pembayaran > 1.000.000 tambah denda dan materai 10000
            if (jumlah > 1000000) {
                tagihanFinal += 10000; // Materai
            }
            
            totalUnpaid += tagihanFinal;
        }
        
        totalTarget += jumlah;
    });
    
    const percentage = totalTarget > 0 ? (totalCollected / totalTarget) * 100 : 0;
    const dailyTarget = remainingDays > 0 ? totalUnpaid / remainingDays : 0;
    
    return {
        totalTarget,
        totalCollected,
        totalUnpaid,
        percentage,
        currentDay,
        daysInMonth,
        remainingDays,
        dailyTarget
    };
}

function updateRevenueProgress() {
    const stats = calculateMonthlyRevenue();
    
    // Update progress bar
    const progressBar = document.getElementById('revenueProgressBar');
    const progressPercentage = document.getElementById('revenueProgressPercentage');
    progressBar.style.width = stats.percentage.toFixed(1) + '%';
    progressPercentage.textContent = stats.percentage.toFixed(1) + '%';
    
    // Update stats
    document.getElementById('currentDayOfMonth').textContent = stats.currentDay;
    document.getElementById('remainingDays').textContent = stats.remainingDays;
    document.getElementById('targetRevenue').textContent = formatRupiah(stats.totalTarget);
    document.getElementById('collectedRevenue').textContent = formatRupiah(stats.totalCollected);
    document.getElementById('remainingRevenue').textContent = formatRupiah(stats.totalUnpaid);
    document.getElementById('dailyTarget').textContent = formatRupiah(stats.dailyTarget);
}

// ============================================
// 🔥 FUNGSI NORMALISASI TEKS - NAMA DIBACA NORMAL
// ============================================
function cleanSpacedLetters(text) {
if (!text) return text;
const parts = text.trim().split(/\s+/);
if (parts.length >= 2 && parts.every(p => p.length === 1 && /^[A-Za-z]$/.test(p))) {
const joined = parts.join('');
return joined.charAt(0).toUpperCase() + joined.slice(1).toLowerCase();
}
return text;
}
function toTitleCase(str) {
if (!str) return str;
return str.replace(/\w\S*/g, (txt) => txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase());
}
function normalizePPOB(text) {
if (!text) return text;
return text.replace(/\bPPOB\b/gi, 'P. P. O. B.');
}
function normalizeTextForSpeech(text) {
if (!text) return text;
text = normalizePPOB(text);
text = text.replace(/\b([A-Z]{3,})\b/g, (word) => {
if (word.includes('.')) return word;
return word.charAt(0) + word.slice(1).toLowerCase();
});
return text;
}
function convertRegionRomanToNumber(regionName) {
if (!regionName) return regionName;
const romanMap = { 'X': '10', 'IX': '9', 'VIII': '8', 'VII': '7', 'VI': '6', 'V': '5', 'IV': '4', 'III': '3', 'II': '2', 'I': '1' };
const romanPattern = /\b(X|IX|VIII|VII|VI|V|IV|III|II|I)\b/g;
return regionName.replace(romanPattern, (match) => romanMap[match] || match);
}
// 🔥 FUNGSI PENGUCAPAN NAMA - DIBACA NORMAL (TIDAK DIEJA)
function formatNameForSpeech(name, gender) {
if (!name) return 'Pelanggan';
// 🔥 Bersihkan nama, hilangkan spasi berlebih, baca normal
let cleanName = name.trim().replace(/\s+/g, ' ');
// Title case agar TTS membaca dengan intonasi yang benar
cleanName = toTitleCase(cleanName.toLowerCase());
return cleanName;
}
// ============================================
// UTILITY FUNCTIONS
// ============================================
function parseKoordinator(s) {
try {
if (!s) return null;
const c = s.split(',').map(x => parseFloat(x.trim()));
return (c.length === 2 && !isNaN(c[0]) && !isNaN(c[1])) ? c : null;
} catch(e) { return null; }
}
function formatRupiah(a) {
if (!a || a === 0) return 'Rp 0';
return 'Rp ' + parseInt(a).toLocaleString('id-ID');
}
function formatRupiahMasked(a) {
if (!a || a === 0) return 'Rp 0';
let formatted = parseInt(a).toLocaleString('id-ID');
return 'Rp ' + formatted.replace(/\d/g, '*');
}
function formatDate(s) {
if (!s || s === '-' || s === '.') return '-';
return new Date(s).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
}
function getStatusColor(g) {
const c = { 'R1': '#3b82f6', 'R2': '#60a5fa', 'R3': '#93c5fd', 'B1': '#10b981', 'B2': '#34d399', 'B3': '#6ee7b7', 'I1': '#f59e0b', 'I2': '#fbbf24', 'I3': '#fcd34d', 'S1': '#8b5cf6', 'S2': '#a78bfa' };
return c[g] || '#6b7280';
}
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
const icons = { 'success': 'fa-check-circle', 'info': 'fa-info-circle', 'warning': 'fa-exclamation-triangle', 'live': 'fa-broadcast-tower' };
toast.innerHTML = `<i class="fas ${icons[type] || 'fa-info-circle'}"></i><span>${msg}</span>`;
document.body.appendChild(toast);
setTimeout(() => { toast.style.animation = 'toastSlide 0.3s ease reverse'; setTimeout(() => toast.remove(), 300); }, 3000);
}
// ============================================
// 🔥 STATISTIK HARI INI
// ============================================
function calculateTodayStats() {
const now = new Date();
const todayStr = now.toISOString().split('T')[0]; // YYYY-MM-DD
let totalToday = 0;
let countToday = 0;
let kubikasiToday = 0;
pelangganDataFromLaravel.forEach(p => {
const status = getPaymentStatus(p);
if (status.tanggal) {
const payDate = new Date(status.tanggal);
const payDateStr = payDate.toISOString().split('T')[0];
if (payDateStr === todayStr) {
totalToday += parseFloat(p.jumlah) || 0;
kubikasiToday += parseFloat(p.pakai) || 0;
countToday++;
}
}
});
return { totalToday, countToday, kubikasiToday, todayStr };
}
function updateTodayStatsDisplay() {
const stats = calculateTodayStats();
const now = new Date();
const dateStr = now.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
document.getElementById('today-date').textContent = dateStr;
document.getElementById('today-amount').textContent = formatRupiah(stats.totalToday);
document.getElementById('today-count').textContent = stats.countToday;
document.getElementById('today-kubikasi').textContent = stats.kubikasiToday.toFixed(1);
}
// ============================================
// 🔥 FITUR PENCARIAN
// ============================================
function performSearch() {
const query = document.getElementById('searchInput').value.trim().toLowerCase();
const filter = document.getElementById('searchFilter').value;
const resultsContainer = document.getElementById('searchResults');
if (!query && filter === 'all') {
resultsContainer.innerHTML = '<div class="search-empty">Ketik untuk mencari pelanggan</div>';
return;
}
let results = pelangganDataFromLaravel.filter(p => {
const status = getPaymentStatus(p);
// Filter status
if (filter !== 'all' && status.status !== filter) return false;
// Filter query
if (!query) return true;
const noSamb = (p.no_pelanggan || '').toLowerCase();
const nama = (p.nama || '').toLowerCase();
const wilayah = (p.nama_wilayah || '').toLowerCase();
const alamat = (p.lokasi || p.alamat || '').toLowerCase();
return noSamb.includes(query) || nama.includes(query) || wilayah.includes(query) || alamat.includes(query);
});
if (results.length === 0) {
resultsContainer.innerHTML = '<div class="search-empty">Tidak ditemukan pelanggan</div>';
return;
}
// Batasi hasil max 20
results = results.slice(0, 20);
let html = '';
results.forEach(p => {
const status = getPaymentStatus(p);
const statusColor = status.color;
const statusIcon = status.icon;
html += `
<div class="search-result-item" onclick="focusOnPelanggan('${p.no_pelanggan}')">
<div>
<div class="sr-name"><i class="fas ${statusIcon}" style="color: ${statusColor};"></i> ${p.nama || 'Tanpa Nama'}</div>
<div class="sr-detail">No: ${p.no_pelanggan} • ${p.nama_wilayah || '-'}</div>
</div>
<div class="sr-badge" style="background: ${statusColor};">${status.status}</div>
</div>
`;
});
resultsContainer.innerHTML = html;
}
function clearSearch() {
document.getElementById('searchInput').value = '';
document.getElementById('searchFilter').value = 'all';
document.getElementById('searchResults').innerHTML = '<div class="search-empty">Ketik untuk mencari pelanggan</div>';
// Reset filter peta
resetPelangganFilter();
}
function focusOnPelanggan(noPelanggan) {
const data = pelangganLayers[`pelanggan_${noPelanggan}`];
if (data && data.coords) {
map.flyTo(data.coords, 18, { duration: 1 });
setTimeout(() => {
data.marker.openPopup();
}, 1000);
showNotification(`📍 Menuju pelanggan: ${noPelanggan}`, 'info');
} else {
// Cari di unpaid list
const unpaid = unpaidCustomerList.find(u => u.data.no_pelanggan === noPelanggan);
if (unpaid) {
map.flyTo(unpaid.coords, 18, { duration: 1 });
setTimeout(() => {
unpaid.marker.openPopup();
}, 1000);
showNotification(`📍 Menuju pelanggan: ${noPelanggan}`, 'info');
} else {
showNotification('Koordinat pelanggan tidak ditemukan', 'warning');
}
}
}
// ============================================
// LAYER CONTROL
// ============================================
function initBaseLayers() {
baseLayers = {
street: L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19, attribution: '© OpenStreetMap' }),
satellite: L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', { maxZoom: 19, attribution: '© Esri' }),
terrain: L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', { maxZoom: 17, attribution: '© OpenTopoMap' }),
dark: L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', { maxZoom: 19, attribution: '© CARTO' })
};
}
function switchLayer(name) {
if (!baseLayers[name]) return;
if (currentBaseLayer) map.removeLayer(currentBaseLayer);
currentBaseLayer = baseLayers[name];
currentBaseLayer.addTo(map);
currentLayer = name;
document.querySelectorAll('.layer-btn').forEach(b => b.classList.remove('active'));
document.querySelector(`.layer-btn[data-layer="${name}"]`).classList.add('active');
showNotification(`Beralih ke ${name}`, 'info');
}
// ============================================
// 🔥 YOUTUBE VOLUME DUCKING
// ============================================
function duckYouTubeVolume() {
if (ytPlayer && isYouTubePlaying && !isYouTubeDucked && typeof ytPlayer.setVolume === 'function') {
try {
ytOriginalVolume = ytPlayer.getVolume();
const duckedVol = Math.max(5, Math.floor(ytUserVolume * 0.15));
ytPlayer.setVolume(duckedVol);
isYouTubeDucked = true;
} catch(e) { console.warn('YT duck error:', e); }
}
}
function restoreYouTubeVolume() {
if (ytPlayer && isYouTubeDucked && typeof ytPlayer.setVolume === 'function') {
try {
ytPlayer.setVolume(ytUserVolume);
isYouTubeDucked = false;
} catch(e) { console.warn('YT restore error:', e); }
}
}
function setYouTubeVolume(v) {
ytUserVolume = parseInt(v);
document.getElementById('youtubeVolumeValue').textContent = v + '%';
if (ytPlayer && isYouTubePlaying && !isYouTubeDucked && typeof ytPlayer.setVolume === 'function') {
try { ytPlayer.setVolume(ytUserVolume); } catch(e) {}
}
}
// ============================================
// SISTEM ANTRIAN SUARA
// ============================================
function addToVoiceQueue(text, gender = 'female', callback = null) {
voiceQueue.push({ text, gender, callback });
processVoiceQueue();
}
function processVoiceQueue() {
if (isVoiceSpeaking || voiceQueue.length === 0) return;
isVoiceSpeaking = true;
const item = voiceQueue.shift();
speak(item.text, item.gender, () => {
isVoiceSpeaking = false;
if (item.callback) item.callback();
setTimeout(() => processVoiceQueue(), 500);
});
}
function clearVoiceQueue() {
voiceQueue = [];
isVoiceSpeaking = false;
speechSynthesis.cancel();
}
// ============================================
// WILAYAH & BLOK
// ============================================
async function loadWilayahDanBlok() {
const container = document.getElementById('wilayah-blok-container');
try {
const dataWilayah = [
{ id: 1, nama_wilayah: 'Wilayah I', blok: [
{ nama_blok: 'Blok A', jumlah_pelanggan: 125 },
{ nama_blok: 'Blok B', jumlah_pelanggan: 98 },
{ nama_blok: 'Blok C', jumlah_pelanggan: 156 },
{ nama_blok: 'Blok D', jumlah_pelanggan: 87 }
]},
{ id: 2, nama_wilayah: 'Wilayah II', blok: [
{ nama_blok: 'Blok E', jumlah_pelanggan: 143 },
{ nama_blok: 'Blok F', jumlah_pelanggan: 76 }
]}
];
let html = '';
dataWilayah.forEach(wilayah => {
const totalPelangganWilayah = wilayah.blok.reduce((sum, blok) => sum + blok.jumlah_pelanggan, 0);
html += `<div class="wilayah-card"><div class="wilayah-header"><span><i class="fas fa-map-marker-alt"></i> ${wilayah.nama_wilayah}</span><span style="background: rgba(255,255,255,0.2); padding: 2px 8px; border-radius: 12px; font-size: 11px;">${totalPelangganWilayah} Pelanggan</span></div><div class="wilayah-blok-list">`;
wilayah.blok.forEach(blok => {
html += `<div class="blok-item"><div style="display: flex; align-items: center; gap: 8px;"><i class="fas fa-layer-group" style="color: #3b82f6; font-size: 10px;"></i><span style="font-weight: 600; color: #1e293b;">${blok.nama_blok}</span></div><div style="display: flex; align-items: center; gap: 6px;"><span style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 2px 8px; border-radius: 10px; font-weight: 700; font-size: 11px;">${blok.jumlah_pelanggan}</span><span style="color: #64748b; font-size: 10px;">pelanggan</span></div></div>`;
});
html += `</div></div>`;
});
container.innerHTML = html;
} catch (error) {
console.error('Error loading wilayah dan blok:', error);
container.innerHTML = `<div class="alert alert-danger" style="font-size: 12px;"><i class="fas fa-exclamation-triangle"></i> Gagal memuat data wilayah</div>`;
}
}
// ============================================
// 🔥 STATISTIK BULANAN PER WILAYAH + SYNC MAP
// ============================================
function calculateMonthlyWilayahStats() {
const now = new Date();
const firstDayOfMonth = new Date(now.getFullYear(), now.getMonth(), 1);
const wilayahStats = {};
let totalPelanggan = 0;
let totalKubikasi = 0;
let totalAmount = 0;
pelangganDataFromLaravel.forEach(p => {
const status = getPaymentStatus(p);
if (status.tanggal) {
const paymentDate = new Date(status.tanggal);
if (paymentDate >= firstDayOfMonth) {
totalPelanggan++;
const kubikasi = parseFloat(p.pakai) || 0;
const jumlah = parseFloat(p.jumlah) || 0;
totalKubikasi += kubikasi;
totalAmount += jumlah;
let wilayah = p.nama_wilayah || 'Tidak Diketahui';
wilayah = convertRegionRomanToNumber(wilayah);
if (!wilayahStats[wilayah]) {
wilayahStats[wilayah] = { count: 0, amount: 0, kubikasi: 0, coords: [] };
}
wilayahStats[wilayah].count++;
wilayahStats[wilayah].amount += jumlah;
wilayahStats[wilayah].kubikasi += kubikasi;
// 🔥 KUMPULKAN KOORDINAT UNTUK ZOOM
const coords = parseKoordinator(p.koordinator);
if (coords && isInArea(coords[0], coords[1])) {
wilayahStats[wilayah].coords.push(coords);
}
}
}
});
return { totalPelanggan, totalKubikasi, totalAmount, wilayahStats };
}
// 🔥 NARASI BULANAN DENGAN ZOOM PETA PER WILAYAH
function narrateMonthlyStats(callback) {
const stats = calculateMonthlyWilayahStats();
const wilayahEntries = Object.entries(stats.wilayahStats);
const totalWilayah = wilayahEntries.length;
const introText = `Sampai dengan hari ini, tanggal ${new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })}, jumlah pelanggan yang sudah melakukan pembayaran sebanyak ${stats.totalPelanggan} rekening, dengan total penerimaan ${formatRupiah(stats.totalAmount)}.`;
addToVoiceQueue(introText, voiceSettings.paymentGender, () => {
if (wilayahEntries.length === 0) {
if (callback) callback();
return;
}
let index = 0;
function narrateNextWilayah() {
if (index >= wilayahEntries.length) {
// 🔥 KEMBALI KE TAMPILAN AWAL
map.flyTo([-6.88, 107.97], 14, { duration: 1.5 });
const summaryText = `Total keseluruhan: ${stats.totalPelanggan} rekening, dengan pemakaian ${stats.totalKubikasi.toFixed(1)} meter kubik, dan total penerimaan ${formatRupiah(stats.totalAmount)}.`;
addToVoiceQueue(summaryText, voiceSettings.paymentGender, callback);
return;
}
const [wilayah, data] = wilayahEntries[index];
// 🔥 ZOOM KE WILAYAH DI PETA
if (data.coords.length > 0) {
const bounds = L.latLngBounds(data.coords);
map.flyToBounds(bounds, { padding: [80, 80], duration: 1.5, maxZoom: 16 });
}
const text = `Untuk ${wilayah}, total jumlah rekening ${data.count}, dengan pemakaian ${data.kubikasi.toFixed(1)} meter kubik, dan ${formatRupiah(data.amount)}.`;
addToVoiceQueue(text, voiceSettings.paymentGender, () => {
index++;
if (index < wilayahEntries.length) {
setTimeout(() => {
addToVoiceQueue('Kita lanjut ke wilayah berikutnya.', voiceSettings.paymentGender, narrateNextWilayah);
}, 1500);
} else {
narrateNextWilayah();
}
});
}
narrateNextWilayah();
});
}
// ============================================
// LIVE DASHBOARD FUNCTIONS
// ============================================
function createUnpaidMarker(pelanggan, coords) {
const nama = pelanggan.nama || 'Tanpa Nama';
const jumlah = parseFloat(pelanggan.jumlah) || 0;
const noPelanggan = pelanggan.no_pelanggan || '-';
let wilayah = pelanggan.nama_wilayah || 'Tidak Diketahui';
wilayah = convertRegionRomanToNumber(wilayah);
const html = `
<div class="unpaid-marker-wrapper" data-no-pelanggan="${noPelanggan}">
<div class="unpaid-marker-label">${nama}</div>
<div class="unpaid-marker-pulse"></div>
<div class="unpaid-marker-pin"><i class="fas fa-exclamation"></i></div>
<div class="unpaid-marker-amount">${formatRupiah(jumlah)}</div>
</div>
`;
return L.marker(coords, {
icon: L.divIcon({ className: 'custom-div-icon', html: html, iconSize: [100, 60], iconAnchor: [50, 30] }),
zIndexOffset: 1000
});
}
function loadUnpaidCustomerMarkers() {
unpaidCustomerMarkers.forEach(m => map.removeLayer(m));
unpaidCustomerMarkers = [];
unpaidCustomerList = [];
pelangganDataFromLaravel.forEach(p => {
const status = getPaymentStatus(p);
if (status.status === 'Belum Bayar') {
const coords = parseKoordinator(p.koordinator);
if (!coords || !isInArea(coords[0], coords[1])) return;
const marker = createUnpaidMarker(p, coords);
let wilayah = p.nama_wilayah || 'Tidak Diketahui';
wilayah = convertRegionRomanToNumber(wilayah);
marker.bindPopup(`
<div style="min-width: 250px; font-family: 'Inter', sans-serif;">
<div style="background: linear-gradient(135deg, #ef4444, #dc2626); color: white; padding: 10px; border-radius: 8px 8px 0 0; font-weight: 700;">
<i class="fas fa-exclamation-triangle"></i> BELUM BAYAR
</div>
<div style="padding: 12px;">
<div style="font-size: 16px; font-weight: 700; color: #1e293b; margin-bottom: 8px;">${p.nama || 'Tanpa Nama'}</div>
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; font-size: 12px;">
<div><strong>No:</strong> ${p.no_pelanggan}</div>
<div><strong>Gol:</strong> ${p.kode_gol_trf || '-'}</div>
<div style="grid-column: span 2;"><strong>Wilayah:</strong> ${wilayah}</div>
</div>
<div style="margin-top: 10px; padding: 10px; background: #fef2f2; border-radius: 8px; border: 2px solid #fecaca;">
<div style="font-size: 10px; color: #991b1b; font-weight: 600;">TAGIHAN</div>
<div style="font-size: 18px; font-weight: 800; color: #dc2626;">${formatRupiah(p.jumlah)}</div>
<div style="font-size: 11px; color: #7f1d1d;">${parseFloat(p.pakai) || 0} m³</div>
</div>
</div>
</div>
`, { maxWidth: 280 });
marker.addTo(map);
unpaidCustomerMarkers.push(marker);
unpaidCustomerList.push({
marker: marker, coords: coords, data: p,
nama: p.nama || 'Tanpa Nama',
jumlah: parseFloat(p.jumlah) || 0,
wilayah: wilayah
});
}
});
document.getElementById('liveCounterTotal').textContent = unpaidCustomerList.length;
}
function syncNotificationBarWithMarker(customer) {
const content = document.getElementById('notificationContent');
if (!content) return;
content.querySelectorAll('.notification-item').forEach(item => {
item.classList.remove('active-sync');
});
const items = content.querySelectorAll('.notification-item');
items.forEach(item => {
const nama = item.querySelector('strong')?.textContent?.trim();
if (nama === customer.nama) {
item.classList.add('active-sync');
}
});
}
function highlightUnpaidMarker(index) {
if (highlightedMarkerElement) highlightedMarkerElement.classList.remove('highlighted');
if (index < 0 || index >= unpaidCustomerList.length) return;
const customer = unpaidCustomerList[index];
const marker = customer.marker;
if (voiceSettings.enabled) {
const namaNormal = formatNameForSpeech(customer.nama, voiceSettings.paymentGender);
// 1. Sekarang NAMA menjadi Kalimat Ke-1 (Pembuka)
const kalimatPembuka = `Pelanggan atas nama ${namaNormal}, di ${customer.wilayah}.`;
// 2. Sekarang TAGIHAN menjadi Kalimat Ke-2 (Detail saat meluncur)
const kalimatDetail = `Belum membayar tagihan sebesar ${formatRupiah(customer.jumlah)}`;
// 🔊 Suara Ke-1 (Nama Pelanggan) diucapkan saat peta masih diam
speak(kalimatPembuka, voiceSettings.paymentGender, function() {
// 🔥 CALLBACK 1: Berjalan TEPAT setelah suara NAMA PELANGGAN selesai!
// Peta mulai meluncur (memakan waktu 1.5 detik)
map.flyTo(customer.coords, 18, { duration: 1.5 });
// 🔊 Suara Ke-2 (Jumlah Tagihan) keluar barengan saat peta meluncur
speak(kalimatDetail, voiceSettings.paymentGender, function() {
// 🔥 CALLBACK 2: Berjalan TEPAT setelah suara JUMLAH TAGIHAN selesai!
if (isLiveDashboardActive) {
if (liveCycleInterval) clearTimeout(liveCycleInterval);
liveCycleInterval = setTimeout(() => {
liveCycleIndex = (liveCycleIndex + 1) % unpaidCustomerList.length;
highlightUnpaidMarker(liveCycleIndex);
}, 3000); // Jeda istirahat 3 detik sebelum lanjut ke pelanggan berikutnya
}
});
// Buka balon info (popup) setelah peta selesai meluncur (1500ms)
setTimeout(() => {
marker.openPopup();
}, 1500);
});
} else {
// Jika fitur suara mati, jalankan perpindahan peta secara normal (langsung)
map.flyTo(customer.coords, 18, { duration: 1.5 });
setTimeout(() => {
marker.openPopup();
if (isLiveDashboardActive) {
if (liveCycleInterval) clearTimeout(liveCycleInterval);
liveCycleInterval = setTimeout(() => {
liveCycleIndex = (liveCycleIndex + 1) % unpaidCustomerList.length;
highlightUnpaidMarker(liveCycleIndex);
}, liveCycleSpeed);
}
}, 1500);
}
// Pembaruan UI lainnya tetap berjalan langsung di latar belakang
updateLiveInfoPanel(customer, index);
syncNotificationBarWithMarker(customer);
}
function startLiveCycle() {
if (unpaidCustomerList.length === 0) {
showNotification('Tidak ada pelanggan belum bayar', 'warning');
return;
}
// Gunakan clearTimeout karena kita beralih dari setInterval ke setTimeout dinamis
if (liveCycleInterval) clearTimeout(liveCycleInterval);
isLiveDashboardActive = true;
liveCycleIndex = 0;
// Mulai pemicu pertama, siklus selanjutnya diatur otomatis oleh callback di dalam fungsi highlightUnpaidMarker
highlightUnpaidMarker(liveCycleIndex);
document.getElementById('btnLiveStart').disabled = true;
document.getElementById('btnLiveStop').disabled = false;
document.getElementById('liveBtn').classList.add('active');
document.getElementById('liveText').textContent = 'LIVE ON';
showNotification(`🔴 LIVE MODE: Auto-cycle ${unpaidCustomerList.length} pelanggan belum bayar`, 'live');
}
function updateLiveInfoPanel(customer, index) {
const panel = document.getElementById('liveInfoPanel');
if (!panel) return;
panel.style.display = 'flex';
document.getElementById('liveCustomerName').textContent = customer.nama;
document.getElementById('liveCustomerDetail').textContent = `${customer.wilayah} • No. ${customer.data.no_pelanggan}`;
document.getElementById('liveCustomerAmount').textContent = formatRupiah(customer.jumlah);
document.getElementById('liveCounterCurrent').textContent = (index + 1);
document.getElementById('liveCounterTotal').textContent = unpaidCustomerList.length;
}
function stopLiveCycle() {
if (liveCycleInterval) { clearInterval(liveCycleInterval); liveCycleInterval = null; }
isLiveDashboardActive = false;
if (highlightedMarkerElement) {
highlightedMarkerElement.classList.remove('highlighted');
highlightedMarkerElement = null;
}
const content = document.getElementById('notificationContent');
if (content) {
content.querySelectorAll('.notification-item').forEach(item => {
item.classList.remove('active-sync');
});
}
document.getElementById('btnLiveStart').disabled = false;
document.getElementById('btnLiveStop').disabled = true;
document.getElementById('liveBtn').classList.remove('active');
document.getElementById('liveText').textContent = 'LIVE OFF';
document.getElementById('liveInfoPanel').style.display = 'none';
map.flyTo([-6.88, 107.97], 14, { duration: 1 });
showNotification('⏸️ LIVE MODE dimatikan', 'info');
}
function toggleLiveDashboard() {
if (isLiveDashboardActive) stopLiveCycle();
else startLiveCycle();
}
function setLiveSpeed(v) {
liveCycleSpeed = v * 1000;
document.getElementById('liveSpeedValue').textContent = v + ' detik';
if (isLiveDashboardActive && liveCycleInterval) {
clearInterval(liveCycleInterval);
liveCycleInterval = setInterval(() => {
liveCycleIndex = (liveCycleIndex + 1) % unpaidCustomerList.length;
highlightUnpaidMarker(liveCycleIndex);
}, liveCycleSpeed);
}
}
// ============================================
// 🔥 AUTO NARASI BERURUTAN
// ============================================
function startAutoNarration() {
clearVoiceQueue();
stopLiveCycle();
const recentOfficePayment = pelangganDataFromLaravel
.filter(p => getPaymentStatus(p).metode === 'Kantor' && getPaymentStatus(p).tanggal)
.sort((a, b) => new Date(getPaymentStatus(b).tanggal) - new Date(getPaymentStatus(a).tanggal))[0];
let firstCallback = () => {
narrateMonthlyStats(() => {
narrateTunggakan(() => {
addToVoiceQueue('Sekarang kami tampilkan data pelanggan yang belum melakukan pembayaran.', voiceSettings.paymentGender, () => {
setTimeout(() => {
if (unpaidCustomerList.length > 0) {
startLiveCycle();
}
}, 2000);
});
});
});
};
addToVoiceQueue('Selamat datang di sistem monitoring PDAM UP Darmaraja.', voiceSettings.paymentGender, () => {
if (recentOfficePayment) {
addToVoiceQueue(formatPaymentVoiceText(recentOfficePayment), voiceSettings.paymentGender, firstCallback);
} else {
firstCallback();
}
});
}
function narrateTunggakan(callback) {
const unpaidData = calculateUnpaidBillsByRegion();
if (unpaidData.totalUnpaid > 0) {
let text = `Sisa tunggakan saat ini sebanyak ${unpaidData.totalUnpaid} rekening, dengan total nominal ${formatRupiah(unpaidData.totalAmount)}. Mohon kepada para pelanggan yang belum melakukan pembayaran, agar segera melunasi tagihan.`;
addToVoiceQueue(text, voiceSettings.paymentGender, callback);
} else {
if (callback) callback();
}
}
function calculateUnpaidBillsByRegion() {
const unpaidByRegion = {};
let totalUnpaid = 0, totalAmount = 0;
pelangganDataFromLaravel.forEach(p => {
const status = getPaymentStatus(p);
if (status.status === 'Belum Bayar') {
let wilayah = p.nama_wilayah || 'Tidak Diketahui';
wilayah = convertRegionRomanToNumber(wilayah);
if (!unpaidByRegion[wilayah]) {
unpaidByRegion[wilayah] = { count: 0, amount: 0, names: [] };
}
unpaidByRegion[wilayah].count++;
unpaidByRegion[wilayah].amount += parseFloat(p.jumlah) || 0;
totalUnpaid++;
totalAmount += parseFloat(p.jumlah) || 0;
}
});
return { byRegion: unpaidByRegion, totalUnpaid, totalAmount };
}
// ============================================
// 🔥 VOICE SYSTEM
// ============================================
function isIndonesianVoice(voice) {
if (!voice) return false;
const lang = (voice.lang || '').toLowerCase();
const name = (voice.name || '').toLowerCase();
if (lang === 'id-id' || lang === 'id' || lang.startsWith('id-') || lang.startsWith('id_')) return true;
for (const keyword of ID_KEYWORDS) { if (name.includes(keyword)) return true; }
return false;
}
function detectGender(voice) {
if (!voice) return 'unknown';
const name = (voice.name || '').toLowerCase();
for (const keyword of FEMALE_KEYWORDS) { if (name.includes(keyword)) return 'female'; }
for (const keyword of MALE_KEYWORDS) { if (name.includes(keyword)) return 'male'; }
return 'unknown';
}
function loadVoices() {
if (!('speechSynthesis' in window)) return;
availableVoices = speechSynthesis.getVoices();
if (availableVoices.length === 0) {
speechSynthesis.onvoiceschanged = () => { availableVoices = speechSynthesis.getVoices(); categorizeIndonesianVoices(); };
} else { categorizeIndonesianVoices(); }
}
function categorizeIndonesianVoices() {
indonesianVoices = []; indonesianFemaleVoices = []; indonesianMaleVoices = [];
availableVoices.forEach(voice => {
if (isIndonesianVoice(voice)) {
indonesianVoices.push(voice);
const gender = detectGender(voice);
if (gender === 'female') indonesianFemaleVoices.push(voice);
else if (gender === 'male') indonesianMaleVoices.push(voice);
}
});
if (indonesianVoices.length === 0) {
indonesianVoices = [...availableVoices];
}
if (indonesianFemaleVoices.length === 0) indonesianFemaleVoices = [...indonesianVoices];
if (indonesianMaleVoices.length === 0) indonesianMaleVoices = [...indonesianVoices];
}
function stopAllVoices() {
clearVoiceQueue();
if (isPaymentVoicePlaying) stopPaymentVoice();
if (isGangguanVoicePlaying) stopGangguanVoice();
}
function speak(text, gender = 'female', callback) {
if (!voiceSettings.enabled || !('speechSynthesis' in window)) { if (callback) callback(); return; }
speechSynthesis.cancel();
const audioEl = document.getElementById('backgroundMusic');
const wasPlaying = isMusicPlaying && !isMusicPaused;
const originalVolume = audioEl ? audioEl.volume : 0.3;
if (wasPlaying && audioEl) audioEl.volume = Math.max(0.05, originalVolume * 0.3);
duckYouTubeVolume();
setTimeout(() => {
const u = new SpeechSynthesisUtterance(text);
u.lang = 'id-ID';
const idx = gender === 'female' ? voiceSettings.paymentVoiceIndex : voiceSettings.gangguanVoiceIndex;
const voicePool = gender === 'female' ? indonesianFemaleVoices : indonesianMaleVoices;
if (voicePool.length > 0) { u.voice = voicePool[idx % voicePool.length] || voicePool[0]; }
else if (indonesianVoices.length > 0) { u.voice = indonesianVoices[0]; }
const p = voiceProfiles[idx] || voiceProfiles[0] || { pitch: 1, rate: 1 };
u.pitch = p.pitch; u.rate = p.rate; u.volume = voiceSettings.volume;
if (u.voice && u.voice.lang && !u.voice.lang.startsWith('id')) u.lang = 'id-ID';
u.onend = () => {
if (wasPlaying && audioEl) audioEl.volume = originalVolume;
restoreYouTubeVolume();
if (callback) callback();
};
u.onerror = (e) => {
console.error('❌ Error saat speak:', e);
if (wasPlaying && audioEl) audioEl.volume = originalVolume;
restoreYouTubeVolume();
if (callback) callback();
};
speechSynthesis.speak(u);
}, 100);
}
function updateGangguanGender() { voiceSettings.gangguanGender = document.getElementById('gangguanGenderSelect').value; }
function updatePaymentGender() { voiceSettings.paymentGender = document.getElementById('paymentGenderSelect').value; }
function updateVoiceIndex() {
voiceSettings.gangguanVoiceIndex = parseInt(document.getElementById('gangguanVoiceSelect').value);
voiceSettings.paymentVoiceIndex = parseInt(document.getElementById('paymentVoiceSelect').value);
}
function formatGangguanVoiceText(g) {
const kodeText = g.kode_laporan.split('').join(' ');
const jenisText = g.jenis_gangguan ? g.jenis_gangguan.toUpperCase() : '-';
const tipeText = g.tipe_kerusakan ? g.tipe_kerusakan.toUpperCase().replace('_', ' ') : '-';
const statusText = g.status === 'menunggu' ? 'Menunggu' : g.status === 'dalam_proses' ? 'Dalam Proses' : 'Selesai';
let lokasiText = g.lokasi || '-';
lokasiText = cleanSpacedLetters(lokasiText);
lokasiText = convertRegionRomanToNumber(lokasiText);
lokasiText = toTitleCase(lokasiText.toLowerCase());
let wilayahText = g.wilayah_terdampak || '-';
wilayahText = cleanSpacedLetters(wilayahText);
wilayahText = convertRegionRomanToNumber(wilayahText);
wilayahText = toTitleCase(wilayahText.toLowerCase());
const ukuranText = g.ukuran_pipa || '-';
let deskripsiText = g.deskripsi || 'Tidak ada deskripsi';
deskripsiText = cleanSpacedLetters(deskripsiText);
deskripsiText = normalizeTextForSpeech(deskripsiText);
const estimasiText = g.estimasi_selesai ? new Date(g.estimasi_selesai).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) : '-';
return `Gangguan nomor ${kodeText}. Status: ${statusText}. Tipe: ${tipeText}. Lokasi: ${lokasiText}. Wilayah Terdampak: ${wilayahText}. Jenis: ${jenisText}. Ukuran: ${ukuranText}. Deskripsi: ${deskripsiText}. Estimasi Penyelesaian: ${estimasiText}.`;
}
// 🔥 FORMAT PEMBAYARAN - NAMA DIBACA NORMAL
function formatPaymentVoiceText(p) {
let lokasiText = p.lokasi || 'lokasi tidak diketahui';
lokasiText = convertRegionRomanToNumber(lokasiText);
// 🔥 NAMA DIBACA NORMAL (TIDAK DIEJA PER HURUF)
let namaText = formatNameForSpeech(p.nama, voiceSettings.paymentGender);
const metodeText = p.metode === 'PPOB' ? 'P. P. O. B.' : 'Kantor Unit Cabang';
return `Terima kasih kepada Yang Terhormat, ${namaText}, yang berlokasi di ${lokasiText}, telah melakukan pembayaran di ${metodeText}. Dan apabila ada keluhan, silahkan hubungi Kantor Unit atau call center kami. Terima kasih, semoga sehat selalu.`;
}
function announcePayment(p, auto = true) {
if (!voiceSettings.enabled) return;
if (p.metode === 'Kantor') {
const wasLiveActive = isLiveDashboardActive;
if (isLiveDashboardActive && liveCycleInterval) {
clearInterval(liveCycleInterval);
liveCycleInterval = null;
}
clearVoiceQueue();
addToVoiceQueue(formatPaymentVoiceText(p), voiceSettings.paymentGender, () => {
setTimeout(() => {
if (wasLiveActive && unpaidCustomerList.length > 0) {
isLiveDashboardActive = true;
liveCycleInterval = setInterval(() => {
liveCycleIndex = (liveCycleIndex + 1) % unpaidCustomerList.length;
highlightUnpaidMarker(liveCycleIndex);
}, liveCycleSpeed);
} else {
startAutoNarration();
}
}, 2000);
});
showNotification(`Pembayaran baru dari ${p.nama} di Kantor`, 'success');
} else {
if (auto) {
addToVoiceQueue(formatPaymentVoiceText(p), voiceSettings.paymentGender);
showNotification(`Pembayaran baru dari ${p.nama}`, 'success');
}
}
}
// ============================================
// GANGGUAN VOICE CONTROLS
// ============================================
function playGangguanVoiceLoop() {
if (!isGangguanVoicePlaying || isGangguanVoicePaused) return;
if (activeGangguanList.length === 0) { updateGangguanVoiceStatus('idle', 'Tidak ada gangguan aktif'); return; }
let currentIndex = 0;
function playNext() {
if (!isGangguanVoicePlaying || isGangguanVoicePaused) return;
if (currentIndex >= activeGangguanList.length) {
if (repeatGangguanVoice) { currentIndex = 0; setTimeout(playNext, 2000); }
else { stopGangguanVoice(); }
return;
}
const g = activeGangguanList[currentIndex];
updateGangguanVoiceStatus('playing', `Memutar: ${g.kode_laporan}`);
addToVoiceQueue(formatGangguanVoiceText(g), voiceSettings.gangguanGender, () => {
currentIndex++;
setTimeout(playNext, 1500);
});
}
playNext();
}
function playGangguanVoice() {
if (activeGangguanList.length === 0) { showNotification('Tidak ada gangguan aktif', 'warning'); return; }
isGangguanVoicePlaying = true; isGangguanVoicePaused = false;
updateGangguanVoiceStatus('playing', `Memutar ${activeGangguanList.length} gangguan`);
updateGangguanVoiceButtons();
playGangguanVoiceLoop();
}
function pauseGangguanVoice() {
if (!isGangguanVoicePlaying) return;
isGangguanVoicePaused = !isGangguanVoicePaused;
if (isGangguanVoicePaused) { speechSynthesis.pause(); updateGangguanVoiceStatus('paused', 'Dijeda'); }
else { speechSynthesis.resume(); updateGangguanVoiceStatus('playing', 'Dilanjutkan'); }
updateGangguanVoiceButtons();
}
function stopGangguanVoice() {
isGangguanVoicePlaying = false; isGangguanVoicePaused = false;
speechSynthesis.cancel();
updateGangguanVoiceStatus('idle', 'Dihentikan');
updateGangguanVoiceButtons();
}
function toggleRepeatGangguan() {
repeatGangguanVoice = !repeatGangguanVoice;
const btn = document.getElementById('btnRepeatGangguan');
btn.innerHTML = repeatGangguanVoice ? '<i class="fas fa-redo"></i> Ulang: ON' : '<i class="fas fa-redo"></i> Ulang: OFF';
}
function updateGangguanVoiceStatus(s, t) {
const d = document.getElementById('gangguanVoiceStatusDot');
d.className = 'voice-status-dot';
if (s === 'playing') d.classList.add('active');
else if (s === 'paused') d.classList.add('paused');
document.getElementById('gangguanVoiceStatusText').textContent = t;
}
function updateGangguanVoiceButtons() {
const h = activeGangguanList.length > 0;
document.getElementById('btnPlayGangguan').disabled = isGangguanVoicePlaying || !h;
document.getElementById('btnPauseGangguan').disabled = !isGangguanVoicePlaying || !h;
document.getElementById('btnStopGangguan').disabled = !isGangguanVoicePlaying && !isGangguanVoicePaused;
document.getElementById('btnPauseGangguan').innerHTML = isGangguanVoicePaused ? '<i class="fas fa-play"></i> Lanjut' : '<i class="fas fa-pause"></i> Pause';
}
// ============================================
// PAYMENT VOICE CONTROLS
// ============================================
function playPaymentSequence() {
if (!isPaymentVoicePlaying || isPaymentVoicePaused) return;
if (currentPaymentIndex >= last5Payments.length) {
if (repeatPaymentVoice) { currentPaymentIndex = 0; setTimeout(() => playPaymentSequence(), 2000); }
else { stopPaymentVoice(); }
return;
}
const p = last5Payments[currentPaymentIndex];
updatePaymentVoiceStatus('playing', `Memutar: ${p.nama}`);
addToVoiceQueue(formatPaymentVoiceText(p), voiceSettings.paymentGender, () => {
currentPaymentIndex++;
setTimeout(() => { if (isPaymentVoicePlaying && !isPaymentVoicePaused) playPaymentSequence(); }, 1500);
});
}
function playLast5Payments() {
if (last5Payments.length === 0) { showNotification('Belum ada data pembayaran', 'warning'); return; }
isPaymentVoicePlaying = true; isPaymentVoicePaused = false; currentPaymentIndex = 0;
updatePaymentVoiceStatus('playing', `Memutar ${last5Payments.length} pembayaran`);
updatePaymentVoiceButtons();
playPaymentSequence();
}
function pausePaymentVoice() {
if (!isPaymentVoicePlaying) return;
isPaymentVoicePaused = !isPaymentVoicePaused;
if (isPaymentVoicePaused) { speechSynthesis.pause(); updatePaymentVoiceStatus('paused', 'Dijeda'); }
else { speechSynthesis.resume(); updatePaymentVoiceStatus('playing', 'Dilanjutkan'); }
updatePaymentVoiceButtons();
}
function stopPaymentVoice() {
isPaymentVoicePlaying = false; isPaymentVoicePaused = false; currentPaymentIndex = 0;
speechSynthesis.cancel();
updatePaymentVoiceStatus('idle', 'Dihentikan');
updatePaymentVoiceButtons();
}
function toggleRepeatPayment() {
repeatPaymentVoice = !repeatPaymentVoice;
const btn = document.getElementById('btnRepeatPayment');
btn.innerHTML = repeatPaymentVoice ? '<i class="fas fa-redo"></i> Auto: ON' : '<i class="fas fa-redo"></i> Auto: OFF';
}
function updatePaymentVoiceStatus(s, t) {
const d = document.getElementById('paymentVoiceStatusDot');
d.className = 'voice-status-dot';
if (s === 'playing') d.classList.add('active');
else if (s === 'paused') d.classList.add('paused');
document.getElementById('paymentVoiceStatusText').textContent = t;
}
function updatePaymentVoiceButtons() {
const h = last5Payments.length > 0;
document.getElementById('btnPlayPayment').disabled = isPaymentVoicePlaying || !h;
document.getElementById('btnPausePayment').disabled = !isPaymentVoicePlaying || !h;
document.getElementById('btnStopPayment').disabled = !isPaymentVoicePlaying && !isPaymentVoicePaused;
document.getElementById('btnPausePayment').innerHTML = isPaymentVoicePaused ? '<i class="fas fa-play"></i> Lanjut' : '<i class="fas fa-pause"></i> Pause';
}
// ============================================
// MUSIC CONTROLS
// ============================================
function changeMusic() {
const sel = document.getElementById('musicSelect');
const t = sel.value;
if (!t) return;
currentMusicType = t;
const playlistIndex = musicPlaylist.indexOf(t);
if (playlistIndex !== -1) currentPlaylistIndex = playlistIndex;
const audioEl = document.getElementById('backgroundMusic');
stopYouTube();
audioEl.src = musicFolder + t;
audioEl.load();
audioEl.oncanplaythrough = () => { if (!isMusicPlaying) playMusic(); };
setTimeout(() => { if (!isMusicPlaying && currentMusicType === t) playMusic(); }, 1000);
}
function playMusic() {
const audioEl = document.getElementById('backgroundMusic');
if (!audioEl.src || audioEl.src === window.location.href) {
showNotification('Pilih musik terlebih dahulu', 'warning');
return;
}
stopYouTube();
const volume = parseInt(document.getElementById('musicVolumeSlider').value) / 100;
audioEl.volume = volume;
audioEl.loop = false;
audioEl.onended = () => { if (autoRotateMusic && !isYouTubePlaying) playNextTrack(); };
const playPromise = audioEl.play();
if (playPromise !== undefined) {
playPromise.then(() => {
isMusicPlaying = true; isMusicPaused = false;
document.getElementById('btnPlayMusic').disabled = true;
document.getElementById('btnPauseMusic').disabled = false;
document.getElementById('btnStopMusic').disabled = false;
document.getElementById('musicStatus').style.display = 'flex';
document.getElementById('musicStatusText').textContent = `🎵 ${musicNames[currentMusicType] || currentMusicType}`;
}).catch(err => {
console.error('Play error:', err);
showNotification('Klik halaman dulu untuk mengaktifkan musik', 'warning');
});
}
}
function playNextTrack() {
if (!autoRotateMusic) return;
currentPlaylistIndex = (currentPlaylistIndex + 1) % musicPlaylist.length;
const nextTrack = musicPlaylist[currentPlaylistIndex];
currentMusicType = nextTrack;
const audioEl = document.getElementById('backgroundMusic');
audioEl.src = musicFolder + nextTrack;
audioEl.load();
audioEl.oncanplaythrough = () => {
audioEl.play();
document.getElementById('musicStatusText').textContent = `🎵 ${musicNames[nextTrack] || nextTrack}`;
};
setTimeout(() => { if (audioEl.paused) audioEl.play().catch(() => {}); }, 1000);
}
function pauseMusic() {
const audioEl = document.getElementById('backgroundMusic');
if (!isMusicPlaying) return;
if (isMusicPaused) {
audioEl.play(); isMusicPaused = false;
document.getElementById('btnPauseMusic').innerHTML = '<i class="fas fa-pause"></i> Pause';
} else {
audioEl.pause(); isMusicPaused = true;
document.getElementById('btnPauseMusic').innerHTML = '<i class="fas fa-play"></i> Lanjut';
}
}
function stopMusic() {
const audioEl = document.getElementById('backgroundMusic');
audioEl.pause(); audioEl.currentTime = 0;
isMusicPlaying = false; isMusicPaused = false;
document.getElementById('btnPlayMusic').disabled = false;
document.getElementById('btnPauseMusic').disabled = true;
document.getElementById('btnStopMusic').disabled = true;
document.getElementById('btnPauseMusic').innerHTML = '<i class="fas fa-pause"></i> Pause';
document.getElementById('musicStatus').style.display = 'none';
}
function toggleLoopMusic() {
autoRotateMusic = !autoRotateMusic;
const btn = document.getElementById('btnLoopMusic');
btn.innerHTML = autoRotateMusic ? '<i class="fas fa-redo"></i> Rotasi: ON' : '<i class="fas fa-redo"></i> Rotasi: OFF';
}
function setMusicVolume(v) {
const audioEl = document.getElementById('backgroundMusic');
audioEl.volume = v / 100;
document.getElementById('musicVolumeValue').textContent = v + '%';
}
// ============================================
// YOUTUBE CONTROLS
// ============================================
function extractYouTubeId(url) {
if (!url) return null;
url = url.trim();
if (/^[a-zA-Z0-9_-]{11}$/.test(url)) return url;
const patterns = [/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/|youtube\.com\/v\/|youtube\.com\/shorts\/)([a-zA-Z0-9_-]{11})/, /[?&]v=([a-zA-Z0-9_-]{11})/];
for (const pattern of patterns) { const match = url.match(pattern); if (match && match[1]) return match[1]; }
return null;
}
function playYouTube() {
const url = document.getElementById('youtubeUrl').value.trim();
if (!url) { showNotification('Masukkan URL atau ID YouTube', 'warning'); return; }
const videoId = extractYouTubeId(url);
if (!videoId) { showNotification('URL/ID YouTube tidak valid', 'warning'); return; }
stopMusic();
if (ytPlayer && typeof ytPlayer.destroy === 'function') {
try { ytPlayer.destroy(); } catch(e) {}
ytPlayer = null;
}
const container = document.getElementById('youtubePlayerContainer');
container.innerHTML = '<div id="ytPlayerDiv"></div>';
if (!isYouTubeAPIReady) {
showNotification('YouTube API belum siap, coba lagi', 'warning');
return;
}
ytPlayer = new YT.Player('ytPlayerDiv', {
height: '1',
width: '1',
videoId: videoId,
playerVars: {
autoplay: 1,
controls: 0,
loop: musicLoop ? 1 : 0,
playlist: videoId,
modestbranding: 1,
rel: 0,
showinfo: 0
},
events: {
'onReady': (event) => {
event.target.setVolume(ytUserVolume);
event.target.playVideo();
isYouTubePlaying = true;
document.getElementById('youtubeStatus').style.display = 'flex';
document.getElementById('youtubeStatusText').textContent = `▶ YouTube: ${videoId}`;
document.getElementById('btnStopYouTube').disabled = false;
document.getElementById('musicStatus').style.display = 'flex';
document.getElementById('musicStatusText').textContent = '📺 YouTube sedang diputar';
},
'onStateChange': (event) => {
if (event.data === YT.PlayerState.ENDED && musicLoop) {
ytPlayer.playVideo();
}
},
'onError': (event) => {
console.error('YouTube error:', event.data);
showNotification('Error memutar YouTube', 'warning');
stopYouTube();
}
}
});
}
function stopYouTube() {
if (ytPlayer) {
try {
ytPlayer.stopVideo();
ytPlayer.destroy();
} catch(e) {}
ytPlayer = null;
}
const container = document.getElementById('youtubePlayerContainer');
container.innerHTML = '';
isYouTubePlaying = false;
isYouTubeDucked = false;
document.getElementById('youtubeStatus').style.display = 'none';
document.getElementById('btnStopYouTube').disabled = true;
if (!isMusicPlaying) document.getElementById('musicStatus').style.display = 'none';
}
// ============================================
// KECEPATAN SCROLL
// ============================================
function setScrollSpeed(v) {
const duration = 210 - v;
document.documentElement.style.setProperty('--scroll-duration', duration + 's');
const content = document.getElementById('notificationContent');
if (content) {
content.style.animationDuration = duration + 's';
content.style.animation = 'none';
content.offsetHeight;
content.style.animation = `scroll-left ${duration}s linear infinite`;
}
let label = 'Normal';
if (v < 40) label = 'Sangat Lambat (' + duration + 's)';
else if (v < 70) label = 'Lambat (' + duration + 's)';
else if (v < 90) label = 'Normal (' + duration + 's)';
else if (v < 130) label = 'Cepat (' + duration + 's)';
else label = 'Sangat Cepat (' + duration + 's)';
document.getElementById('scrollSpeedValue').textContent = label;
}
function toggleVoicePanel() { document.getElementById('voicePanel').classList.toggle('active'); }
function setVoiceVolume(v) { voiceSettings.volume = v / 100; document.getElementById('volumeValue').textContent = v + '%'; }
function testVoice() {
const gender = voiceSettings.paymentGender;
const text = gender === 'female' ? 'Halo, ini adalah suara perempuan Alternatif 3 untuk notifikasi pembayaran PDAM UP Darmaraja. Contoh nama dibaca normal: Budi Santoso, Siti Aminah, Ahmad Hidayat.' : 'Halo, ini adalah suara laki-laki untuk notifikasi gangguan PDAM UP Darmaraja';
speak(text, gender);
}
if ('speechSynthesis' in window) { loadVoices(); setTimeout(loadVoices, 500); setTimeout(loadVoices, 1500); }
// ============================================
// DATA PROCESSING
// ============================================
function updateNotificationBar(payments) {
const bar = document.getElementById('notificationBar');
const content = document.getElementById('notificationContent');
if (payments.length === 0) { bar.style.display = 'none'; return; }
bar.style.display = 'block';
last5Payments = payments.slice(0, 5);
let html = '';
payments.forEach((p) => {
html += `<div class="notification-item" data-nama="${p.nama}"><strong>${p.nama}</strong> <span class="amount">${formatRupiah(p.jumlah)}</span> <span style="color: #86efac;">(${p.kubikasi} m³)</span> <span class="location"><i class="fas fa-${p.lokasi === 'Kantor' ? 'building' : 'mobile-alt'}"></i> ${p.lokasi}</span></div>`;
});
content.innerHTML = html + html;
updatePaymentVoiceButtons();
}
function getPaymentStatus(p) {
const hasLoket = p.tanggal_pembayaran_loket && p.tanggal_pembayaran_loket !== '-' && p.tanggal_pembayaran_loket !== '.' && p.tanggal_pembayaran_loket !== null;
const hasPPOB = p.tanggal_pembayaran_ppob && p.tanggal_pembayaran_ppob !== '-' && p.tanggal_pembayaran_ppob !== '.' && p.tanggal_pembayaran_ppob !== null;
if (hasLoket) return { status: 'Kantor', color: '#10b981', icon: 'fa-building', tanggal: p.tanggal_pembayaran_loket, metode: 'Kantor' };
else if (hasPPOB) return { status: 'PPOB', color: '#f59e0b', icon: 'fa-mobile-alt', tanggal: p.tanggal_pembayaran_ppob, metode: 'PPOB' };
else return { status: 'Belum Bayar', color: '#ef4444', icon: 'fa-times', tanggal: null, metode: null };
}
function calculateRevenue() {
totalRevenue = 0; totalKubikasi = 0; let recent = [];
pelangganDataFromLaravel.forEach(p => {
const s = getPaymentStatus(p);
if (s.status !== 'Belum Bayar') {
totalRevenue += parseFloat(p.jumlah) || 0;
totalKubikasi += parseFloat(p.pakai) || 0;
if (s.tanggal) recent.push({ nama: p.nama || 'Pelanggan', jumlah: parseFloat(p.jumlah) || 0, kubikasi: parseFloat(p.pakai) || 0, lokasi: p.nama_wilayah || 'Tidak Diketahui', tanggal: s.tanggal, metode: s.metode });
}
});
recent.sort((a, b) => new Date(b.tanggal) - new Date(a.tanggal));
updateRevenueDisplay();
updateNotificationBar(recent.slice(0, 10));
}
function updateRevenueDisplay() {
const el = document.getElementById('revenue-display');
if (el) {
el.innerHTML = `<div class="revenue-title"><i class="fas fa-coins"></i> Total Pendapatan Hari Ini</div><div class="revenue-amount">${formatRupiahMasked(totalRevenue)}</div><div class="revenue-kubikasi"><i class="fas fa-tint"></i> <strong>${totalKubikasi.toFixed(1)} m³</strong> total pemakaian</div>`;
}
}
function initSidebarAutoScroll() {
const sb = document.getElementById('sidebarContent');
if (!sb) return;
const scrollSpeed = 50, scrollAmount = 1;
sidebarScrollInterval = setInterval(() => {
const idle = Date.now() - lastActivityTime;
if (idle > 30000 && sb.scrollHeight > sb.clientHeight + 50) {
isSidebarAutoScrolling = true;
sb.scrollTop += sidebarScrollDirection * scrollAmount;
if (sb.scrollTop >= sb.scrollHeight - sb.clientHeight - 5) sidebarScrollDirection = -1;
else if (sb.scrollTop <= 0) sidebarScrollDirection = 1;
} else { isSidebarAutoScrolling = false; }
}, scrollSpeed);
const resetIdle = () => { lastActivityTime = Date.now(); };
document.addEventListener('mousemove', resetIdle);
document.addEventListener('click', resetIdle);
document.addEventListener('keypress', resetIdle);
document.addEventListener('scroll', resetIdle, true);
if (sb) sb.addEventListener('scroll', resetIdle);
}
// ============================================
// MAP INITIALIZATION
// ============================================
function initMap() {
const bounds = L.latLngBounds(L.latLng(-6.98, 107.80), L.latLng(-6.80, 108.15));
map = L.map('map', { center: [-6.88, 107.97], zoom: 14, minZoom: 11, maxZoom: 18, maxBounds: bounds, maxBoundsViscosity: 0.8, zoomControl: false });
L.control.zoom({ position: 'topright' }).addTo(map);
initBaseLayers();
currentBaseLayer = baseLayers[currentLayer];
currentBaseLayer.addTo(map);
const polygon = [[-6.9584, 108.0315], [-6.9421, 108.0242], [-6.9315, 108.0198], [-6.9202, 108.0211], [-6.9110, 108.0322], [-6.8985, 108.0410], [-6.8842, 108.0556], [-6.8810, 108.0695], [-6.8892, 108.0841], [-6.9011, 108.0920], [-6.9154, 108.0985], [-6.9320, 108.0950], [-6.9488, 108.0862], [-6.9595, 108.0711], [-6.9680, 108.0544], [-6.9642, 108.0398], [-6.9584, 108.0315]];
L.polygon(polygon, { color: '#3b82f6', fillColor: '#3b82f6', fillOpacity: 0.1, weight: 3, dashArray: '10, 5' }).addTo(map).bindPopup(`<div style="text-align:center; padding:10px;"><h6 style="color:#1e3c72; margin:0;"><i class="fas fa-map-marker-alt"></i> KECAMATAN DARMARAJA</h6><small>Kab. Sumedang, Jawa Barat</small></div>`);
const center = L.polygon(polygon).getBounds().getCenter();
L.marker([center.lat, center.lng], { icon: L.divIcon({ className: 'custom-div-icon', html: `<div id="darmaraja-label" style="background: rgba(30, 60, 114, 0.9); color: white; padding: 8px 20px; border-radius: 20px; font-weight: 700; font-size: 14px; letter-spacing: 2px; box-shadow: 0 4px 15px rgba(0,0,0,0.3); border: 3px solid white; white-space: nowrap; transition: opacity 0.3s;"><i class="fas fa-map-marker-alt"></i> DARMARAJA</div>`, iconSize: [200, 40], iconAnchor: [100, 20] }), interactive: false }).addTo(map);
map.on('zoomend', () => {
const l = document.getElementById('darmaraja-label');
if (l) {
l.style.opacity = map.getZoom() >= 14 ? '0' : '1';
l.style.pointerEvents = map.getZoom() >= 14 ? 'none' : 'auto';
}
});
loadJalurPipa(); loadBangunan(); loadGangguan(); loadTitikPenting(); loadPelanggan();
calculateRevenue();
loadUnpaidCustomerMarkers();
loadWilayahDanBlok();
updateTodayStatsDisplay();
updateRevenueProgress(); // 🔥 Update progress bar pendapatan
if (gangguanData && gangguanData.length > 0) {
activeGangguanList = gangguanData.filter(g => g.status !== 'selesai');
if (activeGangguanList.length > 0) {
updateGangguanVoiceButtons();
updateGangguanVoiceStatus('idle', `${activeGangguanList.length} gangguan siap diputar`);
}
}
initSidebarAutoScroll();
setScrollSpeed(60);
// 🔥 INIT SEARCH
document.getElementById('searchResults').innerHTML = '<div class="search-empty">Ketik untuk mencari pelanggan</div>';
if (unpaidCustomerList.length > 0) {
setTimeout(() => { startAutoNarration(); }, 5000);
}
}
function loadJalurPipa() {
jalurPipaData.forEach(j => {
try {
const c = parseCoordinates(j.coordinates);
if (!c || c.length === 0 || !hasPointInArea(c)) return;
const pl = L.polyline(c, { color: j.warna, weight: parseInt(j.ketebalan) || 4, opacity: 0.85 }).addTo(map);
let d = 0; for (let i = 0; i < c.length - 1; i++) d += L.latLng(c[i]).distanceTo(L.latLng(c[i+1]));
pl.bindPopup(`<div style="min-width:250px;"><h6 style="background:${j.warna};color:white;padding:10px;border-radius:8px 8px 0 0;margin:0;"><i class="fas fa-route"></i> ${j.nama_jalur}</h6><div style="padding:12px; font-size:12px;"><div style="display:flex;justify-content:space-between;padding:6px 0;border-bottom:1px dashed #e2e8f0;"><span style="color:#64748b;">Jenis:</span><strong>${j.jenis_jalur.toUpperCase()}</strong></div><div style="display:flex;justify-content:space-between;padding:6px 0;border-bottom:1px dashed #e2e8f0;"><span style="color:#64748b;">Ukuran:</span><strong>${j.ukuran_pipa}</strong></div><div style="display:flex;justify-content:space-between;padding:6px 0;"><span style="color:#64748b;">Panjang:</span><strong style="color:#0369a1;">${(d/1000).toFixed(2)} km</strong></div>${j.keterangan ? `<div style="margin-top:8px;padding-top:8px;border-top:1px dashed #e2e8f0;color:#64748b;font-size:11px;"><i class="fas fa-info-circle"></i> ${j.keterangan}</div>` : ''}</div></div>`, { maxWidth: 300 });
jalurLayers[j.id] = pl;
} catch(e) { console.error(e); }
});
}
function loadBangunan() {
bangunanData.forEach(b => {
try {
const c = parseCoordinates(b.coordinates);
if (!c || c.length === 0 || !hasPointInArea(c)) return;
const poly = L.polygon(c, { color: b.warna, fillColor: b.warna, fillOpacity: 0.25, weight: 2 }).addTo(map);
const center = poly.getBounds().getCenter();
const icons = { 'reservoir': { i: 'fa-database', c: '#06b6d4' }, 'ipa': { i: 'fa-industry', c: '#8b5cf6' }, 'kantor': { i: 'fa-building', c: '#3b82f6' }, 'lainnya': { i: 'fa-building', c: '#6b7280' } };
const cfg = icons[b.jenis_bangunan] || icons['lainnya'];
const m = L.marker(center, { icon: L.divIcon({ className: 'custom-div-icon', html: `<div class="marker-wrapper"><div class="marker-pin shape-square" style="background: ${cfg.c}; width: 34px; height: 34px;"><i class="fas ${cfg.i}"></i></div><div class="marker-label">${b.nama_bangunan}</div></div>`, iconSize: [34, 50], iconAnchor: [17, 17] }) }).addTo(map);
m.bindPopup(`<div style="min-width:220px;"><h6 style="background:${cfg.c};color:white;padding:10px;border-radius:8px 8px 0 0;margin:0;"><i class="fas ${cfg.i}"></i> ${b.nama_bangunan}</h6><div style="padding:12px; font-size:12px;"><div style="display:flex;justify-content:space-between;padding:6px 0;"><span style="color:#64748b;">Jenis:</span><strong>${b.jenis_bangunan.toUpperCase()}</strong></div>${b.keterangan ? `<div style="margin-top:8px;padding-top:8px;border-top:1px dashed #e2e8f0;color:#64748b;font-size:11px;"><i class="fas fa-info-circle"></i> ${b.keterangan}</div>` : ''}</div></div>`);
markerLayers[`bangunan_${b.id}`] = m;
} catch(e) { console.error(e); }
});
}
function loadGangguan() {
gangguanData.forEach(g => {
try {
const lat = parseFloat(g.latitude), lng = parseFloat(g.longitude);
if (isNaN(lat) || isNaN(lng)) return;
const cfg = { 'menunggu': { c: '#ef4444', i: 'fa-clock', t: 'Menunggu', bg: '#fee2e2' }, 'dalam_proses': { c: '#f59e0b', i: 'fa-tools', t: 'Dalam Proses', bg: '#fef3c7' }, 'selesai': { c: '#10b981', i: 'fa-check', t: 'Selesai', bg: '#d1fae5' } }[g.status] || { c: '#ef4444', i: 'fa-clock', t: 'Menunggu', bg: '#fee2e2' };
const icons = { 'bocor': 'fa-tint', 'pecah': 'fa-bomb', 'mampet': 'fa-ban', 'rusak_ringan': 'fa-exclamation', 'rusak_berat': 'fa-exclamation-triangle', 'lainnya': 'fa-question' };
const di = icons[g.tipe_kerusakan] || 'fa-question';
const active = g.status !== 'selesai';
const html = `<div class="marker-wrapper">${active ? `<div class="marker-banner"><i class="fas fa-exclamation-triangle"></i> GANGGUAN AKTIF</div>` : ''}<div style="position: relative; width: 50px; height: 50px;">${active ? `<div class="pulse-ring" style="background: ${cfg.c}; color: ${cfg.c}; animation: pulse-red 1.5s infinite;"></div>` : ''}<div class="marker-pin shape-circle" style="background: ${cfg.c}; width: 50px; height: 50px; border: 4px solid white; box-shadow: 0 4px 15px rgba(0,0,0,0.4);"><i class="fas ${di}" style="font-size: 22px; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));"></i></div><div style="position: absolute; top: -2px; right: -2px; background: white; color: ${cfg.c}; width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px; border: 3px solid ${cfg.c}; box-shadow: 0 2px 8px rgba(0,0,0,0.3); font-weight: 700;"><i class="fas ${cfg.i}"></i></div></div><div class="marker-label" style="background: ${cfg.c}; font-weight: 700; font-size: 10px; padding: 3px 8px;">${g.kode_laporan}</div></div>`;
const m = L.marker([lat, lng], { icon: L.divIcon({ className: 'custom-div-icon', html: html, iconSize: [110, 120], iconAnchor: [55, 60], popupAnchor: [0, -60] }) }).addTo(map);
m.bindPopup(`
<div style="min-width:300px;">
<div style="background:linear-gradient(135deg, ${cfg.c}, ${cfg.c}dd);color:white;padding:12px;text-align:center;">
<div style="font-size:11px;opacity:0.9;margin-bottom:3px;"><i class="fas fa-info-circle"></i> INFORMASI PELAYANAN</div>
<div style="font-weight:700;font-size:13px;">${g.status === 'selesai' ? 'Gangguan Telah Selesai' : 'Mohon Maaf Pelayanan Terganggu'}</div>
</div>
<div style="padding:15px;">
<h6 style="margin:0 0 12px 0; color:#1e293b; font-size:15px;">${g.kode_laporan}</h6>
<div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:12px;">
<div style="background:${cfg.bg};padding:10px;border-radius:8px;text-align:center;">
<div style="font-size:10px;color:#64748b;">STATUS</div>
<div style="font-weight:700;color:${cfg.c};font-size:12px;"><i class="fas fa-circle" style="font-size:8px;"></i> ${cfg.t}</div>
</div>
<div style="background:#f1f5f9;padding:10px;border-radius:8px;text-align:center;">
<div style="font-size:10px;color:#64748b;">TIPE</div>
<div style="font-weight:700;color:#1e293b;font-size:12px;">${g.tipe_kerusakan ? g.tipe_kerusakan.toUpperCase() : '-'}</div>
</div>
</div>
<div style="margin-bottom:10px;"><div style="font-size:11px;color:#64748b;margin-bottom:3px;"><i class="fas fa-map-marker-alt"></i> Lokasi</div><div style="font-weight:600;color:#1e293b;">${g.lokasi || '-'}</div></div>
<div style="margin-bottom:10px;"><div style="font-size:11px;color:#64748b;margin-bottom:3px;"><i class="fas fa-users"></i> Wilayah Terdampak</div><div style="font-weight:600;color:#1e293b;">${g.wilayah_terdampak || '-'}</div></div>
${g.deskripsi ? `<div style="background:#fef3c7;padding:10px;border-radius:8px;border-left:3px solid #f59e0b;margin-bottom:12px;"><div style="font-size:10px;color:#92400e;font-weight:600;"><i class="fas fa-info-circle"></i> DESKRIPSI</div><div style="font-size:12px;color:#78350f;margin-top:3px;">${g.deskripsi}</div></div>` : ''}
<div style="background:linear-gradient(135deg,#ecfdf5,#d1fae5);padding:12px;border-radius:8px;text-align:center;">
<div style="font-size:11px;color:#065f46;margin-bottom:4px;"><i class="fas fa-calendar-check"></i> Estimasi Penyelesaian</div>
<div style="font-weight:700;color:#064e3b;font-size:14px;">${g.estimasi_selesai ? new Date(g.estimasi_selesai).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) : '-'}</div>
</div>
<a href="https://wa.me/6281234567890?text=Halo%2C%20saya%20ingin%20menanyakan%20gangguan%20${encodeURIComponent(g.kode_laporan)}%20di%20${encodeURIComponent(g.lokasi)}" target="_blank" style="display:block;background:linear-gradient(135deg,#25D366,#128C7E);color:white;padding:10px;border-radius:8px;text-align:center;text-decoration:none;margin-top:12px;font-weight:600;"><i class="fab fa-whatsapp"></i> Laporkan via WhatsApp</a>
</div>
</div>
`, { maxWidth: 350 });
markerLayers[`gangguan_${g.id}`] = m;
} catch(e) { console.error(e); }
});
}
function loadTitikPenting() {
const icons = { 'valve': { i: 'fa-toggle-on', c: '#ef4444' }, 'hydrant': { i: 'fa-fire', c: '#dc2626' }, 'meter': { i: 'fa-tachometer-alt', c: '#3b82f6' }, 'sambungan': { i: 'fa-link', c: '#8b5cf6' }, 'pompa': { i: 'fa-water', c: '#10b981' }, 'tandon': { i: 'fa-database', c: '#06b6d4' }, 'lainnya': { i: 'fa-map-pin', c: '#6b7280' } };
titikPentingData.forEach(t => {
try {
const lat = parseFloat(t.latitude), lng = parseFloat(t.longitude);
if (isNaN(lat) || isNaN(lng) || !isInArea(lat, lng)) return;
const c = icons[t.jenis_titik] || icons['lainnya'];
const m = L.marker([lat, lng], { icon: L.divIcon({ className: 'custom-div-icon', html: `<div class="marker-wrapper"><div class="marker-pin shape-circle" style="background:${c.c};width:28px;height:28px;"><i class="fas ${c.i}"></i></div><div class="marker-label">${t.nama_titik}</div></div>`, iconSize: [28, 40], iconAnchor: [14, 14] }) }).addTo(map);
m.bindPopup(`<div style="min-width:200px;"><h6 style="background:${c.c};color:white;padding:10px;border-radius:8px 8px 0 0;margin:0;"><i class="fas ${c.i}"></i> ${t.nama_titik}</h6><div style="padding:12px;font-size:12px;"><div><strong>Jenis:</strong> ${t.jenis_titik}</div>${t.keterangan ? `<div style="margin-top:5px;"><strong>Ket:</strong> ${t.keterangan}</div>` : ''}</div></div>`);
markerLayers[`titik_${t.id}`] = m;
} catch(e) { console.error(e); }
});
}
function loadPelanggan() {
if (!pelangganDataFromLaravel || pelangganDataFromLaravel.length === 0) return;
pelangganClusterGroup = L.markerClusterGroup({
maxClusterRadius: 50, spiderfyOnMaxZoom: true, showCoverageOnHover: false, zoomToBoundsOnClick: true,
iconCreateFunction: function(cluster) {
const count = cluster.getChildCount();
let color = '#3b82f6', size = '28px';
if (count > 50) { color = '#ef4444'; size = '36px'; } else if (count > 20) { color = '#f59e0b'; size = '32px'; }
return L.divIcon({ html: `<div style="background:${color};color:white;width:${size};height:${size};border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:12px;border:3px solid white;box-shadow:0 2px 8px rgba(0,0,0,0.3);">${count}</div>`, className: 'marker-cluster-custom', iconSize: L.point(parseInt(size), parseInt(size)) });
}
});
const grouped = { byPayment: {}, byGolongan: {}, byWilayah: {}, totalKantor: 0, totalPPOB: 0, totalBelumBayar: 0, countKantor: 0, countPPOB: 0, countBelumBayar: 0 };
pelangganDataFromLaravel.forEach(p => {
const s = getPaymentStatus(p);
if (!grouped.byPayment[s.status]) grouped.byPayment[s.status] = [];
grouped.byPayment[s.status].push(p);
const j = parseFloat(p.jumlah) || 0, k = parseFloat(p.pakai) || 0;
if (s.status === 'Kantor') { grouped.totalKantor += j; grouped.countKantor++; }
else if (s.status === 'PPOB') { grouped.totalPPOB += j; grouped.countPPOB++; }
else { grouped.totalBelumBayar += j; grouped.countBelumBayar++; }
const gol = p.kode_gol_trf || 'Lainnya';
if (!grouped.byGolongan[gol]) grouped.byGolongan[gol] = [];
grouped.byGolongan[gol].push(p);
const w = p.nama_wilayah || 'Tidak Diketahui';
if (!grouped.byWilayah[w]) grouped.byWilayah[w] = [];
grouped.byWilayah[w].push(p);
if (s.status === 'Belum Bayar') return;
const coords = parseKoordinator(p.koordinator);
if (!coords || !isInArea(coords[0], coords[1])) return;
const m = L.marker(coords, { icon: L.divIcon({ className: 'custom-div-icon', html: `<div style="background: ${s.color}; width: 18px; height: 18px; border-radius: 50%; border: 2px solid white; box-shadow: 0 2px 6px rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center;"><i class="fas ${s.icon}" style="color: white; font-size: 8px;"></i></div>`, iconSize: [18, 18], iconAnchor: [9, 9] }), zIndexOffset: 100 });
m.bindPopup(`<div style="min-width:250px; font-family: 'Inter', sans-serif; font-size: 12px;"><div style="background: ${s.color}; color: white; padding: 8px; border-radius: 6px 6px 0 0; font-weight: 700;"><i class="fas ${s.icon}"></i> ${p.nama || 'Tanpa Nama'}</div><div style="padding: 10px;"><div style="margin-bottom: 6px;"><strong>No:</strong> ${p.no_pelanggan}</div><div style="margin-bottom: 6px;"><strong>Golongan:</strong> ${gol}</div><div style="margin-bottom: 6px;"><strong>Wilayah:</strong> ${w}</div><div style="margin-bottom: 6px;"><strong>Status:</strong> <span style="color: ${s.color}; font-weight: 700;"><i class="fas ${s.icon}"></i> ${s.status}</span></div><div style="margin-bottom: 6px;"><strong>Pemakaian:</strong> ${k} m³</div>${s.tanggal ? `<div style="margin-bottom: 6px;"><strong>Tgl Bayar:</strong> ${formatDate(s.tanggal)}</div>` : ''}<div style="background: #fef3c7; padding: 6px; border-radius: 4px; margin-top: 8px;"><strong>Tagihan:</strong> ${formatRupiah(p.jumlah)}</div></div></div>`, { maxWidth: 280 });
pelangganClusterGroup.addLayer(m);
pelangganLayers[`pelanggan_${p.no_pelanggan}`] = { marker: m, coords: coords, golongan: gol, wilayah: w, paymentStatus: s.status };
});
map.addLayer(pelangganClusterGroup);
updatePelangganStats(grouped);
}
function updatePelangganStats(g) {
const c = document.querySelector('.sidebar-content');
if (!c) return;
const html = `
<div class="section-title" style="margin-top: 20px; cursor: pointer;" onclick="resetPelangganFilter()"><i class="fas fa-money-bill-wave text-success"></i> Penerimaan Pembayaran <small style="color: #94a3b8; font-size: 10px; margin-left: auto;">(klik untuk reset)</small></div>
<div class="stats-grid-3">
<div class="stat-card stat-kantor" onclick="filterByPayment('Kantor')"><i class="fas fa-building stat-icon"></i><div class="stat-value">${g.countKantor}</div><div class="stat-label">Kantor</div></div>
<div class="stat-card stat-ppob" onclick="filterByPayment('PPOB')"><i class="fas fa-mobile-alt stat-icon"></i><div class="stat-value">${g.countPPOB}</div><div class="stat-label">PPOB</div></div>
<div class="stat-card stat-belum" onclick="filterByPayment('Belum Bayar')"><i class="fas fa-times-circle stat-icon"></i><div class="stat-value">${g.countBelumBayar}</div><div class="stat-label">Belum Bayar</div></div>
</div>
<div style="background: linear-gradient(135deg, #10b981, #059669); padding: 12px; border-radius: 10px; margin-bottom: 10px; color: white; cursor: pointer;" onclick="filterByPayment('Kantor')"><div style="font-size: 10px; opacity: 0.9; margin-bottom: 4px;"><i class="fas fa-building"></i> Total Masuk ke Kantor</div><div style="font-size: 18px; font-weight: 700;">${formatRupiahMasked(g.totalKantor)}</div></div>
<div style="background: linear-gradient(135deg, #f59e0b, #d97706); padding: 12px; border-radius: 10px; margin-bottom: 10px; color: white; cursor: pointer;" onclick="filterByPayment('PPOB')"><div style="font-size: 10px; opacity: 0.9; margin-bottom: 4px;"><i class="fas fa-mobile-alt"></i> Total Masuk ke PPOB</div><div style="font-size: 18px; font-weight: 700;">${formatRupiahMasked(g.totalPPOB)}</div></div>
<div style="background: linear-gradient(135deg, #ef4444, #dc2626); padding: 12px; border-radius: 10px; margin-bottom: 15px; color: white; cursor: pointer;" onclick="filterByPayment('Belum Bayar')"><div style="font-size: 10px; opacity: 0.9; margin-bottom: 4px;"><i class="fas fa-exclamation-triangle"></i> Total Belum Dibayar</div><div style="font-size: 18px; font-weight: 700;">${formatRupiahMasked(g.totalBelumBayar)}</div></div>
<div class="section-title"><i class="fas fa-chart-pie"></i> Berdasarkan Golongan</div>
<div id="golongan-list">${Object.entries(g.byGolongan).map(([gol, data]) => `<div class="list-item" onclick="filterPelangganByGolongan('${gol}')"><div class="list-item-header"><div class="list-item-title"><span class="color-indicator" style="background: ${getStatusColor(gol)};"></span> Golongan ${gol}</div><span class="badge" style="background: ${getStatusColor(gol)}20; color: ${getStatusColor(gol)};">${data.length}</span></div></div>`).join('')}</div>
<div class="section-title"><i class="fas fa-map"></i> Berdasarkan Wilayah</div>
<div id="wilayah-list">${Object.entries(g.byWilayah).slice(0, 5).map(([w, data]) => `<div class="list-item" onclick="filterPelangganByWilayah('${w}')"><div class="list-item-header"><div class="list-item-title"><i class="fas fa-map-marker-alt" style="color: #64748b;"></i> ${w}</div><span class="badge bg-secondary">${data.length}</span></div></div>`).join('')}${Object.keys(g.byWilayah).length > 5 ? `<div style="text-align: center; padding: 8px; color: #64748b; font-size: 11px;">+${Object.keys(g.byWilayah).length - 5} wilayah lainnya</div>` : ''}</div>
`;
const sec = c.querySelector('.section-title');
if (sec) { const d = document.createElement('div'); d.innerHTML = html; sec.parentNode.insertBefore(d, sec.nextSibling); }
}
function filterByPayment(t) {
if (pelangganClusterGroup) map.removeLayer(pelangganClusterGroup);
pelangganClusterGroup = L.markerClusterGroup({ maxClusterRadius: 50, spiderfyOnMaxZoom: true, showCoverageOnHover: false, zoomToBoundsOnClick: true });
const f = pelangganDataFromLaravel.filter(p => getPaymentStatus(p).status === t);
const b = [];
f.forEach(p => { const d = pelangganLayers[`pelanggan_${p.no_pelanggan}`]; if (d && d.coords) { pelangganClusterGroup.addLayer(d.marker); b.push(d.coords); } });
map.addLayer(pelangganClusterGroup);
if (b.length > 0) map.fitBounds(L.latLngBounds(b), { padding: [50, 50] });
showNotification(`Menampilkan ${f.length} pelanggan ${t}`, 'success');
}
function resetPelangganFilter() {
if (pelangganClusterGroup) map.removeLayer(pelangganClusterGroup);
pelangganClusterGroup = L.markerClusterGroup({ maxClusterRadius: 50, spiderfyOnMaxZoom: true, showCoverageOnHover: false, zoomToBoundsOnClick: true });
Object.values(pelangganLayers).forEach(d => pelangganClusterGroup.addLayer(d.marker));
map.addLayer(pelangganClusterGroup);
showNotification('Menampilkan semua pelanggan', 'info');
}
function filterPelangganByGolongan(gol) {
if (pelangganClusterGroup) map.removeLayer(pelangganClusterGroup);
pelangganClusterGroup = L.markerClusterGroup({ maxClusterRadius: 50, spiderfyOnMaxZoom: true, showCoverageOnHover: false, zoomToBoundsOnClick: true });
const f = pelangganDataFromLaravel.filter(p => p.kode_gol_trf === gol);
const b = [];
f.forEach(p => { const d = pelangganLayers[`pelanggan_${p.no_pelanggan}`]; if (d && d.coords) { pelangganClusterGroup.addLayer(d.marker); b.push(d.coords); } });
map.addLayer(pelangganClusterGroup);
if (b.length > 0) map.fitBounds(L.latLngBounds(b), { padding: [50, 50] });
showNotification(`Filter: Golongan ${gol} (${f.length} pelanggan)`, 'info');
}
function filterPelangganByWilayah(w) {
if (pelangganClusterGroup) map.removeLayer(pelangganClusterGroup);
pelangganClusterGroup = L.markerClusterGroup({ maxClusterRadius: 50, spiderfyOnMaxZoom: true, showCoverageOnHover: false, zoomToBoundsOnClick: true });
const f = pelangganDataFromLaravel.filter(p => p.nama_wilayah === w);
const b = [];
f.forEach(p => { const d = pelangganLayers[`pelanggan_${p.no_pelanggan}`]; if (d && d.coords) { pelangganClusterGroup.addLayer(d.marker); b.push(d.coords); } });
map.addLayer(pelangganClusterGroup);
if (b.length > 0) map.fitBounds(L.latLngBounds(b), { padding: [50, 50] });
showNotification(`Filter: Wilayah ${w} (${f.length} pelanggan)`, 'info');
}
function focusOnJalur(id) { if (jalurLayers[id]) { map.fitBounds(jalurLayers[id].getBounds(), { padding: [50, 50] }); jalurLayers[id].openPopup(); if (window.innerWidth < 768) toggleSidebar(); } }
function focusOnBangunan(id) { const m = markerLayers[`bangunan_${id}`]; if (m) { map.setView(m.getLatLng(), 17); m.openPopup(); if (window.innerWidth < 768) toggleSidebar(); } }
function focusOnGangguan(id) {
document.querySelectorAll('.gangguan-card, .list-item').forEach(i => i.classList.remove('active'));
const t = document.querySelector(`.gangguan-card[data-id="${id}"]`);
if (t) { t.classList.add('active'); t.scrollIntoView({ behavior: 'smooth', block: 'nearest' }); }
if (markerLayers[`gangguan_${id}`]) { const m = markerLayers[`gangguan_${id}`]; map.flyTo(m.getLatLng(), 17, { duration: 0.8 }); setTimeout(() => m.openPopup(), 800); }
if (window.innerWidth < 768) toggleSidebar();
}
function toggleSidebar() { document.getElementById('sidebar').classList.toggle('active'); }
function toggleFullscreen() {
const w = document.getElementById('mainWrapper'), b = document.getElementById('expandBtn');
if (!isFullscreen) {
if (w.requestFullscreen) w.requestFullscreen(); else if (w.webkitRequestFullscreen) w.webkitRequestFullscreen();
w.classList.add('is-fullscreen'); isFullscreen = true;
b.classList.add('active'); b.innerHTML = '<i class="fas fa-compress"></i> <span>Keluar Fullscreen</span>';
} else {
if (document.exitFullscreen) document.exitFullscreen(); else if (document.webkitExitFullscreen) document.webkitExitFullscreen();
w.classList.remove('is-fullscreen'); isFullscreen = false;
b.classList.remove('active'); b.innerHTML = '<i class="fas fa-expand"></i> <span>Fullscreen</span>';
}
setTimeout(() => { if (map) map.invalidateSize(); }, 300);
}
document.addEventListener('fullscreenchange', () => { if (!document.fullscreenElement && !document.webkitFullscreenElement) { document.getElementById('mainWrapper').classList.remove('is-fullscreen'); isFullscreen = false; document.getElementById('expandBtn').classList.remove('active'); document.getElementById('expandBtn').innerHTML = '<i class="fas fa-expand"></i> <span>Fullscreen</span>'; setTimeout(() => { if (map) map.invalidateSize(); }, 300); } });
document.addEventListener('keydown', e => { if (e.key === 'F11') { e.preventDefault(); toggleFullscreen(); } });
function showWAQR() {
new bootstrap.Modal(document.getElementById('waQRModal')).show();
if (!waQRGenerated) {
document.getElementById('wa-qrcode').innerHTML = '';
new QRCode(document.getElementById('wa-qrcode'), { text: 'https://wa.me/6281234567890?text=Halo%20PDAM%20Tirta%20Medal', width: 220, height: 220, colorDark: '#128C7E', colorLight: '#ffffff', correctLevel: QRCode.CorrectLevel.H });
waQRGenerated = true;
}
}
document.addEventListener('DOMContentLoaded', initMap);
</script>
</body>
</html>