<?php

namespace Database\Seeders;

use App\Models\CommunityService;
use App\Models\CommunityServiceOutput;
use App\Models\Document;
use App\Models\Output;
use App\Models\Post;
use App\Models\Prodi;
use App\Models\Research;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Jalankan Seeder Prodi, Pengguna, Struktur Organisasi & Kerjasama Riset
        $this->call([
            ProdiSeeder::class,
            UserSeeder::class,
            OrganizationMemberSeeder::class,
            CollaborationSeeder::class,
        ]);

        $admin = User::where('role', 'admin')->first();
        $prodiRstj = Prodi::where('kode_prodi', 'RSTJ')->first();
        $prodiTro = Prodi::where('kode_prodi', 'TRO')->first();
        $prodiTo = Prodi::where('kode_prodi', 'TO')->first();

        $dosenHendro = User::where('email', 'dosen@pktj.ac.id')->first();
        $dosenBambang = User::where('email', 'reviewer@pktj.ac.id')->first();
        $dosenBudi = User::where('email', 'budi.santoso@pktj.ac.id')->first();
        $dosenSiti = User::where('email', 'siti.rahmawati@pktj.ac.id')->first();
        $dosenAgus = User::where('email', 'agus.setiawan@pktj.ac.id')->first();
        $dosenWahyu = User::where('email', 'wahyu.nugroho@pktj.ac.id')->first();

        // 2. Data Awal Berita & Pengumuman
        $posts = [
            [
                'judul' => 'Sosialisasi Panduan Call for Proposals Penelitian & Pengabdian PKTJ Tahun Anggaran 2026',
                'slug' => 'sosialisasi-panduan-call-for-proposals-2026',
                'kategori' => 'pengumuman',
                'ringkasan' => 'Pusat Penelitian dan Pengabdian kepada Masyarakat (P3M) mengumumkan pembukaan periode pengajuan usulan hibah DIPA institusi.',
                'konten' => 'Dalam rangka meningkatkan mutu luaran riset terapan dan hilirisasi produk keselamatan transportasi jalan, P3M PKTJ membuka penerimaan proposal penelitian dan pengabdian kepada masyarakat untuk Tahun Anggaran 2026. Batas akhir pengajuan usulan melalui sistem SIM P3M adalah 30 April 2026.',
                'gambar_sampul' => null,
                'user_id' => $admin ? $admin->id : null,
                'status' => 'published',
                'tanggal_publikasi' => now(),
                'is_pinned' => true,
            ],
            [
                'judul' => 'Diseminasi Hasil Riset Prototipe Sensor Blind Spot Monitoring Kendaraan Berat di Jalur Logistik',
                'slug' => 'diseminasi-hasil-riset-sensor-blind-spot-kendaraan-berat',
                'kategori' => 'berita',
                'ringkasan' => 'Dosen Prodi D4 TRO memaparkan inovasi perangkat keselamatan aktif pendeteksi titik buta pada armada bus dan truk.',
                'konten' => 'Uji lapang sistem peringatan dini berbasis sensor ultrasonik dan pemrosesan citra digital berhasil membuktikan peningkatan kewaspadaan pengemudi saat bermanuver di jalan arteri sempit Pantura.',
                'gambar_sampul' => null,
                'user_id' => $admin ? $admin->id : null,
                'status' => 'published',
                'tanggal_publikasi' => now()->subDays(3),
                'is_pinned' => false,
            ],
            [
                'judul' => 'Workshop Penyusunan Proposal Berstandar SINTA & Paten Sederhana Bagi Dosen Vokasi',
                'slug' => 'workshop-penyusunan-proposal-berstandar-sinta-dan-paten',
                'kategori' => 'agenda',
                'ringkasan' => 'Pelatihan intensif penulisan manuskrip ilmiah bereputasi dan pendaftaran Hak Kekayaan Intelektual bagi seluruh civitas akademika.',
                'konten' => 'Kegiatan diselenggarakan pada Ruang Rapat P3M Lt. 2 Kampus PKTJ Tegal menghadirkan narasumber reviewer nasional Kemdiktisaintek.',
                'gambar_sampul' => null,
                'user_id' => $admin ? $admin->id : null,
                'status' => 'published',
                'tanggal_publikasi' => now()->addDays(5),
                'is_pinned' => false,
            ],
        ];

        foreach ($posts as $post) {
            Post::updateOrCreate(['slug' => $post['slug']], $post);
        }

        // 3. Data Awal Dokumen Unduhan (Renstra Penelitian, Renstra Pengabdian, Roadmap, SOP)
        $documents = [
            [
                'judul' => 'Dokumen Rencana Strategis Penelitian 2026-2031',
                'kategori' => 'renstra_penelitian',
                'deskripsi' => 'Arah kebijakan, target indikator kinerja, dan sasaran strategis riset keselamatan transportasi darat 5 tahunan PKTJ.',
                'file_path' => 'documents/renstra_penelitian_2026_2031.pdf',
                'file_size' => '3.2 MB',
                'tahun' => '2026 - 2031',
                'user_id' => $admin ? $admin->id : null,
            ],
            [
                'judul' => 'Dokumen Rencana Strategis Pengabdian Kepada Masyarakat',
                'kategori' => 'renstra_pengabdian',
                'deskripsi' => 'Pedoman tata kelola dan target capaian program pengabdian kepada masyarakat berbasis pemberdayaan desa binaan keselamatan jalan.',
                'file_path' => 'documents/renstra_pengabdian_masyarakat.pdf',
                'file_size' => '2.8 MB',
                'tahun' => '2026 - 2031',
                'user_id' => $admin ? $admin->id : null,
            ],
            [
                'judul' => 'Rencana Strategis (Renstra) P3M PKTJ 2026 – 2031',
                'kategori' => 'renstra',
                'deskripsi' => 'Arah kebijakan induk, target indikator kinerja, dan sasaran strategis riset dan pengabdian institusi PKTJ.',
                'file_path' => 'documents/renstra_2026_2031.pdf',
                'file_size' => '2.4 MB',
                'tahun' => '2026',
                'user_id' => $admin ? $admin->id : null,
            ],
            [
                'judul' => 'Roadmap Penelitian Keselamatan Transportasi Terpadu',
                'kategori' => 'roadmap',
                'deskripsi' => 'Peta jalan riset terpadu fokus teknologi keselamatan transportasi darat dan otomasi.',
                'file_path' => 'documents/roadmap_penelitian_pktj.pdf',
                'file_size' => '1.8 MB',
                'tahun' => '2026',
                'user_id' => $admin ? $admin->id : null,
            ],
            [
                'judul' => 'Standar Operasional Prosedur (SOP) Pengusulan Riset DIPA',
                'kategori' => 'sop_penelitian',
                'deskripsi' => 'Tahapan pengajuan usulan, seleksi administrasi, review substansi hingga pelaporan.',
                'file_path' => 'documents/sop_penelitian_dipa.pdf',
                'file_size' => '850 KB',
                'tahun' => '2026',
                'user_id' => $admin ? $admin->id : null,
            ],
            [
                'judul' => 'Standar Operasional Prosedur (SOP) Pengabdian kepada Masyarakat',
                'kategori' => 'sop_pengabdian',
                'deskripsi' => 'Tata kelola pelaksanaan pendampingan desa binaan, mitra UMKM, dan keselamatan jalan.',
                'file_path' => 'documents/sop_pengabdian_masyarakat.pdf',
                'file_size' => '920 KB',
                'tahun' => '2026',
                'user_id' => $admin ? $admin->id : null,
            ],
            [
                'judul' => 'Pedoman Penelitian dan Pengembangan Sumberdaya Manusia',
                'kategori' => 'pedoman_penelitian',
                'deskripsi' => 'Arah kebijakan, etika riset, kualifikasi peneliti, serta pembinaan dan peningkatan kompetensi kepakaran SDM dosen dan taruna PKTJ.',
                'file_path' => 'documents/pedoman_penelitian_sdm.pdf',
                'file_size' => '2.1 MB',
                'tahun' => '2026',
                'user_id' => $admin ? $admin->id : null,
            ],
            [
                'judul' => 'Pedoman Pengabdian kepada Masyarakat dan Pengembangan Kualitas Kepakaran',
                'kategori' => 'pedoman_pengabdian',
                'deskripsi' => 'Panduan pelaksanaan PkM, hilirisasi kepakaran keselamatan jalan, transfer teknologi, serta kemitraan dengan industri dan masyarakat.',
                'file_path' => 'documents/pedoman_pkm_kepakaran.pdf',
                'file_size' => '1.9 MB',
                'tahun' => '2026',
                'user_id' => $admin ? $admin->id : null,
            ],
            [
                'judul' => 'Dokumen Proses Pengabdian kepada Masyarakat',
                'kategori' => 'proses_pengabdian',
                'deskripsi' => 'Standar operasional tahapan pelaksanaan PkM: mulai pengusulan, verifikasi lapangan, implementasi mitra, monitoring evaluasi, hingga pelaporan.',
                'file_path' => 'documents/proses_pengabdian_masyarakat.pdf',
                'file_size' => '1.4 MB',
                'tahun' => '2026',
                'user_id' => $admin ? $admin->id : null,
            ],
            [
                'judul' => 'Buku Panduan Penggunaan Sistem Informasi (SIM P3M)',
                'kategori' => 'panduan_sistem',
                'deskripsi' => 'Panduan teknis pengoperasian portal bagi Dosen Pengusul, Reviewer, dan Verifikator dalam proses pengajuan dan monitoring riset & PkM.',
                'file_path' => 'documents/buku_panduan_sim_p3m.pdf',
                'file_size' => '1.5 MB',
                'tahun' => '2026',
                'user_id' => $admin ? $admin->id : null,
            ],
        ];

        foreach ($documents as $doc) {
            Document::updateOrCreate(['judul' => $doc['judul']], $doc);
        }

        // 4. Data Rekap Riset Publik (Researches)
        if ($prodiRstj && $prodiTro && $prodiTo) {
            $researches = [
                [
                    'judul' => 'Rancang Bangun Sensor Deteksi Kelelahan Pengemudi Angkutan Umum Berbasis Computer Vision',
                    'abstrak' => 'Penelitian ini mengembangkan sistem cerdas berbasis computer vision untuk memantau kedipan mata dan gerakan kepala pengemudi bus antarkota secara waktu-nyata guna mencegah kecelakaan fatal akibat microsleep.',
                    'prodi_id' => $prodiTro->id,
                    'user_id' => $dosenHendro?->id,
                    'ketua_peneliti' => 'Dr. Ir. Hendro Wibowo, M.T.',
                    'anggota' => 'Agus Setiawan, M.T., Dimas (Taruna)',
                    'tahun' => 2026,
                    'skema' => 'Penelitian Terapan Unggulan',
                    'sumber_dana' => 'DIPA Kemenhub',
                    'anggaran' => 45000000,
                    'berkas_laporan' => null,
                    'status' => 'Selesai',
                ],
                [
                    'judul' => 'Pemetaan Spasial Daerah Rawan Kecelakaan (Black Spot) pada Ruas Arteri Pantura Menggunakan Algoritma Geografis',
                    'abstrak' => 'Studi komprehensif mengintegrasikan data historis laka lantas Korlantas Polri dengan Sistem Informasi Geografis (SIG) untuk merumuskan rekomendasi rekayasa geometrik simpang dan rambu peringatan dini di jalur Pantura.',
                    'prodi_id' => $prodiRstj->id,
                    'user_id' => $dosenBambang?->id,
                    'ketua_peneliti' => 'Prof. Dr. Ir. Bambang Suhardi, M.Sc.',
                    'anggota' => 'Budi Santoso, S.T., M.Sc., Rian (Taruna)',
                    'tahun' => 2026,
                    'skema' => 'Penelitian Terapan Kebijakan',
                    'sumber_dana' => 'DIPA Kemenhub',
                    'anggaran' => 40000000,
                    'berkas_laporan' => null,
                    'status' => 'Selesai',
                ],
                [
                    'judul' => 'Analisis Kinerja Geometrik Simpang Tak Bersinyal untuk Mitigasi Titik Konflik Lalu Lintas Perkotaan',
                    'abstrak' => 'Evaluasi kapasitas simpang prioritas, derajat kejenuhan, dan tundaan kendaraan perkotaan untuk menghasilkan usulan kanalisasi arus dan optimalisasi pulau lalu lintas sesuai pedoman MKJI.',
                    'prodi_id' => $prodiRstj->id,
                    'user_id' => $dosenBudi?->id,
                    'ketua_peneliti' => 'Budi Santoso, S.T., M.Sc.',
                    'anggota' => 'Prof. Dr. Bambang Suhardi, Rian (Taruna)',
                    'tahun' => 2026,
                    'skema' => 'Penelitian Dosen Pemula',
                    'sumber_dana' => 'DIPA PKTJ',
                    'anggaran' => 25000000,
                    'berkas_laporan' => null,
                    'status' => 'Berjalan',
                ],
                [
                    'judul' => 'Pengembangan Purwarupa Pengereman Anti-Lock Braking System (ABS) untuk Kendaraan Listrik Roda Dua Vokasi',
                    'abstrak' => 'Inovasi aktuator hidrolik mikro dan modul ECU ABS mandiri yang dirancang untuk mencegah penguncian roda sepeda motor listrik pada permukaan basah, mendukung hilirisasi industri otomotif nasional.',
                    'prodi_id' => $prodiTro->id,
                    'user_id' => $dosenAgus?->id,
                    'ketua_peneliti' => 'Agus Setiawan, M.T.',
                    'anggota' => 'Dr. Ir. Hendro Wibowo, Fajar (Taruna)',
                    'tahun' => 2025,
                    'skema' => 'Penelitian Hilirisasi Industri',
                    'sumber_dana' => 'Kemdiktisaintek',
                    'anggaran' => 50000000,
                    'berkas_laporan' => null,
                    'status' => 'Selesai',
                ],
                [
                    'judul' => 'Uji Karakteristik Emisi Gas Buang Kendaraan Niaga Berbahan Bakar Biosolar Campuran B35',
                    'abstrak' => 'Pengujian performa torsi, opasitas asap, dan konsumsi spesifik bahan bakar solar B35 pada kendaraan niaga muatan berat di laboratorium uji motor bakar PKTJ bekerjasama dengan industri karoseri mitra.',
                    'prodi_id' => $prodiTo->id,
                    'user_id' => $dosenWahyu?->id,
                    'ketua_peneliti' => 'Wahyu Nugroho, M.Sc.',
                    'anggota' => 'Siti Rahmawati, S.Si.T., M.T., Aldi (Taruna)',
                    'tahun' => 2025,
                    'skema' => 'Penelitian Terapan',
                    'sumber_dana' => 'Mitra Industri',
                    'anggaran' => 35000000,
                    'berkas_laporan' => null,
                    'status' => 'Selesai',
                ],
                [
                    'judul' => 'Rancang Bangun Sistem Konversi Sepeda Motor Konvensional Menjadi Motor Listrik Ramah Lingkungan',
                    'abstrak' => 'Rancang bangun kit konversi motor bakar 110cc ke motor listrik BLDC 2kW dengan konfigurasi baterai lithium-ferro phosphate (LFP) 72V 20Ah bersertifikasi uji kelaikan teknis Kemenhub.',
                    'prodi_id' => $prodiTo->id,
                    'user_id' => $dosenSiti?->id,
                    'ketua_peneliti' => 'Siti Rahmawati, S.Si.T., M.T.',
                    'anggota' => 'Wahyu Nugroho, M.Sc., Gilang (Taruna)',
                    'tahun' => 2026,
                    'skema' => 'Penelitian Terapan Vokasi',
                    'sumber_dana' => 'Mandiri',
                    'anggaran' => 30000000,
                    'berkas_laporan' => null,
                    'status' => 'Berjalan',
                ],
            ];

            foreach ($researches as $res) {
                Research::updateOrCreate(['judul' => $res['judul']], $res);
            }

            // Data Publikasi Ilmiah, HKI & Produk/Jasa (Outputs)
            $outputs = [
                // 1. KATEGORI PUBLIKASI ILMIAH
                [
                    'kategori' => 'publikasi',
                    'judul' => 'Driver Drowsiness Detection System on Public Transportation Using Facial Landmark and Head Pose Estimation',
                    'prodi_id' => $prodiTro->id,
                    'user_id' => $dosenHendro?->id,
                    'author_inventor' => 'Dr. Ir. Hendro Wibowo, M.T., Agus Setiawan, M.T.',
                    'tahun' => 2026,
                    'nama_jurnal_penerbit' => 'Indonesian Road Safety Journal (IRSJ) Vol. 4 No. 2',
                    'tingkat_kesiapan_terapan' => 'TKT 6',
                    'lisensi' => 'CC BY 4.0 (Open Access)',
                    'fase_roadmap' => 'Fase 2 - Inovasi Rekayasa Cerdas',
                    'deskripsi_kemanfaatan' => 'Mencegah kecelakaan armada angkutan umum antar-kota akibat fenomena microsleep pengemudi melalui sistem alarm getar dan audio otomatis.',
                    'mitra_kerjasama' => 'Perum DAMRI & BPTD Jawa Tengah',
                    'sumber_dana' => 'DIPA PKTJ',
                    'realisasi_dana' => 45000000,
                    'link_dokumen' => 'https://doi.org/10.1234/irsj.v4i2.2026',
                    'berkas_luaran' => 'outputs/artikel_irsj_drowsiness_2026.pdf',
                ],
                [
                    'kategori' => 'publikasi',
                    'judul' => 'Spatial Risk Modeling and Identification of Traffic Accident Black Spots along the Northern Java Coastal Highway',
                    'prodi_id' => $prodiRstj->id,
                    'user_id' => $dosenBambang?->id,
                    'author_inventor' => 'Prof. Dr. Ir. Bambang Suhardi, M.Sc., Budi Santoso, S.T., M.Sc.',
                    'tahun' => 2025,
                    'nama_jurnal_penerbit' => 'Journal of Transportation Safety & Security Vol. 17 No. 3 (Scopus Q2)',
                    'tingkat_kesiapan_terapan' => 'TKT 5',
                    'lisensi' => 'CC BY-NC 4.0 (Open Access)',
                    'fase_roadmap' => 'Fase 1 - Riset Dasar & Titik Rawan',
                    'deskripsi_kemanfaatan' => 'Pemodelan spasial titik rawan kecelakaan (black spot) sebagai acuan penempatan rambu dan rekomendasi perbaikan geometri jalan di jalur logistik Pantura.',
                    'mitra_kerjasama' => 'Korlantas Polri & Balai Besar Pelaksanaan Jalan Nasional (BBPJN)',
                    'sumber_dana' => 'Kemdiktisaintek',
                    'realisasi_dana' => 75000000,
                    'link_dokumen' => 'https://doi.org/10.1080/19439962.2025.1001',
                    'berkas_luaran' => 'outputs/artikel_scopus_blackspot_2025.pdf',
                ],
                [
                    'kategori' => 'publikasi',
                    'judul' => 'Evaluasi Kinerja Geometrik Tikungan Kritis dan Pengaruhnya Terhadap Stabilitas Kendaraan Berat di Jalur Logistik',
                    'prodi_id' => $prodiRstj->id,
                    'user_id' => $dosenBudi?->id,
                    'author_inventor' => 'Budi Santoso, S.T., M.Sc.',
                    'tahun' => 2026,
                    'nama_jurnal_penerbit' => 'Jurnal Keselamatan Transportasi Darat (SINTA 2) Vol. 8 No. 1',
                    'tingkat_kesiapan_terapan' => 'TKT 4',
                    'lisensi' => 'CC BY 4.0 (Open Access)',
                    'fase_roadmap' => 'Fase 1 - Riset Dasar & Titik Rawan',
                    'deskripsi_kemanfaatan' => 'Menghitung batas kecepatan aman dan rekomendasi superelevasi jalan untuk mencegah risiko rollover truk tronton.',
                    'mitra_kerjasama' => 'Dinas Perhubungan Provinsi Jawa Tengah',
                    'sumber_dana' => 'DIPA PKTJ',
                    'realisasi_dana' => 38000000,
                    'link_dokumen' => 'https://doi.org/10.38035/jktd.v8i1.2026',
                    'berkas_luaran' => 'outputs/jurnal_geometrik_logistik_2026.pdf',
                ],
                [
                    'kategori' => 'publikasi',
                    'judul' => 'Analisis Opasitas Gas Buang dan Performa Mesin Diesel Common Rail Menggunakan Bahan Bakar B35',
                    'prodi_id' => $prodiTo->id,
                    'user_id' => $dosenWahyu?->id,
                    'author_inventor' => 'Wahyu Nugroho, M.Sc., Siti Rahmawati, M.T.',
                    'tahun' => 2025,
                    'nama_jurnal_penerbit' => 'Jurnal Teknologi Otomotif Vokasi (SINTA 3) Vol. 5 No. 1',
                    'tingkat_kesiapan_terapan' => 'TKT 4',
                    'lisensi' => 'CC BY 4.0 (Open Access)',
                    'fase_roadmap' => 'Fase 2 - Inovasi Rekayasa Cerdas',
                    'deskripsi_kemanfaatan' => 'Verifikasi kelaikan emisi dan keausan injektor kendaraan komersial berbahan bakar nabati biodiesel kelapa sawit B35.',
                    'mitra_kerjasama' => 'Balai Pengujian Laik Jalan dan Sertifikasi Kendaraan Bermotor (BPLJSKB)',
                    'sumber_dana' => 'Mitra Industri',
                    'realisasi_dana' => 30000000,
                    'link_dokumen' => 'https://doi.org/10.31294/jtov.v5i1.2025',
                    'berkas_luaran' => 'outputs/jurnal_emisi_b35_2025.pdf',
                ],

                // 2. KATEGORI HAK KEKAYAAN INTELEKTUAL (HKI)
                [
                    'kategori' => 'hki',
                    'judul' => 'Paten Sederhana: Perangkat Peringatan Dini Kelelahan Pengemudi Berbasis Getar Sabuk Pengaman Aktif',
                    'prodi_id' => $prodiTro->id,
                    'user_id' => $dosenHendro?->id,
                    'author_inventor' => 'Dr. Ir. Hendro Wibowo, M.T., Ir. Bambang Suhardi, M.Sc.',
                    'tahun' => 2025,
                    'nomor_registrasi_hki' => 'IDS000004921',
                    'tingkat_kesiapan_terapan' => 'TKT 7',
                    'lisensi' => 'Hak Eksklusif Kedinasan (DJKI Kemenkumham)',
                    'fase_roadmap' => 'Fase 2 - Inovasi Rekayasa Cerdas',
                    'deskripsi_kemanfaatan' => 'Invensi sabuk keselamatan haptik dengan aktuator getar multifrekuensi yang terpicu saat sensor kamera mendeteksi mata terpejam lebih dari 1,5 detik.',
                    'mitra_kerjasama' => 'PT Hino Motors Manufacturing Indonesia',
                    'sumber_dana' => 'DIPA PKTJ',
                    'realisasi_dana' => 60000000,
                    'link_dokumen' => 'https://pdki-indonesia.dgip.go.id/detail/IDS000004921',
                    'berkas_luaran' => 'outputs/sertifikat_paten_sabuk_haptik_2025.pdf',
                ],
                [
                    'kategori' => 'hki',
                    'judul' => 'Hak Cipta: Desain Sirkuit Kontrol Modulator Pengereman Anti-Lock Elektrik untuk Sepeda Motor Konversi',
                    'prodi_id' => $prodiTro->id,
                    'user_id' => $dosenAgus?->id,
                    'author_inventor' => 'Agus Setiawan, M.T., Hendro Wibowo, M.T.',
                    'tahun' => 2025,
                    'nomor_registrasi_hki' => 'EC00202518290',
                    'tingkat_kesiapan_terapan' => 'TKT 6',
                    'lisensi' => 'Lisensi Terbuka Non-Komersial (Open Hardware CC BY-SA)',
                    'fase_roadmap' => 'Fase 3 - Hilirisasi & Kemitraan Industri',
                    'deskripsi_kemanfaatan' => 'Skema modul pengaman rem elektrik anti-selip roda dua untuk bengkel konversi motor listrik UMKM binaan perhubungan.',
                    'mitra_kerjasama' => 'Kementerian ESDM & Asosiasi Bengkel Konversi',
                    'sumber_dana' => 'DIPA PKTJ',
                    'realisasi_dana' => 40000000,
                    'link_dokumen' => 'https://pdki-indonesia.dgip.go.id/detail/EC00202518290',
                    'berkas_luaran' => 'outputs/sertifikat_hakcipta_abs_konversi_2025.pdf',
                ],
                [
                    'kategori' => 'hki',
                    'judul' => 'Hak Cipta: Perangkat Lunak Road Safety Audit Automation System (ROSA-PKTJ v1.0)',
                    'prodi_id' => $prodiRstj->id,
                    'user_id' => $dosenBudi?->id,
                    'author_inventor' => 'Budi Santoso, S.T., M.Sc., Siti Rahmawati, M.T.',
                    'tahun' => 2026,
                    'nomor_registrasi_hki' => 'EC00202610452',
                    'tingkat_kesiapan_terapan' => 'TKT 7',
                    'lisensi' => 'GPL v3.0 (Open Source Software)',
                    'fase_roadmap' => 'Fase 3 - Hilirisasi & Kemitraan Industri',
                    'deskripsi_kemanfaatan' => 'Aplikasi otomasi kalkulasi risiko geometrik dan inspeksi kelaikan jalan terstandar pedoman audit keselamatan jalan Kementerian Perhubungan.',
                    'mitra_kerjasama' => 'Direktorat Keselamatan Transportasi Jalan, Ditjen Hubdat',
                    'sumber_dana' => 'DIPA PKTJ',
                    'realisasi_dana' => 50000000,
                    'link_dokumen' => 'https://pdki-indonesia.dgip.go.id/detail/EC00202610452',
                    'berkas_luaran' => 'outputs/sertifikat_software_rosa_2026.pdf',
                ],

                // 3. KATEGORI PRODUK & JASA TEKNOLOGI
                [
                    'kategori' => 'produk',
                    'judul' => 'Purwarupa Portable Speed Limiter & Data Logger Cerdas untuk Angkutan Barang Curah Cair',
                    'prodi_id' => $prodiTro->id,
                    'user_id' => $dosenAgus?->id,
                    'author_inventor' => 'Agus Setiawan, M.T., Hendro Wibowo, M.T., Tim Taruna TRO',
                    'tahun' => 2026,
                    'tingkat_kesiapan_terapan' => 'TKT 8',
                    'lisensi' => 'Open Source Hardware (CERN-OHL-W)',
                    'fase_roadmap' => 'Fase 3 - Hilirisasi & Kemitraan Industri',
                    'deskripsi_kemanfaatan' => 'Perangkat pembatas kecepatan elektronik terintegrasi GPS telemetry yang membatasi suplai bahan bakar ketika kendaraan memasuki zona turunan curam rawan rem blong.',
                    'mitra_kerjasama' => 'PT Pertamina Patra Niaga Regional Jawa Bagian Tengah',
                    'sumber_dana' => 'Mitra Industri',
                    'realisasi_dana' => 85000000,
                    'link_dokumen' => 'https://p3m.pktj.ac.id/produk/speed-limiter-logger',
                    'berkas_luaran' => 'outputs/spesifikasi_teknis_speed_limiter_2026.pdf',
                ],
                [
                    'kategori' => 'produk',
                    'judul' => 'Naskah Rekomendasi Kebijakan: Pedoman Teknis Pemasangan Fasilitas Penenang Lalu Lintas (Traffic Calming) Kawasan Sekolah Vokasi',
                    'prodi_id' => $prodiRstj->id,
                    'user_id' => $dosenBudi?->id,
                    'author_inventor' => 'Budi Santoso, S.T., M.Sc., Prof. Bambang Suhardi, M.Sc.',
                    'tahun' => 2025,
                    'tingkat_kesiapan_terapan' => 'TKT 9',
                    'lisensi' => 'Creative Commons Public Domain (CC0 1.0)',
                    'fase_roadmap' => 'Fase 3 - Hilirisasi & Kemitraan Industri',
                    'deskripsi_kemanfaatan' => 'Rancangan pedoman standar penempatan speed table, pita penggaduh, dan zona selamat sekolah (ZoSS) yang telah diadopsi dan diundangkan Pemerintah Kota Tegal.',
                    'mitra_kerjasama' => 'Pemerintah Kota Tegal & BPTD Kelas II Jawa Tengah',
                    'sumber_dana' => 'DIPA PKTJ',
                    'realisasi_dana' => 35000000,
                    'link_dokumen' => 'https://jdih.tegalkota.go.id/pedoman-zoss-2025',
                    'berkas_luaran' => 'outputs/naskah_kebijakan_zoss_pktj_2025.pdf',
                ],
                [
                    'kategori' => 'produk',
                    'judul' => 'Alat Portable Smoke Opacity Tester Berbasis Sensor Inframerah untuk Uji Berkala Kendaraan Bermotor Lapangan',
                    'prodi_id' => $prodiTo->id,
                    'user_id' => $dosenWahyu?->id,
                    'author_inventor' => 'Wahyu Nugroho, M.Sc., Siti Rahmawati, M.T.',
                    'tahun' => 2026,
                    'tingkat_kesiapan_terapan' => 'TKT 7',
                    'lisensi' => 'Lisensi Terbuka Akademik (MIT License)',
                    'fase_roadmap' => 'Fase 2 - Inovasi Rekayasa Cerdas',
                    'deskripsi_kemanfaatan' => 'Alat ukur kepekatan asap kendaraan diesel portabel bobot ringan (kurang dari 2 kg) untuk operasi gabungan penegakan hukum kelaikan jalan Dishub dan Kepolisian.',
                    'mitra_kerjasama' => 'Unit Pelaksana Pengujian Berkala Kendaraan Bermotor (UPPKB) Margadana',
                    'sumber_dana' => 'DIPA PKTJ',
                    'realisasi_dana' => 42000000,
                    'link_dokumen' => 'https://p3m.pktj.ac.id/produk/smoke-opacity-tester',
                    'berkas_luaran' => 'outputs/manual_uji_smoke_tester_2026.pdf',
                ],
            ];

            foreach ($outputs as $out) {
                Output::updateOrCreate(['judul' => $out['judul']], $out);
            }

            // 5. Data Rekap Pengabdian Masyarakat Publik (Community Services)
            $communityServices = [
                [
                    'judul' => 'Audit Keselamatan Rute Aman Selamat Sekolah (RASS) dan Pemasangan Marka Kejut Zona Sekolah',
                    'ringkasan' => 'Pelaksanaan audit fasilitas pejalan kaki di gerbang sekolah, sosialisasi tata cara menyeberang jalan aman, dan pemasangan rambu peringatan serta pita penggaduh zona selamat sekolah.',
                    'prodi_id' => $prodiRstj->id,
                    'ketua_pelaksana' => 'Prof. Dr. Ir. Bambang Suhardi, M.Sc.',
                    'anggota' => 'Budi Santoso, S.T., M.Sc., Rian (Taruna)',
                    'tahun' => 2026,
                    'skema' => 'PkM Kemitraan Wilayah',
                    'mitra' => 'Dinas Perhubungan & SD Negeri 1 Kraton',
                    'lokasi_kegiatan' => 'Kec. Tegal Barat, Kota Tegal',
                    'sumber_dana' => 'DIPA PKTJ',
                    'anggaran' => 20000000,
                    'berkas_laporan' => 'community_services/reports/laporan_pkm_rass_sekolah_2026.pdf',
                    'status' => 'Selesai',
                ],
                [
                    'judul' => 'Edukasi Titik Buta (Blind Spot) dan Simulasi Evakuasi Darurat Bus Sekolah bagi Pelajar Menengah',
                    'ringkasan' => 'Simulasi interaktif area blind spot armada bus besar dan pelatihan pemecahan kaca darurat menggunakan palu keselamatan bagi 150 siswa SMK di koridor lalu lintas Pantura.',
                    'prodi_id' => $prodiRstj->id,
                    'ketua_pelaksana' => 'Budi Santoso, S.T., M.Sc.',
                    'anggota' => 'Prof. Dr. Bambang Suhardi, Rian (Taruna)',
                    'tahun' => 2025,
                    'skema' => 'PkM Sosialisasi Keselamatan',
                    'mitra' => 'Dinas Pendidikan & SMK Negeri 1 Slawi',
                    'lokasi_kegiatan' => 'Kec. Slawi, Kabupaten Tegal',
                    'sumber_dana' => 'DIPA PKTJ',
                    'anggaran' => 18000000,
                    'berkas_laporan' => 'community_services/reports/laporan_pkm_blind_spot_2025.pdf',
                    'status' => 'Selesai',
                ],
                [
                    'judul' => 'Pelatihan Pengujian Emisi Gas Buang dan Standardisasi Kalibrasi Alat Uji bagi Teknisi Bengkel Rakyat',
                    'ringkasan' => 'Transfer pengetahuan kalibrasi mandiri smoke tester dan gas analyzer portabel guna mempersiapkan kesiapan bengkel rakyat dalam program kepatuhan uji emisi berkala kendaraan bermotor.',
                    'prodi_id' => $prodiTo->id,
                    'ketua_pelaksana' => 'Wahyu Nugroho, M.Sc.',
                    'anggota' => 'Siti Rahmawati, S.Si.T., M.T., Aldi (Taruna)',
                    'tahun' => 2026,
                    'skema' => 'PkM Penerapan Teknologi Tepat Guna',
                    'mitra' => 'Asosiasi Bengkel Pantura Mandiri',
                    'lokasi_kegiatan' => 'Desa Kalinyamat Kulon, Kota Tegal',
                    'sumber_dana' => 'Kemdiktisaintek',
                    'anggaran' => 25000000,
                    'berkas_laporan' => 'community_services/reports/laporan_pkm_emisi_bengkel_2026.pdf',
                    'status' => 'Selesai',
                ],
                [
                    'judul' => 'Penerapan Teknologi Konversi Sepeda Motor Listrik bagi Kelompok Usaha Karang Taruna Pesisir',
                    'ringkasan' => 'Pelatihan perakitan kit motor listrik 2kW, penyambungan baterai LFP 72V, dan standardisasi wiring kelistrikan yang aman terhadap bahaya arus pendek bagi pemuda pesisir.',
                    'prodi_id' => $prodiTo->id,
                    'ketua_pelaksana' => 'Siti Rahmawati, S.Si.T., M.T.',
                    'anggota' => 'Wahyu Nugroho, M.Sc., Gilang (Taruna)',
                    'tahun' => 2025,
                    'skema' => 'PkM Kewirausahaan Vokasi',
                    'mitra' => 'Karang Taruna Bahari Mandiri',
                    'lokasi_kegiatan' => 'Kelurahan Muarareja, Kota Tegal',
                    'sumber_dana' => 'Mandiri',
                    'anggaran' => 22000000,
                    'berkas_laporan' => 'community_services/reports/laporan_pkm_motor_listrik_2025.pdf',
                    'status' => 'Selesai',
                ],
                [
                    'judul' => 'Pendampingan Standar Perawatan Berkala Sistem Pengereman Pneumatik bagi Pengemudi Armada Logistik Pantura',
                    'ringkasan' => 'Sosialisasi teknis mitigasi brake fade pada truk tronton sarat muatan saat menuruni jalan terjal dan praktik cek mandiri ketebalan kampas rem serta tangki udara bertekanan.',
                    'prodi_id' => $prodiTro->id,
                    'ketua_pelaksana' => 'Dr. Ir. Hendro Wibowo, M.T.',
                    'anggota' => 'Agus Setiawan, M.T., Dimas (Taruna)',
                    'tahun' => 2026,
                    'skema' => 'PkM Kemitraan Industri',
                    'mitra' => 'DPC Organda & Paguyuban Pengemudi Truk Pantura',
                    'lokasi_kegiatan' => 'Kec. Larangan, Kabupaten Brebes',
                    'sumber_dana' => 'Mitra Industri',
                    'anggaran' => 30000000,
                    'berkas_laporan' => 'community_services/reports/laporan_pkm_rem_pneumatik_2026.pdf',
                    'status' => 'Selesai',
                ],
                [
                    'judul' => 'Sosialisasi Kelaikan Teknis dan Uji Rem Dinamik Kendaraan Angkutan Pedesaan Berkeselamatan',
                    'ringkasan' => 'Pemeriksaan teknis gratis efisiensi rem, keselarasan roda depan, dan lampu penerangan bagi 40 unit angkutan desa guna menjamin keselamatan penumpang di rute antar-pasar.',
                    'prodi_id' => $prodiTro->id,
                    'ketua_pelaksana' => 'Agus Setiawan, M.T.',
                    'anggota' => 'Dr. Ir. Hendro Wibowo, Fajar (Taruna)',
                    'tahun' => 2024,
                    'skema' => 'PkM Kemitraan Komunitas',
                    'mitra' => 'Koperasi Angkutan Pedesaan Jatibarang',
                    'lokasi_kegiatan' => 'Kec. Jatibarang, Kabupaten Brebes',
                    'sumber_dana' => 'DIPA PKTJ',
                    'anggaran' => 16000000,
                    'berkas_laporan' => 'community_services/reports/laporan_pkm_angkutan_desa_2024.pdf',
                    'status' => 'Selesai',
                ],
                [
                    'judul' => 'Penyusunan Rencana Induk Manajemen Lalu Lintas dan Marka Pemandu di Kawasan Wisata Bahari',
                    'ringkasan' => 'Pemberian rekomendasi skema rekayasa sirkulasi satu arah saat akhir pekan libur nasional dan penataan zona kantong parkir bus pariwisata agar tidak menimbulkan kemacetan di jalan arteri.',
                    'prodi_id' => $prodiRstj->id,
                    'ketua_pelaksana' => 'Prof. Dr. Ir. Bambang Suhardi, M.Sc.',
                    'anggota' => 'Budi Santoso, S.T., M.Sc.',
                    'tahun' => 2024,
                    'skema' => 'PkM Tata Kelola Wilayah',
                    'mitra' => 'Pokdarwis Pantai Alam Indah & Dishub Kota Tegal',
                    'lokasi_kegiatan' => 'Kawasan Wisata PAI, Kota Tegal',
                    'sumber_dana' => 'Kemdiktisaintek',
                    'anggaran' => 24000000,
                    'berkas_laporan' => 'community_services/reports/laporan_pkm_pariwisata_bahari_2024.pdf',
                    'status' => 'Selesai',
                ],
            ];

            foreach ($communityServices as $com) {
                CommunityService::updateOrCreate(['judul' => $com['judul']], $com);
            }

            // 5b. Data Hasil Analisis Luaran Pengabdian kepada Masyarakat (Community Service Outputs)
            $pkmRass = CommunityService::where('judul', 'like', '%Rute Aman Selamat Sekolah%')->first();
            $pkmEmisi = CommunityService::where('judul', 'like', '%Emisi Gas Buang%')->first();
            $pkmBlindSpot = CommunityService::where('judul', 'like', '%Titik Buta%')->first();
            $pkmMotor = CommunityService::where('judul', 'like', '%Konversi Sepeda Motor%')->first();
            $pkmRem = CommunityService::where('judul', 'like', '%Pengereman Pneumatik%')->first();
            $pkmAngkutan = CommunityService::where('judul', 'like', '%Angkutan Pedesaan%')->first();
            $pkmWisata = CommunityService::where('judul', 'like', '%Manajemen Lalu Lintas dan Marka%')->first();

            $pkmOutputs = [
                [
                    'kategori' => 'publikasi',
                    'judul' => 'Diseminasi Audit Zona Selamat Sekolah dan Reduksi Risiko Konflik Pejalan Kaki Pelajar di Jalur Perkotaan',
                    'community_service_id' => $pkmRass?->id,
                    'prodi_id' => $prodiRstj->id,
                    'user_id' => $dosenBambang?->id,
                    'pelaksana' => 'Prof. Dr. Ir. Bambang Suhardi, M.Sc., Budi Santoso, S.T., M.Sc.',
                    'tahun' => 2026,
                    'mitra_sasaran' => 'Dinas Pendidikan & SD Negeri 1 Kraton',
                    'lokasi' => 'Kota Tegal',
                    'deskripsi_manfaat' => 'Publikasi artikel ilmiah pada Jurnal Pengabdian Vokasi Nasional (SINTA 3) menganalisis penurunan kecepatan rata-rata kendaraan bermotor sebesar 38% setelah penataan pita penggaduh dan rambu zona selamat sekolah.',
                    'indikator_keberhasilan' => 'Penurunan kecepatan kendaraan zona sekolah 38%, artikel terindeks SINTA 3',
                    'tingkat_kepuasan_mitra' => '96% (Sangat Baik)',
                    'link_dokumen' => 'https://doi.org/10.1234/jpv.2026.rass',
                    'berkas_luaran' => 'community_services/outputs/jurnal_pkm_rass_sekolah_2026.pdf',
                ],
                [
                    'kategori' => 'ttg',
                    'judul' => 'Penerapan Alat Uji Opasitas Portabel Berbasis Mikrokontroler untuk Kalibrasi Mandiri Bengkel Rakyat',
                    'community_service_id' => $pkmEmisi?->id,
                    'prodi_id' => $prodiTo->id,
                    'user_id' => $dosenWahyu?->id,
                    'pelaksana' => 'Wahyu Nugroho, M.Sc., Siti Rahmawati, S.Si.T., M.T.',
                    'tahun' => 2026,
                    'mitra_sasaran' => 'Asosiasi Bengkel Pantura Mandiri',
                    'lokasi' => 'Desa Kalinyamat Kulon, Kota Tegal',
                    'deskripsi_manfaat' => 'Peralatan uji emisi gas buang diesel portabel yang dihibahkan ke asosiasi mekanik desa guna mempermudah pra-inspeksi kelaikan emisi sebelum kendaraan niaga mengikuti uji berkala KIR.',
                    'indikator_keberhasilan' => '25 mekanik desa terlatih melakukan kalibrasi dengan akurasi alat mencapai 95%',
                    'tingkat_kepuasan_mitra' => '94% (Sangat Baik)',
                    'link_dokumen' => 'https://p3m.pktj.ac.id/luaran/ttg-smoke-tester',
                    'berkas_luaran' => 'community_services/outputs/manual_ttg_smoke_tester_2026.pdf',
                ],
                [
                    'kategori' => 'modul',
                    'judul' => 'Buku Saku & SOP Pemeriksaan Kelaikan Sistem Pengereman Truk Berat bagi Paguyuban Sopir Logistik',
                    'community_service_id' => $pkmRem?->id,
                    'prodi_id' => $prodiTro->id,
                    'user_id' => $dosenHendro?->id,
                    'pelaksana' => 'Dr. Ir. Hendro Wibowo, M.T., Agus Setiawan, M.T.',
                    'tahun' => 2026,
                    'mitra_sasaran' => 'DPC Organda Brebes & Paguyuban Pengemudi Truk Pantura',
                    'lokasi' => 'Kec. Larangan, Kab. Brebes',
                    'deskripsi_manfaat' => 'Buku saku praktis panduan inspeksi kebocoran kompresor udara, batas ketebalan kampas rem pneumatik, dan prosedur pendinginan tromol saat melintasi jalur turunan curam.',
                    'indikator_keberhasilan' => 'Teredukasi 180 pengemudi armada angkutan barang lintas provinsi',
                    'tingkat_kepuasan_mitra' => '92% (Sangat Baik)',
                    'link_dokumen' => null,
                    'berkas_luaran' => 'community_services/outputs/modul_sop_bengkel_rakyat_2026.pdf',
                ],
                [
                    'kategori' => 'hki',
                    'judul' => 'Hak Cipta: Media Pembelajaran Interaktif Titik Buta (Blind Spot) Bus Sekolah untuk Pelajar Menengah',
                    'community_service_id' => $pkmBlindSpot?->id,
                    'prodi_id' => $prodiRstj->id,
                    'user_id' => $dosenBudi?->id,
                    'pelaksana' => 'Budi Santoso, S.T., M.Sc.',
                    'tahun' => 2025,
                    'mitra_sasaran' => 'SMK Negeri 1 Slawi Kab. Tegal',
                    'lokasi' => 'Kab. Tegal',
                    'deskripsi_manfaat' => 'Pendaftaran Hak Cipta Kemenkumham (Nomor EC0020251928) atas desain modul visualisasi sudut mati armada bus sekolah dan simulasi pemecahan kaca darurat.',
                    'indikator_keberhasilan' => 'Perolehan sertifikat terdaftar DJKI Kemenkumham dan diadopsi oleh 12 sekolah mitra binaan',
                    'tingkat_kepuasan_mitra' => '95% (Sangat Baik)',
                    'link_dokumen' => 'https://pdki-indonesia.dgip.go.id/detail/EC0020251928',
                    'berkas_luaran' => 'community_services/outputs/hki_hak_cipta_modul_blind_spot_2025.pdf',
                ],
                [
                    'kategori' => 'desa_binaan',
                    'judul' => 'Rekayasa Sirkulasi Satu Arah dan Zonasi Parkir Ramah Pejalan Kaki Kawasan Wisata Bahari PAI',
                    'community_service_id' => $pkmWisata?->id,
                    'prodi_id' => $prodiRstj->id,
                    'user_id' => $dosenBambang?->id,
                    'pelaksana' => 'Prof. Dr. Ir. Bambang Suhardi, M.Sc.',
                    'tahun' => 2025,
                    'mitra_sasaran' => 'Pokdarwis Pantai Alam Indah & Dishub Kota Tegal',
                    'lokasi' => 'Kota Tegal',
                    'deskripsi_manfaat' => 'Penerapan kanalisasi parkir terpadu dan rambu pemandu sirkulasi satu arah yang mengeliminasi penumpukan kendaraan di pintu masuk kawasan wisata bahari saat libur nasional.',
                    'indikator_keberhasilan' => 'Penurunan antrean kendaraan 60% dan nihil insiden kecelakaan pengunjung',
                    'tingkat_kepuasan_mitra' => '98% (Sangat Baik)',
                    'link_dokumen' => null,
                    'berkas_luaran' => 'community_services/outputs/rekayasa_desa_binaan_pariwisata_2025.pdf',
                ],
                [
                    'kategori' => 'modul',
                    'judul' => 'Panduan Praktis Konversi Motor Bakar ke Motor Listrik BLDC untuk Bengkel Pemuda Pesisir',
                    'community_service_id' => $pkmMotor?->id,
                    'prodi_id' => $prodiTo->id,
                    'user_id' => $dosenSiti?->id,
                    'pelaksana' => 'Siti Rahmawati, S.Si.T., M.T., Wahyu Nugroho, M.Sc.',
                    'tahun' => 2025,
                    'mitra_sasaran' => 'Karang Taruna Bahari Mandiri',
                    'lokasi' => 'Kelurahan Muarareja, Kota Tegal',
                    'deskripsi_manfaat' => 'Buku saku teknis perakitan kit motor listrik 2kW, prosedur keamanan pengkabelan paket baterai litium LFP, dan uji kelistrikan tahan percikan air laut.',
                    'indikator_keberhasilan' => 'Tercipta 2 unit purwarupa motor listrik konversi nelayan pesisir yang laik jalan',
                    'tingkat_kepuasan_mitra' => '91% (Baik)',
                    'link_dokumen' => null,
                    'berkas_luaran' => 'community_services/outputs/buku_panduan_motor_listrik_pesisir_2025.pdf',
                ],
                [
                    'kategori' => 'desa_binaan',
                    'judul' => 'Evaluasi Dampak Audit Rem Dinamik Angkutan Desa terhadap Penurunan Gangguan Teknis Armada',
                    'community_service_id' => $pkmAngkutan?->id,
                    'prodi_id' => $prodiTro->id,
                    'user_id' => $dosenAgus?->id,
                    'pelaksana' => 'Agus Setiawan, M.T., Dr. Ir. Hendro Wibowo, M.T.',
                    'tahun' => 2024,
                    'mitra_sasaran' => 'Koperasi Angkutan Pedesaan Jatibarang',
                    'lokasi' => 'Kec. Jatibarang, Kab. Brebes',
                    'deskripsi_manfaat' => 'Hasil analisis inspeksi dan perawatan berkala sistem rem pada 40 unit angkutan pedesaan yang menghasilkan catatan nihil insiden mogok rem blong selama 1 tahun operasional.',
                    'indikator_keberhasilan' => 'Zero failure teknis pengereman pada 40 angkutan desa selama 12 bulan',
                    'tingkat_kepuasan_mitra' => '93% (Sangat Baik)',
                    'link_dokumen' => null,
                    'berkas_luaran' => 'community_services/outputs/laporan_evaluasi_dampak_laka_2024.pdf',
                ],
            ];

            foreach ($pkmOutputs as $outputData) {
                CommunityServiceOutput::updateOrCreate(['judul' => $outputData['judul']], $outputData);
            }
        }

        // 6. Data Pengaturan Beranda & Video Profil (Settings)
        $defaultSettings = [
            'video_profile_url' => 'https://www.youtube.com/watch?v=5F_fNlPGBdQ',
            'video_profile_title' => 'Video Profil P3M PKTJ Tegal',
            'video_profile_desc' => 'Inovasi Riset Unggulan Keselamatan Transportasi Jalan & Pengabdian Vokasi',
            'video_profile_active' => '1',
            'about_lead' => 'Pusat Penelitian dan Pengabdian kepada Masyarakat (P3M) merupakan unit pelaksana strategis di lingkungan Politeknik Keselamatan Transportasi Jalan (PKTJ) Tegal di bawah naungan Badan Pengembangan Sumber Daya Manusia Perhubungan (BPSDMP), Kementerian Perhubungan Republik Indonesia.',
            'about_vision_mission' => 'P3M PKTJ berkomitmen mengakselerasi inovasi teknologi terapan yang solutif guna menurunkan angka fatalitas kecelakaan lalu lintas nasional, mengoptimalkan kelaikan operasional kendaraan bermotor, dan mentransfer pengetahuan ilmiah langsung kepada masyarakat, industri transportasi, dan instansi pembina keselamatan.',
            'facility_1_title' => 'Laboratorium Uji Keselamatan',
            'facility_1_desc' => 'Fasilitas uji terstandar untuk simulasi dinamika kendaraan, uji pengereman aktif, dan visualisasi geometri jalan.',
            'facility_2_title' => 'Audit Koridor Pantura Jawa',
            'facility_2_desc' => 'Survei lapangan berkala di koridor pantai utara Jawa Tengah untuk memetakan titik rawan kecelakaan (black spot).',
            'facility_3_title' => 'Aksi Nyata Pengabdian',
            'facility_3_desc' => 'Sosialisasi budaya keselamatan berkendara bagi pelajar, pengemudi angkutan umum, dan bengkel mitra binaan.',
        ];

        foreach ($defaultSettings as $key => $val) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $val, 'group' => 'homepage']
            );
        }

        // 7. Data Pengaturan Visi, Misi & Tujuan (Settings)
        $visiMisiSettings = [
            'visi_title' => 'Visi P3M Politeknik Keselamatan Transportasi Jalan',
            'visi_statement' => 'Menjadi pusat rujukan riset terapan dan pengabdian masyarakat unggulan berbasis keselamatan transportasi jalan yang solutif, berdaya saing global, dan berintegritas pada tahun 2031.',
            'visi_subtext' => 'Mengakselerasi terwujudnya transportasi darat nasional yang selamat, tertib, dan berkelanjutan melalui keunggulan riset vokasi sivitas akademika PKTJ di bawah Badan Pengembangan SDM Perhubungan.',
            'misi_1' => 'Menyelenggarakan penelitian terapan yang inovatif dan solutif guna memitigasi titik rawan kecelakaan (black spot) dan meningkatkan keselamatan transportasi darat.',
            'misi_2' => 'Melaksanakan pengabdian kepada masyarakat berbasis aksi nyata, edukasi budaya keselamatan berkendara, pendampingan desa binaan, dan standardisasi bengkel rakyat.',
            'misi_3' => 'Mengembangkan kemitraan riset sinergis dengan Kementerian Perhubungan, Korlantas Polri, KNKT, pemerintah daerah, dan industri manufaktur otomotif nasional.',
            'misi_4' => 'Mendorong hilirisasi invensi teknologi keselamatan, percepatan perolehan Hak Kekayaan Intelektual (HKI/Paten), serta publikasi berkala pada jurnal ilmiah terakreditasi.',
            'misi_5' => 'Mengoptimalkan tata kelola kelembagaan P3M yang transparan, akuntabel, dan berbasis sistem informasi digital (SIM P3M) berstandar mutu pendidikan tinggi vokasi.',
            'tujuan_lead' => 'Tujuan strategis P3M PKTJ dirumuskan untuk menjamin ketercapaian sasaran mutu kelembagaan dan kontribusi nyata bagi keselamatan lalu lintas nasional.',
            'tujuan_1_title' => 'Reduksi Fatalitas Kecelakaan',
            'tujuan_1_desc' => 'Menghasilkan rekomendasi teknis audit keselamatan jalan dan rekayasa simpang yang menurunkan angka fatalitas korban lalu lintas nasional.',
            'tujuan_2_title' => 'Kemandirian Riset Vokasi',
            'tujuan_2_desc' => 'Meningkatkan kuantitas dan kualitas penelitian terapan dosen dan taruna yang didanai DIPA Kemenhub, Kemdiktisaintek, maupun mitra industri.',
            'tujuan_3_title' => 'Penguatan HKI & Jurnal Ilmiah',
            'tujuan_3_desc' => 'Meningkatkan perolehan paten invensi, hak cipta desain industri, dan publikasi artikel ilmiah pada Indonesian Road Safety Journal terindeks SINTA.',
            'tujuan_4_title' => 'Pemberdayaan Masyarakat Pantura',
            'tujuan_4_desc' => 'Memperluas jangkauan desa binaan tertib lalu lintas dan transfer teknologi standardisasi uji kelaikan armada ke bengkel UMKM mitra.',
        ];

        foreach ($visiMisiSettings as $key => $val) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $val, 'group' => 'visi_misi']
            );
        }
    }
}
