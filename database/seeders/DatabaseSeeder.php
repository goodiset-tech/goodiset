<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([

            // AdminSeeder::class,
            // SettingSeeder::class,
            // UserSeeder::class,
            // PermissionSeeder::class,
            // CountrySeeder::class,
            // FormatSeeder::class,
            // FlavorSeeder::class,
            // ProductSeeder::class,
            // ProductUpdateSeeder::class,
            // PaymentMethodsSeeder::class,
            // CategoryTypeConditionsSeeder::class,
            // ShapesTableSeeder::class,
            // TypesTableSeeder::class,
        ]);
    }
}
