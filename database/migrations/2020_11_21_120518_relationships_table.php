<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RelationshipsTable extends Migration
{
    static $table = 'relationships';

    public function up()
    {
        Schema::create(static::$table, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('source_id')->index()->unsigned();
            $table->integer('target_id')->index()->unsigned();
            $table->char('key', 32);
            $table->char('value', 255)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists(static::$table);
    }
}