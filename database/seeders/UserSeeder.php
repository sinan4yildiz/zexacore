<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    static $table = 'users';


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
        DB::table(static::$table)->truncate();

        DB::table(static::$table)->insert([
            'firstname'      => 'Sinan',
            'lastname'       => 'Yildiz',
            'title'          => 'Web Developer',
            'email'          => 'snn@sinanyildiz.me',
            'password'       => Hash::make('123123'),
            'remember_token' => Str::random(10),
            'api_token'      => Str::random(32),
        ]);

        User::factory()->times(5)->create();
    }
}
