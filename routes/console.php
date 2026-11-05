<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

if (! function_exists('getDatabaseBinary')) {
    /**
     * Mencari path file binary MySQL / mysqldump pada sistem host.
     */
    function getDatabaseBinary(string $binaryName): ?string
    {
        $winBinary = $binaryName.'.exe';

        // 1. Cek dari PATH environment
        $whereOutput = @shell_exec('where '.escapeshellarg($binaryName).' 2>nul');
        if ($whereOutput) {
            $lines = array_filter(array_map('trim', explode(PHP_EOL, $whereOutput)));
            foreach ($lines as $line) {
                if (file_exists($line)) {
                    return $line;
                }
            }
        }

        // 2. Cek direktori standar Laragon
        $laragonMatches = glob('C:/laragon/bin/mysql/*/bin/'.$winBinary);
        if (empty($laragonMatches)) {
            $laragonMatches = glob('C:/laragon/bin/mysql/*/'.$winBinary);
        }
        if (! empty($laragonMatches) && file_exists($laragonMatches[0])) {
            return str_replace('/', DIRECTORY_SEPARATOR, $laragonMatches[0]);
        }

        // 3. Cek direktori XAMPP jika ada
        $xamppPath = 'C:/xampp/mysql/bin/'.$winBinary;
        if (file_exists($xamppPath)) {
            return str_replace('/', DIRECTORY_SEPARATOR, $xamppPath);
        }

        return null;
    }
}

/**
 * Perintah Artisan untuk mencadangkan database saat ini.
 */
Artisan::command('data:backup {filename?}', function (?string $filename = null) {
    $filename = $filename ?: 'p3m_backup_with_dummy.sql';
    $backupDir = database_path('backups');

    if (! is_dir($backupDir)) {
        mkdir($backupDir, 0755, true);
    }

    $targetFile = $backupDir.DIRECTORY_SEPARATOR.$filename;
    $dbHost = config('database.connections.mysql.host', '127.0.0.1');
    $dbPort = config('database.connections.mysql.port', '3306');
    $dbUser = config('database.connections.mysql.username', 'root');
    $dbPass = config('database.connections.mysql.password', '');
    $dbName = config('database.connections.mysql.database', 'p3m');

    $mysqldump = getDatabaseBinary('mysqldump');

    if ($mysqldump && file_exists($mysqldump)) {
        $passPart = ! empty($dbPass) ? ' -p'.escapeshellarg($dbPass) : '';
        $cmd = sprintf(
            '"%s" -h %s -P %s -u %s%s %s > "%s"',
            $mysqldump,
            escapeshellarg($dbHost),
            escapeshellarg($dbPort),
            escapeshellarg($dbUser),
            $passPart,
            escapeshellarg($dbName),
            $targetFile
        );

        exec($cmd, $output, $returnCode);

        if ($returnCode === 0 && file_exists($targetFile) && filesize($targetFile) > 0) {
            $this->info("[BERHASIL] Cadangan database berhasil disimpan di: {$targetFile}");
            $this->info('Ukuran berkas cadangan: '.round(filesize($targetFile) / 1024, 2).' KB');

            return 0;
        }
    }

    // Fallback: Dump tabel via query generator internal
    $this->warn('[PERINGATAN] mysqldump tidak terdeteksi di PATH, menggunakan metode fallback internal.');
    $tables = DB::select('SHOW TABLES');
    $dumpContent = "-- Cadangan Basis Data P3M\nSET FOREIGN_KEY_CHECKS=0;\n\n";

    foreach ($tables as $t) {
        $table = array_values((array) $t)[0];
        $createTable = DB::select("SHOW CREATE TABLE `{$table}`");
        $createSql = ((array) $createTable[0])['Create Table'];

        $dumpContent .= "DROP TABLE IF EXISTS `{$table}`;\n".$createSql.";\n\n";

        $rows = DB::table($table)->get();
        foreach ($rows as $row) {
            $rowArray = (array) $row;
            $keys = array_map(fn ($k) => "`{$k}`", array_keys($rowArray));
            $values = array_map(function ($v) {
                if ($v === null) {
                    return 'NULL';
                }

                return "'".addslashes((string) $v)."'";
            }, array_values($rowArray));

            $dumpContent .= "INSERT INTO `{$table}` (".implode(', ', $keys).') VALUES ('.implode(', ', $values).");\n";
        }
        $dumpContent .= "\n";
    }

    $dumpContent .= "SET FOREIGN_KEY_CHECKS=1;\n";
    file_put_contents($targetFile, $dumpContent);

    $this->info("[BERHASIL] Cadangan database (fallback) berhasil disimpan di: {$targetFile}");

    return 0;
})->purpose('Mencadangkan basis data MySQL saat ini ke berkas SQL');

/**
 * Perintah Artisan untuk mengosongkan seluruh data dummy operasional.
 */
Artisan::command('data:clear-dummy', function () {
    $this->info('Menyiapkan pengosongan data dummy operasional...');

    // 1. Pastikan backup otomatis sudah dibuat sebelum pengosongan
    $backupPath = database_path('backups'.DIRECTORY_SEPARATOR.'p3m_backup_with_dummy.sql');
    if (! file_exists($backupPath) || filesize($backupPath) === 0) {
        $this->info('Membuat salinan cadangan otomatis sebelum pengosongan...');
        Artisan::call('data:backup', ['filename' => 'p3m_backup_with_dummy.sql']);
    }

    // 2. Daftar tabel dummy yang dikosongkan
    $dummyTables = [
        'proposal_final_reports',
        'proposal_monevs',
        'proposal_reviews',
        'proposal_budgets',
        'proposal_members',
        'proposals',
        'community_service_outputs',
        'community_services',
        'outputs',
        'researches',
        'documents',
        'posts',
        'collaborations',
        'organization_members',
    ];

    Schema::disableForeignKeyConstraints();

    $clearedCount = 0;
    foreach ($dummyTables as $table) {
        if (Schema::hasTable($table)) {
            $countBefore = DB::table($table)->count();
            DB::table($table)->truncate();
            $this->line(" - Tabel `{$table}`: {$countBefore} data dibersihkan (sekarang 0 data).");
            $clearedCount += $countBefore;
        }
    }

    Schema::enableForeignKeyConstraints();

    // 3. Bersihkan cache tampilan dan query
    Artisan::call('cache:clear');
    Artisan::call('view:clear');

    $this->newLine();
    $this->info("[SELESAI] Total {$clearedCount} data dummy berhasil dikosongkan.");
    $this->info('Data master akun pengguna (Admin, Reviewer, Dosen), 3 Prodi (D4 RSTJ, D4 TRO, D3 TO), dan pengaturan situs tetap dipertahankan.');
    $this->info('Untuk mengembalikan seluruh data dummy kapan saja, jalankan: php artisan data:restore-dummy');

    return 0;
})->purpose('Mengosongkan seluruh data dummy riset, pengabdian, dokumen, berita, dan proposal');

/**
 * Perintah Artisan untuk memulihkan kembali seluruh data dummy dari cadangan.
 */
Artisan::command('data:restore-dummy {filename?}', function (?string $filename = null) {
    $filename = $filename ?: 'p3m_backup_with_dummy.sql';
    $backupFile = database_path('backups'.DIRECTORY_SEPARATOR.$filename);

    $this->info("Memulai proses pemulihan data dummy dari: {$filename}...");

    if (! file_exists($backupFile)) {
        $this->warn("[PERINGATAN] Berkas cadangan {$backupFile} tidak ditemukan.");
        $this->info('Menjalankan seeder bawaan aplikasi sebagai alternatif pemulihan...');
        Artisan::call('db:seed', ['--force' => true]);
        $this->info('[BERHASIL] Basis data berhasil dipulihkan via DatabaseSeeder.');

        return 0;
    }

    $dbHost = config('database.connections.mysql.host', '127.0.0.1');
    $dbPort = config('database.connections.mysql.port', '3306');
    $dbUser = config('database.connections.mysql.username', 'root');
    $dbPass = config('database.connections.mysql.password', '');
    $dbName = config('database.connections.mysql.database', 'p3m');

    $mysqlBin = getDatabaseBinary('mysql');

    if ($mysqlBin && file_exists($mysqlBin)) {
        $passPart = ! empty($dbPass) ? ' -p'.escapeshellarg($dbPass) : '';
        $innerCmd = sprintf(
            '"%s" -h %s -P %s -u %s%s %s < "%s"',
            $mysqlBin,
            escapeshellarg($dbHost),
            escapeshellarg($dbPort),
            escapeshellarg($dbUser),
            $passPart,
            escapeshellarg($dbName),
            $backupFile
        );

        $cmd = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ? 'cmd /c "'.$innerCmd.'"' : $innerCmd;
        exec($cmd, $output, $returnCode);

        if ($returnCode === 0) {
            Artisan::call('cache:clear');
            Artisan::call('view:clear');
            $this->newLine();
            $this->info('[BERHASIL] Seluruh data dummy berhasil dipulihkan secara presisi dari berkas cadangan SQL.');

            return 0;
        }
    }

    // Fallback: Gunakan DB::unprepared atau DatabaseSeeder
    $this->warn('[PERINGATAN] mysql binary tidak dapat dieksekusi secara langsung. Menjalankan import fallback...');
    try {
        $sql = file_get_contents($backupFile);
        DB::unprepared($sql);
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        $this->info('[BERHASIL] Seluruh data dummy berhasil dipulihkan via DB unprepared.');

        return 0;
    } catch (Throwable $e) {
        $this->warn('Eksekusi SQL langsung menghasilkan: '.$e->getMessage());
        $this->info('Menjalankan DatabaseSeeder sebagai alternatif pemulihan...');
        Artisan::call('db:seed', ['--force' => true]);
        $this->info('[BERHASIL] Seluruh data dummy berhasil dipulihkan melalui DatabaseSeeder.');

        return 0;
    }
})->purpose('Memulihkan kembali seluruh data dummy dari berkas cadangan SQL atau seeder');
