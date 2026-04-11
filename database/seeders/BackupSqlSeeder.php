<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Process;

/**
 * Imports a plain-text pg_dump file (COPY ... FROM stdin) via the psql client.
 *
 * PDO and most SQL GUIs cannot execute COPY FROM stdin; psql can.
 *
 * Requirements:
 * - Default connection driver pgsql (e.g. Railway DATABASE_URL).
 * - psql on PATH, or config database_import.psql_binary, or Windows Program Files lookup.
 * - config database.backup_sql.path (default database/seeders/backup1.sql).
 *
 * Restores schema + data. By default runs db:wipe first. Set database.backup_sql.skip_wipe
 * via config at runtime (e.g. AppServiceProvider) when the DB was already wiped.
 */
class BackupSqlSeeder extends Seeder
{
    public function run(): void
    {
        $connectionName = config('database.default');
        $driver = config("database.connections.{$connectionName}.driver");

        if ($driver !== 'pgsql') {
            throw new \RuntimeException(
                'BackupSqlSeeder only works with PostgreSQL (DB_CONNECTION=pgsql). The backup file is a PostgreSQL pg_dump.'
            );
        }

        if (! filter_var(config('database.backup_sql.skip_wipe', false), FILTER_VALIDATE_BOOL)) {
            $this->command?->warn('Dropping all tables before restore (database.backup_sql.skip_wipe skips this).');
            Artisan::call('db:wipe', ['--force' => true]);
        }

        $path = config('database.backup_sql.path');

        if (! is_string($path) || ! is_file($path)) {
            throw new \RuntimeException(
                "Backup SQL file not found: ".($path ?? '(null)').'. Set config database.backup_sql.path or add database/seeders/backup1.sql.'
            );
        }

        $path = realpath($path) ?: $path;

        $path = $this->prepareSqlFileForPsql($path);

        $config = config("database.connections.{$connectionName}");
        $host = $config['host'] ?? '127.0.0.1';
        $port = (string) ($config['port'] ?? 5432);
        $database = $config['database'] ?? '';
        $username = $config['username'] ?? '';
        $password = (string) ($config['password'] ?? '');

        $env = array_merge($_ENV, $_SERVER, [
            'PGPASSWORD' => $password,
            'PGCLIENTENCODING' => 'UTF8',
        ]);

        $psql = $this->resolvePsqlBinary();

        $command = [
            $psql,
            '-h', $host,
            '-p', $port,
            '-U', $username,
            '-d', $database,
            '-v', 'ON_ERROR_STOP=1',
            '-f', $path,
        ];

        $process = new Process($command, null, $env);
        $process->setTimeout(null);

        $this->command?->info('Running: psql ... -f '.basename($path).' (this may take a while)');

        $process->run();

        if (! $process->isSuccessful()) {
            $detail = trim($process->getErrorOutput().$process->getOutput());

            throw new \RuntimeException(
                'psql failed. Is psql installed and on your PATH? '
                ."If tables already exist, run php artisan db:wipe --force first or use prepare_on_boot.\n\n".$detail
            );
        }

        $this->command?->info('Backup SQL imported successfully.');
    }

    private function resolvePsqlBinary(): string
    {
        $fromConfig = config('database_import.psql_binary');
        if (is_string($fromConfig) && $fromConfig !== '' && is_file($fromConfig)) {
            return $fromConfig;
        }

        if (PHP_OS_FAMILY === 'Windows') {
            for ($v = 18; $v >= 12; $v--) {
                $candidate = "C:\\Program Files\\PostgreSQL\\{$v}\\bin\\psql.exe";
                if (is_file($candidate)) {
                    return $candidate;
                }
            }
        }

        return 'psql';
    }

    /**
     * Some hosts append psql meta-commands like \unrestrict that stock psql rejects
     * when not in "restricted" mode. Strip those so the restore can finish with exit 0.
     */
    private function prepareSqlFileForPsql(string $path): string
    {
        $contents = file_get_contents($path);
        if ($contents === false) {
            throw new \RuntimeException("Could not read SQL file: {$path}");
        }

        $filtered = preg_replace('/^\\\\unrestrict\\s+\\S+\\s*$/m', '', $contents);
        if ($filtered === $contents) {
            return $path;
        }

        $tmp = tempnam(sys_get_temp_dir(), 'pg_backup_');
        if ($tmp === false || file_put_contents($tmp, $filtered) === false) {
            throw new \RuntimeException('Could not write filtered SQL to a temp file.');
        }

        register_shutdown_function(static function () use ($tmp): void {
            if (is_file($tmp)) {
                @unlink($tmp);
            }
        });

        return $tmp;
    }
}
