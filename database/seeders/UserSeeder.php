<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\People\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    static $table = 'users';

    public static function run()
    {
        DB::table(static::$table)->truncate();

        User::factory()->times(10)->create();
    }
}
