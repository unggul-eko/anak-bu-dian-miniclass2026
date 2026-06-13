// ========== PET DAN KURSOR INTERAKTIF ==========
const petQuotes = {
  focus: ["Fokus ya! Jangan buka sosmed dulu! 🤫", "Wah kamu keren banget, lanjutin! 🔥", "Aku mengawasimu belajar, semangat! 🎯"],
  break: ["Waktunya peregangan otot dulu! ☕", "Minum air putih dulu sana! 🚰"],
  alarm: ["Hei! Waktunya jadwal Zoom / kegiatan kuliah dimulai tuh! ⏰"],
};

function updatePetSpeech(type) {
  const bubble = document.getElementById("petBubbleChat");
  if(bubble) bubble.innerText = petQuotes[type][Math.floor(Math.random() * petQuotes[type].length)];
}

const animalCursors = {
  frog: "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='32' height='32' style='font-size:24px'><text y='24'>🐸</text></svg>",
  cat: "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='32' height='32' style='font-size:24px'><text y='24'>🐱</text></svg>",
  dog: "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='32' height='32' style='font-size:24px'><text y='24'>🐶</text></svg>",
  rabbit: "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='32' height='32' style='font-size:24px'><text y='24'>🐰</text></svg>",
  butterfly: "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='32' height='32' style='font-size:24px'><text y='24'>🦋</text></svg>",
  panda: "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='32' height='32' style='font-size:24px'><text y='24'>🐼</text></svg>"
};

const canvas = document.getElementById("petCanvas");
const ctx = canvas.getContext("2d");
let currentAnimal = "frog";
let targetX = 90, targetY = 90;

document.addEventListener("mousemove", (e) => {
  if(!canvas) return;
  const rect = canvas.getBoundingClientRect();
  targetX = (e.clientX - rect.left) * (canvas.width / rect.width);
  targetY = (e.clientY - rect.top) * (canvas.height / rect.height);
  drawPet();
});

function drawEye(centerX, centerY, eyeRadius, pupilRadius, mx, my, isPanda = false) {
  if (isPanda) {
    ctx.beginPath();
    ctx.arc(centerX, centerY, eyeRadius + 5, 0, 2 * Math.PI);
    ctx.fillStyle = "#2c2c2c";
    ctx.fill();
  }
  ctx.beginPath();
  ctx.arc(centerX, centerY, eyeRadius, 0, 2 * Math.PI);
  ctx.fillStyle = "#FFFFFF";
  ctx.fill();
  ctx.strokeStyle = "#2c3e2f";
  ctx.lineWidth = 1.5;
  ctx.stroke();
  let dx = mx - centerX, dy = my - centerY;
  let angle = Math.atan2(dy, dx);
  let distance = Math.min(eyeRadius - pupilRadius - 1.5, Math.hypot(dx, dy) * 0.15);
  ctx.beginPath();
  ctx.arc(centerX + Math.cos(angle) * distance, centerY + Math.sin(angle) * distance, pupilRadius, 0, 2 * Math.PI);
  ctx.fillStyle = isPanda ? "#000000" : "#1f2e1c";
  ctx.fill();
}

function drawFrog(mx, my) {
  ctx.fillStyle = "#6B8E23"; ctx.beginPath(); ctx.ellipse(100, 110, 55, 50, 0, 0, Math.PI*2); ctx.fill();
  ctx.fillStyle = "#FFFDD0"; ctx.beginPath(); ctx.ellipse(100, 125, 35, 25, 0, 0, Math.PI*2); ctx.fill();
  ctx.fillStyle = "rgba(255, 105, 180, 0.4)";
  ctx.beginPath(); ctx.arc(60, 110, 10, 0, Math.PI*2); ctx.fill();
  ctx.beginPath(); ctx.arc(140, 110, 10, 0, Math.PI*2); ctx.fill();
  drawEye(75, 75, 17, 7, mx, my); drawEye(125, 75, 17, 7, mx, my);
  ctx.beginPath(); ctx.arc(100, 105, 15, 0, Math.PI);
  ctx.strokeStyle = "#3A2A1A"; ctx.lineWidth = 3; ctx.lineCap = "round"; ctx.stroke();
}

function drawCat(mx, my) {
  ctx.fillStyle = "#F4A261"; ctx.beginPath(); ctx.ellipse(100, 110, 50, 48, 0, 0, Math.PI*2); ctx.fill();
  ctx.fillStyle = "#E76F51";
  ctx.beginPath(); ctx.moveTo(50, 85); ctx.lineTo(65, 35); ctx.lineTo(90, 75); ctx.fill();
  ctx.beginPath(); ctx.moveTo(150, 85); ctx.lineTo(135, 35); ctx.lineTo(110, 75); ctx.fill();
  ctx.fillStyle = "#FFB6C1";
  ctx.beginPath(); ctx.moveTo(56, 82); ctx.lineTo(67, 43); ctx.lineTo(84, 73); ctx.fill();
  ctx.beginPath(); ctx.moveTo(144, 82); ctx.lineTo(133, 43); ctx.lineTo(116, 73); ctx.fill();
  ctx.fillStyle = "rgba(231, 111, 81, 0.35)";
  ctx.beginPath(); ctx.arc(60, 115, 8, 0, Math.PI*2); ctx.fill();
  ctx.beginPath(); ctx.arc(140, 115, 8, 0, Math.PI*2); ctx.fill();
  drawEye(75, 85, 14, 6, mx, my); drawEye(125, 85, 14, 6, mx, my);
  ctx.fillStyle = "#E76F51"; ctx.beginPath(); ctx.moveTo(96, 100); ctx.lineTo(104, 100); ctx.lineTo(100, 104); ctx.fill();
  ctx.strokeStyle = "#4A3525"; ctx.lineWidth = 2.5; ctx.lineCap = "round";
  ctx.beginPath(); ctx.arc(94, 104, 6, 0.1, Math.PI - 0.2); ctx.stroke();
  ctx.beginPath(); ctx.arc(106, 104, 6, 0.2, Math.PI - 0.1); ctx.stroke();
}

function drawDog(mx, my) {
  ctx.fillStyle = "#D4A373"; ctx.beginPath(); ctx.ellipse(100, 110, 52, 48, 0, 0, Math.PI*2); ctx.fill();
  ctx.fillStyle = "#A26E3A"; ctx.beginPath(); ctx.ellipse(45, 115, 14, 28, Math.PI/12, 0, Math.PI*2); ctx.fill();
  ctx.beginPath(); ctx.ellipse(155, 115, 14, 28, -Math.PI/12, 0, Math.PI*2); ctx.fill();
  ctx.fillStyle = "#FEFAE0"; ctx.beginPath(); ctx.ellipse(100, 118, 22, 16, 0, 0, Math.PI*2); ctx.fill();
  ctx.fillStyle = "rgba(233, 196, 106, 0.4)";
  ctx.beginPath(); ctx.arc(62, 115, 8, 0, Math.PI*2); ctx.fill();
  ctx.beginPath(); ctx.arc(138, 115, 8, 0, Math.PI*2); ctx.fill();
  drawEye(75, 85, 14, 6, mx, my); drawEye(125, 85, 14, 6, mx, my);
  ctx.fillStyle = "#FF7B94"; ctx.beginPath(); ctx.arc(100, 122, 7, 0, Math.PI); ctx.fill();
  ctx.fillStyle = "#4A2810"; ctx.beginPath(); ctx.ellipse(100, 112, 9, 6, 0, 0, Math.PI*2); ctx.fill();
}

function drawRabbit(mx, my) { /* sederhana, bisa diisi sendiri */ drawFrog(mx,my); }
function drawButterfly(mx, my) { drawCat(mx,my); }
function drawPanda(mx, my) { drawDog(mx,my); }

function drawPet() {
  if(!ctx) return;
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  if (currentAnimal === "frog") drawFrog(targetX, targetY);
  else if (currentAnimal === "cat") drawCat(targetX, targetY);
  else if (currentAnimal === "dog") drawDog(targetX, targetY);
  else if (currentAnimal === "rabbit") drawRabbit(targetX, targetY);
  else if (currentAnimal === "butterfly") drawButterfly(targetX, targetY);
  else if (currentAnimal === "panda") drawPanda(targetX, targetY);
}

document.querySelectorAll(".emoji-picker span").forEach((btn) => {
  btn.addEventListener("click", () => {
    document.querySelectorAll(".emoji-picker span").forEach(s => s.classList.remove("active-cursor"));
    btn.classList.add("active-cursor");
    const selectedType = btn.getAttribute("data-animal");
    if (selectedType === "normal") {
      document.body.style.cursor = "auto";
      document.getElementById("petBubbleChat").innerText = "Kursor kamu kembali normal! Tapi aku tetap menemanimu di sini. 💻";
    } else {
      currentAnimal = selectedType;
      document.getElementById("petBubbleChat").innerText = `Kursor kamu berubah! Sekarang aku jadi ${currentAnimal}! 🐾`;
      const svgData = animalCursors[currentAnimal];
      document.body.style.cursor = `url("${svgData}") 4 4, auto`;
    }
    drawPet();
  });
});

// ========== NOTIFIKASI SUARA ==========
function playBuzzerNotification() {
  try {
    const AudioContext = window.AudioContext || window.webkitAudioContext;
    if (!AudioContext) return;
    const audioCtx = new AudioContext();
    [0, 0.2, 0.4].forEach(delay => {
      let osc = audioCtx.createOscillator();
      let gainNode = audioCtx.createGain();
      osc.type = "sine";
      osc.frequency.setValueAtTime(880, audioCtx.currentTime + delay);
      gainNode.gain.setValueAtTime(0.2, audioCtx.currentTime + delay);
      gainNode.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + delay + 0.12);
      osc.connect(gainNode);
      gainNode.connect(audioCtx.destination);
      osc.start(audioCtx.currentTime + delay);
      osc.stop(audioCtx.currentTime + delay + 0.15);
    });
  } catch(e) { console.log("AudioContext blocked."); }
}

// ========== DATA GLOBAL ==========
let timerInterval = null, isRunning = false, isPaused = false, currentMode = "focus";
let userFocusSeconds = 0, userBreakSeconds = 0, currentSeconds = 0, totalDurationInMode = 0;
let lockedHour = 0, lockedMin = 0, lockedSec = 0;
let stats = {
  activeBreakCompleted: 0, focusMinutesTotal: 0, weeklyStreak: 0, lastStreakDate: null,
  totalFocusSessionsToday: 0, memos: [], customMaxMenit: 0, customMaxTugas: 0
};
let tasks = [];
const todayObj = new Date();
let selectedFilterDate = `${todayObj.getFullYear()}-${(todayObj.getMonth()+1).toString().padStart(2,'0')}-${todayObj.getDate().toString().padStart(2,'0')}`;

// ========== WHEEL PICKER ==========
function build3DWheelPicker() {
  setupWheelColumn("wheelHours", 23);
  setupWheelColumn("wheelMinutes", 59);
  setupWheelColumn("wheelSeconds", 59);
  setupWheelScrollListener("wheelHours");
  setupWheelScrollListener("wheelMinutes");
  setupWheelScrollListener("wheelSeconds");
  setTimeout(() => {
    setWheelActiveValue("wheelHours", 0);
    setWheelActiveValue("wheelMinutes", 0);
    setWheelActiveValue("wheelSeconds", 0);
    calculateTotalSecondsFromWheels();
  }, 200);
}

function setupWheelColumn(columnId, maxVal) {
  const col = document.getElementById(columnId);
  if(!col) return;
  col.innerHTML = '<div class="wheel-spacer-top-bottom"></div>';
  for (let i = 0; i <= maxVal; i++) {
    const item = document.createElement("div");
    item.className = "wheel-item";
    item.setAttribute("data-val", i);
    item.innerText = i.toString().padStart(2, "0");
    item.addEventListener("click", () => { if(!isRunning && !isPaused) { setWheelActiveValue(columnId, i); setTimeout(calculateTotalSecondsFromWheels,50); } });
    col.appendChild(item);
  }
  const bottomSpacer = document.createElement("div");
  bottomSpacer.className = "wheel-spacer-top-bottom";
  col.appendChild(bottomSpacer);
}

let scrollTimeout = null;
function setupWheelScrollListener(columnId) {
  const col = document.getElementById(columnId);
  if(!col) return;
  col.addEventListener("scroll", () => {
    if(isRunning || isPaused) return;
    if(scrollTimeout) clearTimeout(scrollTimeout);
    scrollTimeout = setTimeout(() => {
      const items = col.querySelectorAll(".wheel-item");
      let centerItem = null, minDistance = Infinity;
      const containerCenter = col.scrollTop + col.offsetHeight/2;
      items.forEach(item => {
        const itemCenter = item.offsetTop + item.offsetHeight/2;
        const dist = Math.abs(containerCenter - itemCenter);
        item.classList.remove("selected");
        if(dist < minDistance) { minDistance = dist; centerItem = item; }
      });
      if(centerItem) { centerItem.classList.add("selected"); calculateTotalSecondsFromWheels(); }
    }, 60);
  });
}

function setWheelActiveValue(columnId, val) {
  const col = document.getElementById(columnId);
  const targetItem = col.querySelector(`.wheel-item[data-val="${val}"]`);
  if(targetItem) {
    col.scrollTop = targetItem.offsetTop - col.offsetHeight/2 + targetItem.offsetHeight/2;
    col.querySelectorAll(".wheel-item").forEach(i => i.classList.remove("selected"));
    targetItem.classList.add("selected");
  }
}

function calculateTotalSecondsFromWheels() {
  if(isRunning || isPaused) return;
  const activeHour = document.querySelector("#wheelHours .wheel-item.selected");
  const activeMin = document.querySelector("#wheelMinutes .wheel-item.selected");
  const activeSec = document.querySelector("#wheelSeconds .wheel-item.selected");
  let h = activeHour ? parseInt(activeHour.getAttribute("data-val")) : 0;
  let m = activeMin ? parseInt(activeMin.getAttribute("data-val")) : 0;
  let s = activeSec ? parseInt(activeSec.getAttribute("data-val")) : 0;
  let total = h*3600 + m*60 + s;
  if(currentMode === "focus") userFocusSeconds = total;
  else userBreakSeconds = total;
  currentSeconds = total;
  totalDurationInMode = total;
  updateTimerDisplay();
}

// ========== STORAGE ==========
function loadStorageData() {
  const savedStats = localStorage.getItem("pomostep_stats");
  if(savedStats) { try { stats = { ...stats, ...JSON.parse(savedStats) }; } catch(e) {} }
  const savedTasks = localStorage.getItem("pomostep_tasks");
  if(savedTasks) { try { tasks = JSON.parse(savedTasks); } catch(e) {} }
  document.getElementById("inputMaxMenit").value = stats.customMaxMenit || 0;
  document.getElementById("inputMaxTugas").value = stats.customMaxTugas || 0;
  const d = new Date(selectedFilterDate);
  renderCalendar(d.getFullYear(), d.getMonth());
  renderTasks();
  updateStatsUI();
  renderMemos();
}

function saveData() {
  localStorage.setItem("pomostep_stats", JSON.stringify(stats));
  localStorage.setItem("pomostep_tasks", JSON.stringify(tasks));
  updateStatsUI();
  const d = new Date(selectedFilterDate);
  renderCalendar(d.getFullYear(), d.getMonth());
}

// ========== KALENDER (DENGAN BINTANG UNTUK SEMUA TUGAS) ==========
const monthNames = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
function renderCalendar(year, month) {
  document.getElementById("calendarMonthYearTitle").innerText = `${monthNames[month]} ${year}`;
  const container = document.getElementById("calendarDaysContainer");
  const labels = container.querySelectorAll(".calendar-day-label");
  container.innerHTML = "";
  labels.forEach(l => container.appendChild(l));
  const numDays = new Date(year, month+1, 0).getDate();
  const startDayIdx = new Date(year, month, 1).getDay();
  for(let i=0; i<startDayIdx; i++) container.appendChild(document.createElement("div"));
  for(let day=1; day<=numDays; day++) {
    const cell = document.createElement("div");
    cell.className = "calendar-cell";
    cell.innerText = day;
    const loopDateStr = `${year}-${(month+1).toString().padStart(2,'0')}-${day.toString().padStart(2,'0')}`;
    // 🌟 BINTANG UNTUK SEMUA TUGAS (tidak peduli completed)
    if(tasks.some(t => t.date === loopDateStr)) {
      cell.classList.add("has-event");
    }
    if(selectedFilterDate === loopDateStr) cell.classList.add("active-selected");
    cell.addEventListener("click", () => {
      selectedFilterDate = loopDateStr;
      document.querySelectorAll(".calendar-cell").forEach(c => c.classList.remove("active-selected"));
      cell.classList.add("active-selected");
      renderTasks();
    });
    container.appendChild(cell);
  }
}

// ========== MANAJEMEN TUGAS ==========
function renderTasks() {
  const todoList = document.getElementById("todoList");
  todoList.innerHTML = "";
  const filtered = tasks.filter(t => t.date === selectedFilterDate);
  if(filtered.length === 0) {
    todoList.innerHTML = `<div class="text-center py-4 text-muted small"><i class="bi bi-calendar-x d-block fs-4 mb-1"></i> Tidak ada kegiatan pada tanggal ini.</div>`;
    return;
  }
  filtered.forEach(task => {
    const globalIndex = tasks.findIndex(t => t.text===task.text && t.date===task.date && t.time===task.time);
    const card = document.createElement("div");
    card.className = `todo-item-custom ${task.completed ? "completed" : ""} d-flex align-items-start gap-2`;
    card.innerHTML = `
      <input class="form-check-input mt-1 flex-shrink-0" type="checkbox" data-index="${globalIndex}" ${task.completed ? "checked" : ""}>
      <div class="flex-grow-1 min-w-0 text-start">
        <div class="fw-bold text-dark small task-title-text text-truncate">${escapeHtml(task.text)}</div>
        <div class="text-muted text-truncate" style="font-size:0.75rem; font-weight:500;">${escapeHtml(task.subject)}</div>
        <div class="d-flex gap-1 flex-wrap mt-1">
          <span class="badge bg-light text-success rounded-pill p-1 px-2" style="font-size:0.68rem;"><i class="bi bi-calendar"></i> ${task.date}</span>
          <span class="badge bg-light text-warning rounded-pill p-1 px-2" style="font-size:0.68rem;"><i class="bi bi-bell"></i> ${task.time}</span>
        </div>
      </div>
      <i class="bi bi-trash text-danger btn-delete-task flex-shrink-0 ms-1 align-self-center" style="cursor:pointer;" data-index="${globalIndex}"></i>
    `;
    todoList.appendChild(card);
  });
  document.querySelectorAll('.todo-item-custom input[type="checkbox"]').forEach(cb => {
    cb.addEventListener("change", (e) => {
      tasks[parseInt(e.target.getAttribute("data-index"))].completed = e.target.checked;
      saveData();
    });
  });
  document.querySelectorAll(".btn-delete-task").forEach(btn => {
    btn.addEventListener("click", (e) => {
      tasks.splice(parseInt(e.target.getAttribute("data-index")), 1);
      saveData();
    });
  });
}

function escapeHtml(str) { return str.replace(/[&<>]/g, function(m){ if(m==='&') return '&amp;'; if(m==='<') return '&lt;'; if(m==='>') return '&gt;'; return m;}); }

document.getElementById("modalTaskForm")?.addEventListener("submit", function(e) {
  e.preventDefault();
  const text = document.getElementById("formTaskText").value.trim();
  const subject = document.getElementById("formTaskSubject").value.trim();
  const date = document.getElementById("formTaskDate").value;
  const time = document.getElementById("formTaskTime").value;
  if(text && subject && date && time) {
    tasks.push({ text, subject, date, time, completed: false, alarmed: false });
    selectedFilterDate = date;
    saveData();
    renderTasks();
    bootstrap.Modal.getInstance(document.getElementById("addTaskModal")).hide();
    document.getElementById("modalTaskForm").reset();
  }
});

// ========== ALARM & NOTIF ==========
setInterval(function checkAlarmTicker() {
  const now = new Date();
  const todayStr = `${now.getFullYear()}-${(now.getMonth()+1).toString().padStart(2,'0')}-${now.getDate().toString().padStart(2,'0')}`;
  const currentHrsMins = `${now.getHours().toString().padStart(2,'0')}:${now.getMinutes().toString().padStart(2,'0')}`;
  tasks.forEach(task => {
    if(task.date === todayStr && task.time === currentHrsMins && !task.alarmed && !task.completed) {
      task.alarmed = true;
      saveData();
      playBuzzerNotification();
      document.getElementById("liveAlarmAlertBanner").classList.remove("d-none");
      document.getElementById("alarmAlertMessage").innerText = `[ALARM KULIAH] ${task.subject.toUpperCase()} - ${task.text}`;
      document.getElementById("timer-section").scrollIntoView({ behavior: "smooth", block: "start" });
    }
  });
}, 1000);

function dismissLiveAlarm() { document.getElementById("liveAlarmAlertBanner").classList.add("d-none"); }

// ========== STREAK & STATISTIK ==========
function verifyStreakLogic() {
  const todayStr = new Date().toDateString();
  if(stats.lastStreakDate) {
    const diffDays = Math.floor(Math.abs(new Date(todayStr) - new Date(stats.lastStreakDate)) / (1000*60*60*24));
    if(diffDays > 1) { stats.weeklyStreak = 0; saveData(); }
  }
}
function triggerStreakIncrement() {
  const todayStr = new Date().toDateString();
  if(stats.lastStreakDate !== todayStr) { stats.weeklyStreak += 1; stats.lastStreakDate = todayStr; }
}

function updateStatsUI() {
  let nowObj = new Date();
  let todayStr = `${nowObj.getFullYear()}-${(nowObj.getMonth()+1).toString().padStart(2,'0')}-${nowObj.getDate().toString().padStart(2,'0')}`;
  let todayTasks = tasks.filter(t => t.date === todayStr);
  let todayTasksCompletedCount = todayTasks.filter(t => t.completed).length;
  let otherTasksCount = tasks.filter(t => t.date !== todayStr).length;
  let targetTugasHariIni = stats.customMaxTugas || 0;
  let totalAkumulatifTargetSemua = targetTugasHariIni + otherTasksCount;
  let totalSeluruhTugasSelesai = tasks.filter(t => t.completed).length;

  document.getElementById("dashActiveBreakCount").innerText = stats.activeBreakCompleted;
  document.getElementById("targetMenitFokus").innerText = stats.focusMinutesTotal;
  document.getElementById("totalMenitFokusKeseluruhan").innerText = stats.focusMinutesTotal;
  document.getElementById("dashWeeklyStreak").innerText = stats.weeklyStreak;
  document.getElementById("dashTotalSessionsToday").innerText = stats.totalFocusSessionsToday;
  document.getElementById("targetTugasSelesai").innerText = todayTasksCompletedCount;
  document.getElementById("targetTugasHariIniTotal").innerText = targetTugasHariIni;
  document.getElementById("totalTugasSelesaiKeseluruhan").innerText = totalSeluruhTugasSelesai;
  document.getElementById("totalTugasKeseluruhanSemua").innerText = totalAkumulatifTargetSemua;

  let maxMenit = stats.customMaxMenit || 0;
  let percentToday = maxMenit > 0 ? Math.min(100, Math.round((stats.focusMinutesTotal / maxMenit) * 100)) : 0;
  document.getElementById("dashProgressPercentText").innerText = percentToday + "%";
  let ringDashOffsetToday = 408.4 - (408.4 * percentToday) / 100;
  document.getElementById("dashCircularProgressRing").style.strokeDashoffset = ringDashOffsetToday;
  let percentAll = totalAkumulatifTargetSemua > 0 ? Math.min(100, Math.round((totalSeluruhTugasSelesai / totalAkumulatifTargetSemua) * 100)) : 0;
  document.getElementById("dashProgressPercentTextAll").innerText = percentAll + "%";
  let ringDashOffsetAll = 408.4 - (408.4 * percentAll) / 100;
  document.getElementById("dashCircularProgressRingAll").style.strokeDashoffset = ringDashOffsetAll;
  document.getElementById("capaianTotalSesi").innerText = stats.totalFocusSessionsToday;
  document.getElementById("capaianRataRata").innerText = (stats.totalFocusSessionsToday > 0 ? Math.round(stats.focusMinutesTotal / stats.totalFocusSessionsToday) : 0) + " m/sesi";
}

function renderMemos() {
  const area = document.getElementById("memoLogArea");
  if(!stats.memos || stats.memos.length === 0) {
    area.innerHTML = `<div class="small text-muted italic text-center py-3">Belum ada rekaman fokus.</div>`;
    return;
  }
  let htmlContent = "";
  stats.memos.forEach(m => {
    htmlContent += `<div class="memo-log-item"><b>[${m.time}]</b> ${m.text}</div>`;
  });
  area.innerHTML = htmlContent;
}

function createFocusMemo() {
  setTimeout(() => {
    const textMemo = prompt("Sesi fokus selesai! Tulis memo singkat:");
    const validText = (textMemo && textMemo.trim() !== "") ? textMemo.trim() : "Menyelesaikan fokus kustom wheel-scroll.";
    const now = new Date();
    const formatTimeClock = now.toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" });
    if(!stats.memos) stats.memos = [];
    stats.memos.unshift({ time: formatTimeClock, text: validText });
    if(stats.memos.length > 20) stats.memos.pop();
    saveData();
    renderMemos();
  }, 600);
}

// ========== TIMER ==========
function updateTimerDisplay() {
  let hrs = Math.floor(currentSeconds/3600);
  let mins = Math.floor((currentSeconds%3600)/60);
  let secs = currentSeconds%60;
  document.getElementById("timerDisplay").innerText = `${hrs.toString().padStart(2,'0')}:${mins.toString().padStart(2,'0')}:${secs.toString().padStart(2,'0')}`;
  let barPercent = totalDurationInMode > 0 ? (currentSeconds/totalDurationInMode)*100 : 0;
  document.getElementById("timerRingBar").style.width = barPercent + "%";
}
function stopTimer() {
  if(timerInterval) { clearInterval(timerInterval); timerInterval = null; }
  isRunning = false; isPaused = true;
  document.getElementById("globalWheelWrapper").classList.add("locked");
  setButtonVisualState("pause");
}
function startTimer() {
  const activeHour = document.querySelector("#wheelHours .wheel-item.selected");
  const activeMin = document.querySelector("#wheelMinutes .wheel-item.selected");
  const activeSec = document.querySelector("#wheelSeconds .wheel-item.selected");
  let totalRoda = 0;
  if(activeHour && activeMin && activeSec) {
    totalRoda = parseInt(activeHour.getAttribute("data-val"))*3600 + parseInt(activeMin.getAttribute("data-val"))*60 + parseInt(activeSec.getAttribute("data-val"));
  }
  if(!isPaused) {
    if(totalRoda > 0) {
      currentSeconds = totalRoda; totalDurationInMode = totalRoda;
      if(currentMode === "focus") userFocusSeconds = totalRoda;
      else userBreakSeconds = totalRoda;
    } else if(currentSeconds <= 0) {
      userFocusSeconds = 25*60; currentSeconds = userFocusSeconds; totalDurationInMode = userFocusSeconds;
      setWheelActiveValue("wheelMinutes", 25);
    }
  }
  updateTimerDisplay();
  if(isRunning) return;
  if(!isPaused) {
    lockedHour = activeHour ? parseInt(activeHour.getAttribute("data-val")) : 0;
    lockedMin = activeMin ? parseInt(activeMin.getAttribute("data-val")) : 25;
    lockedSec = activeSec ? parseInt(activeSec.getAttribute("data-val")) : 0;
  }
  isRunning = true; isPaused = false;
  document.getElementById("globalWheelWrapper").classList.add("locked");
  setButtonVisualState("start");
  timerInterval = setInterval(() => {
    if(currentSeconds <= 0) {
      clearInterval(timerInterval); timerInterval = null;
      isRunning = false; isPaused = false;
      document.getElementById("globalWheelWrapper").classList.remove("locked");
      setButtonVisualState("reset");
      playBuzzerNotification();
      if(currentMode === "focus") {
        stats.focusMinutesTotal += Math.max(1, Math.round(totalDurationInMode/60));
        stats.totalFocusSessionsToday += 1;
        triggerStreakIncrement();
        saveData();
        alert("✅ Sesi fokus selesai! Waktunya active break!");
        createFocusMemo();
        setMode("break");
      } else {
        stats.activeBreakCompleted += 1;
        saveData();
        alert("🎉 Break selesai! Saatnya kembali fokus!");
        setMode("focus");
      }
      return;
    }
    currentSeconds--;
    updateTimerDisplay();
  }, 1000);
}
function setMode(mode) {
  currentMode = mode;
  document.getElementById("timerModeText").innerText = mode==="focus" ? "Fokus Dimulai" : "Waktunya Istirahat";
  document.getElementById("timerModeText").className = mode==="focus" ? "small fw-bold text-uppercase text-success" : "small fw-bold text-uppercase text-warning";
  document.getElementById("focusModeBtn").classList.toggle("active", mode==="focus");
  document.getElementById("breakModeBtn").classList.toggle("active", mode==="break");
  if(timerInterval) { clearInterval(timerInterval); timerInterval=null; }
  isRunning=false; isPaused=false;
  document.getElementById("globalWheelWrapper").classList.remove("locked");
  setButtonVisualState("reset");
  currentSeconds = mode==="focus" ? userFocusSeconds : userBreakSeconds;
  totalDurationInMode = currentSeconds;
  updateTimerDisplay();
}
function setButtonVisualState(activeBtnId) {
  const btnStart = document.getElementById("startTimerBtn");
  const btnPause = document.getElementById("pauseTimerBtn");
  const btnReset = document.getElementById("resetTimerBtn");
  [btnStart, btnPause, btnReset].forEach(btn => btn.classList.remove("btn-status-active","btn-status-inactive"));
  if(activeBtnId==="reset") return;
  if(activeBtnId==="start") {
    btnStart.classList.add("btn-status-active");
    btnPause.classList.add("btn-status-inactive");
    btnReset.classList.add("btn-status-inactive");
  } else if(activeBtnId==="pause") {
    btnPause.classList.add("btn-status-active");
    btnStart.classList.add("btn-status-inactive");
    btnReset.classList.add("btn-status-inactive");
  }
}

// ========== EVENT LISTENER ==========
document.getElementById("startTimerBtn")?.addEventListener("click", startTimer);
document.getElementById("pauseTimerBtn")?.addEventListener("click", stopTimer);
document.getElementById("resetTimerBtn")?.addEventListener("click", () => setMode(currentMode));
document.getElementById("focusModeBtn")?.addEventListener("click", () => setMode("focus"));
document.getElementById("breakModeBtn")?.addEventListener("click", () => setMode("break"));
document.getElementById("btnFocusNow")?.addEventListener("click", () => {
  document.querySelectorAll(".nav-pill-custom").forEach(p => p.classList.remove("active"));
  document.querySelector('[data-target="timer-section"]').classList.add("active");
  document.getElementById("timer-section").scrollIntoView({ behavior: "smooth", block: "start" });
});
document.getElementById("btnSeeTasks")?.addEventListener("click", () => {
  document.querySelectorAll(".nav-pill-custom").forEach(p => p.classList.remove("active"));
  document.querySelector('[data-target="tugas-section"]').classList.add("active");
  document.getElementById("tugas-section").scrollIntoView({ behavior: "smooth", block: "start" });
});
document.getElementById("resetDataBtn")?.addEventListener("click", () => {
  if(confirm("Apakah Anda yakin ingin reset semua data?")) {
    localStorage.clear();
    stats = { activeBreakCompleted:0, focusMinutesTotal:0, weeklyStreak:0, lastStreakDate:null, totalFocusSessionsToday:0, memos:[], customMaxMenit:0, customMaxTugas:0 };
    tasks = [];
    userFocusSeconds=0; userBreakSeconds=0;
    document.getElementById("inputMaxMenit").value = 0;
    document.getElementById("inputMaxTugas").value = 0;
    const nowD = new Date();
    selectedFilterDate = `${nowD.getFullYear()}-${(nowD.getMonth()+1).toString().padStart(2,'0')}-${nowD.getDate().toString().padStart(2,'0')}`;
    setMode("focus");
    loadStorageData();
  }
});
document.getElementById("inputMaxMenit")?.addEventListener("input", (e) => {
  let val = parseInt(e.target.value);
  stats.customMaxMenit = !isNaN(val) && val>=0 ? val : 0;
  saveData();
});
document.getElementById("inputMaxTugas")?.addEventListener("input", (e) => {
  let val = parseInt(e.target.value);
  stats.customMaxTugas = !isNaN(val) && val>=0 ? val : 0;
  saveData();
});

// ========== SCROLL SPY ==========
window.addEventListener("scroll", () => {
  const targets = document.querySelectorAll(".scroll-target-marker");
  let currentActiveId = "dashboard-section";
  targets.forEach(section => {
    if(section.getBoundingClientRect().top <= 180) currentActiveId = section.getAttribute("id");
  });
  const capsules = document.querySelectorAll("#navCapsulesGroup .nav-pill-custom");
  capsules.forEach(pill => {
    const targetAttr = pill.getAttribute("data-target");
    if(targetAttr === currentActiveId) pill.classList.add("active");
    else pill.classList.remove("active");
  });
});

// ========== INISIALISASI ==========
document.body.style.cursor = `url("${animalCursors["frog"]}") 4 4, auto`;
build3DWheelPicker();
loadStorageData();
setMode("focus");
drawPet();

// Modal picker sederhana (opsional)
function initCustomPickers() {
  const dateInput = document.getElementById("formTaskDate");
  const timeInput = document.getElementById("formTaskTime");
  if(dateInput && timeInput) {
    dateInput.onclick = () => { /* bisa diisi kalender bawaan */ };
    timeInput.onclick = () => { };
  }
}
initCustomPickers();