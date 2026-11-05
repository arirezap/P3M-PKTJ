<?php

namespace Database\Seeders;

use App\Models\OrganizationMember;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class OrganizationMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Pengaturan Legalitas & Bagan Struktur Organisasi P3M
        $organizationSettings = [
            'org_sk_number' => 'SK Direktur PKTJ No. KP.004/1/12/PKTJ-2026',
            'org_period' => '2026 – 2031',
            'org_chart_image' => null,
            'org_title' => 'Struktur Organisasi P3M PKTJ',
            'org_lead_text' => 'Pusat Penelitian dan Pengabdian kepada Masyarakat (P3M) merupakan unit pelaksana strategis bidang riset terapan dan pengabdian masyarakat di lingkungan Politeknik Keselamatan Transportasi Jalan, berkedudukan langsung di bawah Direktur PKTJ dan dikoordinasikan oleh Wakil Direktur I Bidang Akademik sesuai ketentuan tata kelola Badan Pengembangan SDM Perhubungan.',
        ];

        foreach ($organizationSettings as $key => $val) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $val, 'group' => 'organization']
            );
        }

        // 2. Susunan Pengurus & Pejabat Struktur Organisasi P3M PKTJ
        $members = [
            [
                'nama' => 'Ir. Bambang Istiyanto, M.T.',
                'nip_nidn' => '196803121994031001',
                'jabatan' => 'Pelindung & Pengarah Institusional',
                'urutan' => 1,
                'foto' => null,
                'deskripsi_tugas' => 'Menetapkan arah kebijakan strategis, standar mutu, dan mengawasi implementasi program riset dan pengabdian vokasi di lingkungan civitas akademika PKTJ.',
                'status_aktif' => true,
            ],
            [
                'nama' => 'Dr. Capt. Tri Cahyadi, M.H., M.Mar.',
                'nip_nidn' => '197405102002121002',
                'jabatan' => 'Penanggung Jawab Akademik & Riset',
                'urutan' => 2,
                'foto' => null,
                'deskripsi_tugas' => 'Mengkoordinasikan integrasi hasil penelitian terapan ke dalam kurikulum pembelajaran pada 3 Program Studi PKTJ.',
                'status_aktif' => true,
            ],
            [
                'nama' => 'Dr. Ir. Hendro Wibowo, M.T.',
                'nip_nidn' => '198004122008121001',
                'jabatan' => 'Kepala Pusat P3M',
                'urutan' => 3,
                'foto' => null,
                'deskripsi_tugas' => 'Memimpin seluruh tata kelola operasional riset terapan, hilirisasi inovasi, pengabdian masyarakat, sentra HKI, serta kemitraan eksternal.',
                'status_aktif' => true,
            ],
            [
                'nama' => 'Siti Rahmawati, S.Si.T., M.T.',
                'nip_nidn' => '198709282010122003',
                'jabatan' => 'Sekretaris P3M',
                'urutan' => 4,
                'foto' => null,
                'deskripsi_tugas' => 'Mengelola ketatausahaan, administrasi pengusulan proposal hibah DIPA, tata kelola keuangan, dan pelaporan akuntabilitas kelembagaan.',
                'status_aktif' => true,
            ],
            [
                'nama' => 'Prof. Dr. Ir. Bambang Suhardi, M.Sc.',
                'nip_nidn' => '197508252000031001',
                'jabatan' => 'Koordinator Bidang Penelitian & Hilirisasi',
                'urutan' => 5,
                'foto' => null,
                'deskripsi_tugas' => 'Merumuskan prioritas roadmap riset keselamatan jalan, mengawal seleksi review proposal, serta memfasilitasi hilirisasi teknologi terapan.',
                'status_aktif' => true,
            ],
            [
                'nama' => 'Budi Santoso, S.T., M.Sc.',
                'nip_nidn' => '198502152014021001',
                'jabatan' => 'Koordinator Bidang Pengabdian kepada Masyarakat',
                'urutan' => 6,
                'foto' => null,
                'deskripsi_tugas' => 'Mengkoordinasikan program aksi nyata keselamatan transportasi, pembinaan desa mitra, sosialisasi budaya berkendara, dan audit perlengkapan jalan.',
                'status_aktif' => true,
            ],
            [
                'nama' => 'Agus Setiawan, M.T.',
                'nip_nidn' => '198203192009121002',
                'jabatan' => 'Koordinator Sentra HKI & Publikasi Ilmiah',
                'urutan' => 7,
                'foto' => null,
                'deskripsi_tugas' => 'Memfasilitasi pendaftaran Hak Cipta, Paten invensi dosen dan taruna, serta mengelola publikasi berkala pada Indonesian Road Safety Journal terindeks SINTA.',
                'status_aktif' => true,
            ],
            [
                'nama' => 'Wahyu Nugroho, M.Sc.',
                'nip_nidn' => '198607112015031001',
                'jabatan' => 'Staf Administrasi & Pengelola SIM P3M',
                'urutan' => 8,
                'foto' => null,
                'deskripsi_tugas' => 'Mengelola infrastruktur portal SIM P3M, pemutakhiran basis data luaran dosen, verifikasi berkas digital, dan layanan teknis pengguna.',
                'status_aktif' => true,
            ],
        ];

        foreach ($members as $member) {
            OrganizationMember::updateOrCreate(
                ['nama' => $member['nama']],
                $member
            );
        }
    }
}
