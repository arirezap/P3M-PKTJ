# Audit: Halaman Riset > Kegiatan Penelitian SIM P3M PKTJ

- Tanggal       : 2026-11-05
- Auditor       : AI Antigravity
- Commit/Branch : main
- Cakupan       : 
  - Route Publik            : `GET /riset/penelitian` (`riset.penelitian`), `GET /riset/penelitian/{research}/unduh` (`riset.penelitian.unduh`)
  - Route CMS Admin         : `admin.researches.*`, `admin.researches.import`
  - Controller Publik       : `app/Http/Controllers/PublicResearchController.php`
  - Controller CMS Admin    : `app/Http/Controllers/Admin/ResearchController.php`
  - View Publik             : `resources/views/riset/penelitian.blade.php`
  - Model                   : `app/Models/Research.php`, `app/Models/Prodi.php`, `app/Models/User.php`
  - Feature Tests           : `tests/Feature/PublicResearchPageTest.php`
- File terkait              : `graphify query "riset kegiatan penelitian sumber dana grafik"` -> `penelitian.blade.php`, `PublicResearchController.php`, `PublicResearchPageTest.php`

---

## Ringkasan Skor

| Bagian | Item Lulus | Item Gagal | N/A | Catatan |
| :--- | :--- | :--- | :--- | :--- |
| A1 Clean Code | 8 | 1 | 0 | Struktur Controller bersih; **Temuan**: Berkas `penelitian.blade.php` mengalami inflasi baris ganda (1252 baris) dengan baris kosong berlebih. Perlu perapian format. |
| A2 SOLID | 5 | 0 | 0 | SRP terpenuhi: `PublicResearchController` fokus menyajikan direktori publik dan agregasi metrik. |
| A3 Self-Documenting | 9 | 0 | 0 | Nama variabel dan method ekspresif (`$researchesByYear`, `$tabCounts`, `$yearlyStats`). |
| A4 Testable | 9 | 0 | 0 | Feature tests di `PublicResearchPageTest` menguji akses, filter prodi, filter tahun, tab sumber dana, pencarian, dan unduh PDF. |
| A5 Performa & Skala | 6 | 0 | 0 | Eager loading relasi `prodi` dan `user` mencegah N+1 query. Agregasi statistik menggunakan koleksi in-memory efisien. |
| A6 Keamanan | 8 | 0 | 0 | Unduh berkas laporan terlindungi via disk publik Laravel dengan pengecekan `Storage::exists()`. |
| A7 Database | 5 | 0 | 0 | Relasi `belongsTo(Prodi)` dan `belongsTo(User)` terindeks dengan baik. |
| A8 Error & Log | 4 | 0 | 0 | Menangani kondisi data riset kosong (*empty state*) dengan instruksi reset filter yang ramah pengguna. |
| A9 Anti Over-Engineering | 6 | 0 | 0 | **Sesuai Penuh**: Mengimplementasikan visualisasi grafik statistik batang native responsif tanpa dependensi pustaka JavaScript pihak ketiga yang berat. |
| B1 Konsistensi Desain | 8 | 0 | 0 | Palet warna identitas Maritim Modern (`#0B2A59`, kuning PKTJ, emerald, slate). Tipografi jelas dan komunikatif. |
| B2 Responsif | 6 | 0 | 0 | Teruji multi-breakpoint (ponsel, tablet, desktop) dengan tabel ber-overflow horizontal terisolasi. |
| B3 Aksesibilitas | 7 | 0 | 0 | Elemen filter dropdown dan tombol aksi memenuhi ukuran tap minimal 44px (`h-11`). |
| B4 Status Tampilan | 5 | 0 | 0 | Modal detail interaktif menyajikan ringkasan abstrak, tim peneliti, dan status penyelesaian. |
| B5 Bahasa & Teks | 6 | 0 | 0 | Bebas jargon teknis; menggunakan istilah akademik baku: *Sumber Pendanaan*, *Program Studi*, *Tahun Anggaran*. |
| C1 Mandat AGENTS.md | 8 | 1 | 0 | 100% bebas emoji (0) dan bebas kata 'resmi' (0). **Temuan**: Masih terdapat kelas arbitrary non-kelipatan 4px (`text-[10px]`, `text-[11px]`, `min-w-[280px]`) yang perlu dinormalisasi ke kelipatan 4px. |
| C2 Dokumen Kebutuhan PDF | 6 | 0 | 0 | **Sesuai 100%**: Menyajikan daftar kegiatan penelitian beserta data pendukung, dibagi berdasarkan sumber dana, tersusun per tahun, dilengkapi grafik statistik dan tabel filter prodi/tahun sesuai Halaman 1 [Kebutuhan Website P3M rev.pdf](file:///c:/laragon/www/p3m/Kebutuhan%20Website%20P3M%20rev.pdf). |

---

## Analisis Kesesuaian Dokumen Kebutuhan & Rekomendasi Peningkatan

### 1. Definisi Dokumen Acuan (Kebutuhan Website P3M rev.pdf)
Pada **[Kebutuhan Website P3M rev.pdf](file:///c:/laragon/www/p3m/Kebutuhan%20Website%20P3M%20rev.pdf)** (Halaman 1, Baris No. 3 Menu Riset):
- **Menu**: Riset
- **Sub Menu**: Kegiatan Penelitian
- **Isi Tampilan**: *"Daftar kegiatan bidang penelitian beserta data pendukungnya berdasarkan sumber dana, tersusun per tahun."*
- **Pemenuhan**: *"Penelitian dibagi berdasarkan sumber dana, terdapat tampilan statistik grafik dan tabel yang bisa difilter per prodi dan per tahun"*

### 2. Status Pemenuhan Saat Ini
1. **Daftar Kegiatan & Data Pendukung**: Telah terpenuhi. Setiap baris riset menyajikan judul, abstrak, ketua/anggota peneliti, skema, nominal anggaran, tombol modal *Detail* lengkap, dan tautan unduh *PDF Laporan*.
2. **Pembagian Berdasarkan Sumber Dana**: Telah terpenuhi melalui 5 Tab Kategori Sumber Dana (*Semua*, *DIPA PKTJ/Kemenhub*, *Kemdiktisaintek/Nasional*, *Mitra Industri/Eksternal*, *Mandiri/Swadana*) yang dilengkapi lencana hitung jumlah (*count badge*).
3. **Tersusun per Tahun**: Telah terpenuhi melalui pengelompokan blok tahun anggaran terurut menurun (*descending*) dengan rekapitulasi total dana alokasi per tahun.
4. **Tampilan Statistik Grafik**: Telah terpenuhi melalui stacked progress bar chart per tahun berdasarkan serapan 4 sumber dana dan sebaran 3 Program Studi PKTJ (D4 RSTJ, D4 TRO, D3 TO).
5. **Filter Tabel per Prodi & per Tahun**: Telah terpenuhi melalui formulir filter ganda (*select* prodi, *select* tahun, dan *input search* kata kunci) yang terintegrasi secara harmonis dengan tab sumber dana aktif.

### 3. Poin Tindak Lanjut Penyelarasan
1. **Pembersihan Kode Template Blade**: Merapikan berkas `penelitian.blade.php` dari baris kosong berlebih (*double-spaced lines*) sehingga kode lebih ringkas, terawat, dan mudah dibaca.
2. **Standardisasi Sistem Spasial Grid 4px**: Mengganti seluruh arbitrary class non-kelipatan 4px (`text-[10px]`, `text-[11px]`, `min-w-[280px]`) menjadi kelas baku kelipatan 4px (`text-xs`, `min-w-64`, `min-w-44`, dsb).
3. **Sinergi Tautan Profil Peneliti**: Menautkan nama ketua peneliti pada tabel dan modal detail ke halaman profil peneliti `/profil/peneliti/{user}` jika akun peneliti terdaftar di sistem.

