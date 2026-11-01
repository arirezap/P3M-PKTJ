# Daftar Tugas & Rencana Eksekusi Proyek P3M PKTJ

Dokumen ini adalah lembar kontrol (*task tracker*) pengembangan portal dan Sistem Informasi Manajemen Riset & Pengabdian kepada Masyarakat (SIM P3M) Politeknik Keselamatan Transportasi Jalan (PKTJ) Tegal.

---

## Ketentuan Kunci & Standar Baku (Wajib Dipedomani)
1. **Master Program Studi PKTJ Tegal (Hanya 3 Prodi)**:
   - **D4 RSTJ**: Rekayasa Sistem Transportasi Jalan
   - **D4 TRO**: Teknologi Rekayasa Otomotif
   - **D3 TO**: Teknologi Otomotif
2. **Sistem Spasial Grid 4px**: Seluruh margin, padding, gap, tinggi elemen, dan line-height wajib kelipatan 4px ($n \times 4\text{px}$).
3. **Mandat Bebas Emoji (Zero-Emoji Policy)**: Dilarang keras menggunakan emoji di manapun pada antarmuka maupun dokumen proyek. Semua ikon wajib berformat SVG minimalis dan terukur.
4. **Bahasa Lugas & Bebas Jargon IT Rumit**: Gunakan istilah akademik formal (Pengajuan Usulan, Unduh Berkas, Rincian Anggaran, Lembar Penilaian).
5. **Larangan Kebocoran Catatan Teknis (Zero Dev-Notes Leakage)**: Dilarang keras memunculkan teks/label internal pengembang pada UI publik.
6. **Peran Pengguna (3 Role)**:
   - **Admin P3M**: Kelola CMS konten publik, buka/tutup periode usulan, verifikasi berkas, tetapkan reviewer, dan keputusan pemenang hibah.
   - **Dosen / Peneliti**: Buat & kirim usulan proposal (Penelitian/Pengabdian), susun Rincian Anggaran Biaya (RAB), pantau status usulan, dan unggah revisi.
   - **Reviewer**: Akses usulan yang ditugaskan, beri nilai kriteria rubrik, catatan evaluasi, dan rekomendasi hasil.

---

## Progres & Checklist Tahapan Pengerjaan

### Tahap 1: Sinkronisasi Tampilan Publik & Basis Data Master
- [x] Perbaikan layout navbar responsif anti-patah & anti-menabrak.
- [x] Penerapan transisi animasi native halus pada landing page.
- [x] Pembersihan teks teknis internal pengembang pada footer.
- [x] Standardisasi Top Menu & Master Layout Publik (`layouts/public.blade.php`, `<x-public-navbar>`, `<x-public-footer>`):
  - [x] Pencatatan bab baku di `design.md` (Mandat Konsistensi Desain Global & Clean Code).
  - [x] Penghapusan duplikasi kode `<header>` dan `<footer>` di 8 berkas view publik (`welcome`, `profil/*`, `riset/*`).
  - [x] Penyelarasan susunan 7 menu baku secara identik di Beranda dan seluruh sub-halaman.
  - [x] Indikator visual otomatis (*Active State*): garis bawah kuning emas pada menu induk dan latar biru muda pada sub-menu yang sedang aktif.
  - [x] Drawer navigasi mobile yang seragam dan stabil di seluruh halaman.
- [x] Perbaikan data Program Studi di tampilan portal menjadi **D4 RSTJ, D4 TRO, D3 TO**.
- [x] Pembuatan berkas migration database:
  - [x] Tabel `prodis` (id, kode_prodi, nama_prodi, jenjang).
  - [x] Pembaruan tabel `users` (tambah kolom: `role` [admin/dosen/reviewer], `nidn_nip`, `prodi_id`, `no_telp`, `avatar`, `status_aktif`).
  - [x] Tabel `posts` (berita kegiatan, agenda, pengumuman call for proposals, status terbit).
  - [x] Tabel `documents` (Renstra, Roadmap, SOP Penelitian, SOP Pengabdian, Panduan SIM).
  - [x] Tabel `researches` & `community_services` (rekap data riset & PkM terfilter prodi/tahun).
  - [x] Tabel `proposals` (judul, tipe [penelitian/pengabdian], skema, prodi_id, ketua_id, dana, status).
  - [x] Tabel `proposal_members` (anggota tim dosen dan taruna/mahasiswa).
  - [x] Tabel `proposal_budgets` (item rincian anggaran biaya / RAB).
  - [x] Tabel `proposal_reviews` (penugasan reviewer, nilai rubrik, catatan rekomendasi).
  - [x] Tabel `outputs` (Publikasi Jurnal, HKI Paten/Hak Cipta, Inovasi Produk/Jasa).
- [x] Pembuatan Seeder data master:
  - [x] Seeder 3 Program Studi: D4 RSTJ, D4 TRO, D3 TO.
  - [x] Seeder akun uji coba awal:
    - Akun Admin: `admin@pktj.ac.id` / password: `password`
    - Akun Dosen: `dosen@pktj.ac.id` / password: `password`
    - Akun Reviewer: `reviewer@pktj.ac.id` / password: `password`
  - [x] Seeder data awal riset, dokumen SOP, dan berita.

---

### Tahap 2: Autentikasi Multi-Role & Halaman Login SIM P3M
- [x] Pembuatan rute dan controller autentikasi (`LoginController`, `LogoutController`).
- [x] Pembuatan tampilan halaman login SIM P3M (`resources/views/auth/login.blade.php`):
  - [x] Desain elegan bernuansa wibawa Kementerian Perhubungan (Biru Deep `#0B2A59` & Kuning Emas).
  - [x] Responsif di smartphone, tablet, laptop, dan desktop.
  - [x] Formulir login (Email/NIDN, Kata Sandi, Ingat Saya).
  - [x] Umpan balik validasi kesalahan yang ramah dan jelas.
- [x] Sistem Middleware & Pengalihan Hak Akses (*Role-Based Redirect*):
  - [x] Login sebagai **Admin** -> dialihkan ke Dashboard CMS (`/admin/dashboard`).
  - [x] Login sebagai **Dosen** -> dialihkan ke Portal Usulan Riset (`/dosen/dashboard`).
  - [x] Login sebagai **Reviewer** -> dialihkan ke Portal Penilaian (`/reviewer/dashboard`).

---

### Tahap 3: Panel CMS Pengelolaan Konten Publik (Admin P3M)
- [x] Tata letak master panel admin (*Admin Layout*) dengan navigasi sidebar responsif.
- [x] Pemasangan Rich Text Editor **TinyMCE Self-Hosted** (100% Free, tanpa API Key Cloud).
- [x] Modul CMS Berita & Pengumuman (Tambah, edit, hapus, upload gambar sampul).
- [x] Modul CMS Dokumen Unduhan (Unggah Renstra, Roadmap, SOP Penelitian & Pengabdian).
- [x] Modul CMS Rekap Riset & PkM (Kelola data yang tampil pada grafik dan tabel portal publik per 3 Program Studi).
- [x] Fitur Import Data Riset/PkM (Format CSV sederhana untuk input data tahunan massal).
- [x] Modul Manajemen Usulan Proposal & Penugasan Reviewer (Verifikasi berkas & assign reviewer).
- [x] Modul Manajemen Akun Pengguna (Kelola akun Dosen & Reviewer per 3 Program Studi).

---

### Tahap 4: Portal Pengajuan Usulan & Rencana Anggaran Biaya (Dosen)
- [x] Dashboard Dosen (Ringkasan usulan aktif, status penerimaan, notifikasi revisi).
- [x] Formulir Pendaftaran Usulan Baru:
  - [x] Pemilihan Kategori (Penelitian Keselamatan Transportasi / Pengabdian Vokasi).
  - [x] Data Usulan (Judul, Abstrak, Skema Hibah, Tahun Anggaran, Target Luaran).
  - [x] Tim Pengusul (Pencarian Dosen Anggota & Kolaborasi Mahasiswa).
  - [x] Penyusunan Rincian Anggaran Biaya (RAB dinamis: belanja bahan, sewa alat, perjalanan, publikasi).
  - [x] Unggah Berkas Proposal (Format PDF terstandar).
- [x] Pemantauan Status Usulan (*Real-Time Tracker*):
  - [x] Tahapan: *Draf -> Diajukan -> Seleksi Administrasi -> Sedang Dinilai -> Revisi -> Diterima / Belum Lolos*.
  - [x] Halaman catatan reviewer dan formulir pengunggahan berkas revisi.

---

### Tahap 5: Modul Penilaian Usulan (Reviewer)
- [x] Dashboard Reviewer (Daftar usulan yang ditugaskan oleh Admin).
- [x] Lembar Penilaian Online (Rubrik skor berstandar akademik PKTJ).
- [x] Formulir Catatan Evaluasi & Penetapan Rekomendasi (*Diterima, Ditolak, Diterima dengan Revisi*).

---

### Tahap 6: Integrasi Data Dinamis ke Halaman Publik
- [x] Menghubungkan Beranda publik dengan data dari basis data (Berita terbaru, pengumuman call for proposals).
- [x] Mengaktifkan filter dinamis tabel riset publik berdasarkan 3 Prodi (D4 RSTJ, D4 TRO, D3 TO) dan Tahun.
- [x] Menghubungkan tautan unduh dokumen SOP dan panduan ke berkas asli yang diunggah Admin.
- [x] Pengujian menyeluruh responsivitas multi-device dan persiapan *deployment*.

---

### Tahap 7: Kebutuhan Website P3M PKTJ (Berdasarkan Dokumen Excel Pemangku Kepentingan)
- [x] **Nomor 1: Homepage (Beranda Publik)**:
  - [x] **Hero Banner & Video Profil Terintegrasi**: Video profil 16:9 disematkan langsung di kolom kanan Hero Banner atas (*above the fold*), langsung tampil dan dapat diputar seketika tanpa popup/kondisional tersembunyi.
  - [x] **Tentang P3M PKTJ (Tata Letak Seimbang Anti-Gepeng)**: Perbaikan tata letak 2 kolom kokoh (`grid-cols-1 lg:grid-cols-2`), profil BPSDMP Kemenhub, mandat, 4 pilar layanan, 3 Program Studi (`D4 RSTJ`, `D4 TRO`, `D3 TO`), dan 3 kartu fasilitas/sarana riset lapangan.
  - [x] **Panel CMS Pengaturan Beranda & Video Profil**: Modul di `/admin/settings/profile` untuk Admin mengelola URL YouTube (otomatis konversi berbagai format ke *privacy-enhanced embed* `youtube-nocookie.com`), judul, narasi, dan teks pengantar secara dinamis dengan fitur *Live Preview*.
  - [x] **Berita Terkini**: Menampilkan diseminasi hasil riset dan berita kegiatan terkini, gambar sampul, ringkasan, dan jendela pembaca interaktif tanpa reload halaman.
- [ ] **Nomor 2: Halaman Profil**:
  - [x] **Rencana Strategis (Renstra)**: Halaman publik `/profil/rencana-strategis` memuat **Dokumen Rencana Strategis Penelitian 2026-2031** dan **Dokumen Rencana Strategis Pengabdian Kepada Masyarakat**, pilar 3 Program Studi (`D4 RSTJ`, `D4 TRO`, `D3 TO`), kartu aksi unduh berkas PDF terhitung, dan pratinjau dokumen interaktif, serta terintegrasi CMS Admin.
  - [x] **Roadmap Penelitian**: Halaman publik `/profil/roadmap-penelitian` memuat **Dokumen Roadmap Penelitian Keselamatan Transportasi Terpadu**, visualisasi 3 fase riset (Fundamental, Inovasi Cerdas, Hilirisasi Industri), 3 klaster pohon kepakaran prodi terstandar (`D4 RSTJ`, `D4 TRO`, `D3 TO`), berkas PDF terhitung, reader modal interaktif, dan terkelola penuh via CMS Admin di `/admin/documents`.
  - [x] **Visi, Misi & Tujuan**: Halaman publik `/profil/visi-misi` memuat pernyataan Visi kelembagaan hingga 2031, 5 butir misi institusi, 4 tujuan strategis & sasaran mutu, sinergi riset 3 Program Studi (`D4 RSTJ`, `D4 TRO`, `D3 TO`), dan panel CMS dinamis mandiri di `/admin/settings/visi-misi`.
  - [x] **Profil Peneliti & Dosen**: Halaman publik `/profil/peneliti` memuat Direktori dosen dan peneliti aktif, filter 3 Program Studi (`D4 RSTJ`, `D4 TRO`, `D3 TO`), pencarian instan nama/NIDN/keahlian, kartu kepakaran, tautan profil akademik (SINTA ID, Scopus ID, Google Scholar), modal portofolio rekapitulasi riset terapan dan publikasi ilmiah luaran HKI, serta formulir penyuntingan profil peneliti terintegrasi CMS Admin di `/admin/users/{user}/edit`.
  - [x] **Sumber Daya Manusia (Struktur Organisasi)**: Halaman publik `/profil/sdm` memuat bagan hierarki organisasi interaktif & unduh berkas gambar bagan visual, dasar hukum SK Direktur PKTJ, masa bakti kepengurusan, dan susunan personil berjenjang (Pengarah & Direktur PKTJ, Penanggung Jawab Akademik, Pimpinan P3M, Koordinator 3 Bidang Riset & Sentra HKI, Staf SIM P3M), serta terkelola penuh via panel CMS di `/admin/organization`.
  - [ ] Sambutan Direktur Politeknik Keselamatan Transportasi Jalan (PKTJ).
  - [ ] Profil P3M PKTJ (Tugas & Fungsi Kelembagaan).
- [ ] **Nomor 3: Riset**:
  - [x] **Kegiatan Penelitian**: Halaman publik `/riset/penelitian` (`route('riset.penelitian')`) memuat **Daftar kegiatan bidang penelitian beserta data pendukungnya berdasarkan sumber dana, tersusun per tahun**:
    - Pembagian riset berdasarkan sumber pendanaan (Tab: Semua Sumber Dana, DIPA PKTJ / Kemenhub, Kemdiktisaintek / Nasional, Mitra Industri / Eksternal, Mandiri / Swadana).
    - Visualisasi statistik grafik native SVG (Capaian riset dan alokasi dana per tahun) serta kartu persentase serapan 3 Program Studi (`D4 RSTJ`, `D4 TRO`, `D3 TO`).
    - Tabel rekapitulasi riset tersusun kronologis per tahun anggaran descending dengan filter prodi, tahun, dan pencarian instan kata kunci.
    - Data pendukung lengkap berupa modal detail (abstrak, skema, ketua & anggota, rincian dana) dan tombol unduh laporan akhir PDF (`route('riset.penelitian.unduh')`).
  - [x] **Luaran Penelitian (Publikasi, HKI, Produk/Jasa)**: Halaman publik `/riset/luaran` (`route('riset.luaran')`) memuat:
    - 3 Pilar Luaran Terpadu: 1. Publikasi Ilmiah (Jurnal SINTA/Scopus, Prosiding, Book Chapter), 2. Hak Kekayaan Intelektual (Paten, Hak Cipta Perangkat Lunak, Desain Industri), 3. Produk & Jasa Teknologi (Prototipe TKT 1-9, Alat Keselamatan Uji Lapang, Piranti Lunak, Dokumen Kebijakan).
    - Pemenuhan 4 Kriteria Akreditasi & Audit Mutu:
      1. Adopsi Lisensi Terbuka (Open License: CC BY, CC BY-SA, Open Access, Open Source Hardware/Software).
      2. Penyelarasan Peta Jalan (Fase Roadmap Riset Keselamatan PKTJ & Deskripsi Kemanfaatan Nyata).
      3. Kerjasama & Kemitraan Strategis (Mitra Industri, Instansi Transportasi, BPTD, Korlantas, Dishub, BUMN).
      4. Realisasi Sumber Dana (DIPA PKTJ, Kemdiktisaintek, Mitra Industri, Swadana) dan nominal rupiah terealisasi.
    - Data pendukung lengkap berupa unduhan berkas PDF bukti luaran (`route('riset.luaran.unduh')`) dan tautan eksternal (DOI, SINTA, DJKI).
    - Filter multi-kriteria: 3 Pilar Tab, Filter 3 Program Studi (`D4 RSTJ`, `D4 TRO`, `D3 TO`), Filter Tahun Realisasi, Filter Lisensi Terbuka, dan Pencarian Judul/Inventor.
    - Terkelola penuh via CMS Administrator di `/admin/outputs` (CRUD terintegrasi, unggah PDF, validasi berkas).
  - [ ] Riset Unggulan Keselamatan Transportasi Jalan.
  - [ ] Fasilitas Laboratorium Riset.
  - [ ] Data Hasil Riset Dosen per 3 Program Studi.
- [ ] **Nomor 4: Pengabdian kepada Masyarakat (PkM)**:
  - [ ] Fasilitas & Sarana Pengabdian.
  - [ ] Data Hasil Pengabdian Masyarakat & Binaan.
- [ ] **Nomor 5: Layanan**:
  - [ ] Layanan Sentra HKI & Paten.
  - [ ] Layanan Publikasi Ilmiah SINTA.
  - [ ] Layanan Penerbitan Buku & Prosiding.
- [ ] **Nomor 6: Portal Rumah Jurnal (OJS PKTJ)**:
  - [ ] Tautan dan etalase Indonesian Road Safety Journal (e-journal PKTJ).
- [x] **Nomor 7: Login SIM P3M**:
  - [x] Halaman login terintegrasi multi-role (Admin, Dosen, Reviewer).
