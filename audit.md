# Panduan Audit Kode & Tampilan P3M PKTJ

Dokumen ini dipakai ulang setiap kali ada fungsi, halaman, atau modul yang perlu diaudit. Salin bagian **Lembar Audit** di akhir dokumen, isi, lalu simpan hasilnya (misalnya di `docs/audit/2026-11-03-beranda.md`).

Acuan utama: [AGENTS.md](AGENTS.md), [design.md](design.md), [PERENCANAAN_PROYEK_P3M.md](PERENCANAAN_PROYEK_P3M.md), [PRD.md](PRD.md), dan [Kebutuhan Website P3M rev.pdf](Kebutuhan%20Website%20P3M%20rev.pdf).

Stack: Laravel 11, PHP 8.2, Blade, Tailwind CSS 3.4, Alpine.js 3, Vite 5, PHPUnit 10, Laravel Pint.

---

## 0. Cara Pakai

1. **Tentukan cakupan.** Satu audit = satu target yang jelas: satu halaman (misal Beranda), satu fitur (misal Pengajuan Usulan), atau satu kelas (misal `ProposalController`).
2. **Petakan file terkait.** Jalankan `graphify query "<nama fitur>"` untuk menemukan route, controller, model, view, dan test yang terhubung.
3. **Jalankan pemeriksaan otomatis** di [Bagian D](#d-perintah-pemeriksaan-otomatis). Hasilnya jadi bahan awal temuan.
4. **Isi checklist** Bagian A, B, dan C. Lewati item yang tidak relevan dengan menandai `N/A`.
5. **Catat temuan** di tabel [Bagian E](#e-format-laporan-temuan) lengkap dengan lokasi `file:baris`, tingkat keparahan, dan rekomendasi.
6. **Tentukan status akhir** berdasarkan [Kriteria Lulus](#kriteria-lulus-audit).

### Penanda Checklist

| Penanda | Arti |
| :--- | :--- |
| `[x]` | Lulus, sudah sesuai |
| `[ ]` | Belum sesuai, wajib dicatat di tabel temuan |
| `N/A` | Tidak berlaku untuk target ini |

### Tingkat Keparahan

| Level | Arti | Contoh | Batas Waktu |
| :--- | :--- | :--- | :--- |
| **Kritis** | Celah keamanan, kehilangan data, atau fitur utama tidak jalan | Dosen bisa membuka usulan dosen lain, file upload tanpa validasi | Perbaiki sebelum rilis |
| **Tinggi** | Melanggar mandat proyek atau merusak pengalaman pengguna | Layout pecah di ponsel, ada emoji di UI, query N+1 di daftar 500 data | Perbaiki di sprint berjalan |
| **Sedang** | Menurunkan kualitas dan kemudahan perawatan | Controller 400 baris, validasi ditulis ulang di 3 tempat | Jadwalkan perbaikan |
| **Rendah** | Kerapian dan konsistensi kecil | Nama variabel kurang jelas, komentar basi | Perbaiki saat menyentuh file |

---

## A. Kualitas Kode

### A1. Clean Code

- [ ] Nama kelas, method, dan variabel menjelaskan tujuan tanpa perlu komentar (`$approvedProposals`, bukan `$data2`).
- [ ] Satu method melakukan satu hal. Method lebih dari ~30 baris dicurigai melakukan terlalu banyak.
- [ ] Tidak ada kode mati: method tak terpakai, variabel tak terpakai, blok `if (false)`, atau kode yang dikomentari.
- [ ] Tidak ada duplikasi logika. Potongan Blade yang muncul di 2+ halaman sudah dijadikan komponen (`resources/views/components/`).
- [ ] Tidak ada angka atau string ajaib. Status usulan, peran pengguna, dan kategori memakai konstanta atau enum, bukan `'diterima'` yang ditulis ulang di banyak file.
- [ ] Kedalaman `if` bersarang maksimal 2 level. Gunakan *early return* / *guard clause*.
- [ ] Parameter method maksimal 3–4. Lebih dari itu, bungkus dalam objek atau array bernama.
- [ ] Format kode lolos Laravel Pint (`vendor\bin\pint --test`).
- [ ] Tidak ada sisa debug: `dd()`, `dump()`, `var_dump()`, `ray()`, `console.log()`.
- [ ] Ukuran file wajar: controller < 300 baris, model < 300 baris, view Blade < 500 baris. Lebih dari itu, pecah.

### A2. SOLID Principles

| Prinsip | Yang Diperiksa di Proyek Laravel Ini |
| :--- | :--- |
| **S** – Single Responsibility | Controller hanya menerima request, memanggil logika, dan mengembalikan response. Validasi di Form Request, logika bisnis (alur status usulan, perhitungan skor reviewer) di Service/Action, query kompleks di scope model. |
| **O** – Open/Closed | Menambah jenis baru (misal skema hibah baru, kategori luaran baru) cukup menambah data atau kelas baru, tanpa membongkar `if/else` panjang di banyak tempat. |
| **L** – Liskov Substitution | Kelas turunan atau implementasi interface bisa menggantikan induknya tanpa mengubah perilaku yang diharapkan pemanggil. |
| **I** – Interface Segregation | Interface atau trait kecil dan spesifik. Model tidak memakai trait yang separuh method-nya tidak relevan. |
| **D** – Dependency Inversion | Dependensi masuk lewat constructor/method injection, bukan `new` di tengah method atau facade yang membuat kelas sulit diuji. |

- [ ] Controller tidak berisi query mentah panjang, perhitungan bisnis, atau manipulasi file.
- [ ] Validasi input memakai Form Request (`app/Http/Requests`), bukan `$request->validate()` yang diulang di banyak method.
- [ ] Hak akses diatur di satu tempat (middleware `CheckRole`, Policy, atau Gate), tidak disebar sebagai `if ($user->role == ...)` di controller dan view.
- [ ] Data bersama untuk banyak view (navbar, footer, pengaturan) dibagikan lewat View Composer, bukan diquery ulang di setiap controller.
- [ ] Logika yang dipakai 2+ controller dipindahkan ke Service, Action, atau scope model.

### A3. Self-Documenting Code

- [ ] Nama method berbentuk kata kerja yang jelas: `assignReviewer()`, `submitFinalReport()`, `archive()`.
- [ ] Nama boolean berbentuk pertanyaan: `isAdmin()`, `hasSubmittedMonev()`, `canBeEdited()`.
- [ ] Type hint dan return type ada di semua method publik (`public function store(StoreProposalRequest $request): RedirectResponse`).
- [ ] Relasi Eloquent diberi return type (`: BelongsTo`, `: HasMany`).
- [ ] Nama route konsisten dan bertingkat: `admin.settings.header-footer.update`, `dosen.proposals.create`.
- [ ] Komentar hanya menjelaskan **alasan** (aturan bisnis, keputusan desain, batasan dari PRD), bukan mengulang apa yang sudah terbaca dari kode.
- [ ] Tidak ada komentar basi yang bertentangan dengan kode di bawahnya.
- [ ] Komentar dan docblock yang tidak terkait perubahan tetap dipertahankan.
- [ ] Istilah domain konsisten di seluruh lapisan (database, model, view): usulan, luaran, monev, laporan akhir, reviewer.

### A4. Testable Code (Dapat Diuji)

- [ ] Setiap route publik dan route per peran (admin, dosen, reviewer) punya feature test minimal untuk status 200 / redirect yang benar.
- [ ] Ada test hak akses negatif: tamu ditolak, dosen tidak bisa masuk area admin, dosen A tidak bisa melihat usulan dosen B, reviewer tidak bisa menilai usulan yang bukan tugasnya.
- [ ] Ada test validasi: input kosong, format salah, file melebihi batas ditolak dengan pesan yang benar.
- [ ] Ada test alur status: draf → diajukan → direview → revisi/diterima/ditolak → monev → laporan akhir.
- [ ] Test memakai `RefreshDatabase` dan factory/seeder, tidak bergantung pada data lokal pengembang.
- [ ] Penyimpanan file diuji dengan `Storage::fake()`, email/notifikasi dengan `Mail::fake()` / `Notification::fake()`.
- [ ] Logika bisnis di Service/Action bisa diuji tanpa HTTP request.
- [ ] Tidak ada `now()`, `rand()`, atau panggilan API luar yang tidak bisa dikendalikan dari test (gunakan `Carbon::setTestNow()` / `Http::fake()`).
- [ ] Assertion teks HTML yang mengandung `&` memakai `assertSee($teks, false)`.
- [ ] `php artisan test` lulus 100%.

### A5. Performant & Scalable

**Database**

- [ ] Tidak ada query N+1. Relasi yang dipakai di loop sudah di-*eager load* (`with()`, `load()`, `withCount()`).
- [ ] Daftar data memakai `paginate()` / `simplePaginate()`, bukan `get()` / `all()` tanpa batas.
- [ ] Hanya kolom yang perlu yang diambil (`select()`) untuk daftar besar.
- [ ] Kolom yang sering dipakai di `where`, `orderBy`, dan foreign key sudah punya index di migration.
- [ ] Agregasi (jumlah, total anggaran) dihitung di database (`count()`, `sum()`, `withSum()`), bukan dengan mengambil semua baris lalu dihitung di PHP.
- [ ] Operasi tulis yang menyentuh beberapa tabel dibungkus `DB::transaction()`.
- [ ] Impor/ekspor data besar memakai `chunk()` / `lazy()` atau queue.

**Cache & Proses Berat**

- [ ] Data yang jarang berubah dan sering dibaca (pengaturan situs, menu, visi misi) di-cache dan cache dibersihkan saat data diubah.
- [ ] Proses lambat (kirim email, olah file, buat PDF) dijalankan lewat queue bila memungkinkan.

**Frontend**

- [ ] Gambar diberi ukuran yang sesuai tampilan, memakai `loading="lazy"` di luar area pertama layar, dan `alt` yang deskriptif.
- [ ] Gambar besar (> 300 KB) sudah dikompres atau dikonversi ke WebP.
- [ ] Iframe video memakai `loading="lazy"`.
- [ ] Tidak ada library JS/CSS yang dimuat tapi tidak dipakai di halaman tersebut.
- [ ] `npm run build` sukses dan ukuran CSS/JS hasil build tidak melonjak tanpa alasan.

### A6. Keamanan

- [ ] Setiap route sensitif dilindungi middleware `auth` dan peran yang tepat.
- [ ] Kepemilikan data dicek di server (Policy atau query `where('user_id', auth()->id())`), bukan hanya disembunyikan di tampilan.
- [ ] Model memakai `$fillable` yang eksplisit. Tidak ada `$guarded = []` tanpa alasan kuat.
- [ ] Semua input divalidasi di server, termasuk tipe, panjang, dan nilai yang diizinkan (`in:`, `exists:`).
- [ ] Output memakai `{{ }}`. Setiap `{!! !!}` sudah dibersihkan (konten TinyMCE disanitasi sebelum disimpan atau ditampilkan).
- [ ] Data PHP ke Alpine/JS memakai `Js::from()` atau `@js()`, bukan menempel string mentah ke atribut.
- [ ] Semua form POST/PUT/DELETE memiliki `@csrf` dan `@method` yang sesuai.
- [ ] Upload file dibatasi `mimes:` dan `max:`, nama file di-generate ulang, dan disimpan di disk yang tidak bisa dieksekusi.
- [ ] Unduhan berkas privat melewati controller yang mengecek hak akses, bukan tautan langsung ke folder publik.
- [ ] Tidak ada kredensial, token, atau kata sandi di kode. `env()` hanya dipanggil di folder `config/`.
- [ ] Login dibatasi percobaannya (rate limit).
- [ ] `composer audit` dan `npm audit --omit=dev` tidak menunjukkan celah tingkat tinggi.

### A7. Database & Integritas Data

- [ ] Perubahan struktur tabel hanya lewat migration baru. Migration lama yang sudah dijalankan tidak diedit.
- [ ] Foreign key punya aturan `onDelete` yang jelas (`cascade`, `restrictOnDelete`, atau `nullOnDelete`).
- [ ] Data penting (usulan, luaran, pengguna) memakai `SoftDeletes` agar bisa dipulihkan.
- [ ] Method `down()` di migration bisa membalikkan perubahan.
- [ ] Seeder hanya memakai 3 prodi PKTJ: D4 RSTJ, D4 TRO, D3 TO.
- [ ] Nilai uang disimpan sebagai `decimal` atau `bigInteger` (rupiah), bukan `float`.

### A8. Penanganan Error & Log

- [ ] Kegagalan yang bisa diperkirakan (file gagal disimpan, data tidak ditemukan) ditangani dan pengguna melihat pesan yang jelas, bukan halaman error mentah.
- [ ] `findOrFail()` / route model binding dipakai agar data yang tidak ada menghasilkan 404.
- [ ] Tidak ada `try/catch` kosong yang menelan error.
- [ ] Error penting dicatat dengan `Log::error()` beserta konteks (id usulan, id pengguna), tanpa mencatat kata sandi atau data pribadi.
- [ ] `APP_DEBUG=false` di server produksi.

### A9. Anti Over-Engineering (KISS, YAGNI & Pragmatisme)

- [ ] **YAGNI (You Aren't Gonna Need It)**: Tidak membangun fitur, fungsi, atau abstraksi antisipatif untuk kemungkinan masa depan yang belum diminta di dokumen kebutuhan.
- [ ] **KISS (Keep It Simple, Stupid)**: Memilih solusi paling sederhana dan lugas. Jika alur kerja cukup diselesaikan dengan Controller dan Eloquent Model standar yang bersih, hindari membuat lapisan berlebih (seperti Repository Pattern, DTO kustom, Service Layer artifisial, atau Event/Listener yang tidak memberi nilai tambah).
- [ ] **Tanpa Premature Optimization**: Menghindari sistem antrean rumit, cache multi-layer yang berbelit, atau arsitektur microservices yang tidak proporsional dengan skala pengguna kampus vokasi.
- [ ] **Pragmatisme Dependensi**: Tidak menambah package composer atau library npm baru untuk fungsi kecil yang dapat diselesaikan dengan 5–15 baris kode native PHP/Blade/Alpine.js.
- [ ] **Struktur Data Proporsional**: Struktur tabel, migrasi, dan relasi langsung mencerminkan kebutuhan dokumen tanpa normalisasi ekstrem yang membutuhkan belasan *join* tanpa alasan operasional.
- [ ] **Alur Kerja Pengguna yang Ringkas**: Tidak ada alur formulir berbelit-belit, tahapan verifikasi yang tidak diminta, atau konfigurasi rumit yang menimbulkan kebingungan bagi dosen maupun reviewer (*no configuration fatigue*).

---

## B. Tampilan & Konsistensi Desain

> Pemeriksaan visual di browser dilakukan langsung oleh pengguna. AI agent memeriksa kelas Tailwind, struktur Blade, dan menjalankan pemeriksaan otomatis dari terminal.

### B1. Konsistensi Garis Desain

**Warna** (sesuai [design.md](design.md) Bagian 2)

- [ ] Biru utama `#0B2A59` untuk header, tombol utama, judul penting.
- [ ] Kuning `yellow-500` / `yellow-400` hanya untuk aksen (garis bawah, badge, penanda aktif), tidak untuk blok besar.
- [ ] Teks: judul `slate-900`, isi `slate-700`, keterangan `slate-500`. Tidak ada abu-abu acak di luar skala `slate`.
- [ ] Border: `slate-200`. Latar selang-seling: `white` dan `slate-50`.
- [ ] Tidak ada warna hex acak baru di luar palet tanpa dicatat di design.md.

**Tipografi**

- [ ] Hierarki judul mengikuti design.md Bagian 3 (H1, H2, H3, isi, keterangan).
- [ ] Satu halaman hanya punya satu `<h1>`. Urutan heading tidak melompat (H2 lalu H4).
- [ ] Font yang dimuat di layout sama dengan yang tertulis di design.md.

**Sistem Grid 4px**

- [ ] Margin, padding, gap, lebar, dan tinggi memakai kelipatan 4px (`p-1`, `p-2`, `p-3`, `p-4`, `p-6`, dst).
- [ ] Tidak ada kelas setengah langkah yang menghasilkan nilai bukan kelipatan 4: `p-0.5` (2px), `gap-1.5` (6px), `px-2.5` (10px), `w-3.5` (14px).
- [ ] Tidak ada nilai arbitrer bukan kelipatan 4 (`p-[13px]`, `h-[37px]`, `min-h-[42px]`).
- [ ] Line height: `leading-4`, `leading-5`, `leading-6`, `leading-7`, `leading-8`, `leading-10`.
- [ ] Radius: `rounded` (4px), `rounded-lg` (8px), `rounded-xl` (12px), `rounded-2xl` (16px), `rounded-full`.

**Komponen**

- [ ] Tombol utama, tombol sekunder, input, kartu, badge, dan tabel memakai gaya yang sama di semua halaman (tinggi, radius, warna, hover).
- [ ] Navbar dan footer publik memakai komponen `x-public-navbar` dan `x-public-footer`, tidak disalin manual ke halaman lain.
- [ ] Ikon berupa SVG inline berukuran kelipatan 4 (`w-4 h-4`, `w-5 h-5`, `w-6 h-6`) dan punya fungsi jelas (cari, unduh, tutup, panah).
- [ ] Tidak ada emoji di mana pun: kode, UI publik, CMS admin, notifikasi, maupun dokumen.

### B2. Responsif Multi-Device

Periksa setiap halaman pada lebar berikut (Chrome DevTools > Toggle Device Toolbar):

| Lebar | Mewakili | Kelompok di AGENTS.md | Status |
| :--- | :--- | :--- | :--- |
| 360 px | Android kecil | Smartphone `< 640px` | [ ] |
| 390 px | iPhone 12–15 | Smartphone `< 640px` | [ ] |
| 430 px | Ponsel besar | Smartphone `< 640px` | [ ] |
| 768 px | iPad potret | Tablet `640–1023px` | [ ] |
| 1024 px | iPad lanskap / laptop kecil | Laptop `1024–1279px` | [ ] |
| 1280 px | Laptop standar | Desktop `≥ 1280px` | [ ] |
| 1440 px | Monitor desktop | Desktop `≥ 1280px` | [ ] |
| 1920 px | Monitor lebar | Desktop `≥ 1280px` | [ ] |

**Semua Ukuran**

- [ ] Tidak ada geser horizontal di level halaman. Hanya wadah tabel yang boleh `overflow-x-auto`.
- [ ] Teks panjang (judul usulan, nama dosen, URL) tidak menjebol wadah (`break-words`, `truncate`, atau `line-clamp`).
- [ ] Gambar dan video menyesuaikan lebar (`w-full`, `aspect-video`, `object-cover`).
- [ ] Konten dibatasi `max-w-7xl mx-auto` dengan padding samping `px-4 sm:px-6 lg:px-8`.

**Smartphone & Tablet**

- [ ] Menu desktop tersembunyi (`hidden lg:flex`) dan diganti tombol menu yang membuka drawer.
- [ ] Drawer menu bisa digulir sampai item terakhir (`max-h-[calc(100dvh-...)] overflow-y-auto`) dan halaman di belakangnya terkunci.
- [ ] Hanya ada satu tombol menu yang tampil di setiap ukuran layar.
- [ ] Elemen yang bisa disentuh (tombol, tautan menu, input, dropdown) minimal 44 × 44 px.
- [ ] Jarak antar elemen sentuh cukup sehingga tidak salah tekan.
- [ ] Grid berubah menjadi satu kolom di ponsel (`grid-cols-1 md:grid-cols-2 lg:grid-cols-3`).
- [ ] Tabel lebar dibungkus `overflow-x-auto` atau ditampilkan sebagai kartu di ponsel.
- [ ] Modal tidak melebihi tinggi layar dan isinya bisa digulir.
- [ ] Input form memakai ukuran teks minimal 16px agar iOS tidak memperbesar layar otomatis.
- [ ] Tampilan lanskap ponsel tetap bisa dipakai (header tidak menutupi separuh layar).

**Laptop & Desktop**

- [ ] Menu navigasi tidak terpotong atau bertumpuk di 1024 px.
- [ ] Dropdown menu tidak keluar dari tepi layar.
- [ ] Di 1920 px konten tidak melebar berlebihan dan tetap rata tengah.

### B3. Aksesibilitas

- [ ] Kontras teks normal minimal 4.5:1, teks besar minimal 3:1 (gunakan checker di `.agents/skills/antislop-human/`).
- [ ] Ukuran teks minimal 12px (`text-xs`). `text-[10px]` dan `text-[11px]` hanya untuk badge pendek, tidak untuk informasi yang harus dibaca.
- [ ] Semua elemen interaktif bisa dicapai dengan tombol Tab dan punya tanda fokus yang terlihat (`focus:ring-2`).
- [ ] Tombol berisi ikon saja memiliki `aria-label` atau teks `sr-only`.
- [ ] Setiap input punya `<label>` yang terhubung (`for`/`id`).
- [ ] Gambar informatif punya `alt` yang deskriptif. Gambar dekoratif memakai `alt=""`.
- [ ] Modal dan drawer bisa ditutup dengan tombol Esc.
- [ ] Atribut `lang="id"` ada di tag `<html>`.
- [ ] Animasi menghormati `motion-reduce:` untuk pengguna yang mematikan animasi.

### B4. Status Tampilan & Interaksi

- [ ] **Kosong**: daftar tanpa data menampilkan pesan yang jelas (misal "Belum ada usulan yang diajukan"), bukan area putih kosong.
- [ ] **Memuat**: tombol kirim dinonaktifkan saat proses berjalan agar tidak terkirim dua kali.
- [ ] **Gagal**: pesan validasi tampil di dekat kolom yang salah dan isian sebelumnya tetap terjaga (`old()`).
- [ ] **Berhasil**: muncul pemberitahuan setelah simpan, ubah, atau hapus.
- [ ] **Hapus**: ada konfirmasi sebelum data dihapus.
- [ ] **Nonaktif**: tombol yang tidak bisa dipakai terlihat jelas berbeda (`opacity-50 cursor-not-allowed`).
- [ ] Elemen Alpine yang awalnya tersembunyi memakai `x-cloak` agar tidak berkedip saat halaman dimuat.
- [ ] Data kosong dari database tidak memunculkan teks `null`, `undefined`, atau error.

### B5. Bahasa & Teks Antarmuka

- [ ] Bahasa Indonesia baku, singkat, dan sopan sesuai konteks institusi Kementerian Perhubungan.
- [ ] Tidak ada istilah teknis yang membingungkan pengguna (payload, endpoint, schema, parsing, rendering, entity, submit, upload). Gunakan: Pengajuan Usulan, Unggah Berkas, Unduh Berkas, Rincian Anggaran, Pemberitahuan.
- [ ] Tidak ada kata terlarang sesuai Mandat AGENTS.md (lihat perintah D3). Gunakan padanan seperti "Website P3M PKTJ", "Email Kedinasan", "Dokumen Panduan".
- [ ] Nama prodi hanya D4 RSTJ, D4 TRO, dan D3 TO.
- [ ] Tidak ada catatan teknis pengembang di UI (grid 4px, responsif, checklist kepatuhan, status pengerjaan).
- [ ] Label tombol berupa kata kerja yang jelas ("Simpan Perubahan", "Ajukan Usulan"), bukan "OK" atau "Klik di sini".
- [ ] Format tanggal dan angka konsisten (misal `3 November 2026`, `Rp 15.000.000`).

---

## C. Kepatuhan Mandat Proyek & Kesesuaian Spesifikasi Kebutuhan

### C1. Kepatuhan Mandat Proyek (AGENTS.md)

Ringkasan cepat. Setiap item terhubung ke pemeriksaan di bagian lain.

| No | Mandat | Rujukan Cek | Status |
| :--- | :--- | :--- | :--- |
| 1 | Responsif multi-device, tanpa geser horizontal, target sentuh ≥ 44px | B2, D3 | [ ] |
| 2 | Spasi, line height, dan radius kelipatan 4px | B1, D3 | [ ] |
| 3 | Tanpa emoji di seluruh sistem | B1, D3 | [ ] |
| 4 | Bahasa antarmuka tanpa istilah teknis rumit | B5, D3 | [ ] |
| 5 | Tanpa catatan teknis pengembang di UI | B5 | [ ] |
| 6 | Hanya 3 prodi PKTJ (D4 RSTJ, D4 TRO, D3 TO) | A7, B5 | [ ] |
| 7 | Tanpa kata terlarang sesuai kebijakan proyek | B5, D3 | [ ] |
| 8 | Semua konten publik dapat diubah dari CMS | Cek manual: teks di view tidak di-hardcode tanpa fallback dari `Setting` | [ ] |
| 9 | Test lulus 100%, build Vite sukses, `composer audit` bersih | D1 | [ ] |
| 10 | `graphify update .` dijalankan setelah perubahan kode | D1 | [ ] |

### C2. Kesesuaian Dokumen Kebutuhan (Kebutuhan Website P3M rev.pdf & PRD)

Pemeriksaan keselarasan fitur dengan dokumen spesifikasi kebutuhan (20 halaman acuan):

**Portal Publik (Halaman 1–2 PDF)**
- [ ] **Homepage**: Menyajikan Profil Singkat P3M PKTJ, Video Profil tersemat, dan Berita Terkini.
- [ ] **Profil (5 Sub-Menu)**: Rencana Strategis (Renstra Penelitian 2026-2031 & Renstra Pengabdian), Roadmap Penelitian, Visi Misi & Tujuan, Profil Peneliti (dosen aktif beserta data riset & publikasi), SDM (Struktur Organisasi).
- [ ] **Riset (3 Sub-Menu)**: Kegiatan Penelitian (daftar per tahun & sumber dana dilengkapi grafik statistik dan tabel filter prodi/tahun), Luaran Penelitian (publikasi, HKI, produk/jasa lisensi terbuka), Kerjasama Penelitian tersusun per tahun.
- [ ] **Pengabdian (3 Sub-Menu)**: Pengabdian Kepada Masyarakat (daftar per tahun & sumber dana dengan statistik grafik & tabel), Luaran Pengabdian (analisis luaran), Kerjasama Pengabdian tersusun per tahun.
- [ ] **Layanan (2 Sub-Menu)**: Panduan dan Pedoman (pedoman riset SDM, pedoman pengabdian, proses pengabdian, panduan sistem), Standar Operasional Prosedur (SOP Penelitian dan SOP Pengabdian).
- [ ] **Jurnal**: Terhubung langsung ke tautan portal jurnal berkala P3M.
- [ ] **Pintu Masuk SIM P3M**: Formulir pendaftaran usulan, pemantauan progress, pengajuan biaya, dan peninjauan reviewer.

**Sistem Informasi Admin (Halaman 3–4 PDF)**
- [ ] **Alur Usulan & Laporan**: Mengelola 3 jenis berkas (proposal, monev, laporan kegiatan) pada tab Penelitian dan Pengabdian.
- [ ] **Tahapan Pipeline**: Memfasilitasi antrean *Belum Ditugaskan* (penugasan reviewer), *Sedang Ditugaskan* (pemantauan proses review), dan *Arsip* berkas selesai.
- [ ] **Pengaturan Pengguna & Peran**: Pengaturan hak akses peran (Admin, Reviewer, Peneliti) berbasis tabel kotak centang (*checkbox table*) dengan kemampuan multi-role.

**Sistem Informasi Peneliti / Dosen (Halaman 5–14 PDF)**
- [ ] **Pendaftaran Proposal**: Formulir identitas usulan (jenis kegiatan, fokus, topik, lokasi, usulan biaya, rekening bank), anggota 3 kelompok (Dosen Internal, Dosen Eksternal, Taruna/Mahasiswa), atribut upload berkas proposal PDF, luaran target, rencana anggaran 4 jenis belanja (honor, bahan habis pakai, perjalanan, sewa), jadwal tahunan, kelengkapan mitra, dan konfirmasi.
- [ ] **Pemantauan Usulan**: Pelacakan progress 5 tahap (Terkirim, Proses Review, Revisi [upload file revisi], Diterima/Ditolak, Selesai).
- [ ] **Pelaporan Monev**: Identitas laporan monev, pengisian instrumen 7 pertanyaan pilihan ganda capaian & 7 pertanyaan esai evaluasi pelaksanaan, upload bukti luaran, dan konfirmasi.
- [ ] **Pelaporan Laporan Kegiatan (Laporan Akhir)**: Pemutakhiran anggota (bila ada), upload berkas laporan kegiatan, pencatatan luaran terealisasi, rekap anggaran, dan konfirmasi.

**Sistem Informasi Reviewer (Halaman 15–20 PDF)**
- [ ] **Konfirmasi Penugasan**: Menerima permintaan review dari admin dengan batas waktu, tombol persetujuan kesediaan review.
- [ ] **Penilaian Proposal**: Rubrik penilaian terbobot (Penelitian: 5 kriteria; Pengabdian: 6 kriteria) dengan skala skor terstandarisasi 1, 2, 3, 5, 6, 7 (1=buruk, 2=sangat kurang, 3=kurang, 5=cukup, 6=baik, 7=sangat baik), perhitungan nilai otomatis, upload tabel catatan revisi, rekomendasi hasil, dan konfirmasi.
- [ ] **Penilaian Monev**: Penilaian 7 kriteria capaian monev dengan skala skor 1–7 dan catatan penilai.
- [ ] **Penilaian Laporan Akhir**: Penilaian 4 kriteria capaian laporan dengan skala skor 1–7, rekomendasi, upload berkas koreksi, dan konfirmasi.

**Pencegahan Scope Creep & Over-Engineering**
- [ ] **Kesesuaian Batasan**: Fitur tidak menyimpang atau menambahkan modul berbelit di luar koridor 20 halaman dokumen spesifikasi kebutuhan.

---

## D. Perintah Pemeriksaan Otomatis

Semua perintah dijalankan dari root proyek (`c:\laragon\www\p3m`) di PowerShell.

### D1. Pemeriksaan Wajib

```powershell
php artisan test                 # Seluruh test harus lulus
npm run build                    # Build aset Vite harus sukses
composer audit                   # Celah keamanan dependensi PHP
npm audit --omit=dev             # Celah keamanan dependensi JS
vendor\bin\pint --test           # Format kode PHP
python -m graphify update .      # Sinkronkan knowledge graph setelah perubahan
```

Untuk satu fitur saja:

```powershell
php artisan test --filter=PublicPortalTest
php artisan route:list --name=admin.settings
```

### D2. Kualitas Kode

```powershell
# Sisa debug
Get-ChildItem app,resources,routes -Recurse -Include *.php,*.js | Select-String -Pattern '\b(dd|dump|var_dump|ray)\(|console\.log\('

# env() di luar folder config
Get-ChildItem app,resources,routes -Recurse -Include *.php | Select-String -Pattern '\benv\('

# File PHP yang terlalu panjang (> 300 baris)
Get-ChildItem app -Recurse -Filter *.php | Where-Object { (Get-Content $_.FullName).Count -gt 300 } | ForEach-Object { "{0} ({1} baris)" -f $_.FullName, (Get-Content $_.FullName).Count }

# View Blade yang terlalu panjang (> 500 baris)
Get-ChildItem resources/views -Recurse -Filter *.blade.php | Where-Object { (Get-Content $_.FullName).Count -gt 500 } | ForEach-Object { "{0} ({1} baris)" -f $_.FullName, (Get-Content $_.FullName).Count }

# Validasi inline di controller (kandidat dipindah ke Form Request)
Get-ChildItem app/Http/Controllers -Recurse -Filter *.php | Select-String -Pattern '\$request->validate\('

# Pengambilan data tanpa batas (kandidat paginate)
Get-ChildItem app/Http/Controllers -Recurse -Filter *.php | Select-String -Pattern '::all\(\)|->get\(\)'

# Model tanpa perlindungan mass assignment
Get-ChildItem app/Models -Filter *.php | Select-String -Pattern '\$guarded\s*=\s*\[\s*\]'
```

### D3. Tampilan & Mandat Proyek

```powershell
# Kelas setengah langkah (bukan kelipatan 4px)
Get-ChildItem resources/views -Recurse -Filter *.blade.php | Select-String -Pattern '(?<![\w-])-?(p|px|py|pt|pb|pl|pr|m|mx|my|mt|mb|ml|mr|gap|gap-x|gap-y|space-x|space-y|w|h|size|top|left|right|bottom|inset)-\d+\.5(?![\w.])'

# Nilai arbitrer px bukan kelipatan 4 pada spasi, ukuran, line height, radius (ukuran font dicek terpisah)
Get-ChildItem resources/views -Recurse -Filter *.blade.php | Select-String -Pattern '(?<![\w-])(?!text-)[\w-]+-\[(\d+)px\]' -AllMatches | Where-Object { $_.Matches | Where-Object { [int]$_.Groups[1].Value % 4 -ne 0 } } | ForEach-Object { "{0}:{1}: {2}" -f $_.Path, $_.LineNumber, $_.Line.Trim() }

# Ukuran font di bawah 12px (sulit dibaca, tinjau apakah memuat informasi penting)
Get-ChildItem resources/views -Recurse -Filter *.blade.php | Select-String -Pattern 'text-\[(9|10|11)px\]' | Group-Object Path | Sort-Object Count -Descending | Select-Object Count, Name

# Emoji dan simbol bergambar
Get-ChildItem app,resources,database -Recurse -Include *.php,*.js,*.css | Select-String -Encoding UTF8 -Pattern '[\uD83C-\uDBFF][\uDC00-\uDFFF]|[\u2600-\u27BF]'

# Kata terlarang (pola sengaja ditulis dengan kurung agar dokumen ini sendiri tetap patuh)
Get-ChildItem app,resources,database,routes -Recurse -Include *.php,*.js | Select-String -Pattern 'r[e]smi'
Get-ChildItem . -Filter *.md | Select-String -Pattern 'r[e]smi'

# Istilah teknis di teks antarmuka (tinjau manual, abaikan yang ada di atribut/kode)
Get-ChildItem resources/views -Recurse -Filter *.blade.php | Select-String -Pattern '\b(payload|endpoint|schema|parsing|refactor|rendering|entity|submit|upload)\b'

# Output HTML tanpa escape (wajib dipastikan aman)
Get-ChildItem resources/views -Recurse -Filter *.blade.php | Select-String -Pattern '\{!!'

# Gambar tanpa atribut alt (membaca tag <img> yang ditulis lebih dari satu baris)
Get-ChildItem resources/views -Recurse -Filter *.blade.php | ForEach-Object { $f = $_; [regex]::Matches((Get-Content $f.FullName -Raw), '<img\b(?:[^>]|(?<=[-=])>)*>') | Where-Object { $_.Value -notmatch '\balt=' } | ForEach-Object { "{0}: {1}" -f $f.FullName, ($_.Value -replace '\s+', ' ') } }

# Form tanpa @csrf (tinjau file yang muncul)
Get-ChildItem resources/views -Recurse -Filter *.blade.php | Where-Object { (Select-String -Path $_.FullName -Pattern 'method="POST"' -Quiet) -and -not (Select-String -Path $_.FullName -Pattern '@csrf' -Quiet) } | Select-Object FullName
```

### D4. Deteksi Query N+1 (Opsional, Lingkungan Lokal)

Tambahkan sementara di `AppServiceProvider::boot()` lalu jalankan `php artisan test` atau buka halaman. Setiap lazy loading akan memunculkan error yang menunjuk lokasinya.

```php
\Illuminate\Database\Eloquent\Model::preventLazyLoading(! app()->isProduction());
```

---

## E. Format Laporan Temuan

| ID | Area | Lokasi | Temuan | Level | Rekomendasi | Status |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| AUD-01 | A5 Performa | `app/Http/Controllers/HomeController.php:42` | Relasi `user` dipanggil di loop tanpa eager load (N+1) | Tinggi | Tambahkan `->with('user')` pada query | Terbuka |
| AUD-02 | B1 Grid 4px | `resources/views/welcome.blade.php:94` | `gap-1.5` menghasilkan 6px | Rendah | Ganti `gap-2` | Selesai |

Nilai **Status**: `Terbuka`, `Dikerjakan`, `Selesai`, `Diterima` (risiko diterima dengan alasan tertulis).

### Kriteria Lulus Audit

| Hasil | Syarat |
| :--- | :--- |
| **Lulus** | Tidak ada temuan Kritis atau Tinggi yang terbuka, `php artisan test` lulus 100%, `npm run build` sukses |
| **Lulus Bersyarat** | Tidak ada temuan Kritis terbuka, temuan Tinggi sudah punya rencana perbaikan dan batas waktu |
| **Tidak Lulus** | Ada temuan Kritis terbuka, atau test/build gagal |

---

## Lembar Audit (Salin Bagian Ini)

```markdown
# Audit: <Nama Halaman / Fitur / Kelas>

- Tanggal       : <YYYY-MM-DD>
- Auditor       : <nama>
- Commit/Branch : <hash atau nama branch>
- Cakupan       : <route, controller, model, view, test yang diperiksa>
- File terkait  : <hasil graphify query>

## Ringkasan Skor

| Bagian | Item Lulus | Item Gagal | N/A | Catatan |
| :--- | :--- | :--- | :--- | :--- |
| A1 Clean Code | | | | |
| A2 SOLID | | | | |
| A3 Self-Documenting | | | | |
| A4 Testable | | | | |
| A5 Performa & Skala | | | | |
| A6 Keamanan | | | | |
| A7 Database | | | | |
| A8 Error & Log | | | | |
| A9 Anti Over-Engineering | | | | |
| B1 Konsistensi Desain | | | | |
| B2 Responsif | | | | |
| B3 Aksesibilitas | | | | |
| B4 Status Tampilan | | | | |
| B5 Bahasa & Teks | | | | |
| C1 Mandat AGENTS.md | | | | |
| C2 Dokumen Kebutuhan PDF | | | | |

## Hasil Pemeriksaan Otomatis

- php artisan test     : <lulus X / gagal Y>
- npm run build        : <sukses / gagal>
- composer audit       : <bersih / jumlah celah>
- pint --test          : <bersih / jumlah file>
- Pemindaian D2 & D3   : <ringkasan jumlah temuan per perintah>

## Temuan

| ID | Area | Lokasi | Temuan | Level | Rekomendasi | Status |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| AUD-01 | | | | | | Terbuka |

## Keputusan

- Hasil  : <Lulus / Lulus Bersyarat / Tidak Lulus>
- Alasan : <ringkas>
- Tindak lanjut : <daftar ID temuan yang harus diselesaikan dan batas waktunya>
```

---

## Contoh Perintah ke AI Agent

```text
Audit halaman Beranda (route: beranda) memakai audit.md.
Jalankan seluruh perintah di Bagian D, isi Lembar Audit, dan simpan hasilnya
ke docs/audit/<tanggal>-beranda.md. Jangan ubah kode dulu, laporkan temuan saja.
```

```text
Audit fitur Pengajuan Usulan dosen (Dosen\ProposalController dan view dosen/proposals)
fokus Bagian A2 SOLID, A4 Testable, dan A6 Keamanan sesuai audit.md.
```
