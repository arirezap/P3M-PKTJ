<?php

namespace App\Console\Commands;

use Database\Seeders\Pkm2025Seeder;
use Illuminate\Console\Command;

class ImportPkm2025Command extends Command
{
    /**
     * Nama dan signature perintah artisan.
     *
     * @var string
     */
    protected $signature = 'p3m:import-pkm-2025';

    /**
     * Deskripsi perintah artisan.
     *
     * @var string
     */
    protected $description = 'Impor dan sinkronisasi data riil Pengabdian kepada Masyarakat tahun 2025 (Pengabdian & PkM_Pokja Diklat) dari database Excel P3M PKTJ';

    /**
     * Eksekusi perintah konsol.
     */
    public function handle(): int
    {
        $this->info('Memulai sinkronisasi data Pengabdian kepada Masyarakat (PkM) 2025 P3M PKTJ...');

        $seeder = new Pkm2025Seeder;
        $seeder->setCommand($this);
        $seeder->run();

        $this->info('Sinkronisasi data Pengabdian kepada Masyarakat 2025 selesai.');

        return self::SUCCESS;
    }
}

