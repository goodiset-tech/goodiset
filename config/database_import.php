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
    */

    'psql_binary' => null,

];
