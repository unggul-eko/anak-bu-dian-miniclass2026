<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>PomoStep - Manajemen Fokus & Tugas</title>
    
    <!-- Bootstrap 5 + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/tampilan.css">
    <link rel="stylesheet" href="pengaturan.css">
    <div id="navCapsulesGroup" class="header-nav-sticky">
    <div class="logo-title">
        <img src="../assets/logo.png" alt="PomoStep Logo" class="logo-img">
    </div>
    <div class="nav-scroll-container">
        <span class="nav-pill-custom active" data-target="dashboard-section">
            <i class="bi bi-house-door-fill"></i> Beranda
        </span>
        <span class="nav-pill-custom" data-target="timer-section">
            <i class="bi bi-stopwatch-fill"></i> Timer
        </span>
        <span class="nav-pill-custom" data-target="tugas-section">
            <i class="bi bi-card-checklist"></i> Tugas & Kalender
        </span>
        <span class="nav-pill-custom" data-target="memo-section">
            <i class="bi bi-journal-text"></i> Memo
        </span>
        
        <a href="statistik.php" class="nav-pill-custom nav-link">
            <i class="bi bi-graph-up-arrow"></i> Statistik
        </a>
        
        <span class="nav-pill-custom" data-bs-toggle="modal" data-bs-target="#pengaturanModal">
            <i class="bi bi-gear-fill"></i> Pengaturan
        </span>
    </div>
</div>
</head>
<body>

<div class="container py-4 py-md-5">

    <!-- Dashboard -->
    <div id="dashboard-section" class="scroll-target-marker" style="scroll-margin-top: 150px;">
        <div class="row align-items-center g-4 mb-5">
            <div class="col-lg-7 text-start">
                <div class="hero-clean-wrapper">
                    <div class="hero-tagline">Kelola Waktu Produktif Tanpa Ribet</div>
                    <h2 class="hero-title">Atur Waktu Fokus Jadi Lebih Baik &amp; Praktis</h2>
                    <p class="hero-desc">Tingkatkan produktivitas dan jaga kebugaran tubuhmu. Mulai sesi fokusmu dan selesaikan target tugas harianmu sekarang juga!</p>
                    <div class="d-flex gap-3">
                        <span id="btnFocusNow" class="btn btn-success btn-hero-action shadow-sm"><i class="bi bi-play-circle-fill me-1"></i> Fokus Sekarang</span>
                        <span id="btnSeeTasks" class="btn btn-outline-success btn-hero-action"><i class="bi bi-checklist-task me-1"></i> Lihat Tugas &amp; Kalender</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="glass-card p-4 text-center">
                    <div class="pet-talk-bubble" id="petBubbleChat">Yuk mulai sesi fokusmu hari ini! 🎯</div>
                    <div class="d-flex justify-content-center my-2">
                        <canvas id="petCanvas" width="180" height="180"></canvas>
                    </div>
                    <div class="small fw-bold text-success mb-2"><i class="bi bi-magic"></i> Pilih Kursor &amp; Teman Fokus Anda:</div>
                    <div class="emoji-picker d-flex gap-1 justify-content-center flex-wrap mt-1">
                        <span data-animal="frog" class="shadow-sm active-cursor">🐸 Katak</span>
                        <span data-animal="cat" class="shadow-sm">🐱 Kucing</span>
                        <span data-animal="dog" class="shadow-sm">🐶 Anjing</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Timer Section -->
    <div class="row g-4 mb-5 scroll-target-marker" id="timer-section" style="scroll-margin-top: 150px;">
        <div class="col-lg-6">
            <div class="glass-card p-4 text-center h-100">
                <h5 class="fw-bold mb-3 text-success"><i class="bi bi-stopwatch-fill"></i> Pengendali Timer Fokus</h5>
                <div id="liveAlarmAlertBanner" class="alert alert-danger d-none align-items-center justify-content-between p-2 mb-3 small">
                    <div><i class="bi bi-alarm-fill text-danger fs-5 me-2"></i> <span id="alarmAlertMessage">Ada Jadwal Kegiatan Sekarang!</span></div>
                    <button class="btn btn-sm btn-outline-danger py-0 rounded-pill px-2" onclick="dismissLiveAlarm()">Selesai</button>
                </div>
                <div class="timer-container mx-auto mb-2">
                    <div class="timer-digit" id="timerDisplay">00:00:00</div>
                    <div id="timerModeText" class="small fw-bold text-uppercase text-success">Fokus Dimulai</div>
                    <div class="timer-progress-ring"><div id="timerRingBar" class="timer-progress-bar"></div></div>
                </div>
                <div class="wheel-picker-box mx-auto mb-4" style="max-width:320px;">
                    <div class="row text-center g-0 mb-1">
                        <div class="col-4 wheel-label-header">Jam</div>
                        <div class="col-4 wheel-label-header">Menit</div>
                        <div class="col-4 wheel-label-header">Detik</div>
                    </div>
                    <div class="wheel-container" id="globalWheelWrapper">
                        <div class="wheel-selection-center"></div>
                        <div id="wheelHours" class="wheel-column"><div class="wheel-spacer-top-bottom"></div><div class="wheel-spacer-top-bottom"></div></div>
                        <div class="wheel-separator-dots">:</div>
                        <div id="wheelMinutes" class="wheel-column"><div class="wheel-spacer-top-bottom"></div><div class="wheel-spacer-top-bottom"></div></div>
                        <div class="wheel-separator-dots">:</div>
                        <div id="wheelSeconds" class="wheel-column"><div class="wheel-spacer-top-bottom"></div><div class="wheel-spacer-top-bottom"></div></div>
                    </div>
                </div>
                <div class="d-flex justify-content-center gap-2 mode-switch w-auto mx-auto mb-3" style="max-width:250px;">
                    <span id="focusModeBtn" class="mode-option active">🎯 Focus time</span>
                    <span id="breakModeBtn" class="mode-option">☕ Break</span>
                </div>
                <div class="d-flex gap-2 justify-content-center flex-wrap mb-3">
                    <button id="startTimerBtn" class="btn btn-control-custom"><i class="bi bi-play-fill"></i> Start</button>
                    <button id="pauseTimerBtn" class="btn btn-control-custom"><i class="bi bi-pause-fill"></i> Pause</button>
                    <button id="resetTimerBtn" class="btn btn-control-custom"><i class="bi bi-arrow-clockwise"></i> Reset</button>
                </div>
                <div class="p-2 mx-auto status-note-box text-center" style="max-width:380px;">
                    <span class="me-3"><span class="badge-dot-real bg-real-running"></span> Running</span>
                    <span><span class="badge-dot-real bg-real-stopped"></span> Stopped</span>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="premium-dashboard-card">
                <i class="bi bi-star-fill bg-star-decoration" style="top:20%; left:15%; opacity:0.3;"></i>
                <i class="bi bi-star-fill bg-star-decoration" style="top:60%; right:12%; opacity:0.4;"></i>
                <i class="bi bi-sparkles bg-star-decoration" style="top:30%; right:20%; opacity:0.3;"></i>
                <div>
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <h5 class="fw-bold m-0 text-success"><i class="bi bi-moon-stars-fill me-2"></i>Sesi Produktif Hari Ini</h5>
                        <span class="streak-badge shadow-sm"><i class="bi bi-fire text-danger"></i> STREAK <span id="dashWeeklyStreak">0</span> HARI</span>
                    </div>
                    <div class="text-danger small fw-bold mb-2">⚠️ Sebelum memulai, atur dulu target Anda hari ini!</div>
                    <div class="bg-white p-3 border border-success border-opacity-10 mb-3 text-start shadow-sm" style="border-radius:1.5rem;">
                        <div class="mb-2 d-flex align-items-center justify-content-between">
                            <label class="small text-secondary fw-semibold" for="inputMaxMenit">Target menit fokus hari ini:</label>
                            <div><input type="number" id="inputMaxMenit" value="0" min="0" class="fw-bold text-success text-center border-0 border-bottom bg-light p-1" style="width:50px;"> <span class="small">menit</span></div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <label class="small text-secondary fw-semibold" for="inputMaxTugas">Target jumlah tugas hari ini:</label>
                            <div><input type="number" id="inputMaxTugas" value="0" min="0" class="fw-bold text-success text-center border-0 border-bottom bg-light p-1" style="width:50px;"> <span class="small">tugas</span></div>
                        </div>
                    </div>
                    <div class="small text-muted text-start mb-2">
                        <i class="bi bi-check-circle-fill text-success me-1"></i> Sesi lengkap ke- <span id="dashTotalSessionsToday" class="fw-bold text-dark">0</span> hari ini.
                    </div>
                </div>
                <div class="dashboard-center-content flex-row justify-content-center gap-4 flex-wrap my-3">
                    <div class="circular-progress-box">
                        <svg class="circular-svg" viewBox="0 0 150 150">
                            <defs><linearGradient id="gradientProgressColor" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#1b5e20"/><stop offset="100%" stop-color="#4caf50"/></linearGradient></defs>
                            <circle class="circular-bg-ring" cx="75" cy="75" r="65"/>
                            <circle class="circular-fill-ring" id="dashCircularProgressRing" cx="75" cy="75" r="65" stroke="url(#gradientProgressColor)"/>
                        </svg>
                        <div class="circular-inner-text"><div class="circular-percent-num" id="dashProgressPercentText">0%</div><div class="circular-percent-lbl">Hari Ini</div></div>
                    </div>
                    <div class="circular-progress-box">
                        <svg class="circular-svg" viewBox="0 0 150 150">
                            <defs><linearGradient id="gradientProgressColorAll" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#0d47a1"/><stop offset="100%" stop-color="#29b6f6"/></linearGradient></defs>
                            <circle class="circular-bg-ring" cx="75" cy="75" r="65"/>
                            <circle class="circular-fill-ring" id="dashCircularProgressRingAll" cx="75" cy="75" r="65" stroke="url(#gradientProgressColorAll)"/>
                        </svg>
                        <div class="circular-inner-text"><div class="circular-percent-num" id="dashProgressPercentTextAll" style="color:#0d47a1;">0%</div><div class="circular-percent-lbl">Total</div></div>
                    </div>
                </div>
                <div class="dashboard-bottom-grid">
                    <div class="micro-stat-card"><div class="small text-warning mb-1"><i class="bi bi-star-fill"></i> <span class="micro-stat-lbl">Break</span></div><div class="micro-stat-num" id="dashActiveBreakCount">0</div></div>
                    <div class="micro-stat-card"><div class="small text-primary mb-1"><i class="bi bi-stopwatch-fill"></i> <span class="micro-stat-lbl">Menit</span></div><div>Hari Ini: <span id="targetMenitFokus" class="fw-bold">0</span></div><div>Total: <span id="totalMenitFokusKeseluruhan" class="fw-bold">0</span></div></div>
                    <div class="micro-stat-card"><div class="small text-success mb-1"><i class="bi bi-trophy-fill"></i> <span class="micro-stat-lbl">Tugas</span></div><div>Hari Ini: <span id="targetTugasSelesai">0</span>/<span id="targetTugasHariIniTotal">0</span></div><div>Total: <span id="totalTugasSelesaiKeseluruhan">0</span>/<span id="totalTugasKeseluruhanSemua">0</span></div></div>
                </div>
                <div class="text-start mt-3 p-2 border-top border-success border-top-opacity small text-secondary">
                    <i class="bi bi-info-circle-fill text-success"></i> <b>Informasi Total:</b> Akumulasi data statistik keseluruhan tugas, project, dan jadwal ter-input.
                </div>
            </div>
        </div>
    </div>

    <!-- Tugas & Kalender -->
    <div class="row g-4 mb-5 scroll-target-marker" id="tugas-section" style="scroll-margin-top:150px;">
        <div class="col-lg-6">
            <div class="glass-card p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-bold m-0 text-success"><i class="bi bi-calendar3"></i> Kalender Aktivitas Kuliah</h6>
                    <span class="calendar-header-title fw-bold text-success" id="calendarMonthYearTitle">Juni 2026</span>
                </div>
                <p class="text-muted small mb-3"><i class="bi bi-info-circle"></i> Tanggal ber-bintang <span class="text-warning fw-bold">⭐</span> memiliki jadwal tugas / kuliah.</p>
                <div class="calendar-grid" id="calendarDaysContainer">
                    <div class="calendar-day-label">Min</div><div class="calendar-day-label">Sen</div><div class="calendar-day-label">Sel</div><div class="calendar-day-label">Rab</div><div class="calendar-day-label">Kam</div><div class="calendar-day-label">Jum</div><div class="calendar-day-label">Sab</div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="glass-card p-4 h-100 d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold m-0 text-success"><i class="bi bi-card-checklist"></i> Manajemen Tugas &amp; Kegiatan</h6>
                    <button class="btn btn-sm btn-success rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#addTaskModal"><i class="bi bi-plus-circle-fill"></i> Tambah</button>
                </div>
                <div class="flex-grow-1" style="max-height:290px; overflow-y:auto;" id="todoList"></div>
            </div>
        </div>
    </div>

    <!-- Memo -->
    <div class="row g-4 mb-5 scroll-target-marker" id="memo-section" style="scroll-margin-top:150px;">
        <div class="col-12">
            <div class="glass-card p-4">
                <div class="fw-bold small text-success mb-2 fs-5"><i class="bi bi-journal-text"></i> Memo Riwayat Ringkasan Fokus</div>
                <div id="memoLogArea" style="max-height:250px; overflow-y:auto;"></div>
            </div>
        </div>
    </div>

    <!-- Statistik -->
    <div class="pt-4 border-top border-success border-opacity-25 scroll-target-marker" id="statistik-section" style="scroll-margin-top:150px;">
        <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
            <h5 class="fw-bold text-success m-0"><i class="bi bi-graph-up-arrow"></i> Target &amp; Capaian Produktivitas</h5>
        </div>
        <div class="row g-4">
            <div class="col-12">
                <div class="glass-card p-4 text-center">
                    <h5 class="fw-bold mb-3 text-success text-start"><i class="bi bi-trophy"></i> Capaian Produktivitas</h5>
                    <div class="row text-start g-3">
                        <div class="col-md-6 py-2 border-bottom border-light"><span class="text-secondary">Rata-rata menit / sesi:</span><span class="fw-bold float-end" id="capaianRataRata">0</span></div>
                        <div class="col-md-6 py-2 border-bottom border-light"><span class="text-secondary">Total sesi fokus lengkap:</span><span class="fw-bold float-end" id="capaianTotalSesi">0</span></div>
                    </div>
                    <div class="alert alert-success py-2 px-3 mt-3 m-0 small border-0 text-start"><i class="bi bi-lightbulb-fill text-warning me-1"></i> Semakin konsisten, streak-mu akan meningkat!</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Tugas -->
<div class="modal fade" id="addTaskModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white"><h5 class="modal-title"><i class="bi bi-plus-circle-fill"></i> Tambah Kegiatan Baru</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div>
            <form id="modalTaskForm">
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label fw-bold">Nama Tugas/Kegiatan</label><input type="text" id="formTaskText" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label fw-bold">Mata Kuliah / Acara</label><input type="text" id="formTaskSubject" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label fw-bold">Tanggal</label><input type="date" id="formTaskDate" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label fw-bold">Jam</label><input type="time" id="formTaskTime" class="form-control" required></div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-success">Simpan</button><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button></div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Pengaturan -->
<div class="modal fade" id="pengaturanModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="bi bi-sliders2"></i> Pengaturan Aplikasi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Opsi Notifikasi -->
                <div class="setting-option-item mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="bi bi-bell-fill text-warning setting-icon"></i>
                            <span class="fw-bold">Notifikasi Suara</span>
                            <p class="small text-muted mb-0">Aktifkan bunyi saat timer selesai atau alarm tugas.</p>
                        </div>
                        <div class="form-check form-switch form-switch-large">
                            <input class="form-check-input" type="checkbox" id="soundNotificationToggle" checked>
                        </div>
                    </div>
                </div>
                <!-- Opsi Mode Gelap -->
                <div class="setting-option-item mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="bi bi-palette-fill text-info setting-icon"></i>
                            <span class="fw-bold">Mode Gelap (Beta)</span>
                            <p class="small text-muted mb-0">Ganti tema gelap untuk kenyamanan mata.</p>
                        </div>
                        <div class="form-check form-switch form-switch-large">
                            <input class="form-check-input" type="checkbox" id="darkModeToggle">
                        </div>
                    </div>
                </div>
                <hr>
                <!-- Zona Berbahaya -->
                <div class="danger-zone-settings">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div>
                            <i class="bi bi-trash3-fill text-danger fs-4 me-2"></i>
                            <span class="fw-bold">Reset Semua Data</span>
                            <p class="small text-muted mb-0">Hapus semua tugas, memo, statistik, dan pengaturan. Tindakan permanen.</p>
                        </div>
                        <button class="btn btn-danger btn-setting-modal" data-bs-toggle="modal" data-bs-target="#confirmResetModal">
                            <i class="bi bi-eraser-fill"></i> Reset Data
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Reset (sub-modal) -->
<div class="modal fade" id="confirmResetModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="bi bi-exclamation-octagon-fill"></i> Konfirmasi Reset Data</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Anda yakin ingin <strong>menghapus semua data</strong>?</p>
                <ul>
                    <li>Semua tugas & jadwal akan hilang</li>
                    <li>Memo fokus akan terhapus</li>
                    <li>Statistik produktivitas (streak, sesi, menit) akan direset ke 0</li>
                    <li>Pengaturan akan kembali ke default</li>
                </ul>
                <p class="text-danger fw-bold mb-0">Tindakan ini TIDAK dapat dibatalkan!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmResetBtn">Ya, Reset Semua Data</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/skrip.js"></script>
</body>
</html>