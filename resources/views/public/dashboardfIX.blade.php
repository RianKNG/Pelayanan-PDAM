<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Peta Jaringan Pipa - PDAM UP Darmaraja</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
  <!-- 🔥 YOUTUBE API -->

  <style>
    * {
       margin: 0;
       padding: 0;
       box-sizing: border-box;
    }
    :root {
       --scroll-duration: 60s;
    }
    body {
       font-family: "Inter", sans-serif;
       background: #0f172a;
       overflow: hidden;
       height: 100vh;
    }
    .top-navbar {
       background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
       color: white;
       padding: 6px 0;
       box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
       position: relative;
       z-index: 1000;
       border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }
    .top-navbar-container {
       max-width: 1600px;
       margin: 0 auto;
       padding: 0 16px;
       display: flex;
       justify-content: space-between;
       align-items: center;
       flex-wrap: wrap;
       gap: 10px;
    }
    .brand-section {
       display: flex;
       align-items: center;
       gap: 8px;
    }
    .brand-logo {
       width: 32px;
       height: 32px;
       background: linear-gradient(135deg, #06b6d4, #0891b2);
       border-radius: 8px;
       display: flex;
       align-items: center;
       justify-content: center;
       font-size: 16px;
       box-shadow: 0 2px 8px rgba(6, 182, 212, 0.4);
    }
    .brand-text h1 {
       font-size: 13px;
       font-weight: 700;
       margin: 0;
       letter-spacing: 0.3px;
    }
    .brand-text small {
       font-size: 9px;
       opacity: 0.7;
    }
    .contact-info-bar {
       display: flex;
       align-items: center;
       gap: 15px;
       background: rgba(255, 255, 255, 0.05);
       padding: 4px 12px;
       border-radius: 8px;
    }
    .contact-item-nav {
       display: flex;
       align-items: center;
       gap: 6px;
       font-size: 11px;
       padding: 3px 8px;
       background: rgba(255, 255, 255, 0.1);
       border-radius: 6px;
       transition: all 0.2s;
    }
    .contact-item-nav:hover {
       background: rgba(255, 255, 255, 0.2);
       transform: translateY(-1px);
    }
    .contact-item-nav i {
       font-size: 12px;
    }
    .wa-qr-btn-nav {
       background: #25d366;
       color: white;
       border: none;
       padding: 3px 8px;
       border-radius: 6px;
       font-size: 9px;
       cursor: pointer;
       margin-left: 5px;
       transition: all 0.2s;
    }
    .wa-qr-btn-nav:hover {
       background: #128c7e;
       transform: scale(1.05);
    }
    .alert-section {
       display: flex;
       align-items: center;
       gap: 8px;
       background: rgba(245, 158, 11, 0.15);
       border: 1px solid rgba(245, 158, 11, 0.3);
       padding: 4px 10px;
       border-radius: 8px;
       font-size: 10px;
    }
    .alert-icon {
       width: 24px;
       height: 24px;
       background: linear-gradient(135deg, #f59e0b, #d97706);
       border-radius: 50%;
       display: flex;
       align-items: center;
       justify-content: center;
       font-size: 10px;
    }
    .alert-text strong {
       display: block;
       font-size: 10px;
    }
    .alert-text small {
       opacity: 0.8;
       font-size: 9px;
    }
    .alert-count {
       background: #f59e0b;
       color: white;
       padding: 2px 8px;
       border-radius: 10px;
       font-weight: 700;
       font-size: 11px;
    }
    .notification-bar {
       background: rgba(16, 185, 129, 0.15);
       border: 1px solid rgba(16, 185, 129, 0.3);
       border-radius: 8px;
       padding: 4px 10px;
       flex: 1;
       max-width: 400px;
       overflow: hidden;
    }
    .notification-title {
       font-size: 8px;
       opacity: 0.9;
       margin-bottom: 2px;
       font-weight: 600;
    }
    .notification-scroll {
       overflow: hidden;
       white-space: nowrap;
    }
    .notification-scroll-content {
       display: inline-block;
       animation: scroll-left var(--scroll-duration, 60s) linear infinite;
       font-size: 9px;
    }
    .notification-item {
       display: inline-block;
       margin-right: 20px;
       padding: 2px 8px;
       background: rgba(255, 255, 255, 0.1);
       border-radius: 10px;
    }
    .notification-item.active-sync {
       background: linear-gradient(135deg, #fbbf24, #f59e0b) !important;
    }
    .notification-item.new-payment {
       animation: flashNew 2s ease;
    }
    @keyframes flashNew {
       0%,
       100% {
          background: rgba(255, 255, 255, 0.1);
       }
       50% {
          background: linear-gradient(135deg, #10b981, #059669);
       }
    }
    .notification-item strong {
       color: #fff;
       font-size: 9px;
    }
    .notification-item .amount {
       color: #86efac;
       font-size: 9px;
    }
    .notification-item .location {
       color: #fcd34d;
       font-size: 8px;
    }
    @keyframes scroll-left {
       0% {
          transform: translateX(100%);
       }
       100% {
          transform: translateX(-100%);
       }
    }
    .unit-progress-bar {
       background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
       padding: 8px 0;
       border-bottom: 1px solid rgba(255, 255, 255, 0.05);
       position: relative;
       z-index: 999;
    }
    .unit-progress-container {
       max-width: 1600px;
       margin: 0 auto;
       padding: 0 16px;
       display: flex;
       align-items: center;
       gap: 16px;
    }
    .unit-image-wrapper {
       width: 80px;
       height: 60px;
       border-radius: 10px;
       overflow: hidden;
       flex-shrink: 0;
       box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
       border: 2px solid rgba(255, 255, 255, 0.1);
    }
    .unit-image-wrapper img {
       width: 100%;
       height: 100%;
       object-fit: cover;
    }
    .unit-info {
       flex-shrink: 0;
       color: white;
       min-width: 140px;
    }
    .unit-info h3 {
       font-size: 11px;
       font-weight: 700;
       margin-bottom: 2px;
       color: #fbbf24;
    }
    .unit-info p {
       font-size: 9px;
       opacity: 0.8;
       margin: 0;
    }
    .unit-narrate-btn {
       background: linear-gradient(135deg, #8b5cf6, #7c3aed);
       color: white;
       border: none;
       padding: 4px 10px;
       border-radius: 6px;
       font-size: 9px;
       font-weight: 600;
       cursor: pointer;
       margin-top: 4px;
       display: flex;
       align-items: center;
       gap: 4px;
       transition: all 0.3s;
    }
    .unit-narrate-btn:hover {
       transform: scale(1.05);
       box-shadow: 0 4px 12px rgba(139, 92, 246, 0.4);
    }
    .revenue-progress-section {
       flex: 1;
       color: white;
    }
    .revenue-progress-header {
       display: flex;
       justify-content: space-between;
       align-items: center;
       margin-bottom: 4px;
    }
    .revenue-progress-title {
       font-size: 9px;
       font-weight: 600;
       display: flex;
       align-items: center;
       gap: 4px;
       opacity: 0.9;
    }
    .revenue-progress-stats {
       display: flex;
       gap: 8px;
       font-size: 9px;
    }
    .revenue-progress-stat {
       display: flex;
       align-items: center;
       gap: 4px;
       background: rgba(255, 255, 255, 0.1);
       padding: 2px 8px;
       border-radius: 10px;
    }
    .revenue-progress-bar-container {
       position: relative;
       height: 20px;
       background: rgba(255, 255, 255, 0.1);
       border-radius: 10px;
       overflow: hidden;
       box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2);
    }
    .revenue-progress-bar {
       height: 100%;
       background: linear-gradient(
          90deg,
          #10b981 0%,
          #059669 50%,
          #047857 100%
       );
       border-radius: 10px;
       transition: width 1s ease-in-out;
       position: relative;
       overflow: hidden;
       box-shadow: 0 0 15px rgba(16, 185, 129, 0.5);
    }
    .revenue-progress-bar::before {
       content: "";
       position: absolute;
       top: 0;
       left: 0;
       right: 0;
       bottom: 0;
       background: linear-gradient(
          90deg,
          transparent,
          rgba(255, 255, 255, 0.3),
          transparent
       );
       animation: shimmer 2s infinite;
    }
    @keyframes shimmer {
       0% {
          transform: translateX(-100%);
       }
       100% {
          transform: translateX(100%);
       }
    }
    .revenue-progress-percentage {
       position: absolute;
       top: 50%;
       left: 50%;
       transform: translate(-50%, -50%);
       font-size: 10px;
       font-weight: 800;
       color: white;
       text-shadow: 0 1px 3px rgba(0, 0, 0, 0.5);
       z-index: 2;
    }
    .revenue-progress-details {
       display: grid;
       grid-template-columns: repeat(4, 1fr);
       gap: 6px;
       margin-top: 6px;
    }
    .revenue-detail-card {
       background: rgba(255, 255, 255, 0.08);
       padding: 4px 8px;
       border-radius: 6px;
       border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .revenue-detail-label {
       font-size: 7px;
       color: rgba(255, 255, 255, 0.7);
       text-transform: uppercase;
       letter-spacing: 0.3px;
       margin-bottom: 1px;
       display: flex;
       align-items: center;
       gap: 3px;
    }
    .revenue-detail-value {
       font-size: 11px;
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
    .main-wrapper {
       display: flex;
       height: calc(100vh - 110px);
       position: relative;
       margin-right: 320px;
    }
    #map {
       flex: 1;
       height: 100%;
       z-index: 1;
       background: #1e293b;
    }
    .sidebar {
       position: fixed !important;
       right: 0 !important;
       top: 110px !important;
       bottom: 0 !important;
       width: 320px !important;
       background: white;
       box-shadow: -2px 0 15px rgba(0, 0, 0, 0.2);
       z-index: 999;
       display: flex;
       flex-direction: column;
       transform: translateX(0) !important;
       border-radius: 12px 0 0 0;
       overflow: hidden;
    }
    .sidebar-header {
       background: linear-gradient(135deg, #1e3c72, #2a5298);
       color: white;
       padding: 10px 14px;
       position: sticky;
       top: 0;
       z-index: 10;
    }
    .sidebar-header h5 {
       margin: 0;
       font-size: 12px;
       font-weight: 600;
       display: flex;
       align-items: center;
       gap: 6px;
    }
    .sidebar-header small {
       opacity: 0.8;
       font-size: 9px;
       display: block;
       margin-top: 2px;
    }
    .sidebar-content {
       padding: 10px;
       overflow-y: auto;
       flex: 1;
       scroll-behavior: smooth;
       background: #f8fafc;
    }
    .sidebar-content::-webkit-scrollbar {
       width: 4px;
    }
    .sidebar-content::-webkit-scrollbar-thumb {
       background: #cbd5e1;
       border-radius: 2px;
    }
    .search-container {
       background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
       padding: 8px;
       border-radius: 8px;
       margin-bottom: 10px;
       border: 1px solid #bae6fd;
    }
    .search-title {
       font-size: 9px;
       font-weight: 700;
       color: #0369a1;
       margin-bottom: 6px;
       display: flex;
       align-items: center;
       gap: 4px;
       text-transform: uppercase;
    }
    .search-row {
       display: flex;
       gap: 4px;
       margin-bottom: 6px;
    }
    .search-input {
       flex: 1;
       padding: 6px 8px;
       border: 1px solid #cbd5e1;
       border-radius: 6px;
       font-size: 10px;
       background: white;
    }
    .search-input:focus {
       outline: none;
       border-color: #3b82f6;
    }
    .search-select {
       padding: 6px 4px;
       border: 1px solid #cbd5e1;
       border-radius: 6px;
       font-size: 9px;
       background: white;
       min-width: 90px;
    }
    .search-btn {
       padding: 6px 10px;
       background: linear-gradient(135deg, #3b82f6, #2563eb);
       color: white;
       border: none;
       border-radius: 6px;
       cursor: pointer;
       font-weight: 600;
       font-size: 10px;
       display: flex;
       align-items: center;
       gap: 4px;
    }
    .search-btn:hover {
       transform: translateY(-1px);
    }
    .search-btn.clear {
       background: linear-gradient(135deg, #94a3b8, #64748b);
    }
    .search-results {
       max-height: 150px;
       overflow-y: auto;
       margin-top: 6px;
    }
    .search-result-item {
       padding: 6px 8px;
       background: white;
       border: 1px solid #e2e8f0;
       border-radius: 6px;
       margin-bottom: 4px;
       cursor: pointer;
       transition: all 0.2s;
       font-size: 10px;
       display: flex;
       justify-content: space-between;
       align-items: center;
    }
    .search-result-item:hover {
       background: #f0f9ff;
       border-color: #3b82f6;
       transform: translateX(2px);
    }
    .search-result-item .sr-name {
       font-weight: 600;
       color: #1e293b;
    }
    .search-result-item .sr-detail {
       color: #64748b;
       font-size: 8px;
    }
    .search-result-item .sr-badge {
       background: #3b82f6;
       color: white;
       padding: 1px 6px;
       border-radius: 8px;
       font-size: 8px;
       font-weight: 700;
    }
    .search-empty {
       text-align: center;
       padding: 8px;
       color: #94a3b8;
       font-size: 10px;
       font-style: italic;
    }
    .stats-grid {
       display: grid;
       grid-template-columns: repeat(2, 1fr);
       gap: 6px;
       margin-bottom: 10px;
    }
    .stats-grid-3 {
       display: grid;
       grid-template-columns: repeat(3, 1fr);
       gap: 6px;
       margin-bottom: 10px;
    }
    .stat-card {
       padding: 8px;
       border-radius: 8px;
       text-align: center;
       color: white;
       box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
       transition: all 0.2s;
       position: relative;
       overflow: hidden;
       cursor: pointer;
    }
    .stat-card:hover {
       transform: translateY(-2px);
       box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    .stat-total {
       background: linear-gradient(135deg, #6366f1, #4f46e5);
    }
    .stat-menunggu {
       background: linear-gradient(135deg, #f59e0b, #d97706);
    }
    .stat-proses {
       background: linear-gradient(135deg, #0ea5e9, #0284c7);
    }
    .stat-selesai {
       background: linear-gradient(135deg, #10b981, #059669);
    }
    .stat-jalur {
       background: linear-gradient(135deg, #06b6d4, #0891b2);
    }
    .stat-bangunan {
       background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    }
    .stat-kantor {
       background: linear-gradient(135deg, #10b981, #059669);
    }
    .stat-ppob {
       background: linear-gradient(135deg, #f59e0b, #d97706);
    }
    .stat-belum {
       background: linear-gradient(135deg, #ef4444, #dc2626);
    }
    .stat-icon {
       font-size: 14px;
       opacity: 0.3;
       position: absolute;
       top: 4px;
       right: 4px;
    }
    .stat-value {
       font-size: 18px;
       font-weight: 700;
       margin: 0;
       position: relative;
    }
    .stat-label {
       font-size: 8px;
       opacity: 0.9;
       text-transform: uppercase;
       letter-spacing: 0.3px;
       margin-top: 2px;
       position: relative;
    }
    .revenue-card {
       background: linear-gradient(135deg, #10b981 0%, #059669 100%);
       color: white;
       padding: 12px;
       border-radius: 10px;
       margin-bottom: 10px;
       box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
       position: relative;
       overflow: hidden;
       cursor: pointer;
    }
    .revenue-title {
       font-size: 9px;
       opacity: 0.9;
       margin-bottom: 4px;
       display: flex;
       align-items: center;
       gap: 4px;
       position: relative;
    }
    .revenue-amount {
       font-size: 20px;
       font-weight: 800;
       margin-bottom: 2px;
       position: relative;
    }
    .revenue-kubikasi {
       font-size: 10px;
       opacity: 0.9;
       position: relative;
       display: flex;
       align-items: center;
       gap: 4px;
    }
    .section-title {
       font-size: 10px;
       font-weight: 600;
       color: #64748b;
       text-transform: uppercase;
       letter-spacing: 0.5px;
       margin: 10px 0 6px 0;
       padding-bottom: 4px;
       border-bottom: 2px solid #e2e8f0;
       display: flex;
       align-items: center;
       gap: 6px;
    }
    .list-item {
       padding: 8px;
       border: 1px solid #e2e8f0;
       border-radius: 8px;
       margin-bottom: 6px;
       cursor: pointer;
       transition: all 0.2s;
       background: white;
    }
    .list-item:hover {
       background: #f0f9ff;
       border-color: #0ea5e9;
       transform: translateX(2px);
       box-shadow: 0 2px 6px rgba(14, 165, 233, 0.1);
    }
    .list-item-header {
       display: flex;
       justify-content: space-between;
       align-items: center;
       margin-bottom: 3px;
    }
    .list-item-title {
       font-weight: 600;
       font-size: 11px;
       color: #1e293b;
       display: flex;
       align-items: center;
       gap: 6px;
    }
    .color-indicator {
       width: 16px;
       height: 3px;
       border-radius: 2px;
    }
    .control-buttons {
       position: fixed;
       left: 10px;
       top: 120px;
       z-index: 1001;
       display: flex;
       flex-direction: column;
       gap: 6px;
    }
    .control-btn {
       background: linear-gradient(135deg, #1e3c72, #2a5298);
       color: white;
       border: none;
       padding: 8px 12px;
       border-radius: 8px;
       box-shadow: 0 2px 8px rgba(30, 60, 114, 0.4);
       cursor: pointer;
       font-weight: 600;
       font-size: 11px;
       display: flex;
       align-items: center;
       gap: 6px;
       transition: all 0.3s;
    }
    .control-btn:hover {
       transform: translateY(-2px);
       box-shadow: 0 4px 12px rgba(30, 60, 114, 0.5);
    }
    .control-btn.expand {
       background: linear-gradient(135deg, #10b981, #059669);
    }
    .control-btn.expand.active {
       background: linear-gradient(135deg, #ef4444, #dc2626);
    }
    .control-btn.voice {
       background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    }
    .control-btn.voice.active {
       background: linear-gradient(135deg, #10b981, #059669);
    }
    .control-btn.live {
       background: linear-gradient(135deg, #ec4899, #db2777);
    }
    .control-btn.live.active {
       background: linear-gradient(135deg, #10b981, #059669);
       animation: pulse-live 2s infinite;
    }
    @keyframes pulse-live {
       0%,
       100% {
          box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
       }
       50% {
          box-shadow: 0 2px 15px rgba(16, 185, 129, 0.6);
       }
    }
    .custom-layer-control {
       position: fixed;
       top: 280px;
       left: 10px;
       background: white;
       border-radius: 8px;
       box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
       z-index: 1001;
       padding: 8px;
       max-width: 160px;
    }
    .layer-control-title {
       font-size: 9px;
       font-weight: 700;
       color: #1e293b;
       margin-bottom: 6px;
       display: flex;
       align-items: center;
       gap: 4px;
       padding-bottom: 4px;
       border-bottom: 1px solid #e2e8f0;
    }
    .layer-btn-group {
       display: grid;
       grid-template-columns: repeat(2, 1fr);
       gap: 4px;
    }
    .layer-btn {
       padding: 6px 4px;
       border: 2px solid #e2e8f0;
       background: white;
       border-radius: 6px;
       cursor: pointer;
       font-size: 9px;
       font-weight: 600;
       color: #64748b;
       transition: all 0.2s;
       display: flex;
       flex-direction: column;
       align-items: center;
       gap: 2px;
    }
    .layer-btn:hover {
       border-color: #3b82f6;
       color: #3b82f6;
    }
    .layer-btn.active {
       background: linear-gradient(135deg, #3b82f6, #2563eb);
       color: white;
       border-color: #3b82f6;
    }
    .layer-btn i {
       font-size: 12px;
    }
    .voice-panel {
       position: fixed;
       right: 10px;
       top: 120px;
       background: white;
       border-radius: 12px;
       box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
       padding: 14px;
       z-index: 1002;
       width: 340px;
       display: none;
       animation: slideInRight 0.3s ease;
       max-height: 85vh;
       overflow-y: auto;
    }
    .voice-panel.active {
       display: block;
    }
    @keyframes slideInRight {
       from {
          transform: translateX(50px);
          opacity: 0;
       }
       to {
          transform: translateX(0);
          opacity: 1;
       }
    }
    .voice-panel-header {
       display: flex;
       justify-content: space-between;
       align-items: center;
       margin-bottom: 10px;
       padding-bottom: 8px;
       border-bottom: 2px solid #e2e8f0;
    }
    .voice-panel-title {
       font-size: 12px;
       font-weight: 700;
       color: #1e293b;
       display: flex;
       align-items: center;
       gap: 6px;
    }
    .voice-panel-close {
       background: none;
       border: none;
       color: #94a3b8;
       cursor: pointer;
       font-size: 14px;
    }
    .voice-select-group {
       margin-bottom: 8px;
    }
    .voice-select-label {
       font-size: 9px;
       font-weight: 600;
       color: #64748b;
       margin-bottom: 3px;
       display: block;
    }
    .voice-select {
       width: 100%;
       padding: 6px;
       border: 1px solid #e2e8f0;
       border-radius: 6px;
       font-size: 10px;
       background: #f8fafc;
    }
    .voice-control-row {
       display: flex;
       align-items: center;
       gap: 8px;
       margin-top: 6px;
    }
    .voice-control-label {
       font-size: 9px;
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
       margin-top: 8px;
       padding: 8px;
       background: linear-gradient(135deg, #10b981, #059669);
       color: white;
       border: none;
       border-radius: 8px;
       cursor: pointer;
       font-weight: 600;
       font-size: 10px;
       display: flex;
       align-items: center;
       justify-content: center;
       gap: 6px;
    }
    .gangguan-voice-control,
    .payment-voice-control,
    .music-control,
    .scroll-control,
    .youtube-control,
    .mute-control {
       margin-top: 10px;
       padding: 10px;
       border-radius: 8px;
       border: 2px solid;
    }
    .gangguan-voice-control {
       background: linear-gradient(135deg, #fef3c7, #fde68a);
       border-color: #f59e0b;
    }
    .payment-voice-control {
       background: linear-gradient(135deg, #d1fae5, #a7f3d0);
       border-color: #10b981;
    }
    .music-control {
       background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
       border-color: #6366f1;
    }
    .scroll-control {
       background: linear-gradient(135deg, #fce7f3, #fbcfe8);
       border-color: #ec4899;
    }
    .youtube-control {
       background: linear-gradient(135deg, #fee2e2, #fecaca);
       border-color: #ef4444;
    }
    .mute-control {
       background: linear-gradient(135deg, #fef3c7, #fde68a);
       border-color: #f59e0b;
    }
    .voice-control-title {
       font-size: 9px;
       font-weight: 700;
       margin-bottom: 6px;
       display: flex;
       align-items: center;
       gap: 4px;
    }
    .gangguan-voice-control .voice-control-title {
       color: #92400e;
    }
    .payment-voice-control .voice-control-title {
       color: #065f46;
    }
    .music-control .voice-control-title {
       color: #3730a3;
    }
    .scroll-control .voice-control-title {
       color: #9d174d;
    }
    .youtube-control .voice-control-title {
       color: #991b1b;
    }
    .mute-control .voice-control-title {
       color: #92400e;
    }
    .voice-btn-group {
       display: grid;
       grid-template-columns: 1fr 1fr;
       gap: 6px;
    }
    .voice-btn {
       padding: 6px;
       border: none;
       border-radius: 6px;
       cursor: pointer;
       font-weight: 600;
       font-size: 9px;
       display: flex;
       align-items: center;
       justify-content: center;
       gap: 4px;
       transition: all 0.2s;
    }
    .voice-btn.play {
       background: linear-gradient(135deg, #10b981, #059669);
       color: white;
    }
    .voice-btn.pause {
       background: linear-gradient(135deg, #f59e0b, #d97706);
       color: white;
    }
    .voice-btn.stop {
       background: linear-gradient(135deg, #ef4444, #dc2626);
       color: white;
    }
    .voice-btn.repeat {
       background: linear-gradient(135deg, #3b82f6, #2563eb);
       color: white;
    }
    .voice-btn:hover {
       transform: translateY(-1px);
    }
    .voice-btn:disabled {
       opacity: 0.5;
       cursor: not-allowed;
    }
    .voice-status-indicator {
       display: flex;
       align-items: center;
       gap: 6px;
       margin-top: 6px;
       padding: 6px;
       background: white;
       border-radius: 6px;
       font-size: 8px;
    }
    .voice-status-dot {
       width: 6px;
       height: 6px;
       border-radius: 50%;
       background: #94a3b8;
    }
    .voice-status-dot.active {
       background: #10b981;
       animation: pulse-dot 1s infinite;
    }
    .voice-status-dot.paused {
       background: #f59e0b;
    }
    @keyframes pulse-dot {
       0%,
       100% {
          opacity: 1;
       }
       50% {
          opacity: 0.5;
       }
    }
    .live-info-panel {
       position: absolute;
       bottom: 10px;
       left: 50%;
       transform: translateX(-50%);
       background: linear-gradient(
          135deg,
          rgba(15, 23, 42, 0.95),
          rgba(30, 58, 138, 0.95)
       );
       color: white;
       padding: 8px 16px;
       border-radius: 10px;
       box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
       z-index: 500;
       display: flex;
       align-items: center;
       gap: 12px;
       backdrop-filter: blur(10px);
       border: 2px solid rgba(239, 68, 68, 0.5);
       min-width: 400px;
       animation: slideUp 0.5s ease;
    }
    @keyframes slideUp {
       from {
          transform: translate(-50%, 50px);
          opacity: 0;
       }
       to {
          transform: translate(-50%, 0);
          opacity: 1;
       }
    }
    .live-info-panel .live-indicator {
       display: flex;
       align-items: center;
       gap: 6px;
       padding: 4px 10px;
       background: linear-gradient(135deg, #ef4444, #dc2626);
       border-radius: 12px;
       font-size: 9px;
       font-weight: 700;
    }
    .live-info-panel .live-dot {
       width: 8px;
       height: 8px;
       background: white;
       border-radius: 50%;
       animation: live-pulse 1.5s infinite;
    }
    @keyframes live-pulse {
       0%,
       100% {
          opacity: 1;
          transform: scale(1);
       }
       50% {
          opacity: 0.5;
          transform: scale(1.3);
       }
    }
    .live-info-panel .customer-info {
       flex: 1;
       display: flex;
       flex-direction: column;
       gap: 1px;
    }
    .live-info-panel .customer-name {
       font-size: 12px;
       font-weight: 700;
       color: #fbbf24;
    }
    .live-info-panel .customer-detail {
       font-size: 9px;
       opacity: 0.9;
    }
    .live-info-panel .customer-amount {
       font-size: 13px;
       font-weight: 800;
       color: #f87171;
       padding: 4px 10px;
       background: rgba(239, 68, 68, 0.2);
       border-radius: 8px;
       border: 1px solid rgba(239, 68, 68, 0.5);
    }
    .live-info-panel .counter {
       text-align: center;
       padding: 2px 10px;
       background: rgba(255, 255, 255, 0.1);
       border-radius: 8px;
    }
    .live-info-panel .counter-num {
       font-size: 14px;
       font-weight: 800;
       color: #fbbf24;
    }
    .live-info-panel .counter-label {
       font-size: 7px;
       opacity: 0.8;
       text-transform: uppercase;
    }
    .unpaid-marker-wrapper {
       position: relative;
       display: flex;
       flex-direction: column;
       align-items: center;
          pointer-events: none; /* ← TAMBAHKAN INI (Buat area luar tembus klik) */
    }
    .unpaid-marker-pin {
       width: 14px;
       height: 14px;
       background: linear-gradient(135deg, #ef4444, #dc2626);
       border-radius: 50%;
       border: 2px solid white;
       display: flex;
       align-items: center;
       justify-content: center;
       color: white;
       font-size: 7px;
       box-shadow: 0 1px 4px rgba(239, 68, 68, 0.5);
       position: relative;
       z-index: 2;
       transition: all 0.3s ease;
       pointer-events: auto; /* ← TAMBAHKAN INI (Hanya pin yang bisa diklik) */
    }
    .unpaid-marker-pulse {
       position: absolute;
       top: 50%;
       left: 50%;
       transform: translate(-50%, -50%);
       width: 14px;
       height: 14px;
       border-radius: 50%;
       background: rgba(239, 68, 68, 0.3);
       animation: unpaid-pulse 2s infinite;
       z-index: 1;
    }
    @keyframes unpaid-pulse {
       0% {
          transform: translate(-50%, -50%) scale(1);
          opacity: 0.6;
       }
       100% {
          transform: translate(-50%, -50%) scale(2);
          opacity: 0;
       }
    }
    .unpaid-marker-label {
       position: absolute;
       top: -20px;
       left: 50%;
       transform: translateX(-50%);
       background: linear-gradient(135deg, #dc2626, #991b1b);
       color: white;
       padding: 1px 6px;
       border-radius: 8px;
       font-size: 7px;
       font-weight: 700;
       white-space: nowrap;
       box-shadow: 0 1px 4px rgba(0, 0, 0, 0.3);
       border: 1px solid white;
       z-index: 3;
       max-width: 100px;
       overflow: hidden;
       text-overflow: ellipsis;
       opacity: 0;
       transition: opacity 0.3s;
    }
    .unpaid-marker-wrapper:hover .unpaid-marker-label,
    .unpaid-marker-wrapper.highlighted .unpaid-marker-label {
       opacity: 1;
    }
    .unpaid-marker-amount {
       position: absolute;
       bottom: -16px;
       left: 50%;
       transform: translateX(-50%);
       background: #fbbf24;
       color: #7c2d12;
       padding: 1px 5px;
       border-radius: 5px;
       font-size: 7px;
       font-weight: 800;
       white-space: nowrap;
       box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
       z-index: 3;
       opacity: 0;
       transition: opacity 0.3s;
    }
    .unpaid-marker-wrapper:hover .unpaid-marker-amount,
    .unpaid-marker-wrapper.highlighted .unpaid-marker-amount {
       opacity: 1;
    }
    .unpaid-marker-wrapper.highlighted .unpaid-marker-pin {
       background: linear-gradient(135deg, #fbbf24, #f59e0b);
       box-shadow: 0 2px 12px rgba(251, 191, 36, 0.8);
       transform: scale(1.8);
       width: 20px;
       height: 20px;
    }
    .unpaid-marker-wrapper.highlighted .unpaid-marker-pulse {
       background: rgba(251, 191, 36, 0.5);
    }
    .pelanggan-marker-small {
       width: 10px;
       height: 10px;
       border-radius: 50%;
       border: 2px solid white;
       box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
       display: flex;
       align-items: center;
       justify-content: center;
       transition: all 0.3s ease;
    }
    .pelanggan-marker-small:hover {
       transform: scale(1.5);
       box-shadow: 0 2px 8px rgba(0, 0, 0, 0.4);
    }
    .toast-notification {
       position: fixed;
       top: 20px;
       left: 50%;
       transform: translateX(-50%);
       background: white;
       padding: 10px 16px;
       border-radius: 8px;
       box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
       z-index: 9999;
       display: flex;
       align-items: center;
       gap: 8px;
       font-size: 12px;
       font-weight: 600;
       animation: toastSlide 0.3s ease;
       max-width: 350px;
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
    .toast-notification.live {
       border-left: 4px solid #ef4444;
       color: #991b1b;
       background: #fef2f2;
    }
    .toast-notification.payment {
       border-left: 4px solid #10b981;
       color: #065f46;
       background: #ecfdf5;
    }
    @keyframes toastSlide {
       from {
          transform: translate(-50%, -50px);
          opacity: 0;
       }
       to {
          transform: translate(-50%, 0);
          opacity: 1;
       }
    }
    .legend {
       position: absolute;
       bottom: 10px;
       left: 10px;
       background: white;
       padding: 10px;
       border-radius: 8px;
       box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
       z-index: 500;
       max-width: 180px;
       font-size: 10px;
    }
    .legend-title {
       font-weight: 700;
       margin-bottom: 6px;
       color: #1e293b;
       font-size: 11px;
       display: flex;
       align-items: center;
       gap: 4px;
    }
    .legend-group {
       margin-bottom: 6px;
    }
    .legend-group-title {
       font-size: 8px;
       color: #64748b;
       text-transform: uppercase;
       font-weight: 600;
       margin-bottom: 2px;
       padding-bottom: 2px;
       border-bottom: 1px solid #e2e8f0;
    }
    .legend-item {
       display: flex;
       align-items: center;
       gap: 6px;
       margin: 2px 0;
    }
    .legend-color {
       width: 16px;
       height: 3px;
       border-radius: 2px;
    }
    .legend-marker {
       width: 12px;
       height: 12px;
       border-radius: 50%;
       border: 2px solid white;
       box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.2);
       display: flex;
       align-items: center;
       justify-content: center;
       color: white;
       font-size: 6px;
    }
    .legend-pelanggan {
       position: absolute;
       bottom: 10px;
       right: 330px;
       background: white;
       padding: 10px;
       border-radius: 8px;
       box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
       z-index: 500;
       max-width: 200px;
       font-size: 10px;
    }
    .legend-pelanggan-title {
       font-weight: 700;
       margin-bottom: 6px;
       color: #1e293b;
       font-size: 11px;
       display: flex;
       align-items: center;
       gap: 4px;
    }
    .legend-pelanggan-item {
       display: flex;
       align-items: center;
       gap: 6px;
       margin: 3px 0;
       font-size: 9px;
    }
    .legend-pelanggan-marker {
       width: 12px;
       height: 12px;
       border-radius: 50%;
       border: 2px solid white;
       box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.2);
       display: flex;
       align-items: center;
       justify-content: center;
       color: white;
       font-size: 6px;
    }
    .gangguan-card {
       margin-bottom: 8px;
       border: 2px solid #e2e8f0;
       border-radius: 8px;
       overflow: hidden;
       cursor: pointer;
       transition: all 0.2s;
       background: white;
    }
    .gangguan-card:hover {
       border-color: #0ea5e9;
       transform: translateX(2px);
       box-shadow: 0 2px 8px rgba(14, 165, 233, 0.15);
    }
    .gangguan-card.active {
       border-color: #3b82f6;
       box-shadow: 0 2px 10px rgba(59, 130, 246, 0.25);
    }
    .gangguan-card-header {
       padding: 6px 10px;
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
       font-size: 11px;
       display: flex;
       align-items: center;
       gap: 4px;
    }
    .gangguan-card-status {
       background: rgba(255, 255, 255, 0.25);
       padding: 2px 8px;
       border-radius: 10px;
       font-size: 8px;
       font-weight: 600;
       text-transform: uppercase;
    }
    .gangguan-card-body {
       padding: 8px 10px;
    }
    .gangguan-info-block {
       margin-bottom: 6px;
    }
    .gangguan-info-label {
       font-size: 8px;
       color: #64748b;
       font-weight: 700;
       text-transform: uppercase;
       margin-bottom: 2px;
       display: flex;
       align-items: center;
       gap: 3px;
    }
    .gangguan-info-value {
       font-weight: 600;
       color: #1e293b;
       font-size: 11px;
    }
    .gangguan-grid-2 {
       display: grid;
       grid-template-columns: 1fr 1fr;
       gap: 6px;
       margin-bottom: 6px;
    }
    .gangguan-grid-item {
       background: #f8fafc;
       padding: 6px;
       border-radius: 5px;
    }
    .gangguan-grid-item .label {
       font-size: 8px;
       color: #64748b;
       font-weight: 600;
       margin-bottom: 1px;
    }
    .gangguan-grid-item .value {
       font-weight: 600;
       color: #1e293b;
       font-size: 10px;
    }
    .estimasi-box {
       background: linear-gradient(135deg, #fef3c7, #fde68a);
       padding: 8px;
       border-radius: 8px;
       border-left: 3px solid #f59e0b;
       margin-top: 6px;
    }
    .estimasi-box-title {
       font-size: 8px;
       color: #92400e;
       font-weight: 700;
       margin-bottom: 6px;
       display: flex;
       align-items: center;
       gap: 4px;
       text-transform: uppercase;
    }
    .estimasi-item {
       margin-bottom: 4px;
    }
    .estimasi-item:last-child {
       margin-bottom: 0;
    }
    .estimasi-label {
       font-size: 8px;
       color: #78350f;
       font-weight: 600;
       margin-bottom: 1px;
       display: flex;
       align-items: center;
       gap: 3px;
    }
    .estimasi-value {
       font-weight: 700;
       color: #92400e;
       font-size: 10px;
    }
    .estimasi-value.big {
       font-size: 16px;
       color: #dc2626;
       display: flex;
       align-items: baseline;
       gap: 3px;
    }
    .estimasi-value.big .unit {
       font-size: 8px;
       color: #92400e;
       font-weight: 600;
    }
    .estimasi-sub {
       font-size: 8px;
       color: #78350f;
       margin-top: 1px;
    }
    .estimasi-sub strong {
       color: #dc2626;
    }
    .wilayah-card {
       margin-bottom: 10px;
       border: 1px solid #e2e8f0;
       border-radius: 8px;
       overflow: hidden;
    }
    .wilayah-header {
       background: linear-gradient(135deg, #3b82f6, #2563eb);
       color: white;
       padding: 6px 10px;
       font-weight: 600;
       font-size: 11px;
       display: flex;
       justify-content: space-between;
       align-items: center;
    }
    .wilayah-blok-list {
       padding: 6px;
    }
    .blok-item {
       display: flex;
       justify-content: space-between;
       align-items: center;
       padding: 6px 8px;
       margin: 3px 0;
       background: #f8fafc;
       border-radius: 5px;
       font-size: 10px;
       cursor: pointer;
       transition: all 0.2s;
    }
    .blok-item:hover {
       background: #e0f2fe;
    }
    .empty-state {
       text-align: center;
       padding: 12px;
       color: #94a3b8;
       font-size: 10px;
       font-style: italic;
    }
    .main-wrapper.is-fullscreen {
       position: fixed !important;
       top: 0 !important;
       left: 0 !important;
       width: 100vw !important;
       height: 100vh !important;
       z-index: 99999 !important;
       background: white;
       margin-right: 0 !important;
    }
    .main-wrapper.is-fullscreen #map {
       height: 100vh !important;
    }
    .main-wrapper.is-fullscreen .top-navbar,
    .main-wrapper.is-fullscreen .unit-progress-bar,
    .main-wrapper.is-fullscreen .sidebar,
    .main-wrapper.is-fullscreen .control-buttons,
    .main-wrapper.is-fullscreen .custom-layer-control {
       display: none !important;
    }
    @media (max-width: 768px) {
       .top-navbar-container {
          flex-direction: column;
          text-align: center;
       }
       .unit-progress-container {
          flex-direction: column;
       }
       .main-wrapper {
          margin-right: 0;
          height: calc(100vh - 150px);
       }
       .sidebar {
          width: 100% !important;
          max-width: 320px !important;
          top: auto !important;
          bottom: 0 !important;
          right: 0 !important;
          transform: translateY(100%) !important;
       }
       .sidebar.active {
          transform: translateY(0) !important;
       }
       .legend {
          max-width: 150px;
          font-size: 9px;
       }
       .legend-pelanggan {
          max-width: 150px;
          font-size: 9px;
          right: 10px;
          bottom: 10px;
       }
       .control-buttons {
          left: 10px;
          top: auto;
          bottom: 10px;
          flex-direction: row;
          flex-wrap: wrap;
       }
       .custom-layer-control {
          top: auto;
          bottom: 60px;
          left: 10px;
          max-width: 150px;
       }
       .voice-panel {
          right: 10px;
          top: auto;
          bottom: 60px;
          width: calc(100% - 20px);
          max-width: 340px;
       }
       .live-info-panel {
          min-width: auto;
          width: calc(100% - 20px);
          flex-wrap: wrap;
          gap: 6px;
       }
       .revenue-progress-details {
          grid-template-columns: repeat(2, 1fr);
       }
    }
  </style>
</head>
<body>
  <audio id="backgroundMusic" loop preload="auto"></audio>
  <div id="youtubePlayerContainer" style="
            position: fixed;
            bottom: -200px;
            right: -200px;
            width: 1px;
            height: 1px;
            opacity: 0;
            pointer-events: none;
            z-index: -1;
         "></div>
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
        <div class="contact-item-nav">
          <i class="fas fa-headset"></i>
          <span>Call Center: <strong>088294979966</strong></span>
        </div>
        <div class="contact-item-nav" style="background: rgba(37, 211, 102, 0.2)">
          <i class="fab fa-whatsapp"></i>
          <span>WhatsApp: <strong>088294979966</strong></span>
          <button class="wa-qr-btn-nav" onclick="showWAQR()">
            <i class="fas fa-qrcode"></i> QR
          </button>
        </div>
      </div>
      @php $gangguanAktif = isset($gangguanAktif) ? $gangguanAktif :
      collect($gangguan ?? [])->where('status', '!=', 'selesai');
      $totalAktif = $gangguanAktif->count(); @endphp @if($totalAktif > 0)
      <div class="alert-section">
        <div class="alert-icon"><i class="fas fa-info-circle"></i></div>
        <div class="alert-text">
          <strong>Informasi Gangguan</strong><small>{{ $totalAktif }} gangguan aktif</small>
        </div>
        <div class="alert-count">{{ $totalAktif }}</div>
      </div>
      @else
      <div class="alert-section" style="
                  background: rgba(16, 185, 129, 0.15);
                  border-color: rgba(16, 185, 129, 0.3);
               ">
        <div class="alert-icon" style="background: linear-gradient(135deg, #10b981, #059669)">
          <i class="fas fa-check-circle"></i>
        </div>
        <div class="alert-text">
          <strong>Pelayanan Normal</strong><small>Semua jaringan beroperasi baik</small>
        </div>
      </div>
      @endif
      <div class="notification-bar" id="notificationBar" style="display: none">
        <div class="notification-title">
          <i class="fas fa-money-bill-wave"></i> Pembayaran Terbaru
        </div>
        <div class="notification-scroll">
          <div class="notification-scroll-content" id="notificationContent"></div>
        </div>
      </div>
    </div>
  </div>
  <div class="unit-progress-bar">
    <div class="unit-progress-container">
      <div class="unit-image-wrapper">
        <img src="https://images.unsplash.com/photo-1581092160607-ee22621dd758?w=200&h=150&fit=crop" alt="Unit PDAM Darmaraja" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2280%22 height=%2260%22%3E%3Crect fill=%22%231e3c72%22 width=%2280%22 height=%2260%22/%3E%3Ctext x=%2240%22 y=%2230%22 text-anchor=%22middle%22 fill=%22white%22 font-size=%2210%22%3EPDAM%3C/text%3E%3C/svg%3E'" />
      </div>
      <div class="unit-info">
        <h3><i class="fas fa-building"></i> Unit Cabang Darmaraja</h3>
        <p>Kec. Darmaraja, Kab. Sumedang</p>
        <button class="unit-narrate-btn" onclick="narrateUnitProfile()">
          <i class="fas fa-volume-up"></i> Dengarkan Profil
        </button>
      </div>
      <div class="revenue-progress-section">
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
              <span>Sisa
                <strong id="remainingDays">0</strong> hari</span>
            </div>
          </div>
        </div>
        <div class="revenue-progress-bar-container">
          <div class="revenue-progress-bar" id="revenueProgressBar" style="width: 0%"></div>
          <div class="revenue-progress-percentage" id="revenueProgressPercentage">
            0%
          </div>
        </div>
        <div class="revenue-progress-details">
          <div class="revenue-detail-card">
            <div class="revenue-detail-label">
              <i class="fas fa-coins"></i><span>Target</span>
            </div>
            <div class="revenue-detail-value" id="targetRevenue">
              Rp 0
            </div>
          </div>
          <div class="revenue-detail-card">
            <div class="revenue-detail-label">
              <i class="fas fa-money-bill-wave"></i><span>Terkumpul</span>
            </div>
            <div class="revenue-detail-value success" id="collectedRevenue">
              Rp 0
            </div>
          </div>
          <div class="revenue-detail-card">
            <div class="revenue-detail-label">
              <i class="fas fa-exclamation-triangle"></i><span>Sisa+Denda</span>
            </div>
            <div class="revenue-detail-value warning" id="remainingRevenue">
              Rp 0
            </div>
          </div>
          <div class="revenue-detail-card">
            <div class="revenue-detail-label">
              <i class="fas fa-tachometer-alt"></i><span>Rata²/Hari</span>
            </div>
            <div class="revenue-detail-value danger" id="dailyTarget">
              Rp 0
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="main-wrapper" id="mainWrapper">
    <div id="map"></div>
    <div class="live-info-panel" id="liveInfoPanel" style="display: none">
      <div class="live-indicator">
        <div class="live-dot"></div>
        <span>LIVE</span>
      </div>
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
      <div class="layer-control-title">
        <i class="fas fa-layer-group"></i> Mode Peta
      </div>
      <div class="layer-btn-group">
        <button class="layer-btn" data-layer="street" onclick="switchLayer('street')">
          <i class="fas fa-map"></i><span>Jalan</span>
        </button>
        <button class="layer-btn active" data-layer="satellite" onclick="switchLayer('satellite')">
          <i class="fas fa-satellite"></i><span>Satelit</span>
        </button>
        <button class="layer-btn" data-layer="terrain" onclick="switchLayer('terrain')">
          <i class="fas fa-mountain"></i><span>Medan</span>
        </button>
        <button class="layer-btn" data-layer="dark" onclick="switchLayer('dark')">
          <i class="fas fa-moon"></i><span>Gelap</span>
        </button>
      </div>
    </div>
    <div class="control-buttons">
      <button class="control-btn" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i> Info
      </button>
      <button class="control-btn expand" id="expandBtn" onclick="toggleFullscreen()">
        <i class="fas fa-expand"></i> <span>Fullscreen</span>
      </button>
      <button class="control-btn voice active" id="voiceBtn" onclick="toggleVoicePanel()">
        <i class="fas fa-sliders-h"></i> <span>Suara</span>
      </button>
      <button class="control-btn live" id="liveBtn" onclick="toggleLiveDashboard()">
        <i class="fas fa-broadcast-tower"></i>
        <span id="liveText">LIVE OFF</span>
      </button>
    </div>
    <div class="voice-panel" id="voicePanel">
      <div class="voice-panel-header">
        <div class="voice-panel-title">
          <i class="fas fa-sliders-h"></i> Panel Kontrol Suara
        </div>
        <button class="voice-panel-close" onclick="toggleVoicePanel()">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="music-control">
        <div class="voice-control-title">
          <i class="fas fa-music"></i> KONTROL MUSIK LATAR
        </div>
        <label class="voice-select-label">🎵 Pilih Musik:</label>
        <select class="voice-select" id="musicSelect" onchange="changeMusic()">
          <option value="">-- Pilih Musik --</option>
          <option value="musik1.mp3">🎵 Musik 1 (Tenang)</option>
          <option value="musik2.mp3">🎶 Musik 2 (Semangat)</option>
          <option value="musik3.mp3">Musik 3 (Klasik)</option>
          <option value="musik4.mp3">🌧️ Musik 4 (Alam)</option>
          <option value="musik5.mp3">🎧 Musik 5 (Lo-Fi)</option>
        </select>
        <div class="voice-control-row">
          <div class="voice-control-label">Volume</div>
          <input type="range" min="0" max="100" value="30" id="musicVolumeSlider" oninput="setMusicVolume(this.value)" />
          <span id="musicVolumeValue" style="font-size: 9px; font-weight: 600; min-width: 30px">30%</span>
        </div>
        <div class="voice-btn-group" style="margin-top: 6px">
          <button class="voice-btn play" id="btnPlayMusic" onclick="playMusic()">
            <i class="fas fa-play"></i> Putar
          </button>
          <button class="voice-btn pause" id="btnPauseMusic" onclick="pauseMusic()" disabled>
            <i class="fas fa-pause"></i> Pause
          </button>
          <button class="voice-btn stop" id="btnStopMusic" onclick="stopMusic()" disabled>
            <i class="fas fa-stop"></i> Stop
          </button>
          <button class="voice-btn repeat" id="btnLoopMusic" onclick="toggleLoopMusic()" style="
                        background: linear-gradient(135deg, #6366f1, #4f46e5);
                     ">
            <i class="fas fa-redo"></i> Rotasi
          </button>
        </div>
      </div>
      <!-- 🔥 YOUTUBE CONTROL -->
      <div class="youtube-control">
        <div class="voice-control-title">
          <i class="fab fa-youtube"></i> YOUTUBE MUSIC
        </div>
        <div class="voice-control-row">
          <input type="text" id="youtubeUrl" placeholder="Paste link YouTube..." style="
                        flex: 1;
                        padding: 6px;
                        border: 1px solid #e2e8f0;
                        border-radius: 6px;
                        font-size: 9px;
                     " />
        </div>
        <div class="voice-btn-group" style="margin-top: 6px">
          <button class="voice-btn play" onclick="loadYouTube()">
            <i class="fab fa-youtube"></i> Putar
          </button>
          <button class="voice-btn stop" onclick="stopYouTube()">
            <i class="fas fa-stop"></i> Stop
          </button>
        </div>
        <div class="voice-control-row" style="margin-top: 6px">
          <div class="voice-control-label">Volume</div>
          <input type="range" min="0" max="100" value="50" id="youtubeVolumeSlider" oninput="setYouTubeVolume(this.value)" />
          <span id="youtubeVolumeValue" style="font-size: 9px; font-weight: 600; min-width: 30px">50%</span>
        </div>
      </div>
      <!-- 🔥 MUTE CONTROL (KHUSUS LIVE) -->
      <div class="mute-control">
        <div class="voice-control-title">
          <i class="fas fa-volume-mute"></i> MUTE SUARA LIVE
        </div>
        <div class="voice-btn-group">
          <button class="voice-btn" id="btnMuteLive" onclick="toggleMuteLive()" style="
                        background: linear-gradient(135deg, #ef4444, #dc2626);
                        grid-column: span 2;
                     ">
            <i class="fas fa-volume-up"></i>
            <span id="muteLiveText">Mute Suara Live</span>
          </button>
        </div>
        <div class="voice-status-indicator" style="margin-top: 6px">
          <div class="voice-status-dot active" id="muteLiveStatusDot"></div>
          <span id="muteLiveStatusText">Suara Live Aktif</span>
        </div>
      </div>
      <div class="gangguan-voice-control">
        <div class="voice-control-title">
          <i class="fas fa-exclamation-triangle"></i> SUARA GANGGUAN
        </div>
        <div class="voice-select-group">
          <label class="voice-select-label">🎤 Gender:</label>
          <select class="voice-select" id="gangguanGenderSelect" onchange="updateGangguanGender()">
            <option value="male">👨 Laki-laki</option>
            <option value="female" selected>👩 Perempuan</option>
          </select>
        </div>
        <div class="voice-select-group">
          <label class="voice-select-label">🎤 Pilih Suara:</label>
          <select class="voice-select" id="gangguanVoiceSelect" onchange="updateVoiceIndex()">
            <option value="0">1. Default</option>
            <option value="1">2. Alternatif 1</option>
            <option value="2">3. Alternatif 2</option>
            <option value="3" selected>4. Alternatif 3 ⭐</option>
            <option value="4">5. Alternatif 4</option>
          </select>
        </div>
        <div class="voice-btn-group">
          <button class="voice-btn play" id="btnPlayGangguan" onclick="playGangguanVoice()" disabled>
            <i class="fas fa-play"></i> Putar
          </button>
          <button class="voice-btn pause" id="btnPauseGangguan" onclick="pauseGangguanVoice()" disabled>
            <i class="fas fa-pause"></i> Pause
          </button>
          <button class="voice-btn stop" id="btnStopGangguan" onclick="stopGangguanVoice()" disabled>
            <i class="fas fa-stop"></i> Stop
          </button>
          <button class="voice-btn repeat" id="btnRepeatGangguan" onclick="toggleRepeatGangguan()">
            <i class="fas fa-redo"></i> Ulang
          </button>
        </div>
        <div class="voice-status-indicator">
          <div class="voice-status-dot" id="gangguanVoiceStatusDot"></div>
          <span id="gangguanVoiceStatusText">Siap</span>
        </div>
      </div>
      <div class="payment-voice-control">
        <div class="voice-control-title">
          <i class="fas fa-money-bill-wave"></i> SUARA PELANGGAN
        </div>
        <div class="voice-select-group">
          <label class="voice-select-label">🎤 Gender:</label>
          <select class="voice-select" id="paymentGenderSelect" onchange="updatePaymentGender()">
            <option value="female" selected>👩 Perempuan</option>
            <option value="male">👨 Laki-laki</option>
          </select>
        </div>
        <div class="voice-select-group">
          <label class="voice-select-label">🎤 Pilih Suara:</label>
          <select class="voice-select" id="paymentVoiceSelect" onchange="updateVoiceIndex()">
            <option value="0">1. Default</option>
            <option value="1">2. Alternatif 1</option>
            <option value="2">3. Alternatif 2</option>
            <option value="3" selected>4. Alternatif 3</option>
            <option value="4">5. Alternatif 4</option>
          </select>
        </div>
        <div class="voice-btn-group">
          <button class="voice-btn play" id="btnPlayPayment" onclick="playLast5Payments()">
            <i class="fas fa-play"></i> Baca Terakhir
          </button>
          <button class="voice-btn pause" id="btnPausePayment" onclick="pausePaymentVoice()" disabled>
            <i class="fas fa-pause"></i> Pause
          </button>
          <button class="voice-btn stop" id="btnStopPayment" onclick="stopPaymentVoice()" disabled>
            <i class="fas fa-stop"></i> Stop
          </button>
          <button class="voice-btn repeat" id="btnRepeatPayment" onclick="toggleRepeatPayment()">
            <i class="fas fa-redo"></i> Auto
          </button>
        </div>
        <div class="voice-status-indicator">
          <div class="voice-status-dot" id="paymentVoiceStatusDot"></div>
          <span id="paymentVoiceStatusText">Siap</span>
        </div>
      </div>
      <div class="scroll-control">
        <div class="voice-control-title">
          <i class="fas fa-broadcast-tower"></i> LIVE DASHBOARD
        </div>
        <div class="voice-control-row">
          <div class="voice-control-label">Kecepatan</div>
          <input type="range" min="3" max="20" value="7" id="liveSpeedSlider" oninput="setLiveSpeed(this.value)" />
          <span id="liveSpeedValue" style="font-size: 9px; font-weight: 600; min-width: 35px">7 detik</span>
        </div>
        <div class="voice-btn-group" style="margin-top: 6px">
          <button class="voice-btn play" id="btnLiveStart" onclick="startLiveCycle()">
            <i class="fas fa-play"></i> Mulai
          </button>
          <button class="voice-btn stop" id="btnLiveStop" onclick="stopLiveCycle()" disabled>
            <i class="fas fa-stop"></i> Stop
          </button>
        </div>
      </div>
      <div style="
                  margin-top: 10px;
                  padding: 10px;
                  background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
                  border-radius: 8px;
                  border: 2px solid #94a3b8;
               ">
        <div class="voice-control-title" style="color: #334155">
          <i class="fas fa-cog"></i> PENGATURAN
        </div>
        <div class="voice-control-row">
          <div class="voice-control-label">Volume</div>
          <input type="range" min="0" max="100" value="80" id="volumeSlider" oninput="setVoiceVolume(this.value)" />
          <span id="volumeValue" style="font-size: 9px; font-weight: 600; min-width: 30px">80%</span>
        </div>
        <button class="voice-test-btn" onclick="testVoice()">
          <i class="fas fa-play"></i> Test Suara
        </button>
      </div>
      <div class="scroll-control">
        <div class="voice-control-title">
          <i class="fas fa-tachometer-alt"></i> KECEPATAN TULISAN
        </div>
        <div class="voice-control-row">
          <div class="voice-control-label">Kecepatan</div>
          <input type="range" min="10" max="200" value="60" id="scrollSpeedSlider" oninput="setScrollSpeed(this.value)" />
          <span id="scrollSpeedValue" style="font-size: 9px; font-weight: 600; min-width: 60px">Normal</span>
        </div>
      </div>
    </div>
    <div class="sidebar" id="sidebar">
      <div class="sidebar-header">
        <h5><i class="fas fa-network-wired"></i> Informasi Jaringan</h5>
        <small>Kecamatan Darmaraja, Kab. Sumedang</small>
      </div>
      <div class="sidebar-content" id="sidebarContent">
        <div class="search-container">
          <div class="search-title">
            <i class="fas fa-search"></i> Pencarian Pelanggan
          </div>
          <div class="search-row">
            <input type="text" class="search-input" id="searchInput" placeholder="No. Sambungan / Nama..." oninput="performSearch()" />
            <select class="search-select" id="searchFilter" onchange="performSearch()">
              <option value="all">Semua</option>
              <option value="Kantor">Kantor</option>
              <option value="PPOB">PPOB</option>
              <option value="Belum Bayar">Belum Bayar</option>
            </select>
          </div>
          <div class="search-row">
            <button class="search-btn" onclick="performSearch()">
              <i class="fas fa-search"></i> Cari
            </button>
            <button class="search-btn clear" onclick="clearSearch()">
              <i class="fas fa-times"></i> Reset
            </button>
          </div>
          <div class="search-results" id="searchResults"></div>
        </div>
        <!-- 🔥 CARD HARI INI DENGAN FORMAT LENGKAP -->
        <div id="today-stats-card" class="revenue-card" style="
                     background: linear-gradient(135deg, #3b82f6, #1d4ed8);
                     margin-bottom: 10px;
                  ">
          <div class="revenue-title">
            <i class="fas fa-calendar-day"></i>
            <span id="today-date">Hari Ini</span>
          </div>
          <div class="revenue-amount" id="today-amount">Rp 0</div>
          <div class="revenue-kubikasi">
            <i class="fas fa-users"></i>
            <strong id="today-count">0</strong> rekening •
            <strong id="today-kubikasi">0</strong> m³
          </div>
        </div>
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
            <div class="stat-value">
              {{ $stats['dalam_proses'] ?? 0 }}
            </div>
            <div class="stat-label">Proses</div>
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
            <div class="stat-value">
              {{ ($jalurPipa ?? collect())->count() }}
            </div>
            <div class="stat-label">Jalur Pipa</div>
          </div>
          <div class="stat-card stat-bangunan">
            <i class="fas fa-building stat-icon"></i>
            <div class="stat-value">
              {{ ($bangunan ?? collect())->count() }}
            </div>
            <div class="stat-label">Bangunan</div>
          </div>
          <!-- 🔥 CARD ZONA -->
          <div class="stat-card" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
            <i class="fas fa-map-marked-alt stat-icon"></i>
            <div class="stat-value">{{ ($zonaList ?? collect())->count() }}</div>
            <div class="stat-label">Zona</div>
          </div>
          <!-- 🔥 CARD TITIK PENTING -->
          <div class="stat-card" style="background: linear-gradient(135deg, #06b6d4, #0891b2);">
            <i class="fas fa-map-pin stat-icon"></i>
            <div class="stat-value">{{ ($titikPenting ?? collect())->count() }}</div>
            <div class="stat-label">Titik Penting</div>
          </div>
        </div>
        <div class="section-title">
          <i class="fas fa-exclamation-triangle text-danger"></i>
          Gangguan Aktif
          <span class="badge bg-danger ms-auto">{{ $gangguanAktif->count() }}</span>
        </div>
        @forelse($gangguanAktif as $gang) @if(is_object($gang))
        <div class="gangguan-card" data-id="{{ $gang->id }}" data-type="gangguan" onclick="focusOnGangguan({{ $gang->id }})">
          <div class="gangguan-card-header status-{{ $gang->status }}">
            <div class="gangguan-card-code">
              <i class="fas fa-exclamation-circle"></i> {{
                        $gang->kode_laporan }}
            </div>
            <span class="gangguan-card-status">{{ ucfirst(str_replace('_', ' ', $gang->status))
                        }}</span>
          </div>
          <div class="gangguan-card-body">
            <div class="gangguan-info-block">
              <div class="gangguan-info-label">
                <i class="fas fa-map-marker-alt"></i> Lokasi
              </div>
              <div class="gangguan-info-value">
                {{ $gang->lokasi }}
              </div>
            </div>
            <div class="gangguan-grid-2">
              <div class="gangguan-grid-item">
                <div class="label">
                  <i class="fas fa-tools"></i> Kondisi
                </div>
                <div class="value">
                  {{ ucfirst(str_replace('_', ' ',
                              $gang->tipe_kerusakan)) }}
                </div>
              </div>
              <div class="gangguan-grid-item">
                <div class="label">
                  <i class="fas fa-users"></i> Dampak
                </div>
                <div class="value">
                  {{ Str::limit($gang->wilayah_terdampak, 15) }}
                </div>
              </div>
            </div>
            <div class="estimasi-box">
              <div class="estimasi-box-title">
                <i class="fas fa-calculator"></i> Estimasi Real-Time
              </div>
              <div class="estimasi-item">
                <div class="estimasi-label">
                  <i class="fas fa-ruler-horizontal"></i> Ukuran
                  Pipa
                </div>
                <div class="estimasi-value">
                  {{ $gang->ukuran_pipa }}
                </div>
              </div>
              <div class="estimasi-item">
                <div class="estimasi-label">
                  <i class="fas fa-tint-slash"></i> Potensi
                  Kehilangan
                </div>
                <div class="estimasi-value big">
                  {{ number_format($gang->debit_bocor ?? 0, 0)
                              }}<span class="unit">m³/jam</span>
                </div>
                <div class="estimasi-sub">
                  Total:
                  <strong>{{ number_format($gang->total_kehilangan_air
                                 ?? 0, 1) }} m³</strong>
                  ({{ $gang->durasi_jam ?? 0 }} jam)
                </div>
              </div>
              @if($gang->estimasi_selesai)
              <div class="estimasi-item">
                <div class="estimasi-label">
                  <i class="fas fa-calendar-check"></i> Estimasi
                  Selesai
                </div>
                <div class="estimasi-value" style="color: #059669">
                  {{
                              \Carbon\Carbon::parse($gang->estimasi_selesai)->format('d/m/Y')
                              }}
                </div>
              </div>
              @endif
            </div>
            @if($gang->deskripsi)
            <div style="
                           margin-top: 6px;
                           padding: 6px;
                           background: #f1f5f9;
                           border-radius: 5px;
                        ">
              <div style="
                              font-size: 8px;
                              color: #64748b;
                              font-weight: 600;
                              margin-bottom: 1px;
                           ">
                <i class="fas fa-info-circle"></i> DESKRIPSI
              </div>
              <div style="font-size: 9px; color: #475569">
                {{ Str::limit($gang->deskripsi, 80) }}
              </div>
            </div>
            @endif
          </div>
        </div>
        @endif @empty
        <div class="empty-state">
          <i class="fas fa-check-circle" style="font-size: 24px; color: #10b981; margin-bottom: 6px"></i>
          <div>Tidak ada gangguan aktif</div>
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
              <i class="fas fa-tag"></i> {{ ucfirst(str_replace('_', '
                        ', $b->jenis_bangunan)) }}
            </div>
          </div>
        </div>
        @empty
        <div class="empty-state">Belum ada data bangunan</div>
        @endforelse
        <!-- 🔥 ZONA WILAYAH -->
        <div class="section-title">
          <i class="fas fa-map-marked-alt" style="color: #f59e0b;"></i> Zona Wilayah
          <span class="badge bg-warning ms-auto">{{ ($zonaList ?? collect())->count() }}</span>
        </div>

        @forelse($zonaList ?? [] as $z)
        <div class="list-item" data-id="{{ $z->id }}" data-type="zona" onclick="focusOnZona({{ $z->id }})">
          <div class="layer-info">
            <div class="layer-name">
              <span class="color-dot" style="background: {{ $z->warna }};"></span>
              {{ $z->nama_zona }}
            </div>
            <div class="layer-meta">
              <i class="fas fa-tag"></i> {{ $z->jenis_zona }}
              @if($z->elevasi_min || $z->elevasi_max)
              <span style="margin-left: 8px;">
                <i class="fas fa-mountain"></i>
                {{ $z->elevasi_min ?? '?' }}-{{ $z->elevasi_max ?? '?' }} mdpl
              </span>
              @endif
            </div>
          </div>
        </div>
        @empty
        <div class="empty-state">Belum ada data zona</div>
        @endforelse
        <div class="section-title">
          <i class="fas fa-map-marked-alt text-primary"></i> Wilayah &
          Blok
        </div>
        <div id="wilayah-blok-container">
          <div class="text-center py-3 text-muted">
            <i class="fas fa-spinner fa-spin"></i> Memuat data
            wilayah...
          </div>
        </div>
      </div>
    </div>
    <div class="legend">
      <div class="legend-title">
        <i class="fas fa-info-circle"></i> Legenda Peta
      </div>
      <!-- 🔥 ZONA WILAYAH -->
      <div class="section-title">
        <i class="fas fa-map-marked-alt" style="color: #f59e0b;"></i> Zona Wilayah
        <span class="badge bg-warning ms-auto">{{ ($zonaList ?? collect())->count() }}</span>
      </div>

      @forelse($zonaList ?? [] as $z)
      <div class="list-item" data-id="{{ $z->id }}" data-type="zona" onclick="focusOnZona({{ $z->id }})">
        <div class="layer-info">
          <div class="layer-name">
            <span class="color-dot" style="background: {{ $z->warna }};"></span>
            {{ $z->nama_zona }}
          </div>
          <div class="layer-meta">
            <i class="fas fa-tag"></i> {{ $z->jenis_zona }}
            @if($z->elevasi_min || $z->elevasi_max)
            <span style="margin-left: 8px;">
              <i class="fas fa-mountain"></i>
              {{ $z->elevasi_min ?? '?' }}-{{ $z->elevasi_max ?? '?' }} mdpl
            </span>
            @endif
          </div>
        </div>
      </div>
      @empty
      <div class="empty-state">Belum ada data zona</div>
      @endforelse
      <div class="legend-group">
        <div class="legend-group-title">Jalur Pipa</div>
        <div class="legend-item">
          <div class="legend-color" style="background: #ef4444"></div>
          <span>Transmisi</span>
        </div>
        <div class="legend-item">
          <div class="legend-color" style="background: #3b82f6"></div>
          <span>Distribusi</span>
        </div>
        <div class="legend-item">
          <div class="legend-color" style="background: #10b981"></div>
          <span>Tersier</span>
        </div>
      </div>
      <div class="legend-group">
        <div class="legend-group-title">Bangunan</div>
        <div class="legend-item">
          <div class="legend-marker" style="background: #06b6d4">
            <i class="fas fa-database"></i>
          </div>
          <span>Reservoir</span>
        </div>
        <div class="legend-item">
          <div class="legend-marker" style="background: #8b5cf6">
            <i class="fas fa-industry"></i>
          </div>
          <span>IPA</span>
        </div>
        <div class="legend-item">
          <div class="legend-marker" style="background: #3b82f6">
            <i class="fas fa-building"></i>
          </div>
          <span>Kantor</span>
        </div>
      </div>
      <div class="legend-group">
        <div class="legend-group-title">Gangguan</div>
        <div class="legend-item">
          <div class="legend-marker" style="background: #ef4444">
            <i class="fas fa-exclamation"></i>
          </div>
          <span>Aktif</span>
        </div>
        <div class="legend-item">
          <div class="legend-marker" style="background: #f59e0b">
            <i class="fas fa-tools"></i>
          </div>
          <span>Proses</span>
        </div>
        <div class="legend-item">
          <div class="legend-marker" style="background: #10b981">
            <i class="fas fa-check"></i>
          </div>
          <span>Selesai</span>
        </div>
      </div>
    </div>
    <div class="legend-pelanggan">
      <div class="legend-pelanggan-title">
        <i class="fas fa-users"></i> Status Pembayaran
      </div>
      <div class="legend-pelanggan-item">
        <div class="legend-pelanggan-marker" style="background: #10b981">
          <i class="fas fa-building"></i>
        </div>
        <span>Bayar di Kantor</span>
      </div>
      <div class="legend-pelanggan-item">
        <div class="legend-pelanggan-marker" style="background: #f59e0b">
          <i class="fas fa-mobile-alt"></i>
        </div>
        <span>Bayar di PPOB</span>
      </div>
      <div class="legend-pelanggan-item">
        <div class="legend-pelanggan-marker" style="background: #ef4444">
          <i class="fas fa-times"></i>
        </div>
        <span>Belum Bayar</span>
      </div>
    </div>
  </div>
  <div class="modal fade" id="waQRModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content wa-modal-content">
        <div class="wa-modal-header">
          <i class="fab fa-whatsapp" style="font-size: 40px"></i>
          <h4 class="mt-2">WhatsApp PDAM Tirta Medal</h4>
          <small>Scan QR Code atau klik tombol di bawah</small>
        </div>
        <div class="wa-qr-container">
          <div id="wa-qrcode"></div>
          <div class="wa-info">
            <div class="wa-info-item">
              <i class="fas fa-phone"></i><span><strong>088294979966</strong></span>
            </div>
            <div class="wa-info-item">
              <i class="fas fa-clock"></i><span>Senin - Sabtu, 08.00 - 16.00 WIB</span>
            </div>
            <div class="wa-info-item">
              <i class="fas fa-info-circle"></i><span>Layanan pengaduan & informasi pelanggan</span>
            </div>
          </div>
          <a href="https://wa.me/6288294979966?text=Halo%20PDAM%20Tirta%20Medal%2C%20saya%20ingin%20melaporkan%20gangguan" target="_blank" class="wa-btn-direct"><i class="fab fa-whatsapp"></i> Buka WhatsApp Langsung</a>
          <button type="button" class="btn btn-light mt-2" data-bs-dismiss="modal" style="width: 100%">
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
    // ============================================
    // DATA DARI LARAVEL
    // ============================================
    const jalurPipaData = @json($jalurPipa ?? []);
    const bangunanData = @json($bangunan ?? []);
    const gangguanData = @json($gangguan ?? []);
    const titikPentingData = @json($titikPenting ?? []);
    const pelangganDataFromLaravel = @json($pelanggan ?? []);
    const zonaData = @json($zonaList ?? []); // 🔥 ZONA DATA
    const API_REALTIME_URL = '/api/pelanggan/realtime';
    const POLLING_INTERVAL = 10000;
    
    
    // ============================================
    // VARIABEL GLOBAL
    // ============================================
            //  let map, jalurLayers = {}, markerLayers = {}, pelangganLayers = {}, pelangganClusterGroup;
    let map, jalurLayers = {}, markerLayers = {}, pelangganLayers = {}, pelangganClusterGroup, zonaLayers = {}; // 🔥 TAMBAH zonaLayers
    let isFullscreen = false, totalRevenue = 0, totalKubikasi = 0;
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
    let isGangguanVoicePlaying = false, isGangguanVoicePaused = false, repeatGangguanVoice = false, activeGangguanList = [];
    let isPaymentVoicePlaying = false, isPaymentVoicePaused = false, repeatPaymentVoice = false, last5Payments = [], currentPaymentIndex = 0;
    let lastActivityTime = Date.now(), sidebarScrollDirection = 1, sidebarScrollInterval, isSidebarAutoScrolling = false;
    let isMusicPlaying = false, isMusicPaused = false, musicLoop = true;
    let currentMusicType = '';
    let unpaidCustomerMarkers = [], unpaidCustomerList = [];
    let liveCycleInterval = null, liveCycleIndex = 0, liveCycleSpeed = 7000;
    let isLiveDashboardActive = false, highlightedMarkerElement = null;
    let voiceQueue = [];
    let isVoiceSpeaking = false;
    let isNarrating = false;
    let currentNarrationIndex = 0;
    let narrationPaused = false;
    let realtimePollingInterval = null;
    let lastKnownPaymentTimestamps = {};
    let isFirstLoad = true;
    // 🔥 VARIABEL YOUTUBE
    let youtubePlayer = null;
    let isYoutubeReady = false;
    // 🔥 VARIABEL MUTE LIVE
    let isLiveMuted = false;
    
    // ============================================
    // 🔥 YOUTUBE API CALLBACK
    // ============================================
    function onYouTubeIframeAPIReady() {
    console.log('✅ YouTube API Ready');
    isYoutubeReady = true;
}

function extractYouTubeId(url) {
    const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
    const match = url.match(regExp);
    return (match && match[2].length === 11) ? match[2] : null;
}

/**
 * FUNGSI PERBAIKAN: Deteksi konten resmi/musik sebelum memuat
 * Membantu pengguna sadar sebelum video error 150 muncul
 */
function isPotentiallyRestricted(url) {
    const blackList = ['vevo', 'officialmusic', 'sony', 'warnermusic'];
    return blackList.some(term => url.toLowerCase().includes(term));
}

function loadYouTube() {
    const url = document.getElementById('youtubeUrl').value.trim();
    if (!url) {
        showNotification('❌ Paste link YouTube dulu', 'warning');
        return;
    }
    
    const videoId = extractYouTubeId(url);
    if (!videoId) {
        showNotification('❌ Link YouTube tidak valid', 'warning');
        return;
    }

    // Peringatan dini jika link terdeteksi sebagai konten berlisensi ketat
    if (isPotentiallyRestricted(url)) {
        console.warn("Terdeteksi link kemungkinan berlisensi ketat.");
    }
    
    if (typeof isYoutubeReady === 'undefined' || !isYoutubeReady) {
        showNotification('⏳ YouTube API belum siap', 'warning');
        return;
    }
    
    if (youtubePlayer) { try { youtubePlayer.destroy(); } catch(e) {} }
    
    document.getElementById('youtubePlayerContainer').innerHTML = '<div id="ytPlayer"></div>';
    
    youtubePlayer = new YT.Player('ytPlayer', {
        height: '1', width: '1',
        videoId: videoId,
        host: 'https://www.youtube.com',
        playerVars: { 
            'autoplay': 1, 'controls': 0, 'loop': 1, 
            'playlist': videoId, 'origin': window.location.origin
        },
        events: {
            'onReady': (e) => {
                const vol = document.getElementById('youtubeVolumeSlider')?.value || 50;
                e.target.setVolume(vol);
                e.target.playVideo();
                showNotification('🎵 Musik diputar', 'success');
            },
            'onError': (e) => {
                // PENANGANAN KHUSUS: Jika Error 150 atau 101, jangan paksa putar
                if (e.data === 150 || e.data === 101) {
                    showNotification(`
                        ❌ Video ini diblokir untuk diputar di situs lain.
                        <button onclick="window.open('https://youtube.com/watch?v=${videoId}', '_blank')" 
                        style="cursor:pointer; background:red; color:white; border:none; padding:5px; border-radius:3px;">
                        Tonton di YouTube
                        </button>`, 'error');
                } else {
                    showNotification('❌ Error: ' + e.data, 'error');
                }
            }
        }
    });
}



function stopYouTube() {
    // Tambahkan pengecekan apakah youtubePlayer benar-benar ada
    if (youtubePlayer && typeof youtubePlayer.stopVideo === 'function') {
        try {
            youtubePlayer.stopVideo();
            youtubePlayer.destroy();
        } catch(e) {
            console.error("Error saat menghentikan player:", e);
        }
    }
    
    // Pastikan UI dibersihkan meskipun terjadi error pada player
    youtubePlayer = null;
    document.getElementById('youtubePlayerContainer').innerHTML = '';
    showNotification('⏹️ YouTube dihentikan', 'info');
}

function setYouTubeVolume(v) {
    // Update tampilan teks volume
    const volDisplay = document.getElementById('youtubeVolumeValue');
    if (volDisplay) volDisplay.textContent = v + '%';
    
    // Pengecekan ketat sebelum memanggil fungsi API
    if (youtubePlayer && typeof youtubePlayer.setVolume === 'function') {
        try {
            youtubePlayer.setVolume(parseInt(v));
        } catch(e) {
            console.error("Gagal mengatur volume:", e);
        }
    } else {
        console.warn("Player belum siap atau belum dimuat.");
    }
}
    // ============================================
    // 🔥 MUTE LIVE CONTROL
    // ============================================
    function toggleMuteLive() {
    isLiveMuted = !isLiveMuted;
    const btn = document.getElementById('btnMuteLive');
    const muteText = document.getElementById('muteLiveText');
    const statusDot = document.getElementById('muteLiveStatusDot');
    const statusText = document.getElementById('muteLiveStatusText');
    if (isLiveMuted) {
    btn.style.background = 'linear-gradient(135deg, #10b981, #059669)';
    muteText.textContent = 'Unmute Suara Live';
    btn.innerHTML = '<i class="fas fa-volume-mute"></i> <span id="muteLiveText">Unmute Suara Live</span>';
    statusDot.className = 'voice-status-dot paused';
    statusText.textContent = 'Suara Live Dimatikan';
    showNotification('🔇 Suara Live dimatikan', 'info');
    } else {
    btn.style.background = 'linear-gradient(135deg, #ef4444, #dc2626)';
    btn.innerHTML = '<i class="fas fa-volume-up"></i> <span id="muteLiveText">Mute Suara Live</span>';
    statusDot.className = 'voice-status-dot active';
    statusText.textContent = 'Suara Live Aktif';
    showNotification('🔊 Suara Live diaktifkan', 'success');
    }
    }
    // ============================================
    // 🔥 NARASI DINAMIS - OTOMATIS BACA DATA
    // ============================================
    function generateDynamicNarration() {
    const narrations = [];
    narrations.push("Selamat datang di Sistem Monitoring PDAM Unit Pelaksana Darmaraja. Unit ini melayani kebutuhan air bersih untuk masyarakat Kecamatan Darmaraja, Kabupaten Sumedang, Jawa Barat.");
    const totalPelanggan = pelangganDataFromLaravel.length;
    let totalKantor = 0, totalPPOB = 0, totalBelumBayar = 0;
    const golCount = {};
    const wilayahData = {};
    pelangganDataFromLaravel.forEach(p => {
    const s = getPaymentStatus(p);
    if (s.status === 'Kantor') totalKantor++;
    else if (s.status === 'PPOB') totalPPOB++;
    else totalBelumBayar++;
    const gol = p.kode_gol_trf || 'Lainnya';
    golCount[gol] = (golCount[gol] || 0) + 1;
    const wilayah = p.nama_wilayah || 'Tidak Diketahui';
    if (!wilayahData[wilayah]) wilayahData[wilayah] = { count: 0, kantor: 0, ppob: 0, belumBayar: 0 };
    wilayahData[wilayah].count++;
    if (s.status === 'Kantor') wilayahData[wilayah].kantor++;
    else if (s.status === 'PPOB') wilayahData[wilayah].ppob++;
    else wilayahData[wilayah].belumBayar++;
    });
    narrations.push(`Saat ini kami melayani total ${totalPelanggan} pelanggan. Dengan rincian ${totalKantor} pelanggan membayar di kantor, ${totalPPOB} pelanggan membayar melalui P P O B, dan ${totalBelumBayar} pelanggan yang belum melakukan pembayaran.`);
    const golEntries = Object.entries(golCount).sort((a, b) => b[1] - a[1]);
    if (golEntries.length > 0) {
    let golText = `Pelanggan kami terbagi dalam ${golEntries.length} golongan tarif. `;
    golEntries.slice(0, 5).forEach(([gol, count], idx) => {
    if (idx > 0) golText += ', ';
    golText += `Golongan ${gol} sebanyak ${count} pelanggan`;
    });
    if (golEntries.length > 5) golText += `, dan golongan lainnya.`;
    golText += '.';
    narrations.push(golText);
    }
    const gangguanAktifCount = gangguanData.filter(g => g.status !== 'selesai').length;
    if (gangguanAktifCount > 0) {
    narrations.push(`Saat ini terdapat ${gangguanAktifCount} gangguan aktif yang sedang dalam penanganan tim teknis kami.`);
    } else {
    narrations.push(`Seluruh jaringan kami beroperasi dengan normal tanpa gangguan.`);
    }
    const stats = calculateMonthlyRevenue();
    const persentase = stats.percentage.toFixed(1);
    narrations.push(`Progres pendapatan bulan ini telah mencapai ${persentase} persen dari target, dengan total terkumpul ${formatRupiah(stats.totalCollected)} dari target ${formatRupiah(stats.totalTarget)}.`);
    return narrations;
    }
    // ============================================
    // 🔥 NARASI RINGKASAN TAGIHAN + SEBUT NAMA PELANGGAN
    // ============================================
            // ============================================
    // 🔥 NARASI RINGKASAN TAGIHAN (TANPA SEBUT NAMA)
    // ============================================
    function generateUnpaidNarration() {
        const narrations = [];
        const unpaidByWilayah = {};
        let totalSudahBayar = 0;
        let totalTagihanBelumBayar = 0;
        let countSudahBayar = 0;
        let countBelumBayar = 0;
        
        pelangganDataFromLaravel.forEach(p => {
            const s = getPaymentStatus(p);
            const jumlah = parseFloat(p.jumlah) || 0;
            const wilayah = p.nama_wilayah || 'Tidak Diketahui';
            
            if (s.status === 'Belum Bayar') {
       const coords = parseKoordinator(p.koordinator);
       if (coords && isInArea(coords[0], coords[1])) {
           if (!unpaidByWilayah[wilayah]) {
               unpaidByWilayah[wilayah] = { 
                   count: 0, 
                   total: 0,
                   coords: []
               };
           }
           unpaidByWilayah[wilayah].count++;
           unpaidByWilayah[wilayah].total += jumlah;
           unpaidByWilayah[wilayah].coords.push(coords);
           
           totalTagihanBelumBayar += jumlah;
           countBelumBayar++;
       }
            } else {
       totalSudahBayar += jumlah;
       countSudahBayar++;
            }
        });
        
        narrations.push(`Ringkasan tagihan pelanggan PDAM UP Darmaraja.`);
        narrations.push(`Total ${countSudahBayar} pelanggan sudah membayar dengan total penerimaan ${formatRupiah(totalSudahBayar)}.`);
        narrations.push(`Sisa ${countBelumBayar} pelanggan belum membayar dengan total tagihan ${formatRupiah(totalTagihanBelumBayar)}.`);
        
        if (Object.keys(unpaidByWilayah).length > 0) {
            narrations.push(`Berikut rincian tagihan belum bayar per wilayah:`);
            
            const sortedWilayah = Object.entries(unpaidByWilayah)
       .sort((a, b) => b[1].total - a[1].total);
            
            sortedWilayah.forEach(([wilayah, data]) => {
       let centerCoords = null;
       if (data.coords.length > 0) {
           const avgLat = data.coords.reduce((sum, c) => sum + c[0], 0) / data.coords.length;
           const avgLng = data.coords.reduce((sum, c) => sum + c[1], 0) / data.coords.length;
           centerCoords = [avgLat, avgLng];
       }
       
       narrations.push({
           text: `Wilayah ${wilayah}, terdapat ${data.count} pelanggan belum bayar, dengan total tagihan ${formatRupiah(data.total)}.`,
           coords: centerCoords
       });
            });
            
            narrations.push(`Demikian ringkasan pembayaran. Terima kasih.`);
        } else {
            narrations.push(`Seluruh pelanggan sudah melakukan pembayaran. Terima kasih.`);
        }
        
        return narrations;
    }
    
    function narrateUnitProfile() {
        if (isNarrating) {
            isNarrating = false;
            clearVoiceQueue();
            speechSynthesis.cancel();
            showNotification('Narasi dihentikan', 'info');
            return;
        }
        isNarrating = true;
        currentNarrationIndex = 0;
        narrationPaused = false;
        if (isLiveDashboardActive) stopLiveCycle();
        
        const profileNarrations = generateDynamicNarration();
        const unpaidNarrations = generateUnpaidNarration();
        const allNarrations = [...profileNarrations, ...unpaidNarrations];
        playDynamicNarrationWithMap(allNarrations);
    }
    
    function playDynamicNarrationWithMap(narrations) {
        if (!isNarrating || currentNarrationIndex >= narrations.length) {
            isNarrating = false;
            currentNarrationIndex = 0;
            showNotification('Narasi selesai', 'success');
            map.flyTo([-6.88, 107.97], 14, { duration: 1 });
            return;
        }
        if (narrationPaused) return;
        const narration = narrations[currentNarrationIndex];
        let text, coords = null;
        if (typeof narration === 'object' && narration.text) {
            text = narration.text;
            coords = narration.coords;
        } else {
            text = narration;
        }
        if (coords && map) {
            map.flyTo(coords, 17, { duration: 1.2 });
        }
        addToVoiceQueue(text, voiceSettings.paymentGender, () => {
            currentNarrationIndex++;
            setTimeout(() => {
       if (isNarrating && !narrationPaused) {
           playDynamicNarrationWithMap(narrations);
       }
            }, 800);
        });
    }
    // ============================================
    // 🔥 REAL-TIME PAYMENT POLLING
    // ============================================
    function startRealtimePolling() {
    console.log('🔄 Memulai real-time polling setiap', POLLING_INTERVAL/1000, 'detik');
    initializePaymentTimestamps();
    realtimePollingInterval = setInterval(checkNewPayments, POLLING_INTERVAL);
    setTimeout(checkNewPayments, 3000);
    }
    function initializePaymentTimestamps() {
    if (typeof pelangganDataFromLaravel !== 'undefined') {
    pelangganDataFromLaravel.forEach(p => {
    const s = getPaymentStatus(p);
    if (s.tanggal) {
    lastKnownPaymentTimestamps[p.no_pelanggan] = s.tanggal;
    }
    });
    }
    isFirstLoad = false;
    }
    async function checkNewPayments() {
    try {
    const response = await fetch(API_REALTIME_URL + '?t=' + Date.now(), {
    method: 'GET',
    headers: { 'Accept': 'application/json', 'Content-Type': 'application/json' }
    });
    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
    const result = await response.json();
    if (!result.success || !result.pelanggan) return;
    const pelangganData = result.pelanggan;
    const newPayments = [];
    pelangganData.forEach(p => {
    const pelangganMapped = {
    no_pelanggan: p.no_pelanggan || p.no_rekening || '-',
    nama: p.nama || 'Tanpa Nama',
    jumlah: p.jumlah || '0',
    pakai: p.pakai || '0',
    kode_gol_trf: p.kode_gol_trf || '-',
    nama_wilayah: p.nama_wilayah || p.cabang || 'Tidak Diketahui',
    koordinator: p.koordinator || '',
    tanggal_pembayaran_loket: p.tanggal_pembayaran_loket || null,
    tanggal_pembayaran_ppob: p.tanggal_pembayaran_ppob || null,
    status: p.status_sl || p.status || 'Aktif'
    };
    const s = getPaymentStatus(pelangganMapped);
    if (s.tanggal) {
    const lastTimestamp = lastKnownPaymentTimestamps[pelangganMapped.no_pelanggan];
    if (!lastTimestamp || lastTimestamp !== s.tanggal) {
    newPayments.push({
    ...pelangganMapped,
    statusInfo: s,
    isNewPayment: !lastTimestamp
    });
    lastKnownPaymentTimestamps[pelangganMapped.no_pelanggan] = s.tanggal;
    }
    }
    });
    if (pelangganData.length > 0 && typeof updatePelangganDataFromAPI === 'function') {
    updatePelangganDataFromAPI(pelangganData);
    }
    if (newPayments.length > 0 && !isFirstLoad) {
    const realNewPayments = newPayments.filter(p => p.isNewPayment);
    if (realNewPayments.length > 0) {
    realNewPayments.forEach((p, idx) => {
    setTimeout(() => {
    handlePaymentReceived(p);
    updateUIAfterPayment(p);
    }, idx * 3000);
    });
    }
    }
    } catch (error) {
    console.error('❌ Error polling:', error);
    }
    }
    function updatePelangganDataFromAPI(newData) {
    const mappedData = newData.map(p => ({
    no_pelanggan: p.no_pelanggan,
    nama: p.nama,
    jumlah: p.jumlah || '0',
    pakai: p.pakai || '0',
    kode_gol_trf: p.kode_gol_trf,
    nama_wilayah: p.nama_wilayah || p.cabang,
    koordinator: p.koordinator,
    tanggal_pembayaran_loket: p.tanggal_pembayaran_loket || null,
    tanggal_pembayaran_ppob: p.tanggal_pembayaran_ppob || null,
    status: p.status,
    alamat: p.alamat
    }));
    mappedData.forEach(newP => {
    const idx = pelangganDataFromLaravel.findIndex(p => p.no_pelanggan === newP.no_pelanggan);
    if (idx !== -1) {
    pelangganDataFromLaravel[idx] = newP;
    } else {
    pelangganDataFromLaravel.push(newP);
    }
    });
    updateRevenueProgress();
    updateTodayStatsDisplay();
    calculateRevenue();
    // 🔥 PENTING: Reload marker unpaid agar yang sudah bayar hilang
    loadUnpaidCustomerMarkers();
    // 🔥 Reload wilayah & blok
    loadWilayahDanBlok();
    }
    function updateUIAfterPayment(pelanggan) {
    const bar = document.getElementById('notificationBar');
    const content = document.getElementById('notificationContent');
    
    if (bar && content) {
        bar.style.display = 'block';
        
        let waktuDisplay = '';
        if (pelanggan.statusInfo && pelanggan.statusInfo.tanggal) {
            const tgl = new Date(pelanggan.statusInfo.tanggal);
            waktuDisplay = `<span class="time" style="color: #fcd34d; font-size: 8px;"><i class="fas fa-clock"></i> ${tgl.toLocaleTimeString('id-ID', {hour:'2-digit', minute:'2-digit'})} WIB</span>`;
        }
        
        const itemHTML = `
            <div class="notification-item new-payment">
                <strong>${pelanggan.nama}</strong>
                <span class="amount">${formatRupiah(pelanggan.jumlah)}</span>
                ${waktuDisplay}
                <span class="location"><i class="fas fa-${pelanggan.statusInfo.metode === 'PPOB' ? 'mobile-alt' : 'building'}"></i> ${pelanggan.statusInfo.metode}</span>
            </div>
        `;
        
        content.innerHTML = itemHTML + itemHTML;
        content.style.animation = 'none';
        content.offsetHeight;
        content.style.animation = `scroll-left ${getComputedStyle(document.documentElement).getPropertyValue('--scroll-duration')} linear infinite`;
        
        if (typeof updateTodayStatsDisplay === 'function') updateTodayStatsDisplay();
        if (typeof calculateRevenue === 'function') calculateRevenue();
    }
}
    function stopRealtimePolling() {
    if (realtimePollingInterval) {
    clearInterval(realtimePollingInterval);
    realtimePollingInterval = null;
    }
    }
    // ============================================
    // 🔥 FUNGSI TERIMA KASIH SAAT PEMBAYARAN
    // ============================================
    // ============================================
// 🔥 FUNGSI TERIMA KASIH SAAT PEMBAYARAN
// (TANPA NOMINAL & TANPA JAM)
// ============================================
function handlePaymentReceived(pelanggan) {
    console.log('💰 Payment received:', pelanggan);
    
    // 🔥 TETAP TAMPILKAN NOTIFIKASI
    showNotification(`💰 Pembayaran dari ${pelanggan.nama} - Terima kasih!`, 'payment');
    
    // 🔥 JIKA LIVE MUTED, TETAP MAINKAN SUARA
    // HAPUS: if (isLiveMuted) { return; }
    
    // 🔥 CEK SPEECH SYNTHESIS
    if (typeof speechSynthesis === 'undefined') {
        console.log('⚠️ Browser tidak support speechSynthesis');
        return;
    }
    
    // 🔥 CANCEL SUARA SEBELUMNYA
    try {
        speechSynthesis.cancel();
    } catch (e) {
        console.log('⚠️ Cancel error:', e);
    }
    
    // 🔥 FORMAT PESAN
    const namaNormal = formatNameForSpeech ? formatNameForSpeech(pelanggan.nama, 'female') : pelanggan.nama;
    
    const thankYouMessages = [
        "Terima kasih atas pembayaran Anda. Kepercayaan Anda adalah motivasi kami untuk terus memberikan pelayanan terbaik.",
        "Pembayaran Anda telah kami terima. Terima kasih telah menjadi pelanggan setia PDAM Unit Pelaksana Darmaraja.",
        "Terima kasih. Kontribusi Anda sangat berarti bagi kelangsungan pelayanan air bersih di wilayah Darmaraja."
    ];
    const thankYouMsg = thankYouMessages[Math.floor(Math.random() * thankYouMessages.length)];
    
    const metodeText = pelanggan.statusInfo && pelanggan.statusInfo.metode === 'PPOB' ? 'P. P. O. B.' : 'Kantor Unit Cabang';
    
    // 🔥 SUSUN PESAN (TANPA NOMINAL & TANPA JAM - SESUAI REQUEST)
    const fullMessage = `${thankYouMsg} Atas nama ${namaNormal}, pembayaran telah kami terima melalui ${metodeText}.`;
    
    console.log('🔊 Playing message:', fullMessage);
    
    // 🔥 PUTAR SUARA
    if (typeof speak === 'function') {
        speak(fullMessage, 'female');
    } else {
        console.error('❌ Fungsi speak() tidak ditemukan!');
    }
}
   //  const fullMessage = `${thankYouMsg} Atas nama ${namaNormal}, pembayaran sebesar ${formatRupiah(pelanggan.jumlah)} telah kami terima melalui ${metodeText}${waktuText}.`;
   //  if (typeof speak === 'function') speak(fullMessage, 'female');
   //  showNotification(`💰 Pembayaran dari ${pelanggan.nama} - Terima kasih!`, 'payment');
   //  }
    // ============================================
    // 🔥 FUNGSI HITUNG PENDAPATAN BULANAN
    // ============================================
    function calculateMonthlyRevenue() {
    const now = new Date();
    const currentYear = now.getFullYear();
    const currentMonth = now.getMonth();
    const currentDay = now.getDate();
    const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
    const remainingDays = daysInMonth - currentDay;
    let totalTarget = 0, totalCollected = 0, totalUnpaidWithPenalty = 0;
    pelangganDataFromLaravel.forEach(p => {
    const jumlah = parseFloat(p.jumlah) || 0;
    const hasLoket = p.tanggal_pembayaran_loket && p.tanggal_pembayaran_loket !== '-' && p.tanggal_pembayaran_loket !== '.' && p.tanggal_pembayaran_loket !== null;
    const hasPPOB = p.tanggal_pembayaran_ppob && p.tanggal_pembayaran_ppob !== '-' && p.tanggal_pembayaran_ppob !== '.' && p.tanggal_pembayaran_ppob !== null;
    if (hasLoket || hasPPOB) {
    totalCollected += jumlah;
    } else {
    let tagihanFinal = jumlah;
    if (currentDay > 20) tagihanFinal += 5000;
    if (jumlah > 1000000) tagihanFinal += 10000;
    totalUnpaidWithPenalty += tagihanFinal;
    }
    totalTarget += jumlah;
    });
    const percentage = totalTarget > 0 ? (totalCollected / totalTarget) * 100 : 0;
    const dailyTarget = remainingDays > 0 ? totalUnpaidWithPenalty / remainingDays : 0;
    return { totalTarget, totalCollected, totalUnpaidWithPenalty, percentage, currentDay, daysInMonth, remainingDays, dailyTarget };
    }
    function updateRevenueProgress() {
    const stats = calculateMonthlyRevenue();
    const progressBar = document.getElementById('revenueProgressBar');
    const progressPercentage = document.getElementById('revenueProgressPercentage');
    progressBar.style.width = stats.percentage.toFixed(1) + '%';
    progressPercentage.textContent = stats.percentage.toFixed(1) + '%';
    document.getElementById('currentDayOfMonth').textContent = stats.currentDay;
    document.getElementById('remainingDays').textContent = stats.remainingDays;
    document.getElementById('targetRevenue').textContent = formatRupiah(stats.totalTarget);
    document.getElementById('collectedRevenue').textContent = formatRupiah(stats.totalCollected);
    document.getElementById('remainingRevenue').textContent = formatRupiah(stats.totalUnpaidWithPenalty);
    document.getElementById('dailyTarget').textContent = formatRupiah(stats.dailyTarget);
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
    function formatDate(s) {
    if (!s || s === '-' || s === '.') return '-';
    return new Date(s).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
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
    const icons = { 'success': 'fa-check-circle', 'info': 'fa-info-circle', 'warning': 'fa-exclamation-triangle', 'live': 'fa-broadcast-tower', 'payment': 'fa-money-bill-wave' };
    toast.innerHTML = `<i class="fas ${icons[type] || 'fa-info-circle'}"></i><span>${msg}</span>`;
    document.body.appendChild(toast);
    setTimeout(() => { toast.style.animation = 'toastSlide 0.3s ease reverse'; setTimeout(() => toast.remove(), 300); }, 3000);
    }
    function calculateTodayStats() {
    const now = new Date();
    const todayStr = now.toISOString().split('T')[0];
    let totalToday = 0, countToday = 0, kubikasiToday = 0;
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
    // 🔥 UPDATE TANGGAL + JAM LENGKAP (REAL-TIME)
    function updateTodayStatsDisplay() {
    const stats = calculateTodayStats();
    const now = new Date();
    
    // 🔥 VALIDASI: Cek apakah now valid
    if (isNaN(now.getTime())) {
        console.error('❌ Date object invalid!');
        return;
    }
    
    const dateStr = now.toLocaleDateString('id-ID', {
        weekday: 'long',
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    });
    
    const timeStr = now.toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: false  // 🔥 PENTING: Gunakan 24 jam
    });
    
    document.getElementById('today-date').innerHTML = `
        <div style="font-size: 9px; opacity: 0.85;">Pembayaran Hari Ini</div>
        <div style="font-size: 11px; font-weight: 700;">${dateStr}</div>
        <div style="font-size: 10px; opacity: 0.9;"><i class="fas fa-clock"></i> ${timeStr} WIB</div>
    `;
    
    document.getElementById('today-amount').textContent = formatRupiah(stats.totalToday);
    document.getElementById('today-count').textContent = stats.countToday;
    document.getElementById('today-kubikasi').textContent = stats.kubikasiToday.toFixed(1);
}
    // 🔥 UPDATE JAM SETIAP DETIK
    setInterval(() => {
    if (typeof updateTodayStatsDisplay === 'function') {
        updateTodayStatsDisplay();
    }
    }, 1000);
    function getPaymentStatus(p) {
    const hasLoket = p.tanggal_pembayaran_loket && p.tanggal_pembayaran_loket !== '-' && p.tanggal_pembayaran_loket !== '.' && p.tanggal_pembayaran_loket !== null;
    const hasPPOB = p.tanggal_pembayaran_ppob && p.tanggal_pembayaran_ppob !== '-' && p.tanggal_pembayaran_ppob !== '.' && p.tanggal_pembayaran_ppob !== null;
    if (hasLoket) return { status: 'Kantor', color: '#10b981', icon: 'fa-building', tanggal: p.tanggal_pembayaran_loket, metode: 'Kantor' };
    else if (hasPPOB) return { status: 'PPOB', color: '#f59e0b', icon: 'fa-mobile-alt', tanggal: p.tanggal_pembayaran_ppob, metode: 'PPOB' };
    else return { status: 'Belum Bayar', color: '#ef4444', icon: 'fa-times', tanggal: null, metode: null };
    }
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
    function formatNameForSpeech(name, gender) {
    if (!name) return 'Pelanggan';
    let cleanName = name.trim().replace(/\s+/g, ' ');
    cleanName = toTitleCase(cleanName.toLowerCase());
    return cleanName;
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
    // VOICE SYSTEM
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
    if (indonesianVoices.length === 0) indonesianVoices = [...availableVoices];
    if (indonesianFemaleVoices.length === 0) indonesianFemaleVoices = [...indonesianVoices];
    if (indonesianMaleVoices.length === 0) indonesianMaleVoices = [...indonesianVoices];
    }
    function speak(text, gender = 'female', callback) {
    // 🔥 CEK KONDISI DASAR
    if (!voiceSettings.enabled || !('speechSynthesis' in window)) {
        console.log('⚠️ Voice disabled atau browser tidak support');
        if (callback) callback();
        return;
    }
    
    // ❌ HAPUS: if (isLiveMuted) { ... return; }
    // ✅ isLiveMuted TIDAK BOLEH MUTE SUARA PEMBAYARAN!
    
    // 🔥 CANCEL DENGAN DELAY (Chrome bug fix)
    try {
        speechSynthesis.cancel();
    } catch (e) {
        console.log('⚠️ Cancel error:', e);
    }
    
    // 🔥 SIMPAN STATE MUSIK
    const audioEl = document.getElementById('backgroundMusic');
    const wasPlaying = isMusicPlaying && !isMusicPaused;
    const originalVolume = audioEl ? audioEl.volume : 0.3;
    if (wasPlaying && audioEl) {
        audioEl.volume = Math.max(0.05, originalVolume * 0.3);
    }
    
    // 🔥 TUNGGU VOICES LOAD
    const trySpeak = (retry = 0) => {
        if (availableVoices.length === 0 && retry < 10) {
            console.log(`⏳ Voices belum load, retry ${retry + 1}/10...`);
            setTimeout(() => trySpeak(retry + 1), 200);
            return;
        }
        
        setTimeout(() => {
            try {
                const u = new SpeechSynthesisUtterance(text);
                u.lang = 'id-ID';
                
                const idx = gender === 'female' ? voiceSettings.paymentVoiceIndex : voiceSettings.gangguanVoiceIndex;
                const voicePool = gender === 'female' ? indonesianFemaleVoices : indonesianMaleVoices;
                
                // 🔥 PILIH VOICE
                if (voicePool.length > 0) {
                    u.voice = voicePool[idx % voicePool.length] || voicePool[0];
                } else if (indonesianVoices.length > 0) {
                    u.voice = indonesianVoices[0];
                } else if (availableVoices.length > 0) {
                    const idVoice = availableVoices.find(v => 
                        (v.lang || '').toLowerCase().includes('id') || 
                        (v.name || '').toLowerCase().includes('indonesia')
                    );
                    if (idVoice) u.voice = idVoice;
                }
                
                const p = voiceProfiles[idx] || voiceProfiles[0] || { pitch: 1, rate: 1 };
                u.pitch = p.pitch;
                u.rate = p.rate;
                u.volume = voiceSettings.volume;
                
                if (u.voice && u.voice.lang && !u.voice.lang.startsWith('id')) {
                    u.lang = 'id-ID';
                }
                
                u.onend = () => {
                    console.log('✅ Speech selesai');
                    if (wasPlaying && audioEl) audioEl.volume = originalVolume;
                    if (callback) callback();
                };
                
                u.onerror = (e) => {
                    console.error('❌ Speech error:', e);
                    if (wasPlaying && audioEl) audioEl.volume = originalVolume;
                    if (callback) callback();
                };
                
                // 🔥 SPEAK
                setTimeout(() => {
                    try {
                        speechSynthesis.speak(u);
                        console.log('🔊 Speech dimulai');
                        
                        // 🔥 WORKAROUND: Chrome bug
                        setTimeout(() => {
                            if (!speechSynthesis.speaking) {
                                console.log('⚠️ Retry speak...');
                                speechSynthesis.speak(u);
                            }
                        }, 100);
                        
                    } catch (error) {
                        console.error('❌ Error saat speak:', error);
                        if (callback) callback();
                    }
                }, 50);
                
            } catch (error) {
                console.error('❌ Error creating utterance:', error);
                if (wasPlaying && audioEl) audioEl.volume = originalVolume;
                if (callback) callback();
            }
        }, 50);
    };
    
    trySpeak();
}
    function updateGangguanGender() { voiceSettings.gangguanGender = document.getElementById('gangguanGenderSelect').value; }
    function updatePaymentGender() { voiceSettings.paymentGender = document.getElementById('paymentGenderSelect').value; }
    function updateVoiceIndex() {
    voiceSettings.gangguanVoiceIndex = parseInt(document.getElementById('gangguanVoiceSelect').value);
    voiceSettings.paymentVoiceIndex = parseInt(document.getElementById('paymentVoiceSelect').value);
    }
    function testVoice() {
    const gender = voiceSettings.paymentGender;
    const text = gender === 'female' ? 'Halo, ini adalah suara perempuan untuk notifikasi pembayaran PDAM UP Darmaraja.' : 'Halo, ini adalah suara laki-laki untuk notifikasi gangguan PDAM UP Darmaraja';
    speak(text, gender);
    }
    if ('speechSynthesis' in window) { loadVoices(); setTimeout(loadVoices, 500); setTimeout(loadVoices, 1500); }
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
    const volume = parseInt(document.getElementById('musicVolumeSlider').value) / 100;
    audioEl.volume = volume;
    audioEl.loop = false;
    audioEl.onended = () => { if (autoRotateMusic) playNextTrack(); };
    const playPromise = audioEl.play();
    if (playPromise !== undefined) {
    playPromise.then(() => {
    isMusicPlaying = true; isMusicPaused = false;
    document.getElementById('btnPlayMusic').disabled = true;
    document.getElementById('btnPauseMusic').disabled = false;
    document.getElementById('btnStopMusic').disabled = false;
    }).catch(err => {
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
    audioEl.oncanplaythrough = () => { audioEl.play(); };
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
    if (v < 40) label = 'Sangat Lambat';
    else if (v < 70) label = 'Lambat';
    else if (v < 90) label = 'Normal';
    else if (v < 130) label = 'Cepat';
    else label = 'Sangat Cepat';
    document.getElementById('scrollSpeedValue').textContent = label;
    }
    function toggleVoicePanel() { document.getElementById('voicePanel').classList.toggle('active'); }
    function setVoiceVolume(v) { voiceSettings.volume = v / 100; document.getElementById('volumeValue').textContent = v + '%'; }
    // ============================================
    // GANGGUAN VOICE
    // ============================================
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
    // PAYMENT VOICE
    // ============================================
    function formatPaymentVoiceText(p) {
    let lokasiText = p.lokasi || 'lokasi tidak diketahui';
    lokasiText = convertRegionRomanToNumber(lokasiText);
    let namaText = formatNameForSpeech(p.nama, voiceSettings.paymentGender);
    const metodeText = p.metode === 'PPOB' ? 'P. P. O. B.' : 'Kantor Unit Cabang';
    let waktuText = '';
    if (p.tanggal) {
    const tgl = new Date(p.tanggal);
    const jam = tgl.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
    waktuText = ` pada pukul ${jam.replace(':', '.')} WIB`;
    }
    return `Terima kasih kepada Yang Terhormat, ${namaText}, yang berlokasi di ${lokasiText}, telah melakukan pembayaran di ${metodeText}${waktuText}. Dan apabila ada keluhan, silahkan hubungi Kantor Unit atau call center kami`;
    }
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
    // LIVE DASHBOARD
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
            icon: L.divIcon({ 
       className: 'custom-div-icon', 
       html: html, 
        iconSize: [14, 14],       // ← UBAH: Pas dengan ukuran pin (14x14)
       iconAnchor: [7, 7],       // ← UBAH: Titik tengah
       popupAnchor: [0, -10]     // Popup di atas
            }),
            zIndexOffset: 300            // ← UBAH dari 1000
        });
    
    
    }
    // 🔥 LOAD MARKER UNPAID - HANYA YANG STATUS BELUM BAYAR
    function loadUnpaidCustomerMarkers() {
    // 🔥 HAPUS SEMUA MARKER LAMA
    unpaidCustomerMarkers.forEach(m => map.removeLayer(m));
    unpaidCustomerMarkers = [];
    unpaidCustomerList = [];
    pelangganDataFromLaravel.forEach(p => {
    const status = getPaymentStatus(p);
    // 🔥 HANYA TAMBAHKAN YANG BELUM BAYAR
    if (status.status === 'Belum Bayar') {
    const coords = parseKoordinator(p.koordinator);
    if (!coords || !isInArea(coords[0], coords[1])) return;
    const marker = createUnpaidMarker(p, coords);
    let wilayah = p.nama_wilayah || 'Tidak Diketahui';
    wilayah = convertRegionRomanToNumber(wilayah);
    marker.bindPopup(`
    <div style="min-width: 220px; font-family: 'Inter', sans-serif;">
    <div style="background: linear-gradient(135deg, #ef4444, #dc2626); color: white; padding: 8px; border-radius: 6px 6px 0 0; font-weight: 700; font-size: 12px;">
    <i class="fas fa-exclamation-triangle"></i> BELUM BAYAR
    </div>
    <div style="padding: 10px;">
    <div style="font-size: 14px; font-weight: 700; color: #1e293b; margin-bottom: 6px;">${p.nama || 'Tanpa Nama'}</div>
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px; font-size: 11px;">
    <div><strong>No:</strong> ${p.no_pelanggan}</div>
    <div><strong>Gol:</strong> ${p.kode_gol_trf || '-'}</div>
    <div style="grid-column: span 2;"><strong>Wilayah:</strong> ${wilayah}</div>
    </div>
    <div style="margin-top: 8px; padding: 8px; background: #fef2f2; border-radius: 6px; border: 2px solid #fecaca;">
    <div style="font-size: 9px; color: #991b1b; font-weight: 600;">TAGIHAN</div>
    <div style="font-size: 16px; font-weight: 800; color: #dc2626;">${formatRupiah(p.jumlah)}</div>
    <div style="font-size: 10px; color: #7f1d1d;">${parseFloat(p.pakai) || 0} m³</div>
    </div>
    </div>
    </div>
    `, { maxWidth: 250 });
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
    // 🔥 JIKA LIST KOSONG DAN LIVE AKTIF, STOP LIVE
    if (unpaidCustomerList.length === 0 && isLiveDashboardActive) {
    showNotification('✅ Semua pelanggan sudah bayar, LIVE MODE otomatis berhenti', 'success');
    stopLiveCycle();
    }
    }
    function syncNotificationBarWithMarker(customer) {
    const content = document.getElementById('notificationContent');
    if (!content) return;
    content.querySelectorAll('.notification-item').forEach(item => item.classList.remove('active-sync'));
    const items = content.querySelectorAll('.notification-item');
    items.forEach(item => {
    const nama = item.querySelector('strong')?.textContent?.trim();
    if (nama === customer.nama) item.classList.add('active-sync');
    });
    }
    function highlightUnpaidMarker(index) {
    if (highlightedMarkerElement) highlightedMarkerElement.classList.remove('highlighted');
    if (index < 0 || index >= unpaidCustomerList.length) return;
    const customer = unpaidCustomerList[index];
    const marker = customer.marker;
    if (voiceSettings.enabled && !isLiveMuted) {
    const namaNormal = formatNameForSpeech(customer.nama, voiceSettings.paymentGender);
    const kalimatPembuka = `Pelanggan atas nama ${namaNormal}, di ${customer.wilayah}.`;
    const kalimatDetail = `Belum membayar tagihan sebesar ${formatRupiah(customer.jumlah)}`;
    speak(kalimatPembuka, voiceSettings.paymentGender, function() {
    map.flyTo(customer.coords, 18, { duration: 1.5 });
    speak(kalimatDetail, voiceSettings.paymentGender, function() {
    if (isLiveDashboardActive) {
    if (liveCycleInterval) clearTimeout(liveCycleInterval);
    liveCycleInterval = setTimeout(() => {
    liveCycleIndex = (liveCycleIndex + 1) % unpaidCustomerList.length;
    highlightUnpaidMarker(liveCycleIndex);
    }, 3000);
    }
    });
    setTimeout(() => { marker.openPopup(); }, 1500);
    });
    } else {
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
    updateLiveInfoPanel(customer, index);
    syncNotificationBarWithMarker(customer);
    }
    function startLiveCycle() {
    if (unpaidCustomerList.length === 0) {
    showNotification('Tidak ada pelanggan belum bayar', 'warning');
    return;
    }
    if (liveCycleInterval) clearTimeout(liveCycleInterval);
    isLiveDashboardActive = true;
    liveCycleIndex = 0;
    highlightUnpaidMarker(liveCycleIndex);
    document.getElementById('btnLiveStart').disabled = true;
    document.getElementById('btnLiveStop').disabled = false;
    document.getElementById('liveBtn').classList.add('active');
    document.getElementById('liveText').textContent = 'LIVE ON';
    showNotification(`🔴 LIVE MODE: ${unpaidCustomerList.length} pelanggan belum bayar`, 'live');
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
    if (content) content.querySelectorAll('.notification-item').forEach(item => item.classList.remove('active-sync'));
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
    // DATA PROCESSING
    // ============================================
    function updateNotificationBar(payments) {
    const bar = document.getElementById('notificationBar');
    const content = document.getElementById('notificationContent');
    if (payments.length === 0) { bar.style.display = 'none'; return; }
    bar.style.display = 'block';
    last5Payments = payments.slice(0, 1);
    let html = '';
    payments.forEach((p) => {
    let waktuDisplay = '';
    if (p.tanggal) {
    const tgl = new Date(p.tanggal);
    waktuDisplay = `<span class="time" style="color: #fcd34d; font-size: 8px;"><i class="fas fa-clock"></i> ${tgl.toLocaleTimeString('id-ID', {hour:'2-digit', minute:'2-digit'})}</span>`;
    }
    html += `<div class="notification-item" data-nama="${p.nama}"><strong>${p.nama}</strong> <span class="amount">${formatRupiah(p.jumlah)}</span> <span style="color: #86efac;">(${p.kubikasi} m³)</span> ${waktuDisplay} <span class="location"><i class="fas fa-${p.lokasi === 'Kantor' ? 'building' : 'mobile-alt'}"></i> ${p.lokasi}</span></div>`;
    });
    content.innerHTML = html + html;
    updatePaymentVoiceButtons();
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
    updateNotificationBar(recent.slice(0, 1));
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
    // MAP INITIALIZATION
    // ============================================
    function initMap() {
    const bounds = L.latLngBounds(L.latLng(-6.98, 107.80), L.latLng(-6.80, 108.15));
    map = L.map('map', { center: [-6.918,108.074], zoom: 16, minZoom: 11, maxZoom: 18, maxBounds: bounds, maxBoundsViscosity: 0.8, zoomControl: false });
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
            //  loadJalurPipa(); loadBangunan(); loadGangguan(); loadTitikPenting(); loadPelanggan();
    loadJalurPipa(); loadBangunan(); loadGangguan(); loadTitikPenting(); loadPelanggan(); loadZona(); // 🔥 TAMBAH loadZona()
    calculateRevenue();
    loadUnpaidCustomerMarkers();
    loadWilayahDanBlok();
    updateTodayStatsDisplay();
    updateRevenueProgress();
    if (gangguanData && gangguanData.length > 0) {
    activeGangguanList = gangguanData.filter(g => g.status !== 'selesai');
    if (activeGangguanList.length > 0) {
    updateGangguanVoiceButtons();
    updateGangguanVoiceStatus('idle', `${activeGangguanList.length} gangguan siap diputar`);
    }
    }
    initSidebarAutoScroll();
    setScrollSpeed(60);
    document.getElementById('searchResults').innerHTML = '<div class="search-empty">Ketik untuk mencari pelanggan</div>';
    startRealtimePolling();
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
    m.bindPopup(`<div style="min-width:300px;"><div style="background:linear-gradient(135deg, ${cfg.c}, ${cfg.c}dd);color:white;padding:12px;text-align:center;"><div style="font-size:11px;opacity:0.9;margin-bottom:3px;"><i class="fas fa-info-circle"></i> INFORMASI PELAYANAN</div><div style="font-weight:700;font-size:13px;">${g.status === 'selesai' ? 'Gangguan Telah Selesai' : 'Mohon Maaf Pelayanan Terganggu'}</div></div><div style="padding:15px;"><h6 style="margin:0 0 12px 0; color:#1e293b; font-size:15px;">${g.kode_laporan}</h6><div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:12px;"><div style="background:${cfg.bg};padding:10px;border-radius:8px;text-align:center;"><div style="font-size:10px;color:#64748b;">STATUS</div><div style="font-weight:700;color:${cfg.c};font-size:12px;"><i class="fas fa-circle" style="font-size:8px;"></i> ${cfg.t}</div></div><div style="background:#f1f5f9;padding:10px;border-radius:8px;text-align:center;"><div style="font-size:10px;color:#64748b;">TIPE</div><div style="font-weight:700;color:#1e293b;font-size:12px;">${g.tipe_kerusakan ? g.tipe_kerusakan.toUpperCase() : '-'}</div></div></div><div style="margin-bottom:10px;"><div style="font-size:11px;color:#64748b;margin-bottom:3px;"><i class="fas fa-map-marker-alt"></i> Lokasi</div><div style="font-weight:600;color:#1e293b;">${g.lokasi || '-'}</div></div><div style="margin-bottom:10px;"><div style="font-size:11px;color:#64748b;margin-bottom:3px;"><i class="fas fa-users"></i> Wilayah Terdampak</div><div style="font-weight:600;color:#1e293b;">${g.wilayah_terdampak || '-'}</div></div>${g.deskripsi ? `<div style="background:#fef3c7;padding:10px;border-radius:8px;border-left:3px solid #f59e0b;margin-bottom:12px;"><div style="font-size:10px;color:#92400e;font-weight:600;"><i class="fas fa-info-circle"></i> DESKRIPSI</div><div style="font-size:12px;color:#78350f;margin-top:3px;">${g.deskripsi}</div></div>` : ''}<div style="background:linear-gradient(135deg,#ecfdf5,#d1fae5);padding:12px;border-radius:8px;text-align:center;"><div style="font-size:11px;color:#065f46;margin-bottom:4px;"><i class="fas fa-calendar-check"></i> Estimasi Penyelesaian</div><div style="font-weight:700;color:#064e3b;font-size:14px;">${g.estimasi_selesai ? new Date(g.estimasi_selesai).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) : '-'}</div></div></div></div>`, { maxWidth: 350 });
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
    // ============================================
    // 🔥 LOAD ZONA WILAYAH
    // ============================================
    function loadZona() {
        if (!zonaData || zonaData.length === 0) {
            console.log('ℹ️ Tidak ada data zona');
            return;
        }
        
        zonaData.forEach(z => {
            try {
       const coords = parseCoordinates(z.coordinates);
       if (!coords || coords.length === 0 || !hasPointInArea(coords)) return;
       
       // 🔥 BUAT POLYGON ZONA
       const polygon = L.polygon(coords, {
           color: z.warna || '#f59e0b',
           fillColor: z.warna || '#f59e0b',
           fillOpacity: 0.2,
           weight: 3,
           dashArray: '8, 5'
       }).addTo(map);
       
       const center = polygon.getBounds().getCenter();
       
       // 🔥 LABEL ZONA DI TENGAH
       const elevasiText = (z.elevasi_min && z.elevasi_max) ? 
           `<br><small style="opacity:0.9;font-size:9px;">${z.elevasi_min}-${z.elevasi_max} mdpl</small>` : '';
       
       const label = L.marker(center, {
           icon: L.divIcon({
               className: 'custom-div-icon',
               html: `
                   <div style="
                       background: rgba(255, 255, 255, 0.95);
                       border: 2px solid ${z.warna || '#f59e0b'};
                       border-radius: 8px;
                       padding: 6px 12px;
                       font-weight: 700;
                       font-size: 11px;
                       color: ${z.warna || '#f59e0b'};
                       box-shadow: 0 2px 8px rgba(0,0,0,0.2);
                       white-space: nowrap;
                       text-align: center;
                   ">
                       <i class="fas fa-map-marked-alt"></i> ${z.nama_zona}
                       ${elevasiText}
                   </div>
               `,
               iconSize: [200, 40],
               iconAnchor: [100, 20]
           }),
           interactive: false
       }).addTo(map);
       
       // 🔥 POPUP INFORMASI ZONA
       polygon.bindPopup(`
           <div style="min-width: 260px; font-family: 'Inter', sans-serif;">
               <div style="background: linear-gradient(135deg, ${z.warna || '#f59e0b'}, ${z.warna || '#f59e0b'}dd); color: white; padding: 12px; border-radius: 8px 8px 0 0; text-align: center;">
                   <div style="font-size: 10px; opacity: 0.9; margin-bottom: 3px;">
                       <i class="fas fa-map-marked-alt"></i> ${z.jenis_zona}
                   </div>
                   <div style="font-weight: 700; font-size: 14px;">
                       ${z.nama_zona}
                   </div>
               </div>
               <div style="padding: 12px; font-size: 12px;">
                   ${(z.elevasi_min || z.elevasi_max) ? `
                   <div style="margin-bottom: 10px; padding: 8px; background: linear-gradient(135deg, #fef3c7, #fde68a); border-radius: 6px; border-left: 3px solid #f59e0b;">
                       <div style="font-size: 9px; color: #92400e; font-weight: 700; margin-bottom: 3px;">
                           <i class="fas fa-mountain"></i> ELEVASI WILAYAH
                       </div>
                       <div style="display: flex; justify-content: space-between; align-items: center;">
                           <div style="text-align: center;">
                               <div style="font-size: 14px; font-weight: 800; color: #10b981;">
                                   <i class="fas fa-arrow-down" style="font-size: 10px;"></i> ${z.elevasi_min || '?'}
                               </div>
                               <div style="font-size: 8px; color: #64748b;">Min (mdpl)</div>
                           </div>
                           <div style="font-size: 18px; color: #f59e0b;">→</div>
                           <div style="text-align: center;">
                               <div style="font-size: 14px; font-weight: 800; color: #ef4444;">
                                   <i class="fas fa-arrow-up" style="font-size: 10px;"></i> ${z.elevasi_max || '?'}
                               </div>
                               <div style="font-size: 8px; color: #64748b;">Max (mdpl)</div>
                           </div>
                       </div>
                   </div>
                   ` : ''}
                   <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px; margin-bottom: 10px;">
                       <div style="background: #f1f5f9; padding: 8px; border-radius: 6px; text-align: center;">
                           <div style="font-size: 9px; color: #64748b; font-weight: 600;">
                               <i class="fas fa-tag"></i> JENIS
                           </div>
                           <div style="font-weight: 700; color: ${z.warna}; font-size: 11px;">
                               ${z.jenis_zona}
                           </div>
                       </div>
                       <div style="background: #f1f5f9; padding: 8px; border-radius: 6px; text-align: center;">
                           <div style="font-size: 9px; color: #64748b; font-weight: 600;">
                               <i class="fas fa-vector-square"></i> TITIK
                           </div>
                           <div style="font-weight: 700; color: #1e293b; font-size: 11px;">
                               ${coords.length} titik
                           </div>
                       </div>
                   </div>
                   ${z.keterangan ? `
                   <div style="background: #f8fafc; padding: 8px; border-radius: 6px; border: 1px solid #e2e8f0;">
                       <div style="font-size: 9px; color: #64748b; font-weight: 600; margin-bottom: 3px;">
                           <i class="fas fa-info-circle"></i> KETERANGAN
                       </div>
                       <div style="font-size: 11px; color: #475569;">
                           ${z.keterangan}
                       </div>
                   </div>
                   ` : ''}
               </div>
           </div>
       `, { maxWidth: 320 });
       
       // 🔥 SIMPAN REFERENCE
       zonaLayers[z.id] = { polygon, label };
       
            } catch (error) {
       console.error('❌ Error loading zona', z.id, error);
            }
        });
        
        console.log(`✅ Loaded ${zonaData.length} zona`);
    }
    function loadPelanggan() {
    if (!pelangganDataFromLaravel || pelangganDataFromLaravel.length === 0) return;
    pelangganClusterGroup = L.markerClusterGroup({
    maxClusterRadius: 50, spiderfyOnMaxZoom: true, showCoverageOnHover: false, zoomToBoundsOnClick: true,
    iconCreateFunction: function(cluster) {
    const count = cluster.getChildCount();
    let color = '#3b82f6', size = '24px';
    if (count > 50) { color = '#ef4444'; size = '30px'; } else if (count > 20) { color = '#f59e0b'; size = '27px'; }
    return L.divIcon({ html: `<div style="background:${color};color:white;width:${size};height:${size};border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:11px;border:3px solid white;box-shadow:0 2px 8px rgba(0,0,0,0.3);">${count}</div>`, className: 'marker-cluster-custom', iconSize: L.point(parseInt(size), parseInt(size)) });
    }
    });
    pelangganDataFromLaravel.forEach(p => {
    const s = getPaymentStatus(p);
    const gol = p.kode_gol_trf || 'Lainnya';
    const w = p.nama_wilayah || 'Tidak Diketahui';
    if (s.status === 'Belum Bayar') return;
    const coords = parseKoordinator(p.koordinator);
    if (!coords || !isInArea(coords[0], coords[1])) return;
    const m = L.marker(coords, { icon: L.divIcon({ className: 'custom-div-icon', html: `<div class="pelanggan-marker-small" style="background: ${s.color};"><i class="fas ${s.icon}" style="color: white; font-size: 5px;"></i></div>`, iconSize: [10, 10], iconAnchor: [5, 5] }), zIndexOffset: 500 });
    m.bindPopup(`<div style="min-width:220px; font-family: 'Inter', sans-serif; font-size: 11px;"><div style="background: ${s.color}; color: white; padding: 6px; border-radius: 6px 6px 0 0; font-weight: 700;"><i class="fas ${s.icon}"></i> ${p.nama || 'Tanpa Nama'}</div><div style="padding: 8px;"><div style="margin-bottom: 4px;"><strong>No:</strong> ${p.no_pelanggan}</div><div style="margin-bottom: 4px;"><strong>Golongan:</strong> ${gol}</div><div style="margin-bottom: 4px;"><strong>Wilayah:</strong> ${w}</div><div style="margin-bottom: 4px;"><strong>Status:</strong> <span style="color: ${s.color}; font-weight: 700;"><i class="fas ${s.icon}"></i> ${s.status}</span></div><div style="margin-bottom: 4px;"><strong>Pemakaian:</strong> ${parseFloat(p.pakai) || 0} m³</div>${s.tanggal ? `<div style="margin-bottom: 4px;"><strong>Tgl Bayar:</strong> ${formatDate(s.tanggal)}</div>` : ''}<div style="background: #fef3c7; padding: 5px; border-radius: 4px; margin-top: 6px;"><strong>Tagihan:</strong> ${formatRupiah(p.jumlah)}</div></div></div>`, { maxWidth: 250 });
    pelangganClusterGroup.addLayer(m);
    pelangganLayers[`pelanggan_${p.no_pelanggan}`] = { marker: m, coords: coords, golongan: gol, wilayah: w, paymentStatus: s.status };
    });
    map.addLayer(pelangganClusterGroup);
    }
    function loadWilayahDanBlok() {
    const container = document.getElementById('wilayah-blok-container');
    try {
    const wilayahMap = {};
    pelangganDataFromLaravel.forEach(p => {
    const w = p.nama_wilayah || 'Tidak Diketahui';
    if (!wilayahMap[w]) wilayahMap[w] = {
    count: 0,
    gol: {},
    status: { 'Kantor': 0, 'PPOB': 0, 'Belum Bayar': 0 },
    coords: []
    };
    wilayahMap[w].count++;
    const s = getPaymentStatus(p);
    wilayahMap[w].status[s.status] = (wilayahMap[w].status[s.status] || 0) + 1;
    const gol = p.kode_gol_trf || 'Lainnya';
    if (!wilayahMap[w].gol[gol]) {
    wilayahMap[w].gol[gol] = {
    count: 0,
    status: { 'Kantor': 0, 'PPOB': 0, 'Belum Bayar': 0 }
    };
    }
    wilayahMap[w].gol[gol].count++;
    wilayahMap[w].gol[gol].status[s.status]++;
    const c = parseKoordinator(p.koordinator);
    if (c && isInArea(c[0], c[1])) {
    wilayahMap[w].coords.push(c);
    }
    });
    let html = '';
    Object.entries(wilayahMap).sort((a, b) => b[1].count - a[1].count).forEach(([wilayah, data]) => {
    const statusBadges = `
    <span style="background: #10b981; padding: 2px 6px; border-radius: 8px; font-size: 9px; font-weight: 700; margin-left: 3px; cursor: pointer;"
    onclick="event.stopPropagation(); focusOnWilayahByStatus('${wilayah.replace(/'/g, "\\'")}', 'Kantor')" title="Bayar di Kantor">
    <i class="fas fa-building"></i> ${data.status['Kantor'] || 0}
    </span>
    <span style="background: #f59e0b; padding: 2px 6px; border-radius: 8px; font-size: 9px; font-weight: 700; margin-left: 3px; cursor: pointer;"
    onclick="event.stopPropagation(); focusOnWilayahByStatus('${wilayah.replace(/'/g, "\\'")}', 'PPOB')" title="Bayar di PPOB">
    <i class="fas fa-mobile-alt"></i> ${data.status['PPOB'] || 0}
    </span>
    <span style="background: #ef4444; padding: 2px 6px; border-radius: 8px; font-size: 9px; font-weight: 700; margin-left: 3px; cursor: pointer;"
    onclick="event.stopPropagation(); focusOnWilayahByStatus('${wilayah.replace(/'/g, "\\'")}', 'Belum Bayar')" title="Belum Bayar">
    <i class="fas fa-times"></i> ${data.status['Belum Bayar'] || 0}
    </span>
    `;
    html += `<div class="wilayah-card">
    <div class="wilayah-header" onclick="focusOnWilayah('${wilayah.replace(/'/g, "\\'")}')" style="cursor: pointer; flex-wrap: wrap; gap: 4px;">
    <span><i class="fas fa-map-marker-alt"></i> ${wilayah}</span>
    <div style="display: flex; align-items: center; gap: 4px;">
    ${statusBadges}
    <span style="background: rgba(255,255,255,0.2); padding: 2px 8px; border-radius: 12px; font-size: 11px;">${data.count}</span>
    </div>
    </div>
    <div class="wilayah-blok-list">`;
    Object.entries(data.gol).forEach(([gol, golData]) => {
    const blokStatus = `
    <span style="color: #10b981; font-size: 9px; font-weight: 700;" title="Kantor">
    <i class="fas fa-building"></i>${golData.status['Kantor'] || 0}
    </span>
    <span style="color: #f59e0b; font-size: 9px; font-weight: 700;" title="PPOB">
    <i class="fas fa-mobile-alt"></i>${golData.status['PPOB'] || 0}
    </span>
    <span style="color: #ef4444; font-size: 9px; font-weight: 700;" title="Belum Bayar">
    <i class="fas fa-times"></i>${golData.status['Belum Bayar'] || 0}
    </span>
    `;
    html += `<div class="blok-item" onclick="focusOnBlok('${wilayah.replace(/'/g, "\\'")}', '${gol.replace(/'/g, "\\'")}')" style="cursor: pointer;">
    <div style="display: flex; align-items: center; gap: 8px; flex: 1;">
    <i class="fas fa-layer-group" style="color: #3b82f6; font-size: 10px;"></i>
    <span style="font-weight: 600; color: #1e293b;">Gol ${gol}</span>
    <div style="display: flex; gap: 6px; margin-left: 4px;">${blokStatus}</div>
    </div>
    <div style="display: flex; align-items: center; gap: 6px;">
    <span style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 2px 8px; border-radius: 10px; font-weight: 700; font-size: 11px;">${golData.count}</span>
    </div>
    </div>`;
    });
    html += `</div></div>`;
    });
    container.innerHTML = html;
    } catch (error) {
    console.error('Error loading wilayah:', error);
    container.innerHTML = `<div class="alert alert-danger" style="font-size: 12px;"><i class="fas fa-exclamation-triangle"></i> Gagal memuat data wilayah</div>`;
    }
    }
    // 🔥 FOKUS KE SELURUH WILAYAH (TIDAK TERHALANG MARKER UNPAID)
    // 🔥 FOKUS KE SELURUH WILAYAH (TIDAK TERHALANG MARKER)
    function focusOnWilayah(namaWilayah) {
        if (isLiveDashboardActive) stopLiveCycle();
    
        const coords = [];
        pelangganDataFromLaravel.forEach(p => {
            if ((p.nama_wilayah || 'Tidak Diketahui') === namaWilayah) {
                const c = parseKoordinator(p.koordinator);
                if (c && isInArea(c[0], c[1])) coords.push(c);
            }
        });
    
        if (coords.length === 0) {
            showNotification(`❌ Tidak ada koordinat untuk ${namaWilayah}`, 'warning');
            return;
        }
    
        const bounds = L.latLngBounds(coords.map(c => L.latLng(c[0], c[1])));
    
        // 🔥 KUNCI: Padding besar + maxZoom rendah agar marker tidak menutupi
        map.fitBounds(bounds, {
            padding: [100, 100],  // Padding lebih besar
            maxZoom: 15,          // Zoom tidak terlalu dekat
            animate: true,
            duration: 1.5
        });
    
        showNotification(`📍 Wilayah: ${namaWilayah} (${coords.length} pelanggan)`, 'info');
        if (window.innerWidth < 768) toggleSidebar();
    }
    // 🔥 FOKUS KE WILAYAH BERDASARKAN STATUS PEMBAYARAN
    function focusOnWilayahByStatus(namaWilayah, statusFilter) {
    if (isLiveDashboardActive) stopLiveCycle();
    const coords = [];
    pelangganDataFromLaravel.forEach(p => {
    if ((p.nama_wilayah || 'Tidak Diketahui') === namaWilayah) {
    const s = getPaymentStatus(p);
    if (s.status === statusFilter) {
    const c = parseKoordinator(p.koordinator);
    if (c && isInArea(c[0], c[1])) coords.push(c);
    }
    }
    });
    if (coords.length === 0) {
    showNotification(`❌ Tidak ada pelanggan "${statusFilter}" di ${namaWilayah}`, 'warning');
    return;
    }
    const bounds = L.latLngBounds(coords.map(c => L.latLng(c[0], c[1])));
    map.fitBounds(bounds, { padding: [80, 80], maxZoom: 17 });
    const iconMap = { 'Kantor': '🏢', 'PPOB': '📱', 'Belum Bayar': '⚠️' };
    showNotification(`${iconMap[statusFilter] || '📍'} ${namaWilayah} - ${statusFilter} (${coords.length} pelanggan)`, 'info');
    if (window.innerWidth < 768) toggleSidebar();
    }
    // 🔥 FOKUS KE BLOK (GOLONGAN) TERTENTU
    function focusOnBlok(namaWilayah, kodeGol) {
    if (isLiveDashboardActive) stopLiveCycle();
    const coords = [];
    pelangganDataFromLaravel.forEach(p => {
    if ((p.nama_wilayah || 'Tidak Diketahui') === namaWilayah &&
    (p.kode_gol_trf || 'Lainnya') === kodeGol) {
    const c = parseKoordinator(p.koordinator);
    if (c && isInArea(c[0], c[1])) coords.push(c);
    }
    });
    if (coords.length === 0) {
    showNotification(`❌ Tidak ada koordinat untuk ${namaWilayah} - Gol ${kodeGol}`, 'warning');
    return;
    }
    const bounds = L.latLngBounds(coords.map(c => L.latLng(c[0], c[1])));
    map.fitBounds(bounds, { padding: [80, 80], maxZoom: 18 });
    showNotification(`📍 ${namaWilayah} - Gol ${kodeGol} (${coords.length} pelanggan)`, 'info');
    if (window.innerWidth < 768) toggleSidebar();
    }
    // ============================================
    // SEARCH & FOCUS
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
    if (filter !== 'all' && status.status !== filter) return false;
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
    results = results.slice(0, 20);
    let html = '';
    results.forEach(p => {
    const status = getPaymentStatus(p);
    html += `<div class="search-result-item" onclick="focusOnPelanggan('${p.no_pelanggan}')"><div><div class="sr-name"><i class="fas ${status.icon}" style="color: ${status.color};"></i> ${p.nama || 'Tanpa Nama'}</div><div class="sr-detail">No: ${p.no_pelanggan} • ${p.nama_wilayah || '-'}</div></div><div class="sr-badge" style="background: ${status.color};">${status.status}</div></div>`;
    });
    resultsContainer.innerHTML = html;
    }
    function clearSearch() {
    document.getElementById('searchInput').value = '';
    document.getElementById('searchFilter').value = 'all';
    document.getElementById('searchResults').innerHTML = '<div class="search-empty">Ketik untuk mencari pelanggan</div>';
    }
    function focusOnPelanggan(noPelanggan) {
    if (isLiveDashboardActive) stopLiveCycle();
    const data = pelangganLayers[`pelanggan_${noPelanggan}`];
    if (data && data.coords) {
    map.flyTo(data.coords, 18, { duration: 1 });
    setTimeout(() => { data.marker.openPopup(); }, 1000);
    showNotification(`📍 Menuju pelanggan: ${noPelanggan}`, 'info');
    } else {
    const unpaid = unpaidCustomerList.find(u => u.data.no_pelanggan === noPelanggan);
    if (unpaid) {
    map.flyTo(unpaid.coords, 18, { duration: 1 });
    setTimeout(() => { unpaid.marker.openPopup(); }, 1000);
    showNotification(`📍 Menuju pelanggan: ${noPelanggan}`, 'info');
    } else {
    showNotification('Koordinat pelanggan tidak ditemukan', 'warning');
    }
    }
    }
    function focusOnJalur(id) {
    if (isLiveDashboardActive) stopLiveCycle();
    if (jalurLayers[id]) { map.fitBounds(jalurLayers[id].getBounds(), { padding: [50, 50] }); jalurLayers[id].openPopup(); if (window.innerWidth < 768) toggleSidebar(); }
    }
    function focusOnBangunan(id) {
    if (isLiveDashboardActive) stopLiveCycle();
    const m = markerLayers[`bangunan_${id}`]; if (m) { map.setView(m.getLatLng(), 17); m.openPopup(); if (window.innerWidth < 768) toggleSidebar(); }
    }
    // 🔥 FOKUS KE ZONA
    function focusOnZona(id) {
        if (isLiveDashboardActive) stopLiveCycle();
        if (zonaLayers[id]) {
            const { polygon } = zonaLayers[id];
            map.fitBounds(polygon.getBounds(), { padding: [80, 80], maxZoom: 16 });
            setTimeout(() => polygon.openPopup(), 800);
            if (window.innerWidth < 768) toggleSidebar();
        }
    }
    function focusOnGangguan(id) {
    if (isLiveDashboardActive) stopLiveCycle();
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
    b.classList.add('active'); b.innerHTML = '<i class="fas fa-compress"></i> <span>Keluar</span>';
    } else {
    if (document.exitFullscreen) document.exitFullscreen(); else if (document.webkitExitFullscreen) document.webkitExitFullscreen();
    w.classList.remove('is-fullscreen'); isFullscreen = false;
    b.classList.remove('active'); b.innerHTML = '<i class="fas fa-expand"></i> <span>Fullscreen</span>';
    }
    setTimeout(() => { if (map) map.invalidateSize(); }, 300);
    }
    document.addEventListener('fullscreenchange', () => { if (!document.fullscreenElement && !document.webkitFullscreenElement) { document.getElementById('mainWrapper').classList.remove('is-fullscreen'); isFullscreen = false; document.getElementById('expandBtn').classList.remove('active'); document.getElementById('expandBtn').innerHTML = '<i class="fas fa-expand"></i> <span>Fullscreen</span>'; setTimeout(() => { if (map) map.invalidateSize(); }, 300); } });
    document.addEventListener('keydown', e => { if (e.key === 'F11') { e.preventDefault(); toggleFullscreen(); } });
    let waQRGenerated = false;
    function showWAQR() {
    new bootstrap.Modal(document.getElementById('waQRModal')).show();
    if (!waQRGenerated) {
    document.getElementById('wa-qrcode').innerHTML = '';
    new QRCode(document.getElementById('wa-qrcode'), { text: 'https://wa.me/6288294979966?text=Halo%20PDAM%20Tirta%20Medal', width: 220, height: 220, colorDark: '#128C7E', colorLight: '#ffffff', correctLevel: QRCode.CorrectLevel.H });
    waQRGenerated = true;
    }
    }
    // ============================================
//  FUNGSI TEST NOTIFIKASI PEMBAYARAN KANTOR
// ============================================
function testPaymentNotification() {
    console.log(' Testing payment notification...');
    
    const dummyPelanggan = {
        no_pelanggan: '0301001001',
        nama: 'DR. HERMAN',
        jumlah: '604800',
        pakai: '71',
        kode_gol_trf: 'RT.D',
        nama_wilayah: 'WILAYAH I',
        koordinator: '-6.9170766,108.0685615',
        statusInfo: {
            status: 'Kantor',
            color: '#10b981',
            icon: 'fa-building',
            tanggal: new Date().toISOString(),
            metode: 'Kantor'
        }
    };
    
    handlePaymentReceived(dummyPelanggan);
    updateUIAfterPayment(dummyPelanggan);
    
    console.log('✅ Test payment notification triggered!');
}

// ============================================
// 🔥 FUNGSI TEST PEMBAYARAN PPOB
// ============================================
function testPaymentPPOB() {
    console.log('🧪 Testing PPOB payment notification...');
    
    const dummyPelanggan = {
        no_pelanggan: '0301007155',
        nama: 'H. ACENG SUHANDI',
        jumlah: '418600',
        pakai: '52',
        kode_gol_trf: 'RT.D',
        nama_wilayah: 'WILAYAH I',
        koordinator: '-6.9152425,108.0678316',
        statusInfo: {
            status: 'PPOB',
            color: '#f59e0b',
            icon: 'fa-mobile-alt',
            tanggal: new Date().toISOString(),
            metode: 'PPOB'
        }
    };
    
    handlePaymentReceived(dummyPelanggan);
    updateUIAfterPayment(dummyPelanggan);
    
    console.log('✅ Test PPOB payment notification triggered!');
}
    document.addEventListener('DOMContentLoaded', initMap);
    window.addEventListener('beforeunload', () => {
    stopRealtimePolling();
    });
  </script>
  <script src="https://www.youtube.com/iframe_api"></script>
</body>
</html>