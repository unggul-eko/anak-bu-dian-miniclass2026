<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
  <title>Anak Bu Dian Miniclass 2026</title>
  <!-- Google Fonts + Bootstrap Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(145deg, #d4e2d0 0%, #bdd3b5 100%);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* Container utama */
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 1.5rem;
      flex: 1;
    }

    /* Header dengan efek kaca */
    .glass-header {
      background: rgba(255, 255, 255, 0.85);
      backdrop-filter: blur(8px);
      border-radius: 2rem;
      padding: 1.2rem 1.8rem;
      margin-bottom: 2rem;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
      border: 1px solid rgba(255,255,255,0.4);
      text-align: center;
    }

    .glass-header h1 {
      font-size: 2rem;
      font-weight: 800;
      background: linear-gradient(135deg, #1b4d1b, #3c8c40);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      margin-bottom: 0.25rem;
    }

    .glass-header p {
      color: #2c5e2a;
      font-weight: 500;
    }

    /* Navigasi modern */
    nav {
      background: rgba(38, 70, 83, 0.75);
      backdrop-filter: blur(12px);
      border-radius: 3rem;
      margin-bottom: 2rem;
      padding: 0.25rem;
      box-shadow: 0 6px 14px rgba(0,0,0,0.1);
    }

    nav ul {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 0.25rem;
      list-style: none;
      margin: 0;
      padding: 0.5rem;
    }

    nav li {
      margin: 0;
    }

    nav a {
      display: inline-block;
      padding: 0.7rem 1.4rem;
      border-radius: 2rem;
      color: white;
      text-decoration: none;
      font-weight: 600;
      transition: all 0.2s ease;
      background: transparent;
    }

    nav a:hover {
      background: rgba(255,255,255,0.25);
      transform: translateY(-2px);
    }

    /* Kartu grid konten */
    .page-links {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 1.5rem;
      margin-top: 1rem;
    }

    .page-card {
      background: rgba(255, 255, 255, 0.92);
      backdrop-filter: blur(4px);
      border-radius: 1.8rem;
      padding: 1.6rem;
      transition: all 0.2s ease;
      border: 1px solid rgba(80,100,70,0.2);
      box-shadow: 0 12px 24px -12px rgba(0,0,0,0.1);
    }

    .page-card:hover {
      transform: translateY(-5px);
      background: rgba(255, 255, 255, 0.97);
      box-shadow: 0 20px 30px -12px rgba(0,0,0,0.15);
    }

    .page-card h2 {
      color: #1f3b1a;
      font-weight: 700;
      margin-bottom: 0.75rem;
      border-left: 5px solid #4caf50;
      padding-left: 0.8rem;
    }

    .page-card p {
      color: #2c4b26;
      line-height: 1.4;
      margin-bottom: 1rem;
    }

    .page-card a {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      background: #2c5e2a;
      color: white;
      padding: 0.5rem 1.2rem;
      border-radius: 2rem;
      text-decoration: none;
      font-weight: 600;
      transition: 0.2s;
    }

    .page-card a:hover {
      background: #1d421b;
      transform: scale(1.02);
    }

    /* Footer */
    footer {
      background: rgba(30, 40, 25, 0.85);
      backdrop-filter: blur(8px);
      color: white;
      text-align: center;
      padding: 1rem;
      border-radius: 2rem 2rem 0 0;
      margin-top: 2rem;
    }

    footer p {
      margin: 0;
      font-size: 0.9rem;
    }

    footer strong {
      color: #ffd966;
    }

    @media (max-width: 640px) {
      .container { padding: 1rem; }
      nav a { padding: 0.5rem 1rem; font-size: 0.85rem; }
      .glass-header h1 { font-size: 1.6rem; }
    }
  </style>
</head>
<body>
<div class="container">
  <!-- Header glassmorphism -->
  <div class="glass-header">
    <h1><i class="bi bi-stars"></i> Anak Bu Dian Miniclass 2026</h1>
    <p>Gunakan menu navigasi di bawah untuk menjelajahi setiap halaman</p>
  </div>

  <!-- Navigasi modern -->
  <nav>
    <ul>
      <li><a href="index.html"><i class="bi bi-house-door"></i> Beranda</a></li>
      <li><a href="tentang.html"><i class="bi bi-info-circle"></i> Tentang</a></li>
      <li><a href="jadwal.html"><i class="bi bi-calendar-week"></i> Jadwal</a></li>
      <li><a href="daftar.html"><i class="bi bi-pencil-square"></i> Daftar</a></li>
      <li><a href="kontak.html"><i class="bi bi-envelope"></i> Kontak</a></li>
    </ul>
  </nav>

  <!-- Konten utama dengan kartu-kartu tautan -->
  <section class="page-links">
    <div class="page-card">
      <h2><i class="bi bi-house-fill"></i> Beranda</h2>
      <p>Halaman utama Miniclass. Informasi terbaru dan pengumuman.</p>
      <a href="index.html">Kunjungi <i class="bi bi-arrow-right"></i></a>
    </div>
    <div class="page-card">
      <h2><i class="bi bi-people-fill"></i> Tentang</h2>
      <p>Pelajari lebih lanjut tentang Anak Bu Dian dan kegiatan miniclass.</p>
      <a href="tentang.html">Lihat Tentang <i class="bi bi-arrow-right"></i></a>
    </div>
    <div class="page-card">
      <h2><i class="bi bi-calendar-check"></i> Jadwal</h2>
      <p>Lihat jadwal lengkap sesi dan kegiatan miniclass 2026.</p>
      <a href="jadwal.html">Lihat Jadwal <i class="bi bi-arrow-right"></i></a>
    </div>
    <div class="page-card">
      <h2><i class="bi bi-person-plus"></i> Daftar</h2>
      <p>Isi formulir pendaftaran untuk bergabung dalam miniclass.</p>
      <a href="daftar.html">Daftar Sekarang <i class="bi bi-arrow-right"></i></a>
    </div>
    <div class="page-card">
      <h2><i class="bi bi-chat-dots"></i> Kontak</h2>
      <p>Hubungi kami untuk informasi lebih lanjut.</p>
      <a href="kontak.html">Hubungi <i class="bi bi-arrow-right"></i></a>
    </div>
  </section>
</div>

<?php include "page/footer/footer.html"; ?>
</body>
</html>