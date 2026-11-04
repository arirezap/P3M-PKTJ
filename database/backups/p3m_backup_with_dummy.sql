-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: p3m
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `collaborations`
--

DROP TABLE IF EXISTS `collaborations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `collaborations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_mitra` varchar(255) NOT NULL,
  `judul_kerjasama` varchar(255) DEFAULT NULL,
  `jenis_kegiatan` enum('penelitian','pengabdian','keduanya') NOT NULL DEFAULT 'penelitian',
  `kategori_mitra` enum('pemerintah','bumn','industri','perguruan_tinggi','lainnya') NOT NULL DEFAULT 'industri',
  `prodi_id` bigint unsigned DEFAULT NULL,
  `deskripsi` text,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_berakhir` date DEFAULT NULL,
  `nomor_mou_pks` varchar(255) DEFAULT NULL,
  `tahun` year NOT NULL,
  `status_kerjasama` enum('aktif','selesai') NOT NULL DEFAULT 'aktif',
  `file_dokumen` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `collaborations_prodi_id_foreign` (`prodi_id`),
  CONSTRAINT `collaborations_prodi_id_foreign` FOREIGN KEY (`prodi_id`) REFERENCES `prodis` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `collaborations`
--

LOCK TABLES `collaborations` WRITE;
/*!40000 ALTER TABLE `collaborations` DISABLE KEYS */;
INSERT INTO `collaborations` VALUES (1,'Korps Lalu Lintas (Korlantas) Polri','Pemetaan Spasial Daerah Rawan Kecelakaan (Black Spot) & Audit Geometri Jalan Koridor Pantura','penelitian','pemerintah',92,'Kerjasama strategis pertukaran data kecelakaan IRSMS Korlantas Polri dan penelitian rekayasa geometrik simpang untuk merumuskan intervensi keselamatan di jalur logistik Pantura.','2026-01-15','2028-12-31','MoU/08/KORLANTAS-PKTJ/2026',2026,'aktif','collaborations/mou_korlantas_blackspot_2026.pdf','2026-10-15 02:57:45','2026-10-15 02:57:45'),(2,'Direktorat Jenderal Perhubungan Darat, Kemenhub','Kajian Standarisasi Desain Geometri Jalur Penyelamat Darurat pada Ruas Jalan Turunan Curam Nasional','penelitian','pemerintah',92,'Penyusunan naskah rekomendasi teknis material gravel bed arrester dan sudut elevasi jalur penyelamat darurat (emergency escape ramp) untuk mencegah fatalitas rem blong armada angkutan barang.','2025-04-10','2027-04-10','PKS/HUBDAT/PKTJ/IV/2025/012',2025,'aktif','collaborations/pks_hubdat_jalur_penyelamat_2025.pdf','2026-10-15 02:57:45','2026-10-15 02:57:45'),(3,'PT Hino Motors Manufacturing Indonesia','Riset Terapan Purwarupa Perangkat Peringatan Titik Buta (Blind Spot Monitoring) Truk Logistik Berat','penelitian','industri',93,'Pengembangan inovasi sensor ultrasonik dan modul kamera pendeteksi kendaraan roda dua di sisi kiri truk angkutan peti kemas, mencakup uji lapang dinamis di fasilitas proving ground mitra.','2026-02-01','2027-01-31','HMMI-CSR-PKTJ/MOU/2026/05',2026,'aktif','collaborations/mou_hino_blindspot_2026.pdf','2026-10-15 02:57:45','2026-10-15 02:57:45'),(4,'Perum DAMRI (Kantor Pusat)','Uji Coba Lapangan Sistem Deteksi Kelelahan Pengemudi (Driver Drowsiness Detector) Bus Antarkota','penelitian','bumn',93,'Implementasi algoritma computer vision pengenal kedipan mata dan gerakan kepala pada 15 armada bus AKAP rute trans Jawa untuk mencegah kecelakaan fatal akibat fenomena microsleep.','2025-01-10','2025-12-31','MoU-DAMRI/DIRUT/PKTJ/2025/08',2025,'selesai','collaborations/mou_damri_drowsiness_2025.pdf','2026-10-15 02:57:45','2026-10-15 02:57:45'),(5,'PT Pertamina Patra Niaga Regional Jawa Bagian Tengah','Implementasi Modul Speed Limiter & Telemetri Cerdas pada Mobil Tangki BBM Lintasan Ekstrem','keduanya','bumn',93,'Pemasangan purwarupa limiter kecepatan otomatis terintegrasi geofencing pada armada mobil tangki distribusi BBM di wilayah pegunungan Jawa Tengah guna menjamin aspek HSSE transportasi.','2026-03-01','2027-02-28','PKS/PPN-JBT/P3M-PKTJ/2026/021',2026,'aktif','collaborations/pks_pertamina_speedlimiter_2026.pdf','2026-10-15 02:57:45','2026-10-15 02:57:45'),(6,'Balai Pengujian Laik Jalan & Sertifikasi Kendaraan Bermotor (BPLJSKB)','Verifikasi Karakteristik Emisi Gas Buang Kendaraan Niaga Berbahan Bakar Biodiesel B35 & B40','penelitian','pemerintah',94,'Pengujian komprehensif opasitas gas buang dan konsumsi bahan bakar mesin diesel pada laboratorium dyno test PKTJ dan fasilitas uji emisi resmi kelaikan jalan nasional.','2025-05-01','2025-11-30','MoU.04/BPLJSKB/PKTJ/2025',2025,'selesai','collaborations/mou_bpljskb_emisi_2025.pdf','2026-10-15 02:57:45','2026-10-15 02:57:45'),(7,'Institut Teknologi Bandung (SAPPK ITB)','Riset Pemodelan Perilaku Pengemudi dan Efektivitas Fasilitas Penenang Lalu Lintas (Traffic Calming)','penelitian','perguruan_tinggi',92,'Kolaborasi riset akademik dalam pengukuran kecepatan sesaat dan dampak visual rumble strip terhadap penurunan angka tabrakan di kawasan zona selamat sekolah.','2024-02-15','2024-12-15','MoU/ITB-SAPPK/PKTJ/2024/09',2024,'selesai','collaborations/mou_itb_traffic_calming_2024.pdf','2026-10-15 02:57:45','2026-10-15 02:57:45'),(8,'Asosiasi Industri Sepeda Motor Listrik Indonesia (AISMOLI)','Penyusunan Pedoman Uji Kelaikan Teknis Konversi Sepeda Motor Listrik Standar Vokasi','penelitian','industri',94,'Rancang bangun kit konversi motor listrik aman bersertifikasi, pelatihan standardisasi uji pengereman mekanik bengkel konversi, dan transfer teknologi baterai manajemen sistem.','2026-01-20','2027-01-20','MoU/AISMOLI-PKTJ/2026/014',2026,'aktif','collaborations/mou_aismoli_konversi_2026.pdf','2026-10-15 02:57:45','2026-10-15 02:57:45'),(9,'Dinas Perhubungan Kota Tegal','Pendampingan Program Desa Binaan Tanggap Keselamatan Lalu Lintas dan Penataan Rambu Zonasi Sekolah','pengabdian','pemerintah',92,'Kolaborasi pengabdian masyarakat pendampingan desa binaan keselamatan, perancangan marka penyeberangan anak sekolah, dan edukasi keselamatan jalan bagi kader kelurahan se-Kota Tegal.','2026-01-10','2027-01-09','MoU/03/DISHUB-TEGAL/PKTJ/2026',2026,'aktif','collaborations/mou_dishub_tegal_pkm_2026.pdf','2026-10-15 07:32:21','2026-10-15 07:32:21'),(10,'PT Kereta Api Indonesia (Persero) Daop 4 Semarang','Sosialisasi Keselamatan dan Rekayasa Perlengkapan Early Warning System di Perlintasan Sebidang','pengabdian','bumn',92,'Aksi pengabdian keselamatan transportasi berupa pemasangan sirine peringatan dini swadaya dan edukasi masyarakat pengguna jalan di 6 perlintasan sebidang tanpa palang pintu wilayah pantura barat.','2026-02-15','2026-12-31','PKS/KAI-DAOP4/PKTJ-PKM/2026/09',2026,'aktif','collaborations/pks_kai_perlintasan_pkm_2026.pdf','2026-10-15 07:32:21','2026-10-15 07:32:21'),(11,'Asosiasi Bengkel Kendaraan Roda Dua Kota Tegal','Pelatihan Alih Teknologi dan Sertifikasi Mandiri Kalibrasi Alat Uji Opasitas Emisi Gas Buang Sepeda Motor','pengabdian','industri',94,'Transfer pengetahuan teknologi alat uji emisi portabel karya sivitas akademika PKTJ kepada 35 teknisi bengkel rakyat demi menurunkan tingkat polusi udara perkotaan.','2026-03-01','2027-02-28','MoU/ABK-TEGAL/PKTJ/2026/011',2026,'aktif','collaborations/mou_bengkel_tegal_emisi_2026.pdf','2026-10-15 07:32:21','2026-10-15 07:32:21'),(12,'Paguyuban Pengemudi Truk Angkutan Logistik Pantura','Bimbingan Teknis Standarisasi Pemeriksaan Harian Sistem Rem Udara dan Mitigasi Rem Blong Truk Logistik','pengabdian','lainnya',93,'Penyuluhan dan simulasi langsung perbaikan katup pengatur angin rem tromol truk angkutan barang berat bagi 80 pengemudi logistik rute Semarang-Cirebon.','2025-03-10','2025-11-30','MoU/PAGUYUBAN-TRUK/PKTJ/2025/017',2025,'selesai','collaborations/mou_sopir_truk_rem_2025.pdf','2026-10-15 07:32:21','2026-10-15 07:32:21'),(13,'Dinas Pendidikan dan Kebudayaan Kabupaten Brebes','Edukasi Budaya Tertib Lalu Lintas dan Diseminasi Model Zona Selamat Sekolah (ZoSS) bagi Guru dan Pelajar','pengabdian','pemerintah',92,'Pelaksanaan program sosialisasi helm standar SNI, pembagian panduan penyeberangan aman, dan peremajaan marka karpet merah ZoSS di 10 sekolah tepian jalan nasional.','2025-06-01','2025-12-15','PKS/DISDIK-BREBES/PKTJ/2025/022',2025,'selesai','collaborations/pks_disdik_brebes_zoss_2025.pdf','2026-10-15 07:32:21','2026-10-15 07:32:21'),(14,'Perum DAMRI Cabang Purwokerto','Workshop Ergonomi Berkendara dan Manajemen Istirahat Awak Bus AKAP guna Pencegahan Microsleep','pengabdian','bumn',93,'Pelatihan penanganan kelelahan pengemudi bus antar kota antar provinsi, panduan pemeriksaan tekanan ban, dan pengecekan emisi gas buang berkala di pool DAMRI Purwokerto.','2025-04-05','2025-10-31','PKS/DAMRI-PWT/PKTJ/2025/031',2025,'selesai','collaborations/pks_damri_purwokerto_microsleep_2025.pdf','2026-10-15 07:32:21','2026-10-15 07:32:21'),(15,'Dewan Pengurus Cabang Organda Kota Tegal','Pendampingan Teknis Standardisasi Dimensi Bak Muatan dan Sertifikasi Uji Kelaikan Angkutan Perkotaan','pengabdian','industri',94,'Bimbingan teknis uji kir gratis, verifikasi dimensi batas aman armada angkot, dan perbaikan sistem penerangan kendaraan guna meningkatkan keselamatan penumpang.','2024-03-01','2024-11-20','MoU/ORGANDA-TEGAL/PKTJ/2024/005',2024,'selesai','collaborations/mou_organda_kelaikan_2024.pdf','2026-10-15 07:32:21','2026-10-15 07:32:21');
/*!40000 ALTER TABLE `collaborations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `community_service_outputs`
--

DROP TABLE IF EXISTS `community_service_outputs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `community_service_outputs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kategori` enum('publikasi','ttg','modul','hki','desa_binaan') NOT NULL,
  `judul` text NOT NULL,
  `community_service_id` bigint unsigned DEFAULT NULL,
  `prodi_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `pelaksana` varchar(255) NOT NULL,
  `tahun` year NOT NULL,
  `mitra_sasaran` varchar(255) DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `deskripsi_manfaat` text,
  `indikator_keberhasilan` varchar(255) DEFAULT NULL,
  `tingkat_kepuasan_mitra` varchar(255) DEFAULT NULL,
  `link_dokumen` varchar(255) DEFAULT NULL,
  `berkas_luaran` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `community_service_outputs_community_service_id_foreign` (`community_service_id`),
  KEY `community_service_outputs_prodi_id_foreign` (`prodi_id`),
  KEY `community_service_outputs_user_id_foreign` (`user_id`),
  CONSTRAINT `community_service_outputs_community_service_id_foreign` FOREIGN KEY (`community_service_id`) REFERENCES `community_services` (`id`) ON DELETE SET NULL,
  CONSTRAINT `community_service_outputs_prodi_id_foreign` FOREIGN KEY (`prodi_id`) REFERENCES `prodis` (`id`),
  CONSTRAINT `community_service_outputs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `community_service_outputs`
--

LOCK TABLES `community_service_outputs` WRITE;
/*!40000 ALTER TABLE `community_service_outputs` DISABLE KEYS */;
INSERT INTO `community_service_outputs` VALUES (1,'publikasi','Diseminasi Audit Zona Selamat Sekolah dan Reduksi Risiko Konflik Pejalan Kaki Pelajar di Jalur Perkotaan',55,92,165,'Prof. Dr. Ir. Bambang Suhardi, M.Sc., Budi Santoso, S.T., M.Sc.',2026,'Dinas Pendidikan & SD Negeri 1 Kraton','Kota Tegal','Publikasi artikel ilmiah pada Jurnal Pengabdian Vokasi Nasional (SINTA 3) menganalisis penurunan kecepatan rata-rata kendaraan bermotor sebesar 38% setelah penataan pita penggaduh dan rambu zona selamat sekolah.','Penurunan kecepatan kendaraan zona sekolah 38%, artikel terindeks SINTA 3','96% (Sangat Baik)','https://doi.org/10.1234/jpv.2026.rass','community_services/outputs/jurnal_pkm_rass_sekolah_2026.pdf','2026-10-15 05:01:56','2026-10-15 05:01:56'),(2,'ttg','Penerapan Alat Uji Opasitas Portabel Berbasis Mikrokontroler untuk Kalibrasi Mandiri Bengkel Rakyat',57,94,169,'Wahyu Nugroho, M.Sc., Siti Rahmawati, S.Si.T., M.T.',2026,'Asosiasi Bengkel Pantura Mandiri','Desa Kalinyamat Kulon, Kota Tegal','Peralatan uji emisi gas buang diesel portabel yang dihibahkan ke asosiasi mekanik desa guna mempermudah pra-inspeksi kelaikan emisi sebelum kendaraan niaga mengikuti uji berkala resmi KIR.','25 mekanik desa terlatih melakukan kalibrasi dengan akurasi alat mencapai 95%','94% (Sangat Baik)','https://p3m.pktj.ac.id/luaran/ttg-smoke-tester','community_services/outputs/manual_ttg_smoke_tester_2026.pdf','2026-10-15 05:01:56','2026-10-15 05:01:56'),(3,'modul','Buku Saku & SOP Pemeriksaan Kelaikan Sistem Pengereman Truk Berat bagi Paguyuban Sopir Logistik',59,93,164,'Dr. Ir. Hendro Wibowo, M.T., Agus Setiawan, M.T.',2026,'DPC Organda Brebes & Paguyuban Pengemudi Truk Pantura','Kec. Larangan, Kab. Brebes','Buku saku praktis panduan inspeksi kebocoran kompresor udara, batas ketebalan kampas rem pneumatik, dan prosedur pendinginan tromol saat melintasi jalur turunan curam.','Teredukasi 180 pengemudi armada angkutan barang lintas provinsi','92% (Sangat Baik)',NULL,'community_services/outputs/modul_sop_bengkel_rakyat_2026.pdf','2026-10-15 05:01:56','2026-10-15 05:01:56'),(4,'hki','Hak Cipta: Media Pembelajaran Interaktif Titik Buta (Blind Spot) Bus Sekolah untuk Pelajar Menengah',56,92,166,'Budi Santoso, S.T., M.Sc.',2025,'SMK Negeri 1 Slawi Kab. Tegal','Kab. Tegal','Pendaftaran Hak Cipta Kemenkumham (Nomor EC0020251928) atas desain modul visualisasi sudut mati armada bus sekolah dan simulasi pemecahan kaca darurat.','Perolehan sertifikat resmi DJKI Kemenkumham dan diadopsi oleh 12 sekolah mitra binaan','95% (Sangat Baik)','https://pdki-indonesia.dgip.go.id/detail/EC0020251928','community_services/outputs/hki_hak_cipta_modul_blind_spot_2025.pdf','2026-10-15 05:01:56','2026-10-15 05:01:56'),(5,'desa_binaan','Rekayasa Sirkulasi Satu Arah dan Zonasi Parkir Ramah Pejalan Kaki Kawasan Wisata Bahari PAI',61,92,165,'Prof. Dr. Ir. Bambang Suhardi, M.Sc.',2025,'Pokdarwis Pantai Alam Indah & Dishub Kota Tegal','Kota Tegal','Penerapan kanalisasi parkir terpadu dan rambu pemandu sirkulasi satu arah yang mengeliminasi penumpukan kendaraan di pintu masuk kawasan wisata bahari saat libur nasional.','Penurunan antrean kendaraan 60% dan nihil insiden kecelakaan pengunjung','98% (Sangat Baik)',NULL,'community_services/outputs/rekayasa_desa_binaan_pariwisata_2025.pdf','2026-10-15 05:01:56','2026-10-15 05:01:56'),(6,'modul','Panduan Praktis Konversi Motor Bakar ke Motor Listrik BLDC untuk Bengkel Pemuda Pesisir',58,94,167,'Siti Rahmawati, S.Si.T., M.T., Wahyu Nugroho, M.Sc.',2025,'Karang Taruna Bahari Mandiri','Kelurahan Muarareja, Kota Tegal','Buku saku teknis perakitan kit motor listrik 2kW, prosedur keamanan pengkabelan paket baterai litium LFP, dan uji kelistrikan tahan percikan air laut.','Tercipta 2 unit purwarupa motor listrik konversi nelayan pesisir yang laik jalan','91% (Baik)',NULL,'community_services/outputs/buku_panduan_motor_listrik_pesisir_2025.pdf','2026-10-15 05:01:56','2026-10-15 05:01:56'),(7,'desa_binaan','Evaluasi Dampak Audit Rem Dinamik Angkutan Desa terhadap Penurunan Gangguan Teknis Armada',60,93,168,'Agus Setiawan, M.T., Dr. Ir. Hendro Wibowo, M.T.',2024,'Koperasi Angkutan Pedesaan Jatibarang','Kec. Jatibarang, Kab. Brebes','Hasil analisis inspeksi dan perawatan berkala sistem rem pada 40 unit angkutan pedesaan yang menghasilkan catatan nihil insiden mogok rem blong selama 1 tahun operasional.','Zero failure teknis pengereman pada 40 angkutan desa selama 12 bulan','93% (Sangat Baik)',NULL,'community_services/outputs/laporan_evaluasi_dampak_laka_2024.pdf','2026-10-15 05:01:56','2026-10-15 05:01:56');
/*!40000 ALTER TABLE `community_service_outputs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `community_services`
--

DROP TABLE IF EXISTS `community_services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `community_services` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `judul` text NOT NULL,
  `ringkasan` text,
  `prodi_id` bigint unsigned NOT NULL,
  `ketua_pelaksana` varchar(255) NOT NULL,
  `anggota` text,
  `tahun` year NOT NULL,
  `skema` varchar(255) DEFAULT NULL,
  `mitra` varchar(255) DEFAULT NULL,
  `lokasi_kegiatan` varchar(255) DEFAULT NULL,
  `sumber_dana` varchar(255) NOT NULL,
  `anggaran` decimal(15,2) NOT NULL DEFAULT '0.00',
  `berkas_laporan` varchar(255) DEFAULT NULL,
  `status` enum('Berjalan','Selesai') NOT NULL DEFAULT 'Selesai',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `community_services_prodi_id_foreign` (`prodi_id`),
  CONSTRAINT `community_services_prodi_id_foreign` FOREIGN KEY (`prodi_id`) REFERENCES `prodis` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `community_services`
--

LOCK TABLES `community_services` WRITE;
/*!40000 ALTER TABLE `community_services` DISABLE KEYS */;
INSERT INTO `community_services` VALUES (53,'Edukasi dan Audit Kelengkapan Perlengkapan Jalan di Lingkungan Sekolah Ramah Anak',NULL,92,'Siti Rahmawati, S.Si.T., M.T.','Budi Santoso, S.T., M.Sc.',2026,'PkM Kemitraan Wilayah','Dinas Pendidikan Kota Tegal & SD Negeri 1 Kraton',NULL,'Internal PKTJ',15000000.00,NULL,'Selesai','2026-10-14 13:54:27','2026-10-14 13:54:27'),(54,'Peningkatan Keterampilan Mekanik Bengkel Desa dalam Uji Diagnostik Sistem Injeksi Sepeda Motor',NULL,94,'Rahmat Hidayat, M.T.','Wahyu Nugroho, M.Sc.',2025,'PkM Penerapan Teknologi Tepat Guna','Komunitas Bengkel Mandiri Desa Kalinyamat Kulon',NULL,'Internal PKTJ',18000000.00,NULL,'Selesai','2026-10-14 13:54:27','2026-10-14 13:54:27'),(55,'Audit Keselamatan Rute Aman Selamat Sekolah (RASS) dan Pemasangan Marka Kejut Zona Sekolah','Pelaksanaan audit fasilitas pejalan kaki di gerbang sekolah, sosialisasi tata cara menyeberang jalan aman, dan pemasangan rambu peringatan serta pita penggaduh zona selamat sekolah.',92,'Prof. Dr. Ir. Bambang Suhardi, M.Sc.','Budi Santoso, S.T., M.Sc., Rian (Taruna)',2026,'PkM Kemitraan Wilayah','Dinas Perhubungan & SD Negeri 1 Kraton','Kec. Tegal Barat, Kota Tegal','DIPA PKTJ',20000000.00,'community_services/reports/laporan_pkm_rass_sekolah_2026.pdf','Selesai','2026-10-15 03:16:50','2026-10-15 03:16:50'),(56,'Edukasi Titik Buta (Blind Spot) dan Simulasi Evakuasi Darurat Bus Sekolah bagi Pelajar Menengah','Simulasi interaktif area blind spot armada bus besar dan pelatihan pemecahan kaca darurat menggunakan palu keselamatan bagi 150 siswa SMK di koridor lalu lintas Pantura.',92,'Budi Santoso, S.T., M.Sc.','Prof. Dr. Bambang Suhardi, Rian (Taruna)',2025,'PkM Sosialisasi Keselamatan','Dinas Pendidikan & SMK Negeri 1 Slawi','Kec. Slawi, Kabupaten Tegal','DIPA PKTJ',18000000.00,'community_services/reports/laporan_pkm_blind_spot_2025.pdf','Selesai','2026-10-15 03:16:50','2026-10-15 03:16:50'),(57,'Pelatihan Pengujian Emisi Gas Buang dan Standardisasi Kalibrasi Alat Uji bagi Teknisi Bengkel Rakyat','Transfer pengetahuan kalibrasi mandiri smoke tester dan gas analyzer portabel guna mempersiapkan kesiapan bengkel rakyat dalam program kepatuhan uji emisi berkala kendaraan bermotor.',94,'Wahyu Nugroho, M.Sc.','Siti Rahmawati, S.Si.T., M.T., Aldi (Taruna)',2026,'PkM Penerapan Teknologi Tepat Guna','Asosiasi Bengkel Pantura Mandiri','Desa Kalinyamat Kulon, Kota Tegal','Kemdiktisaintek',25000000.00,'community_services/reports/laporan_pkm_emisi_bengkel_2026.pdf','Selesai','2026-10-15 03:16:50','2026-10-15 03:16:50'),(58,'Penerapan Teknologi Konversi Sepeda Motor Listrik bagi Kelompok Usaha Karang Taruna Pesisir','Pelatihan perakitan kit motor listrik 2kW, penyambungan baterai LFP 72V, dan standardisasi wiring kelistrikan yang aman terhadap bahaya arus pendek bagi pemuda pesisir.',94,'Siti Rahmawati, S.Si.T., M.T.','Wahyu Nugroho, M.Sc., Gilang (Taruna)',2025,'PkM Kewirausahaan Vokasi','Karang Taruna Bahari Mandiri','Kelurahan Muarareja, Kota Tegal','Mandiri',22000000.00,'community_services/reports/laporan_pkm_motor_listrik_2025.pdf','Selesai','2026-10-15 03:16:50','2026-10-15 03:16:50'),(59,'Pendampingan Standar Perawatan Berkala Sistem Pengereman Pneumatik bagi Pengemudi Armada Logistik Pantura','Sosialisasi teknis mitigasi brake fade pada truk tronton sarat muatan saat menuruni jalan terjal dan praktik cek mandiri ketebalan kampas rem serta tangki udara bertekanan.',93,'Dr. Ir. Hendro Wibowo, M.T.','Agus Setiawan, M.T., Dimas (Taruna)',2026,'PkM Kemitraan Industri','DPC Organda & Paguyuban Pengemudi Truk Pantura','Kec. Larangan, Kabupaten Brebes','Mitra Industri',30000000.00,'community_services/reports/laporan_pkm_rem_pneumatik_2026.pdf','Selesai','2026-10-15 03:16:50','2026-10-15 03:16:50'),(60,'Sosialisasi Kelaikan Teknis dan Uji Rem Dinamik Kendaraan Angkutan Pedesaan Berkeselamatan','Pemeriksaan teknis gratis efisiensi rem, keselarasan roda depan, dan lampu penerangan bagi 40 unit angkutan desa guna menjamin keselamatan penumpang di rute antar-pasar.',93,'Agus Setiawan, M.T.','Dr. Ir. Hendro Wibowo, Fajar (Taruna)',2024,'PkM Kemitraan Komunitas','Koperasi Angkutan Pedesaan Jatibarang','Kec. Jatibarang, Kabupaten Brebes','DIPA PKTJ',16000000.00,'community_services/reports/laporan_pkm_angkutan_desa_2024.pdf','Selesai','2026-10-15 03:16:50','2026-10-15 03:16:50'),(61,'Penyusunan Rencana Induk Manajemen Lalu Lintas dan Marka Pemandu di Kawasan Wisata Bahari','Pemberian rekomendasi skema rekayasa sirkulasi satu arah saat akhir pekan libur nasional dan penataan zona kantong parkir bus pariwisata agar tidak menimbulkan kemacetan di jalan arteri.',92,'Prof. Dr. Ir. Bambang Suhardi, M.Sc.','Budi Santoso, S.T., M.Sc.',2024,'PkM Tata Kelola Wilayah','Pokdarwis Pantai Alam Indah & Dishub Kota Tegal','Kawasan Wisata PAI, Kota Tegal','Kemdiktisaintek',24000000.00,'community_services/reports/laporan_pkm_pariwisata_bahari_2024.pdf','Selesai','2026-10-15 03:16:50','2026-10-15 03:16:50');
/*!40000 ALTER TABLE `community_services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documents`
--

DROP TABLE IF EXISTS `documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `documents` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `kategori` varchar(50) NOT NULL DEFAULT 'renstra',
  `deskripsi` text,
  `file_path` varchar(255) NOT NULL,
  `file_size` varchar(50) DEFAULT NULL,
  `tahun` varchar(50) DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `download_count` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `documents_user_id_foreign` (`user_id`),
  CONSTRAINT `documents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=196 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documents`
--

LOCK TABLES `documents` WRITE;
/*!40000 ALTER TABLE `documents` DISABLE KEYS */;
INSERT INTO `documents` VALUES (184,'Dokumen Rencana Strategis Penelitian 2026-2031','renstra_penelitian','Arah kebijakan, target indikator kinerja, dan sasaran strategis riset keselamatan transportasi darat 5 tahunan PKTJ.','documents/renstra_penelitian_2026_2031.pdf','3.2 MB','2026 - 2031',163,2,'2026-10-14 13:54:27','2026-10-14 14:08:56'),(185,'Dokumen Rencana Strategis Pengabdian Kepada Masyarakat','renstra_pengabdian','Pedoman tata kelola dan target capaian program pengabdian kepada masyarakat berbasis pemberdayaan desa binaan keselamatan jalan.','documents/renstra_pengabdian_masyarakat.pdf','2.8 MB','2026 - 2031',163,0,'2026-10-14 13:54:27','2026-10-14 13:54:27'),(186,'Rencana Strategis (Renstra) P3M PKTJ 2026 – 2031','renstra','Arah kebijakan induk, target indikator kinerja, dan sasaran strategis riset dan pengabdian institusi PKTJ.','documents/renstra_2026_2031.pdf','2.4 MB','2026',163,0,'2026-10-14 13:54:27','2026-10-14 13:54:27'),(187,'Roadmap Penelitian Keselamatan Transportasi Terpadu','roadmap','Peta jalan riset terpadu fokus teknologi keselamatan transportasi darat dan otomasi.','documents/roadmap_penelitian_pktj.pdf','1.8 MB','2026',163,0,'2026-10-14 13:54:27','2026-10-14 13:54:27'),(188,'Standar Operasional Prosedur (SOP) Pengusulan Riset DIPA','sop_penelitian','Tahapan pengajuan usulan, seleksi administrasi, review substansi hingga pelaporan.','documents/sop_penelitian_dipa.pdf','850 KB','2026',163,0,'2026-10-14 13:54:27','2026-10-14 13:54:27'),(189,'Standar Operasional Prosedur (SOP) Pengabdian kepada Masyarakat','sop_pengabdian','Tata kelola pelaksanaan pendampingan desa binaan, mitra UMKM, dan keselamatan jalan.','documents/sop_pengabdian_masyarakat.pdf','920 KB','2026',163,0,'2026-10-14 13:54:27','2026-10-14 13:54:27'),(190,'Buku Panduan Penggunaan Sistem Informasi (SIM P3M)','panduan_sistem','Panduan teknis pengoperasian portal bagi Dosen Pengusul, Reviewer, dan Verifikator dalam proses pengajuan dan monitoring riset & PkM.','documents/buku_panduan_sim_p3m.pdf','1.5 MB','2026',163,0,'2026-10-14 13:54:27','2026-10-15 07:50:06'),(191,'Pedoman Penelitian dan Pengembangan Sumberdaya Manusia','pedoman_penelitian','Arah kebijakan, etika riset, kualifikasi peneliti, serta pembinaan dan peningkatan kompetensi kepakaran SDM dosen dan taruna PKTJ.','documents/pedoman_penelitian_sdm.pdf','2.1 MB','2026',163,0,'2026-10-15 07:50:06','2026-10-15 07:50:06'),(192,'Pedoman Pengabdian kepada Masyarakat dan Pengembangan Kualitas Kepakaran','pedoman_pengabdian','Panduan pelaksanaan PkM, hilirisasi kepakaran keselamatan jalan, transfer teknologi, serta kemitraan dengan industri dan masyarakat.','documents/pedoman_pkm_kepakaran.pdf','1.9 MB','2026',163,0,'2026-10-15 07:50:06','2026-10-15 07:50:06'),(193,'Dokumen Proses Pengabdian kepada Masyarakat','proses_pengabdian','Standar operasional tahapan pelaksanaan PkM: mulai pengusulan, verifikasi lapangan, implementasi mitra, monitoring evaluasi, hingga pelaporan.','documents/proses_pengabdian_masyarakat.pdf','1.4 MB','2026',163,0,'2026-10-15 07:50:06','2026-10-15 07:50:06'),(194,'Standar Operasional Prosedur (SOP) Monitoring, Evaluasi, dan Pelaporan Akhir Penelitian','sop_penelitian','Mekanisme pemantauan kemajuan riset (monev), verifikasi luaran sementara, hingga penyampaian laporan akhir dan pertanggungjawaban anggaran.','documents/sop_monev_laporan_penelitian.pdf','910 KB','2026',NULL,0,'2026-11-02 07:06:13','2026-11-02 07:06:13'),(195,'Standar Operasional Prosedur (SOP) Monitoring Lapangan dan Pelaporan Luaran PkM','sop_pengabdian','Tata cara inspeksi lapangan kegiatan pengabdian, evaluasi kepuasan mitra sasaran, dan pelaporan luaran berdaya guna.','documents/sop_monev_luaran_pkm.pdf','880 KB','2026',NULL,0,'2026-11-02 07:06:13','2026-11-02 07:06:13');
/*!40000 ALTER TABLE `documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_10_14_000001_create_prodis_table',1),(5,'2026_10_14_000002_add_p3m_columns_to_users_table',1),(6,'2026_10_14_000003_create_posts_table',1),(7,'2026_10_14_000004_create_documents_table',1),(8,'2026_10_14_000005_create_researches_and_community_services_tables',1),(9,'2026_10_14_000006_create_proposals_table',1),(10,'2026_10_14_000007_create_proposal_members_table',1),(11,'2026_10_14_000008_create_proposal_budgets_table',1),(12,'2026_10_14_000009_create_proposal_reviews_table',1),(13,'2026_10_14_000010_create_outputs_and_collaborations_tables',1),(14,'2026_10_14_000011_create_settings_table',1),(15,'2026_10_14_000012_update_documents_kategori_column',1),(16,'2026_10_14_000013_add_user_id_to_researches_and_outputs_tables',2),(17,'2026_10_15_000001_create_organization_members_table',3),(18,'2026_10_15_000002_add_berkas_and_abstrak_to_researches_table',4),(19,'2026_10_15_000003_add_indicators_to_outputs_table',5),(20,'2026_10_15_000016_add_details_to_collaborations_table',6),(21,'2026_10_15_000017_add_details_to_community_services_table',7),(22,'2026_10_15_000018_create_community_service_outputs_table',8),(23,'2026_11_01_000001_update_proposals_status_column',9),(24,'2026_11_02_000001_add_roles_to_users_table',10),(25,'2026_11_02_000002_create_proposal_monevs_table',11),(26,'2026_11_02_000003_create_proposal_final_reports_table',11),(27,'2026_11_02_000004_update_proposal_reviews_table',12),(28,'2026_11_02_000005_add_extended_attributes_to_proposals_table',13),(29,'2026_11_02_000006_add_extended_attributes_to_proposal_members_table',13),(30,'2026_11_02_000007_add_peneliti_extended_fields_to_proposals_table',14),(31,'2026_11_02_000008_add_reviewer_workflow_fields',15);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `organization_members`
--

DROP TABLE IF EXISTS `organization_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `organization_members` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `nip_nidn` varchar(255) DEFAULT NULL,
  `jabatan` varchar(255) NOT NULL,
  `urutan` int NOT NULL DEFAULT '0',
  `foto` varchar(255) DEFAULT NULL,
  `deskripsi_tugas` text,
  `status_aktif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organization_members`
--

LOCK TABLES `organization_members` WRITE;
/*!40000 ALTER TABLE `organization_members` DISABLE KEYS */;
INSERT INTO `organization_members` VALUES (1,'Ir. Bambang Istiyanto, M.T.','196803121994031001','Pelindung & Pengarah Institusional',1,NULL,'Menetapkan arah kebijakan strategis, standar mutu, dan mengawasi implementasi program riset dan pengabdian vokasi di lingkungan civitas akademika PKTJ.',1,'2026-10-15 01:02:24','2026-10-15 01:02:24'),(3,'Dr. Ir. Hendro Wibowo, M.T.','198004122008121001','Kepala Pusat P3M',3,NULL,'Memimpin seluruh tata kelola operasional riset terapan, hilirisasi inovasi, pengabdian masyarakat, sentra HKI, serta kemitraan eksternal.',1,'2026-10-15 01:02:24','2026-10-15 01:02:24'),(4,'Siti Rahmawati, S.Si.T., M.T.','198709282010122003','Sekretaris P3M',4,NULL,'Mengelola ketatausahaan, administrasi pengusulan proposal hibah DIPA, tata kelola keuangan, dan pelaporan akuntabilitas kelembagaan.',1,'2026-10-15 01:02:24','2026-10-15 01:02:24'),(5,'Prof. Dr. Ir. Bambang Suhardi, M.Sc.','197508252000031001','Koordinator Bidang Penelitian & Hilirisasi',5,NULL,'Merumuskan prioritas roadmap riset keselamatan jalan, mengawal seleksi review proposal, serta memfasilitasi hilirisasi teknologi terapan.',1,'2026-10-15 01:02:24','2026-10-15 01:02:24'),(6,'Budi Santoso, S.T., M.Sc.','198502152014021001','Koordinator Bidang Pengabdian kepada Masyarakat',6,NULL,'Mengkoordinasikan program aksi nyata keselamatan transportasi, pembinaan desa mitra, sosialisasi budaya berkendara, dan audit perlengkapan jalan.',1,'2026-10-15 01:02:24','2026-10-15 01:02:24'),(7,'Agus Setiawan, M.T.','198203192009121002','Koordinator Sentra HKI & Publikasi Ilmiah',7,NULL,'Memfasilitasi pendaftaran Hak Cipta, Paten invensi dosen dan taruna, serta mengelola publikasi berkala pada Indonesian Road Safety Journal terindeks SINTA.',1,'2026-10-15 01:02:24','2026-10-15 01:02:24'),(8,'Wahyu Nugroho, M.Sc.','198607112015031001','Staf Administrasi & Pengelola SIM P3M',8,NULL,'Mengelola infrastruktur portal SIM P3M, pemutakhiran basis data luaran dosen, verifikasi berkas digital, dan layanan teknis pengguna.',1,'2026-10-15 01:02:24','2026-10-15 01:02:24'),(9,'Dr. Capt. Tri Cahyadi, M.H., M.Mar.','197405102002121002','Penanggung Jawab Akademik & Riset',2,NULL,'Mengkoordinasikan integrasi hasil penelitian terapan ke dalam kurikulum pembelajaran pada 3 Program Studi resmi PKTJ.',1,'2026-10-15 01:41:39','2026-10-15 01:41:39');
/*!40000 ALTER TABLE `organization_members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `outputs`
--

DROP TABLE IF EXISTS `outputs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `outputs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kategori` enum('publikasi','hki','produk') NOT NULL,
  `judul` text NOT NULL,
  `prodi_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `author_inventor` varchar(255) NOT NULL,
  `tahun` year NOT NULL,
  `nama_jurnal_penerbit` varchar(255) DEFAULT NULL,
  `nomor_registrasi_hki` varchar(255) DEFAULT NULL,
  `tingkat_kesiapan_terapan` varchar(255) DEFAULT NULL,
  `lisensi` varchar(255) DEFAULT NULL,
  `fase_roadmap` varchar(255) DEFAULT NULL,
  `deskripsi_kemanfaatan` text,
  `mitra_kerjasama` varchar(255) DEFAULT NULL,
  `sumber_dana` varchar(255) DEFAULT NULL,
  `realisasi_dana` decimal(15,2) DEFAULT '0.00',
  `link_dokumen` varchar(255) DEFAULT NULL,
  `berkas_luaran` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `outputs_prodi_id_foreign` (`prodi_id`),
  KEY `outputs_user_id_foreign` (`user_id`),
  CONSTRAINT `outputs_prodi_id_foreign` FOREIGN KEY (`prodi_id`) REFERENCES `prodis` (`id`),
  CONSTRAINT `outputs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `outputs`
--

LOCK TABLES `outputs` WRITE;
/*!40000 ALTER TABLE `outputs` DISABLE KEYS */;
INSERT INTO `outputs` VALUES (1,'publikasi','Driver Drowsiness Detection System on Public Transportation Using Facial Landmark and Head Pose Estimation',93,164,'Dr. Ir. Hendro Wibowo, M.T., Agus Setiawan, M.T.',2026,'Indonesian Road Safety Journal (IRSJ) Vol. 4 No. 2',NULL,'TKT 6','CC BY 4.0 (Open Access)','Fase 2 - Inovasi Rekayasa Cerdas','Mencegah kecelakaan armada angkutan umum antar-kota akibat fenomena microsleep pengemudi melalui sistem alarm getar dan audio otomatis.','Perum DAMRI & BPTD Jawa Tengah','DIPA PKTJ',45000000.00,'https://doi.org/10.1234/irsj.v4i2.2026','outputs/artikel_irsj_drowsiness_2026.pdf','2026-10-14 15:03:21','2026-10-15 07:50:06'),(2,'hki','Paten Sederhana: Perangkat Peringatan Dini Kelelahan Pengemudi Berbasis Getar Sabuk Pengaman Aktif',93,164,'Dr. Ir. Hendro Wibowo, M.T., Ir. Bambang Suhardi, M.Sc.',2025,NULL,'IDS000004921','TKT 7','Hak Eksklusif Kedinasan (DJKI Kemenkumham)','Fase 2 - Inovasi Rekayasa Cerdas','Invensi sabuk keselamatan haptik dengan aktuator getar multifrekuensi yang terpicu saat sensor kamera mendeteksi mata terpejam lebih dari 1,5 detik.','PT Hino Motors Manufacturing Indonesia','DIPA PKTJ',60000000.00,'https://pdki-indonesia.dgip.go.id/detail/IDS000004921','outputs/sertifikat_paten_sabuk_haptik_2025.pdf','2026-10-14 15:03:21','2026-10-15 07:50:06'),(3,'publikasi','Spatial Risk Modeling and Identification of Traffic Accident Black Spots along the Northern Java Coastal Highway',92,165,'Prof. Dr. Ir. Bambang Suhardi, M.Sc., Budi Santoso, S.T., M.Sc.',2025,'Journal of Transportation Safety & Security Vol. 17 No. 3 (Scopus Q2)',NULL,'TKT 5','CC BY-NC 4.0 (Open Access)','Fase 1 - Riset Dasar & Titik Rawan','Pemodelan spasial titik rawan kecelakaan (black spot) sebagai acuan penempatan rambu dan rekomendasi perbaikan geometri jalan di jalur logistik Pantura.','Korlantas Polri & Balai Besar Pelaksanaan Jalan Nasional (BBPJN)','Kemdiktisaintek',75000000.00,'https://doi.org/10.1080/19439962.2025.1001','outputs/artikel_scopus_blackspot_2025.pdf','2026-10-14 15:03:21','2026-10-15 07:50:06'),(4,'publikasi','Evaluasi Kinerja Geometrik Tikungan Kritis dan Pengaruhnya Terhadap Stabilitas Kendaraan Berat di Jalur Logistik',92,166,'Budi Santoso, S.T., M.Sc.',2026,'Jurnal Keselamatan Transportasi Darat (SINTA 2) Vol. 8 No. 1',NULL,'TKT 4','CC BY 4.0 (Open Access)','Fase 1 - Riset Dasar & Titik Rawan','Menghitung batas kecepatan aman dan rekomendasi superelevasi jalan untuk mencegah risiko rollover truk tronton.','Dinas Perhubungan Provinsi Jawa Tengah','DIPA PKTJ',38000000.00,'https://doi.org/10.38035/jktd.v8i1.2026','outputs/jurnal_geometrik_logistik_2026.pdf','2026-10-14 15:03:21','2026-10-15 07:50:06'),(5,'hki','Hak Cipta: Desain Sirkuit Kontrol Modulator Pengereman Anti-Lock Elektrik untuk Sepeda Motor Konversi',93,168,'Agus Setiawan, M.T., Hendro Wibowo, M.T.',2025,NULL,'EC00202518290','TKT 6','Lisensi Terbuka Non-Komersial (Open Hardware CC BY-SA)','Fase 3 - Hilirisasi & Kemitraan Industri','Skema modul pengaman rem elektrik anti-selip roda dua untuk bengkel konversi motor listrik UMKM binaan perhubungan.','Kementerian ESDM & Asosiasi Bengkel Konversi','DIPA PKTJ',40000000.00,'https://pdki-indonesia.dgip.go.id/detail/EC00202518290','outputs/sertifikat_hakcipta_abs_konversi_2025.pdf','2026-10-14 15:03:21','2026-10-15 07:50:06'),(6,'publikasi','Karakteristik Efisiensi Termal dan Konsumsi Spesifik Motor Bakar 150cc dengan Variasi Campuran Bioetanol Nira Aren',94,167,'Siti Rahmawati, S.Si.T., M.T.',2025,'Jurnal Rekayasa Otomotif Terapan Vol. 6 No. 2',NULL,'TKT 5',NULL,NULL,NULL,NULL,NULL,0.00,'https://doi.org/10.22146/jrot.v6i2.2025',NULL,'2026-10-14 15:03:21','2026-10-14 15:03:21'),(7,'publikasi','Analisis Opasitas Gas Buang dan Performa Mesin Diesel Common Rail Menggunakan Bahan Bakar B35',94,169,'Wahyu Nugroho, M.Sc., Siti Rahmawati, M.T.',2025,'Jurnal Teknologi Otomotif Vokasi (SINTA 3) Vol. 5 No. 1',NULL,'TKT 4','CC BY 4.0 (Open Access)','Fase 2 - Inovasi Rekayasa Cerdas','Verifikasi kelaikan emisi dan keausan injektor kendaraan komersial berbahan bakar nabati biodiesel kelapa sawit B35.','Balai Pengujian Laik Jalan dan Sertifikasi Kendaraan Bermotor (BPLJSKB)','Mitra Industri',30000000.00,'https://doi.org/10.31294/jtov.v5i1.2025','outputs/jurnal_emisi_b35_2025.pdf','2026-10-14 15:03:21','2026-10-15 07:50:06'),(8,'hki','Hak Cipta: Perangkat Lunak Road Safety Audit Automation System (ROSA-PKTJ v1.0)',92,166,'Budi Santoso, S.T., M.Sc., Siti Rahmawati, M.T.',2026,NULL,'EC00202610452','TKT 7','GPL v3.0 (Open Source Software)','Fase 3 - Hilirisasi & Kemitraan Industri','Aplikasi otomasi kalkulasi risiko geometrik dan inspeksi kelaikan jalan terstandar pedoman audit keselamatan jalan Kementerian Perhubungan.','Direktorat Keselamatan Transportasi Jalan, Ditjen Hubdat','DIPA PKTJ',50000000.00,'https://pdki-indonesia.dgip.go.id/detail/EC00202610452','outputs/sertifikat_software_rosa_2026.pdf','2026-10-15 02:05:45','2026-10-15 07:50:06'),(9,'produk','Purwarupa Portable Speed Limiter & Data Logger Cerdas untuk Angkutan Barang Curah Cair',93,168,'Agus Setiawan, M.T., Hendro Wibowo, M.T., Tim Taruna TRO',2026,NULL,NULL,'TKT 8','Open Source Hardware (CERN-OHL-W)','Fase 3 - Hilirisasi & Kemitraan Industri','Perangkat pembatas kecepatan elektronik terintegrasi GPS telemetry yang membatasi suplai bahan bakar ketika kendaraan memasuki zona turunan curam rawan rem blong.','PT Pertamina Patra Niaga Regional Jawa Bagian Tengah','Mitra Industri',85000000.00,'https://p3m.pktj.ac.id/produk/speed-limiter-logger','outputs/spesifikasi_teknis_speed_limiter_2026.pdf','2026-10-15 02:05:45','2026-10-15 07:50:06'),(10,'produk','Naskah Rekomendasi Kebijakan: Pedoman Teknis Pemasangan Fasilitas Penenang Lalu Lintas (Traffic Calming) Kawasan Sekolah Vokasi',92,166,'Budi Santoso, S.T., M.Sc., Prof. Bambang Suhardi, M.Sc.',2025,NULL,NULL,'TKT 9','Creative Commons Public Domain (CC0 1.0)','Fase 3 - Hilirisasi & Kemitraan Industri','Rancangan pedoman standar penempatan speed table, pita penggaduh, dan zona selamat sekolah (ZoSS) yang telah diadopsi dan diundangkan Pemerintah Kota Tegal.','Pemerintah Kota Tegal & BPTD Kelas II Jawa Tengah','DIPA PKTJ',35000000.00,'https://jdih.tegalkota.go.id/pedoman-zoss-2025','outputs/naskah_kebijakan_zoss_pktj_2025.pdf','2026-10-15 02:05:45','2026-10-15 07:50:06'),(11,'produk','Alat Portable Smoke Opacity Tester Berbasis Sensor Inframerah untuk Uji Berkala Kendaraan Bermotor Lapangan',94,169,'Wahyu Nugroho, M.Sc., Siti Rahmawati, M.T.',2026,NULL,NULL,'TKT 7','Lisensi Terbuka Akademik (MIT License)','Fase 2 - Inovasi Rekayasa Cerdas','Alat ukur kepekatan asap kendaraan diesel portabel bobot ringan (kurang dari 2 kg) untuk operasi gabungan penegakan hukum kelaikan jalan Dishub dan Kepolisian.','Unit Pelaksana Pengujian Berkala Kendaraan Bermotor (UPPKB) Margadana','DIPA PKTJ',42000000.00,'https://p3m.pktj.ac.id/produk/smoke-opacity-tester','outputs/manual_uji_smoke_tester_2026.pdf','2026-10-15 02:05:45','2026-10-15 07:50:06');
/*!40000 ALTER TABLE `outputs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `kategori` enum('berita','agenda','pengumuman') NOT NULL DEFAULT 'berita',
  `ringkasan` text,
  `konten` longtext NOT NULL,
  `gambar_sampul` varchar(255) DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `status` enum('draft','published') NOT NULL DEFAULT 'published',
  `tanggal_publikasi` date DEFAULT NULL,
  `is_pinned` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `posts_slug_unique` (`slug`),
  KEY `posts_user_id_foreign` (`user_id`),
  CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (80,'Sosialisasi Panduan Call for Proposals Penelitian & Pengabdian PKTJ Tahun Anggaran 2026','sosialisasi-panduan-call-for-proposals-2026','pengumuman','Pusat Penelitian dan Pengabdian kepada Masyarakat (P3M) mengumumkan pembukaan periode pengajuan usulan hibah DIPA institusi.','Dalam rangka meningkatkan mutu luaran riset terapan dan hilirisasi produk keselamatan transportasi jalan, P3M PKTJ membuka penerimaan proposal penelitian dan pengabdian kepada masyarakat untuk Tahun Anggaran 2026. Batas akhir pengajuan usulan melalui sistem SIM P3M adalah 30 April 2026.',NULL,163,'published','2026-10-15',1,'2026-10-14 13:54:27','2026-10-15 07:50:06'),(81,'Diseminasi Hasil Riset Prototipe Sensor Blind Spot Monitoring Kendaraan Berat di Jalur Logistik','diseminasi-hasil-riset-sensor-blind-spot-kendaraan-berat','berita','Dosen Prodi D4 TRO memaparkan inovasi perangkat keselamatan aktif pendeteksi titik buta pada armada bus dan truk.','Uji lapang sistem peringatan dini berbasis sensor ultrasonik dan pemrosesan citra digital berhasil membuktikan peningkatan kewaspadaan pengemudi saat bermanuver di jalan arteri sempit Pantura.',NULL,163,'published','2026-10-12',0,'2026-10-14 13:54:27','2026-10-15 07:50:06'),(82,'Workshop Penyusunan Proposal Berstandar SINTA & Paten Sederhana Bagi Dosen Vokasi','workshop-penyusunan-proposal-berstandar-sinta-dan-paten','agenda','Pelatihan intensif penulisan manuskrip ilmiah bereputasi dan pendaftaran Hak Kekayaan Intelektual bagi seluruh civitas akademika.','Kegiatan diselenggarakan pada Ruang Rapat P3M Lt. 2 Kampus PKTJ Tegal menghadirkan narasumber reviewer nasional Kemdiktisaintek.',NULL,163,'published','2026-10-20',0,'2026-10-14 13:54:27','2026-10-15 07:50:06');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prodis`
--

DROP TABLE IF EXISTS `prodis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prodis` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode_prodi` varchar(20) NOT NULL,
  `nama_prodi` varchar(150) NOT NULL,
  `jenjang` varchar(10) NOT NULL,
  `deskripsi` text,
  `status_aktif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `prodis_kode_prodi_unique` (`kode_prodi`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prodis`
--

LOCK TABLES `prodis` WRITE;
/*!40000 ALTER TABLE `prodis` DISABLE KEYS */;
INSERT INTO `prodis` VALUES (92,'RSTJ','Rekayasa Sistem Transportasi Jalan','D4','Program Sarjana Terapan Rekayasa Sistem Transportasi Jalan berfokus pada perencanaan transportasi, manajemen dan rekayasa lalu lintas, serta audit keselamatan jalan.',1,'2026-10-14 13:54:26','2026-10-14 13:54:26'),(93,'TRO','Teknologi Rekayasa Otomotif','D4','Program Sarjana Terapan Teknologi Rekayasa Otomotif berfokus pada desain dan rancang bangun kendaraan, konversi armada listrik, serta pengujian berkala kelaikan kendaraan bermotor.',1,'2026-10-14 13:54:26','2026-10-14 13:54:26'),(94,'TO','Teknologi Otomotif','D3','Program Diploma Tiga Teknologi Otomotif mencetak tenaga ahli madya yang kompeten dalam pemeliharaan armada, diagnostik kelistrikan kendaraan, dan pengujian emisi.',1,'2026-10-14 13:54:26','2026-10-14 13:54:26');
/*!40000 ALTER TABLE `prodis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proposal_budgets`
--

DROP TABLE IF EXISTS `proposal_budgets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proposal_budgets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `proposal_id` bigint unsigned NOT NULL,
  `kategori_belanja` enum('bahan_habis_pakai','sewa_alat','perjalanan_lapangan','honorarium','publikasi_diseminasi','lainnya') NOT NULL DEFAULT 'bahan_habis_pakai',
  `tahun_ke` tinyint unsigned NOT NULL DEFAULT '1',
  `uraian` varchar(255) NOT NULL,
  `volume` decimal(10,2) NOT NULL DEFAULT '1.00',
  `satuan` varchar(50) NOT NULL DEFAULT 'paket',
  `harga_satuan` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_harga` decimal(15,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `proposal_budgets_proposal_id_foreign` (`proposal_id`),
  CONSTRAINT `proposal_budgets_proposal_id_foreign` FOREIGN KEY (`proposal_id`) REFERENCES `proposals` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proposal_budgets`
--

LOCK TABLES `proposal_budgets` WRITE;
/*!40000 ALTER TABLE `proposal_budgets` DISABLE KEYS */;
/*!40000 ALTER TABLE `proposal_budgets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proposal_final_reports`
--

DROP TABLE IF EXISTS `proposal_final_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proposal_final_reports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `proposal_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `file_laporan_akhir` varchar(255) NOT NULL,
  `file_revisi_laporan` varchar(255) DEFAULT NULL,
  `ringkasan_hasil` text,
  `perubahan_anggota` text,
  `total_realisasi_anggaran` decimal(15,2) NOT NULL DEFAULT '0.00',
  `rincian_realisasi` json DEFAULT NULL,
  `file_bukti_spj` varchar(255) DEFAULT NULL,
  `capaian_luaran` json DEFAULT NULL,
  `status_laporan` varchar(50) NOT NULL DEFAULT 'terkirim',
  `total_skor_laporan` decimal(5,2) DEFAULT NULL,
  `catatan_reviewer` text,
  `file_catatan_revisi` varchar(255) DEFAULT NULL,
  `konfirmasi_hasil` varchar(255) NOT NULL DEFAULT 'setuju',
  `tanggal_penyerahan` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `proposal_final_reports_proposal_id_foreign` (`proposal_id`),
  KEY `proposal_final_reports_user_id_foreign` (`user_id`),
  CONSTRAINT `proposal_final_reports_proposal_id_foreign` FOREIGN KEY (`proposal_id`) REFERENCES `proposals` (`id`) ON DELETE CASCADE,
  CONSTRAINT `proposal_final_reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proposal_final_reports`
--

LOCK TABLES `proposal_final_reports` WRITE;
/*!40000 ALTER TABLE `proposal_final_reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `proposal_final_reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proposal_members`
--

DROP TABLE IF EXISTS `proposal_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proposal_members` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `proposal_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `peran` varchar(50) NOT NULL DEFAULT 'dosen_anggota',
  `kategori_anggota` varchar(30) NOT NULL DEFAULT 'internal',
  `asal_instansi` varchar(255) DEFAULT NULL,
  `negara` varchar(100) NOT NULL DEFAULT 'Indonesia',
  `nidn_nim` varchar(30) DEFAULT NULL,
  `tugas` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `proposal_members_proposal_id_foreign` (`proposal_id`),
  KEY `proposal_members_user_id_foreign` (`user_id`),
  CONSTRAINT `proposal_members_proposal_id_foreign` FOREIGN KEY (`proposal_id`) REFERENCES `proposals` (`id`) ON DELETE CASCADE,
  CONSTRAINT `proposal_members_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proposal_members`
--

LOCK TABLES `proposal_members` WRITE;
/*!40000 ALTER TABLE `proposal_members` DISABLE KEYS */;
/*!40000 ALTER TABLE `proposal_members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proposal_monevs`
--

DROP TABLE IF EXISTS `proposal_monevs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proposal_monevs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `proposal_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `capaian_penelitian` varchar(50) NOT NULL,
  `publikasi_ilmiah` varchar(50) NOT NULL,
  `pemakalah_ilmiah` varchar(50) NOT NULL,
  `hki` varchar(50) NOT NULL,
  `teknologi_tepat_guna` varchar(50) NOT NULL,
  `produk_purwarupa` varchar(50) NOT NULL,
  `buku_ajar` varchar(50) NOT NULL,
  `kegiatan_terlaksana` text NOT NULL,
  `kesesuaian_waktu` text NOT NULL,
  `kesesuaian_metode` text NOT NULL,
  `kesesuaian_personalia` text NOT NULL,
  `kesesuaian_anggaran` text NOT NULL,
  `kesesuaian_sarpras` text NOT NULL,
  `kesesuaian_target` text NOT NULL,
  `file_bukti_luaran` varchar(255) DEFAULT NULL,
  `status_monev` varchar(50) NOT NULL DEFAULT 'terkirim',
  `total_skor_monev` decimal(5,2) DEFAULT NULL,
  `catatan_reviewer` text,
  `konfirmasi_hasil` varchar(255) NOT NULL DEFAULT 'setuju',
  `tanggal_monev` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `proposal_monevs_proposal_id_foreign` (`proposal_id`),
  KEY `proposal_monevs_user_id_foreign` (`user_id`),
  CONSTRAINT `proposal_monevs_proposal_id_foreign` FOREIGN KEY (`proposal_id`) REFERENCES `proposals` (`id`) ON DELETE CASCADE,
  CONSTRAINT `proposal_monevs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proposal_monevs`
--

LOCK TABLES `proposal_monevs` WRITE;
/*!40000 ALTER TABLE `proposal_monevs` DISABLE KEYS */;
/*!40000 ALTER TABLE `proposal_monevs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proposal_reviews`
--

DROP TABLE IF EXISTS `proposal_reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proposal_reviews` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `proposal_id` bigint unsigned NOT NULL,
  `reviewer_id` bigint unsigned NOT NULL,
  `skor_urgensi` decimal(5,2) DEFAULT NULL,
  `skor_metodologi` decimal(5,2) DEFAULT NULL,
  `skor_kelayakan_rab` decimal(5,2) DEFAULT NULL,
  `skor_luaran` decimal(5,2) DEFAULT NULL,
  `total_skor` decimal(5,2) DEFAULT NULL,
  `detail_nilai` json DEFAULT NULL,
  `catatan_reviewer` text,
  `file_catatan_revisi` varchar(255) DEFAULT NULL,
  `rekomendasi` varchar(50) DEFAULT NULL,
  `status_review` enum('menunggu','selesai') NOT NULL DEFAULT 'menunggu',
  `disetujui_review_at` timestamp NULL DEFAULT NULL,
  `batas_waktu_review` date DEFAULT NULL,
  `persetujuan_komitmen` tinyint(1) NOT NULL DEFAULT '1',
  `konfirmasi_hasil` varchar(255) NOT NULL DEFAULT 'setuju',
  `tanggal_review` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `proposal_reviews_proposal_id_foreign` (`proposal_id`),
  KEY `proposal_reviews_reviewer_id_foreign` (`reviewer_id`),
  CONSTRAINT `proposal_reviews_proposal_id_foreign` FOREIGN KEY (`proposal_id`) REFERENCES `proposals` (`id`) ON DELETE CASCADE,
  CONSTRAINT `proposal_reviews_reviewer_id_foreign` FOREIGN KEY (`reviewer_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proposal_reviews`
--

LOCK TABLES `proposal_reviews` WRITE;
/*!40000 ALTER TABLE `proposal_reviews` DISABLE KEYS */;
/*!40000 ALTER TABLE `proposal_reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proposals`
--

DROP TABLE IF EXISTS `proposals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proposals` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode_usulan` varchar(50) NOT NULL,
  `jenis` enum('penelitian','pengabdian') NOT NULL,
  `judul` text NOT NULL,
  `abstrak` text,
  `kata_kunci` varchar(255) DEFAULT NULL,
  `prodi_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `tahun_anggaran` year NOT NULL,
  `lama_kegiatan_tahun` tinyint unsigned NOT NULL DEFAULT '1',
  `skema` varchar(255) NOT NULL,
  `bidang_fokus` varchar(255) DEFAULT NULL,
  `topik_kegiatan` varchar(255) DEFAULT NULL,
  `lokasi_kegiatan` varchar(255) DEFAULT NULL,
  `sumber_dana` varchar(255) NOT NULL DEFAULT 'DIPA PKTJ',
  `total_anggaran` decimal(15,2) NOT NULL DEFAULT '0.00',
  `bank_nama` varchar(100) DEFAULT NULL,
  `bank_rekening` varchar(50) DEFAULT NULL,
  `bank_pemilik` varchar(150) DEFAULT NULL,
  `file_proposal` varchar(255) DEFAULT NULL,
  `nama_berkas_proposal` varchar(255) DEFAULT NULL,
  `file_revisi` varchar(255) DEFAULT NULL,
  `nama_mitra` varchar(255) DEFAULT NULL,
  `kontribusi_mitra` varchar(255) DEFAULT NULL,
  `dana_mitra` decimal(15,2) DEFAULT NULL,
  `dana_tambahan` decimal(15,2) DEFAULT NULL,
  `file_mitra` varchar(255) DEFAULT NULL,
  `luaran_target` json DEFAULT NULL,
  `jadwal_kegiatan` json DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'draft',
  `persetujuan_konfirmasi` tinyint(1) NOT NULL DEFAULT '0',
  `catatan_admin` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `proposals_kode_usulan_unique` (`kode_usulan`),
  KEY `proposals_prodi_id_foreign` (`prodi_id`),
  KEY `proposals_user_id_foreign` (`user_id`),
  CONSTRAINT `proposals_prodi_id_foreign` FOREIGN KEY (`prodi_id`) REFERENCES `prodis` (`id`),
  CONSTRAINT `proposals_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proposals`
--

LOCK TABLES `proposals` WRITE;
/*!40000 ALTER TABLE `proposals` DISABLE KEYS */;
/*!40000 ALTER TABLE `proposals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `researches`
--

DROP TABLE IF EXISTS `researches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `researches` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `judul` text NOT NULL,
  `abstrak` text,
  `prodi_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ketua_peneliti` varchar(255) NOT NULL,
  `anggota` text,
  `tahun` year NOT NULL,
  `skema` varchar(255) DEFAULT NULL,
  `sumber_dana` varchar(255) NOT NULL,
  `anggaran` decimal(15,2) NOT NULL DEFAULT '0.00',
  `berkas_laporan` varchar(255) DEFAULT NULL,
  `status` enum('Berjalan','Selesai') NOT NULL DEFAULT 'Selesai',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `researches_prodi_id_foreign` (`prodi_id`),
  KEY `researches_user_id_foreign` (`user_id`),
  CONSTRAINT `researches_prodi_id_foreign` FOREIGN KEY (`prodi_id`) REFERENCES `prodis` (`id`),
  CONSTRAINT `researches_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `researches`
--

LOCK TABLES `researches` WRITE;
/*!40000 ALTER TABLE `researches` DISABLE KEYS */;
INSERT INTO `researches` VALUES (105,'Rancang Bangun Sensor Deteksi Kelelahan Pengemudi Angkutan Umum Berbasis Computer Vision','Penelitian ini mengembangkan sistem cerdas berbasis computer vision untuk memantau kedipan mata dan gerakan kepala pengemudi bus antarkota secara waktu-nyata guna mencegah kecelakaan fatal akibat microsleep.',93,164,'Dr. Ir. Hendro Wibowo, M.T.','Agus Setiawan, M.T., Dimas (Taruna)',2026,'Penelitian Terapan Unggulan','DIPA Kemenhub',45000000.00,NULL,'Selesai','2026-10-14 13:54:27','2026-10-15 01:41:39'),(106,'Analisis Daerah Rawan Kecelakaan (Black Spot) pada Ruas Arteri Pantura Menggunakan Algoritma Geografis',NULL,92,NULL,'Budi Santoso, S.T., M.Sc.','Prof. Dr. Bambang Suhardi, Rian (Taruna)',2026,'Penelitian Dosen Pemula','Internal PKTJ',25000000.00,NULL,'Berjalan','2026-10-14 13:54:27','2026-10-14 13:54:27'),(107,'Pengembangan Purwarupa Pengereman Anti-Lock Braking System (ABS) untuk Kendaraan Listrik Roda Dua Vokasi','Inovasi aktuator hidrolik mikro dan modul ECU ABS mandiri yang dirancang untuk mencegah penguncian roda sepeda motor listrik pada permukaan basah, mendukung hilirisasi industri otomotif nasional.',93,168,'Agus Setiawan, M.T.','Dr. Ir. Hendro Wibowo, Fajar (Taruna)',2025,'Penelitian Hilirisasi Industri','Kemdiktisaintek',50000000.00,NULL,'Selesai','2026-10-14 13:54:27','2026-10-15 01:41:39'),(108,'Uji Karakteristik Emisi Gas Buang Kendaraan Niaga Berbahan Bakar Biosolar Campuran',NULL,94,NULL,'Wahyu Nugroho, M.Sc.','Rahmat Hidayat, M.T., Aldi (Taruna)',2025,'Penelitian Terapan','Kerjasama Industri',35000000.00,NULL,'Selesai','2026-10-14 13:54:27','2026-10-14 13:54:27'),(109,'Pemetaan Spasial Daerah Rawan Kecelakaan (Black Spot) pada Ruas Arteri Pantura Menggunakan Algoritma Geografis','Studi komprehensif mengintegrasikan data historis laka lantas Korlantas Polri dengan Sistem Informasi Geografis (SIG) untuk merumuskan rekomendasi rekayasa geometrik simpang dan rambu peringatan dini di jalur Pantura.',92,165,'Prof. Dr. Ir. Bambang Suhardi, M.Sc.','Budi Santoso, S.T., M.Sc., Rian (Taruna)',2026,'Penelitian Terapan Kebijakan','DIPA Kemenhub',40000000.00,NULL,'Selesai','2026-10-14 15:03:21','2026-10-15 01:41:39'),(110,'Analisis Kinerja Geometrik Simpang Tak Bersinyal untuk Mitigasi Titik Konflik Lalu Lintas Perkotaan','Evaluasi kapasitas simpang prioritas, derajat kejenuhan, dan tundaan kendaraan perkotaan untuk menghasilkan usulan kanalisasi arus dan optimalisasi pulau lalu lintas sesuai pedoman MKJI.',92,166,'Budi Santoso, S.T., M.Sc.','Prof. Dr. Bambang Suhardi, Rian (Taruna)',2026,'Penelitian Dosen Pemula','DIPA PKTJ',25000000.00,NULL,'Berjalan','2026-10-14 15:03:21','2026-10-15 01:41:39'),(111,'Uji Karakteristik Emisi Gas Buang Kendaraan Niaga Berbahan Bakar Biosolar Campuran B35','Pengujian performa torsi, opasitas asap, dan konsumsi spesifik bahan bakar solar B35 pada kendaraan niaga muatan berat di laboratorium uji motor bakar PKTJ bekerjasama dengan industri karoseri mitra.',94,169,'Wahyu Nugroho, M.Sc.','Siti Rahmawati, S.Si.T., M.T., Aldi (Taruna)',2025,'Penelitian Terapan','Mitra Industri',35000000.00,NULL,'Selesai','2026-10-14 15:03:21','2026-10-15 01:41:39'),(112,'Rancang Bangun Sistem Konversi Sepeda Motor Konvensional Menjadi Motor Listrik Ramah Lingkungan','Rancang bangun kit konversi motor bakar 110cc ke motor listrik BLDC 2kW dengan konfigurasi baterai lithium-ferro phosphate (LFP) 72V 20Ah bersertifikasi uji kelaikan teknis Kemenhub.',94,167,'Siti Rahmawati, S.Si.T., M.T.','Wahyu Nugroho, M.Sc., Gilang (Taruna)',2026,'Penelitian Terapan Vokasi','Mandiri',30000000.00,NULL,'Berjalan','2026-10-14 15:03:21','2026-10-15 01:41:39');
/*!40000 ALTER TABLE `researches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('6rzAAy04TQfUdZCWqRyVKOXCMgGy0ybf77ES6AGL',164,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSGd2eHBOUExobDhXaHJ4MGdtYWNUMWYzc3M1MVVSdk5DVjJ2WlVUZSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDY6Imh0dHA6Ly9wM20udGVzdC9kb3Nlbi9kYXNoYm9hcmQ/dGFiPXBlbmdhYmRpYW4iO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxNjQ7fQ==',1793609805),('DBfUjcSgAaoavwAMhbPOsK7b5dILkm4UCJC74ijR',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiRTZNNk5Iak5pTElycmxEVGFvTnBHTVVsNjVCbHVORFhYeUU5SkFobiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTE6Imh0dHA6Ly9wM20udGVzdC9wZW5nYWJkaWFuL3BrbT9zdW1iZXJfZGFuYT1pbmR1c3RyaSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1792050108),('m3cufgbK6uaqqjnwOVcsGimquagZOpK9yYgbqlkO',163,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRTB4RDVYRHhEenhxcmxMT09UVFZGUng4WlJNZGJlTHlzaVF5cWlnciI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9wM20udGVzdC9sb2dpbiI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE2Mzt9',1793540691),('nqvZifUaaxivUJwXY1RkLA543VJtF22LBpyRB5Nl',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiS25LODBtVWxxOWZMTmZTeDNnWXNGRXNCNTRWaURoMnpjWEs1Mm5vZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTU6Imh0dHA6Ly9wM20udGVzdCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1793595901),('SJ5rsIgRVD6NiKawWuzUSQDoCaexIAJQvnbqmBCM',163,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQVk1U3JKWnE0akxvTGMzalU1eVE5RGxQTlcwcHlTS0RISm40bmJ1eCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTU6Imh0dHA6Ly9wM20udGVzdCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE2Mzt9',1793542918),('Tde5niKIeDkht5HBpjQ4RIv5gCrxMnmqLfrhLfau',163,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSVVGa3FxaG1ZNk5FSG9ZM2hpMWhJejY2YVRpMzA5UlRPVW5SZWw5OCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9wM20udGVzdC9hZG1pbi9wb3N0cyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE2Mzt9',1793679851),('tI6PjU8EBwkOAzY36dICFxmPR5LqXI9bCzrPwtJT',163,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTldWVWdNUXlmYnJnSzgxdnhFQ0tDVVlUU2FKd2ZmQzZLOEtleWZHWCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9wM20udGVzdC9wZW5nYWJkaWFuL3BrbSI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE2Mzt9',1792039976);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` longtext,
  `group` varchar(255) NOT NULL DEFAULT 'general',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`),
  KEY `settings_group_index` (`group`)
) ENGINE=InnoDB AUTO_INCREMENT=347 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (313,'video_profile_url','https://www.youtube.com/watch?v=5F_fNlPGBdQ','homepage','2026-10-14 13:54:27','2026-10-14 13:54:27'),(314,'video_profile_title','Video Profil P3M PKTJ Tegal','homepage','2026-10-14 13:54:27','2026-10-14 13:54:27'),(315,'video_profile_desc','Inovasi Riset Unggulan Keselamatan Transportasi Jalan & Pengabdian Vokasi','homepage','2026-10-14 13:54:27','2026-10-14 13:54:27'),(316,'video_profile_active','1','homepage','2026-10-14 13:54:27','2026-10-14 13:54:27'),(317,'about_lead','Pusat Penelitian dan Pengabdian kepada Masyarakat (P3M) merupakan unit pelaksana strategis di lingkungan Politeknik Keselamatan Transportasi Jalan (PKTJ) Tegal di bawah naungan Badan Pengembangan Sumber Daya Manusia Perhubungan (BPSDMP), Kementerian Perhubungan Republik Indonesia.','homepage','2026-10-14 13:54:27','2026-10-14 13:54:27'),(318,'about_vision_mission','P3M PKTJ berkomitmen mengakselerasi inovasi teknologi terapan yang solutif guna menurunkan angka fatalitas kecelakaan lalu lintas nasional, mengoptimalkan kelaikan operasional kendaraan bermotor, dan mentransfer pengetahuan ilmiah langsung kepada masyarakat, industri transportasi, dan instansi pembina keselamatan.','homepage','2026-10-14 13:54:27','2026-10-14 13:54:27'),(319,'facility_1_title','Laboratorium Uji Keselamatan','homepage','2026-10-14 13:54:27','2026-10-14 13:54:27'),(320,'facility_1_desc','Fasilitas uji terstandar untuk simulasi dinamika kendaraan, uji pengereman aktif, dan visualisasi geometri jalan.','homepage','2026-10-14 13:54:27','2026-10-14 13:54:27'),(321,'facility_2_title','Audit Koridor Pantura Jawa','homepage','2026-10-14 13:54:27','2026-10-14 13:54:27'),(322,'facility_2_desc','Survei lapangan berkala di koridor pantai utara Jawa Tengah untuk memetakan titik rawan kecelakaan (black spot).','homepage','2026-10-14 13:54:27','2026-10-14 13:54:27'),(323,'facility_3_title','Aksi Nyata Pengabdian','homepage','2026-10-14 13:54:27','2026-10-14 13:54:27'),(324,'facility_3_desc','Sosialisasi budaya keselamatan berkendara bagi pelajar, pengemudi angkutan umum, dan bengkel mitra binaan.','homepage','2026-10-14 13:54:27','2026-10-14 13:54:27'),(325,'visi_title','Visi P3M Politeknik Keselamatan Transportasi Jalan','visi_misi','2026-10-14 14:08:56','2026-10-14 14:08:56'),(326,'visi_statement','Menjadi pusat rujukan riset terapan dan pengabdian masyarakat unggulan berbasis keselamatan transportasi jalan yang solutif, berdaya saing global, dan berintegritas pada tahun 2031.','visi_misi','2026-10-14 14:08:56','2026-10-14 14:08:56'),(327,'visi_subtext','Mengakselerasi terwujudnya transportasi darat nasional yang selamat, tertib, dan berkelanjutan melalui keunggulan riset vokasi sivitas akademika PKTJ di bawah Badan Pengembangan SDM Perhubungan.','visi_misi','2026-10-14 14:08:57','2026-10-14 14:08:57'),(328,'misi_1','Menyelenggarakan penelitian terapan yang inovatif dan solutif guna memitigasi titik rawan kecelakaan (black spot) dan meningkatkan keselamatan transportasi darat.','visi_misi','2026-10-14 14:08:57','2026-10-14 14:08:57'),(329,'misi_2','Melaksanakan pengabdian kepada masyarakat berbasis aksi nyata, edukasi budaya keselamatan berkendara, pendampingan desa binaan, dan standardisasi bengkel rakyat.','visi_misi','2026-10-14 14:08:57','2026-10-14 14:08:57'),(330,'misi_3','Mengembangkan kemitraan riset sinergis dengan Kementerian Perhubungan, Korlantas Polri, KNKT, pemerintah daerah, dan industri manufaktur otomotif nasional.','visi_misi','2026-10-14 14:08:57','2026-10-14 14:08:57'),(331,'misi_4','Mendorong hilirisasi invensi teknologi keselamatan, percepatan perolehan Hak Kekayaan Intelektual (HKI/Paten), serta publikasi berkala pada jurnal ilmiah terakreditasi.','visi_misi','2026-10-14 14:08:57','2026-10-14 14:08:57'),(332,'misi_5','Mengoptimalkan tata kelola kelembagaan P3M yang transparan, akuntabel, dan berbasis sistem informasi digital (SIM P3M) berstandar mutu pendidikan tinggi vokasi.','visi_misi','2026-10-14 14:08:57','2026-10-14 14:08:57'),(333,'tujuan_lead','Tujuan strategis P3M PKTJ dirumuskan untuk menjamin ketercapaian sasaran mutu kelembagaan dan kontribusi nyata bagi keselamatan lalu lintas nasional.','visi_misi','2026-10-14 14:08:57','2026-10-14 14:08:57'),(334,'tujuan_1_title','Reduksi Fatalitas Kecelakaan','visi_misi','2026-10-14 14:08:57','2026-10-14 14:08:57'),(335,'tujuan_1_desc','Menghasilkan rekomendasi teknis audit keselamatan jalan dan rekayasa simpang yang menurunkan angka fatalitas korban lalu lintas nasional.','visi_misi','2026-10-14 14:08:57','2026-10-14 14:08:57'),(336,'tujuan_2_title','Kemandirian Riset Vokasi','visi_misi','2026-10-14 14:08:57','2026-10-14 14:08:57'),(337,'tujuan_2_desc','Meningkatkan kuantitas dan kualitas penelitian terapan dosen dan taruna yang didanai DIPA Kemenhub, Kemdiktisaintek, maupun mitra industri.','visi_misi','2026-10-14 14:08:57','2026-10-14 14:08:57'),(338,'tujuan_3_title','Penguatan HKI & Jurnal Ilmiah','visi_misi','2026-10-14 14:08:57','2026-10-14 14:08:57'),(339,'tujuan_3_desc','Meningkatkan perolehan paten invensi, hak cipta desain industri, dan publikasi artikel ilmiah pada Indonesian Road Safety Journal terindeks SINTA.','visi_misi','2026-10-14 14:08:57','2026-10-14 14:08:57'),(340,'tujuan_4_title','Pemberdayaan Masyarakat Pantura','visi_misi','2026-10-14 14:08:57','2026-10-14 14:08:57'),(341,'tujuan_4_desc','Memperluas jangkauan desa binaan tertib lalu lintas dan transfer teknologi standardisasi uji kelaikan armada ke bengkel UMKM mitra.','visi_misi','2026-10-14 14:08:57','2026-10-14 14:08:57'),(342,'org_sk_number','SK Direktur PKTJ No. KP.004/1/12/PKTJ-2026','organization','2026-10-15 01:02:24','2026-10-15 01:02:24'),(343,'org_period','2026 – 2031','organization','2026-10-15 01:02:24','2026-10-15 01:02:24'),(344,'org_chart_image',NULL,'organization','2026-10-15 01:02:24','2026-10-15 01:02:24'),(345,'org_title','Struktur Organisasi & Tata Kelola P3M PKTJ','organization','2026-10-15 01:02:24','2026-10-15 01:02:24'),(346,'org_lead_text','Pusat Penelitian dan Pengabdian kepada Masyarakat (P3M) merupakan unit pelaksana strategis bidang riset terapan dan pengabdian masyarakat di lingkungan Politeknik Keselamatan Transportasi Jalan, berkedudukan langsung di bawah Direktur PKTJ dan dikoordinasikan oleh Wakil Direktur I Bidang Akademik sesuai ketentuan tata kelola Badan Pengembangan SDM Perhubungan.','organization','2026-10-15 01:02:24','2026-10-15 01:02:24');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('admin','dosen','reviewer') NOT NULL DEFAULT 'dosen',
  `roles` json DEFAULT NULL,
  `nidn_nip` varchar(30) DEFAULT NULL,
  `prodi_id` bigint unsigned DEFAULT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `sinta_id` varchar(50) DEFAULT NULL,
  `google_scholar` varchar(255) DEFAULT NULL,
  `scopus_id` varchar(50) DEFAULT NULL,
  `keahlian` varchar(255) DEFAULT NULL,
  `status_aktif` tinyint(1) NOT NULL DEFAULT '1',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_prodi_id_foreign` (`prodi_id`),
  CONSTRAINT `users_prodi_id_foreign` FOREIGN KEY (`prodi_id`) REFERENCES `prodis` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=170 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (163,'Administrator P3M PKTJ','admin@pktj.ac.id','admin','[\"admin\"]','198801152012121002',NULL,'081234567890',NULL,NULL,NULL,NULL,'Manajemen Riset & Tata Kelola Hibah Akademik',1,NULL,'$2y$12$KhxtV5FcvczKA2WE2u.EfOk9gpV1PPoR2nh3xeMT1oXrNcCAasChO',NULL,'2026-10-14 13:54:26','2026-10-15 07:50:04'),(164,'Dr. Ir. Hendro Wibowo, M.T.','dosen@pktj.ac.id','dosen','[\"peneliti\"]','0612048001',93,'081298765432',NULL,'6012345','https://scholar.google.com','57219876543','Keselamatan Kendaraan, Otomasi & Sistem Pengereman Cerdas',1,NULL,'$2y$12$zjhEbioqMIh.DImW/trY8eRXbyx72BTLCFGemkkm9nmt.H2F65idi',NULL,'2026-10-14 13:54:26','2026-10-15 07:50:05'),(165,'Prof. Dr. Ir. Bambang Suhardi, M.Sc.','reviewer@pktj.ac.id','reviewer','[\"reviewer\"]','0625087502',92,'081345678901',NULL,'5987654','https://scholar.google.com','57198765432','Manajemen Rekayasa Lalu Lintas & Audit Daerah Rawan Kecelakaan',1,NULL,'$2y$12$OUwoAjAYLHg.Y6wjXLIDJeulE8MnbDb9WdpZ8eXZGsTumCEMAnu6.',NULL,'2026-10-14 13:54:26','2026-10-15 07:50:05'),(166,'Budi Santoso, S.T., M.Sc.','budi.santoso@pktj.ac.id','dosen','[\"peneliti\"]','0615028501',92,'081356789012',NULL,'6123456',NULL,'57221234567','Geometrik Jalan, Black Spot & Keselamatan Infrastruktur',1,NULL,'$2y$12$0ugwQQxhy2BDDPeUHWq4pOIVE5FCa2dQYjz/IvTCKgi9le36uIpKG',NULL,'2026-10-14 13:54:26','2026-10-15 07:50:05'),(167,'Siti Rahmawati, S.Si.T., M.T.','siti.rahmawati@pktj.ac.id','dosen','[\"peneliti\"]','0628098702',94,'081367890123',NULL,'6234567',NULL,'57232345678','Teknologi Motor Bakar, Uji Emisi & Konversi Kendaraan Listrik',1,NULL,'$2y$12$AqPsueZmheD0SbTZFw.B7O/YByHT3zgOo0ZS/eAnXJ6hYEAGHIW7u',NULL,'2026-10-14 13:54:27','2026-10-15 07:50:05'),(168,'Agus Setiawan, M.T.','agus.setiawan@pktj.ac.id','dosen','[\"peneliti\"]','0619038201',93,'081378901234',NULL,'6345678',NULL,'57243456789','Dinamika Kendaraan, Sistem Kemudi & Chasis Transportasi Jalan',1,NULL,'$2y$12$fT1LMkYz/jLRroZpqtDduemprGoogifo/MY58TMcdH4UwmKjdLpXC',NULL,'2026-10-14 15:03:21','2026-10-15 07:50:05'),(169,'Wahyu Nugroho, M.Sc.','wahyu.nugroho@pktj.ac.id','dosen','[\"peneliti\"]','0611078601',94,'081389012345',NULL,'6456789',NULL,'57254567890','Efisiensi Energi, Bahan Bakar Terbarukan & Sistem Transmisi Otomotif',1,NULL,'$2y$12$HAwrH5W30IZpn6qSEK.m5emyHv/HBk3tc1X143U2h3hw3ch8FCqOu',NULL,'2026-10-14 15:03:21','2026-10-15 07:50:06');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-11-03 11:30:33
