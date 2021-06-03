<?php

namespace Database\Seeders;

use App\Models\Message;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessageSeeder extends Seeder
{
    static $table = 'messages';


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
        DB::table(static::$table)->truncate();

        Message::factory()->times(9)->create();
    }
}
