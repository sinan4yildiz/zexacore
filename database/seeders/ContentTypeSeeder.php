<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ContentTypeSeeder extends Seeder
{
    static $table = 'content_types';
    static $translation_table = 'content_type_translations';


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

        // Content types
        DB::table(static::$table)->insert([
            [
                'sort_order' => 1,
            ],
            [
                'sort_order' => 2,
            ],
            [
                'sort_order' => 3,
            ],
        ]);

        // Content type translations
        DB::table(static::$translation_table)->insert([
            [
                'content_type_id' => 1,
                'language_id'     => 1,
                'title'           => 'Services',
                'description'     => 'This type of content includes your services provided by your company.',
            ],
            [
                'content_type_id' => 1,
                'language_id'     => 2,
                'title'           => 'Hizmetler',
                'description'     => 'Bu içerik tipi firmanızın sağladığı hizmetleri içerir.',
            ],
            [
                'content_type_id' => 2,
                'language_id'     => 1,
                'title'           => 'References',
                'description'     => 'This type of content includes your reference works.',
            ],
            [
                'content_type_id' => 2,
                'language_id'     => 2,
                'title'           => 'Hizmetler',
                'description'     => 'Bu içerik tipi firmanızın yaptığı referans çalışmaları içerir.',
            ],
            [
                'content_type_id' => 3,
                'language_id'     => 1,
                'title'           => 'Blog',
                'description'     => 'You can post your blogs through this content type.',
            ],
            [
                'content_type_id' => 3,
                'language_id'     => 2,
                'title'           => 'Blog',
                'description'     => 'Blog yazılarınızı bu içerik tipi ile yazabilirsiniz.',
            ],
        ]);
    }
}
