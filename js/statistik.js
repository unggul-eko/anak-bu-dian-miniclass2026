let compositionChart = null;
let tasksProgressChart = null;

// ==========================================
// Mengambil data statistik dari localStorage (format utama.php)
// ==========================================
function getStats() {
  const defaultStats = {
    activeBreakCompleted: 0,
    focusMinutesTotal: 0,
    weeklyStreak: 0,
    lastStreakDate: null,
    totalFocusSessionsToday: 0,
    memos: [],
  };
  
  let stored = localStorage.getItem("pomostep_stats");
  if (stored) {
    try {
      let parsed = JSON.parse(stored);
      return { ...defaultStats, ...parsed };
    } catch (e) {
      return defaultStats;
    }
  }
  return defaultStats;
}

// ==========================================
// Mengambil daftar tugas dari localStorage (sinkron dengan skrip.js)
// ==========================================
function getTasks() {
  let stored = localStorage.getItem("pomostep_tasks");
  if (stored) {
    try {
      return JSON.parse(stored);
    } catch (e) {
      return []; // jika rusak, kembalikan kosong
    }
  }
  return []; // tidak ada data -> kosong, bukan default buatan
}

// ==========================================
// Render daftar tugas di ringkasan
// ==========================================
function renderTaskSummary() {
  const tasks = getTasks();
  const container = document.getElementById("todoListSummary");
  if (!container) return;
  
  container.innerHTML = "";
  
  tasks.forEach((task) => {
    const div = document.createElement("div");
    div.className = `todo-item-summary ${task.completed ? "completed" : ""}`;
    div.innerHTML = `
      <i class="bi ${task.completed ? "bi-check-circle-fill text-success" : "bi-circle text-secondary"}"></i>
      <span>${task.text}</span>
    `;
    container.appendChild(div);
  });
  
  const completed = tasks.filter((t) => t.completed).length;
  document.getElementById("completedTasksCount").innerText = completed;
  document.getElementById("totalTasksCount").innerText = tasks.length;
  
  let percent = tasks.length ? (completed / tasks.length) * 100 : 0;
  document.getElementById("tasksProgressBar").style.width = Math.min(100, percent) + "%";
}

// ==========================================
// Render chart donut: Sesi Fokus Hari Ini vs Total Break
// ==========================================
function renderCompositionChart(stats) {
  const ctx = document.getElementById("compositionChart").getContext("2d");
  if (compositionChart) compositionChart.destroy();
  
  compositionChart = new Chart(ctx, {
    type: "doughnut",
    data: {
      labels: ["Sesi Fokus (Hari Ini)", "Total Active Break"],
      datasets: [
        {
          data: [stats.totalFocusSessionsToday, stats.activeBreakCompleted],
          backgroundColor: ["#2e7d32", "#ffa726"],
          borderWidth: 0,
          hoverOffset: 8,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: true,
      plugins: { legend: { position: "bottom" } },
    },
  });
}

// ==========================================
// Render chart bar: Progress Tugas
// ==========================================
function renderTasksProgressChart() {
  const tasks = getTasks();
  const completed = tasks.filter((t) => t.completed).length;
  const percent = tasks.length ? (completed / tasks.length) * 100 : 0;
  const ctx = document.getElementById("tasksProgressChart").getContext("2d");
  
  if (tasksProgressChart) tasksProgressChart.destroy();
  
  tasksProgressChart = new Chart(ctx, {
    type: "bar",
    data: {
      labels: ["Tugas Selesai"],
      datasets: [
        {
          label: "Persentase (%)",
          data: [Math.min(100, percent)],
          backgroundColor: ["#2196f3"],
          borderRadius: 8,
          barPercentage: 0.5,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: true,
      scales: { y: { beginAtZero: true, max: 100 } },
      plugins: {
        tooltip: { callbacks: { label: (ctx) => `${ctx.raw.toFixed(1)}%` } },
      },
    },
  });
}

// ==========================================
// Update semua UI statistik
// ==========================================
function updateStatisticsUI() {
  const stats = getStats();
  
  document.getElementById("totalSesiHariIni").innerText = stats.totalFocusSessionsToday;
  document.getElementById("totalActiveBreak").innerText = stats.activeBreakCompleted;
  document.getElementById("totalFocusMinutes").innerText = stats.focusMinutesTotal;
  document.getElementById("weeklyStreak").innerText = stats.weeklyStreak;
  document.getElementById("totalFocusSessionsCount").innerText = stats.totalFocusSessionsToday;
  
  let avg = stats.totalFocusSessionsToday 
    ? Math.round(stats.focusMinutesTotal / stats.totalFocusSessionsToday) 
    : 0;
  document.getElementById("avgMinutesPerSession").innerText = avg;
  
  renderTaskSummary();
  renderCompositionChart(stats);
  renderTasksProgressChart();
}

// ==========================================
// Reset semua data (Menggunakan Bootstrap Modal)
// ==========================================
function resetAllStats() {
  const confirmModal = document.getElementById("confirmModal"); // Pastikan ID ini ada di HTML Anda
  
  // Fallback jika elemen modal tidak ditemukan (gunakan confirm bawaan browser)
  if (!confirmModal) {
    if (confirm("Yakin ingin mereset SEMUA data? Tindakan permanen.")) {
      localStorage.removeItem("pomostep_stats");
      localStorage.removeItem("pomostep_tasks");
      localStorage.removeItem("pomostep_timer");
      updateStatisticsUI();
      location.reload();
    }
    return;
  }

  // Jika modal Bootstrap ditemukan
  const modalInstance = new bootstrap.Modal(confirmModal);
  modalInstance.show();

  const doReset = () => {
    localStorage.removeItem("pomostep_stats");
    localStorage.removeItem("pomostep_tasks");
    localStorage.removeItem("pomostep_timer");
    
    const defaultStats = {
      activeBreakCompleted: 0,
      focusMinutesTotal: 0,
      weeklyStreak: 0,
      lastStreakDate: null,
      totalFocusSessionsToday: 0,
      memos: [],
    };
    localStorage.setItem("pomostep_stats", JSON.stringify(defaultStats));
    
    const defaultTasks = [
      { text: "Implement auth module", completed: false },
      { text: "Tulis laporan praktikum", completed: false },
      { text: "Review PR teman", completed: false },
    ];
    localStorage.setItem("pomostep_tasks", JSON.stringify(defaultTasks));
    
    updateStatisticsUI();
    
    // Non-blocking notification
    const notify = document.createElement("div");
    notify.className = "alert alert-success shadow-sm";
    notify.style.position = "fixed";
    notify.style.top = "16px";
    notify.style.right = "16px";
    notify.style.zIndex = "10800";
    notify.innerText = "Semua statistik telah direset.";
    document.body.appendChild(notify);
    
    setTimeout(() => {
      notify.remove();
    }, 2000);
  };

  // Hapus listener lama jika ada agar tidak double-trigger, lalu tambahkan yang baru
  const resetBtn = document.getElementById("statConfirmResetBtn");
  if (resetBtn) {
    // Clone node untuk mereset event listener lama secara instan (jika ada)
    const newBtn = resetBtn.cloneNode(true);
    resetBtn.parentNode.replaceChild(newBtn, resetBtn);
    
    newBtn.addEventListener("click", () => {
      doReset();
      const mi = bootstrap.Modal.getInstance(confirmModal);
      if (mi) mi.hide();
    }, { once: true });
  }
}

// ==========================================
// Inisialisasi Event Listener
// ==========================================
document.addEventListener("DOMContentLoaded", () => {
  updateStatisticsUI();
  const resetBtn = document.getElementById("resetStatsBtn");
  if (resetBtn) resetBtn.addEventListener("click", resetAllStats);
});

// Update jika ada perubahan dari tab lain (misal dari utama.php)
window.addEventListener("storage", (event) => {
  if (event.key === "pomostep_stats" || event.key === "pomostep_tasks") {
    updateStatisticsUI();
  }
});