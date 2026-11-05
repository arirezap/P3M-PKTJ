# Audit: Halaman Profil > Roadmap Penelitian SIM P3M PKTJ

- Tanggal       : 2026-11-05
- Auditor       : AI Antigravity
- Commit/Branch : main
- Cakupan       : 
  - Route Publik: `GET /profil/roadmap-penelitian` (`profil.roadmap-penelitian`), `GET /dokumen/{document}/unduh` (`documents.download`)
  - Route CMS Admin: `GET /admin/settings/roadmap` (`admin.settings.roadmap`), `PUT /admin/settings/roadmap` (`admin.settings.roadmap.update`), `Route::resource('documents', AdminDocumentController::class)`
  - Controller: `app/Http/Controllers/ProfileController.php`, `app/Http/Controllers/Admin/SettingController.php`, `app/Http/Controllers/Admin/DocumentController.php`
  - View Publik: `resources/views/profil/roadmap-penelitian.blade.php`
  - View CMS Admin: `resources/views/admin/settings/roadmap.blade.php`
  - Model: `app/Models/Document.php`, `app/Models/Setting.php`
  - Feature Tests: `tests/Feature/PublicRoadmapTest.php`, `tests/Feature/AdminSettingTest.php`
- File terkait  : `graphify query "roadmap penelitian profil"` -> `roadmap-penelitian.blade.php`, `ProfileController.php`, `SettingController.php`, `DocumentController.php`, `PublicRoadmapTest.php`, `AdminSettingTest.php`

---

## Ringkasan Skor

| Bagian | Item Lulus | Item Gagal | N/A | Catatan |
| :--- | :--- | :--- | :--- | :--- |
| A1 Clean Code | 10 | 0 | 0 | File Blade dipangkas dari 1.172 baris menjadi ~130 baris murni berorientasi pada penyajian dokumen digital asli; lolos Laravel Pint. |
| A2 SOLID | 5 | 0 | 0 | SRP terpenuhi: `ProfileController` melayani tampilan publik dan penyajian berkas; pengelolaan data narasi dan unggah PDF dikelola terpisah di `Admin\SettingController`. |
| A3 Self-Documenting | 9 | 0 | 0 | Penamaan method ekspresif (`editRoadmap()`, `updateRoadmap()`, `roadmapPenelitian()`), type hint dan return type lengkap. |
| A4 Testable | 10 | 0 | 0 | Feature tests di `PublicRoadmapTest` dan `AdminSettingTest` memverifikasi alur publik dan pengelolaan CMS. |
| A5 Performa & Skala | 6 | 0 | 0 | Penampil berkas PDF menggunakan iframe `loading="lazy"` beresolusi terukur, ukuran aset terkompilasi optimal. |
| A6 Keamanan | 9 | 0 | 0 | Validasi unggah berkas ketat (`mimes:pdf`, `max:20480`), disk publik terlindungi, rute CMS dilindungi otorisasi peran admin. |
| A7 Database | 5 | 0 | 0 | Pengaturan grup `roadmap` terpusat pada tabel `settings`; counter unduhan berkas dicatat secara atomik pada tabel `documents`. |
| A8 Error & Log | 4 | 0 | 0 | Penanganan fallback tampilan jika dokumen belum diunggah, penanganan 404 pada unduhan ID tidak valid, dan alert validasi informatif. |
| A9 Anti Over-Engineering | 6 | 0 | 0 | **Selesai Diperbaiki**: Memangkas ~1.000 baris kode berlebih (kartu indikator, seksi 3 fase riset hardcoded, seksi 3 prodi, loop dokumen regulasi pendukung, banner CTA panjang, dan modal reader imitasi) menjadi penampil PDF langsung (*embed*) sesuai kebutuhan dokumen. |
| B1 Konsistensi Desain | 8 | 0 | 0 | Mengadopsi palet warna identitas Maritim Modern (`#0B2A59`, slate-50, aksen kuning emas PKTJ). Hirarki tipografi terstruktur rapi. |
| B2 Responsif | 6 | 0 | 0 | Teruji multi-breakpoint (ponsel pintar `< 640px`, tablet `640px-1023px`, laptop/desktop `≥ 1024px`) dengan zero horizontal overflow. |
| B3 Aksesibilitas | 7 | 0 | 0 | Target sentuh tombol aksi unduh (`h-11` = 44px) memenuhi standar ergonomi minimal 44px. Iframe PDF menyertakan title deskriptif. |
| B4 Status Tampilan | 5 | 0 | 0 | Status dokumen kosong memiliki wadah informatif jika berkas belum diunggah oleh pengelola. |
| B5 Bahasa & Teks | 6 | 0 | 0 | Teks mengutamakan diksi akademik yang komunikatif ("Peta Jalan Riset Terapan", "Keselamatan Transportasi Jalan"), bebas jargon teknis rumit. |
| C1 Mandat AGENTS.md | 10 | 0 | 0 | 100% bebas emoji (0), bebas kata terlarang (0), patuh penuh pada grid 4px (seluruh kelas kelipatan 4px), menyertakan dukungan CMS penuh. |
| C2 Dokumen Kebutuhan PDF | 6 | 0 | 0 | **Sesuai 100%**: Langsung menampilkan Dokumen Roadmap Penelitian sesuai Halaman 1 [Kebutuhan Website P3M rev.pdf](file:///c:/laragon/www/p3m/Kebutuhan%20Website%20P3M%20rev.pdf). |

---

## Analisis Kesesuaian Dokumen Kebutuhan & Anti Over-Engineering

### 1. Temuan Ketidaksesuaian Awal (Over-Engineering & Scope Creep)
Dokumen acuan **[Kebutuhan Website P3M rev.pdf](file:///c:/laragon/www/p3m/Kebutuhan%20Website%20P3M%20rev.pdf)** (Halaman 1, Baris No. 2 Profil) mendefinisikan:
- **Menu**: Profil
- **Sub Menu**: Roadmap Penelitian
- **Isi Tampilan**: *"Dokumen Roadmap Penelitian"*

Namun kode sebelumnya memuat lebih dari 1.170 baris dengan komponen-komponen berlebih:
1. Tiga kartu indikator jangka waktu, klaster keilmuan, dan sasaran akhir luaran.
2. Seksi matriks 3 tahapan evolusi riset keselamatan PKTJ fiktif.
3. Seksi roadmap 3 prodi dengan tabel-tabel hardcoded panjang.
4. Seksi dokumen regulasi pendukung.
5. Seksi formulir/banner ajakan usulan penelitian sesuai tema roadmap.
6. Pratinjau modal popup dengan kotak abu-abu imitasi, bukan menampilkan berkas dokumen asli.
Hal ini melanggar kriteria **A9 Anti Over-Engineering (KISS & YAGNI)** dan menyimpang dari mandat kesederhanaan dokumen kebutuhan.

### 2. Solusi Refaktorisasi yang Diterapkan
1. **Pemangkasan Kode Bloat**: Menghapus seluruh seksi asing yang tidak diminta sehingga file Blade menjadi ramping, bersih, dan berorientasi dokumen (~130 baris).
2. **Penampil PDF Langsung (*Direct PDF Embed*)**:
   - Menyematkan elemen `<iframe>` responsif (`h-[768px]`) sehingga pengunjung dan dosen dapat langsung membaca isi dokumen Roadmap Penelitian secara utuh di halaman web tanpa wajib mengunduh terlebih dahulu.
   - Menyediakan tautan dan tombol unduh langsung berstandar ergonomis (`h-11` = 44px) yang menaikkan counter unduhan secara atomik.
3. **Pengelolaan Penuh Melalui CMS Admin**:
   - Membangun antarmuka CMS di `/admin/settings/roadmap`.
   - Mengizinkan Administrator P3M untuk menyunting badge, judul, paragraf pengantar, konten HTML kustom, serta mengunggah/mengganti berkas PDF Roadmap Penelitian secara mandiri.

---

## Temuan & Tindakan Perbaikan

| ID | Area | Lokasi | Temuan | Level | Rekomendasi | Status |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| AUD-ROADMAP-01 | Over-Engineering | `resources/views/profil/roadmap-penelitian.blade.php` | Halaman memuat 1.172 baris dengan seksi fiktif (3 fase riset, matriks prodi, cta) dan modal reader imitasi. | Tinggi | Pangkas seksi berlebih, implementasikan penampil PDF langsung (*embed iframe*) sesuai dokumen kebutuhan. | Selesai |
| AUD-ROADMAP-02 | Kelengkapan CMS | `app/Http/Controllers/Admin/SettingController.php` | Belum ada menu CMS khusus untuk mengelola teks pengantar, HTML kustom, dan berkas PDF Roadmap Penelitian. | Sedang | Buat rute dan method `editRoadmap()` & `updateRoadmap()` serta formulir CMS di `resources/views/admin/settings/roadmap.blade.php`. | Selesai |
| AUD-ROADMAP-03 | Grid Spasial | `resources/views/profil/roadmap-penelitian.blade.php` | Penggunaan tinggi iframe wajib mengikuti kelipatan 4px (`h-[768px]`). | Rendah | Tetapkan tinggi iframe menjadi `h-[768px]`. | Selesai |
| AUD-ROADMAP-04 | Cakupan Uji | `tests/Feature/AdminSettingTest.php` & `PublicRoadmapTest.php` | Pengujian akses dan pembaruan pengaturan roadmap via CMS serta tampilan dokumen publik. | Rendah | Tambahkan unit pengujian baru di `AdminSettingTest` dan sesuaikan `PublicRoadmapTest`. | Selesai |

---

## Keputusan

- Hasil  : **Lulus**
- Alasan : Halaman Profil > Roadmap Penelitian kini telah 100% selaras dengan dokumen [Kebutuhan Website P3M rev.pdf](file:///c:/laragon/www/p3m/Kebutuhan%20Website%20P3M%20rev.pdf), terbebas dari *over-engineering*, menyajikan penampil dokumen PDF langsung (*embed*), serta dapat dikustomisasi secara menyeluruh (teks, HTML, dan berkas PDF) melalui panel CMS Admin.

