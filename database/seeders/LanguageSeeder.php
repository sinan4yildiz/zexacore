<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    static $table = 'languages';


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table(static::$table)->truncate();

        DB::table(static::$table)->insert([
            [
                'name'      => 'English',
                'native'    => 'English',
                'code'      => 'en',
                'locale'    => 'en_GB.UTF-8, en_GB@GBP, en_GB, english',
                'is_active' => true
            ],
            [
                'name'      => 'Turkish',
                'native'    => 'Türkçe',
                'code'      => 'tr',
                'locale'    => 'tr_TR.UTF-8, tr_TR@TRY, tr_TR, turkish',
                'is_active' => true
            ],
            [
                'name'      => 'German',
                'native'    => 'Deutsch',
                'code'      => 'de',
                'locale'    => 'de_DE.UTF-8, de_DE@EUR, de_DE, german',
                'is_active' => true
            ],
            /*[
                'name'      => 'French',
                'native'    => 'Français',
                'code'      => 'fr',
                'locale'    => 'fr_FR.UTF-8, fr_FR@EUR, fr_FR, french',
                'is_active' => false
            ],*/
            [
                'name'      => 'Ukrainian',
                'native'    => 'Українська',
                'code'      => 'ua',
                'locale'    => 'ua_UA.UTF-8, ua_UA@UAH, ua_UA, ukrainian',
                'is_active' => false
            ],
            /*[
                'name'      => 'Russian',
                'native'    => 'Русский',
                'code'      => 'ru',
                'locale'    => 'ru_RU.UTF-8, ru_RU@RUB, ru_RU, russian',
                'is_active' => false
            ],*/
        ]);
    }
}
