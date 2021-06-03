<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MessagesTable extends Migration
{
    static $table = 'messages';

    public function up()
    {
        Schema::create(static::$table, function (Blueprint $table) {
            $table->increments('id');
            $table->text('subject');
            $table->text('text');
            $table->string('name');
            $table->string('email');
            $table->string('telephone');
            $table->integer('unread')->default(1)->unsigned();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    public function down()
    {
        Schema::dropIfExists(static::$table);
    }
}