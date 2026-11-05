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
     * Jalankan seeder data riil penelitian tahun 2025 dari berkas Excel P3M PKTJ.
     */
    public function run(): void
    {
        $jsonPath = database_path('seeders/research_2025_data.json');
        if (! File::exists($jsonPath)) {
            $this->command?->error('Berkas data research_2025_data.json tidak ditemukan.');

            return;
        }

        $items = json_decode(File::get($jsonPath), true);
        if (empty($items)) {
            $this->command?->error('Data research_2025_data.json kosong.');

            return;
        }

        $prodis = Prodi::all()->keyBy('kode_prodi');

        // 1. Bersihkan data penelitian dummy tahun 2025 (pertahankan riwayat tahun lainnya)
        Research::where('tahun', 2025)->delete();

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

        // 3. Masukkan 27 data penelitian riil tahun 2025
        $defaultPasswordHash = Hash::make('password');
        $importedCount = 0;
        foreach ($items as $idx => $item) {
            $ketua = trim($item['ketua']);
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

            // Jika user sudah ada tapi belum punya prodi/nama lengkap, update
            if ($user->prodi_id !== $prodi?->id || ! $user->status_aktif) {
                $user->update([
                    'prodi_id' => $prodi?->id,
                    'status_aktif' => true,
                ]);
            }

            // Simpan kegiatan penelitian
            Research::create([
                'judul' => $item['judul'],
                'abstrak' => $item['abstrak'],
                'prodi_id' => $prodi?->id,
                'user_id' => $user->id,
                'ketua_peneliti' => $ketua,
                'anggota' => $item['anggota'] ?: null,
                'tahun' => 2025,
                'skema' => 'Penelitian Terapan Vokasi',
                'sumber_dana' => $item['sumber_dana'],
                'anggaran' => 0, // Sesuai arahan: diisi 0 jika tidak tercantum angka spesifik di sheet Excel
                'berkas_laporan' => $item['berkas_laporan'] ?: null,
                'status' => 'Selesai',
            ]);

            $importedCount++;
        }

        $this->command?->info("Sukses menyinkronkan {$importedCount} data kegiatan penelitian riil tahun 2025.");
    }
}
