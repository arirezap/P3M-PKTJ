# 🎨 Pedoman Desain UI/UX Website P3M PKTJ
*(Design System & Visual Guidelines)*

---

## 1. Filosofi & Prinsip Desain
- **Simple & Elegan**: Mengutamakan kebersihan visual, ruang bernapas (*white space*) yang luas, dan tata letak yang proporsional.
- **Anti "AI Slop"**: Menghindari elemen visual berlebihan yang sering dihasilkan template AI generik (tidak ada kartu melayang dengan bayangan neon tebal, tidak ada gradien ungu/cyan liar, dan tidak ada dekorasi visual tanpa fungsi).
- **Institusional & Kredibel**: Tampilan mencerminkan wibawa perguruan tinggi kedinasan di bawah Kementerian Perhubungan.
- **Minimalis Ikonografi**: Penggunaan ikon ditekan seminimal mungkin — **hanya digunakan jika memiliki nilai fungsi langsung** (seperti ikon panah dropdown, unduh berkas, atau pencarian). Tidak memasang ikon hiasan di setiap judul atau kartu.
- **Fokus pada Konten & Data**: Tipografi tajam, tabel akademik yang mudah dibaca, serta grafik data riset yang jelas dan profesional.

---

## 2. Palet Warna (Color System)
Mengacu pada identitas resmi khas **Kementerian Perhubungan**: dominan latar belakang putih bersih dengan aksen **Biru Kemenhub** dan **Kuning Emas/Amber**.

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
- **Hanya gunakan ikon untuk interaksi fungsional**:
  - 🔍 **Pencarian**: Ikon kaca pembesar di form filter/search bar.
  - 📥 **Unduh**: Ikon panah ke bawah pada tombol download dokumen Renstra/SOP.
  - ⌄ **Dropdown**: Ikon chevron kecil pada menu navigasi bertingkat.
  - ↗ **Tautan Eksternal**: Ikon panah keluar pada link menuju Jurnal OJS.
  - ☰ / ✕ **Navigasi Mobile**: Hamburger menu untuk layar smartphone.
- **Larangan**:
  - ❌ Dilarang menaruh icon di setiap card fitur (misal: ikon buku di kartu riset, ikon orang di kartu profil). Gunakan hierarki tipografi dan garis aksen tipis warna biru/kuning.
  - ❌ Dilarang menggunakan emoji sebagai pengganti ikon pada UI resmi institusi.

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
  - Logo PKTJ, identitas resmi kampus Politeknik Keselamatan Transportasi Jalan Tegal.
  - Alamat lengkap, kontak email resmi P3M, nomor telepon/layanan.
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
   - Pada layar `< 1024px` (`lg:`), menu navigasi utama berganti menjadi tombol hamburger minimalis (`☰`).
   - Saat dibuka, menu muncul berupa *drawer / modal slide-in* yang bersih, mudah ditutup (`✕` atau klik backdrop), dengan ukuran font navigasi yang nyaman dibaca dan ditekan.

---

## 8. Aset Resmi yang Sudah Tersedia
1. **Logo Resmi PKTJ**: Sudah tersedia file [logoPKTJ.png](logoPKTJ.png) (PNG transparan beresolusi tinggi, siap disematkan di navbar dan footer).
2. **Font Resmi**: **Poppins** via Google Web Fonts (otomatis terpasang tanpa butuh install di perangkat pengguna).
3. **Warna Footer**: **Biru Kemenhub Gelap (`#0B2A59`)**.
