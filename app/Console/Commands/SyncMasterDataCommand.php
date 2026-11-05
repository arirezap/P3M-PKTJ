<?php

namespace App\Console\Commands;

use App\Models\CommunityService;
use App\Models\Output;
use App\Models\Prodi;
use App\Models\Research;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SyncMasterDataCommand extends Command
{
    /**
     * Nama dan tanda tangan command.
     *
     * @var string
     */
    protected $signature = 'p3m:sync-master-data';

    /**
     * Deskripsi command konsol.
     *
     * @var string
     */
    protected $description = 'Sinkronisasi master data penelitian dan pengabdian dari berkas Excel sah P3M PKTJ tanpa duplikasi.';

    /**
     * Eksekusi perintah konsol.
     */
    public function handle(): int
    {
        $this->info('Memulai sinkronisasi master data P3M PKTJ...');

        $researchJsonPath = database_path('seeders/research_master_data.json');
        $pkmJsonPath = database_path('seeders/pkm_master_data.json');
        $publishedOutputsJsonPath = database_path('seeders/outputs_published_master_data.json');

        if (! File::exists($researchJsonPath) || ! File::exists($pkmJsonPath)) {
            $this->error('Berkas JSON master data tidak ditemukan di database/seeders/.');

            return Command::FAILURE;
        }

        $researchItems = json_decode(File::get($researchJsonPath), true);
        $pkmItems = json_decode(File::get($pkmJsonPath), true);
        $publishedOutputs = File::exists($publishedOutputsJsonPath)
            ? json_decode(File::get($publishedOutputsJsonPath), true)
            : [];

        $prodis = Prodi::all()->keyBy('kode_prodi');
        $defaultPasswordHash = Hash::make('password');

        // Pemetaan fokus kepakaran dosen
        $keahlianMap = [
            'Brasie Pradana' => 'Laboratorium Virtual Reality & Simulasi Transportasi',
            'Dani F. Brilianti' => 'Rekayasa Perkerasan Jalan & E-Learning Rekayasa Transportasi',
            'Dwi Wahyu Hidayat' => 'Drainase Jalan, Perkerasan & Volume Lalu Lintas',
            'Ethys Pranoto' => 'Analisis Tegangan Sasis & Konstruksi Kendaraan Barang',
            'Setya Wijayanta' => 'Sistem Pendingin Termoelektrik & Reduksi Emisi Kendaraan',
            'Nurul Fitriani' => 'Perencanaan Transportasi Publik & Kinerja Angkutan Umum',
            'Yogi Oktopianto' => 'Geometrik Jalan, Skid Resistance & Fasilitas Shelter Angkutan',
            'Mokhammad Rifqi Tsani' => 'Kendaraan Listrik, Sistem Cerdas & Case Base Reasoning',
            'Ramadhan Dwi Prasetyo' => 'Logistik Transportasi, Kebijakan Daerah & Regulasi Angkutan',
            'Aat Eska Fahmadi' => 'Chasis Kendaraan Niaga & Uji Beban Lebih (Over Dimension Overload)',
            'Moch. Aziz Kurniawan' => 'Diesel Particulate Filter & Termodinamika Mesin Kendaraan',
            'Frans Tohom' => 'Analisis Daerah Rawan Kecelakaan & Pemodelan Vissim Simpang',
            'Helmi Wibowo' => 'Computer Vision, Deteksi Citra YOLO & Sensor Kendaraan',
            'Joko Siswanto' => 'Deep Learning, LSTM-Transformer & Prediksi Kecelakaan Lalu Lintas',
            'Reza Yoga Anindita' => 'Rute Angkutan Bahan Berbahaya (B3) & Logika Fuzzy',
            'Ery Muthoriq' => 'Side Slip Tester & Alat Uji Kelaikan Kendaraan',
            'Rizal Aprianto' => 'Tata Ruang Transportasi, Jalan Tol & Keselamatan Geometrik Simpang',
            'Anton Budiharjo' => 'Manajemen Angkutan Massal, Terminal Penumpang & Andalalin',
            'Naomi Srie Kusumastutie' => 'Keselamatan Pengendara Sepeda Motor & Perilaku Pengemudi',
            'Arief Novianto' => 'Analisis Tabrakan Depan-Belakang & Keparahan Kerusakan Kendaraan',
            'Muhammad Reza Artha' => 'Inspeksi Keselamatan Jalan & Audit Kelaikan Prasarana',
        ];

        // 1. Sinkronisasi Data Kegiatan Penelitian (56 records multi-tahun)
        $this->info('1. Menyinkronkan kegiatan penelitian...');
        $researchesCreated = 0;
        $researchesUpdated = 0;

        foreach ($researchItems as $idx => $item) {
            $ketua = trim($item['ketua_peneliti']);
            $prodiCode = $item['prodi_code'] ?? 'RSTJ';
            $prodi = $prodis->get($prodiCode) ?? $prodis->first();

            // Akun User Dosen Ketua
            $email = Str::slug($ketua, '.').'@pktj.ac.id';
            $nidnNip = '06'.str_pad((string) (100000 + $idx + 1), 8, '0', STR_PAD_LEFT);

            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $ketua,
                    'password' => $defaultPasswordHash,
                    'role' => 'dosen',
                    'roles' => ['dosen'],
                    'prodi_id' => $prodi?->id,
                    'nidn_nip' => $nidnNip,
                    'keahlian' => $keahlianMap[$ketua] ?? 'Keselamatan Transportasi Jalan & Rekayasa Vokasi',
                    'status_aktif' => true,
                ]
            );

            // Cari penelitian berdasarkan kode atau judul yang dinormalisasi
            $normalizedTitle = $this->normalizeString($item['judul']);
            $existing = Research::where('kode_penelitian', $item['kode_penelitian'])
                ->orWhere(function ($q) use ($item) {
                    $q->where('judul', $item['judul']);
                })
                ->first();

            if (! $existing) {
                // Pencocokan fuzzy berbasis judul normal
                $candidates = Research::where('tahun', $item['tahun'])->get();
                foreach ($candidates as $cand) {
                    if ($this->normalizeString($cand->judul) === $normalizedTitle) {
                        $existing = $cand;
                        break;
                    }
                }
            }

            $payload = [
                'kode_penelitian' => $item['kode_penelitian'],
                'judul' => $item['judul'],
                'prodi_id' => $prodi?->id,
                'user_id' => $user->id,
                'ketua_peneliti' => $ketua,
                'anggota' => $item['anggota'] ?: null,
                'tahun' => (string) $item['tahun'],
                'skema' => $item['skema'] ?? 'Penelitian Terapan Vokasi',
                'sumber_dana' => $item['sumber_dana'] ?? 'PT / Mandiri',
                'anggaran' => (float) ($item['anggaran'] ?? 0),
                'target_luaran' => $item['target_luaran'] ?: null,
                'relevansi_prodi' => $item['relevansi_prodi'] ?: null,
                'status' => (strtolower((string) ($item['status'] ?? '')) === 'selesai') ? 'Selesai' : 'Berjalan',
            ];

            if ($existing) {
                $existing->update($payload);
                $researchesUpdated++;
            } else {
                $payload['abstrak'] = 'Kegiatan riset terapan terintegrasi program studi vokasi bidang keselamatan transportasi jalan PKTJ.';
                Research::create($payload);
                $researchesCreated++;
            }
        }

        $this->info("   Selesai: {$researchesUpdated} diperbarui, {$researchesCreated} ditambahkan. Total sekarang: ".Research::count());

        // 2. Sinkronisasi Data Pengabdian kepada Masyarakat (PkM)
        $this->info('2. Menyinkronkan data Pengabdian kepada Masyarakat (PkM)...');
        $pkmUpdated = 0;

        foreach ($pkmItems as $pkmItem) {
            $normPkmTitle = $this->normalizeString($pkmItem['judul']);
            $existingCs = CommunityService::where('kode_pkm', $pkmItem['kode_pkm'])
                ->orWhere('judul', $pkmItem['judul'])
                ->first();

            if (! $existingCs) {
                $candidates = CommunityService::all();
                foreach ($candidates as $cand) {
                    if ($this->normalizeString($cand->judul) === $normPkmTitle) {
                        $existingCs = $cand;
                        break;
                    }
                }
            }

            if ($existingCs) {
                $existingCs->update([
                    'kode_pkm' => $pkmItem['kode_pkm'],
                    'relevansi_prodi' => $pkmItem['relevansi_prodi'] ?: null,
                ]);
                $pkmUpdated++;
            }
        }

        $this->info("   Selesai: {$pkmUpdated} kegiatan PkM diperkaya dengan kode dan relevansi prodi. Total PkM: ".CommunityService::count());

        // 3. Sinkronisasi Luaran Riset Berstatus 'Published'
        $this->info('3. Menyinkronkan luaran publikasi sah...');
        $outputsAdded = 0;

        foreach ($publishedOutputs as $pub) {
            $normPubTitle = $this->normalizeString($pub['judul']);
            $existingOutput = Output::where('judul', $pub['judul'])->first();

            if (! $existingOutput) {
                $candidates = Output::where('tahun', $pub['tahun'])->get();
                foreach ($candidates as $cand) {
                    if ($this->normalizeString($cand->judul) === $normPubTitle) {
                        $existingOutput = $cand;
                        break;
                    }
                }
            }

            if (! $existingOutput) {
                // Temukan research terkait untuk mendapatkan user dan prodi
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
                $outputsAdded++;
            }
        }

        $this->info("   Selesai: {$outputsAdded} luaran publikasi baru disinkronkan. Total Luaran: ".Output::count());
        $this->info('Sinkronisasi master data P3M PKTJ berhasil diselesaikan dengan sukses.');

        return Command::SUCCESS;
    }

    /**
     * Normalisasi string untuk perbandingan toleran.
     */
    private function normalizeString(string $str): string
    {
        $cleaned = preg_replace('/[^a-zA-Z0-9\s]/', '', strtolower($str));
        $cleaned = str_replace('metode', '', (string) $cleaned);

        return trim(preg_replace('/\s+/', ' ', (string) $cleaned));
    }
}
