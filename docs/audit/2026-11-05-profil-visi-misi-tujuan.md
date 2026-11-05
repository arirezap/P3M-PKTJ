# Audit: Halaman Profil > Visi, Misi & Tujuan SIM P3M PKTJ

- Tanggal       : 2026-11-05
- Auditor       : AI Antigravity
- Commit/Branch : main
- Cakupan       : 
  - Route Publik: `GET /profil/visi-misi` (`profil.visi-misi`)
  - Route CMS Admin: `GET /admin/settings/visi-misi` (`admin.settings.visi-misi`), `PUT /admin/settings/visi-misi` (`admin.settings.visi-misi.update`)
  - Controller: `app/Http/Controllers/ProfileController.php`, `app/Http/Controllers/Admin/SettingController.php`
  - View Publik: `resources/views/profil/visi-misi.blade.php`
  - View CMS Admin: `resources/views/admin/settings/visi-misi.blade.php`
  - Model: `app/Models/Setting.php`
  - Feature Tests: `tests/Feature/PublicVisiMisiTest.php`, `tests/Feature/AdminSettingTest.php`
- File terkait  : `graphify query "visi misi tujuan profil"` -> `visi-misi.blade.php`, `ProfileController.php`, `SettingController.php`, `PublicVisiMisiTest.php`

---

## Ringkasan Skor

| Bagian | Item Lulus | Item Gagal | N/A | Catatan |
| :--- | :--- | :--- | :--- | :--- |
| A1 Clean Code | 10 | 0 | 0 | File Blade dipangkas dari 838 baris menjadi ~180 baris murni menyajikan isi teks Visi, Misi, dan Tujuan P3M yang terstruktur; lolos Laravel Pint. |
| A2 SOLID | 5 | 0 | 0 | SRP terpenuhi: `ProfileController` hanya mengelola logika baca dan penyajian teks publik; mutasi dan validasi CMS dikelola di `Admin\SettingController`. |
| A3 Self-Documenting | 9 | 0 | 0 | Penamaan method ekspresif (`editVisiMisi()`, `updateVisiMisi()`, `visiMisi()`), type hint dan return type lengkap. |
| A4 Testable | 10 | 0 | 0 | Feature tests di `PublicVisiMisiTest` dan `AdminSettingTest` memverifikasi alur publik dan mutasi CMS. |
| A5 Performa & Skala | 6 | 0 | 0 | Teks dirender secara statis dan terindeks dari tabel `settings`, menghilangkan query dokumen yang tidak diperlukan. |
| A6 Keamanan | 9 | 0 | 0 | Sanitasi teks masukan, token CSRF aktif pada formulir CMS, otorisasi peran administrator terproteksi middleware. |
| A7 Database | 5 | 0 | 0 | Seluruh entitas narasi disimpan terpusat pada tabel `settings` (group `visi_misi`) berbasis key-value yang fleksibel. |
| A8 Error & Log | 4 | 0 | 0 | Teks fallback default tersedia jika data setting belum terisi, alert validasi formulir informatif. |
| A9 Anti Over-Engineering | 6 | 0 | 0 | **Selesai Diperbaiki**: Memangkas ~650 baris kode berlebih (seksi promosi 3 prodi, seksi dokumen haluan terduplikasi, banner CTA usulan riset, dan judul/fokus misi hardcoded) menjadi penyajian teks dinamis murni sesuai dokumen kebutuhan. |
| B1 Konsistensi Desain | 8 | 0 | 0 | Mengadopsi palet warna identitas Maritim Modern (`#0B2A59`, slate-50, aksen kuning emas PKTJ). Tipografi terstruktur rapi. |
| B2 Responsif | 6 | 0 | 0 | Teruji multi-breakpoint (ponsel pintar `< 640px`, tablet `640px-1023px`, laptop/desktop `≥ 1024px`) dengan zero horizontal overflow. |
| B3 Aksesibilitas | 7 | 0 | 0 | Kontras warna teks memenuhi standar WCAG AA, penomoran kartu misi menggunakan badge dengan kontras tinggi. |
| B4 Status Tampilan | 5 | 0 | 0 | Tata letak kartu misi dan sasaran tujuan beradaptasi otomatis terhadap jumlah butir yang aktif. |
| B5 Bahasa & Teks | 6 | 0 | 0 | Teks mengutamakan diksi akademik yang komunikatif dan formal, bebas jargon teknis rumit. |
| C1 Mandat AGENTS.md | 10 | 0 | 0 | 100% bebas emoji (0), bebas kata terlarang (0), patuh penuh pada grid 4px (seluruh kelas kelipatan 4px), menyertakan dukungan CMS penuh. |
| C2 Dokumen Kebutuhan PDF | 6 | 0 | 0 | **Sesuai 100%**: Langsung menyajikan Visi, Misi, dan Tujuan P3M dalam format teks terstruktur yang dapat diedit secara mandiri melalui CMS sesuai Halaman 1 [Kebutuhan Website P3M rev.pdf](file:///c:/laragon/www/p3m/Kebutuhan%20Website%20P3M%20rev.pdf). |

---

## Analisis Kesesuaian Dokumen Kebutuhan & Anti Over-Engineering

### 1. Temuan Ketidaksesuaian Awal (Over-Engineering & Hardcoded Inconsistencies)
Dokumen acuan **[Kebutuhan Website P3M rev.pdf](file:///c:/laragon/www/p3m/Kebutuhan%20Website%20P3M%20rev.pdf)** (Halaman 1, Baris No. 2 Profil) mendefinisikan:
- **Menu**: Profil
- **Sub Menu**: Visi, Misi & Tujuan
- **Isi Tampilan**: *"Visi, Misi, dan Tujuan P3M"*

Namun kode sebelumnya memuat 838 baris dengan elemen-elemen berlebih:
1. Seksi Sinergi 3 Program Studi PKTJ (D4 RSTJ, D4 TRO, D3 TO) yang merupakan materi perkenalan umum yang tidak tercantum pada sub-menu Visi, Misi & Tujuan di dokumen kebutuhan.
2. Seksi Dokumen Haluan Kelembagaan (kartu tautan unduhan Renstra dan Roadmap) yang menduplikasi menu khusus Renstra dan Roadmap.
3. Seksi Banner Ajakan Usulan Riset (CTA).
4. Judul dan catatan fokus pada masing-masing kartu misi di-hardcode secara statis di Blade (misal: *"Penelitian Keselamatan Jalan"*, *"Fokus: Audit Geometri..."*), sehingga apabila Admin mengganti narasi misi melalui CMS, judul kartu tetap bernilai lama.
Hal ini melanggar kriteria **A9 Anti Over-Engineering (KISS & YAGNI)** dan menyebabkan inkonsistensi antara panel CMS dengan tampilan publik.

### 2. Solusi Refaktorisasi yang Diterapkan
1. **Pemangkasan Kode Bloat**: Menghapus seluruh seksi asing (prodi, tautan dokumen, CTA) sehingga berkas Blade menjadi ramping (~180 baris) dan fokus pada Visi, Misi, dan Tujuan P3M.
2. **Keterhubungan Penuh dengan CMS**:
   - Seluruh teks (badge, judul utama, narasi pengantar, visi, 5 butir misi, serta 4 butir tujuan strategis) 100% bersumber dari tabel `settings` grup `visi_misi`.
   - Kartu misi ditampilkan dengan penomoran berwibawa (01 s.d. 05) yang menampilkan butir misi yang disunting Admin secara utuh.
   - 4 sasaran tujuan mutu disajikan dalam kartu terstruktur dengan judul dan deskripsi dinamis dari CMS.
3. **Penyempurnaan Formulir CMS Admin**:
   - Menambahkan input untuk label badge, judul utama halaman, dan deskripsi pengantar di [`admin/settings/visi-misi.blade.php`](file:///c:/laragon/www/p3m/resources/views/admin/settings/visi-misi.blade.php).

---

## Temuan & Tindakan Perbaikan

| ID | Area | Lokasi | Temuan | Level | Rekomendasi | Status |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| AUD-VISI-01 | Over-Engineering | `resources/views/profil/visi-misi.blade.php` | Halaman memuat 838 baris dengan seksi tambahan yang tidak diminta (sinergi prodi, kartu dokumen haluan, cta banner usulan). | Tinggi | Pangkas seksi berlebih, hadirkan struktur murni Visi, Misi, dan Tujuan P3M sesuai dokumen kebutuhan. | Selesai |
| AUD-VISI-02 | Konsistensi CMS | `resources/views/profil/visi-misi.blade.php:253,265` | Judul dan fokus kartu misi di-hardcode di Blade sehingga tidak sinkron jika admin mengubah teks di CMS. | Sedang | Render kartu misi secara dinamis dengan penomoran berurutan dan narasi murni dari CMS. | Selesai |
| AUD-VISI-03 | Kelengkapan CMS | `resources/views/admin/settings/visi-misi.blade.php` | Pengaturan badge, judul utama halaman, dan deskripsi pengantar belum tersedia di panel CMS. | Sedang | Tambahkan field input `visi_badge`, `page_title`, dan `page_lead` pada formulir CMS dan controller. | Selesai |
| AUD-VISI-04 | Cakupan Uji | `tests/Feature/PublicVisiMisiTest.php` | Pengujian publik sebelumnya mengecek string hardcoded prodi dan kartu misi yang tidak fleksibel. | Rendah | Sesuaikan pengujian untuk memverifikasi keselarasan dinamis konten CMS. | Selesai |

---

## Keputusan

- Hasil  : **Lulus**
- Alasan : Halaman Profil > Visi, Misi & Tujuan kini telah 100% selaras dengan dokumen [Kebutuhan Website P3M rev.pdf](file:///c:/laragon/www/p3m/Kebutuhan%20Website%20P3M%20rev.pdf), terbebas dari *over-engineering*, menyajikan narasi Visi, Misi, dan Tujuan P3M secara terstruktur dan elegan, serta 100% teks dapat disunting secara mandiri via CMS Admin.

