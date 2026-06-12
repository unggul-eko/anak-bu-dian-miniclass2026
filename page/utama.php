<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>PomoStep • Pomodoro & Active Break</title>
    <!-- Bootstrap 5 CSS + Icons + Google Font Inter & Roboto Mono -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Roboto+Mono:wght@700;800&display=swap" rel="stylesheet">
    
    <style>
        html {
            scroll-behavior: smooth;
        }
        body {
            background: linear-gradient(135deg, #e3eedf 0%, #cbdcc3 50%, #b1caa6 100%);
            font-family: 'Inter', system-ui, 'Segoe UI', Roboto, sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
            transition: cursor 0.1s ease;
        }
        
        /* STYLE NAVBAR CAPSULE BUTTONS */
        .nav-pill-custom {
            background: white;
            padding: 0.4rem 1rem;
            border-radius: 50px;
            color: #2c3e2f;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.03);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            white-space: nowrap;
            cursor: pointer;
            border: 1px solid rgba(46, 125, 50, 0.05);
        }
        .nav-pill-custom:hover, .nav-pill-custom.active {
            background: #2e7d32;
            color: white !important;
            box-shadow: 0 8px 15px rgba(46, 125, 50, 0.2);
            transform: translateY(-2px);
        }

        /* HERO LAYOUT WITHOUT DENSE BOX BACKGROUND */
        .hero-clean-wrapper {
            padding: 1rem;
        }
        .hero-tagline {
            background: linear-gradient(90deg, #2e7d32, #4caf50);
            color: white;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.4rem 1.2rem;
            border-radius: 50px;
            display: inline-block;
            margin-bottom: 1.2rem;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            box-shadow: 0 4px 10px rgba(46, 125, 50, 0.15);
        }
        .hero-title {
            font-size: 2.8rem; 
            font-weight: 800;
            line-height: 1.25;
            color: #112a16;
            margin-bottom: 1.2rem;
        }
        .hero-desc {
            font-size: 0.95rem; 
            color: #3e533b;
            line-height: 1.65;
            margin-bottom: 2rem;
            max-width: 520px;
        }
        .btn-hero-action {
            border-radius: 50px;
            padding: 0.75rem 1.8rem;
            font-weight: 700;
            font-size: 0.9rem;
            transition: all 0.25s ease;
            cursor: pointer;
        }
        .btn-hero-action:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 10px 20px rgba(46, 125, 50, 0.15);
        }

        /* INTERACTIVE GLASS CARD */
        .glass-card {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(10px);
            border-radius: 2.5rem;
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 15px 35px rgba(31, 90, 46, 0.05);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        .glass-card:hover {
            transform: translateY(-4px); 
            box-shadow: 0 20px 40px rgba(31, 90, 46, 0.1); 
            border-color: rgba(46, 125, 50, 0.25);
        }
        
        /* TIMER DISPLAY STYLE */
        .timer-digit {
            font-family: 'Roboto Mono', monospace;
            font-size: 4.8rem; 
            font-weight: 800;
            letter-spacing: -1px;
            color: #1f5a2e; 
            display: block;
            line-height: 1;
            text-shadow: 0 4px 10px rgba(46, 125, 50, 0.1);
        }
        .timer-progress-ring {
            height: 8px;
            background: rgba(46, 125, 50, 0.08);
            border-radius: 50px;
            width: 80%;
            margin: 1rem auto 0 auto;
            overflow: hidden;
        }
        .timer-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #2e7d32, #66bb6a);
            width: 0%;
            transition: width 1s linear;
            border-radius: 50px;
        }

        /* 3D WHEEL PICKER CLEAN DESIGN */
        .wheel-container {
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            height: 140px; 
            background: rgba(46, 125, 50, 0.04); 
            border-radius: 2rem;
        }
        .wheel-container.locked {
            opacity: 0.5;
            pointer-events: none;
        }
        .wheel-selection-center {
            position: absolute;
            left: 3%; right: 3%; top: 50px; height: 40px;
            border-radius: 12px;
            background: rgba(46, 125, 50, 0.06);
            pointer-events: none;
            z-index: 1;
            border: 1px solid rgba(46,125,50,0.1);
        }
        .wheel-column {
            flex: 1; height: 100%; overflow-y: scroll; scroll-snap-type: y mandatory; scrollbar-width: none; text-align: center;
        }
        .wheel-column::-webkit-scrollbar { display: none; }
        .wheel-item { height: 40px; line-height: 40px; font-family: 'Roboto Mono', monospace; font-size: 1.2rem; font-weight: 500; color: #a2bca0; scroll-snap-align: center; transition: all 0.2s ease; }
        .wheel-item.selected { color: #1f5a2e; font-weight: 800; font-size: 1.4rem; transform: scale(1.08); }
        .wheel-spacer-top-bottom { height: 50px; pointer-events: none; }
        .wheel-separator-dots { font-size: 1.4rem; font-weight: 800; color: #2e7d32; user-select: none; margin-bottom: 4px; }

        /* BALON KATA PET LINGKARAN FUN */
        .pet-talk-bubble {
            position: relative;
            background: #ffffff;
            border-radius: 1.5rem;
            padding: 0.6rem 1.2rem;
            margin: 0 auto 1.2rem auto;
            max-width: 260px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #1f5a2e;
            box-shadow: 0 6px 15px rgba(0,0,0,0.04);
            border: 1px solid rgba(46,125,50,0.15);
        }
        .pet-talk-bubble::after {
            content: ''; position: absolute; bottom: -8px; left: 50%; transform: translateX(-50%);
            border-width: 8px 8px 0; border-style: solid; border-color: #ffffff transparent; display: block; width: 0;
        }

        /* ULTRA PREMIUM COGNITIVE DASHBOARD CARD */
        .premium-dashboard-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.96) 0%, rgba(224,245,218,0.85) 100%);
            border: 1px solid rgba(46, 125, 50, 0.15);
            border-radius: 2.8rem; 
            box-shadow: 0 15px 35px rgba(46, 125, 50, 0.05);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 100%;
            padding: 2rem !important;
        }
        .bg-star-decoration {
            position: absolute; color: rgba(46, 125, 50, 0.05); font-size: 1.5rem; pointer-events: none;
        }

        .dashboard-center-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            flex-grow: 1;
            margin: 1.2rem 0;
            position: relative;
        }

        /* Lingkaran Progress Target Raksasa */
        .circular-progress-box {
            position: relative;
            width: 155px;
            height: 155px;
            margin: 0 auto;
            filter: drop-shadow(0 6px 12px rgba(46,125,50,0.1));
        }
        .circular-svg { transform: rotate(-90deg); width: 100%; height: 100%; }
        .circular-bg-ring { fill: none; stroke: rgba(46, 125, 50, 0.06); stroke-width: 12; }
        .circular-fill-ring {
            fill: none; stroke: url(#gradientProgressColor); stroke-width: 12; stroke-linecap: round;
            stroke-dasharray: 408.4; stroke-dashoffset: 408.4;
            transition: stroke-dashoffset 1.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .circular-inner-text { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; }
        .circular-percent-num { font-size: 1.9rem; font-weight: 800; color: #1f5a2e; line-height: 1; }
        .circular-percent-lbl { font-size: 0.68rem; font-weight: 700; color: #5d7e5a; text-transform: uppercase; letter-spacing: 1px; margin-top: 3px; }

        /* Tiga Kartu Statistik Kapsul Mengambang */
        .dashboard-bottom-grid {
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.85rem; width: 100%; margin-top: auto;
        }
        .micro-stat-card {
            background: white;
            border-radius: 1.8rem; 
            padding: 0.85rem 0.5rem;
            border: 1px solid rgba(46, 125, 50, 0.08);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.02);
            transition: all 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-align: center;
        }
        .micro-stat-card:hover {
            transform: translateY(-4px) scale(1.03);
            border-color: #2e7d32;
            box-shadow: 0 10px 20px rgba(46, 125, 50, 0.08);
        }
        .micro-stat-num { font-size: 1.45rem; font-weight: 800; color: #1b4d1b; line-height: 1.2; }
        .micro-stat-lbl { font-size: 0.75rem; color: #61775e; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }

        /* TOMBOL KONTROL CAPSULE POP-OUT */
        .btn-control-custom {
            background-color: white; color: #556b53; border: 1px solid rgba(46,125,50,0.2);
            border-radius: 50px; padding: 0.55rem 1.6rem; font-weight: 700; font-size: 0.9rem;
            transition: all 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 4px 10px rgba(0,0,0,0.02);
        }
        .btn-control-custom:hover {
            transform: translateY(-2px); box-shadow: 0 6px 15px rgba(46,125,50,0.1); color: #1f5a2e;
        }
        .btn-status-active { background: linear-gradient(135deg, #2e7d32, #4caf50) !important; border-color: #2e7d32 !important; color: white !important; }
        .btn-status-inactive { background: linear-gradient(135deg, #d32f2f, #f44336) !important; border-color: #d32f2f !important; color: white !important; }

        /* KALENDER LINGKARAN (CIRCULAR CELLS) + PENANDA BINTANG */
        .calendar-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 8px; text-align: center; }
        .calendar-cell {
            position: relative; font-size: 0.85rem; font-weight: 700; width: 38px; height: 38px;
            margin: 0 auto; border-radius: 50% !important; 
            background: rgba(255,255,255,0.5); color: #3b5238; cursor: pointer; transition: all 0.2s ease;
            display: flex; align-items: center; justify-content: center;
        }
        .calendar-cell:hover { background: #c8e6c9; transform: scale(1.1); }
        .calendar-cell.has-event::after {
            content: '🌟'; position: absolute; top: -6px; right: -6px; font-size: 0.7rem; animation: pulseStar 2s infinite;
        }
        .calendar-cell.active-selected { background: #2e7d32 !important; color: white !important; box-shadow: 0 4px 10px rgba(46,125,50,0.3); }

        @keyframes pulseStar {
            0% { transform: scale(1); } 50% { transform: scale(1.2); } 100% { transform: scale(1); }
        }

        /* LIST CARD JADWAL KAPSUL */
        .todo-item-custom {
            background: white; border-radius: 20px; padding: 0.85rem 1.2rem; margin-bottom: 0.65rem;
            border: 1px solid rgba(46, 125, 50, 0.06); box-shadow: 0 4px 8px rgba(0,0,0,0.01); transition: all 0.2s ease;
        }
        .todo-item-custom:hover { transform: translateX(3px); border-color: rgba(46, 125, 50, 0.15); }
        .todo-item-custom.completed { background: #eef5ed; opacity: 0.65; }
        .todo-item-custom.completed .task-title-text { text-decoration: line-through; color: #627c5e; }
        .form-check-input { border-radius: 50% !important; border-color: #2e7d32; width: 1.15rem; height: 1.15rem; cursor: pointer; }
        .form-check-input:checked { background-color: #2e7d32; border-color: #2e7d32; }

        .mode-switch { background: #e4ede2; border-radius: 50px; padding: 0.2rem; }
        .mode-option { border-radius: 50px; padding: 0.4rem 1.2rem; font-weight: 600; font-size: 0.85rem; cursor: pointer; transition: 0.2s; }
        .mode-option.active { background: #2e7d32; color: white; box-shadow: 0 4px 10px rgba(46, 125, 50, 0.15); }

        canvas { background: #FEF3DA; border-radius: 50%; box-shadow: 0 10px 25px rgba(0,0,0,0.12); cursor: pointer; width: 100%; max-width: 160px; aspect-ratio: 1 / 1; display: block; margin: 0 auto; border: 3px solid white; }
        
        /* EMOJI PICKER FLEXIBLE SYSTEM */
        .emoji-picker span { font-size: 1rem; font-weight: 700; cursor: pointer; transition: 0.2s; background: white; border-radius: 50px; padding: 6px 12px; box-shadow: 0 4px 8px rgba(0,0,0,0.04); display: inline-flex; align-items: center; justify-content: center; color: #2e7d32; }
        .emoji-picker span:hover, .emoji-picker span.active-cursor { background: #c8e6c9; transform: scale(1.05); border: 2px solid #2e7d32; }
        
        /* REVISI NOTE INDIKATOR BULAT REALTIME */
        .status-note-box { background: rgba(255, 255, 255, 0.6); border-radius: 50px; font-size: 0.85rem; color: #3b4d38; border: 1px dashed rgba(46, 125, 50, 0.25); font-weight: 600; }
        .badge-dot-real { display: inline-block; width: 11px; height: 11px; border-radius: 50%; margin-right: 4px; vertical-align: middle; }
        .bg-real-running { background-color: #2e7d32; box-shadow: 0 0 8px #4caf50; }
        .bg-real-stopped { background-color: #dc3545; box-shadow: 0 0 8px #ff4d4d; }

        .streak-badge { background: linear-gradient(45deg, #fff1c0, #ffe082); border-radius: 50px; padding: 0.25rem 1.1rem; font-weight: 700; font-size: 0.8rem; border: 1px solid rgba(255,255,255,0.6); color: #795548; }
        .memo-date-header { font-size: 0.85rem; font-weight: 700; color: white; background: #2e7d32; padding: 0.35rem 1rem; border-radius: 50px; margin-top: 0.75rem; display: inline-block; box-shadow: 0 4px 8px rgba(46,125,50,0.1); }
        .memo-log-item { font-size: 0.85rem; background: white; border-left: 4px solid #4caf50; padding: 0.6rem 1rem; margin-top: 0.5rem; margin-left: 0.5rem; border-radius: 0 15px 15px 0; box-shadow: 0 2px 5px rgba(0,0,0,0.02); }
    </style>
</head>
<body>

<div class="container py-4 py-md-5" id="top-dashboard-anchor">
    <!-- NAVBAR NAVIGATION -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-5 pb-2 border-bottom border-success border-opacity-25">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-lightning-charge-fill text-success fs-2"></i>
            <h1 class="display-6 fw-bold" style="background: linear-gradient(135deg,#1b4d1b,#3c8c40); -webkit-background-clip:text; background-clip:text; color:transparent;">PomoStep</h1>
        </div>
        <div class="d-flex align-items-center flex-wrap gap-2" id="navCapsulesGroup">
            <span class="nav-pill-custom active" data-target="top-dashboard-anchor"><i class="bi bi-house-door"></i> Dashboard</span>
            <span class="nav-pill-custom" data-target="timer-section"><i class="bi bi-stopwatch"></i> Timer</span>
            <span class="nav-pill-custom" data-target="tugas-section"><i class="bi bi-calendar-event"></i> Jadwal &amp; Tugas</span>
            <span class="nav-pill-custom" data-target="memo-section"><i class="bi bi-journal-text"></i> Memo</span>
            <span class="nav-pill-custom" data-target="statistik-section"><i class="bi bi-graph-up"></i> Statistik</span>
            <span class="nav-pill-custom" id="resetDataBtn"><i class="bi bi-arrow-repeat"></i> Pengaturan</span>
        </div>
    </div>

    <!-- TOP SECTION -->
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
                    <span data-animal="normal" class="shadow-sm" title="Normal Laptop">💻 Normal</span>
                    <span data-animal="frog" class="shadow-sm active-cursor" title="Katak">🐸 Katak</span>
                    <span data-animal="cat" class="shadow-sm" title="Kucing">🐱 Kucing</span>
                    <span data-animal="dog" class="shadow-sm" title="Anjing">🐶 Anjing</span>
                    <span data-animal="rabbit" class="shadow-sm" title="Kelinci">🐰 Kelinci</span>
                    <span data-animal="butterfly" class="shadow-sm" title="Kupu-Kupu">🦋 Kupu</span>
                    <span data-animal="panda" class="shadow-sm" title="Panda">🐼 Panda</span>
                </div>
            </div>
        </div>
    </div>

    <!-- MIDDLE SECTION: TIMER KONTROL DAN SESI PRODUKTIF PREMIUM INTERAKTIF -->
    <div class="row g-4 mb-5" id="timer-section">
        <!-- Pengendali Timer (Kiri) -->
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

                <!-- REVISI INDIKATOR BULAT WARNA REALTIME -->
                <div class="p-2 mx-auto status-note-box text-center" style="max-width: 380px;">
                    <span class="me-3"><span class="badge-dot-real bg-real-running"></span> Running</span>
                    <span><span class="badge-dot-real bg-real-stopped"></span> Stopped</span>
                </div>
            </div>
        </div>

        <!-- SESI PRODUKTIF RINGKASAN -->
        <div class="col-lg-6">
            <div class="premium-dashboard-card">
                <i class="bi bi-star-fill bg-star-decoration" style="top: 20%; left: 15%; opacity: 0.3;"></i>
                <i class="bi bi-star-fill bg-star-decoration" style="top: 60%; right: 12%; opacity: 0.4; font-size: 1rem;"></i>
                <i class="bi bi-sparkles bg-star-decoration" style="top: 30%; right: 20%; opacity: 0.3;"></i>

                <div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="fw-bold m-0 text-success"><i class="bi bi-moon-stars-fill me-2"></i>Sesi Produktif Hari Ini</h5>
                        <span class="streak-badge shadow-sm"><i class="bi bi-fire text-danger animate-bounce"></i> STREAK <span id="dashWeeklyStreak">0</span> HARI</span>
                    </div>
                    <div class="small text-muted text-start">
                        <i class="bi bi-check-circle-fill text-success me-1"></i> Sesi lengkap ke- <span id="dashTotalSessionsToday" class="fw-bold text-dark">0</span> hari ini. Keep it up!
                    </div>
                </div>
                
                <div class="dashboard-center-content">
                    <div class="circular-progress-box">
                        <svg class="circular-svg">
                            <defs>
                                <linearGradient id="gradientProgressColor" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#1b5e20" />
                                    <stop offset="100%" stop-color="#4caf50" />
                                </linearGradient>
                            </defs>
                            <circle class="circular-bg-ring" cx="75" cy="75" r="65" />
                            <circle class="circular-fill-ring" id="dashCircularProgressRing" cx="75" cy="75" r="65" />
                        </svg>
                        <div class="circular-inner-text">
                            <div class="circular-percent-num" id="dashProgressPercentText">0%</div>
                            <div class="circular-percent-lbl">Target</div>
                        </div>
                    </div>
                </div>

                <div class="dashboard-bottom-grid">
                    <div class="micro-stat-card">
                        <div class="small text-warning"><i class="bi bi-star-fill"></i></div>
                        <div class="micro-stat-num" id="dashActiveBreakCount">0</div>
                        <div class="micro-stat-lbl">Break</div>
                    </div>
                    <div class="micro-stat-card" style="background: linear-gradient(180deg, #ffffff 0%, #f1f9f0 100%); border-color: rgba(46, 125, 50, 0.2);">
                        <div class="small text-primary"><i class="bi bi-stopwatch-fill"></i></div>
                        <div class="micro-stat-num" id="dashFocusMinutes">0</div>
                        <div class="micro-stat-lbl">Menit</div>
                    </div>
                    <div class="micro-stat-card">
                        <div class="small text-success"><i class="bi bi-trophy-fill"></i></div>
                        <div class="micro-stat-num" id="dashTasksRatio">0/0</div>
                        <div class="micro-stat-lbl">Tugas</div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- LOWER SECTION -->
    <div class="row g-4 mb-5" id="tugas-section">
        <div class="col-lg-6">
            <div class="glass-card p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-bold m-0 text-success"><i class="bi bi-calendar3"></i> Kalender Aktivitas Kuliah</h6>
                    <span class="calendar-header-title fw-bold text-success" id="calendarMonthYearTitle">Juni 2026</span>
                </div>
                <p class="text-muted small mb-3" style="font-size:0.75rem;"><i class="bi bi-info-circle"></i> Tanggal ber-bintang <span class="text-warning fw-bold">🌟</span> memiliki jadwal tugas / kuliah aktif.</p>
                
                <div class="calendar-grid" id="calendarDaysContainer">
                    <div class="calendar-day-label small fw-bold text-muted">Min</div>
                    <div class="calendar-day-label small fw-bold text-muted">Sen</div>
                    <div class="calendar-day-label small fw-bold text-muted">Sel</div>
                    <div class="calendar-day-label small fw-bold text-muted">Rab</div>
                    <div class="calendar-day-label small fw-bold text-muted">Kam</div>
                    <div class="calendar-day-label small fw-bold text-muted">Jum</div>
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

    <!-- MEMO LOG AREA SECTION -->
    <div class="row g-4 mb-5" id="memo-section">
        <div class="col-12">
            <div class="glass-card p-4">
                <div class="fw-bold small text-success mb-2 fs-5"><i class="bi bi-journal-text"></i> Memo Riwayat Ringkasan Fokus</div>
                <div id="memoLogArea" style="max-height: 250px; overflow-y: auto; padding-right: 5px;">
                    <div class="small text-muted italic text-center py-3">Belum ada rekaman fokus.</div>
                </div>
            </div>
        </div>
    </div>

    <!-- BOTTOM SECTION: STATISTIK TARGET -->
    <div class="pt-4 border-top border-success border-opacity-25" id="statistik-section">
        <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
            <h5 class="fw-bold text-success m-0"><i class="bi bi-graph-up-arrow"></i> Target &amp; Capaian Produktivitas ActiveFlow</h5>
        </div>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="glass-card p-4 h-100" style="border-radius: 2rem;">
                    <h5 class="fw-bold mb-3 text-success"><i class="bi bi-card-checklist"></i> Target Harian</h5>
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom border-light">
                        <span class="text-secondary"><i class="bi bi-hourglass"></i> Menit fokus</span>
                        <span class="fw-bold"><span id="targetMenitFokus">0</span> / 60 menit</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom border-light">
                        <span class="text-secondary"><i class="bi bi-check2-square"></i> Tugas selesai</span>
                        <span class="fw-bold"><span id="targetTugasSelesai">0</span> / 3 tugas</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center py-2">
                        <span class="text-secondary"><i class="bi bi-calendar3"></i> Sesi fokus hari ini</span>
                        <span class="fw-bold" id="targetSesiHariIni">0</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="glass-card p-4 h-100" style="border-radius: 2rem;">
                    <h5 class="fw-bold mb-3 text-success"><i class="bi bi-trophy"></i> Capaian Produktivitas</h5>
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom border-light">
                        <span class="text-secondary">Rata-rata menit / sesi</span>
                        <span class="fw-bold" id="capaianRataRata">0</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center py-2 mb-3">
                        <span class="text-secondary">Total sesi fokus lengkap</span>
                        <span class="fw-bold" id="capaianTotalSesi">0</span>
                    </div>
                    <div class="alert alert-success py-2 px-3 m-0 small border-0" style="border-radius: 1rem; background: #e8f5e9; color: #2e7d32;">
                        <i class="bi bi-lightbulb-fill text-warning me-1"></i> Semakin konsisten, streak-mu akan meningkat!
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL FORM TAMBAH JADWAL -->
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
                <input type="text" class="form-control" id="formTaskSubject" placeholder="Contoh: pw" required style="border-radius:12px;">
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

<script>
    const petQuotes = {
        focus: ["Fokus ya! Jangan buka sosmed dulu! 🤫", "Wah kamu keren banget, lanjutin! 🔥", "Aku mengawasimu belajar, semangat! 🎯"],
        break: ["Waktunya peregangan otot dulu! ☕", "Minum air putih dulu sana! 🚰"],
        alarm: ["Hei! Waktunya jadwal Zoom / kegiatan kuliah dimulai tuh! ⏰"]
    };

    function updatePetSpeech(type) {
        const bubble = document.getElementById('petBubbleChat');
        const quotes = petQuotes[type];
        bubble.innerText = quotes[Math.floor(Math.random() * quotes.length)];
    }

    const animalCursors = {
        frog: "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='32' height='32' style='font-size:24px'><text y='24'>🐸</text></svg>",
        cat: "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='32' height='32' style='font-size:24px'><text y='24'>🐱</text></svg>",
        dog: "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='32' height='32' style='font-size:24px'><text y='24'>🐶</text></svg>",
        rabbit: "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='32' height='32' style='font-size:24px'><text y='24'>🐰</text></svg>",
        butterfly: "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='32' height='32' style='font-size:24px'><text y='24'>🦋</text></svg>",
        panda: "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='32' height='32' style='font-size:24px'><text y='24'>🐼</text></svg>"
    };

    const canvas = document.getElementById('petCanvas'); const ctx = canvas.getContext('2d');
    let currentAnimal = 'frog'; let targetX = 90, targetY = 90;
    
    document.addEventListener('mousemove', (e) => {
        const rect = canvas.getBoundingClientRect();
        targetX = (e.clientX - rect.left) * (canvas.width / rect.width);
        targetY = (e.clientY - rect.top) * (canvas.height / rect.height);
        drawPet();
    });

    function drawEye(centerX, centerY, eyeRadius, pupilRadius, mx, my, isPanda=false) {
        if(isPanda) {
            ctx.beginPath(); ctx.arc(centerX, centerY, eyeRadius + 5, 0, 2 * Math.PI);
            ctx.fillStyle = "#2c2c2c"; ctx.fill();
        }
        ctx.beginPath(); ctx.arc(centerX, centerY, eyeRadius, 0, 2 * Math.PI);
        ctx.fillStyle = "#FFFFFF"; ctx.fill(); ctx.strokeStyle = "#2c3e2f"; ctx.lineWidth = 1.5; ctx.stroke();
        let dx = mx - centerX; let dy = my - centerY; let angle = Math.atan2(dy, dx);
        let distance = Math.min(eyeRadius - pupilRadius - 1.5, Math.hypot(dx, dy) * 0.15);
        ctx.beginPath(); ctx.arc(centerX + Math.cos(angle)*distance, centerY + Math.sin(angle)*distance, pupilRadius, 0, 2 * Math.PI);
        ctx.fillStyle = isPanda ? "#000000" : "#1f2e1c"; ctx.fill();
    }
    
    function drawFrog(mx, my) {
        ctx.fillStyle = "#6B8E23"; ctx.beginPath(); ctx.ellipse(90, 100, 52, 45, 0, 0, Math.PI*2); ctx.fill();
        ctx.fillStyle = "#556B2F"; ctx.beginPath(); ctx.ellipse(90, 112, 38, 28, 0, 0, Math.PI*2); ctx.fill();
        drawEye(66, 68, 15, 6, mx, my); drawEye(114, 68, 15, 6, mx, my);
        ctx.beginPath(); ctx.arc(90, 95, 18, 0.1, Math.PI - 0.1); ctx.strokeStyle = "#3A2A1A"; ctx.lineWidth = 2; ctx.stroke();
    }
    function drawCat(mx, my) {
        ctx.fillStyle = "#F4A261"; ctx.beginPath(); ctx.ellipse(90, 100, 48, 45, 0, 0, Math.PI*2); ctx.fill();
        ctx.fillStyle = "#E76F51"; ctx.beginPath(); ctx.moveTo(52, 62); ctx.lineTo(66, 35); ctx.lineTo(80, 62); ctx.fill();
        ctx.beginPath(); ctx.moveTo(128, 62); ctx.lineTo(114, 35); ctx.lineTo(100, 62); ctx.fill();
        drawEye(63, 73, 14, 5, mx, my); drawEye(117, 73, 14, 5, mx, my);
        ctx.fillStyle = "#D95B43"; ctx.beginPath(); ctx.arc(90, 88, 4, 0, 2*Math.PI); ctx.fill();
    }
    function drawDog(mx, my) {
        ctx.fillStyle = "#D4A373"; ctx.beginPath(); ctx.ellipse(90, 100, 50, 45, 0, 0, Math.PI*2); ctx.fill();
        ctx.fillStyle = "#B97F44"; ctx.beginPath(); ctx.ellipse(90, 114, 34, 26, 0, 0, Math.PI*2); ctx.fill();
        drawEye(66, 78, 13, 5, mx, my); drawEye(114, 78, 13, 5, mx, my);
        ctx.fillStyle = "#6B3E1C"; ctx.beginPath(); ctx.arc(90, 94, 6, 0, 2*Math.PI); ctx.fill();
    }
    function drawRabbit(mx, my) {
        ctx.fillStyle = "#Eaeaea"; ctx.beginPath(); ctx.ellipse(55, 45, 12, 35, -0.1, 0, Math.PI*2); ctx.fill();
        ctx.fillStyle = "#Ffced6"; ctx.beginPath(); ctx.ellipse(55, 48, 6, 25, -0.1, 0, Math.PI*2); ctx.fill();
        ctx.fillStyle = "#Eaeaea"; ctx.beginPath(); ctx.ellipse(125, 45, 12, 35, 0.1, 0, Math.PI*2); ctx.fill();
        ctx.fillStyle = "#Ffced6"; ctx.beginPath(); ctx.ellipse(125, 48, 6, 25, 0.1, 0, Math.PI*2); ctx.fill();
        ctx.fillStyle = "#F7F7F7"; ctx.beginPath(); ctx.ellipse(90, 105, 46, 42, 0, 0, Math.PI*2); ctx.fill();
        drawEye(68, 85, 11, 4, mx, my); drawEye(112, 85, 11, 4, mx, my);
        ctx.fillStyle = "#Ffa4b4"; ctx.beginPath(); ctx.moveTo(86, 96); ctx.lineTo(94, 96); ctx.lineTo(90, 100); ctx.fill();
    }
    function drawButterfly(mx, my) {
        ctx.fillStyle = "#81d4fa"; ctx.beginPath(); ctx.ellipse(45, 100, 32, 24, -0.3, 0, Math.PI*2); ctx.fill();
        ctx.beginPath(); ctx.ellipse(40, 122, 22, 16, 0.2, 0, Math.PI*2); ctx.fill();
        ctx.fillStyle = "#81d4fa"; ctx.beginPath(); ctx.ellipse(135, 100, 32, 24, 0.3, 0, Math.PI*2); ctx.fill();
        ctx.beginPath(); ctx.ellipse(140, 122, 22, 16, -0.2, 0, Math.PI*2); ctx.fill();
        ctx.fillStyle = "#5d4037"; ctx.beginPath(); ctx.ellipse(90, 105, 14, 40, 0, 0, Math.PI*2); ctx.fill();
        drawEye(82, 82, 7, 3, mx, my); drawEye(98, 82, 7, 3, mx, my);
    }
    function drawPanda(mx, my) {
        ctx.fillStyle = "#2c2c2c"; ctx.beginPath(); ctx.arc(52, 60, 18, 0, Math.PI*2); ctx.fill();
        ctx.beginPath(); ctx.arc(128, 60, 18, 0, Math.PI*2); ctx.fill();
        ctx.fillStyle = "#FFFFFF"; ctx.beginPath(); ctx.ellipse(90, 105, 50, 44, 0, 0, Math.PI*2); ctx.fill();
        drawEye(68, 88, 10, 4, mx, my, true); drawEye(112, 88, 10, 4, mx, my, true);
        ctx.fillStyle = "#2c2c2c"; ctx.beginPath(); ctx.ellipse(90, 102, 7, 4, 0, 0, Math.PI*2); ctx.fill();
    }
    
    function drawPet() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        if (currentAnimal === 'frog') drawFrog(targetX, targetY);
        else if (currentAnimal === 'cat') drawCat(targetX, targetY);
        else if (currentAnimal === 'dog') drawDog(targetX, targetY);
        else if (currentAnimal === 'rabbit') drawRabbit(targetX, targetY);
        else if (currentAnimal === 'butterfly') drawButterfly(targetX, targetY);
        else if (currentAnimal === 'panda') drawPanda(targetX, targetY);
    }
    
    document.querySelectorAll('.emoji-picker span').forEach(btn => {
        btn.addEventListener('click', () => { 
            document.querySelectorAll('.emoji-picker span').forEach(s => s.classList.remove('active-cursor'));
            btn.classList.add('active-cursor');
            
            const selectedType = btn.getAttribute('data-animal');
            if (selectedType === 'normal') {
                document.body.style.cursor = 'auto';
                document.getElementById('petBubbleChat').innerText = `Kursor kamu kembali normal! Tapi aku tetap menemanimu di sini. 💻`;
            } else {
                currentAnimal = selectedType;
                document.getElementById('petBubbleChat').innerText = `Kursor kamu berubah! Sekarang aku jadi ${currentAnimal}! 🐾`;
                const svgData = animalCursors[currentAnimal];
                document.body.style.cursor = `url("${svgData}") 4 4, auto`;
            }
            drawPet(); 
        });
    });

    // SISTEM PENGHASIL SUARA NATIVE (WEB AUDIO API BEEP TICKER)
    function playBuzzerNotification() {
        try {
            const AudioContext = window.AudioContext || window.webkitAudioContext;
            if (!AudioContext) return;
            const audioCtx = new AudioContext();
            
            // Pola bunyi "tit tit tit" sebanyak 3 kali berturut-turut
            let patternTimes = [0, 0.2, 0.4];
            patternTimes.forEach((delay) => {
                let osc = audioCtx.createOscillator();
                let gainNode = audioCtx.createGain();
                
                osc.type = 'sine';
                osc.frequency.setValueAtTime(880, audioCtx.currentTime + delay); // Frekuensi nada tinggi (880Hz)
                
                gainNode.gain.setValueAtTime(0.2, audioCtx.currentTime + delay);
                gainNode.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + delay + 0.12);
                
                osc.connect(gainNode);
                gainNode.connect(audioCtx.destination);
                
                osc.start(audioCtx.currentTime + delay);
                osc.stop(audioCtx.currentTime + delay + 0.15);
            });
        } catch (e) {
            console.log("AudioContext blocked/not supported by user guest gesture yet.");
        }
    }

    // ENGINE TIMER & DATA STORAGE
    let timerInterval = null; let isRunning = false; let isPaused = false; let currentMode = "focus";
    let userFocusSeconds = 0; let userBreakSeconds = 0; 
    let currentSeconds = 0; let totalDurationInMode = 0;
    let lockedHour = 0, lockedMin = 0, lockedSec = 0;

    let stats = { activeBreakCompleted: 0, focusMinutesTotal: 0, weeklyStreak: 0, lastStreakDate: null, totalFocusSessionsToday: 0, memos: [] };
    let tasks = [];

    const todayObj = new Date();
    let selectedFilterDate = `${todayObj.getFullYear()}-${(todayObj.getMonth()+1).toString().padStart(2,'0')}-${todayObj.getDate().toString().padStart(2,'0')}`;

    function build3DWheelPicker() {
        setupWheelColumn('wheelHours', 23); setupWheelColumn('wheelMinutes', 59); setupWheelColumn('wheelSeconds', 59);
        setupWheelScrollListener('wheelHours'); setupWheelScrollListener('wheelMinutes'); setupWheelScrollListener('wheelSeconds');
        
        setTimeout(() => {
            setWheelActiveValue('wheelHours', 0);
            setWheelActiveValue('wheelMinutes', 0);
            setWheelActiveValue('wheelSeconds', 0);
            calculateTotalSecondsFromWheels();
        }, 100);
    }

    function setupWheelColumn(columnId, maxVal) {
        const col = document.getElementById(columnId); const endSpacer = col.lastElementChild;
        for (let i = 0; i <= maxVal; i++) {
            const item = document.createElement('div'); item.className = 'wheel-item';
            item.setAttribute('data-val', i); item.innerText = i.toString().padStart(2, '0');
            
            item.addEventListener('click', () => {
                if (!isRunning && !isPaused) {
                    setWheelActiveValue(columnId, i);
                    calculateTotalSecondsFromWheels();
                }
            });
            col.insertBefore(item, endSpacer);
        }
    }

    function setupWheelScrollListener(columnId) {
        const col = document.getElementById(columnId);
        col.addEventListener('scroll', () => {
            if (isRunning || isPaused) {
                if (columnId === 'wheelHours') setWheelActiveValue('wheelHours', lockedHour);
                if (columnId === 'wheelMinutes') setWheelActiveValue('wheelMinutes', lockedMin);
                if (columnId === 'wheelSeconds') setWheelActiveValue('wheelSeconds', lockedSec);
                return;
            }
            const items = col.querySelectorAll('.wheel-item');
            let centerItem = null; let minDistance = Infinity;
            items.forEach(item => {
                const rect = item.getBoundingClientRect(); const containerRect = col.getBoundingClientRect();
                const dist = Math.abs((containerRect.top + containerRect.height/2) - (rect.top + rect.height/2));
                item.classList.remove('selected'); if (dist < minDistance) { minDistance = dist; centerItem = item; }
            });
            if (centerItem) { centerItem.classList.add('selected'); calculateTotalSecondsFromWheels(); }
        });
    }

    function setWheelActiveValue(columnId, val) {
        const col = document.getElementById(columnId); const targetItem = col.querySelector(`.wheel-item[data-val="${val}"]`);
        if (targetItem) { col.scrollTop = targetItem.offsetTop - 50; targetItem.classList.add('selected'); }
    }

    function calculateTotalSecondsFromWheels() {
        if (isRunning || isPaused) return;
        const activeHour = document.querySelector('#wheelHours .wheel-item.selected');
        const activeMin = document.querySelector('#wheelMinutes .wheel-item.selected');
        const activeSec = document.querySelector('#wheelSeconds .wheel-item.selected');
        if (activeHour && activeMin && activeSec) {
            let total = (parseInt(activeHour.getAttribute('data-val')) * 3600) + (parseInt(activeMin.getAttribute('data-val')) * 60) + parseInt(activeSec.getAttribute('data-val'));
            if (currentMode === "focus") userFocusSeconds = total; else userBreakSeconds = total;
            currentSeconds = total; totalDurationInMode = total; updateTimerDisplay();
        }
    }

    function loadStorageData() {
        const savedStats = localStorage.getItem('pomostep_stats');
        if (savedStats) { try { stats = { ...stats, ...JSON.parse(savedStats) }; } catch(e) {} }
        const savedTasks = localStorage.getItem('pomostep_tasks');
        if (savedTasks) { try { tasks = JSON.parse(savedTasks); } catch(e) {} }
        
        const d = new Date(selectedFilterDate);
        renderCalendar(d.getFullYear(), d.getMonth());
        renderTasks(); updateStatsUI(); renderMemos();
    }

    function saveData() {
        localStorage.setItem('pomostep_stats', JSON.stringify(stats));
        localStorage.setItem('pomostep_tasks', JSON.stringify(tasks));
        updateStatsUI();
        const d = new Date(selectedFilterDate);
        renderCalendar(d.getFullYear(), d.getMonth());
    }

    document.getElementById('modalTaskForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const text = document.getElementById('formTaskText').value.trim();
        const subject = document.getElementById('formTaskSubject').value.trim();
        const date = document.getElementById('formTaskDate').value;
        const time = document.getElementById('formTaskTime').value;

        if (text && subject && date && time) {
            tasks.push({ text, subject, date, time, completed: false, alarmed: false });
            selectedFilterDate = date; 
            saveData(); renderTasks();
            bootstrap.Modal.getInstance(document.getElementById('addTaskModal')).hide();
            document.getElementById('modalTaskForm').reset();
        }
    });

    // REALTIME ALARM + BUNYI SUARA PERINGATAN KULIAH
    setInterval(function checkAlarmTicker() {
        const now = new Date();
        const todayStr = `${now.getFullYear()}-${(now.getMonth()+1).toString().padStart(2,'0')}-${now.getDate().toString().padStart(2,'0')}`;
        const currentHrsMins = `${now.getHours().toString().padStart(2,'0')}:${now.getMinutes().toString().padStart(2,'0')}`;
        tasks.forEach(task => {
            if (task.date === todayStr && task.time === currentHrsMins && !task.alarmed && !task.completed) {
                task.alarmed = true; saveData();
                playBuzzerNotification(); // Bunyi alarm tit tit tit kegiatan kuliah
                document.getElementById('liveAlarmAlertBanner').classList.remove('d-none');
                document.getElementById('alarmAlertMessage').innerText = `[ALARM KULIAH] ${task.subject.toUpperCase()} - ${task.text}`;
                document.getElementById('timer-section').scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    }, 1000);
    function dismissLiveAlarm() { document.getElementById('liveAlarmAlertBanner').classList.add('d-none'); }

    const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    function renderCalendar(year, month) {
        document.getElementById('calendarMonthYearTitle').innerText = `${monthNames[month]} ${year}`;
        const container = document.getElementById('calendarDaysContainer');
        const labels = container.querySelectorAll('.calendar-day-label');
        container.innerHTML = ""; labels.forEach(l => container.appendChild(l));

        const numDays = new Date(year, month + 1, 0).getDate();
        const startDayIdx = new Date(year, month, 1).getDay();

        for (let i = 0; i < startDayIdx; i++) { container.appendChild(document.createElement('div')); }

        for (let day = 1; day <= numDays; day++) {
            const cell = document.createElement('div'); cell.className = "calendar-cell"; cell.innerText = day;
            const loopDateStr = `${year}-${(month + 1).toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;

            if (tasks.some(t => t.date === loopDateStr && !t.completed)) { cell.classList.add('has-event'); }
            if (selectedFilterDate === loopDateStr) { cell.classList.add('active-selected'); }

            cell.addEventListener('click', () => {
                selectedFilterDate = loopDateStr;
                document.querySelectorAll('.calendar-cell').forEach(c => c.classList.remove('active-selected'));
                cell.classList.add('active-selected');
                renderTasks(); 
            });
            container.appendChild(cell);
        }
    }

    function renderTasks() {
        const todoList = document.getElementById('todoList'); todoList.innerHTML = "";
        const filtered = tasks.filter(t => t.date === selectedFilterDate);

        if (filtered.length === 0) {
            todoList.innerHTML = `<div class="text-center py-4 text-muted small"><i class="bi bi-calendar-x d-block fs-4 mb-1"></i> Tidak ada kegiatan pada tanggal ini.</div>`;
            return;
        }

        filtered.forEach((task) => {
            const globalIndex = tasks.findIndex(t => t.text === task.text && t.date === task.date && t.time === task.time);
            const card = document.createElement('div');
            card.className = `todo-item-custom ${task.completed ? 'completed' : ''} d-flex align-items-start gap-2`;
            card.innerHTML = `
                <input class="form-check-input mt-1 flex-shrink-0" type="checkbox" data-index="${globalIndex}" ${task.completed ? 'checked' : ''}>
                <div class="flex-grow-1 min-w-0 text-start">
                    <div class="fw-bold text-dark small task-title-text text-truncate">${task.text}</div>
                    <div class="text-muted text-truncate" style="font-size:0.75rem; font-weight:500;">${task.subject}</div>
                    <div class="d-flex gap-1 flex-wrap mt-1">
                        <span class="badge bg-light text-success rounded-pill p-1 px-2" style="font-size: 0.68rem;"><i class="bi bi-calendar"></i> ${task.date}</span>
                        <span class="badge bg-light text-warning rounded-pill p-1 px-2" style="font-size: 0.68rem;"><i class="bi bi-bell"></i> ${task.time}</span>
                    </div>
                </div>
                <i class="bi bi-trash text-danger btn-delete-task flex-shrink-0 ms-1 align-self-center" style="cursor:pointer;" data-index="${globalIndex}"></i>
            `;
            todoList.appendChild(card);
        });

        document.querySelectorAll('.todo-item-custom input[type="checkbox"]').forEach(cb => {
            cb.addEventListener('change', (e) => {
                tasks[parseInt(e.target.getAttribute('data-index'))].completed = e.target.checked; saveData(); renderTasks();
            });
        });
        document.querySelectorAll('.btn-delete-task').forEach(btn => {
            btn.addEventListener('click', (e) => {
                tasks.splice(parseInt(e.target.getAttribute('data-index')), 1); saveData(); renderTasks();
            });
        });
    }

    function verifyStreakLogic() {
        const todayStr = new Date().toDateString();
        if (stats.lastStreakDate) {
            const diffDays = Math.floor(Math.abs(new Date(todayStr) - new Date(stats.lastStreakDate)) / (1000 * 60 * 60 * 24));
            if (diffDays > 1) { stats.weeklyStreak = 0; localStorage.setItem('pomostep_stats', JSON.stringify(stats)); }
        }
    }
    function triggerStreakIncrement() {
        const todayStr = new Date().toDateString(); if (stats.lastStreakDate !== todayStr) { stats.weeklyStreak += 1; stats.lastStreakDate = todayStr; }
    }
    
    function updateStatsUI() {
        let totalCount = tasks.length;
        let completedCount = tasks.filter(t => t.completed).length;

        document.getElementById('dashActiveBreakCount').innerText = stats.activeBreakCompleted;
        document.getElementById('dashFocusMinutes').innerText = stats.focusMinutesTotal;
        document.getElementById('dashWeeklyStreak').innerText = stats.weeklyStreak;
        document.getElementById('dashTotalSessionsToday').innerText = stats.totalFocusSessionsToday;
        document.getElementById('dashTasksRatio').innerText = `${completedCount}/${totalCount}`;
        
        let percent = Math.min(100, Math.round((stats.focusMinutesTotal / 60) * 100));
        document.getElementById('dashProgressPercentText').innerText = percent + "%";
        
        let ringDashOffset = 408.4 - (408.4 * percent / 100);
        document.getElementById('dashCircularProgressRing').style.strokeDashoffset = ringDashOffset;
        
        document.getElementById('targetMenitFokus').innerText = stats.focusMinutesTotal;
        document.getElementById('targetTugasSelesai').innerText = completedCount;
        document.getElementById('targetSesiHariIni').innerText = stats.totalFocusSessionsToday;
        document.getElementById('capaianTotalSesi').innerText = stats.totalFocusSessionsToday;
        document.getElementById('capaianRataRata').innerText = (stats.totalFocusSessionsToday > 0 ? Math.round(stats.focusMinutesTotal / stats.totalFocusSessionsToday) : 0) + " m/sesi";
    }

    function renderMemos() {
        const area = document.getElementById('memoLogArea');
        if(!stats.memos || stats.memos.length === 0) { area.innerHTML = `<div class="small text-muted italic text-center py-3">Belum ada rekaman fokus.</div>`; return; }
        const groupedMemos = {};
        stats.memos.forEach(memo => {
            if (!groupedMemos[memo.dateLabel]) { groupedMemos[memo.dateLabel] = []; }
            groupedMemos[memo.dateLabel].push(memo);
        });
        let htmlContent = "";
        for (const dateLabel in groupedMemos) {
            htmlContent += `<div class="memo-date-header"><i class="bi bi-calendar-check me-1"></i> ${dateLabel}</div>`;
            groupedMemos[dateLabel].forEach(m => { htmlContent += `<div class="memo-log-item"><b>[${m.time}]</b> ${m.text}</div>`; });
        }
        area.innerHTML = htmlContent;
    }

    function createFocusMemo() {
        setTimeout(() => {
            const textMemo = prompt("Sesi fokus selesai! Tulis memo singkat:");
            const validText = (textMemo && textMemo.trim() !== "") ? textMemo.trim() : "Menyelesaikan fokus kustom wheel-scroll.";
            const daysNameId = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
            const monthsNameId = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
            const now = new Date();
            const formatDayLabel = `${daysNameId[now.getDay()]}, ${now.getDate()} ${monthsNameId[now.getMonth()]} ${now.getFullYear()}`;
            const formatTimeClock = now.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});

            if(!stats.memos) stats.memos = [];
            stats.memos.unshift({ dateLabel: formatDayLabel, time: formatTimeClock, text: validText });
            if(stats.memos.length > 20) stats.memos.pop(); saveData(); renderMemos();
        }, 600);
    }

    function setButtonVisualState(activeBtnId) {
        const btnStart = document.getElementById('startTimerBtn'); const btnPause = document.getElementById('pauseTimerBtn'); const btnReset = document.getElementById('resetTimerBtn');
        [btnStart, btnPause, btnReset].forEach(btn => btn.classList.remove('btn-status-active', 'btn-status-inactive'));
        if (activeBtnId === 'reset') return;
        if (activeBtnId === 'start') { btnStart.classList.add('btn-status-active'); btnPause.classList.add('btn-status-inactive'); btnReset.classList.add('btn-status-inactive'); }
        else if (activeBtnId === 'pause') { btnPause.classList.add('btn-status-active'); btnStart.classList.add('btn-status-inactive'); btnReset.classList.add('btn-status-inactive'); }
    }

    function updateTimerDisplay() {
        let hrs = Math.floor(currentSeconds / 3600); let mins = Math.floor((currentSeconds % 3600) / 60); let secs = currentSeconds % 60;
        document.getElementById('timerDisplay').innerText = `${hrs.toString().padStart(2,'0')}:${mins.toString().padStart(2,'0')}:${secs.toString().padStart(2,'0')}`;
        document.getElementById('timerRingBar').style.width = (totalDurationInMode > 0 ? (currentSeconds / totalDurationInMode) * 100 : 0) + "%";
    }
    function stopTimer() { if(timerInterval) { clearInterval(timerInterval); timerInterval = null; } isRunning = false; isPaused = true; document.getElementById('globalWheelWrapper').classList.add('locked'); setButtonVisualState('pause'); }
    function startTimer() {
        if (currentSeconds <= 0) { alert("Silakan gulir Jam, Menit, atau Detik pada roda pengendali terlebih dahulu!"); return; }
        if (isRunning) return;
        if(!isPaused) {
            const activeHour = document.querySelector('#wheelHours .wheel-item.selected'); const activeMin = document.querySelector('#wheelMinutes .wheel-item.selected'); const activeSec = document.querySelector('#wheelSeconds .wheel-item.selected');
            lockedHour = activeHour ? parseInt(activeHour.getAttribute('data-val')) : 0; lockedMin = activeMin ? parseInt(activeMin.getAttribute('data-val')) : 0; lockedSec = activeSec ? parseInt(activeSec.getAttribute('data-val')) : 0;
        }
        isRunning = true; isPaused = false; document.getElementById('globalWheelWrapper').classList.add('locked'); setButtonVisualState('start');
        timerInterval = setInterval(() => {
            if (currentSeconds <= 0) {
                clearTimeout(timerInterval); timerInterval = null; isRunning = false; isPaused = false;
                document.getElementById('globalWheelWrapper').classList.remove('locked'); setButtonVisualState('reset');
                
                playBuzzerNotification(); // Bunyi alarm tit tit tit saat waktu habis
                
                if (currentMode === "focus") { stats.focusMinutesTotal += Math.max(1, Math.round(totalDurationInMode / 60)); stats.totalFocusSessionsToday += 1; triggerStreakIncrement(); saveData(); alert("✅ Sesi fokus selesai! Waktunya active break!"); createFocusMemo(); setMode("break"); }
                else { stats.activeBreakCompleted += 1; saveData(); alert("🎉 Break selesai! Saatnya kembali fokus!"); setMode("focus"); }
                return;
            }
            currentSeconds--; updateTimerDisplay();
        }, 1000);
    }
    function setMode(mode) {
        currentMode = mode; document.getElementById('timerModeText').innerText = mode === "focus" ? "Fokus Dimulai" : "Waktunya Istirahat";
        document.getElementById('timerModeText').className = mode === "focus" ? "small fw-bold text-uppercase text-success" : "small fw-bold text-uppercase text-warning";
        document.getElementById('focusModeBtn').classList.toggle('active', mode === "focus"); document.getElementById('breakModeBtn').classList.toggle('active', mode === "break");
        if(timerInterval) { clearInterval(timerInterval); timerInterval = null; } isRunning = false; isPaused = false; document.getElementById('globalWheelWrapper').classList.remove('locked'); setButtonVisualState('reset');
        currentSeconds = (mode === "focus") ? userFocusSeconds : userBreakSeconds; totalDurationInMode = currentSeconds; updateTimerDisplay();
    }
    
    document.getElementById('focusModeBtn').addEventListener('click', () => { if(!isRunning && !isPaused) setMode('focus'); });
    document.getElementById('breakModeBtn').addEventListener('click', () => { if(!isRunning && !isPaused) setMode('break'); });
    document.getElementById('startTimerBtn').addEventListener('click', startTimer);
    document.getElementById('pauseTimerBtn').addEventListener('click', stopTimer);
    document.getElementById('resetTimerBtn').addEventListener('click', () => { setMode(currentMode); });
    
    // NAVIGASI CAPSULES
    const navCapsules = document.querySelectorAll('#navCapsulesGroup .nav-pill-custom');
    navCapsules.forEach(pill => {
        pill.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target'); if(!targetId) return;
            navCapsules.forEach(p => p.classList.remove('active')); this.classList.add('active');
            const targetElement = document.getElementById(targetId); if(targetElement) targetElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });
    document.getElementById('btnFocusNow').addEventListener('click', () => { navCapsules.forEach(p => p.classList.remove('active')); document.querySelector('[data-target="timer-section"]').classList.add('active'); document.getElementById('timer-section').scrollIntoView({ behavior: 'smooth', block: 'start' }); });
    document.getElementById('btnSeeTasks').addEventListener('click', () => { navCapsules.forEach(p => p.classList.remove('active')); document.querySelector('[data-target="tugas-section"]').classList.add('active'); document.getElementById('tugas-section').scrollIntoView({ behavior: 'smooth', block: 'start' }); });
    document.getElementById('resetDataBtn').addEventListener('click', () => {
        if(confirm("Apakah Anda yakin ingin reset semua data?")) {
            localStorage.clear(); stats = { activeBreakCompleted: 0, focusMinutesTotal: 0, weeklyStreak: 0, lastStreakDate: null, totalFocusSessionsToday: 0, memos: [] };
            tasks = []; userFocusSeconds = 0; userBreakSeconds = 0;
            const nowD = new Date(); selectedFilterDate = `${nowD.getFullYear()}-${(nowD.getMonth()+1).toString().padStart(2,'0')}-${nowD.getDate().toString().padStart(2,'0')}`;
            setMode('focus'); loadStorageData();
        }
    });

    document.body.style.cursor = `url("${animalCursors['frog']}") 4 4, auto`;
    build3DWheelPicker(); loadStorageData(); setMode('focus'); drawPet();
</script>
</body>
</html>