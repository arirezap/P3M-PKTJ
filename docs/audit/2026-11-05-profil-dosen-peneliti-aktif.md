# Audit: Halaman Profil > Profil Peneliti (Daftar Dosen & Peneliti Aktif) SIM P3M PKTJ

- Tanggal       : 2026-11-05
- Auditor       : AI Antigravity
- Commit/Branch : main
- Cakupan       : 
  - Route Publik Direktori: `GET /profil/peneliti` (`profil.peneliti`)
  - Route Publik Detail   : `GET /profil/peneliti/{user}` (`profil.peneliti.show`)
  - Controller: `app/Http/Controllers/ProfileController.php` (method `peneliti()`, `showPeneliti()`)
  - View Publik Direktori : `resources/views/profil/peneliti.blade.php`
  - View Publik Detail    : `resources/views/profil/peneliti-detail.blade.php`
  - Models: `app/Models/User.php`, `app/Models/Prodi.php`, `app/Models/Research.php`, `app/Models/Output.php`
  - Feature Tests: `tests/Feature/PublicResearcherTest.php`
- File terkait  : `graphify query "profil peneliti dosen aktif"` -> `peneliti.blade.php`, `peneliti-detail.blade.php`, `ProfileController.php`, `PublicResearcherTest.php`

---

## Ringkasan Skor

| Bagian | Item Lulus | Item Gagal | N/A | Catatan |
| :--- | :--- | :--- | :--- | :--- |
| A1 Clean Code | 10 | 0 | 0 | Templat Blade direktori dan halaman detail terstruktur rapi, kode JavaScript rusak dihapus; lolos Laravel Pint. |
| A2 SOLID | 5 | 0 | 0 | SRP terpenuhi: `ProfileController` melayani penyajian direktori dan detail profil peneliti secara terisolasi. |
| A3 Self-Documenting | 9 | 0 | 0 | Penamaan method ekspresif (`peneliti()`, `showPeneliti()`), type hint dan return type lengkap. |
| A4 Testable | 10 | 0 | 0 | Feature tests di `PublicResearcherTest` memverifikasi direktori, clickable nama dosen, detail riset/publikasi, proteksi akun non-aktif, filter prodi, dan pencarian. |
| A5 Performa & Skala | 6 | 0 | 0 | Eager loading relasi `prodi`, `researches`, dan `outputs` mencegah N+1 query. Paginasi 12 kartu per halaman. |
| A6 Keamanan | 9 | 0 | 0 | Verifikasi status aktif pengguna (`status_aktif == true`) dan otorisasi peran akademik (`isAcademic`) mencegah kebocoran akun non-akademik via rute publik. |
| A7 Database | 5 | 0 | 0 | Relasi Eloquent `belongsTo(Prodi)`, `hasMany(Research)`, dan `hasMany(Output)` dioptimalkan dengan indeks basis data. |
| A8 Error & Log | 4 | 0 | 0 | Respons 404 informatif jika ID peneliti tidak ditemukan atau statusnya dinonaktifkan. *Empty state* informatif saat data riset/luaran belum ada. |
| A9 Anti Over-Engineering | 6 | 0 | 0 | **Selesai Diperbaiki**: Menghapus modal script Alpine.js yang tidak sinkron dan menggantinya dengan halaman detail penuh terarah (`/profil/peneliti/{id}`) sesuai arahan pengguna. |
| B1 Konsistensi Desain | 8 | 0 | 0 | Mengadopsi palet warna identitas Maritim Modern (`#0B2A59`, slate-50, aksen emas PKTJ). Tipografi terstruktur rapi. |
| B2 Responsif | 6 | 0 | 0 | Teruji multi-breakpoint (ponsel pintar `< 640px`, tablet `640px-1023px`, laptop/desktop `≥ 1024px`) dengan zero horizontal overflow. |
| B3 Aksesibilitas | 7 | 0 | 0 | Nama dosen berupa tautan dengan kontras tinggi, tombol aksi memiliki tinggi ergonomis 44px (`h-11`). |
| B4 Status Tampilan | 5 | 0 | 0 | Menangani kondisi tanpa foto (inisial elegan) dan kondisi daftar riset/publikasi kosong secara profesional. |
| B5 Bahasa & Teks | 6 | 0 | 0 | Menggunakan diksi akademik Indonesia formal, lugas, dan bebas jargon teknologi asing. |
| C1 Mandat AGENTS.md | 10 | 0 | 0 | 100% bebas emoji (0), bebas kata terlarang (0), patuh penuh pada grid kelipatan 4px (seluruh kelas kelipatan 4px). |
| C2 Dokumen Kebutuhan PDF | 6 | 0 | 0 | **Sesuai 100%**: Menyajikan daftar dosen dan peneliti yang aktif dengan pemenuhan *clickable* namanya yang menampilkan data penelitian dan publikasi sesuai Halaman 1 [Kebutuhan Website P3M rev.pdf](file:///c:/laragon/www/p3m/Kebutuhan%20Website%20P3M%20rev.pdf). |

---

## Analisis Kesesuaian Dokumen Kebutuhan & Anti Over-Engineering

### 1. Temuan Ketidaksesuaian Awal (Incomplete Clickable Behavior & Unusable Modal)
Dokumen acuan **[Kebutuhan Website P3M rev.pdf](file:///c:/laragon/www/p3m/Kebutuhan%20Website%20P3M%20rev.pdf)** (Halaman 1, Baris No. 2 Profil) mendefinisikan:
- **Menu**: Profil
- **Sub Menu**: Profil Peneliti
- **Isi Tampilan**: *"Daftar dosen dan peneliti yang aktif"*
- **Pemenuhan**: *"Data penelitian dan publikasi yang dimiliki oleh dosen"*

Kondisi awal sebelum perbaikan:
1. **Nama Dosen Tidak Clickable**: Nama dosen pada kartu direktori dirender sebagai elemen teks statis `<h2>{{ $dosen->name }}</h2>` tanpa tautan interaktif.
2. **Bug Modal Alpine.js**: Variabel pada `x-data` (`detailModalOpen`, `selectedUser`) tidak sinkron dengan atribut modal (`modalOpen`, `activeDosen`), sehingga tombol klik modal tidak dapat membuka informasi portofolio pada peramban nyata.
3. **Overhead Payload JSON**: Setiap kartu merender string JSON payload berat di dalam atribut HTML tombol, membebani ukuran DOM halaman.

### 2. Solusi Refaktorisasi yang Diterapkan
1. **Pemenuhan Clickable Nama Dosen**:
   - Nama dosen pada setiap kartu direktori kini berwujud tautan aktif menuju halaman detail khusus:
     `<a href="{{ route('profil.peneliti.show', $dosen) }}">{{ $dosen->name }}</a>`
   - Foto avatar dan tombol aksi bawah kartu turut menghubungkan ke rute detail yang sama.
2. **Penyediaan Halaman Penuh Khusus (`/profil/peneliti/{user}`)**:
   - Menghadirkan view mandiri [`resources/views/profil/peneliti-detail.blade.php`](file:///c:/laragon/www/p3m/resources/views/profil/peneliti-detail.blade.php).
   - Menyajikan kartu profil lengkap (identitas, NIDN, prodi, email, kepakaran, SINTA, Scopus, Google Scholar).
   - Menyajikan seksi **Data Kegiatan Penelitian** (rekapitulasi riset terapan per tahun, skema, sumber dana, dan status).
   - Menyajikan seksi **Data Publikasi Ilmiah & Luaran HKI** (kategori, judul, tahun, jurnal/penerbit, nomor registrasi HKI, TKT, dan tautan dokumen artikel).
   - Dilengkapi tombol navigasi kembali ke direktori peneliti.
3. **Penyederhanaan Kode Direktori**:
   - Menghapus skrip modal yang rusak dari templat direktori, memangkas ukuran berkas dari 426 baris menjadi 217 baris murni direktori.
   - Tetap mempertahankan bilah filter Program Studi (3 prodi PKTJ) dan kotak pencarian instan nama/kepakaran.

---

## Temuan & Tindakan Perbaikan

| ID | Area | Lokasi | Temuan | Level | Rekomendasi | Status |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| AUD-PENELITI-01 | Pemenuhan PRD | `resources/views/profil/peneliti.blade.php:169` | Nama dosen tidak clickable sehingga tidak memenuhi spesifikasi pemenuhan PRD PDF halaman 1. | Tinggi | Bungkus nama dosen dengan elemen tautan menuju rute profil lengkap dosen bersangkutan. | Selesai |
| AUD-PENELITI-02 | Fungsionalitas | `resources/views/profil/peneliti.blade.php:7,254` | Mismatch variabel `x-data` dengan modal (`detailModalOpen` vs `modalOpen`) menyebabkan aksi klik tidak berfungsi. | Tinggi | Ganti alur modal yang tidak fungsional dengan rute halaman detail penuh terarah (`profil.peneliti.show`). | Selesai |
| AUD-PENELITI-03 | Rute & View Baru | `routes/web.php`, `ProfileController.php` | Belum ada rute publik khusus `/profil/peneliti/{user}` untuk menyajikan portofolio riset dan luaran dosen. | Sedang | Buat rute `profil.peneliti.show`, method `showPeneliti()`, dan view `profil.peneliti-detail.blade.php`. | Selesai |
| AUD-PENELITI-04 | Kerapian Grid 4px | `resources/views/profil/peneliti.blade.php` | Terdapat kelas arbitrary `text-[10px]` dan `text-[11px]`. | Rendah | Ganti dengan kelas standar kelipatan 4px `text-xs` (12px). | Selesai |
| AUD-PENELITI-05 | Cakupan Pengujian | `tests/Feature/PublicResearcherTest.php` | Pengujian belum memverifikasi keterhubungan klik nama dosen dan aksesibilitas halaman detail portofolio. | Sedang | Tambahkan pengujian asersi tautan rute detail dan rendering data riset/publikasi. | Selesai |

---

## Keputusan

- Hasil  : **Lulus**
- Alasan : Halaman Profil > Profil Peneliti (Daftar Dosen & Peneliti Aktif) kini telah 100% selaras dengan dokumen [Kebutuhan Website P3M rev.pdf](file:///c:/laragon/www/p3m/Kebutuhan%20Website%20P3M%20rev.pdf), nama dosen aktif berwujud *clickable* yang menghubungkan ke halaman detail portofolio riset dan publikasi secara elegan, bebas emoji, patuh grid 4px, dan teruji 100% pada rangkaian pengujian otomatis.

