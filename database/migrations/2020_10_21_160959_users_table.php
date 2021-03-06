<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UsersTable extends Migration
{
    static $table = 'users';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(static::$table, function (Blueprint $table) {
            $table->id();
            $table->char('email', 128)->index();
            $table->string('password');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('title')->nullable();
            $table->char('api_token', 128)->unique()->nullable()->default(null);
            $table->rememberToken();
            $table->boolean('is_active')->default(true);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('deleted_at')->nullable();
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