<?php

namespace Database\Seeders;

use App\Models\Output;
use App\Models\Prodi;
use App\Models\Research;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Output2025Seeder extends Seeder
{
    /**
     * Jalankan seeder data riil luaran penelitian tahun 2025 (Publikasi, Publikasi Pending, Buku, HaKI)
     * dari berkas Excel P3M PKTJ.
     */
    public function run(): void
    {
        $jsonPath = database_path('seeders/outputs_2025_data.json');
        if (! File::exists($jsonPath)) {
            $this->command?->error('Berkas data outputs_2025_data.json tidak ditemukan.');

            return;
        }

        $items = json_decode(File::get($jsonPath), true);
        if (empty($items)) {
            $this->command?->error('Data outputs_2025_data.json kosong.');

            return;
        }

        $prodis = Prodi::all()->keyBy('kode_prodi');

        // 1. Bersihkan data luaran dummy tahun 2025 (pertahankan riwayat tahun lainnya)
        Output::where('tahun', 2025)->delete();

        // 2. Masukkan 184 data luaran riil tahun 2025 secara idempoten (tanpa duplikasi)
        $defaultPasswordHash = Hash::make('password');
        $existingUsers = User::all()->keyBy('email');
        $now = now();
        $batchInsert = [];
        $seenKeys = [];

        foreach ($items as $idx => $item) {
            $dedupKey = strtolower(trim($item['kategori'])).'|'.strtolower(trim($item['judul']));
            if (isset($seenKeys[$dedupKey])) {
                continue;
            }
            $seenKeys[$dedupKey] = true;

            $primaryDosen = trim($item['primary_dosen'] ?? 'Tim Peneliti PKTJ');
            $prodiCode = $item['prodi_code'] ?? 'RSTJ';
            $prodi = $prodis->get($prodiCode) ?? $prodis->first();

            // Sinkronkan akun user dosen internal tanpa duplikasi
            $slugName = Str::slug($primaryDosen, '.');
            if (empty($slugName)) {
                $slugName = 'dosen.pktj.'.($idx + 1);
            }
            $email = $slugName.'@pktj.ac.id';

            $user = $existingUsers->get($email);
            if (! $user) {
                $nidnNip = '06'.str_pad((string) (200000 + $idx + 1), 8, '0', STR_PAD_LEFT);
                $user = User::create([
                    'name' => $primaryDosen,
                    'email' => $email,
                    'password' => $defaultPasswordHash,
                    'role' => 'dosen',
                    'roles' => ['dosen'],
                    'prodi_id' => $prodi?->id,
                    'nidn_nip' => $nidnNip,
                    'keahlian' => 'Keselamatan Transportasi Jalan & Rekayasa Vokasi',
                    'status_aktif' => true,
                ]);
                $existingUsers->put($email, $user);
            } elseif (! $user->prodi_id && $prodi) {
                $user->update([
                    'prodi_id' => $prodi->id,
                    'status_aktif' => true,
                ]);
            }

            $batchInsert[] = [
                'kategori' => $item['kategori'],
                'judul' => $item['judul'],
                'prodi_id' => $prodi?->id,
                'user_id' => $user->id,
                'author_inventor' => $item['author_inventor'] ?: $primaryDosen,
                'penulis_korespondensi' => $item['penulis_korespondensi'] ?? $primaryDosen,
                'anggota_dosen' => $item['anggota_dosen'] ?? null,
                'anggota_taruna' => $item['anggota_taruna'] ?? null,
                'tahun' => (int) ($item['tahun'] ?? 2025),
                'nama_jurnal_penerbit' => $item['nama_jurnal_penerbit'] ?? null,
                'indeksasi_nasional' => $item['indeksasi_nasional'] ?? null,
                'indeksasi_internasional' => $item['indeksasi_internasional'] ?? null,
                'kategori_kpi' => $item['kategori_kpi'] ?? null,
                'tanggal_publikasi' => $item['tanggal_publikasi'] ?? null,
                'status_publikasi' => $item['status_publikasi'] ?? 'terbit',
                'nomor_registrasi_hki' => $item['nomor_registrasi_hki'] ?? null,
                'isbn' => $item['isbn'] ?? null,
                'tempat_terbit' => $item['tempat_terbit'] ?? null,
                'jumlah_halaman' => $item['jumlah_halaman'] ?? null,
                'jenis_ciptaan' => $item['jenis_ciptaan'] ?? null,
                'pemegang_hki' => $item['pemegang_hki'] ?? null,
                'tanggal_permohonan' => $item['tanggal_permohonan'] ?? null,
                'tanggal_diumumkan' => $item['tanggal_diumumkan'] ?? null,
                'tingkat_kesiapan_terapan' => $item['tingkat_kesiapan_terapan'] ?? 'TKT 3',
                'lisensi' => $item['lisensi'] ?? 'Open Access',
                'fase_roadmap' => $item['fase_roadmap'] ?? 'Fase 2: Pengembangan Rekayasa & Manajemen (2025-2026)',
                'deskripsi_kemanfaatan' => $item['deskripsi_kemanfaatan'] ?? null,
                'mitra_kerjasama' => $item['mitra_kerjasama'] ?? null,
                'sumber_dana' => $item['sumber_dana'] ?? 'Mandiri / DIPA PKTJ',
                'realisasi_dana' => 0,
                'link_dokumen' => $item['link_dokumen'] ?? null,
                'berkas_luaran' => $item['berkas_luaran'] ?? null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        foreach (array_chunk($batchInsert, 50) as $chunk) {
            Output::insert($chunk);
        }

        // Sinkronkan luaran publikasi berstatus Published dari master Excel
        $pubJsonPath = database_path('seeders/outputs_published_master_data.json');
        if (File::exists($pubJsonPath)) {
            $publishedItems = json_decode(File::get($pubJsonPath), true);
            foreach ($publishedItems as $pub) {
                $exists = Output::where('judul', $pub['judul'])->exists();
                if (! $exists) {
                    $relatedResearch = Research::where('kode_penelitian', $pub['kode_penelitian'])->first();
                    Output::create([
                        'kategori' => 'publikasi',
                        'judul' => $pub['judul'],
                        'prodi_id' => $relatedResearch?->prodi_id ?? $prodis->first()?->id,
                        'user_id' => $relatedResearch?->user_id,
                        'author_inventor' => $relatedResearch?->ketua_peneliti ?? 'Tim Peneliti PKTJ',
                        'tahun' => (string) $pub['tahun'],
                        'nama_jurnal_penerbit' => 'Jurnal Ilmiah Terakreditasi Nasional / Internasional',
                        'link_dokumen' => $pub['doi'] ?: null,
                        'status_publikasi' => 'published',
                    ]);
                }
            }
        }

        $importedCount = count($batchInsert);
        $this->command?->info("Sukses menyinkronkan {$importedCount} data luaran penelitian riil tahun 2025.");
    }
}
