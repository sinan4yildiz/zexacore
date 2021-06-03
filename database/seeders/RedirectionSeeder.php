<?php

namespace Database\Seeders;

use App\Models\Redirection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RedirectionSeeder extends Seeder
{
    static $table = 'redirections';


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
        DB::table(static::$table)->truncate();

        Redirection::factory()->times(8)->create();
    }
}
