<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\Slug;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class PageSeeder extends Seeder
{
    static $table = 'pages';


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table(static::$table)->truncate();

        Schema::enableForeignKeyConstraints();

        // Data
        $data = [
            [
                'title'         => 'About us',
                'language_code' => 'en',
            ],
            [
                'title'         => 'Hakkımızda',
                'language_code' => 'tr',
            ],
            [
                'title'         => 'Über uns',
                'language_code' => 'de',
            ],
            [
                'title'         => 'Terms & Conditions',
                'language_code' => 'en',
            ],
            [
                'title'         => 'Kullanım Şartları',
                'language_code' => 'tr',
            ],
            [
                'title'         => 'Geschäftsbedingungen',
                'language_code' => 'de',
            ],
            [
                'title'         => 'Privacy Policy',
                'language_code' => 'en',
            ],
            [
                'title'         => 'Gizlilik Politikasi',
                'language_code' => 'tr',
            ],
            [
                'title'         => 'Datenschutz-Bestimmungen',
                'language_code' => 'de',
            ],
        ];

        foreach ($data as $item) {
            $page = new Page();
            $page->title = $item['title'];
            $page->language_code = $item['language_code'];
            $page->user_id = 1;
            $page->views = rand(10, 1500);
            $page->save();

            $slug = new Slug();
            $slug->language_code = $page->language_code;
            $slug->module = config('constants.slugs.module.page');
            $slug->keyword = Str::slug($page->title);
            $slug->value = $page->id;
            $slug->save();
        }
    }
}
