<?php

namespace Database\Seeders;

use App\Models\Admins\Admin;
use App\Models\Admins\User;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::create([
            'name' => 'Sahil', 
            'email' => 'sahil@gmail.com', 
            'password' => Hash::make('password123'), 
        ]);
        Role::create([
            'name' => 'Super Admin', 
        ]);
        DB::table('role_user')->insert([
            'user_id' => 1, 
            'role_id' => 1, 
        ]);
    }
}
