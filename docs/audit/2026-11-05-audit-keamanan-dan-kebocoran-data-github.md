# Laporan Audit Keamanan Repositori & Kebocoran Data GitHub

**Tanggal:** 5 November 2026  
**Status:** Selesai & Diamankan  
**Repositori Remote:** `https://github.com/arirezap/P3M-PKTJ.git` (Branch `main`)

---

## 1. Ringkasan Eksekutif

Pemeriksaan menyeluruh telah dilakukan terhadap seluruh berkas yang terlacak pada repositori Git dan GitHub. Ditemukan beberapa kategori berkas sensitif dan dokumen kerja internal yang sebelumnya terlacak ke GitHub. Tindakan pengamanan telah dilakukan dengan mengeluarkan berkas-berkas tersebut dari pelacakan Git (`git rm --cached`) tanpa menghapus berkas fisik di komputer lokal, serta memperbarui berkas [`.gitignore`](../../.gitignore) dengan aturan perlindungan komprehensif.

---

## 2. Rincian Temuan Berkas Sensitif Sebelumnya di GitHub

| Kategori | Berkas Terkait | Tingkat Risiko | Penjelasan & Potensi Kebocoran |
| :--- | :--- | :--- | :--- |
| **Cadangan Basis Data (SQL Dump)** | `database/backups/p3m_backup_with_dummy.sql` | **Kritis / Tinggi** | Memuat dump struktur tabel dan baris data pengguna (`users`) yang mencakup *hash* kata sandi bcrypt (`$2y$12$...`), alamat email, nomor telepon seluler pribadi, dan NIDN/NIP. Berkas dump SQL mentah sangat rentan jika tersimpan di GitHub. |
| **Spreadsheet Kerja Operasional** | `2025_Database_Kinerja Penelitian&PkM.xlsx`<br>`Data_Penelitian.xlsx`<br>`Data_PkM.xlsx`<br>`Kebutuhan Website P3M rev.xlsx` | **Sedang - Tinggi** | Dokumen spreadsheet kerja operasional internal institusi yang memuat catatan personal tim, tautan privat Google Drive (beserta token akses URL), rincian gender dan nama peserta pelatihan diklat. Data ini telah berhasil diekstrak dan disaring ke seeder JSON aplikasi (`database/seeders/*_2025_data.json`) sehingga berkas biner `.xlsx` tidak diperlukan lagi pada repositori kode sumber. |
| **Dokumen PDF Acuan Internal** | `database excel p3m.pdf`<br>`Kebutuhan Website P3M rev.pdf` | **Sedang** | Berkas PDF hasil konversi database Excel dan dokumen kebutuhan kerja internal. |
| **Artefak Build Sementara Vite** | `vite.config.js.timestamp-1791990649871-70449ce9d617e8.mjs`<br>`vite.config.js.timestamp-1793540626368-6acc9a8df85b48.mjs` | **Rendah** | Berkas timestamp sementara yang otomatis dibuat oleh bundler Vite saat dijalankan di lingkungan Windows. |
| **Snapshot Cadangan & Konversi Graphify** | `graphify-out/converted/*`<br>`graphify-out/2026-11-05/*` | **Rendah - Sedang** | Salinan teks markdown dari file spreadsheet dan snapshot cadangan graf berukuran 140.000+ baris yang membebani repositori. |

---

## 3. Hasil Pemindaian Kredensial & Kunci Rahasia (*Secret Scanning*)

- **Berkas Kunci Lingkungan (`.env`)**: Berada dalam [`.gitignore`](../../.gitignore) dan **tidak terlacak** di GitHub.
- **Berkas Contoh (`.env.example`)**: Bersih, seluruh konfigurasi rahasia (`APP_KEY`, `DB_PASSWORD`, `AWS_SECRET_ACCESS_KEY`) bernilai kosong.
- **Konfigurasi Aplikasi (`config/*.php`)**: Bersih, seluruh parameter koneksi dan rahasia menggunakan fungsi pembantu `env(...)` tanpa nilai mentah (*hardcoded*).
- **Pencarian Pola Kunci API (OpenAI, Google API, GitHub PAT, Private Key)**: Tidak ditemukan kebocoran kunci API aktif pada kode sumber aplikasi.

---

## 4. Tindakan Pengamanan yang Telah Diterapkan

1. **Pembaruan Aturan [`.gitignore`](../../.gitignore)**:
   Menambahkan blok aturan isolasi:
   - `*.sql` dan `/database/backups/`
   - `*.xlsx`, `*.xls`, `*.csv`
   - `/database excel p3m.pdf` dan `/Kebutuhan Website P3M rev.pdf`
   - `vite.config.js.timestamp-*`
   - `/graphify-out/cache/`, `/graphify-out/converted/`, `/graphify-out/20*`
   - `.DS_Store`, `Thumbs.db`
2. **Penghapusan dari Indeks Git (`git rm --cached`)**:
   Seluruh berkas di atas telah dikeluarkan dari pelacakan repositori. Seluruh berkas fisik asli tetap aman tersimpan di direktori lokal komputer.
3. **Commit Pengamanan**:
   Telah dibuat commit pengamanan pada branch `main` (`651eb6d`).
4. **Verifikasi Fungsionalitas Aplikasi**:
   Seluruh 199 tes unit & fitur lulus **100% (980 assertions)** tanpa kegagalan.

---

## 5. Rekomendasi Tindak Lanjut

1. **Sinkronisasi ke Remote GitHub**:
   Jalankan perintah berikut di terminal untuk menyinkronkan status pengamanan ke GitHub:
   ```bash
   git push origin main
   ```
2. **Pembersihan Riwayat Commit Lama (Opsional)**:
   Jika repositori berstatus publik dan Anda ingin menghapus berkas-berkas tersebut dari seluruh riwayat commit lama (*commit history* terdahulu), dapat digunakan utilitas `git-filter-repo` atau BFG Repo-Cleaner.

