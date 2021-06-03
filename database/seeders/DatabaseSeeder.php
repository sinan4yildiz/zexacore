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
        $this->call([
            SettingSeeder::class,
            LanguageSeeder::class,
            ArticleSeeder::class,
            PageSeeder::class,
            CategorySeeder::class,
            ContentTypeSeeder::class,
            UserSeeder::class,
            RelationshipSeeder::class,
            MessageSeeder::class,
            NotFoundSeeder::class,
            RedirectionSeeder::class,
        ]);
    }
}
