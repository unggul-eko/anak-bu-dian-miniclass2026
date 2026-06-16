// ==========================================
// GLOBALS & STATE MANAGEMENT
// ==========================================
let timerInterval = null;
let isRunning = false;
let isPaused = false;
let currentMode = "focus"; // "focus" atau "break"

let userFocusSeconds = 0;
let userBreakSeconds = 0;
let currentSeconds = 0;
let totalDurationInMode = 0;

let lockedHour = 0;
let lockedMin = 0;
let lockedSec = 0;

let stats = {
  activeBreakCompleted: 0,
  focusMinutesTotal: 0,
  weeklyStreak: 0,
  lastStreakDate: null,
  totalFocusSessionsToday: 0,
  memos: [],
  customMaxMenit: 0,
  customMaxTugas: 0,
};

let tasks = [];
const todayObj = new Date();
let selectedFilterDate = `${todayObj.getFullYear()}-${(todayObj.getMonth() + 1).toString().padStart(2, "0")}-${todayObj.getDate().toString().padStart(2, "0")}`;

// ==========================================
// Lightweight non-blocking notification (top-right)
function showNotification(message, type = "success", timeout = 2500) {
  let container = document.getElementById("globalNotificationBanner");
  if (!container) {
    container = document.createElement("div");
    container.id = "globalNotificationBanner";
    container.style.position = "fixed";
    container.style.top = "16px";
    container.style.right = "16px";
    container.style.zIndex = "10800";
    document.body.appendChild(container);
  }
  const el = document.createElement("div");
  el.className = `alert alert-${type} shadow-sm`;
  el.style.minWidth = "220px";
  el.style.marginBottom = "8px";
  el.role = "alert";
  el.innerText = message;
  container.appendChild(el);
  setTimeout(() => {
    el.classList.add("fade");
    el.style.transition = "opacity 220ms";
    el.style.opacity = "0";
    setTimeout(() => el.remove(), 250);
  }, timeout);
  return el;
}
// ==========================================
// INTERACTIVE PET & CURSOR MODULE
// ==========================================
const petQuotes = {
  focus: [
    "Fokus ya! Jangan buka sosmed dulu! 🤫",
    "Wah kamu keren banget, lanjutin! 🔥",
    "Aku mengawasimu belajar, semangat! 🎯",
  ],
  break: ["Waktunya peregangan otot dulu! ☕", "Minum air putih dulu sana! 🚰"],
  alarm: ["Hei! Waktunya jadwal Zoom / kegiatan kuliah dimulai tuh! ⏰"],
};

function updatePetSpeech(type) {
  const bubble = document.getElementById("petBubbleChat");
  if (bubble)
    bubble.innerText =
      petQuotes[type][Math.floor(Math.random() * petQuotes[type].length)];
}

const animalCursors = {
  frog: "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='32' height='32' style='font-size:24px'><text y='24'>🐸</text></svg>",
  cat: "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='32' height='32' style='font-size:24px'><text y='24'>🐱</text></svg>",
  dog: "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='32' height='32' style='font-size:24px'><text y='24'>🐶</text></svg>",
};

// Variabel Khusus HTML5 Canvas Pet
const petCanvas = document.getElementById("petCanvas");
const petCtx = petCanvas ? petCanvas.getContext("2d") : null;
let currentAnimal = "frog";
let targetX = 90,
  targetY = 90;

// Mouse Tracking khusus untuk Canvas Pet
if (petCanvas) {
  window.addEventListener("mousemove", (e) => {
    const rect = petCanvas.getBoundingClientRect();
    targetX = (e.clientX - rect.left) * (petCanvas.width / rect.width);
    targetY = (e.clientY - rect.top) * (petCanvas.height / rect.height);
    drawPet();
  });
}

function drawEye(centerX, centerY, eyeRadius, pupilRadius, mx, my) {
  if (!petCtx) return;
  petCtx.beginPath();
  petCtx.arc(centerX, centerY, eyeRadius, 0, 2 * Math.PI);
  petCtx.fillStyle = "#FFFFFF";
  petCtx.fill();
  petCtx.strokeStyle = "#2c3e2f";
  petCtx.lineWidth = 1.5;
  petCtx.stroke();

  let dx = mx - centerX,
    dy = my - centerY;
  let angle = Math.atan2(dy, dx);
  let distance = Math.min(
    eyeRadius - pupilRadius - 1.5,
    Math.hypot(dx, dy) * 0.15,
  );

  petCtx.beginPath();
  petCtx.arc(
    centerX + Math.cos(angle) * distance,
    centerY + Math.sin(angle) * distance,
    pupilRadius,
    0,
    2 * Math.PI,
  );
  petCtx.fillStyle = "#1f2e1c";
  petCtx.fill();
}

function drawPet() {
  if (!petCtx || !petCanvas) return;
  petCtx.clearRect(0, 0, petCanvas.width, petCanvas.height);

  const cx = petCanvas.width / 2;
  const cy = petCanvas.height / 2;

  if (currentAnimal === "frog") drawFrog(targetX, targetY, cx, cy);
  else if (currentAnimal === "cat") drawCat(targetX, targetY, cx, cy);
  else if (currentAnimal === "dog") drawDog(targetX, targetY, cx, cy);
}

function drawFrog(mx, my, cx, cy) {
  if (!petCtx) return; // Menggunakan petCtx sesuai dengan cuplikan kode terakhirmu

  // --- 1. BAYANGAN LEMBUT (Biar kelihatan menapak bumi) ---
  petCtx.fillStyle = "rgba(0, 0, 0, 0.08)";
  petCtx.beginPath();
  petCtx.ellipse(cx, cy + 50, 60, 15, 0, 0, Math.PI * 2);
  petCtx.fill();

  // --- 2. KAKI BELAKANG & BADAN UTAMA (Gembul & Bulat) ---
  // Kaki belakang samar di kiri-kanan bawah badan
  petCtx.fillStyle = "#A3B18A"; // Hijau zaitun muda soft sesuai gambar
  petCtx.beginPath();
  petCtx.arc(cx - 45, cy + 35, 20, 0, Math.PI * 2);
  petCtx.fill();
  petCtx.beginPath();
  petCtx.arc(cx + 45, cy + 35, 20, 0, Math.PI * 2);
  petCtx.fill();

  // Badan Utama (Oval gemuk agak miring ke bawah sedikit)
  petCtx.fillStyle = "#A3B18A";
  petCtx.beginPath();
  petCtx.ellipse(cx, cy + 10, 65, 52, (Math.PI / 180) * 2, 0, Math.PI * 2);
  petCtx.fill();

  // --- 3. CORAK BINTIK PUNGGUNG (Spotted Pattern) ---
  petCtx.fillStyle = "#4F5D2F"; // Hijau tua untuk bintik-bintik
  // Bintik di punggung atas/samping kiri
  petCtx.beginPath();
  petCtx.ellipse(cx - 40, cy - 15, 8, 12, Math.PI / 4, 0, Math.PI * 2);
  petCtx.fill();
  petCtx.beginPath();
  petCtx.arc(cx - 50, cy + 5, 5, 0, Math.PI * 2);
  petCtx.fill();
  // Bintik di punggung atas/samping kanan
  petCtx.beginPath();
  petCtx.ellipse(cx + 45, cy - 10, 12, 10, -Math.PI / 6, 0, Math.PI * 2);
  petCtx.fill();
  petCtx.beginPath();
  petCtx.arc(cx + 35, cy + 15, 6, 0, Math.PI * 2);
  petCtx.fill();

  // --- 4. PERUT KREM/LEMOT (Drawn inside using clipping or strategic layering) ---
  petCtx.fillStyle = "#EAE2B7"; // Krem hangat pekat untuk perut bawah
  petCtx.beginPath();
  petCtx.ellipse(cx, cy + 30, 45, 28, 0, 0, Math.PI * 2);
  petCtx.fill();

  // --- 5. BLUSH PINK LEMBUT (Pipi estetik bawah mata) ---
  petCtx.fillStyle = "rgba(255, 105, 180, 0.5)";
  petCtx.beginPath();
  petCtx.ellipse(cx - 38, cy + 0, 12, 8, 0, 0, Math.PI * 2);
  petCtx.fill();
  petCtx.beginPath();
  petCtx.ellipse(cx + 38, cy + 0, 12, 8, 0, 0, Math.PI * 2);
  petCtx.fill();

  // --- 6. MATA RAKSASA MELIRIK (Gaya Desert Rain Frog) ---
  // Posisi mata katak ini agak menonjol ke atas luar kepala
  drawDesertFrogEye(cx - 28, cy - 25, mx, my);
  drawDesertFrogEye(cx + 28, cy - 25, mx, my);

  // --- 7. HIDUNG & MULUT MINIMALIS ---
  // Garis mulut datar/sedikit melengkung kecil khas katak pasrah
  petCtx.strokeStyle = "#3D405B";
  petCtx.lineWidth = 2.5;
  petCtx.lineCap = "round";

  // Garis mulut kecil tepat di tengah di antara mata bawah
  petCtx.beginPath();
  petCtx.arc(cx, cy - 2, 4, 0.2, Math.PI - 0.2);
  petCtx.stroke();
}

// Fungsi pembantu khusus mata katak referensi (Iris Kuning tebal + Pupil Hitam Raksasa)
function drawDesertFrogEye(ecx, ecy, mx, my) {
  // 1. Outline/Kelopak luar mata hijau
  petCtx.fillStyle = "#A3B18A";
  petCtx.beginPath();
  petCtx.arc(ecx, ecy, 20, 0, Math.PI * 2);
  petCtx.fill();

  // 2. Iris Kuning/Oranye Terang tebal
  petCtx.fillStyle = "#F4A261"; // Oranye/kuning hangat pastel
  petCtx.beginPath();
  petCtx.arc(ecx, ecy, 17, 0, Math.PI * 2);
  petCtx.fill();

  // Lingkaran dalam kuning terang mendominasi sebelum pupil
  petCtx.fillStyle = "#E9C46A";
  petCtx.beginPath();
  petCtx.arc(ecx, ecy, 15, 0, Math.PI * 2);
  petCtx.fill();

  // Hitung lirikan pointer mouse
  let angle = Math.atan2(my - ecy, mx - ecx);
  let dist = Math.min(
    Math.sqrt(Math.pow(mx - ecx, 2) + Math.pow(my - ecy, 2)),
    2.5,
  ); // Gerakan pupil smooth kecil
  let pupilX = ecx + Math.cos(angle) * dist;
  let pupilY = ecy + Math.sin(angle) * dist;

  // 3. Pupil Hitam Raksasa (Sangat bulat dan besar)
  petCtx.fillStyle = "#1D1E2C";
  petCtx.beginPath();
  petCtx.arc(pupilX, pupilY, 11, 0, Math.PI * 2);
  petCtx.fill();

  // 4. Pantulan Cahaya Putih (Binar mata kecil di pojok atas)
  petCtx.fillStyle = "#FFFFFF";
  petCtx.beginPath();
  petCtx.arc(pupilX - 4, pupilY - 4, 2.5, 0, Math.PI * 2);
  petCtx.fill();
}

function drawCat(mx, my, cx, cy) {
  if (!petCtx) return;

  // 1. Kaki Kecil di Bawah (Efek Perspektif dari Atas)
  petCtx.fillStyle = "#8C6A5C";
  // Kaki Kiri
  petCtx.beginPath();
  petCtx.ellipse(cx - 25, cy + 120, 15, 10, 0, 0, Math.PI * 2);
  petCtx.fill();
  // Kaki Kanan
  petCtx.beginPath();
  petCtx.ellipse(cx + 25, cy + 120, 15, 10, 0, 0, Math.PI * 2);
  petCtx.fill();

  // Detail Cakar Kaki
  petCtx.strokeStyle = "#402E2B";
  petCtx.lineWidth = 2;
  for (let i = -1; i <= 1; i++) {
    petCtx.beginPath();
    petCtx.moveTo(cx - 25 + i * 5, cy + 115);
    petCtx.lineTo(cx - 25 + i * 5, cy + 128);
    petCtx.stroke();
    petCtx.beginPath();
    petCtx.moveTo(cx + 25 + i * 5, cy + 115);
    petCtx.lineTo(cx + 25 + i * 5, cy + 128);
    petCtx.stroke();
  }

  // 2. Badan Mengecil di Bawah Kepala
  petCtx.fillStyle = "#A98473";
  petCtx.beginPath();
  petCtx.moveTo(cx - 40, cy + 30);
  petCtx.quadraticCurveTo(cx - 45, cy + 90, cx - 25, cy + 120);
  petCtx.lineTo(cx + 25, cy + 120);
  petCtx.quadraticCurveTo(cx + 45, cy + 90, cx + 40, cy + 30);
  petCtx.closePath();
  petCtx.fill();

  // 3. Telinga Lebar & Tegak (Digambar di belakang kepala)
  petCtx.fillStyle = "#8C6A5C";
  // Telinga Kiri
  petCtx.beginPath();
  petCtx.moveTo(cx - 75, cy - 10);
  petCtx.lineTo(cx - 85, cy - 90);
  petCtx.lineTo(cx - 25, cy - 45);
  petCtx.closePath();
  petCtx.fill();
  // Bagian dalam telinga kiri
  petCtx.fillStyle = "#B08A79";
  petCtx.beginPath();
  petCtx.moveTo(cx - 70, cy - 15);
  petCtx.lineTo(cx - 78, cy - 80);
  petCtx.lineTo(cx - 32, cy - 43);
  petCtx.closePath();
  petCtx.fill();

  // Telinga Kanan
  petCtx.fillStyle = "#8C6A5C";
  petCtx.beginPath();
  petCtx.moveTo(cx + 75, cy - 10);
  petCtx.lineTo(cx + 85, cy - 90);
  petCtx.lineTo(cx + 25, cy - 45);
  petCtx.closePath();
  petCtx.fill();
  // Bagian dalam telinga kanan
  petCtx.fillStyle = "#B08A79";
  petCtx.beginPath();
  petCtx.moveTo(cx + 70, cy - 15);
  petCtx.lineTo(cx + 78, cy - 80);
  petCtx.lineTo(cx + 32, cy - 43);
  petCtx.closePath();
  petCtx.fill();

  // 4. Kepala Bulat Besar Melebar (Fisheye)
  petCtx.fillStyle = "#A98473";
  petCtx.beginPath();
  petCtx.ellipse(cx, cy, 95, 80, 0, 0, Math.PI * 2);
  petCtx.fill();

  // 5. Corak Loreng (Stripes) di Jidat & Pipi
  petCtx.fillStyle = "#362624";

  // Loreng Jidat Tengah
  petCtx.beginPath();
  petCtx.moveTo(cx - 5, cy - 75);
  petCtx.lineTo(cx, cy - 30);
  petCtx.lineTo(cx + 5, cy - 75);
  petCtx.fill();
  petCtx.beginPath();
  petCtx.moveTo(cx - 20, cy - 70);
  petCtx.quadraticCurveTo(cx - 10, cy - 45, cx - 12, cy - 35);
  petCtx.lineTo(cx - 22, cy - 65);
  petCtx.fill();
  petCtx.beginPath();
  petCtx.moveTo(cx + 20, cy - 70);
  petCtx.quadraticCurveTo(cx + 10, cy - 45, cx + 12, cy - 35);
  petCtx.lineTo(cx + 22, cy - 65);
  petCtx.fill();

  // Loreng Pipi Kiri & Kanan
  for (let i = 0; i < 3; i++) {
    petCtx.beginPath();
    petCtx.moveTo(cx - 90, cy - 10 + i * 15);
    petCtx.lineTo(cx - 50, cy + i * 10);
    petCtx.lineTo(cx - 85, cy + 5 + i * 15);
    petCtx.fill();

    // Kanan
    petCtx.beginPath();
    petCtx.moveTo(cx + 90, cy - 10 + i * 15);
    petCtx.lineTo(cx + 50, cy + i * 10);
    petCtx.lineTo(cx + 85, cy + 5 + i * 15);
    petCtx.fill();
  }

  // 6. Mata Marah/Galak Warna Kuning Terang
  drawAngryYellowEye(cx - 35, cy - 5, mx, my, true);
  drawAngryYellowEye(cx + 35, cy - 5, mx, my, false);

  // 7. Hidung Segitiga Pink Tua / Merah Gelap
  petCtx.fillStyle = "#9C3D3D";
  petCtx.beginPath();
  petCtx.moveTo(cx - 8, cy + 22);
  petCtx.lineTo(cx + 8, cy + 22);
  petCtx.lineTo(cx, cy + 32);
  petCtx.closePath();
  petCtx.fill();

  // Batang hidung atas (shadow)
  petCtx.fillStyle = "#594036";
  petCtx.beginPath();
  petCtx.moveTo(cx - 8, cy + 22);
  petCtx.lineTo(cx + 8, cy + 22);
  petCtx.lineTo(cx + 4, cy + 5);
  petCtx.lineTo(cx - 4, cy + 5);
  petCtx.fill();

  // 8. Mulut Serius (Garis Tipis ke Bawah)
  petCtx.strokeStyle = "#2B1E1C";
  petCtx.lineWidth = 3;
  petCtx.lineCap = "round";
  petCtx.beginPath();
  petCtx.moveTo(cx, cy + 32);
  petCtx.lineTo(cx, cy + 40);
  petCtx.stroke();

  petCtx.beginPath();
  petCtx.moveTo(cx - 10, cy + 43);
  petCtx.quadraticCurveTo(cx, cy + 38, cx + 10, cy + 43);
  petCtx.stroke();

  // 9. Kumis Putih yang Panjang & Tegas
  petCtx.strokeStyle = "#FFFFFF";
  petCtx.lineWidth = 2.5;
  // Kumis Kiri
  for (let i = 0; i < 3; i++) {
    petCtx.beginPath();
    petCtx.moveTo(cx - 40, cy + 30 + i * 3);
    petCtx.lineTo(cx - 140, cy + 20 + i * 20);
    petCtx.stroke();
  }
  // Kumis Kanan
  for (let i = 0; i < 3; i++) {
    petCtx.beginPath();
    petCtx.moveTo(cx + 40, cy + 30 + i * 3);
    petCtx.lineTo(cx + 140, cy + 20 + i * 20);
    petCtx.stroke();
  }
}

// Fungsi Baru untuk Menggambar Mata Kuning yang Galak/Tajam
function drawAngryYellowEye(ecx, ecy, mx, my, isLeft) {
  if (!petCtx) return;

  petCtx.save();
  // Kemiringan kelopak mata agar tetap terlihat intens/galak
  petCtx.translate(ecx, ecy);
  petCtx.rotate(isLeft ? 0.15 : -0.15);

  // Sclera/Mata Kuning Cerah
  petCtx.fillStyle = "#D6E61C";
  petCtx.beginPath();
  petCtx.ellipse(0, 0, 24, 15, 0, 0, Math.PI * 2);
  petCtx.fill();

  // Efek Kelopak Mata Atas Hitam (Mata melotot tajam)
  petCtx.fillStyle = "#261917";
  petCtx.beginPath();
  petCtx.ellipse(0, -6, 26, 12, 0, 0, Math.PI * 2);
  petCtx.fill();

  // Mengembalikan area kuning secara proporsional
  petCtx.fillStyle = "#D6E61C";
  petCtx.beginPath();
  petCtx.ellipse(0, 4, 22, 10, 0, 0, Math.PI * 2);
  petCtx.fill();

  // Perhitungan Interaktivitas Pergerakan Pupil
  let angle = Math.atan2(my - ecy, mx - ecx);
  let dist = Math.min(
    Math.sqrt(Math.pow(mx - ecx, 2) + Math.pow(my - ecy, 2)),
    3,
  ); // Jarak gerak dikurangi sedikit agar pupil besar tidak keluar jalur
  let pupilX = Math.cos(angle) * dist;
  let pupilY = Math.sin(angle) * dist + 1;

  // ===== PERUBAHAN DI SINI: Pupil Dibuat Besar & Bulat =====
  petCtx.fillStyle = "#0D0D0D";
  petCtx.beginPath();
  // Mengubah radius X dan Y menjadi hampir sama besar (11 dan 12) agar pupil melebar bulat seperti di gambar
  petCtx.ellipse(pupilX, pupilY, 11, 12, 0, 0, Math.PI * 2);
  petCtx.fill();

  // Sorot Lampu / Glare Putih (Sedikit digeser ke atas agar terlihat hidup)
  petCtx.fillStyle = "#FFFFFF";
  petCtx.beginPath();
  petCtx.arc(pupilX - 3, pupilY - 4, 2.5, 0, Math.PI * 2);
  petCtx.fill();

  petCtx.restore();
}

// Fungsi Gambar Anjing Mengintip (Fokus Utama pada Pilihan Anjing)
function drawDog(mx, my, cx, cy) {
  if (!petCtx) return;
  // Latar Kuning Tua
  petCtx.fillStyle = "#F5B016";
  petCtx.fillRect(cx - 150, cy - 150, 300, 300);

  // Bulu Hitam Kepala
  petCtx.fillStyle = "#1A1A1A";
  petCtx.beginPath();
  petCtx.ellipse(cx, cy + 50, 95, 80, 0, 0, Math.PI * 2);
  petCtx.fill();

  // Corak Putih Jidat
  petCtx.fillStyle = "#FFFFFF";
  petCtx.beginPath();
  petCtx.moveTo(cx - 12, cy + 50);
  petCtx.quadraticCurveTo(cx, cy - 25, cx, cy - 25);
  petCtx.quadraticCurveTo(cx, cy - 25, cx + 12, cy + 50);
  petCtx.closePath();
  petCtx.fill();

  // Mata Mendongak
  drawDogUpwardEye(cx - 42, cy + 10, mx, my);
  drawDogUpwardEye(cx + 42, cy + 10, mx, my);

  // Moncong Putih
  let muzzleGrad = petCtx.createLinearGradient(cx, cy + 10, cx, cy + 100);
  muzzleGrad.addColorStop(0, "#FFFFFF");
  muzzleGrad.addColorStop(1, "#EAEAEA");
  petCtx.fillStyle = muzzleGrad;
  petCtx.beginPath();
  petCtx.ellipse(cx, cy + 70, 65, 45, 0, 0, Math.PI * 2);
  petCtx.fill();

  // Hidung Hitam Besar
  petCtx.fillStyle = "#252525";
  petCtx.beginPath();
  petCtx.ellipse(cx, cy + 85, 42, 25, 0, 0, Math.PI * 2);
  petCtx.fill();
  petCtx.fillStyle = "rgba(255, 255, 255, 0.15)";
  petCtx.beginPath();
  petCtx.ellipse(cx, cy + 73, 20, 6, 0, 0, Math.PI * 2);
  petCtx.fill();
}

function drawDogUpwardEye(ecx, ecy, mx, my) {
  if (!petCtx) return;
  petCtx.strokeStyle = "#111111";
  petCtx.lineWidth = 1.5;
  petCtx.fillStyle = "#111111";
  petCtx.beginPath();
  petCtx.arc(ecx, ecy, 19, 0, Math.PI * 2);
  petCtx.fill();
  petCtx.stroke();

  petCtx.fillStyle = "#A66226";
  petCtx.beginPath();
  petCtx.arc(ecx, ecy, 17, 0, Math.PI * 2);
  petCtx.fill();
  petCtx.fillStyle = "rgba(40, 20, 5, 0.6)";
  petCtx.beginPath();
  petCtx.arc(ecx, ecy, 17, Math.PI, 0);
  petCtx.fill();

  let angle = Math.atan2(my - ecy, mx - ecx);
  let dist = Math.min(
    Math.sqrt(Math.pow(mx - ecx, 2) + Math.pow(my - ecy, 2)),
    4,
  );
  let pupilX = ecx + Math.cos(angle) * dist;
  let pupilY = ecy - 2 + Math.sin(angle) * dist;

  petCtx.fillStyle = "#1A1A1A";
  petCtx.beginPath();
  petCtx.arc(pupilX, pupilY, 11, 0, Math.PI * 2);
  petCtx.fill();
  petCtx.fillStyle = "rgba(255, 255, 255, 0.85)";
  petCtx.beginPath();
  petCtx.ellipse(pupilX - 2, pupilY - 4, 6, 3, Math.PI / 12, 0, Math.PI * 2);
  petCtx.fill();
  petCtx.fillStyle = "rgba(255, 255, 255, 0.3)";
  petCtx.beginPath();
  petCtx.arc(pupilX + 4, pupilY + 5, 2, 0, Math.PI * 2);
  petCtx.fill();
}

// Handler Emoji Cursor Picker Click
document.querySelectorAll(".emoji-picker span").forEach((btn) => {
  btn.addEventListener("click", () => {
    document
      .querySelectorAll(".emoji-picker span")
      .forEach((s) => s.classList.remove("active-cursor"));
    btn.classList.add("active-cursor");
    const selectedType = btn.getAttribute("data-animal");

    if (selectedType === "normal") {
      document.body.style.cursor = "auto";
      document.getElementById("petBubbleChat").innerText =
        "Kursor kamu kembali normal! Tapi aku tetap menemanimu di sini. 💻";
    } else {
      currentAnimal = selectedType;
      document.getElementById("petBubbleChat").innerText =
        `Kursor kamu berubah! Sekarang aku jadi ${currentAnimal}! 🐾`;
      const svgData = animalCursors[currentAnimal];
      document.body.style.cursor = `url("${svgData}") 4 4, auto`;
    }
    drawPet();
  });
});

// ==========================================
// AUDIO ALARM BUZZER SYSTEM
// ==========================================
function playBuzzerNotification() {
  try {
    const AudioContext = window.AudioContext || window.webkitAudioContext;
    if (!AudioContext) return;
    const audioCtx = new AudioContext();
    [0, 0.2, 0.4].forEach((delay) => {
      let osc = audioCtx.createOscillator();
      let gainNode = audioCtx.createGain();
      osc.type = "sine";
      osc.frequency.setValueAtTime(880, audioCtx.currentTime + delay);
      gainNode.gain.setValueAtTime(0.2, audioCtx.currentTime + delay);
      gainNode.gain.exponentialRampToValueAtTime(
        0.01,
        audioCtx.currentTime + delay + 0.12,
      );
      osc.connect(gainNode);
      gainNode.connect(audioCtx.destination);
      osc.start(audioCtx.currentTime + delay);
      osc.stop(audioCtx.currentTime + delay + 0.15);
    });
  } catch (e) {
    console.log("AudioContext blocked.");
  }
}

// ==========================================
// 3D WHEEL TIME PICKER MODULE
// ==========================================
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
  if (!col) return;
  col.innerHTML = '<div class="wheel-spacer-top-bottom"></div>';
  for (let i = 0; i <= maxVal; i++) {
    const item = document.createElement("div");
    item.className = "wheel-item";
    item.setAttribute("data-val", i);
    item.innerText = i.toString().padStart(2, "0");
    item.addEventListener("click", () => {
      if (!isRunning && !isPaused) {
        setWheelActiveValue(columnId, i);
        setTimeout(calculateTotalSecondsFromWheels, 50);
      }
    });
    col.appendChild(item);
  }
  const bottomSpacer = document.createElement("div");
  bottomSpacer.className = "wheel-spacer-top-bottom";
  col.appendChild(bottomSpacer);
}

let scrollTimeout = null;
function setupWheelScrollListener(columnId) {
  const col = document.getElementById(columnId);
  if (!col) return;
  col.addEventListener("scroll", () => {
    if (isRunning || isPaused) return;
    if (scrollTimeout) clearTimeout(scrollTimeout);
    scrollTimeout = setTimeout(() => {
      const items = col.querySelectorAll(".wheel-item");
      let centerItem = null,
        minDistance = Infinity;
      const containerCenter = col.scrollTop + col.offsetHeight / 2;
      items.forEach((item) => {
        const itemCenter = item.offsetTop + item.offsetHeight / 2;
        const dist = Math.abs(containerCenter - itemCenter);
        item.classList.remove("selected");
        if (dist < minDistance) {
          minDistance = dist;
          centerItem = item;
        }
      });
      if (centerItem) {
        centerItem.classList.add("selected");
        calculateTotalSecondsFromWheels();
      }
    }, 60);
  });
}

function setWheelActiveValue(columnId, val) {
  const col = document.getElementById(columnId);
  if (!col) return;
  const targetItem = col.querySelector(`.wheel-item[data-val="${val}"]`);
  if (targetItem) {
    col.scrollTop =
      targetItem.offsetTop - col.offsetHeight / 2 + targetItem.offsetHeight / 2;
    col
      .querySelectorAll(".wheel-item")
      .forEach((i) => i.classList.remove("selected"));
    targetItem.classList.add("selected");
  }
}

function calculateTotalSecondsFromWheels() {
  if (isRunning || isPaused) return;
  const activeHour = document.querySelector("#wheelHours .wheel-item.selected");
  const activeMin = document.querySelector(
    "#wheelMinutes .wheel-item.selected",
  );
  const activeSec = document.querySelector(
    "#wheelSeconds .wheel-item.selected",
  );
  let h = activeHour ? parseInt(activeHour.getAttribute("data-val")) : 0;
  let m = activeMin ? parseInt(activeMin.getAttribute("data-val")) : 0;
  let s = activeSec ? parseInt(activeSec.getAttribute("data-val")) : 0;
  let total = h * 3600 + m * 60 + s;
  if (currentMode === "focus") userFocusSeconds = total;
  else userBreakSeconds = total;
  currentSeconds = total;
  totalDurationInMode = total;
  updateTimerDisplay();
}

// ==========================================
// LOCAL STORAGE DATA & STATE
// ==========================================
function loadStorageData() {
  const savedStats = localStorage.getItem("pomostep_stats");
  if (savedStats) {
    try {
      stats = { ...stats, ...JSON.parse(savedStats) };
    } catch (e) {}
  }
  const savedTasks = localStorage.getItem("pomostep_tasks");
  if (savedTasks) {
    try {
      tasks = JSON.parse(savedTasks);
    } catch (e) {}
  }

  const inputMenit = document.getElementById("inputMaxMenit");
  const inputTugas = document.getElementById("inputMaxTugas");
  if (inputMenit) inputMenit.value = stats.customMaxMenit || 0;
  if (inputTugas) inputTugas.value = stats.customMaxTugas || 0;

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

// ==========================================
// CALENDER RENDERING SYSTEM
// ==========================================
const monthNames = [
  "Januari",
  "Februari",
  "Maret",
  "April",
  "Mei",
  "Juni",
  "Juli",
  "Agustus",
  "September",
  "Oktober",
  "November",
  "Desember",
];
function renderCalendar(year, month) {
  const title = document.getElementById("calendarMonthYearTitle");
  if (title) title.innerText = `${monthNames[month]} ${year}`;
  const container = document.getElementById("calendarDaysContainer");
  if (!container) return;
  const labels = container.querySelectorAll(".calendar-day-label");
  container.innerHTML = "";
  labels.forEach((l) => container.appendChild(l));
  const numDays = new Date(year, month + 1, 0).getDate();
  const startDayIdx = new Date(year, month, 1).getDay();
  for (let i = 0; i < startDayIdx; i++)
    container.appendChild(document.createElement("div"));
  for (let day = 1; day <= numDays; day++) {
    const cell = document.createElement("div");
    cell.className = "calendar-cell";
    cell.innerText = day;
    const loopDateStr = `${year}-${(month + 1).toString().padStart(2, "0")}-${day.toString().padStart(2, "0")}`;
    cell.setAttribute("data-date", loopDateStr);

    if (tasks.some((t) => t.date === loopDateStr)) {
      cell.classList.add("has-event");
    }
    if (selectedFilterDate === loopDateStr)
      cell.classList.add("active-selected");
    container.appendChild(cell);
  }
}

// Event delegation untuk calendar cells - hindari event listener accumulation
document
  .getElementById("calendarDaysContainer")
  ?.addEventListener("click", (e) => {
    const cell = e.target.closest(".calendar-cell");
    if (cell) {
      const dateStr = cell.getAttribute("data-date");
      selectedFilterDate = dateStr;
      document
        .querySelectorAll(".calendar-cell")
        .forEach((c) => c.classList.remove("active-selected"));
      cell.classList.add("active-selected");
      renderTasks();
    }
  });

// ==========================================
// TASK MANAJEMEN LOGIC
// ==========================================
function renderTasks() {
  const todoList = document.getElementById("todoList");
  if (!todoList) return;
  todoList.innerHTML = "";
  const filtered = tasks.filter((t) => t.date === selectedFilterDate);
  if (filtered.length === 0) {
    todoList.innerHTML = `<div class="text-center py-4 text-muted small"><i class="bi bi-calendar-x d-block fs-4 mb-1"></i> Tidak ada kegiatan pada tanggal ini.</div>`;
    return;
  }
  filtered.forEach((task) => {
    const globalIndex = tasks.findIndex(
      (t) =>
        t.text === task.text && t.date === task.date && t.time === task.time,
    );
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
}

// Event delegation untuk task items - hindari event listener accumulation
document.getElementById("todoList")?.addEventListener("change", (e) => {
  if (e.target.matches('.todo-item-custom input[type="checkbox"]')) {
    tasks[parseInt(e.target.getAttribute("data-index"))].completed =
      e.target.checked;
    saveData();
  }
});

document.getElementById("todoList")?.addEventListener("click", (e) => {
  if (e.target.closest(".btn-delete-task")) {
    const btn = e.target.closest(".btn-delete-task");
    tasks.splice(parseInt(btn.getAttribute("data-index")), 1);
    saveData();
    renderTasks();
  }
});

function escapeHtml(str) {
  return str.replace(/[&<>]/g, function (m) {
    if (m === "&") return "&amp;";
    if (m === "<") return "&lt;";
    if (m === ">") return "&gt;";
    return m;
  });
}

document
  .getElementById("modalTaskForm")
  ?.addEventListener("submit", function (e) {
    e.preventDefault();
    const text = document.getElementById("formTaskText").value.trim();
    const subject = document.getElementById("formTaskSubject").value.trim();
    const date = document.getElementById("formTaskDate").value;
    const time = document.getElementById("formTaskTime").value;
    if (text && subject && date && time) {
      tasks.push({
        text,
        subject,
        date,
        time,
        completed: false,
        alarmed: false,
      });
      selectedFilterDate = date;
      saveData();
      renderTasks();
      bootstrap.Modal.getInstance(
        document.getElementById("addTaskModal"),
      ).hide();
      document.getElementById("modalTaskForm").reset();
    }
  });

// ==========================================
// BACKGROUND REALTIME ALARM TICKER
// ==========================================
setInterval(function checkAlarmTicker() {
  const now = new Date();
  const todayStr = `${now.getFullYear()}-${(now.getMonth() + 1).toString().padStart(2, "0")}-${now.getDate().toString().padStart(2, "0")}`;
  const currentHrsMins = `${now.getHours().toString().padStart(2, "0")}:${now.getMinutes().toString().padStart(2, "0")}`;
  tasks.forEach((task) => {
    if (
      task.date === todayStr &&
      task.time === currentHrsMins &&
      !task.alarmed &&
      !task.completed
    ) {
      task.alarmed = true;
      saveData();
      playBuzzerNotification();

      const banner = document.getElementById("liveAlarmAlertBanner");
      const message = document.getElementById("alarmAlertMessage");
      if (banner && message) {
        banner.classList.remove("d-none");
        message.innerText = `[ALARM KULIAH] ${task.subject.toUpperCase()} - ${task.text}`;
      }
      document
        .getElementById("timer-section")
        ?.scrollIntoView({ behavior: "smooth", block: "start" });
    }
  });
}, 1000);

function dismissLiveAlarm() {
  document.getElementById("liveAlarmAlertBanner")?.classList.add("d-none");
}

// ==========================================
// DASHBOARD STREAK & STATISTIK UI
// ==========================================
function verifyStreakLogic() {
  const todayStr = new Date().toDateString();
  if (stats.lastStreakDate) {
    const diffDays = Math.floor(
      Math.abs(new Date(todayStr) - new Date(stats.lastStreakDate)) /
        (1000 * 60 * 60 * 24),
    );
    if (diffDays > 1) {
      stats.weeklyStreak = 0;
      saveData();
    }
  }
}

function triggerStreakIncrement() {
  const todayStr = new Date().toDateString();
  if (stats.lastStreakDate !== todayStr) {
    stats.weeklyStreak += 1;
    stats.lastStreakDate = todayStr;
  }
}

function updateStatsUI() {
  let nowObj = new Date();
  let todayStr = `${nowObj.getFullYear()}-${(nowObj.getMonth() + 1).toString().padStart(2, "0")}-${nowObj.getDate().toString().padStart(2, "0")}`;
  let todayTasks = tasks.filter((t) => t.date === todayStr);
  let todayTasksCompletedCount = todayTasks.filter((t) => t.completed).length;
  let allTasksCount = tasks.length;
  let totalTugasHariIni = todayTasks.length; 
  let targetTugasHariIni = stats.customMaxTugas || 0;
  let totalAkumulatifTargetSemua = targetTugasHariIni + allTasksCount;
  let totalSeluruhTugasSelesai = tasks.filter((t) => t.completed).length;

  const bindings = {
    dashActiveBreakCount: stats.activeBreakCompleted,
    targetMenitFokus: stats.focusMinutesTotal,
    totalMenitFokusKeseluruhan: stats.focusMinutesTotal,
    dashWeeklyStreak: stats.weeklyStreak,
    dashTotalSessionsToday: stats.totalFocusSessionsToday,
    targetTugasSelesai: todayTasksCompletedCount,
    targetTugasHariIniTotal: totalTugasHariIni, 
    totalTugasSelesaiKeseluruhan: totalSeluruhTugasSelesai,
    totalTugasKeseluruhanSemua: totalAkumulatifTargetSemua,
    capaianTotalSesi: stats.totalFocusSessionsToday,
    capaianRataRata:
      (stats.totalFocusSessionsToday > 0
        ? Math.round(stats.focusMinutesTotal / stats.totalFocusSessionsToday)
        : 0) + " m/sesi",
  };

  for (let key in bindings) {
    const el = document.getElementById(key);
    if (el) el.innerText = bindings[key];
  }

  // Ring Progress Hari Ini
  let maxMenit = stats.customMaxMenit || 0;
  let percentToday =
    maxMenit > 0
      ? Math.min(100, Math.round((stats.focusMinutesTotal / maxMenit) * 100))
      : 0;
  const tPercentToday = document.getElementById("dashProgressPercentText");
  if (tPercentToday) tPercentToday.innerText = percentToday + "%";
  const rRingToday = document.getElementById("dashCircularProgressRing");
  if (rRingToday)
    rRingToday.style.strokeDashoffset = 408.4 - (408.4 * percentToday) / 100;

  // Ring Progress Total Kumulatif
  let percentAll =
    totalAkumulatifTargetSemua > 0
      ? Math.min(
          100,
          Math.round(
            (totalSeluruhTugasSelesai / totalAkumulatifTargetSemua) * 100,
          ),
        )
      : 0;
  const tPercentAll = document.getElementById("dashProgressPercentTextAll");
  if (tPercentAll) tPercentAll.innerText = percentAll + "%";
  const rRingAll = document.getElementById("dashCircularProgressRingAll");
  if (rRingAll)
    rRingAll.style.strokeDashoffset = 408.4 - (408.4 * percentAll) / 100;
}

function renderMemos() {
  const area = document.getElementById("memoLogArea");
  if (!area) return;
  if (!stats.memos || stats.memos.length === 0) {
    area.innerHTML = `<div class="small text-muted italic text-center py-3">Belum ada rekaman fokus.</div>`;
    return;
  }
  let htmlContent = "";
  stats.memos.forEach((m) => {
    htmlContent += `<div class="memo-log-item"><b>[${m.time}]</b> ${m.text}</div>`;
  });
  area.innerHTML = htmlContent;
}

function createFocusMemo() {
  setTimeout(() => {
    let memoModalEl = document.getElementById("memoModal");
    let memoInput = document.getElementById("memoInput");

    // If modal not present in DOM, create it dynamically and append to body
    if (!memoModalEl || !memoInput) {
      const wrapper = document.createElement("div");
      wrapper.innerHTML = `
      <div class="modal fade" id="memoModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Catatan Sesi</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <p id="memoModalMsg" class="small text-muted">Sesi selesai. Tulis ringkasan singkat kegiatan Anda:</p>
              <textarea id="memoInput" class="form-control" rows="3" placeholder="Tulis catatan singkat..."></textarea>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Lewati</button>
              <button type="button" class="btn btn-primary" id="memoSaveBtn">OK</button>
            </div>
          </div>
        </div>
      </div>`;
      document.body.appendChild(wrapper);
      memoModalEl = document.getElementById("memoModal");
      memoInput = document.getElementById("memoInput");
    }

    if (!memoModalEl || !memoInput) return;
    memoInput.value = "";
    const memoModal = new bootstrap.Modal(memoModalEl);

    memoModalEl.addEventListener("shown.bs.modal", () => memoInput.focus(), {
      once: true,
    });

    const saveHandler = () => {
      const text =
        memoInput.value && memoInput.value.trim() !== ""
          ? memoInput.value.trim()
          : "Menyelesaikan fokus kustom wheel-scroll.";
      const now = new Date();
      const formatTimeClock = now.toLocaleTimeString([], {
        hour: "2-digit",
        minute: "2-digit",
      });
      if (!stats.memos) stats.memos = [];
      stats.memos.unshift({ time: formatTimeClock, text });
      if (stats.memos.length > 20) stats.memos.pop();
      saveData();
      renderMemos();
      memoModal.hide();
    };

    const saveBtn = document.getElementById("memoSaveBtn");
    if (saveBtn) saveBtn.addEventListener("click", saveHandler, { once: true });
    // Allow Enter (without Shift) to submit the memo quickly
    memoInput.addEventListener(
      "keydown",
      (ev) => {
        if (ev.key === "Enter" && !ev.shiftKey) {
          ev.preventDefault();
          saveHandler();
        }
      },
      { once: true },
    );
    memoModal.show();
  }, 600);
}

// ==========================================
// CORE POMODORO TIMER ENGINE
// ==========================================
function updateTimerDisplay() {
  const timerDisp = document.getElementById("timerDisplay");
  if (!timerDisp) return;
  let hrs = Math.floor(currentSeconds / 3600);
  let mins = Math.floor((currentSeconds % 3600) / 60);
  let secs = currentSeconds % 60;
  timerDisp.innerText = `${hrs.toString().padStart(2, "0")}:${mins.toString().padStart(2, "0")}:${secs.toString().padStart(2, "0")}`;

  let barPercent =
    totalDurationInMode > 0 ? (currentSeconds / totalDurationInMode) * 100 : 0;
  const timerBar = document.getElementById("timerRingBar");
  if (timerBar) timerBar.style.width = barPercent + "%";
}

function stopTimer() {
  if (timerInterval) {
    clearInterval(timerInterval);
    timerInterval = null;
  }
  isRunning = false;
  isPaused = true;
  document.getElementById("globalWheelWrapper")?.classList.add("locked");
  setButtonVisualState("pause");
}

function startTimer() {
  const activeHour = document.querySelector("#wheelHours .wheel-item.selected");
  const activeMin = document.querySelector(
    "#wheelMinutes .wheel-item.selected",
  );
  const activeSec = document.querySelector(
    "#wheelSeconds .wheel-item.selected",
  );
  let totalRoda = 0;
  if (activeHour && activeMin && activeSec) {
    totalRoda =
      parseInt(activeHour.getAttribute("data-val")) * 3600 +
      parseInt(activeMin.getAttribute("data-val")) * 60 +
      parseInt(activeSec.getAttribute("data-val"));
  }
  if (!isPaused) {
    if (totalRoda > 0) {
      currentSeconds = totalRoda;
      totalDurationInMode = totalRoda;
      if (currentMode === "focus") userFocusSeconds = totalRoda;
      else userBreakSeconds = totalRoda;
    } else if (currentSeconds <= 0) {
      userFocusSeconds = 25 * 60;
      currentSeconds = userFocusSeconds;
      totalDurationInMode = userFocusSeconds;
      setWheelActiveValue("wheelMinutes", 25);
    }
  }
  updateTimerDisplay();
  if (isRunning) return;
  if (!isPaused) {
    lockedHour = activeHour ? parseInt(activeHour.getAttribute("data-val")) : 0;
    lockedMin = activeMin ? parseInt(activeMin.getAttribute("data-val")) : 25;
    lockedSec = activeSec ? parseInt(activeSec.getAttribute("data-val")) : 0;
  }
  isRunning = true;
  isPaused = false;
  document.getElementById("globalWheelWrapper")?.classList.add("locked");
  setButtonVisualState("start");

  timerInterval = setInterval(() => {
    if (currentSeconds <= 0) {
      clearInterval(timerInterval);
      timerInterval = null;
      isRunning = false;
      isPaused = false;
      document.getElementById("globalWheelWrapper")?.classList.remove("locked");
      setButtonVisualState("reset");
      playBuzzerNotification();

      if (currentMode === "focus") {
        stats.focusMinutesTotal += Math.max(
          1,
          Math.round(totalDurationInMode / 60),
        );
        stats.totalFocusSessionsToday += 1;
        triggerStreakIncrement();
        saveData();
        // Tampilkan modal memo (tanpa alert)
        createFocusMemo();
        setMode("break");
      } else {
        stats.activeBreakCompleted += 1;
        saveData();
        // Break selesai — lanjutkan ke fokus tanpa alert
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
  const mText = document.getElementById("timerModeText");
  if (mText) {
    mText.innerText = mode === "focus" ? "Fokus Dimulai" : "Waktunya Istirahat";
    mText.className =
      mode === "focus"
        ? "small fw-bold text-uppercase text-success"
        : "small fw-bold text-uppercase text-warning";
  }
  document
    .getElementById("focusModeBtn")
    ?.classList.toggle("active", mode === "focus");
  document
    .getElementById("breakModeBtn")
    ?.classList.toggle("active", mode === "break");
  if (timerInterval) {
    clearInterval(timerInterval);
    timerInterval = null;
  }
  isRunning = false;
  isPaused = false;
  document.getElementById("globalWheelWrapper")?.classList.remove("locked");
  setButtonVisualState("reset");
  currentSeconds = mode === "focus" ? userFocusSeconds : userBreakSeconds;
  totalDurationInMode = currentSeconds;
  updateTimerDisplay();
}

function setButtonVisualState(activeBtnId) {
  const btnStart = document.getElementById("startTimerBtn");
  const btnPause = document.getElementById("pauseTimerBtn");
  const btnReset = document.getElementById("resetTimerBtn");
  if (!btnStart || !btnPause || !btnReset) return;

  [btnStart, btnPause, btnReset].forEach((btn) =>
    btn.classList.remove("btn-status-active", "btn-status-inactive"),
  );
  if (activeBtnId === "reset") return;
  if (activeBtnId === "start") {
    btnStart.classList.add("btn-status-active");
    btnPause.classList.add("btn-status-inactive");
    btnReset.classList.add("btn-status-inactive");
  } else if (activeBtnId === "pause") {
    btnPause.classList.add("btn-status-active");
    btnStart.classList.add("btn-status-inactive");
    btnReset.classList.add("btn-status-inactive");
  }
}

// ==========================================
// CORE DOM & NAVIGATION EVENT LISTENERS
// ==========================================
document.getElementById("startTimerBtn")?.addEventListener("click", startTimer);
document.getElementById("pauseTimerBtn")?.addEventListener("click", stopTimer);
document
  .getElementById("resetTimerBtn")
  ?.addEventListener("click", () => setMode(currentMode));
document
  .getElementById("focusModeBtn")
  ?.addEventListener("click", () => setMode("focus"));
document
  .getElementById("breakModeBtn")
  ?.addEventListener("click", () => setMode("break"));

document.getElementById("btnFocusNow")?.addEventListener("click", () => {
  document
    .querySelectorAll(".nav-pill-custom")
    .forEach((p) => p.classList.remove("active"));
  document
    .querySelector('[data-target="timer-section"]')
    ?.classList.add("active");
  document
    .getElementById("timer-section")
    ?.scrollIntoView({ behavior: "smooth", block: "start" });
});

document.getElementById("btnSeeTasks")?.addEventListener("click", () => {
  document
    .querySelectorAll(".nav-pill-custom")
    .forEach((p) => p.classList.remove("active"));
  document
    .querySelector('[data-target="tugas-section"]')
    ?.classList.add("active");
  document
    .getElementById("tugas-section")
    ?.scrollIntoView({ behavior: "smooth", block: "start" });
});

document.getElementById("resetDataBtn")?.addEventListener("click", () => {
  const modalEl = document.getElementById("confirmResetModal");
  if (modalEl) {
    bootstrap.Modal.getOrCreateInstance(modalEl).show();
  } else {
    // fallback to open a simple confirm if modal missing
    if (confirm("Apakah Anda yakin ingin reset semua data?")) {
      localStorage.clear();
      location.reload();
    }
  }
});

document.getElementById("confirmResetBtn")?.addEventListener("click", () => {
  localStorage.clear();
  stats = {
    activeBreakCompleted: 0,
    focusMinutesTotal: 0,
    weeklyStreak: 0,
    lastStreakDate: null,
    totalFocusSessionsToday: 0,
    memos: [],
    customMaxMenit: 0,
    customMaxTugas: 0,
  };
  tasks = [];
  userFocusSeconds = 0;
  userBreakSeconds = 0;
  const inMenit = document.getElementById("inputMaxMenit");
  const inTugas = document.getElementById("inputMaxTugas");
  if (inMenit) inMenit.value = 0;
  if (inTugas) inTugas.value = 0;
  const nowD = new Date();
  selectedFilterDate = `${nowD.getFullYear()}-${(nowD.getMonth() + 1).toString().padStart(2, "0")}-${nowD.getDate().toString().padStart(2, "0")}`;
  setMode("focus");
  loadStorageData();
  // Tutup modal setelah reset
  const modalElement = document.getElementById("confirmResetModal");
  if (modalElement) {
    const modal = bootstrap.Modal.getInstance(modalElement);
    if (modal) modal.hide();
  }
  showNotification("✅ Semua data berhasil direset!", "success", 1200);
  setTimeout(() => location.reload(), 900);
});

document.getElementById("inputMaxMenit")?.addEventListener("input", (e) => {
  let val = parseInt(e.target.value);
  stats.customMaxMenit = !isNaN(val) && val >= 0 ? val : 0;
  saveData();
});

document.getElementById("inputMaxTugas")?.addEventListener("input", (e) => {
  let val = parseInt(e.target.value);
  stats.customMaxTugas = !isNaN(val) && val >= 0 ? val : 0;
  saveData();
});

// Scroll Spy Tracker
window.addEventListener("scroll", () => {
  const targets = document.querySelectorAll(".scroll-target-marker");
  let currentActiveId = "dashboard-section";
  targets.forEach((section) => {
    if (section.getBoundingClientRect().top <= 180)
      currentActiveId = section.getAttribute("id");
  });
  const capsules = document.querySelectorAll(
    "#navCapsulesGroup .nav-pill-custom",
  );
  capsules.forEach((pill) => {
    const targetAttr = pill.getAttribute("data-target");
    if (targetAttr === currentActiveId) pill.classList.add("active");
    else pill.classList.remove("active");
  });
});

// Click To Scroll Navigation Setup
document.querySelectorAll(".nav-pill-custom").forEach((pill) => {
  pill.addEventListener("click", function () {
    const targetId = this.getAttribute("data-target");
    const targetSection = document.getElementById(targetId);

    if (targetSection) {
      targetSection.scrollIntoView({ behavior: "smooth", block: "start" });
      document
        .querySelectorAll(".nav-pill-custom")
        .forEach((p) => p.classList.remove("active"));
      this.classList.add("active");
    }
  });
});

document.addEventListener("DOMContentLoaded", () => {
  const darkModeToggle = document.getElementById("darkModeToggle");
  const htmlElement = document.documentElement;

  // 1. Cek apakah user sudah pernah memilih tema sebelumnya di localStorage
  const currentTheme = localStorage.getItem("theme");

  if (currentTheme === "dark") {
    // Jika preferensi sebelumnya gelap, terapkan mode gelap
    htmlElement.setAttribute("data-bs-theme", "dark"); // Untuk Bootstrap 5.3+
    document.body.classList.add("dark-mode"); // Untuk custom CSS
    darkModeToggle.checked = true;
  }

  // 2. Dengarkan event saat toggle di-klik
  darkModeToggle.addEventListener("change", (e) => {
    if (e.target.checked) {
      // Aktifkan mode gelap
      htmlElement.setAttribute("data-bs-theme", "dark");
      document.body.classList.add("dark-mode");
      localStorage.setItem("theme", "dark");
    } else {
      // Kembalikan ke mode terang
      htmlElement.setAttribute("data-bs-theme", "light");
      document.body.classList.remove("dark-mode");
      localStorage.setItem("theme", "light");
    }
  });
});

// ==========================================
// SYSTEM INITIALIZATION
// ==========================================
document.body.style.cursor = `url("${animalCursors["frog"]}") 4 4, auto`;
build3DWheelPicker();
loadStorageData();
verifyStreakLogic();
setMode("focus");
drawPet();
