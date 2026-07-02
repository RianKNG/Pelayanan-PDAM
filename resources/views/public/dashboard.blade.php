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
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
/* CSS SAMA SEPERTI SEBELUMNYA (Dipertahankan untuk konsistensi) */
* { margin: 0; padding: 0; box-sizing: border-box; }
:root { --scroll-duration: 60s; }
body { font-family: 'Inter', sans-serif; background: #0f172a; overflow: hidden; height: 100vh; }
.top-navbar { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: white; padding: 6px 0; box-shadow: 0 2px 10px rgba(0,0,0,0.3); position: relative; z-index: 1000; border-bottom: 1px solid rgba(255,255,255,0.05); }
.top-navbar-container { max-width: 1600px; margin: 0 auto; padding: 0 16px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; }
.brand-section { display: flex; align-items: center; gap: 8px; }
.brand-logo { width: 32px; height: 32px; background: linear-gradient(135deg, #06b6d4, #0891b2); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 16px; box-shadow: 0 2px 8px rgba(6, 182, 212, 0.4); }
.brand-text h1 { font-size: 13px; font-weight: 700; margin: 0; letter-spacing: 0.3px; }
.brand-text small { font-size: 9px; opacity: 0.7; }
.contact-info-bar { display: flex; align-items: center; gap: 15px; background: rgba(255,255,255,0.05); padding: 4px 12px; border-radius: 8px; }
.contact-item-nav { display: flex; align-items: center; gap: 6px; font-size: 11px; padding: 3px 8px; background: rgba(255,255,255,0.1); border-radius: 6px; transition: all 0.2s; }
.contact-item-nav:hover { background: rgba(255,255,255,0.2); transform: translateY(-1px); }
.wa-qr-btn-nav { background: #25D366; color: white; border: none; padding: 3px 8px; border-radius: 6px; font-size: 9px; cursor: pointer; margin-left: 5px; }
.alert-section { display: flex; align-items: center; gap: 8px; background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.3); padding: 4px 10px; border-radius: 8px; font-size: 10px; }
.alert-icon { width: 24px; height: 24px; background: linear-gradient(135deg, #f59e0b, #d97706); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 10px; }
.alert-count { background: #f59e0b; color: white; padding: 2px 8px; border-radius: 10px; font-weight: 700; font-size: 11px; }

/* 🔥 REALTIME INDICATOR */
.realtime-indicator { display: flex; align-items: center; gap: 6px; background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); padding: 4px 10px; border-radius: 8px; font-size: 10px; transition: all 0.3s; }
.realtime-indicator.active { background: rgba(16, 185, 129, 0.3); border-color: #10b981; animation: pulse-realtime 1.5s infinite; }
@keyframes pulse-realtime { 0%, 100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4); } 50% { box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); } }
.realtime-dot { width: 8px; height: 8px; background: #10b981; border-radius: 50%; }
.realtime-indicator.active .realtime-dot { background: #fff; }

.notification-bar { background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 8px; padding: 4px 10px; flex: 1; max-width: 400px; overflow: hidden; }
.notification-title { font-size: 8px; opacity: 0.9; margin-bottom: 2px; font-weight: 600; }
.notification-scroll { overflow: hidden; white-space: nowrap; }
.notification-scroll-content { display: inline-block; animation: scroll-left var(--scroll-duration, 60s) linear infinite; font-size: 9px; }
.notification-item { display: inline-block; margin-right: 20px; padding: 2px 8px; background: rgba(255,255,255,0.1); border-radius: 10px; }
@keyframes scroll-left { 0% { transform: translateX(100%); } 100% { transform: translateX(-100%); } }

/* Progress Bar & Layout */
.unit-progress-bar { background: linear-gradient(135deg, #1e293b 0%, #334155 100%); padding: 8px 0; border-bottom: 1px solid rgba(255,255,255,0.05); z-index: 999; }
.unit-progress-container { max-width: 1600px; margin: 0 auto; padding: 0 16px; display: flex; align-items: center; gap: 16px; }
.unit-image-wrapper { width: 80px; height: 60px; border-radius: 10px; overflow: hidden; flex-shrink: 0; box-shadow: 0 4px 12px rgba(0,0,0,0.3); border: 2px solid rgba(255,255,255,0.1); }
.unit-image-wrapper img { width: 100%; height: 100%; object-fit: cover; }
.unit-info { flex-shrink: 0; color: white; min-width: 140px; }
.unit-info h3 { font-size: 11px; font-weight: 700; margin-bottom: 2px; color: #fbbf24; }
.unit-info p { font-size: 9px; opacity: 0.8; margin: 0; }
.unit-narrate-btn { background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; border: none; padding: 4px 10px; border-radius: 6px; font-size: 9px; font-weight: 600; cursor: pointer; margin-top: 4px; display: flex; align-items: center; gap: 4px; }
.revenue-progress-section { flex: 1; color: white; }
.revenue-progress-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px; }
.revenue-progress-title { font-size: 9px; font-weight: 600; display: flex; align-items: center; gap: 4px; opacity: 0.9; }
.revenue-progress-bar-container { position: relative; height: 20px; background: rgba(255,255,255,0.1); border-radius: 10px; overflow: hidden; }
.revenue-progress-bar { height: 100%; background: linear-gradient(90deg, #10b981 0%, #059669 100%); border-radius: 10px; transition: width 1s ease-in-out; }
.revenue-progress-percentage { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 10px; font-weight: 800; color: white; }
.revenue-progress-details { display: grid; grid-template-columns: repeat(4, 1fr); gap: 6px; margin-top: 6px; }
.revenue-detail-card { background: rgba(255,255,255,0.08); padding: 4px 8px; border-radius: 6px; border: 1px solid rgba(255,255,255,0.1); }
.revenue-detail-label { font-size: 7px; color: rgba(255,255,255,0.7); margin-bottom: 1px; }
.revenue-detail-value { font-size: 11px; font-weight: 700; color: white; }

.main-wrapper { display: flex; height: calc(100vh - 110px); position: relative; margin-right: 320px; }
#map { flex: 1; height: 100%; z-index: 1; background: #1e293b; }
.sidebar { position: fixed !important; right: 0 !important; top: 110px !important; bottom: 0 !important; width: 320px !important; background: white; box-shadow: -2px 0 15px rgba(0,0,0,0.2); z-index: 999; display: flex; flex-direction: column; border-radius: 12px 0 0 0; overflow: hidden; }
.sidebar-header { background: linear-gradient(135deg, #1e3c72, #2a5298); color: white; padding: 10px 14px; }
.sidebar-content { padding: 10px; overflow-y: auto; flex: 1; background: #f8fafc; }

/* Controls */
.control-buttons { position: fixed; left: 10px; top: 120px; z-index: 1001; display: flex; flex-direction: column; gap: 6px; }
.control-btn { background: linear-gradient(135deg, #1e3c72, #2a5298); color: white; border: none; padding: 8px 12px; border-radius: 8px; cursor: pointer; font-size: 11px; display: flex; align-items: center; gap: 6px; }
.voice-panel { position: fixed; right: 10px; top: 120px; background: white; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.2); padding: 14px; z-index: 1002; width: 340px; display: none; max-height: 85vh; overflow-y: auto; }
.voice-panel.active { display: block; }
.youtube-input-group { display: flex; gap: 6px; margin-top: 8px; }
.youtube-input { flex: 1; padding: 8px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 11px; }
.youtube-btn { padding: 8px 12px; background: #ef4444; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 11px; }

/* Markers & Cards */
.gangguan-card { margin-bottom: 8px; border: 2px solid #e2e8f0; border-radius: 8px; background: white; cursor: pointer; }
.gangguan-card-header { padding: 6px 10px; color: white; display: flex; justify-content: space-between; }
.gangguan-card-header.status-menunggu { background: #f59e0b; }
.gangguan-card-header.status-dalam_proses { background: #3b82f6; }
.gangguan-card-body { padding: 8px 10px; }
.estimasi-box { background: #fef3c7; padding: 8px; border-radius: 8px; border-left: 3px solid #f59e0b; margin-top: 6px; }
.wilayah-card { margin-bottom: 10px; border: 1px solid #e2e8f0; border-radius: 8px; background: white; }
.wilayah-header { background: #3b82f6; color: white; padding: 6px 10px; font-size: 11px; }
.blok-item { display: flex; justify-content: space-between; padding: 6px 8px; margin: 3px 0; background: #f8fafc; border-radius: 5px; font-size: 10px; }

/* Toast */
.toast-notification { position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background: white; padding: 10px 16px; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.2); z-index: 9999; font-size: 12px; }
.toast-notification.success { border-left: 4px solid #10b981; }
.toast-notification.payment { border-left: 4px solid #10b981; background: #ecfdf5; }

@media (max-width: 768px) {
    .main-wrapper { margin-right: 0; }
    .sidebar { width: 100% !important; transform: translateY(100%) !important; }
    .sidebar.active { transform: translateY(0) !important; }
    .control-buttons { bottom: 10px; top: auto; flex-direction: row; flex-wrap: wrap; }
}
</style>
</head>
<body>

<audio id="backgroundMusic" loop preload="auto"></audio>
<div id="youtubePlayerContainer" style="position: fixed; bottom: -200px; right: -200px; width: 1px; height: 1px; opacity: 0; pointer-events: none; z-index: -1;"></div>

<!-- NAVBAR -->
<div class="top-navbar">
<div class="top-navbar-container">
    <div class="brand-section">
        <div class="brand-logo"><i class="fas fa-tint"></i></div>
        <div class="brand-text"><h1>PDAM UP - DARMARAJA</h1><small>Sistem Monitoring</small></div>
    </div>
    
    <div class="contact-info-bar">
        <div class="contact-item-nav"><i class="fas fa-headset"></i> <strong>088294979966</strong></div>
        <div class="contact-item-nav" style="background: rgba(37, 211, 102, 0.2);">
            <i class="fab fa-whatsapp"></i> <strong>088294979966</strong>
            <button class="wa-qr-btn-nav" onclick="showWAQR()"><i class="fas fa-qrcode"></i></button>
        </div>
    </div>

    <!-- 🔥 REALTIME INDICATOR -->
    <div class="realtime-indicator" id="realtimeIndicator">
        <div class="realtime-dot"></div>
        <span>Live: <strong id="lastUpdateTime">--:--:--</strong></span>
    </div>

    <div class="alert-section">
        <div class="alert-icon"><i class="fas fa-info-circle"></i></div>
        <div class="alert-text"><strong>Gangguan</strong><small id="gangguanCountText">0 aktif</small></div>
        <div class="alert-count" id="gangguanCountBadge">0</div>
    </div>

    <div class="notification-bar" id="notificationBar" style="display: none;">
        <div class="notification-title"><i class="fas fa-money-bill-wave"></i> Pembayaran Terbaru (Realtime)</div>
        <div class="notification-scroll"><div class="notification-scroll-content" id="notificationContent"></div></div>
    </div>
</div>
</div>

<!-- PROGRESS BAR -->
<div class="unit-progress-bar">
<div class="unit-progress-container">
    <div class="unit-image-wrapper">
        <img src="https://images.unsplash.com/photo-1581092160607-ee22621dd758?w=200&h=150&fit=crop" alt="Unit" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2280%22 height=%2260%22%3E%3Crect fill=%22%231e3c72%22 width=%2280%22 height=%2260%22/%3E%3C/svg%3E'">
    </div>
    <div class="unit-info">
        <h3><i class="fas fa-building"></i> Unit Cabang Darmaraja</h3>
        <p>Kec. Darmaraja, Kab. Sumedang</p>
        <button class="unit-narrate-btn" onclick="narrateUnitProfile()"><i class="fas fa-volume-up"></i> Dengarkan Profil & Data</button>
    </div>
    <div class="revenue-progress-section">
        <div class="revenue-progress-header">
            <div class="revenue-progress-title"><i class="fas fa-chart-line"></i> PROGRES PENDAPATAN BULAN INI</div>
            <div style="font-size: 9px; opacity: 0.8;">Hari ke-<strong id="currentDayOfMonth">0</strong> | Sisa <strong id="remainingDays">0</strong> hari</div>
        </div>
        <div class="revenue-progress-bar-container">
            <div class="revenue-progress-bar" id="revenueProgressBar" style="width: 0%;"></div>
            <div class="revenue-progress-percentage" id="revenueProgressPercentage">0%</div>
        </div>
        <div class="revenue-progress-details">
            <div class="revenue-detail-card"><div class="revenue-detail-label">Target</div><div class="revenue-detail-value" id="targetRevenue">Rp 0</div></div>
            <div class="revenue-detail-card"><div class="revenue-detail-label">Terkumpul</div><div class="revenue-detail-value" style="color: #86efac;" id="collectedRevenue">Rp 0</div></div>
            <div class="revenue-detail-card"><div class="revenue-detail-label">Sisa+Denda</div><div class="revenue-detail-value" style="color: #fbbf24;" id="remainingRevenue">Rp 0</div></div>
            <div class="revenue-detail-card"><div class="revenue-detail-label">Rata²/Hari</div><div class="revenue-detail-value" style="color: #f87171;" id="dailyTarget">Rp 0</div></div>
        </div>
    </div>
</div>
</div>

<div class="main-wrapper" id="mainWrapper">
    <div id="map"></div>
    
    <div class="control-buttons">
        <button class="control-btn" onclick="toggleSidebar()"><i class="fas fa-bars"></i> Info</button>
        <button class="control-btn" onclick="toggleVoicePanel()"><i class="fas fa-sliders-h"></i> Suara</button>
        <button class="control-btn" onclick="toggleLiveDashboard()"><i class="fas fa-broadcast-tower"></i> LIVE</button>
    </div>

    <!-- VOICE PANEL WITH YOUTUBE -->
    <div class="voice-panel" id="voicePanel">
        <div style="display: flex; justify-content: space-between; margin-bottom: 10px; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px;">
            <strong style="font-size: 12px;">Panel Kontrol</strong>
            <button onclick="toggleVoicePanel()" style="background: none; border: none; cursor: pointer;"><i class="fas fa-times"></i></button>
        </div>
        
        <div style="margin-bottom: 15px; padding: 10px; background: #f1f5f9; border-radius: 8px;">
            <div style="font-size: 10px; font-weight: 700; margin-bottom: 6px; color: #334155;">📺 YOUTUBE PLAYER</div>
            <div class="youtube-input-group">
                <input type="text" class="youtube-input" id="youtubeUrl" placeholder="URL/ID YouTube">
                <button class="youtube-btn" onclick="playYouTube()"><i class="fab fa-youtube"></i> Putar</button>
            </div>
            <div style="margin-top: 6px; display: flex; gap: 6px;">
                <button class="control-btn" style="flex: 1; padding: 6px; font-size: 10px;" onclick="stopYouTube()"><i class="fas fa-stop"></i> Stop</button>
            </div>
            <div style="font-size: 9px; margin-top: 6px; color: #64748b;">
                <i class="fas fa-volume-up"></i> Volume: 
                <input type="range" min="0" max="100" value="100" id="youtubeVolumeSlider" oninput="setYouTubeVolume(this.value)" style="width: 60px;">
            </div>
        </div>

        <div style="margin-bottom: 15px; padding: 10px; background: #f1f5f9; border-radius: 8px;">
            <div style="font-size: 10px; font-weight: 700; margin-bottom: 6px; color: #334155;">🎵 MUSIK LATAR</div>
            <select class="search-select" id="musicSelect" onchange="changeMusic()" style="width: 100%; padding: 6px; font-size: 10px; margin-bottom: 6px;">
                <option value="">-- Pilih Musik --</option>
                <option value="musik1.mp3">Musik 1 (Tenang)</option>
                <option value="musik2.mp3">Musik 2 (Semangat)</option>
            </select>
            <div style="display: flex; gap: 6px;">
                <button class="control-btn" style="flex: 1; padding: 6px; font-size: 10px;" onclick="playMusic()"><i class="fas fa-play"></i></button>
                <button class="control-btn" style="flex: 1; padding: 6px; font-size: 10px;" onclick="stopMusic()"><i class="fas fa-stop"></i></button>
            </div>
        </div>

        <div style="padding: 10px; background: #f1f5f9; border-radius: 8px;">
            <div style="font-size: 10px; font-weight: 700; margin-bottom: 6px; color: #334155;">⚙️ PENGATURAN SUARA</div>
            <div style="font-size: 9px; margin-bottom: 4px;">Volume TTS: <span id="volumeValue">80%</span></div>
            <input type="range" min="0" max="100" value="80" id="volumeSlider" oninput="setVoiceVolume(this.value)" style="width: 100%;">
            <button class="control-btn" style="width: 100%; margin-top: 8px; padding: 8px;" onclick="testVoice()"><i class="fas fa-play"></i> Test Suara</button>
        </div>
    </div>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-header"><h5><i class="fas fa-network-wired"></i> Informasi Jaringan</h5></div>
        <div class="sidebar-content" id="sidebarContent">
            <!-- Content loaded via JS -->
            <div class="text-center py-3"><i class="fas fa-spinner fa-spin"></i> Memuat data...</div>
        </div>
    </div>
</div>

<!-- Modal WA -->
<div class="modal fade" id="waQRModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content">
    <div class="modal-header bg-success text-white"><h5 class="modal-title">WhatsApp PDAM</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div>
    <div class="modal-body text-center">
        <div id="wa-qrcode" class="d-flex justify-content-center my-3"></div>
        <p><strong>088294979966</strong></p>
        <a href="https://wa.me/6288294979966" target="_blank" class="btn btn-success w-100"><i class="fab fa-whatsapp"></i> Chat Langsung</a>
    </div>
</div></div></div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script src="https://www.youtube.com/iframe_api"></script>

<script>
// ============================================
// DATA DARI LARAVEL (Simulasi untuk standalone)
// ============================================
// Ganti ini dengan @json($data) dari Laravel Anda
const jalurPipaData = [];
const bangunanData = [];
const gangguanData = [];
const titikPentingData = [];
let pelangganDataFromLaravel = []; // Akan diupdate via API/Realtime

// ============================================
// VARIABEL GLOBAL
// ============================================
let map, pelangganLayers = {}, pelangganClusterGroup;
let voiceSettings = { enabled: true, volume: 0.8, paymentGender: 'female' };
let isYouTubePlaying = false, ytPlayer = null, ytUserVolume = 100;
let isNarrating = false;
let lastPaymentHash = ''; // Untuk deteksi perubahan realtime

// ============================================
// 🔥 YOUTUBE API
// ============================================
function onYouTubeIframeAPIReady() { console.log('YT API Ready'); }
function playYouTube() {
    const url = document.getElementById('youtubeUrl').value.trim();
    if (!url) return;
    let videoId = url;
    if (url.includes('v=')) videoId = url.split('v=')[1].split('&')[0];
    else if (url.includes('youtu.be/')) videoId = url.split('youtu.be/')[1];
    
    if (ytPlayer) ytPlayer.destroy();
    document.getElementById('youtubePlayerContainer').innerHTML = '<div id="ytPlayerDiv"></div>';
    
    ytPlayer = new YT.Player('ytPlayerDiv', {
        height: '1', width: '1', videoId: videoId,
        playerVars: { autoplay: 1, controls: 0, loop: 1, playlist: videoId },
        events: {
            'onReady': (e) => { e.target.setVolume(ytUserVolume); e.target.playVideo(); isYouTubePlaying = true; },
            'onStateChange': (e) => { if (e.data === YT.PlayerState.ENDED) e.target.playVideo(); }
        }
    });
}
function stopYouTube() { if (ytPlayer) { ytPlayer.stopVideo(); ytPlayer.destroy(); ytPlayer = null; } isYouTubePlaying = false; document.getElementById('youtubePlayerContainer').innerHTML = ''; }
function setYouTubeVolume(v) { ytUserVolume = v; if (ytPlayer) ytPlayer.setVolume(v); }

// ============================================
// 🔥 REALTIME PAYMENT CHECK (AUTO REFRESH)
// ============================================
function checkRealtimePayments() {
    // Simulasi: Di produksi, ini fetch ke API Laravel Anda
    // const response = await fetch('/api/pelanggan');
    // const newData = await response.json();
    
    // Deteksi perubahan (hash sederhana dari jumlah pembayaran)
    const currentPaidCount = pelangganDataFromLaravel.filter(p => p.tanggal_pembayaran_loket || p.tanggal_pembayaran_ppob).length;
    const currentHash = currentPaidCount.toString();
    
    if (currentHash !== lastPaymentHash && lastPaymentHash !== '') {
        // Ada perubahan!
        const indicator = document.getElementById('realtimeIndicator');
        indicator.classList.add('active');
        document.getElementById('lastUpdateTime').textContent = new Date().toLocaleTimeString('id-ID');
        
        // Update UI
        updateRevenueProgress();
        updateNotificationBar(getRecentPayments());
        showNotification('💰 Pembayaran baru terdeteksi! Data diperbarui.', 'payment');
        
        setTimeout(() => indicator.classList.remove('active'), 5000);
    }
    lastPaymentHash = currentHash;
}

// Mulai check setiap 10 detik
setInterval(checkRealtimePayments, 10000);

// ============================================
// 🔥 NARASI PROFIL DINAMIS (DATA GROUPING)
// ============================================
function narrateUnitProfile() {
    if (isNarrating) { isNarrating = false; speechSynthesis.cancel(); return; }
    isNarrating = true;
    
    const now = new Date();
    const dateStr = now.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
    const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
    
    // Hitung Data
    const totalPelanggan = pelangganDataFromLaravel.length;
    const totalTarget = pelangganDataFromLaravel.reduce((sum, p) => sum + (parseFloat(p.jumlah) || 0), 0);
    const totalPaid = pelangganDataFromLaravel.filter(p => p.tanggal_pembayaran_loket || p.tanggal_pembayaran_ppob).reduce((sum, p) => sum + (parseFloat(p.jumlah) || 0), 0);
    
    // Grouping Wilayah
    const byWilayah = {};
    pelangganDataFromLaravel.forEach(p => {
        const w = p.nama_wilayah || 'Lainnya';
        if (!byWilayah[w]) byWilayah[w] = { count: 0, amount: 0 };
        byWilayah[w].count++;
        byWilayah[w].amount += parseFloat(p.jumlah) || 0;
    });
    
    // Grouping Golongan
    const byGolongan = {};
    pelangganDataFromLaravel.forEach(p => {
        const g = p.kode_gol_trf || 'Lainnya';
        if (!byGolongan[g]) byGolongan[g] = 0;
        byGolongan[g]++;
    });

    // Susun Narasi
    let narasi = `Laporan Profil Unit Darmaraja, per tanggal ${dateStr}, jam ${timeStr}. `;
    narasi += `Total pelanggan terdaftar sebanyak ${totalPelanggan} rekening. `;
    narasi += `Total target pendapatan bulan ini adalah ${formatRupiah(totalTarget)}. `;
    narasi += `Sudah terkumpul ${formatRupiah(totalPaid)}. `;
    
    narasi += `Rincian per Wilayah: `;
    Object.entries(byWilayah).forEach(([w, data], i) => {
        narasi += `Wilayah ${w} sebanyak ${data.count} pelanggan dengan total tagihan ${formatRupiah(data.amount)}. `;
        if (i > 2) narasi += `dan seterusnya. `; // Batasi agar tidak terlalu panjang
    });
    
    narasi += `Rincian per Golongan: `;
    Object.entries(byGolongan).forEach(([g, count], i) => {
        narasi += `Golongan ${g} sebanyak ${count} pelanggan. `;
    });
    
    narasi += `Demikian laporan profil unit. Terima kasih.`;
    
    speak(narasi, 'female', () => { isNarrating = false; });
}

// ============================================
// FUNGSI BANTUAN
// ============================================
function formatRupiah(a) { return 'Rp ' + (parseInt(a) || 0).toLocaleString('id-ID'); }
function getPaymentStatus(p) {
    if (p.tanggal_pembayaran_loket) return { status: 'Kantor', tanggal: p.tanggal_pembayaran_loket };
    if (p.tanggal_pembayaran_ppob) return { status: 'PPOB', tanggal: p.tanggal_pembayaran_ppob };
    return { status: 'Belum Bayar', tanggal: null };
}
function getRecentPayments() {
    return pelangganDataFromLaravel
        .filter(p => p.tanggal_pembayaran_loket || p.tanggal_pembayaran_ppob)
        .sort((a, b) => new Date(b.tanggal_pembayaran_loket || b.tanggal_pembayaran_ppob) - new Date(a.tanggal_pembayaran_loket || a.tanggal_pembayaran_ppob))
        .slice(0, 5);
}

// ============================================
// UPDATE UI
// ============================================
function updateRevenueProgress() {
    const now = new Date();
    const daysInMonth = new Date(now.getFullYear(), now.getMonth() + 1, 0).getDate();
    const currentDay = now.getDate();
    const remainingDays = daysInMonth - currentDay;
    
    let totalTarget = 0, totalCollected = 0, totalUnpaid = 0;
    
    pelangganDataFromLaravel.forEach(p => {
        const jumlah = parseFloat(p.jumlah) || 0;
        const status = getPaymentStatus(p);
        if (status.status !== 'Belum Bayar') {
            totalCollected += jumlah;
        } else {
            let final = jumlah;
            if (currentDay > 20) final += 5000; // Denda
            if (jumlah > 1000000) final += 10000; // Materai
            totalUnpaid += final;
        }
        totalTarget += jumlah;
    });
    
    const percentage = totalTarget > 0 ? (totalCollected / totalTarget) * 100 : 0;
    const dailyTarget = remainingDays > 0 ? totalUnpaid / remainingDays : 0;
    
    document.getElementById('revenueProgressBar').style.width = percentage.toFixed(1) + '%';
    document.getElementById('revenueProgressPercentage').textContent = percentage.toFixed(1) + '%';
    document.getElementById('currentDayOfMonth').textContent = currentDay;
    document.getElementById('remainingDays').textContent = remainingDays;
    document.getElementById('targetRevenue').textContent = formatRupiah(totalTarget);
    document.getElementById('collectedRevenue').textContent = formatRupiah(totalCollected);
    document.getElementById('remainingRevenue').textContent = formatRupiah(totalUnpaid);
    document.getElementById('dailyTarget').textContent = formatRupiah(dailyTarget);
}

function updateNotificationBar(payments) {
    if (payments.length === 0) { document.getElementById('notificationBar').style.display = 'none'; return; }
    document.getElementById('notificationBar').style.display = 'block';
    let html = '';
    payments.forEach(p => {
        const status = getPaymentStatus(p);
        const tgl = new Date(status.tanggal).toLocaleString('id-ID', { day: 'numeric', month: 'short', hour: '2-digit', minute: '2-digit' });
        html += `<div class="notification-item"><strong>${p.nama}</strong> ${formatRupiah(p.jumlah)} <span style="color:#fcd34d; font-size:8px;">${tgl}</span></div>`;
    });
    document.getElementById('notificationContent').innerHTML = html + html;
}

function showNotification(msg, type) {
    const toast = document.createElement('div');
    toast.className = `toast-notification ${type}`;
    toast.innerHTML = msg;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}

// ============================================
// VOICE SYSTEM
// ============================================
function speak(text, gender, callback) {
    if (!voiceSettings.enabled) { if (callback) callback(); return; }
    speechSynthesis.cancel();
    const u = new SpeechSynthesisUtterance(text);
    u.lang = 'id-ID';
    u.volume = voiceSettings.volume;
    u.onend = () => { if (callback) callback(); };
    speechSynthesis.speak(u);
}
function setVoiceVolume(v) { voiceSettings.volume = v / 100; document.getElementById('volumeValue').textContent = v + '%'; }
function testVoice() { speak('Tes suara sistem monitoring PDAM Darmaraja.', 'female'); }

// ============================================
// INIT MAP
// ============================================
function initMap() {
    map = L.map('map', { center: [-6.88, 107.97], zoom: 14, zoomControl: false });
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
    L.control.zoom({ position: 'topright' }).addTo(map);
    
    // Load initial data
    updateRevenueProgress();
    updateNotificationBar(getRecentPayments());
    lastPaymentHash = pelangganDataFromLaravel.filter(p => p.tanggal_pembayaran_loket || p.tanggal_pembayaran_ppob).length.toString();
    document.getElementById('lastUpdateTime').textContent = new Date().toLocaleTimeString('id-ID');
    
    // Render sidebar content (simplified)
    document.getElementById('sidebarContent').innerHTML = `
        <div style="padding: 10px; background: white; border-radius: 8px; margin-bottom: 10px;">
            <strong style="font-size: 12px;">Statistik</strong>
            <div style="font-size: 11px; margin-top: 5px;">Total Pelanggan: ${pelangganDataFromLaravel.length}</div>
        </div>
    `;
}

function toggleSidebar() { document.getElementById('sidebar').classList.toggle('active'); }
function toggleVoicePanel() { document.getElementById('voicePanel').classList.toggle('active'); }
function toggleLiveDashboard() { showNotification('LIVE Mode toggled', 'info'); }
function showWAQR() { new bootstrap.Modal(document.getElementById('waQRModal')).show(); }

document.addEventListener('DOMContentLoaded', initMap);
</script>
</body>
</html>