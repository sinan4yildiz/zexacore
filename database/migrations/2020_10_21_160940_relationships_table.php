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

            $table->integer('sid')->index()->unsigned();
            $table->integer('gid')->index()->unsigned();
            $table->char('key', 32);
            $table->char('value', 255);
        });
    }

    public function down()
    {
        Schema::dropIfExists(static::$table);
    }
}
