<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            'site_title' => 'My Website',
            'site_tagline' => 'The best site ever',
            'meta_title' => 'Welcome to My Website',
            'meta_description' => 'This is the best website for real estate.',
            'meta_keywords' => 'real estate, properties, buy, sell',
            'hero_image' => '/images/hero.jpg',
            'hero_title' => 'Find Your Dream Home',
            'hero_subtitle' => 'We help you find the best properties.',
            'hero_cta_text' => 'Get Started',
            'hero_cta_link' => '/get-started',
            'about_section_title' => 'About Us',
            'about_section_description' => 'We are the leading real estate platform.',
            'footer_text' => '© 2025 My Website. All rights reserved.',
            'logo' => '/images/logo.png',
            'favicon' => '/images/favicon.ico',
            'social_facebook' => 'https://facebook.com/mywebsite',
            'social_twitter' => 'https://twitter.com/mywebsite',
            'social_instagram' => 'https://instagram.com/mywebsite',
            'social_linkedin' => 'https://linkedin.com/company/mywebsite',
            'social_youtube' => 'https://youtube.com/mywebsite',
            'share_image' => '/images/share.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}