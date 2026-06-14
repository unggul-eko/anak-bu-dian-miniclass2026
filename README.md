# PomoStep — anak-bu-dian-miniclass2026

Ringkasan

- PomoStep adalah aplikasi web sederhana untuk manajemen fokus (pomodoro-like), tugas, kalender, dan memo. Dibangun dengan PHP untuk struktur halaman dan JavaScript (vanilla) untuk logika timer, penyimpanan lokal, dan UI interaktif.

Fitur Utama

- Pengatur timer fokus & break dengan wheel picker
- Modal input memo saat sesi selesai (disimpan ke localStorage)
- Manajemen tugas dan kalender (tambah/hapus/checkbox)
- Statistik ringkas dengan chart (Chart.js)
- Mode gelap yang tersimpan di localStorage
- Notifikasi non-blok (banner/modal) untuk reset dan alarm

Struktur Proyek

- `index.php` — entry point (mengarah ke `page/utama.php`)
- `page/utama.php` — UI utama (dashboard, timer, tugas, memo)
- `page/statistik.php` — halaman statistik
- `js/skrip.js` — logika utama aplikasi (timer, tugas, memo, tema)
- `js/statistik.js` — helper untuk halaman statistik (chart)
- `css/tampilan.css` & `css/statistik.css` — stylesheet kustom
- `assets/` — gambar & ikon lokal

Persyaratan & Jalankan Lokal

1. Pasang XAMPP (atau stack LAMP/WAMP yang setara) dengan PHP.
2. Salin folder proyek ke `htdocs` (mis. `C:/xampp/htdocs/anak-bu-dian-miniclass2026`).
3. Jalankan Apache di XAMPP Control Panel.
4. Buka browser ke `http://localhost/anak-bu-dian-miniclass2026/page/utama.php`.

Catatan Pengembangan

- Gunakan Chrome/Edge/Firefox terbaru untuk dukungan Web Audio dan Modal Bootstrap.
- File utama untuk diedit:
  - `page/utama.php` untuk markup dan modal
  - `js/skrip.js` untuk logika timer, memo, storage
  - `css/tampilan.css` untuk styling tema gelap/terang
- Pastikan hanya satu versi Bootstrap CDN dimuat pada halaman.

Debugging Cepat

- Jika modal memo tidak muncul: refresh penuh (Ctrl+F5) dan pastikan `js/skrip.js` dimuat setelah Bootstrap bundle.
- Jika icon Bootstrap tidak muncul: periksa versi `bootstrap-icons` CDN.
- Untuk reset yang tidak bekerja: buka DevTools Console untuk melihat error JS terkait `confirmResetBtn` atau `resetDataBtn`.

Kontribusi

- Ini repo tugas/kelas — buat branch jika ingin menambah fitur lalu ajukan PR. Untuk perubahan cepat, cukup edit file di workspace lokal.

Lisensi

- Bebas untuk tujuan pembelajaran. Cantumkan kredit pembuat asli saat menggunakan kembali kode ini.

Kontak

- Untuk bantuan pengembangan, lampirkan screenshot console JS dan langkah reproduksi masalah saat membuka issue.
