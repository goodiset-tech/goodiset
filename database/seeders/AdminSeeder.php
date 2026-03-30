<?php

namespace Database\Seeders;

use App\Models\Admins\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Admin::create([
            'email' => 'sahil@gmail.com', // Admin email
            'password' => Hash::make('password123'), // Admin password (hashed)
        ]);
    }
}
