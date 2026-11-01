<?php

namespace Database\Seeders;

use App\Models\Prodi;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prodiRstj = Prodi::where('kode_prodi', 'RSTJ')->first();
        $prodiTro = Prodi::where('kode_prodi', 'TRO')->first();
        $prodiTo = Prodi::where('kode_prodi', 'TO')->first();

        // 1. Akun Admin P3M
        User::updateOrCreate(
            ['email' => 'admin@pktj.ac.id'],
            [
                'name' => 'Administrator P3M PKTJ',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'nidn_nip' => '198801152012121002',
                'prodi_id' => null,
                'no_telp' => '081234567890',
                'keahlian' => 'Manajemen Riset & Tata Kelola Hibah Akademik',
                'status_aktif' => true,
            ]
        );

        // 2. Akun Dosen / Peneliti (D4 TRO)
        User::updateOrCreate(
            ['email' => 'dosen@pktj.ac.id'],
            [
                'name' => 'Dr. Ir. Hendro Wibowo, M.T.',
                'password' => Hash::make('password'),
                'role' => 'dosen',
                'nidn_nip' => '0612048001',
                'prodi_id' => $prodiTro ? $prodiTro->id : null,
                'no_telp' => '081298765432',
                'sinta_id' => '6012345',
                'scopus_id' => '57219876543',
                'google_scholar' => 'https://scholar.google.com',
                'keahlian' => 'Keselamatan Kendaraan, Otomasi & Sistem Pengereman Cerdas',
                'status_aktif' => true,
            ]
        );

        // 3. Akun Reviewer (D4 RSTJ)
        User::updateOrCreate(
            ['email' => 'reviewer@pktj.ac.id'],
            [
                'name' => 'Prof. Dr. Ir. Bambang Suhardi, M.Sc.',
                'password' => Hash::make('password'),
                'role' => 'reviewer',
                'nidn_nip' => '0625087502',
                'prodi_id' => $prodiRstj ? $prodiRstj->id : null,
                'no_telp' => '081345678901',
                'sinta_id' => '5987654',
                'scopus_id' => '57198765432',
                'google_scholar' => 'https://scholar.google.com',
                'keahlian' => 'Manajemen Rekayasa Lalu Lintas & Audit Daerah Rawan Kecelakaan',
                'status_aktif' => true,
            ]
        );

        // 4. Dosen Tambahan (D4 RSTJ) untuk Kolaborasi Tim
        User::updateOrCreate(
            ['email' => 'budi.santoso@pktj.ac.id'],
            [
                'name' => 'Budi Santoso, S.T., M.Sc.',
                'password' => Hash::make('password'),
                'role' => 'dosen',
                'nidn_nip' => '0615028501',
                'prodi_id' => $prodiRstj ? $prodiRstj->id : null,
                'no_telp' => '081356789012',
                'sinta_id' => '6123456',
                'scopus_id' => '57221234567',
                'keahlian' => 'Geometrik Jalan, Black Spot & Keselamatan Infrastruktur',
                'status_aktif' => true,
            ]
        );

        // 5. Dosen Tambahan (D3 TO) untuk Kolaborasi Tim
        User::updateOrCreate(
            ['email' => 'siti.rahmawati@pktj.ac.id'],
            [
                'name' => 'Siti Rahmawati, S.Si.T., M.T.',
                'password' => Hash::make('password'),
                'role' => 'dosen',
                'nidn_nip' => '0628098702',
                'prodi_id' => $prodiTo ? $prodiTo->id : null,
                'no_telp' => '081367890123',
                'sinta_id' => '6234567',
                'scopus_id' => '57232345678',
                'keahlian' => 'Teknologi Motor Bakar, Uji Emisi & Konversi Kendaraan Listrik',
                'status_aktif' => true,
            ]
        );

        // 6. Dosen Tambahan (D4 TRO)
        User::updateOrCreate(
            ['email' => 'agus.setiawan@pktj.ac.id'],
            [
                'name' => 'Agus Setiawan, M.T.',
                'password' => Hash::make('password'),
                'role' => 'dosen',
                'nidn_nip' => '0619038201',
                'prodi_id' => $prodiTro ? $prodiTro->id : null,
                'no_telp' => '081378901234',
                'sinta_id' => '6345678',
                'scopus_id' => '57243456789',
                'keahlian' => 'Dinamika Kendaraan, Sistem Kemudi & Chasis Transportasi Jalan',
                'status_aktif' => true,
            ]
        );

        // 7. Dosen Tambahan (D3 TO)
        User::updateOrCreate(
            ['email' => 'wahyu.nugroho@pktj.ac.id'],
            [
                'name' => 'Wahyu Nugroho, M.Sc.',
                'password' => Hash::make('password'),
                'role' => 'dosen',
                'nidn_nip' => '0611078601',
                'prodi_id' => $prodiTo ? $prodiTo->id : null,
                'no_telp' => '081389012345',
                'sinta_id' => '6456789',
                'scopus_id' => '57254567890',
                'keahlian' => 'Efisiensi Energi, Bahan Bakar Terbarukan & Sistem Transmisi Otomotif',
                'status_aktif' => true,
            ]
        );
    }
}
