<?php

namespace App\Console\Commands;

use Database\Seeders\Research2025Seeder;
use Illuminate\Console\Command;

class ImportPenelitian2025Command extends Command
{
    /**
     * Nama dan signature perintah konsol.
     *
     * @var string
     */
    protected $signature = 'p3m:import-penelitian-2025';

    /**
     * Deskripsi perintah konsol.
     *
     * @var string
     */
    protected $description = 'Impor dan sinkronisasi data riil 27 kegiatan penelitian tahun 2025 dari berkas Excel P3M PKTJ ke basis data.';

    /**
     * Eksekusi perintah konsol.
     */
    public function handle(): int
    {
        $this->info('Memulai sinkronisasi data riil 27 kegiatan penelitian tahun 2025...');

        $seeder = new Research2025Seeder;
        $seeder->setCommand($this);
        $seeder->run();

        $this->info('Sinkronisasi data penelitian 2025 selesai.');

        return Command::SUCCESS;
    }
}
