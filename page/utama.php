<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>PomoStep • Pomodoro & Active Break</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background: linear-gradient(145deg, #d4e2d0 0%, #bdd3b5 100%);
            font-family: 'Inter', system-ui, 'Segoe UI', Roboto, sans-serif;
            min-height: 100vh;
        }
        
        /* 💡 REVISI UTAMA: EFEK INTERAKTIF PADA 4 KOTAK UTAMA */
        .glass-card {
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(2px);
            border-radius: 2rem;
            border: 1px solid rgba(80,100,70,0.15);
            
            /* Animasi transisi harus smooth saat kursor masuk dan keluar kotak */
            transition: transform 0.3s cubic-bezier(0.25, 0.8, 0.25, 1), box-shadow 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            will-change: transform, box-shadow;
        }
        
        /* Efek ketika kursor mengarah ke salah satu kotak (:hover) */
        .glass-card:hover {
            transform: scale(1.025); /* Efek zoom-in dikit (2.5% lebih besar) */
            
            /* Memberikan efek bayangan warna hijau lembut di belakang kotak */
            box-shadow: 0 15px 30px rgba(31, 90, 46, 0.15), 0 5px 15px rgba(0, 0, 0, 0.05);
            border-color: rgba(46, 125, 50, 0.3); /* Bingkai ikut menggelap tipis */
        }
        
        /* REVISI UTAMA TIMER ATAS: Tanpa BG Gelap, Tanpa Efek Neon, Angka Solid Bersih */
        .timer-container {
            background: transparent;
            border-radius: 0;
            padding: 1rem 0;
            box-shadow: none;
            position: relative;
        }
        .timer-digit {
            font-family: 'Fira Mono', monospace;
            font-size: 4.5rem;
            font-weight: 800;
            letter-spacing: 1px;
            color: #1f5a2e; 
            text-shadow: none; 
            display: block;
            line-height: 1;
            margin-bottom: 0.5rem;
        }
        .timer-progress-ring {
            height: 6px;
            background: rgba(0, 0, 0, 0.08);
            border-radius: 10px;
            width: 80%;
            margin: 1.2rem auto 0 auto;
            overflow: hidden;
        }
        .timer-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #2e7d32, #4caf50);
            width: 100%;
            transition: width 1s linear;
        }

        /* REVISI UTAMA PICKER BAWAH: Tanpa Kotak Hitam, Menggunakan BG Cerah Menyerupai Putih */
        .wheel-picker-box {
            background: transparent;
            border-radius: 0;
            padding: 0.5rem 0;
            box-shadow: none;
            color: #2c3e2f;
        }
        .wheel-container {
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            height: 160px;
            background: #f4f9f3; 
            border: 1px solid rgba(80, 100, 70, 0.15);
            border-radius: 1.5rem;
            box-shadow: inset 0 2px 8px rgba(0,0,0,0.03);
        }
        .wheel-container::before, .wheel-container::after {
            content: '';
            position: absolute;
            left: 0; right: 0; height: 50px; z-index: 3;
            pointer-events: none;
        }
        .wheel-container::before {
            top: 0; background: linear-gradient(to bottom, #f4f9f3 15%, rgba(244, 249, 243, 0) 100%);
        }
        .wheel-container::after {
            bottom: 0; background: linear-gradient(to top, #f4f9f3 15%, rgba(244, 249, 243, 0) 100%);
        }
        .wheel-selection-center {
            position: absolute;
            left: 4%; right: 4%; top: 60px; height: 40px;
            border-top: 1px solid rgba(46, 125, 50, 0.2);
            border-bottom: 1px solid rgba(46, 125, 50, 0.2);
            background: rgba(46, 125, 50, 0.03);
            pointer-events: none;
            z-index: 1;
        }
        .wheel-column {
            flex: 1;
            height: 100%;
            overflow-y: scroll;
            scroll-snap-type: y mandatory;
            scrollbar-width: none;
            z-index: 2;
            text-align: center;
        }
        .wheel-column::-webkit-scrollbar {
            display: none;
        }
        .wheel-label-header {
            font-size: 0.85rem;
            font-weight: 700;
            color: #5d7e5a;
            letter-spacing: 0.5px;
        }
        .wheel-spacer-top-bottom {
            height: 60px;
        }
        .wheel-item {
            height: 40px;
            line-height: 40px;
            font-family: 'Fira Mono', monospace;
            font-size: 1.3rem;
            font-weight: 500;
            color: #a2bca0; 
            scroll-snap-align: center;
            transition: all 0.2s ease;
            cursor: pointer;
        }
        .wheel-item.selected {
            color: #1f5a2e; 
            font-weight: 800;
            font-size: 1.55rem;
            transform: scale(1.05);
        }
        .wheel-separator-dots {
            font-size: 1.4rem;
            font-weight: 800;
            color: #2e7d32;
            padding-bottom: 4px;
            user-select: none;
        }

        /* Komponen Pendukung Samping */
        .mode-switch {
            background: #e9ecef;
            border-radius: 60px;
            padding: 0.2rem;
        }
        .mode-option {
            border-radius: 60px;
            padding: 0.4rem 1.2rem;
            font-weight: 600;
            cursor: pointer;
            transition: 0.1s;
        }
        .mode-option.active {
            background: #4caf50;
            color: white;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        .stat-box {
            background: #f8fef5;
            border-radius: 1.5rem;
            text-align: center;
            padding: 0.5rem;
        }
        .stat-number-big {
            font-size: 1.6rem;
            font-weight: 800;
            color: #1f5a2e;
            line-height: 1.2;
        }
        
        .todo-item-custom {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.6rem 0;
            border-bottom: 1px solid #cfe2cf;
            transition: all 0.2s ease;
        }
        .todo-item-custom.completed span {
            text-decoration: line-through;
            color: #8fa48f;
            font-style: italic;
        }

        canvas {
            background: #FEF3DA;
            border-radius: 48px;
            box-shadow: 0 12px 20px rgba(0,0,0,0.15);
            cursor: pointer;
            width: 100%;
            max-width: 220px;
            aspect-ratio: 1 / 1;
            display: block;
            margin: 0 auto;
        }
        .emoji-picker span {
            font-size: 2rem;
            cursor: pointer;
            transition: 0.1s;
            background: #ffffffc9;
            border-radius: 50px;
            padding: 5px 12px;
        }
        .emoji-picker span:hover {
            background: #c8e6c9;
            transform: scale(1.05);
        }
        .streak-badge {
            background: #ffefc0;
            border-radius: 40px;
            padding: 0.2rem 1rem;
            font-weight: 600;
        }
        .next-card {
            background: #ecf6e7;
            border-radius: 1.2rem;
            padding: 0.8rem;
        }
        .btn-focus {
            background-color: #2c5e2a;
            color: white;
            border-radius: 40px;
            padding: 0.5rem 1.4rem;
            font-weight: 600;
        }
        .btn-focus:hover {
            background-color: #1e4620;
            color: white;
        }
        
        .memo-log-item {
            font-size: 0.85rem;
            background: rgba(255,255,255,0.6);
            border-left: 3px solid #4caf50;
            padding: 0.3rem 0.6rem;
            margin-top: 0.4rem;
            border-radius: 0 8px 8px 0;
        }

        @media (max-width: 768px) {
            .timer-digit { font-size: 3.2rem; }
        }
    </style>
</head>
<body>

<div class="container py-4 py-md-5">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-2 border-bottom border-success border-opacity-25">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-lightning-charge-fill text-success fs-2"></i>
            <h1 class="display-6 fw-bold" style="background: linear-gradient(135deg,#1b4d1b,#3c8c40); -webkit-background-clip:text; background-clip:text; color:transparent;">PomoStep</h1>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <span class="badge bg-light text-dark px-3 py-2 rounded-pill shadow-sm"><i class="bi bi-stopwatch"></i> Timer</span>
            <span class="badge bg-light text-dark px-3 py-2 rounded-pill shadow-sm"><i class="bi bi-activity"></i> Active Break</span>
            <span class="badge bg-light text-dark px-3 py-2 rounded-pill shadow-sm"><i class="bi bi-graph-up"></i> Statistik</span>
            <span class="badge bg-light text-dark px-3 py-2 rounded-pill shadow-sm" id="resetDataBtn" style="cursor:pointer;"><i class="bi bi-arrow-repeat"></i> Pengaturan</span>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="glass-card p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <h5 class="fw-bold m-0"><i class="bi bi-cup-hot-fill me-2"></i>Sesi produktif</h5>
                </div>
                <div class="d-flex justify-content-between mt-3 mb-3">
                    <span><i class="bi bi-calendar-check"></i> Sesi #<span id="totalSessionsToday">0</span> hari ini</span>
                    <span class="streak-badge"><i class="bi bi-fire"></i> WEEKLY STREAK <span id="weeklyStreak">0</span> hari</span>
                </div>
                
                <div class="row g-2 text-center mt-2">
                    <div class="col-4"><div class="stat-box"><div class="stat-number-big" id="activeBreakCount">0</div><i class="bi bi-emoji-sunglasses"></i> Active break</div></div>
                    <div class="col-4"><div class="stat-box"><div class="stat-number-big" id="focusMinutes">0</div><i class="bi bi-hourglass-split"></i> Menit fokus</div></div>
                    <div class="col-4"><div class="stat-box"><div class="stat-number-big" id="tasksRatio">0/0</div><i class="bi bi-check2-circle"></i> Tugas</div></div>
                </div>
                <div class="progress mt-3" style="height: 8px;">
                    <div id="focusProgressBar" class="progress-bar bg-success" style="width:0%" role="progressbar"></div>
                </div>
                
                <div class="mt-3 pt-2 border-top border-success border-opacity-10">
                    <div class="fw-bold small text-success mb-1"><i class="bi bi-journal-text"></i> Memo Riwayat Fokus:</div>
                    <div id="memoLogArea" style="max-height: 90px; overflow-y: auto;">
                        <div class="small text-muted italic">Belum ada rekaman fokus. Selesaikan sesi untuk menulis memo.</div>
                    </div>
                </div>
            </div>

            <div class="glass-card p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold m-0"><i class="bi bi-checklist"></i> TUGAS SESI INI</h5>
                    <button class="btn btn-sm btn-success rounded-pill px-3" id="addTaskBtn"><i class="bi bi-plus-circle-fill"></i> Tambah Tugas</button>
                </div>
                
                <ul class="list-unstyled mt-3" id="todoList">
                    <li class="todo-item-custom"><input class="form-check-input me-2" type="checkbox" data-index="0"> <span>Implement auth module</span></li>
                    <li class="todo-item-custom"><input class="form-check-input me-2" type="checkbox" data-index="1"> <span>Tulis laporan praktikum</span></li>
                    <li class="todo-item-custom"><input class="form-check-input me-2" type="checkbox" data-index="2"> <span>Review PR teman</span></li>
                </ul>
                <div class="next-card mt-3">
                    <div class="fw-semibold"><i class="bi bi-arrow-repeat"></i> SELANJUTNYA</div>
                    <div><i class="bi bi-activity"></i> Active Break — <span id="nextBreakHint">Setelah sesi fokus selesai</span></div>
                    <div><i class="bi bi-hourglass-top"></i> Sesi #<span id="nextSessionNum">1</span> — Mulai setelah break</div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="glass-card p-4 text-center mb-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-timer"></i> Timer Fokus</h5>
                
                <div class="timear-container mx-auto mb-2" style="max-width: 320px;">
                    <div class="timer-digit" id="timerDisplay">00:25:00</div>
                    <div id="timerModeText" class="small fw-bold text-uppercase tracking-wider text-success" style="font-size: 0.75rem; letter-spacing: 0.5px;">Fokus Dimulai</div>
                    <div class="timer-progress-ring">
                        <div id="timerRingBar" class="timer-progress-bar"></div>
                    </div>
                </div>

                <div class="wheel-picker-box mx-auto mb-4" style="max-width: 320px;">
                    <div class="row text-center g-0 mb-2">
                        <div class="col-4 wheel-label-header">Jam</div>
                        <div class="col-4 wheel-label-header">Menit</div>
                        <div class="col-4 wheel-label-header">Detik</div>
                    </div>
                    
                    <div class="wheel-container">
                        <div class="wheel-selection-center"></div>
                        
                        <div id="wheelHours" class="wheel-column">
                            <div class="wheel-spacer-top-bottom"></div>
                            <div class="wheel-spacer-top-bottom"></div>
                        </div>
                        <div class="wheel-separator-dots">:</div>
                        <div id="wheelMinutes" class="wheel-column">
                            <div class="wheel-spacer-top-bottom"></div>
                            <div class="wheel-spacer-top-bottom"></div>
                        </div>
                        <div class="wheel-separator-dots">:</div>
                        <div id="wheelSeconds" class="wheel-column">
                            <div class="wheel-spacer-top-bottom"></div>
                            <div class="wheel-spacer-top-bottom"></div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-center gap-2 mode-switch w-auto mx-auto mb-3" style="max-width: 260px;">
                    <span id="focusModeBtn" class="mode-option active">🎯 Focus time</span>
                    <span id="breakModeBtn" class="mode-option">☕ Break</span>
                </div>
                <div class="d-flex gap-2 justify-content-center flex-wrap">
                    <button id="startTimerBtn" class="btn btn-focus"><i class="bi bi-play-fill"></i> Start</button>
                    <button id="pauseTimerBtn" class="btn btn-outline-secondary rounded-pill"><i class="bi bi-pause"></i> Pause</button>
                    <button id="resetTimerBtn" class="btn btn-outline-secondary rounded-pill"><i class="bi bi-arrow-clockwise"></i> Reset</button>
                </div>
            </div>

            <div class="glass-card p-4 text-center">
                <h5 class="fw-bold"><i class="bi bi-emoji-heart-eyes"></i> Teman fokusmu</h5>
                <div class="d-flex justify-content-center my-2">
                    <canvas id="petCanvas" width="200" height="200" style="width:200px; height:200px"></canvas>
                </div>
                <div class="emoji-picker d-flex gap-3 justify-content-center mt-3">
                    <span data-animal="frog" class="px-3 py-1 rounded-pill bg-white shadow-sm">🐸</span>
                    <span data-animal="cat" class="px-3 py-1 rounded-pill bg-white shadow-sm">🐱</span>
                    <span data-animal="dog" class="px-3 py-1 rounded-pill bg-white shadow-sm">🐶</span>
                </div>
                <div class="small text-secondary mt-2"><i class="bi bi-cursor"></i> Mataku selalu memperhatikanmu!</div>
            </div>
        </div>
    </div>
</div>

<script>
    // ------------------- KONTROL MATA INTERAKTIF -------------------
    const canvas = document.getElementById('petCanvas');
    const ctx = canvas.getContext('2d');
    let currentAnimal = 'frog'; let targetX = 100, targetY = 100;

    document.addEventListener('mousemove', (e) => {
        const rect = canvas.getBoundingClientRect();
        const scaleX = canvas.width / rect.width; const scaleY = canvas.height / rect.height;
        targetX = (e.clientX - rect.left) * scaleX; targetY = (e.clientY - rect.top) * scaleY;
        drawPet();
    });

    function drawEye(centerX, centerY, eyeRadius, pupilRadius, mx, my) {
        ctx.beginPath(); ctx.arc(centerX, centerY, eyeRadius, 0, 2 * Math.PI);
        ctx.fillStyle = "#FFFFFF"; ctx.fill(); ctx.strokeStyle = "#2c3e2f"; ctx.lineWidth = 1.5; ctx.stroke();
        let dx = mx - centerX; let dy = my - centerY; let angle = Math.atan2(dy, dx);
        let distance = Math.min(eyeRadius - pupilRadius - 2, Math.hypot(dx, dy) * 0.15);
        let offsetX = Math.cos(angle) * distance; let offsetY = Math.sin(angle) * distance;
        ctx.beginPath(); ctx.arc(centerX + offsetX, centerY + offsetY, pupilRadius, 0, 2 * Math.PI);
        ctx.fillStyle = "#1f2e1c"; ctx.fill();
        ctx.beginPath(); ctx.arc(centerX + offsetX - 2, centerY + offsetY - 2, pupilRadius * 0.3, 0, 2 * Math.PI);
        ctx.fillStyle = "white"; ctx.fill();
    }
    
    function drawFrog(mx, my) {
        ctx.fillStyle = "#6B8E23"; ctx.beginPath(); ctx.ellipse(100, 110, 55, 50, 0, 0, Math.PI*2); ctx.fill();
        ctx.fillStyle = "#556B2F"; ctx.beginPath(); ctx.ellipse(100, 125, 40, 30, 0, 0, Math.PI*2); ctx.fill();
        drawEye(75, 75, 17, 7, mx, my); drawEye(125, 75, 17, 7, mx, my);
        ctx.beginPath(); ctx.arc(100, 105, 20, 0.1, Math.PI - 0.1); ctx.strokeStyle = "#3A2A1A"; ctx.lineWidth = 2; ctx.stroke();
    }
    
    function drawCat(mx, my) {
        ctx.fillStyle = "#F4A261"; ctx.beginPath(); ctx.ellipse(100, 110, 50, 48, 0, 0, Math.PI*2); ctx.fill();
        ctx.fillStyle = "#E76F51"; ctx.beginPath(); ctx.moveTo(60, 70); ctx.lineTo(75, 40); ctx.lineTo(90, 70); ctx.fill();
        ctx.beginPath(); ctx.moveTo(140, 70); ctx.lineTo(125, 40); ctx.lineTo(110, 70); ctx.fill();
        drawEye(72, 80, 15, 6, mx, my); drawEye(128, 80, 15, 6, mx, my);
        ctx.fillStyle = "#D95B43"; ctx.beginPath(); ctx.arc(100, 98, 5, 0, 2*Math.PI); ctx.fill();
    }
    
    function drawDog(mx, my) {
        ctx.fillStyle = "#D4A373"; ctx.beginPath(); ctx.ellipse(100, 110, 52, 48, 0, 0, Math.PI*2); ctx.fill();
        ctx.fillStyle = "#B97F44"; ctx.beginPath(); ctx.ellipse(100, 125, 35, 28, 0, 0, Math.PI*2); ctx.fill();
        drawEye(75, 85, 14, 6, mx, my); drawEye(125, 85, 14, 6, mx, my);
        ctx.fillStyle = "#6B3E1C"; ctx.beginPath(); ctx.arc(100, 102, 8, 0, 2*Math.PI); ctx.fill();
    }
    
    function drawPet() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        if (currentAnimal === 'frog') drawFrog(targetX, targetY);
        else if (currentAnimal === 'cat') drawCat(targetX, targetY);
        else if (currentAnimal === 'dog') drawDog(targetX, targetY);
    }
    
    document.querySelectorAll('.emoji-picker span').forEach(btn => {
        btn.addEventListener('click', () => { currentAnimal = btn.getAttribute('data-animal'); drawPet(); });
    });

    // ------------------- ENGINE 3D WHEEL SCROLL LOGIC -------------------
    let timerInterval = null; let isRunning = false; let currentMode = "focus";
    let userFocusSeconds = 25 * 60; let userBreakSeconds = 5 * 60;
    let currentSeconds = userFocusSeconds; let totalDurationInMode = userFocusSeconds;
    
    let stats = { activeBreakCompleted: 0, focusMinutesTotal: 0, weeklyStreak: 0, lastStreakDate: null, totalFocusSessionsToday: 0, memos: [] };
    let tasks = [{ text: "Implement auth module", completed: false }, { text: "Tulis laporan praktikum", completed: false }, { text: "Review PR teman", completed: false }];

    function build3DWheelPicker() {
        setupWheelColumn('wheelHours', 23); setupWheelColumn('wheelMinutes', 59); setupWheelColumn('wheelSeconds', 59);
        setupWheelScrollListener('wheelHours'); setupWheelScrollListener('wheelMinutes'); setupWheelScrollListener('wheelSeconds');
        setWheelActiveValue('wheelHours', 0); setWheelActiveValue('wheelMinutes', 25); setWheelActiveValue('wheelSeconds', 0);
    }

    function setupWheelColumn(columnId, maxVal) {
        const col = document.getElementById(columnId); const endSpacer = col.lastElementChild;
        for (let i = 0; i <= maxVal; i++) {
            const item = document.createElement('div'); item.className = 'wheel-item';
            item.setAttribute('data-val', i); item.innerText = i.toString().padStart(2, '0');
            col.insertBefore(item, endSpacer);
        }
    }

    function setupWheelScrollListener(columnId) {
        const col = document.getElementById(columnId);
        col.addEventListener('scroll', () => {
            if(isRunning) stopTimer();
            const items = col.querySelectorAll('.wheel-item');
            let centerItem = null; let minDistance = Infinity;

            items.forEach(item => {
                const rect = item.getBoundingClientRect(); const containerRect = col.getBoundingClientRect();
                const centerPos = containerRect.top + (containerRect.height / 2);
                const itemCenter = rect.top + (rect.height / 2); const dist = Math.abs(centerPos - itemCenter);
                item.classList.remove('selected');
                if (dist < minDistance) { minDistance = dist; centerItem = item; }
            });
            if (centerItem) { centerItem.classList.add('selected'); calculateTotalSecondsFromWheels(); }
        });
    }

    function setWheelActiveValue(columnId, val) {
        const col = document.getElementById(columnId); const targetItem = col.querySelector(`.wheel-item[data-val="${val}"]`);
        if (targetItem) { col.scrollTop = targetItem.offsetTop - 60; targetItem.classList.add('selected'); }
    }

    function calculateTotalSecondsFromWheels() {
        const activeHour = document.querySelector('#wheelHours .wheel-item.selected');
        const activeMin = document.querySelector('#wheelMinutes .wheel-item.selected');
        const activeSec = document.querySelector('#wheelSeconds .wheel-item.selected');

        if (activeHour && activeMin && activeSec) {
            let h = parseInt(activeHour.getAttribute('data-val')); let m = parseInt(activeMin.getAttribute('data-val')); let s = parseInt(activeSec.getAttribute('data-val'));
            let total = (h * 3600) + (m * 60) + s; if (total <= 0) total = 1;
            if (currentMode === "focus") userFocusSeconds = total; else userBreakSeconds = total;
            currentSeconds = total; totalDurationInMode = total; updateTimerDisplay();
        }
    }

    // ------------------- PERSISTENCE STORAGE & UTILS -------------------
    function loadStorageData() {
        const savedStats = localStorage.getItem('pomostep_stats');
        if (savedStats) { try { stats = { ...stats, ...JSON.parse(savedStats) }; } catch(e) {} }
        const savedTasks = localStorage.getItem('pomostep_tasks');
        if (savedTasks) { try { tasks = JSON.parse(savedTasks); } catch(e) {} }
        verifyStreakLogic(); renderTasks(); updateStatsUI(); renderMemos();
    }
    
    function saveData() {
        localStorage.setItem('pomostep_stats', JSON.stringify(stats));
        localStorage.setItem('pomostep_tasks', JSON.stringify(tasks));
        updateStatsUI();
    }

    function verifyStreakLogic() {
        const todayStr = new Date().toDateString();
        if (stats.lastStreakDate) {
            const lastDate = new Date(stats.lastStreakDate);
            const diffDays = Math.floor(Math.abs(new Date(todayStr) - lastDate) / (1000 * 60 * 60 * 24));
            if (diffDays > 1) { stats.weeklyStreak = 0; localStorage.setItem('pomostep_stats', JSON.stringify(stats)); }
        }
    }

    function triggerStreakIncrement() {
        const todayStr = new Date().toDateString();
        if (stats.lastStreakDate !== todayStr) { stats.weeklyStreak += 1; stats.lastStreakDate = todayStr; }
    }
    
    function updateStatsUI() {
        document.getElementById('activeBreakCount').innerText = stats.activeBreakCompleted;
        document.getElementById('focusMinutes').innerText = stats.focusMinutesTotal;
        document.getElementById('weeklyStreak').innerText = stats.weeklyStreak;
        document.getElementById('totalSessionsToday').innerText = stats.totalFocusSessionsToday;
        document.getElementById('nextSessionNum').innerText = stats.totalFocusSessionsToday + 1;
        
        let completedCount = tasks.filter(t => t.completed).length;
        document.getElementById('tasksRatio').innerText = `${completedCount}/${tasks.length}`;
        let percent = Math.min(100, (stats.focusMinutesTotal / 60) * 100);
        document.getElementById('focusProgressBar').style.width = percent + "%";
    }

    function renderTasks() {
        const todoList = document.getElementById('todoList'); todoList.innerHTML = "";
        tasks.forEach((task, index) => {
            const li = document.createElement('li');
            li.className = `todo-item-custom ${task.completed ? 'completed' : ''}`;
            li.innerHTML = `
                <input class="form-check-input me-2" type="checkbox" data-index="${index}" ${task.completed ? 'checked' : ''}>
                <span>${task.text}</span>
                <i class="bi bi-trash text-danger ms-auto btn-delete-task" style="cursor:pointer;" data-index="${index}"></i>
            `;
            todoList.appendChild(li);
        });

        document.querySelectorAll('.todo-item-custom input[type="checkbox"]').forEach(cb => {
            cb.addEventListener('change', (e) => {
                const index = parseInt(e.target.getAttribute('data-index'));
                tasks[index].completed = e.target.checked; saveData(); renderTasks();
            });
        });

        document.querySelectorAll('.btn-delete-task').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const index = parseInt(e.target.getAttribute('data-index'));
                tasks.splice(index, 1); saveData(); renderTasks();
            });
        });
    }

    document.getElementById('addTaskBtn').addEventListener('click', () => {
        const taskName = prompt("Masukkan nama tugas baru:");
        if (taskName && taskName.trim() !== "") { tasks.push({ text: taskName.trim(), completed: false }); saveData(); renderTasks(); }
    });

    function renderMemos() {
        const area = document.getElementById('memoLogArea');
        if(stats.memos.length === 0) {
            area.innerHTML = `<div class="small text-muted italic">Belum ada rekaman fokus. Selesaikan sesi untuk menulis memo.</div>`; return;
        }
        area.innerHTML = stats.memos.map(m => `<div class="memo-log-item"><b>[${m.time}]</b> ${m.text}</div>`).join('');
    }

    function createFocusMemo() {
        setTimeout(() => {
            const textMemo = prompt("Sesi fokus selesai! Tulis memo singkat:");
            const validText = (textMemo && textMemo.trim() !== "") ? textMemo.trim() : "Menyelesaikan fokus kustom wheel-scroll.";
            const timeNow = new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
            stats.memos.unshift({ time: timeNow, text: validText }); if(stats.memos.length > 10) stats.memos.pop();
            saveData(); renderMemos();
        }, 600);
    }

    // ------------------- CORE TIMER LOGIC -------------------
    function updateTimerDisplay() {
        let hrs = Math.floor(currentSeconds / 3600); let mins = Math.floor((currentSeconds % 3600) / 60); let secs = currentSeconds % 60;
        document.getElementById('timerDisplay').innerText = `${hrs.toString().padStart(2,'0')}:${mins.toString().padStart(2,'0')}:${secs.toString().padStart(2,'0')}`;
        let barPercent = totalDurationInMode > 0 ? (currentSeconds / totalDurationInMode) * 100 : 0;
        document.getElementById('timerRingBar').style.width = barPercent + "%";
    }
    
    function stopTimer() { if(timerInterval) { clearInterval(timerInterval); timerInterval = null; } isRunning = false; }
    
    function startTimer() {
        if (isRunning) return; isRunning = true;
        timerInterval = setInterval(() => {
            if (currentSeconds <= 0) {
                stopTimer();
                if (currentMode === "focus") {
                    let addedMinutes = Math.max(1, Math.round(userFocusSeconds / 60));
                    stats.focusMinutesTotal += addedMinutes; stats.totalFocusSessionsToday += 1;
                    triggerStreakIncrement(); saveData();
                    alert("✅ Sesi fokus selesai! Waktunya active break!");
                    createFocusMemo(); setMode("break");
                } else {
                    stats.activeBreakCompleted += 1; saveData();
                    alert("🎉 Break selesai! Saatnya kembali fokus!"); setMode("focus");
                }
                return;
            }
            currentSeconds--; updateTimerDisplay();
        }, 1000);
    }
    
    function setMode(mode) {
        currentMode = mode; const modeText = document.getElementById('timerModeText');
        if(mode === "focus") {
            document.getElementById('focusModeBtn').classList.add('active');
            document.getElementById('breakModeBtn').classList.remove('active');
            modeText.innerText = "Fokus Dimulai"; modeText.className = "small fw-bold text-uppercase tracking-wider text-success";
            let h = Math.floor(userFocusSeconds / 3600); let m = Math.floor((userFocusSeconds % 3600) / 60); let s = userFocusSeconds % 60;
            setWheelActiveValue('wheelHours', h); setWheelActiveValue('wheelMinutes', m); setWheelActiveValue('wheelSeconds', s);
        } else {
            document.getElementById('breakModeBtn').classList.add('active');
            document.getElementById('focusModeBtn').classList.remove('active');
            modeText.innerText = "Waktunya Istirahat Aktivitas"; modeText.className = "small fw-bold text-uppercase tracking-wider text-warning";
            let h = Math.floor(userBreakSeconds / 3600); let m = Math.floor((userBreakSeconds % 3600) / 60); let s = userBreakSeconds % 60;
            setWheelActiveValue('wheelHours', h); setWheelActiveValue('wheelMinutes', m); setWheelActiveValue('wheelSeconds', s);
        }
        stopTimer(); currentSeconds = (mode === "focus") ? userFocusSeconds : userBreakSeconds;
        totalDurationInMode = currentSeconds; updateTimerDisplay();
    }
    
    document.getElementById('focusModeBtn').addEventListener('click', () => setMode('focus'));
    document.getElementById('breakModeBtn').addEventListener('click', () => setMode('break'));
    document.getElementById('startTimerBtn').addEventListener('click', startTimer);
    document.getElementById('pauseTimerBtn').addEventListener('click', stopTimer);
    document.getElementById('resetTimerBtn').addEventListener('click', () => { stopTimer(); setMode(currentMode); });
    
    document.getElementById('resetDataBtn').addEventListener('click', () => {
        if(confirm("Apakah Anda yakin ingin reset semua data?")) {
            localStorage.clear();
            stats = { activeBreakCompleted: 0, focusMinutesTotal: 0, weeklyStreak: 0, lastStreakDate: null, totalFocusSessionsToday: 0, memos: [] };
            tasks = [{ text: "Implement auth module", completed: false }, { text: "Tulis laporan praktikum", completed: false }, { text: "Review PR teman", completed: false }];
            userFocusSeconds = 25 * 60; userBreakSeconds = 5 * 60; setMode('focus'); loadStorageData();
        }
    });

    build3DWheelPicker(); loadStorageData(); setMode('focus'); drawPet();
</script>
</body>
</html>