<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Language;
use App\Models\Page;
use App\Models\Relationship;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RelationshipSeeder extends Seeder
{
    static $table = 'relationships';


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
        DB::table(static::$table)->truncate();

        /**
         * Page translations
         *
         */
        $page_groups = [
            [1, 2, 3],
            [4, 5, 6],
            [7, 8, 9],
        ];

        foreach ($page_groups as $page_group) {
            foreach ($page_group as $page_id) {
                foreach (Page::find($page_group) as $translation) {
                    Page::attachTranslation($page_id, $translation->id, $translation->language_code);
                }
            }
        }

        /**
         * Article categories
         *
         */
        foreach (Article::get() as $article) {
            for ($i = 0; $i < rand(0, 10); $i++) {
                $category = Category::where('content_type_id', $article->content_type_id)->inRandomOrder()->first();

                if ($category) {
                    Relationship::updateOrCreate([
                        'source_id' => $article->id,
                        'target_id' => $category->id,
                        'key'       => config('constants.relationships.category.article'),
                    ]);
                }
            }
        }
    }
}
