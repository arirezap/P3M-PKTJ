<?php

namespace Database\Seeders;

use App\Models\CommunityService;
use App\Models\CommunityServiceOutput;
use App\Models\Prodi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class Pkm2025Seeder extends Seeder
{
    /**
     * Jalankan seeder data riil Pengabdian kepada Masyarakat (PkM) tahun 2025
     * (Sheet Pengabdian & PkM_Pokja Diklat) beserta capaian luarannya dari berkas Excel P3M PKTJ.
     */
    public function run(): void
    {
        $jsonPath = database_path('seeders/pkm_2025_data.json');
        if (! File::exists($jsonPath)) {
            $this->command?->error('Berkas data pkm_2025_data.json tidak ditemukan.');

            return;
        }

        $payload = json_decode(File::get($jsonPath), true);
        $servicesData = $payload['services'] ?? [];
        $outputsData = $payload['outputs'] ?? [];

        if (empty($servicesData)) {
            $this->command?->error('Data pkm_2025_data.json kosong.');

            return;
        }

        $prodis = Prodi::all()->keyBy('kode_prodi');

        // 1. Bersihkan data PkM & Luaran PkM dummy tahun 2025 (pertahankan tahun lainnya)
        CommunityServiceOutput::where('tahun', 2025)->delete();
        CommunityService::where('tahun', 2025)->delete();

        // 2. Masukkan 74 data kegiatan PkM 2025 (14 Pengabdian + 60 Diklat) secara idempoten
        $now = now();
        $serviceBatch = [];
        $seenTitles = [];

        foreach ($servicesData as $item) {
            $dedupKey = strtolower(trim($item['judul']));
            if (isset($seenTitles[$dedupKey])) {
                continue;
            }
            $seenTitles[$dedupKey] = true;

            $prodiCode = $item['prodi_code'] ?? 'RSTJ';
            $prodi = $prodis->get($prodiCode) ?? $prodis->first();

            $serviceBatch[] = [
                'judul' => $item['judul'],
                'ringkasan' => $item['ringkasan'] ?? null,
                'prodi_id' => $prodi?->id,
                'ketua_pelaksana' => $item['ketua_pelaksana'] ?? 'Tim Dosen P3M PKTJ',
                'anggota' => $item['anggota'] ?? null,
                'tahun' => (int) ($item['tahun'] ?? 2025),
                'skema' => $item['skema'] ?? 'Pengabdian kepada Masyarakat',
                'jenis_diklat' => $item['jenis_diklat'] ?? null,
                'angkatan' => $item['angkatan'] ?? null,
                'kategori_peserta' => $item['kategori_peserta'] ?? null,
                'mitra' => $item['mitra'] ?? null,
                'lokasi_kegiatan' => $item['lokasi_kegiatan'] ?? null,
                'waktu_pelaksanaan' => $item['waktu_pelaksanaan'] ?? null,
                'target_peserta' => $item['target_peserta'] ?? 0,
                'realisasi_peserta' => $item['realisasi_peserta'] ?? 0,
                'peserta_l' => $item['peserta_l'] ?? null,
                'peserta_p' => $item['peserta_p'] ?? null,
                'sumber_dana' => $item['sumber_dana'] ?? 'Internal (DIPA PKTJ)',
                'anggaran' => 0,
                'berkas_laporan' => $item['berkas_laporan'] ?? null,
                'link_foto' => $item['link_foto'] ?? null,
                'link_laporan' => $item['link_laporan'] ?? null,
                'status' => $item['status'] ?? 'Selesai',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        foreach (array_chunk($serviceBatch, 50) as $chunk) {
            CommunityService::insert($chunk);
        }

        // 3. Petakan ID kegiatan PkM 2025 untuk dihubungkan ke community_service_outputs
        $serviceMap = CommunityService::where('tahun', 2025)->pluck('id', 'judul');
        $outputBatch = [];
        $seenOutputTitles = [];

        foreach ($outputsData as $out) {
            $dedupOutKey = strtolower(trim($out['judul']));
            if (isset($seenOutputTitles[$dedupOutKey])) {
                continue;
            }
            $seenOutputTitles[$dedupOutKey] = true;

            $prodiCode = $out['prodi_code'] ?? 'RSTJ';
            $prodi = $prodis->get($prodiCode) ?? $prodis->first();
            $serviceId = $serviceMap->get($out['service_judul'] ?? '') ?? null;

            $outputBatch[] = [
                'kategori' => $out['kategori'] ?? 'desa_binaan',
                'judul' => $out['judul'],
                'community_service_id' => $serviceId,
                'prodi_id' => $prodi?->id,
                'user_id' => null,
                'pelaksana' => $out['pelaksana'] ?? 'Tim Dosen P3M PKTJ',
                'tahun' => (int) ($out['tahun'] ?? 2025),
                'mitra_sasaran' => $out['mitra_sasaran'] ?? null,
                'lokasi' => $out['lokasi'] ?? null,
                'deskripsi_manfaat' => $out['deskripsi_manfaat'] ?? null,
                'indikator_keberhasilan' => $out['indikator_keberhasilan'] ?? null,
                'tingkat_kepuasan_mitra' => $out['tingkat_kepuasan_mitra'] ?? '95% (Sangat Baik)',
                'link_dokumen' => $out['link_dokumen'] ?? null,
                'berkas_luaran' => $out['berkas_luaran'] ?? null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        foreach (array_chunk($outputBatch, 50) as $chunk) {
            CommunityServiceOutput::insert($chunk);
        }

        $serviceCount = count($serviceBatch);
        $outputCount = count($outputBatch);
        $this->command?->info("Sukses menyinkronkan {$serviceCount} kegiatan PkM 2025 dan {$outputCount} capaian luaran PkM 2025.");
    }
}

