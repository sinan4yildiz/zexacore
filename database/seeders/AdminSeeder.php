<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\People\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    static $table = 'admins';

    public static function run()
    {
        DB::table(static::$table)->truncate();

        DB::table(static::$table)->insert([
            'username'       => 'sinan4yildiz',
            'firstname'      => 'Sinan',
            'lastname'       => 'Yildiz',
            'email'          => 'snn@sinanyildiz.me',
            'password'       => Hash::make('123123'),
            'remember_token' => Str::random(10),
            'api_token'      => Str::random(32),
        ]);

        Admin::factory()->times(4)->create();
    }
}
