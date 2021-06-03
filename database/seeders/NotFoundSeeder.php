<?php

namespace Database\Seeders;

use App\Models\NotFound;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotFoundSeeder extends Seeder
{
    static $table = 'not_founds';


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
        DB::table(static::$table)->truncate();

        NotFound::factory()->times(18)->create();
    }
}
