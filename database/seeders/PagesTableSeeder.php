<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PagesTableSeeder extends Seeder
{
    public function run()
    {
        $pages = [
            ['name' => 'About Us', 'slug' => 'about-us'],
            ['name' => 'Contact Us', 'slug' => 'contact-us'],
            ['name' => 'Terms & Conditions', 'slug' => 'terms'],
            ['name' => 'Privacy Policy', 'slug' => 'privacypolicy'],
            ['name' => 'FAQs', 'slug' => 'faqs'],
        ];

        foreach ($pages as $page) {
            DB::table('pages')->updateOrInsert(
                ['slug' => $page['slug']],
                [
                    'name' => $page['name'],
                    'slug' => $page['slug'],
                    'page_image' => null,
                    'status' => 1,
                    'view' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}

