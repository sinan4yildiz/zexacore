<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ArticleSeeder extends Seeder
{
    static $table = 'articles';


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table(static::$table)->truncate();

        Schema::enableForeignKeyConstraints();

        Article::factory()->times(250)->create();
    }
}
