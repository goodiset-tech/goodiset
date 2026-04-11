<?php

namespace App\Providers;

use Database\Seeders\BackupSqlSeeder;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        config([
            'database.backup_sql.path' => config(
                'database_import.backup_sql_path',
                database_path('seeders/backup1.sql')
            ),
        ]);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        $this->prepareDatabaseFromBackupIfRequested();
    }

    /**
     * When config('database_import.prepare_on_boot') is true: drop all tables, import
     * database/seeders/backup1.sql (pgsql + psql), then run pending migrations.
     * See config/database_import.php (no .env flags required).
     */
    private function prepareDatabaseFromBackupIfRequested(): void
    {
        if (! config('database_import.prepare_on_boot', false)) {
            return;
        }

        if (app()->runningInConsole() && ! config('database_import.prepare_on_console', false)) {
            return;
        }

        $connectionName = config('database.default');
        if (config("database.connections.{$connectionName}.driver") !== 'pgsql') {
            Log::warning('database_import.prepare_on_boot skipped: default DB driver is not pgsql.');

            return;
        }

        $backupPath = config('database.backup_sql.path');
        if (! is_string($backupPath) || ! is_file($backupPath)) {
            Log::error('database_import.prepare_on_boot aborted: backup SQL missing.', ['path' => $backupPath]);

            return;
        }

        $lock = Cache::lock('goodiset-database-prepare', 900);

        try {
            $lock->block(900);
        } catch (LockTimeoutException $e) {
            Log::warning('database_import.prepare_on_boot skipped: could not acquire lock.', ['exception' => $e]);

            return;
        }

        try {
            Log::info('database_import: wiping database.');
            Artisan::call('db:wipe', ['--force' => true]);

            $originalSkipWipe = config('database.backup_sql.skip_wipe');
            config(['database.backup_sql.skip_wipe' => true]);

            try {
                Log::info('database_import: restoring backup SQL.');
                Artisan::call('db:seed', ['--class' => BackupSqlSeeder::class, '--force' => true]);
            } finally {
                config(['database.backup_sql.skip_wipe' => $originalSkipWipe]);
            }

            Log::info('database_import: running migrations.');
            Artisan::call('migrate', ['--force' => true]);

            Log::info('database_import: finished.');
        } catch (\Throwable $e) {
            Log::error('database_import.prepare_on_boot failed.', [
                'exception' => $e,
                'message' => $e->getMessage(),
            ]);
            throw $e;
        } finally {
            $lock->release();
        }
    }
}
