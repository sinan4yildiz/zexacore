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

        // It's me
        DB::table(static::$table)->insert([
            'firstname'      => 'Sinan',
            'lastname'       => 'Yildiz',
            'title'          => 'Web Developer',
            'email'          => 'snn@sinanyildiz.me',
            'password'       => Hash::make('123123'),
            'remember_token' => Str::random(10),
        ]);

        // It's John
        DB::table(static::$table)->insert([
            'firstname'      => 'John',
            'lastname'       => 'Doe',
            'title'          => 'Testing Engineer',
            'email'          => 'john@doe.com',
            'password'       => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        // Dummy users
        User::factory()->times(5)->create();
    }
}
