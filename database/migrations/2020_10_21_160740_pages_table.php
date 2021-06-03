<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PagesTable extends Migration
{
    static $table = 'pages';

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

            $table->char('language_code', 2)->index();
            $table->integer('user_id')->index()->unsigned();
            $table->integer('views')->default(0)->unsigned();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_indexable')->default(true);
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
