# Panduan Agent Proyek Website P3M PKTJ

<!-- antislop:start -->
## antislop
For UI, copy, people, mobile layout, or code comments work, read `.agents/skills/antislop/SKILL.md` (core) and then the skill for the task:
- UI / visual: `.agents/skills/antislop-ui/SKILL.md`
- Copy & text: `.agents/skills/antislop-copywriting/SKILL.md`
- People: `.agents/skills/antislop-human/SKILL.md`
- Mobile / responsive: `.agents/skills/antislop-layoutmobile/SKILL.md`
- Code comments: `.agents/skills/antislop-code/SKILL.md`

Before starting, follow the core's "Two Usage Modes" section in strict order: explicit session instruction first, then global preference, then ask. A session instruction always wins. For a resolved mode, say `antislop active: <mode> (session override).` or `antislop active: <mode> (global preference).` once before presenting findings or making edits, using the actual mode and source.

Arah desain utama mengacu pada [design.md](design.md) dan arsitektur fitur pada [PERENCANAAN_PROYEK_P3M.md](PERENCANAAN_PROYEK_P3M.md).

### Mandat Responsivitas Multi-Device (PC, Laptop, Tablet, Smartphone)
Setiap antarmuka yang dibuat atau diedit wajib mematuhi standar multi-device berikut:
1. **Fluid across breakpoints**: Wajib teruji dan tertata rapi di Smartphone (`< 640px`), Tablet (`640px - 1023px`), Laptop (`1024px - 1279px`), dan Desktop (`≥ 1280px`).
2. **Zero horizontal overflow**: Dilarang ada pergeseran layar horizontal (*no horizontal scrollbar*) pada mobile selain wadah tabel/data khusus.
3. **Touch ergonomics**: Elemen interaktif (tombol, input, link dropdown) minimal berukuran 44x44px untuk kemudahan tap pada layar sentuh.
4. **Adaptive Navigation & Tables**: Gunakan mobile drawer yang rapi pada smartphone/tablet dan penyajian tabel/grafik yang dapat menyesuaikan lebar layar secara otomatis.

### Mandat Sistem Spasial Grid 4px (Strict 4px Multiples Rule)
Seluruh styling antarmuka (Tailwind CSS) wajib tunduk pada kelipatan 4 pixel:
1. **Dimensi Spasial**: Semua margin, padding, gap, lebar, dan tinggi elemen wajib menggunakan skala kelipatan 4px (`p-1`=4px, `p-2`=8px, `p-3`=12px, `p-4`=16px, `p-5`=20px, `p-6`=24px, `p-8`=32px, `p-10`=40px, `p-12`=48px, dst).
2. **Tanpa Angka Acak/Ganjil**: Dilarang keras menggunakan arbitrary class bernilai ganjil / acak di luar kelipatan 4px (seperti `p-[13px]`, `m-[7px]`, `h-[37px]`).
3. **Line-Height & Radius**: Line height tipografi wajib mengunci kelipatan 4px (`leading-4`=16px, `leading-5`=20px, `leading-6`=24px, `leading-7`=28px, `leading-8`=32px, `leading-10`=40px) dan border-radius kelipatan 4 (`rounded`=4px, `rounded-lg`=8px, `rounded-xl`=12px, `rounded-2xl`=16px).

### Mandat Larangan Keras Emoji di Seluruh Sistem (Strict Zero-Emoji Policy)
1. **Dilarang Keras Menggunakan Emoji**: Dilarang keras menggunakan emoji di mana pun: baik pada kode program, antarmuka publik, antarmuka CMS admin, modal, tombol, alert banner, maupun dokumen proyek.
2. **Gunakan Ikon SVG Fungsional & Minimalis**: Ikon hanya digunakan jika memiliki nilai fungsi langsung (seperti search, download, chevron dropdown, close) dan wajib dirender menggunakan SVG berukuran presisi kelipatan 4 (contoh: `w-4 h-4` = 16px, `w-5 h-5` = 20px).

### Mandat Bahasa & Komunikasi (Bebas Jargon IT Rumit)
Dalam seluruh antarmuka aplikasi (label tombol, menu, navigasi, notifikasi, pesan status, formulir, maupun komunikasi):
1. **Dilarang Jargon IT Rumit**: Dilarang keras menggunakan istilah teknis komputer/koding yang membingungkan dosen dan masyarakat umum (seperti *payload, endpoint, schema, parsing, refactor, backend logic, rendering, entity*).
2. **Singkat, Padat, Jelas, dan Profesional**: Setiap teks antarmuka wajib lugas, formal, komunikatif, mudah dipahami civitas akademika, dan mencerminkan wibawa institusi Kementerian Perhubungan.
3. **Orientasi Pengguna (User-Centric)**: Selalu gunakan istilah operasional akademik yang akrab bagi dosen, misalnya: *Pengajuan Usulan* (bukan *form submission*), *Unduh Berkas* (bukan *download asset*), *Rincian Anggaran* (bukan *budget payload*), *Pemberitahuan* (bukan *notification event*).

### Mandat Larangan Kebocoran Catatan Teknis ke UI Publik (No Dev Notes in UI)
1. **Standar Teknis Hanya Ada di Kode & Dokumen**: Pedoman teknis seperti *Sistem Grid 4px*, *Multi-Device Responsive*, *Anti-AI Slop*, checklist pengerjaan, atau status kepatuhan adalah instruksi koding internal.
2. **Dilarang Keras Tampil di Layar Pengguna**: Dilarang keras mencantumkan teks, badge, label, atau watermark kepatuhan teknis tersebut di footer, header, atau bagian antarmuka manapun. Terapkan standar teknis ke dalam kualitas koding dan styling, jangan pernah dipamerkan sebagai teks pada UI publik.

### Mandat 3 Program Studi PKTJ (Hanya 3 Prodi)
Program Studi di lingkungan PKTJ Tegal hanya ada 3:
1. **D4 RSTJ**: Rekayasa Sistem Transportasi Jalan
2. **D4 TRO**: Teknologi Rekayasa Otomotif
3. **D3 TO**: Teknologi Otomotif
Dilarang keras menggunakan singkatan atau nama prodi di luar ketiga prodi tersebut dalam database, seeder, formulir, maupun tampilan antarmuka.

### Mandat Larangan Penggunaan Kata 'Resmi' (Strict Prohibited 'Resmi' Policy)
1. **Dilarang Keras Menggunakan Kata 'Resmi'**: Dilarang keras menggunakan kata "resmi" (baik huruf kecil, kapital, maupun kombinasi) pada seluruh antarmuka publik, antarmuka CMS admin, modal, tombol, alert banner, judul halaman, metadata, maupun dokumen PRD/proyek.
2. **Gunakan Padanan Kontekstual yang Lugas & Elegan**:
   - Ganti *"Website Resmi P3M"* / *"Portal Resmi"* ➔ *"Website P3M PKTJ"* atau *"Portal P3M PKTJ"*.
   - Ganti *"3 Program Studi Resmi PKTJ"* ➔ *"3 Program Studi di Lingkungan PKTJ"* atau *"3 Program Studi PKTJ"*.
   - Ganti *"Jurnal Resmi"* ➔ *"Jurnal Ilmiah P3M"* atau *"Jurnal Berkala P3M"*.
   - Ganti *"Email Resmi"* ➔ *"Email Kedinasan"*, *"Email Institusi"*, atau *"Email PKTJ"*.
   - Ganti *"Dokumen Resmi"* ➔ *"Dokumen Panduan"*, *"Dokumen Kelembagaan"*, atau *"Dokumen P3M"*.
   - Ganti *"Surat Keputusan Resmi"* ➔ *"Surat Keputusan Direktur"* atau *"SK Penetapan"*.

### Mandat Larangan Keras Membuka Browser Otomatis (No Autonomous Browser Launch)
1. **Dilarang Keras Membuka Browser Sendiri**: AI Agent dilarang keras membuka peramban/browser secara mandiri (baik melalui *browser subagent*, otomasi Chromium, maupun Puppeteer).
2. **Pengecekan Tampilan Mandiri oleh Pengguna**: Seluruh inspeksi dan pengecekan visual pada layar peramban (baik desktop, tablet, maupun mobile) adalah wewenang dan tugas pengguna secara langsung.
3. **Fokus Tugas AI Agent**: AI Agent fokus pada penulisan kode (Blade, PHP, Tailwind CSS, Alpine.js), kompilasi aset (`npm run build`), dan pengujian fitur via terminal CLI (`php artisan test`).

### Mandat Graphify Knowledge Graph (Query Konteks & Update Pasca Sesi)
1. **Pencarian Kode Relevan via `graphify query`**: Setiap kali akan memulai eksplorasi, meneliti arsitektur basis kode, atau merancang integrasi fitur baru, gunakan `graphify query "<kata kunci/pertanyaan>"` untuk menemukan node, file, dan relasi kode yang paling relevan dengan konteks.
2. **Pembaruan Graf Wajib Setiap Task Selesai**: Setiap kali satu sesi tasklist atau pengerjaan fitur selesai diuji, wajib mengeksekusi perintah `graphify update .` di terminal untuk menjaga knowledge graph proyek tetap sinkron dan mutakhir.

### Mandat Perencanaan & Wawancara Pengguna (Plan Mode & Grilling Interview)
1. **Wajib Rencana Implementasi Terarah (Plan Mode)**: Dilarang langsung menulis kode secara membabi buta tanpa rencana tertulis. Buat dokumen rencana kerja (*Implementation Plan*) yang memuat arsitektur database, alur UI/UX, rute, kontroler, dan skenario pengujian.
2. **Wawancara Pengguna ("Grill Me") Sebelum Eksekusi**: Lakukan proses wawancara/klarifikasi terstruktur (gunakan tool `ask_question` dengan opsi pilihan ganda yang tajam) untuk mendefinisikan apa yang ingin dikerjakan, preferensi tampilan, dan batasan operasional sebelum mulai mengedit kode, agar hasil implementasi terarah dan presisi sesuai kehendak pengguna.
<!-- antislop:end -->


