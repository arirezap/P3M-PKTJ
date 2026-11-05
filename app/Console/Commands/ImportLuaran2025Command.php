<?php

namespace App\Console\Commands;

use Database\Seeders\Output2025Seeder;
use Illuminate\Console\Command;

class ImportLuaran2025Command extends Command
{
    /**
     * Nama dan signature perintah artisan.
     *
     * @var string
     */
    protected $signature = 'p3m:import-luaran-2025';

    /**
     * Deskripsi perintah artisan.
     *
     * @var string
     */
    protected $description = 'Impor dan sinkronisasi data riil Luaran Penelitian tahun 2025 (Publikasi, Pending, Buku, HaKI) dari database Excel P3M PKTJ';

    /**
     * Eksekusi perintah konsol.
     */
    public function handle(): int
    {
        $this->info('Memulai sinkronisasi data Luaran Penelitian 2025 P3M PKTJ...');

        $seeder = new Output2025Seeder;
        $seeder->setCommand($this);
        $seeder->run();

        $this->info('Sinkronisasi data Luaran Penelitian 2025 selesai.');

        return self::SUCCESS;
    }
}

