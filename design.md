# Pedoman Desain UI/UX Website P3M PKTJ
*(Design System & Visual Guidelines)*

---

## 1. Filosofi & Prinsip Desain
- **Simple & Elegan**: Mengutamakan kebersihan visual, ruang bernapas (*white space*) yang luas, dan tata letak yang proporsional.
- **Anti "AI Slop"**: Menghindari elemen visual berlebihan yang sering dihasilkan template AI generik (tidak ada kartu melayang dengan bayangan neon tebal, tidak ada gradien ungu/cyan liar, dan tidak ada dekorasi visual tanpa fungsi).
- **Institusional & Kredibel**: Tampilan mencerminkan wibawa perguruan tinggi kedinasan di bawah Kementerian Perhubungan.
- **Mandat Bebas Emoji (Strict Zero-Emoji Mandate)**:
  - **Dilarang keras menggunakan emoji di mana pun**: baik pada kode program, template blade, halaman publik/admin, maupun dokumen markdown proyek.
  - Penggunaan emoji dinilai sebagai penurunan kualitas visual ("AI slop") yang merusak citra profesional dan wibawa institusi pemerintah.
- **Bahasa Singkat, Padat, Jelas & Bebas Jargon IT Rumit**:
  - Dilarang keras menggunakan istilah teknis IT/pemrograman yang rumit dan membingungkan (seperti *payload, endpoint, schema, parsing, refactor, backend logic, rendering, entity*).
  - Seluruh teks antarmuka (label tombol, menu navigasi, notifikasi, pesan panduan, dan formulir) wajib menggunakan bahasa Indonesia yang **singkat, padat, jelas, dan profesional**.
  - Mengedepankan istilah operasional akademik yang akrab bagi dosen dan peneliti (contoh: gunakan *Pengajuan Usulan*, *Unduh Berkas*, *Rincian Anggaran*, *Pemberitahuan*, bukan istilah komputasi/database).
- **Larangan Kebocoran Catatan Teknis / Developer ke UI Publik (Zero Dev-Notes Leakage)**:
  - Pedoman desain seperti *Sistem Grid 4px*, *Multi-Device Responsive*, *Anti-AI Slop*, checklist audit, atau status kepatuhan teknis adalah **pedoman kerja internal pengembang dalam menulis kode**.
  - **Dilarang keras mencantumkan teks atau label kepatuhan teknis tersebut pada tampilan antarmuka publik** (termasuk pada footer, header, badge, atau watermark). Publik dan dosen hanya berhak melihat konten terstandar institusi, bukan catatan internal developer.
- **Minimalis Ikonografi**: Penggunaan ikon ditekan seminimal mungkin — **hanya digunakan jika memiliki nilai fungsi langsung** (seperti ikon panah dropdown, unduh berkas, atau pencarian). Tidak memasang ikon hiasan di setiap judul atau kartu.
- **Fokus pada Konten & Data**: Tipografi tajam, tabel akademik yang mudah dibaca, serta grafik data riset yang jelas dan profesional.
- **Protokol Pengecekan Visual (Larangan Keras Membuka Browser Otomatis)**:
  - **AI Agent dilarang keras membuka browser sendiri** (baik melalui browser subagent, otomasi browser, maupun puppeteer).
  - Pengecekan tampilan antarmuka, tata letak visual, responsivitas, dan interaksi pada peramban/browser adalah **sepenuhnya tugas dan wewenang pengguna (user)** secara langsung.
  - Tugas AI Agent fokus pada penulisan kode, penyesuaian styling Tailwind, kompilasi aset (`npm run build`), dan pengujian backend/feature test via CLI (`php artisan test`).

---

## 2. Palet Warna (Color System)
Mengacu pada identitas khas **Kementerian Perhubungan**: dominan latar belakang putih bersih dengan aksen **Biru Kemenhub** dan **Kuning Emas/Amber**.

### A. Warna Utama (Primary & Secondary)
| Peran | Hex Code | Tailwind Token | Penggunaan |
| :--- | :--- | :--- | :--- |
| **Dominan Background** | `#FFFFFF` | `bg-white` | Latar belakang utama halaman, kartu, dan formulir |
| **Secondary Background** | `#F8FAFC` | `bg-slate-50` | Latar selang-seling section atau header tabel |
| **Aksen Biru Perhubungan (Deep)** | `#0B2A59` | `bg-[#0B2A59]` / `text-[#0B2A59]` | Header, navbar brand, tombol utama, judul penting |
| **Aksen Biru Perhubungan (Mid)** | `#1E40AF` | `bg-blue-800` / `text-blue-800` | Link interaktif, hover tombol, border fokus |
| **Aksen Kuning Perhubungan** | `#EAB308` | `bg-yellow-500` / `border-yellow-500` | Garis aksen tipis (*underline accent*), badge status, highlight |
| **Kuning Emas / Amber Tua** | `#CA8A04` | `text-yellow-600` | Teks highlight di atas background putih |

### B. Warna Netral & Tipografi
| Peran | Hex Code | Tailwind Token | Penggunaan |
| :--- | :--- | :--- | :--- |
| **Heading Text** | `#0F172A` | `text-slate-900` | Judul artikel, heading section, nama tabel |
| **Body Text** | `#334155` | `text-slate-700` | Paragraf bacaan, deskripsi, label form |
| **Muted Text** | `#64748B` | `text-slate-500` | Tanggal berita, keterangan tahun, breadcrumb |
| **Border / Divider** | `#E2E8F0` | `border-slate-200` | Garis batas kartu, pemisah baris tabel, border input |

---

## 3. Tipografi
- **Primary Font Family**: **Poppins** (Google Web Fonts).
  - **Mekanisme Distribusi Font**: Pengunjung / pengguna **TIDAK PERLU meng-install font apapun di devicenya**. Font Poppins akan dimuat otomatis oleh browser melalui sistem Web Font / stylesheet saat membuka website dalam hitungan milidetik. Tampilan font akan 100% konsisten di semua perangkat (laptop Windows/Mac, tablet, maupun smartphone Android/iPhone).
  - Karakteristik Poppins: Modern, geometris, bersih, dan memberikan kesan elegan sekaligus tegas untuk website akademik dan institusi pemerintah.
- **Hierarki Skala Tipografi**:
  - **H1 (Hero / Page Title)**: `text-3xl md:text-4xl font-bold tracking-tight text-slate-900`
  - **H2 (Section Header)**: `text-2xl font-semibold tracking-tight text-[#0B2A59]`
  - **H3 (Card / Sub-header)**: `text-lg font-semibold text-slate-900`
  - **Body / Paragraf**: `text-base leading-relaxed text-slate-700`
  - **Small / Meta Data**: `text-sm text-slate-500`
  - **Angka Statistik / Counter**: `text-3xl font-extrabold text-[#0B2A59]`

---

## 4. Sistem Grid Spasial 4px (The 4px Grid System)
Seluruh dimensi antarmuka (margin, padding, gap, tinggi elemen, lebar elemen, hingga line-height) **wajib tunduk pada kelipatan 4 pixel** ($n \times 4\text{px}$). Sistem ini menjamin keteraturan visual yang presisi, ritme vertikal/horizontal yang konsisten, dan rendering tajam tanpa *subpixel blur* di semua rasio layar.

### A. Skala Spasial & Pemetaan Tailwind CSS
| Skala (px) | Token Tailwind | Peruntukan Utama |
| :---: | :---: | :--- |
| **4px** | `1` (`p-1`, `gap-1`, `h-1`) | Micro-spacing, jarak icon ke teks ringkas, badge internal padding |
| **8px** | `2` (`p-2`, `gap-2`, `space-y-2`) | Jarak antar elemen kecil, padding tombol compact, gap form inline |
| **12px** | `3` (`p-3`, `gap-3`, `rounded-xl`) | Padding input form, jarak antar kartu kecil |
| **16px** | `4` (`p-4`, `gap-4`, `space-y-4`) | Padding kartu mobile, padding horizontal tombol standar, jarak paragraf |
| **20px** | `5` (`p-5`, `gap-5`, `h-5 w-5`) | Dimensi icon standar, padding kartu sedang |
| **24px** | `6` (`p-6`, `gap-6`, `space-y-6`) | Padding kartu desktop, jarak antar section kecil |
| **32px** | `8` (`p-8`, `gap-8`, `py-8`) | Spacing antar blok konten, padding modal dialog |
| **40px** | `10` (`h-10`, `gap-10`, `py-10`) | Tinggi standar tombol primer & input text form desktop |
| **48px** | `12` (`h-12`, `py-12`, `gap-12`) | Tinggi tombol sentuh mobile (memenuhi tap target $\ge 44\text{px}$), padding section |
| **64px** | `16` (`py-16`, `gap-16`) | Spacing section utama portal publik |
| **80px** | `20` (`py-20`) | Padding vertikal hero section |
| **96px** | `24` (`py-24`) | Pemisah section besar desktop |

### B. Aturan Ketat Penggunaan Nilai 4px:
1. **Dilarang Nilai Piksel Ganjil / Acak**: Dilarang menggunakan arbitrary class bernilai acak di luar kelipatan 4px (misal: `p-[13px]`, `m-[7px]`, `h-[37px]`).
2. **Ketinggian Baris Tipografi (Line-Height)**: Semua `line-height` wajib mengunci kelipatan 4px:
   - `leading-4` (16px), `leading-5` (20px), `leading-6` (24px), `leading-7` (28px), `leading-8` (32px), `leading-10` (40px).
3. **Komponen Form & Tombol**:
   - Tombol Small: `h-8` (32px), `px-3` (12px), `text-xs`
   - Tombol Normal (Desktop): `h-10` (40px), `px-4` (16px), `text-sm`
   - Tombol Mobile / Touch: `h-12` (48px), `px-6` (24px), `text-base` (ramah sentuh & kelipatan 4)
4. **Border Radius (Sudut Membulat)**:
   - Sudut kartu & tombol: `rounded` (4px), `rounded-lg` (8px), `rounded-xl` (12px), `rounded-2xl` (16px), atau `rounded-full`.

---

## 5. Aturan Penggunaan Ikon (Strict Minimalist)
- **Hanya gunakan ikon SVG fungsional untuk interaksi**:
  - **Pencarian**: Ikon SVG kaca pembesar di form filter/search bar.
  - **Unduh**: Ikon SVG panah ke bawah pada tombol download dokumen Renstra/SOP.
  - **Dropdown**: Ikon SVG chevron kecil pada menu navigasi bertingkat.
  - **Tautan Eksternal**: Ikon SVG panah keluar pada link menuju Jurnal OJS.
  - **Navigasi Mobile**: Ikon SVG hamburger / close untuk layar smartphone.
- **Larangan**:
  - Dilarang menaruh ikon dekoratif di setiap kartu fitur (misal: ikon buku di kartu riset, ikon orang di kartu profil). Gunakan hierarki tipografi dan garis aksen tipis warna biru/kuning.
  - Dilarang keras menggunakan emoji di manapun pada antarmuka aplikasi maupun dokumen proyek. Semua ikon wajib berformat SVG minimalis.

---

## 6. Tata Letak & Gaya Komponen (Layout & Components)

### A. Header & Navigasi (Navbar)
- Background putih solid (`bg-white`) dengan garis batas bawah tipis berwarna abu-abu terang (`border-b border-slate-200`).
- Logo PKTJ & tulisan "P3M PKTJ" di sisi kiri.
- Menu navigasi teks warna `text-slate-700`, saat aktif/hover bertransformasi menjadi `text-[#0B2A59]` dengan indikator garis bawah warna kuning khas perhubungan (`border-b-2 border-yellow-500`).
- Tombol **"Login / SIM P3M"** di sisi kanan dengan warna Biru Kemenhub solid (`bg-[#0B2A59] text-white hover:bg-blue-900 rounded-md px-4 py-2 text-sm font-medium`).

### B. Hero Section
- Latar belakang putih bersih atau slate-50 yang terang dan lapang.
- Menampilkan judul utama dengan tipografi tegas, kalimat penjelas singkat tentang P3M PKTJ.
- Aksen garis kuning emas tipis (2px - 3px) di bawah judul section untuk identitas khas perhubungan.
- Tombol aksi primer (Biru Kemenhub) dan tombol sekunder (Outline border-slate-300).

### C. Kartu (Cards) & Wadah Konten
- Kartu berbentuk flat: `bg-white border border-slate-200 rounded-lg p-6`.
- **Tidak ada shadow berlebihan**: gunakan `shadow-sm` halus atau tanpa shadow (cukup border clean).
- Hover effect: transisi halus pada border `hover:border-slate-300` tanpa efek naik/terbang berlebihan.

### D. Tabel Akademik & Filter
- Header tabel: `bg-slate-50 text-slate-700 text-xs uppercase tracking-wider font-semibold border-b border-slate-200`.
- Baris tabel: garis pemisah `border-b border-slate-100`, hover baris `hover:bg-slate-50/70`.
- Dropdown filter (Prodi & Tahun): Form select standar yang bersih dan rapi (`border-slate-300 rounded-md text-sm`).

### E. Grafik Statistik (Chart.js / ApexCharts)
- Warna grafik diselaraskan dengan palet perhubungan:
  - Batang 1 / Garis 1: Biru Kemenhub (`#0B2A59`)
  - Batang 2 / Garis 2: Kuning Emas (`#EAB308`)
  - Batang 3 / Garis 3: Soft Teal / Slate (`#64748B`)
- Background grafik bersih di atas kartu putih flat.

### F. Footer
- **Latar Belakang**: **Biru Kemenhub Gelap (`#0B2A59` atau `#081D3C`)** dengan teks `text-slate-200`.
- Memberikan penutup visual yang kokoh, berwibawa, dan formal khas institusi pemerintah.
- Menampilkan:
  - Logo PKTJ, identitas kampus Politeknik Keselamatan Transportasi Jalan Tegal.
  - Alamat lengkap, kontak email institusi P3M, nomor telepon/layanan.
  - Tautan regulasi & link eksternal (Jurnal OJS, Kemenhub, SINTA).
  - Garis aksen kuning emas (`border-yellow-500/40`) pada divider hak cipta.

---

## 7. Standar Responsivitas & Multi-Device (PC, Laptop, Tablet, Smartphone)
Sesuai prinsip `antislop-layoutmobile`, seluruh antarmuka wajib dirancang adaptif dan berfungsi sempurna di berbagai resolusi layar tanpa ada bagian yang terpotong atau patah:

### A. Strategi Breakpoint (Tailwind CSS)
- **Mobile (Smartphone)**: `< 640px` (layar 360px - 480px, orientasi vertikal)
- **Tablet / Phablet**: `640px – 1023px` (`sm:` dan `md:`, orientasi portrait & landscape)
- **Laptop / Desktop Standar**: `1024px – 1279px` (`lg:`)
- **Desktop Layar Lebar**: `≥ 1280px` (`xl:` dan `2xl:`)

### B. Aturan Tata Letak & Ergonomi Mobile (Smartphone & Tablet)
1. **Target Sentuh Ramah Jari (Tap Targets)**:
   - Semua tombol, link navigasi, dan kontrol form minimal memiliki area sentuh **44x44 pixel** agar mudah ditekan di layar sentuh tanpa salah klik (sejalan dengan kelipatan 4px: 44px atau 48px).
   - Jarak antar tombol aksi diberi ruang yang cukup (`gap-2` [8px] atau `gap-3` [12px]).
2. **Bebas Masalah Overflow Horizontal**:
   - **Dilarang keras** terjadi geser horizontal liar (*horizontal scrolling*) pada halaman utama mobile. Seluruh konten teks harus otomatis *wrap/reflow*.
   - Tidak diperkenankan menutup bug layout dengan trik `overflow-x: hidden` pada `<body>`.
3. **Penyajian Tabel Data Riset & Pengabdian di Layar Kecil**:
   - Tabel akademik riset/pengabdian yang memiliki banyak kolom dibungkus dengan wadah responsif (`overflow-x-auto`) bergaris batas halus dan indikator scroll horizontal visual.
   - Alternatif tampilan mobile: Baris tabel dapat bertransformasi menjadi kartu ringkasan (*card stack view*) di layar smartphone agar mudah dibaca satu per satu.
4. **Grafik Statistik yang Adaptif**:
   - Canvas grafik (Chart.js / ApexCharts) disetel `responsive: true` dan `maintainAspectRatio: false` dengan batas tinggi yang fleksibel (`h-64 sm:h-80 md:h-96`) sehingga tetap proporsional baik di layar ponsel sempit maupun monitor PC ultrawide.
5. **Navigasi Mobile (Navbar & Drawer)**:
   - Pada layar `< 1024px` (`lg:`), menu navigasi utama berganti menjadi tombol hamburger SVG minimalis.
   - Saat dibuka, menu muncul berupa *drawer / modal slide-in* yang bersih, mudah ditutup (ikon SVG close atau klik backdrop), dengan ukuran font navigasi yang nyaman dibaca dan ditekan.

---

## 8. Aset Pendukung yang Sudah Tersedia
1. **Logo PKTJ**: Sudah tersedia file [logoPKTJ.png](logoPKTJ.png) (PNG transparan beresolusi tinggi, siap disematkan di navbar dan footer).
2. **Font Standar**: **Poppins** via Google Web Fonts (otomatis terpasang tanpa butuh install di perangkat pengguna).
3. **Warna Footer**: **Biru Kemenhub Gelap (`#0B2A59`)**.

---

## 9. Referensi Benchmarking & ATM (Amati, Tiru, Modifikasi) — LPPM Universitas Brawijaya (UB)
Sebagai rujukan tata kelola portal penelitian dan pengabdian perguruan tinggi terkemuka, dilakukan analisis komparatif terhadap portal **LPPM / DRPM Universitas Brawijaya** (`https://lppm.ub.ac.id/id/`) dengan metode **ATM (Amati, Tiru, Modifikasi)** yang diselaraskan dengan identitas Politeknik Keselamatan Transportasi Jalan (PKTJ):

### A. AMATI (Analisis UI/UX & Pola Informasi LPPM UB)
1. **Navigasi & Header**: Memadukan top-bar identitas universitas/kementerian dengan navigasi utama berjenjang (Profil, Penelitian, Pengabdian, Layanan/Sentra, Publikasi/Jurnal, Berita/Agenda, Dokumen/Unduhan, Kontak) serta tombol pintas login sistem informasi (SIPP UB).
2. **Hero & Highlight Program**: Menggunakan banner bergulir (slider) yang mengomunikasikan pengumuman hibah strategis (*Call for Proposals*), sosialisasi skema riset, dan monev.
3. **Quick Links / Akses Layanan Dosen**: Menyediakan deretan kartu pintasan menuju layanan krusial yang sering diakses dosen (Sistem Usulan SIPP, Panduan/Pedoman, Sentra HKI, Rumah Jurnal).
4. **Pemisahan Berita vs Pengumuman**: Memisahkan secara tegas antara rubrik **Berita/Kegiatan** (dokumentasi seminar, liputan workshop, foto) dan **Pengumuman terstandar** (jadwal seleksi hibah, batas unggah proposal, pengumuman pemenang pendanaan, edaran monev).
5. **Penyajian Data Kinerja & Capaian**: Menampilkan statistik agregat jumlah penelitian internal/eksternal, pengabdian masyarakat, HKI/paten, dan kerjasama.
6. **Pusat Unduhan Terkategori**: Pengelompokan dokumen berdasarkan skema (Panduan Riset, Panduan PkM, SOP, Renstra/Roadmap, template lembar pengesahan).
7. **Footer Institusional Berwibawa**: Menyajikan alamat lengkap gedung, kanal helpdesk/kontak, peta kampus, dan tautan eksternal ke kementerian/portal nasional (SINTA, BIMA, Garuda).

### B. TIRU (Pola Efektif yang Diadopsi untuk P3M PKTJ)
1. **Layout 2-Kolom Beranda (Berita Kegiatan & Pengumuman Call for Proposals)**:
   - Kolom kiri: Menampilkan Berita & Liputan Diseminasi Riset terbaru dengan gambar cover tajam.
   - Kolom kanan: Menampilkan Pengumuman & Agenda Penting P3M yang dilengkapi tanggal publikasi, badge status (*Aktif / Ditutup*), dan tombol unduh edaran.
2. **Deretan Kartu Layanan Pintas (Quick Access Service Grid)**:
   - Ditempatkan tepat di bawah Hero Section untuk mempermudah dosen dan pengunjung menjangkau 5 layanan prioritas:
     - 1. **Login SIM P3M** (Pengajuan usulan riset & PkM)
     - 2. **Pedoman & SOP** (Pusat unduhan dokumen panduan)
     - 3. **Data & Grafik Riset** (Eksplorasi capaian per prodi & tahun)
     - 4. **Direktori Peneliti** (Profil dosen, kepakaran, SINTA/Scopus)
     - 5. **Portal Jurnal PKTJ** (Tautan langsung ke OJS)
3. **Etalase Rumah Jurnal Ilmiah (OJS Showcase Widget)**:
   - Mengadopsi blok khusus promosi jurnal ilmiah berkala PKTJ yang mencantumkan nama jurnal, fokus cakupan keselamatan transportasi, status akreditasi (SINTA), dan tombol langsung untuk submisi naskah.
4. **Pusat Layanan Unduhan Bertag Kategori**:
   - Pengelompokan dokumen dengan penanda badge warna (Renstra, Roadmap, SOP Penelitian, SOP Pengabdian, Panduan SIM) agar pengunjung tidak bingung membedakan dokumen regulasi dan panduan teknis.

### C. MODIFIKASI (Sentuhan Khas, Peningkatan Kualitas, & Standar PKTJ)
1. **Identitas Karakter Kementerian Perhubungan**:
   - Mengganti palet warna UB dengan palet khas Kemenhub: dominan putih lapang, aksen Biru Kemenhub Deep (`#0B2A59`), Mid (`#1E40AF`), dan aksen Kuning Emas Perhubungan (`#EAB308`).
   - Fokus konten riset dikhususkan pada disiplin **Keselamatan Transportasi Jalan, Otomasi & Manajemen Lalu Lintas, serta Teknologi Kendaraan Vokasi**.
2. **Penerapan Standar Anti-AI Slop & Minimalis Modern**:
   - Menghindari tampilan template lama yang padat/berjejal. Tata letak dirancang modern dengan *white space* luas, kartu flat ber-border halus (`border-slate-200`), tanpa bayangan tebal, dan tipografi tegas font **Poppins**.
   - Menghilangkan ikon-ikon dekoratif tanpa fungsi (hanya menyisakan ikon fungsional seperti kaca pembesar filter, panah unduh, dan chevron dropdown).
3. **Kedisiplinan Grid Spasial 4px**:
   - Seluruh elemen antarmuka, margin, padding, tinggi tombol (`h-10`, `h-12`), hingga line-height wajib mengunci kelipatan 4 pixel untuk ketajaman visual absolut di layar resolusi tinggi.
4. **Interaktivitas Data Riset & PkM (Filter 3 Program Studi & Tahun + Grafik Dinamis)**:
   - Berbeda dari web konvensional yang menyajikan data dalam bentuk PDF statis yang kaku, P3M PKTJ menyediakan **tabel rekapitulasi interaktif yang dapat difilter seketika berdasarkan 3 Program Studi PKTJ (D4 RSTJ, D4 TRO, D3 TO) dan Tahun Anggaran**, disertai grafik visualisasi otomatis (menggunakan Chart.js + Alpine.js).
5. **Ergonomi Sentuh & Responsivitas Multi-Device Unggul**:
   - Seluruh kontrol interaktif memiliki area sentuh minimum **44x44px** untuk kenyamanan akses di smartphone/tablet.
   - Navigasi mobile menggunakan drawer slide-in yang rapi, dan tabel data dilengkapi pembungkus responsif dengan indikator visual agar ramah dibaca di perangkat bergerak tanpa *horizontal scroll* pada halaman utama.

---

## 10. Sistem Animasi & Interaktivitas Profesional (Motion Design System)
Agar antarmuka portal publik P3M PKTJ tampil hidup, memukau, dan dinamis saat diakses tanpa terjebak dalam gaya animasi berlebihan (slop), disusun standar gerakan (*motion guidelines*) yang mencerminkan wibawa institusi pendidikan tinggi Kementerian Perhubungan:

### A. Filosofi Gerakan (Motion Principles)
1. **Bermakna & Bertujuan (Purposeful)**:
   - Setiap animasi wajib memiliki alasan UX yang jelas: memandu arah pandang pengguna (*visual guidance*), memberikan konfirmasi sentuhan/klik (*haptic feedback*), atau menandai pergantian status (*state transition*).
   - **Anti-Slop (R-19)**: Dilarang keras menggunakan animasi loop/denyut terus-menerus tanpa henti (*no endless pulse, bounce, or float loops*). Gerakan hanya aktif saat pemicu terjadi (interaksi kursor atau kemunculan pertama pada viewport).
2. **Performa Tinggi (Hardware-Accelerated)**:
   - Hanya menggunakan properti CSS yang diakselerasi GPU: `opacity` dan `transform` (`translate`, `scale`).
   - Dilarang menganimasikan `width`, `height`, `margin`, atau `padding` secara dinamis yang dapat memicu *browser layout thrashing*.
3. **Cepat & Terkendali (Controlled Timing Scale)**:
   - **Micro-interactions (Hover / Focus / Active)**: `150ms` – `200ms` (`ease-out`). Memberikan responsivitas instan tanpa jeda lambat.
   - **Dropdown & Modal Slide**: `150ms` – `250ms` (`cubic-bezier(0.16, 1, 0.3, 1)`).
   - **Section / Card Reveal**: `300ms` – `400ms` dengan pergeseran vertikal halus maksimal 8px – 12px (`translate-y-2` ke `translate-y-0`).
4. **Ramah Aksesibilitas (`prefers-reduced-motion`)**:
   - Sistem wajib menyertakan kelas fallback untuk menghormati pengguna yang mengaktifkan mode hemat gerak pada sistem operasi mereka (`motion-reduce:transform-none motion-reduce:transition-none`).

### B. Spesifikasi Rincian Animasi Komponen Front Page

| Komponen | Pemicu (Trigger) | Properti Gerakan | Timing & Easing | Tujuan UX |
| :--- | :--- | :--- | :--- | :--- |
| **Hero Title & Staggered Copy** | Page Load / Viewport Entry | `opacity: 0 -> 1`, `translate-y-3 -> translate-y-0` (stagger 100ms per blok) | `duration-300 ease-out` | Memberikan kesan portal yang tertata rapi dan menyambut pengunjung dengan tenang. |
| **Quick Access Service Cards** | Hover kursor (Desktop) | `-translate-y-1` (naik 4px), border berubah dari `border-slate-200` ke `border-[#0B2A59]`, bayangan halus `shadow-md` | `duration-200 ease-out` | Mengindikasikan bahwa kartu tersebut adalah tombol pintasan yang dapat diklik. |
| **Tombol CTA Utama** | Hover & Click (Active) | Hover: transisi warna background & bayangan.<br>Active/Click: `scale-98` (efek tekan halus) | `duration-150 ease-out` | Memberi umpan balik taktil nyata saat tombol ditekan. |
| **Dropdown Menu Navbar** | Click / Hover Navbar | `opacity: 0 -> 100`, `translate-y-1 -> translate-y-0` | `duration-150 ease-out` | Menampilkan menu bertingkat secara elegan tanpa menutupi konten secara mendadak. |
| **Drawer Navigasi Mobile** | Tap Tombol Hamburger | `opacity: 0 -> 100`, `-translate-y-2 -> translate-y-0` | `duration-200 ease-out` | Membuka navigasi mobile secara mulus dari atas ke bawah. |
| **Baris Tabel Riset** | Filter Berubah / Search | `opacity: 0 -> 100` pada hasil filter baru | `duration-150 ease-out` | Memberi indikasi bahwa data telah ter-filter dengan lancar. |
| **Kartu Dokumen SOP** | Hover Tombol Unduh | Ikon panah unduh bergeser 2px ke bawah (`group-hover:translate-y-0.5`) | `duration-200 ease-out` | Isyarat visual intuitif untuk aksi unduh file dokumen. |

### C. Konfigurasi Transisi Tailwind CSS
Diintegrasikan ke dalam konfigurasi stylesheet proyek ([resources/css/app.css](resources/css/app.css)) untuk konsistensi di seluruh tampilan:
```css
/* Smooth interaction utilities */
.motion-safe-transition {
    transition-property: color, background-color, border-color, box-shadow, transform, opacity;
    transition-timing-function: cubic-bezier(0.16, 1, 0.3, 1);
    transition-duration: 200ms;
}
```

---

## 11. Protokol Verifikasi Tampilan & Pembagian Kerja (User vs AI Agent)
Untuk menjaga alur kerja yang efisien, tidak menginterupsi lingkungan kerja pengguna, dan menghargai peran inspeksi visual langsung oleh pengguna:
1. **Larangan Otomasi Browser oleh AI**:
   - AI Agent **dilarang keras membuka peramban/browser secara mandiri** (baik melalui *browser subagent*, otomasi Chromium, maupun puppeteer).
2. **Pengecekan Tampilan Mandiri oleh Pengguna**:
   - Seluruh inspeksi tampilan visual di browser (baik via desktop, tablet, maupun simulasi responsive mobile inspect) adalah **sepenuhnya tugas dan wewenang pengguna (user)**.
3. **Tanggung Jawab AI Agent**:
   - Menghasilkan kode Blade, Alpine.js, Tailwind CSS, dan PHP/Laravel yang bersih, rapi, dan mematuhi seluruh spesifikasi desain di atas.
   - Menjalankan build aset frontend (`npm run build`) setelah modifikasi styling/template.
   - Menjalankan pengujian fitur otomatis melalui terminal (`php artisan test`) untuk memastikan integritas data dan logika rute.
   - Memperbarui dokumentasi proyek dan menunggu instruksi/umpan balik hasil pengecekan visual dari pengguna.

---

## 12. Mandat Konsistensi Desain Global & Clean Code (Global Design Consistency & Reusable Layouts)
Untuk menjaga integritas visual, keteraturan kode, dan mencegah inkonsistensi antarmuka antarahalaman:

### A. Prinsip Single Source of Truth & Clean Code (DRY)
1. **Dilarang Keras Duplikasi Header & Footer**:
   - Seluruh antarmuka publik wajib menggunakan satu Master Layout terpusat (`resources/views/layouts/public.blade.php`) atau memanggil komponen terstandar (`<x-public-navbar>` dan `<x-public-footer>`).
   - Dilarang keras melakukan copy-paste blok kode tag `<header>` atau `<footer>` ke dalam masing-masing file view Blade secara terpisah.
2. **Kemudahan Pemeliharaan (Maintainability)**:
   - Setiap perubahan rute, penambahan menu, perbaikan interaksi dropdown, atau pembaruan tautan terstandar harus dilakukan hanya pada satu berkas komponen, dan secara otomatis berdampak ke seluruh halaman portal (Beranda maupun seluruh sub-halaman).

### B. Struktur Baku Top Navigation Menu (7 Menu Utama)
Seluruh halaman publik wajib menampilkan susunan menu navigasi yang seragam tanpa variasi urutan:
1. **Beranda**: Tautan langsung ke halaman beranda (`route('beranda')`).
2. **Profil (Dropdown 5 Sub-Item)**:
   - Sumber Daya Manusia (SDM) -> `route('profil.sdm')`
   - Profil Peneliti & Dosen -> `route('profil.peneliti')`
   - Visi, Misi & Tujuan -> `route('profil.visi-misi')`
   - Rencana Strategis (Renstra 2026-2031) -> `route('profil.rencana-strategis')`
   - Roadmap Penelitian Keselamatan -> `route('profil.roadmap-penelitian')`
3. **Berita**: Tautan langsung ke rubrik berita di beranda (`route('beranda') . '#berita-terkini'`).
4. **Riset (Dropdown 4 Sub-Item)**:
   - Kegiatan Penelitian Terapan -> `route('riset.penelitian')`
   - Luaran Penelitian (Publikasi, HKI, Produk) -> `route('riset.luaran')`
   - Roadmap Riset Keselamatan -> `route('profil.roadmap-penelitian')`
   - Ringkasan Riset di Beranda -> `route('beranda') . '#kegiatan-riset'`
5. **Pengabdian (Dropdown 3 Sub-Item)**:
   - Kegiatan Pengabdian Masyarakat -> `route('beranda') . '#kegiatan-riset'`
   - Desa Binaan & Mitra PkM -> `route('beranda') . '#kegiatan-riset'`
   - SOP Pengabdian kepada Masyarakat -> `route('beranda') . '#layanan-dokumen'`
6. **Layanan (Dropdown 4 Sub-Item)**:
   - Panduan & Pedoman Riset -> `route('beranda') . '#layanan-dokumen'`
   - SOP Penelitian Dosen -> `route('beranda') . '#layanan-dokumen'`
   - SOP Pengabdian kepada Masyarakat -> `route('beranda') . '#layanan-dokumen'`
   - Panduan Sistem Informasi SIM P3M -> `route('beranda') . '#layanan-dokumen'`
7. **Jurnal**: Tautan keluar / scroll ke etalase portal jurnal OJS PKTJ (`route('beranda') . '#jurnal'`).
8. **Tombol CTA Aksi**: "Login SIM P3M" (`route('login')`), tombol solid Biru Kemenhub (`bg-[#0B2A59] text-white hover:bg-blue-900 rounded-lg h-10 px-4 text-xs xl:text-sm font-semibold`).

### C. Aturan Visual Indikator Halaman Aktif (Active State)
1. **Menu Induk (Top Level)**:
   - Jika pengguna sedang berada di halaman Beranda (`routeIs('beranda')`), menu Beranda diberi garis bawah kuning emas: `font-semibold text-[#0B2A59] border-b-2 border-yellow-500 pb-1`.
   - Jika pengguna sedang berada di salah satu sub-halaman Profil (`routeIs('profil.*')`), tombol dropdown Profil otomatis aktif dengan garis bawah kuning emas: `font-semibold text-[#0B2A59] border-b-2 border-yellow-500 pb-1`.
   - Jika pengguna sedang berada di salah satu sub-halaman Riset (`routeIs('riset.*')`), tombol dropdown Riset otomatis aktif dengan garis bawah kuning emas: `font-semibold text-[#0B2A59] border-b-2 border-yellow-500 pb-1`.
2. **Item Sub-Menu Dropdown**:
   - Item sub-menu yang rutenya sedang dibuka wajib mendapatkan sorotan visual: `font-bold text-[#0B2A59] bg-blue-50` dengan padding `px-4 py-2 text-xs leading-4`.
   - Item yang tidak aktif tetap menggunakan: `font-medium text-slate-700 hover:bg-slate-50 hover:text-[#0B2A59]`.

### D. Ergonomi & Stabilitas Interaksi Dropdown (Anti-Flicker)
1. **Jembatan Kursor (Cursor Bridge)**: Wadah dropdown wajib memiliki top-padding transparan (`pt-2`) yang melekat ke tombol trigger (`absolute left-0 top-full pt-2 w-64 z-50`) sehingga menu tidak hilang saat kursor bergerak dari teks trigger ke kotak menu.
2. **Isolasi Klik Event**: Gunakan `@click="open = !open"` pada tombol trigger dan `@click.outside="open = false"` pada pembungkus luar agar dropdown tertutup dengan wajar hanya ketika pengguna mengklik di luar area menu.

### E. Konsistensi Mobile Navigation Drawer
- Drawer mobile pada layar `< 1024px` wajib terstruktur dengan pengelompokan sub-header yang jelas (*Profil Kelembagaan*, *Publikasi & Riset*, *Layanan Dokumen*), tinggi tap target minimal 44px–48px, dan tombol aksi Login SIM P3M di bagian bawah.

