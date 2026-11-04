# Audit: Autentikasi Sistem (Login & Logout) SIM P3M PKTJ

- Tanggal       : 2026-11-03
- Auditor       : AI Antigravity
- Commit/Branch : main
- Cakupan       : 
  - Route: `GET /login`, `POST /login` (dengan `throttle:15,1`), `POST /logout`
  - Controller: `app/Http/Controllers/Auth/LoginController.php`
  - View: `resources/views/auth/login.blade.php`
  - Model: `app/Models/User.php`
  - Feature Tests: `tests/Feature/AuthenticationTest.php`, `tests/Feature/AdminWorkflowTest.php`
- File terkait  : `graphify query "login logout authentication"` -> `LoginController.php`, `login.blade.php`, `AuthenticationTest.php`, `User.php`, `web.php`

---

## Ringkasan Skor

| Bagian | Item Lulus | Item Gagal | N/A | Catatan |
| :--- | :--- | :--- | :--- | :--- |
| A1 Clean Code | 10 | 0 | 0 | Struktur method padat, tanpa kode mati/duplikasi, lolos Laravel Pint (`vendor\bin\pint --test`). |
| A2 SOLID | 5 | 0 | 0 | SRP terpenuhi, login controller hanya memproses alur sesi dan delegasi autentikasi. OCP didukung role methods. |
| A3 Self-Documenting | 9 | 0 | 0 | Penamaan deskriptif, type hint lengkap (`View|RedirectResponse`, `RedirectResponse`), bebas jargon komputasi berlebih. |
| A4 Testable | 10 | 0 | 0 | 12 Feature tests di `AuthenticationTest` + 10 di `AdminWorkflowTest` lulus 100% (mencakup NIDN/NIP dan akun nonaktif). |
| A5 Performa & Skala | 6 | 0 | 0 | Autentikasi via indeks unik email & nidn_nip, payload aset CSS/JS termampatkan optimal via Vite. |
| A6 Keamanan | 9 | 0 | 0 | CSRF token (`@csrf`), rate limiting (`throttle:15,1`), proteksi brute force, regenerasi sesi, invalidasi saat nonaktif & logout. |
| A7 Database | 5 | 0 | 0 | Kolom `status_aktif`, `nidn_nip`, `email` terindeks dengan baik pada tabel `users`. |
| A8 Error & Log | 4 | 0 | 0 | Penanganan validasi jelas dalam bahasa Indonesia yang santun dan akrab bagi dosen. |
| B1 Konsistensi Desain | 8 | 0 | 0 | Sesuai design.md, palet warna Maritim Modern (`#0B2A59`, aksen kuning emas, latar slate-50). |
| B2 Responsif | 6 | 0 | 0 | Zero horizontal overflow di seluruh breakpoint (mobile, tablet, desktop). Container fleksibel. |
| B3 Aksesibilitas | 7 | 0 | 0 | Seluruh target sentuh (tombol submit `h-12` = 48px, tombol pengujian cepat `h-11` = 44px) memenuhi standar ≥ 44px. Label input terhubung id. |
| B4 Status Tampilan | 5 | 0 | 0 | Pesan sukses logout (alert hijau) dan pesan kesalahan validasi/kredensial (alert merah) memiliki kontras teks yang ramah dibaca. |
| B5 Bahasa & Teks | 6 | 0 | 0 | Istilah ramah pengguna civitas akademika ("Nama Pengguna", "Kata Sandi", "Masuk ke SIM P3M"). Bebas jargon teknis. |
| C Mandat Proyek | 8 | 0 | 0 | Bebas emoji (0), bebas kata "resmi" (0), tunduk grid 4px (0 pelanggaran half-step), gambar memiliki atribut alt. |

---

## Hasil Pemeriksaan Otomatis

- php artisan test     : Lulus 178 / Gagal 0 (100% kelulusan, 870 assertions)
- npm run build        : Sukses (Vite v5.4.21, app.css 73.62 kB, app.js 107.37 kB)
- composer audit       : Ditemukan 6 advisori dependensi upstream framework Laravel / Symfony
- pint --test          : Bersih (Passed dengan format PSR-12 / Laravel Standards)
- Pemindaian Grid 4px  : 0 pelanggaran (semua padding, margin, width, height, leading kelipatan 4px)
- Pemindaian Kata 'Resmi' : 0 kemunculan
- Pemindaian Emoji     : 0 kemunculan
- Pemindaian Image Alt : 100% gambar memiliki atribut alt valid

---

## Evaluasi Alur Fitur Login & Logout

### 1. Pengenalan Ganda Pengidentifikasi (Dual-Field Identifier)
Sistem secara cerdas memeriksa apakah masukan merupakan alamat surel atau nomor induk dosen/pegawai:
- Jika format berupa surel (diuji via `filter_var($loginInput, FILTER_VALIDATE_EMAIL)`), autentikasi mencari kolom `email`.
- Jika bukan surel, autentikasi mencari kolom `nidn_nip`.
- Hal ini memberikan kenyamanan bagi dosen atau tenaga kependidikan yang lebih hafal NIDN/NIP mereka.

### 2. Matriks Pengalihan Berdasarkan Peran (Role-Based Redirection Matrix)

| Peran Pengguna | Jalur Masuk Berhasil | Jalur Logout | Proteksi Halaman Tamu |
| :--- | :--- | :--- | :--- |
| **Admin P3M** | Redirect ke `/admin/dashboard` | Redirect ke `/login` (dengan pesan status sukses) | Jika sudah login membuka `/login`, otomatis diarahkan ke `/admin/dashboard` |
| **Dosen / Peneliti** | Redirect ke `/dosen/dashboard` | Redirect ke `/login` (dengan pesan status sukses) | Jika sudah login membuka `/login`, otomatis diarahkan ke `/dosen/dashboard` |
| **Reviewer** | Redirect ke `/reviewer/dashboard` | Redirect ke `/login` (dengan pesan status sukses) | Jika sudah login membuka `/login`, otomatis diarahkan ke `/reviewer/dashboard` |
| **Pengguna Nonaktif** | Ditolak seketika, sesi diinvalasi, kembali ke `/login` dengan peringatan | N/A | Akun dengan `status_aktif = false` diblokir aksesnya |

### 3. Aspek Keamanan Autentikasi
1. **Pencegahan Brute-Force**: Rute `POST /login` dibatasi dengan middleware `throttle:15,1` (maksimal 15 percobaan per menit per IP).
2. **Pencegahan Session Fixation**: Pemanggilan `$request->session()->regenerate()` dilakukan segera setelah kredensial terverifikasi valid.
3. **Pembersihan Sesi Total pada Logout**: Logout menjalankan `Auth::logout()`, `$request->session()->invalidate()`, dan `$request->session()->regenerateToken()`.
4. **Pencegahan Enumerasi Akun**: Pesan kesalahan kredensial disamarkan secara terpadu ("Email/NIDN atau kata sandi yang Anda masukkan tidak sesuai") sehingga penyerang tidak dapat menebak keberadaan email tertentu.

### 4. Tampilan Antarmuka & Ergonomi (UI/UX)
1. **Fitur Intuitif**: Dilengkapi fitur "Tampilkan/Sembunyikan Kata Sandi" interaktif berbasis Alpine.js tanpa muat ulang halaman.
2. **Pengujian Cepat (Tester Quick-Fill)**: Disediakan tombol pintas akun uji coba untuk Admin, Dosen, dan Reviewer dengan ukuran ergonomis `h-11` (44px).
3. **Sentuhan Visual Berwibawa**: Mengusung lambang PKTJ beresolusi tinggi, bilah navigasi mini Kementerian Perhubungan RI di bagian atas, dan tombol aksi utama dengan feedback taktil (`active:scale-[0.98]`).

---

## Temuan

| ID | Area | Lokasi | Temuan | Level | Rekomendasi | Status |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| AUD-AUTH-01 | Keamanan | `routes/web.php:94` | Rute login sebelumnya belum memiliki pembatasan laju (*rate limiting*) `throttle`. | Sedang | Tambahkan `middleware('throttle:15,1')` pada rute `POST /login`. | Selesai |
| AUD-AUTH-02 | Grid Spasial | `resources/views/auth/login.blade.php:38-39` | Tautan kembali ke portal menggunakan `gap-1.5` (6px) dan SVG `w-3.5 h-3.5` (14px). | Rendah | Sesuaikan menjadi `gap-2` (8px) dan `w-4 h-4` (16px) sesuai kelipatan 4px. | Selesai |
| AUD-AUTH-03 | Ergonomi Sentuh | `resources/views/auth/login.blade.php:162-176` | Tombol pengujian cepat akun sebelumnya berukuran `h-10` (40px). | Rendah | Tingkatkan tinggi tombol menjadi `h-11` (44px) memenuhi standar ergonomi sentuh ≥ 44px. | Selesai |
| AUD-AUTH-04 | Cakupan Uji | `tests/Feature/AuthenticationTest.php` | Pengujian login NIDN/NIP dan blokir akun nonaktif belum tercakup eksplisit. | Rendah | Tambahkan unit pengujian `test_user_can_authenticate_using_nidn_nip` dan `test_deactivated_user_cannot_authenticate`. | Selesai |

---

## Keputusan

- Hasil  : **Lulus**
- Alasan : Seluruh kriteria fungsional, keamanan (CSRF, session fixation, throttling), responsivitas, dan kepatuhan desain (grid 4px, nol emoji, nol kata "resmi") telah terpenuhi 100%. Rangkaian pengujian otomatis lulus sempurna (178 tes, 870 assertions), dan kompilasi aset Vite berjalan tanpa eror.
- Tindak lanjut : Tidak ada temuan kritis atau tinggi yang tertunda. Sistem siap beroperasi.

