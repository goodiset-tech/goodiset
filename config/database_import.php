<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Auto restore on application boot
    |--------------------------------------------------------------------------
    |
    | Toggle these in this file (commit to git) — no extra Railway variables.
    |
    | When prepare_on_boot is true and the default connection uses pgsql, the first
    | web request (per deploy) wipes the database, imports backup SQL, then runs
    | migrate --force. A cache lock prevents concurrent workers from doing it twice.
    |
    | Set prepare_on_boot back to false after a successful import so you do not
    | wipe production on every request.
    |
    | Large restores need long HTTP timeouts (nginx fastcgi_read_timeout, PHP-FPM
    | request_terminate_timeout). If Railway still shows TCP_ABORT_ON_DATA to Postgres,
    | run the import once via SSH instead: php artisan db:seed --class=BackupSqlSeeder
    |
    */

    'prepare_on_boot' => false,

    'prepare_on_console' => false,

    /*
    |--------------------------------------------------------------------------
    | php artisan db:seed (no --class)
    |--------------------------------------------------------------------------
    |
    | When true, DatabaseSeeder only runs BackupSqlSeeder.
    |
    */

    'database_seeder_backup_only' => false,

    /*
    |--------------------------------------------------------------------------
    | Paths
    |--------------------------------------------------------------------------
    |
    | backup1.sql is gitignored (dumps often contain API keys). Keep the file locally
    | or on a Railway volume and set an absolute path here when not using the default.
    |
    */

    'backup_sql_path' => database_path('seeders/backup1.sql'),

    'psql_binary' => null,

];
