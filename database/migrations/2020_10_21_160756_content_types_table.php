<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ContentTypesTable extends Migration
{
    static $table = 'content_types';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(static::$table, function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('has_listing')->default(false);
            $table->boolean('is_indexable')->default(true);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(1)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(static::$table);
    }
}
