<?php

namespace Database\Seeders;

use App\Models\Prodi;
use Illuminate\Database\Seeder;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prodis = [
            [
                'kode_prodi' => 'RSTJ',
                'nama_prodi' => 'Rekayasa Sistem Transportasi Jalan',
                'jenjang' => 'D4',
                'deskripsi' => 'Program Sarjana Terapan Rekayasa Sistem Transportasi Jalan berfokus pada perencanaan transportasi, manajemen dan rekayasa lalu lintas, serta audit keselamatan jalan.',
                'status_aktif' => true,
            ],
            [
                'kode_prodi' => 'TRO',
                'nama_prodi' => 'Teknologi Rekayasa Otomotif',
                'jenjang' => 'D4',
                'deskripsi' => 'Program Sarjana Terapan Teknologi Rekayasa Otomotif berfokus pada desain dan rancang bangun kendaraan, konversi armada listrik, serta pengujian berkala kelaikan kendaraan bermotor.',
                'status_aktif' => true,
            ],
            [
                'kode_prodi' => 'TO',
                'nama_prodi' => 'Teknologi Otomotif',
                'jenjang' => 'D3',
                'deskripsi' => 'Program Diploma Tiga Teknologi Otomotif mencetak tenaga ahli madya yang kompeten dalam pemeliharaan armada, diagnostik kelistrikan kendaraan, dan pengujian emisi.',
                'status_aktif' => true,
            ],
        ];

        foreach ($prodis as $prodi) {
            Prodi::updateOrCreate(
                ['kode_prodi' => $prodi['kode_prodi']],
                $prodi
            );
        }
    }
}
