<?php

namespace Database\Seeders;

use App\Models\Collaboration;
use App\Models\Prodi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class CollaborationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prodiRstj = Prodi::where('kode_prodi', 'RSTJ')->first();
        $prodiTro = Prodi::where('kode_prodi', 'TRO')->first();
        $prodiTo = Prodi::where('kode_prodi', 'TO')->first();

        // Siapkan folder storage dan dummy PDF
        Storage::disk('public')->makeDirectory('collaborations');
        $dummyPdfContent = "%PDF-1.4\n1 0 obj<</Type/Catalog/Pages 2 0 R>>endobj 2 0 obj<</Type/Pages/Kids[3 0 R]/Count 1>>endobj 3 0 obj<</Type/Page/MediaBox[0 0 595 842]/Parent 2 0 R/Resources<<>>>>endobj\nxref\n0 4\n0000000000 65535 f\n0000000009 00000 n\n0000000052 00000 n\n0000000098 00000 n\ntrailer<</Size 4/Root 1 0 R>>\nstartxref\n178\n%%EOF";

        $collaborations = [
            [
                'nama_mitra' => 'Korps Lalu Lintas (Korlantas) Polri',
                'judul_kerjasama' => 'Pemetaan Spasial Daerah Rawan Kecelakaan (Black Spot) & Audit Geometri Jalan Koridor Pantura',
                'jenis_kegiatan' => 'penelitian',
                'kategori_mitra' => 'pemerintah',
                'prodi_id' => $prodiRstj?->id,
                'nomor_mou_pks' => 'MoU/08/KORLANTAS-PKTJ/2026',
                'tahun' => 2026,
                'status_kerjasama' => 'aktif',
                'deskripsi' => 'Kerjasama strategis pertukaran data kecelakaan IRSMS Korlantas Polri dan penelitian rekayasa geometrik simpang untuk merumuskan intervensi keselamatan di jalur logistik Pantura.',
                'tanggal_mulai' => '2026-01-15',
                'tanggal_berakhir' => '2028-12-31',
                'file_dokumen' => 'collaborations/mou_korlantas_blackspot_2026.pdf',
            ],
            [
                'nama_mitra' => 'Direktorat Jenderal Perhubungan Darat, Kemenhub',
                'judul_kerjasama' => 'Kajian Standarisasi Desain Geometri Jalur Penyelamat Darurat pada Ruas Jalan Turunan Curam Nasional',
                'jenis_kegiatan' => 'penelitian',
                'kategori_mitra' => 'pemerintah',
                'prodi_id' => $prodiRstj?->id,
                'nomor_mou_pks' => 'PKS/HUBDAT/PKTJ/IV/2025/012',
                'tahun' => 2025,
                'status_kerjasama' => 'aktif',
                'deskripsi' => 'Penyusunan naskah rekomendasi teknis material gravel bed arrester dan sudut elevasi jalur penyelamat darurat (emergency escape ramp) untuk mencegah fatalitas rem blong armada angkutan barang.',
                'tanggal_mulai' => '2025-04-10',
                'tanggal_berakhir' => '2027-04-10',
                'file_dokumen' => 'collaborations/pks_hubdat_jalur_penyelamat_2025.pdf',
            ],
            [
                'nama_mitra' => 'PT Hino Motors Manufacturing Indonesia',
                'judul_kerjasama' => 'Riset Terapan Purwarupa Perangkat Peringatan Titik Buta (Blind Spot Monitoring) Truk Logistik Berat',
                'jenis_kegiatan' => 'penelitian',
                'kategori_mitra' => 'industri',
                'prodi_id' => $prodiTro?->id,
                'nomor_mou_pks' => 'HMMI-CSR-PKTJ/MOU/2026/05',
                'tahun' => 2026,
                'status_kerjasama' => 'aktif',
                'deskripsi' => 'Pengembangan inovasi sensor ultrasonik dan modul kamera pendeteksi kendaraan roda dua di sisi kiri truk angkutan peti kemas, mencakup uji lapang dinamis di fasilitas proving ground mitra.',
                'tanggal_mulai' => '2026-02-01',
                'tanggal_berakhir' => '2027-01-31',
                'file_dokumen' => 'collaborations/mou_hino_blindspot_2026.pdf',
            ],
            [
                'nama_mitra' => 'Perum DAMRI (Kantor Pusat)',
                'judul_kerjasama' => 'Uji Coba Lapangan Sistem Deteksi Kelelahan Pengemudi (Driver Drowsiness Detector) Bus Antarkota',
                'jenis_kegiatan' => 'penelitian',
                'kategori_mitra' => 'bumn',
                'prodi_id' => $prodiTro?->id,
                'nomor_mou_pks' => 'MoU-DAMRI/DIRUT/PKTJ/2025/08',
                'tahun' => 2025,
                'status_kerjasama' => 'selesai',
                'deskripsi' => 'Implementasi algoritma computer vision pengenal kedipan mata dan gerakan kepala pada 15 armada bus AKAP rute trans Jawa untuk mencegah kecelakaan fatal akibat fenomena microsleep.',
                'tanggal_mulai' => '2025-01-10',
                'tanggal_berakhir' => '2025-12-31',
                'file_dokumen' => 'collaborations/mou_damri_drowsiness_2025.pdf',
            ],
            [
                'nama_mitra' => 'PT Pertamina Patra Niaga Regional Jawa Bagian Tengah',
                'judul_kerjasama' => 'Implementasi Modul Speed Limiter & Telemetri Cerdas pada Mobil Tangki BBM Lintasan Ekstrem',
                'jenis_kegiatan' => 'keduanya',
                'kategori_mitra' => 'bumn',
                'prodi_id' => $prodiTro?->id,
                'nomor_mou_pks' => 'PKS/PPN-JBT/P3M-PKTJ/2026/021',
                'tahun' => 2026,
                'status_kerjasama' => 'aktif',
                'deskripsi' => 'Pemasangan purwarupa limiter kecepatan otomatis terintegrasi geofencing pada armada mobil tangki distribusi BBM di wilayah pegunungan Jawa Tengah guna menjamin aspek HSSE transportasi.',
                'tanggal_mulai' => '2026-03-01',
                'tanggal_berakhir' => '2027-02-28',
                'file_dokumen' => 'collaborations/pks_pertamina_speedlimiter_2026.pdf',
            ],
            [
                'nama_mitra' => 'Balai Pengujian Laik Jalan & Sertifikasi Kendaraan Bermotor (BPLJSKB)',
                'judul_kerjasama' => 'Verifikasi Karakteristik Emisi Gas Buang Kendaraan Niaga Berbahan Bakar Biodiesel B35 & B40',
                'jenis_kegiatan' => 'penelitian',
                'kategori_mitra' => 'pemerintah',
                'prodi_id' => $prodiTo?->id,
                'nomor_mou_pks' => 'MoU.04/BPLJSKB/PKTJ/2025',
                'tahun' => 2025,
                'status_kerjasama' => 'selesai',
                'deskripsi' => 'Pengujian komprehensif opasitas gas buang dan konsumsi bahan bakar mesin diesel pada laboratorium dyno test PKTJ dan fasilitas uji emisi kelaikan jalan nasional.',
                'tanggal_mulai' => '2025-05-01',
                'tanggal_berakhir' => '2025-11-30',
                'file_dokumen' => 'collaborations/mou_bpljskb_emisi_2025.pdf',
            ],
            [
                'nama_mitra' => 'Institut Teknologi Bandung (SAPPK ITB)',
                'judul_kerjasama' => 'Riset Pemodelan Perilaku Pengemudi dan Efektivitas Fasilitas Penenang Lalu Lintas (Traffic Calming)',
                'jenis_kegiatan' => 'penelitian',
                'kategori_mitra' => 'perguruan_tinggi',
                'prodi_id' => $prodiRstj?->id,
                'nomor_mou_pks' => 'MoU/ITB-SAPPK/PKTJ/2024/09',
                'tahun' => 2024,
                'status_kerjasama' => 'selesai',
                'deskripsi' => 'Kolaborasi riset akademik dalam pengukuran kecepatan sesaat dan dampak visual rumble strip terhadap penurunan angka tabrakan di kawasan zona selamat sekolah.',
                'tanggal_mulai' => '2024-02-15',
                'tanggal_berakhir' => '2024-12-15',
                'file_dokumen' => 'collaborations/mou_itb_traffic_calming_2024.pdf',
            ],
            [
                'nama_mitra' => 'Asosiasi Industri Sepeda Motor Listrik Indonesia (AISMOLI)',
                'judul_kerjasama' => 'Penyusunan Pedoman Uji Kelaikan Teknis Konversi Sepeda Motor Listrik Standar Vokasi',
                'jenis_kegiatan' => 'penelitian',
                'kategori_mitra' => 'industri',
                'prodi_id' => $prodiTo?->id,
                'nomor_mou_pks' => 'MoU/AISMOLI-PKTJ/2026/014',
                'tahun' => 2026,
                'status_kerjasama' => 'aktif',
                'deskripsi' => 'Rancang bangun kit konversi motor listrik aman bersertifikasi, pelatihan standardisasi uji pengereman mekanik bengkel konversi, dan transfer teknologi baterai manajemen sistem.',
                'tanggal_mulai' => '2026-01-20',
                'tanggal_berakhir' => '2027-01-20',
                'file_dokumen' => 'collaborations/mou_aismoli_konversi_2026.pdf',
            ],
            // Data Kerjasama Pengabdian kepada Masyarakat (PkM)
            [
                'nama_mitra' => 'Dinas Perhubungan Kota Tegal',
                'judul_kerjasama' => 'Pendampingan Program Desa Binaan Tanggap Keselamatan Lalu Lintas dan Penataan Rambu Zonasi Sekolah',
                'jenis_kegiatan' => 'pengabdian',
                'kategori_mitra' => 'pemerintah',
                'prodi_id' => $prodiRstj?->id,
                'nomor_mou_pks' => 'MoU/03/DISHUB-TEGAL/PKTJ/2026',
                'tahun' => 2026,
                'status_kerjasama' => 'aktif',
                'deskripsi' => 'Kolaborasi pengabdian masyarakat pendampingan desa binaan keselamatan, perancangan marka penyeberangan anak sekolah, dan edukasi keselamatan jalan bagi kader kelurahan se-Kota Tegal.',
                'tanggal_mulai' => '2026-01-10',
                'tanggal_berakhir' => '2027-01-09',
                'file_dokumen' => 'collaborations/mou_dishub_tegal_pkm_2026.pdf',
            ],
            [
                'nama_mitra' => 'PT Kereta Api Indonesia (Persero) Daop 4 Semarang',
                'judul_kerjasama' => 'Sosialisasi Keselamatan dan Rekayasa Perlengkapan Early Warning System di Perlintasan Sebidang',
                'jenis_kegiatan' => 'pengabdian',
                'kategori_mitra' => 'bumn',
                'prodi_id' => $prodiRstj?->id,
                'nomor_mou_pks' => 'PKS/KAI-DAOP4/PKTJ-PKM/2026/09',
                'tahun' => 2026,
                'status_kerjasama' => 'aktif',
                'deskripsi' => 'Aksi pengabdian keselamatan transportasi berupa pemasangan sirine peringatan dini swadaya dan edukasi masyarakat pengguna jalan di 6 perlintasan sebidang tanpa palang pintu wilayah pantura barat.',
                'tanggal_mulai' => '2026-02-15',
                'tanggal_berakhir' => '2026-12-31',
                'file_dokumen' => 'collaborations/pks_kai_perlintasan_pkm_2026.pdf',
            ],
            [
                'nama_mitra' => 'Asosiasi Bengkel Kendaraan Roda Dua Kota Tegal',
                'judul_kerjasama' => 'Pelatihan Alih Teknologi dan Sertifikasi Mandiri Kalibrasi Alat Uji Opasitas Emisi Gas Buang Sepeda Motor',
                'jenis_kegiatan' => 'pengabdian',
                'kategori_mitra' => 'industri',
                'prodi_id' => $prodiTo?->id,
                'nomor_mou_pks' => 'MoU/ABK-TEGAL/PKTJ/2026/011',
                'tahun' => 2026,
                'status_kerjasama' => 'aktif',
                'deskripsi' => 'Transfer pengetahuan teknologi alat uji emisi portabel karya sivitas akademika PKTJ kepada 35 teknisi bengkel rakyat demi menurunkan tingkat polusi udara perkotaan.',
                'tanggal_mulai' => '2026-03-01',
                'tanggal_berakhir' => '2027-02-28',
                'file_dokumen' => 'collaborations/mou_bengkel_tegal_emisi_2026.pdf',
            ],
            [
                'nama_mitra' => 'Paguyuban Pengemudi Truk Angkutan Logistik Pantura',
                'judul_kerjasama' => 'Bimbingan Teknis Standarisasi Pemeriksaan Harian Sistem Rem Udara dan Mitigasi Rem Blong Truk Logistik',
                'jenis_kegiatan' => 'pengabdian',
                'kategori_mitra' => 'lainnya',
                'prodi_id' => $prodiTro?->id,
                'nomor_mou_pks' => 'MoU/PAGUYUBAN-TRUK/PKTJ/2025/017',
                'tahun' => 2025,
                'status_kerjasama' => 'selesai',
                'deskripsi' => 'Penyuluhan dan simulasi langsung perbaikan katup pengatur angin rem tromol truk angkutan barang berat bagi 80 pengemudi logistik rute Semarang-Cirebon.',
                'tanggal_mulai' => '2025-03-10',
                'tanggal_berakhir' => '2025-11-30',
                'file_dokumen' => 'collaborations/mou_sopir_truk_rem_2025.pdf',
            ],
            [
                'nama_mitra' => 'Dinas Pendidikan dan Kebudayaan Kabupaten Brebes',
                'judul_kerjasama' => 'Edukasi Budaya Tertib Lalu Lintas dan Diseminasi Model Zona Selamat Sekolah (ZoSS) bagi Guru dan Pelajar',
                'jenis_kegiatan' => 'pengabdian',
                'kategori_mitra' => 'pemerintah',
                'prodi_id' => $prodiRstj?->id,
                'nomor_mou_pks' => 'PKS/DISDIK-BREBES/PKTJ/2025/022',
                'tahun' => 2025,
                'status_kerjasama' => 'selesai',
                'deskripsi' => 'Pelaksanaan program sosialisasi helm standar SNI, pembagian panduan penyeberangan aman, dan peremajaan marka karpet merah ZoSS di 10 sekolah tepian jalan nasional.',
                'tanggal_mulai' => '2025-06-01',
                'tanggal_berakhir' => '2025-12-15',
                'file_dokumen' => 'collaborations/pks_disdik_brebes_zoss_2025.pdf',
            ],
            [
                'nama_mitra' => 'Perum DAMRI Cabang Purwokerto',
                'judul_kerjasama' => 'Workshop Ergonomi Berkendara dan Manajemen Istirahat Awak Bus AKAP guna Pencegahan Microsleep',
                'jenis_kegiatan' => 'pengabdian',
                'kategori_mitra' => 'bumn',
                'prodi_id' => $prodiTro?->id,
                'nomor_mou_pks' => 'PKS/DAMRI-PWT/PKTJ/2025/031',
                'tahun' => 2025,
                'status_kerjasama' => 'selesai',
                'deskripsi' => 'Pelatihan penanganan kelelahan pengemudi bus antar kota antar provinsi, panduan pemeriksaan tekanan ban, dan pengecekan emisi gas buang berkala di pool DAMRI Purwokerto.',
                'tanggal_mulai' => '2025-04-05',
                'tanggal_berakhir' => '2025-10-31',
                'file_dokumen' => 'collaborations/pks_damri_purwokerto_microsleep_2025.pdf',
            ],
            [
                'nama_mitra' => 'Dewan Pengurus Cabang Organda Kota Tegal',
                'judul_kerjasama' => 'Pendampingan Teknis Standardisasi Dimensi Bak Muatan dan Sertifikasi Uji Kelaikan Angkutan Perkotaan',
                'jenis_kegiatan' => 'pengabdian',
                'kategori_mitra' => 'industri',
                'prodi_id' => $prodiTo?->id,
                'nomor_mou_pks' => 'MoU/ORGANDA-TEGAL/PKTJ/2024/005',
                'tahun' => 2024,
                'status_kerjasama' => 'selesai',
                'deskripsi' => 'Bimbingan teknis uji kir gratis, verifikasi dimensi batas aman armada angkot, dan perbaikan sistem penerangan kendaraan guna meningkatkan keselamatan penumpang.',
                'tanggal_mulai' => '2024-03-01',
                'tanggal_berakhir' => '2024-11-20',
                'file_dokumen' => 'collaborations/mou_organda_kelaikan_2024.pdf',
            ],
        ];

        foreach ($collaborations as $col) {
            // Tulis dummy PDF jika belum ada
            if ($col['file_dokumen'] && ! Storage::disk('public')->exists($col['file_dokumen'])) {
                Storage::disk('public')->put($col['file_dokumen'], $dummyPdfContent);
            }

            Collaboration::updateOrCreate(
                ['nomor_mou_pks' => $col['nomor_mou_pks']],
                $col
            );
        }
    }
}
