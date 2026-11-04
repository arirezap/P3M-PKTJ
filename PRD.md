# DOKUMEN SPESIFIKASI KEBUTUHAN SISTEM (PRD)
## WEBSITE & SISTEM INFORMASI MANAJEMEN PENELITIAN DAN PENGABDIAN KEPADA MASYARAKAT (SIM P3M)
### POLITEKNIK KESELAMATAN TRANSPORTASI JALAN (PKTJ) TEGAL
**Acuan Utama Kebutuhan**: `Kebutuhan Website P3M rev.pdf` (Dokumen 20 Halaman)

---

## 1. PENDAHULUAN & PRINSIP PENGEMBANGAN

Dokumen Product Requirement Document (PRD) ini merangkum seluruh spesifikasi kebutuhan fungsional antarmuka, alur kerja, dan pemenuhan sistem yang tertuang dalam dokumen `Kebutuhan Website P3M rev.pdf`.

### Prinsip Utama Sistem:
1. **Fokus & Tidak Over-Engineering**: Sistem hanya mengimplementasikan menu, sub-menu, alur kerja, dan atribut data yang tercantum dalam dokumen acuan kebutuhan tanpa penambahan fitur spekulatif yang tidak diperlukan.
2. **Kepatuhan 3 Program Studi PKTJ**: Data program studi terkunci pada 3 prodi di lingkungan PKTJ:
   - **D4 RSTJ**: Rekayasa Sistem Transportasi Jalan
   - **D4 TRO**: Teknologi Rekayasa Otomotif
   - **D3 TO**: Teknologi Otomotif
3. **Standar Kualitas Teknis**:
   - Tata letak responsif multi-device (ponsel cerdas, tablet, laptop, dan komputer kerja).
   - Sistem spasial antarmuka berbasis kelipatan 4px Tailwind CSS.
   - Kebijakan bebas emoji (*Zero-Emoji Policy*), menggunakan ikon SVG fungsional kelipatan 4px.
   - Bebas jargon IT rumit, menggunakan peristilahan akademik operasional.
   - Kebijakan bebas kata "resmi" pada seluruh teks antarmuka dan dokumen.

---

## 2. KEBUTUHAN WEBSITE P3M (PORTAL PUBLIK)
*Sumber: Dokumen PDF Halaman 1–2*

| No | Menu | Sub Menu | Isi Tampilan | Pemenuhan |
|:---:|---|---|---|---|
| **1** | **Homepage** | - | Tentang P3M PKTJ, Video profil, berita terkini | Menampilkan profil kelembagaan P3M, pemutar video profil (*embed* / MP4), dan pos berita kegiatan akademik terkini. |
| **2** | **Profil** | **Rencana Strategis** | Dokumen Rencana Strategis Penelitian 2026-2031 dan Dokumen Rencana Strategis Pengabdian Kepada Masyarakat | Menyediakan unduhan berkas PDF Renstra Penelitian dan PkM dengan pelacak jumlah unduhan (*download counter*). |
| | | **Roadmap Penelitian** | Dokumen Roadmap Penelitian | Menyajikan dokumen peta jalan penelitian unggulan keselamatan transportasi jalan dan diagram alur tahapan riset. |
| | | **Visi, Misi & Tujuan** | Visi, Misi, dan Tujuan P3M | Menyajikan rumusan visi, misi, dan tujuan kelembagaan P3M PKTJ. |
| | | **Profil Peneliti** | Daftar dosen dan peneliti yang aktif | Data penelitian dan publikasi yang dimiliki oleh dosen aktif di lingkungan PKTJ. Dilengkapi pencarian dan filter program studi. |
| | | **Sumber Daya Manusia** | Struktur organisasi | Menampilkan bagan visual struktur organisasi P3M PKTJ dan penanggung jawab unit kerja. |
| **3** | **Riset** | **Kegiatan Penelitian** | Daftar kegiatan bidang penelitian beserta data pendukungnya berdasarkan sumber dana, tersusun per tahun. | Penelitian dibagi berdasarkan sumber dana, terdapat tampilan statistik grafik dan tabel yang bisa difilter per prodi dan per tahun. |
| | | **Luaran Penelitian** | • Publikasi<br>• HKI<br>• Produk/Jasa | Luaran penelitian yang mengadopsi lisensi terbuka, menunjukkan keberlanjutan dan kemanfaatan hasil penelitian sesuai peta jalan, kerjasama yang dilaksanakan, serta realisasi sumber dana penelitian dan pengembangan. |
| | | **Kerjasama** | Kegiatan kerjasama bidang penelitian beserta data pendukungnya, tersusun per tahun. | Menampilkan daftar mitra kerjasama penelitian per tahun anggaran dan berkas dokumen pendukung (MoU/PKS). |
| **4** | **Pengabdian** | **Pengabdian Kepada Masyarakat** | Daftar kegiatan bidang pengabdian kepada masyarakat beserta data pendukungnya berdasarkan sumber dana, tersusun per tahun. | Kegiatan pengabdian dibagi berdasarkan sumber dana, terdapat tampilan statistik grafik dan tabel yang bisa difilter per prodi dan per tahun. |
| | | **Luaran** | Hasil analisis terhadap luaran Pengabdian kepada Masyarakat | Menampilkan evaluasi kebermanfaatan dan dampak sosial kegiatan PkM terhadap peningkatan keselamatan transportasi masyarakat. |
| | | **Kerjasama** | Kegiatan kerjasama pengabdian kepada masyarakat beserta data pendukungnya, tersusun per tahun. | Menampilkan daftar mitra kerjasama PkM per tahun anggaran dan data pendukung. |
| **5** | **Layanan** | **Panduan dan Pedoman** | Dokumen:<br>1. Pedoman penelitian dan pengembangan sumberdaya manusia<br>2. Pedoman Pengabdian kepada Masyarakat dan pengembangan kualitas kepakaran<br>3. Proses Pengabdian kepada Masyarakat<br>4. Panduan Penggunaan Sistem Informasi | Menghimpun 4 kategori berkas panduan kelembagaan yang dapat diunduh langsung dalam format PDF dengan filter tab dan pencarian kata kunci. |
| | | **Standar Operasional Prosedur (SOP)** | Dibedakan antara SOP Penelitian dan SOP Pengabdian | Menyajikan kumpulan berkas SOP dengan pemisahan tegas antara SOP Bidang Penelitian dan SOP Bidang Pengabdian Masyarakat. |
| **6** | **Jurnal** | - | Terhubung ke link jurnal P3M | Tautan eksternal yang mengarah langsung ke portal jurnal ilmiah PKTJ (`https://ktj.pktj.ac.id/`). |
| **7** | **Login** | **Sistem Informasi Pendaftaran Penelitian dan Pengabdian Kepada Masyarakat** | Form Pendaftaran Penelitian | Pintu masuk otentikasi SIM P3M. Masing-masing dosen bisa mengirimkan proposal pengabdian/penelitian, memantau progressnya, proses reviewer terpantau sampai keputusan ditetapkan, dan pengajuan biaya dapat dilakukan. |

---

## 3. KEBUTUHAN SISTEM INFORMASI MANAJEMEN - ADMIN VIEW
*Sumber: Dokumen PDF Halaman 3–4*

Administrator bertugas memberikan penugasan kepada reviewer terkait pengajuan yang masuk dan memantau seluruh progres kegiatan mulai dari *submission* hingga *archive*.

### 3.1 Otentikasi & Halaman Utama Admin
| No | Role | Menu | Sub Menu | Isi Tampilan | Pemenuhan |
|:---:|:---:|---|---|---|---|
| **1** | Admin | **Login** | - | • Nama pengguna<br>• Kata Sandi | Halaman admin hanya bisa diakses oleh pengguna yang memiliki hak akses administrator. |
| **2** | Admin | **Home** | • Penelitian<br>• Pengabdian kepada Masyarakat<br>• Pengaturan | Pengguna dapat memilih untuk mengakses Modul Penelitian, Modul Pengabdian kepada Masyarakat, atau Pengaturan sesuai kebutuhan. |

### 3.2 Alur Meja Kerja Modul Penelitian & Pengabdian kepada Masyarakat (Admin View)
Tampilan saat administrator memilih **"Penelitian"** atau **"Pengabdian kepada Masyarakat (PKM)"** memiliki 4 struktur menu/tab:

| No | Menu | Sub Menu | Isi Tampilan | Pemenuhan |
|:---:|---|---|---|---|
| **1** | **Daftar Proposal dan Laporan Masuk** | - | Seluruh file terkait Penelitian / PKM yang masuk. | Menampilkan 3 jenis berkas yang masuk dari dosen: **Proposal**, **Monev**, dan **Laporan Kegiatan**. |
| **2** | **Belum Ditugaskan** | **Penugasan** | Daftar file Penelitian / PKM yang sudah masuk tapi belum menerima reviewer. | Klik judul yang akan ditugaskan, klik tombol penugasan, pilih reviewer internal yang kompeten, dan sistem langsung meneruskan berkas (proposal, monev, laporan) ke reviewer tersebut. |
| **3** | **Sedang Ditugaskan** | - | Daftar file Penelitian / PKM yang sedang dalam proses peninjauan oleh reviewer. | Administrator dapat memantau tahapan setiap berkas yang diunggah. |
| **4** | **Arsip** | - | Seluruh file terkait Penelitian / PKM yang telah selesai. | Menampung seluruh kegiatan yang telah tuntas melewati masa pelaksanaan, luaran, dan pertanggungjawaban. Dilengkapi fitur cetak lembar rekapitulasi capaian. |

### 3.3 Menu Pengaturan (Admin View)
Tampilan saat administrator memilih **"Pengaturan"**:

| No | Menu | Sub Menu | Isi Tampilan | Pemenuhan |
|:---:|---|---|---|---|
| **1** | **User & Roles** | • Admin<br>• Reviewer<br>• Peneliti | Seluruh email atau username yang telah terdaftar dalam sistem. | Administrator dapat menentukan peran (tugas) setiap pengguna terdaftar dengan mencentang kotak pilihan (*checkbox*) lalu klik simpan. **Satu pengguna dapat memiliki lebih dari satu peran (multi-role)**. |

---

## 4. KEBUTUHAN SISTEM INFORMASI MANAJEMEN - PENELITI VIEW
*Sumber: Dokumen PDF Halaman 5–14*

Dosen peneliti memiliki kewenangan untuk mengajukan proposal, mengisi instrumen monev, dan menyampaikan laporan kegiatan untuk skema **Penelitian** maupun **Pengabdian kepada Masyarakat**.

### 4.1 Otentikasi & Halaman Utama Peneliti
| No | Role | Menu | Sub Menu | Isi Tampilan | Pemenuhan |
|:---:|:---:|---|---|---|---|
| **1** | Peneliti | **Login** | Masuk | • Nama pengguna<br>• Kata Sandi | Sistem hanya bisa diakses oleh dosen internal PKTJ. |
| **2** | Peneliti | **Home** | • Penelitian<br>• Pengabdian kepada Masyarakat | Pengguna memilih untuk mengakses alur kegiatan Penelitian atau Pengabdian kepada Masyarakat. |

### 4.2 Alur Kerja Peneliti: Skema Penelitian & Pengabdian kepada Masyarakat
Alur kerja pada menu **Penelitian** dan **Pengabdian kepada Masyarakat** memiliki 6 menu tahapan yang terstruktur:

#### 1. Pendaftaran Proposal
Terdiri dari 8 sub-menu pengisian formulir:
1. **Identitas Usulan**:
   - *Jenis Kegiatan*: Pilihan: 1) Penelitian; 2) Pengabdian kepada Masyarakat
   - *Judul* (isian teks)
   - *Ringkasan* (isian teks maksimal 500 kata)
   - *Kata kunci* (isian teks)
   - *Bidang fokus* (isian teks prioritas keselamatan transportasi)
   - *Lama kegiatan* (pilihan dalam tahun: 1 tahun, 2 tahun, dst.)
   - *Topik kegiatan* (isian spesifik)
   - *Lokasi Penelitian* (tempat pengujian / lokus kegiatan)
   - *Usulan Biaya* (nominal total anggaran)
   - *Dana Rekening*: Nama bank, nomor rekening, dan nama pemilik rekening penampung hibah.
2. **Anggota**:
   - *1) Anggota Dosen Internal*: No, NIDN, NIP/NIK, Nama, Jabatan Fungsional, Prodi Homebase (D4 RSTJ, D4 TRO, D3 TO), Peran (Ketua/Anggota), Status.
   - *2) Anggota Dosen Eksternal*: No, NIP/NIK, Nama, Asal Instansi/Institusi, Fakultas/Prodi, Negara (diisi jika ada anggota dosen non-PKTJ).
   - *3) Anggota Taruna/Mahasiswa*: No, Notar/NIM, Nama, Prodi, Angkatan (diisi jika melibatkan taruna PKTJ).
3. **Atribut Usulan**:
   - Formulir unggah berkas naskah proposal PDF (maksimal 10 MB). Isikan keterangan nama berkas, pilih berkas, dan klik Simpan.
4. **Luaran & Target**:
   - No dan Jenis Luaran: *Jurnal Nasional*, *Jurnal Internasional*, *HKI*, *Produk/Jasa*. Luaran wajib skema muncul otomatis, dan pengusul dapat menambah luaran lainnya (*Tambah Luaran*).
5. **Rencana Anggaran (RAB)**:
   - Input rincian anggaran: Tahun ke-, Jenis Pembelanjaan (*honorarium*, *bahan habis pakai*, *biaya perjalanan*, *biaya sewa*), nama item, detail item, biaya satuan, volume, dan total otomatis.
6. **Jadwal Kegiatan**:
   - Matriks jadwal: No, Nama Kegiatan, Urutan Tahun, tanggal mulai, dan tanggal selesai.
7. **Kelengkapan Lain**:
   - Isian tambah mitra kerjasama: Nama mitra, kontribusi dana mitra (*dari luar/in-cash*), dana tambahan, dan unggah dokumen pendukung (Surat Kesediaan Mitra). Bersifat wajib jika skema mewajibkan mitra, dan opsional jika tidak disyaratkan.
8. **Konfirmasi**:
   - Pilihan persetujuan: *Setuju / Tidak Setuju* terhadap ketentuan yang berlaku, lalu klik *Simpan* untuk mengirimkan usulan.

#### 2. Review Proposal
1. **Progress Proposal**:
   - Memantau tahapan status usulan secara transparan:
     `1.) Terkirim` ➔ `2.) Proses Review` ➔ `3.) Revisi` ➔ `4.) Diterima / Ditolak` ➔ `5.) Selesai`
2. **Revisi Proposal**:
   - Jika terdapat catatan revisi dari reviewer, pengusul wajib mengunggah berkas PDF naskah proposal perbaikan dalam batas waktu yang ditentukan.

#### 3. Monev (Pemantauan dan Evaluasi)
1. **Identitas Laporan Monev**:
   - Isian umum usulan monev: Jenis Kegiatan, Judul, Ringkasan, Kata Kunci, Bidang Fokus, Topik, Tahun, Lokasi Penelitian.
2. **Laporan Monev**:
   - Dijawab langsung melalui sistem:
     - **Pertanyaan Pilihan Ganda (7 Butir Capaian)**:
       1) Capaian Penelitian
       2) Publikasi Ilmiah
       3) Sebagai pemakalah dalam pertemuan ilmiah
       4) Hak Kekayaan Intelektual (HKI)
       5) Teknologi Tepat Guna (TTG)
       6) Produk / model / purwarupa / desain / karya seni / rekayasa sosial
       7) Buku ajar
     - **Pertanyaan Essai (7 Butir Kesesuaian Pelaksanaan)**:
       8) Uraikan kegiatan penelitian yang sudah dilaksanakan sampai saat ini
       9) Kesesuaian Waktu Penelitian (alasan bila tidak sesuai)
       10) Kesesuaian Metode atau Rancangan Penelitian (alasan bila tidak sesuai)
       11) Kesesuaian Personalia (alasan bila tidak sesuai)
       12) Kesesuaian Anggaran / Biaya Penelitian (alasan bila tidak sesuai)
       13) Kesesuaian Sarana dan Prasarana (alasan bila tidak sesuai)
       14) Kesesuaian Pelaksanaan dengan Usulan Penelitian (alasan bila tidak sesuai)
     - *Upload bukti fisik luaran sementara*.
3. **Konfirmasi**:
   - Memilih *Setuju* untuk menyetujui ketentuan dan menyelesaikan pengisian monev.

#### 4. Review Monev
1. **Progress Monev**:
   - Memantau tahapan status: `1.) Terkirim` ➔ `2.) Proses Penilaian` ➔ `3.) Selesai`. Nilai hasil monev dan catatan reviewer muncul setelah proses selesai.

#### 5. Laporan Kegiatan (Laporan Akhir)
1. **Identitas Laporan**: Verifikasi Jenis Kegiatan, Judul, Abstrak, Kata Kunci, Bidang Fokus, Topik, Tahun, Lokasi.
2. **Anggota**: Hanya diisi apabila terdapat perubahan susunan personalia anggota tim selama pelaksanaan.
3. **Atribut Laporan**: Unggah berkas dokumen naskah Laporan Akhir lengkap (PDF).
4. **Luaran / Capaian**: Pemutakhiran status luaran yang dicapai dan unggah bukti luaran akhir.
5. **Anggaran**: Menambahkan detail rincian pembukuan anggaran serapan 100% yang digunakan selama kegiatan.
6. **Konfirmasi**: Memilih *Setuju* untuk menyetujui pertanggungjawaban dan menyelesaikan pelaporan.

#### 6. Review Laporan
1. **Progress Laporan**:
   - Memantau tahapan status: `1.) Terkirim` ➔ `2.) Proses Review` ➔ `3.) Revisi / Tanpa Revisi` ➔ `5.) Selesai`.
2. **Revisi Laporan**:
   - Fasilitas unggah berkas revisi laporan kegiatan apabila reviewer meminta perbaikan dalam batas waktu yang ditetapkan.

---

## 5. KEBUTUHAN SISTEM INFORMASI MANAJEMEN - REVIEWER VIEW
*Sumber: Dokumen PDF Halaman 15–20*

Reviewer memiliki kewenangan untuk meninjau usulan proposal, laporan kemajuan monev, dan laporan akhir kegiatan yang telah ditugaskan oleh administrator.

### 5.1 Otentikasi & Halaman Utama Reviewer
| No | Role | Menu | Sub Menu | Isi Tampilan | Pemenuhan |
|:---:|:---:|---|---|---|---|
| **1** | Reviewer | **Login** | Masuk | • Nama pengguna<br>• Kata Sandi | Sistem hanya bisa diakses oleh dosen internal PKTJ yang ditugaskan sebagai reviewer. |
| **2** | Reviewer | **Home** | • Penelitian<br>• Pengabdian kepada Masyarakat | Pilihan akses untuk meninjau penugasan bidang Penelitian atau Pengabdian kepada Masyarakat. |

### 5.2 Standar Skala Skor Penilaian Reviewer
Seluruh rubrik telaah proposal, monev, dan laporan akhir menggunakan **skala 6 tingkat baku**:
- `1` = Buruk
- `2` = Sangat Kurang
- `3` = Kurang
- `5` = Cukup
- `6` = Baik
- `7` = Sangat Baik
*(Skor 4 sengaja ditiadakan sesuai standar forced-choice)*.  
Formula akumulasi nilai: **Nilai = Bobot × Skor**.

---

### 5.3 Alur Telaah Bidang Penelitian (Reviewer View)

#### 1. Daftar Review
- Menampilkan seluruh judul penelitian yang ditugaskan oleh admin. Klik salah satu judul untuk memulai telaah.

#### 2. Proposal
1. **Permintaan**: Tipe review, unduh berkas proposal, informasi jadwal telaah (admin request, respon reviewer, batas waktu), kotak persetujuan, dan tombol *Setujui Review*.
2. **Review (Rubrik 5 Kriteria Baku Penelitian)**:
   - *Kriteria 1*: Perumusan masalah, tujuan, dan peta jalan penelitian (**BOBOT 15%**)
   - *Kriteria 2*: Luaran proses dan produk (produk/kebijakan/model/rekayasa/TTG, HKI, publikasi) (**BOBOT 35%**)
   - *Kriteria 3*: Tinjauan pustaka / kemajuan yang telah dicapai (**BOBOT 15%**)
   - *Kriteria 4*: Metode penelitian (desain dan ketepatan metode) (**BOBOT 20%**)
   - *Kriteria 5*: Kelayakan (jadwal, personalia, biaya RAB, dukungan sarpras) (**BOBOT 15%**)
   - *Komentar Penilai*: Kolom isian catatan kualitatif.
   - *Skor*: 1, 2, 3, 5, 6, 7.
3. **Atribut Revisi**:
   - Unggah berkas tabel catatan revisi (format Word / PDF).
   - Rekomendasi hasil telaah proposal: `1) Revisi`, `2) Diterima`, `3) Ditolak`.
4. **Konfirmasi**:
   - Pilihan *Setuju / Tidak Setuju*, lalu klik *Simpan* untuk menyelesaikan penilaian proposal.

#### 3. Monev
1. **Permintaan**: Tipe review, jawaban isian monev pengusul, jadwal review, kotak persetujuan, dan klik *Setujui Review*.
2. **Review (Rubrik 7 Komponen Capaian Monev)**:
   - Review jawaban 7 PG dan 7 Essai.
   - Penilaian komponen berbobot:
     1) Capaian Penelitian (**BOBOT 25**)
     2) Publikasi Ilmiah (**BOBOT 20**)
     3) Sebagai pemakalah dalam pertemuan ilmiah (**BOBOT 10**)
     4) Hak Kekayaan Intelektual (**BOBOT 5**)
     5) Teknologi Tepat Guna (**BOBOT 10**)
     6) Produk / model / purwarupa / desain / rekayasa sosial (**BOBOT 20**)
     7) Buku ajar (**BOBOT 10**)
   - *Komentar Penilai*: Isian catatan evaluasi luaran.
   - *Skor*: 1, 2, 3, 5, 6, 7 (pemberian skor melihat kesesuaian target vs bukti fisik luaran di lapangan).
3. **Konfirmasi**:
   - Pilihan *Setuju / Tidak Setuju*, lalu klik *Simpan* untuk menyelesaikan proses penilaian monev.

#### 4. Laporan Kegiatan (Laporan Akhir)
1. **Permintaan**: Tipe review, berkas laporan kegiatan, jadwal review, kotak persetujuan, dan klik *Setujui Review*.
2. **Review (Rubrik 4 Kriteria Baku Laporan Akhir)**:
   - *Kriteria 1*: Kesesuaian hasil dengan tujuan dan sasaran penelitian (*product oriented*) (**BOBOT 30%**)
   - *Kriteria 2*: Realisasi capaian luaran penelitian sesuai rencana (**BOBOT 30%**)
   - *Kriteria 3*: Tingkat pemanfaatan hasil penelitian (kapasitas PT, aplikasi masyarakat/industri, kebijakan publik) (**BOBOT 25%**)
   - *Kriteria 4*: Kesiapan dan kemampuan mempresentasikan hasil (**BOBOT 15%**)
   - *Komentar Penilai*: Isian catatan akhir.
   - *Skor*: 1, 2, 3, 5, 6, 7.
3. **Atribut Revisi**:
   - Unggah berkas tabel catatan revisi (Word / PDF).
   - Rekomendasi laporan: `1) Revisi` atau `2) Diterima`.
4. **Konfirmasi**:
   - Pilihan *Setuju / Tidak Setuju*, lalu klik *Simpan* untuk menyelesaikan evaluasi laporan akhir.

---

### 5.4 Alur Telaah Bidang Pengabdian kepada Masyarakat / PKM (Reviewer View)
Struktur menu telaah PkM identik dengan Penelitian (Daftar Review, Proposal, Monev, Laporan), dengan pembeda utama pada **Rubrik Penilaian Proposal PkM (6 Kriteria Baku)**:
1. *Kriteria 1*: Analisis Situasi (kondisi mitra saat ini, persoalan umum mitra) (**BOBOT 20%**)
2. *Kriteria 2*: Permasalahan prioritas mitra dan solusi yang ditawarkan (**BOBOT 15%**)
3. *Kriteria 3*: Target Luaran (jenis luaran dan spesifikasi sesuai kegiatan) (**BOBOT 15%**)
4. *Kriteria 4*: Ketepatan metode pendekatan, rencana kegiatan, kontribusi partisipasi mitra (**BOBOT 20%**)
5. *Kriteria 5*: Kelayakan Perguruan Tinggi (kualifikasi tim, relevansi keahlian, sinergisme, jadwal, lampiran) (**BOBOT 10%**)
6. *Kriteria 6*: Kelayakan usulan anggaran biaya (bahan habis pakai, peralatan, perjalanan, lain-lain) (**BOBOT 20%**)
- *Skor*: 1, 2, 3, 5, 6, 7.
- *Rekomendasi*: `Revisi`, `Diterima`, `Ditolak`.
- Penilaian Monev PkM dan Laporan Akhir PkM menggunakan instrumen dan rubrik berbobot yang sama dengan bidang penelitian.

---

## 6. BATASAN KHUSUS & STANDAR KUALITAS INSTITUSI PKTJ

1. **3 Program Studi PKTJ (Strict 3 Prodis Only)**:
   - Dilarang keras menampilkan prodi di luar: `D4 RSTJ`, `D4 TRO`, dan `D3 TO`.
2. **Kebijakan Bebas Emoji (Strict Zero-Emoji Policy)**:
   - Dilarang menggunakan karakter emoji di seluruh kode, antarmuka publik, panel admin, formulir, alert, dan dokumen.
3. **Standar Spasial Grid 4px Tailwind CSS**:
   - Semua margin, padding, tinggi, lebar, border radius, dan leading tipografi wajib menggunakan kelipatan angka 4px.
4. **Bebas Jargon IT Rumit**:
   - Menggunakan peristilahan akademik yang ramah pengguna (*Pengajuan Usulan*, *Unduh Berkas*, *Rincian Anggaran Biaya*, *Nama Pengguna & Kata Sandi*).
5. **Kebijakan Larangan Kata 'Resmi'**:
   - Dilarang menggunakan kata "resmi" pada UI dan dokumen (gunakan padanan: *Website P3M PKTJ*, *Email Kedinasan*, *Dokumen Panduan*, *SK Penetapan*).
6. **Larangan Membuka Browser Otomatis**:
   - Seluruh inspeksi tampilan peramban dilakukan secara mandiri oleh pengguna.

---
*Dokumen ini diperbarui untuk mencerminkan secara presisi dan ringkas seluruh tabel kebutuhan pada `Kebutuhan Website P3M rev.pdf` tanpa penambahan fitur spekulatif di luar dokumen acuan.*
