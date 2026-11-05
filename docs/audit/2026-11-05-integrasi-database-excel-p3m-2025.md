# Laporan Integrasi Database Kinerja Penelitian & PkM 2025 (Excel P3M PKTJ)

**Tanggal:** 5 November 2026  
**Sumber Data:** `2025_Database_Kinerja Penelitian&PkM.xlsx` (8 Lembar Kerja)  
**Status:** Selesai & Terverifikasi (Tanpa Duplikasi Data atau Tabel Ganda)

---

## 1. Ringkasan Eksekutif

Seluruh data operasional tahun 2025 dari berkas `2025_Database_Kinerja Penelitian&PkM.xlsx` telah diintegrasikan secara bertahap (Tahap 1 hingga Tahap 3) ke dalam skema database aplikasi P3M PKTJ yang sudah ada melalui penyesuaian kolom migrasi baru, tanpa membuat tabel ganda dan dengan jaminan **nihil duplikasi data (zero duplicate records)**.

| Tahap | Lembar Kerja Excel (`Sheet`) | Tabel Aplikasi Tujuan | Jumlah Baris Unik 2025 |Perintah Sinkronisasi CLI |
| :--- | :--- | :--- | :--- | :--- |
| **Tahap 1** | `Penelitian` | `researches` & `users` | **27 Kegiatan Penelitian** (21 Ketua Peneliti Dosen) | `php artisan p3m:import-penelitian-2025` |
| **Tahap 2** | `Publikasi`, `Publikasi_pending`, `Buku`, `HaKI` | `outputs` & `users` | **184 Luaran Penelitian** (`144` Publikasi Terbit + `21` Publikasi Pending Unik + `6` Buku Monograf/Produk + `13` HaKI) | `php artisan p3m:import-luaran-2025` |
| **Tahap 3** | `Pengabdian`, `PkM_Pokja Diklat` | `community_services` & `community_service_outputs` | **74 Kegiatan PkM** (`14` Penyuluhan/Sosialisasi + `60` Angkatan Diklat) & **33 Capaian Luaran PkM** | `php artisan p3m:import-pkm-2025` |

---

## 2. Penyesuaian Skema Database (Tanpa Tabel Ganda)

1. **Tabel `outputs` ([`2026_11_05_000001_add_spreadsheet_columns_to_outputs_table.php`](../../database/migrations/2026_11_05_000001_add_spreadsheet_columns_to_outputs_table.php))**:
   - Memperlebar kolom `author_inventor`, `nama_jurnal_penerbit`, dan `link_dokumen` menjadi `TEXT` agar daftar panjang tim penulis dosen/taruna serta tautan jurnal tidak terpotong.
   - Menambahkan kolom metadata spreadsheet: `penulis_korespondensi`, `anggota_dosen`, `anggota_taruna`, `indeksasi_nasional`, `indeksasi_internasional`, `kategori_kpi`, `tanggal_publikasi`, `status_publikasi`, `isbn`, `tempat_terbit`, `jumlah_halaman`, `jenis_ciptaan`, `pemegang_hki`, `tanggal_permohonan`, `tanggal_diumumkan`.
2. **Tabel `community_services` & `community_service_outputs` ([`2026_11_05_000002_add_spreadsheet_columns_to_community_services_table.php`](../../database/migrations/2026_11_05_000002_add_spreadsheet_columns_to_community_services_table.php))**:
   - Menambahkan kolom metadata spreadsheet pada `community_services`: `jenis_diklat`, `angkatan`, `kategori_peserta`, `waktu_pelaksanaan`, `target_peserta`, `realisasi_peserta`, `peserta_l`, `peserta_p`, `link_foto`, `link_laporan`.
   - Memperlebar kolom `berkas_laporan`, `link_dokumen`, dan `berkas_luaran` menjadi `TEXT`.

---

## 3. Deduplikasi & Pembersihan Data Dummy 2025

- **Deduplikasi `Publikasi` vs `Publikasi_pending`**: Dari 24 baris pada sheet `Publikasi_pending`, terdeteksi 3 judul artikel yang sudah tercatat pada sheet `Publikasi` (baris 5, 6, dan 28). Ketiga baris duplikat tersebut otomatis dilewati sehingga menghasilkan tepat **165 publikasi unik** (`144` terbit + `21` pending).
- **Pembersihan Data Dummy Tahun 2025**: Seluruh data contoh (dummy) tahun 2025 pada tabel `researches`, `outputs`, `community_services`, dan `community_service_outputs` dibersihkan sebelum penyemaian data riil spreadsheet, sementara data tahun lainnya (2024 dan 2026) tetap dipertahankan untuk kesinambungan grafik tren multi-tahun.
- **Kebijakan Anggaran Rp 0**: Sesuai ketiadaan kolom nominal rupiah pada berkas Excel 2025, seluruh kolom `anggaran` dan `realisasi_dana` untuk data impor 2025 diisi `0`.

