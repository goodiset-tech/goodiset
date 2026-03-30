<?php

use Illuminate\Support\Facades\DB;

if (!function_exists('getSetting')) {
    /**
     * Retrieve the value of a given setting column.
     *
     * @param string $column
     * @return mixed
     */
    function getSetting(string $column)
    {
        return DB::table('setting')->value($column);
    }
}
