<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>PomoStep • Pomodoro & Active Break</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2 family=Inter:wght@400;500;600;700;800&family=Roboto+Mono:wght@700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="tampilan.css">
</head>
<body>

<div class="container py-3 py-md-5">
    <div class="header-nav-sticky">
        <div class="d-flex align-items-center gap-2 mb-2 mb-md-0">
            <i class="bi bi-lightning-charge-fill text-success fs-3 fs-md-2"></i>
            <h1 class="logo-title m-0">PomoStep</h1>
        </div>
        <div class="nav-scroll-container" id="navCapsulesGroup">
            <span class="nav-pill-custom active" data-target="dashboard-section"><i class="bi bi-house-door"></i> Dashboard</span>
            <span class="nav-pill-custom" data-target="timer-section"><i class="bi bi-stopwatch"></i> Timer</span>
            <span class="nav-pill-custom" data-target="tugas-section"><i class="bi bi-calendar-event"></i> Jadwal &amp; Tugas</span>
            <span class="nav-pill-custom" data-target="memo-section"><i class="bi bi-journal-text"></i> Memo</span>
            <span onclick="window.location.href='statistik.php'"
            class="nav-pill-custom" data-target="statistik-section"><i class="bi bi-graph-up"></i> Statistik</span>
            <span class="nav-pill-custom" id="resetDataBtn"><i class="bi bi-arrow-repeat"></i> Pengaturan</span>
        </div>
    </div>

    <div id="dashboard-section" class="scroll-target-marker" style="scroll-margin-top: 150px;">
        <div class="row align-items-center g-4 mb-5">
            <div class="col-lg-7 text-start">
                <div class="hero-clean-wrapper">
                    <div class="hero-tagline">Kelola Waktu Produktif Tanpa Ribet</div>
                    <h2 class="hero-title">Atur Waktu Fokus Jadi Lebih Baik &amp; Praktis</h2>
                    <p class="hero-desc">
                        Tingkatkan produktivitas dan jaga kebugaran tubuhmu. Mulai sesi fokusmu dan selesaikan target tugas harianmu sekarang juga!
                    </p>
                    <div class="d-flex gap-3">
                        <span id="btnFocusNow" class="btn btn-success btn-hero-action shadow-sm"><i class="bi bi-play-circle-fill me-1"></i> Fokus Sekarang</span>
                        <span id="btnSeeTasks" class="btn btn-outline-success btn-hero-action"><i class="bi bi-checklist-task me-1"></i> Lihat Tugas &amp; Kalender</span>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-5">
                <div class="glass-card p-4 text-center">
                    <div class="pet-talk-bubble" id="petBubbleChat"> Yuk mulai sesi fokusmu hari ini! 🎯</div>
                    <div class="d-flex justify-content-center my-2">
                        <canvas id="petCanvas" width="180" height="180"></canvas>
                    </div>
                    <div class="small fw-bold text-success mb-2"><i class="bi bi-magic"></i> Pilih Kursor &amp; Teman Fokus Anda:</div>
                    <div class="emoji-picker d-flex gap-1 justify-content-center flex-wrap mt-1">
                        <span data-animal="frog" class="shadow-sm active-cursor" title="Katak">🐸 Katak</span>
                        <span data-animal="cat" class="shadow-sm" title="Kucing">🐱 Kucing</span>
                        <span data-animal="dog" class="shadow-sm" title="Anjing">🐶 Anjing</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5 scroll-target-marker" id="timer-section" style="scroll-margin-top: 150px;">
        <div class="col-lg-6">
            <div class="glass-card p-4 text-center h-100">
                <h5 class="fw-bold mb-3 text-success"><i class="bi bi-stopwatch-fill"></i> Pengendali Timer Fokus</h5>
                
                <div id="liveAlarmAlertBanner" class="alert alert-danger d-none align-items-center justify-content-between p-2 mb-3 small" style="border-radius: 12px;">
                    <div><i class="bi bi-alarm-fill text-danger fs-5 me-2"></i> <span id="alarmAlertMessage">Ada Jadwal Kegiatan Sekarang!</span></div>
                    <button class="btn btn-sm btn-outline-danger py-0 rounded-pill px-2" onclick="dismissLiveAlarm()">Selesai</button>
                </div>

                <div class="timer-container mx-auto mb-2">
                    <div class="timer-digit" id="timerDisplay">00:00:00</div>
                    <div id="timerModeText" class="small fw-bold text-uppercase text-success" style="font-size: 0.75rem; letter-spacing: 0.5px;">Fokus Dimulai</div>
                    <div class="timer-progress-ring">
                        <div id="timerRingBar" class="timer-progress-bar"></div>
                    </div>
                </div>

                <div class="wheel-picker-box mx-auto mb-4" style="max-width: 320px;">
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
                
                <div class="d-flex justify-content-center gap-2 mode-switch w-auto mx-auto mb-3" style="max-width: 250px;">
                    <span id="focusModeBtn" class="mode-option active">🎯 Focus time</span>
                    <span id="breakModeBtn" class="mode-option">☕ Break</span>
                </div>
                
                <div class="d-flex gap-2 justify-content-center flex-wrap mb-3">
                    <button id="startTimerBtn" class="btn btn-control-custom"><i class="bi bi-play-fill"></i> Start</button>
                    <button id="pauseTimerBtn" class="btn btn-control-custom"><i class="bi bi-pause-fill"></i> Pause</button>
                    <button id="resetTimerBtn" class="btn btn-control-custom"><i class="bi bi-arrow-clockwise"></i> Reset</button>
                </div>

                <div class="p-2 mx-auto status-note-box text-center" style="max-width: 380px;">
                    <span class="me-3"><span class="badge-dot-real bg-real-running"></span> Running</span>
                    <span><span class="badge-dot-real bg-real-stopped"></span> Stopped</span>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="premium-dashboard-card">
                <i class="bi bi-star-fill bg-star-decoration" style="top: 20%; left: 15%; opacity: 0.3;"></i>
                <i class="bi bi-star-fill bg-star-decoration" style="top: 60%; right: 12%; opacity: 0.4; font-size: 1rem;"></i>
                <i class="bi bi-sparkles bg-star-decoration" style="top: 30%; right: 20%; opacity: 0.3;"></i>

                <div>
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <h5 class="fw-bold m-0 text-success"><i class="bi bi-moon-stars-fill me-2"></i>Sesi Produktif Hari Ini</h5>
                        <span class="streak-badge shadow-sm"><i class="bi bi-fire text-danger"></i> STREAK <span id="dashWeeklyStreak">0</span> HARI</span>
                    </div>
                    
                    <div class="text-danger small fw-bold mb-2" style="font-size: 0.78rem; letter-spacing: 0.3px;">
                        <i class="bi bi-exclamation-circle-fill"></i> Note: Sebelum memulai, atur dulu target Anda hari ini!
                    </div>

                    <div class="bg-white p-3 border border-success border-opacity-10 mb-3 text-start shadow-sm" style="border-radius:1.5rem;">
                        <div class="mb-2 d-flex align-items-center justify-content-between">
                            <label class="small text-secondary fw-semibold m-0" for="inputMaxMenit">Isi berapa menit Anda ingin fokus / belajar hari ini:</label>
                            <div class="d-flex align-items-center gap-1">
                                <input type="number" id="inputMaxMenit" value="0" min="0" class="fw-bold text-success text-center border-0 border-bottom border-success border-opacity-20 bg-light p-1" style="width:50px; border-radius:6px; outline:none;">
                                <span class="small text-muted fw-bold">menit</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <label class="small text-secondary fw-semibold m-0" for="inputMaxTugas">Berapa jumlah total tugas / project target hari ini:</label>
                            <div class="d-flex align-items-center gap-1">
                                <input type="number" id="inputMaxTugas" value="0" min="0" class="fw-bold text-success text-center border-0 border-bottom border-success border-opacity-20 bg-light p-1" style="width:50px; border-radius:6px; outline:none;">
                                <span class="small text-muted fw-bold">tugas</span>
                            </div>
                        </div>
                    </div>

                    <div class="small text-muted text-start mb-2">
                        <i class="bi bi-check-circle-fill text-success me-1"></i> Sesi lengkap ke- <span id="dashTotalSessionsToday" class="fw-bold text-dark">0</span> hari ini. Keep it up!
                    </div>
                </div>
                
                <div class="dashboard-center-content flex-row justify-content-center gap-4 flex-wrap my-3">
                    <div class="circular-progress-box">
                        <svg class="circular-svg" viewBox="0 0 150 150">
                            <defs>
                                <linearGradient id="gradientProgressColor" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#1b5e20" />
                                    <stop offset="100%" stop-color="#4caf50" />
                                </linearGradient>
                            </defs>
                            <circle class="circular-bg-ring" cx="75" cy="75" r="65" />
                            <circle class="circular-fill-ring" id="dashCircularProgressRing" cx="75" cy="75" r="65" stroke="url(#gradientProgressColor)" />
                        </svg>
                        <div class="circular-inner-text">
                            <div class="circular-percent-num" id="dashProgressPercentText">0%</div>
                            <div class="circular-percent-lbl">Hari Ini</div>
                        </div>
                    </div>

                    <div class="circular-progress-box">
                        <svg class="circular-svg" viewBox="0 0 150 150">
                            <defs>
                                <linearGradient id="gradientProgressColorAll" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#0d47a1" />
                                    <stop offset="100%" stop-color="#29b6f6" />
                                </linearGradient>
                            </defs>
                            <circle class="circular-bg-ring" cx="75" cy="75" r="65" />
                            <circle class="circular-fill-ring" id="dashCircularProgressRingAll" cx="75" cy="75" r="65" stroke="url(#gradientProgressColorAll)" />
                        </svg>
                        <div class="circular-inner-text">
                            <div class="circular-percent-num" id="dashProgressPercentTextAll" style="color: #0d47a1;">0%</div>
                            <div class="circular-percent-lbl">Total</div>
                        </div>
                    </div>
                </div>

                <div class="dashboard-bottom-grid">
                    <div class="micro-stat-card d-flex flex-column justify-content-center">
                        <div class="small text-warning mb-1"><i class="bi bi-star-fill"></i> <span class="micro-stat-lbl">Break</span></div>
                        <div class="micro-stat-num" id="dashActiveBreakCount">0</div>
                    </div>
                    <div class="micro-stat-card" style="background: linear-gradient(180deg, #ffffff 0%, #f1f9f0 100%); border-color: rgba(46, 125, 50, 0.2);">
                        <div class="small text-primary mb-1"><i class="bi bi-stopwatch-fill"></i> <span class="micro-stat-lbl">Menit</span></div>
                        <div style="font-size: 0.78rem; font-weight:700;" class="text-secondary">Hari Ini: <span id="targetMenitFokus" class="text-dark fw-bold">0</span></div>
                        <div style="font-size: 0.78rem; font-weight:700;" class="text-secondary">Total: <span id="totalMenitFokusKeseluruhan" class="text-success fw-bold">0</span></div>
                    </div>
                    <div class="micro-stat-card">
                        <div class="small text-success mb-1"><i class="bi bi-trophy-fill"></i> <span class="micro-stat-lbl">Tugas</span></div>
                        <div style="font-size: 0.75rem; font-weight:700;" class="text-secondary">Hari Ini: <span id="targetTugasSelesai" class="text-dark fw-bold">0</span> / <span id="targetTugasHariIniTotal" class="text-dark fw-bold">0</span></div>
                        <div style="font-size: 0.75rem; font-weight:700;" class="text-secondary">Total: <span id="totalTugasSelesaiKeseluruhan" class="text-success fw-bold">0</span> / <span id="totalTugasKeseluruhanSemua" class="text-success fw-bold">0</span></div>
                    </div>
                </div>
                
                <div class="text-start mt-3 p-2 border-top border-success border-top-opacity" style="font-size: 0.73rem; font-weight: 500; color: #556b2f; line-height: 1.4;">
                    <i class="bi bi-info-circle-fill text-success"></i> <b>Informasi Total:</b> Akumulasi data statistik keseluruhan tugas, project, dan jadwal ter-input yang Anda miliki di luar data historis hari ini.
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5 scroll-target-marker" id="tugas-section" style="scroll-margin-top: 150px;">
        <div class="col-lg-6">
            <div class="glass-card p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-bold m-0 text-success"><i class="bi bi-calendar3"></i> Kalender Aktivitas Kuliah</h6>
                    <span class="calendar-header-title fw-bold text-success" id="calendarMonthYearTitle">Juni 2026</span>
                </div>
                <p class="text-muted small mb-3" style="font-size:0.75rem;"><i class="bi bi-info-circle"></i> Tanggal ber-bintang <span class="text-warning fw-bold">🌟</span> memiliki jadwal tugas / kuliah aktif.</p>
                
                <div class="calendar-grid" id="calendarDaysContainer">
                    <div class="calendar-day-label fw-bold text-muted">Min</div>
                    <div class="calendar-day-label fw-bold text-muted">Sen</div>
                    <div class="calendar-day-label fw-bold text-muted">Sel</div>
                    <div class="calendar-day-label fw-bold text-muted">Rab</div>
                    <div class="calendar-day-label fw-bold text-muted">Kam</div>
                    <div class="calendar-day-label fw-bold text-muted">Jum</div>
                    <div class="calendar-day-label small fw-bold text-muted">Sab</div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="glass-card p-4 h-100 d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold m-0 text-success"><i class="bi bi-card-checklist"></i> Manajemen Tugas &amp; Kegiatan</h6>
                    <button class="btn btn-sm btn-success rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#addTaskModal"><i class="bi bi-plus-circle-fill"></i> Tambah</button>
                </div>
                <div class="flex-grow-1" style="max-height: 290px; overflow-y: auto;" id="todoList"></div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5 scroll-target-marker" id="memo-section" style="scroll-margin-top: 150px;">
        <div class="col-12">
            <div class="glass-card p-4">
                <div class="fw-bold small text-success mb-2 fs-5"><i class="bi bi-journal-text"></i> Memo Riwayat Ringkasan Fokus</div>
                <div id="memoLogArea" style="max-height: 250px; overflow-y: auto; padding-right: 5px;">
                    <div class="small text-muted italic text-center py-3">Belum ada rekaman fokus.</div>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-4 border-top border-success border-opacity-25 scroll-target-marker" id="statistik-section" style="scroll-margin-top: 150px;">
        <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
            <h5 class="fw-bold text-success m-0"><i class="bi bi-graph-up-arrow"></i> Target &amp; Capaian Produktivitas ActiveFlow</h5>
        </div>
        <div class="row g-4">
            <div class="col-12">
                <div class="glass-card p-4 text-center" style="border-radius: 2rem;">
                    <h5 class="fw-bold mb-3 text-success text-start"><i class="bi bi-trophy"></i> Capaian Produktivitas</h5>
                    <div class="row text-start g-3">
                        <div class="col-md-6 py-2 border-bottom border-light">
                            <span class="text-secondary">Rata-rata menit / sesi:</span>
                            <span class="fw-bold float-end" id="capaianRataRata">0</span>
                        </div>
                        <div class="col-md-6 py-2 border-bottom border-light">
                            <span class="text-secondary">Total sesi fokus lengkap:</span>
                            <span class="fw-bold float-end" id="capaianTotalSesi">0</span>
                        </div>
                    </div>
                    <div class="alert alert-success py-2 px-3 mt-3 m-0 small border-0 text-start" style="border-radius: 1rem; background: #e8f5e9; color: #2e7d32;">
                        <i class="bi bi-lightbulb-fill text-warning me-1"></i> Semakin konsisten, streak-mu akan meningkat!
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius:24px; border:none; background:#fbfdfa;">
      <div class="modal-header border-0 bg-success text-white" style="border-radius: 24px 24px 0 0;">
        <h6 class="modal-title fw-bold" id="addTaskModalLabel"><i class="bi bi-calendar-plus"></i> Tambah Tugas &amp; Kegiatan</h6>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="modalTaskForm">
            <div class="mb-2">
                <label class="form-label small fw-bold text-secondary">Nama Tugas / Kegiatan</label>
                <input type="text" class="form-control" id="formTaskText" placeholder="Contoh: zoom" required style="border-radius:12px;">
            </div>
            <div class="mb-2">
                <label class="form-label small fw-bold text-secondary">Mata Kuliah / Jenis Kegiatan</label>
                <input type="text" class="form-control" id="formTaskSubject" placeholder="Contoh: Matematika" required style="border-radius:12px;">
            </div>
            <div class="row g-2">
                <div class="col-7">
                    <div class="mb-2">
                        <label class="form-label small fw-bold text-secondary">Tanggal Pelaksanaan</label>
                        <input type="date" class="form-control" id="formTaskDate" required style="border-radius:12px;">
                    </div>
                </div>
                <div class="col-5">
                    <div class="mb-2">
                        <label class="form-label small fw-bold text-secondary">Jam Peringatan</label>
                        <input type="time" class="form-control" id="formTaskTime" required style="border-radius:12px;">
                    </div>
                </div>
            </div>
            <div class="text-end mt-3">
                <button type="button" class="btn btn-light rounded-pill px-3 me-1" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success rounded-pill px-4">Simpan Jadwal</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="skrip.js"></script>
</body>
</html>