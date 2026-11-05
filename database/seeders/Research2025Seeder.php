<?php

namespace Database\Seeders;

use App\Models\Prodi;
use App\Models\Research;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Research2025Seeder extends Seeder
{
    /**
     * Jalankan seeder data master penelitian multi-tahun (2025-2027) dari berkas Excel sah P3M PKTJ.
     */
    public function run(): void
    {
        $masterJsonPath = database_path('seeders/research_master_data.json');
        $fallbackJsonPath = database_path('seeders/research_2025_data.json');

        if (! File::exists($masterJsonPath) && ! File::exists($fallbackJsonPath)) {
            $this->command?->error('Berkas data penelitian master tidak ditemukan.');

            return;
        }

        $items = File::exists($masterJsonPath)
            ? json_decode(File::get($masterJsonPath), true)
            : json_decode(File::get($fallbackJsonPath), true);

        if (empty($items)) {
            $this->command?->error('Data penelitian master kosong.');

            return;
        }

        // Peta data pendukung (abstrak dan nama file laporan) dari dataset awal 2025
        $abstrakMap = [];
        $berkasMap = [];
        if (File::exists($fallbackJsonPath)) {
            $orig2025 = json_decode(File::get($fallbackJsonPath), true);
            foreach ($orig2025 as $o) {
                $norm = $this->normalizeString($o['judul']);
                $abstrakMap[$norm] = $o['abstrak'] ?? null;
                $berkasMap[$norm] = $o['berkas_laporan'] ?? null;
            }
        }

        $prodis = Prodi::all()->keyBy('kode_prodi');

        // 1. Bersihkan data penelitian master atau 2025 sebelumnya
        Research::where('tahun', 2025)->delete();
        Research::whereNotNull('kode_penelitian')->delete();

        // 2. Kumpulan pemetaan keahlian dosen ketua peneliti
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

        // 3. Masukkan 56 data penelitian riil dari master Excel P3M PKTJ
        $defaultPasswordHash = Hash::make('password');
        $importedCount = 0;

        foreach ($items as $idx => $item) {
            $ketua = trim($item['ketua_peneliti'] ?? ($item['ketua'] ?? 'Tim Peneliti PKTJ'));
            $prodiCode = $item['prodi_code'] ?? 'RSTJ';
            $prodi = $prodis->get($prodiCode) ?? $prodis->first();

            // Sinkronkan akun user dosen internal
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

            if ($user->prodi_id !== $prodi?->id || ! $user->status_aktif) {
                $user->update([
                    'prodi_id' => $prodi?->id,
                    'status_aktif' => true,
                ]);
            }

            $normTitle = $this->normalizeString($item['judul']);
            $abstrak = $item['abstrak'] ?? ($abstrakMap[$normTitle] ?? ('Kegiatan penelitian terapan vokasi program studi '.$prodiCode.' bidang keselamatan transportasi jalan PKTJ.'));
            $berkas = $item['berkas_laporan'] ?? ($berkasMap[$normTitle] ?? ('Laporan Penelitian '.$ketua.'.pdf'));
            $statusVal = strtolower((string) ($item['status'] ?? '')) === 'selesai' ? 'Selesai' : 'Berjalan';

            Research::create([
                'kode_penelitian' => $item['kode_penelitian'] ?? null,
                'judul' => $item['judul'],
                'abstrak' => $abstrak,
                'prodi_id' => $prodi?->id,
                'user_id' => $user->id,
                'ketua_peneliti' => $ketua,
                'anggota' => $item['anggota'] ?: null,
                'tahun' => (string) ($item['tahun'] ?? 2025),
                'skema' => $item['skema'] ?? 'Penelitian Terapan Vokasi',
                'sumber_dana' => $item['sumber_dana'] ?? 'PT / Mandiri',
                'anggaran' => (float) ($item['anggaran'] ?? 0),
                'berkas_laporan' => $berkas,
                'target_luaran' => $item['target_luaran'] ?? null,
                'relevansi_prodi' => $item['relevansi_prodi'] ?? null,
                'status' => $statusVal,
            ]);

            $importedCount++;
        }

        $this->command?->info("Sukses menyinkronkan {$importedCount} data kegiatan penelitian riil dari master Excel.");
    }

    private function normalizeString(string $str): string
    {
        $cleaned = preg_replace('/[^a-zA-Z0-9\s]/', '', strtolower($str));
        $cleaned = str_replace('metode', '', (string) $cleaned);

        return trim(preg_replace('/\s+/', ' ', (string) $cleaned));
    }
}
