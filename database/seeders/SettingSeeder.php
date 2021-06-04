<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    static $table = 'settings';


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table(static::$table)->truncate();

        DB::table(static::$table)->insert([

            // General
            [
                'key'   => 'maintenance_mode',
                'value' => false,
            ],
            [
                'key'   => 'analytics',
                'value' => false,
            ],

            // Brand
            [
                'key'   => 'brand_name',
                'value' => 'Zexacore',
            ],
            [
                'key'   => 'company_name',
                'value' => 'Marsus Digital Ltd',
            ],
            [
                'key'   => 'email_address',
                'value' => 'master@marsus.com',
            ],
            [
                'key'   => 'telephone',
                'value' => '+44 7444 647 199',
            ],
            [
                'key'   => 'address',
                'value' => '135 Fulham Road',
            ],
            [
                'key'   => 'postcode',
                'value' => 'SW6 NX5',
            ],
            [
                'key'   => 'city',
                'value' => 'London',
            ],
            [
                'key'   => 'country',
                'value' => 'United Kingdom',
            ],

            // Social media
            [
                'key'   => 'facebook_url',
                'value' => 'https://www.facebook.com/zexacore',
            ],
            [
                'key'   => 'twitter_url',
                'value' => 'https://twitter.com/zexacore',
            ],
            [
                'key'   => 'instagram_url',
                'value' => 'https://www.instagram.com/zexacore',
            ],
            [
                'key'   => 'linkedin_url',
                'value' => 'https://www.linkedin.com/company/zexacore',
            ],
            [
                'key'   => 'youtube_url',
                'value' => 'https://www.youtube.com/c/zexacore',
            ],

            // SEO
            [
                'key'   => 'indexing',
                'value' => true,
            ],
            [
                'key'   => 'meta_keywords',
                'value' => true,
            ],

            // Localisation
            [
                'key'   => 'default_language_code',
                'value' => 'en',
            ],
            [
                'key'   => 'default_time_zone',
                'value' => 1,
            ],
        ]);
    }
}
