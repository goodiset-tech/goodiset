<?php

namespace Database\Seeders;

use App\Models\Admins\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds. /
     */
    public function run()
    {
        Setting::create([
            'site_title' => 'My Website', // Site title
            'email' => 'contact@mywebsite.com', // Contact email
            'text' => 'Welcome to our website!', // Main website text
            'phone' => '1234567890', // Phone number
            'logo' => 'logo.png', // Logo image file path
            'logo1' => 'logo1.png', // Additional logo image file path
            'homepage_image_one' => 'home_image_one.jpg', // Image for homepage
            'homepage_image_two' => 'home_image_two.jpg', // Second homepage image
            'homepage_image_3' => 'home_image_three.jpg', // Third homepage image
            'homepage_image_4' => 'home_image_four.jpg', // Fourth homepage image
            'homepage_footer' => 'Footer text goes here...', // Footer content
            'footer_text' => 'This is footer text.', // Additional footer text
            'history_text' => 'Our company history goes here...', // History text
            'title' => 'My Website - Home', // SEO Title
            'description' => 'Description of my website.', // SEO Description
            'keywords' => 'website, my website, example', // SEO Keywords
            'phonetwo' => '9876543210', // Secondary phone number
            'instagram' => 'https://www.instagram.com/mywebsite', // Instagram link
            'about_image_one' => 'about_image.jpg', // About image
            'status' => 1
        ]);
    }
}
