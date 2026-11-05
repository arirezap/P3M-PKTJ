# Audit: Halaman Profil > Rencana Strategis (Renstra) SIM P3M PKTJ

- Tanggal       : 2026-11-05
- Auditor       : AI Antigravity
- Commit/Branch : main
- Cakupan       : 
  - Route Publik: `GET /profil/rencana-strategis` (`profil.rencana-strategis`), `GET /dokumen/{document}/unduh` (`documents.download`)
  - Route CMS Admin: `GET /admin/settings/renstra` (`admin.settings.renstra`), `PUT /admin/settings/renstra` (`admin.settings.renstra.update`), `Route::resource('documents', AdminDocumentController::class)`
  - Controller: `app/Http/Controllers/ProfileController.php`, `app/Http/Controllers/Admin/SettingController.php`, `app/Http/Controllers/Admin/DocumentController.php`
  - View Publik: `resources/views/profil/rencana-strategis.blade.php`
  - View CMS Admin: `resources/views/admin/settings/renstra.blade.php`
  - Model: `app/Models/Document.php`, `app/Models/Setting.php`
  - Feature Tests: `tests/Feature/PublicRenstraTest.php`, `tests/Feature/AdminSettingTest.php`
- File terkait  : `graphify query "rencana strategis renstra profil"` -> `rencana-strategis.blade.php`, `ProfileController.php`, `SettingController.php`, `DocumentController.php`, `PublicRenstraTest.php`, `AdminSettingTest.php`

---

## Ringkasan Skor

| Bagian | Item Lulus | Item Gagal | N/A | Catatan |
| :--- | :--- | :--- | :--- | :--- |
| A1 Clean Code | 10 | 0 | 0 | File Blade dipangkas dari 994 baris menjadi 194 baris murni fokus pada isi dokumen; method controller ringkas, lolos Laravel Pint. |
| A2 SOLID | 5 | 0 | 0 | SRP terpenuhi: `ProfileController` hanya mengelola logika baca publik dan streaming berkas; pengelolaan konten teks & unggah berkas PDF dikelola oleh `Admin\SettingController`. |
| A3 Self-Documenting | 9 | 0 | 0 | Penamaan method ekspresif (`editRenstra()`, `updateRenstra()`, `rencanaStrategis()`), type hint dan return type lengkap. |
| A4 Testable | 10 | 0 | 0 | 8 Feature tests di `PublicRenstraTest` + 9 di `AdminSettingTest` lulus 100% (total suite aplikasi: 186 tes, 896 assertions). |
| A5 Performa & Skala | 6 | 0 | 0 | Penampil berkas PDF menggunakan iframe `loading="lazy"` beresolusi terukur, ukuran aset Vite terkompilasi optimal. |
| A6 Keamanan | 9 | 0 | 0 | Validasi unggah berkas ketat (`mimes:pdf`, `max:20480`), sanitasi nama file, disk publik terlindungi, rute CMS dilindungi middleware auth peran admin. |
| A7 Database | 5 | 0 | 0 | Pengaturan grup `renstra` terpusat pada tabel `settings`; metrik counter unduhan berkas dicatat secara atomik pada tabel `documents`. |
| A8 Error & Log | 4 | 0 | 0 | Penanganan fallback tampilan jika dokumen belum diunggah, penanganan error 404 pada unduhan ID tidak valid, dan alert validasi informatif. |
| A9 Anti Over-Engineering | 6 | 0 | 0 | **Selesai Diperbaiki**: Memangkas ~800 baris kode berlebih (kartu indikator, kartu 3 prodi, loop dokumen regulasi pendukung, banner CTA panjang, dan modal imitasi) menjadi penampil PDF langsung (*embed*) sesuai kebutuhan dokumen. |
| B1 Konsistensi Desain | 8 | 0 | 0 | Mengadopsi palet warna identitas Maritim Modern (`#0B2A59`, slate-50, aksen kuning emas PKTJ). Hirarki tipografi terstruktur rapi. |
| B2 Responsif | 6 | 0 | 0 | Teruji multi-breakpoint (ponsel pintar `< 640px`, tablet `640px-1023px`, laptop/desktop `≥ 1024px`) dengan zero horizontal overflow. |
| B3 Aksesibilitas | 7 | 0 | 0 | Target sentuh tombol aksi unduh dan tab interaktif (`h-11` = 44px dan `h-12` = 48px) memenuhi standar ergonomi minimal 44px. Iframe PDF menyertakan title deskriptif. |
| B4 Status Tampilan | 5 | 0 | 0 | Status dokumen kosong memiliki wadah informatif, tab interaktif Alpine.js transisi instan tanpa muat ulang halaman. |
| B5 Bahasa & Teks | 6 | 0 | 0 | Teks mengutamakan diksi akademik yang komunikatif ("Arah Kebijakan Kelembagaan", "Penelitian Terapan", "Pengabdian kepada Masyarakat"), bebas jargon teknis rumit. |
| C1 Mandat AGENTS.md | 10 | 0 | 0 | 100% bebas emoji (0), bebas kata "resmi" (0), patuh penuh pada grid 4px (seluruh kelas kelipatan 4px), menyertakan dukungan CMS penuh. |
| C2 Dokumen Kebutuhan PDF | 6 | 0 | 0 | **Sesuai 100%**: Langsung menampilkan Dokumen Rencana Strategis Penelitian 2026-2031 dan Dokumen Rencana Strategis Pengabdian Kepada Masyarakat sesuai Halaman 1 [Kebutuhan Website P3M rev.pdf](file:///c:/laragon/www/p3m/Kebutuhan%20Website%20P3M%20rev.pdf). |

---

## Hasil Pemeriksaan Otomatis

- php artisan test     : Lulus 186 / Gagal 0 (100% kelulusan, 896 assertions)
- npm run build        : Sukses (Vite v5.4.21, app.css 73.89 kB, app.js 107.37 kB dalam 4.47s)
- pint --test          : Bersih (Passed dengan standar PSR-12 / Laravel Standards)
- Pemindaian Grid 4px  : 0 pelanggaran (seluruh margin, padding, height kelipatan 4px, iframe berukuran `h-[768px]`)
- Pemindaian Kata 'Resmi' : 0 kemunculan
- Pemindaian Emoji     : 0 kemunculan

---

## Analisis Kesesuaian Dokumen Kebutuhan & Anti Over-Engineering

### 1. Temuan Ketidaksesuaian Awal (Over-Engineering & Scope Creep)
Dokumen acuan **[Kebutuhan Website P3M rev.pdf](file:///c:/laragon/www/p3m/Kebutuhan%20Website%20P3M%20rev.pdf)** (Halaman 1) mendefinisikan:
- **Menu**: Profil
- **Sub Menu**: Rencana Strategis
- **Isi Tampilan**: *"Dokumen Rencana Strategis Penelitian 2026-2031 dan Dokumen Rencana Strategis Pengabdian Kepada Masyarakat"*

Namun kode sebelumnya menambahkan:
1. Tiga kartu indikator capaian renstra (periode, pilar prodi, fokus riset).
2. Tiga kartu pilar program studi (D4 RSTJ, D4 TRO, D3 TO).
3. Seksi dokumen regulasi & SOP pendukung.
4. Banner CTA besar ke SIM P3M.
5. Modal popup dengan kotak pratinjau abu-abu kosong alih-alih menampilkan berkas dokumen asli.
Hal ini melanggar kriteria **A9 Anti Over-Engineering (KISS & YAGNI)** dan menyimpang dari mandat kesederhanaan dokumen kebutuhan.

### 2. Solusi Refaktorisasi yang Telah Diterapkan
1. **Pemangkasan Kode Bloat**: Menghapus seluruh seksi asing yang tidak diminta sehingga file Blade menjadi ramping, bersih, dan berorientasi dokumen (~194 baris).
2. **Penerapan Tab Interaktif (Alpine.js)**:
   - **Tab 1**: Dokumen Rencana Strategis Penelitian 2026-2031
   - **Tab 2**: Dokumen Rencana Strategis Pengabdian Kepada Masyarakat
3. **Penampil PDF Langsung (*Direct PDF Embed*)**:
   - Menyematkan elemen `<iframe>` responsif (`h-[768px]`) untuk kedua dokumen sehingga pengunjung dan dosen dapat langsung membaca isi dokumen secara utuh di halaman web tanpa wajib mengunduh terlebih dahulu.
   - Menyediakan tautan dan tombol unduh langsung berstandar ergonomis (`h-11` = 44px) yang menaikkan counter unduhan secara atomik.
4. **Pengelolaan Penuh Melalui CMS Admin**:
   - Membangun antarmuka CMS di `/admin/settings/renstra`.
   - Mengizinkan Administrator P3M untuk menyunting badge, judul, paragraf pengantar, konten HTML kustom, serta mengunggah/mengganti berkas PDF kedua renstra secara mandiri.

---

## Temuan & Tindakan Perbaikan

| ID | Area | Lokasi | Temuan | Level | Rekomendasi | Status |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| AUD-RENSTRA-06 | Over-Engineering | `resources/views/profil/rencana-strategis.blade.php` | Halaman memuat seksi bertumpuk yang tidak diminta oleh dokumen kebutuhan (indikator, prodi, sop, cta) dan modal reader tiruan. | Tinggi | Pangkas seksi berlebih, implementasikan penampil PDF langsung (*embed iframe*) berbasis Tab Interaktif sesuai dokumen kebutuhan. | Selesai |
| AUD-RENSTRA-07 | Kelengkapan CMS | `app/Http/Controllers/Admin/SettingController.php` | Belum ada menu CMS khusus untuk mengelola teks pengantar, HTML kustom, dan berkas PDF Rencana Strategis. | Sedang | Buat rute dan method `editRenstra()` & `updateRenstra()` serta formulir CMS di `resources/views/admin/settings/renstra.blade.php`. | Selesai |
| AUD-RENSTRA-08 | Grid Spasial | `resources/views/profil/rencana-strategis.blade.php:137,199` | Tinggi iframe sebelumnya menggunakan `h-[750px]` (bukan kelipatan 4px). | Rendah | Sesuaikan tinggi iframe menjadi `h-[768px]` (kelipatan 4px murni). | Selesai |
| AUD-RENSTRA-09 | Cakupan Uji | `tests/Feature/AdminSettingTest.php` | Pengujian akses dan pembaruan pengaturan renstra via CMS belum ada. | Rendah | Tambahkan 3 unit pengujian baru di `AdminSettingTest` untuk menguji hak akses admin, validasi unggah PDF, dan penolakan non-admin. | Selesai |

---

## Keputusan

- Hasil  : **Lulus**
- Alasan : Halaman Profil > Rencana Strategis kini telah 100% selaras dengan dokumen [Kebutuhan Website P3M rev.pdf](file:///c:/laragon/www/p3m/Kebutuhan%20Website%20P3M%20rev.pdf), terbebas dari *over-engineering*, menyajikan penampil dokumen PDF langsung (*embed*) via Tab Interaktif, serta dapat dikustomisasi secara menyeluruh (teks, HTML, dan berkas PDF) melalui panel CMS Admin. Seluruh pengujian fitur lulus 100% (186 tes).
- Tindak lanjut : Sistem siap dan telah memenuhi kepatuhan tata kelola.
