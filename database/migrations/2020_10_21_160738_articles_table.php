<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ArticlesTable extends Migration
{
    static $table = 'articles';

    public function up()
    {
        Schema::create(static::$table, function (Blueprint $table) {
            $table->increments('id');

            // Translation fields
            $table->string('title');
            $table->string('content')->nullable();
            $table->string('image')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            $table->integer('language_code')->index()->unsigned();
            $table->integer('content_type_id')->index()->unsigned();
            $table->integer('user_id')->index()->unsigned();
            $table->integer('primary_category_id')->index()->unsigned()->nullable();
            $table->integer('views')->default(0)->unsigned();
            $table->char('status', 32)->default('published');
            $table->boolean('is_indexable')->default(true);
            $table->integer('sort_order')->default(1)->unsigned();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists(static::$table);
    }
}
