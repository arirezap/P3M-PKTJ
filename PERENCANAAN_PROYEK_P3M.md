# 📋 Dokumen Spesifikasi & Perencanaan Proyek Website P3M
*(Pusat Penelitian dan Pengabdian kepada Masyarakat - PKTJ)*

---

## 1. Ringkasan & Tujuan Proyek
Website P3M PKTJ berfungsi sebagai:
1. **Portal Publik & Repositori Resmi**: Menampilkan profil kelembagaan, visi-misi, dokumen renstra & roadmap, rekapitulasi capaian riset & pengabdian dengan grafik interaktif per prodi dan per tahun, etalase luaran (publikasi, HKI, produk/jasa), kerjasama, serta pusat unduhan dokumen (panduan & SOP).
2. **Sistem Informasi Manajemen Riset & Pengabdian (SIM P3M / Internal)**: Portal terotentikasi bagi dosen untuk mengajukan usulan proposal riset/pengabdian lengkap dengan RAB biaya, memantau alur review secara transparan, hingga penetapan keputusan pendanaan.

---

## 2. Keputusan Tech Stack (Final)

| Komponen | Pilihan Teknologi | Keterangan |
| :--- | :--- | :--- |
| **Framework Backend** | **Laravel 11 / 12** | PHP 8.2+ (Maksimal PHP 8.5 didukung cPanel) |
| **Database & Manajemen** | **MySQL / MariaDB via phpMyAdmin** | Standar SQL (`InnoDB`, `utf8mb4`), dapat dikelola & diekspor langsung via phpMyAdmin |
| **Styling & UI** | **Tailwind CSS + Vite** | Desain modern, ultra-cepat, tree-shaking otomatis |
| **Frontend Interaktif** | **Laravel Blade + Alpine.js / Livewire** | Sangat responsif, filter dinamis, tanpa daemon Node.js di server |
| **Visualisasi Grafik** | **Chart.js / ApexCharts** | Untuk grafik statistik riset & pengabdian per tahun/prodi |
| **Panduan UI/UX** | **[design.md](design.md)** | Simpel, elegan, anti-AI slop, font **Poppins**, dominan putih dengan aksen biru & kuning Perhubungan, footer biru gelap, **Grid 4px & Multi-Device** |
| **Filter Standar Kode & UI** | **[anti-slop](AGENTS.md)** | Plugin rulebook resmi untuk mencegah UI generik, fake data, dan komentar AI slop |
| **Codebase & Architecture Graph** | **[graphify](.agents/rules/graphify.md)** | Ekstraksi dan pemetaan struktur arsitektur codebase ke dalam graf relasi (*knowledge graph*) |
| **Aset Logo** | **[logoPKTJ.png](logoPKTJ.png)** | Logo resmi PKTJ transparan resolusi tinggi sudah siap digunakan |
| **Deployment Target** | **cPanel Hosting via Git Push-Pull** | Menggunakan menu *Git™ Version Control* cPanel |

---

## 3. Rincian Kebutuhan Fitur (Berdasarkan File Excel Kebutuhan)

Berdasarkan analisis file `Kebutuhan Website P3M rev.xlsx`, struktur menu dan fungsionalitas sistem dibagi menjadi:

### A. Portal Publik (Frontend / Pengunjung)

#### 1. Beranda (Homepage)
- **Hero Section**: Tentang P3M PKTJ, sambutan kepala P3M, banner dinamis.
- **Video Profil P3M**: Integrasi embed video profil kelembagaan.
- **Berita & Pengumuman Terkini**: Artikel kegiatan, diseminasi, dan info call for proposals.
- **Statistik Cepat (Quick Counter)**: Total riset, pengabdian, HKI terdaftar, dan mitra kerjasama.

#### 2. Profil
- **Rencana Strategis**: Akses & unduh Dokumen Renstra Penelitian 2026–2031 dan Renstra Pengabdian kepada Masyarakat.
- **Roadmap Penelitian**: Visualisasi dan dokumen peta jalan (roadmap) riset PKTJ.
- **Visi, Misi & Tujuan**: Visi, misi, dan tujuan strategis P3M.
- **Profil Peneliti & Dosen**: Direktori dosen/peneliti aktif, profil kepakaran, data riwayat penelitian, dan riwayat publikasi ilmiah dosen.
- **Sumber Daya Manusia (SDM)**: Struktur organisasi kepengurusan P3M beserta foto & jabatan.

#### 3. Riset (Penelitian)
- **Kegiatan Penelitian**: 
  - Daftar kegiatan penelitian beserta data pendukung berdasarkan **sumber dana** (Internal, DIPA, Kemenhub, Kemdiktisaintek, Mandiri, Kerjasama).
  - Tersusun per tahun.
  - **Fitur Khusus**: Visualisasi statistik grafik dan tabel yang **dapat difilter per Program Studi (Prodi) dan per Tahun**.
- **Luaran Penelitian**:
  - **Publikasi**: Menampilkan publikasi (jurnal/prosiding) berlisensi terbuka, relevansi roadmap, dan realisasi dana.
  - **HKI**: Data Hak Cipta, Paten, Desain Industri dosen/mahasiswa.
  - **Produk / Jasa**: Showcase produk prototipe, inovasi teknologi keselamatan transportasi, atau jasa kepakaran.
- **Kerjasama Penelitian**: Riwayat & dokumen kerjasama riset dengan industri, instansi pemerintah, dan perguruan tinggi lain per tahun.

#### 4. Pengabdian kepada Masyarakat (PkM)
- **Kegiatan Pengabdian**: 
  - Daftar kegiatan PkM berdasarkan sumber dana, tersusun per tahun.
  - **Fitur Khusus**: Statistik grafik dan tabel yang **dapat difilter per Program Studi (Prodi) dan per Tahun**.
- **Luaran Pengabdian**: Hasil analisis capaian luaran PkM (mitra desa, pelatihan, peningkatan keselamatan jalan).
- **Kerjasama Pengabdian**: Kegiatan kerjasama kemitraan pengabdian masyarakat tersusun per tahun.

#### 5. Layanan & Regulasi
- **Panduan & Pedoman**: 
  - Pedoman penelitian & pengembangan SDM.
  - Pedoman Pengabdian kepada Masyarakat & pengembangan kepakaran.
  - Proses pelaksanaan PkM.
  - Panduan penggunaan Sistem Informasi (User Manual).
- **Standar Operasional Prosedur (SOP)**: Pemisahan kategori yang rapi antara **SOP Penelitian** dan **SOP Pengabdian**.

#### 6. Jurnal
- Tautan langsung (Direct Link) ke portal Open Journal Systems (OJS) / Jurnal Ilmiah P3M PKTJ.

---

### B. Modul CMS Konten Publik (Pengelolaan Frontend oleh Admin)
Agar seluruh konten di portal publik bersifat dinamis dan mudah dikelola tanpa menyentuh kodingan, disediakan panel CMS khusus untuk Admin/Operator P3M:

1. **CMS Beranda & Profil Kelembagaan**:
   - **Banner & Hero**: Kelola slider gambar, judul headline sambutan, dan tombol aksi.
   - **Video Profil**: Kelola tautan embed video profil resmi P3M PKTJ.
   - **Visi, Misi & Tujuan**: Editor teks dinamis visi, misi, dan sasaran strategis.
   - **Struktur Organisasi (SDM)**: Upload bagan struktur, tambah/edit data pengurus (foto, nama, NIP/NIDN, jabatan).

2. **CMS Berita, Agenda & Pengumuman**:
   - Rich Text Editor (WYSIWYG) untuk penulisan artikel diseminasi dan berita kegiatan.
   - Upload gambar sampul (thumbnail), pemilihan kategori, dan status *Draft/Publish*.
   - Notifikasi pengumuman berjalan (*running text / call for proposals announcement*).

3. **CMS Data Riset & Pengabdian (Sumber Data Tabel & Grafik Publik)**:
   - Formulir input rekap kegiatan riset & PkM (judul, ketua, prodi, tahun, skema, sumber dana, anggaran).
   - **Fitur Import Excel**: Memudahkan admin mengunggah data rekap tahunan riset/PkM secara massal agar grafik statistik dan tabel publik langsung terisi.

4. **CMS Luaran & Inovasi (Showcase)**:
   - **Publikasi**: Input judul artikel, penulis, nama jurnal, tahun, dan tautan lisensi terbuka.
   - **HKI**: Input judul invensi/ciptaan, jenis HKI (Paten, Hak Cipta, Desain Industri), inventor, nomor sertifikat, dan unduhan bukti sertifikat.
   - **Produk / Jasa**: Input inovasi produk teknologi keselamatan transportasi, foto produk, spesifikasi, dan status kesiapan teknologi (TKT).

5. **CMS Kerjasama & Kemitraan**:
   - Input data mitra kemitraan, instansi, klasifikasi (Riset atau PkM), nomor MoU/PKS, masa berlaku, dan dokumen pendukung.

6. **CMS Pusat Unduhan (Dokumen & Regulasi)**:
   - Manajemen file unduhan **Renstra 2026–2031** dan **Roadmap Penelitian**.
   - Manajemen file **Pedoman & Panduan** (Pedoman Riset, Pedoman PkM, Buku Panduan SIM P3M).
   - Manajemen file **SOP** terpisah (**SOP Penelitian** dan **SOP Pengabdian**).

7. **CMS Direktori Dosen & Kepakaran**:
   - Kelola data profil dosen aktif, foto, bidang fokus riset/kepakaran, dan tautan profil publik (SINTA ID, Scopus ID, Google Scholar).

8. **CMS Tautan Jurnal & Kontak**:
   - Konfigurasi URL langsung ke portal Jurnal OJS P3M PKTJ.
   - Pengaturan kontak resmi, alamat kampus, email, dan akun media sosial.

---

### C. Sistem Informasi Pendaftaran Riset & Pengabdian (SIM P3M / Login Area)

Area terotentikasi untuk dosen/peneliti, reviewer, dan admin:

#### 1. Peran Pengguna (User Roles)
1. **Dosen / Peneliti / Pengabdi**:
   - Mengisi & mengirimkan formulir pendaftaran proposal (Penelitian / Pengabdian).
   - Pengajuan rincian rencana anggaran biaya (**RAB / Biaya**).
   - Memantau progres status usulan secara *real-time* (Draft, Diajukan, Sedang Direview, Revisi, Diterima / Ditolak).
   - Melihat catatan reviewer dan mengunggah proposal revisi jika diperlukan.
2. **Reviewer (Penilai)**:
   - Melihat daftar proposal yang ditugaskan oleh admin.
   - Mengisi lembar penilaian / rubrik skor online.
   - Memberikan rekomendasi (Diterima, Ditolak, Diterima dengan Revisi) beserta catatan evaluasi.
3. **Admin P3M**:
   - Mengelola periode penerimaan usulan (pembukaan & penutupan skema).
   - Verifikasi administrasi berkas proposal masuk.
   - Penugasan reviewer (assign reviewer ke proposal).
   - Penetapan keputusan akhir pemenang hibah / pendanaan.
   - Manajemen konten portal publik (Berita, Profil Dosen, Luaran, Dokumen Panduan, Kerjasama).

---

## 4. Perancangan Struktur Basis Data (MySQL / phpMyAdmin)

Tabel-tabel utama yang akan dibuat:
1. `users`: Akun (Dosen, Reviewer, Admin), NIDN/NIP, Prodi, nomor kontak, foto.
2. `prodis`: Master data program studi di lingkungan kampus.
3. `peneliti_profiles`: Data kepakaran, link SINTA, Google Scholar, Scopus dosen.
4. `proposals`: Usulan riset/pengabdian (tipe: Penelitian / PkM, judul, abstrak, prodi, tahun, skema, sumber dana, file PDF, status).
5. `proposal_members`: Anggota tim pengusul (dosen anggota & mahasiswa).
6. `proposal_budgets`: Rincian item biaya / RAB pengajuan dana.
7. `proposal_reviews`: Penilaian reviewer, skor kriteria, catatan rekomendasi, status review.
8. `researches`: Arsip data kegiatan penelitian (untuk tampilan tabel & grafik publik).
9. `community_services`: Arsip data kegiatan pengabdian (untuk tampilan tabel & grafik publik).
10. `outputs`: Luaran terverifikasi (kategori: Publikasi, HKI, Produk/Jasa) berelasi ke penelitian/PkM.
11. `collaborations`: Data kerjasama (Penelitian / Pengabdian, mitra, nomor MoU/PKS, tahun, dokumen).
12. `documents`: Master file unduhan (Renstra, Roadmap, Pedoman, SOP Penelitian, SOP Pengabdian).
13. `posts` / `articles`: Berita kegiatan P3M, agenda, dan pengumuman.

---

## 5. Alur Kerja Git & Deployment cPanel

```
[Komputer Lokal (Laragon)]
   ├── 1. Koding fitur & tampilan Blade/Tailwind
   ├── 2. Jalankan: npm run build (menghasilkan folder public/build)
   ├── 3. git add . && git commit -m "update fitur"
   └── 4. git push origin main
                │
                ▼
         [GitHub Repo]
                │
                ▼
      [cPanel Hosting Server]
         ├── 1. Klik 'Update from Remote' di Git™ Version Control
         ├── 2. Terminal cPanel: php artisan migrate (jika ada tabel baru)
         └── 3. Selesai (Web otomatis ter-update!)
```

---

## 6. Rencana Tahapan Eksekusi (Roadmap)
1. **Langkah 1: Setup Proyek Laravel 11 & Tailwind CSS**
   - Inisialisasi Laravel di `c:\laragon\www\p3m`.
   - Setup konfigurasi Tailwind CSS, Vite, dan icon library (Lucide / Heroicons).
   - Konfigurasi koneksi MySQL `.env` ke phpMyAdmin lokal.
2. **Langkah 2: Pembuatan Migration Database & Model (phpMyAdmin)**
   - Buat tabel users, roles, prodi, profil dosen, dokumen, proposal, reviewer, luaran, dan kerjasama.
   - Isi data awal (seeder prodi & akun admin/dosen tester).
3. **Langkah 3: Pembuatan Portal Publik**
   - Beranda, Halaman Profil (Renstra, Roadmap, Struktur SDM, Direktori Dosen & Publikasi).
   - Halaman Riset & PkM (Tabel + Grafik Statistik per prodi/tahun).
   - Halaman Luaran (Publikasi, HKI, Produk/Jasa) & Kerjasama.
   - Halaman Layanan (Pusat Unduhan Panduan & SOP) + Link Jurnal.
4. **Langkah 4: Pembuatan Sistem Pendaftaran & Review Proposal (SIM P3M)**
   - Autentikasi multi-role (Dosen, Reviewer, Admin).
   - Form pendaftaran usulan penelitian & PkM + Form RAB dinamis + upload file proposal.
   - Modul Reviewer (rubrik penilaian & catatan).
   - Dashboard progres status usulan & verifikasi admin.
5. **Langkah 5: Finisihing & Persiapan cPanel**
   - Testing responsivitas mobile & performa.
   - Build asset produksi (`npm run build`).
   - Panduan upload dan konfigurasi database di cPanel.
