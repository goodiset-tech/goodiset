<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        DB::statement('ALTER TABLE products ALTER COLUMN original_price TYPE DECIMAL(10,2) USING original_price::numeric;');
        DB::statement('ALTER TABLE products ALTER COLUMN discount_price TYPE DECIMAL(10,2) USING discount_price::numeric;');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE products ALTER COLUMN original_price TYPE INTEGER USING original_price::integer;');
        DB::statement('ALTER TABLE products ALTER COLUMN discount_price TYPE INTEGER USING discount_price::integer;');
    }
};

